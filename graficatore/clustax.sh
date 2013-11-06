#!/bin/bash

POSFILE=$1
CLUDIR=$2
LISTLENGTH=$3
GENOMELENGTH=$4

LUNGH=4552
BINS=2

while true;
do
    PVA1=$(zcat $CLUDIR/$BINS.$LISTLENGTH.txt.gz | sed -n '100p')
    PVA01=$(zcat $CLUDIR/$BINS.$LISTLENGTH.txt.gz | sed -n '10p')
    PVA001=$(zcat $CLUDIR/$BINS.$LISTLENGTH.txt.gz | sed -n '1p')

# Stampa: bin binsize posizione altezza limite
    cat $POSFILE | randomizzatore/histosmooth 8192 $BINS 0 $GENOMELENGTH | 
    awk -v BIN=$BINS \
	-v PV1=$PVA1 \
	-v PV01=$PVA01 \
	-v PV001=$PVA001 \
	'{ if ( $2 > PV001 )
                  { print BIN, (4639651/BIN),$1,$2,0.0001 }
               else if ( $2 > PV01 )
                  { print BIN, (4639651/BIN),$1,$2,0.001 }                
               else if ( $2 > PV1 )
                  { print BIN, (4639651/BIN),$1,$2,0.01 }
             }'
    
    BINS=$((BINS*2))
    if [ $BINS -ge 8192 ]
    then
	break;
    fi
done

