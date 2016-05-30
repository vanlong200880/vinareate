/* Join table [province, district] as PD base on provinceid, then [PD, ward] base on districtid*/
SELECT p_name, d_name, ward.name as w_name FROM (SELECT province.name as p_name, district.name as d_name, district.districtid FROM province JOIN district ON province.provinceid = district.provinceid) as PD JOIN ward ON PD.districtid = ward.districtid;

/* Limit, Offset, need offset at the end*/
/* SELECT * FROM province OFFSET 10 LIMIT 5; */
SELECT * FROM province LIMIT 5 OFFSET 10;

/* Order */
SELECT * FROM province ORDER BY province.name ASC;

/* Nested select, order after select them out */
SELECT * FROM (SELECT * FROM province LIMIT 10 OFFSET 5) AS T WHERE T.name LIKE "%L%";
SELECT * FROM (SELECT * FROM province LIMIT 10 OFFSET 5) AS T ORDER BY T.name ASC;

/* Count */
SELECT COUNT(*) FROM post_features;