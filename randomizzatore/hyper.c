#include <stdio.h>
#include <stdlib.h>
#include <math.h>
#include <gsl/gsl_cdf.h>

unsigned int k;
unsigned int n1;
unsigned int n2;
unsigned int t;

static void usage(int argc, char *argv[]) {
  printf (
  "Usage: %s k n1 n2 t\n"
  "\n"
  "If a population contains n1 elements of \"type 1\" and n2 elements\n"
  "of \"type 2\" then the hypergeometric distribution gives the probability\n"
  "of obtaining k elements of \"type 1\" in t samples from the population\n"
  "without replacement.\n"
  "This program computes the Pvalue of such a distribution\n", argv[0]);
  exit (-1);
}

int main(int argc, char *argv[]) {

  if (argc != 5)
    usage(argc, argv);

  k = atoi(argv[1]);
  n1 = atoi(argv[2]);
  n2 = atoi(argv[3]);
  t = atoi(argv[4]);

  double Q = gsl_cdf_hypergeometric_Q (k, n1, n2, t);
  double P = gsl_cdf_hypergeometric_P (k, n1, n2, t);

  printf("%g\n", Q);
  if (P < Q)
    fprintf(stderr, "Warning: P < Q, %g < %g\n", P, Q);

}
