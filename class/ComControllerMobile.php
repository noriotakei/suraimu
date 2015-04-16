<?php
/**
 * ComControllerMobile.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * モバイル用フロントコントローラー制御クラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      Shinichi Hata
 */

class ComControllerMobile extends ComController {

    /** ビジネスロジック格納ディレクトリ */
    const BUSINESSLOGIC_PATH = "/action/mobile/";

    /** HTML表示ファイル格納ディレクトリ */
    const TEMPLATE_PATH = "/templates/mobile/";

    /** インクルードファイル格納ディレクトリ */
    const INCLUDE_PATH = "/action/mobile/include/";

    /** インクルードHTML表示ファイル格納ディレクトリ */
    const INCLUDE_TEMPLATE_PATH = "/templates/mobile/include/";

    /**
     * PHP処理ファイル名の取得。
     *
     * @return mixed PHP処理ファイル名、失敗ならfalse
     */
    public function getBusinessLogic() {

        // ディレクトリ対応型アクション名に変換
        $actionName = $this->convertActionName();

        // アクション名がない場合
        if (!$actionName) {
            $businessLogicFile = D_BASE_DIR . self::BUSINESSLOGIC_PATH . "index.php";
        // ビジネスロジックファイルが存在する場合
        } else if (file_exists(D_BASE_DIR . self::BUSINESSLOGIC_PATH . $actionName . ".php")) {
            $businessLogicFile = D_BASE_DIR . self::BUSINESSLOGIC_PATH . $actionName . ".php";
        // ビジネスロジックファイルがない場合
        } else {
            $businessLogicFile = D_BASE_DIR . self::BUSINESSLOGIC_PATH . "index.php";
        }

        return $businessLogicFile;
    }

    /**
     * HTML表示ファイル名の取得。
     *
     * @return mixed HTML表示ファイル名、失敗ならfalse
     */
    public function getTemplate() {

        // ディレクトリ対応型アクション名に変換
        $actionName = $this->convertActionName();

        // アクション名がない場合
        if (!$actionName) {
            $templateFile = D_BASE_DIR . self::TEMPLATE_PATH . "index.tpl";
        // HTML表示ファイルが存在する場合
        } else if (file_exists(D_BASE_DIR . self::TEMPLATE_PATH . $actionName . ".tpl")) {
            $templateFile = D_BASE_DIR . self::TEMPLATE_PATH . $actionName . ".tpl";
        // HTML表示ファイルがない場合
        } else {
            $templateFile = D_BASE_DIR . self::TEMPLATE_PATH . "index.tpl";
        }

        return $templateFile;
    }

    /**
     *  getIncludeBusinessLogicメソッド
     *
     *  HTML表示共通phpファイルの取得
     *
     *  @param  string  $action ファイル名
     *  @return string  HTML表示phpファイル名
     */
    public function getIncludeBusinessLogic($actionName = NULL) {
        if (!$actionName) {
            return FALSE;
        }

        return D_BASE_DIR . self::INCLUDE_PATH . $actionName . ".php";
    }

    /**
     *  getIncludeDispPageメソッド
     *
     *  HTML表示共通tplファイルの取得
     *
     *  @param  string  $action ファイル名
     *  @return string  HTML表示tplファイル名
     */
    public function getIncludeDispPage($actionName = NULL) {
        if (!$actionName) {
            return FALSE;
        }

        return D_BASE_DIR . self::INCLUDE_TEMPLATE_PATH . $actionName . ".tpl";
    }

}

?>
