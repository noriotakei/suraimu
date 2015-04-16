<?php
/**
 * InterfaceOrdering.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  注文管理クラスインターフェース
*/

interface InterfaceOrdering {

    // オーダ状況種別
    const ORDERING_STATUS_WAIT_BAS = 1;  // '入金待ち(銀振)',
    const ORDERING_STATUS_WAIT_BANK = 2;  // '入金待ち(入金おまかせサービス)',
    const ORDERING_STATUS_WAIT_CREDIT = 3;  // '入金待ち(クレジット)',
    const ORDERING_STATUS_WAIT_CVD = 4;  // '入金待ち(コンビニダイレクト)',
    const ORDERING_STATUS_WAIT_BITCASH = 5;  // '入金待ち(BITCASH)',
    const ORDERING_STATUS_ERR_BAS = 6;  // '入金エラー(銀振)',
    const ORDERING_STATUS_ERR_BANK = 7;  // '入金エラー(入金おまかせサービス)',
    const ORDERING_STATUS_ERR_CREDIT = 8;  // '入金エラー(クレジット)',
    const ORDERING_STATUS_ERR_CVD = 9;  // '入金エラー(コンビニダイレクト)',
    const ORDERING_STATUS_ERR_BITCASH = 10;  // '入金エラー(BITCASH)',
    const ORDERING_STATUS_PRE_COMPLETE = 11;  // '仮購入',
    const ORDERING_STATUS_COMPLETE = 12;  // '決済完了',
    const ORDERING_STATUS_REST = 13;  // '余り金決済完了',
    const ORDERING_STATUS_WAIT_TELECOM = 14;  // '入金待ち(テレコムクレジット)',
    const ORDERING_STATUS_ERR_TELECOM = 15;  // '入金エラー(テレコムクレジット)',
    const ORDERING_STATUS_WAIT_CCHECK = 16;  // '入金待ち(C-check)',
    const ORDERING_STATUS_ERR_CCHECK = 17;  // '入金エラー(C-check)',
    const ORDERING_STATUS_WAIT_DIGITALEDY = 18;  // '入金待ち(デジタルチェックEDY)',
    const ORDERING_STATUS_ERR_DIGITALEDY = 19;  // '入金エラー(デジタルチェックEDY)',
    const ORDERING_STATUS_WAIT_RAKUTEN = 20;  // '入金待ち(楽天銀行)',
    const ORDERING_STATUS_ERR_RAKUTEN = 21;  // '入金エラー(楽天銀行)',

    // 支払いタイプ種別
    const PAY_TYPE_BANK_AUTOMATIONBAS = 1;  // 銀振り(BAS)
    const PAY_TYPE_BANK_AUTOMATION = 2;  // 銀振り(入金おまかせサービス)
    const PAY_TYPE_CREDIT = 3;  // クレジット
    const PAY_TYPE_CVD = 4;  // コンビニダイレクト
    const PAY_TYPE_BITCASH = 5;  // BITCASH
    const PAY_TYPE_ADMIN = 6; // 管理手動入力
    const PAY_TYPE_TELECOM = 7;  // テレコムクレジット
    const PAY_TYPE_CCHECK = 8;  // C-check
    const PAY_TYPE_DIGITALEDY = 9; // デジタルチェックEDY
    const PAY_TYPE_BANK_RAKUTEN = 10; // 楽天銀行

    // 予約注文表示場所
    const ORDERING_DISPLAY_CD_PC_HOME = 1;  // PCログイン後トップ
    const ORDERING_DISPLAY_CD_PC_ITEMLIST = 2;  // PC商品リスト

}

?>