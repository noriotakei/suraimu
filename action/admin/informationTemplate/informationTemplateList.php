<?php
/*
*       情報定型文リスト
*       informationTemplateList.php
 *
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa hosoda
 */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

$AdmInfoTemplateOBJ = AdmInformationTemplate::getInstance();

// セッションオブジェクトのインスタンス
$messageSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$msg = $messageSessOBJ->getIterator();

// セッション変数の破棄
$messageSessOBJ->unsetAll();

$smartyOBJ->assign("msg", $msg);

$param = $requestOBJ->getParameterExcept($exceptArray);

$dispCnt = 20;

// 項目の取得
$returnValue = $returnSessOBJ->return;

// セッション変数の破棄
$returnSessOBJ->unsetAll();

// 戻ってきた場合
if ($returnValue) {
    $param = $returnValue;
}

$smartyOBJ->assign("param", $param);

// 情報定型文データリストの取得
$infoTemplateList = $AdmInfoTemplateOBJ->getInformationTemplateList();

$totalCount = $AdmInfoTemplateOBJ->getFoundRows();
$dispFirst = $offset + 1;
$dispLast = $offset + count($infoTemplateList);

$smartyOBJ->assign("infoTemplateList", $infoTemplateList);
$smartyOBJ->assign("totalCount", $totalCount);
$smartyOBJ->assign("dispFirst", $dispFirst);
$smartyOBJ->assign("dispLast", $dispLast);

$tags = array(
            "itid",
            );

$URLparam = $requestOBJ->makeGetTag($tags);

?>