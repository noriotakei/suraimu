<?php
/**
 * コンバート重複ユーザー確認
 *
 * ※本ファイルは生きてるユーザーのみ重複チェックします（disable=0 のみ）
 *
 * 各サイトにあるコンバート対象ユーザーテーブル(**_convert_user)を指定して実行
 * remail_key,access_keyは振り直せば良いのでdisable対象としません
 *
 *  */

require_once(D_BASE_DIR . "/common/admin_common.php");

$UserOBJ = User::getInstance();

$param = $requestOBJ->getParameterExcept($exceptArray);

if( (!$param['type'] == "target") && (!$param['type'] == "verify") ){
    exit("対象ﾃｰﾌﾞﾙ情報取得ｴﾗｰ!　行数：".__LINE__);
}
$tableName = $param['type'];

ini_set("memory_limit","-1");
ini_set("max_execution_time", 0);

//重複確認：disable対象
$updateArray = array("disable" => 1);
$whereKeyWordArray = array(
                             "mb_serial_number"
                            ,"mb_address"
                            ,"pc_address"
                            ,"login_id"
                            );

$resultMailWord = "";
$resultWordArray = array();

foreach($whereKeyWordArray as $keyWord){

    $updateWhereArray = "";
    $updateCount = 0;

    $updateWhereArray[] = "
    cnv.disable = 0
    AND cnv." . $keyWord ." != ''
    AND EXISTS
    (
        SELECT * FROM user as user
        WHERE user.disable = 0
        AND user." . $keyWord ." != ''
        AND cnv." . $keyWord ." = user." . $keyWord ."
    )";

    $dbResultOBJ = $UserOBJ->update("convert_".$tableName."_user as cnv", $updateArray, $updateWhereArray);

    if ($dbResultOBJ === FALSE) {
        exit("ﾕｰｻﾞｰ情報取得ｴﾗｰ!　行数：".__LINE__);
    }else{
        $resultMailWord.= $keyWord . " => " .  $dbResultOBJ->rowCount()."\n";
        $resultWordArray[] = $keyWord . " ： " .  $dbResultOBJ->rowCount();
    }
}

$resultMailWord .= "\n\n";

if($param['type'] == "verify"){
    //重複確認：非disable対象
    $searchWordArray = array(
                             "remail_key"
                            ,"access_key"
                            );

    $columnArray = "";
    $columnArray[] = "id";

    foreach($searchWordArray as $searchWord){
        $searchWhereArray = "";

        $searchWhereArray[] = "
            cnv.disable = 0
            AND cnv." . $searchWord ." != ''
            AND EXISTS
            (
                SELECT * FROM user as user
                WHERE user.disable = 0
                AND user." . $searchWord ." != ''
                AND cnv." . $searchWord ." = user." . $searchWord ."
            )
        ";

        $sql = $UserOBJ->makeSelectQuery("convert_".$tableName."_user as cnv", $columnArray, $searchWhereArray);

        $dbResultOBJ = "";
        if (!$dbResultOBJ = $UserOBJ->executeQuery($sql)) {
            // エラー(処理止めずに先へ)
            print "ERROR = " . $searchWord;

        }

        $dataList = $dbResultOBJ->fetchAll();

        if(count($dataList) >= 1){
            $resultMailWord .= $searchWord." に重複あり!振り直して下さい\n";
            $resultWordArray[] = $searchWord." に重複あり!振り直して下さい\n";
        }else{
            $resultMailWord .= $searchWord." 重複無し\n";
            $resultWordArray[] = $searchWord." 重複無し\n";
        }
    }
}


print "<table>";
foreach($resultWordArray as $value){
    print "<tr><td>".$value."</td></tr>";
}
print "</table>";

exit("COMPLETE");

?>