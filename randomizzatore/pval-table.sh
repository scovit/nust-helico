#!/bin/bash

WORKDIR=$1
NUMRAND=$2
#GENOMELENGHT=4639651
UTILDIR=randomizzatore

if ! [ -d $WORKDIR ]
then
    echo Error: directory $1 does not exist 1>&2
    exit 251
fi

if ! [ -f $WORKDIR/position.txt ]
then
    echo Error: directory $1 does not contain a postition.txt file 1>&2
    exit 250
fi

mkdir $WORKDIR/random

if ! [ -x $UTILDIR/subroutine ]
then 
    echo Errore: subroutine should be compiled in $UTILDIR/histosmooth 1>&2
    exit 253
fi

which gzip > /dev/null
if [ $? != 0 ]
then
    echo Errore: gzip must be installed 1>&2
    exit 222
fi

echo Executing $0 with NUMRAND=$NUMRAND and WORKDIR=$WORKDIR

NUMGENES=`wc -l $WORKDIR/position.txt | cut -d ' ' -f 1`
echo $NUMGENES
GENOMELENGTH=`awk '{print $3 + 1}' $WORKDIR/position.txt |
              sort -r -n | head -n 1 `
echo $GENOMELENGTH

POSFILE=`mktemp`
awk '{print $2}' $WORKDIR/position.txt > $POSFILE
trap "rm $POSFILE; exit 12" SIGINT SIGTERM



# This part must be written in C
# BINS=2
# {
#     while true;
#     do
	
# 	for i in `seq 1 $NUMGENES`
# 	do
# 	    echo -ne `date` - 
# 	    echo bin $BINS, randomizing $NUMRAND lists of lenght $i out of $NUMGENES
# 	    for j in `seq 1 $NUMRAND`
# 	    do
# 		shuf -n $i $POSFILE |
# 		$UTILDIR/histosmooth 8192 $BINS 0 $GENOMELENGHT |
# 		sort --buffer-size=320K -n -r -k 2 |
# 		{ head -n 1; cat >/dev/null; };
# 	    done | cut -f 2 |
# 	    gzip - > $WORKDIR/random/$i.$BINS.txt.gz
# 	done
	
# 	BINS=$((BINS*2))
# 	if [ $BINS -ge 8192 ]
# 	then
# 	    break;
# 	fi
	
#     done
# }

# possible to start two parallel jobs
echo "Executing $UTILDIR/subroutine 1 $NUMGENES $GENOMELENGTH $WORKDIR/random $NUMRAND < $POSFILE &"
$UTILDIR/subroutine 1 $NUMGENES $NUMGENES $GENOMELENGTH $WORKDIR/random $NUMRAND < $POSFILE

RETVAL=$?
rm $POSFILE
exit $RETVAL
