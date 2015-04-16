<?php
/**
 * InterfaceInformation.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 情報表示場所の管理を行うクラスインターフェース。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa hosoda
 */
interface InterfaceInformation {

    // 情報表示場所
    const DISPLAY_POSITION_TOP                      = "1";  // 'ログイン後トップ'
    const DISPLAY_POSITION_POST_FREE_INFORMATION    = "2";  // 'ログイン後フリー情報'
    const DISPLAY_POSITION_PRE_FREE_INFORMATION     = "3";  // 'ログイン前フリー情報'
    const DISPLAY_POSITION_POST_TOP_CAMP            = "4";  // 'PC/MB共通ログイン後TOPキャンペーン'
    const DISPLAY_POSITION_ITEM_EXPLANATION         = "5";  // 'アイテムリストタイトル1'
    const DISPLAY_POSITION_ITEM_LIST                = "6";  // 'アイテムリスト1'
    const DISPLAY_POSITION_PC_PRE_SIDE_INFORMATION  = "12"; // 'PCログイン前サイド表示情報'
    const DISPLAY_POSITION_PC_POST_SIDE_INFORMATION = "13"; // 'PCログイン後サイド表示情報'
    const DISPLAY_POSITION_PC_PRE_TOP_CAMP          = "14"; // 'PCログイン前TOPキャンペーン'
    const DISPLAY_POSITION_INFORMATION_OPEN         = "15"; // '情報公開'
    const DISPLAY_POSITION_INFORMATION_LIST         = "16"; // '情報リストページ'
    const DISPLAY_POSITION_HOME_TOP_CAMP            = "17"; // 'PC/MB共通ログイン後HOMETOPキャンペーン

    // 入金状態種別
    const PAY_STATUS_PAY     = 1;  // '入金あり'
    const PAY_STATUS_NOT_PAY = 2;  // '入金なし'

    // 情報HTMLタイプ(対象カラム名)
    const INFORMAITON_HTML_TEXT_BANNER_PC = "html_text_banner_pc"; // '情報バナーPC'
    const INFORMAITON_HTML_TEXT_BANNER_MB = "html_text_banner_mb"; // '情報バナーMB'
    const INFORMAITON_HTML_TEXT_PC        = "html_text_pc";        // '情報詳細PC'
    const INFORMAITON_HTML_TEXT_MB        = "html_text_mb";        // '情報詳細MB'
}

?>