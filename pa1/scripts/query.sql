DROP TABLE IF EXISTS calc_result;
SELECT R.num1 AS A, S.pkey AS B, R.node AS C, S.node AS D, R.inserttime AS E, S.inserttime AS F INTO TABLE calc_result FROM raw_r_tuples R, raw_s_tuples S WHERE R.num1=S.pkey;
SELECT count(*) FROM calc_result;
