<?php

//MySQL DBA用共通コンスタント集

//パスワード宣言
    define('D_USER_PASSWORD','user');   //ユーザー（参照のみ）
    define('D_ADMIN_PASSWORD','admin'); //管理者（更新可能）

//権限の配列宣言（添え字：0:ユーザー、1:管理者、2：エラー）
//添え字追加の時は、_func.phpの修正が必要！
    $ARS_ACT['cd']          =   array('1','2','9');
    $ARS_ACT['msg']         =   array('ユーザー権限でログインしています。<br>参照系のＳＱＬのみ実行可能です。',
                                    '管理者権限でログインしています。','ログイン出来ていません。');
    $ARS_ACT['bgcolor']     =   array('#FFFFCC','#CCFFCC','#FFFFCC');
    $ARS_ACT['actAdminFlg'] =   array(false,true,false);    //更新権限フラグ（true：更新可能）
    $sActCd                 =   '';     //$ARS_ACT['cd']の値を保持する変数

//ＤＢ接続用配列宣言（ここの配列に入れればmain.phpに表示される←こっちの改修はいらない）
    $ARS_DB['siteName'] =   array(
                                    '手入力',
                                    'test_admin',
                                );
    $ARS_DB['hostName'] =   array(
                                    '',
                                    'localhost',
                                );
    $ARS_DB['userName'] =   array(
                                    '',
                                    'test_admin',
                                );
    $ARS_DB['password']     =   array(
                                    '',
                                    '50po100po',
                                );
    $ARS_DB['dbName']       =   array(
                                    '',
                                    'test_admin',
                                );

//定型のＳＱＬ文
    define('D_SHOW_TABLE','SHOW TABLES');
    define('D_SHOW_TABLE_STATUS','SHOW TABLE STATUS');
    define('D_SHOW_COLUMNS','SHOW COLUMNS FROM ');
    define('D_SHOW_INDEX','SHOW INDEX FROM ');
    define('D_SHOW_CREATE_TABLE','SHOW CREATE TABLE ');
    define('D_EXPLAIN','EXPLAIN ');
    define('D_OPTIMIZE','OPTIMIZE TABLE ');
    define('D_ANALYZE','ANALYZE TABLE ');
    define('D_SELECT_AST','SELECT * FROM ');
    define('D_LIMIT_DATA','LIMIT 10');  //db_mntで「ﾃﾞｰﾀ表示」の時に使用

?>
