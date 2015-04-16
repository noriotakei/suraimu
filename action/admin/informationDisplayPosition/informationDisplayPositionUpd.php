<?php
/**
 * informationDisplayPositionUpd.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
  * 管理画面表示場所フォルダ更新ページ
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

$AdmInfoDispPositionOBJ = AdmInformationDisplayPosition::getInstance();

$dispCategoryData = $AdmInfoDispPositionOBJ->getInformationCategoryData($param["fid"]);

// 登録エラーで戻った場合
if ($returnValue["return_cd"]  == "position") {
    $dispPositionParam = $returnValue;
    $dispPositionParam["return_flag"] = 1;
    $dispParam = $dispCategoryData;
} else if ($returnValue["return_flag"]) {
    $dispParam = $returnValue;
    $dispPositionParam["return_flag"] = 0;
} else {
    $dispParam = $dispCategoryData;
    $dispPositionParam["return_flag"] = 0;
}

// 表示場所名
$smartyOBJ->assign("displayPositionNameList", AdmInformationDisplayPosition::$_displayPositionName);
// 表示フラグ
$smartyOBJ->assign("isDisplay", AdmInformationDisplayPosition::$_isDisplay);

$smartyOBJ->assign("dispParam", $dispParam);
$smartyOBJ->assign("dispPositionParam", $dispPositionParam);

// 情報表示場所リスト取得
$dispPositionList = $AdmInfoDispPositionOBJ->getInformationdisplayPositionList($param, $offset, "", $dispCnt);
$smartyOBJ->assign("dispPositionList", $dispPositionList);

$tags = array(
            "fid",
            );

$POSTparam = $requestOBJ->makePostTag($tags);
$reloadParam = $requestOBJ->makePostTag($tags);

$smartyOBJ->assign("POSTparam", $POSTparam);
// 画面リロード用
$smartyOBJ->assign("reloadParam", $reloadParam);

?>

