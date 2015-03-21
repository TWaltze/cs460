CREATE TABLE raw_r_tuples (tname varchar(2), pkey int, num2 int, num3 int, num1 int, node varchar(16), inserttime float8, lifetime float8, testname varchar(64));
CREATE TABLE raw_s_tuples (tname varchar(2), pkey int PRIMARY KEY, num2 int, num3 int, num1 int, node varchar(16), inserttime float8, lifetime float8, testname varchar(64));
COPY raw_r_tuples FROM '/tmp/R' DELIMITERS ',';
COPY raw_s_tuples FROM '/tmp/S' DELIMITERS ',';
