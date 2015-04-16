<?php


class Calculation {

    var $config;

    var $db = false;

    function Calculation($accessKey) {
        $this->getConfig();
        $this->isAccessOk($accessKey);
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

    function isAccessOk($accessKey) {
        if ($accessKey != $this->config["access_key"]) {
            echo "<?xml version=\"1.0\"?>";
            echo "<delyzer>";
            echo "<judge>false</judge>";
            echo "</delyzer>";
            exit();
        }
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


    function getMonthAgoDate($date , $agoNum) {

        $year   = substr($date , "0" , "4");
        $month  = substr($date , "4" , "2");

        $year   = date("Y", mktime(0, 0, 0, $month - $agoNum, 1, $year));
        $month  = date("m", mktime(0, 0, 0, $month - $agoNum, 1, $year));

        return array($year, $month);
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

    function fetchAssoc($result) {
        if (!$result) {
            return false;
        }

        if (function_exists("mysqli_fetch_assoc")) {
            return mysqli_fetch_assoc($result);
        } else {
            return mysql_fetch_assoc($result);
        }

    }


    function calcNewUser($sql) {
        if (!is_string($sql)) {
            return false;
        }

        $result = $this->executeQuery($sql);
        if (!$result) {
            return false;
        }

        $user_data = array();
        while ($data = $this->fetchAssoc($result)) {
            if($data["ad_code"] == ""){
                continue;
            }else if (preg_match("/[^0-9a-z_]/i", $data["ad_code"])) {
                continue;
            }
            foreach ($this->config["user_column_array"] as $user_clm) {
                $user_data[$data[$this->config["access_column_array"]["1"]]][$user_clm] = $data[$user_clm];
            }
        }
        return $user_data;
    }

    function calcAccess($sql) {
        if (!is_string($sql)) {
            return false;
        }

        $result = $this->executeQuery($sql);
        if (!$result) {
            return false;
        }

        $access_data = array();
        while ($data = $this->fetchAssoc($result)) {
            if($data["ad_code"] == ""){
                continue;
            }else if (preg_match("/[^0-9a-z_]/i", $data["ad_code"])) {
                continue;
            }
            $access_data[$data[$this->config["access_column_array"]["1"]]][$this->config["access_column_array"]["2"]] = $data[$this->config["access_column_array"]["2"]];
        }

        return $access_data;
    }

    function calcTrd($sql) {
        if (!is_string($sql)) {
            return false;
        }

        $result = $this->executeQuery($sql);
        if (!$result) {
            return false;
        }

        $trd_data = array();
        while ($data = $this->fetchAssoc($result)) {
            if($data["ad_code"] == ""){
                continue;
            }else if (preg_match("/[^0-9a-z_]/i", $data["ad_code"])) {
                continue;
            }

            foreach ($this->config["trd_column_array"] as $trd_clm) {
                $trd_data[$data[$this->config["access_column_array"]["1"]]][$trd_clm] = $data[$trd_clm];
            }

            }

        return $trd_data;
    }

    function calcTrdDetail($sql) {
        if (!is_string($sql)) {
            return false;
        }

        $result = $this->executeQuery($sql);
        if (!$result) {
            return false;
        }

        $trd_data = array();
        while ($data = $this->fetchAssoc($result)) {
            if($data["ad_code"] == ""){
                continue;
            }else if (preg_match("/[^0-9a-z_]/i", $data["ad_code"])) {
                continue;
            }

            for ($i = 0; $i <= 12; $i++) {
                $trd_data[$data[$this->config["access_column_array"]["1"]]]["sales_male_".$i] = $data["sales_male_".$i];
                $trd_data[$data[$this->config["access_column_array"]["1"]]]["sales_female_".$i] = $data["sales_female_".$i];
                $trd_data[$data[$this->config["access_column_array"]["1"]]]["count_male_".$i] = $data["count_male_".$i];
                $trd_data[$data[$this->config["access_column_array"]["1"]]]["count_female_".$i] = $data["count_female_".$i];
            }

            }

        return $trd_data;
    }


    function calcTradeUniqueCount($sql) {
        if (!is_string($sql)) {
            return false;
        }

        $result = $this->executeQuery($sql);
        if (!$result) {
            return false;
        }

        $trd_data = array();
        while ($data = $this->fetchAssoc($result)) {
            if($data["ad_code"] == ""){
                continue;
            }else if (preg_match("/[^0-9a-z_]/i", $data["ad_code"])) {
                continue;
            }
                $trade_data[$data["ad_code"]]["three_month_unique"] = $data["three_month_unique"];
                $trade_data[$data["ad_code"]]["two_month_unique"] = $data["two_month_unique"];
                $trade_data[$data["ad_code"]]["one_month_unique"] = $data["one_month_unique"];
                $trade_data[$data["ad_code"]]["current_month_unique"] = $data["current_month_unique"];
                $trade_data[$data["ad_code"]]["current_date_unique"] = $data["current_date_unique"];
            }

        return $trade_data;
    }

    function calcAccessDetail($sql) {
        if (!is_string($sql)) {
            return false;
        }

        $result = $this->executeQuery($sql);
        if (!$result) {
            return false;
        }

        $access_data = array();
        while ($data = $this->fetchAssoc($result)) {
            if($data["ad_code"] == ""){
                continue;
            }else if (preg_match("/[^0-9a-z_]/i", $data["ad_code"])) {
                continue;
            }
            $access_data[$data["ad_code"]]["week_payed"] = $data["week_payed"];
            $access_data[$data["ad_code"]]["month_payed"] = $data["month_payed"];
            $access_data[$data["ad_code"]]["week_nopay"] = $data["week_nopay"];
            $access_data[$data["ad_code"]]["month_nopay"] = $data["month_nopay"];
        }

        return $access_data;
    }


}

?>