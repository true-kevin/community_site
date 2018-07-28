<xmp>
<?
//조건값
$tch_cd = 1006;
$subj_cd = 3;
$choice_cate = 1;
//$db_nm = 'bs_hwakinkor';
$db_nm = 'bs_gasehis';
//$db_nm = 'bs_signalhjb';

//(시작 -1) 값
$cate = 4;
$scate = 0;
$test_seq = 1300;
$qst_seq = 12000;
$item_seq = 31000;

$str = "
-- insert into tbs_mdcop.TEST_SCATE
SELECT 
TEST_CATE + {$cate}, TEST_SCATE + {$scate}, TEST_SCATE_NM, USE_YN, DP_ORD, NOW(), '{$tch_cd}', '{$subj_cd}'
FROM {$db_nm}.TEST_SCATE WHERE TEST_CATE = {$choice_cate}

-- INSERT INTO tbs_mdcop.TEST_TCATE
SELECT 
TEST_CATE + {$cate}, TEST_SCATE + {$scate}, TEST_TCATE, TEST_TCATE_NM, USE_YN, DP_ORD, NOW()
FROM {$db_nm}.TEST_TCATE WHERE TEST_CATE = {$choice_cate}

-- INSERT INTO tbs_mdcop.TEST_INFO
SELECT 
TEST_SEQ + {$test_seq}, GRP_SEQ ,TEST_CATE + {$cate}, TEST_SCATE + {$scate}, TEST_TCATE, TEST_NM, REG_DTTM, SDT, EDT, 
QST_TYP, QST_CNT, LIMIT_TM, DP_YN, FILE_PATH, FILE_PATH2, TOT_SCORE, MDF_DTTM, TEST_AREA, TEST_VOD, GRAPH_YN, AVR_SCORE, FIR_SCORE, EX_CATE, 'N', '{$subj_cd}', '{$tch_cd}'
FROM {$db_nm}.TEST_INFO WHERE TEST_CATE = {$choice_cate}

-- INSERT INTO tbs_mdcop.TEST_QST
SELECT
b.QST_SEQ + {$qst_seq}, b.TEST_SEQ + {$test_seq}, b.BODY_SEQ, b.ORD, b.QST_KND, b.BQST_SEQ, b.QST, b.QST_IMG, b.QST_MP3, b.ANS, b.EXPLN, 
b.ITEM_TYP, b.LIMIT_TM, b.LIMIT_TM2, b.ALLOT, b.LVL, b.REG_DTTM, b.MDF_DTTM, b.USE_YN, b.TYP, b.CANS_PER
FROM
{$db_nm}.TEST_INFO a, {$db_nm}.TEST_QST b
WHERE
a.TEST_SEQ = b.TEST_SEQ
AND TEST_CATE = {$choice_cate}

-- INSERT INTO tbs_mdcop.TEST_QST_ITEM
SELECT
b.TEST_SEQ + {$test_seq}, b.QST_SEQ + {$qst_seq}, b.ITEM_SEQ + {$item_seq}, b.ORD, b.ITEM, b.ITEM_IMG, b.REG_DTTM, b.MDF_DTTM
FROM
{$db_nm}.TEST_INFO a, {$db_nm}.TEST_QST_ITEM b
WHERE
a.TEST_SEQ = b.TEST_SEQ
AND TEST_CATE = {$choice_cate}
";


$str2 = "
-- insert into tbs_mdcop.TEST_SCATE
SELECT
 '6' AS TEST_CATE, TEST_CATE AS TEST_SCATE, TEST_CATE_NM AS TEST_SCATE_NM, 'Y' AS USE_YN, DP_ORD, NOW(), '1018', '2'
 FROM bs_riracleeng.TEST_CATE
 
-- insert into tbs_mdcop.TEST_TCATE
SELECT 
'6', TEST_CATE, TEST_SCATE, TEST_SCATE_NM, USE_YN, DP_ORD, NOW()
FROM bs_riracleeng.TEST_SCATE 

-- INSERT INTO tbs_mdcop.TEST_INFO
SELECT 
TEST_SEQ + {$test_seq}, GRP_SEQ, '6', TEST_CATE, TEST_SCATE, TEST_NM, REG_DTTM, SDT, EDT, 
QST_TYP, QST_CNT, LIMIT_TM, DP_YN, FILE_PATH, FILE_PATH2, TOT_SCORE, MDF_DTTM, TEST_AREA, TEST_VOD, GRAPH_YN, AVR_SCORE, FIR_SCORE, EX_CATE, '2', '1018'
FROM bs_riracleeng.TEST_INFO

-- INSERT INTO tbs_mdcop.TEST_QST
SELECT
b.QST_SEQ + {$qst_seq}, b.TEST_SEQ + {$test_seq}, b.BODY_SEQ, b.ORD, b.QST_KND, b.BQST_SEQ, b.QST, b.QST_IMG, b.QST_MP3, b.ANS, b.EXPLN, 
b.ITEM_TYP, b.LIMIT_TM, b.LIMIT_TM2, b.ALLOT, b.LVL, b.REG_DTTM, b.MDF_DTTM, b.USE_YN, b.TYP, b.CANS_PER
FROM
bs_riracleeng.TEST_INFO a, bs_riracleeng.TEST_QST b
WHERE
a.TEST_SEQ = b.TEST_SEQ

-- INSERT INTO tbs_mdcop.TEST_QST_ITEM
SELECT
b.TEST_SEQ + {$test_seq}, b.QST_SEQ + {$qst_seq}, b.ITEM_SEQ + {$item_seq}, b.ORD, b.ITEM, b.ITEM_IMG, b.REG_DTTM, b.MDF_DTTM
FROM
bs_riracleeng.TEST_INFO a, bs_riracleeng.TEST_QST_ITEM b
WHERE
a.TEST_SEQ = b.TEST_SEQ
";


echo $str2;
?>
</xmp>