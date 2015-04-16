<?php
/**
 * /home/beth/www/mumumu/sendData.php
 * @copyright 2010 fraise Corporation
 * @author    takuro_ito
 * @version   SVN:$Id$
 * @since     derbyc_1.0 - 2008/07/06
*/

//-20100706-takuro
//mumumu集計サイトへのデータ送信用ファイルです
//mumumu側より毎時55分と深夜1時に叩かれます

// クラスファイル読み込み
require_once("./Calculation.php");

define( 'D_S_RECEIVE_SERVER',    'http://219.111.1.132/analyze/accept/data_accept.php' );

//入金種別コード
define(PAY_TYPE_BANK_AUTOMATIONBAS, 1);  //銀振り(BAS)
define(PAY_TYPE_BANK_AUTOMATION,    2);  //銀振り(入金おまかせサービス)
define(PAY_TYPE_CREDIT,             3);  //クレジット
define(PAY_TYPE_CVD,                4);  //コンビニダイレクト
define(PAY_TYPE_BITCASH,            5);  //BITCASH
define(PAY_TYPE_ADMIN,              6);  //管理手動入力
define(PAY_TYPE_TELECOM,            7);  //テレコムクレジット
define(PAY_TYPE_CCHECK,             8);  //C-check
define(PAY_TYPE_DIGITALEDY,         9);  //デジタルチェックEDY
define(PAY_TYPE_BANK_RAKUTEN,       10);  //楽天銀行

// ユーザ登録種別
define(USER_REGIST_STATUS_PRE_MEMBER,  0);  // '仮登録',
define(USER_REGIST_STATUS_MEMBER,      1);  // '本登録会員',
define(USER_REGIST_STATUS_MEMBER_QUIT, 2);  // '会員解除',

// 不正アクセスチェック
//アクセス許可IP
$allowIpArray = array(
    "219.111.2.137",
    "219.111.1.132",
);

$ip = $_SERVER[REMOTE_ADDR];
if( !in_array( $ip ,  $allowIpArray) ){
    header("location:http://www.yahoo.co.jp");
    exit;
}

$calc = new Calculation();

$i_male_uriage       = 0;    // 男性指定日売上
$i_female_uriage     = 0;    // 女性指定日売上
$i_total_uriage      = 0;    // 男女指定日売上
$i_man_regist_num    = 0;    // 男性指定日登録数
$i_female_regist_num = 0;    // 女性指定日登録数
$i_total_regist_num  = 0;    // 男女指定日登録数
$site_code           = $_REQUEST['site_cd'];
$targetDate          = $_REQUEST['target_date'];

if( !$site_code ){
    exit("siteCdError:".__LINE__);
}

if (!$calc->isDate($targetDate)) {
    exit("targetDateError:".__LINE__);
}

$targetDateYear   = substr($targetDate, 0, 4);
$targetDateMonth  = substr($targetDate, 4, 2);
$targetDateDay    = substr($targetDate, 6, 2);
$reformTargetDate = $targetDateYear."-".$targetDateMonth."-".$targetDateDay;

//------------トップページのアクセス数を取得----------------------
$access_sql =
       "SELECT sum(access_count) AS total_access FROM media_analyze"
      ." WHERE analyze_datetime >= '".$reformTargetDate." 00:00:00'"
      ." AND analyze_datetime <= '".$reformTargetDate." 23:59:59'"
      ." AND disable = 0 "
      ;

$access_result = $calc->executeQuery($access_sql);
$resultAccessData = $calc->fetchObject($access_result);
$i_total_access = $resultAccessData->total_access;

if (!$i_total_access) {
    exit("topCntError:".__LINE__);
}

//--------------対象日時の入金額取得---------------------------
$paymentSql  = "SELECT SUM(receive_money) AS t_today_uriage";
$paymentSql .= ",SUM(CASE WHEN pay_type = ".PAY_TYPE_BANK_AUTOMATIONBAS.    " THEN receive_money ELSE 0 END) AS bank_uriage";
$paymentSql .= ",SUM(CASE WHEN pay_type = ".PAY_TYPE_CREDIT.                " THEN receive_money ELSE 0 END) AS credit_uriage";
$paymentSql .= ",SUM(CASE WHEN pay_type = ".PAY_TYPE_CVD.                   " THEN receive_money ELSE 0 END) AS cvd_uriage";
$paymentSql .= ",SUM(CASE WHEN pay_type = ".PAY_TYPE_BITCASH.               " THEN receive_money ELSE 0 END) AS bitcash_uriage";
$paymentSql .= ",SUM(CASE WHEN pay_type = ".PAY_TYPE_TELECOM.               " THEN receive_money ELSE 0 END) AS telecom_uriage";
$paymentSql .= ",SUM(CASE WHEN pay_type = ".PAY_TYPE_BANK_AUTOMATION.       " THEN receive_money ELSE 0 END) AS omakase_uriage";
$paymentSql .= ",SUM(CASE WHEN pay_type = ".PAY_TYPE_CCHECK.                " THEN receive_money ELSE 0 END) AS ccheck_uriage";
$paymentSql .= ",SUM(CASE WHEN pay_type = ".PAY_TYPE_DIGITALEDY.            " THEN receive_money ELSE 0 END) AS edy_uriage";
$paymentSql .= ",SUM(CASE WHEN pay_type = ".PAY_TYPE_BANK_RAKUTEN.          " THEN receive_money ELSE 0 END) AS ebank_uriage";

$paymentSql .= " FROM payment_log";
$paymentSql .= " WHERE create_datetime >= '".$reformTargetDate." 00:00:00'";
$paymentSql .= " AND create_datetime   <= '".$reformTargetDate." 23:59:59'";
$paymentSql .= " AND receive_money != 1";
$paymentSql .= " AND is_cancel = 0";
$paymentSql .= " AND pay_type != ".PAY_TYPE_ADMIN;
$paymentSql .= " AND disable = 0";

//print $paymentSql;
$paymentResult = $calc->executeQuery($paymentSql);

if (!$paymentResult) {
    exit("paymentError:".__LINE__);
}

$resultPaymentData = $calc->fetchObject($paymentResult);

$i_female_uriage     = "0";
$i_male_uriage       = "0";
$i_total_uriage      = ($resultPaymentData->t_today_uriage) ? $resultPaymentData->t_today_uriage : "0";
$i_bank_uriage       = ($resultPaymentData->bank_uriage)    ? $resultPaymentData->bank_uriage    : "0";
$i_credit_uriage     = ($resultPaymentData->credit_uriage)  ? $resultPaymentData->credit_uriage  : "0";
$i_cvd_uriage        = ($resultPaymentData->cvd_uriage)     ? $resultPaymentData->cvd_uriage     : "0";
$i_bitcash_uriage    = ($resultPaymentData->bitcash_uriage) ? $resultPaymentData->bitcash_uriage : "0";
$i_fregi_uriage      = ($resultPaymentData->fregi_uriage)   ? $resultPaymentData->fregi_uriage   : "0";
$i_jnb_uriage        = ($resultPaymentData->jnb_uriage)     ? $resultPaymentData->jnb_uriage     : "0";
$i_ebank_uriage      = ($resultPaymentData->ebank_uriage)   ? $resultPaymentData->ebank_uriage   : "0";
$i_edy_uriage        = ($resultPaymentData->edy_uriage)     ? $resultPaymentData->edy_uriage     : "0";
$i_telecom_uriage    = ($resultPaymentData->telecom_uriage) ? $resultPaymentData->telecom_uriage : "0";
$i_felucca_uriage    = ($resultPaymentData->felucca_uriage) ? $resultPaymentData->felucca_uriage : "0";
$i_omakase_uriage    = ($resultPaymentData->omakase_uriage) ? $resultPaymentData->omakase_uriage : "0";
$i_edy_uriage        = ($resultPaymentData->edy_uriage)     ? $resultPaymentData->edy_uriage     : "0";
$i_ccheck_uriage     = ($resultPaymentData->ccheck_uriage)  ? $resultPaymentData->ccheck_uriage  : "0";
//------------------本登録数------------------------------
$regCntSql  = "SELECT COUNT(id) AS registCount ";
$regCntSql .= " FROM user ";
$regCntSql .= " WHERE regist_datetime >= '".$reformTargetDate." 00:00:00'";
$regCntSql .= " AND regist_datetime   <= '".$reformTargetDate." 23:59:59'";
$regCntSql .= " AND regist_status = ".USER_REGIST_STATUS_MEMBER;
$regCntSql .= " AND disable = 0";

//print $regCntSql;
$regCntResult = $calc->executeQuery($regCntSql);

if ( !$regCntResult ) {
    exit("regCntError:".__LINE__);
}
$o_row = $calc->fetchObject($regCntResult);

$i_female_regist_num = "0";
$i_man_regist_num    = "0";
$i_total_regist_num  = $o_row->registCount;



//----------------------初入金者数----------------------------------
$fastPayCntSql  = "SELECT COUNT(id) AS fastPayCount ";
$fastPayCntSql .= " FROM profile ";
$fastPayCntSql .= " WHERE first_pay_datetime >= '".$reformTargetDate." 00:00:00'";
$fastPayCntSql .= " AND first_pay_datetime   <= '".$reformTargetDate." 23:59:59'";
$fastPayCntSql .= " AND disable = 0";

//print $fastPayCntSql;
$fastPayCntResult = $calc->executeQuery($fastPayCntSql);

if ( !$fastPayCntResult ) {
    exit("fastPayCntError:".__LINE__);
}

$o_row = $calc->fetchObject($fastPayCntResult);

$i_first_nyukin_num        = $o_row->fastPayCount;

//---------------------アクセス(入有り入無し別詳細)---------------------------

$processTargetDate = mktime (0, 0, 0, $targetDateMonth, $targetDateDay,  $targetDateYear);

$target_before_one_week   = date('Y-m-d', $processTargetDate - 86400*7);
$target_before_one_month  = date('Y-m-d', $processTargetDate - 86400*31);
$target_before_two_months = date('Y-m-d', $processTargetDate - 86400*62);

$access_sql = "SELECT "
            . "SUM(CASE WHEN v_user_profile.last_access_datetime > '".$target_before_one_week.  " 00:00:00' AND v_user_profile.total_payment > 0 AND v_user_profile.buy_count > 0 THEN 1 ELSE 0 END) AS pay_week_num,"
            . "SUM(CASE WHEN v_user_profile.last_access_datetime > '".$target_before_one_month. " 00:00:00' AND v_user_profile.total_payment > 0 AND v_user_profile.buy_count > 0 THEN 1 ELSE 0 END) AS pay_month_num,"
            . "SUM(CASE WHEN v_user_profile.last_access_datetime > '".$target_before_two_months." 00:00:00' AND v_user_profile.total_payment > 0 AND v_user_profile.buy_count > 0 THEN 1 ELSE 0 END) AS pay_two_months_num,"
            . "SUM(CASE WHEN v_user_profile.last_access_datetime > '".$target_before_one_week.  " 00:00:00' AND v_user_profile.total_payment = 0 AND v_user_profile.buy_count = 0 THEN 1 ELSE 0 END) AS no_pay_week_num,"
            . "SUM(CASE WHEN v_user_profile.last_access_datetime > '".$target_before_one_month. " 00:00:00' AND v_user_profile.total_payment = 0 AND v_user_profile.buy_count = 0 THEN 1 ELSE 0 END) AS no_pay_month_num,"
            . "SUM(CASE WHEN v_user_profile.last_access_datetime > '".$target_before_two_months." 00:00:00' AND v_user_profile.total_payment = 0 AND v_user_profile.buy_count = 0 THEN 1 ELSE 0 END) AS no_pay_two_months_num "
            . "FROM v_user_profile "
            . "WHERE v_user_profile.user_disable = 0 "
            . "AND v_user_profile.last_access_datetime > '".$target_before_two_months." 00:00:00' ";

//print $access_sql;
$accessCntResult = $calc->executeQuery($access_sql);

if ( !$accessCntResult ) {
    exit("accessCntError:".__LINE__);
}

$o_row = $calc->fetchObject($accessCntResult);

$i_no_pay_week_num       = $o_row->no_pay_week_num;
$i_no_pay_month_num      = $o_row->no_pay_month_num;
$i_no_pay_two_months_num = $o_row->no_pay_two_months_num;
$i_pay_week_num          = $o_row->pay_week_num;
$i_pay_month_num         = $o_row->pay_month_num;
$i_pay_two_months_num    = $o_row->pay_two_months_num;

//-----------------curl通信用POSTフィールド作成------------------------
$s_post_field  = "ac="          .$i_total_access;
$s_post_field .= "&m_uri="      .$i_male_uriage;
$s_post_field .= "&f_uri="      .$i_female_uriage;
$s_post_field .= "&t_uri="      .$i_total_uriage;
$s_post_field .= "&bank_uri="   .$i_bank_uriage;
$s_post_field .= "&credit_uri=" .$i_credit_uriage;
$s_post_field .= "&cvd_uri="    .$i_cvd_uriage;
$s_post_field .= "&bitcash_uri=".$i_bitcash_uriage;
$s_post_field .= "&fregi_uri="  .$i_fregi_uriage;
$s_post_field .= "&jnb_uri="    .$i_jnb_uriage;
$s_post_field .= "&ebank_uri="  .$i_ebank_uriage;
$s_post_field .= "&telecom_uri=".$i_telecom_uriage;
$s_post_field .= "&edy_uri="    .$i_edy_uriage;
$s_post_field .= "&felucca_uri=".$i_felucca_uriage;
$s_post_field .= "&omakase_uri=".$i_omakase_uriage;
$s_post_field .= "&ccheck_uri=" .$i_ccheck_uriage;
$s_post_field .= "&m_reg="      .$i_man_regist_num;
$s_post_field .= "&f_reg="      .$i_female_regist_num;
$s_post_field .= "&t_reg="      .$i_total_regist_num;
$s_post_field .= "&first_trd="  .$i_first_nyukin_num;
$s_post_field .= "&n_pay_w="    .$i_no_pay_week_num;
$s_post_field .= "&n_pay_m="    .$i_no_pay_month_num;
$s_post_field .= "&n_pay_tm="   .$i_no_pay_two_months_num;
$s_post_field .= "&pay_w="      .$i_pay_week_num;
$s_post_field .= "&pay_m="      .$i_pay_month_num;
$s_post_field .= "&pay_tm="     .$i_pay_two_months_num;
$s_post_field .= "&target_date=".$targetDate;
$s_post_field .= "&site_cd="    .$site_code;

//------------curl通信------------------



$ch = curl_init();
curl_setopt( $ch, CURLOPT_HTTPHEADER, array("Expect:"));
curl_setopt( $ch, CURLOPT_URL, D_S_RECEIVE_SERVER );
curl_setopt( $ch, CURLOPT_FAILONERROR, 0 );
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
curl_setopt( $ch, CURLOPT_TIMEOUT, 100000 );
//curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt( $ch, CURLOPT_POST, 1 );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $s_post_field );
$result = curl_exec($ch);
curl_close ($ch);

//-20100702-takuro --------以下デバッグ用----------
/*
$s_debug_disp[] = "<tr><td>野郎売上</td><td>".$i_male_uriage."</td><td>円</td></tr>";
$s_debug_disp[] = "<tr><td>乙女売上</td><td>".$i_female_uriage."</td><td>円</td></tr>";
$s_debug_disp[] = "<tr><td>合計売上</td><td>".$i_total_uriage."</td><td>円</td></tr>";
$s_debug_disp[] = "<tr><td>初入金</td><td>"  .$i_first_nyukin_num."</td><td>人</td></tr>";

$s_debug_disp[] = "<tr><td>銀行売上</td><td>"       .$i_bank_uriage."</td><td>円</td></tr>";
$s_debug_disp[] = "<tr><td>ｸﾚｼﾞｯﾄ売上</td><td>"     .$i_credit_uriage."</td><td>円</td></tr>";
$s_debug_disp[] = "<tr><td>ｺﾝﾋﾞﾆﾀﾞｲﾚｸﾄ売上</td><td>".$i_cvd_uriage."</td><td>円</td></tr>";
$s_debug_disp[] = "<tr><td>C-CHECK売上</td><td>"    .$i_ccheck_uriage."</td><td>円</td></tr>";
$s_debug_disp[] = "<tr><td>ﾋﾞｯﾄｷｬｯｼｭ売上</td><td>"  .$i_bitcash_uriage."</td><td>円</td></tr>";
$s_debug_disp[] = "<tr><td>jnb売上</td><td>"        .$i_jnb_uriage."</td><td>円</td></tr>";
$s_debug_disp[] = "<tr><td>ｲｰﾊﾞﾝｸ売上</td><td>"     .$i_ebank_uriage."</td><td>円</td></tr>";
$s_debug_disp[] = "<tr><td>ﾃﾚｺﾑｸﾚｼﾞｯﾄ売上</td><td>" .$i_telecom_uriage."</td><td>円</td></tr>";
$s_debug_disp[] = "<tr><td>Edy売上</td><td>"        .$i_edy_uriage."</td><td>円</td></tr>";
$s_debug_disp[] = "<tr><td>Felucca売上</td><td>"    .$i_felucca_uriage."</td><td>円</td></tr>";
$s_debug_disp[] = "<tr><td>入金ｵﾏｶｾ売上</td><td>"   .$i_omakase_uriage."</td><td>円</td></tr>";

$s_debug_disp[] = "<tr><td>アクセス</td><td>"          .$i_total_access."</td><td>人</td></tr>";
$s_debug_disp[] = "<tr><td>入無ｱｸｾｽ数（週）</td><td>"  .$i_no_pay_week_num."</td><td>人</td></tr>";
$s_debug_disp[] = "<tr><td>入無ｱｸｾｽ数（月）</td><td>"  .$i_no_pay_month_num."</td><td>人</td></tr>";
$s_debug_disp[] = "<tr><td>入無ｱｸｾｽ数（二月）</td><td>".$i_no_pay_two_months_num."</td><td>人</td></tr>";
$s_debug_disp[] = "<tr><td>入有ｱｸｾｽ数（週）</td><td>"  .$i_pay_week_num."</td><td>人</td></tr>";
$s_debug_disp[] = "<tr><td>入有ｱｸｾｽ数（月）</td><td>"  .$i_pay_month_num."</td><td>人</td></tr>";
$s_debug_disp[] = "<tr><td>入有ｱｸｾｽ数（二月）</td><td>".$i_pay_two_months_num."</td><td>人</td></tr>";

$s_debug_disp[] = "<tr><td>野郎新規登録数</td><td>".$i_man_regist_num."</td><td>人</td></tr>";
$s_debug_disp[] = "<tr><td>乙女新規登録数</td><td>".$i_female_regist_num."</td><td>人</td></tr>";
$s_debug_disp[] = "<tr><td>合計新規登録数</td><td>".$i_total_regist_num."</td><td>人</td></tr>";

print "<title>集計</title>";
print "</head>";
print "<body bgcolor=\"#FFFFCC\">";
print "<center>";
print "<table border cellpadding=\"5\">";
        for( $i=0; $i<count($s_debug_disp); $i++ ){
            print($s_debug_disp[$i]);
        }
print "</table>";
print "</center>";
print "</body>";
print "</html>";
*/
exit();
?>





