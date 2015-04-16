<?php
/**
 * AdmRegistPage.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 *  管理側登録ページ管理クラス
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */
class AdmRegistPage extends ComCommon implements InterfaceRegistPage {

    const REGIST_PAGE_REMAIL_ADDRESS = "info@";
    const REGIST_PAGE_RETURN_PATH = "bounce@mail.";

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
     *
     * 登録ページデータの取得
     *
     * @param  integer $id 注文ID
     * @return array データ配列
     */
    public function getRegistPageData($id) {

        if (!is_numeric($id)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "id = " . $id;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("regist_page", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * 登録ページリストの取得
     *
     * @param  array $param パラメーター
     * @param  integer $offset オフセット
     * @param  string $order 表示順
     * @param  integer $limit 表示件数
     *
     * @return array $dataList データ配列
     */
    public function getRegistPageList($param, $offset, $order, $limit) {

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        if ($param["category_id"]) {
            $whereArray[] = "regist_page_category_id = " . $param["category_id"];
        }

        $whereArray[] = "disable = 0";

        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }
        if (ComValidation::isNumeric($offset)) {
            $otherArray[] = " LIMIT ". $offset . ", " . $limit;
        }

        $sql = $this->makeSelectQuery("regist_page", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;

    }

    /**
     * 登録ページ画像の取得。
     *
     * @param  integer $registPageId 登録ページID
     * @param  boolean $isMobile モバイルフラグ
     *
     * @return arrat 登録ページ画像リスト、失敗ならfalse
     */
    public function getRegistPageImageData($registPageId, $isMobile = false) {

        if (!is_numeric($registPageId)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "regist_page_id = " . $registPageId;
        $whereArray[] = "is_mobile = " . ($isMobile ? 1 : 0);
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("regist_page_image", $columnArray, $whereArray);

        if ($dbResultOBJ = $this->executeQuery($sql)) {
            $dataArray = $this->fetchAll($dbResultOBJ);
        } else {
            return FALSE;
        }

        return $dataArray;
    }

    /**
     * 登録ページの登録。
     *
     * @param  array $insertArray 挿入データ配列
     * @return boolean
     */
    public function insertRegistPageData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("regist_page", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * 登録ページの更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateRegistPageData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("regist_page", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     *
     *  登録ページ画像の追加
     *
     *  @param  array   $registPageId 登録ページID
     *  @param  string   $imageName 画像変数名
     *  @param  boolean $isMobile モバイルフラグ
     *
     *  @return boolean
     */
    public function insertRegistPageImage($registPageId, $imageName, $isMobile = false) {

        if (!$imageName) {
            return FALSE;
        }

        $imgDeviceName = ($isMobile ? "_mb" : "_pc");

        // 登録ページの生成
        for ($i = 1; $i <= count($_FILES[$imageName]["tmp_name"]); $i++) {
            if ($_FILES[$imageName]["tmp_name"][$i]) {
                $imageAry = getimagesize($_FILES[$imageName]["tmp_name"][$i]);
                $extension = ComImgFileUpload::$extensionTypeArray[$imageAry[2]];

                // 添付画像を残す
                move_uploaded_file($_FILES[$imageName]["tmp_name"][$i],
                                   D_BASE_DIR . self::REGIST_PAGE_IMAGE_PATH . $registPageId . "_" . $i . $imgDeviceName . "." . $extension);
                chmod(D_BASE_DIR . self::REGIST_PAGE_IMAGE_PATH . $registPageId . "_" . $i . $imgDeviceName . "." . $extension, 0755);

                $insertArray = array(
                    "regist_page_id" => $registPageId,
                    "file_name"           => $registPageId . "_" . $i . $imgDeviceName . "." . $extension,
                    "is_mobile"           => ($isMobile ? 1 : 0),
                    "create_datetime"     => date("YmdHis"),
                );
                if (!$dbResultOBJ = $this->insert("regist_page_image", $insertArray)) {
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
     *  @param  array   $registPageId リメールエレメントID
     *  @param  string  $imageName 画像変数名
     *  @param  boolean $isMobile モバイルフラグ
     *  @param  array   $param パラメータ
     *
     *  @return boolean
     */
    public function updateRegistPageImage($registPageId, $imageName, $isMobile = false, $param) {

        if (!$imageName) {
            return FALSE;
        }

        $imageDataList = self::getRegistPageImageData($param["regist_page_id"], $isMobile);
        $imgDeviceName = ($isMobile ? "_mb" : "_pc");

        $this->beginTransaction();

        // リメール画像の生成
        for ($i = 1; $i <= count($_FILES[$imageName]["tmp_name"]); $i++) {
            if ($_FILES[$imageName]["tmp_name"][$i]) {
                $imageAry = getimagesize($_FILES[$imageName]["tmp_name"][$i]);
                $extension = ComImgFileUpload::$extensionTypeArray[$imageAry[2]];

                // 添付画像を残す
                move_uploaded_file($_FILES[$imageName]["tmp_name"][$i],
                                   D_BASE_DIR . self::REGIST_PAGE_IMAGE_PATH . $registPageId . "_" . $i . $imgDeviceName . "." . $extension);
                chmod(D_BASE_DIR . self::REGIST_PAGE_IMAGE_PATH . $registPageId . "_" . $i . $imgDeviceName . "." . $extension, 0755);

                $insertArray = array(
                    "regist_page_id" => $registPageId,
                    "file_name"           => $registPageId . "_" . $i . $imgDeviceName . "." . $extension,
                    "is_mobile"           => ($isMobile ? 1 : 0),
                    "create_datetime"     => date("YmdHis"),
                );

                // 該当のレコードがあるか検索
                foreach ((array)$imageDataList as $key => $val) {
                    $tmp = explode(".", $val["file_name"]);
                    list($id, $no) = explode("_", $tmp[0]);
                    if ($no == $i) {
                        $updateFlag = TRUE;
                        break;
                    }
                    $updateFlag = FALSE;
                }

                if ($updateFlag) {
                    if (!$this->updateRegistPageImageData($insertArray, array("id = ". $imageDataList[$i - 1]["id"]))) {
                        $this->_errorMsg[] = "データ登録できませんでした。";
                        $this->rollbackTransaction();
                        return FALSE;
                    }
                } else {
                    if (!$dbResultOBJ = $this->insertRegistPageImageData($insertArray)) {
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
                if (!self::updateRegistPageImageData($updateAry, array("id = " . $val["id"]))) {
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
    public function insertRegistPageImageData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("regist_page_image", $insertArray)) {
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
    public function updateRegistPageImageData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("regist_page_image", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

    /**
     * 登録ページカテゴリーリストの取得
     *
     * @return array データ配列
     */
    public function getRegistPageCategoryList() {

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("regist_page_category", $columnArray, $whereArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;
    }

    /**
     *
     * 登録ページカテゴリーデータの取得
     *
     * @param  int $keyConvertCategoryId 登録ページカテゴリーID
     * @return array $data データ配列
     */
    public function getRegistPageCategoryData($keyConvertCategoryId) {

        if (!is_numeric($keyConvertCategoryId)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "id = " . $keyConvertCategoryId;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("regist_page_category", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * selectbox用登録ページカテゴリーコードリストの取得
     *
     * @return array $dataArray データ配列
     */
    public function getRegistPageCategoryForSelect() {

        $columnArray[] = "*";

        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("regist_page_category", $columnArray, $whereArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        while ($data = $this->fetch($dbResultOBJ)) {
            $dataArray[$data["id"]] = $data["name"];
        }

        return $dataArray;

    }

    /**
     *
     * 登録ページカテゴリーデータ登録
     * @param  array $aryInsertData INSERTデータ配列
     * @return boolean
     */
    public function insertRegistPageCategoryData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("regist_page_category", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * 登録ページカテゴリーデータの更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateRegistPageCategoryData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("regist_page_category", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

}
?>