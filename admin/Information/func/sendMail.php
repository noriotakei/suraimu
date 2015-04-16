<?php
/**
 * sendMail(シンプルなメール送信)
 * sendMailCurl(crulでメールサーバへメールを送信)
 * getPostStr(curlのPOST用の文字列作成（ToとBody抜き）)
 * sendCurl(curl送信)
 * sendMailAdmin(管理人にメール送信)
 */

/**
 * 処理:シンプルなメール送信
 */
function sendMail($to, $sbj, $body, $from, $from_name="", $rtn_path="", $rep_to="", $html=""){

    if (!$rtn_path) {
        $rtn_path = $from;
    }
    if (!$rep_to) {
        $rep_to = $from;
    }

    if ($from_name) {
        $from_name = mb_encode_mimeheader($from_name);
        $from = $from_name . " <" . $from . ">";
    }

    if ($html) {
        $content_type = "html";
    } else {
        $content_type = "plain";
    }

    $sbj = "=?iso-2022-jp?B?" 
         . base64_encode(mb_convert_encoding($sbj, "ISO-2022-JP", "eucJP-win")) 
         . "?=";
    $body = mb_convert_encoding($body, "ISO-2022-JP", "eucJP-win");

    $ml_header = (
        "From: " . $from."\n".
        "Return-Path: ". $rtn_path."\n".
        "Reply-To: " . $rep_to."\n".
        "Mime-Version: 1.0\n".
        "Content-Type: text/" . $content_type . "; charset=ISO-2022-JP\n".
        "Content-Transfer-Encoding: 7bit"
    );

    mail($to, $sbj, $body, $ml_header);
}


/*********************************************************************
処理:HTMLメール送信（使用してない？？？）
*********************************************************************/
function sendHtmlMail($to,$sbj,$body,$from,$from_name="",$rtn_path="",$rep_to=""){

    if(!$rtn_path){
        $rtn_path = $from;
    }
    if(!$rep_to){
        $rep_to = $from;
    }

    if($from_name){
        $from_name = mb_encode_mimeheader($from_name);
        $from = $from_name." <".$from.">";
    }

    $sbj ="=?iso-2022-jp?B?".base64_encode(mb_convert_encoding($sbj, "ISO-2022-JP", "eucJP-win"))."?=";
    $body = mb_convert_encoding($body, "ISO-2022-JP", "eucJP-win");

    $ml_header = ("From: ".$from."\n".
        "Return-Path: ".$rtn_path."\n".
        "Reply-To: ".$rep_to."\n".
        "Mime-Version: 1.0\n".
        "Content-Type: text/plain; charset=ISO-2022-JP\n".
        "Content-Transfer-Encoding: 7bit");

    mail($to, $sbj, $body, $ml_header);
}




/**************************************************
    運営さんへwebサーバから送信
**************************************************/
function sendMailAdmin($sbj,$body,$from,$DB,$mailserver="",$html=""){
    //$mailserverの指定があったらCURL送信

    //メアド取得
    $where = " where email != ''";
    $rs = $DB->dbSelect("auth",$where,"email");

    while($row = mysql_fetch_array($rs['result'])){
        list($email) = $row;
        $email = trim($email);
        if($email){
            if(!$mailserver){
                sendMail($email,$sbj,$body,$from,"","","",$html);
            }else{
                sendMailCurl($email,$sbj,$body,$from,$from,$from,$from,$mailserver);
            }
        }
    }
}

function curlSend ($mailAddress, $mailElements, $mailServer) {
        if (!isset($mailAddress)) {
            return false;
        }
        if (!isset($mailServer)) {
            return false;
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


?>