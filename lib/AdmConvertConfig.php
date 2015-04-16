<?php
/**
 * AdmConvertConfig.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理側競馬観コンバートを行うクラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      norihisa hosoda
 */

class AdmConvertConfig extends ComCommon {

    CONST CONVERT_TYPE_HORCE_RACE_VISITOR = "1";
    CONST CONVERT_TYPE_PRIZE_VISITOR      = "2";
    CONST CONVERT_TYPE_MAGAZINE_VISITOR   = "3";
    CONST CONVERT_TYPE_REWARD_VISITOR   = "4";

    // 競馬全サイトのサイトコード(固定)
    CONST SITE_CD_SURAIMU = 5;
    CONST SITE_CD_CHIMERA = 6;
    CONST SITE_CD_TROLL  = 9;
    CONST SITE_CD_GOLEM   = 8;
    CONST SITE_CD_GIZMO   = 3;

    /*** 競馬全サイトの競馬間コンバート用検索保存条件ID ***/
    // 競馬客
    private $_hourseRaceVisitor = array(
            self::SITE_CD_SURAIMU => array(
                    "61",
                    "120"
                ),
            self::SITE_CD_CHIMERA => array(
                    "59",
                    "85"
                ),
            self::SITE_CD_TROLL => array(
                    "536",
                    "537"
                ),
            self::SITE_CD_GOLEM => array(
                    "58",
                    "59"
                ),
            self::SITE_CD_GIZMO => array(
                    "47",
                    "51"
                ),
        );
    // 懸賞客
    private $_prizeVisitor = array(
            self::SITE_CD_SURAIMU => array(
                    "113",
                    "121"
                ),
            self::SITE_CD_CHIMERA => array(
                    "83",
                    "86"
                ),
            self::SITE_CD_TROLL => array(
                    "538",
                    "539"
                ),
            self::SITE_CD_GOLEM => array(
                    "60",
                    "61"
                ),
            self::SITE_CD_GIZMO => array(
                    "48",
                    "52"
                ),
        );
    // 雑誌客
    private $_magazineVisitor = array(
            self::SITE_CD_SURAIMU => array(
                    "62",
                    "101",
                    "122",
                    "123"
                ),
            self::SITE_CD_CHIMERA => array(
                    "60",
                    "78",
                    "87",
                    "88"
                ),
            self::SITE_CD_TROLL => array(
                    "542",
                    "543",
                    "544",
                    "545"
                ),
            self::SITE_CD_GOLEM => array(
                    "62",
                    "63"
                ),
            self::SITE_CD_GIZMO => array(
                    "10",
                    "36",
                    "53",
                    "54"
                ),
        );
    // 成果報酬客
    private $_rewardVisitor = array(
            self::SITE_CD_SURAIMU => array(
                    "192",
                    "193"
                ),
            self::SITE_CD_CHIMERA => array(
                    "121",
                    "122"
                ),
            self::SITE_CD_TROLL => array(
                    "540",
                    "541"
                ),
            self::SITE_CD_GOLEM => array(
                    "56",
                    "57"
                ),
            self::SITE_CD_GIZMO => array(
                    "78",
                    "79"
                ),
        );

    /** @var string エラーメッセージ */
    protected $_errorMsg = null;

    /** @var object インスタンスを保持するstatic変数 */
    protected static $_instance = null;

    /**
     * コンストラクタ。
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * インスタンスの取得。
     *
     * インスタンスが既に生成済みの場合は既存インスタンスを返し、
     * 未生成であれば新たに生成したものを返す。
     *
     * @return mixed 成功時はインスタンス、失敗時はfalseを返す
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
     * 競馬観コンバートデータリストの取得。
     *
     * @return mixed ユーザー情報リスト、失敗ならfalse
     */
    public function getConvertConfigList($whereArray = null) {

        $columnArray[] = "*";

        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("convert_config", $columnArray, $whereArray);

        if ($dbResultOBJ = $this->executeQuery($sql)) {
            $dataArray = $this->fetchAll($dbResultOBJ);
        } else {
            return FALSE;
        }

        return $dataArray[0];
    }

    /**
     * 競馬間コンバートの対象客タイプを取得
     *
     * @param  int 検索保存条件ID $searchId
     * @return int 対象客の種類
     */
    public function getVisitorType($searchId) {

        if (empty($searchId)) {
            return false;
        }

        if (in_array($searchId, $this->_hourseRaceVisitor[$this->_configOBJ->define->SITE_CD])) {
            return self::CONVERT_TYPE_HORCE_RACE_VISITOR;
        }
        if (in_array($searchId, $this->_prizeVisitor[$this->_configOBJ->define->SITE_CD])) {
            return self::CONVERT_TYPE_PRIZE_VISITOR;
        }
        if (in_array($searchId, $this->_magazineVisitor[$this->_configOBJ->define->SITE_CD])) {
            return self::CONVERT_TYPE_MAGAZINE_VISITOR;
        }
        if (in_array($searchId, $this->_rewardVisitor[$this->_configOBJ->define->SITE_CD])) {
            return self::CONVERT_TYPE_REWARD_VISITOR;
        }

        return false;
    }
}
?>
