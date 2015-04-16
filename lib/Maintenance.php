<?php

/**
 *
 * Maintenance.php
 *
 * @copyright 2009 fraise Corporation
 * @author    mitsuhiro_nakamura
 */

/**
 * Maintenance
 *
 * メンテナンス管理クラス
 *
 * @author    mitsuhiro_nakamura
 */

class Maintenance {

        /**
         * checkMaintenanceメソッド
         *
         * メンテナンス状態取得
         * @return $checkMaintenance 停止：1 稼動：0
         *
         */
        public function checkMaintenance() {

            $isMaintenance = 0;

            //バックアップ時間メンテナンス
            if (strtotime(date("YmdHis")) >= strtotime(date("Ymd040000")) AND strtotime(date("YmdHis")) <= strtotime(date("Ymd041500"))) {
                $currentMaintenance = true;
            } else {
                require_once(D_BASE_DIR . '/etc/maintenance-ini.php');
                $currentMaintenance = $isMaintenance;
            }

            return $currentMaintenance;
        }
}

?>
