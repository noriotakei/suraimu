<?php
/**
 * File Name:   InfoMail.inc
 *
 * Description: InfoMailクラス定義ファイル
 *
 * Author       Shinichi Hata <hata@icodw.co.jp>
 * Created      2006/02/06
 * Modified:    2006/03/27 by hata
 *
 * @package     InfoMail
 */
/**********************************************************************
 * インクルードセクション
 **********************************************************************/
// パッケージパスの設定
// 設定ファイル群の読み込み
// パッケージファイル群の読み込み
require_once("./ini/config.php");       // 各種設定ファイル
require_once("./ini/dir_tbl.php");      // フォルダデータテーブル
require_once("./ini/operator_tbl.php"); // 担当者データテーブル
require_once("./lib/funcs.php");        // ファンクション定義ファイル
require_once("./ini/ad_book_tbl.php");  // アドレス帳データテーブル
require_once("./ini/ad_book_tbl.php");  // アドレス帳データテーブル
require_once("./ini/msg_tmp.php");      // アドレス帳データテーブル
require_once("./ini/signature.php");    // 署名
require_once("./ini/user_common.php");    // 問い合わせログインユーザー
require_once("./func/SendMagicDelivery.php"); // SMTPメール送信処理ファイル

/**
 * InfoMailクラス
 *
 * DBに格納したメールデータを扱うクラス。
 * 表示用文字列変換処理や各カラムの更新処理、
 * また受信メールに対する返信処理などを行う。
 *
 * @package InfoMail
 */
class InfoMail {
    // DB オブジェクト
    var $db = null;
    // @var int メールID
    var $infoId;
    // @var string
    var $fromAddress;
    // @var string 送信者名
    var $fromName;
    // @var string 宛先メールアドレス
    var $toAddress;
    // @var string メールヘッダー情報
    var $header;
    // @var string 件名
    var $subject;
    // @var string 本文
    var $body;
    // @var string 受信日時
    var $receivedDate;
    // @var integer メール重要度
    var $priority;
    // @var integer 状態フラグ
    var $readStatus;
    // @var string 状態フラグ表示用文字列
    var $readStatusStr;
    // @var int 対応状況
    var $replyStatus;
    // @var string 対応状況表示用文字列 */
    var $replyStatusStr;
    // @var int サイトフラグ */
    var $siteFlag;
    // @var string サイトフラグ表示用文字列 */
    var $siteFlagStr;
    // @var string 登録者メンバーID */
    var $userId;
    // @var int 担当者ID */
    var $operatorId;
    // @var string 担当者表示用文字列 */
    var $operatorIdStr;
    // @var int フォルダID */
    var $dirId;

    var $mail_server = "http://127.0.0.1:8080/maildelivery.php";

    var $mail_server_array = array("1" => "http://127.0.0.1:8080/maildelivery.php",
                                   "2" => "http://127.0.0.1:8081/maildelivery.php");

    var $_mail_server = "103.18.100.163:25";

    var $_mail_server_array = array("1"  => "103.18.100.163:25"
                                   ,"2"  => "103.18.100.163:25");


    /**
     * コンストラクタ
     *
     * DBから取得したメールデータオブジェクトを元に、
     * 各クラス変数を初期化を行う。
     *
     * @param object $record メールデータオブジェクト
     */
    function InfoMail($record, $db) {
        $this->db = $db;

        if (!empty($record)) {
            $this->infoId       = $record["info_id"];
            $this->fromAddress  = $record["from_address"];
            $this->fromName     = $record["from_name"];
            $this->fromNameNoDomain = $record["from_name_no_domain"];
            $this->toAddress    = $record["to_address"];
            $this->header       = $record["header"];
            $this->subject      = $record["subject"];
            $this->body         = $record["body"];
            $this->receivedDate = $record["received_date"];
            $this->priority     = $record["priority"];
            $this->readStatus   = $record["read_status"];
            $this->replyStatus  = $record["reply_status"];
            $this->siteFlag     = $record["site_flag"];
            $this->userId       = $record["user_id"];
            $this->operatorId   = $record["operator_id"];
            $this->dirId        = $record["dir_id"];
            $this->status_cd    = $record["regist_status"];
            $this->total_payment    = $record["total_payment"];
            $this->media_cd     = $record["media_cd"];
        }
        $this->setStatusCdIdStr($this->status_cd);
        $this->setReadStatusStr($this->readStatus);
        $this->setReplyStatusStr($this->replyStatus);
        $this->setSiteFlagStr($this->siteFlag);
        $this->setOperatorIdStr($this->operatorId);
    }
    /**
     * 状態フラグ表示用変換メソッド
     *
     * 状態フラグを表示用文字列に変換し、
     * クラス変数$readStatusStrに格納する。
     *
     * @param integer $value 状態フラグ
     */
    function setReadStatusStr($value) {
        switch ($value) {
            case UNREAD_MAIL:
                $this->readStatusStr = "未読";
                break;
            case READED_MAIL:
                $this->readStatusStr = "既読";
                break;
            case TRANSMITTED_MAIL:
                $this->readStatusStr = "送信";
                break;
        }
    }

    /**
     * ユーザーステータス表示用変換メソッド
     *
     * ユーザーステータスを表示用文字列に変換し、
     * クラス変数$readStatusStrに格納する。
     *
     * @param integer $value ユーザーステータス
     */
    function setStatusCdIdStr($value) {

        if (is_null($value)) {
            $this->status_cdStr = "<font size='2'>未登録</font>";
            return;
        }

        switch ($value) {
/*
            case 1:
                $this->status_cdStr = "<font size='2'>登録</font>";
                break;
            case 2:
                $this->status_cdStr = "<font size='2'>仮登録</font>";
                break;
            case 3:
                $this->status_cdStr = "<font size='2' color='FF0000'>退会</font>";
                break;
            case 4:
                $this->status_cdStr = "<font size='2' color='FF0000'>ブラック</font>";
                break;
            case 5:
                $this->status_cdStr = "<font size='2' color='FF0000'>デーモン</font>";
                break;
*/
            case 0:
                $this->status_cdStr = "<font size='2'>仮登録</font>";
                break;
            case 1:
                $this->status_cdStr = "<font size='2'>本登録</font>";
                break;
            case 2:
                $this->status_cdStr = "<font size='2' color='FF0000'>退会</font>";
                break;


        }
    }

    /**
     * 対応状況表示用変換メソッド
     *
     * 対応状況を表示用文字列に変換し、
     * クラス変数$replyStatusStrに格納する。
     *
     * @param int $value 対応状況
     */
    function setReplyStatusStr($value) {
        global $replyStatus;

        if ($replyStatus[$value]) {
            $this->replyStatusStr = $replyStatus[$value];
        }
    }

    /**
     * サイトフラグ表示用変換メソッド
     *
     * サイトフラグを表示用文字列に変換し、
     * クラス変数$siteFlagStrに格納する。
     *
     * @param integer $value サイトフラグ
     */
    function setSiteFlagStr($value) {
        // $site_ary: admarray.ini内で宣言
        global $site_ary;

        if (isset($value) && isset($site_ary[$value][0])) {
            // サイト名の取得
            $this->siteFlagStr = $site_ary[$value][0];
        } else {
            $this->siteFlagStr = "不明";
        }
    }

    /**
     * 担当者名表示用変換メソッド
     *
     * 担当者IDを表示用文字列に変換し、
     * クラス変数$operatorIdStrに格納する。
     *
     * @param integer $value 担当者ID
     */
    function setOperatorIdStr($value) {
        // $operator_tbl: operator_tbl.ini内で宣言
        global $operator_tbl;
        if (isset($value) && $value !== strval(NOT_DEFINED)) {
            foreach ($operator_tbl as $key => $val) {
                if ($operator_tbl[$key]["id"] == $value) {
                    // 担当者名の取得
                    $this->operatorIdStr = $operator_tbl[$key]["name"];
                }
            }
        } else {
            $this->operatorIdStr = "未設定";
        }
    }

    /**
     * 状態フラグ更新メソッド
     *
     * DB内の状態フラグを$valueで指定された値に更新し、
     * クラス変数$readStatus, $readStatusStrを新たにセットする。
     *
     * @param int readStatus 新しい状態フラグ値
     */
    function updateReadStatus($readStatus) {
        $sql = " UPDATE info_mail SET"
             . " read_status = ?"
             . " WHERE info_id =  ?";
        $key = array();
        $key[] = $readStatus;
        $key[] = $this->infoId;
        $this->db->executeSql($sql, $key);

        $this->readStatus = $readStatus;
    }

    /**
     * 対応状況更新メソッド
     *
     * DB内の対応状況を$valueで指定された値に更新し、
     * クラス変数$replyStatus, $replyStatusStrを新たにセットする。
     *
     * @param integer replyStatus 新しい対応状況値
     */
    function updateReplyStatus($replyStatus) {
        $sql = " UPDATE info_mail SET"
             . " reply_status = ?"
             . " WHERE info_id =  ?";
        $key = array();
        $key[] = $replyStatus;
        $key[] = $this->infoId;
        $this->db->executeSql($sql, $key);

        $this->setReplyStatusStr($replyStatus);
        $this->replyStatus = $replyStatus;
    }

    /**
     * 担当者ID更新メソッド
     *
     * DB内の担当者IDを$valueで指定された値に更新し、
     * クラス変数$operatorId, $operatorIdStrを新たにセットする。
     *
     * @param integer $value 新しい担当者ID値
     * @param object $dbObj DBオブジェクト
     */
    function updateOperatorId($operatorId) {
        $sql = " UPDATE info_mail SET"
             . " operator_id = ?"
             . " WHERE info_id =  ?";
        $key = array();
        $key[] = $operatorId;
        $key[] = $this->infoId;
        $this->db->executeSql($sql, $key);

        $this->operatorId = $operatorId;
        $this->setOperatorIdStr($operatorId);

    }

    /**
     * フォルダID更新メソッド
     *
     * DB内のフォルダIDを$valueで指定された値に更新し、
     * クラス変数$dirIdを新たにセットする。
     *
     * @param int dirId 新しいフォルダID値
     */
    function updateDirId($dirId) {
        $sql = " UPDATE info_mail SET"
             . " dir_id = ? "
             . " WHERE info_id = ? ";
        $key = array();
        $key[] = $dirId;
        $key[] = $this->infoId;
        $this->db->executeSql($sql, $key);

        $this->dirId = $dirId;
    }

    /**
     * 保存フォルダID更新メソッド
     *
     * 保存フォルダに移動した時はカラムのpriorityがマイナスの値
     * DB内のフォルダIDを$valueで指定された値に更新し、
     * クラス変数$dirIdを新たにセットする。
     *
     * @param int value 新しいフォルダ（保存フォルダ階層）ID値
     */
    function updateDirIdKeep($dirId) {
        $this->priority = -1 * $this->priority;

        $sql = " UPDATE info_mail SET"
             . " dir_id = ? "
             . " ,priority = ? "
             . " WHERE info_id = ? ";
        $key = array();
        $key[] = $dirId;
        $key[] = $this->priority;
        $key[] = $this->infoId;
        $this->db->executeSql($sql, $key);

        $this->dirId = $dirId;
    }

    /**
     * userステータス更新(退会)メソッド
     *
     *
     * @param integer $value define値
     * @param object $dbObj DBオブジェクト
     */
    function updateRetireStatus($value) {

        if (!$this->userId) {
            return FALSE;
        }

        $sql = " UPDATE user SET"
             . " regist_status = " . $value["define"]["USER_REGIST_STATUS_MEMBER_QUIT"]
             . " ,quit_datetime = '" . date("YmdHis") . "'"
             . " ,update_datetime = '" . date("YmdHis") . "'"
             . " WHERE id = ? ";

        $this->db->executeSql($sql, array($this->userId));

        return TRUE;
    }

    /**
     * userメールステータス更新(退会)メソッド
     *
     *
     * @param integer $value define値
     * @param object $dbObj DBオブジェクト
     */
    function updateMailStatus($value) {

        if (!$this->userId) {
            return FALSE;
        }

        $sql = " UPDATE profile SET"
             . " pc_is_mailmagazine = 1"
             . " ,mb_is_mailmagazine = 1"
             . " ,update_datetime = '" . date("YmdHis") . "'"
             . " WHERE user_id = ? ";

        $this->db->executeSql($sql, array($this->userId));

        return TRUE;
    }

    /**
     * user.danger_status更新(ブラック有効)メソッド
     *
     *
     * @param integer $value define値
     * @param object $dbObj DBオブジェクト
     */
    function updateDangerStatus($value) {

        if (!$this->userId) {
            return FALSE;
        }

        $sql = " UPDATE user SET"
             . " danger_status = " . $value["define"]["DANGER_VALID"]
             . " ,update_datetime = '" . date("YmdHis") . "'"
             . " WHERE id = ? ";

        $this->db->executeSql($sql, array($this->userId));

        return TRUE;
    }

    /**
     * user.danger_status更新(ブラック解除)メソッド
     *
     *
     * @param integer $value define値
     * @param object $dbObj DBオブジェクト
     */
    function updateDangerStatusForRescission($value) {

        if (!$this->userId) {
            return FALSE;
        }

        $sql = " UPDATE user SET"
             . " danger_status = " . $value["define"]["DANGER_NOT"]
             . " ,update_datetime = '" . date("YmdHis") . "'"
             . " WHERE id = ? ";

        $this->db->executeSql($sql, array($this->userId));

        return TRUE;
    }

    /**
     * 返信処理＆DB格納メソッド
     *
     * 引数で指定されたデータを元に返信メール送信処理を行う。
     * またデータをエスケープ処理した後に、info_mail_tblテーブルに対して
     * インサート処理をし、返信メールデータをDBに追加する。
     *
     * @param string  to      宛先メールアドレス
     * @param string  from    送信元アカウント
     * @param int     fromDm  送信元ドメイン
     * @param string  subject 件名
     * @param string  body    本文
     * @param int     opeId   担当者ID
     * @param boolean db      DB格納ありなし
     */
    function sendReply($to, $from, $subject, $body, $opeId, $fromName, $db=false) {
        // php.iniのmajic_quotes_gpcがonの場合はstripslashes()でエスケープ解除
        if (get_magic_quotes_gpc()) {
            $to       = stripslashes($to);
            $from     = stripslashes($from);
            $subject  = stripslashes($subject);
            $body     = stripslashes($body);
            $fromName = stripslashes($fromName);
        }

        // 送信者の空チェック
        if(!$fromName){
            $fromName = $from;
        }

        // 入力された情報を元にメールを送信する
        $param = array(
            "To"          => $to,
            "Subject"     => $subject,
            "Body"        => $body,
            "From"        => $from,
            "FromName"    => $fromName,
            "Return-Path" => $from,
            "Reply-To"    => $from,
        );
        $this->sendMailCurl($param);

        // dbがtrueの時のみインサートをする
        if ($db) {
            // DB格納用にエスケープする
            $to       = htmlspecialchars($to);
            $from     = htmlspecialchars($from);
            $subject  = htmlspecialchars($subject);
            $body     = htmlspecialchars($body);
            $fromName = htmlspecialchars($fromName);

            // SJIS特有の文字化け対策のため追加
            $subject .= "&nbsp;"; $body .= "&nbsp;";

            // INSERTテーブルカラムの指定
            $sql = " INSERT INTO info_mail SET"
                 . " from_address = ? "
                 . " ,from_name = ? "
                 . " ,to_address = ? "
                 . " ,header = ? "
                 . " ,subject = ? "
                 . " ,body = ? "
                 . " ,received_date = now() "
                 . " ,priority = ? "
                 . " ,read_status = ? "
                 . " ,reply_status = ? "
                 . " ,user_id = ?"
                 . " ,operator_id = ? "
                 . " ,dir_id = ?";
            $key = array(
                $from,
                $fromName,
                $to,
                "",
                $subject,
                $body,
                NORMAL_PRIOR,
                TRANSMITTED_MAIL,
                $this->replyStatus,
                $this->userId,
                $opeId,
                TRANSMIT_DIR
            );
            $this->db->executeSql($sql, $key);
        }
    }
    /**
     * infoMailへインサート
     *
     * @param arrayインサートパラメーター
     */
    function addInfoMail($params) {
            $to       = htmlspecialchars($params["To"]);
            $from     = htmlspecialchars($params["From"]);
            $subject  = htmlspecialchars($params["Subject"]);
            $body     = htmlspecialchars($params["plain"]);
            $fromName = htmlspecialchars($params["FromName"]);

            // SJIS特有の文字化け対策のため追加
            $subject .= "&nbsp;"; $body .= "&nbsp;";

            // INSERTテーブルカラムの指定
            $sql = " INSERT INTO info_mail SET"
                 . " from_address = ? "
                 . " ,from_name = ? "
                 . " ,to_address = ? "
                 . " ,header = ? "
                 . " ,subject = ? "
                 . " ,body = ? "
                 . " ,received_date = now() "
                 . " ,priority = ? "
                 . " ,read_status = ? "
                 . " ,reply_status = ? "
                 . " ,user_id = ?"
                 . " ,operator_id = ? "
                 . " ,dir_id = ?";
            $key = array(
                $from,
                $fromName,
                $to,
                "",
                $subject,
                $body,
                NORMAL_PRIOR,
                TRANSMITTED_MAIL,
                $this->replyStatus,
                $this->userId,
                $params["opeId"],
                TRANSMIT_DIR
            );
            $this->db->executeSql($sql, $key);
    }

    /**
     * crulでメールサーバへメールを送信
     *
     * @param array 送信パラメーター
     */
    function sendMailCurl($param) {

        // curlのPOST用文字列作成
        $post = "to=" . urlencode($param["To"])
              . "&body=" . urlencode($param["Body"])
              . "&from=" . urlencode($param["From"])
              . "&from_nm=" . urlencode($param["FromName"])
              . "&sbj=" . urlencode($param["Subject"])
              . "&rtn_path=" . urlencode($param["From"])
              . "&rep_to=" . urlencode($param["Reply-To"]);


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->mail_server);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_exec($ch);
        curl_close($ch);
    }
    public function curlSend ($mailAddress, $mailElements, $mailServer) {
        if (!isset($mailAddress)) {
            return false;
        }
        if (!isset($mailServer)) {
            $mailServer = $this->mail_server;
        }
        //送信用にエンコード
        $tmp = array("subject","text_body",);
        foreach($tmp as $val){
            if (array_key_exists($val , $mailElements)) {
                if($val == "html_body"){
                    $mailElements[$val] = urlencode(base64_encode($mailElements[$val]));
                }else{
                    $mailElements[$val] = urlencode($mailElements[$val]);
                }
            } else {
                $mailElements[$val] = "";
            }
        }
        if (array_key_exists("html_body",$mailElements)) {
            $mailElements["html_body"] = urlencode(base64_encode($mailElements["html_body"]));
        } else {
            $mailElements["html_body"] = "";
        }
        if(!array_key_exists("from_name",$mailElements)){
            $mailElements["from_name"] = $mailElements["from_address"];
        }
        //mail_secは空なら0をセット
        if(!isset($mailElements["mail_sec"])){
            $mailElements["mail_sec"] = 0;
        }

        //↓「from_name」は空なら「from_address」の値が入る
        $postData = "sec=" . $mailElements["mail_sec"]
                      . "&from=" . $mailElements["from_address"]
                      . "&from_nm=" . $mailElements["from_name"]
                      . "&rtn_path=" . $mailElements["return_path"]
                      . "&rep_to=" . $mailElements["from_address"]
                      . "&to=" . $mailAddress
                      . "&to_nm=" . ""
                      . "&sbj=" . $mailElements["subject"]
                      . "&body=" . $mailElements["text_body"]
                      . "&html=" . $mailElements["html_body"];
        // default設定
        $optArray = array(
                    CURLOPT_URL            => $mailServer,
                    CURLOPT_FAILONERROR    => 1,
                    CURLOPT_FOLLOWLOCATION => 1,
                    CURLOPT_TIMEOUT        => 60,
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_POST           => 1,
                    CURLOPT_POSTFIELDS     => $postData,
        );
        $ch = curl_init();
        foreach ($optArray as $key => $val) {
            curl_setopt($ch, $key, $val);
        }
        curl_exec($ch);
        curl_close($ch);
    }

    /**
     * smtpMailToメソッド(SMTP)
     *
     * メール送信実行
     *
     * @param array   $mailElements  送信する要素
     *   [from_address]:メール送信元アドレス
     *   [from_name]   :メール送信元名(任意)
     *   [return_path] :リターンアドレス(任意)
     *   [subject]     :メールタイトル
     *   [text_body]   :メール本文(テキスト)
     *   [html_body]   :メール本文(HTML)(任意)
     * @return 送信成功:True 送信失敗:False
     */
    public function smtpMailTo ($mailElements) {

        if (!isset($mailElements["to_address"])) {
            return false;
        }

        //mail_secは空なら0をセット
        if(!isset($mailElements["mail_sec"])){
            $mailElements["mail_sec"] = 0;
        }

        //送信用にエンコード
        $sendSubject = $mailElements["subject"];
        $sendTextBody = htmlspecialchars_decode($mailElements["text_body"], ENT_QUOTES);
        //$sendHtmlBody = base64_encode($mailElements["html_body"]);

        // 送信項目の設定
        $postData["to"] = $mailElements["to_address"];
        //$postdata["to_nm"] = $mailElements["to_name"];
        $postData["rtn_path"] = $mailElements["return_path"];
        $postData["from"] = $mailElements["from_address"];
        $postData["from_nm"] = $mailElements["from_name"];
        $postData["sbj"] = $sendSubject;
        $postData["body"] = $sendTextBody;
        $postData["html"] = $mailElements["html_body"];
        $postData["sec"] = $mailElements["mail_sec"];

        //インスタンス生成
        $sendMagicDeliveryOBJ  = new SendMagicDelivery();

        // SMTPホスト設定(通常・反転)
        $sendMagicDeliveryOBJ->setSendMailServerIp($this->_mail_server_array[$mailElements["select_send_mail"]]);

        // SMTP接続開始
        if(!$sendMagicDeliveryOBJ->openSmtpConnect()){
            return false;
        }

        // 送信
        $sendResult = "";
        $sendMailData = $postData;
        $sendResult = $sendMagicDeliveryOBJ->sendMagicDelivery($sendMailData);

        // SMTP切断
        $sendMagicDeliveryOBJ->closeSmtpConnect();

        /*** 以下デバッグテストメールです ※確認用です ***/
        //mb_send_mail("norihisa_hosoda@gdmm.co.jp", "smtp_result_mail:", $sendResult, "");
        /*************************************************/

        return $sendResult;
    }

    /**
     * debugMailToメソッド(SMTP)
     *
     * デバッグメール送信実行
     *
     * @param array   $mailElements  送信する要素
     *   [return_path] :リターンアドレス(任意)
     *   [subject]     :メールタイトル
     *   [text_body]   :メール本文(テキスト)
     *   [html_body]   :メール本文(HTML)(任意)
     * @return 送信成功:True 送信失敗:False
     */
    public function debugMailTo ($mailElements, $sec = 0) {

        if (!isset($mailElements)) {
            return FALSE;
        }

        // $site: config.php内で宣言
        global $site;

        // http通信
        //送信用にエンコード
        $sendSubject = $mailElements["subject"];
        $sendTextBody = htmlspecialchars_decode($mailElements["text_body"], ENT_QUOTES);
        //$sendHtmlBody = base64_encode($mailElements["html_body"]);

        // 送信項目の設定
        $postData["to"] = "ml_sys_com_portal@ichi5.asia";
        $postData["rtn_path"] = ($mailElements["return_path"] ? $mailElements["return_path"] : $site["site_account"][$site["default_info"]]["return_path"]);
        $postData["from"] = "root@" . $site["site_account"][$site["default_info"]]["domain"];
        $postData["from_nm"] = $site["site_account"][$site["default_info"]]["name"];
        $postData["sbj"] = $sendSubject;
        $postData["body"] = $sendTextBody;
        $postData["html"] = $mailElements["html_body"];
        $postData["sec"] = $sec;

        // リメール用インスタンス生成
        $debugMailComSendMagicDeliveryOBJ = new SendMagicDelivery();

        // SMTPホスト設定(通常)
        $debugMailComSendMagicDeliveryOBJ->setSendMailServerIp($this->_mail_server);

        // SMTP接続開始
        if(!$debugMailComSendMagicDeliveryOBJ->openSmtpConnect()){
            return false;
        }

        $sendResult = "";
        $sendMailData = $postData;

        $sendResult = true;
        if ($sendMailData) {
            // リメール送信
            if (!$debugMailComSendMagicDeliveryOBJ->sendMagicDelivery($sendMailData)) {
                $sendResult = false;
            }
        } else {
            $sendResult = false;
        }

        // SMTP切断
        $debugMailComSendMagicDeliveryOBJ->closeSmtpConnect();

        return $sendResult;
    }

    /**
     * operationMailToメソッド(SMTP)
     *
     * 運営へメール送信実行
     *
     * @param array   $mailElements  送信する要素
     *   [return_path] :リターンアドレス(任意)
     *   [subject]     :メールタイトル
     *   [text_body]   :メール本文(テキスト)
     *   [html_body]   :メール本文(HTML)(任意)
     * @return 送信成功:True 送信失敗:False
     */
    public function operationMailTo ($mailElements, $sec = 0) {

        if (!isset($mailElements)) {
            return FALSE;
        }

        // $site: config.php内で宣言
        global $site;

        // http通信
        //送信用にエンコード
        $sendSubject = $mailElements["subject"];
        $sendTextBody = htmlspecialchars_decode($mailElements["text_body"], ENT_QUOTES);
        //$sendHtmlBody = base64_encode($mailElements["html_body"]);

        // 送信項目の設定
        $postData["to"] = $site["default_info"];
        $postData["rtn_path"] = ($mailElements["return_path"] ? $mailElements["return_path"] : $site["site_account"][$site["default_info"]]["return_path"]);
        $postData["from"] = "root@" . $site["site_account"][$site["default_info"]]["domain"];
        $postData["from_nm"] = $site["site_account"][$site["default_info"]]["name"];
        $postData["sbj"] = $sendSubject;
        $postData["body"] = $sendTextBody;
        $postData["html"] = $mailElements["html_body"];
        $postData["sec"] = $sec;

        // リメール用インスタンス生成
        $operationMailSendMagicDeliveryOBJ = new SendMagicDelivery();

        // SMTPホスト設定(通常)
        $operationMailSendMagicDeliveryOBJ->setSendMailServerIp($this->_mail_server);

        // SMTP接続開始
        if(!$operationMailSendMagicDeliveryOBJ->openSmtpConnect()){
            return false;
        }

        $sendResult = "";
        $sendMailData = $postData;

        $smtpSendResult = true;
        if ($sendMailData) {
            // リメール送信
            if (!$operationMailSendMagicDeliveryOBJ->sendMagicDelivery($sendMailData)) {
                $smtpSendResult = false;
            }
        } else {
            $smtpSendResult = false;
        }

        // SMTP切断
        $operationMailSendMagicDeliveryOBJ->closeSmtpConnect();

        return $smtpSendResult;
    }
}
?>
