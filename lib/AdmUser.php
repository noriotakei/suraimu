<?php
/**
 * AdmUser.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理側ユーザーデータの管理を行うクラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

class AdmUser extends ComCommon {

    /** @var object インスタンスを保持するstatic変数 */
    protected static $_instance = null;

    /** @var string エラーメッセージ */
    private $_errorMsg = null;

    /** @var string ユーザー検索sql文 */
    private $_listSql = null;

    /** 日付選択プルダウン配列 */
    private $datetimeParameter = array(
            "2" => "-2 hour",
            "3" => "-1 day",
            "4" => "-3 day",
            "5" => "-1 week",
            "6" => "-1 month",
            "8" => "-2 month",
            "9" => "-3 month",
            "10" => "-4 month",
            "11" => "-5 month",
            "12" => "-6 month",
            "13" => "-7 month",
            "14" => "-8 month",
            "15" => "-9 month",
        );


    /** 利用期限日プルダウン配列 */
    private $dateParameter = array(
            "2" => "-1 day",
            "3" => "-3 day",
            "4" => "-1 week",
            "5" => "-1 month",
        );

    /** @var string 検索条件内容 */
    private $_contents = null;

    /**
     * コンストラクタ。
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * getInstanceメソッド
     *
     * このクラスのオブジェクトを生成する。
     * 既に生成されていたら、前回と同じものを返す。
     *
     * @return object $instance
     */
    public static function getInstance() {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * ユーザーデータの取得
     *
     * @param  integer $id ユーザーID
     * @return array ユーザーデータ
     */
    public function getUserData($id) {

        if (!$id) {
            return false;
        }

        $columnArray[] = "*";
        $columnArray[] = "SUBSTRING(login_id,1,LOCATE('@',login_id)) as login_id_no_domain";

        $columnArray[] = "SUBSTRING(pc_address,1,LOCATE('@',pc_address)) as pc_address_no_domain";
        $columnArray[] = "SUBSTRING(mb_address,1,LOCATE('@',mb_address)) as mb_address_no_domain";

        $whereArray[] = "user_id = " . $id;
        $whereArray[] = "user_disable = 0";

        $sql = $this->makeSelectQuery("v_user_profile", $columnArray, $whereArray);

        // ユーザー情報の取得
        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;
    }

    /**
     * ユーザーデータリストの取得
     *
     * @param  array $param パラメーター
     * @param  integer $offset オフセット
     * @param  string $order 表示順
     * @param  integer $limit 表示件数
     * @return array ユーザーデータ
     */
    public function getUserList($param, $offset = null, $order = null, $limit = null) {

        if (!$param) {
            return false;
        }

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray = $this->setWhereString($param);

        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }
        if (ComValidation::isNumeric($offset)) {
            $otherArray[] = " LIMIT ". $offset . ", " . $limit;
        }

        $this->_listSql = $this->makeSelectQuery("v_user_profile", $columnArray, $whereArray, $otherArray);

if($_SERVER["REMOTE_ADDR"] == "219.111.2.137"){
    print $this->_listSql ;
}

        if (!$dbResultOBJ = $this->executeQuery($this->_listSql)) {
            return false;
        }

        // データリスト取得
        $dataList = $dbResultOBJ->fetchAll();

        return $dataList;
    }

    /**
     * ユーザーリスト取得
     *
     * @param  array $columnArray 列指定
     * @param  array $whereArray 条件指定
     * @param  array $otherArray その他指定
     *
     * @return array ユーザーデータ
     */
    public function getUserListByFreeSearch($columnArray, $whereArray, $otherArray = null) {

        $whereArray[] = "user_disable = 0";

        $sql = $this->makeSelectQuery("v_user_profile", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return false;
        }

        // データリスト取得
        $dataList = $dbResultOBJ->fetchAll();

        return $dataList;
    }



    /**
     * ユーザー情報の登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertUserData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("user", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * ユーザー情報の更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateUserData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("user", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * サイト固有ユーザー情報の登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertProfileData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("profile", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * サイト固有ユーザー情報の更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @param  string $table テーブル名
     * @param  int   $autoQuotes 自動クォーテーション付加フラグ
     *
     * @return boolean
     */
    public function updateProfileData($updateArray, $whereArray = null, $table = "profile", $autoQuotes = true) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update($table, $updateArray, $whereArray, $autoQuotes)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * エラーメッセージの取得
     *
     * @return $_errorMsg
     */
    public function getErrorMsg() {

        return $this->_errorMsg;
    }

    /**
     * ユーザー検索の条件文の作成
     *
     * @param  array $param データ配列
     * @return array 検索条件文配列
     */
    public function setWhereString($param) {

        $where[] = "v_user_profile.user_disable = 0";

        // ユーザーID
        if ($param["user_id"]) {
            if (!in_array("", explode(",", $param["user_id"]))) {
                // ユーザーIDを含む
                if ($param["user_id_specify_target_including"]) {
                    $where[] = "v_user_profile.user_id IN (" . $param["user_id"] . ")";
                    $this->_contents["ユーザーID"] = $param["user_id"] . "を含む";
                } else {
                    $where[] = "v_user_profile.user_id NOT IN (" . $param["user_id"] . ")";
                    $this->_contents["ユーザーID"] = $param["user_id"] . "を含まない";
                }
            }
        }

        // 性別
        if(ComValidation::isArray($param["sex_cd"])){
            $where[] = "v_user_profile.sex_cd IN (" . implode(",", $param["sex_cd"]) . ")";
            foreach ($param["sex_cd"] as $key => $val) {
                $sexName[] = $this->_configOBJ->admin_config->sex_cd->$val;
            }
            $this->_contents["性別"] = implode(", ", $sexName);
        }

        //生年月日
        switch ($param["specify_birth_day"]) {
            case 1 :
                $where[] = "v_user_profile.birth_date != '0000-00-00'";
                $this->_contents["生年月日"] = "有り" ;
                break;
            case 2 :
                $where[] = "v_user_profile.birth_date = '0000-00-00'";
                $this->_contents["生年月日"] = "無し" ;
                break;
            case 3 :

                $birthDayDatetimeFrom = $param["birth_day_from_Date"]
                                        . " " ."00:00:00";
                $birthDayDatetimeTo = $param["birth_day_to_Date"]
                                        . " " ."00:00:00";

                if (ComValidation::isDatetime($birthDayDatetimeFrom)) {
                    $birthDayDatetime["from"] = $birthDayDatetimeFrom;
                }
                if (ComValidation::isDatetime($birthDayDatetimeTo)) {
                    $birthDayDatetime["to"] = $birthDayDatetimeTo;
                }
                if ($birthDayDatetime) {
                    $where[] = "v_user_profile.birth_date >='".date("Ymd", strtotime($birthDayDatetimeFrom ))."' AND "
                                   ."v_user_profile.birth_date <='".date("Ymd", strtotime($birthDayDatetimeTo )) ."'";

                    $this->_contents["生年月日"] = $birthDayDatetimeFrom . " ～ " . $birthDayDatetimeTo ;
                }
                break;
            case 4 :
                $where[] = "v_user_profile.birth_date != '0000-00-00'";
                $where[] = "MONTH(v_user_profile.birth_date) = ".date("m");
                $where[] = "DAY(v_user_profile.birth_date) = ".date("d");
                $this->_contents["生年月日"] = "本日" ;
                break;
            default :
                break;
        }

        //年齢
        if($param["user_age_from"] OR $param["user_age_to"]){

            $searchAgeSqAry = array();
            $searchAgeSql = "" ;

            // 年齢 ～以上
            if($param["user_age_from"]){
                $fromAgeParam = "-".$param["user_age_from"]." YEAR" ;
                $fromBirthday = date("Y-m-d",strtotime($fromAgeParam)) ;

                $searchAgeSqAry[] = "v_user_profile.birth_date <='". $fromBirthday."'" ;

                if(!$param["user_age_to"] AND !$param["user_age_no_data"]){
                    $where[] = "v_user_profile.birth_date !='0000-00-00'" ;
                }

                $this->_contents["年齢"] .= "『" . $param["user_age_from"] . "』歳以上<br>";
            }

            // 年齢 ～未満
            if($param["user_age_to"]){
                $toAge = $param["user_age_to"]+1 ;
                $toAgeParam = "-".$toAge." YEAR  +1 DAY" ;
                $toBirthday = date("Y-m-d",strtotime($toAgeParam)) ;

                $searchAgeSqAry[] = "v_user_profile.birth_date >='". $toBirthday."'" ;

                $this->_contents["年齢"] .= "『" . $param["user_age_to"] . "』歳以下<br>";
            }

            $searchAgeSql = "(".implode(" AND ",$searchAgeSqAry).")" ;

            if($param["user_age_no_data"]){
                $where[] = "(".$searchAgeSql."OR v_user_profile.birth_date ='0000-00-00' )" ;
                $this->_contents["年齢"] .= "未入力を含む<br>";
            } else {
                $where[] = $searchAgeSql ;
                $this->_contents["年齢"] .= "未入力を含まない<br>";
            }

        }

       // 干支
        if($param["sexagenary_cycle"]){

            $sexagenaryCycleBaseAry = array(
                   1=>1900
                   ,2=>1901
                   ,3=>1902
                   ,4=>1903
                   ,5=>1904
                   ,6=>1905
                   ,7=>1906
                   ,8=>1907
                   ,9=>1908
                   ,10=>1909
                   ,11=>1910
                   ,12=>1911
            ) ;

            foreach($param["sexagenary_cycle"] as $key => $val ){
                $sexagenaryCycleBase = $sexagenaryCycleBaseAry[$val] ;

                $sexagenaryCycleNameAry[] = $this->_configOBJ->admin_config->specify_sexagenary_cycle_select->$val;

                for($i = 12; $i <= 120;) {

                    $sexagenaryCycleAge = $sexagenaryCycleBase+$i ;

                    $sexagenaryCycleWhereAry[] = "v_user_profile.birth_date like '".$sexagenaryCycleAge."%'" ;

                    $i = $i+12 ;
                }
            }
            $sexagenaryCycleWhere = implode(" OR ",$sexagenaryCycleWhereAry) ;
            $sexagenaryCycleNameString = implode(" , ",$sexagenaryCycleNameAry) ;

            $where[] = "(".$sexagenaryCycleWhere.")" ;

            $this->_contents["干支"] .= "『" . $sexagenaryCycleNameString . "』<br>";
        }

       // 星座
        if($param["constellation"]){

            $constellationTermAry = array(
                   1=>array("term_start"=>"01-21","term_end"=>"02-18")
                   ,2=>array("term_start"=>"02-19","term_end"=>"03-20")
                   ,3=>array("term_start"=>"03-21","term_end"=>"04-19")
                   ,4=>array("term_start"=>"04-20","term_end"=>"05-20")
                   ,5=>array("term_start"=>"05-21","term_end"=>"06-21")
                   ,6=>array("term_start"=>"06-22","term_end"=>"07-22")
                   ,7=>array("term_start"=>"07-23","term_end"=>"08-22")
                   ,8=>array("term_start"=>"08-23","term_end"=>"09-22")
                   ,9=>array("term_start"=>"09-23","term_end"=>"10-20")
                   ,10=>array("term_start"=>"10-21","term_end"=>"11-22")
                   ,11=>array("term_start"=>"11-23","term_end"=>"12-21")
                   ,12=>array("term_start"=>"12-22","term_end"=>"01-20")
            ) ;

            foreach($param["constellation"] as $key => $val ){
                $constellationTerm = $constellationTermAry[$val] ;
                $constellationNameAry[] = $this->_configOBJ->admin_config->specify_constellation_select->$val;
                $constellationWhereAry[] = "(DATE_FORMAT(v_user_profile.birth_date,'%m-%d') >= '".$constellationTermAry[$val]["term_start"]."' AND DATE_FORMAT(v_user_profile.birth_date,'%m-%d') <= '".$constellationTermAry[$val]["term_end"]."')" ;
            }
            $constellationWhere = implode(" OR ",$constellationWhereAry) ;
            $constellationNameString = implode(" , ",$constellationNameAry) ;

            $where[] = "(".$constellationWhere.")" ;

            $this->_contents["星座"] .= "『" . $constellationNameString . "』<br>";
        }
/*
        //注文検索
        if($param["ordering_item_id"] AND count($param["is_cancel"])){
            $where[] = "EXISTS ("
                    ." SELECT 'x' FROM ordering,ordering_detail"
                    ." WHERE is_paid = 0 AND v_user_profile.user_id = ordering.user_id"
                    ." AND ordering_detail.ordering_id = ordering.id AND ordering_detail.is_cancel IN (" . implode(",", $param["is_cancel"]) . ")"
                    ." AND ordering_detail.disable = 0 AND ordering.disable = 0"
                    ." AND ordering_detail.item_id =".$param["ordering_item_id"].")";


            foreach($param["is_cancel"] as $key => $val){
                $cancelStatusString .= "  ".AdmOrdering::$_cancelFlag[$val] ;
            }
            $this->_contents["注文検索"] .= "『商品ID" . $param["ordering_item_id"] .$cancelStatusString. "』<br>";
        }
*/

        //指定注文（商品ID）対象を抽出
        if($param["ordering_item_id"] AND count($param["is_cancel"])){
            $orderingItemIdArray =  explode(",", $param["ordering_item_id"]);

            if (!in_array("", $orderingItemIdArray)) {
                // すべての商品IDに含まれる
                if($param["ordering_item_specify_target_select"]){
                    foreach($orderingItemIdArray as $val){
                        $where[] = "EXISTS ("
                                ." SELECT 'x' FROM ordering,ordering_detail"
                                        ." WHERE is_paid = 0 AND v_user_profile.user_id = ordering.user_id"
                                                ." AND ordering_detail.ordering_id = ordering.id AND ordering_detail.is_cancel IN (" . implode(",", $param["is_cancel"]) . ")"
                                                        ." AND ordering_detail.disable = 0 AND ordering.disable = 0"
                                                                ." AND ordering_detail.item_id =".$val.")";
                    }

                    $orderingItemSpecifyTargetSelectString = "  すべてに含まれる" ;
                } else {
                    $orderingItemIdString= "" ;
                    foreach($orderingItemIdArray as $val){
                        $orderingItemIdString[] = "EXISTS ("
                                ." SELECT 'x' FROM ordering,ordering_detail"
                                        ." WHERE is_paid = 0 AND v_user_profile.user_id = ordering.user_id"
                                                ." AND ordering_detail.ordering_id = ordering.id AND ordering_detail.is_cancel IN (" . implode(",", $param["is_cancel"]) . ")"
                                                        ." AND ordering_detail.disable = 0 AND ordering.disable = 0"
                                                                ." AND ordering_detail.item_id =".$val.")";
                    }
                    $where[] = "(" . implode(" OR ", $orderingItemIdString) . ")";

                    $orderingItemSpecifyTargetSelectString = "  いずれかに含まれる" ;
                }
            }

            foreach($param["is_cancel"] as $key => $val){
                $cancelStatusString .= "  ".AdmOrdering::$_cancelFlag[$val] ;
            }
            $this->_contents["注文検索"] .= "『商品ID" . $param["ordering_item_id"] .$cancelStatusString.$orderingItemSpecifyTargetSelectString. "』<br>";
        }


        //指定注文（商品ID）以外を抽出
        if($param["except_ordering_item_id"] AND count($param["is_cancel"])){
            $orderingItemIdArray =  explode(",", $param["except_ordering_item_id"]);
            if (!in_array("", $orderingItemIdArray)) {
                // すべての商品IDに含まれない
                if($param["except_ordering_item_specify_target_select"]){
                    $expectOrderingItemIdString = "" ;
                    foreach($orderingItemIdArray as $val){
                        $expectOrderingItemIdString[] = "EXISTS ("
                                ." SELECT 'x' FROM ordering,ordering_detail"
                                        ." WHERE is_paid = 0 AND v_user_profile.user_id = ordering.user_id"
                                                ." AND ordering_detail.ordering_id = ordering.id AND ordering_detail.is_cancel IN (" . implode(",", $param["is_cancel"]) . ")"
                                                        ." AND ordering_detail.disable = 0 AND ordering.disable = 0"
                                                                ." AND ordering_detail.item_id =".$val.")";
                    }
                    $where[] = "NOT (" . implode(" AND ", $expectOrderingItemIdString) . ")";

                    $expectOrderingItemSpecifyTargetSelectString = "  すべてに含まれる以外" ;
                } else {
                    $orderingItemIdString= "" ;
                    foreach($orderingItemIdArray as $val){
                        $where[] = "NOT EXISTS ("
                                ." SELECT 'x' FROM ordering,ordering_detail"
                                        ." WHERE is_paid = 0 AND v_user_profile.user_id = ordering.user_id"
                                                ." AND ordering_detail.ordering_id = ordering.id AND ordering_detail.is_cancel IN (" . implode(",", $param["is_cancel"]) . ")"
                                                        ." AND ordering_detail.disable = 0 AND ordering.disable = 0"
                                                                ." AND ordering_detail.item_id =".$val.")";
                    }
                    $expectOrderingItemSpecifyTargetSelectString = "  いずれかに含まれる以外" ;
                }
            }

            foreach($param["is_cancel"] as $key => $val){
                $cancelStatusString .= "  ".AdmOrdering::$_cancelFlag[$val] ;
            }
            $this->_contents["注文検索"] .= "『商品ID" . $param["except_ordering_item_id"] .$cancelStatusString.$expectOrderingItemSpecifyTargetSelectString. "』<br>";
        }

        //ﾕｰｻﾞｰﾌﾟﾗｲﾊﾞｼｰ
        if($param["address_detail"] OR $param["bank_detail"]){

            $userPrivacyComment = "あり " ;

            if(!$param["specify_userPrivacy"]){
                $notSqlUserPrivacy = "NOT" ;
                $userPrivacyComment = "なし " ;
            }

            if($param["address_detail"]){
                $addressDetailSqlArray = array(1=>" AND address != '' "
                                                      ,2=>" AND name != '' "
                                                      ,3=>" AND phone_number != '' "
                ) ;
                $addressDetailCommentArray = array(1=>"住所"
                                                      ,2=>"名前"
                                                      ,3=>"電話番号"
                ) ;

                foreach($param["address_detail"] as $val){
                    $addAdressDetailSql .= $addressDetailSqlArray[$val] ;
                    $userPrivacyComment .= " ".$addressDetailCommentArray[$val] ;
                }
                $where[] = $notSqlUserPrivacy." EXISTS ("
                        ." SELECT 'x' FROM address_detail"
                        ." WHERE v_user_profile.user_id = address_detail.user_id"
                        .$addAdressDetailSql.")";

            }

            if($param["bank_detail"]){
                $bankDetailSqlArray = array(1=>" AND bank_name != '' "
                                                      ,2=>" AND branch_name != '' "
                                                      ,3=>" AND type != '' "
                                                      ,4=>" AND account_number != '' "
                                                      ,5=>" AND name != '' "
                ) ;
                $bankDetailCommentArray = array(1=>"銀行名"
                                                      ,2=>"支店名"
                                                      ,3=>"種別"
                                                      ,4=>"口座番号"
                                                      ,5=>"名義人"
                ) ;

                foreach($param["bank_detail"] as $val){
                    $addBankDetailSql .= $bankDetailSqlArray[$val] ;
                    $userPrivacyComment .= " ".$bankDetailCommentArray[$val] ;
                }
                $where[] = $notSqlUserPrivacy." EXISTS ("
                        ." SELECT 'x' FROM bank_detail"
                        ." WHERE v_user_profile.user_id = bank_detail.user_id"
                        .$addBankDetailSql.")";

            }

            $this->_contents["ﾕｰｻﾞｰﾌﾟﾗｲﾊﾞｼｰ"] .= "『".$userPrivacyComment. "』<br>";

        }

        //血液型
        if($param["blood_type"]){
            foreach($param["blood_type"] as $val){
                $bloodTypeNameString .= $this->_configOBJ->admin_config->blood_type->$val."  ";
            }
            $bloodTypeString = implode(",",$param["blood_type"]) ;
            $where[] = "v_user_profile.blood_type in (".$bloodTypeString.")" ;
            $this->_contents["血液型"] .= "『" . $bloodTypeNameString . "』<br>";
        }

        // 電話番号
        if (ComValidation::isNumeric($param["specify_phone_number"])) {
            switch ($param["specify_phone_number"]) {
                case 1 : //前方一致
                    $where[] = " EXISTS ("
                            ." SELECT ad_dt.user_id FROM address_detail ad_dt"
                            ." WHERE ad_dt.disable = 0"
                            ." AND ad_dt.user_id = v_user_profile.user_id"
                            ." AND (ad_dt.phone_number LIKE '".$param["phone_number"]."%' OR ad_dt.phone_number2 LIKE '".$param["phone_number"]."%' OR ad_dt.phone_number3 LIKE '".$param["phone_number"]."%')"
                            .")";
                    $this->_contents["電話番号"] = "前方一致 " . $param["pc_address"];
                    break;
                case 2 : //後方一致
                    $where[] = " EXISTS ("
                            ." SELECT ad_dt.user_id FROM address_detail ad_dt"
                            ." WHERE ad_dt.disable = 0"
                            ." AND ad_dt.user_id = v_user_profile.user_id"
                            ." AND (ad_dt.phone_number LIKE '%".$param["phone_number"]."' OR ad_dt.phone_number2 LIKE '%".$param["phone_number"]."' OR ad_dt.phone_number3 LIKE '%".$param["phone_number"]."')"
                            .")";
                    $this->_contents["電話番号"] = "後方一致 " . $param["pc_address"];
                    break;
                case 3 : //完全一致
                    $where[] = " EXISTS ("
                            ." SELECT ad_dt.user_id FROM address_detail ad_dt"
                            ." WHERE ad_dt.disable = 0"
                            ." AND ad_dt.user_id = v_user_profile.user_id"
                            ." AND (ad_dt.phone_number = '".$param["phone_number"]."' OR ad_dt.phone_number2 = '".$param["phone_number"]."' OR ad_dt.phone_number3 = '".$param["phone_number"]."')"
                            .")";
                    $this->_contents["電話番号"] = "完全一致 " . $param["pc_address"];
                    break;
                case 4 : //あり
                    $where[] = " EXISTS ("
                            ." SELECT ad_dt.user_id FROM address_detail ad_dt"
                            ." WHERE ad_dt.disable = 0"
                            ." AND ad_dt.user_id = v_user_profile.user_id"
                            ." AND (ad_dt.phone_number != '' OR ad_dt.phone_number2 !='' OR ad_dt.phone_number3 !='') "
                            .")";
                    $this->_contents["電話番号"] = "あり";
                    break;
                case 0 : //なし
                    $where[] = " NOT EXISTS ("
                            ." SELECT ad_dt.user_id FROM address_detail ad_dt"
                            ." WHERE ad_dt.disable = 0"
                            ." AND ad_dt.user_id = v_user_profile.user_id"
                            ." AND (ad_dt.phone_number != '' OR ad_dt.phone_number2 !='' OR ad_dt.phone_number3 !='') "
                            .")";
                    $this->_contents["電話番号"] = "なし";
                    break;
                default :
                    break;
            }
        }
        // 電話受信
        if (ComValidation::isNumeric($param["phone_is_use"])) {

            switch ($param["phone_is_use"]) {
                case 0 : //電話受信なし
                    $where[] = " NOT EXISTS ("
                            ." SELECT ad_dt.user_id FROM address_detail ad_dt"
                            ." WHERE ad_dt.disable = 0"
                            ." AND ad_dt.user_id = v_user_profile.user_id"
                            ." AND phone_is_use =1 "
                            .")";
                    $this->_contents["電話受信"] = "なし";
                    break;
                case 1 : //電話受信あり
                    $where[] = " EXISTS ("
                            ." SELECT ad_dt.user_id FROM address_detail ad_dt"
                            ." WHERE ad_dt.disable = 0"
                            ." AND ad_dt.user_id = v_user_profile.user_id"
                            ." AND phone_is_use =1 "
                            .")";
                    $this->_contents["電話受信"] = "あり";
                    break;
                default :
                    break;
            }
        }

        // PC配信ドメイン
        if (ComValidation::isArray($param["pc_send_domain_type"])) {
            $where[] = "v_user_profile.pc_mailmagazine_from_domain_id IN (" . implode(",", $param["pc_send_domain_type"]) . ")";
            foreach ($param["pc_send_domain_type"] as $val) {
                $isMbReverseStatus[] = $this->_configOBJ->define->SEND_MAIL_DOMAIN->$val;
            }
            $this->_contents["PC配信ドメイン"] = implode(", ", $isMbReverseStatus);
        }

        // MB配信ドメイン
        if (ComValidation::isArray($param["mb_send_domain_type"])) {
            $where[] = "v_user_profile.mb_mailmagazine_from_domain_id IN (" . implode(",", $param["mb_send_domain_type"]) . ")";
            foreach ($param["mb_send_domain_type"] as $val) {
                $isMbReverseStatus[] = $this->_configOBJ->define->SEND_MAIL_DOMAIN->$val;
            }
            $this->_contents["MB配信ドメイン"] = implode(", ", $isMbReverseStatus);
        }

        // ログインID
        if ($param["login_id"]) {
            $where[] = "v_user_profile.login_id LIKE '" . $param["login_id"] . "%'";
            $this->_contents["ログインID(前方一致)"] = $param["login_id"];
        }

        // 個体識別番号
        if ($param["mb_serial_number"]) {
            $where[] = "v_user_profile.mb_serial_number LIKE '" . $param["mb_serial_number"] . "%'";
            $this->_contents["個体識別番号(前方一致)"] = $param["mb_serial_number"];
        }

        if ($param["pc_ip_address"]) {
            $where[] = "v_user_profile.pc_ip_address LIKE '" . $param["pc_ip_address"] . "%'";
            $this->_contents["PC IPｱﾄﾞﾚｽ(前方一致)"] = $param["pc_ip_address"];
        }

        // PCメールアドレス
        if (ComValidation::isNumeric($param["pc_specify_address"])) {
            switch ($param["pc_specify_address"]) {
                case 1 : //前方一致
                    $where[] = "v_user_profile.pc_address LIKE '" . $param["pc_address"] . "%'";
                    $this->_contents["PCメールアドレス"] = "前方一致 " . $param["pc_address"];
                    break;
                case 2 : //後方一致
                    $where[] = "v_user_profile.pc_address LIKE '%" . $param["pc_address"] . "'";
                    $this->_contents["PCメールアドレス"] = "後方一致 " . $param["pc_address"];
                    break;
                case 3 : //完全一致
                    $where[] = "v_user_profile.pc_address = '" . $param["pc_address"] . "'";
                    $this->_contents["PCメールアドレス"] = "完全一致 " . $param["pc_address"];
                    break;
                case 4 : //あり
                    $where[] = "v_user_profile.pc_address != ''";
                    $this->_contents["PCメールアドレス"] = "あり";
                    break;
                case 0 : //なし
                    $where[] = "v_user_profile.pc_address = ''";
                    $this->_contents["PCメールアドレス"] = "なし";
                    break;
                default :
                    break;
            }
        }

        if (ComValidation::isNumeric($param["mb_specify_address"])) {
            // MBメールアドレス
            switch ($param["mb_specify_address"]) {
                case 1 : //前方一致
                    $where[] = "v_user_profile.mb_address LIKE '" . $param["mb_address"] . "%'";
                    $this->_contents["MBメールアドレス"] = "前方一致 " . $param["mb_address"];
                    break;
                case 2 : //後方一致
                    $where[] = "v_user_profile.mb_address LIKE '%" . $param["mb_address"] . "'";
                    $this->_contents["MBメールアドレス"] = "後方一致 " . $param["mb_address"];
                    break;
                case 3 : //完全一致
                    $where[] = "v_user_profile.mb_address = '" . $param["mb_address"] . "'";
                    $this->_contents["MBメールアドレス"] = "完全一致 " . $param["mb_address"];
                    break;
                case 4 : //あり
                    $where[] = "v_user_profile.mb_address != ''";
                    $this->_contents["MBメールアドレス"] = "あり";
                    break;
                case 0 : //なし
                    $where[] = "v_user_profile.mb_address = ''";
                    $this->_contents["MBメールアドレス"] = "なし";
                    break;
                default :
                    break;
            }
        }
        // PCデバイス
        if (ComValidation::isArray($param["pc_device_cd"])) {
            $where[] = "v_user_profile.pc_device_cd IN (" . implode(",", $param["pc_device_cd"]) . ")";
            foreach ($param["pc_device_cd"] as $val) {
                $pcDevice[] = $this->_configOBJ->admin_config->pc_device->$val;
            }
            $this->_contents["PCデバイス"] = implode(", ", $pcDevice);
        }

        // MBデバイス
        if (ComValidation::isArray($param["mb_device_cd"])) {
            $where[] = "v_user_profile.mb_device_cd IN (" . implode(",", $param["mb_device_cd"]) . ")";
            foreach ($param["mb_device_cd"] as $val) {
                $mbDevice[] = $this->_configOBJ->admin_config->mb_device->$val;
            }
            $this->_contents["MBデバイス"] = implode(", ", $mbDevice);
        }

        // ユーザーステータス
        if (ComValidation::isArray($param["regist_status"])) {
            $where[] = "v_user_profile.regist_status IN (" . implode(",", $param["regist_status"]) . ")";
            foreach ($param["regist_status"] as $val) {
                $registStatus[] = $this->_configOBJ->admin_config->regist_status->$val;
            }
            $this->_contents["ユーザーステータス"] = implode(", ", $registStatus);
        }

        // PCｱﾄﾞﾚｽｽﾃ-ﾀｽ
        if (ComValidation::isArray($param["pc_address_status"])) {
            $where[] = "v_user_profile.pc_address_status IN (" . implode(",", $param["pc_address_status"]) . ")";
            foreach ($param["pc_address_status"] as $val) {
                $pcAddressStatus[] = $this->_configOBJ->admin_config->address_status->$val;
            }
            $this->_contents["PCｱﾄﾞﾚｽｽﾃ-ﾀｽ"] = implode(", ", $pcAddressStatus);
        }

        // PC送信ｽﾃ-ﾀｽ
        if (ComValidation::isArray($param["pc_send_status"])) {
            $where[] = "v_user_profile.pc_send_status IN (" . implode(",", $param["pc_send_status"]) . ")";
            foreach ($param["pc_send_status"] as $val) {
                $pcSendStatus[] = $this->_configOBJ->admin_config->address_send_status->$val;
            }
            $this->_contents["PC送信ｽﾃ-ﾀｽ"] = implode(", ", $pcSendStatus);
        }

        // PCﾒｰﾙ受信設定
        if (ComValidation::isArray($param["pc_is_mailmagazine"])) {
            $where[] = "v_user_profile.pc_is_mailmagazine IN (" . implode(",", $param["pc_is_mailmagazine"]) . ")";
            foreach ($param["pc_is_mailmagazine"] as $val) {
                $pcIsMailmagazine[] = $this->_configOBJ->common_config->is_mailmagazine->$val;
            }
            $this->_contents["PCﾒｰﾙ受信設定"] = implode(", ", $pcIsMailmagazine);
        }

        // MBｱﾄﾞﾚｽｽﾃ-ﾀｽ
        if (ComValidation::isArray($param["mb_address_status"])) {
            $where[] = "v_user_profile.mb_address_status IN (" . implode(",", $param["mb_address_status"]) . ")";
            foreach ($param["mb_address_status"] as $val) {
                $mbAddressStatus[] = $this->_configOBJ->admin_config->address_status->$val;
            }
            $this->_contents["MBｱﾄﾞﾚｽｽﾃ-ﾀｽ"] = implode(", ", $mbAddressStatus);
        }

        // MB送信ｽﾃ-ﾀｽ
        if (ComValidation::isArray($param["mb_send_status"])) {
            $where[] = "v_user_profile.mb_send_status IN (" . implode(",", $param["mb_send_status"]) . ")";
            foreach ($param["mb_send_status"] as $val) {
                $mbSendStatus[] = $this->_configOBJ->admin_config->address_send_status->$val;
            }
            $this->_contents["MB送信ｽﾃ-ﾀｽ"] = implode(", ", $mbSendStatus);
        }

        // MBﾒｰﾙ受信設定
        if (ComValidation::isArray($param["mb_is_mailmagazine"])) {
            $where[] = "v_user_profile.mb_is_mailmagazine IN (" . implode(",", $param["mb_is_mailmagazine"]) . ")";
            foreach ($param["mb_is_mailmagazine"] as $val) {
                $mbIsMailmagazine[] = $this->_configOBJ->common_config->is_mailmagazine->$val;
            }
            $this->_contents["MBﾒｰﾙ受信設定"] = implode(", ", $mbIsMailmagazine);
        }

        // OR検索用ｱﾄﾞﾚｽｽﾃ-ﾀｽ
        if (ComValidation::isArray($param["is_address_status_or"])) {
            $where[] = "((v_user_profile.pc_address != '' AND v_user_profile.pc_address_status = " . $this->_configOBJ->define->ADDRESS_STATUS_DO . ") OR (v_user_profile.mb_address != '' AND v_user_profile.mb_address_status = " . $this->_configOBJ->define->ADDRESS_STATUS_DO . "))";
            foreach ($param["is_address_status_or"] as $val) {
                $isAddressStatusOr[] = $this->_configOBJ->admin_config->is_address_send_status_or->$val;
            }
            $this->_contents["ｱﾄﾞﾚｽｽﾃ-ﾀｽ"] = implode(", ", $isAddressStatusOr);
        }

        // OR検索用送信ｽﾃ-ﾀｽ
        if (ComValidation::isArray($param["is_address_send_status_or"])) {
            $where[] = "((v_user_profile.pc_address != '' AND v_user_profile.pc_send_status = " . $this->_configOBJ->define->ADDRESS_SEND_STATUS_DO . ") OR (v_user_profile.mb_address != '' AND v_user_profile.mb_send_status = " . $this->_configOBJ->define->ADDRESS_SEND_STATUS_DO . "))";
            foreach ($param["is_address_send_status_or"] as $val) {
                $isAddressSendStatusOr[] = $this->_configOBJ->admin_config->is_address_send_status_or->$val;
            }
            $this->_contents["ﾒｰﾙ送信ｽﾃｲﾀｽ"] = implode(", ", $isAddressSendStatusOr);
        }

        // OR検索用ﾒｰﾙ受信設定
        if (ComValidation::isArray($param["is_mailmagazine_or"])) {
            $where[] = "((v_user_profile.pc_address != '' AND v_user_profile.pc_is_mailmagazine = " . $this->_configOBJ->define->ADDRESS_SEND_STATUS_DO . ") OR (v_user_profile.mb_address != '' AND v_user_profile.mb_is_mailmagazine = " . $this->_configOBJ->define->ADDRESS_SEND_STATUS_DO . "))";
            foreach ($param["is_mailmagazine_or"] as $val) {
                $isMailmagazineOr[] = $this->_configOBJ->admin_config->is_mailmagazine_or->$val;
            }
            $this->_contents["ﾒｰﾙ受信設定"] = implode(", ", $isMailmagazineOr);
        }

        // PCメール強行
        if (ComValidation::isArray($param["is_pc_reverse"])) {
            $where[] = "v_user_profile.is_pc_reverse IN (" . implode(",", $param["is_pc_reverse"]) . ")";
            foreach ($param["is_pc_reverse"] as $val) {
                $isPcReverseStatus[] = $this->_configOBJ->admin_config->reverse_status->$val;
            }
            $this->_contents["PC強行フラグ"] = implode(", ", $isPcReverseStatus);
        }

        // MBメール強行
        if (ComValidation::isArray($param["is_mb_reverse"])) {
            $where[] = "v_user_profile.is_mb_reverse IN (" . implode(",", $param["is_mb_reverse"]) . ")";
            foreach ($param["is_mb_reverse"] as $val) {
                $isMbReverseStatus[] = $this->_configOBJ->admin_config->reverse_status->$val;
            }
            $this->_contents["MB強行フラグ"] = implode(", ", $isMbReverseStatus);
        }

        // ブラック
        if (ComValidation::isArray($param["danger_status"])) {
            $where[] = "v_user_profile.danger_status IN (" . implode(",", $param["danger_status"]) . ")";
            foreach ($param["danger_status"] as $val) {
                $dangerStatus[] = $this->_configOBJ->admin_config->danger_status->$val;
            }
            $this->_contents["危険人物フラグ"] = implode(", ", $dangerStatus);
        }

        // ｽﾏｰﾄﾌｫﾝOS
        if (ComValidation::isArray($param["smart_phone_os"])) {

            $smartPhoneUserAgentAry = ComUserAgentSmartPhone::$_smartPhoneUserAgent ;

            foreach($param["smart_phone_os"] as $val){
                if($val == $this->_configOBJ->define->SMART_PHONE_OTHER){
                    //Phone,Android以外
                    unset($smartPhoneUserAgentAry[0],$smartPhoneUserAgentAry[2]);
                    $whereSmartPhone[] = "v_user_profile.mb_user_agent REGEXP '" . implode("|", $smartPhoneUserAgentAry) . "'";
                } else {
                    $whereSmartPhone[] = "v_user_profile.mb_user_agent REGEXP '".$this->_configOBJ->admin_config->smart_phone_os->$val."'";
                }
            }

            $where[] = "(" . implode(" OR ", $whereSmartPhone) . ")";

            foreach ($param["smart_phone_os"] as $val) {
                $smartPhoneOsType[] = $this->_configOBJ->admin_config->smart_phone_os->$val;
            }
            $this->_contents["ｽﾏｰﾄﾌｫﾝOS"] = implode(", ", $smartPhoneOsType);
        }

        // 入金種別
        if (ComValidation::isArray($param["pay_type"])) {
            $where[] = "EXISTS ("
                    ." SELECT payment_log.user_id FROM payment_log"
                    ." WHERE payment_log.pay_type IN (" . implode(",", $param["pay_type"]) . ")"
                    ." AND is_cancel = 0 AND disable= 0"
                    ." AND payment_log.user_id = v_user_profile.user_id GROUP BY payment_log.user_id)";
            foreach ($param["pay_type"] as $val) {
                $payType[] = AdmOrdering::$_payType[$val];
            }
            $this->_contents["入金種別"] = implode(", ", $payType);
        }

        // ユニットIDに含まれる
        if($param["unit_id"]){
            $unitIdArray =  explode(",", $param["unit_id"]);
            if (!in_array("", $unitIdArray)) {
                // すべてのユニットIDに含まれる
                if($param["unit_specify_target_select"]){
                    foreach($unitIdArray as $val){
                        $where[] = "EXISTS ("
                            ." SELECT unit.user_id FROM unit_user AS unit"
                            ." WHERE unit.unit_id = " . $val
                            ." AND unit.user_id = v_user_profile.user_id)";
                    }
                    $this->_contents["ユニットID"] .= "『" . $param["unit_id"] . "』すべてに含まれる<br>";
                } else {
                    $unitIdString = "";
                    foreach($unitIdArray as $val){
                    $unitIdString[] = "EXISTS ("
                        ." SELECT unit.user_id FROM unit_user AS unit"
                        ." WHERE unit.unit_id = " . $val
                        ." AND unit.user_id = v_user_profile.user_id)";
                    }
                    $where[] = "(" . implode(" OR ", $unitIdString) . ")";
                    $this->_contents["ユニットID"] .= "『" . $param["unit_id"] . "』いずれかに含まれる<br>";
                }
            }
        }

        // ユニットIDに含まれる以外
        if($param["except_unit_id"]){
            $exceptUnitIdArray = explode(",", $param["except_unit_id"]);
            if (!in_array("", $exceptUnitIdArray)) {
                // すべてのユニットIDに含まれない
                if($param["except_unit_specify_target_select"]){
                    $exceptUnitIdString = "";
                    foreach($exceptUnitIdArray as $val){
                        $exceptUnitIdString[] = "EXISTS ("
                            ." SELECT unit.user_id FROM unit_user AS unit"
                            ." WHERE unit.unit_id = " . $val
                            ." AND unit.user_id = v_user_profile.user_id)";
                    }
                    $where[] = "NOT (" . implode(" AND ", $exceptUnitIdString) . ")";
                    $this->_contents["ユニットID"] .= "『" . $param["except_unit_id"] . "』すべてに含まれる以外<br>";
                } else {
                    foreach($exceptUnitIdArray as $val){
                        $where[] = "NOT EXISTS ("
                            ." SELECT unit.user_id FROM unit_user AS unit"
                            ." WHERE unit.unit_id = " . $val
                            ." AND unit.user_id = v_user_profile.user_id )";
                    }
                    $this->_contents["ユニットID"] .= "『" . $param["except_unit_id"] . "』いずれかに含まれる以外<br>";
                }
            }
        }

        // 抽選ユニットIDに含まれる
        if($param["lottery_unit_id"]){
            if (!in_array("", explode(",", $param["lottery_unit_id"]))) {
                // すべての抽選ユニットIDに含まれる
                if($param["lottery_unit_specify_target_select"]){
                    $where[] = "EXISTS ("
                        ." SELECT lottery_unit.user_id FROM lottery_unit_user AS lottery_unit"
                        ." WHERE lottery_unit.lottery_unit_id IN (" . $param["lottery_unit_id"] . ")"
                        ." AND lottery_unit.user_id = v_user_profile.user_id GROUP BY lottery_unit.user_id"
                        ." HAVING COUNT(lottery_unit.user_id) >= " .  count(explode(",", $param["lottery_unit_id"])) . ")";
                        $this->_contents["抽選ユニットID"] .= "『" . $param["lottery_unit_id"] . "』すべてに含まれる<br>";
                } else {
                    $where[] = "EXISTS ("
                        ." SELECT lottery_unit.user_id FROM lottery_unit_user AS lottery_unit"
                        ." WHERE lottery_unit.lottery_unit_id IN (" . $param["lottery_unit_id"] . ")"
                        ." AND lottery_unit.user_id = v_user_profile.user_id GROUP BY lottery_unit.user_id)";
                    $this->_contents["抽選ユニットID"] .= "『" . $param["lottery_unit_id"] . "』いずれかに含まれる<br>";
                }
            }
        }

        // 抽選ユニットIDに含まれる以外
        if($param["except_lottery_unit_id"]){
            if (!in_array("", explode(",", $param["except_lottery_unit_id"]))) {
                // すべての抽選ユニットIDに含まれない
                if($param["except_lottery_unit_specify_target_select"]){

                    $where[] = "NOT EXISTS ("
                        ." SELECT lottery_unit.user_id FROM lottery_unit_user AS lottery_unit"
                        ." WHERE lottery_unit.lottery_unit_id IN (" . $param["except_lottery_unit_id"] . ")"
                        ." AND lottery_unit.user_id = v_user_profile.user_id GROUP BY lottery_unit.user_id"
                        ." HAVING COUNT(lottery_unit.user_id) >= " .  count(explode(",", $param["except_lottery_unit_id"])) . ")";
                    $this->_contents["抽選ユニットID"] .= "『" . $param["except_lottery_unit_id"] . "』すべてに含まれる以外<br>";
                } else {
                    $where[] = "NOT EXISTS ("
                        ." SELECT lottery_unit.user_id FROM lottery_unit_user AS lottery_unit"
                        ." WHERE lottery_unit.lottery_unit_id IN (" . $param["except_lottery_unit_id"] . ")"
                        ." AND lottery_unit.user_id = v_user_profile.user_id GROUP BY lottery_unit.user_id)";
                    $this->_contents["抽選ユニットID"] .= "『" . $param["except_lottery_unit_id"] . "』いずれかに含まれる以外<br>";
                }
            }
        }

        //フリーワード検索
        if($param["specify_free_word"]){
            for ($i = 1; $i <= 10; $i++) {
                if($param["specify_free_word_type_1__".$i] AND $param["free_word_type_from_1__".$i]  AND $param["free_word_type_to_1__".$i]){
                    $where[] = "EXISTS ("
                        ." SELECT 'X' FROM convert_free_word as cfw"
                        ." WHERE free_word_type = 1 AND free_word_cd = ".$i." AND free_word_value >= ".$param["free_word_type_from_1__".$i] . " AND free_word_value <= ". $param["free_word_type_to_1__".$i]
                        ." AND cfw.user_id =v_user_profile.user_id)" ;
                    $this->_contents["フリーワード含む"] .= "『".$i."桁  ".$param["free_word_type_from_1__".$i]."～".$param["free_word_type_to_1__".$i]."』   ";
                }else if(($param["specify_free_word_type_1__".$i] != "" AND $param["specify_free_word_type_1__".$i] == 0) AND $param["free_word_type_from_1__".$i]  AND $param["free_word_type_to_1__".$i]){
                    $where[] = "NOT EXISTS ("
                        ." SELECT 'X' FROM convert_free_word as cfw"
                        ." WHERE free_word_type = 1 AND free_word_cd = ".$i." AND free_word_value >= ".$param["free_word_type_from_1__".$i] . " AND free_word_value <= ". $param["free_word_type_to_1__".$i]
                        ." AND cfw.user_id =v_user_profile.user_id)" ;
                    $this->_contents["フリーワード含まない"] .= "『".$i."桁  ".$param["free_word_type_from_1__".$i]."～".$param["free_word_type_to_1__".$i]."』   ";
                }
            }
        }

        //フリーワード管理設定検索
        if($param["specify_free_word_set"]){
            $AdmFreeWordOBJ = AdmFreeWord::getInstance();

            for ($i = 1; $i <= 10; $i++) {
                $freeWordValueString = "";
                if($param["specify_free_word_type_set_2__".$i] AND $param["free_word_type_set_2__".$i]){
                    $freeWordValueString = implode(",",$param["free_word_type_set_2__".$i]) ;

                    $freeWordSearchResultDspAry = array() ;
                    foreach($param["free_word_type_set_2__".$i] as $key => $val){
                        $freeWordData = $AdmFreeWordOBJ->getFreeWordDataForEdit(2,$i,$val) ;
                        $freeWordSearchResultDspAry[] = $freeWordData[0] ["free_word_text"];
                    }

                    $freeWordSearchResultDsp = implode("<br>",$freeWordSearchResultDspAry) ;

                    $where[] = "EXISTS ("
                        ." SELECT 'X' FROM convert_free_word as cfw"
                        ." WHERE free_word_type = 2 AND free_word_cd = ".$i." AND free_word_value in(". $freeWordValueString . ") "
                        ." AND cfw.user_id =v_user_profile.user_id)" ;
                    $this->_contents["フリーワード文言選択含む"] .= "『対象％変換  -%free_word_2_".$i."-』 <br>".$freeWordSearchResultDsp."<br><br>" ;
                }else if(($param["specify_free_word_type_set_2__".$i] != "" AND $param["specify_free_word_type_set_2__".$i] == 0) AND $param["free_word_type_set_2__".$i]){
                    $freeWordValueString = implode(",",$param["free_word_type_set_2__".$i]) ;

                    $freeWordSearchResultDspAry = array() ;
                    foreach($param["free_word_type_set_2__".$i] as $key => $val){
                        $freeWordData = $AdmFreeWordOBJ->getFreeWordDataForEdit(2,$i,$val) ;
                        $freeWordSearchResultDspAry[] = $freeWordData[0] ["free_word_text"];
                    }

                    $freeWordSearchResultDsp = implode("<br>",$freeWordSearchResultDspAry) ;

                    $where[] = "NOT EXISTS ("
                        ." SELECT 'X' FROM convert_free_word as cfw"
                        ." WHERE free_word_type = 2 AND free_word_cd = ".$i." AND free_word_value in(". $freeWordValueString . ") "
                        ." AND cfw.user_id =v_user_profile.user_id)" ;
                    $this->_contents["フリーワード文言選択含まない"] .= "『対象％変換  -%free_word_2_".$i."-』 <br>".$freeWordSearchResultDsp."<br><br>" ;
                }
            }
        }

        // 商品IDを購入している
        if($param["item_id"]){
            if (!in_array("", explode(",", $param["item_id"]))) {
                // すべての商品IDを購入している
                if($param["item_specify_target_select"]){
                    $where[] = "EXISTS ("
                            ." SELECT ordering.user_id FROM ordering,ordering_detail"
                            ." WHERE ordering_detail.item_id IN (" . $param["item_id"] . ")"
                            ." AND ordering.status IN (" . AdmOrdering::ORDERING_STATUS_PRE_COMPLETE . "," . AdmOrdering::ORDERING_STATUS_COMPLETE . ")"
                            ." AND ordering_detail.is_cancel = 0"
                            ." AND ordering.user_id = v_user_profile.user_id"
                            ." AND ordering_detail.ordering_id = ordering.id GROUP BY ordering.user_id"
                            ." HAVING COUNT(ordering.user_id) >= " .  count(explode(",", $param["item_id"])) . ")";
                    $this->_contents["購入商品ID"] .= "『" . $param["item_id"] . "』すべてを購入している<br>";
                } else {
                     $where[] = "EXISTS ("
                            ." SELECT ordering.user_id FROM ordering,ordering_detail"
                            ." WHERE ordering_detail.item_id IN (" . $param["item_id"] . ")"
                            ." AND ordering.status IN (" . AdmOrdering::ORDERING_STATUS_PRE_COMPLETE . "," . AdmOrdering::ORDERING_STATUS_COMPLETE . ")"
                            ." AND ordering_detail.is_cancel = 0"
                            ." AND ordering.user_id = v_user_profile.user_id"
                            ." AND ordering_detail.ordering_id = ordering.id GROUP BY ordering.user_id)";
                     $this->_contents["購入商品ID"] .= "『" . $param["item_id"] . "』いずれかを購入している<br>";
                }
            }
        }

        // 商品IDを購入している以外
        if($param["except_item_id"]){
            if (!in_array("", explode(",", $param["except_item_id"]))) {
                // すべての商品IDを購入していない
                if($param["except_item_specify_target_select"]){
                    $where[] = "NOT EXISTS ("
                            ." SELECT ordering.user_id FROM ordering,ordering_detail"
                            ." WHERE ordering_detail.item_id IN (" . $param["except_item_id"] . ")"
                            ." AND ordering.status IN (" . AdmOrdering::ORDERING_STATUS_PRE_COMPLETE . "," . AdmOrdering::ORDERING_STATUS_COMPLETE . ")"
                            ." AND ordering_detail.is_cancel = 0"
                            ." AND ordering.user_id = v_user_profile.user_id"
                            ." AND ordering_detail.ordering_id = ordering.id GROUP BY ordering.user_id"
                            ." HAVING COUNT(ordering.user_id) >= " .  count(explode(",", $param["except_item_id"])) . ")";
                    $this->_contents["購入商品ID"] .= "『" . $param["except_item_id"] . "』すべてを購入している以外<br>";
                } else {
                    $where[] = "NOT EXISTS ("
                            ." SELECT ordering.user_id FROM ordering,ordering_detail"
                            ." WHERE ordering_detail.item_id IN (" . $param["except_item_id"] . ")"
                            ." AND ordering.status IN (" . AdmOrdering::ORDERING_STATUS_PRE_COMPLETE . "," . AdmOrdering::ORDERING_STATUS_COMPLETE . ")"
                            ." AND ordering_detail.is_cancel = 0"
                            ." AND ordering.user_id = v_user_profile.user_id"
                            ." AND ordering_detail.ordering_id = ordering.id GROUP BY ordering.user_id)";
                    $this->_contents["購入商品ID"] .= "『" . $param["except_item_id"] . "』いずれかを購入している以外<br>";
                }
            }
        }

        // 情報IDを見ている
        if($param["information_id"]){
            if (!in_array("", explode(",", $param["information_id"]))) {
                // すべての情報IDを見ている
                if($param["information_specify_target_select"]){
                    $where[] = "EXISTS ("
                            ." SELECT information_status_log.user_id FROM information_status_log"
                            ." WHERE information_status_log.information_status_id IN (" . $param["information_id"] . ")"
                            ." AND information_status_log.user_id = v_user_profile.user_id GROUP BY information_status_log.user_id"
                            ." HAVING COUNT(information_status_log.user_id) >= " .  count(explode(",", $param["information_id"])) . ")";
                    $this->_contents["既読情報ID"] .= "『" . $param["information_id"] . "』すべてを見ている<br>";
                } else {
                    $where[] = "EXISTS ("
                            ." SELECT information_status_log.user_id FROM information_status_log"
                            ." WHERE information_status_log.information_status_id IN (" . $param["information_id"] . ")"
                            ." AND information_status_log.user_id = v_user_profile.user_id GROUP BY information_status_log.user_id)";
                    $this->_contents["既読情報ID"] .= "『" . $param["information_id"] . "』いずれかを見ている<br>";
                }
            }
        }

        // 情報IDを見ていない
        if($param["except_information_id"]){
            if (!in_array("", explode(",", $param["except_information_id"]))) {
                // すべての情報IDを見ていない
                if($param["except_information_specify_target_select"]){
                    $where[] = "NOT EXISTS ("
                            ." SELECT information_status_log.user_id FROM information_status_log"
                            ." WHERE information_status_log.information_status_id IN (" . $param["except_information_id"] . ")"
                            ." AND information_status_log.user_id = v_user_profile.user_id GROUP BY information_status_log.user_id"
                            ." HAVING COUNT(information_status_log.user_id) >= " .  count(explode(",", $param["except_information_id"])) . ")";
                    $this->_contents["既読情報ID"] .= "『" . $param["except_information_id"] . "』すべてを見ている以外<br>";
                } else {
                    $where[] = "NOT EXISTS ("
                            ." SELECT information_status_log.user_id FROM information_status_log"
                            ." WHERE information_status_log.information_status_id IN (" . $param["except_information_id"] . ")"
                            ." AND information_status_log.user_id = v_user_profile.user_id GROUP BY information_status_log.user_id)";
                    $this->_contents["既読情報ID"] .= "『" . $param["except_information_id"] . "』いずれかを見ている以外<br>";
                }
            }
        }

        // 登録入口カテゴリー
        if ($param["regist_page_category_id"]) {
            $AdmRegistPageOBJ = AdmRegistPage::getInstance();
            foreach ($param["regist_page_category_id"] as $val) {
                if ($val) {
                    $data = $AdmRegistPageOBJ->getRegistPageCategoryData($val);
                } else {
                    $data["name"] = "ダイレクト登録";
                    $subWhere = " OR v_user_profile.regist_page_id = 0";
                }
                $registPageCategoryName[] = $data["name"];
            }
            $where[] = "(EXISTS ("
                    ." SELECT v_user_profile.user_id FROM regist_page"
                    ." WHERE regist_page.regist_page_category_id IN (" . implode(",", $param["regist_page_category_id"]) . ")"
                    ." AND regist_page.id = v_user_profile.regist_page_id)" . $subWhere . ")";
            $this->_contents["登録入口カテゴリー"] =  "『" . implode("、", $registPageCategoryName) . "』から登録している<br>";
        }

        // 登録入口ID
        if ($param["regist_page_id"] != "") {
            if (!in_array("", explode(",", $param["regist_page_id"]))) {
                $where[] = "v_user_profile.regist_page_id IN (" . $param["regist_page_id"] . ")";
                $this->_contents["登録入口ID"] .=  "『" . $param["regist_page_id"] . "』から登録している<br>";
            }
        }

        // 対象外登録入り口ID
        if ($param["except_regist_page_id"] != "") {
            if (!in_array("", explode(",", $param["except_regist_page_id"]))) {
                $where[] = "v_user_profile.regist_page_id NOT IN (" . $param["except_regist_page_id"] . ")";
                $this->_contents["登録入口ID"] .=  "『" . $param["except_regist_page_id"] . "』から登録していない<br>";
            }
        }

        //ログイン後トップアクセス
        if ($param["difference_between_regist_and_home_from"] AND $param["difference_between_regist_and_home_to"]) {
            $where[] = "(UNIX_TIMESTAMP(v_user_profile.home_access_datetime) - UNIX_TIMESTAMP(v_user_profile.regist_datetime)) >= ".$param["difference_between_regist_and_home_from"] ;
            $where[] = "(UNIX_TIMESTAMP(v_user_profile.home_access_datetime) - UNIX_TIMESTAMP(v_user_profile.regist_datetime)) <= ".$param["difference_between_regist_and_home_to"] ;
            $this->_contents["登録日時とﾛｸﾞｲﾝ後ﾄｯﾌﾟｱｸｾｽ日時の差分"] .=  $param["difference_between_regist_and_home_from"]."秒～".$param["difference_between_regist_and_home_to"]."秒の範囲";
        }

        //ログイン後トップアクセス有り
        if ($param["is_home_acccess_datetime"]) {
            $where[]  = "v_user_profile.home_access_datetime != '0000-00-00 00:00:00' " ;
            $this->_contents["ログイン後トップアクセス有り"] .=  "ログイン後トップアクセス有り" ;
        }

        //ログイン後トップアクセス無し
        if ($param["is_not_home_acccess_datetime"]) {
            $where[]  = "v_user_profile.home_access_datetime = '0000-00-00 00:00:00' " ;
            $this->_contents["ログイン後トップアクセス無し"] .=  "ログイン後トップアクセス無し" ;
        }

        //最終アクセス
        switch ($param["specify_last_access"]) {

            case 1 :
                $lastAccessDatetimeFrom = $param["last_access_from_Date"]
                                        . " " . $param["last_access_from_Time"];

                $lastAccessDatetimeTo = $param["last_access_to_Date"]
                                        . " " . $param["last_access_to_Time"];

                if (ComValidation::isDatetime($lastAccessDatetimeFrom)) {
                    $where[] = "v_user_profile.last_access_datetime >= '" . date("YmdHis", strtotime($lastAccessDatetimeFrom)) . "'";
                    $lastAccessDatetime["from"] = $lastAccessDatetimeFrom;
                    $lastAccessDatetime["to"] = $lastAccessDatetimeTo;
                }
                if (ComValidation::isDatetime($lastAccessDatetimeTo)) {
                    $where[] = "v_user_profile.last_access_datetime <= '" . date("YmdHis", strtotime($lastAccessDatetimeTo)) . "'";
                    $lastAccessDatetime["to"] = $lastAccessDatetimeTo;
                }

                if ($lastAccessDatetime) {
                    $this->_contents["最終アクセス"] = $lastAccessDatetime["from"] . " ～ " . $lastAccessDatetime["to"];
                }
                break;
            case 2 :
            case 3 :
            case 4 :
            case 5 :
            case 6 :
            case 8 :
            case 9 :
            case 10 :
            case 11 :
            case 12 :
            case 13 :
            case 14 :
            case 15 :

                $where[] = "v_user_profile.last_access_datetime >= '". date("YmdHis", strtotime($this->datetimeParameter[$param["specify_last_access"]])) . "'";

                if($this->_configOBJ->admin_config->specify_date_time_select->$param["specify_last_access"]){
                    $last_access_datetime_content =  $this->_configOBJ->admin_config->specify_date_time_select->$param["specify_last_access"] ;
                } else {
                    $last_access_datetime_content =  $this->_configOBJ->admin_config->specify_month_select->$param["specify_last_access"] ;
                }
                $this->_contents["最終アクセス"] = $last_access_datetime_content ;
                break;
            case 7 :
                // 不等号に気をつける！
                // 小さい値
                if (ComValidation::isNumeric($param["last_access_time_from"])) {
                    $where[] = "v_user_profile.last_access_datetime <= '" . date("YmdHis", strtotime("-" . $param["last_access_time_from"] . " hour")) . "'";
                    $lastAccessDatetime["from"] = $param["last_access_time_from"] . "時間前以上";
                }
                // 大きい値
                if (ComValidation::isNumeric($param["last_access_time_to"])) {
                    $where[] = "v_user_profile.last_access_datetime > '" . date("YmdHis", strtotime("-" . $param["last_access_time_to"] . " hour")) . "'";
                    $lastAccessDatetime["to"] = $param["last_access_time_to"] . "時間前未満";
                }

                if ($lastAccessDatetime) {
                    $this->_contents["最終アクセス"] = $lastAccessDatetime["from"] . " " . $lastAccessDatetime["to"];
                }
                break;
            default :
                break;
        }

        //アクセス無し
        switch ($param["specify_not_access"]) {

            case 1 :
                $notAccessDatetimeFrom = $param["not_access_from_Date"]
                                        . " " . $param["not_access_from_Time"];

                $notAccessDatetimeTo = $param["not_access_to_Date"]
                                        . " " . $param["not_access_to_Time"];

                // ～前以上～未満
                if (ComValidation::isDatetime($notAccessDatetimeFrom) AND ComValidation::isDatetime($notAccessDatetimeTo)) {
                    $where[] = "NOT EXISTS(SELECT 'x' FROM v_user_profile AS vup WHERE vup.last_access_datetime >= '" . date("YmdHis", strtotime($notAccessDatetimeFrom)) . "' AND vup.last_access_datetime < '" . date("YmdHis", strtotime($notAccessDatetimeTo)) . "' AND v_user_profile.user_id = vup.user_id)" ;
                    $lastAccessDatetime["from"] = $notAccessDatetimeFrom;
                    $lastAccessDatetime["to"] = $notAccessDatetimeTo;
                //～未満
                } else  if (ComValidation::isDatetime($notAccessDatetimeTo)) {
                    $where[] = "v_user_profile.last_access_datetime < '" . date("YmdHis", strtotime($notAccessDatetimeTo)) . "'";
                    $lastAccessDatetime["to"] = $notAccessDatetimeTo;
                } else {
                    break;
                }
                if ($lastAccessDatetime) {
                    $this->_contents["アクセス無し"] = $lastAccessDatetime["from"] . " " . $lastAccessDatetime["to"];
                }

                break;
            case 2 :
            case 3 :
            case 4 :
            case 5 :
            case 6 :
            case 8 :
            case 9 :
            case 10 :
            case 11 :
            case 12 :
            case 13 :
            case 14 :
            case 15 :

                $where[] = "v_user_profile.last_access_datetime <= '". date("YmdHis", strtotime($this->datetimeParameter[$param["specify_not_access"]])) . "'";

                 if($this->_configOBJ->admin_config->specify_date_time_select->$param["specify_not_access"]){
                     $not_access_datetime_content =  $this->_configOBJ->admin_config->specify_date_time_select->$param["specify_not_access"] ;
                 } else {
                     $not_access_datetime_content =  $this->_configOBJ->admin_config->specify_month_select->$param["specify_not_access"] ;
                 }

                $this->_contents["アクセス無し"] = $not_access_datetime_content ;
                break;
            case 7 :
                // ～前以上～未満
                if (ComValidation::isNumeric($param["not_access_time_from"]) AND ComValidation::isNumeric($param["not_access_time_to"])) {
                    $where[] = "NOT EXISTS(SELECT 'x' FROM v_user_profile AS vup WHERE vup.last_access_datetime <= '" . date("YmdHis", strtotime("-" . $param["not_access_time_from"] . " hour")) . "' AND vup.last_access_datetime > '" . date("YmdHis", strtotime("-" . $param["not_access_time_to"] . " hour")) . "' AND v_user_profile.user_id = vup.user_id)" ;
                    $lastAccessDatetime["from"] = $param["not_access_time_from"] . "時間前以上";
                    $lastAccessDatetime["to"] = $param["not_access_time_to"] . "時間前未満";
                //～未満
                } else  if (ComValidation::isNumeric($param["not_access_time_to"])) {
                    $where[] = "v_user_profile.last_access_datetime < '" . date("YmdHis", strtotime("-" . $param["not_access_time_to"] . " hour")) . "'";
                    $lastAccessDatetime["to"] = $param["not_access_time_to"] . "時間前未満";
                } else {
                    break;
                }
                if ($lastAccessDatetime) {
                    $this->_contents["アクセス無し"] = $lastAccessDatetime["from"] . " " . $lastAccessDatetime["to"];
                }
                break;
            default :
                break;
        }

        //アクセス日時あり
        if ($param["except_access_no_data"]) {
            $where[]  = "v_user_profile.last_access_datetime != '0000-00-00 00:00:00' " ;
            $this->_contents["アクセス日時あり"] .=  "アクセス日時あり" ;
        }

         //アクセス日時  0000-00-00
        if ($param["access_no_data"]) {
            $where[]  = "v_user_profile.last_access_datetime = '0000-00-00 00:00:00' " ;
            $this->_contents["アクセス日時 0000-00-00"] .=  "アクセス日時  0000-00-00" ;
        }

        // 仮登録日
        switch ($param["specify_pre_regist"]) {
            case 1 :
                $preRegistDatetimeFrom = $param["pre_regist_from_Date"]
                                        . " " . $param["pre_regist_from_Time"];

                $preRegistDatetimeTo = $param["pre_regist_to_Date"]
                                        . " " . $param["pre_regist_to_Time"];
                if (ComValidation::isDatetime($preRegistDatetimeFrom)) {
                    $where[] = "v_user_profile.pre_regist_datetime >= '" . date("YmdHis", strtotime($preRegistDatetimeFrom)) . "'";
                    $preRegistDatetime["from"] = $preRegistDatetimeFrom;
                }
                if (ComValidation::isDatetime($preRegistDatetimeTo)) {
                    $where[] = "v_user_profile.pre_regist_datetime <= '" . date("YmdHis", strtotime($preRegistDatetimeTo)) . "'";
                    $preRegistDatetime["to"] = $preRegistDatetimeTo;

                }
                if ($preRegistDatetime) {
                    $this->_contents["仮登録日時"] = $preRegistDatetime["from"] . " ～ " . $preRegistDatetime["to"];
                }
                break;
            case 2 :
            case 3 :
            case 4 :
            case 5 :
            case 6 :
                $where[] = "v_user_profile.pre_regist_datetime >= '"
                    . date("YmdHis", strtotime($this->datetimeParameter[$param["specify_pre_regist"]])) . "'";
                $this->_contents["登録日時"] = $this->_configOBJ->admin_config->specify_date_time_select->$param["specify_pre_regist"];
                break;
            case 7 :
                // 不等号に気をつける！
                // 小さい値
                if (ComValidation::isNumeric($param["pre_regist_time_from"])) {
                    $where[] = "v_user_profile.pre_regist_datetime <= '" . date("YmdHis", strtotime("-" . $param["pre_regist_time_from"] . " hour")) . "'";
                    $preRegistDatetime["from"] = $param["pre_regist_time_from"] . "時間前以上";
                }
                // 大きい値
                if (ComValidation::isNumeric($param["pre_regist_time_to"])) {
                    $where[] = "v_user_profile.pre_regist_datetime > '" . date("YmdHis", strtotime("-" . $param["pre_regist_time_to"] . " hour")) . "'";
                    $preRegistDatetime["to"] = $param["pre_regist_time_to"] . "時間前未満";
                }

                if ($preRegistDatetime) {
                    $this->_contents["仮登録日時"] = $preRegistDatetime["from"] . " " . $preRegistDatetime["to"];
                }
                break;
            default :
                break;
        }

        // 登録日
        switch ($param["specify_regist"]) {
            case 1 :
                $registDatetimeFrom = $param["regist_from_Date"]
                                        . " " . $param["regist_from_Time"];

                $registDatetimeTo = $param["regist_to_Date"]
                                        . " " . $param["regist_to_Time"];
                if (ComValidation::isDatetime($registDatetimeFrom)) {
                    $where[] = "v_user_profile.regist_datetime >= '" . date("YmdHis", strtotime($registDatetimeFrom)) . "'";
                    $registDatetime["from"] = $registDatetimeFrom;
                }
                if (ComValidation::isDatetime($registDatetimeTo)) {
                    $where[] = "v_user_profile.regist_datetime <= '" . date("YmdHis", strtotime($registDatetimeTo)) . "'";
                    $registDatetime["to"] = $registDatetimeTo;

                }
                if ($registDatetime) {
                    $this->_contents["登録日時"] = $registDatetime["from"] . " ～ " . $registDatetime["to"];
                }
                break;
            case 2 :
            case 3 :
            case 4 :
            case 5 :
            case 6 :
                $where[] = "v_user_profile.regist_datetime >= '"
                    . date("YmdHis", strtotime($this->datetimeParameter[$param["specify_regist"]])) . "'";
                $this->_contents["登録日時"] = $this->_configOBJ->admin_config->specify_date_time_select->$param["specify_regist"];
                break;
            case 7 :
                // 不等号に気をつける！
                // 小さい値
                if (ComValidation::isNumeric($param["regist_time_from"])) {
                    $where[] = "v_user_profile.regist_datetime <= '" . date("YmdHis", strtotime("-" . $param["regist_time_from"] . " hour")) . "'";
                    $registDatetime["from"] = $param["regist_time_from"] . "時間前以上";
                }
                // 大きい値
                if (ComValidation::isNumeric($param["regist_time_to"])) {
                    $where[] = "v_user_profile.regist_datetime > '" . date("YmdHis", strtotime("-" . $param["regist_time_to"] . " hour")) . "'";
                    $registDatetime["to"] = $param["regist_time_to"] . "時間前未満";
                }

                if ($registDatetime) {
                    $this->_contents["登録日時"] = $registDatetime["from"] . " " . $registDatetime["to"];
                }
                break;
            default :
                break;
        }

        // 初回入金日
        switch ($param["specify_first_pay"]) {
            case 1 :
                $firstPayDatetimeFrom = $param["first_pay_from_Date"]
                                        . " " . $param["first_pay_from_Time"];

                $firstPayDatetimeTo = $param["first_pay_to_Date"]
                                        . " " . $param["first_pay_to_Time"];
                if (ComValidation::isDatetime($firstPayDatetimeFrom)) {
                    $where[] = "v_user_profile.first_pay_datetime >= '" . date("YmdHis", strtotime($firstPayDatetimeFrom)) . "'";
                    $firstPayDatetime["from"] = $firstPayDatetimeFrom;
                }
                if (ComValidation::isDatetime($firstPayDatetimeTo)) {
                    $where[] = "v_user_profile.first_pay_datetime <= '" . date("YmdHis", strtotime($firstPayDatetimeTo)) . "'";
                    $firstPayDatetime["to"] = $firstPayDatetimeTo;

                }
                if ($firstPayDatetime) {
                    $this->_contents["初回入金日"] = $firstPayDatetime["from"] . " ～ " . $firstPayDatetime["to"];
                }
                break;
            case 2 :
            case 3 :
            case 4 :
            case 5 :
            case 6 :
                $where[] = "v_user_profile.first_pay_datetime >= '"
                    . date("YmdHis", strtotime($this->datetimeParameter[$param["specify_first_pay"]])) . "'";
                $this->_contents["初回入金日"] = $this->_configOBJ->admin_config->specify_date_time_select->$param["specify_first_pay"];
                break;
            case 7 :
                // 不等号に気をつける！
                // 小さい値
                if (ComValidation::isNumeric($param["first_pay_time_from"])) {
                    $where[] = "v_user_profile.first_pay_datetime <= '" . date("YmdHis", strtotime("-" . $param["first_pay_time_from"] . " hour")) . "'";
                    $firstPayDatetime["from"] = $param["first_pay_time_from"] . "時間前以上";
                }
                // 大きい値
                if (ComValidation::isNumeric($param["first_pay_time_to"])) {
                    $where[] = "v_user_profile.first_pay_datetime > '" . date("YmdHis", strtotime("-" . $param["first_pay_time_to"] . " hour")) . "'";
                    $firstPayDatetime["to"] = $param["first_pay_time_to"] . "時間前未満";
                }

                if ($firstPayDatetime) {
                    $this->_contents["初回入金日"] = $firstPayDatetime["from"] . " " . $firstPayDatetime["to"];
                }
                break;
            default :
                break;
        }

        // 最終購入日
        switch ($param["specify_last_buy"]) {
            case 1 :
                $lastBuyDatetimeFrom = $param["last_buy_from_Date"]
                                        . " " . $param["last_buy_from_Time"];

                $lastBuyDatetimeTo = $param["last_buy_to_Date"]
                                        . " " . $param["last_buy_to_Time"];
                if (ComValidation::isDatetime($lastBuyDatetimeFrom)) {
                    $where[] = "v_user_profile.last_buy_datetime >= '" . date("YmdHis", strtotime($lastBuyDatetimeFrom)) . "'";
                    $lastBuyDatetime["from"] = $lastBuyDatetimeFrom;
                }
                if (ComValidation::isDatetime($lastBuyDatetimeTo)) {
                    $where[] = "v_user_profile.last_buy_datetime <= '" . date("YmdHis", strtotime($lastBuyDatetimeTo)) . "'";
                    $lastBuyDatetime["to"] = $lastBuyDatetimeTo;

                }
                if ($lastBuyDatetime) {
                    $this->_contents["最終購入日"] = $lastBuyDatetime["from"] . " ～ " . $lastBuyDatetime["to"];
                }
                break;
            case 2 :
            case 3 :
            case 4 :
            case 5 :
            case 6 :
                $where[] = "v_user_profile.last_buy_datetime >= '"
                    . date("YmdHis", strtotime($this->datetimeParameter[$param["specify_last_buy"]])) . "'";
                $this->_contents["最終購入日"] = $this->_configOBJ->admin_config->specify_date_time_select->$param["specify_last_buy"];
                break;
            case 7 :
                // 不等号に気をつける！
                // 小さい値
                if (ComValidation::isNumeric($param["last_buy_time_from"])) {
                    $where[] = "v_user_profile.last_buy_datetime <= '" . date("YmdHis", strtotime("-" . $param["last_buy_time_from"] . " hour")) . "'";
                    $lastBuyDatetime["from"] = $param["last_buy_time_from"] . "時間前以上";
                }
                // 大きい値
                if (ComValidation::isNumeric($param["last_buy_time_to"])) {
                    $where[] = "v_user_profile.last_buy_datetime > '" . date("YmdHis", strtotime("-" . $param["last_buy_time_to"] . " hour")) . "'";
                    $lastBuyDatetime["to"] = $param["last_buy_time_to"] . "時間前未満";
                }

                if ($lastBuyDatetime) {
                    $this->_contents["最終購入日"] = $lastBuyDatetime["from"] . " " . $lastBuyDatetime["to"];
                }
                break;
            default :
                break;
        }

        // 仮登録経過日
        if(ComValidation::isNumeric($param["pre_past_date_from"]) || ComValidation::isNumeric($param["pre_past_date_to"])){

            if(ComValidation::isNumeric($param["pre_past_date_from"])){
                $prePastDate["from"] = $param["pre_past_date_from"] . "日前以上";
            }

            if(ComValidation::isNumeric($param["pre_past_date_to"])){
                $prePastDate["to"] = $param["pre_past_date_to"] . "日前まで";
            }
            // 不等号に気をつける！
            // 小さい値
            if ($prePastDate["from"]) {

                $where[] = "v_user_profile.pre_regist_datetime <= SUBDATE(DATE_FORMAT(NOW(), '%y%m%d235959'), interval " . $param["pre_past_date_from"] . " day)";

            }
            // 大きい値
            if ($prePastDate["to"]) {

                $where[] = "v_user_profile.pre_regist_datetime >= SUBDATE(DATE_FORMAT(NOW(), '%y%m%d000000'), interval " . $param["pre_past_date_to"] . " day)";
            }

            if ($prePastDate) {
                $this->_contents["仮登録経過日"] = $prePastDate["from"] . " " . $prePastDate["to"];
            }
        }

        // 登録経過日
        if(ComValidation::isNumeric($param["past_date_from"]) || ComValidation::isNumeric($param["past_date_to"])){

            if(ComValidation::isNumeric($param["past_date_from"])){
                $pastDate["from"] = $param["past_date_from"] . "日前以上";
            }

            if(ComValidation::isNumeric($param["past_date_to"])){
                $pastDate["to"] = $param["past_date_to"] . "日前まで";
            }
            // 不等号に気をつける！
            // 小さい値
            if ($pastDate["from"]) {

                $where[] = "v_user_profile.regist_datetime <= SUBDATE(DATE_FORMAT(NOW(), '%y%m%d235959'), interval " . $param["past_date_from"] . " day)";

            }
            // 大きい値
            if ($pastDate["to"]) {

                $where[] = "v_user_profile.regist_datetime >= SUBDATE(DATE_FORMAT(NOW(), '%y%m%d000000'), interval " . $param["past_date_to"] . " day)";
            }

            if ($pastDate) {
                $this->_contents["登録経過日"] = $pastDate["from"] . " " . $pastDate["to"];
            }
        }

        // 期間消費ポイント
        if(ComValidation::isNumeric($param["use_point_from"]) || ComValidation::isNumeric($param["use_point_to"])){
            $subWhere = "";
            $subHaving = "";
            if(ComValidation::isNumeric($param["use_point_from"])){
                $usePoint["from"] = $param["use_point_from"] . "pt以上";
                $subHaving[] = "SUM(point_log.point) <= " . (0 - $param["use_point_from"]);
            }

            if(ComValidation::isNumeric($param["use_point_to"])){
                $usePoint["to"] = $param["use_point_to"] . "ptまで";
                $subHaving[] = "SUM(point_log.point) >= " . (0 - $param["use_point_to"]);
            }

            switch ($param["specify_use_point"]) {
                case 1 :

                    $usePointDatetimeFrom = $param["use_point_from_Date"]
                                            . " " . $param["use_point_from_Time"];

                    $usePointDatetimeTo = $param["use_point_to_Date"]
                                            . " " . $param["use_point_to_Time"];
                    if (ComValidation::isDatetime($usePointDatetimeFrom)) {
                        $subWhere[] = "point_log.create_datetime >= '" . date("YmdHis", strtotime($usePointDatetimeFrom)) . "'";
                        $usePointDatetime["from"] = $usePointDatetimeFrom;
                    }
                    if (ComValidation::isDatetime($usePointDatetimeTo)) {
                        $subWhere[] = "point_log.create_datetime <= '" . date("YmdHis", strtotime($usePointDatetimeTo)) . "'";
                        $usePointDatetime["to"] = $usePointDatetimeTo;
                    }
                    if ($usePointDatetime) {
                        $where[] = "EXISTS ("
                                ." SELECT point_log.user_id FROM point_log"
                                ." WHERE " . implode(" AND ", $subWhere)
                                ." AND point_log.type = " . AdmPointLog::TYPE_NORMAL
                                ." AND point_log.point < 0"
                                ." AND point_log.disable = 0"
                                ." AND point_log.user_id = v_user_profile.user_id GROUP BY point_log.user_id"
                                ." HAVING " . implode(" AND ", $subHaving) . ")";
                        $this->_contents["期間消費ポイント"] = $usePointDatetime["from"] . " ～ " . $usePointDatetime["to"] . "<br>" . $usePoint["from"] . " " . $usePoint["to"];
                    }
                    break;
                case 2 :
                case 3 :
                case 4 :
                case 5 :
                case 6 :
                    $subWhere[] = "point_log.create_datetime  >= '"
                        . date("YmdHis", strtotime($this->datetimeParameter[$param["specify_use_point"]])) . "'";
                    $where[] = "EXISTS ("
                                ." SELECT point_log.user_id FROM point_log"
                                ." WHERE " . implode(" AND ", $subWhere)
                                ." AND point_log.type = " . AdmPointLog::TYPE_NORMAL
                                ." AND point_log.point < 0"
                                ." AND point_log.disable = 0"
                                ." AND point_log.user_id = v_user_profile.user_id GROUP BY point_log.user_id"
                                ." HAVING " . implode(" AND ", $subHaving) . ")";
                    $this->_contents["期間消費ポイント"] = $this->_configOBJ->admin_config->specify_date_time_select->$param["specify_use_point"] . " ～" . "<br>" . $usePoint["from"] . " " . $usePoint["to"];
                    break;
                case 7 :
                    // 不等号に気をつける！
                    // 小さい値
                    if (ComValidation::isNumeric($param["use_point_time_from"])) {
                        $subWhere[] = "point_log.create_datetime <= '" . date("YmdHis", strtotime("-" . $param["use_point_time_from"] . " hour")) . "'";
                        $usePointDatetime["from"] = $param["use_point_time_from"] . "時間前以上";
                    }
                    // 大きい値
                    if (ComValidation::isNumeric($param["use_point_time_to"])) {
                        $subWhere[] = "point_log.create_datetime > '" . date("YmdHis", strtotime("-" . $param["use_point_time_to"] . " hour")) . "'";
                        $usePointDatetime["to"] = $param["use_point_time_to"] . "時間前未満";
                    }

                    if ($usePointDatetime) {
                        $where[] = "EXISTS ("
                                ." SELECT point_log.user_id FROM point_log"
                                ." WHERE " . implode(" AND ", $subWhere)
                                ." AND point_log.type = " . AdmPointLog::TYPE_NORMAL
                                ." AND point_log.point < 0"
                                ." AND point_log.disable = 0"
                                ." AND point_log.user_id = v_user_profile.user_id GROUP BY point_log.user_id"
                                ." HAVING " . implode(" AND ", $subHaving) . ")";
                        $this->_contents["期間消費ポイント"] = $usePointDatetime["from"] . " " . $usePointDatetime["to"] . "<br>" . $usePoint["from"] . " " . $usePoint["to"];
                    }
                    break;
                default :
                    break;
            }
        }

        // 保有ポイント
        if(ComValidation::isNumeric($param["point_from"]) || ComValidation::isNumeric($param["point_to"])){

            if(ComValidation::isNumeric($param["point_from"])){
                $point["from"] = $param["point_from"] . "pt以上";
            }

            if(ComValidation::isNumeric($param["point_to"])){
                $point["to"] = $param["point_to"] . "ptまで";
            }

            if ($point["from"]) {

                $where[] = "v_user_profile.point >= " . $param["point_from"];

            }
            if ($point["to"]) {

                $where[] = "v_user_profile.point <= " . $param["point_to"];
            }

            if ($point) {
                $this->_contents["保有ポイント"] = $point["from"] . " " . $point["to"];
            }
        }

        // 合計付与ポイント
        if(ComValidation::isNumeric($param["total_addition_point_from"]) || ComValidation::isNumeric($param["total_addition_point_to"])){

            if(ComValidation::isNumeric($param["total_addition_point_from"])){
                $totalAdditionPoint["from"] = $param["total_addition_point_from"] . "pt以上";
            }

            if(ComValidation::isNumeric($param["total_addition_point_to"])){
                $totalAdditionPoint["to"] = $param["total_addition_point_to"] . "ptまで";
            }

            if ($totalAdditionPoint["from"]) {

                $where[] = "v_user_profile.total_addition_point >= " . $param["total_addition_point_from"];

            }
            if ($totalAdditionPoint["to"]) {

                $where[] = "v_user_profile.total_addition_point <= " . $param["total_addition_point_to"];
            }

            if ($totalAdditionPoint) {
                $this->_contents["合計付与ポイント"] = $totalAdditionPoint["from"] . " " . $totalAdditionPoint["to"];
            }
        }

        // 合計使用ポイント
        if(ComValidation::isNumeric($param["total_use_point_from"]) || ComValidation::isNumeric($param["total_use_point_to"])){

            if(ComValidation::isNumeric($param["total_use_point_from"])){
                $totalUsePoint["from"] = $param["total_use_point_from"] . "pt以上";
            }

            if(ComValidation::isNumeric($param["total_use_point_to"])){
                $totalUsePoint["to"] = $param["total_use_point_to"] . "ptまで";
            }

            if ($totalUsePoint["from"]) {

                $where[] = "v_user_profile.total_use_point >= " . $param["total_use_point_from"];

            }
            if ($totalUsePoint["to"]) {

                $where[] = "v_user_profile.total_use_point <= " . $param["total_use_point_to"];
            }

            if ($totalUsePoint) {
                $this->_contents["合計使用ポイント"] = $totalUsePoint["from"] . " " . $totalUsePoint["to"];
            }
        }

        // 期間購入金額
        if(ComValidation::isNumeric($param["terms_pay_from"]) || ComValidation::isNumeric($param["terms_pay_to"])){
            $subWhere = "";
            $subHaving = "";
            if(ComValidation::isNumeric($param["terms_pay_from"])){
                $termsPay["from"] = $param["terms_pay_from"] . "円以上";
                $subHaving[] = "SUM(payment_log.receive_money) >= " . $param["terms_pay_from"];
            }

            if(ComValidation::isNumeric($param["terms_pay_to"])){
                $termsPay["to"] = $param["terms_pay_to"] . "円まで";
                $subHaving[] = "SUM(payment_log.receive_money) <= " . $param["terms_pay_to"];
            }

            switch ($param["specify_terms_pay"]) {
                case 1 :

                    $termsPayDatetimeFrom = $param["terms_pay_from_Date"]
                                            . " " . $param["terms_pay_from_Time"];

                    $termsPayDatetimeTo = $param["terms_pay_to_Date"]
                                            . " " . $param["terms_pay_to_Time"];
                    if (ComValidation::isDatetime($termsPayDatetimeFrom)) {
                        $subWhere[] = "payment_log.create_datetime >= '" . date("YmdHis", strtotime($termsPayDatetimeFrom)) . "'";
                        $termsPayDatetime["from"] = $termsPayDatetimeFrom;
                    }
                    if (ComValidation::isDatetime($termsPayDatetimeTo)) {
                        $subWhere[] = "payment_log.create_datetime <= '" . date("YmdHis", strtotime($termsPayDatetimeTo)) . "'";
                        $termsPayDatetime["to"] = $termsPayDatetimeTo;
                    }
                    if ($termsPayDatetime) {
                        $where[] = "EXISTS ("
                                ." SELECT payment_log.user_id FROM payment_log"
                                ." WHERE " . implode(" AND ", $subWhere)
                                ." AND payment_log.is_cancel = 0"
                                ." AND payment_log.disable = 0"
                                ." AND payment_log.user_id = v_user_profile.user_id GROUP BY payment_log.user_id"
                                ." HAVING " . implode(" AND ", $subHaving) . ")";
                        $this->_contents["期間購入金額"] = $termsPayDatetime["from"] . " ～ " . $termsPayDatetime["to"] . "<br>" . $termsPay["from"] . " " . $termsPay["to"];
                    }
                    break;
                case 2 :
                case 3 :
                case 4 :
                case 5 :
                case 6 :
                    $subWhere[] = "payment_log.create_datetime  >= '"
                        . date("YmdHis", strtotime($this->datetimeParameter[$param["specify_terms_pay"]])) . "'";
                    $where[] = "EXISTS ("
                                ." SELECT payment_log.user_id FROM payment_log"
                                ." WHERE " . implode(" AND ", $subWhere)
                                ." AND payment_log.is_cancel = 0"
                                ." AND payment_log.disable = 0"
                                ." AND payment_log.user_id = v_user_profile.user_id GROUP BY payment_log.user_id"
                                ." HAVING " . implode(" AND ", $subHaving) . ")";
                    $this->_contents["期間購入金額"] = $this->_configOBJ->admin_config->specify_date_time_select->$param["specify_terms_pay"] . " ～" . "<br>" . $termsPay["from"] . " " . $termsPay["to"];
                    break;
                case 7 :
                    // 不等号に気をつける！
                    // 小さい値
                    if (ComValidation::isNumeric($param["terms_pay_time_from"])) {
                        $subWhere[] = "payment_log.create_datetime <= '" . date("YmdHis", strtotime("-" . $param["terms_pay_time_from"] . " hour")) . "'";
                        $termsPayDatetime["from"] = $param["terms_pay_time_from"] . "時間前以上";
                    }
                    // 大きい値
                    if (ComValidation::isNumeric($param["terms_pay_time_to"])) {
                        $subWhere[] = "payment_log.create_datetime > '" . date("YmdHis", strtotime("-" . $param["terms_pay_time_to"] . " hour")) . "'";
                        $termsPayDatetime["to"] = $param["terms_pay_time_to"] . "時間前未満";
                    }

                    if ($termsPayDatetime) {
                        $where[] = "EXISTS ("
                                ." SELECT payment_log.user_id FROM payment_log"
                                ." WHERE " . implode(" AND ", $subWhere)
                                ." AND payment_log.is_cancel = 0"
                                ." AND payment_log.disable = 0"
                                ." AND payment_log.user_id = v_user_profile.user_id GROUP BY payment_log.user_id"
                                ." HAVING " . implode(" AND ", $subHaving) . ")";
                        $this->_contents["期間購入金額"] = $termsPayDatetime["from"] . " " . $termsPayDatetime["to"] . "<br>" . $termsPay["from"] . " " . $termsPay["to"];
                    }
                    break;
                default :
                    break;
            }
        }

        //平均購入金額
        if(ComValidation::isNumeric($param["average_item_from"]) || ComValidation::isNumeric($param["average_item_to"])){
            if(ComValidation::isNumeric($param["average_item_from"])){
                $averageItem["from"] = $param["average_item_from"] . "円以上";
            }

            if(ComValidation::isNumeric($param["average_item_to"])){
                $averageItem["to"] = $param["average_item_to"] . "円まで";
            }

            if ($averageItem["from"]) {

                $where[] = "(v_user_profile.total_payment/v_user_profile.buy_count) >= " . $param["average_item_from"];

            }
            if ($averageItem["to"]) {

                $where[] = "(v_user_profile.total_payment/v_user_profile.buy_count) <= " . $param["average_item_to"];
            }

            if ($averageItem) {
                $this->_contents["平均購入金額"] = $averageItem["from"] . " " . $averageItem["to"];
            }

        }

        //最高購入金額
        if(ComValidation::isNumeric($param["expensive_item_from"]) || ComValidation::isNumeric($param["expensive_item_to"])){
            if(ComValidation::isNumeric($param["expensive_item_from"])){
                $expensiveItem["from"] = $param["expensive_item_from"] . "円以上";
            }

            if(ComValidation::isNumeric($param["expensive_item_to"])){
                $expensiveItem["to"] = $param["expensive_item_to"] . "円まで";
            }

            if ($expensiveItem["from"]) {
                $where[] = "exists(select * from ordering o ,ordering_detail od where o.id=od.ordering_id AND v_user_profile.user_id = o.user_id AND status in(".AdmOrdering::ORDERING_STATUS_PRE_COMPLETE.",".AdmOrdering::ORDERING_STATUS_COMPLETE.",".AdmOrdering::ORDERING_STATUS_REST.") group by v_user_profile.user_id having max(price) >= ".$param["expensive_item_from"]." )" ;
            }
            if ($expensiveItem["to"]) {
                $where[] = "exists(select * from ordering o ,ordering_detail od where o.id=od.ordering_id AND v_user_profile.user_id = o.user_id AND status in(".AdmOrdering::ORDERING_STATUS_PRE_COMPLETE.",".AdmOrdering::ORDERING_STATUS_COMPLETE.",".AdmOrdering::ORDERING_STATUS_REST.") group by v_user_profile.user_id having max(price) <= ".$param["expensive_item_to"]." )" ;
            }

            if ($expensiveItem) {
                $this->_contents["最高購入金額"] = $expensiveItem["from"] . " " . $expensiveItem["to"];
            }
        }

        //最低購入金額
        if(ComValidation::isNumeric($param["cheap_item_from"]) || ComValidation::isNumeric($param["cheap_item_to"])){
            if(ComValidation::isNumeric($param["cheap_item_from"])){
                $cheapItem["from"] = $param["cheap_item_from"] . "円以上";
            }

            if(ComValidation::isNumeric($param["cheap_item_to"])){
                $cheapItem["to"] = $param["cheap_item_to"] . "円まで";
            }

            if ($cheapItem["from"]) {
                $where[] = "exists(select * from ordering o ,ordering_detail od where o.id=od.ordering_id AND v_user_profile.user_id = o.user_id AND status in(".AdmOrdering::ORDERING_STATUS_PRE_COMPLETE.",".AdmOrdering::ORDERING_STATUS_COMPLETE.",".AdmOrdering::ORDERING_STATUS_REST.") group by v_user_profile.user_id having min(price) >= ".$param["cheap_item_from"]." )" ;
            }
            if ($cheapItem["to"]) {
                $where[] = "exists(select * from ordering o ,ordering_detail od where o.id=od.ordering_id AND v_user_profile.user_id = o.user_id AND status in(".AdmOrdering::ORDERING_STATUS_PRE_COMPLETE.",".AdmOrdering::ORDERING_STATUS_COMPLETE.",".AdmOrdering::ORDERING_STATUS_REST.") group by v_user_profile.user_id having min(price) <= ".$param["cheap_item_to"]." )" ;
            }

            if ($cheapItem) {
                $this->_contents["最低購入金額"] = $cheapItem["from"] . " " . $cheapItem["to"];
            }
        }

        //最頻値購入金額
        if(ComValidation::isNumeric($param["frequently_item_from"]) || ComValidation::isNumeric($param["frequently_item_to"])){
            $havingSqlFrom = "" ;
            $havingSqlTo = "" ;

            if(ComValidation::isNumeric($param["frequently_item_from"])){
                $frequentlyItem["from"] = $param["frequently_item_from"] . "円以上";
                $havingSqlFrom = " price >=".$param["frequently_item_from"] ." AND ";
            }

            if(ComValidation::isNumeric($param["frequently_item_to"])){
                $frequentlyItem["to"] = $param["frequently_item_to"] . "円まで";
                $havingSqlTo = " price <=".$param["frequently_item_to"] ." AND ";
            }

             $where[] = "exists("
                                   . "select o1.user_id from ordering o1,ordering_detail od1 "
                                   . "where v_user_profile.user_id =o1.user_id AND od1.ordering_id = o1.id AND o1.disable = 0 AND o1.is_cancel = 0 AND o1.is_paid = 1 AND o1.status in(".AdmOrdering::ORDERING_STATUS_PRE_COMPLETE.",".AdmOrdering::ORDERING_STATUS_COMPLETE.",".AdmOrdering::ORDERING_STATUS_REST.") AND od1.is_cancel = 0 AND od1.disable = 0 AND "
                                   . "exists( "
                                       . "select 'x' from ordering o2,ordering_detail od2 "
                                       . "where od1.price= od2.price AND o2.id=od2.ordering_id AND v_user_profile.user_id = o2.user_id "
                                       . "group by price "
                                       . "having  ".$havingSqlFrom.$havingSqlTo
                                       . " count(*) >= all(select count(*) from ordering o2,ordering_detail od2 where o2.id=od2.ordering_id AND v_user_profile.user_id = o2.user_id "
                                       . "group by price) "
                                       . ") group by o1.user_id order by o1.user_id "
                                   . ") " ;

            if ($frequentlyItem) {
                $this->_contents["最頻値購入金額"] = $frequentlyItem["from"] . " " . $frequentlyItem["to"];
            }
        }

        // 購入金額
        if(ComValidation::isNumeric($param["total_payment_from"]) || ComValidation::isNumeric($param["total_payment_to"])){

            if(ComValidation::isNumeric($param["total_payment_from"])){
                $totalPayment["from"] = $param["total_payment_from"] . "円以上";
            }

            if(ComValidation::isNumeric($param["total_payment_to"])){
                $totalPayment["to"] = $param["total_payment_to"] . "円まで";
            }

            if ($totalPayment["from"]) {

                $where[] = "v_user_profile.total_payment >= " . $param["total_payment_from"];

            }
            if ($totalPayment["to"]) {

                $where[] = "v_user_profile.total_payment <= " . $param["total_payment_to"];
            }

            if ($totalPayment) {
                $this->_contents["購入金額"] = $totalPayment["from"] . " " . $totalPayment["to"];
            }
        }

        // 購入回数
        if(ComValidation::isNumeric($param["buy_count_from"]) || ComValidation::isNumeric($param["buy_count_to"])){

            if(ComValidation::isNumeric($param["buy_count_from"])){
                $buyCount["from"] = $param["buy_count_from"] . "回以上";
            }

            if(ComValidation::isNumeric($param["buy_count_to"])){
                $buyCount["to"] = $param["buy_count_to"] . "回まで";
            }

            if ($buyCount["from"]) {

                $where[] = "v_user_profile.buy_count >= " . $param["buy_count_from"];

            }
            if ($buyCount["to"]) {

                $where[] = "v_user_profile.buy_count <= " . $param["buy_count_to"];
            }

            if ($buyCount) {
                $this->_contents["購入回数"] = $buyCount["from"] . " " . $buyCount["to"];
            }
        }

        // キャンセル回数
        if(ComValidation::isNumeric($param["cancel_count_from"]) || ComValidation::isNumeric($param["cancel_count_to"])){

            if(ComValidation::isNumeric($param["cancel_count_from"])){
                $cancelCount["from"] = $param["cancel_count_from"] . "回以上";
            }

            if(ComValidation::isNumeric($param["cancel_count_to"])){
                $cancelCount["to"] = $param["cancel_count_to"] . "回まで";
            }

            if ($cancelCount["from"]) {

                $where[] = "v_user_profile.cancel_count >= " . $param["cancel_count_from"];

            }
            if ($cancelCount["to"]) {

                $where[] = "v_user_profile.cancel_count <= " . $param["cancel_count_to"];
            }

            if ($cancelCount) {
                $this->_contents["キャンセル回数"] = $cancelCount["from"] . " " . $cancelCount["to"];
            }
        }

        /***********************************************************/
        /*** 以下、「月額コースID指定」⇒「月額コース」の順で処理***/
        /***********************************************************/

        //月額コースID(対象を抽出)
        if ($param["monthly_course_id"]) {
            // まず入力データチェック
            $inputId = "";
            // 末尾のカンマ削除(あれば)
            $param["monthly_course_id"] = rtrim($param["monthly_course_id"], ",");
            $inputId = explode(",", $param["monthly_course_id"]);
            foreach ($inputId as $key => $val) {
                if (!ComValidation::isNumeric($val) || !$val) {
                    $this->_errorMsg[] = "月額コースIDは数値のみ入力可能です。";
                    return false;
                }
            }

            // 対象を抽出
            $searchMonthlyCourseIdType = "";
            $searchMonthlyCourseIdType = "search_monthly_course_id_type";

            // 検索対象カラム
            $searchMonthlyCourseClm = "";
            $searchMonthlyCourseClm = "mcu.monthly_course_id";

            // 月額コースID
            $searchMonthlyCourseIdArray = "";
            $searchMonthlyCourseIdArray = explode(",",rtrim($param["monthly_course_id"], ","));

            // 月額コースID検索条件
            if ($param[$searchMonthlyCourseIdType] == 1) {

                // 初期値
                if (!$whereSqlString) {
                    $whereSqlString = "";
                }

                // 検索結果時の表示文言
                $searchResultString = "すべて";

                // AND検索
                foreach($searchMonthlyCourseIdArray as $key => $value){
                    $whereSqlString .= " AND FIND_IN_SET( '" . $value . "' , " . $searchMonthlyCourseClm . ")";
                }
            } else {
                // 検索結果時の表示文言
                $searchResultString = "いずれか";

                // OR検索(正規表現)
                $searchMonthlyCourseRegString = "";
                $searchMonthlyCourseRegString = "(" . implode("|",array_unique($searchMonthlyCourseIdArray)) . ")";
                $whereSqlString .= " AND " . $searchMonthlyCourseClm . " REGEXP '^" . $searchMonthlyCourseRegString . "\$|^".$searchMonthlyCourseRegString.",|,".$searchMonthlyCourseRegString."\$|,".$searchMonthlyCourseRegString.",'";
            }
            $this->_contents["月額コースID"] .= "『" . $param["monthly_course_id"] . "』" . $searchResultString . "を付与されている<br>";
        }

        //月額コースID(以外を抽出)
        if($param["except_monthly_course_id"]){
            // まず入力データチェック
            $inputId = "";
            // 末尾のカンマ削除(あれば)
            $param["except_monthly_course_id"] = rtrim($param["except_monthly_course_id"], ",");
            $inputId = explode(",", $param["except_monthly_course_id"]);
            foreach ($inputId as $key => $val) {
                if (!ComValidation::isNumeric($val) || !$val) {
                    $this->_errorMsg[] = "月額コースIDは数値のみ入力可能です。";
                    return false;
                }
            }
            // 以外を抽出
            $searchExceptMonthlyCourseIdType = "";
            $searchExceptMonthlyCourseIdType = "except_search_monthly_course_id_type";

            // 検索対象カラム
            $searchMonthlyCourseClm = "";
            $searchMonthlyCourseClm = "mcu.monthly_course_id";

            // 月額コースID
            $searchExceptMonthlyCourseIdArray = "";
            $searchExceptMonthlyCourseIdArray = explode(",",rtrim($param["except_monthly_course_id"], ","));

            // 月額コースID検索条件
            if ($param[$searchExceptMonthlyCourseIdType] == 1) {

                // 初期値
                if (!$whereSqlString) {
                    $whereSqlString = "";
                }

                // 検索結果時の表示文言
                $searchResultString = "すべて";

                // AND検索
                $whereSqlString = "";
                foreach($searchExceptMonthlyCourseIdArray as $key => $value){
                    $whereSqlString .= " AND NOT FIND_IN_SET( '" . $value . "' , " . $searchMonthlyCourseClm . ")";
                }
            } else {
                // 検索結果時の表示文言
                $searchResultString = "いずれか";

                // OR検索(正規表現)
                $searchMonthlyCourseRegString = "";
                $searchMonthlyCourseRegString = "(" . implode("|",array_unique($searchExceptMonthlyCourseIdArray)) . ")";
                $whereSqlString = " AND " . $searchMonthlyCourseClm . " NOT REGEXP '^" . $searchMonthlyCourseRegString . "\$|^".$searchMonthlyCourseRegString.",|,".$searchMonthlyCourseRegString."\$|,".$searchMonthlyCourseRegString.",'";
            }
            $this->_contents["月額コースID"] .= "『" . $param["except_monthly_course_id"] . "』" . $searchResultString . "を付与されている以外<br>";
        }

        // 付与月額更新用商品
        if (ComValidation::isNumeric($param["specify_monthly_update"])) {

            // 初期値
            if (!$whereSqlString) {
                $whereSqlString = "";
            }

            switch ($param["specify_monthly_update"]) {
                case 1 :
                    //「あり」を取得
                    $whereSqlString .= " AND mcu.is_monthly_update = 1";
                    $this->_contents["付与月額更新用商品"] .= "付与月額更新用商品あり<br>";
                    break;
                case 2 :
                    //「なし」を取得
                    $whereSqlString .= " AND mcu.is_monthly_update = 0";
                    $this->_contents["付与月額更新用商品"] .= "付与月額更新用商品なし<br>";
                    break;
                case 3 :
                    //付与月額更新用ID(対象を抽出)
                    if ($param["monthly_update_item_id"]) {
                        // まず入力データチェック
                        $inputId = "";
                        // 末尾のカンマ削除(あれば)
                        $param["monthly_update_item_id"] = rtrim($param["monthly_update_item_id"], ",");
                        $inputId = explode(",", $param["monthly_update_item_id"]);
                        foreach ($inputId as $key => $val) {
                            if (!ComValidation::isNumeric($val) || !$val) {
                                $this->_errorMsg[] = "月額更新用商品IDは数値のみ入力可能です。";
                                return false;
                            }
                        }

                        // 対象を抽出
                        $searchMonthlyUpdateItemIdType = "";
                        $searchMonthlyUpdateItemIdType = "search_monthly_update_item_id_type";

                        // 検索対象カラム
                        $searchMonthlyUpdateClm = "";
                        $searchMonthlyUpdateClm = "mcu.monthly_update_item_id";

                        // 月額更新用商品ID
                        $searchMonthlyUpdateItemIdArray = "";
                        $searchMonthlyUpdateItemIdArray = explode(",",rtrim($param["monthly_update_item_id"], ","));

                        // 月額更新用商品ID検索条件
                        if ($param[$searchMonthlyUpdateItemIdType] == 1) {

                            // 検索結果時の表示文言
                            $searchResultString = "すべて";

                            // AND検索
                            foreach($searchMonthlyUpdateItemIdArray as $key => $value){
                                $whereSqlString .= " AND FIND_IN_SET( '" . $value . "' , " . $searchMonthlyUpdateClm . ")";
                            }
                        } else {
                            // 検索結果時の表示文言
                            $searchResultString = "いずれか";

                            // OR検索(正規表現)
                            $searchMonthlyUpdateItemRegString = "";
                            $searchMonthlyUpdateItemRegString = "(" . implode("|",array_unique($searchMonthlyUpdateItemIdArray)) . ")";
                            $whereSqlString .= " AND " . $searchMonthlyUpdateClm . " REGEXP '^" . $searchMonthlyUpdateItemRegString . "\$|^".$searchMonthlyUpdateItemRegString.",|,".$searchMonthlyUpdateItemRegString."\$|,".$searchMonthlyUpdateItemRegString.",'";
                        }
                        $this->_contents["付与月額更新用商品ID"] .= "『" . $param["monthly_update_item_id"] . "』" . $searchResultString . "を付与されている<br>";
                    }

                    //月額更新用商品ID(以外を抽出)
                    if($param["except_monthly_update_item_id"]){
                        // まず入力データチェック
                        $inputId = "";
                        // 末尾のカンマ削除(あれば)
                        $param["except_monthly_update_item_id"] = rtrim($param["except_monthly_update_item_id"], ",");
                        $inputId = explode(",", $param["except_monthly_update_item_id"]);
                        foreach ($inputId as $key => $val) {
                            if (!ComValidation::isNumeric($val) || !$val) {
                                $this->_errorMsg[] = "月額更新用商品IDは数値のみ入力可能です。";
                                return false;
                            }
                        }
                        // 以外を抽出
                        $searchExceptMonthlyUpdateItemIdType = "except_search_monthly_update_item_id_type";


                        // 検索対象カラム
                        $searchMonthlyUpdateClm = "";
                        $searchMonthlyUpdateClm = "mcu.monthly_update_item_id";

                        // 月額コースID
                        $searchExceptMonthlyUpdateItemIdArray = "";
                        $searchExceptMonthlyUpdateItemIdArray = explode(",",rtrim($param["except_monthly_update_item_id"], ","));

                        // 月額コースID検索条件
                        if ($param[$searchExceptMonthlyUpdateItemIdType] == 1) {

                            // 検索結果時の表示文言
                            $searchResultString = "すべて";

                            // AND検索
                            $whereSqlString = "";
                            foreach($searchExceptMonthlyUpdateItemIdArray as $key => $value){
                                $whereSqlString .= " AND NOT FIND_IN_SET( '" . $value . "' , " . $searchMonthlyUpdateClm . ")";
                            }
                        } else {
                            // 検索結果時の表示文言
                            $searchResultString = "いずれか";

                            // OR検索(正規表現)
                            $searchMonthlyUpdateItemRegString = "";
                            $searchMonthlyUpdateItemRegString = "(" . implode("|",array_unique($searchExceptMonthlyUpdateItemIdArray)) . ")";
                            $whereSqlString = " AND " . $searchMonthlyUpdateClm . " NOT REGEXP '^" . $searchMonthlyUpdateItemRegString . "\$|^".$searchMonthlyUpdateItemRegString.",|,".$searchMonthlyUpdateItemRegString."\$|,".$searchMonthlyUpdateItemRegString.",'";
                        }
                        $this->_contents["付与月額更新用商品ID"] .= "『" . $param["except_monthly_update_item_id"] . "』" . $searchResultString . "を付与されている以外<br>";
                    }
                        break;
                    default :
                        break;
                    }
                }

        // ここで、「月額コース」を選択してなければ、上記SQL文を生成
        if (!$param["specify_monthly_course"] && $whereSqlString) {
            $where[] = "EXISTS ("
                ." SELECT mcu.user_id FROM monthly_course_user AS mcu"
                ." WHERE mcu.disable = 0"
                ." AND mcu.user_id = v_user_profile.user_id"
                . $whereSqlString
                ." GROUP BY mcu.user_id"
                .")";
        }

        // 付与月額コース
        if (ComValidation::isNumeric($param["specify_monthly_course"])) {

            // 初期値
            if (!$whereSqlString) {
                $whereSqlString = "";
            }

            switch ($param["specify_monthly_course"]) {
                case 1 :
                    //あり(期限中)を取得
                    $where[] = "EXISTS ("
                        ." SELECT mcu.user_id FROM monthly_course_user AS mcu"
                        ." WHERE mcu.limit_end_date >= DATE_FORMAT(NOW(), '%y-%m-%d')"
                        ." AND mcu.is_invalid = 0"
                        ." AND mcu.disable = 0"
                        . $whereSqlString
                        ." AND mcu.user_id = v_user_profile.user_id GROUP BY mcu.user_id)";

                    $this->_contents["月額コースID"] .= "月額コースあり(期限中)<br>";
                    break;
                case 2 :
                    //「あり(期限中：残り日数指定)」を取得
                    $whereString = "";
                    if (ComValidation::isNumeric($param["monthly_rest_date_from"]) || ComValidation::isNumeric($param["monthly_rest_date_to"])) {
                        if (ComValidation::isNumeric($param["monthly_rest_date_from"])) {
                            $whereString .= " AND mcu.limit_end_date >= DATE_ADD(DATE_FORMAT(NOW(), '%y-%m-%d'), interval " . $param["monthly_rest_date_from"] . " day)";
                            $this->_contents["月額コースID"] .= "月額コース残り期限『" . $param["monthly_rest_date_from"] . "』日以上<br>";
                        }
                        if (ComValidation::isNumeric($param["monthly_rest_date_to"])) {
                            $whereString .= " AND mcu.limit_end_date <= DATE_ADD(DATE_FORMAT(NOW(), '%y-%m-%d'), interval " . $param["monthly_rest_date_to"] . " day)";
                            $this->_contents["月額コースID"] .= "月額コース残り期限『" . $param["monthly_rest_date_to"] . "』日まで<br>";
                        }

                        $where[] = "EXISTS ("
                            ." SELECT mcu.user_id FROM monthly_course_user AS mcu"
                            ." WHERE mcu.limit_end_date >= DATE_FORMAT(NOW(), '%y-%m-%d')"
                            .$whereString
                            ." AND mcu.is_invalid = 0"
                            ." AND mcu.disable = 0"
                            . $whereSqlString
                            ." AND mcu.user_id = v_user_profile.user_id GROUP BY mcu.user_id)";
                    }

                    $this->_contents["月額コースID"] .= "月額コースあり(期限中)<br>";
                    break;
                case 3 :
                    //「あり(期限切れ)」を取得
                    $where[] = "NOT EXISTS ("
                        ." SELECT mcu.user_id FROM monthly_course_user AS mcu"
                        ." WHERE mcu.limit_end_date >= DATE_FORMAT(NOW(), '%y-%m-%d')"
                        ." AND mcu.is_invalid = 0"
                        ." AND mcu.disable = 0"
                        ." AND mcu.user_id = v_user_profile.user_id GROUP BY mcu.user_id)";
                    $where[] = "EXISTS ("
                        ." SELECT mcu.user_id FROM monthly_course_user AS mcu, monthly_course AS mc"
                        ." WHERE mcu.limit_end_date < DATE_FORMAT(NOW(), '%y-%m-%d')"
                        ." AND mc.id = mcu.monthly_course_id"
                        ." AND mcu.is_invalid = 0"
                        ." AND mcu.disable = 0"
                        ." AND mc.disable = 0"
                        ." AND NOT EXISTS ( "
                        ."     SELECT mcu2.user_id FROM monthly_course_user AS mcu2, monthly_course AS mc2"
                        ."     WHERE mcu2.limit_end_date >= DATE_FORMAT(NOW(), '%y-%m-%d')"
                        ."     AND mcu2.monthly_course_id = mcu.monthly_course_id"
                        ."     AND mc2.id = mcu2.monthly_course_id"
                        ."     AND mcu2.is_invalid = 0"
                        ."     AND mcu2.disable = 0"
                        ."     AND mc2.disable = 0"
                        ."     AND mcu2.user_id = v_user_profile.user_id GROUP BY mcu2.user_id"
                        ."     ) "
                        ." AND mcu.user_id = v_user_profile.user_id GROUP BY mcu.user_id)";



                    $this->_contents["月額コースID"] .= "月額コースあり(期限切れ)";
                    break;
                case 4 :
                    //「あり」を取得(他の指定なし※「無効」も含む)
                    $where[] = "EXISTS ("
                        ." SELECT mcu.user_id FROM monthly_course_user AS mcu"
                        ." WHERE mcu.disable = 0"
                        . $whereSqlString
                        ." AND mcu.user_id = v_user_profile.user_id GROUP BY mcu.user_id)";

                    $this->_contents["月額コースID"] .= "月額コースあり<br>";
                    break;
                case 5 :
                    //「なし」を取得
                    $where[] = "NOT EXISTS ("
                        ." SELECT mcu.user_id FROM monthly_course_user AS mcu"
                        ." WHERE mcu.disable = 0"
                        . $whereSqlString
                        ." AND mcu.user_id = v_user_profile.user_id GROUP BY mcu.user_id)";
                    $this->_contents["月額コースID"] .= "月額コースなし<br>";
                    break;
                default :
                    break;
            }
        }

        // 通常メール回数
        if(ComValidation::isNumeric($param["mail_count_from"]) || ComValidation::isNumeric($param["mail_count_from"])){

            if(ComValidation::isNumeric($param["mail_count_from"])){
                $mailCount["from"] = $param["mail_count_from"] . "回以上";
            }

            if(ComValidation::isNumeric($param["mail_count_to"])){
                $mailCount["to"] = $param["mail_count_to"] . "回まで";
            }

            if ($mailCount["from"] AND $mailCount["to"]) {

                $havingString = "count(*) >=" .$param["mail_count_from"]." AND count(*) <=".$param["mail_count_to"] ;

            } else if($mailCount["from"] ){

                $havingString = "count(*) >=" .$param["mail_count_from"] ;

            } else if($mailCount["to"] ){

                $havingString = "count(*) <=" .$param["mail_count_to"] ;

            }

            $where[] = "exists(select 'x' from mailmagazine_send_log msl,mailmagazine_log ml where msl.disable = 0 AND  ml.disable = 0 AND msl.mailmagazine_log_id = ml.id  AND v_user_profile.user_id = msl.user_id group by user_id having ".$havingString.")" ;


            if ($mailCount) {
                $this->_contents["通常メール回数"] = $mailCount["from"] . " " . $mailCount["to"];
            }
        }

        // 予約メール回数
        if(ComValidation::isNumeric($param["mail_reserve_count_from"]) || ComValidation::isNumeric($param["mail_reserve_count_to"])){

            if(ComValidation::isNumeric($param["mail_reserve_count_from"])){
                $mailReserveCount["from"] = $param["mail_reserve_count_from"] . "回以上";
            }

            if(ComValidation::isNumeric($param["mail_reserve_count_to"])){
                $mailReserveCount["to"] = $param["mail_reserve_count_to"] . "回まで";
            }

            if ($mailReserveCount["from"] AND $mailReserveCount["to"]) {

                $havingString = "count(*) >=" .$param["mail_reserve_count_from"]." AND count(*) <=".$param["mail_reserve_count_to"] ;

            } else if($mailReserveCount["from"] ){

                $havingString = "count(*) >=" .$param["mail_reserve_count_from"] ;

            } else if($mailReserveCount["to"] ){

                $havingString = "count(*) <=" .$param["mail_reserve_count_to"] ;

            }

            $where[] = "exists(select 'x' from mailmagazine_send_log msl,mailmagazine_log ml where msl.disable = 0 AND  ml.disable = 0 AND msl.mailmagazine_log_id_reserve = ml.id  AND v_user_profile.user_id = msl.user_id group by user_id having ".$havingString.")" ;


            if ($mailReserveCount) {
                $this->_contents["予約メール回数"] = $mailReserveCount["from"] . " " . $mailReserveCount["to"];
            }
        }

        // 定期メール回数
        if(ComValidation::isNumeric($param["mail_regular_count_from"]) || ComValidation::isNumeric($param["mail_regular_count_to"])){

            if(ComValidation::isNumeric($param["mail_regular_count_from"])){
                $mailRegularCount["from"] = $param["mail_regular_count_from"] . "回以上";
            }

            if(ComValidation::isNumeric($param["mail_regular_count_to"])){
                $mailRegularCount["to"] = $param["mail_regular_count_to"] . "回まで";
            }

            if ($mailRegularCount["from"] AND $mailRegularCount["to"]) {

                $havingString = "count(*) >=" .$param["mail_regular_count_from"]." AND count(*) <=".$param["mail_regular_count_to"] ;

            } else if($mailRegularCount["from"] ){

                $havingString = "count(*) >=" .$param["mail_regular_count_from"] ;

            } else if($mailRegularCount["to"] ){

                $havingString = "count(*) <=" .$param["mail_regular_count_to"] ;

            }

            $where[] = "exists(select 'x' from mailmagazine_send_log msl,mailmagazine_log ml where msl.disable = 0 AND  ml.disable = 0 AND msl.mailmagazine_log_id_regular = ml.id  AND v_user_profile.user_id = msl.user_id group by user_id having ".$havingString.")" ;


            if ($mailRegularCount) {
                $this->_contents["定期メール回数"] = $mailRegularCount["from"] . " " . $mailRegularCount["to"];
            }
        }

        // 強行メール回数
        if(ComValidation::isNumeric($param["reverse_mail_status_count_from"]) || ComValidation::isNumeric($param["reverse_mail_status_count_to"])){

            if(ComValidation::isNumeric($param["reverse_mail_status_count_from"])){
                $reverseMailStatusCount["from"] = $param["reverse_mail_status_count_from"] . "回以上";
            }

            if(ComValidation::isNumeric($param["reverse_mail_status_count_to"])){
                $reverseMailStatusCount["to"] = $param["reverse_mail_status_count_to"] . "回まで";
            }

            if ($reverseMailStatusCount["from"]) {

                $where[] = "v_user_profile.reverse_mail_status_count >= " . $param["reverse_mail_status_count_from"];

            }
            if ($reverseMailStatusCount["to"]) {

                $where[] = "v_user_profile.reverse_mail_status_count <= " . $param["reverse_mail_status_count_to"];
            }

            if ($reverseMailStatusCount) {
                $this->_contents["強行メール回数"] = $reverseMailStatusCount["from"] . " " . $reverseMailStatusCount["to"];
            }
        }

        /** 媒体コード(対象を抽出) */
        if($param["media_cd"]){
            $mediaCdArray = "";
            $mediaCdArray = explode(",", $param["media_cd"]);
            foreach ($mediaCdArray as $key => $val) {
                $mediaCdArray[$key] = "v_user_profile.media_cd LIKE '" . $val . "'";
            }

            if ($param["search_media_cd_type"]) {
                // すべて含む
                $where[] = "(" . implode(" AND ", $mediaCdArray) . ")";

                $this->_contents["媒体コード"] .= "『" . $param["media_cd"] . "』すべて含む<br>";
            } else {
                // いずれか
                $where[] = "(" . implode(" OR ", $mediaCdArray) . ")";

                $this->_contents["媒体コード"] .= "『" . $param["media_cd"] . "』いずれか含む<br>";
            }
        }

        /** 媒体コード(以外を抽出) */
        if($param["except_media_cd"]){
            $mediaCdArray = "";
            $mediaCdArray = explode(",", $param["except_media_cd"]);
            foreach ($mediaCdArray as $key => $val) {
                $mediaCdArray[$key] = "v_user_profile.media_cd NOT LIKE '" . $val . "'";
            }

            if ($param["search_except_media_cd_type"]) {
                // すべて含む
                $where[] = "(" . implode(" AND ", $mediaCdArray) . ")";

                $this->_contents["媒体コード"] .= "『" . $param["except_media_cd"] . "』すべて含む以外<br>";
            } else {
                // いずれか
                $where[] = "(" . implode(" OR ", $mediaCdArray) . ")";

                $this->_contents["媒体コード"] .= "『" . $param["except_media_cd"] . "』いずれか含む以外<br>";
            }
        }

        // 管理ﾎﾞｯｸｽ
        if(ComValidation::isNumeric($param["admin_id"])){
            $where[] = "v_user_profile.admin_id = " . $param["admin_id"];

            // デフォルト管理ユーザー検索種別を調べる
            if (array_key_exists($param["admin_id"], AdmAdmin::$_searchArray)) {
                $this->_contents["管理ﾎﾞｯｸｽ"] = AdmAdmin::$_searchArray[$param["admin_id"]];
            } else {
                $AdmAdminOBJ = AdmAdmin::getInstance();
                $adminData = $AdmAdminOBJ->getData($param["admin_id"]);
                $this->_contents["管理ﾎﾞｯｸｽ"] = $adminData["name"];
            }
        }

        // サイト間登録
        if(ComValidation::isArray($param["regist_site"])){
            // サイト間登録
            $AdmRegistSiteOBJ = AdmRegistSite::getInstance();
            $registSiteList = $AdmRegistSiteOBJ->getListForSelect();

            // ２の累乗の１０進数の作成
            foreach ($param["regist_site"] as $val) {
                $searchRgistSite += pow (2, $val);
                $registSiteName[] = $registSiteList[$val];
            }

            // 未登録
            if ($param["specify_regist_site"] == 0) {
                $existParam = "NOT EXISTS";
                $this->_contents["管理サイト間登録"] = implode(" ", $registSiteName) . "に" . AdmRegistSite::$_specifyRegistSite[$param["specify_regist_site"]];
            // 登録済み
            } else {
                $existParam = "EXISTS";
                $this->_contents["管理サイト間登録"] = implode("か", $registSiteName) . "に" . AdmRegistSite::$_specifyRegistSite[$param["specify_regist_site"]];
            }

            $where[] = $existParam . " ("
                    ." SELECT regist_site_log.user_id FROM regist_site_log"
                    ." WHERE (CONV(regist_site_log.regist_site_data_id, 2, 10) & " . $searchRgistSite . ") > 0"
                    ." AND regist_site_log.disable = 0"
                    ." AND regist_site_log.user_id = v_user_profile.user_id)";
        }

        /* 住所あり、なし */
        if (ComValidation::isNumeric($param["address_detail"])) {
            $this->_contents["住所"] = $this->_configOBJ->admin_config->is_setting->$param["address_detail"];
            switch ($param["address_detail"]) {
                case 0 : // なし
                    $where[] = "NOT EXISTS ("
                            ." SELECT ad_dt.user_id FROM address_detail ad_dt"
                            ." WHERE ad_dt.disable = 0"
                            ." AND ad_dt.user_id = v_user_profile.user_id"
                            ." AND ad_dt.address != '')";
                    break;
                case 1 : // あり
                    $where[] = "EXISTS ("
                            ." SELECT ad_dt.user_id FROM address_detail ad_dt"
                            ." WHERE ad_dt.disable = 0"
                            ." AND ad_dt.user_id = v_user_profile.user_id"
                            ." AND ad_dt.address != '')";
                    break;
                default :
                    break;
            }
        }

        /* 銀行口座あり、なし */
        if (ComValidation::isNumeric($param["bank_detail"])) {
            $this->_contents["銀行口座"] = $this->_configOBJ->admin_config->is_setting->$param["bank_detail"];
            switch ($param["bank_detail"]) {
                case 0 : // なし
                    $where[] = "NOT EXISTS ("
                            ." SELECT ba_dt.user_id FROM bank_detail ba_dt"
                            ." WHERE ba_dt.disable = 0"
                            ." AND ba_dt.user_id = v_user_profile.user_id"
                            ." AND ba_dt.bank_name != '')";
                    break;
                case 1 : // あり
                    $where[] = "EXISTS ("
                            ." SELECT ba_dt.user_id FROM bank_detail ba_dt"
                            ." WHERE ba_dt.disable = 0"
                            ." AND ba_dt.user_id = v_user_profile.user_id"
                            ." AND ba_dt.bank_name != '')";
                    break;
                default :
                    break;
            }
        }

       /** 備考 */
       if($param["description"] != ""){
           $where[] = "v_user_profile.description LIKE '%" . $param["description"] . "%'";
           $this->_contents["備考"] = $param["description"];
       }

       /** user profile flag*/
       if($param["user_profile_flag_code"]){
       	    if($param['userProfileCodeFlagList']){
       	        foreach($param["user_profile_flag_code"] as $val){
       	             $userProfileFlagNameString .= $param['userProfileCodeFlagList'][$val] . " ";
       	        }
       	    } else {
       	    	foreach($param["user_profile_flag_code"] as $val){
       	    		$userProfileFlagNameString .= $val . " ";
       	    	}
       	    }
           $userProfileFlagString = implode(",",$param["user_profile_flag_code"]);
           $where[] = "v_user_profile.user_profile_flag in (".$userProfileFlagString.")" ;
           $this->_contents["ユーザー識別フラグ"] .= "『" . $userProfileFlagNameString . "』<br>";
       }

       if ($param['search_history']) {
           foreach ($param['search_history'] as $val) {
               $where[] = "v_user_profile.user_id NOT IN (". $val .")";
           }
       }
       return $where;
    }

    /**
     * ユーザー検索の条件内容の作成
     *
     * @return array 検索内容配列
     */
    public function getWhereContents() {

        return $this->_contents;
    }

    /**
     * ユーザー検索のsql文の取得
     *
     * @return string ユーザー検索sql文
     */
    public function getListSql() {
        return $this->_listSql;
    }

    /**
     * chkUserDataFromPcMailAddressメソッド
     *
     * 重複PCメールアドレスのチェック
     *
     * @param  string $mailAddress メールアドレス
     * @param  integer $userId ユーザーID
     * @return array $data データ
     */
    public function chkUserDataFromPcMailAddress ($mailAddress, $userId = null) {

        if (!$mailAddress) {
            return false;
        }

        $columnArray[] = "*";
        if ($userId) {
            $whereArray[] = "user_id != " . $userId;
        }
        $whereArray[] = "pc_address = '" . $mailAddress . "'";
        $whereArray[] = "regist_status NOT IN (" . $this->_configOBJ->define->USER_REGIST_STATUS_MEMBER_QUIT . ")";
        $whereArray[] = "user_disable = 0";

        $otherArray[] = "ORDER BY user_id DESC";

        $sql = $this->makeSelectQuery("v_user_profile", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return false;
        }

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     * chkUserDataFromMbMailAddressメソッド
     *
     * 重複MBメールアドレスのチェック
     *
     * @param  string $mailAddress メールアドレス
     * @param  integer $userId ユーザーID
     * @return array $data データ
     */
    public function chkUserDataFromMbMailAddress ($mailAddress, $userId = null) {

        if (!$mailAddress) {
            return false;
        }

        $columnArray[] = "*";
        if ($userId) {
            $whereArray[] = "user_id != " . $userId;
        }
        $whereArray[] = "mb_address = '" . $mailAddress . "'";
        $whereArray[] = "regist_status NOT IN (" . $this->_configOBJ->define->USER_REGIST_STATUS_MEMBER_QUIT . ")";
        $whereArray[] = "user_disable = 0";

        $otherArray[] = "ORDER BY user_id DESC";

        $sql = $this->makeSelectQuery("v_user_profile", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return false;
        }

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * 重複ログインIDのチェック
     *
     * @param  string $loginId ログインID
     * @param  integer $userId ユーザーID
     * @return array $data データ
     */
    public function chkUserDataFromLoginId ($loginId, $userId = null) {

        if (!$loginId) {
            return false;
        }

        $columnArray[] = "*";
        if ($userId) {
            $whereArray[] = "user_id != " . $userId;
        }
        $whereArray[] = "login_id = '" . $loginId . "'";
        $whereArray[] = "regist_status != " . $this->_configOBJ->define->USER_REGIST_STATUS_MEMBER_QUIT ;
        $whereArray[] = "user_disable = 0";

        $otherArray[] = "ORDER BY user_id DESC";

        $sql = $this->makeSelectQuery("v_user_profile", $columnArray, $whereArray, $otherArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     * ユーザー検索条件データの取得
     *
     * @param  integer $id ユーザーID
     * @return array ユーザーデータ
     */
    public function getUserSearchConditionData($id) {

        if (!$id) {
            return false;
        }

        $columnArray[] = "*";

        $whereArray[] = "id = " . $id;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("user_search_conditions", $columnArray, $whereArray);

        // ユーザー検索情報の取得
        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;
    }

    /**
     * ユーザー検索条件リストの取得
     *
     * @param  array $param パラメーター
     * @param  integer $offset オフセット
     * @param  string $order 表示順
     * @param  integer $limit 表示件数
     * @return array ユーザーデータ
     */
    public function getUserSearchConditionList($param = null, $offset = null, $order = "id DESC", $limit = null) {

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "disable = 0";

        if (ComValidation::isNumeric($param["id"])) {
            $whereArray[] = "id = " . $param["id"];
        }

        if (ComValidation::isNumeric($param["category_id"])) {
            $whereArray[] = "search_conditions_category_id = " . $param["category_id"];
        }

        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }
        if (ComValidation::isNumeric($offset)) {
            $otherArray[] = " LIMIT ". $offset . ", " . $limit;
        }

        $sql = $this->makeSelectQuery("user_search_conditions", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return false;
        }

        // データリスト取得
        $dataList = $dbResultOBJ->fetchAll();

        return $dataList;
    }

    /**
     * ユーザー検索条件の登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertUserSearchConditionData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("user_search_conditions", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * ユーザー検索条件の更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateUserSearchConditionData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("user_search_conditions", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * ユーザー検索条件カテゴリーリストの取得
     *
     * @return array データ配列
     */
    public function getUserSearchConditionsCategoryList() {

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("user_search_conditions_category", $columnArray, $whereArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;
    }

    /**
     *
     * ユーザー検索条件カテゴリーデータの取得
     *
     * @param  int $keyConvertCategoryId ユーザー検索条件カテゴリーID
     * @return array $data データ配列
     */
    public function getUserSearchConditionsCategoryData($categoryId) {

        if (!is_numeric($categoryId)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "id = " . $categoryId;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("user_search_conditions_category", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * selectbox用ユーザー検索条件カテゴリーコードリストの取得
     *
     * @return array $dataArray データ配列
     */
    public function getUserSearchConditionsCategoryForSelect() {

        $columnArray[] = "*";

        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("user_search_conditions_category", $columnArray, $whereArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        while ($data = $this->fetch($dbResultOBJ)) {
            $dataArray[$data["id"]] = $data["name"];
        }

        return $dataArray;

    }


    /**
     * ユーザー検索条件の登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertUserSearchConditionsCategoryData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("user_search_conditions_category", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * ユーザー検索条件の更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateUserSearchConditionsCategoryData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("user_search_conditions_category", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * 銀行振込先リストの取得
     *
     * @param  array $param パラメーター
     * @return array ユーザーデータ
     */
    public function getBankDetailList($param) {

        if (!$param) {
            return false;
        }

        $columnArray[] = "SQL_CALC_FOUND_ROWS bank_detail.*";

        $whereArray = $this->setWhereString($param);
        $whereArray[] = "bank_detail.bank_name != ''";
        $whereArray[] = "bank_detail.user_id = v_user_profile.user_id";
        $whereArray[] = "bank_detail.disable = 0";

        $this->_listSql = $this->makeSelectQuery("v_user_profile, bank_detail", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($this->_listSql)) {
            return false;
        }

        // データリスト取得
        $dataList = $dbResultOBJ->fetchAll();

        return $dataList;
    }

    /**
     * 住所リストの取得
     *
     * @param  array $param パラメーター
     * @return array ユーザーデータ
     */
    public function getAddressDetailList($param) {

        if (!$param) {
            return false;
        }

        $columnArray[] = "SQL_CALC_FOUND_ROWS address_detail.*";

        $whereArray = $this->setWhereString($param);
        $whereArray[] = "address_detail.address != ''";
        $whereArray[] = "address_detail.user_id = v_user_profile.user_id";
        $whereArray[] = "address_detail.disable = 0";

        $this->_listSql = $this->makeSelectQuery("v_user_profile, address_detail", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($this->_listSql)) {
            return false;
        }

        // データリスト取得
        $dataList = $dbResultOBJ->fetchAll();

        return $dataList;
    }

    /**
     * 貢献金額リストの取得
     *
     * @param  array $param パラメーター
     * @return array ユーザーデータ
     */
    public function getPayAmountCsvList($param) {

        if (!$param) {
            return false;
        }

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray = $this->setWhereString($param);
        $otherArray[] = " ORDER BY user_id ASC";
        $this->_listSql = $this->makeSelectQuery("v_user_profile", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($this->_listSql)) {
            return false;
        }

        // データリスト取得
        $dataList = $dbResultOBJ->fetchAll();

        return $dataList;
    }

    /**
     * コンバート用CSVファイルの取得
     *
     * @param  array $param パラメーター
     * @return array ユーザーデータ
     */
    public function getConvertCsvList($param) {

        if (!$param) {
            return false;
        }

        $columnArray[] = "SQL_CALC_FOUND_ROWS *, " .
                            "CASE" .
                            " WHEN regist_status=0 THEN 2" .
                            " WHEN regist_status=1 THEN 1" .
                            " WHEN regist_status=2 THEN 3" .
                            " ELSE 4" .
                            " END order_regist_status"; // 登録ステータスでソート(優：本登録>仮登録>退会：劣)

        $whereArray = $this->setWhereString($param);

        //$whereArray[] = "v_user_profile.media_cd != 'te20001'";
        //$whereArray[] = "v_user_profile.media_cd NOT LIKE 'te%'";
        //$whereArray[] = "v_user_profile.media_cd NOT LIKE 'tc%'";
        //$whereArray[] = "v_user_profile.media_cd NOT LIKE 'zf%'";

        $mailChangeSql = " NOT EXISTS(SELECT * FROM mail_address_change";
        $mailChangeSql.= " WHERE `create_datetime` >= SUBDATE(DATE_FORMAT(NOW(), '%y%m%d235959'), interval 30 day)";
        $mailChangeSql.= " AND `disable` = '1'";
        $mailChangeSql.= " AND mail_address_change.user_id = v_user_profile.user_id)";

        $whereArray[] = $mailChangeSql;

        $otherArray[] = " ORDER BY order_regist_status";

        $this->_listSql = $this->makeSelectQuery("v_user_profile", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($this->_listSql)) {
            return false;
        }

        // データリスト取得
        $dataList = $dbResultOBJ->fetchAll();

        return $dataList;
    }

    /**
     *
     * @param array $param
     * @return int
     * @author van_don
     */
    public function getNumberOfUserByParams($param) {

        if (!$param) {
            return false;
        }

        $columnArray[] = "count(*) as 'total'";

        $whereArray = $this->setWhereString($param);

        $this->_listSql = $this->makeSelectQuery("v_user_profile", $columnArray, $whereArray);
        if (!$dataList = $this->executeQuery($this->_listSql, "fetchRow")) {
            return 0;
        }
        return $dataList['total'];
    }

    public function reset_search_contents() {
        $this->_contents = '';
    }
}

?>
