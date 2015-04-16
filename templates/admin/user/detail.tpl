{include file=$admHeader}
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
</head>
<body>
<div class="BlockCol">
    <h2 class="ContentTitle">ユーザー情報</h2>
    {* 更新時エラーコメント *}
    {if $errMsg|@count}
        <div class="warning ui-widget">
        <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
        <p>
        <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
        { foreach from=$errMsg item="val" }
            {$val|@implode:"<br>"}
        {/foreach}
        </p>
        </div>
        </div>
        <br>
    {/if}
    {if $userData}
        <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
            <tr>
                <td style="padding:5px;"><a href="{make_link action="action_user_LogList" getTags="user_id="|cat:$userData.user_id}" target="_blank">各種ログ</a></td>
                <td style="padding:5px;"><a href="{make_link action="action_ordering_OrderingSet" getTags="user_id="|cat:$userData.user_id}" target="_blank">商品予約</a></td>
                <td><a href="{$config.define.SITE_URL}?action_Home=1&{$accessKeyName}={$userData.access_key}" target="_blank">PCログイン</a></td>
                <td><a href="{$config.define.SITE_URL_MOBILE}?action_Home=1&{$accessKeyName}={$userData.access_key}" target="_blank">MBログイン</a></td>
                <td style="padding:5px;"><a href="{make_link action="action_user_MonthlyCourseUserList" getTags="user_id="|cat:$userData.user_id}" target="_blank">月額コース管理</a></td>
            </tr>
        </table>
        <br>
        {if $duplicateUserDataList}
            <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
                <tr>
                    <th rowspan="{math equation="(x / y) + 1" x=$duplicateUserDataList|@count y=10 format="%.0f"}">重複ユーザーID</th>
                    { foreach name="dataLoop" from=$duplicateUserDataList item="val" }
                    <td style="padding:5px;">
                        <a href="{make_link action="action_User_Detail" getTags="user_id="|cat:$val.user_id}" target="_blank">{$val.user_id}</a>
                    </td>
                    {if $smarty.foreach.dataLoop.iteration % 10 == 0}
                        </tr><tr>
                    {/if}
                    {/foreach}
                </tr>
            </table>
            <br>
        {/if}
        <form action="./" method="post">
            {$POSTparam}
            <table>
                <tr>
                    <td style="vertical-align:top;">
                        <table>
                            <tr>
                                <td style="vertical-align:top;">
                                    <table border="0" cellspacing="0" cellpadding="0" class="TableSet02">
                                        <tr>
                                            <th>ﾕｰｻﾞｰID</th>
                                            <td style="text-align: left;">{$userData.user_id}</td>
                                        </tr>
                                        {if "login_id"|in_array:$displayUserDetail}
                                        <tr>
                                            <th>ﾛｸﾞｲﾝID</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="login_id" value="{$userData.login_id}" style="ime-mode:disabled" size="50">
                                            </td>
                                        </tr>
                                        {/if}
                                        {if "login_id_no_domain"|in_array:$displayUserDetail}
                                        <tr>
                                            <th>ﾛｸﾞｲﾝID(ドメインなし)</th>
                                            <td style="text-align: left;">
                                                {$userData.login_id_no_domain}
                                            </td>
                                        </tr>
                                        {/if}
                                        <tr>
                                            <th>ﾕｰｻﾞｰPASS</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="password" value="" style="ime-mode:disabled" size="16">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>ﾕｰｻﾞｰ識別ｷｰ</th>
                                            <td style="text-align: left;">{$userData.access_key}</td>
                                        </tr>
                                        {if "credit_certify_phone_number"|in_array:$displayUserDetail}
                                        <tr>
                                            <th>ｾﾞﾛｸﾚｼﾞｯﾄ登録電話番号</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="credit_certify_phone_number" value="{$userData.credit_certify_phone_number}" style="ime-mode:disabled" maxlength="13" size="15">
                                            </td>
                                        </tr>
                                        {/if}
                                        {if "credit_certify_phone_number_mb"|in_array:$displayUserDetail}
                                        <tr>
                                            <th>ｾﾞﾛｸﾚｼﾞｯﾄMB登録電話番号</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="credit_certify_phone_number_mb" value="{$userData.credit_certify_phone_number_mb}" style="ime-mode:disabled" maxlength="13" size="15">
                                            </td>
                                        </tr>
                                        {/if}
                                        {if "telecom_certify_phone_number"|in_array:$displayUserDetail}
                                        <tr>
                                            <th>ﾃﾚｺﾑｸﾚｼﾞｯﾄ登録電話番号</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="telecom_certify_phone_number" value="{$userData.telecom_certify_phone_number}" style="ime-mode:disabled" maxlength="13" size="15">
                                            </td>
                                        </tr>
                                        {/if}
                                        <tr>
                                            <th>ｽﾃｰﾀｽ</th>
                                            <td style="text-align: left;">
                                                {html_options name="regist_status" options=$config.admin_config.regist_status selected=$userData.regist_status}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>性別</th>
                                            <td style="text-align: left;">
                                                {html_options name="sex_cd" options=$config.admin_config.sex_cd selected=$userData.sex_cd}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>血液型</th>
                                            <td style="text-align: left;">
                                                {html_options name="blood_type" options=$config.admin_config.blood_type selected=$userData.blood_type}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>PCﾒｰﾙ強行</th>
                                            <td style="text-align: left;">
                                                {html_options name="is_pc_reverse" options=$config.admin_config.reverse_status selected=$userData.is_pc_reverse}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>MBﾒｰﾙ強行</th>
                                            <td style="text-align: left;">
                                                {html_options name="is_mb_reverse" options=$config.admin_config.reverse_status selected=$userData.is_mb_reverse}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>ブラック</th>
                                            <td style="text-align: left;">
                                                {html_options name="danger_status" options=$config.admin_config.danger_status selected=$userData.danger_status}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>ユーザー識別フラグ</th>
                                            <td style="text-align: left;">
                                                {html_options name="user_profile_flag_code_update" options=$user_profile_flag_code selected=$userData.user_profile_flag}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>PCﾃﾞﾊﾞｲｽ</th>
                                            <td style="text-align: left;">{$config.admin_config.pc_device[$userData.pc_device_cd]}</td>
                                        </tr>
                                        <tr>
                                            <th>PC IPｱﾄﾞﾚｽ</th>
                                            <td style="text-align: left;">{$userData.pc_ip_address}</td>
                                        </tr>
                                        {if "pc_address"|in_array:$displayUserDetail}
                                        <tr>
                                            <th>PCﾒｰﾙｱﾄﾞﾚｽ</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="pc_address" value="{$userData.pc_address}" style="ime-mode:disabled" size="50">
                                            </td>
                                        </tr>
                                        {/if}
                                        {if "pc_address_no_domain"|in_array:$displayUserDetail}
                                        <tr>
                                            <th>PCﾒｰﾙｱﾄﾞﾚｽ(ドメインなし)</th>
                                            <td style="text-align: left;">
                                                {$userData.pc_address_no_domain}
                                            </td>
                                        </tr>
                                        {/if}
                                        <tr>
                                            <th>PCｱﾄﾞﾚｽｽﾃ-ﾀｽ</th>
                                            <td style="text-align: left;">
                                                {html_options name="pc_address_status" options=$config.admin_config.address_status selected=$userData.pc_address_status}
                                             </td>
                                        </tr>
                                        <tr>
                                            <th>PC送信ｽﾃ-ﾀｽ</th>
                                            <td style="text-align: left;">
                                                {html_options name="pc_send_status" options=$config.admin_config.address_send_status selected=$userData.pc_send_status}
                                             </td>
                                        </tr>
                                        <tr>
                                            <th>PCﾒｰﾙ受信設定</th>
                                            <td style="text-align: left;">
                                                {html_options name="pc_is_mailmagazine" options=$config.common_config.is_mailmagazine selected=$userData.pc_is_mailmagazine}
                                             </td>
                                        </tr>
                                        <tr>
                                            <th>PCﾕｰｻﾞｰｴｰｼﾞｪﾝﾄ</th>
                                            <td style="text-align: left;">{$userData.pc_user_agent}</td>
                                        </tr>
                                        <tr>
                                            <th>PCｴﾗｰﾒｰﾙ数</th>
                                            <td style="text-align: left;">{$userData.pc_emsys_count}回</td>
                                        </tr>
                                        {if "mb_serial_number"|in_array:$displayUserDetail}
                                        <tr>
                                            <th>個体識別番号</th>
                                            <td style="text-align: left;">
                                                {$userData.mb_serial_number}&nbsp;&nbsp;&nbsp;
                                                {if $userData.mb_serial_number}
                                                    {html_checkboxes name="serial_number_delete" options=$serialNumberDelete selected=$value.serial_number_delete|default:0 separator="&nbsp;"}
                                                {/if}
                                            </td>
                                        </tr>
                                        {/if}
                                        {if "mb_device_cd"|in_array:$displayUserDetail}
                                        <tr>
                                            <th>MBﾃﾞﾊﾞｲｽ</th>
                                            <td style="text-align: left;">{$config.admin_config.mb_device[$userData.mb_device_cd]}</td>
                                        </tr>
                                        {/if}
                                        {if "mb_address"|in_array:$displayUserDetail}
                                        <tr>
                                            <th>MBﾒｰﾙｱﾄﾞﾚｽ</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="mb_address" value="{$userData.mb_address}" style="ime-mode:disabled" size="50">
                                            </td>
                                        </tr>
                                        {/if}
                                        {if "mb_address_no_domain"|in_array:$displayUserDetail}
                                        <tr>
                                            <th>MBﾒｰﾙｱﾄﾞﾚｽ(ドメインなし)</th>
                                            <td style="text-align: left;">
                                                {$userData.mb_address_no_domain}
                                            </td>
                                        </tr>
                                        {/if}
                                        <tr>
                                            <th>MBｱﾄﾞﾚｽｽﾃｰﾀｽ</th>
                                            <td style="text-align: left;">
                                                {html_options name="mb_address_status" options=$config.admin_config.address_status selected=$userData.mb_address_status}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>MB送信ｽﾃ-ﾀｽ</th>
                                            <td style="text-align: left;">
                                                {html_options name="mb_send_status" options=$config.admin_config.address_send_status selected=$userData.mb_send_status}
                                             </td>
                                        </tr>
                                        <tr>
                                            <th>MBﾒｰﾙ受信設定</th>
                                            <td style="text-align: left;">
                                                {html_options name="mb_is_mailmagazine" options=$config.common_config.is_mailmagazine selected=$userData.mb_is_mailmagazine}
                                             </td>
                                        </tr>
                                        {if "mb_user_agent"|in_array:$displayUserDetail}
                                        <tr>
                                            <th>MBﾕｰｻﾞｰｴｰｼﾞｪﾝﾄ</th>
                                            <td style="text-align: left;">{$userData.mb_user_agent}</td>
                                        </tr>
                                        {/if}
                                        <tr>
                                            <th>MBｴﾗｰﾒｰﾙ数</th>
                                            <td style="text-align: left;">{$userData.mb_emsys_count}回</td>
                                        </tr>
                                        {if "mb_ip_address"|in_array:$displayUserDetail}
                                        <tr>
                                            <th>MBIPｱﾄﾞﾚｽ</th>
                                            <td style="text-align: left;">{$userData.mb_ip_address}</td>
                                        </tr>
                                        {/if}
                                        {if "mb_model"|in_array:$displayUserDetail}
                                        <tr>
                                            <th>ﾕｰｻﾞｰ携帯機種名</th>
                                            <td style="text-align: left;">{$userData.mb_model}</td>
                                        </tr>
                                        {/if}
                                        <tr>
                                            <th>媒体ｺｰﾄﾞ</th>
                                            <td style="text-align: left;"><input type="text" name="media_cd" value="{$userData.media_cd}" style="ime-mode:disabled" size="10"style="text-align:right;"></td>
                                        </tr>
                                        <tr>
                                            <th>保有ﾎﾟｲﾝﾄ</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="point" value="{$userData.point}" style="ime-mode:disabled" size="7"style="text-align:right;">pt
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>合計付与ﾎﾟｲﾝﾄ</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="total_addition_point" value="{$userData.total_addition_point}" style="ime-mode:disabled" size="7"style="text-align:right;">pt
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>合計使用ﾎﾟｲﾝﾄ</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="total_use_point" value="{$userData.total_use_point}" style="ime-mode:disabled" size="7"style="text-align:right;">pt
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>管理ﾎﾞｯｸｽ</th>
                                            <td style="text-align: left;">
                                                {html_options name="admin_id" options=$adminList selected=$userData.admin_id}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>購入金額</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="total_payment" value="{$userData.total_payment}" style="ime-mode:disabled" size="7"style="text-align:right;">円
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>購入回数</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="buy_count" value="{$userData.buy_count}" style="ime-mode:disabled" size="3"style="text-align:right;">回
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>キャンセル回数</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="cancel_count" value="{$userData.cancel_count}" style="ime-mode:disabled" size="3"style="text-align:right;">回
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>平均購入金額</th>
                                            <td style="text-align: left;">
                                                <input type="text" value="{$userData.average_item}" style="ime-mode:disabled" size="3"style="text-align:right;" readonly>円
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>最高購入金額</th>
                                            <td style="text-align: left;">
                                                <input type="text" value="{$userData.expensive_item}" style="ime-mode:disabled" size="3"style="text-align:right;" readonly>円
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>最低購入金額</th>
                                            <td style="text-align: left;">
                                                <input type="text" value="{$userData.cheap_item}" style="ime-mode:disabled" size="3"style="text-align:right;" readonly>円
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>中央値</th>
                                            <td style="text-align: left;">
                                                <input type="text" value="{$userData.median_item}" style="ime-mode:disabled" size="3"style="text-align:right;" readonly>円
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>最頻値</th>
                                            <td style="text-align: left;">
                                                <input type="text" value="{$userData.frequently_item}" style="ime-mode:disabled" size="3"style="text-align:right;" readonly>円
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>登録時発行状況</th>
                                            <td style="text-align: left;">{if $userData.affiliate_tag_status}発行済{else}未発行{/if}</td>
                                        </tr>
                                        {if "affiliate_tag_url"|in_array:$displayUserDetail}
                                        <tr>
                                            <th>登録時発行タグ</th>
                                            <td style="text-align: left;">{$userData.affiliate_tag_url}</td>
                                        </tr>
                                        {/if}
                                        <tr>
                                            <th>登録入口ID</th>
                                            <td style="text-align: left;"><input type="text" name="regist_page_id" value="{$userData.regist_page_id}" style="ime-mode:disabled" size="3"style="text-align:right;"></td>
                                        </tr>
                                        <tr>
                                            <th>仮登録日時</th>
                                            <td style="text-align: left;">
                                                <input size="15" class="datepicker" type="text" value="{$userData.pre_regist_datetime|zend_date_format:'yyyy-MM-dd'}" name="pre_regist_datetime_Date" maxlength="10">
                                                <input name="pre_regist_datetime_Time" class="time" type="text" value="{$userData.pre_regist_datetime|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>登録日時</th>
                                            <td style="text-align: left;">
                                                <input size="15" class="datepicker" type="text" value="{$userData.regist_datetime|zend_date_format:'yyyy-MM-dd'}" name="regist_datetime_Date" maxlength="10">
                                                <input name="regist_datetime_Time" class="time" type="text" value="{$userData.regist_datetime|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>初回入金日時</th>
                                            <td style="text-align: left;">
                                                <input size="15" class="datepicker" type="text" value="{$userData.first_pay_datetime|zend_date_format:'yyyy-MM-dd'}" name="first_pay_datetime_Date" maxlength="10">
                                                <input name="first_pay_datetime_Time" class="time" type="text" value="{$userData.first_pay_datetime|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>最終購入日時</th>
                                            <td style="text-align: left;">
                                                <input size="15" class="datepicker" type="text" value="{$userData.last_buy_datetime|zend_date_format:'yyyy-MM-dd'}" name="last_buy_datetime_Date" maxlength="10">
                                                <input name="last_buy_datetime_Time" class="time" type="text" value="{$userData.last_buy_datetime|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>最終ｱｸｾｽ日時</th>
                                            <td style="text-align: left;">
                                                <input size="15" class="datepicker" type="text" value="{$userData.last_access_datetime|zend_date_format:'yyyy-MM-dd'}" name="last_access_datetime_Date" maxlength="10">
                                                <input name="last_access_datetime_Time" class="time" type="text" value="{$userData.last_access_datetime|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>ﾛｸﾞｲﾝ後ﾄｯﾌﾟｱｸｾｽ日時</th>
                                            <td style="text-align: left;">
                                                <input size="15" class="datepicker" type="text" value="{$userData.home_access_datetime|zend_date_format:'yyyy-MM-dd'}" name="home_access_datetime_date" maxlength="10">
                                                <input name="home_access_datetime_time" class="time" type="text" value="{$userData.home_access_datetime|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>退会日時</th>
                                            <td style="text-align: left;">
                                                <input size="15" class="datepicker" type="text" value="{$userData.quit_datetime|zend_date_format:'yyyy-MM-dd'}" name="quit_datetime_Date" maxlength="10">
                                                <input name="quit_datetime_Time" class="time" type="text" value="{$userData.quit_datetime|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>生年月日</th>
                                            <td style="text-align: left;">
                                                <input size="15" class="datepicker" type="text" value="{$userData.birth_date|zend_date_format:'yyyy-MM-dd'}" name="birth_date" maxlength="10">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>強行メール回数</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="reverse_mail_status_count" value="{$userData.reverse_mail_status_count}" style="ime-mode:disabled" size="3" style="text-align:right;">回
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>PC配信ドメイン</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="pc_mailmagazine_from_domain" value="{$userData.pc_mailmagazine_from_domain}" style="ime-mode:disabled" size="25" style="text-align:right;">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>MB配信ドメイン</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="mb_mailmagazine_from_domain" value="{$userData.mb_mailmagazine_from_domain}" style="ime-mode:disabled" size="25" style="text-align:right;">
                                            </td>
                                        </tr>
                                        {if "bank_name"|in_array:$displayUserDetail}
                                        <tr>
                                            <th>銀行名</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="bank_name" value="{$userData.bank_name}" size="20">
                                            </td>
                                        </tr>
                                        {/if}
                                        {if "bank_code"|in_array:$displayUserDetail}
                                        <tr>
                                            <th>銀行コード</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="bank_code" value="{$userData.bank_code}" style="ime-mode:disabled" size="7">
                                            </td>
                                        </tr>
                                        {/if}
                                        {if "branch_name"|in_array:$displayUserDetail}
                                        <tr>
                                            <th>支店名</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="branch_name" value="{$userData.branch_name}" size="20">
                                            </td>
                                        </tr>
                                        {/if}
                                        {if "branch_code"|in_array:$displayUserDetail}
                                        <tr>
                                            <th>支店コード</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="branch_code" value="{$userData.branch_code}" style="ime-mode:disabled" size="7">
                                            </td>
                                        </tr>
                                        {/if}
                                        {if "type"|in_array:$displayUserDetail}
                                        <tr>
                                            <th>種別</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="type" value="{$userData.type}" size="6">
                                            </td>
                                        </tr>
                                        {/if}
                                        {if "account_number"|in_array:$displayUserDetail}
                                        <tr>
                                            <th>口座番号</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="account_number" value="{$userData.account_number}" style="ime-mode:disabled" size="10" maxlength="7">
                                            </td>
                                        </tr>
                                        {/if}
                                        {if "account_holder_name"|in_array:$displayUserDetail}
                                        <tr>
                                            <th>名義人</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="account_holder_name" value="{$userData.account_holder_name}" size="20">
                                            </td>
                                        </tr>
                                        {/if}
                                        {if "postal_code"|in_array:$displayUserDetail}
                                        <tr>
                                            <th>郵便番号</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="postal_code" value="{$userData.postal_code}" style="ime-mode:disabled" size="10" maxlength="7">
                                            </td>
                                        </tr>
                                        {/if}
                                        {if "address"|in_array:$displayUserDetail}
                                        <tr>
                                            <th>住所</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="address" value="{$userData.address}" size="70">
                                            </td>
                                        </tr>
                                        {/if}
                                        {if "address_name"|in_array:$displayUserDetail}
                                        <tr>
                                            <th>名前</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="address_name" value="{$userData.address_name}" size="20">
                                            </td>
                                        </tr>
                                        {/if}
                                        {if "phone_number"|in_array:$displayUserDetail}
                                        <tr>
                                            <th>電話番号1</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="phone_number" value="{$userData.phone_number}" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>電話番号2</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="phone_number2" value="{$userData.phone_number2}" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>電話番号3</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="phone_number3" value="{$userData.phone_number3}" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>電話受信設定</th>
                                            <td style="text-align: left;">
                                                {html_options name="phone_is_use" options=$phoneIsUse selected=$userData.phone_is_use}
                                             </td>
                                        </tr>
                                        {/if}
                                        <tr>
                                            <th>備考</th>
                                            <td style="text-align: left;">
                                                <textarea name="description" rows="5" cols="50">{$userData.description}</textarea>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align:top;text-align:right;">
                        <input type="submit" name="action_user_UpdateExec" value="更新" OnClick="return confirm('更新しますか？')" style="width:8em;"/>
                    </td>
                </tr>
                {* 管理者 システム用メニュー *}
                {if $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SYSTEM
                    OR $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_MANAGE}
                <tr>
                    <td style="vertical-align:top;">
                        <input type="submit" name="action_user_DeleteExec" value="削除" OnClick="return confirm('本当に削除しますか？')" style="width:8em;"/>
                    </td>
                </tr>
                {/if}
            </table>
        </form>
    {else}
        <div class="warning ui-widget">
        <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
        <p>
        <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
        該当データはありません
        </p>
        </div>
    {/if}
{include file=$admFooter}
</div>
<script type="text/javascript" src="./js/jquery.timepickr.min.js"></script>
<script language="JavaScript">
<!--
    $(function() {ldelim}

        // カレンダー
        $(".datepicker").datepicker({ldelim}
            showOn: 'button',
            buttonImage: './img/calendar.gif',
            buttonImageOnly: true,
            dateFormat: "yy-mm-dd"
        {rdelim});

    {rdelim});

// -->
</script>
</body>
</html>
