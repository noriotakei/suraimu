<?php
/**
 * ComMimeParserDecomail.php
 *
 * デコメフォーマットを解析するクラス
 *
 * @author    mitsuhiro_nakamura
 * @since     2009/08/11
 */

/**
 * ComMimeParserDecomail
 *
 * @author  mitsuhiro_nakamur
 * @version 1.0
 */
class ComMimeParserDecomail extends Mime_Parser_ComMimeParserDecomail {

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