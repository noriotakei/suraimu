<?php
/**
 * doctype.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 携帯端末種別毎にheader,doctype等を生成する。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      Mitsuhiro Nakamura
 */

// モバイルなら設定する
if ($isURIMobile) {
    $limited_width="width:100%;";
    $smartyOBJ->assign("limited_width", $limited_width);

    //リンクカラー設定
    $bodyLink="#ffcc99";
    $bodyFocus="#ff3399";
    $bodyVisited="#cc9966";
    $smartyOBJ->assign("bodyLink", $bodyLink);
    $smartyOBJ->assign("bodyFocus", $bodyFocus);
    $smartyOBJ->assign("bodyVisited", $bodyVisited);

    //フォントカラー設定
    $bodyTextcolor="#ffffff";
    $smartyOBJ->assign("bodyTextcolor", $bodyTextcolor);

    //ページ背景色設定
    $bodyBgcolor="#000000";
    $smartyOBJ->assign("bodyBgcolor", $bodyBgcolor);

    //$amebloTag = "background-image:url('http://m.ameba.jp/m/blogTop.do?unm=invest-f')";
    $amebloTag = "";
    $bodyTag = "link=\"" . $bodyLink . "\" vlink=\"" . $bodyVisited . "\" alink=\"" . $bodyFocus . "\" text=\"" . $bodyTextcolor . "\" style=\"color:" . $bodyTextcolor . "; background:" . $bodyBgcolor . "; " . $amebloTag . "\" bgcolor=\"" . $bodyBgcolor . "\"";
    $smartyOBJ->assign("bodyTag", $bodyTag);

    //HR設定罫線色1
    $hr_1color="#993";
    $smartyOBJ->assign("hr_1color", $hr_1color);

    //HR設定罫線色2
    $hr_2color="#963";
    $smartyOBJ->assign("hr_2color", $hr_2color);
}

$userAgentOBJ = ComUserAgentMobile::getInstance();

// Docomoの場合
if ($userAgentOBJ->getCarrier() == "Docomo") {
    // foma
    if ($userAgentOBJ->isFoma()) {
        // xml
        ini_set("default_mimetype","application/xhtml+xml");

        $xml = '<?xml version="1.0" encoding="Shift_JIS"?>';
        $docType = "<!DOCTYPE html PUBLIC \"-//i-mode group (ja)//DTD XHTML i-XHTML(Locale/Ver.=ja/2.1) 1.0//EN\" \"i-xhtml_4ja_10.dtd\">\n";
        $docType .= "<html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"ja\" xml:lang=\"ja\">\n<head>\n";

        $hr_1style ="style=\"width:100%; height:1px; background:$hr_1color; border:1px solid $hr_1color;\"";
        $hr_2style ="style=\"width:100%; height:1px; background:$hr_2color; border:1px solid $hr_2color;\"";
        $hr_3style ="style=\"width:100%; height:1px; background:$hr_3color; border:1px solid $hr_3color;\"";
        $hr_4style ="style=\"width:100%; height:1px; background:$hr_4color; border:1px solid $hr_4color;\"";
        $hr_5style ="style=\"width:100%; height:1px; background:$hr_5color; border:1px solid $hr_5color;\"";

        $input_e_style ="-wap-input-format:&quot;*&lt;ja:en&gt;&quot;";
        $input_e ="";
        $input_m_style ="-wap-input-format:&quot;*&lt;ja:n&gt;&quot;";
        $input_m ="";

    }

    $contentType = "application/xhtml+xml";

// AUの場合
} else if ($userAgentOBJ->getCarrier() == "Ezweb") {
    // no-cache
    header("Cache-Control: no-cache");
    header("Pragma: no-cache");

    // xml
    $xml = '<?xml version="1.0" encoding="Shift_JIS"?>';
    $docType .= "<!DOCTYPE html PUBLIC \"-//OPENWAVE//DTD XHTML 1.0//EN\" \"http://www.openwave.com/DTD/xhtml-basic.dtd\">\n";
    $docType .= "<html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"ja\" xml:lang=\"ja\">\n<head>\n";

    $hr_1style ="size=\"1\" style=\"width:100%; color:$hr_1color;\"";
    $hr_2style ="size=\"1\" style=\"width:100%; color:$hr_2color;\"";
    $hr_3style ="size=\"1\" style=\"width:100%; color:$hr_3color;\"";
    $hr_4style ="size=\"1\" style=\"width:100%; color:$hr_4color;\"";
    $hr_5style ="size=\"1\" style=\"width:100%; color:$hr_5color;\"";
    $input_e_style ="";
    $input_e ="format=\"*m\"";
    $input_m_style ="";
    $input_m ="format=\"*N\"";

    $contentType = "application/xhtml+xml";

// SoftBankの場合
} else if ($userAgentOBJ->getCarrier() == "Softbank") {
    // 3G
    if ($userAgentOBJ->isType3Gc()) {
        // xml
        $xml = '<?xml version="1.0" encoding="Shift_JIS"?>';
        $docType.="<!DOCTYPE html PUBLIC \"-//J-PHONE//DTD XHTML Basic 1.0 Plus//EN\" \"xhtml_basic10-plus.dtd\">\n";
        $docType.="<html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"ja\" xml:lang=\"ja\">\n<head>\n";

        $hr_1style ="style=\"width:100%; height:1px; margin:2px 0 ; padding:0; background:$hr_1color; border:1px solid $hr_1color;\"";
        $hr_2style ="style=\"width:100%; height:1px; margin:2px 0 ; padding:0; background:$hr_2color; border:2px solid $hr_2color;\"";
        $hr_3style ="style=\"width:100%; height:1px; margin:2px 0 ; padding:0; background:$hr_3color; border:1px solid $hr_3color;\"";
        $hr_4style ="style=\"width:100%; height:1px; margin:2px 0 ; padding:0; background:$hr_4color; border:2px solid $hr_4color;\"";
        $hr_5style ="style=\"width:100%; height:1px; margin:2px 0 ; padding:0; background:$hr_5color; border:2px solid $hr_5color;\"";
        $input_e_style ="";
        $input_e ="mode=\"alphabet\"";
        $input_m_style ="";
        $input_m ="mode=\"numeric\"";

    }

    $contentType = "application/xhtml+xml";

// PCその他の場合
} else {

    $xml ="<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    $docType = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
    $docType .= "<html>\n<head>\n";

    $userAgentSmartPhoneOBJ = new ComUserAgentSmartPhone();
    if ($userAgentSmartPhoneOBJ ->isSmartPhone() && $isURIMobile) {
        $docType .= "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=2\">\n";
        //$docType .= "<link media=\"only screen and (max-device-width:480px)\" href=\"http://image." . $_config["define"]["SITE_DOMAIN"] . "/systemtest/smart.css\" type=\"text/css\" rel=\"stylesheet\" />\n";

        if (!$_config["define"]["TEST_DEVELOPMENT_FLAG"]) {
            // 本番環境
            $docType .= "<link media=\"only screen and (max-device-width:480px)\" href=\"http://image." . $_config["define"]["SITE_DOMAIN"] . "/contents/smartcss/smart.css\" type=\"text/css\" rel=\"stylesheet\" />\n";
            $docType .= "<link rel=\"stylesheet\" href=\"http://image." . $_config["define"]["SITE_DOMAIN"] . "/contents/smartcss/settle.css\" />\n";
        } else {
            // ローカル or TEST環境
            $docType .= "<link media=\"only screen and (max-device-width:480px)\" href=\"http://" . $_config["define"]["SITE_DOMAIN"] . "/i/contents/smartcss/smart.css\" type=\"text/css\" rel=\"stylesheet\" />\n";
            $docType .= "<link rel=\"stylesheet\" href=\"http://" . $_config["define"]["SITE_DOMAIN"] . "/i/contents/smartcss/settle.css\" />\n";
        }
    }

    $hr_1style ="size=\"1\" style=\"width:100%; color:$hr_1color;\"";
    $hr_2style ="size=\"1\" style=\"width:100%; color:$hr_2color;\"";
    $hr_3style ="size=\"1\" style=\"width:100%; color:$hr_3color;\"";
    $hr_4style ="size=\"1\" style=\"width:100%; color:$hr_4color;\"";
    $hr_5style ="size=\"1\" style=\"width:100%; color:$hr_5color;\"";
    $input_e_style ="";
    $input_e ="";
    $input_m_style ="";
    $input_m ="";

    $contentType = "application/xhtml+xml";

    // キャッシュ対策
    header("Expires: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-cache,must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
}

$smartyOBJ->assign("xml", $xml);
$smartyOBJ->assign("docType", $docType);
$smartyOBJ->assign("contentType", $contentType);
$smartyOBJ->assign("hr_1style", $hr_1style);
$smartyOBJ->assign("hr_2style", $hr_2style);
$smartyOBJ->assign("hr_3style", $hr_3style);
$smartyOBJ->assign("hr_4style", $hr_4style);
$smartyOBJ->assign("hr_5style", $hr_5style);
$smartyOBJ->assign("input_e_style", $input_e_style);
$smartyOBJ->assign("input_e", $input_e);
$smartyOBJ->assign("input_m_style", $input_m_style);
$smartyOBJ->assign("input_m", $input_m);

?>
