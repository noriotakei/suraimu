<?php
/**
 * ComRequest.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * リクエストデータの制御クラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      Shinichi Hata
 */

class ComRequest {

    /** パラメータ取得時に行うエスケープリスト */
    const PARAMETER_ESCAPE_LIST = "mbconvert,html,sql";

    /** @var object インスタンスを保持するstatic変数 */
    protected static $_instance = null;

    /** @var array リクエストデータタイプ */
    protected $_dataType = null;

    /** @var array リクエストデータ格納配列 */
    protected $_parameter = array();

    /**
     * インスタンスの取得。
     *
     * インスタンスが既に生成済みの場合は既存インスタンスを返し、
     * 未生成であれば新たに生成したものを返す。
     *
     * @return mixed 成功時はインスタンス、失敗時はfalseを返す
     */
    public static function getInstance() {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * リクエストデータタイプの取得。
     *
     * @return string
     */
    public function getDataType() {
        return $this->dataType;
    }

    /**
     * 基本的なエスケープ処理を行う。
     *
     * @param  mixed $value データ
     * @return mixed 処理済データ
     */
    private function basicEscapeCallback($value) {

        // 多次元配列なら再起的に呼び出す
        if (is_array($value)) {
            $value = array_map(array("self", "basicEscapeCallback"), $value);
        } else {
            // magic_quote_gpcがONの場合
            if (get_magic_quotes_gpc()) {
                $value = stripslashes($value);
            }

            // ディレクトリトラバーサル対策
            $value = preg_replace("/\\.+(\\/|\\\\)/", "", $value);
            $value = preg_replace("/\r\n/", "\n", $value);
            $value = trim($value);
        }

        return $value;
    }

    /**
     * 取得データタイプでデータを格納する
     *
     * @param string $dataType 取得するデータタイプ
     */
    public function setParameterArray($dataType = "request") {

        switch (strtolower($dataType)) {
            case "get":
                $parameter = $_GET;
                $this->_dataType = "get";
                break;
            case "post":
                $parameter = $_POST;
                $this->_dataType = "post";
                break;
            case "cookie":
                $parameter = $_COOKIE;
                $this->_dataType = "cookie";
                break;
            case "server":
                $parameter = $_SERVER;
                $this->_dataType = "server";

                break;
            case "request":
            default:
                $parameter = $_REQUEST;
                $this->_dataType = "request";
                break;
        }

        // 基本的なエスケープ処理を行った上でデータを格納する
        $this->_parameter = array_map(array("self", "basicEscapeCallback"), $parameter);


    }

    /**
     * 指定パラメータキーのリクエストデータを取得する。
     *
     * @param  string $key 取得パラメータキー
     * @param  string $escapeList エスケープリスト(カンマ区切りの文字列)
     * @return mixed 指定パラメータキーのリクエストデータ
     */
    public function getParameter($key, $escapeList = self::PARAMETER_ESCAPE_LIST, $dataType = "request") {

        // パラメータの取得、セット
        $this->setParameterArray($dataType);

        $param = array_key_exists($key, $this->_parameter) ? $this->_parameter[$key] : "" ;

        return $this->getParameterEscape($param, $escapeList);
    }

    /**
     * パラメータのエスケープしたデータを取得する。
     *
     * @param  string $param パラメータキー
     * @param  string $escapeList エスケープリスト(カンマ区切りの文字列)
     * @return mixed エスケープしたデータ
     */
    public function getParameterEscape($param, $escapeList = self::PARAMETER_ESCAPE_LIST) {

        // エスケープ処理リストの指定
        $escapeArray = explode(",", $escapeList);

        foreach ($escapeArray as $escapeType) {

            switch (strtolower($escapeType)) {
                // 絵文字変換処理
                case "emoji":
                    $param = self::encodeEmojiCallback($param);
                    break;
                // 文字コード変換処理
                case "mbconvert":
                    $param = self::mbConvertEncodingCallback($param);
                    break;
                // HTMLエンティティ変換処理
                case "html":
                    $param = self::htmlspecialcharsCallback($param);
                    break;
                // 特殊文字クォート処理
                case "sql":
                    $param = self::addslashesCallback($param);
                    break;
            }
        }

        return $param;
    }

    /**
     * 内部エンコーディングへ文字コードを変換する
     *
     * @param  mixed $value データ
     * @return mixed 処理済データ
     */
    private function mbConvertEncodingCallback($value) {

        // 内部エンコーディングの取得
        $internal = mb_internal_encoding();
        // デフォルト文字コードの取得
        $charset = ini_get("default_charset");

        // 多次元配列なら再起的に呼び出す
        if (is_array($value)) {
            $value = array_map(array("self", "mbConvertEncodingCallback"), $value);
        } else if ($internal && $charset) {

            if ($internal != mb_detect_encoding($value)) {
                // 内部エンコーディングへ変換
                $value = mb_convert_encoding($value, $internal, $charset);
            }
        }

        return $value;
    }

    /**
     * 特殊文字をHTMLエンティティに変換する
     *
     * @param  mixed $value データ
     * @return mixed 処理済データ
     */
    private function htmlspecialcharsCallback($value) {

        // 多次元配列なら再起的に呼び出す
        if (is_array($value)) {
            $value = array_map(array("self", "htmlspecialcharsCallback"), $value);
        } else {
            // HTMLエンティティへ変換
            $value = htmlspecialchars($value, ENT_QUOTES);
        }

        return $value;
    }

    /**
     * 特殊文字をクォートする。
     *
     * @param  mixed $value データ
     * @return mixed 処理済データ
     */
    private function addslashesCallback($value) {

        // 多次元配列なら再起的に呼び出す
        if (is_array($value)) {
            $value = array_map(array("self", "addslashesCallback"), $value);
        } else {
            // クォート処理
            $value = addslashes($value);
        }

        return $value;
    }

    /**
     * 全リクエストデータを取得する
     *
     * @param  string $escapeList エスケープリスト(カンマ区切りの文字列)
     * @return array 全リクエストデータ
     */
    public function getAllParameter($escapeList = self::PARAMETER_ESCAPE_LIST, $dataType = "request") {

        // パラメータの取得、セット
        $this->setParameterArray($dataType);

        $paramArray = array();

        foreach ($this->_parameter as $key => $value) {
            $paramArray[$key] = $this->getParameter($key, $escapeList);
        }

        return $paramArray;
    }

    /**
     * 指定パラメータキー以外のリクエストデータを取得する。
     *
     * @param  array $keyArray 除外パラメータキー配列
     * @param  string $escapeList エスケープリスト(カンマ区切りの文字列)
     * @return array 指定パラメータキー以外のリクエストデータ
     */
    public function getParameterExcept($keyArray, $escapeList = self::PARAMETER_ESCAPE_LIST, $dataType = "request") {

        // パラメータの取得、セット
        $this->setParameterArray($dataType);

        if (!is_array($keyArray)) {
            return false;
        }

        $paramArray = array();

        foreach ($this->_parameter as $key => $value) {
            // 指定パラメータキーでない場合
            if (!in_array($key, $keyArray)) {
                $paramArray[$key] = $this->getParameter($key, $escapeList, $dataType);
            }
        }

        return $paramArray;
    }

   /**
     * 指定パラメータキーのリクエストデータをセットする。
     *
     * @param string $key パラメータキー
     * @param mixed $value パラメータ値
     */
    public function setParameter($key, $value) {
        $this->_parameter[$key] = self::basicEscapeCallback($value);
    }

    /**
     * 指定パラメータキーのGET送信用タグを生成する。
     *
     * @param  array $keyArray パラメータキー配列
     * @param  string $prefix 接頭文字
     * @return string GET送信用タグ
     */
    public function makeGetTag($keyArray, $prefix = "") {

        if (!is_array($keyArray)) {
            return "";
        }

        $getTag = "";

        foreach ($this->_parameter as $key => $value) {
            // 指定パラメータキーの場合
            if (in_array($key, $keyArray)) {
                $getTag .= self::makeGetTagCallback($key, $value);
            }
        }

        // 接頭文字を追加
        $getTag = $prefix . $getTag;
        // 最後の余計な「&」を削除
        $getTag = rtrim($getTag, "&");

        return $getTag;
    }

    /**
     * 指定パラメータキー以外のGET送信用タグを生成する。
     *
     * @param  array $keyArray パラメータキー配列
     * @param  string $prefix 接頭文字
     * @return string GET送信用タグ
     */
    public function makeGetTagExcept($keyArray, $prefix = "") {

        if (!is_array($keyArray)) {
            return "";
        }

        $getTag = "";

        foreach ($this->_parameter as $key => $value) {
            // 指定パラメータキーの場合
            if (!in_array($key, $keyArray)) {
                $getTag .= self::makeGetTagCallback($key, $value);
            }
        }

        // 接頭文字を追加
        $getTag = $prefix . $getTag;
        // 最後の余計な「&」を削除
        $getTag = rtrim($getTag, "&");

        return $getTag;
    }

    /**
     * 指定パラメータキーのGET送信用タグを生成する。(コールバック用)
     *
     * @param string $key パラメータキー
     * @param mixed $value パラメータ値
     * @return string GET送信用タグ
     */
    private function makeGetTagCallback($key, $value, $escapeList = self::PARAMETER_ESCAPE_LIST) {

        $getTag = "";

        if (is_array($value)) {
            // 多次元配列なら再起的に呼び出す
            foreach ($value as $childKey => $childValue) {
                $childKey = $key . "[" . $childKey . "]";
                $getTag .= self::makeGetTagCallback($childKey ,$childValue);
            }
        } else {
            // 各種変換処理
            // エスケープ処理リストの指定
            $escapeArray = explode(",", $escapeList);
            foreach ($escapeArray as $escapeType) {

                switch (strtolower($escapeType)) {
                    // 絵文字変換処理
                    case "emoji":
                        $value = self::encodeEmojiCallback($value);
                        break;
                    // 文字コード変換処理
                    case "mbconvert":
                        $value = self::mbConvertEncodingCallback($value);
                        break;
                    // HTMLエンティティ変換処理
                    case "html":
                        $value = self::htmlspecialcharsCallback($value);
                        break;
                    // 特殊文字クォート処理
                    case "sql":
                        $value = self::addslashesCallback($value);
                        break;
                }
            }

            $getTag .= $key . "=" . $value . "&";
        }

        return $getTag;
    }

    /**
     * 指定パラメータキーのPOST送信用タグを生成する。
     *
     * @param  array $keyArray パラメータキー配列
     * @return string POST送信用タグ
     */
    public function makePostTag($keyArray) {

        if (!is_array($keyArray)) {
            return "";
        }

        $postTag = "";

        foreach ($this->_parameter as $key => $value) {
            // 指定パラメータキーの場合
            if (in_array($key, $keyArray)) {
                $postTag .= self::makePostTagCallback($key, $value);
            }
        }

        return $postTag;
    }

    /**
     * 指定パラメータキー以外のGET送信用タグを生成する。
     *
     * @param  array $keyArray パラメータキー配列
     * @return string POST送信用タグ
     */
    public function makePostTagExcept($keyArray) {

        if (!is_array($keyArray)) {
            return "";
        }

        $postTag = "";

        foreach ($this->_parameter as $key => $value) {
            // 指定パラメータキーの場合
            if (!in_array($key, $keyArray)) {
                $postTag .= self::makePostTagCallback($key, $value);
            }
        }

        return $postTag;
    }

    /**
     * 指定パラメータキーのPOST送信用タグを生成する。(コールバック用)
     *
     * @param string $key パラメータキー
     * @param mixed $value パラメータ値
     * @return string POST送信用タグ
     */
    private function makePostTagCallback($key, $value, $escapeList = self::PARAMETER_ESCAPE_LIST) {

        $postTag = "";

        if (is_array($value)) {
            // 多次元配列なら再起的に呼び出す
            foreach ($value as $childKey => $childValue) {
                $childKey = $key . "[" . $childKey . "]";
                $postTag .= self::makePostTagCallback($childKey ,$childValue);
            }
        } else {
            // 各種変換処理
            // エスケープ処理リストの指定
            $escapeArray = explode(",", $escapeList);
            foreach ($escapeArray as $escapeType) {

                switch (strtolower($escapeType)) {
                    // 絵文字変換処理
                    case "emoji":
                        $value = self::encodeEmojiCallback($value);
                        break;
                    // 文字コード変換処理
                    case "mbconvert":
                        $value = self::mbConvertEncodingCallback($value);
                        break;
                    // HTMLエンティティ変換処理
                    case "html":
                        $value = self::htmlspecialcharsCallback($value);
                        break;
                    // 特殊文字クォート処理
                    case "sql":
                        $value = self::addslashesCallback($value);
                        break;
                }
            }

            $postTag .= "<input type=\"hidden\" name=\"" . $key . "\" value=\"" . $value . "\" />\n";
        }
        return $postTag;
    }

    /**
     * リクエストアクション名の取得。
     *
     * @return string アクション名
     */
    public function getActionName() {

        // パラメータの取得、セット
        $this->setParameterArray();

        foreach ($this->_parameter as $key => $value) {

            if (strncmp($key, "action_", 7) === 0) {
                $actionName = str_replace("action_", "", $key);
                // 先頭1文字のみ小文字に変換
                $actionName = substr_replace($actionName, strtolower(substr($actionName, 0, 1)), 0, 1);
                break;
            }
        }

        return $actionName;
    }

    /**
     * リクエストアクションキーの取得。
     *
     * @return string アクションキー
     */
    public function getActionKey() {

        // パラメータの取得、セット
        $this->setParameterArray();

        foreach ($this->_parameter as $key => $value) {
            if (strncmp($key, "action_", 7) === 0) {
                $actionKey = $key;
                break;
            }
        }

        return $actionKey;
    }
}

