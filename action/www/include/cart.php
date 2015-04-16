<?php
/**
 * cart.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * ログイン後 最新のカート内表示処理ファイル。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      Norihisa Hosoda
 */

$param = $requestOBJ->getParameterExcept($exceptArray);

//var_dump($param);

// カート内の取得
// カートに商品IDを格納
$cartSessOBJ = new ComSessionNamespace("cart");
$ItemOBJ = Item::getInstance();
//var_dump($cartSessOBJ->itemId);



// カートから商品削除
if ($param["del"]) {
    // カートから削除対象商品IDの「キー」を抽出
    if ($param["iid"] AND $cartSessOBJ->itemId) {
        $delCartItemKey = array_search($param["iid"], $cartSessOBJ->itemId);
        // カートからキーを元に削除
        unset($cartSessOBJ->itemId[$delCartItemKey]);
    }
}

// カートに入れた商品リストの取得
if ($cartSessOBJ->itemId) {
    // 販売終了フラグ(デフォルトはFALSE)
    $salesEndFlg = FALSE;

    // カートの商品を取得
    $cartItemList = array();
    $itemSearchKey = array();
    foreach ($cartSessOBJ->itemId as $key => $val) {

        // 商品アクセスキー設定
        $itemSearchKey["access_key"] = $val;

        if ($data = $ItemOBJ->getItemData($comUserData, $itemSearchKey)) {
            // 購入可能な商品のみ格納
            $cartItemList[$key] = $data;
            $itemTotalMoney += $data["price"];
        } else {
            // カートからキーを元に削除
            unset($cartSessOBJ->itemId[$key]);
            // カートの商品が販売終了なのでフラグ変更
            $salesEndFlg = TRUE;
        }
    }

    // カートに販売終了の商品があればエラーメッセージ生成
    if ($salesEndFlg) {
        // エラーメッセージ作成
        $errMsgSessOBJ->errMsg[] = "販売終了とさせて頂きました商品をカートから削除しました｡";
    }

    //var_dump($cartItemList);

    // この時点でカートに商品が有れば表示
    if ($cartItemList) {
        // 表示配列を逆順にしてアサイン
        $smartyOBJ->assign("cartItemList", array_reverse($cartItemList));
    }
}
//var_dump($cartItemList);
// 現在のページを取得
$smartyOBJ->assign("accessPageName", ucwords($accessPageName));
//var_dump($accessPageName);


?>
