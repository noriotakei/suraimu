<?php
/**
 * DBクラス
 *
 * @copyright 2007 fraise Corporation
 * @author    fukunaga@wrk.jp
 * @package   ban2
 * @version   InformationDB.php 10013 2008-10-01 10:02:30Z saitou $
 * @since     ban2_1.0 - 2008/05/26
 */

// PEAR DB読み込み
require_once("DB.php");

/**
 * DB
 *
 * @author    fukunaga@wrk.jp
 * @version   Release: Information_3.0
 */
class InformationDB extends DB {
    var $db;

    function InformationDB($dsn, $options=array()) {
        $db =& DB::connect($dsn, $options);
        if (PEAR::isError($db)) {
            die($db->getMessage());
        }
        $this->db =$db;
    }

    function executeSql($sql, $key=array()) {
        $st = $this->db->prepare($sql);
        if (PEAR::isError($sql)) {
            die($st->getMessage());
        }
        
        $rs =& $this->db->execute($st, $key);
        if (PEAR::isError($rs)) {
            die($rs->getMessage());
        }

        return $rs;
    }
}
?>