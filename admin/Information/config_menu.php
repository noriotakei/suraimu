<?php
/**
 * File Name:   config_memu.php
 *
 * Description: 設定項目表示PHPファイル。
 *              設定ツールから変更できる設定項目へのリンクを表示する。
 *
 * Author:      Shinichi Hata <hata@icodw.co.jp>
 * Created:     2006/02/06
 * Modified:    2006/03/20 by hata
 */
/**********************************************************************
 * HTML表示セクション
 **********************************************************************/
?>
<!-- 設定項目表示 -->
<strong>設定ツール</strong>
<hr>
<font size="2">
<a href="Information.php?do=config&mode=address">アドレス帳設定</a><br>
<a href="Information.php?do=config&mode=message">メッセージルール設定</a><br>
<a href="Information.php?do=config&mode=folder">フォルダ設定</a><br>
<a href="Information.php?do=config&mode=message_tmp">定型文設定</a><br>
<a href="Information.php?do=config&mode=signiture">署名設定</a><br>
<a href="Information.php?do=config&mode=delete">DB削除設定</a><br>
</font>
