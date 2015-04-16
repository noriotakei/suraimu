{include file=$admHeader}
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script language="JavaScript">
<!--
    $(function() {ldelim}
        {* テーブルマウスオーバーカラー *}
        $('#list_table').colorize({ldelim}
            altColor :'#CCCCCC',
            hiliteColor :'none'
        {rdelim});

        {* 追加フォーム 媒体コード *}
        if (!{$cdSettingParam.return_flag}) {ldelim}
            $("#add_form_cd").hide();
        {rdelim} else {ldelim}
            $("#add_form_cd").show();
        {rdelim}
        $('#add_button_cd').live("click", function(){ldelim}
            $("#add_form_cd").toggle("blind", null, "slow");
        {rdelim});

        {* 追加フォーム 認証IPアドレス *}
        if (!{$ipSettingParam.return_flag}) {ldelim}
            $("#add_form_ip_address").hide();
        {rdelim} else {ldelim}
            $("#add_form_ip_address").show();
        {rdelim}
        $('#add_button_ip_address').live("click", function(){ldelim}
            $("#add_form_ip_address").toggle("blind", null, "slow");
        {rdelim});
    {rdelim});

</script>
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">代理店媒体更新画面</h2>
{* 更新時エラーコメント *}
{if $execMsg|@count}
    <div class="warning ui-widget">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    <p>
    <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    { foreach from=$execMsg item="val" }
        {$val|@implode:"<br>"}
    {/foreach}
    </p>
    </div>
    </div>
{/if}
<br>
<form action="./" method="post">
    <input type="submit" name="action_baitaiAgency_BaitaiAgencyList" value="一覧へ戻る" style="width:8em;"/>
</form>
<br>
<form action="./" method="POST">
    {$POSTparam}
    <table class="TableSet01">
        <tr>
            <th>
                名前：
            </th>
            <td style="text-align: left;">
                <input type="text" name="name" value="{$agencyParam.name}" size="40">
            </td>
        </tr>
        <tr>
            <th>
                ログインID：
            </th>
            <td style="text-align: left;">
                <input type="text" name="login_id" value="{$agencyParam.login_id}">
            </td>
        </tr>
        <tr>
            <th>
                パスワード：
            </th>
            <td style="text-align: left;">
                <input type="text" name="display_password" value="{$agencyParam.display_password}" style="ime-mode:disabled">
            </td>
        </tr>
        <tr>
            <th>IPアドレス認証：</th>
            <td style="text-align: left;">
                {html_radios name="is_auth_ip_address" options=$isAuthIpAddress selected=$agencyParam.is_auth_ip_address id="is_auth_ip_address"}
            </td>
        </tr>
        <tr>
            <th>
                入金額の表示設定：
            </th>
            <td style="text-align: left;">
                {html_options name="is_display" options=$isDisplayPay selected=$agencyParam.is_display_trade_amount|default:1}
            </td>
        </tr>
        <tr>
            <th>
                削除：
            </th>
            <td style="text-align: left;">
                {html_checkboxes name="disable" options=$disable selected=$agencyParam.disable}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">
                <input type="hidden" name="agency_upd" value="1">
                <input type="submit" value="更　新" name="action_baitaiAgency_BaitaiAgencyRegExec" onClick="return confirm('更新しますか？')">
            </td>
        </tr>
    </table>
</form>
<br>
<hr>
<div class="SubMenu">
    <input type="button" id="add_button_cd" value="媒体コード追加" />&nbsp;
</div>
<div id="add_form_cd" style="display:none">
<form action="./" method="post" enctype="multipart/form-data">
    {$POSTparam}
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
        <tr>
            <th>媒体名</th>
            <th>媒体コード</th>
            <th></th>
        </tr>
        <tr>
            <td style="text-align: left;">
                <input type="text" name="media_name" value="{$cdSettingParam.media_name}" size="25">
            </td>
            <td style="text-align: left;">
                <input type="text" name="media_cd" value="{$cdSettingParam.media_cd}" size="25">
            </td>
            <td><input type="submit" name="action_baitaiAgency_BaitaiAgencyCdSettingExec" value="登 録" OnClick="return confirm('登録しますか？')" /></td>
        </tr>
    </table>
</form>
</div>
<br>


<table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet01">
<tr>
<td style="text-align: left;">

■広告費関連項目の説明</br>

・広告費タイプ</br>
  └媒体毎の広告費のタイプを選択</br></br>
・広告費毎の入力フォーム</br>
  └広告費タイプで選択した広告費タイプのフォームのみ適切な数値を入力して下さい</br>
  　複数個所に入力があると正常な集計が行われません。</br></br>
・広告期間　　　2012-03～2012-07と年月のみ入力</br>
  └広告費(毎月)・・広告期間from～広告期間toの間に集計対象年月が含まれている場合は広告費を計上。</br>
  └広告費(一回払い)・・広告期間from～広告期間to共に同じ年月を入力。集計対象年月が含まれている場合は広告費を計上。</br>
  └広告費（単価）・・広告期間from～広告期間toの間に集計対象年月が含まれている場合は広告費を計上。</br>
  └成果報酬・・広告期間from～広告期間toの間に集計対象年月が含まれている場合は広告費を計上。</br>
　　　　　　　　　無期限の場合は「広告期間to」を遠い未来にして下さい。</br>
</td>
</tr>
</table>



{if $cdSettingList}
    <form action="./" method="post" enctype="multipart/form-data">
        {$POSTparam}
            <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet01">
                <tr>
                    <th>媒体名</th>
                    <th>媒体コード</th>
                    <th>広告費タイプ</th>
                    <th>広告費(毎月)</th>
                    <th>広告費(一回払い)</th>
                    <th>広告費（単価）</th>
                    <th>成果報酬{*　　　　期間*}</th>
                    <th>広告期間from</th>
                    <th>広告期間to</th>
                    <th style="text-align:center;">削除<br><input type="checkbox" onclick="$('#list_table input:checkbox').attr('checked', this.checked);" ></th>
                </tr>
                {foreach from=$cdSettingList item="val"}
                <tr>
                    <td style="text-align: left;">
                        <input type="text" name="media_name[{$val.id}]" value="{$val.media_name}" size="15">
                    </td>
                    <td style="text-align: left;">
                        <input type="text" name="media_cd[{$val.id}]" value="{$val.media_cd}" size="15">
                    </td>
                    <td style="text-align: left;">
                        {html_options name="advertise_expenses_type[`$val.id`]" options=$advertiseExpensesType selected=`$val.advertise_expenses_type`}
                    </td>
                    <td style="text-align: left;">
                        <input type="text" name="advertise_expenses[{$val.id}]" value="{$val.advertise_expenses}" size="15">
                    </td>
                    <td style="text-align: left;">
                        <input type="text" name="advertise_expenses_once[{$val.id}]" value="{$val.advertise_expenses_once}" size="15">
                    </td>
                    <td style="text-align: left;">
                        <input type="text" name="advertise_expenses_apiece[{$val.id}]" value="{$val.advertise_expenses_apiece}" size="15">
                    </td>
                    <td style="text-align: left;">
                        <input type="text" name="advertise_expenses_percent[{$val.id}]" value="{$val.advertise_expenses_percent}" size="2">%　　
                        {*{html_options name="span_for_percent[`$val.id`]" options=$spanForPercent selected=`$val.advertise_expenses_percent_span`}*}
                    </td>
                    <td style="text-align: left;">
                        <input type="text" name="advertise_period_from[{$val.id}]" value="{$val.advertise_period_from}" size="15">
                    </td>
                    <td style="text-align: left;">
                        <input type="text" name="advertise_period_to[{$val.id}]" value="{$val.advertise_period_to}" size="15">
                    </td>
                    <td style="text-align:center;">
                        <input type="checkbox" name="disable[{$val.id}]" value="1">
                        <input type="hidden" name="agency_id[]" value="{$val.id}">
                    </td>
                </tr>
                {/foreach}
            </table>
            <div class="SubMenu">
                <input type="submit" name="action_baitaiAgency_BaitaiAgencyCdSettingExec" value="更 新" OnClick="return confirm('更新しますか？')" />
            </div>
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
<hr>
<div class="SubMenu">
    <input type="button" id="add_button_ip_address" value="認証IPアドレス追加" />
</div>
<div id="add_form_ip_address" style="display:none">
<form action="./" method="post" enctype="multipart/form-data">
    {$POSTparam}
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
        <tr>
            <th>認証IPアドレス</th>
            <th>使用状況</th>
            <th></th>
        </tr>
        <tr>
            <td style="text-align: left;" nowrap>
                <input type="text" name="ip_address[]" value="{$ipSettingParam.ip_address.0}" style="ime-mode:disabled" size="5">．
                <input type="text" name="ip_address[]" value="{$ipSettingParam.ip_address.1}" style="ime-mode:disabled" size="5">．
                <input type="text" name="ip_address[]" value="{$ipSettingParam.ip_address.2}" style="ime-mode:disabled" size="5">．
                <input type="text" name="ip_address[]" value="{$ipSettingParam.ip_address.3}" style="ime-mode:disabled" size="5">
            </td>
            <td style="text-align: left;">
                {html_options name="is_use" options=$isUse selected=$ipSettingParam.is_use.$key|default:$val.is_use}
            </td>
            <td rowspan="2" style="text-align:center;">
                <input type="submit" name="action_baitaiAgency_BaitaiAgencyIpAddressSettingExec" value="登 録" OnClick="return confirm('登録しますか？')" />
            </td>
        </tr>
    </table>
</form>
</div>
<br>
{if $ipSettingList}
    <form action="./" method="post" enctype="multipart/form-data">
        {$POSTparam}
            <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet01">
                <tr>
                    <th>認証IPアドレス</th>
                    <th>使用状況</th>
                    <th style="text-align:center;">削除<br><input type="checkbox" onclick="$('#list_table input:checkbox').attr('checked', this.checked);" ></th>
                </tr>
                {foreach from=$ipSettingList item="val"}
                <tr>
                    <td style="text-align: left;" nowrap>
                        <input type="text" name="ip_address[{$val.id}][]" value="{$val.ip_address.0}" style="ime-mode:disabled" size="5">．
                        <input type="text" name="ip_address[{$val.id}][]" value="{$val.ip_address.1}" style="ime-mode:disabled" size="5">．
                        <input type="text" name="ip_address[{$val.id}][]" value="{$val.ip_address.2}" style="ime-mode:disabled" size="5">．
                        <input type="text" name="ip_address[{$val.id}][]" value="{$val.ip_address.3}" style="ime-mode:disabled" size="5">
                    </td>
                    <td style="text-align: left;">
                        {html_options name="is_use[]" options=$isUse selected=$val.is_use.$key|default:$val.is_use}
                    </td>
                    <td style="text-align:center;">
                        <input type="checkbox" name="disable[{$val.id}]" value="1">
                        <input type="hidden" name="ip_address_setting_id[]" value="{$val.id}">
                    </td>
                </tr>
                {/foreach}
            </table>
            <div class="SubMenu">
                <input type="submit" name="action_baitaiAgency_BaitaiAgencyIpAddressSettingExec" value="更 新" OnClick="return confirm('更新しますか？')" />
            </div>
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
</body>
</html>