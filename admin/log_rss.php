<?php
header("Content-Type: text/xml; charset=UTF-8");
switch ($_REQUEST["type"]) {
    case "slow-log":
		$remote_data=`ssh -o "StrictHostKeyChecking no" -i /home/devel/log/W-497-2@10.7.14.20.adm admagent@10.7.14.20 "(cd /home/devel; cat slow-log.rss)"`;
		print($remote_data);
		break;	

//        readfile("/home/devel/slow-log.rss");
//        break;
    case "php_error":
        readfile("/home/devel/php_error_log.rss");
        break;
    case "table_status":
		$remote_data=`ssh -o "StrictHostKeyChecking no" -i /home/devel/log/W-497-2@10.7.14.20.adm admagent@10.7.14.20 "(cd /home/devel; cat table_status.rss)"`;
		print($remote_data);
		break;
//        readfile("/home/devel/table_status.rss");
//       break;
    default:
        exit($_REQUEST["type"] . " no loging");
        break;
}
?>
