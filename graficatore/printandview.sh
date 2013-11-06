#!/bin/bash
LISTDIR=$2
CODE=$3
TMPDIR=`mktemp -d`
trap "rm $TMPDIR"'/*'"; rmdir $TMPDIR; exit 12" SIGINT SIGTERM

echo -10 1 1 1 1 1 1 > $TMPDIR/001
echo -10 1 1 1 1 1 1 > $TMPDIR/01
echo -10 1 1 1 1 1 1 > $TMPDIR/1
echo $TMPDIR

awk '($7 == 0.0001) { print }' < $1 >> $TMPDIR/001
awk '($7 == 0.001) { print }' < $1 >> $TMPDIR/01
awk '($7 == 0.01) { print }' < $1 >> $TMPDIR/1

gracebat -settype xyboxplot -param graficatore/parfile/cluster.par \
    -autoscale none -hdevice PNG -hardcopy \
    -printfile $LISTDIR/cluster/result.png -pexec 'title "'$CODE'"' \
    $TMPDIR/001 $TMPDIR/01 $TMPDIR/1 -saveall $LISTDIR/cluster/result.agr
RETVAL=$?

gracebat -settype xyboxplot -param graficatore/parfile/cluster.par \
    -autoscale none -hdevice EPS -hardcopy \
    -printfile $LISTDIR/cluster/result.eps -pexec 'title "'$CODE'"' \
    $TMPDIR/001 $TMPDIR/01 $TMPDIR/1 -saveall $LISTDIR/cluster/result.agr

epstopdf $LISTDIR/cluster/result.eps --outfile=$LISTDIR/cluster/result.pdf
rm $LISTDIR/cluster/result.eps
pdfcrop $LISTDIR/cluster/result.pdf $LISTDIR/cluster/result.pdf

rm $TMPDIR/*
rmdir $TMPDIR

exit $RETVAL

