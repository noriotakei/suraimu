<?php
/**
 * Utility
 *
 * @copyright 2009 fraise Corporation
 * @author    mitsuhiro_nakamura
 * @package   bigtime
 * @version   SVN:$Id$
 * @since     2009/05/12
 * */

class Utility {

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

    /**
     *  getDeviceFromMailAddressメソッド
     *
     *  メールアドレスからデバイスを取得
     *
     *  @param  string  $mailAddress    メールアドレス
     *  @return int     デバイス
     */
    public function getDeviceFromMailAddress($mailAddress) {

        $address = strtolower($mailAddress);
        if (preg_match("/docomo.ne.jp/", $address)) {
            //Docomo
            return DEVICE_DOCOMO;
        } else if (preg_match("/ezweb.ne.jp/", $address)) {
            //Ezweb
            return DEVICE_AU;
        } else if (preg_match("/softbank.ne.jp|vodafone.ne.jp/", $address)) {
            //SoftBank
            return DEVICE_SOFTBANK;
        } else if (preg_match("/disney.ne.jp/", $address)) {
            //disney
            return DEVICE_DISNEY;
        } else {
            //それ以外
            return DEVICE_OTHER;
        }
    }

}
?>