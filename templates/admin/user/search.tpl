{include file=$admHeader}
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
<style type="text/css">
.watermark {ldelim}
   color: #999;
{rdelim}
</style>
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">ユーザー検索</h2>
{if $errMsg|@count}
    <div class="warning ui-widget">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    <p>
    <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    { foreach from=$errMsg item="val"}
        {$val|@implode:"<br>"}
    {/foreach}
    </p>
    </div>
    </div>
    <br>
{/if}
<table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
    <tr>
        <th style="text-align: center; font-weight: bold;">検索条件ロード<br><a href="{make_link action="action_user_SearchConditionList"}" target="_blank">検索条件保存リスト</a></th>
    </tr>
        <tr>
            <td>
                <form action="./" method="POST">
                    検索条件保存ID：<input type="text" name="search_conditions_id" value="" size="7" style="ime-mode:disabled">
                    <input type="submit" name="action_user_Search" value="検索条件ロード">
                </form>
            </td>
        </tr>
</table>
<br>
<form action="./" method="post" name="userSearch">
{$POSTparam}
<table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet01" width="95%">

<tr>
<th colspan="2" style="text-align: center; font-weight: bold;">ユーザー情報関連</th>
</tr>

<tr>
    <td>ユーザーID<br>(カンマ区切りで複数可)</td>
    <td style="text-align: left;">
        <input type="text" name="user_id" value="{$value.user_id}" size="30" style="ime-mode:disabled">&nbsp;&nbsp;{html_radios id="user_id_specify_target_including" name="user_id_specify_target_including" options=$config.admin_config.specify_target_including selected=$value.user_id_specify_target_including|default:"1" separator="&nbsp;"}
    </td>
</tr>
<tr>
    <td>性別</td>
    <td style="text-align: left;">
        {html_checkboxes name="sex_cd" options=$config.admin_config.sex_cd selected=$value.sex_cd separator="&nbsp;"}
    </td>
</tr>
<tr>
    <td>ログインID<br>(前方一致)</td>
    <td style="text-align: left;">
        <div id="login_id">
            <input type="text" name="login_id" value="{$value.login_id}" size="30" style="ime-mode:disabled">
        </div>
    </td>
</tr>
<tr>
    <td>PCアドレス</td>
    <td style="text-align: left;">
        {html_radios id="pc_specify_address" name="pc_specify_address" options=$config.admin_config.specify_address selected=$value.pc_specify_address separator="&nbsp;"}
        <div id="pc_address">
            <input type="text" name="pc_address" value="{$value.pc_address}" size="30" style="ime-mode:disabled">
        </div>
    </td>
</tr>
<tr>
    <td>MBアドレス</td>
    <td style="text-align: left;">
        {html_radios id="mb_specify_address" name="mb_specify_address" options=$config.admin_config.specify_address selected=$value.mb_specify_address separator="&nbsp;"}
        <div id="mb_address">
            <input type="text" name="mb_address" value="{$value.mb_address}" size="30" style="ime-mode:disabled">
        </div>
    </td>
</tr>
<tr>
    <td>PCデバイス</td>
    <td style="text-align: left;">
        {html_checkboxes name="pc_device_cd" options=$config.admin_config.pc_device selected=$value.pc_device_cd separator="&nbsp;"}
    </td>
</tr>
<tr>
    <td>MBデバイス</td>
    <td style="text-align: left;">
        {html_checkboxes name="mb_device_cd" options=$config.admin_config.mb_device selected=$value.mb_device_cd separator="&nbsp;"}
    </td>
</tr>
<tr>
    <td>個体識別番号<br>(前方一致)</td>
    <td style="text-align: left;">
        <div id="mb_serial_number">
            <input type="text" name="mb_serial_number" value="{$value.mb_serial_number}" size="50" style="ime-mode:disabled">
        </div>
    </td>
</tr>
<tr>
    <td>PC IPｱﾄﾞﾚｽ<br>(前方一致)</td>
    <td style="text-align: left;">
        <div id="pc_ip_address">
            <input type="text" name="pc_ip_address" value="{$value.pc_ip_address}" size="50" style="ime-mode:disabled">
        </div>
    </td>
</tr>
<tr>
    <td>ｽﾏｰﾄﾌｫﾝOS</td>
    <td style="text-align: left;">
        {html_checkboxes name="smart_phone_os" options=$config.admin_config.smart_phone_os selected=$value.smart_phone_os separator="&nbsp;"}
    </td>
</tr>
<tr>
    <td>ユーザーステイタス</td>
    <td style="text-align: left;">
        {html_checkboxes name="regist_status" options=$config.admin_config.regist_status selected=$value.regist_status|default:$defaultRegistUserStatus separator="&nbsp;"}
    </td>
</tr>
<tr>
    <td>PCｱﾄﾞﾚｽｽﾃｲﾀｽ</td>
    <td style="text-align: left;">
        {html_checkboxes name="pc_address_status" options=$config.admin_config.address_status selected=$value.pc_address_status separator="&nbsp;"}
    </td>
</tr>
<tr>
    <td>PC送信ｽﾃｲﾀｽ</td>
    <td style="text-align: left;">
        {html_checkboxes name="pc_send_status" options=$config.admin_config.address_send_status selected=$value.pc_send_status separator="&nbsp;"}
    </td>
</tr>
<tr>
    <td>PCﾒｰﾙ受信設定</td>
    <td style="text-align: left;">
        {html_checkboxes name="pc_is_mailmagazine" options=$config.common_config.is_mailmagazine selected=$value.pc_is_mailmagazine separator="&nbsp;"}
    </td>
</tr>
<tr>
    <td>MBｱﾄﾞﾚｽｽﾃｲﾀｽ</td>
    <td style="text-align: left;">
        {html_checkboxes name="mb_address_status" options=$config.admin_config.address_status selected=$value.mb_address_status separator="&nbsp;"}
    </td>
</tr>
<tr>
    <td>MB送信ｽﾃｲﾀｽ</td>
    <td style="text-align: left;">
        {html_checkboxes name="mb_send_status" options=$config.admin_config.address_send_status selected=$value.mb_send_status separator="&nbsp;"}
    </td>
</tr>
<tr>
    <td>MBﾒｰﾙ受信設定</td>
    <td style="text-align: left;">
        {html_checkboxes name="mb_is_mailmagazine" options=$config.common_config.is_mailmagazine selected=$value.mb_is_mailmagazine separator="&nbsp;"}
    </td>
</tr>
<tr>
    <td>ｱﾄﾞﾚｽｽﾃｲﾀｽ</td>
    <td style="text-align: left;">
        {html_checkboxes name="is_address_status_or" options=$config.admin_config.is_address_send_status_or selected=$value.is_address_status_or separator="&nbsp;"}
    </td>
</tr>
<tr>
    <td>ﾒｰﾙ送信ｽﾃｲﾀｽ</td>
    <td style="text-align: left;">
        {html_checkboxes name="is_address_send_status_or" options=$config.admin_config.is_address_send_status_or selected=$value.is_address_send_status_or separator="&nbsp;"}
    </td>
</tr>
<tr>
    <td>ﾒｰﾙ受信設定</td>
    <td style="text-align: left;">
        {html_checkboxes name="is_mailmagazine_or" options=$config.admin_config.is_mailmagazine_or selected=$value.is_mailmagazine_or separator="&nbsp;"}
    </td>
</tr>
<tr>
    <td>PCﾒｰﾙ強行</td>
    <td style="text-align: left;">
        {html_checkboxes name="is_pc_reverse" options=$config.admin_config.reverse_status selected=$value.is_pc_reverse separator="&nbsp;"}
    </td>
</tr>
<tr>
    <td>MBﾒｰﾙ強行</td>
    <td style="text-align: left;">
        {html_checkboxes name="is_mb_reverse" options=$config.admin_config.reverse_status selected=$value.is_mb_reverse separator="&nbsp;"}
    </td>
</tr>
<tr>
    <td>PC配信ドメイン</td>
    <td style="text-align: left;">
        {html_checkboxes name="pc_send_domain_type" options=$sendDomainType selected=$value.pc_send_domain_type separator="&nbsp;" assign="checkboxes"}
        {foreach from=$checkboxes item="checkbox"}
            {$checkbox}{cycle values=",,,<br />"}
        {/foreach}
    </td>
</tr>
<tr>
    <td>MB配信ドメイン</td>
    <td style="text-align: left;">
        {html_checkboxes name="mb_send_domain_type" options=$sendDomainType selected=$value.mb_send_domain_type separator="&nbsp;" assign="checkboxes"}
        {foreach from=$checkboxes item="checkbox"}
            {$checkbox}{cycle values=",,,<br />"}
        {/foreach}
    </td>
</tr>
<tr>
    <td>電話番号</td>
    <td style="text-align: left;">
        {html_radios id="specify_phone_number" name="specify_phone_number" options=$config.admin_config.specify_address selected=$value.specify_phone_number separator="&nbsp;"}
        <div id="phone_number">
            <input type="text" name="phone_number" value="{$value.phone_number}" size="30" style="ime-mode:disabled">
        </div>
    </td>
</tr>

<tr>
    <td>電話受信</td>
    <td style="text-align: left;">
        {html_options name="phone_is_use" options=$phoneIsUse selected=$value.phone_is_use}
    </td>
</tr>
<tr>
    <td>ブラック</td>
    <td style="text-align: left;">
        {html_checkboxes name="danger_status" options=$config.admin_config.danger_status selected=$value.danger_status separator="&nbsp;"}
    </td>
</tr>
<tr>
    <td>入金種別</td>
    <td style="text-align: left;">
        {html_checkboxes name="pay_type" options=$payType selected=$value.pay_type separator="&nbsp;" assign="checkboxes"}
        {foreach from=$checkboxes item="checkbox"}
            {$checkbox}{cycle values=",,,<br />"}
        {/foreach}
    </td>
</tr>
<tr>
<td>購入商品ID<br>(カンマ区切りで複数可)</td>
    <td style="text-align: left;">
        <div>
            対象を抽出：<input type="text" name="item_id" value="{$value.item_id}" size="20" style="ime-mode:disabled;">&nbsp;&nbsp;{html_radios id="item_specify_target_select" name="item_specify_target_select" options=$config.admin_config.specify_target_select selected=$value.item_specify_target_select separator="&nbsp;"}
        </div>
        <div>
            以外を抽出：<input type="text" name="except_item_id" value="{$value.except_item_id}" size="20" style="ime-mode:disabled;">&nbsp;&nbsp;{html_radios id="except_item_specify_target_select" name="except_item_specify_target_select" options=$config.admin_config.specify_target_select selected=$value.except_item_specify_target_select separator="&nbsp;"}
        </div>
    </td>
</tr>

<tr>
<td>ユニットID<br>(カンマ区切りで複数可)<br>※5個まで(推奨)※</td>
    <td style="text-align: left;">
        <div>
            対象を抽出：<input type="text" name="unit_id" value="{$value.unit_id}" size="20" style="ime-mode:disabled;">&nbsp;&nbsp;{html_radios id="unit_specify_target_select" name="unit_specify_target_select" options=$config.admin_config.specify_target_select selected=$value.unit_specify_target_select separator="&nbsp;"}
        </div>
        <div>
            以外を抽出：<input type="text" name="except_unit_id" value="{$value.except_unit_id}" size="20" style="ime-mode:disabled;">&nbsp;&nbsp;{html_radios id="except_unit_specify_target_select" name="except_unit_specify_target_select" options=$config.admin_config.specify_target_select selected=$value.except_unit_specify_target_select separator="&nbsp;"}
        </div>
    </td>
</tr>

<tr>
<td>抽選ユニットID<br>(カンマ区切りで複数可)</td>
    <td style="text-align: left;">
        <div>
            対象を抽出：<input type="text" name="lottery_unit_id" value="{$value.lottery_unit_id}" size="20" style="ime-mode:disabled;">&nbsp;&nbsp;{html_radios id="lottery_unit_specify_target_select" name="lottery_unit_specify_target_select" options=$config.admin_config.specify_target_select selected=$value.lottery_unit_specify_target_select separator="&nbsp;"}
        </div>
        <div>
            以外を抽出：<input type="text" name="except_lottery_unit_id" value="{$value.except_lottery_unit_id}" size="20" style="ime-mode:disabled;">&nbsp;&nbsp;{html_radios id="except_lottery_unit_specify_target_select" name="except_lottery_unit_specify_target_select" options=$config.admin_config.specify_target_select selected=$value.except_lottery_unit_specify_target_select separator="&nbsp;"}
        </div>
    </td>
</tr>

<tr>
<td>既読情報ID<br>(カンマ区切りで複数可)</td>
    <td style="text-align: left;">
        <div>
            対象を抽出：<input type="text" name="information_id" value="{$value.information_id}" size="20" style="ime-mode:disabled;">&nbsp;&nbsp;{html_radios id="information_specify_target_select" name="information_specify_target_select" options=$config.admin_config.specify_target_select selected=$value.information_specify_target_select separator="&nbsp;"}
        </div>
        <div>
            以外を抽出：<input type="text" name="except_information_id" value="{$value.except_information_id}" size="20" style="ime-mode:disabled;">&nbsp;&nbsp;{html_radios id="except_information_specify_target_select" name="except_information_specify_target_select" options=$config.admin_config.specify_target_select selected=$value.except_information_specify_target_select separator="&nbsp;"}
        </div>
    </td>
</tr>
<!--
<tr>
    <td>注文検索（商品ＩＤ）</td>
    <td style="text-align: left;">
        <div id="ordering_item_id">
            <input type="text" name="ordering_item_id" value="{$value.ordering_item_id}" size="10" style="ime-mode:disabled">
            <font color="red">※入金無し対象</font>
        </div>
        {html_checkboxes name="is_cancel" id="is_cancel" options=$cancelFlag selected=$value.is_cancel separator="&nbsp;"}
    </td>
</tr>
-->

<tr>
    <td>注文検索（商品ＩＤ）</td>
    <td style="text-align: left;">
        <div id="ordering_item_id">
                      対象を抽出：<input type="text" name="ordering_item_id" value="{$value.ordering_item_id}" size="20" style="ime-mode:disabled;">&nbsp;&nbsp;{html_radios id="ordering_item_specify_target_select" name="ordering_item_specify_target_select" options=$config.admin_config.specify_target_select selected=$value.ordering_item_specify_target_select separator="&nbsp;"}
        </div>
        <div id="ordering_item_id">
                      以外を抽出：<input type="text" name="except_ordering_item_id" value="{$value.except_ordering_item_id}" size="20" style="ime-mode:disabled;">&nbsp;&nbsp;{html_radios id="except_ordering_item_specify_target_select" name="except_ordering_item_specify_target_select" options=$config.admin_config.specify_target_select selected=$value.except_ordering_item_specify_target_select separator="&nbsp;"}
        </div>
        {html_checkboxes name="is_cancel" id="is_cancel" options=$cancelFlag selected=$value.is_cancel separator="&nbsp;"}
        <font color="red">※入金無し対象</font>
    </td>
</tr>

<tr>
    <td>登録入口カテゴリー</td>
    <td style="text-align: left;">
        {html_checkboxes name="regist_page_category_id" options=$registPageCategoryList selected=$value.regist_page_category_id separator="&nbsp;" assign="checkboxes"}
        {foreach from=$checkboxes item="checkbox"}
            {$checkbox}{cycle values=",,,<br />"}
        {/foreach}
    </td>
</tr>

<tr>
<td>登録入口ID<br>(カンマ区切りで複数可)</td>
    <td style="text-align: left;">
        <div>
            対象を抽出：<input type="text" name="regist_page_id" value="{$value.regist_page_id}" size="20" style="ime-mode:disabled;">
        </div>
        <div>
            以外を抽出：<input type="text" name="except_regist_page_id" value="{$value.except_regist_page_id}" size="20" style="ime-mode:disabled;">
        </div>
    </td>
</tr>
<tr>
<td>検索保存条件を省く(除外)</td>
<td style="text-align: left;">
      <input type="text" name="search_condition_ids" value="{$value.search_condition_ids}" size="20" style="ime-mode:disabled;">
    </td>
</tr>
<tr>
<td>ログイン後トップアクセス</td>
    <td style="text-align: left;">
       登録日時とﾛｸﾞｲﾝ後ﾄｯﾌﾟｱｸｾｽ日時の差分
        <input type="text" name="difference_between_regist_and_home_from" value="{$value.difference_between_regist_and_home_from}" size="5" style="ime-mode:disabled;text-align:right;">
        秒から
        <input type="text" name="difference_between_regist_and_home_to" value="{$value.difference_between_regist_and_home_to}" size="5" style="ime-mode:disabled;text-align:right;">
        秒   <font color="red">※両方のﾌｫｰﾑに値を入れて下さい</font><br>
       <input type="checkbox" name="is_home_acccess_datetime" value="1" {if $value.is_home_acccess_datetime} checked/ {/if}>ﾛｸﾞｲﾝ後ﾄｯﾌﾟｱｸｾｽ有り
       <input type="checkbox" name="is_not_home_acccess_datetime" value="1" {if $value.is_not_home_acccess_datetime} checked/ {/if}>ﾛｸﾞｲﾝ後ﾄｯﾌﾟｱｸｾｽ無し
    </td>
</tr>
<tr>
    <td>最終アクセス日</td>
    <td style="text-align: left;">
        {html_radios id="last_access" name="specify_last_access" options=$config.admin_config.specify_date_time_select selected=$value.specify_last_access separator="&nbsp;"}
        <br>
        {html_radios id="last_access" name="specify_last_access" options=$config.admin_config.specify_month_select selected=$value.specify_last_access separator="&nbsp;"}
        <br>
        <div id="last_access_date">
            <input size="15" class="datepicker" type="text" value="{$lastAccessDatetimeFrom|zend_date_format:'yyyy-MM-dd'}" name="last_access_from_Date" maxlength="10">
            <input name="last_access_from_Time" class="time" type="text" value="{$lastAccessDatetimeFrom|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
            ～&nbsp;<input size="15" class="datepicker" type="text" value="{$lastAccessDatetimeTo|zend_date_format:'yyyy-MM-dd'}" name="last_access_to_Date" maxlength="10">
            <input name="last_access_to_Time" class="time" type="text" value="{$lastAccessDatetimeTo|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
        </div>
        <div id="last_access_time">
            <input type="text" name="last_access_time_from" value="{$value.last_access_time_from}" size="4" maxlength="4" style="ime-mode:disabled;text-align:right;">
            時間前以上
            <input type="text" name="last_access_time_to" value="{$value.last_access_time_to}" size="4" maxlength="4" style="ime-mode:disabled;text-align:right;">
            時間前未満
        </div>
    </td>
</tr>
<tr>
    <td>アクセスなし<br> <font color="red">※アクセス  0000-00-00も含みます</font></td>
    <td style="text-align: left;">
        {html_radios id="not_access" name="specify_not_access" options=$config.admin_config.specify_date_time_select selected=$value.specify_not_access separator="&nbsp;"}
        <br>
        {html_radios id="not_access" name="specify_not_access" options=$config.admin_config.specify_month_select selected=$value.specify_not_access separator="&nbsp;"}
        <br>
        <div id="not_access_date">
            <input size="15" class="datepicker" type="text" value="{$notAccessDatetimeFrom|zend_date_format:'yyyy-MM-dd'}" name="not_access_from_Date" maxlength="10">
            <input name="not_access_from_Time" class="time" type="text" value="{$notAccessDatetimeFrom|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
            <span style="color:#ff0000;">←のみの入力はNG</span>
            ～&nbsp;<input size="15" class="datepicker" type="text" value="{$notAccessDatetimeTo|zend_date_format:'yyyy-MM-dd'}" name="not_access_to_Date" maxlength="10">
            <input name="not_access_to_Time" class="time" type="text" value="{$notAccessDatetimeTo|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
            <span style="color:#ff0000;">←のみの入力はOK</span>
        </div>
        <div id="not_access_time">
            <input type="text" name="not_access_time_from" value="{$value.not_access_time_from}" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
            時間前以上<span style="color:#ff0000;">←のみの入力はNG</span>
            <input type="text" name="not_access_time_to" value="{$value.not_access_time_to}" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
            時間前未満<span style="color:#ff0000;">←のみの入力はOK</span>
        </div>
    </td>
</tr>
<tr>
    <td>アクセス日時あり</td>
    <td style="text-align: left;">
        <input type="checkbox" name="except_access_no_data" value="1" {if $value.except_access_no_data} checked/ {/if}>アクセス日時 0000-00-00
    </td>
</tr>
<tr>
    <td>アクセス日時 0000-00-00</td>
    <td style="text-align: left;">
        <input type="checkbox" name="access_no_data" value="1" {if $value.access_no_data} checked/ {/if}>アクセス日時 0000-00-00
    </td>
</tr>
<tr>
    <td>仮登録日</td>
    <td style="text-align: left;">
        {html_radios id="pre_regist" name="specify_pre_regist" options=$config.admin_config.specify_date_time_select selected=$value.specify_pre_regist separator="&nbsp;"}
        <br>
        <div id="pre_regist_date">
            <input size="15" class="datepicker" type="text" value="{$preRegistDatetimeFrom|zend_date_format:'yyyy-MM-dd'}" name="pre_regist_from_Date" maxlength="10">
            <input name="pre_regist_from_Time" class="time" type="text" value="{$preRegistDatetimeFrom|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
            ～&nbsp;<input size="15" class="datepicker" type="text" value="{$preRegistDatetimeTo|zend_date_format:'yyyy-MM-dd'}" name="pre_regist_to_Date" maxlength="10">
            <input name="pre_regist_to_Time" class="time" type="text" value="{$preRegistDatetimeTo|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
        </div>
        <div id="pre_regist_time">
            <input type="text" name="pre_regist_time_from" value="{$value.pre_regist_time_from}" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
            時間前以上
            <input type="text" name="pre_regist_time_to" value="{$value.pre_regist_time_to}" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
            時間前未満
        </div>
    </td>
</tr>

<tr>
    <td>登録日</td>
    <td style="text-align: left;">
        {html_radios id="regist" name="specify_regist" options=$config.admin_config.specify_date_time_select selected=$value.specify_regist separator="&nbsp;"}
        <br>
        <div id="regist_date">
            <input size="15" class="datepicker" type="text" value="{$registDatetimeFrom|zend_date_format:'yyyy-MM-dd'}" name="regist_from_Date" maxlength="10">
            <input name="regist_from_Time" class="time" type="text" value="{$registDatetimeFrom|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
            ～&nbsp;<input size="15" class="datepicker" type="text" value="{$registDatetimeTo|zend_date_format:'yyyy-MM-dd'}" name="regist_to_Date" maxlength="10">
            <input name="regist_to_Time" class="time" type="text" value="{$registDatetimeTo|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
        </div>
        <div id="regist_time">
            <input type="text" name="regist_time_from" value="{$value.regist_time_from}" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
            時間前以上
            <input type="text" name="regist_time_to" value="{$value.regist_time_to}" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
            時間前未満
        </div>
    </td>
</tr>

<tr>
<td>仮登録経過日</td>
    <td style="text-align: left;">
        <input type="text" class="from" name="pre_past_date_from" value="{$value.pre_past_date_from}" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
        日前以上
        <input type="text" class="to" name="pre_past_date_to" value="{$value.pre_past_date_to}" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
        日前まで
    </td>
</tr>
<tr>
<td>登録経過日</td>
    <td style="text-align: left;">
        <input type="text" class="from" name="past_date_from" value="{$value.past_date_from}" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
        日前以上
        <input type="text" class="to" name="past_date_to" value="{$value.past_date_to}" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
        日前まで
    </td>
</tr>

<tr>
    <td>フリーワード数字(ﾕｰｻﾞｰ選択)</td>
    <td style="text-align: left;">
       {html_radios id="specify_free_word" name="specify_free_word" options=$freeWord selected=$value.specify_free_word separator="&nbsp;"}
        &nbsp;&nbsp;&nbsp;小～大 は必ず入力して下さい。
        <div id="free_word_data">
            {section name=cnt start=1  loop=11}
                {assign var="countA" value=$countA|cat:"0"}
                {assign var="countB" value=$countB|cat:"9"}

                {assign var="free_word_type_from" value="free_word_type_from_1__"|cat:$smarty.section.cnt.index}
                {assign var="free_word_type_to" value="free_word_type_to_1__"|cat:$smarty.section.cnt.index}
                {assign var="specify_free_word_type" value="specify_free_word_type_1__"|cat:$smarty.section.cnt.index}
                {html_radios id="free_word_type_1__"|cat:$smarty.section.cnt.index name="specify_free_word_type_1__"|cat:$smarty.section.cnt.index options=$isSetting selected=$value[$specify_free_word_type] separator="&nbsp;"}
                &nbsp;
                <input type="text" class="from" name="free_word_type_from_1__{$smarty.section.cnt.index}" value="{$value[$free_word_type_from]}" size="10" maxlength="{$smarty.section.cnt.index}" style="ime-mode:disabled;text-align:right;">
                {$countA}～&nbsp;
                <input type="text" class="to" name="free_word_type_to_1__{$smarty.section.cnt.index}" value="{$value[$free_word_type_to]}" size="10" maxlength="{$smarty.section.cnt.index}" style="ime-mode:disabled;text-align:right;">
                {$countB}&nbsp;<font color="red">-%free_word_1_{$smarty.section.cnt.index}- &nbsp&nbsp({$smarty.section.cnt.index}桁)</font>
                <br>
            {/section}
        </div>
    </td>
</tr>

<tr>
    <td>フリーワード文言(管理選択)</td>
    <td style="text-align: left;">
       {html_radios id="specify_free_word_set" name="specify_free_word_set" options=$freeWord selected=$value.specify_free_word_set separator="&nbsp;"}
        &nbsp;&nbsp;&nbsp;小～大 は必ず入力して下さい。
        <div id="free_word_data_set">
            {foreach from=$freeWordList key=key item=item}
                {assign var="free_word_set_check" value="free_word_type_set_2__"|cat:$key}
                {assign var="specify_free_word_type_set" value="specify_free_word_type_set_2__"|cat:$key}
                {html_radios id="specify_free_word_type_set_2__"|cat:$key name="specify_free_word_type_set_2__"|cat:$key options=$isSetting selected=$value[$specify_free_word_type_set] separator="&nbsp;"}
                  ～&nbsp;<font color="red">-%free_word_2_{$key}- </font><br>
                {html_checkboxes name="free_word_type_set_2__"|cat:$key options=$item selected=$value[$free_word_set_check] separator="&nbsp;"}<br><br>
            {/foreach}
        </div>
    </td>
</tr>

<tr>
    <td>期間消費ポイント</td>
    <td style="text-align: left;">
        {html_radios id="use_point" name="specify_use_point" options=$config.admin_config.specify_date_time_select selected=$value.specify_use_point separator="&nbsp;"}
        <br>
        <div id="use_point_date">
            <input size="15" class="datepicker" type="text" value="{$usePointDatetimeFrom|zend_date_format:'yyyy-MM-dd'}" name="use_point_from_Date" maxlength="10">
            <input name="use_point_from_Time" class="time" type="text" value="{$usePointDatetimeFrom|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
            ～&nbsp;<input size="15" class="datepicker" type="text" value="{$usePointDatetimeTo|zend_date_format:'yyyy-MM-dd'}" name="use_point_to_Date" maxlength="10">
            <input name="use_point_to_Time" class="time" type="text" value="{$usePointDatetimeTo|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
        </div>
        <div id="use_point_time">
            <input type="text" name="use_point_time_from" value="{$value.use_point_time_from}" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
            時間前以上
            <input type="text" name="use_point_time_to" value="{$value.use_point_time_to}" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
            時間前未満
        </div>
        <div id="use_point_val">
            <input type="text" class="from" name="use_point_from" value="{$value.use_point_from}" size="5" style="ime-mode:disabled;text-align:right;">
            pt以上
            <input type="text" class="to" name="use_point_to" value="{$value.use_point_to}" size="5" style="ime-mode:disabled;text-align:right;">
            ptまで
        </div>
    </td>
</tr>

<tr>
<td>保有ポイント</td>
    <td style="text-align: left;">
        <input type="text" class="from" name="point_from" value="{$value.point_from}" size="5" style="ime-mode:disabled;text-align:right;">
        pt以上
        <input type="text" class="to" name="point_to" value="{$value.point_to}" size="5" style="ime-mode:disabled;text-align:right;">
        ptまで
    </td>
</tr>

<tr>
<td>合計付与ポイント</td>
    <td style="text-align: left;">
        <input type="text" class="from" name="total_addition_point_from" value="{$value.total_addition_point_from}" size="5" style="ime-mode:disabled;text-align:right;">
        pt以上
        <input type="text" class="to" name="total_addition_point_to" value="{$value.total_addition_point_to}" size="5" style="ime-mode:disabled;text-align:right;">
        ptまで
    </td>
</tr>

<tr>
<td>合計使用ポイント</td>
    <td style="text-align: left;">
        <input type="text" class="from" name="total_use_point_from" value="{$value.total_use_point_from}" size="5" style="ime-mode:disabled;text-align:right;">
        pt以上
        <input type="text" class="to" name="total_use_point_to" value="{$value.total_use_point_to}" size="5" style="ime-mode:disabled;text-align:right;">
        ptまで
    </td>
</tr>

<tr>
    <td>初回入金日</td>
    <td style="text-align: left;">
        {html_radios id="first_pay" name="specify_first_pay" options=$config.admin_config.specify_date_time_select selected=$value.specify_first_pay separator="&nbsp;"}
        <br>
        <div id="first_pay_date">
            <input size="15" class="datepicker" type="text" value="{$firstPayDatetimeFrom|zend_date_format:'yyyy-MM-dd'}" name="first_pay_from_Date" maxlength="10">
            <input name="first_pay_from_Time" class="time" type="text" value="{$firstPayDatetimeFrom|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
            ～&nbsp;<input size="15" class="datepicker" type="text" value="{$firstPayDatetimeTo|zend_date_format:'yyyy-MM-dd'}" name="first_pay_to_Date" maxlength="10">
            <input name="first_pay_to_Time" class="time" type="text" value="{$firstPayDatetimeTo|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
        </div>
        <div id="first_pay_time">
            <input type="text" name="first_pay_time_from" value="{$value.first_pay_time_from}" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
            時間前以上
            <input type="text" name="first_pay_time_to" value="{$value.first_pay_time_to}" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
            時間前未満
        </div>
    </td>
</tr>

<tr>
    <td>期間購入金額</td>
    <td style="text-align: left;">
        {html_radios id="terms_pay" name="specify_terms_pay" options=$config.admin_config.specify_date_time_select selected=$value.specify_terms_pay separator="&nbsp;"}
        <br>
        <div id="terms_pay_date">
            <input size="15" class="datepicker" type="text" value="{$termsPayDatetimeFrom|zend_date_format:'yyyy-MM-dd'}" name="terms_pay_from_Date" maxlength="10">
            <input name="terms_pay_from_Time" class="time" type="text" value="{$termsPayDatetimeFrom|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
            ～&nbsp;<input size="15" class="datepicker" type="text" value="{$termsPayDatetimeTo|zend_date_format:'yyyy-MM-dd'}" name="terms_pay_to_Date" maxlength="10">
            <input name="terms_pay_to_Time" class="time" type="text" value="{$termsPayDatetimeTo|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
        </div>
        <div id="terms_pay_time">
            <input type="text" name="terms_pay_time_from" value="{$value.terms_pay_time_from}" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
            時間前以上
            <input type="text" name="terms_pay_time_to" value="{$value.terms_pay_time_to}" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
            時間前未満
        </div>
        <div id="terms_pay_val">
            <input type="text" class="from" name="terms_pay_from" value="{$value.terms_pay_from}" size="10" style="ime-mode:disabled;text-align:right;">
            円以上
            <input type="text" class="to" name="terms_pay_to" value="{$value.terms_pay_to}" size="10" style="ime-mode:disabled;text-align:right;">
            円まで
        </div>
    </td>
</tr>

<tr>
<td>平均購入金額</td>
    <td style="text-align: left;">
        <input type="text" class="from" name="average_item_from" value="{$value.average_item_from}" size="10" style="ime-mode:disabled;text-align:right;">
        円以上
        <input type="text" class="to" name="average_item_to" value="{$value.average_item_to}" size="10" style="ime-mode:disabled;text-align:right;">
        円まで
    </td>
</tr>

<tr>
<td>最高購入金額</td>
    <td style="text-align: left;">
        <input type="text" class="from" name="expensive_item_from" value="{$value.expensive_item_from}" size="10" style="ime-mode:disabled;text-align:right;">
        円以上
        <input type="text" class="to" name="expensive_item_to" value="{$value.expensive_item_to}" size="10" style="ime-mode:disabled;text-align:right;">
        円まで
    </td>
</tr>

<tr>
<td>最低購入金額</td>
    <td style="text-align: left;">
        <input type="text" class="from" name="cheap_item_from" value="{$value.cheap_item_from}" size="10" style="ime-mode:disabled;text-align:right;">
        円以上
        <input type="text" class="to" name="cheap_item_to" value="{$value.cheap_item_to}" size="10" style="ime-mode:disabled;text-align:right;">
        円まで
    </td>
</tr>

<tr>
<td>最頻値購入金額</td>
    <td style="text-align: left;">
        <input type="text" class="from" name="frequently_item_from" value="{$value.frequently_item_from}" size="10" style="ime-mode:disabled;text-align:right;">
        円以上
        <input type="text" class="to" name="frequently_item_to" value="{$value.frequently_item_to}" size="10" style="ime-mode:disabled;text-align:right;">
        円まで
    </td>
</tr>

<tr>
<td>購入金額</td>
    <td style="text-align: left;">
        <input type="text" class="from" name="total_payment_from" value="{$value.total_payment_from}" size="10" style="ime-mode:disabled;text-align:right;">
        円以上
        <input type="text" class="to" name="total_payment_to" value="{$value.total_payment_to}" size="10" style="ime-mode:disabled;text-align:right;">
        円まで
    </td>
</tr>

<tr>
<td>購入回数</td>
    <td style="text-align: left;">
        <input type="text" class="from" name="buy_count_from" value="{$value.buy_count_from}" size="5" style="ime-mode:disabled;text-align:right;">
        回以上
        <input type="text" class="to" name="buy_count_to" value="{$value.buy_count_to}" size="5" style="ime-mode:disabled;text-align:right;">
        回まで
    </td>
</tr>

<tr>
<td>キャンセル回数</td>
    <td style="text-align: left;">
        <input type="text" class="from" name="cancel_count_from" value="{$value.cancel_count_from}" size="5" style="ime-mode:disabled;text-align:right;">
        回以上
        <input type="text" class="to" name="cancel_count_to" value="{$value.cancel_count_to}" size="5" style="ime-mode:disabled;text-align:right;">
        回まで
    </td>
</tr>

<tr>
    <td>最終購入日</td>
    <td style="text-align: left;">
        {html_radios id="last_buy" name="specify_last_buy" options=$config.admin_config.specify_date_time_select selected=$value.specify_last_buy separator="&nbsp;"}
        <br>
        <div id="last_buy_date">
            <input size="15" class="datepicker" type="text" value="{$lastBuyDatetimeFrom|zend_date_format:'yyyy-MM-dd'}" name="last_buy_from_Date" maxlength="10">
            <input name="last_buy_from_Time" class="time" type="text" value="{$lastBuyDatetimeFrom|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
            ～&nbsp;<input size="15" class="datepicker" type="text" value="{$lastBuyDatetimeTo|zend_date_format:'yyyy-MM-dd'}" name="last_buy_to_Date" maxlength="10">
            <input name="last_buy_to_Time" class="time" type="text" value="{$lastBuyDatetimeTo|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
        </div>
        <div id="last_buy_time">
            <input type="text" name="last_buy_time_from" value="{$value.last_buy_time_from}" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
            時間前以上
            <input type="text" name="last_buy_time_to" value="{$value.last_buy_time_to}" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
            時間前未満
        </div>
    </td>
</tr>
<tr>
    <td>付与月額コース</td>
    <td style="text-align: left;">
        {html_radios id="specify_monthly_course" name="specify_monthly_course" options=$config.admin_config.specify_monthly_course_select selected=$value.specify_monthly_course|default:0 separator="&nbsp;"}
        <div id="monthly_course_remainder_days">
            残り期限
            <input type="text" class="from" name="monthly_rest_date_from" value="{$value.monthly_rest_date_from}" size="6" style="ime-mode:disabled;text-align:right;">
            日以上
            <input type="text" class="to" name="monthly_rest_date_to" value="{$value.monthly_rest_date_to}" size="6" style="ime-mode:disabled;text-align:right;">
            日まで
        </div>
    </td>
</tr>
<tr>
    <td>付与月額コースID<br>(カンマ区切りで複数可)</td>
    <td style="text-align: left;">
        対象を抽出：<input type="text" name="monthly_course_id" value="{$value.monthly_course_id}" size="20" style="ime-mode:disabled;">&nbsp;&nbsp;{html_radios id="search_monthly_course_id_type" name="search_monthly_course_id_type" options=$config.admin_config.specify_target_select selected=$value.search_monthly_course_id_type separator="&nbsp;"}
        <br>
        以外を抽出：<input type="text" name="except_monthly_course_id" value="{$value.except_monthly_course_id}" size="20" style="ime-mode:disabled;">&nbsp;&nbsp;{html_radios id="except_search_monthly_course_id_type" name="except_search_monthly_course_id_type" options=$config.admin_config.specify_target_select selected=$value.except_search_monthly_course_id_type separator="&nbsp;"}
    </td>
</tr>
<tr>
    <td>付与月額更新用商品</td>
    <td style="text-align: left;">
        {html_radios id="specify_monthly_update" name="specify_monthly_update" options=$config.admin_config.specify_monthly_update_select selected=$value.specify_monthly_update|default:0 separator="&nbsp;"}
        <div id="monthly_course_update_item">
            対象を抽出：<input type="text" name="monthly_update_item_id" value="{$value.monthly_update_item_id}" size="20" style="ime-mode:disabled;">&nbsp;&nbsp;{html_radios id="search_monthly_update_item_type" name="search_monthly_update_item_type" options=$config.admin_config.specify_target_select selected=$value.search_monthly_update_item_type separator="&nbsp;"}
            <br>
            以外を抽出：<input type="text" name="except_monthly_update_item_id" value="{$value.except_monthly_update_item_id}" size="20" style="ime-mode:disabled;">&nbsp;&nbsp;{html_radios id="except_search_monthly_update_item_id_type" name="except_search_monthly_update_item_id_type" options=$config.admin_config.specify_target_select selected=$value.except_search_monthly_update_item_id_type separator="&nbsp;"}
        </div>
    </td>
</tr>

<tr>
<td>通常メール回数</td>
    <td style="text-align: left;">
        <input type="text" class="from" name="mail_count_from" value="{$value.mail_count_from}" size="5" style="ime-mode:disabled;text-align:right;">
        回以上
        <input type="text" class="to" name="mail_count_to" value="{$value.mail_count_to}" size="5" style="ime-mode:disabled;text-align:right;">
        回まで
    </td>
</tr>

<tr>
<td>予約メール回数</td>
    <td style="text-align: left;">
        <input type="text" class="from" name="mail_reserve_count_from" value="{$value.mail_reserve_count_from}" size="5" style="ime-mode:disabled;text-align:right;">
        回以上
        <input type="text" class="to" name="mail_reserve_count_to" value="{$value.mail_reserve_count_to}" size="5" style="ime-mode:disabled;text-align:right;">
        回まで
    </td>
</tr>

<tr>
<td>定期メール回数</td>
    <td style="text-align: left;">
        <input type="text" class="from" name="mail_regular_count_from" value="{$value.mail_regular_count_from}" size="5" style="ime-mode:disabled;text-align:right;">
        回以上
        <input type="text" class="to" name="mail_regular_count_to" value="{$value.mail_regular_count_to}" size="5" style="ime-mode:disabled;text-align:right;">
        回まで
    </td>
</tr>

<tr>
<td>強行メール回数</td>
    <td style="text-align: left;">
        <input type="text" class="from" name="reverse_mail_status_count_from" value="{$value.reverse_mail_status_count_from}" size="5" style="ime-mode:disabled;text-align:right;">
        回以上
        <input type="text" class="to" name="reverse_mail_status_count_to" value="{$value.reverse_mail_status_count_to}" size="5" style="ime-mode:disabled;text-align:right;">
        回まで
    </td>
</tr>
<tr>
    <td>銀行口座</td>
    <td style="text-align: left;">
        {html_radios id="bank_detail" name="bank_detail" options=$isSetting selected=$value.bank_detail separator="&nbsp;"}
    </td>
</tr>
<tr>
    <td>住所</td>
    <td style="text-align: left;">
        {html_radios id="address_detail" name="address_detail" options=$isSetting selected=$value.address_detail separator="&nbsp;"}
    </td>
</tr>
<tr>
    <td>ﾕｰｻﾞｰﾌﾟﾗｲﾊﾞｼｰ</td>
    <td style="text-align: left;">
       {html_checkboxes name="address_detail" options=$addressDetail selected=$value.address_detail separator="&nbsp;"}
       {html_checkboxes name="bank_detail" options=$bankDetail selected=$value.bank_detail separator="&nbsp;"}
       {html_radios id="specify_userPrivacy" name="specify_userPrivacy" options=$config.admin_config.is_setting selected=$value.specify_userPrivacy separator="&nbsp;"}
    </td>
</tr>
<tr>
    <td>生年月日</td>
    <td style="text-align: left;">
        {html_radios id="specify_birth_day" name="specify_birth_day" options=$config.admin_config.specify_birth_day_select selected=$value.specify_birth_day separator="&nbsp;"}
        <br>
        <div id="birth_day_date">
            <input size="15" class="datepicker" type="text" value="{$birthDayDatetimeFrom|zend_date_format:'yyyy-MM-dd'}" name="birth_day_from_Date" maxlength="10">
            ～&nbsp;<input size="15" class="datepicker" type="text" value="{$birthDayDatetimeTo|zend_date_format:'yyyy-MM-dd'}" name="birth_day_to_Date" maxlength="10">
        </div>
    </td>
</tr>
<tr>
<td>年齢</td>
    <td style="text-align: left;">
        <input type="text" class="from" name="user_age_from" value="{$value.user_age_from}" size="5" style="ime-mode:disabled;text-align:right;">
        歳以上
        <input type="text" class="to" name="user_age_to" value="{$value.user_age_to}" size="5" style="ime-mode:disabled;text-align:right;">
        歳まで
       <input type="checkbox" name="user_age_no_data" value="1" {if $value.user_age_no_data} checked/ {/if}>入力無し含む
    </td>
</tr>
<tr>
    <td>干支</td>
    <td style="text-align: left;">
        {html_checkboxes name="sexagenary_cycle" options=$config.admin_config.specify_sexagenary_cycle_select selected=$value.sexagenary_cycle separator="&nbsp;"}
    </td>
</tr>
<tr>
    <td>星座</td>
    <td style="text-align: left;">
        {html_checkboxes name="constellation" options=$config.admin_config.specify_constellation_select selected=$value.constellation separator="&nbsp;"}
    </td>
</tr>

<tr>
    <td>血液型</td>
    <td style="text-align: left;">
        {html_checkboxes name="blood_type" options=$bloodType selected=$value.blood_type separator="&nbsp;"}
    </td>
</tr>
<tr>
    <td>媒体コード<br>(カンマ区切りで複数可)<br>[% => 任意の数の文字]<br>[_ =>  1 つの文字]</td>
    <td style="text-align: left;">
        <div id="media_cd">
            対象を抽出：<input type="text" name="media_cd" value="{$value.media_cd}" size="30" style="ime-mode:disabled;">&nbsp;&nbsp;{html_radios id="search_media_cd_type" name="search_media_cd_type" options=$config.admin_config.specify_target_select selected=$value.search_media_cd_type separator="&nbsp;"}
        </div>
        <div id="except_media_cd">
            以外を抽出：<input type="text" name="except_media_cd" value="{$value.except_media_cd}" size="30" style="ime-mode:disabled;">&nbsp;&nbsp;{html_radios id="search_except_media_cd_type" name="search_except_media_cd_type" options=$config.admin_config.specify_target_select selected=$value.search_except_media_cd_type separator="&nbsp;"}
        </div>
    </td>
</tr>
<tr>
    <td>管理ﾎﾞｯｸｽ</td>
    <td style="text-align: left;">
        {html_options name="admin_id" options=$adminList selected=$value.admin_id}
    </td>
</tr>

<tr>
    <td>サイト間登録</td>
    <td style="text-align: left;">
        {html_radios id="specify_regist_site" name="specify_regist_site" options=$specifyRegistSite selected=$value.specify_regist_site|default:"0" separator="&nbsp;"}<br>
        {html_checkboxes name="regist_site" options=$registSiteList selected=$value.regist_site separator="&nbsp;"}
    </td>
</tr>
{if $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SYSTEM}
<tr>
    <td>ユーザー検索タイプ</td>
    <td style="text-align: left;">
        {html_radios id="specify_convert_type" name="specify_convert_type" options=$selectSearchType selected=$value.specify_convert_type|default:1 separator="&nbsp;"}
        <div id="specify_convert_type_input">
            &nbsp;&nbsp;⇒入金条件指定：&nbsp;&nbsp;{html_radios name="convert_pay_type" options=$config.admin_config.specify_payment_input_select selected=$value.convert_pay_type|default:0 separator="&nbsp;"}
            <font color="blue">※入金条件指定は「KH⇒EM,OK,TS または AG⇒EM,OK,TS」のみ有効</font>
            <br>
            &nbsp;&nbsp;⇒コンバート先指定：&nbsp;&nbsp;{html_radios name="to_convert_sites" options=$convertSitesAry selected=$value.to_convert_sites|default:"$convertSiteSelectDefault" separator="&nbsp;"}
        </div>
    </td>
</tr>
{/if}

{* ユーザー識別フラグ *}
<tr>
    <td>ユーザー識別フラグ</td>
    <td style="text-align: left;">
        {html_checkboxes name="user_profile_flag_code" options=$user_profile_flag_code selected=$value.user_profile_flag_code|default:0 separator="&nbsp;"}<br>
        <font color="red">※チェックが無い場合はフラグに関係なく検索(全てにチェックを入れた場合と同じ)</font>
    </td>
</tr>

<tr>
   <td>備考<br>(部分一致)</td>
       <td style="text-align: left;">
          <textarea name="description" rows="3" cols="51">{$value.description}</textarea>
      </td>
</tr>

</table>

<div class="SubMenu">
    {html_options name="limit" options=$limit selected=$value.limit}
件ずつ
    {html_options name="order" options=$order selected=$value.order}
順に
<input type="submit" value="検索!!" name="action_User_List"/>
</div>
</form>
{include file=$admFooter}
<script type="text/javascript" src="./js/jquery.timepickr.min.js"></script>
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script type="text/javascript" src="./js/watermark/jquery.watermark.min.js"></script>
<script type="text/javascript" src="./js/userSearch.js"></script>
</body>
</html>

