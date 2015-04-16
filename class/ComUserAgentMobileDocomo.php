<?php
/**
 * ComUserAgentMobile.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * Docomo端末情報を扱うクラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      Shinichi Hata
 */

class ComUserAgentMobileDocomo {

    /** @var string ユーザーエージェント情報 */
    protected $_httpUserAgent = null;

    /** @var object リクエストobject */
    protected $_requestOBJ = null;

    /**
     * 基本的に旧機種に関する情報なので更新する必要はありません。
     *
     * @var array FOMAでもテーブルタグが使えない端末リスト
     */
    private $_no3GModel = array(
        "N2001",
        "N2002",
        "P2002",
        "D2101V",
        "P2101V",
        "SH2101V",
        "T2101V",
        "F2051",
        "N2051",
        "P2102V",
        "F2102V",
        "N2102V",
        "N2701",
        "NM850iG",
        "NM705i",
        "NM706i",
        "F900i",
        "N900i",
        "P900i",
        "SH900i",
        "F900iT",
        "P900iV",
        "N900iS",
        "D900i",
        "F900iC",
        "N900iL",
        "N900iG",
        "F880iES",
        "SH901iC",
        "F901iC",
        "N901iC",
        "D901i",
        "P901i",
        "SH901iS",
        "F901iS",
        "D901iS",
        "P901iS",
        "N901iS",
        "P901iTV",
        "F700i",
        "SH700i",
        "N700i",
        "P700i",
        "F700iS",
        "SH700iS",
        "SA700iS",
        "SH851i",
        "P851i",
        "F881iES",
        "D701i",
        "N701i",
        "P701iD",
        "D701iWM",
        "N701iECO",
        "SA800i",
        "L600i",
        "N600i",
        "L601i",
        "M702iS",
        "M702iG",
        "L602i",
    );

    /**
     * コンストラクタ
     *
     * @param string $httpUserAgent $_SERVER["HTTP_USER_AGENT"]の値
     */
    public function __construct($httpUserAgent) {
        $this->_httpUserAgent = $httpUserAgent;
        $this->_requestOBJ = ComRequest::getInstance();
    }

    /**
     * FOMA端末かどうかをチェックする。
     *
     * @return boolean FOMAならtrue、違うならfalse
     */
    public function isFoma() {

        if (!$this->_httpUserAgent) {
            return false;
        }

        // 正規表現文字列に「/」を使用するため「!」がデリミタ
        $fomaRegex = "!^DoCoMo/(\d)\.\d[ /]!";

        if (!preg_match($fomaRegex, $this->_httpUserAgent, $matches)) {
            return false;
        }

        // FOMA端末の場合
        if ($matches[1] == "2") {
            return true;
        // それ以外
        } else {
            return false;
        }
    }

    /**
     * FOMA3G端末かどうかをチェックする。
     *
     * FOMA端末でもテーブルタグ&CSSが使えないものは除く。
     *
     * @return boolean FOMA3Gならtrue、違うならfalse
     */
    public function isFoma3G() {

        if (!$this->_httpUserAgent) {
            return false;
        }

        if (!$this->isFoma()) {
            return false;
        }

        if (array_search($this->getModel(), $this->_no3GModel)) {
            return false;
        }

        return true;
    }

    /**
     * 携帯機種名を取得する。
     *
     * @return mixed 取得成功なら携帯機種名、失敗ならfalse
     */
    public function getModel() {

        if (!$this->_httpUserAgent) {
            return false;
        }

        // 正規表現文字列に「/」を使用するため「!」がデリミタ
        $docomoDeviceRegex = "!^DoCoMo/\d\.\d[ /]([^(/]+)[(/]!";

        if (!preg_match($docomoDeviceRegex, $this->_httpUserAgent, $matches)) {
            return false;
        }

        switch ($matches[1]) {
            case "MST_v_SH2101V":
                $model = "SH2101V";
                break;
            default:
                $model = $matches[1];
        }

        return $model;
    }

    /**
     * getManufacturerIdメソッド
     *
     * 個体識別番号を取得する
     *
     * http://tachibana.blog.ocn.ne.jp/blog/2006/05/ez_7a39.html
     *
     * @return string 個体識別番号
     */
    public function getManufacturerId() {

        $serialNumber = "";

        // FOMA
        if (preg_match("/ser(\w{15});/", $this->_ua, $matches) && $this->isFoma()) {
            $serialNumber = $matches[1];
        // mova
        } else if (preg_match("/ser(\w{11})/", $this->_ua, $matches)) {
            $serialNumber = $matches[1];
        }

        return $serialNumber;
    }

    /**
     * getCardIdメソッド
     *
     * カード製造番号を取得する
     *
     * http://tachibana.blog.ocn.ne.jp/blog/2006/05/ez_7a39.html
     *
     * @return string カード製造番号
     */
    public function getCardId() {

        $cardId = "";

        if (preg_match("/icc(\w{20})/", $this->_ua, $matches)) {
            $cardId = $matches[1];
        }

        return $cardId;
    }

    /**
     * getSerialNumber()
     * i-mode ID を取得する
     *
     * @return string imodeid
     */
    public function getSerialNumber() {

        $guid = $this->_requestOBJ->getParameter("guid", "", "get");

        if (empty($guid)) {
            return null;
        }

        if ($guid != "ON" && $guid != "on") {
            return null;
        }

        $serialNumber = $this->_requestOBJ->getParameter("HTTP_X_DCMGUID", "", "server");
        if (empty($serialNumber)) {
            return null;
        }

        return $serialNumber;
    }

}

?>
