<?php
/**
 * KeyConvert.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * システム変換を行うクラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

class KeyConvert extends ComCommon {

    /** @var int 再起カウント */
    protected $_callBackCnt = 0;

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
     * execConvertメソッド
     *
     * コンバート実行(execKeyConvertとexecArrayConvertの両方を実行)
     *
     * @param  string  $convertText コンバートするテキスト
     * @param  integer $userId      ユーザーid
     * @param  array   $dataArray   変換対象の配列(array[%key]=>convertValue)
     * @return string  $convertText コンバート後テキスト
     */
    public function execConvert($convertText, $userId = FALSE, $dataArray = FALSE) {

        if (!$convertText) {
            return $convertText;
        }

        // 変換内容の取得
        $convertData = $this->convertSettingData();
        if ($userId) {
            $convertData = $convertData + $this->convertUserData($userId);
        }
        if ($dataArray) {
            $dataArray = $dataArray + $convertData;
        } else {
            $dataArray = $convertData;
        }
        // アレンジ変換(通常)
        $dataArray = $this->convertArrangeData($dataArray);

        if ($userId) {
            // アレンジ変換(ユーザー情報)
            $dataArray = $this->convertArrangeUserData($dataArray);
        }
        if ($dataArray){
            $convertText = self::execReplace($dataArray, $convertText);
        }

        // 残っている-%-を削除
        $convertText = preg_replace("/-%.*?-/", "", $convertText);

        return $convertText;
    }

    /**
     * execConvertArrayメソッド
     *
     * コンバート実行(配列型)(execKeyConvertArrayとexecArrayConvertの両方を実行)
     *
     * @param  array  $convertArrayText コンバートするテキスト配列
     * @param  integer $userId      ユーザーid
     * @param  array   $dataArray   変換対象の配列(array[%key]=>convertValue)
     * @return array  $convertArrayText コンバート後テキスト配列
     */
    public function execConvertArray($convertArrayText, $userId = FALSE, $dataArray = FALSE) {

        if (!is_array($convertArrayText)) {
            return $convertArrayText;
        }

        // 変換内容の取得
        $convertData = $this->convertSettingData();
        if ($userId) {
            $convertData = $convertData + $this->convertUserData($userId);
        }
        if ($dataArray) {
            $dataArray = $dataArray + $convertData;
        } else {
            $dataArray = $convertData;
        }
        // アレンジ変換(通常)
        $dataArray = $this->convertArrangeData($dataArray);

        if ($userId) {
            // アレンジ変換(ユーザー情報)
            $dataArray = $this->convertArrangeUserData($dataArray);
        }
        if ($dataArray){
            foreach ($convertArrayText as $key => $val) {
                $convertArrayText[$key] = self::execReplace($dataArray, $val);
            }
        }

        // 残っている-%-を削除
        foreach ($convertArrayText as $key => $val) {
            $convertArrayText[$key] = preg_replace("/-%.*?-/", "", $val);
        }

        return $convertArrayText;
    }

    /**
     * execConvertAllArrayメソッド
     *
     * コンバート実行(完全配列型)(execKeyConvertArrayとexecArrayConvertの両方を実行)
     *
     * @param  array  $convertArrayText コンバートするテキスト配列
     * @param  integer $userId      ユーザーid
     * @param  array   $dataArray   変換対象の配列(array[0][%key]=>convertValue)
     * @return array  $convertArrayText コンバート後テキスト配列
     */
    public function execConvertAllArray($convertArrayText, $userId = FALSE, $dataArray = FALSE) {

        if (!is_array($convertArrayText)) {
            return $convertArrayText;
        }

        // 変換内容の取得
        $convertData = $this->convertSettingData();
        if ($userId) {
            $convertData = $convertData + $this->convertUserData($userId);
        }

        if ($convertData){
            foreach ($convertArrayText as $key => $val) {
                if ($dataArray[$key]) {
                    $dataArray[$key] = $dataArray[$key] + $convertData;
                } else {
                    $dataArray[$key] = $convertData;
                }
            }
            // アレンジ変換(通常)
            $dataArray = $this->convertArrayArrangeData($dataArray);

            if ($userId) {
                // アレンジ変換(ユーザー情報)
                $dataArray = $this->convertArrayArrangeUserData($dataArray);
            }
        }
        if ($dataArray){
            foreach ($convertArrayText as $key => $val) {
                $convertArrayText[$key] = self::execReplace($dataArray[$key], $val);
            }
        }

        // 残っている-%-を削除
        foreach ($convertArrayText as $key => $val) {
            $convertArrayText[$key] = preg_replace("/-%.*?-/", "", $val);
        }

        return $convertArrayText;
    }

    /**
     * keyConvertDataメソッド
     *
     * 変換内容の取得
     *
     * @param  integer $type タイプ
     * @return array $dataList 変換内容配列
     */
    public function keyConvertData($type) {

        if (!ComValidation::isNumeric($type)) {
            return FALSE;
        }

        // 変換内容の取得
        $subColumnArray[] = "*";

        $subWhereArray[] = "display_start_datetime <= '" . date("Y-m-d H:i:s") . "'";
        $subWhereArray[] = "(display_end_datetime >= '" . date("Y-m-d H:i:s") . "' OR display_end_datetime = '0000-00-00 00:00:00')";
        $subWhereArray[] = "disable = 0";

        $subOtherArray[] = "ORDER BY id DESC";

        $subSql = $this->makeSelectQuery("key_convert_contents", $subColumnArray, $subWhereArray, $subOtherArray);

        $columnArray[] = "kcl.key_name";
        $columnArray[] = "kcc.contents";

        $whereArray[] = "kcl.type = " . $type;
        $whereArray[] = "kcl.id = kcc.key_convert_list_id";
        $whereArray[] = "kcl.disable = 0";

        $otherArray[] = "GROUP BY kcl.id";

        $sql = $this->makeSelectQuery("key_convert_list kcl, (" . $subSql . ") kcc", $columnArray, $whereArray, $otherArray);

        if (!$dbResultOBJ = $this->executeQuery($sql)) {
            return $convertText;
        }

        $dataList = $this->fetchAll($dbResultOBJ);

        return $dataList;
    }

    /**
     * convertArrangeUserDataメソッド
     *
     * アレンジ変換(ユーザー情報)データを取得
     *
     * @param array $replaceData 変換対象の連想配列(array[user_id]=>3)
     * @return array $replaceData コンバート配列
     */
    protected function convertArrangeUserData($replaceData) {

        if (!is_array($replaceData)) {
            return FALSE;
        }
        $configArray = $this->_configOBJ->toArray();
        // 変換内容の取得
        $dataList = self::keyConvertData($this->_configOBJ->define->CONVERT_TYPE_ARRANGE);

        if ($dataList) {
            while ($data = array_shift($dataList)) {
                $contents = self::execReplace($replaceData, htmlspecialchars_decode($data["contents"], ENT_QUOTES));
                eval('$replaceData[$data["key_name"]] =' . $contents . ';');
            }
        }

        return $replaceData;
    }

    /**
     * convertArrayArrangeUserDataメソッド
     *
     * アレンジ変換(ユーザー情報)データを取得(配列型)
     *
     * @param array $replaceData 変換対象の連想配列(array[user_id]=>3)
     * @return array $replaceData コンバート配列
     */
    protected function convertArrayArrangeUserData($replaceData) {

        if (!is_array($replaceData)) {
            return FALSE;
        }
        $configArray = $this->_configOBJ->toArray();
        // 変換内容の取得
        $dataList = self::keyConvertData($this->_configOBJ->define->CONVERT_TYPE_ARRANGE);
        if ($dataList) {
            while ($data = array_shift($dataList)) {
                foreach ($replaceData as $key => $val) {
                    $contents = self::execReplace($val, htmlspecialchars_decode($data["contents"], ENT_QUOTES));
                    eval('$replaceData[$key][$data["key_name"]] =' . $contents . ';');
                }
            }
        }

        return $replaceData;
    }

    /**
     * convertArrangeDataメソッド
     *
     * アレンジ変換データを取得
     *
     * @param array $replaceData 変換対象の連想配列(array[user_id]=>3)
     * @return array $replaceData コンバート配列
     */
    protected function convertArrangeData($replaceData) {

        if (!is_array($replaceData)) {
            return FALSE;
        }
        $configArray = $this->_configOBJ->toArray();
        // 変換内容の取得
        $dataList = self::keyConvertData($this->_configOBJ->define->CONVERT_TYPE_NORMAL_ARRANGE);

        if ($dataList) {
            while ($data = array_shift($dataList)) {
                $contents = self::execReplace($replaceData, htmlspecialchars_decode($data["contents"], ENT_QUOTES));
                eval('$replaceData[$data["key_name"]] =' . $contents . ';');
            }
        }

        return $replaceData;
    }

    /**
     * convertArrayArrangeDataメソッド
     *
     * アレンジ変換データを取得(配列型)
     *
     * @param array $replaceData 変換対象の連想配列(array[user_id]=>3)
     * @return array $replaceData コンバート配列
     */
    protected function convertArrayArrangeData($replaceData) {

        if (!is_array($replaceData)) {
            return FALSE;
        }
        $configArray = $this->_configOBJ->toArray();
        // 変換内容の取得
        $dataList = self::keyConvertData($this->_configOBJ->define->CONVERT_TYPE_NORMAL_ARRANGE);
        if ($dataList) {
            while ($data = array_shift($dataList)) {
                foreach ($replaceData as $key => $val) {
                    $contents = self::execReplace($val, htmlspecialchars_decode($data["contents"], ENT_QUOTES));
                    eval('$replaceData[$key][$data["key_name"]] =' . $contents . ';');
                }
            }
        }

        return $replaceData;
    }

    /**
     * convertSettingDataメソッド
     *
     * convert_listテーブルにて設定されたものを取得
     *
     * @return array $convertArray コンバート配列
     */
    protected function convertSettingData() {

        // 変換内容の取得
        $dataList = self::keyConvertData($this->_configOBJ->define->CONVERT_TYPE_SITE_DEFAULT);
        if ($dataList) {
            while ($data = array_shift($dataList)) {
                $convertArray[$data["key_name"]] = $data["contents"];
            }
        }

        return $convertArray;
    }

    /**
     * convertUserDataメソッド
     *
     * 任意のユーザーデータの取得
     *
     * @param  integer $userId      ユーザーid
     * @return array $convertArray コンバート配列
     */
    protected function convertUserData($userId) {

        if (!is_numeric($userId)) {
            return FALSE;
        }

        // ユーザーデータの取得
        $AdmUserOBJ = AdmUser::getInstance();
        $userData = $AdmUserOBJ->getUserData($userId);

        // 変換内容の取得
        $dataList = self::keyConvertData($this->_configOBJ->define->CONVERT_TYPE_USER);
        if ($dataList) {
            while ($data = array_shift($dataList)) {
                $convertArray[$data["key_name"]] = $userData[$data["contents"]];
            }
        }

        return $convertArray;
    }

    /**
     * execReplaceメソッド
     *
     * 置換実行
     *
     * @param  array  $convertArray コンバート配列
     * @param string  $convertText コンバートテキスト
     *
     * @return string  $convertText コンバート後テキスト
     */
    public function execReplace($convertArray, $text) {
        if (!is_array($convertArray) OR !$text) {
            return $text;
        }

        $convertText = str_replace(array_keys($convertArray), array_values($convertArray), $text);

        // コンバート配列と同じコンバートキーが無いか検索
        if (preg_match_all("/-%.*?-/", $convertText, $searchArray)) {

            if (array_intersect($searchArray[0], array_keys($convertArray))) {
                // 再起ループが多すぎたら強制終了
                if ($this->_callBackCnt > 50) {
                    return $convertText;
                }
                $this->_callBackCnt++;
                // あれば再帰的に処理をする
                $convertText = self::execReplace($convertArray, $convertText);
            }
        }
        // 初期化
        $this->_callBackCnt = 0;

        return $convertText;
    }

}
?>