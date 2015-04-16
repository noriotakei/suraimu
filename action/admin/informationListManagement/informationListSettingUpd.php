<?php
/**
 * informationListSettingUpd.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
  * 管理画面 情報リスト設定更新ページ
 *
 * @copyright   2009 Fraise, Inc.
 * @author      norihisa hosoda
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

// セッションオブジェクトのインスタンス
$messageSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");
$param = $requestOBJ->getParameterExcept($exceptArray);

$msg = $messageSessOBJ->getIterator();
// セッション変数の破棄
$messageSessOBJ->unsetAll();
$smartyOBJ->assign("msg", $msg);

// 入力項目の取得
$returnValue = $returnSessOBJ->return;
// セッション変数の破棄
$returnSessOBJ->unsetAll();

// インスタンス生成
$AdmInfoListGroupOBJ    = AdmInformationListGroup::getInstance();
$AdmInfoSettingOBJ      = AdmInformationListSetting::getInstance();
$AdmInfoDispPositionOBJ = AdmInformationDisplayPosition::getInstance();

// 情報リストグループデータ取得
$infoGroupData = $AdmInfoListGroupOBJ->getInformationListGroupData($param["gid"]);

// 登録エラーで戻った場合
if ($returnValue["return_cd"] == "folder") {
    // 情報フォルダ追加/更新エラー
    $infoFolderParam = $returnValue;
    $infoFolderParam["return_flag"] = 1;
    $dispParam = $infoGroupData;
} else if ($returnValue["return_flag"]) {
    // 情報グループ登録/更新エラー
    $dispParam = $returnValue;
    $infoFolderParam["return_flag"] = 0;
} else {
    $dispParam = $infoGroupData;
    $infoFolderParam["return_flag"] = 0;
}

// アクセスURL
$accessUrl = "./?action_InformationList=1&gack=" . $dispParam["access_key"];
$smartyOBJ->assign("accessUrl", $accessUrl);

// 表示フラグ
$smartyOBJ->assign("isDisplay", AdmInformationDisplayPosition::$_isDisplay);

$smartyOBJ->assign("dispParam", $dispParam);
$smartyOBJ->assign("infoFolderParam", $infoFolderParam);

// 情報リストデータの取得
$infomationListSettingList = "";
$infomationListSettingList = $AdmInfoSettingOBJ->getInformationListSettingList($param, $offset, "", $dispCount);

$smartyOBJ->assign("infomationListSettingList", $infomationListSettingList);

// 情報フォルダリスト取得
$infoFolderList = $AdmInfoDispPositionOBJ->getInformationDisplayPositionForSelect();
$smartyOBJ->assign("infoFolderList", $infoFolderList);

$tags = array(
            "gid",
            );

$POSTparam = $requestOBJ->makePostTag($tags);
$reloadParam = $requestOBJ->makePostTag($tags);

$smartyOBJ->assign("POSTparam", $POSTparam);
// 画面リロード用
$smartyOBJ->assign("reloadParam", $reloadParam);

?>

