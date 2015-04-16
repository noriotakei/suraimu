<?php
/**
 * maintenance.php
 *
 *  メンテナンス情報書き換えページ
 *
 * @copyright 2009 fraise Corporation
 * @author    mitsuhiro_nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

$param = $requestOBJ->getParameterExcept($exceptArray);

$fileName = "maintenance-ini.php";
$logFileName = D_BASE_DIR . "/etc/" . $fileName;

$logContents = "<?php \$isMaintenance = " . $param["is_maintenance"] . " ?>";

// ログファイルに書き込む
$fp = fopen( $logFileName, "w+");
if(!$fp){
    exit("書き込みできませんでした。");
}
flock( $fp, LOCK_EX );
fputs ( $fp, $logContents );
flock( $fp, LOCK_UN );
fclose( $fp );

header("Location: ./?action_maintenance_Maintenance=1");
exit;
?>
