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

if ($_POST["up"]) {
    
    foreach ($_POST as $key => $val) {
        $val = addslashes($val);
        $post_data[$key] = str_replace('$', '\$', $val);
    }   
    
    $string[] = "<?php";
    $string[] = "\$tables_data = array(";
    $string[] = "\t \"テーブル名（物理）\" => array(\"テーブル名（論理）\", \"使用目的\", \"備考\")";
    while ($d = $rtn_table->fetchAssoc()) {
        $string[] = "\t,\"".$d["Tables_in_" . $projectName]."\" => array(\"".$post_data[$d["Tables_in_" . $projectName]."_1"]."\", \"".$post_data[$d["Tables_in_" . $projectName]."_2"]."\", \"".$post_data[$d["Tables_in_" . $projectName]."_3"]."\")";
    }
    $string[] = ");";
    $string[] = "?>\n";
    
    $output_string = implode($string, "\n");
    
    $fp = fopen($tables_data_file_path, "w+");
    fputs($fp, $output_string);
    fclose($fp);
    chmod($tables_data_file_path, 0766) ;
    header("Location: ".$_SERVER["PHP_SELF"]);
}
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
<?php $i = 1;?>
<?php while ($d = $rtn_table->fetchAssoc()) { ?>
    <tr bgcolor="<?php print tr_color($i);?>">
        <td><a href="./db_desc.php?db_table=<?php print $i;?>"><?php print $d["Tables_in_" . $projectName];?></a></td>
    <?php if ($tables_data[$d["Tables_in_" . $projectName]][0] != "") { ?>
        <td><?php print $tables_data[$d["Tables_in_" . $projectName]][0];?></td>
    <?php } else { ?>
        <td><br></td>
    <?php } ?>
    <?php if ($tables_data[$d["Tables_in_" . $projectName]][1] != "") { ?>
        <td><?php print $tables_data[$d["Tables_in_" . $projectName]][1];?></td>
    <?php } else { ?>
        <td><br></td>
    <?php } ?>
    <?php if ($tables_data[$d["Tables_in_" . $projectName]][2] != "") { ?>
        <td style="font-size:13px;"><?php print $tables_data[$d["Tables_in_" . $projectName]][2];?></td>
    <?php } else { ?>
        <td><br></td>
    <?php } ?>
    </tr>
    <?php $i++;?>
<?php } ?>
</table>
<br>
<br>
<form action="./tbl_detail_update.php" method="post">
<input type="submit" value="詳細を修正する">
</form>
</div>
</body>
</html>
