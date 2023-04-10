/*USE board;

CREATE TABLE board_info(
board_no INT(11) PRIMARY KEY auto_increment
, board_title VARCHAR(100) NOT null
, board_contents VARCHAR(1000) NOT null
, board_write_date DATETIME NOT null
, board_del_flg CHAR(1) DEFAULT '0' NOT null
, board_del_date DATETIME
)*/

/* SELECT * FROM board_info; */

/* desc board_info; */

/* INSERT INTO board_info(
board_title
, board_contents
, board_write_date
, board_del_flg
, board_del_date )
VALUES (
"title20",
"content20",
NOW(),
'0',
NULL
); */

/* UPDATE board_info
SET board_title="title19", board_contents="content19"
WHERE board_no=19; */
/* COMMIT; */
SELECT * FROM board_info;