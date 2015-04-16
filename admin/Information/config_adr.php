<?php
/**
 * File Name:   config_adr.php
 *
 * Description: アドレス帳設定表示PHPファイル。
 *              新しい連絡先の追加、削除用フォームを表示する。
 *
 * Author:      Shinichi Hata <hata@icodw.co.jp>
 * Created:     2006/02/16
 * Modified:    2006/03/20 by hata
 */
?>

<?php
/**********************************************************************
 * HTML表示セクション
 **********************************************************************/
?>
<!-- 設定フォーム表示 -->
<strong>アドレス帳設定</strong>
<hr>
<font size="2"><strong>・連絡先一覧</strong></font>
<table border="1" cellpadding="0" cellspacing="0">
    <tr>
        <td width="30"><font size="2">NO</font></td>
        <td width="160"><font size="2">名前</font></td>
        <td width="180"><font size="2">メールアドレス</font></td>
    </tr>
<?php foreach ((array)$ad_book_tbl as $key => $value) { ?>
    <tr>
        <td><font size="2"><?php print($ad_book_tbl[$key]["id"]); ?></font></td>
        <td><font size="2"><?php print($ad_book_tbl[$key]["name"]); ?></font></td>
        <td><font size="2"><?php print($ad_book_tbl[$key]["mail_address"]); ?></font></td>
    </tr>
<?php } ?>
</table>
<br>
<font size="2"><strong>・連絡先の追加</strong></font>
<table border="0" cellpadding="0" cellspacing="0">
    <form method="post" action="Information.php?do=config_exec&mode=address" style="margin-top:0; margin-bottom:0;">
    <tr>
        <td width="90"><font size="2">名前：</font></td>
        <td width="145"><input type="text" name="new_name" size="25"></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td><font size="2">メールアドレス：</font></td>
        <td><input type="text" name="new_mail_address" size="25"></td>
        <td>
        <input type="hidden" name="add_address" value="1">
        <input type="submit" value="追加">
        </td>
    </tr>
    </form>
</table>
<br>
<font size="2"><strong>・連絡先の削除</strong></font>
<table border="0" cellpadding="0" cellspacing="0">
    <form method="post" action="Information.php?do=config_exec&mode=address" style="margin-top:0; margin-bottom:0;">
    <tr>
        <td width="118"><font size="2">削除する連絡先NO：</font></td>
        <td width="35"><input type="text" name="del_address_id" size="3"></td>
        <td>
        <input type="hidden" name="del_address" value="1">
        <input type="submit" value="削除">
        </td>
    </tr>
    </form>
</table>
