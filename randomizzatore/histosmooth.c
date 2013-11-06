#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <math.h>

#define MAXDATA 1000000

int verbose = 0;

static void usage(int argc, char *argv[]) {
    printf ("Usage: %s nstep nbin min max\n", argv[0]);
    exit (-1);
}

static void parseparam(int nstep, int nbin, double min, double max) {
  if (max <= min) {
    fprintf(stderr, "Error: max should be greater than min\n");
    exit (-1);
  }

  if ((nstep <= 0) || (nbin <= 0)) {
    fprintf(stderr, "Error: nstep and nbin should be greater than zero\n");
    exit (-1);
  }

  if (nstep % nbin) {
    fprintf(stderr, "Error: nstep should be a multiple of nbin\n");
    exit (-1);
  }
}

int main(int argc, char *argv[]) {
  int nstep;
  int nbin;
  int stepxbin;
  double min;
  double max;
  double stepsize;

  int *x;
  double value;
  int valuestep;

  if (argc != 5)
    usage(argc, argv);

  nstep = atoi(argv[1]);
  nbin = atoi(argv[2]);
  min = atof(argv[3]);
  max = atof(argv[4]);
  parseparam(nstep, nbin, min, max);

  stepxbin = nstep / nbin;
  stepsize = (max - min) / nstep;

  x = calloc(nstep, sizeof(int));

  int i;
  int scartato = 0;
  for (i = 0; (i < MAXDATA) && (!feof(stdin)); i++) {
    /* read a value from input */
    if (scanf("%lf", &value) != 1) {
      if(feof(stdin)) {
        break;
      } else {
        fprintf(stderr,"read error\n");
        exit(-1);
      }
    }

    /* accept or reject it */
    if ((value >= max) || (value <= min)) {
      if (verbose)
	fprintf(stderr, "warning: valore scartato %f\n", value);
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

  fprintf(stderr, "Valori scartati %d, %d accettati\n", scartato, i - scartato);

  // stampa l'istogramma
  for (i = 0; i < nstep; i++)
    printf("%d\t%d\n", (int)(min + i * stepsize), x[i]);

  return 0;

}
