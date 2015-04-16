<?php
/**
 * File Name:   Information.php
 *
 * Description: メーラー画面表示PHPファイル。
 *              このファイルに書かれているのはメーラー画面の大まかな枠組みだけで、
 *              実際に画面左側のメニュー部分と画面右側のメインコンテンツ部分に
 *              表示されるのは、requireで読み込まれた別PHPファイルのコードになる。
 *
 * @author      Shinichi Hata <hata@icodw.co.jp>
 * @created     2006/02/06
 * @modified    2006/03/27 by hata
 * @version     SVN:$Id: Information.php 1498 2009-08-18 01:34:53Z honma $
 */

/*
 * インクルードセクション
 */
// 共通ファイル部分の読み込み
require_once("./ini/common.php");

/*
 * PHP処理セクション
 */
// メニュー部分に表示するphpファイルの指定
if (!preg_match("/config/", $_REQUEST["do"])) {
    $menuIncFile = "./dir_tree.php";
} else {
    $menuIncFile = "./config_menu.php";
}

// メインコンテンツ部分に表示するphpファイルの指定
if (isset($_REQUEST["do"]) && $_REQUEST['do'] != "" && file_exists("./{$_REQUEST['do']}.php")) {
    /* 新規作成画面or一括返信画面表示時には入力チェックのJSをonLoadで走らせる
       (checkInputs()のファンクション定義は、$mainIncFileで指定されたファイル内で行う) */
    if ($_REQUEST['do'] == "new" || ($_REQUEST['do'] == "multi" && $_REQUEST['mode'] == "reply_all")) {
        $onLoad=" onLoad=\"checkInputs();\"";
    }
    $mainIncFile = "./{$_REQUEST['do']}.php";
} else {
    // 指定がないor存在しなければ受信トレイを表示
    $_REQUEST["dir_id"] = RECEIVE_DIR;
    $mainIncFile = "./tray.php";
}

// 下のjavascriptでcookieにセットした情報を$styleにいれてます。
$style = $_REQUEST["style"];
$style = explode(",",$style);

// $css には、読み込むスタイルシートのファイル名がはいります。
$css = $style[0];
// $country には、読み込む画像の名前が入ります。
$country = $style[1];

// 設定無しの場合はデフォルトで下のが入ります。
if($style[0] == NULL || $style[1] == NULL){
    $css = "./css/mailer_color8.css";
    $country = "./img/england.jpg";
}

?>
<?php
/**********************************************************************
 * HTML表示セクション
 **********************************************************************/
?>
<html>
<head>
    <title><?php print($site["site_account"][$site["default_info"]]["name"]); ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=Shift-JIS">
    <meta http-equiv="Cache-Control" content="no-cache">
    <link href="<?php print($css); ?>" rel="stylesheet" type="text/css" />
</head>

<script type="text/javascript" langage="javascript">
<!--
/*
 * クッキーでファイル名、画像名を記憶します。
 * 第一引数(kword)にクッキーで読み込む時のファイル名
 * 第二引数(kdata)にクッキーで読み込むデータ
 * 第三引数(kday)にクッキーを何日有効にするか
 * 第四引数(kokki)に読み込みの画像名が入ります。
*/
function CookieWrite(kword, kdata, kday , kokki){
    if(!navigator.cookieEnabled){ // クッキーが利用可能かどうか
    alert("クッキーの設定を許可しないと使えません");
    return;
    }
    var obj = document.getElementsByTagName("link"); // objに<link href= xA珪の部分を入れる
    var country_ary = new Array(2);
    country_ary[0] = kdata; // cuuntry_ary[0]にスタイルシートのファイル名を入れる
    country_ary[1] = kokki; // country_ary[1]に画像の名前を入れる
//    document.getElementById("img").src = kokki; // 画像を切り替えてます。
    obj[0].href = kdata; // スタイルシートの切り替え
    sday = new Date();
    sday.setTime(sday.getTime() + (kday * 1000 * 60 * 60 * 24)); // クッキーの有効時間をここで作ります。
    s2day = sday.toGMTString();
    document.cookie = kword + "=" + escape(country_ary) + ";expires=" + s2day; // クッキーの書き込み
}
//-->
</script>

<body<?php print($onLoad); ?>>

<table width="980" height="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td width="140" height="67" bgcolor="white" valign="bottom">
        <center><font style="font-weight: bold;"><?php print($site["site_account"][$site["default_info"]]["name"]); ?></font></center>
        </td>
        <td class="color10">&nbsp;
        </td>
        <td width="820" bgcolor="white" valign="bottom">&nbsp;
            <input type="image" src="./img/germany.gif" name="color" value="1" onclick="CookieWrite('style','./css/mailer_style.css','30','./img/doitz_l.jpg')">
            <input type="image" src="./img/italy.gif" name="color" value="2" onclick="CookieWrite('style','./css/mailer_color2.css','30','./img/italie_l.jpg')">
            <input type="image" src="./img/france.gif" name="color" value="3" onclick="CookieWrite('style','./css/mailer_color3.css','30','./img/flans_l.jpg')">
            <input type="image" src="./img/japan.gif" name="color" value="4" onclick="CookieWrite('style','./css/mailer_color4.css','30','./img/japan_l.jpg')">
            <input type="image" src="./img/brazil.gif" name="color" value="5" onclick="CookieWrite('style','./css/mailer_color5.css','30','./img/blazil.jpg')">
            <input type="image" src="./img/spain.gif" name="color" value="6" onclick="CookieWrite('style','./css/mailer_color6.css','30','./img/spain_l.jpg')">
            <input type="image" src="./img/nigeria.gif" name="color" value="7" onclick="CookieWrite('style','./css/mailer_color7.css','30','./img/nige_l.jpg')">
            <input type="image" src="./img/ing.gif" name="color" value="8" onclick="CookieWrite('style','./css/mailer_color8.css','30','./img/england.jpg')">
        </td>
    </tr>
    <tr>
        <td height="3" class="color1">
        </td>
        <td class="color2">
        </td>
        <td class="color3">
        </td>
    </tr>
    <tr>
        <td height="25" class="color4">&nbsp;
        </td>
        <td class="color5">&nbsp;
        </td>
        <td class="color6">
        <table height="20" border="0" cellpadding="3" cellspacing="2">
        <tr>
            <td class="color6"><font color="white">|</font></td>
            <td class="color6"><a href="Information.php?do=tray&dir_id=<?php print(RECEIVE_DIR); ?>"><font color="black">受信トレイ</font></a></td>
            <td class="color6"><font color="white">|</font></td>
            <td class="color6"><a href="Information.php?do=new"><font color="black">新規作成</font></a></td>
            <td class="color6"><font color="white">|</font></td>
            <td class="color6"><a href="Information.php?do=config"><font color="black">設定ツール</font></a></td>
            <td class="color6"><font color="white">|</font></td>
            <td class="color6"><a href="Information.php?do=src"><font color="black">検索ツール</font></a></td>
            <td class="color6"><font color="white">|</font></td>
<?php /*
            <td class="color6"><a href="Information.php?do=list_send"><font color="black">ﾘｽﾄ一括送信</font></a></td>
            <td class="color6"><font color="white">|</font></td>
*/ ?>
                </tr>
        </table>
        </td>
    </tr>
    <tr>
        <td height="3" class="color7">
        </td>
        <td class="color8">
        </td>
        <td class="color9">
        </td>
    </tr>
    <tr>
        <td valign="top" bgcolor="white">
        <?php include_once($menuIncFile); ?>
        </td>
        <td valign="top" class="color11">&nbsp;
        </td>
        <td valign="top" bgcolor="white">
        <?php include_once($mainIncFile); ?>
        </td>
    </tr>
</table>
</body>
</html>
