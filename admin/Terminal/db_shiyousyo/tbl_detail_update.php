<?php
require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/etc/__autoload.php");

$projectName = PROJECT;

function tr_color($i) {
    if ($i % 2) {
        // $i が奇数
        return "#DCDCDC";
    } else {
        // $i が偶数
        return "#F5F5F5";
    }
}
// $columns_data が定義されているファイルのパス
$tables_data_file_path = "./tables/tables.ini";

if (file_exists($tables_data_file_path)) {
    include ($tables_data_file_path);
} else {
    if (fopen($tables_data_file_path, "w+")) {
        chmod($tables_data_file_path, 0766) ;
    } else {
        exit ("エラー発生") ;
    }
}

$dbOBJ = DatabaseAccess::getInstance();
$sql = "SHOW TABLES";
$rtn_table = $dbOBJ->executeQuery($sql);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
<title>BIG TIME テーブル一覧</title>
</head>
<body>
<div align="center">
<span style="font-size:20pt; color:#666666;">BIG TIMEテーブル一覧</font>
<table border="1" bordercolor="#999999" cellspacing="0" cellpadding="3" style="font-size:14px; color:#666666;">
    <tr bgcolor="<?php print tr_color(0);?>">
        <td>テーブル名（物理）</td>
        <td>テーブル名（論理）</td>
        <td>使用目的</td>
        <td>備考</td>
    </tr>
<form action="./db_show_tables.php" method="post">
<?php $i = 1;?>
<?php while ($d = $rtn_table->fetchAssoc()) { ?>
    <tr bgcolor="<?php print tr_color($i);?>">
        <td><a href="./db_desc.php?db_table=<?php print $i;?>"><?php print $d["Tables_in_" . $projectName];?></a></td>
        <td><input type="text" name="<?php print $d["Tables_in_" . $projectName];?>_1" value="<?php print $tables_data[$d["Tables_in_" . $projectName]][0];?>" size="30"></td>
        <td><input type="text" name="<?php print $d["Tables_in_" . $projectName];?>_2" value="<?php print $tables_data[$d["Tables_in_" . $projectName]][1];?>" size="50"></td>
        <td><input type="text" name="<?php print $d["Tables_in_" . $projectName];?>_3" value="<?php print $tables_data[$d["Tables_in_" . $projectName]][2];?>" size="50"></td>
    </tr>
    <?php $i++;?>
<?php } ?>
</table>
<br>
<input type="submit" value="更新">
<input type="hidden" name="up" value="1">
</form>
</div>
</body>
</html>
