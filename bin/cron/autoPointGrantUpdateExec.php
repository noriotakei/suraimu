<?php
define("D_BASE_DIR", dirname(dirname(dirname(__FILE__))));
require_once(D_BASE_DIR . "/common/common.php");

$AdminUserOBJ = AdmUser::getInstance();
$AdminAutoOBJ = AdmAutoPointGrant::getInstance();
$AdmPointLogOBJ = AdmPointLog::getInstance();
$SendMailOBJ = SendMail::getInstance();

$param["dispDatetimeTo"] = date("Y-m-d H:i:s");
$param["is_exec"] = 0;

//get data from reserve_point_grant
$reservePointGrantData = $AdminAutoOBJ->getReservePointGrantData($param);

if (!$reservePointGrantData) {
    exit("No data");
}

foreach ($reservePointGrantData as $reservePoint) {

    try {
        $AdminAutoOBJ->beginTransaction();

        //conditions to update userProfile
        $whereArray = $AdminUserOBJ->setWhereString(unserialize($reservePoint["search_condition"]));
        $userProfileWhere = $whereArray;

        //data to update userProfile
        $setProfileParam["profile.point"] = "IF ((v_user_profile.point + (" . $reservePoint["point"] . ")) <= 0, 0, v_user_profile.point + (" . $reservePoint["point"] . "))";
        $setProfileParam["profile.total_addition_point"] = "IF ((v_user_profile.point + (" . $reservePoint["point"] . ")) > 0, v_user_profile.total_addition_point + (" . $reservePoint["point"] . "), IF ((v_user_profile.total_addition_point  -  v_user_profile.point) <= 0, 0, v_user_profile.total_addition_point  -  v_user_profile.point))";
        $setProfileParam["profile.update_datetime"] = "'" . date("YmdHis") . "'";

        //table to be updated
        $table = "profile join v_user_profile on profile.id = v_user_profile.profile_id";

        //updating data to profile table
        if (!$AdminUserOBJ->updateProfileData($setProfileParam, $userProfileWhere, $table, false)) {
            $errorMsg = $AdminUserOBJ->getErrorMsg();
            throw new Exception($errorMsg);
        }

        //conditions to update reservePointGrant
        $reservePointGrantWhere = array();
        $reservePointGrantWhere[] = "id ='" . $reservePoint["id"] . "'";

        //data to update reservePointGrant
        $setReservePointGrantParam["is_exec"] = 1;

        //updating data to reservePointGrant
        if (!$AdminAutoOBJ->updateReservePointGrantData($setReservePointGrantParam, $reservePointGrantWhere)) {
            $errorMsg = $AdminAutoOBJ->getErrorMsg();
            throw new Exception($errorMsg);
        }

        //insert point log data
        $columnArray = array();
        $columnArray[] = "IF (point = 0, " . $reservePoint["point"] . ", IF ((point + (" . $reservePoint["point"] . ")) <= 0, (0 -  point), " . $reservePoint["point"] . "))";
        $columnArray[] = "user_id";
        $columnArray[] = AdmPointLog::TYPE_GRANT;
        $columnArray[] = "NOW()";

        $listSql = $AdminUserOBJ->makeSelectQuery("v_user_profile", $columnArray, $whereArray);

        $insertColmunPointLog = array();
        $insertColmunPointLog[] = "point";
        $insertColmunPointLog[] = "user_id";
        $insertColmunPointLog[] = "type";
        $insertColmunPointLog[] = "create_datetime";

        if (!$AdmPointLogOBJ->insertSelectPointLogData($insertColmunPointLog, $listSql)) {

            $errorMsg = $AdmPointLogOBJ->getErrorMsg();
            throw new Exception($errorMsg);
        }

        $AdminAutoOBJ->commitTransaction();
    } catch (Exception $ex) {

        //send mail
        $debugMail = array();
        $debugMail["subject"] = "自動ポイントばらまき/回収エラー";
        $debugMail["text_body"][] = "file:" . __FILE__ ;
        $debugMail["text_body"][] = "line:" . __LINE__ ;
        $debugMail["text_body"][] = "reserve_point_grant_id:" . $reservePoint["id"];
        $debugMail["text_body"][] = "err:" . $ex->getMessage();
        $debugMail["text_body"] = implode("\n", $debugMail["text_body"]);

        // システムにエラーメール
        $SendMailOBJ->debugMailTo($debugMail);

        $AdminAutoOBJ->rollbackTransaction();

        var_dump($ex->getMessage());
    }
}

var_dump("Cron has been completed!!!");
exit();
