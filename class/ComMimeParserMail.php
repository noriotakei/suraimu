<?php
/**
 * ComMimeParserMail.php
 *
 * サーバー上で受信したメールを解析するクラス
 *
 * @author    mitsuhiro_nakamura
 * @since     2009/08/11
 */

/**
 * ComMimeParserMail
 *
 * @author  mitsuhiro_nakamura
 * @version 1.0
 */
class ComMimeParserMail extends Mime_Parser_ComMimeParserMail {

    /** @var インスタンスを保持する変数。static変数 */
    protected static $instance = false;

    /**
     *  getInstanceメソッド
     *
     *  このクラスのオブジェクトを生成する。
     *  既に生成されていたら、前回と同じものを返す。
     *
     *  @return object  $instance
     */
    public static function getInstance() {
        if (!self::$instance) {
            $className = __CLASS__;
            self::$instance = new $className();
        }
        return self::$instance;
    }

}

?>