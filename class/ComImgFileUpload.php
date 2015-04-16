<?php
/**
 * ComFileUpload.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 画像ファイルのアップロードを行うクラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

class ComImgFileUpload {

    /** @var array アップロードファイル情報配列 */
    protected $_fileData = array();


    /** 拡張子配列 */
    public static $extensionTypeArray = array(
            IMAGETYPE_GIF => "gif",
            IMAGETYPE_JPEG => "jpg",
            IMAGETYPE_PNG => "png",
            IMAGETYPE_SWF => "swf",
            IMAGETYPE_SWC => "swf",     // swfがファイルによってswcと認識される場合がある
        );

    /**
     * コンストラクタ
     *
     * @param $inputName アップロード用inputタグname属性値
     */
    public function __construct($inputName) {
        // アップロードファイル情報を格納
        $this->_fileData = $_FILES[$inputName];
    }

    /**
     * アップロードファイル名を取得する。
     *
     * @return string ファイル名
     */
    public function getFileName() {
        return $this->_fileData["name"];
    }

    /**
     * アップロードファイルの拡張子タイプを取得する。
     *
     * @return int 拡張子タイプ
     */
    public function getExtensionType() {

        $imageAry = getimagesize($this->_fileData["tmp_name"]);

        //$imageAry[2]は画像の種類を意味 1.gif,2.jpg,3.png,4.swf
        if(!array_key_exists($imageAry[2], self::$extensionTypeArray)){
            return false;
        }

        return $imageAry[2];
    }

    /**
     * アップロードファイルの拡張子を取得する。
     *
     * @return mixed 拡張子
     */
    public function getExtension() {

        $extension = self::$extensionTypeArray[self::getExtensionType()];

        return $extension;
    }

    /**
     * アップロードファイルのMIMEタイプを取得する。
     *
     * @return string MIMEタイプ
     */
    public function getMimeType() {
        return $this->_fileData["type"];
    }

    /**
     * アップロードファイルのファイルサイズを取得する。
     *
     * @return integer ファイルサイズ(Byte)
     */
    public function getFileSize() {
        return $this->_fileData["size"];
    }

    /**
     * アップロード時のエラーコードを取得する。
     *
     * @return integer エラーコード
     */
    public function getErrorCode() {
        return $this->_fileData["error"];
    }

    /**
     * アップロード時のエラーメッセージを取得する。
     *
     * @return mixed エラーメッセージ
     */
    public function getErrorMessage() {

        switch ($this->_fileData["error"]) {
            case UPLOAD_ERR_INI_SIZE:
                return "php.iniに設定されたupload_max_filesize値を超えてます";
            case UPLOAD_ERR_FORM_SIZE:
                return "フォームで設定されたMAX_FILE_SIZE値を超えてます";
            case UPLOAD_ERR_PARTIAL:
                return "一部分のみしかアップロードされていません";
            case UPLOAD_ERR_NO_FILE:
                return "アップロードファイルがありません";
            default:
                return $this->_fileData["error"];
        }
    }

    /**
     * アップロード処理が正常に完了したかをチェックする。
     *
     * @return boolean
     */
    public function isCompleted() {

        if ($this->_fileData["tmp_name"] && $this->_fileData["error"] === UPLOAD_ERR_OK) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * アップロードファイルを保存する。
     *
     * @param  string $dirPath 保存先ディレクトリ
     * @param  string $fileName ファイル名
     * @param  string $permission ファイル属性
     * @return boolean
     */
    public function save($dirPath, $fileName = null, $permission = 0777) {

        if (!$this->isCompleted()) {
            return false;
        }

        if (!$fileName) {
            // ファイル名指定がなければランダムファイル名を指定
            $fileName = self::getRandomFileName($dirPath) . "." . self::getExtension();
        }

        // 一時ファイルを保存先に移動する
        if (!move_uploaded_file($this->_fileData["tmp_name"], $dirPath . $fileName)) {
            return false;
        }

        // ファイル属性の変更
        if (!chmod($dirPath . $fileName, $permission)) {
            return false;
        }

        return true;
    }

    /**
     * ランダムなファイル名を取得する。
     *
     * @param  string $dirPath 保存先ディレクトリ
     * @return string ファイル名
     */
    public function getRandomFileName($dirPath = null) {

        // 保存先ディレクトリが指定されている場合
        if ($dirPath) {
            // ファイル名がユニークになるまでループ
            do {
                $randomFileName = md5(microtime());
            } while (file_exists($dirPath . $randomFileName . "." . self::getExtension()));
        } else {

            $randomFileName = md5(microtime());
        }

        return $randomFileName;
    }

    /**
     * 重複していないファイル名を取得する。
     *
     * @param  string $dirPath 保存先ディレクトリ
     * @return string ファイル名
     */
    public function getDuplicateFileName($dirPath = null, $fileName = null) {

        if (strpos($fileName, ".") === 0) {
             $fileName = "";
        }

        if (!$fileName) {
            $fileName = $this->getFileName();
        }

        // 保存先ディレクトリが指定されている場合
        if ($dirPath AND file_exists($dirPath . $fileName)) {
            $this->_fileData["error"] = "ファイル名が重複しています。";
            return FALSE;
        }

        return (strpos($fileName, ".") !== false) ? substr($fileName, 0, strpos($fileName, ".")) : $fileName;
    }
}

?>
