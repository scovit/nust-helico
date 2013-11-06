CFLAGS=-Wall -std=c99 -O2
LIBS=-lm

all: subroutine histosmooth hyper normalize

hyper: hyper.c
	gcc ${CFLAGS} -o hyper hyper.c -lm -lgsl -lgslcblas

histosmooth: histosmooth.c
	gcc ${CFLAGS} -o histosmooth histosmooth.c ${LIBS}

subroutine: subroutine.c
	gcc ${CFLAGS} -o subroutine subroutine.c ${LIBS}

normalize: normalize.c
	gcc ${CFLAGS} -o normalize normalize.c

clean:
	rm subroutine hyper histosmooth normalize
