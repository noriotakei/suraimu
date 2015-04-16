<?php


class Calculation {

    var $config;

    var $db = false;

    function Calculation() {
        $this->getConfig();
        //$this->isAccessOk($accessKey);
        $db_access["user"] = $this->config["mysql"]["DATABASE_USER"];
        $db_access["pass"] = $this->config["mysql"]["DATABASE_PASS"];
        $db_access["address"] = $this->config["mysql"]["DATABASE_ADDRESS"];
        $db_access["name"] = $this->config["mysql"]["DATABASE_NAME"];
        $this->DBconnect($db_access["user"], $db_access["pass"], $db_access["address"], $db_access["name"]);

    }

    function getConfig() {
        $file = "./config-ini.php";

        if (file_exists($file)) {
            include($file);
        } else {
            return false;
        }
        $this->config = $config;

        return true;
    }

    function DBconnect ($user, $pass, $address, $name) {
        if (function_exists("mysqli_connect")) {
            if (!$this->db = mysqli_connect($address, $user, $pass, $name)) {
                exit("データベース接続に失敗！");
            }
        } else {
            if (!$this->db = mysql_connect($address, $user, $pass)) {
                exit("データベース接続に失敗！");
            }
            if (!mysql_select_db($name)) {
                mysql_close($this->db);
                exit("データベース選択に失敗！");
            }
        }
        return true;
    }


    function isDate($date) {

        //list($year, $month, $day) = @explode("-", $date);
        $year   = substr($date , "0" , "4");
        $month  = substr($date , "4" , "2");
        $day    = substr($date , "6" , "2");
        $time   = substr($date , "8" , "2");

        $year  = (int)$year;
        $month = (int)$month;
        $day   = (int)$day;

        return checkdate($month, $day, $year);
    }

    function executeQuery($query) {
        if (!is_string($query)) {
            return false;
        }

        if (!$this->db) {
            return false;
        }

        if (function_exists("mysqli_query")) {
            $result = mysqli_query($this->db, $query);
        } else {
            $result = mysql_query($query);
        }

        return $result;

    }

    function fetchObject($result) {
        if (!$result) {
            return false;
        }

        if (function_exists("mysqli_fetch_assoc")) {
            return mysqli_fetch_object($result);
        } else {
            return mysql_fetch_object($result);
        }

    }

}

?>