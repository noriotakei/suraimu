<?php
/**
 * AdmImage.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理側画像データの管理を行うクラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

class AdmImage extends ComCommon {

    const IMAGE_PATH = "image/img/";

    /** @var object FileUploadオブジェクト */
    protected $_fileUploadOBJ = null;

    /** @var string エラーメッセージ */
    protected $_errorMsg = null;

    /** @var object インスタンスを保持するstatic変数 */
    protected static $_instance = null;

    /** 検索タイプ配列 */
    public static $searchTypeAry = array(
                            "0" => "気にしない"
                            ,"1" => "画像名"
                            ,"2" => "コメント"
                            ,"3" => "登録日時"
                            ,"4" => "更新日時"
        );

    /** キーワード特定配列 */
    public static $specifyKeywordAry = array(
                            "0" => "前方一致"
                            ,"1" => "後方一致"
                            ,"2" => "完全一致"
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
     * エラーメッセージの取得
     *
     * @return $_errorMsg
     */
    public function getErrorMsg() {

        return $this->_errorMsg;
    }

    /**
     * 画像データの取得
     *
     * @param  integer $id 画像データID
     * @return array 画像データ
     */
    public function getImageData($id) {

        if (!$id) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "id = " . $id;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("image", $columnArray, $whereArray);

        // 画像情報の取得
        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;
    }

    /**
     * 画像データリストの取得
     *
     * @param  array $param パラメーター
     * @param  integer $offset オフセット
     * @param  string $order 表示順
     * @param  integer $limit 表示件数
     * @return array データ
     */
    public function getImageList($param, $offset, $order, $limit) {

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "disable = 0";

        if ($param["category_id"]) {
            $whereArray[] = "image_category_id = " . $param["category_id"];
        }

        if ($param["extension_type"] == IMAGETYPE_SWF) {
            $whereArray[] = "extension_type IN (" . IMAGETYPE_SWF . ", " . IMAGETYPE_SWC . ")";
        } else if ($param["extension_type"]) {
            $whereArray[] = "extension_type = " . $param["extension_type"];
        }

        // 画像名
        if ($param["search_type"] == 1) {
            // 後方一致
            if ($param["specify_keyword"] == 1) {
                $whereArray[] = "name LIKE '%" . $param["search_string"] . "'";
            // 完全一致
            } else if ($param["specify_keyword"] == 2) {
                $whereArray[] = "name = '" . $param["search_string"] . "'";
            // 前方一致
            } else {
                $whereArray[] = "name LIKE '" . $param["search_string"] . "%'";
            }
        }

        // コメント
        if ($param["search_type"] == 2) {
            // 後方一致
            if ($param["specify_keyword"] == 1) {
                $whereArray[] = "comment LIKE '%" . $param["search_string"] . "'";
            // 完全一致
            } else if ($param["specify_keyword"] == 2) {
                $whereArray[] = "comment = '" . $param["search_string"] . "'";
            // 前方一致
            } else {
                $whereArray[] = "comment LIKE '" . $param["search_string"] . "%'";
            }
        }

        if (ComValidation::isDateTime($param["searchDatetimeFrom"])) {
            // 登録日時
            if ($param["search_type"] == 3) {
                $whereArray[] = "create_datetime >= '" . $param["searchDatetimeFrom"] . "'";
            // 更新日時
            } else if ($param["search_type"] == 4) {
                $whereArray[] = "update_datetime >= '" . $param["searchDatetimeFrom"] . "'";
            }
        }

        if (ComValidation::isDateTime($param["searchDatetimeTo"])) {
            // 登録日時
            if ($param["search_type"] == 3) {
                $whereArray[] = "create_datetime <= '" . $param["searchDatetimeTo"] . "'";
            // 更新日時
            } else if ($param["search_type"] == 4) {
                $whereArray[] = "update_datetime <= '" . $param["searchDatetimeTo"] . "'";
            }
        }


        if ($order) {
            $otherArray[] = " ORDER BY ". $order;
        }
        if (ComValidation::isNumeric($offset)) {
            $otherArray[] = " LIMIT ". $offset . ", " . $limit;
        }

        $sql = $this->makeSelectQuery("image", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;
    }


    /**
     *
     *  画像の追加
     *
     *  @param  array   $values カラム名を添え字とした更新するデータの配列
     *  @param  array   $values カラム名を添え字とした更新するデータの配列
     *  @return boolean
     */
    public function insertImageData($insertArray, $inputName) {

        if (!is_array($insertArray) || !$inputName) {
            return FALSE;
        }

        // ファイルアップロードオブジェクト作成
        $this->_fileUploadOBJ = new ComImgFileUpload($inputName);
        if ($errorMsg = $this->_fileUploadOBJ->getErrorMessage()) {
            $this->_errorMsg[] = $errorMsg;
            return FALSE;
        }
        $filename = $this->_fileUploadOBJ->getRandomFileName(D_BASE_DIR . "/" . self::IMAGE_PATH);
        // 拡張子取得
        if (!$extension = $this->_fileUploadOBJ->getExtension()) {
            $this->_errorMsg[] = "ファイル形式が違います。";
            return FALSE;
        }

        $insertArray["file_name"] = $filename;
        $insertArray["extension_type"] = $this->_fileUploadOBJ->getExtensionType();

        // ファイル保存
        if (!$this->_fileUploadOBJ->save(D_BASE_DIR . "/" . self::IMAGE_PATH, $filename . "." . $extension)) {
            $this->_errorMsg[] = "ファイルアップロードできませんでした。";
            return FALSE;
        }

        if (!$dbResultOBJ = $this->insert("image", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return FALSE;
        }
        return $dbResultOBJ;
    }

    /**
     * 画像情報の更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @param  array $fileDataArray 添付ファイル配列
     * @param  array $imageData 画像データ配列
     * @return boolean
     */
    public function updateImageData($updateArray, $whereArray, $inputName, $imageData) {

        if (!is_array($updateArray) || !is_array($whereArray) || !$inputName || !is_array($imageData)) {
            return FALSE;
        }

        // ファイルアップロードオブジェクト作成
        $this->_fileUploadOBJ = new ComImgFileUpload($inputName);
        // ファイルが上がっている
        if (!$this->_fileUploadOBJ->getErrorCode()) {
            // ファイルサイズがある
            if ($this->_fileUploadOBJ->getFileSize() < 0) {
                return FALSE;

            }
            // 拡張子取得
            if (!$extension = $this->_fileUploadOBJ->getExtension()) {
                $this->_errorMsg[] = "ファイル形式が違います。";
                return FALSE;
            }
            $updateArray["extension_type"] = $this->_fileUploadOBJ->getExtensionType();

            // ファイル保存
            if (!$this->_fileUploadOBJ->save(D_BASE_DIR . "/" . self::IMAGE_PATH, $imageData["file_name"] . "." . $extension)) {
                $this->_errorMsg[] = "ファイルアップロードできませんでした。";
                return FALSE;
            }

        }

        if (!$dbResultOBJ = $this->update("image", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }

    /**
     * 画像カテゴリーリストの取得
     *
     * @return array データ配列
     */
    public function getImageCategoryList() {

        $columnArray[] = "SQL_CALC_FOUND_ROWS *";

        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("image_category", $columnArray, $whereArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return FALSE;
        }

        // データリスト取得
        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;
    }

    /**
     *
     * 画像カテゴリーデータの取得
     *
     * @param  int $keyConvertCategoryId 画像カテゴリーID
     * @return array $data データ配列
     */
    public function getImageCategoryData($keyConvertCategoryId) {

        if (!is_numeric($keyConvertCategoryId)) {
            return FALSE;
        }

        $columnArray[] = "*";

        $whereArray[] = "id = " . $keyConvertCategoryId;
        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("image_category", $columnArray, $whereArray);

        if (!$data = $this->executeQuery($sql, "fetchRow")) {
            return FALSE;
        }

        return $data;

    }

    /**
     *
     * selectbox用画像カテゴリーコードリストの取得
     *
     * @return array $dataArray データ配列
     */
    public function getImageCategoryForSelect() {

        $columnArray[] = "*";

        $whereArray[] = "disable = 0";

        $sql = $this->makeSelectQuery("image_category", $columnArray, $whereArray);

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
     * 画像カテゴリーデータ登録
     * @param  array $aryInsertData INSERTデータ配列
     * @return boolean
     */
    public function insertImageCategoryData($insertArray) {

        if (!is_array($insertArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->insert("image_category", $insertArray)) {
            $this->_errorMsg[] = "データ登録できませんでした。";
            return false;
        }

        return $dbResultOBJ;
    }

    /**
     * 画像カテゴリーデータの更新。
     *
     * @param  array $updateArray 更新データ配列
     * @param  array $whereArray 抽出条件配列
     * @return boolean
     */
    public function updateImageCategoryData($updateArray, $whereArray = null) {

        if (!is_array($updateArray)) {
            return false;
        }

        if (!$dbResultOBJ = $this->update("image_category", $updateArray, $whereArray)) {
            $this->_errorMsg[] = "データ更新できませんでした。";
            return FALSE;
        }

        return $dbResultOBJ;
    }


}
?>