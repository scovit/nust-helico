#!/bin/bash
# usage: slid listfile posfile nbin

LISTDIR=$1
GENOMEDIR=$2
NBINS1=$3
NBINS2=$4

if ! [ -d $LISTDIR ]
then
    echo Error: directory $LISTDIR does not exist 1>&2
    exit 251
fi

if ! [ -f $LISTDIR/list.txt ]
then
    echo Error: directory $GENOMEDIR does not contain a list.txt file 1>&2
    exit 250
fi

if ! [ -d $GENOMEDIR ]
then
    echo Error: directory $GENOMEDIR does not exist 1>&2
    exit 251
fi

if ! [ -f $GENOMEDIR/position.txt ]
then
    echo Error: directory $GENOMEDIR does not contain a position.txt file 1>&2
    exit 250
fi

if ! [ -d $GENOMEDIR/random ]
then
    mkdir $GENOMEDIR/random
fi

if ! [ -d $LISTDIR/cluster ]
then
    mkdir $LISTDIR/cluster
fi

GENOMELENGTH=`awk '{print $3 + 1}' $GENOMEDIR/position.txt | sort -g | tail -n 1`

trap "exit 12" SIGINT SIGTERM

awk -v genomelenght=$GENOMELENGTH 'BEGIN { SPESS = 1; TIPO=0; print "# CLNAME DEPTH START END COLOR (start and end are expressed in Mbases)"; print "# note that all coordinates are to be taken"; print "# modulo the genome length"; print "# genome length L =" genomelenght/1e6 " Mb"; } (!((NR % 3) - 1) && ($1 >= '$NBINS1') && ($1 <= '$NBINS2')) { if ($1 != TIPO) SPESS++; print "clust" int(NR/3) + 1, SPESS, $6, $5, "red"; TIPO = $1; }' $LISTDIR/cluster/result.clust.graph > $LISTDIR/cluster/$NBINS1.$NBINS2.circular.dat

awk -v genomelenght=$GENOMELENGTH 'BEGIN { SPESS = 1; TIPO=0; print "# CLUSTER_NAME OBSERVATION_SCALE START STOP P-VALUE (start and end are expressed in Mbases)"; print "# noted that all coordinates are to be taken"; print "# modulo the genome length"; print "# genome length L =" genomelenght/1e6 " Mb"; } (!((NR % 3) - 1) && ($1 >= '$NBINS1') && ($1 <= '$NBINS2')) { if ($1 != TIPO) SPESS++; print "clust" int(NR/3) + 1, $1, $6, $5, $7; TIPO = $1; }' $LISTDIR/cluster/result.clust.graph > $LISTDIR/cluster/$NBINS1.$NBINS2.circular.txt

awk -v genomelenght=$GENOMELENGTH 'BEGIN { SPESS = 1; TIPO=0; print "<!DOCTYPE HTML><html><head><style type=\"text/css\">body{font:82%/1.2 Verdana, Lucida Grande, Lucida Sans, Tahoma, sans-serif; color: black; max-width:525px;}</style></head><body><div style=\"display:table-cell;vertical-align: middle; height:400px;\"><table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" width=\"100%\"><tr><th>Name</th><th>Obs. scale</th><th>Start</th><th>Stop</th><th>P-Value</th></tr>"; } (!((NR % 3) - 1) && ($1 >= '$NBINS1') && ($1 <= '$NBINS2')) { if ($1 != TIPO) SPESS++; print "<tr><td>clust" int(NR/3) + 1 "</td><td>" $1 "</td><td>" $6 "</td><td>" $5 "</td><td>" $7 "</td></tr>"; TIPO = $1; } END { print "</table><p>Note: start and stop coordinates for clusters are to be taken modulo the genome length, L = " genomelenght/1e6 " Mb.</p></div></body></html>";}' $LISTDIR/cluster/result.clust.graph > $LISTDIR/cluster/$NBINS1.$NBINS2.circular.html

awk -v genomelenght=$GENOMELENGTH -v color="red" -f ./graficatore/disegnaclusters.awk ./graficatore/macro.dat $LISTDIR/cluster/$NBINS1.$NBINS2.circular.dat > $LISTDIR/cluster/$NBINS1.$NBINS2.circular.svg

awk -v genomelenght=$GENOMELENGTH -v color="black" -f ./graficatore/disegnaclusters.awk ./graficatore/macro.bw.dat $LISTDIR/cluster/$NBINS1.$NBINS2.circular.dat > $LISTDIR/cluster/$NBINS1.$NBINS2.circular.bw.svg

rsvg-convert $LISTDIR/cluster/$NBINS1.$NBINS2.circular.svg > $LISTDIR/cluster/$NBINS1.$NBINS2.circular.png
rsvg-convert -f pdf $LISTDIR/cluster/$NBINS1.$NBINS2.circular.svg > $LISTDIR/cluster/$NBINS1.$NBINS2.circular.pdf
# pdfcrop $LISTDIR/cluster/$NBINS1.$NBINS2.circular.pdf $LISTDIR/cluster/$NBINS1.$NBINS2.circular.pdf

rm $TMPFILE
