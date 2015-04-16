<?php
/**
 * registTestAddressUserDelExec.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面テストアドレスユーザー削除処理ページファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$AdmRegistTestAddressOBJ = AdmRegistTestAddress::getInstance();
$AdmUserOBJ = AdmUser::getInstance();
$ComUtilityOBJ = ComUtility::getInstance();

$messageSessOBJ = new ComSessionNamespace("exec_msg");
$returnSessOBJ = new ComSessionNamespace("return");

$param = $requestOBJ->getParameterExcept($exceptArray);

if ($param["disable"]) {

    $AdmUserOBJ->beginTransaction();

    $value["update_datetime"] = date("YmdHis");

    foreach ($param["disable"] as $key => $val) {

        $addressData = $AdmRegistTestAddressOBJ->getRegistTestAddressData($key);
        if($addressData["mail_address"]){
            $value["disable"] = $val;

            $whereArray = array(
                                    "(pc_address = '" . $addressData["mail_address"] . "' OR mb_address = '" . $addressData["mail_address"] . "')",
                                    "disable = 0"
                                );

            if (!$AdmUserReturnOBJ = $AdmUserOBJ->updateUserData($value , $whereArray)) {
                $messageSessOBJ->message = $AdmUserOBJ->getErrorMsg();
                $returnSessOBJ->return = $param;
                $AdmUserOBJ->rollbackTransaction();
                header("Location: ./?action_user_RegistTestAddressDelForm=1");
                exit();
            }
            $cnt += $AdmUserOBJ->getNumRows($AdmUserReturnOBJ);
        }
    }

    $AdmUserOBJ->commitTransaction();
    if ($cnt) {
        $messageSessOBJ->exec_msg = array($cnt . "件削除しました。");
    } else {
        $messageSessOBJ->exec_msg = array("データがありませんでした。");
    }

}

header("Location: ./?action_user_RegistTestAddressDelForm=1");
exit();
?>