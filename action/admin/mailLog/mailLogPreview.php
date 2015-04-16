<?php
/**
 * mailLogPreview.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 管理画面メルマガログプレビューHTML表示ページ処理ファイル。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      mitsuhiro nakamura
 */

require_once(D_BASE_DIR . "/common/admin_common.php");

// インスタンスの作成
$AdmMailMagazineOBJ = AdmMailMagazine::getInstance();
$AdmSupportMailOBJ = AdmSupportMail::getInstance();
$AdmSupportMailLogOBJ = AdmSupportMailLog::getInstance();

$param = $requestOBJ->getParameterExcept($exceptArray);

if ($param["mlid"]) {
    $data = $AdmMailMagazineOBJ->getMailLogData($param["mlid"]);
    $pcImgLogList = $AdmMailMagazineOBJ->getMailImageLogData($param["mlid"], false);
    $mbImgLogList = $AdmMailMagazineOBJ->getMailImageLogData($param["mlid"], true);
    $imgFolder = "log";
} else if ($param["rgmlid"]) {
    $data = $AdmMailMagazineOBJ->getMailLogData($param["rgmlid"]);
    $pcImgLogList = $AdmMailMagazineOBJ->getMailImageRegularData($param["rgmlid"], false);
    $mbImgLogList = $AdmMailMagazineOBJ->getMailImageRegularData($param["rgmlid"], true);
    $imgFolder = "regular";
} else if ($param["rvsmlid"]) {
    $data = $AdmSupportMailOBJ->getSupportMailReserveData($param["rvsmlid"]);
    $pcImgLogList = $AdmSupportMailOBJ->getSupportMailImageReserveData($param["rvsmlid"], false);
    $mbImgLogList = $AdmSupportMailOBJ->getSupportMailImageReserveData($param["rvsmlid"], true);
    $imgFolder = "supportReserve";
} else if ($param["rgsmlid"]) {
    $data = $AdmSupportMailOBJ->getSupportMailRegularData($param["rgsmlid"]);
    $pcImgLogList = $AdmSupportMailOBJ->getSupportMailImageRegularData($param["rgsmlid"], false);
    $mbImgLogList = $AdmSupportMailOBJ->getSupportMailImageRegularData($param["rgsmlid"], true);
    $imgFolder = "supportRegular";
} else if ($param["smlid"]) {
    $data = $AdmSupportMailOBJ->getSupportMailLogData($param["smlid"]);
//2014年4月9日現在 smlidと保存画像のリレーションが出来ず画像取得出来ない
//    $pcImgLogList = $AdmSupportMailOBJ->getSupportMailSendLogImageData($param["smlid"], false);
//    $mbImgLogList = $AdmSupportMailOBJ->getSupportMailSendLogImageData($param["smlid"], true);
    $imgFolder = "supportLog";
} else if ($param["ssmlid"]) {
    $data = $AdmSupportMailLogOBJ->getSupportMailSendLogData($param["ssmlid"]);
    $pcImgLogList = $AdmSupportMailOBJ->getSupportMailSendLogImageData($param["ssmlid"], false);
    $mbImgLogList = $AdmSupportMailOBJ->getSupportMailSendLogImageData($param["ssmlid"], true);
    $imgFolder = "supportLog";
} else {
    $data = $AdmMailMagazineOBJ->getMailReserveData($param["rvmlid"]);
    $pcImgLogList = $AdmMailMagazineOBJ->getMailImageReserveData($param["rvmlid"], false);
    $mbImgLogList = $AdmMailMagazineOBJ->getMailImageReserveData($param["rvmlid"], true);
    $imgFolder = "reserve";
}

// imgタグの変換
$pcHtmlBodyDecode = htmlspecialchars_decode(($param["pc_html_body"] ? $param["pc_html_body"] : $data["pc_html_body"]), ENT_QUOTES);
$mbHtmlBodyDecode = htmlspecialchars_decode(($param["mb_html_body"] ? $param["mb_html_body"] : $data["mb_html_body"]), ENT_QUOTES);
foreach ((array)$pcImgLogList as $value) {
    $tmp = explode(".", $value["file_name"]);
    list($id, $no, $imgDevice) = explode("_", $tmp[0]);

    $imageSize = getimagesize("./img/mail/" . $imgFolder . "/" . $value["file_name"]);

    if($no>=10){
        $search = '<img src="0' . $no . '"';    	
    } else {
        $search = '<img src="00' . $no . '"';    	
    }

    $replace = '<img src="./img/mail/' . $imgFolder . '/' . $value["file_name"] . '" width="' . $imageSize[0] . '" height="' . $imageSize[1] . '" border="0"';

    $pcHtmlBodyDecode = str_replace($search, $replace, $pcHtmlBodyDecode);
}

foreach ((array)$mbImgLogList as $value) {
    $tmp = explode(".", $value["file_name"]);
    list($id, $no, $imgDevice) = explode("_", $tmp[0]);

    $imageSize = getimagesize("./img/mail/" . $imgFolder . "/" . $value["file_name"]);

    if($no>=10){
        $search = '<img src="0' . $no . '"';    	
    } else {
        $search = '<img src="00' . $no . '"';    	
    }

    $replace = '<img src="./img/mail/' . $imgFolder . '/' . $value["file_name"] . '" width="' . $imageSize[0] . '" height="' . $imageSize[1] . '" border="0"';

    $mbHtmlBodyDecode = str_replace($search, $replace, $mbHtmlBodyDecode);
}

if ($param["pc"]) {
    $smartyOBJ->assign("html_body", $pcHtmlBodyDecode);
} else {
    $smartyOBJ->assign("html_body", $mbHtmlBodyDecode);
}
?>

