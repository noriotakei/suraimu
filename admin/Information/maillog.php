<?php
/**
 * メールログ出力
 *
 * Description: メール対応ログ表示PHPファイル。
 *              指定されたメールアドレスを元に、そのアドレスからの受信メールと
 *              そのアドレスあてに送られた送信メールの両方を検索し、それらを
 *              対応ログとして表示する。
 *
 * @copyright 2007 fraise Corporation
 * @author    Shinichi Hata <hata@icodw.co.jp>
 * @package
 * @since     2006/02/06
 * @version   SVN:$Id: maillog.php 1498 2009-08-18 01:34:53Z honma $
 */
// 共通ファイル部分の読み込み
require_once("./ini/common.php");

/*
 * PHP処理セクション
 */

//--------------------------------
// リクエスト送信データのチェック
//--------------------------------
// maillog.phpを表示するには$_REQUEST["info_id"]が必須
if (empty($_REQUEST["info_id"]) || !is_numeric($_REQUEST["info_id"])) {
    $mailLog = "対応ログはありません。<br>\n";
}

//--------------------------------
// ログ表示対象メールデータの取得
//--------------------------------

//var_dump($_REQUEST);

// $_REQUEST["info_id"]で指定されたメール情報をDBから取得する
$sql = " SELECT * "
     . " FROM info_mail"
     . " WHERE info_id = ? ";
$key = array();
$key[] = $_REQUEST["info_id"];
$rs = $db->executeSql($sql, $key);

if ($rs->numRows() > 0) {
    // DBから取得したメール情報をオブジェクトとして格納する
    $infoMail = new InfoMail($rs->fetchRow(DB_FETCHMODE_ASSOC), $db);
}

// 「PC」or 「MB」のログを表示
if (!empty($_REQUEST["display_log_type"])) {
	$userData = "";
    // ユーザーデータを取得
    if (!empty($infoMail->userId)) {
        $sql = " SELECT *"
             . " FROM v_user_profile"
             . " WHERE user_id = " . $infoMail->userId
             . " AND user_disable = 0 "
             . " AND profile_disable = 0 "
             . " ORDER BY user_id DESC" ;

        $rs = $db->executeSql($sql);
        while ($array = $rs->fetchRow(DB_FETCHMODE_ASSOC)) {
            $userData = $array;
        }
        //var_dump($userData);

        // PCからの問い合わせログのみ
        if ($_REQUEST["display_log_type"] == DISPLAY_LOG_PC) {
            // PCメールからinfo情報をDBから取得する(1件のみ)
            $sql = " SELECT * "
                 . " FROM info_mail"
                 . " WHERE user_id = " . $userData["user_id"]
                 . " AND from_address = '" . $userData["pc_address"] . "'"
                 . " ORDER BY info_id DESC "
                 . " LIMIT 1";

            $rs = $db->executeSql($sql);

            //if ($rs->numRows() > 0) {
                // DBから取得したメール情報をオブジェクトとして格納する
                $infoMail = new InfoMail($rs->fetchRow(DB_FETCHMODE_ASSOC), $db);
            //}
                $displayLogPcMbNgFlag = TRUE ;
        }

        // MBからの問い合わせログのみ
        if ($_REQUEST["display_log_type"] == DISPLAY_LOG_MB) {
            // PCメールからinfo情報をDBから取得する(1件のみ)
            $sql = " SELECT * "
                 . " FROM info_mail"
                 . " WHERE user_id = " . $userData["user_id"]
                 . " AND from_address = '" . $userData["mb_address"] . "'"
                 . " ORDER BY info_id DESC "
                 . " LIMIT 1";

            $rs = $db->executeSql($sql);

            //if ($rs->numRows() > 0) {
                // DBから取得したメール情報をオブジェクトとして格納する
                $infoMail = new InfoMail($rs->fetchRow(DB_FETCHMODE_ASSOC), $db);
            //}
                $displayLogPcMbNgFlag = TRUE ;
        }

        // ＰＣ，MBからの問い合わせログ
        if ($_REQUEST["display_log_type"] == DISPLAY_LOG_PC_MB) {
        	// user_idからinfo情報をDBから取得する(1件のみ)
        	$sql = " SELECT * "
        			. " FROM info_mail"
        			. " WHERE user_id = " . $userData["user_id"]
        			. " AND (from_address = '" . $userData["pc_address"] . "' OR from_address = '".$userData["mb_address"]."')"
        			. " ORDER BY info_id DESC "
        			. " LIMIT 1";
        
        	$rs = $db->executeSql($sql);
        
        	//if ($rs->numRows() > 0) {
        	// DBから取得したメール情報をオブジェクトとして格納する
        	$infoMail = new InfoMail($rs->fetchRow(DB_FETCHMODE_ASSOC), $db);
        	//}
        }    
    
    }
}

//----------------------
// 対応ログデータの取得
//----------------------
/*
 * DB負荷軽減のためSQLクエリでのOR検索をしないようにしているため、
 * 以下ではあえて並べ替えをPHPの方でするようにしています。
 */
if ($infoMail->readStatus != TRANSMITTED_MAIL) {
	// 通常の受信メールから対応ログを取得する場合は
    if (!empty($infoMail->fromAddress)) {

    	if(!$displayLogPcMbNgFlag AND !empty($infoMail->userId)){

    		$sql = " SELECT *"
    			. " FROM info_mail"
    			. " WHERE user_id = ? "
    			. " ORDER BY received_date DESC"
    			. " LIMIT 0, 500";
    		$key = array();
    		$key[] = $infoMail->userId;
    		$rs = $db->executeSql($sql, $key);
    		while ($array = $rs->fetchRow(DB_FETCHMODE_ASSOC)) {
    			$fromMailLog[] = $array;
    		}

    		// 件数格納(最大500件)
    		$recCnt1 = count($fromMailLog);
    		$recCnt2 = 0 ;
    	
    	} else {
        //送信元メールアドレスでログ検索をかける 
        	// まずは送信元に対象のメアドがないかを調べる
    	    $sql = " SELECT *"
                 . " FROM info_mail"
                 . " WHERE from_address = ? "
                 . " ORDER BY received_date DESC"
                 . " LIMIT 0, 500";
            $key = array();
            $key[] = $infoMail->fromAddress;
            $rs = $db->executeSql($sql, $key);
            while ($array = $rs->fetchRow(DB_FETCHMODE_ASSOC)) {
                $fromMailLog[] = $array;
            }

            // 件数格納(最大500件)
            $recCnt1 = count($fromMailLog);

            // 次に宛先に対象のメアドがないかを調べる
            $sql = " SELECT * "
                 . " FROM info_mail"
                 . " WHERE to_address = ? "
                 . " ORDER BY received_date DESC"
                 . " LIMIT 0, 500";
            $key = array();
            $key[] = $infoMail->fromAddress;
            $rs = $db->executeSql($sql, $key);
            while ($array = $rs->fetchRow(DB_FETCHMODE_ASSOC)) {
                $toMailLog[] = $array;
            }

            // 件数格納(最大500件)
            $recCnt2 = count($toMailLog);
    	}
        
        // 上記2つの結果件数を足す(最大で1000件)
        $recCnt = $recCnt1 + $recCnt2;
    } else {
        $recCnt = 0;
    }
} else {
	/* info送信メールから対応ログを取得する場合は
       宛先メールアドレスでログ検索をかける */
    if (!empty($infoMail->toAddress)) {

        if(!$displayLogPcMbNgFlag AND !empty($infoMail->userId)){
        	// まずは送信元に対象のメアドがないかを調べる
    	    $sql = " SELECT *"
    		    	. " FROM info_mail"
    			    . " WHERE user_id = ? "
        			. " ORDER BY received_date DESC"
        			. " LIMIT 0, 500";
        	$key = array(
    	    		$infoMail->userId,
    	    );
        	$rs = $db->executeSql($sql, $key);
        	while ($array = $rs->fetchRow(DB_FETCHMODE_ASSOC)) {
    	    	$toMailLog[] = $array;
        	}
        	// 件数格納(最大500件)
    	    $recCnt1 = 0 ;
        	$recCnt2 = count($toMailLog);
        }else{
            // まずは送信元に対象のメアドがないかを調べる
            $sql = " SELECT *"
                 . " FROM info_mail"
                 . " WHERE from_address = ? "
                 . " ORDER BY received_date DESC"
                 . " LIMIT 0, 500";
            $key = array(
                $infoMail->toAddress,
            );
            $rs = $db->executeSql($sql, $key);
                while ($array = $rs->fetchRow(DB_FETCHMODE_ASSOC)) {
                $fromMailLog[] = $array;
            }

            // 件数格納(最大500件)
            $recCnt1 = count($fromMailLog);

            // 次に宛先に対象のメアドがないかを調べる
            $sql = " SELECT * "
                 . " FROM info_mail"
                 . " WHERE to_address = ? "
                 . " ORDER BY received_date DESC"
                 . " LIMIT 0, 500";
            $key = array(
                $infoMail->toAddress,
            );
            $rs = $db->executeSql($sql, $key);
            while ($array = $rs->fetchRow(DB_FETCHMODE_ASSOC)) {
                $toMailLog[] = $array;
            }

            // 件数格納(最大500件)
            $recCnt2 = count($toMailLog);

        }        
        // 上記2つの結果件数を足す(最大で1000件)
        $recCnt = $recCnt1 + $recCnt2;
    } else {
        $recCnt = 0;
    }
}

if ($recCnt > 0) {
    $logAry = array();
    // ログデータのオブジェクト配列の生成
    for ($i = 0; $i < $recCnt1; $i++) {
        $logAry[] = new InfoMail($fromMailLog[$i], $db);
    }
    for ($i = 0; $i < $recCnt2; $i++) {
        $logAry[] = new InfoMail($toMailLog[$i], $db);
    }

    // 受信日時が新しい順に配列を並べ替える
    function sortReceivedDate($array, $array2) {
        if($array->receivedDate > $array2->receivedDate) {
            return -1;
        } else {
            return 1;
        }
    }
    usort($logAry, "sortReceivedDate");

    // 表示するログ件数は最大で500件まで
    if ($recCnt > 500) {
        $recCnt = 500;
    }
    
    $mailLog = "";
    for ($i = 0; $i < $recCnt; $i++) {
        // 対応ログ表示用タグの生成
        if ($logAry[$i]->infoId == $_REQUEST["info_id"]) {
            $mailLog .= "<strong style=\"color: crimson;\">＞現在表示中のメール</strong><br>\n";
        }
        if ($logAry[$i]->readStatus != TRANSMITTED_MAIL) {
            $mailLog .= "<strong style=\"color: green;\">[受信]</strong> ";
        } else {
            $mailLog .= "<strong style=\"color: blue;\">[送信]</strong> ";
        }

        $mailLog .= "<strong style=\"color: #555555;\">{$logAry[$i]->receivedDate}</strong> "
                  . "[担当者：".$logAry[$i]->operatorIdStr."] "
                  . "[対応状況：{$logAry[$i]->replyStatusStr}]<br>\n"
                  . "<table width=\"558\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\" style=\"font-size:12; margin-top:5;\">\n"
                  . "<tr><td width=\"40\">件名：</td><td>".str_replace("&nbsp;", "", strip_tags($logAry[$i]->subject))."</td></tr>\n"
                  . "<tr><td valign=\"top\">本文：</td><td>".replaceToBr(str_replace("&nbsp;", "", strip_tags($logAry[$i]->body)))."</td></tr>\n"
                  . "</table>\n"
                  . "<hr color=\"lightsteelblue\">\n";

    }
} else {
    $mailLog = "対応ログはありません。<br>\n";
}

?>

<?php
/**
 * HTML表示セクション
 */
?>
<html>
<head>
    <title>メール対応ログ</title>
    <meta http-equiv="Content-Type" content="text/html; charset=Shift-JIS">
    <meta http-equiv="Cache-Control" content="no-cache">
</head>

<body>

<!-- メール対応ログ表示 -->
<font size="2">
<strong>メール対応ログ</strong>
<hr color="lightsteelblue">
<?php print($mailLog); ?>
</font>

</body>
</html>
