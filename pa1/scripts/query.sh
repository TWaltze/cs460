#!/bin/bash

if [ "$#" -eq "0" ]
then
	echo "Assuming number of buffers = 16"
	NBUFFERS=16
else
	NBUFFERS=$1
	echo "Input number of buffers = "$NBUFFERS
fi


source env.sh

echo 'Starting your postgres server and executing queries in query.sql'

# From http://www.postgresql.org/docs/9.4/static/app-postgres.html
# 
# -f { s | i | o | b | t | n | m | h }
#
# Forbids the use of particular scan and join methods: 
# s and i disable sequential and index scans respectively, 
# o, b and t disable index-only scans, bitmap index scans, and TID scans respectively, 
# while n, m, and h disable nested-loop, merge and hash joins respectively.
# Neither sequential scans nor nested-loop joins can be disabled completely; 
# the -fs and -fn options simply discourage the optimizer from using those plan types if it has any other alternative.
# 
# -t pa[rser] | pl[anner] | e[xecutor]
# 
# Print timing statistics for each query relating to each of the major system modules. This option cannot be used together with the -s option.

# From http://www.postgresql.org/docs/9.4/static/runtime-config-statistics.html
#PGOPTIONS='-c log_parser_stats=yes -c log_planner_stats=yes -c log_executor_stats=yes'
#PGOPTIONS='-c log_statement_stats=yes'
#PGOPTIONS='-c log_executor_stats=yes'
postgres --single -B $NBUFFERS $PGOPTIONS -E -d 1 -fm -fh -te $DBNAME > /tmp/query_results.log 2> /tmp/query_stats.log < query.sql

echo 'Query execution successful'
echo 'Postgres statistics are available in "output" folder'

