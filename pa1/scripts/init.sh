#!/bin/bash
#           -*-mode:ksh-*-  (keep emacs happy)
#
# init.sh: Initialize the experiment
# 
# Sailesh Krishnamurthy
#
# Modified by ashwin thangali
# 
# Updated by Hanwen Wu <steinwaywhw@gmail.com> 
# Date: 02-24-2015
# 


help ()
{
  	echo
  	echo 'Usage: init.sh [index]'
  	echo 
  	echo 'The argument if provided should be the string "index" and'
  	echo 'results in the creation of indices on the R and S tables.'
  	echo
}

SEC=3
INDEX=0

# ==================================
if [ "$#" -gt 1 ]
then
  	help
  	exit 1
fi

# ==================================
if [ "$#" == 1 ]
then
	if [ "$1" != "index" ]
	then
  	  	help
	  	exit 1
	fi
	INDEX=1
fi

# ==================================
source env.sh

# ==================================
echo "executing initdb"
rm -rf $PGDATA
initdb 
echo "initdb successful"

# ==================================
if [ $INDEX -eq 1 ]
then 
	./reinit.sh index 
else 
	./reinit.sh 
fi 

# ==================================
echo
echo "init.sh completed successfully"

