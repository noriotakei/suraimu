<?php
/**
 * dispKeyConvertList.php
 *
 * 表示用システム変換一覧
 *
 * @copyright 2009 fraise Corporation
 * @author    mitsuhiro_nakamura
 * */

require_once(D_BASE_DIR . "/common/admin_common.php");
require_once($controllerOBJ->getIncludeBusinessLogic("admInclude"));

// インスタンスの作成
$AdmKeyConvertOBJ = AdmKeyConvert::getInstance();

$param = $requestOBJ->getParameterExcept($exceptArray);
$smartyOBJ->assign("param", $param);

$keyConvertList = $AdmKeyConvertOBJ->getKeyConvertList($param);
while (list($key, $val) = each($keyConvertList)) {
    $keyConvertList[$key]["contents"] = $AdmKeyConvertOBJ->keyConvertContentsData($val["id"]);
}

$smartyOBJ->assign("keyConvertList", $keyConvertList);

$categoryList = $AdmKeyConvertOBJ->getKeyConvertCategoryForSelect();
$smartyOBJ->assign("categoryList", array("" => "気にしない") + (array)$categoryList);

$tags = array(
            "key_convert_list_category_id",
            );

$reloadParam = $requestOBJ->makePostTag($tags);

// 画面リロード用
$smartyOBJ->assign("reloadParam", $reloadParam);


?>