<?php
/**
 * InfomationStatus.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * ユーザー側 情報データの管理を行うクラス。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa hosoda
 */

class InformationStatus extends ComCommon implements InterfaceInformation {

    /** 情報表示チェック用配列 (この配列データ以外はログイン前では表示出来ない)*/
    public static $_prePermissionDisplayPosition = array(
            self::DISPLAY_POSITION_PC_PRE_TOP_CAMP,
            self::DISPLAY_POSITION_PRE_FREE_INFORMATION,
            self::DISPLAY_POSITION_PC_PRE_SIDE_INFORMATION
        );

    /** @var string エラーメッセージ */
    protected $_errorMsg = null;

    /** @var object インスタンスを保持するstatic変数 */
    protected static $_instance = null;

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
     * エラーメッセージの取得
     *
     * @return $_errorMsg
     */
    public function getErrorMsg() {

        return $this->_errorMsg;
    }

    /**
     * getInformationStatusPreviewDataメソッド
     *
     * プレビュー用の情報表示条件の取得
     *
     * @param  array $param 情報ID配列
     * @return array data   商品データ
     */
    public function getInformationStatusPreviewData($param) {

        // 引数が不正ならFALSE
        if (!is_array($param)) {
            return FALSE;
        }

        // IDのパラメータによって抽出条件、参照テーブル決定
        if ($param["itid"]) {
            $columnArray[] = "*";

            $whereArray[] = "id = " . $param["itid"];
            $whereArray[] = "disable = 0";

            $tableName = "information_template";
        } elseif ($param["isid"]) {
            $columnArray[] = "ims.*";

            $whereArray[] = "ims.id = " . $param["isid"];
            $whereArray[] = "ims.disable = 0";
            $whereArray[] = "imdp.disable = 0";
            $whereArray[] = "ic.disable = 0";
            $whereArray[] = "ic.id = ims.information_category_id";
            $whereArray[] = "ims.information_category_id = imdp.information_category_id";

        $tableName = "information_status AS ims, information_display_position AS imdp, information_category AS ic";
        } else {
            return FALSE;
        }

        $sql = $this->makeSelectQuery($tableName, $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }


        return $data;

    }

    /**
     * getPostInformationStatusDataメソッド
     *
     * ログイン前後共通 情報データの取得
     *
     * @param  array $searchAry 情報表示条件キー
     * @param  array   userData       ユーザデータ
     * @param  boolean TRUE=ログイン前 FALSE=ログイン後
     * @return array   data           商品データ
     */
    public function getInformationStatusData($searchAry, $userData, $isPreAccess = FALSE) {

        // 引数が不正ならFALSE(ログイン後はユーザーデータ必要)
        if (!is_array($searchAry) || (!$isPreAccess && !is_array($userData))) {
            return FALSE;
        }

        $columnArray[] = "ims.*";
        $columnArray[] = "imdp.cd";

        // 検索条件(入金状態)設定(ログイン後のみ)
        if (!$isPreAccess) {
            if ($userData["total_payment"] > 0) {
                $userData["pay_status"] = self::PAY_STATUS_NOT_PAY;
            } else {
                $userData["pay_status"] = self::PAY_STATUS_PAY;
            }
            $whereArray[] = "ims.payment_status != " . $userData["pay_status"];
        }

        if ($searchAry["isid"]) {
            $whereArray[] = "ims.access_key = '" . $searchAry["isid"] . "'";
        } elseif ($searchAry["id"]) {
            $whereArray[] = "ims.id = '" . $searchAry["id"] . "'";
        }

        $whereArray[] = "ims.is_display = 1";
        $whereArray[] = "ic.is_display = 1";
        $whereArray[] = "imdp.is_display = 1";
        $whereArray[] = "(ims.display_start_datetime <= '" . date("Y-m-d H:i:s") . "' OR ims.display_start_datetime = '0000-00-00 00:00:00')";
        $whereArray[] = "(ims.display_end_datetime >= '" . date("Y-m-d H:i:s") . "' OR ims.display_end_datetime = '0000-00-00 00:00:00')";
        $whereArray[] = "ims.disable = 0";
        $whereArray[] = "imdp.disable = 0";
        $whereArray[] = "ic.disable = 0";

        $whereArray[] = "ic.id = ims.information_category_id";
        $whereArray[] = "ims.information_category_id = imdp.information_category_id";

        $sql = $this->makeSelectQuery("information_status AS ims, information_display_position AS imdp, information_category AS ic", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        // 情報表示条件チェック(ログイン後のみ)
        if (!$isPreAccess) {
            if (!$this->informationDisplayConditionCheck($data, $userData)) {
                return FALSE;
            }
        }

        // 情報の閲覧の可否をチェック
        if ($isPreAccess) {
            if (!$this->chkInformationDisplay($data["information_category_id"])) {
                return FALSE;
            }
        }

        return $data;

    }

    /**
     * getInformationStatusListメソッド
     *
     * 情報リストの取得
     *
     * @param integer $infoCategoryId 情報表示フォルダId
     * @param array   $userData           ユーザデータ
     * @param array   $convertAry         ％変換情報配列
     * @return array  $data 情報一覧
     */
    public function getInformationStatusList($infoCategoryId, $userData, $isPreAccess = FALSE) {

        // 引数が不正ならFALSE
        if ((!$isPreAccess && !is_array($userData)) || !isset($infoCategoryId)) {
            return FALSE;
        }

        $columnArray[] = "SQL_CALC_FOUND_ROWS ims.*";

        $whereArray[] = "ic.id = ims.information_category_id";
        $whereArray[] = "ims.information_category_id = imdp.information_category_id";

        $whereArray[] = "ims.information_category_id = " . $infoCategoryId;

        // 検索条件(入金状態)設定(ログイン後のみ)
        if (!$isPreAccess) {
            if ($userData["total_payment"] > 0) {
                $userData["pay_status"] = self::PAY_STATUS_NOT_PAY;
            } else {
                $userData["pay_status"] = self::PAY_STATUS_PAY;
            }
            $whereArray[] = "ims.payment_status != " . $userData["pay_status"];
        }

        $whereArray[] = "imdp.is_display = 1";
        $whereArray[] = "ims.is_display = 1";
        $whereArray[] = "ic.is_display = 1";
        $whereArray[] = "(ims.display_start_datetime <= '" . date("Y-m-d H:i:s") . "' OR ims.display_start_datetime = '0000-00-00 00:00:00')";
        $whereArray[] = "(ims.display_end_datetime >= '" . date("Y-m-d H:i:s") . "' OR ims.display_end_datetime = '0000-00-00 00:00:00')";
        $whereArray[] = "ims.disable = 0";
        $whereArray[] = "imdp.disable =0" ;
        $whereArray[] = "ic.disable =0" ;

        $otherArray[] = "GROUP BY ims.id";
        $otherArray[] = "ORDER BY ims.sort_seq DESC, ims.id DESC";

        $sql = $this->makeSelectQuery("information_status AS ims, information_display_position AS imdp, information_category AS ic", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $dbResultOBJ->fetchAll();

        // 情報表示条件チェック(表示条件クリアしてるデータのみ抽出)(ログイン後のみ)
        if (!$isPreAccess) {
            $infoDataList = array();
            foreach ($dataList as $key => $val) {
                if ($this->informationDisplayConditionCheck($val, $userData)) {
                    $infoDataList[] = $val;
                }
            }
        } else {
            // 初期化
            $infoDataList = array();
            $infoDataList = $dataList;
        }

        return $infoDataList;

    }

    /**
     * informationKeyConvertメソッド
     *
     * 情報データのコンバート処理
     *
     * @param  array   $dataArray       情報データ
     * @param  array   $userData        ユーザデータ
     * @param  boolean $isMobile        モバイルアクセス TRUE:モバイル FALSE:PC
     * @param  string  $infoHtmlTextKey コンバート対象情報HTMLキー名
     * @param  integer $isPreAccess     ログイン前フラグ
     * @param  array   $convertAry      コンバートデータ
     *
     * @return array   $data        コンバートされた情報データ
     */
    public function informationKeyConvert($dataArray, $userData, $isMobile, $infoHtmlTextKey = "", $isPreAccess = FALSE, $convertAry = "") {

        // 引数が不正ならFALSE(ログイン後はユーザーデータ必要)
        if (!is_array($dataArray) || (!$isPreAccess && !is_array($userData))) {
            return FALSE;
        }

        //%変換クラスのインスタンス生成
        $KeyConvOBJ = KeyConvert::getInstance();

        //情報アクセスログクラスのインスタンス生成
        $InfoStatusLogOBJ = InformationStatusLog::getInstance();

        //情報の未読/既読で変更(ログイン後のみ)
        if (!$isPreAccess) {
            if ($InfoStatusLogOBJ->isAccessed($dataArray["id"], $userData["user_id"])) {
                $convertAry["-%link_flag-"] = 1;
            } else {
                $convertAry["-%link_flag-"] = 0;
            }
        }

        if($dataArray["user_bank_data"]){
            $convertAry["-%u_bank-"] = $dataArray["user_bank_data"]["bank_name"] ;
            $convertAry["-%u_b_code-"] = $dataArray["user_bank_data"]["bank_code"] ;
            $convertAry["-%u_b_branch-"] = $dataArray["user_bank_data"]["branch_name"] ;
            $convertAry["-%u_b_branchcode-"] = $dataArray["user_bank_data"]["branch_code"] ;
            $convertAry["-%u_b_classification-"] = $dataArray["user_bank_data"]["type"] ;
            $convertAry["-%u_b_number-"] = $dataArray["user_bank_data"]["account_number"] ;
            $convertAry["-%u_b_registered_stockholder-"] = $dataArray["user_bank_data"]["name"] ;
        }

        if($dataArray["user_address_data"]){
            $convertAry["-%u_postcode-"] = $dataArray["user_address_data"]["postal_code"] ;
            $convertAry["-%u_address-"] = $dataArray["user_address_data"]["address"] ;
            $convertAry["-%u_name-"] = $dataArray["user_address_data"]["name"] ;
            $convertAry["-%u_telephone_number-"] = $dataArray["user_address_data"]["phone_number"] ;
        }

        //％変換処理 フリーワード
        if(count($dataArray["user_free_word_data"])){
            foreach($dataArray["user_free_word_data"] as $val){
                $valFreeWord = 0 ;
                if($val["free_word_type"] == 2){
                    $valFreeWord = $val["free_word_text"] ;
                } else {
                    $valFreeWord = $val["free_word_value"] ;
                }
                $convertAry["-%free_word_".$val["free_word_type"]."_".$val["free_word_cd"]."-"] = $valFreeWord;
            }
        }

        // ％変換処理 情報アクセスキー
        $convertAry["-%my_info_access_key-"] = $dataArray["access_key"];

        // ％変換処理 消費ポイント
        $convertAry["-%info_point-"] = $dataArray["point"];

        // ％変換処理 付与ポイント
        $convertAry["-%bonus_info_point-"] = $dataArray["bonus_point"];

        if ($infoHtmlTextKey) {
            // バナー表示情報 or 詳細情報
            if ($dataArray[$infoHtmlTextKey]) {
                $dataArray[$infoHtmlTextKey] = $KeyConvOBJ->execConvert(htmlspecialchars_decode($dataArray[$infoHtmlTextKey], ENT_QUOTES), $userData["user_id"], $convertAry);
            }
        } else {
            // 両方

            // アクセス端末でコンバート対象データ切り分け(MB or PC)
            if ($isMobile) {
                $infoHtmlTextBannerKey = self::INFORMAITON_HTML_TEXT_BANNER_MB;
                $infoHtmlTextKey = self::INFORMAITON_HTML_TEXT_MB;
            } else {
                $infoHtmlTextBannerKey = self::INFORMAITON_HTML_TEXT_BANNER_PC;
                $infoHtmlTextKey = self::INFORMAITON_HTML_TEXT_PC;
            }

            // バナー表示情報
            if ($dataArray[$infoHtmlTextBannerKey]) {
                $dataArray[$infoHtmlTextBannerKey] = $KeyConvOBJ->execConvert(htmlspecialchars_decode($dataArray[$infoHtmlTextBannerKey], ENT_QUOTES), $userData["user_id"], $convertAry);
            }
            // 詳細情報
            if ($dataArray[$infoHtmlTextKey]) {
                $dataArray[$infoHtmlTextKey] = $KeyConvOBJ->execConvert(htmlspecialchars_decode($dataArray[$infoHtmlTextKey], ENT_QUOTES), $userData["user_id"], $convertAry);
            }

        }

        return $dataArray;
    }

    /**
     * makeInformationConvertKeyメソッド
     *
     * 情報データコンバート用変換キーの生成
     *
     *
     * @param  array   $dataArray   情報データ
     * @param  array   $userData    ユーザデータ
     * @param  array   $infoDataLog 情報データログ
     *
     * @return array   $convertAry  生成された変換対象キーデータ(配列)
     */
    public function makeInformationConvertKey($dataArray, $infoDataLog = "", $convertAry = "") {

        // 引数が不正ならFALSE
        if (!is_array($dataArray)) {
            return FALSE;
        }

        //%変換クラスのインスタンス生成
        $KeyConvOBJ = KeyConvert::getInstance();

        //情報アクセスログクラスのインスタンス生成
        $InfoStatusLogOBJ = InformationStatusLog::getInstance();

        // 初期化
        $convertAry = "";

        //情報の未読/既読で変更(ログイン後のみ)
        if ($infoDataLog) {
            if (in_array($dataArray["id"], $infoDataLog)) {
                $convertAry["-%link_flag-"] = 1;
            } else {
                $convertAry["-%link_flag-"] = 0;
            }
        }

        if($dataArray["user_bank_data"]){
            $convertAry["-%u_bank-"] = $dataArray["user_bank_data"]["bank_name"] ;
            $convertAry["-%u_b_code-"] = $dataArray["user_bank_data"]["bank_code"] ;
            $convertAry["-%u_b_branch-"] = $dataArray["user_bank_data"]["branch_name"] ;
            $convertAry["-%u_b_branchcode-"] = $dataArray["user_bank_data"]["branch_code"] ;
            $convertAry["-%u_b_classification-"] = $dataArray["user_bank_data"]["type"] ;
            $convertAry["-%u_b_number-"] = $dataArray["user_bank_data"]["account_number"] ;
            $convertAry["-%u_b_registered_stockholder-"] = $dataArray["user_bank_data"]["name"] ;
        }

        if($dataArray["user_address_data"]){
            $convertAry["-%u_postcode-"] = $dataArray["user_address_data"]["postal_code"] ;
            $convertAry["-%u_address-"] = $dataArray["user_address_data"]["address"] ;
            $convertAry["-%u_name-"] = $dataArray["user_address_data"]["name"] ;
            $convertAry["-%u_telephone_number-"] = $dataArray["user_address_data"]["phone_number"] ;
        }

        //％変換処理 フリーワード
        if(count($dataArray["user_free_word_data"])){
            foreach($dataArray["user_free_word_data"] as $val){
                $valFreeWord = 0 ;
                if($val["free_word_type"] == 2){
                    $valFreeWord = $val["free_word_text"] ;
                } else {
                    $valFreeWord = $val["free_word_value"] ;
                }
                $convertAry["-%free_word_".$val["free_word_type"]."_".$val["free_word_cd"]."-"] = $valFreeWord;
            }
        }

        // ％変換処理 情報アクセスキー
        $convertAry["-%my_info_access_key-"] = $dataArray["access_key"];

        // ％変換処理 消費ポイント
        $convertAry["-%info_point-"] = $dataArray["point"];

        // ％変換処理 付与ポイント
        $convertAry["-%bonus_info_point-"] = $dataArray["bonus_point"];

        return $convertAry;
    }

    /**
     * getInformationDataForConvertメソッド
     *
     * コンバートする情報HTMLデータの取得
     *
     *
     * @param  array   $dataArray       情報データ
     * @param  boolean $isMobile        モバイルアクセス TRUE:モバイル FALSE:PC
     * @param  string  $processPageName アクセスページ名
     *
     * @return array   $convertData コンバート対象の情報データ(配列)
     */
    public function getInformationDataForConvert($dataArray, $isMobile, $convertKey = "") {

        // 引数が不正ならFALSE(ログイン後はユーザーデータ必要)
        if (!is_array($dataArray)) {
            return FALSE;
        }

        // 初期化
        $convertData = "";
        if ($dataArray[$convertKey]) {
            $convertData = htmlspecialchars_decode($dataArray[$convertKey], ENT_QUOTES);
        }

        return $convertData;
    }

    /**
     * informationListKeyConvertメソッド
     *
     * 情報リストの％変換処理を実施
     *
     * @param array   $contents   コンバート対象データ
     * @param integer $userId     ユーザーID
     * @param array   $convertAry %変換用配列(個別処理用)
     * @return array 変換済みメール要素配列
     */
    public function informationListKeyConvert($elements, $userId = "", $convertAry = "") {
        if (!isset($elements)) {
            return FALSE;
        }
        $KeyConvertOBJ = KeyConvert::getInstance();
        // 変換処理
        $elements = $KeyConvertOBJ->execConvertAllArray($elements, $userId, $convertAry);

        return $elements;
    }

    /**
     * informationDisplayConditionCheckメソッド
     *
     * 情報表示条件チェック処理
     *
     * @param  integer $data   情報データ
     * @param  integer $userId ユーザデータ
     * @return array   $data   表示条件に合った情報データ
     */
    public function informationDisplayConditionCheck($data, $userData) {

        // 引数が不正ならFALSE
        if (!is_array($data) || !is_array($userData)) {
            return FALSE;
        }

        //ユニットクラスのインスタンス生成
        $UnitOBJ = Unit::getInstance();

        //注文クラスのインスタンス生成
        $OrderingOBJ = Ordering::getInstance();

        /***************** [情報表示条件] **********************/
        /*  unit_id        = TRUE;  // ユニットID（表示）  */
        /*  except_unit_id = FALSE; // ユニットID（非表示）*/
        /*  item_id        = TRUE;  // 購入商品ID（表示）  */
        /*  except_item_id = FALSE; // 購入商品ID（非表示）*/
        /*******************************************************/

        //ユニットID（表示）チェック
        if ($data["unit_id"]) {
            // ユニットIDが「無ければ」情報閲覧不可
            if (!$UnitOBJ->isInUnitUser($userData["user_id"], $data["unit_id"])) {
                return FALSE;
            }
        }

        //ユニットID（非表示）チェック
        if ($data["except_unit_id"]) {
            // ユニットIDが「有れば」情報閲覧不可
            if ($UnitOBJ->isInUnitUser($userData["user_id"], $data["except_unit_id"])) {
                return FALSE;
            }
        }

        // 購入商品ID（表示）チェック
        if ($data["item_id"]) {
            // ユニットIDが「無ければ」情報閲覧不可
            if (!$OrderingOBJ->isBoughtItem($userData["user_id"], $data["item_id"])) {
                return FALSE;
            }
        }

        // 購入商品ID（非表示）チェック
        if ($data["except_item_id"]) {
            // ユニットIDが「有れば」情報閲覧不可
            if ($OrderingOBJ->isBoughtItem($userData["user_id"], $data["except_item_id"])) {
                return FALSE;
            }
        }

        // 検索条件保存ID(表示)※「AND検索→すべて該当する場合/OR検索→1つでも該当する場合」⇒ 表示
        if ($data["user_search_conditions_id"]) {

            // 管理用ユーザークラスのインスタンス生成
            $AdmUserOBJ = AdmUser::getInstance();
            $searchConditionAry = explode(",", $data["user_search_conditions_id"]);
            $searchConditionIdCount = count($searchConditionAry);

            foreach ($searchConditionAry as $val) {
                $searchSaveData = "";
                $searchValue = "";
                if ($searchSaveData = $AdmUserOBJ->getUserSearchConditionData($val)) {
                    $searchValue = unserialize($searchSaveData["search_condition"]);

                    $columnArray = "";
                    $whereArray = "";

                    $columnArray[] = "user_id";

                    $whereArray = $AdmUserOBJ->setWhereString($searchValue);
                    $whereArray[] = "user_id = " . $userData["user_id"];

                    $sql = $this->makeSelectQuery("v_user_profile", $columnArray, $whereArray);

                    // ユーザー検索情報の取得
                    if (!$this->executeQuery($sql, "fetchRow")) {
                        // 検索結果が取れてこなかった場合
                        if ($data["user_search_conditions_type"]) {
                            // AND検索(1つでも該当なしならFALSE)
                            return FALSE;
                        } else {
                            // OR検索(該当なしなら件数からマイナス)
                            $searchConditionIdCount --;
                        }
                    } else {
                        // 検索結果が取れてきた場合(OR検索)
                        if (!$data["user_search_conditions_type"]) {
                            // OR検索(1つでも該当したらループ抜ける)
                            break;
                        }
                    }
                }
            }
            // 検索条件IDに該当しない場合はFALSE
            if ($searchConditionIdCount == 0) {
                return FALSE;
            }
        }

        // 検索条件保存ID(非表示) ※「AND検索→すべて該当する場合/OR検索→1つでも該当する場合」⇒ 非表示
        if ($data["except_user_search_conditions_id"]) {
            // 管理用ユーザークラスのインスタンス生成
            $AdmUserOBJ = AdmUser::getInstance();
            $exceptSearchConditionAry = explode(",", $data["except_user_search_conditions_id"]);
            $exceptSearchConditionIdCount = count($exceptSearchConditionAry);

            foreach ($exceptSearchConditionAry as $val) {
                $searchSaveData = "";
                $searchValue = "";
                if ($searchSaveData = $AdmUserOBJ->getUserSearchConditionData($val)) {
                    $searchValue = unserialize($searchSaveData["search_condition"]);

                    $columnArray = "";
                    $whereArray = "";

                    $columnArray[] = "user_id";

                    $whereArray = $AdmUserOBJ->setWhereString($searchValue);
                    $whereArray[] = "user_id = " . $userData["user_id"];

                    $sql = $this->makeSelectQuery("v_user_profile", $columnArray, $whereArray);

                    // ユーザー検索情報の取得
                    if ($this->executeQuery($sql, "fetchRow")) {
                        // 検索結果が取れてきた場合
                        if ($data["except_user_search_conditions_type"]) {
                            // AND検索(「該当あり」なら件数からマイナス)
                            $exceptSearchConditionIdCount --;
                        } else {
                            // OR検索(「非表示」なので、1件でも「該当あり」ならFALSE)
                            return FALSE;
                        }
                    } else {
                        // 検索結果が取れてこない場合(AND検索)
                        if ($data["except_user_search_conditions_type"]) {
                            // AND検索(1件でも「該当なし」ならループ抜ける)
                            break;
                        }
                    }
                }
            }
            // AND検索の場合はすべて「該当あり」ならFALSE
            if ($exceptSearchConditionIdCount == 0) {
                return FALSE;
            }
        }

        // 曜日間の情報表示縛り設定
        if ($data["is_display_week"] != 0) {
            if($data["display_week_string"]) {

                //その週の日曜日の日付（weekStartDate）を取得します
                $nowDate = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
                $nowDateArray = getdate($nowDate);
                $nowWeekNum = $nowDateArray['wday']; //指定日の曜日番号
                $weekStartDate = date("Y-m-d",($nowDate - $nowWeekNum * 24 * 60 * 60));

                $currentWeekArray = explode("-",$weekStartDate);

                //設定値を取得、整形します
                $displayWeekStringArray = explode("_",$data["display_week_string"]);

                $startValueArray = explode(",",$displayWeekStringArray[0]);
                $lastValueArray  = explode(",",$displayWeekStringArray[1]);

                //その週での表示開始、終了曜日
                $firstWeekNum = $startValueArray[0];
                $lastWeekNum  = $lastValueArray[0];

                $startTimeArray = explode(":",$startValueArray[1]);
                $lastTimeArray  = explode(":",$lastValueArray[1]);

                //その週での開始日時、終了日時を取得します
                $StartDatetime = mktime($startTimeArray[0], $startTimeArray[1], $startTimeArray[2], $currentWeekArray[1], $currentWeekArray[2] + $firstWeekNum, $currentWeekArray[0]);
                $lastDatetime  = mktime($lastTimeArray[0],  $lastTimeArray[1],  $lastTimeArray[2],  $currentWeekArray[1], $currentWeekArray[2] + $lastWeekNum,  $currentWeekArray[0]);
                //現時点でのタイムスタンプ
                $nowTime = time();

                //表示する場合
                if($data["is_display_week"] == 1){

                    if( ($StartDatetime > $nowTime) OR ($lastDatetime < $nowTime) ){
                        return FALSE;
                    }

/*
                    //金曜(5)～月曜(1)設定の場合
                    if($StartDatetime > $lastDatetime){
                        //『表示終了時刻（月曜設定）より前か、表示開始時刻（金曜設定）より後』の条件満たす排他的論理和
                        if( ($StartDatetime < $nowTime) XOR ($lastDatetime > $nowTime) ){
                            //おｋなので何もしません
                        }else{
                            return FALSE;
                        }
                    }else{

                        if( ($StartDatetime > $nowTime) OR ($lastDatetime < $nowTime) ){
                            return FALSE;
                        }
                    }
*/
                //表示しない場合
                }elseif($data["is_display_week"] == 2){

                    if( ($StartDatetime < $nowTime) AND ($lastDatetime > $nowTime) ){
                        return FALSE;
                    }
                }
            }
        }
        return TRUE;
    }

    /**
     * chkInformationDisplayメソッド
     *
     * 情報の閲覧の可否をチェック
     *
     * @param integer $infoCategoryId 情報表示フォルダId
     * @return boolean  $chkResult 表示可能はTRUE 不可はFALSE
     */
    public function chkInformationDisplay($folderId) {

        // 引数が不正ならFALSE
        if (!isset($folderId)) {
            return FALSE;
        }

        $columnArray[] = "SQL_CALC_FOUND_ROWS imdp.*";

        $whereArray[] = "imdp.information_category_id = " . $folderId;
        $whereArray[] = "imdp.is_display = 1";
        $whereArray[] = "imdp.disable =0" ;

        $sql = $this->makeSelectQuery("information_display_position AS imdp", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $dbResultOBJ->fetchAll();

        // 取得フォルダが表示場所ログイン前かどうかチェック
        if ($dataList) {
            // デフォルトはFALSE
            $chkResult = FALSE;
            foreach ($dataList as $val) {
                if (in_array($val["cd"], self::$_prePermissionDisplayPosition)) {
                    // 登録フォルダが１件でも「表示場所：ログイン前」ならTRUE
                    $chkResult = TRUE;
                }
            }
        }

        return $chkResult;

    }

    function getWhatDayOfWeek($year, $month, $number, $dayOfWeek) {
        $firstDayOfWeek = date("w", mktime(0, 0, 0, $month, 1, $year));//指定した年月の1日の曜日を取得
        $day = $dayOfWeek - $firstDayOfWeek + 1;
        if($day <= 0) $day += 7;//1週間を足す
        $dt = mktime(0, 0, 0, $month, $day, $year);
        $dt += (86400 * 7 * ($number - 1));//n曜日まで1週間を足し込み
        return date("Y-m-d", $dt);
    }

}

?>