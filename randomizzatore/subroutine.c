#include <stdio.h>
#include <stdlib.h>
#include <time.h>
#include <signal.h>
#include <sys/wait.h>
#include <strings.h>
#include <string.h>
#include <math.h>

int int_cmp_inv(const void *a, const void *b) 
{ 
    const int *ia = (const int *)a; // casting pointer types 
    const int *ib = (const int *)b;
    return *ib  - *ia; 
} 


void shuffle(int n, int *vector) {
  // To shuffle an array a of n elements (indexes 0..n-1):
  int i;
  int j;
  int c;

  for (i = n - 1; i > 0; i--) {
    j = rand() % (i + 1);
    c = vector[j];
    vector[j] = vector[i];
    vector[i] = c;
  }
}

static void usage(int argc, char *argv[]) {
    fprintf(stderr, "Usage: %s inizio fine numgenes genomelength outdir nrand\n", argv[0]);
    exit (-1);
}

static inline int max(int *x, int l) {
  int i;
  int max = -100000000;
  for (i = 0; i < l; i++)
    if (x[i] > max)
      max = x[i];

  return max;
}

void histosmooth(int *position,
		 int l,
		 int nstep,
		 int nbin,
		 int mini,
		 int maxi,
		 int *x)
{
  int stepxbin;
  double min = mini;
  double max = maxi;
  double stepsize;

  double value;
  int valuestep;

  stepxbin = nstep / nbin;
  stepsize = (max - min) / nstep;

  bzero(x, sizeof(int) * nstep);

  int i;
  int scartato = 0;
  for (i = 0; i < l; i++) {
    value = position[i];
    
    /* accept or reject it */
    if ((value >= max) || (value <= min)) {
      scartato++;
      continue;
    }
    
    /* find the step */
    valuestep = (stepxbin % 2 ?
		 nearbyint((value - min)/stepsize) : 
		 (value - min)/stepsize);

    valuestep -= (stepxbin - 1) / 2;

    int j;
    for (j = valuestep;
	 j < valuestep + stepxbin;
	 j++)
      x[ j >= 0 ? j % nstep : nstep + (j % nstep)]++;
  }
  
  if (scartato)
    fprintf(stderr, "Valori scartati %d, %d accettati\n", scartato, i - scartato);

  // stampa l'istogramma
  //  for (i = 0; i < nstep; i++)
  //  printf("%lf\t%d\n", min + i * stepsize, x[i]);
}

int main(int argc, char *argv[]) {
  int inizio;
  int fine;
  int numgenes;
  int genomelength;
  char *outdir;
  int nrand;

  srand(time(NULL));

  if (argc != 7)
    usage(argc, argv);

  inizio = atoi(argv[1]);
  fine = atoi(argv[2]);
  numgenes = atoi(argv[3]);
  genomelength = atoi(argv[4]);
  outdir = argv[5];
  nrand = atoi(argv[6]);

  int *position;
  position = malloc(numgenes * sizeof(int));

  /* read genome positions from stdin */
  int i;
  for (i = 0; i < numgenes; i++) {
    if (scanf("%d", position + i) != 1) {
      fprintf(stderr,"read error\n");
      exit(16);
    }
  }

  int nbin, l;
  char outfile[100];
  char command[200];
  int *x = malloc(8192 * sizeof(int));

  for (l = inizio; l <= fine; l++)
    for (nbin = 2; nbin < 8192; nbin = nbin * 2) {
      struct tm *local;
      time_t t;
      t = time(NULL);
      local = localtime(&t);
      printf("%s", asctime(local));
      printf("bin %d - randomizing %d lists of lenght %d in interval %d-%d \n",
	     nbin, nrand, l, inizio, fine);
      sprintf(outfile, "%s/%d.%d.txt", outdir, nbin, l);
      fflush(stdout);

      int *maximi = malloc(nrand * sizeof(int));
      for (i = 0; i < nrand; i++) {
	shuffle(numgenes, position);
	histosmooth(position, l, 8192, nbin, 0, genomelength, x);
	maximi[i] = max(x, 8192);
      }

      qsort(maximi, nrand, sizeof(int), int_cmp_inv);

      FILE *outf = fopen(outfile, "w");
      for (i = 0; i < nrand; i++) {
	fprintf(outf, "%d\n", maximi[i]);
      }
      fclose(outf);

      sprintf(command, "%s %s", "gzip ", outfile);
      int ret = system(command);
      if (WIFSIGNALED(ret) &&
	  (WTERMSIG(ret) == SIGINT || WTERMSIG(ret) == SIGQUIT))
	exit(22);
      
    }
  
  return 0;
  
}
