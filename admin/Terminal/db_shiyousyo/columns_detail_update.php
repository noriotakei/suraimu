<?php
require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/etc/__autoload.php");

$projectName = PROJECT;

function tr_color($i) {
    if ($i % 2) {
        // $i が奇数
        return "#F5F5F5";
    } else {
        // $i が偶数
        return "#DCDCDC";
    }
}

// ここからデータベースを操作
$dbOBJ = DatabaseAccess::getInstance();
$sql = "SHOW TABLES";
$rtn_table = $dbOBJ->executeQuery($sql);
$k = 1;
while ($d = $rtn_table->fetchAssoc()) {
    foreach($d as $v) {
        if ($_REQUEST["db_table"] == $k) {
            $option_tag .= "<option value=\"".$k."\" selected>".$v."</option>\n";
            $tbl_number = $k;
        } else {
            $option_tag .= "<option value=\"".$k."\">".$v."</option>\n";
        }
        $db_table_array[$k] = $v;
    }
    $k++;
}

if ($_REQUEST["db_table"] =="") {
    // 空なら user_tbl のキー
    $_REQUEST["db_table"] = array_search("user_tbl", $db_table_array);
}

if ($_REQUEST["db_table"] < 1 || $k < $_REQUEST["db_table"]) {
    exit("何か変。。。");
}

// $columns_data が定義されているファイルのパス
$columns_data_file_path = "./tables/".$db_table_array[$_REQUEST["db_table"]].".ini";

if (file_exists($columns_data_file_path)) {
    include ($columns_data_file_path);
} else {
    if (fopen($columns_data_file_path, "w+")) {
        chmod($columns_data_file_path, 0766) ;
    } else {
        exit ("エラー発生") ;
    }
}

$sql = "DESC ".$db_table_array[$_REQUEST["db_table"]];
$rtn = $dbOBJ->executeQuery($sql);

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
<title><?php print $db_table_array[$_REQUEST["db_table"]];?></title>
</head>
<body>
<div align="center">
<form action="./db_desc.php" method="post">
    <select name="db_table"><?php print $option_tag;?></select>
<input type="submit" value="desc">
</form>
<a href="./db_show_tables.php" style="font-size:13px; color=:#666666;">DB 一覧へ</a><br>

<br>
<span style="font-size:20pt; color:#666666;"><?php print $db_table_array[$_REQUEST["db_table"]];?></span>
<br>
<table border="1" bordercolor="#999999" cellspacing="0" cellpadding="3" style="font-size:14px; color:#666666;">
    <tr style="font-size:13px;" bgcolor="<?php print tr_color(1);?>">
        <td>Field</td>
        <td>Type</td>
        <td>Null</td>
        <td>Key</td>
        <td>Default</td>
        <td>Extra</td>
        <td>カラム名（論理）</td>
        <td>備考</td>
    </tr>
<form action="./db_desc.php" method="post">
<?php $i = 0;?>
<?php while ($d = $rtn->fetchAssoc()) { ?>
    <tr bgcolor="<?php print tr_color($i);?>">
    <?php foreach($d as $v) { ?>
        <?php if ($v != "") { ?>
        <td><?php print $v;?></td>
        <?php } else { ?>
        <td><br></td>
        <?php } ?>
    <?php } ?>
        <td style="font-size:14px;"><input type="text" name="<?php print $d["Field"];?>_1" value="<?php print $columns_data[$d["Field"]][0];?>"></td>
        <td style="font-size:13px;"><input type="text" name="<?php print $d["Field"];?>_2" value="<?php print $columns_data[$d["Field"]][1];?>" size="80"></td>
    </tr>
<?php $i ++;?>
<?php } ?>
</table>
<br>
<br>
<input type="submit" value="更新">
<input type="hidden" name="db_table" value="<?php print $tbl_number;?>">
<input type="hidden" name="up" value="1">
</form>
</div>
</body>
</html>
