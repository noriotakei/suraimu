<?php
/**
 * ComUserAgentSmartPhone.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * スマートフォン端末情報を扱うクラス。
 *
 * @copyright   2011 Fraise, Inc.
 * @author      hiroki mizuno
 */

class ComUserAgentSmartPhone {

    /** @var string ユーザーエージェント情報 */
    protected $_httpUserAgent = null;

    /** @var object リクエストobject */
    private $_requestOBJ = null;

    /**
     *
     *
     *
     */
    public static $_smartPhoneUserAgent = array(
        'iPhone',         // Apple iPhone
        'iPod',           // Apple iPod touch
        'Android',        // 1.5+ Android
        'dream',          // Pre 1.5 Android
        'CUPCAKE',        // 1.5+ Android
        'blackberry9500', // Storm
        'blackberry9530', // Storm
        'blackberry9520', // Storm v2
        'blackberry9550', // Storm v2
        'blackberry9800', // Torch
        'webOS',          // Palm Pre Experimental
        'incognito',      // Other iPhone browser
        'webmate'         // Other iPhone browser
    );

    /**
     * コンストラクタ
     *
     * @param string $httpUserAgent $_SERVER["HTTP_USER_AGENT"]の値
     */
    public function __construct() {
        $this->_requestOBJ = ComRequest::getInstance();
        // ユーザーエージェント情報をセット
        $this->_httpUserAgent = $this->_requestOBJ->getParameter("HTTP_USER_AGENT", "", "server");
    }

    public function isSmartPhone() {
        $pattern = '/' . implode('|' ,ComUserAgentSmartPhone::$_smartPhoneUserAgent) . '/i';
        if (!preg_match($pattern ,$this->_httpUserAgent)) {
            return false;
        }
        return true;
    }


    /**
     * 機種名取得
     *
     * @param string $model 
     */
    public function getSmartPhoneModel() {

        $userAgent =  $this->_requestOBJ->getParameter("HTTP_USER_AGENT", "", "server");

        //ua0がユーザーエージェント、ua1が配列、ua2は区切り文字。結果$ua1[6]が機種名 
        $ua0 = $userAgent; 
        $ua1 = array(); 
        $ua2 = " "; 
        //Androidをチェック　HT03Aだけ7番目が機種名 
        if(strpos($ua0, "Android" ) ){ 
            $ua1 = spliti( $ua2 , $ua0 ); 
            if (!preg_match("/Build/",$ua1[7])){ 
                $ua1[6] .=" ".$ua1[7]; 
             } 
             if ($ua1[6]=='TOSHIBA_AC_AND_AZ)'){ 
                 $ua1[6]="TOSHIBA_AC_AND_AZ"; 
             } 
             $model = $ua1[6]; 
        } 
        //iPadをチェック　(と;が付いてしまうので処理  OK
        else if(strpos($ua0, "iPad" ) ){ 
            $ua1 = spliti( $ua2 , $ua0 ); 
            $ua1[6] = str_replace('(', '', $ua1[1]); 
            $ua1[6] = str_replace(';', '', $ua1[6]); 
            $model = $ua1[6]; 
        } 
        //iPhone　バージョンを入れる OK
        else if(strpos($ua0, "iPhone" ) ){ 
            $ua1 = spliti( $ua2 , $ua0 ); 
            $ua1[6] = str_replace('(', '', $ua1[1]); 
            $ua1[6] = str_replace(';', '', $ua1[6]); 
            $model = $ua1[6]; 
        } 
        //iPod　(と;が付いてしまうので処理 OK 
        else if(strpos($ua0, "iPod" ) ){ 
            $ua1 = spliti( $ua2 , $ua0 ); 
            $ua1[6] = str_replace('(', '', $ua1[1]); 
            $ua1[6] = str_replace(';', '', $ua1[6]); 
            $model = $ua1[6]; 
        } 
        //HTC　Macという認識もするらしいので、文字列もキレイに 
        else if(strpos($ua0, "Macintosh" ) ){ 
            $ua1 = spliti( $ua2 , $ua0 ); 
            $ua1[6]=$ua1[9]; 
            $ua1[6] = str_replace('/ERE27)', '', $ua1[6]); 
            $model = $ua1[6]; 
        } else if(strpos($ua0, "Windows" ) ){ 
        //Windows　Phone
            $ua1 = spliti( $ua2 , $ua0 ); 
            $ua1[6] = str_replace(';', '', $ua1[11]); 
            $model = $ua1[6];         	
        }
        //とりあえず何もひっかからなければ通常の値を。  
        else{ 
            $model = "UNDEFINE"; 
        }
        return $model;
    }
}
?>