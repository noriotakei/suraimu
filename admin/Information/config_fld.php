<?php
/**
 * File Name:    config_fld.php
 * 
 * Description: フォルダ設定表示PHPファイル。
 *              設定変更したいフォルダを選択し、フォルダ名の変更、
 *              サブフォルダの追加、フォルダ削除用のフォームを表示する。
 * 
 * Author:      Shinichi Hata <hata@icodw.co.jp>
 * Created:     2006/02/06
 * Modified:    2006/03/20 by hata
 */

/**********************************************************************
 * インクルードセクション
 **********************************************************************/
// 共通ファイル部分の読み込み
require_once("./ini/common.php");

/**********************************************************************
 * PHP処理セクション
 **********************************************************************/

// フォルダツリー表示用データの生成
$dirList = "";
foreach ($dir_tbl as $key => $value) {
    // 1階層目フォルダデータの取得
    if ($value["tree_level"] == 1) {
        $dirList .= '<span style="margin-left: 5;"'
                  . ' onClick="setDirForm(' . $value['id'] . ');">'
                  . $value['name'] . '</span><br>' . "\n";
        
        foreach ($dir_tbl as $key2 => $value2) {
            // 2階層目フォルダデータの取得
            if ($value2["tree_level"] == 2 && $value2["parent_id"] == $value["id"]) {
                // 1階層目フォルダの子フォルダであれば表示用配列に格納する
                $dirList .= '<span style="margin-left: 15;"'
                          . ' onClick="setDirForm(' . $value2['id'] . ');">'
                          . '+' . $value2['name'] . '</span><br>' . "\n";
                
                foreach ($dir_tbl as $key3 => $value3) {
                    // 3階層目フォルダデータの取得
                    if ($value3["tree_level"] == 3 && $value3["parent_id"] == $value2["id"]) {
                        // 2階層目フォルダの子フォルダであれば表示配列に格納する
                        $dirList .= '<span style="margin-left: 25;"'
                                  . ' onClick="setDirForm(' . $value3['id'] . ');">'
                                  . '+' . $value3['name'] . '</span><br>' . "\n";
                    }
                }
            }
        }
    }
}
?>

<?php
/**********************************************************************
 * HTML表示セクション
 **********************************************************************/
?>
<?php // JavaScript定義 ?>
<script language="Javascript" type="text/javascript">
<!--
<?php
$cnt = count($dir_tbl);

print("var dirData = [\n");
for ($i = 0; $i < $cnt; $i++) {
    print("\t[{$dir_tbl[$i][id]}, \"{$dir_tbl[$i][name]}\", {$dir_tbl[$i][tree_level]}]");
    if ($i != $cnt-1) {
        print(",\n");
    } else {
        print("\n");
    }
}
print("];\n");
?>

function setDirForm(dirId) {
    var i;

    for (i=0; i<dirData.length; i++) {
        if (dirData[i][0] == dirId) {
            document.getElementById("dirName").innerText   = dirData[i][1];
            document.getElementById("dirName").textContent = dirData[i][1]
            document.getElementById("renDirName").value    = dirData[i][1];
            document.getElementById("subDirName").value    = "サブフォルダ名";
            document.getElementById("renDirId").value      = dirData[i][0];
            document.getElementById("subDirId").value      = dirData[i][0];
            document.getElementById("delDirId").value      = dirData[i][0];
            if (dirData[i][2] == 1) {
                document.getElementById("rename").style.display    = "none";
                document.getElementById("subFolder").style.display = "block";
                document.getElementById("delete").style.display    = "none";
            } else if (dirData[i][2] == 2) {
                document.getElementById("rename").style.display    = "block";
                document.getElementById("subFolder").style.display = "block";
                document.getElementById("delete").style.display    = "block";
            } else {
                document.getElementById("rename").style.display    = "block";
                document.getElementById("subFolder").style.display = "none";
                document.getElementById("delete").style.display    = "block";
            }
            document.getElementById("dirForm").style.display = "block";
        }
    }
}

function clearForm(obj) {
    if (obj.value == "サブフォルダ名") {
        obj.value = "";
    }
}
// -->
</script>

<!-- 設定フォーム表示 -->
<strong>フォルダ設定</strong>
<hr>
<font size="2">
<strong>・設定変更したいフォルダ名をクリックしてください</strong><br>
<br>
<?php print($dirList); ?>
<br>
<div id="dirForm" style="display: none">
    <strong>・「<span id="dirName"></span>」フォルダの設定変更</strong><br>
    <div id="rename" style="display: none">
    <form method="post" action="Information.php?do=config_exec&mode=folder" style="margin-top:0; margin-bottom:5;">
    <input type="text" name="new_dir_name" value="" size="15" id="renDirName">
    <input type="hidden" name="dir_id" value="" id="renDirId">
    <input type="hidden" name="change_dir_name" value="1">
    <input type="submit" value="フォルダ名の変更">
    </form>
    </div>
    <div id="subFolder" style="display: none">
    <form method="post" action="Information.php?do=config_exec&mode=folder" style="margin-top:0; margin-bottom:5;">
    <input type="text" name="new_subdir_name" value="" size="15" onFocus="clearForm(this);" id="subDirName">
    <input type="hidden" name="dir_id" value="" id="subDirId">
    <input type="hidden" name="add_subdir" value="1">
    <input type="submit" value="サブフォルダの追加">
    </form>
    </div>
    <div id="delete" style="display: none">
    <form method="post" action="Information.php?do=config_exec&mode=folder" style="margin-top:0; margin-bottom:5;">
    <input type="hidden" name="del_dir_id" value="" id="delDirId">
    <input type="hidden" name="del_dir" value="1">
    <input type="submit" value="フォルダの削除">
    </form>
    </div>
</div>
</font>
