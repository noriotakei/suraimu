<?php
/**
 * AdmInfomationStatus.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理側情報データの管理を行うクラス。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa hosoda
 */

class AdmInformationStatus extends ComCommon implements InterfaceInformation {

    /** 表示位置プルダウン配列 */
    public static $_displayPositionName = array(
            self::DISPLAY_POSITION_TOP                       => "ログイン後トップ",
            self::DISPLAY_POSITION_POST_FREE_INFORMATION     => "ログイン後フリー情報",
            self::DISPLAY_POSITION_PRE_FREE_INFORMATION      => "ログイン前フリー情報",
            self::DISPLAY_POSITION_POST_TOP_CAMP             => "ログイン後TOPキャンペーン",
            self::DISPLAY_POSITION_HOME_TOP_CAMP             => "ログイン後HOMEキャンペーン",
            self::DISPLAY_POSITION_ITEM_EXPLANATION          => "アイテムリストタイトル",
            self::DISPLAY_POSITION_ITEM_LIST                 => "アイテムリスト",
            self::DISPLAY_POSITION_PC_PRE_SIDE_INFORMATION   => "PCログイン前サイド表示情報",
            self::DISPLAY_POSITION_PC_POST_SIDE_INFORMATION  => "PCログイン後サイド表示情報",
            self::DISPLAY_POSITION_PC_PRE_TOP_CAMP           => "PCログイン前TOPキャンペーン",
            self::DISPLAY_POSITION_INFORMATION_OPEN          => "情報公開",
            self::DISPLAY_POSITION_INFORMATION_LIST          => "情報リストページ",
            self::DISPLAY_POSITION_MB_HOME_MIDDLE_CAMP          => "MB購入キャンペーンの情報公開中",
            self::DISPLAY_CD_QUIT_WEEKLY_RACE          => "今週の注目レース",
            self::DISPLAY_POSITION_MB_HOME_INFORMATION_OPEN          => "MBチケット情報 公開中",
        );

    /* 入金状態状態 */
    public static $_paymentStatus = array(
                                    "0" => "設定しない",
                                    self::PAY_STATUS_PAY => "入金有り",
                                    self::PAY_STATUS_NOT_PAY => "入金無し"
                                );

    /* ｽﾏﾎ表示切り替え */
    public static $_isSmartPhone = array(
            "0" => "非表示",
            "1" => "表示中"
    );

    /* 表示状態 */
    public static $_isDisplay = array(
                                    "0" => "非表示",
                                    "1" => "表示中"
                                );
    /* 全画面表示設定 */
    public static $_isAllDisplay = array(
                                    "0" => "OFF",
                                    "1" => "ON"
                                );
    /* 曜日縛り表示設定 */
    public static $_isDisplayWeek = array(
                                    "0" => "設定しない",
                                    "1" => "表示する",
                                    "2" => "表示しない"
                                );
    /** 検索タイプ配列 */
    public static $_searchTypeAry = array(
                            "0" => "気にしない"
                            //,"1" => "情報ID"
                            //,"2" => "情報アクセスキー"
                            ,"3" => "管理用情報名(あいまい検索)"
                            //,"4" => "表示開始日時"
                            ,"5" => "検索条件保存ID"
                            ,"6" => "情報本文検索"
        );

    /** 表示日時指定配列 */
    public static $_searchDisplayDateTimeTypeAry = array(
                            "0" => "気にしない"
                            ,"1" => "期間中"
                            ,"2" => "期間切れ"
                            ,"3" => "日時指定"
        );

    /** 情報本文検索配列 */
    public static $_searchHtmlTextAry = array(
                            "1" => "PCバナー"
                            ,"2" => "PC詳細"
                            ,"3" => "MBバナー"
                            ,"4" => "MB詳細"
        );

    /* 検索用表示状態 */
    public static $_searchIsDisplay = array(
                                    "0" => "気にしない",
                                    "1" => "非表示",
                                    "2" => "表示中"
                                );

    /* 検索用情報表示日時指定 */
    public static $_searchDisplayDateTimeType = array(
                                    "0" => "気にしない",
                                    "1" => "表示期限中",
                                    "2" => "表示期限切れ",
                                    "3" => "日時指定"
                                );

    /* 情報データ一括操作内容 */
    public static $_batchOperateInfoSelectAry = array(
                                    "1" => "表示状態変更",
                                    "2" => "フォルダ移動",
                                    "3" => "情報データコピー",
                                    "4" => "削除",
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
     *
     * 情報データの取得
     *
     * @param  int $id 情報ID
     *
     * @return array $data データ配列
     */
    public function getInformationStatusData($id) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $columnArray[] = "ims.*";

        $whereArray[] = "ims.id = " . $id;
        $whereArray[] = "ims.disable = 0";

        $sql = $this->makeSelectQuery("information_status AS ims", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * 情報データの取得
     *
     * @param  int $id 情報ID
     *
     * @return array $data データ配列
     */
    public function getInformationStatusDisplayPositionData($id) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $columnArray[] = "ims.*";
        $columnArray[] = "imdp.cd";

        $whereArray[] = "ims.id = " . $id;
        $whereArray[] = "ims.disable = 0";
        $whereArray[] = "imdp.disable = 0";
        $whereArray[] = "ims.information_category_id = imdp.information_category_id";

        $sql = $this->makeSelectQuery("information_status AS ims, information_display_position AS imdp", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     * 情報リストの取得
     *
     * @param  array $param パラメーター
     * @param  integer $offset オフセット
     * @param  string $order 表示順
     * @param  integer $limit 表示件数
     *
     * @return array $dataList データ配列
     */
    public function getInformationStatusList($param, $offset = 0, $order = null, $limit = 0) {

        $columnArray[] = "SQL_CALC_FOUND_ROWS ims.*";
        $columnArray[] = "imdp.cd AS position_cd";

        $whereArray[] = "ims.information_category_id = ic.id";
        $whereArray[] = "ic.id = imdp.information_category_id";

        // 登録フォルダ
        if ($param["folder_id"]) {
            $whereArray[] = "ims.information_category_id = " . $param["folder_id"];
        }

        // 情報表示場所
        if ($param["position_id"]) {
            $whereArray[] = "imdp.cd = " . $param["position_id"];
        }

        // 情報ID
        if ($param["search_information_id"]) {
            // 情報ID
            $whereArray[] = "ims.id IN (" . $param["search_information_id"] . ")";
        }

        // 情報アクセスキー
        if ($param["search_information_key"]) {
            // 複数の場合、文字列としてそれぞれ指定しないといけない
            $searchInformationKeyAry = array();
            $searchInformationKeyAry = explode(",", $param["search_information_key"]);

            $searchInformationKey = array();
            foreach ($searchInformationKeyAry as $key => $val) {
                $searchInformationKey[] = "'" . $val . "'";
            }

            // 再度、カンマで連結
            $searchInformationKeyString = "";
            $searchInformationKeyString = implode(",", $searchInformationKey);

            $whereArray[] = "ims.access_key IN (" . $searchInformationKeyString . ")";
        }

        if ($param["search_display_datetime_type"] == 1) {
            // 期間中(開始日時<=現在日時, 現在日時<=終了日時 or 終了日時=0000-00-00 00:00:00)
            $whereArray[] = "ims.display_start_datetime <= '" . date("Y-m-d H:i:s") . "'";
            $whereArray[] = "(ims.display_end_datetime >= '" . date("Y-m-d H:i:s") . "' OR ims.display_end_datetime = '0000-00-00 00:00:00')";
        } elseif ($param["search_display_datetime_type"] == 2) {
            // 期間切れ(終了日時 < 現在日時)
            $whereArray[] = "ims.display_end_datetime != '0000-00-00 00:00:00'";
            $whereArray[] = "ims.display_end_datetime < '" . date("Y-m-d H:i:s") . "'";
        }  else {
            // 表示日時開始日
            if ($param["searchDatetimeFrom"]) {
                $whereArray[] = "ims.display_start_datetime <= '" . $param["searchDatetimeFrom"] . "'";
                $whereArray[] = "(ims.display_end_datetime >= '" .  $param["searchDatetimeFrom"] . "' OR ims.display_end_datetime = '0000-00-00 00:00:00')";
            }
            // 表示日時終了日
            if ($param["searchDatetimeTo"]) {
                $whereArray[] = "ims.display_end_datetime <= '" . $param["searchDatetimeTo"] . "'";
                $whereArray[] = "ims.display_end_datetime != '0000-00-00 00:00:00'";
            }
        }

        // 検索対象
        if ($param["search_type"] == 3) {
            // 管理用情報名検索
            if ($param["search_string"]) {
                // あいまい検索
                $whereArray[] = "ims.name LIKE '%" . $param["search_string"] . "%'";
            }
        } elseif ($param["search_type"] == 5 && $param["search_conditions_id"] && $param["search_conditions_type"]) {
            // 検索条件保存ID
            //-20100630-takuro 多対多検索対応
            $searchConditionsIdArray = explode(",",rtrim($param["search_conditions_id"], ","));

            // 検索条件保存IDの表示タイプで参照カラム設定
            if ($param["search_conditions_display_type"]) {
                // 表示
                $isSearchConditionsClm = "ims.user_search_conditions_id";
            } else {
                // 非表示
                $isSearchConditionsClm = "ims.except_user_search_conditions_id";
            }

            if($param["search_conditions_type"] == 1){
                //AND検索
                foreach($searchConditionsIdArray as $key => $value){
                    $whereArray[] = "FIND_IN_SET( '" . $value . "' , " . $isSearchConditionsClm . ")";
                }
            }else{
                //OR検索 正規表現間違ってたらゴメンなさい
                $searchConditionsRegString = "(" . implode("|",array_unique($searchConditionsIdArray)) . ")";
                $whereArray[] = $isSearchConditionsClm . " REGEXP '^" . $searchConditionsRegString . "\$|^".$searchConditionsRegString.",|,".$searchConditionsRegString."\$|,".$searchConditionsRegString.",'";
            }
        } elseif ($param["search_type"] == 6 && $param["search_html_text_type"]) {
            // 情報本文検索
            foreach ($param["search_html_text_type"] as $val) {
                if ($val == 1) {
                    // PCバナー
                    $searchColumnArray[] = " ims.html_text_banner_pc";
                } elseif ($val == 2) {
                    // PC詳細
                    $searchColumnArray[] = " ims.html_text_pc";
                } elseif ($val == 3) {
                    // MBバナー
                    $searchColumnArray[] = " ims.html_text_banner_mb";
                } else {
                    // MB詳細
                    $searchColumnArray[] = " ims.html_text_mb";
                }
            }
            $whereHtmlTextArray = implode(", " , $searchColumnArray);
            $whereArray[] = " (CONCAT(" . $whereHtmlTextArray . ") LIKE '%" . $param["search_html_text"] . "%')";

            // 条件をORで連結
            //$whereArray[] = implode(" OR ", $whereHtmlTextArray);
        }

        // 表示状態
        if ($param["search_is_display"] == 1) {
            $whereArray[] = "ims.is_display = 0";
        } elseif ($param["search_is_display"] == 2) {
            $whereArray[] = "ims.is_display = 1";
        }

        $whereArray[] = "ims.disable = 0";
        $whereArray[] = "imdp.disable = 0";
        $whereArray[] = "ic.disable = 0";

        $otherArray[] = "GROUP BY ims.id";

        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }
        if (ComValidation::isNumeric($offset)) {
            $otherArray[] = " LIMIT ". $offset . ", " . $limit;
        }

        $sql = $this->makeSelectQuery("information_status AS ims, information_display_position AS imdp, information_category AS ic", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;
    }

    /**
     *
     * 情報データ登録
     * @param  array $aryInsertData INSERTデータ配列
     *
     * @return boolean
     */
    public function insertInformationStatusData($insertArray) {

        if (!is_array($insertArray)) {
            return FALSE;
        }

        if (!$dbResultOBJ = $this->insert("information_status", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

    /**
     * 情報データの更新。
     *
     * @param  array $updateArray 更新データ配列
     *
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateInformationStatusData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return FALSE;
        }

        if (!$dbResultOBJ = $this->update("information_status", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

    /**
     * getMaxSortSeqメソッド
     *
     * 並び順の最大値を取得
     *
     * @return integer 並び順の最大値
     */
    public function getMaxSortSeq() {

        $sql = "SELECT MAX(sort_seq) AS max_seq FROM information_status WHERE disable = FALSE";

        try {
            $dbResultOBJ = $this->executeQuery($sql);
        } catch  (QueryException $e) {
            return 0;
        }

        if (!$dbResultOBJ) {
            return 0;
        }

        $data = $this->fetchAll($dbResultOBJ);

        return $data[0]["max_seq"];
    }

    /**
     *
     * access_keyの重複が無い様にaccess_keyを返す。
     *
     *
     * @param datetime $registDatetime キー生成に使用するデータ
     *
     * @return string accessKey　を連想配列で返す
     */
    public function getNewAccessKey($data)  {

        if (!$data) {
            return FALSE;
        }

        $i = 0;

        // access_keyがユニークになるまで繰り返す
        do {
            $accessKey   = md5($data . "__" . time());
            $accessKey   = substr($accessKey,0,16);

            $columnArray[] = "*";

            $whereArray[] = "access_key = '" . $accessKey . "'";
            $whereArray[] = "disable = 0";

            $sql = $this->makeSelectQuery("information_status", $columnArray, $whereArray);

            $i++;

            // ループ回数は100回
            if ($i > 100) {
                return FALSE;
            }

        } while ($data = $this->executeQuery($sql, "fetchRow"));

        return $accessKey;
    }
}
?>