#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <math.h>

#define MAXDATA 5000000

int verbose = 0;

static void usage(int argc, char *argv[]) {
    printf ("Usage: %s file\n", argv[0]);
    exit (-1);
}

int main(int argc, char *argv[]) {
  double *x;
  double *y;

  if (argc != 2)
    usage(argc, argv);
  
  char *filename = argv[1];
  FILE * pfile = fopen (filename, "r");
  if (pfile == NULL) {
    fprintf(stderr, "Error: file not found\n");
    exit(-1);
  }

  x = calloc(MAXDATA, sizeof(double));
  y = calloc(MAXDATA, sizeof(double));


  int i, count;
  for (i = 0; (i < MAXDATA) && (!feof(pfile)); i++) {
    /* read a value from input */
    if (fscanf(pfile, "%lf %lf", x + i, y + i) != 2) {
      if(feof(pfile)) {
        break;
      } else {
        fprintf(stderr,"read error at line %d\n", i + 1);
        exit(-1);
      }
    }
  }
  count = i;
  fclose(pfile);

  double sum = 0;
  for (i = 0; i < count; i++) {
    sum += y[i];
  }

  for (i = 0; i < count; i++) {
    y[i] /= sum;
  }

  // stampa
  pfile = fopen (filename, "w");
  for (i = 0; i < count; i++)
    fprintf(pfile, "%lf %lf\n", x[i], y[i]);
  fclose(pfile);

  return 0;

}
