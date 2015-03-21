#!/bin/bash

help ()
{
	echo
	echo 'Usage: test.sh clock|mru|lru outputdir NBuffers index'
	echo
}

#######################
# Check Parameters
#######################

# Check numbers
if [ "$#" -lt 2 ]
then
  	help
  	exit 1
fi

# Check 1
if [ "$1" != "clock" -a "$1" != "mru" -a "$1" != "lru" ]
then 
	help
	exit 1 
fi

# Check 3
NBUFFERS=16
if [ "$#" -lt 2 ]
then
	echo "Assuming number of buffers = 16"
else
	NBUFFERS=$3
	echo "Input number of buffers = "$NBUFFERS
fi

# Check 4
INDEX=0
if [ "$#" -eq 4 ]
then 
	if [ "$4" != "index" ]
	then
  	  	help
	  	exit 1
	fi
	INDEX=1
fi 


#######################
# Test
#######################

source env.sh

# Remove old ones
rm -f /tmp/query_results.log /tmp/query_results.log

# Initialize
if [ $INDEX == 1 ]
then 
	sudo su postgres -c "./reinit.sh index"
else 
	sudo su postgres -c ./reinit.sh
fi  

# Query
sudo su postgres -c "./query.sh $NBUFFERS"

# Output
DATE=$(date +%T)

if [ $INDEX == 1 ]
then 
	cp /tmp/query_results.log $2/result.$1.$NBUFFERS.index.log
	cp /tmp/query_results.log $2/buffer.$1.$NBUFFERS.index.log
	cp /tmp/query_stats.log   $2/stats.$1.$NBUFFERS.index.log
	sed -i '/^[\[<]/d' $2/result.$1.$NBUFFERS.index.log
	sed -i '/^[\[<]/!d' $2/buffer.$1.$NBUFFERS.index.log
else 
	cp /tmp/query_results.log $2/result.$1.$NBUFFERS.log
	cp /tmp/query_results.log $2/buffer.$1.$NBUFFERS.log
	cp /tmp/query_stats.log   $2/stats.$1.$NBUFFERS.log
	sed -i '/^[\[<]/d' $2/result.$1.$NBUFFERS.log
	sed -i '/^[\[<]/!d' $2/buffer.$1.$NBUFFERS.log
fi


