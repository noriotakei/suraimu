<?php
/**
 * ComValidation.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */


/**
 * 入力チェックを行う関数群を扱うクラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

class ComValidation {

    /**
     * 指定された値が、空であるかをチェックする。
     *
     * @param  string $str 文字列
     * @return boolean 空ならばtrue、そうでなければfalseを返す
     */
    public static function isEmpty($str) {

        if ($str === null || $str === "") {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 指定された値が、空でないかをチェックする。
     *
     * @param  string $str 文字列
     * @return boolean 空でなければtrue、そうでなければfalseを返す
     */
    public static function isValue($str) {

        if ($str !== null && $str !== "") {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 指定された値が、数値として扱えるかをチェックする。
     *
     * @param  string $str 文字列
     * @return boolean 数値として扱えればtrue、そうでなければfalseを返す
     */
    public static function isNumeric($str) {
        return is_numeric($str);
    }

    /**
     * 指定された値が、整数型であるかをチェックする。
     *
     * @param  string $str 文字列
     * @return boolean 整数型ならばtrue、そうでなければfalseを返す
     */
    public static function isInt($str) {
        return is_int($str);
    }

    /**
     * 指定された値が、浮動小数型点型であるかをチェックする。
     *
     * @param  string $str 文字列
     * @return boolean 浮動小数点型ならばtrue、そうでなければfalseを返す
     */
    public static function isFloat($str) {
        return is_float($str);
    }

    /**
     * 指定された値が、文字列型であるかをチェックする。
     *
     * @param  string $str 文字列
     * @return boolean 文字列型ならばtrue、そうでなければfalseを返す
     */
    public static function isString($str) {
        return is_string($str);
    }

    /**
     * 指定された値が、配列型であるかをチェックする。
     *
     * @param  string $str 文字列
     * @return boolean 配列型ならばtrue、そうでなければfalseを返す
     */
    public static function isArray($str) {
        return is_array($str);
    }

    /**
     * 指定された値が、オブジェクト型であるかをチェックする。
     *
     * @param  string $str 文字列
     * @return boolean オブジェクト型ならばtrue、そうでなければfalseを返す
     */
    public static function isObject($str) {
        return is_object($str);
    }

    /**
     * 指定された値が、特定の範囲内であるかをチェックする。
     *
     * @param  integer $int 整数
     * @param  integer $min 最小値
     * @param  integer $max 最大値
     * @return boolean 範囲内ならばtrue、そうでなければfalseを返す
     */
    public static function isBetween($int, $min, $max) {

        if ($int >= $min && $int <= $max) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 指定された値が、指定バイト数以内かどうかチェックする。
     *
     * @param  string $str 文字列
     * @param  integer $maxLength 指定最大バイト数
     * @param  boolean $countLf 改行をカウントするか
     * @return boolean 指定バイト数以内であればtrue、なければfalseを返す
     */
    public static function isWithin($str, $maxLength, $countLf = false) {

        // 改行をカウントしない場合
        if (!$countLf) {
            $str = str_replace("\n", "", $str);
        }

        // 絵文字は1文字計算
        $str = self::convertEmojiCodeToByte($str);

        if (strlen($str) <= $maxLength) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 指定された値が、指定文字数以内かどうかチェックする。
     *
     * @param  string $str 文字列
     * @param  integer $maxLength 指定最大文字数
     * @param  boolean $countLf 改行をカウントするか
     * @param  string $encoding 文字エンコーディング
     * @return boolean 指定文字数以内であればtrue、なければfalseを返す
     */
    public static function isMbWithin($str, $maxLength, $countLf = false, $encoding = "UTF-8") {

        // 改行をカウントしない場合
        if (!$countLf) {
            $str = str_replace("\n", "", $str);
        }

        // 絵文字は1文字計算
        $str = self::convertEmojiCodeToByte($str);

        if (mb_strlen($str, $encoding) <= $maxLength) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 日付の妥当性チェックする。
     *
     * 引数1つの場合
     * @param  string $date 年月日(yyyy-mm-dd)
     * 引数3つの場合
     * @param  integer $year 年
     * @param  integer $month 月
     * @param  integer $day 日
     * @return boolean 妥当性OKならtrue、NGはfalseを返す
     */
    public static function isDate() {
        // 引数の数と引数リストを取得
        $numArgs = func_num_args();
        $argList = func_get_args();

        // 1つなら文字列指定
        if ($numArgs == 1) {
            list($year, $month, $day) = @explode("-", $argList[0], 3);
            $year  = (int)$year;
            $month = (int)$month;
            $day   = (int)$day;
        // 3つなら年月日個別指定
        } else if ($numArgs == 3) {
            $year  = (int)$argList[0];
            $month = (int)$argList[1];
            $day   = (int)$argList[2];
        } else {
            return false;
        }

        return checkdate($month, $day, $year);
    }

    /**
     * 時間の妥当性チェックする。
     *
     * 引数1つの場合
     * @param  string $time 時分秒(hh:mm:ss)
     * 引数3つの場合
     * @param  interger $hour 時
     * @param  interger $min 分
     * @param  interger $sec 秒
     * @return boolean 妥当性OKならtrue、NGはfalseを返す
     */
    public static function isTime() {

        // 引数の数と引数リストを取得
        $numArgs = func_num_args();
        $argList = func_get_args();

        // 1つなら文字列指定
        if ($numArgs == 1) {
            list($hour, $min, $sec) = @explode(":", $argList[0], 3);
            // 数字でない
            if (!self::isNumeric($hour) ||
                !self::isNumeric($min) ||
                !self::isNumeric($sec)) {
                return false;
            }
        // 3つなら時分秒個別指定
        } else if ($numArgs == 3) {
            $hour = $argList[0];
            $min  = $argList[1];
            $sec  = $argList[2];

            // 数字でない
            if (!self::isNumeric($hour) ||
                !self::isNumeric($min) ||
                !self::isNumeric($sec)) {
                return false;
            }
        } else {
            return false;
        }

        if (($hour < 0 || $hour > 23) ||
            ($min < 0 || $min > 59) ||
            ($sec < 0 || $sec > 59)) {
            return false;
        }

        return true;
    }

    /**
     * 日時の妥当性チェックする。
     *
     * 引数1つの場合
     * @param  string $datetime 年月日時分秒(yyyy-mm-dd hh:mm:ss)
     * 引数6つの場合
     * @param  integer $year 年
     * @param  integer $month 月
     * @param  integer $day 日
     * @param  integer $hour 時
     * @param  integer $min 分
     * @param  integer $sec 秒
     * @return boolean 妥当性OKならtrue、NGはfalseを返す
     */
    public static function isDateTime() {

        // 引数の数と引数リストを取得
        $numArgs = func_num_args();
        $argList = func_get_args();

        // 1つなら文字列指定
        if ($numArgs == 1) {
            list($date, $time) = @explode(" ", $argList[0], 2);
        // 6つなら年月日時分秒個別指定
        } else if ($numArgs == 6) {
            $year  = $argList[0];
            $month = $argList[1];
            $day   = $argList[2];
            $hour  = $argList[3];
            $min   = $argList[4];
            $sec   = $argList[5];

            $date = $year . "-" . $month . "-" . $day;
            $time = $hour . ":" . $min . ":" . $sec;
        } else {
            return false;
        }

        if (self::isDate($date) && self::isTime($time)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 指定された値が、ひらがなかどうかチェックする。
     *
     * @param  string $str 文字列
     * @param  boolean $allowSpace スペース許可フラグ
     * @return boolean ひらがなであればtrue、なければfalseを返す
     */
    public static function isHiragana($str, $allowSpace = true) {

        // 正規表現文字列
        $regexStr = "/^[ぁ-ん]+$/u";

        // スペース許可の場合、文字中のスペースを削除
        if ($allowSpace) {
            $str = str_replace("　", " ", $str);
            $str = preg_replace("/\s/", "", $str);
        }

        if (preg_match($regexStr, $str)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 指定された値が、カタカナかどうかチェックする。
     *
     * @param  string $str 文字列
     * @param  string $strClass 全半角識別文字列
     * @param  boolean $allowSpace スペース許可フラグ
     * @return boolean カタカナであればtrue、なければfalseを返す
     */
    public static function isKatakana($str, $strClass = "all", $allowSpace = true) {

        switch (strtolower($strClass)) {
            // 半角ｶﾅ
            case "hankaku":
                $regexStr = "/^[｡-ﾟ]+$/u";
                break;
            // 全角カナ
            case "zenkaku":
                $regexStr = "/^[ァ-ヴー]+$/u";
                break;
            case "all":
                // break;
            default:
                $regexStr = "/^([｡-ﾟ]|[ァ-ヴー])+$/u";
                break;
        }

        // スペース許可の場合、文字中のスペースを削除
        if ($allowSpace) {
            $str = str_replace("　", " ", $str);
            $str = preg_replace("/\s/", "", $str);
        }

        if (preg_match($regexStr, $str)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 指定された値が、アルファベットかどうかチェックする。
     *
     * @param  string $str 文字列
     * @param  string $strClass マッチ対象文字クラス
     * @return boolean 対象クラスのアルファベットであればtrue、なければfalseを返す
     */
    public static function isAlphabet($str, $strClass = "alpha") {

        switch (strtolower($strClass)) {
            // 小文字
            case "lower":
                $regexStr = "/^[a-z]+$/";
                break;
            // 大文字
            case "upper":
                $regexStr = "/^[A-Z]+$/";
                break;
            case "alpha":
                // break;
            default:
                $regexStr = "/^[a-zA-Z]+$/";
                break;
        }

        if (preg_match($regexStr, $str)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 指定された値が、英数字かどうかチェックする。
     *
     * @param  string $str 文字列
     * @return boolean 英数字であればtrue、なければfalseを返す
     */
    public static function isAlnum($str) {

        if (ctype_alnum($str)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 指定された値が、携帯のメールアドレスかどうかチェックする。
     *
     * @param  string $str 文字列
     * @return boolean 携帯のメールアドレスであればtrue、なければfalseを返す
     */
    public static function isMobileAddress($str) {

        // モバイルドメインリスト
        $regexMailList = array(
            "docomo\.ne\.jp",
            "ezweb\.ne\.jp",
            "[dhtrcknsq]\.vodafone\.ne\.jp",
            "softbank\.ne\.jp",
            "i\.softbank\.jp",
            "disney\.ne\.jp",
        );

        // @以降の文字列を取得
        $mailHost = substr(strstr($str, "@"), 1);

        // 正規表現文字列
        $regexStr = "/^[-+.?\/\w]+@(" . implode("|", $regexMailList) . ")$/";

        if (preg_match($regexStr, strtolower($str)) && self::checkMXRecode($mailHost)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 指定された値が、メールアドレスかどうかチェックする。
     *
     * @param  string $str 文字列
     * @return boolean メールアドレスであればtrue、なければfalseを返す
     */
    public static function isMailAddress($str) {

        // @以降の文字列を取得
        $mailHost = substr(strstr($str, "@"), 1);

        // 正規表現文字列
        $regexStr = "/^[-+.\/\w]+@([\w])+([\w\._-])*\.([a-zA-Z])+$/";

        if (preg_match($regexStr, $str) && self::checkMXRecode($mailHost)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 指定された値が、電話番号かどうかチェックする。
     *
     * @param  string $str 文字列
     * @return boolean 電話番号であればtrue、なければfalseを返す
     */
    public static function isTelephoneNumber($str) {

        // ハイフンの排除
        $telNo = str_replace("-", "", $str);

        // 正規表現文字列
        $regexStr = "/^0[0-9]{8,10}$/";

        if (preg_match($regexStr, $telNo)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 指定された値が、URLかどうかチェックする。
     *
     * @param  string $str 文字列
     * @return boolean URLであればtrue、なければfalseを返す
     */
    public static function isUrl($str) {

        // 正規表現文字列
        $regexStr = "/^https?:\/\/[-_.!~*'()a-zA-Z0-9;\/?:@&=+\$,%#]+$/";

        if (preg_match($regexStr, $str)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 携帯のユーザーエージェントかどうかチェックする。
     *
     * @return boolean 携帯のユーザーエージェントであればtrue、なければfalseを返す
     */
    public static function isMobileAgent($httpUserAgent) {

        if (!$httpUserAgent) {
            return false;
        }

        $eregAgentList = array(
            "DoCoMo\/1\.0", // docomo(move)
            "DoCoMo\/2\.0", // docomo(foma)
            "KDDI",         // au(WAP2.0)
            "UP\.Browser",  // au(HDMLブラウザ搭載端末)
            "J-PHONE",      // j-phone
            "Vodafone",     // vodafone
            "Softbank",     // softbank
            "MOT-[CV]980",  // vodafone(モトローラー)
        );

        // 正規表現文字列
        $regexStr = "/^" . implode("|", $eregAgentList) . "/";

        if (preg_match($regexStr, $httpUserAgent)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 指定された値が、MXレコードとして有効かどうかチェックする。
     *
     * @param  string $host ホスト名またはIPアドレス
     * @return boolean 有効なホストであればtrue、なければfalseを返す
     */
    public static function checkMXRecode($host) {
        return checkdnsrr($host, "MX");
    }

    /**
     * 内部エンコード済み絵文字コードを1バイト文字に変換する。
     *
     * @param  string $str 文字列
     * @return string 変換後の文字列
     */
    public static function convertEmojiCodeToByte($str) {
        return preg_replace("/%[ies]\d{1,4}%/", "e", $str);
    }

    /**
     * 配列に対して指定した関数を実行しチェックを行う。
     *
     * isset、emptyなどは言語構造のため可変関数で使用できません。
     *
     * @param  array $array 配列
     * @param  string $func 関数名(is_numericとか)
     * @return boolean すべての配列がOKならtrue、一部でもNGならfalseを返す
     */
    public static function checkArray($array, $func = "empty") {

        // 引数チェック
        if (!is_array($array) || !$func) {
            return false;
        }

        if ($func == "empty") {
            foreach ($array as $value) {
                if (empty($value)){
                    return false;
                }
            }
        } else {
            // 関数チェック
            if (function_exists($func) === false) {
                return false;
            }

            foreach ($array as $value) {
                if (!$func($value)){
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * 指定された送信者名に、不正なタグが無いかどうかチェックする。
     *
     * @param  string $str 送信者名
     * @return boolean 不正文字がなければtrue、あればfalseを返す
     */
    public static function isFromName($str) {

        // 正規表現文字列
        $regexStr = "/([<>]+)|([【】]+)|([≪≫]+)/u";

        if (preg_match($regexStr, htmlspecialchars_decode($str))) {
            return false;
        } else {
            return true;
        }
    }
}

?>
