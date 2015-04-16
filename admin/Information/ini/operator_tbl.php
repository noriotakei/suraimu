<?php
// 問い合わせ対応ユーザーデータを取得する(管理画面ログインユーザーを参照)
if (!$db) {

    $base = dirname(dirname(dirname(dirname(__FILE__))));

    require_once($base . "/etc/config-ini.php");
    require_once($base . "/admin/Information/lib/InformationDB.php");
    $config["dsn"] = "mysqli://"
                    .$define["define"]["DATABASE"]["params"]["username"]
                    .":" . $define["define"]["DATABASE"]["params"]["password"]
                    ."@" . $define["define"]["DATABASE"]["params"]["host"]
                    .":3306"
                    ."/" . $define["define"]["DATABASE"]["params"]["dbname"];

    // MySQLへ接続
    $db = new InformationDB($config["dsn"]);

    $whereString = array();
    $whereString[] = "is_display = 1";
    $whereString[] = "disable = 0";
    $whereString = implode(" AND ", $whereString);

    $sql = " SELECT *"
         . " FROM information_operator_list"
         . " WHERE "
         . $whereString
         . " ORDER BY id ASC" ;

    $rs = $db->executeSql($sql);

    $operatorList = "";
    if ($rs->numRows() > 0) {
        while ($row = $rs->fetchRow(DB_FETCHMODE_ASSOC)) {
            $operator_tbl[] = $row;
        }
    } /*else {
        // デフォルトの担当者テーブル（DB保持前）
        // is_display = 0[非表示]、1[表示]
        $operator_tbl = array(
            array('id' => 3, 'name' => '清水', 'sakura' => '3', 'is_display' => 1),
            array('id' => 4, 'name' => '井坂', 'sakura' => '4', 'is_display' => 1),
            array('id' => 6, 'name' => '鈴木', 'sakura' => '6', 'is_display' => 1),
            array('id' => 7, 'name' => '坂入', 'sakura' => '7', 'is_display' => 1),
            array('id' => 9, 'name' => '酒井', 'sakura' => '9', 'is_display' => 1),
            array('id' => 11, 'name' => '関谷', 'sakura' => '11', 'is_display' => 1),
            array('id' => 12, 'name' => '楡木', 'sakura' => '12', 'is_display' => 1),
            array('id' => 13, 'name' => '大竹', 'sakura' => '13', 'is_display' => 1),
            array('id' => 14, 'name' => '森', 'sakura' => '14', 'is_display' => 1),
            array('id' => 15, 'name' => '米原', 'sakura' => '15', 'is_display' => 1),
            array('id' => 16, 'name' => '木村', 'sakura' => '16', 'is_display' => 1),
            array('id' => 17, 'name' => '網本', 'sakura' => '17', 'is_display' => 1),
            array('id' => 18, 'name' => '荒木', 'sakura' => '18', 'is_display' => 1),
            array('id' => 19, 'name' => '山本', 'sakura' => '19', 'is_display' => 1),
        );
    }*/
}

/*
$operator_tbl = array(
//    array('id' => 1, 'name' => 'TEST1', 'sakura' => '1', 'is_display' => 0 または 1),
    array('id' => 2, 'name' => '本好', 'sakura' => '2', 'is_display' => 1),
    array('id' => 3, 'name' => '清水', 'sakura' => '3', 'is_display' => 1),
    array('id' => 4, 'name' => '井坂', 'sakura' => '4', 'is_display' => 1),
    array('id' => 5, 'name' => '深味', 'sakura' => '5', 'is_display' => 0),
    array('id' => 6, 'name' => '鈴木', 'sakura' => '6', 'is_display' => 1),
    array('id' => 7, 'name' => '坂入', 'sakura' => '7', 'is_display' => 1),
    array('id' => 8, 'name' => '檜垣', 'sakura' => '8', 'is_display' => 0),
    array('id' => 9, 'name' => '酒井', 'sakura' => '9', 'is_display' => 1),
    array('id' => 10, 'name' => '中村', 'sakura' => '10', 'is_display' => 1),
    array('id' => 11, 'name' => '関谷', 'sakura' => '11', 'is_display' => 1),
    array('id' => 12, 'name' => '楡木', 'sakura' => '12', 'is_display' => 1),
    array('id' => 13, 'name' => '大竹', 'sakura' => '13', 'is_display' => 1),
    array('id' => 14, 'name' => '森', 'sakura' => '14', 'is_display' => 1),
    array('id' => 15, 'name' => '米原', 'sakura' => '15', 'is_display' => 1),
    array('id' => 16, 'name' => '木村', 'sakura' => '16', 'is_display' => 1),
);
*/
?>