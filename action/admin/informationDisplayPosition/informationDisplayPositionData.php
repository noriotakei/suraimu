<?php
/**
 * informationDisplayPositionData.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
  * 管理画面表示場所フォルダ一覧ページ
 *
 * @copyright   2010 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$param = $requestOBJ->getParameterExcept($exceptArray);
$smartyOBJ->assign("param", $param);

// 表示場所名
$smartyOBJ->assign("displayPositionNameList", AdmInformationDisplayPosition::$_displayPositionName);
// 表示フラグ
$smartyOBJ->assign("isDisplay", AdmInformationDisplayPosition::$_isDisplay);

$AdmInfoDispPositionOBJ = AdmInformationDisplayPosition::getInstance();

if ($param["sort"] == "mb") {
    $sort = "idp.mb_sort_seq DESC, idp.pc_sort_seq DESC";
} else {
    $sort = "idp.pc_sort_seq DESC, idp.mb_sort_seq DESC";
}

// 情報表示場所リスト取得
$dispFolderList = $AdmInfoDispPositionOBJ->getInformationdisplayPositionList($param, $offset, $sort, $dispCnt);
$smartyOBJ->assign("dispFolderList", $dispFolderList);

$tags = array(
            "position_id",
            );

$URLparam = $requestOBJ->makeGetTag($tags);
$POSTparam = $requestOBJ->makePostTag($tags);
$reloadParam = $requestOBJ->makePostTag($tags);

$smartyOBJ->assign("URLparam", $URLparam);
$smartyOBJ->assign("POSTparam", $POSTparam);
// 画面リロード用
$smartyOBJ->assign("reloadParam", $reloadParam);

?>

