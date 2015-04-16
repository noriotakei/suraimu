<?php
/**
 * ComMaintenance.php
 * 
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * メンテナンス制御クラス。
 * 
 * @copyright   2009 Fraise, Inc.
 * @author      Shinichi Hata
 */

class ComMaintenance {
    
    /** メンテナンス設定データファイルパス */
    const MAINTENANCE_FILE_PATH = "/etc/maintenance-ini.php";
    
    /**
     * 現在のメンテナンス状態を取得する。
     * 
     * @return boolean メンテナンス中ならtrue、違うならfalse
     */
    public static function checkStatus() {
        
        $file = D_BASE_DIR . self::MAINTENANCE_FILE_PATH;
        
        if (file_exists($file)) {
            include($file);
        } else {
            return false;
        }
        
        return $isMaintenance;
    }
}

?>
