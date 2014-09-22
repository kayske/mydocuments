BEGIN TRANSACTION;
CREATE TEMPORARY TABLE test_temp(id int, name text, img1 text, img2 text, img3 text, description text, blandTitle text, blandMessage text, flBid numeric, user_id int);
INSERT INTO test_temp SELECT * FROM goods;
DROP TABLE goods;
CREATE TABLE goods (id int, name text, img1 text, img2 text, img3 text, description text, blandTitle text, blandMessage text, flBid numeric, user_id int, endDate text);
INSERT INTO goods SELECT *,null FROM test_temp;
DROP TABLE test_temp;
COMMIT;