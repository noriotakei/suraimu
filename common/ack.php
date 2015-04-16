<?php
/**
 * ack.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * アクセスキー定義。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      Shinichi Hata
 */

$userAgentOBJ = ComUserAgentMobile::getInstance();

// Docomoの場合
if ($userAgentOBJ->getCarrier() == "Docomo") {

    $ack1 = "accesskey=\"1\"";
    $ack2 = "accesskey=\"2\"";
    $ack3 = "accesskey=\"3\"";
    $ack4 = "accesskey=\"4\"";
    $ack5 = "accesskey=\"5\"";
    $ack6 = "accesskey=\"6\"";
    $ack7 = "accesskey=\"7\"";
    $ack8 = "accesskey=\"8\"";
    $ack9 = "accesskey=\"9\"";
    $ack0 = "accesskey=\"0\"";

    // foma
    if ($userAgentOBJ->isFoma()) {
        $acm1 = "style=\"-wap-input-format:&quot;*&lt;ja:h&gt;&quot;\"";
        $acm2 = "style=\"-wap-input-format:&quot;*&lt;ja:hk&gt;&quot;\"";
        $acm3 = "style=\"-wap-input-format:&quot;*&lt;ja:en&gt;&quot;\"";
        $acm4 = "style=\"-wap-input-format:&quot;*&lt;ja:n&gt;&quot;\"";
    } else {
        $acm1 = "istyle=\"1\"";
        $acm2 = "istyle=\"2\"";
        $acm3 = "istyle=\"3\"";
        $acm4 = "istyle=\"4\"";
    }

// AUの場合
} else if ($userAgentOBJ->getCarrier() == "Ezweb") {

    $ack1 = "accesskey=\"1\"";
    $ack2 = "accesskey=\"2\"";
    $ack3 = "accesskey=\"3\"";
    $ack4 = "accesskey=\"4\"";
    $ack5 = "accesskey=\"5\"";
    $ack6 = "accesskey=\"6\"";
    $ack7 = "accesskey=\"7\"";
    $ack8 = "accesskey=\"8\"";
    $ack9 = "accesskey=\"9\"";
    $ack0 = "accesskey=\"0\"";

    $acm1 = "istyle=\"1\"";
    $acm2 = "istyle=\"2\"";
    $acm3 = "istyle=\"3\"";
    $acm4 = "istyle=\"4\"";

// SoftBankの場合
} else if ($userAgentOBJ->getCarrier() == "Softbank") {
    $ack1 = "accesskey=\"1\"";
    $ack2 = "accesskey=\"2\"";
    $ack3 = "accesskey=\"3\"";
    $ack4 = "accesskey=\"4\"";
    $ack5 = "accesskey=\"5\"";
    $ack6 = "accesskey=\"6\"";
    $ack7 = "accesskey=\"7\"";
    $ack8 = "accesskey=\"8\"";
    $ack9 = "accesskey=\"9\"";
    $ack0 = "accesskey=\"0\"";

    $acm1 = "mode=\"hiragana\"";
    $acm2 = "mode=\"katakana\"";
    $acm3 = "mode=\"alphabet\"";
    $acm4 = "mode=\"numeric\"";
}

    $smartyOBJ->assign("ack1", $ack1);
    $smartyOBJ->assign("ack2", $ack2);
    $smartyOBJ->assign("ack3", $ack3);
    $smartyOBJ->assign("ack4", $ack4);
    $smartyOBJ->assign("ack5", $ack5);
    $smartyOBJ->assign("ack6", $ack6);
    $smartyOBJ->assign("ack7", $ack7);
    $smartyOBJ->assign("ack8", $ack8);
    $smartyOBJ->assign("ack9", $ack9);
    $smartyOBJ->assign("ack0", $ack0);
    $smartyOBJ->assign("acm1", $acm1);
    $smartyOBJ->assign("acm2", $acm2);
    $smartyOBJ->assign("acm3", $acm3);
    $smartyOBJ->assign("acm4", $acm4);

?>
