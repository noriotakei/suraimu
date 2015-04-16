<?php
/**
 * ComArrayValidation.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 配列データの妥当性をチェックするクラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      Shinichi Hata
 */

class ComArrayValidation extends ComValidation {

    /** @var array データ格納配列 */
    protected $_array = array();

    /** @var array エラーメッセージ格納配列 */
    private $_errorMessage = array();

    /**
     * コンストラクタ
     */
    public function __construct($array) {
        $this->_array = $array;
    }

    /**
     * 配列データに対して、Validationクラス内のチェックメソッドを実行する。
     *
     * 使用可能メソッド  : 指定するキー名                     : 実行結果
     * ---------------------------------------------------------------------------------------------
     * isEmpty           : Empty or empty                     : 入力がなければtrue
     * isValue           : Value or value                     : 入力があればtrue
     * isNumeric         : Numeric or numeric                 : 数値文字であればtrue
     * isInt             : Int or int                         : 整数型であればtrue
     * isFloat           : Float or float                     : 浮動小数点型であればtrue
     * isString          : String or string                   : 文字列型であればtrue
     * isArray           : Array or array                     : 配列型であればtrue
     * isObject          : Object or object                   : オブジェクト型であればtrue
     * isBetween         : Between or between                 : 指定範囲内であればtrue
     * isWithin          : Within or within                   : 指定バイト数以内であればtrue
     * isMbWithin        : MbWithin or mbWithin               : 指定文字数以内であればtrue
     * isDate            : Date or date                       : 日付として有効であればtrue
     * isTime            : Time or time                       : 時間として有効であればtrue
     * isDateTime        : DateTime or dateTime               : 日時として有効であればtrue
     * isHiragana        : Hiragana or hiragana               : ひらがなであればtrue
     * isKatakana        : Katakana or katakana               : かたかなであればtrue
     * isAlphabet        : Alphabet or alphabet               : アルファベットであればtrue
     * isAlnum           : Alnum or alnum                     : 英数字であればtrue
     * isMobileAddress   : MobileAddress or mobileAddress     : 携帯メールアドレスであればtrue
     * isMailAddress     : MailAddress or mailAddress         : メールアドレスであればtrue
     * isTelephoneNumber : TelephoneNumber or telephoneNumber : 電話番号であればtrue
     * isUrl             : Url or url                         : URLであればtrue
     * isMobileAgent     : MobileAgent or mobileAgent         : 携帯ユーザーエージェントであればtrue
     * isFromName        : FromName or fromName               : 送信者名が正しければtrue
     * ---------------------------------------------------------------------------------------------
     *
     * ※メタキャラクタについて
     * [.]でキーまたは文字列を繋ぐと、連結した値でチェックを行います。
     * [/]で括られた文字はキー名ではなく、文字列として扱います。
     * 文字列に[/][.]を使いたい場合は[\/][\.]とすることで使用可能です。
     *
     * 使用例：
     *
     * check("name", "名前",
     *       array("Value" => null),
     *       array("Value" => "名前を入力してください"));
     *
     * 単純な名前の入力チェックのみを行う。
     * チェックメソッドがに引数を必要としない場合は「null」を指定する。
     *
     * check(array("mail_address" => "mail_address_1./@/.mail_address_2"), "メールアドレス",
     *       array("Value" => null, "MailAddress" => null));
     *
     * 「mail_address_1」と「mail_address_2」の各要素を
     * 「@」で連結した値を「mail_address」のチェックとして行う。
     *
     * @param  mixed  $key キー名
     * @param  string $name 項目名
     * @param  array  $methodArray チェックメソッド名配列
     * @param  array  $errorArray 個別エラーメッセージ配列
     * @return void
     */
    public function check($key, $name, $methodArray, $errorArray = null) {

        // 配列によるチェックキー名指定の場合
        if (is_array($key)) {

            // 1番目の配列要素を取り出す
            list($alias, $keyString) = each($key);
            // チェックキー名の要素を取得
            $param = $this->getParam($keyString);

            unset($key);
            // 別名をキー名にする
            $key = $alias;

        // 文字列によるチェックキー名指定の場合
        } else {
            // チェックキー名の要素を取得
            $param = $this->getParam($key);
        }

        foreach ($methodArray as $method => $args) {

            // チェックメソッド名の生成
            $func = "is" . ucfirst($method);
            // 引数用変数の初期化
            $argStr = "";

            // 引数なし(null指定)の場合
            if (is_null($args)) {
                $argStr .= "\$param";
            } else {
                // 引数を「-」区切りから「,」区切りに
                $argArray = explode("-", $args);
                $tmpStr   = implode(",", $argArray);
                // 引数の追加
                $argStr  .= "\$param," . $tmpStr;
            }

            // チェックメソッドの実行
            eval("\$validation = parent::$func($argStr);");

            // エラーが返った場合
            if ($validation === false) {

                if (isset($errorArray[$method])) {
                    // 個別エラーメッセージの指定
                    $this->_errorMessage[$key] = $errorArray[$method];
                } else {
                    // デフォルトエラーメッセージの指定
                    $this->setDefaultErrorMessage($key, $name, $method ,$args);
                }
                break;
            }
        }
    }

    /**
     * 指定キーの要素を取得する。
     *
     * キー名指定は[/]や[.]などで連結したものも指定可能。
     *
     * @param  string $keyString キー名
     * @return mixed 指定キーの要素
     */
    private function getParam($keyString) {

        if (!$keyString) {
            return false;
        }

        // エスケープされたドット[\.]以外のドット[.]で分割
        $keyArray = preg_split("/(?<![\\\\])\./", $keyString);
        // エスケープされたドットは文字として扱うので通常のドットへ戻す
        $keyArray = preg_replace("/[\\\\]\./", ".", $keyArray);
        // スラッシュ[/]で括られた配列を取得(文字列扱い)
        $stringArray = preg_grep("/(?<![\\\\])\/.*(?<![\\\\])\//", $keyArray);

        $param = "";
        foreach ($keyArray as $key => $keyName) {

            // 文字列扱いされている場合
            if (isset($stringArray[$key])) {
                // 前後のスラッシュ[/]を削除し、エスケープされたスラッシュ[\/]を通常のスラッシュへ戻す
                $param .= preg_replace(array("/(?<![\\\\])\//", "/[\\\\]\//"), array("", "/"), $stringArray[$key]);

            // 指定キーの要素が配列の場合
            } else if (is_array($this->_array[$keyName])) {
                $param = $this->_array[$keyName];

            // 通常は指定キーの要素を配列から取り出す
            } else {
                $param .= $this->_array[$keyName];
            }
        }

        return $param;
    }

    /**
     * デフォルトのエラーメッセージをセットします。
     *
     * @param  string $key キー名
     * @param  string $name 項目名
     * @param  string $method チェックメソッド名
     * @param  string $args 引数(複数指定の場合は「-」区切り)
     * @return boolean
     */
    private function setDefaultErrorMessage($key, $name, $method, $args) {

        if (!$key || !$name || !$method) {
            return false;
        }

        // チェックメソッド別デフォルトエラーメッセージの指定
        switch (strtolower($method)) {
            case "empty":
                $this->_errorMessage[$key] = $name . "の入力があります";
                break;
            case "value":
                $this->_errorMessage[$key] = $name . "の入力がありません";
                break;
            case "numeric":
                $this->_errorMessage[$key] = $name . "は数字で入力してください";
                break;
            case "int":
                $this->_errorMessage[$key] = $name . "は整数ではありません";
                break;
            case "float":
                $this->_errorMessage[$key] = $name . "は浮動小数点ではありません";
                break;
            case "string":
                $this->_errorMessage[$key] = $name . "は文字列ではありません";
                break;
            case "array":
                $this->_errorMessage[$key] = $name . "は配列ではありません";
                break;
            case "object":
                $this->_errorMessage[$key] = $name . "はオブジェクトではありません";
                break;
            case "between":
                list($min, $max) = explode("-", $args);
                $this->_errorMessage[$key] = $name . "は" . $min . "以上"
                                          . $max . "以内で入力してください";
                break;
            case "within":
                $this->_errorMessage[$key] = $name . "は半角" . $args . "文字(全角"
                                          . floor($args / 2) . "文字)以内で入力してください";
                break;
            case "mbwithin":
                $this->_errorMessage[$key] = $name . "は" . $args . "文字以内で入力してください";
                break;
            case "date":
                $this->_errorMessage[$key] = $name . "は有効な日付ではありません";
                break;
            case "time":
                $this->_errorMessage[$key] = $name . "は有効な時間ではありません";
                break;
            case "datetime":
                $this->_errorMessage[$key] = $name . "は有効な日時ではありません";
                break;
            case "hiragana":
                $this->_errorMessage[$key] = $name . "はひらがなで入力してください";
                break;
            case "katakana":
                $this->_errorMessage[$key] = $name . "はカタカナで入力してください";
                break;
            case "alphabet":
                $this->_errorMessage[$key] = $name . "はアルファベットで入力してください";
                break;
            case "alnum":
                $this->_errorMessage[$key] = $name . "は英数字で入力してください";
                break;
            case "mobileaddress":
                $this->_errorMessage[$key] = $name . "は有効な携帯のメールアドレスではありません";
                break;
            case "mailaddress":
                $this->_errorMessage[$key] = $name . "は有効なメールアドレスではありません";
                break;
            case "telephonenumber":
                $this->_errorMessage[$key] = $name . "は有効な電話番号ではありません";
                break;
            case "url":
                $this->_errorMessage[$key] = $name . "は有効なURLではありません";
                break;
            case "fromname":
                $this->_errorMessage[$key] = $name . "に不正な文字が含まれてます";
                break;
        }

        return true;
    }

    /**
     * エラーの有無をチェックする
     *
     * @param  string $key キー名
     * @return boolean
     */
    public function isError($key = null) {

        // キー指定がある場合
        if ($key) {
            if (isset($this->_errorMessage[$key])) {
                return true;
            } else {
                return false;
            }
        // キー指定がない場合
        } else {
            if (count($this->_errorMessage)) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * エラーメッセージを取得する。
     *
     * @param  string $key キー名
     * @return mixed
     */
    public function getErrorMessage($key = null) {

        // キー指定がある場合
        if ($key) {
            return $this->_errorMessage[$key];
        // キー指定がない場合
        } else {
            return $this->_errorMessage;
        }
    }

    /**
     * 指定キーのエラーメッセージをセットする。
     *
     * @param  string $key キー名
     * @param  string $message メッセージ内容
     * @return boolean
     */
    public function setErrorMessage($key, $message) {

        if (!$key || !$message) {
            return false;
        }

        // キー指定
        $this->_errorMessage[$key] = $message;

        return true;
    }
}

?>
