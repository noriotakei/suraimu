<?php

/**
 * AdmMailContents.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理側リメール設定管理を行うクラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */


class AdmAutoMail extends ComCommon implements InterfaceAutoMail {

    const REMAIL_ADDRESS = "info@";
    const REMAIL_RETURN_PATH = "bounce@mail.";

    /** @var string エラーメッセージ */
    protected $_errorMsg = null;

    /** @var object インスタンスを保持するstatic変数 */
    protected static $_instance = null;

    /* 表示状態 */
    public static $_isUse = array(
                                    "0" => "未使用",
                                    "1" => "使用中",
                                );

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
     * リメールコンテンツリストの取得
     *
     * @return array データ配列
     */
    public function getAutoMailContentsList() {

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "disable = 0";

        $otherArray[] = "ORDER BY sort_seq DESC";

        $sql = $this->makeSelectQuery("auto_mail_contents", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;
    }

    /**
     *
     * リメールコンテンツデータの取得
     *
     * @param  int $autoMailContentsId リメールコンテンツID
     * @return array $data データ配列
     */
    public function getAutoMailContentsData($autoMailContentsId) {

        if (!is_numeric($autoMailContentsId)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "id = " . $autoMailContentsId;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("auto_mail_contents", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * リメールコンテンツデータ登録
     * @param  array $aryInsertData INSERTデータ配列
     * @return boolean
     */
    public function insertAutoMailContentsData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("auto_mail_contents", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * リメールコンテンツデータの更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateAutoMailContentsData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("auto_mail_contents", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

    /**
     *
     * リメールエレメントデータの取得
     *
     * @param  int $autoMailContentsId リメールコンテンツID
     * @return array $data データ配列
     */
    public function getAutoMailElementData($autoMailContentsId) {

        if (!is_numeric($autoMailContentsId)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "auto_mail_contents_id = " . $autoMailContentsId;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("auto_mail_elements", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     * リメールエレメント画像の取得。
     *
     * @param  integer $autoMailElementsId リメールエレメントID
     * @param  boolean $isMobile モバイルフラグ
     *
     * @return arrat リメールエレメント画像リスト、失敗ならfalse
     */
    public function getAutoMailImageData($autoMailElementsId, $isMobile = false) {

        if (!is_numeric($autoMailElementsId)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "auto_mail_elements_id = " . $autoMailElementsId;
        $whereArray[] = "is_mobile = " . ($isMobile ? 1 : 0);
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("auto_mail_image", $columnArray, $whereArray);

        if ($dbResultOBJ = $this->executeQuery($sql)) {
            $dataArray = $this->fetchAll($dbResultOBJ);
        } else {
            return FALSE;
        }

        return $dataArray;
    }

    /**
     *
     * リメールエレメントデータ登録
     * @param  array $aryInsertData INSERTデータ配列
     * @return boolean
     */
    public function insertAutoMailElementData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("auto_mail_elements", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * リメールエレメントの更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateAutoMailElementData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("auto_mail_elements", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

    /**
     *
     *  リメール画像の追加
     *
     *  @param  array   $autoMailElementsId リメールエレメントID
     *  @param  string   $imageName 画像変数名
     *  @param  boolean $isMobile モバイルフラグ
     *
     *  @return boolean
     */
    public function insertAutoMailImage($autoMailElementsId, $imageName, $isMobile = false) {

        if (!$imageName) {
            return FALSE;
        }

        $imgDeviceName = ($isMobile ? "_mb" : "_pc");

        // リメール画像の生成
        for ($i = 1; $i <= count($_FILES[$imageName]["tmp_name"]); $i++) {
            if ($_FILES[$imageName]["tmp_name"][$i]) {
                $imageAry = getimagesize($_FILES[$imageName]["tmp_name"][$i]);
                $extension = ComImgFileUpload::$extensionTypeArray[$imageAry[2]];

                $imgFileName = $autoMailElementsId . "_" . $i . $imgDeviceName . "." . $extension;

                // 添付画像を残す
                move_uploaded_file($_FILES[$imageName]["tmp_name"][$i],
                                   D_BASE_DIR . self::AUTO_MAIL_IMAGE_PATH . $imgFileName);
                chmod(D_BASE_DIR . self::AUTO_MAIL_IMAGE_PATH . $imgFileName, 0755);

                $insertArray = array(
                    "auto_mail_elements_id" => $autoMailElementsId,
                    "file_name"           => $imgFileName,
                    "is_mobile"           => ($isMobile ? 1 : 0),
                    "create_datetime"     => date("YmdHis"),
                );
                if (!$dbResultOBJ = self::insertAutoMailImageData($insertArray)) {
                    $this->_errorMsg[] = "データ登録できませんでした。";
                    return FALSE;
                }
            }
        }

        return TRUE;
    }

    /**
     *
     *  リメール画像の更新
     *
     *  @param  array   $autoMailElementsId リメールエレメントID
     *  @param  string  $imageName 画像変数名
     *  @param  boolean $isMobile モバイルフラグ
     *  @param  array   $param パラメータ
     *
     *  @return boolean
     */
    public function updateAutoMailImage($autoMailElementsId, $imageName, $isMobile = false, $param) {

        if (!$imageName) {
            return FALSE;
        }

        $imageDataList = self::getAutoMailImageData($autoMailElementsId, $isMobile);
        $imgDeviceName = ($isMobile ? "_mb" : "_pc");

        $this->beginTransaction();

        // リメール画像の生成
        for ($i = 1; $i <= count($_FILES[$imageName]["tmp_name"]); $i++) {
            $insertArray = "";
            if ($_FILES[$imageName]["tmp_name"][$i]) {
                $imageAry = getimagesize($_FILES[$imageName]["tmp_name"][$i]);
                $extension = ComImgFileUpload::$extensionTypeArray[$imageAry[2]];

                $imgFileName = $autoMailElementsId . "_" . $i . $imgDeviceName . "." . $extension;

                // 添付画像を残す
                move_uploaded_file($_FILES[$imageName]["tmp_name"][$i],
                                   D_BASE_DIR . self::AUTO_MAIL_IMAGE_PATH . $imgFileName);
                chmod(D_BASE_DIR . self::AUTO_MAIL_IMAGE_PATH . $imgFileName, 0755);

                $insertArray = array(
                    "auto_mail_elements_id" => $autoMailElementsId,
                    "file_name"           => $imgFileName,
                    "is_mobile"           => ($isMobile ? 1 : 0),
                    "create_datetime" => date("YmdHis"),
                );

                // 該当のレコードがあるか検索
                foreach ((array)$imageDataList as $key => $val) {
                    $tmp = explode(".", $val["file_name"]);
                    list($id, $no, $imgDevice) = explode("_", $tmp[0]);
                    if ($no == $i) {
                        $updateFlag = TRUE;
                        break;
                    }
                    $updateFlag = FALSE;
                }
                if ($updateFlag) {
                    if (!self::updateAutoMailImageData($insertArray, array("id = ". $imageDataList[$i - 1]["id"]))) {
                        $this->_errorMsg[] = "データ更新できませんでした。";
                        $this->rollbackTransaction();
                        return FALSE;
                    }
                } else if ($insertArray) {
                    if (!$dbResultOBJ = self::insertAutoMailImageData($insertArray)) {
                        $this->_errorMsg[] = "データ登録できませんでした。";
                        $this->rollbackTransaction();
                        return FALSE;
                    }
                }
            }
        }

        // 画像の削除
        $updateAry["disable"] = 1;
        $imageDelName = ($isMobile ? "mb_image_del" : "pc_image_del");
        foreach ((array)$imageDataList as $key => $val) {
            $tmp = explode(".", $val["file_name"]);
            list($id, $no, $imgDevice) = explode("_", $tmp[0]);
            if ($param[$imageDelName][$no]) {
                if (!self::updateAutoMailImageData($updateAry, array("id = " . $val["id"]))) {
                    $this->_errorMsg[] = "削除できませんでした。";
                    $this->rollbackTransaction();
                    return FALSE;
                }
            }
        }

        $this->commitTransaction();
        return TRUE;
    }

    /**
     *
     *  リメール画像データの登録
     * @param  array $aryInsertData INSERTデータ配列
     * @return boolean
     */
    public function insertAutoMailImageData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("auto_mail_image", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     *
     *  リメール画像データの更新
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     *  @return boolean
     */
    public function updateAutoMailImageData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("auto_mail_image", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }
}

?>