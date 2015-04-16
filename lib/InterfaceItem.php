<?php
/**
 * InterfaceItem.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  商品クラスインターフェース
*/

interface InterfaceItem {

    // 入金状態種別
    const PAY_STATUS_PAY     = 1;  // '入金あり'
    const PAY_STATUS_NOT_PAY = 2;  // '入金なし'

    // 商品カテゴリーグループ
    const ITEM_CATEGORY_GROUP_CAMP    = 1;  // 'キャンペーン'
    const ITEM_CATEGORY_GROUP_POINT   = 2;  // 'ポイント'
    const ITEM_CATEGORY_GROUP_MONTHLY = 3;  // '月額'
}

?>