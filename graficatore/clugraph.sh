#!/bin/bash

GL=$2

LUNGH=4552
BINS=2

while true;
do

awk -v BIN=$BINS \
    'BEGIN { Z = 0.; A = 0.; B = -10000000. ; W = 0.; WP = 100. ; BS = 0.; }
     ($1 == BIN) { 
       BS = $2
       Z = $3;
       if ( Z > B + BS ) {     # se inizia un cluster
          if ( B != -10000000. )             # e non e il primo della lista
          {
             print BIN, A/1e6, B/1e6, A/1e6, (B + BS/2)/1e6, (A - BS/2)/1e6, WP;         #stampa il cluster
             print BIN, (A + '$GL'.)/1e6, (B + '$GL'.)/1e6, (A + '$GL'.)/1e6, (B + '$GL'. + BS/2)/1e6, (A + '$GL'. - BS/2)/1e6, WP;
             print BIN, (A - '$GL'.)/1e6, (B - '$GL'.)/1e6, (A - '$GL'.)/1e6, (B - '$GL'. + BS/2)/1e6, (A - '$GL'. - BS/2)/1e6, WP;
          }

          WP = 100.                  # resetta il pvalue
          A = Z;                     # setta linizio del cluster
       }

       B = Z + '$GL'./8192 + 1;    # aggiorna la fine del cluster
       if ($5 < WP) {                # se questa riga ha un migliore pvalue rispetto al resto
          WP = $5;                   # aggiorna il pvalue
          W = Z;                     # aggiorna la posizione del picco
       }
     }
     END { if ( B != -10000000 ) {
              print BIN, A/1e6, B/1e6, A/1e6, (B + BS/2)/1e6, (A - BS/2)/1e6, WP ;
              print BIN, (A + '$GL'.)/1e6, (B + '$GL'.)/1e6, (A + '$GL'.)/1e6, (B + '$GL'. + BS/2)/1e6, (A + '$GL'. - BS/2)/1e6, WP;
              print BIN, (A - '$GL'.)/1e6, (B - '$GL'.)/1e6, (A - '$GL'.)/1e6, (B - '$GL'. + BS/2)/1e6, (A - '$GL'. - BS/2)/1e6, WP;
           }
     }' < $1

   BINS=$((BINS*2))
   if [ $BINS -ge 8192 ]
   then
       break;
   fi
done
