<?php
/**
 * File Name:   src.php
 *
 * Description: 検索フォーム表示PHPファイル。
 *              検索方法の設定検索文字列の入力、
 *
 * Author:      owada
 * Created:     2007/04/18
 */

/**
 * インクルードセクション
 */
// 共通ファイル部分の読み込み
require_once("./ini/common.php");

// 検索フォルダ選択タグの生成
$dirIdOpt = "";
foreach ($dir_tbl as $key => $value) {
    // 1階層目フォルダデータの取得
    if ($dir_tbl[$key]["tree_level"] == 1 && !($_REQUEST["dir_id"] == DELETE_DIR && $dir_tbl[$key]["id"] == DELETE_DIR)) {
        // 削除済みフォルダから削除済みフォルダへの移動選択はできない
        $dirIdOpt .= "<option value=\"{$dir_tbl[$key][id]}\">{$dir_tbl[$key][name]}</option>\n";

        foreach ($dir_tbl as $key2 => $value2) {
            // 2階層目フォルダデータの取得
            if ($dir_tbl[$key2]["tree_level"] == 2 && $dir_tbl[$key2]["parent_id"] == $dir_tbl[$key]["id"]) {
                // 1階層目フォルダの子フォルダであれば表示用配列に格納する
                $dirIdOpt .= "<option value=\"{$dir_tbl[$key2][id]}\">　+{$dir_tbl[$key2][name]}</option>\n";

                foreach ($dir_tbl as $key3 => $value3) {
                    // 3階層目フォルダデータの取得
                    if ($dir_tbl[$key3]["tree_level"] == 3 && $dir_tbl[$key3]["parent_id"] == $dir_tbl[$key2]["id"]) {
                        // 2階層目フォルダの子フォルダであれば表示配列に格納する
                        $dirIdOpt .= "<option value=\"{$dir_tbl[$key3][id]}\">　　+{$dir_tbl[$key3][name]}</option>\n";
                    }
                }
            }
        }
    }
}

// 検索条件指定用タグの生成(登録状態)
$searchRegistStatusOpt = "";
$searchRegistStatusOpt .= "<option value=''>気にしない</option>\n";
$searchRegistStatusOpt .= "<option value='".$define["define"]["USER_REGIST_STATUS_PRE_MEMBER"]."'>仮登録</option>\n";
$searchRegistStatusOpt .= "<option value='".$define["define"]["USER_REGIST_STATUS_MEMBER"]."'>本登録</option>\n";
$searchRegistStatusOpt .= "<option value='".$define["define"]["USER_REGIST_STATUS_MEMBER_QUIT"]."'>会員解除</option>\n";

// 検索条件指定用タグの生成(入金状態)
$searchTradeStatusOpt = "";
$searchTradeStatusOpt .= "<option value=''>気にしない</option>\n";
$searchTradeStatusOpt .= "<option value='0'>入金無し</option>\n";
$searchTradeStatusOpt .= "<option value='1'>入金有り</option>\n";
?>

<!-- 検索フォーム表示 -->
<strong>検索フォーム</strong>
<hr>
<form method="post" action="Information.php" style="margin-top:0; margin-bottom:0;">
<table border="0" cellpadding="0" cellspacing="0">
<tr>
    <td height="30" valign="top">
        <select name="dir_id">
            <?php echo  $dirIdOpt?>
        </select>
        <input type="checkbox" name="sub_dir" value="1">サブフォルダも含む
    </td>
</tr>
</table>
<table width="600" border="1" cellpadding="2" cellspacing="0">
    <tr>
        <td width="110">
        <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="70"><font size="2">送信者アド</font></td>
            <td>
                <font size="2" color="green"><strong>： &gt;&gt;&gt;</strong></font>
            </td>
        </tr>
        </table>
        </td>
        <td><input type="text" name="src_from_address" size="90" value="" style="ime-mode: disabled;"></td>
    </tr>
    <tr>
        <td width="110">
        <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="70"><font size="2">送信者名</font></td>
            <td>
                <font size="2" color="green"><strong>： &gt;&gt;&gt;</strong></font>
            </td>
        </tr>
        </table>
        </td>
        <td><input type="text" name="src_from_name" size="90" value=""></td>
    </tr>
    <tr>
        <td width="110">
        <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="70"><font size="2">宛先</font></td>
            <td>
                <font size="2" color="green"><strong>： &gt;&gt;&gt;</strong></font>
            </td>
        </tr>
        </table>
        </td>
        <td><input type="text" name="src_to_address" size="90" value="" style="ime-mode: disabled;"></td>
    </tr>
    <tr>
        <td width="110">
        <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="70"><font size="2">件名</font></td>
            <td>
                <font size="2" color="green"><strong>： &gt;&gt;&gt;</strong></font>
            </td>
        </tr>
        </table>
        </td>
        <td><input type="text" name="src_subject" size="90" value=""></td>
    </tr>
    <tr>
        <td width="110">
        <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="70"><font size="2">登録ｽﾃｰﾀｽ</font></td>
            <td>
                <font size="2" color="green"><strong>： &gt;&gt;&gt;</strong></font>
            </td>
        </tr>
        </table>
        </td>
        <td>
        <select name="src_regist_status">
            <?php print($searchRegistStatusOpt); ?>
        </select>
        </td>
    </tr>
    <tr>
        <td width="110">
        <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="70"><font size="2">入金状態</font></td>
            <td>
                <font size="2" color="green"><strong>： &gt;&gt;&gt;</strong></font>
            </td>
        </tr>
        </table>
        </td>
        <td>
        <select name="src_trade_status">
            <?php print($searchTradeStatusOpt); ?>
        </select>
        </td>
    </tr>
    <tr>
        <td width="110">
        <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="70"><font size="2">本文</font></td>
            <td>
                <font size="2" color="green"><strong>： &gt;&gt;&gt;</strong></font>
            </td>
        </tr>
        </table>
        </td>
        <td><input type="text" name="src_body" size="90" value=""></td>
    </tr>
</table>
<br>
<input type="checkbox" name="src_rcv_date_from" value="1">
<input type="text" name="rcv_date_from_y" value="<?php echo  date("Y")?>" size="4" maxlength="4" style="ime-mode: disabled;">年
<input type="text" name="rcv_date_from_m" value="<?php echo  date("m")?>" size="2" maxlength="2" style="ime-mode: disabled;">月
<input type="text" name="rcv_date_from_d" value="<?php echo  date("d")?>" size="2" maxlength="2" style="ime-mode: disabled;">日
<input type="text" name="rcv_date_from_h" value="<?php echo  date("H")?>" size="2" maxlength="2" style="ime-mode: disabled;">時
<input type="text" name="rcv_date_from_i" value="<?php echo  date("i")?>" size="2" maxlength="2" style="ime-mode: disabled;">分
<input type="text" name="rcv_date_from_s" value="<?php echo  date("s")?>" size="2" maxlength="2" style="ime-mode: disabled;">秒　以降に受信<br>
<input type="checkbox" name="src_rcv_date_to" value="1">
<input type="text" name="rcv_date_to_y" value="<?php echo  date("Y")?>" size="4" maxlength="4" style="ime-mode: disabled;">年
<input type="text" name="rcv_date_to_m" value="<?php echo  date("m")?>" size="2" maxlength="2" style="ime-mode: disabled;">月
<input type="text" name="rcv_date_to_d" value="<?php echo  date("d")?>" size="2" maxlength="2" style="ime-mode: disabled;">日
<input type="text" name="rcv_date_to_h" value="<?php echo  date("H")?>" size="2" maxlength="2" style="ime-mode: disabled;">時
<input type="text" name="rcv_date_to_i" value="<?php echo  date("i")?>" size="2" maxlength="2" style="ime-mode: disabled;">分
<input type="text" name="rcv_date_to_s" value="<?php echo  date("s")?>" size="2" maxlength="2" style="ime-mode: disabled;">秒　以前に受信
<br><br>
<input type="radio" name="src_method" value="0" checked>AND 検索
<input type="radio" name="src_method" value="1">OR 検索
<br><br>
<input type="submit" name="src" value="検索">
<input type="hidden" name="do" value="tray">
</form>
</table>
