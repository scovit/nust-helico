#!/bin/bash

LISTDIR=$1
GENOMEDIR=$2
NUMRAND=$3
CODE=$4

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

if ! [ -x randomizzatore/subroutine ]
then 
    echo Errore: subroutine should be compiled in randomizzatore 1>&2
    exit 253
fi

if ! [ -x randomizzatore/histosmooth ]
then 
    echo Errore: histosmooth should be compiled in randomizzatore 1>&2
    exit 253
fi

which gzip > /dev/null
if [ $? != 0 ]
then
    echo Errore: gzip must be installed 1>&2
    exit 222
fi

echo Executing $0 with NUMRAND=$NUMRAND,
echo LISTDIR=$LISTDIR
echo and GENOMEDIR=$GENOMEDIR

NUMGENES=`wc -l $GENOMEDIR/position.txt | cut -d ' ' -f 1`
echo $NUMGENES

GENOMELENGTH=`awk '{print $3 + 1}' $GENOMEDIR/position.txt |
              sort -n | tail -n 1 `
echo $GENOMELENGTH

LISTLENGTH=`wc -l $LISTDIR/list.txt | cut -d ' ' -f 1`
echo $LISTLENGTH

POSFILE=`mktemp`
trap "rm $POSFILE; exit 12" SIGINT SIGTERM

# check if the randomizations are already there
if [ `ls $GENOMEDIR/random/*.$LISTLENGTH.txt.gz | wc -l` != 12 ]
then
    awk '{print $2}' $GENOMEDIR/position.txt > $POSFILE
    
    echo "Executing randomizzatore/subroutine $LISTLENGTH $LISTLENGTH $NUMGENES " \
	"$GENOMELENGTH $GENOMEDIR/random $NUMRAND < $POSFILE &"
    randomizzatore/subroutine $LISTLENGTH $LISTLENGTH $NUMGENES $GENOMELENGTH \
	$GENOMEDIR/random $NUMRAND < $POSFILE

    [ $? ] || { rm $POSFILE; exit 233; }
fi

# convert the list to positions
for i in `cat $LISTDIR/list.txt`
do
    awk -v GENE="$i" '($1 == GENE) {print $2}' $GENOMEDIR/position.txt
done > $POSFILE

if [ `wc -l $POSFILE | cut -d ' ' -f 1` != $LISTLENGTH ]
then
    echo Errore nella creazione della lista delle posizioni 1>&2
    rm $POSFILE
    exit 15
fi

# run the algorithms
graficatore/clustax.sh $POSFILE $GENOMEDIR/random $LISTLENGTH $GENOMELENGTH > \
    $LISTDIR/cluster/result.clust
[ $? ] || { rm $POSFILE; exit 233; }

graficatore/clugraph.sh $LISTDIR/cluster/result.clust $GENOMELENGTH > \
    $LISTDIR/cluster/result.clust.graph
[ $? ] || { rm $POSFILE; exit 233; }
    
graficatore/printandview.sh $LISTDIR/cluster/result.clust.graph $LISTDIR $CODE

RETVAL=$?
rm $POSFILE
exit $RETVAL
