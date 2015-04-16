{include file=$admHeader}
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script language="JavaScript">
<!--

    $(function() {ldelim}
        // テーブルマウスオーバーカラー
        $('#list_table').colorize({ldelim}
            altColor :'#CCCCCC',
            hiliteColor :'none'
        {rdelim});

        if (!{$param.return_flag}) {ldelim}
            $("#add_form").hide();
        {rdelim}

        $('#add_button').live("click", function(env){ldelim}
            if (env.button !== 0) return;
            $("#add_form").toggle("clip", null, "slow");
        {rdelim});

        {* 入力フォームを隠す *}
        $("#input_form").hide();

        var updateIdAry = Array('#authority_type option:selected');
        for (var val in updateIdAry) {ldelim}
            openFolderSelect(updateIdAry[val]);
        {rdelim}

        {* 管理区分を変えたとき *}
        $('#authority_type').change(function(){ldelim}
            openFolderSelect('#authority_type option:selected');
        {rdelim});

    {rdelim});

    function openFolderSelect(selectId) {ldelim}

        var selectId = $(selectId);

        if (selectId.val() == 6) {ldelim}
            $('#input_form').show("blind", "slow");
        {rdelim} else {ldelim}
            $('#input_form').hide();
        {rdelim}

    {rdelim}

// -->
</script>
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">代理店媒体管理</h2>
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
{if $baitaiAgencyList}
    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">
    <tr>
    <th nowrap="nowrap">代理店名</th>
    <th nowrap="nowrap">ログインID</th>
    <th nowrap="nowrap">パスワード</th>
    <!--<th nowrap="nowrap">管理区分</th>-->
    <th nowrap="nowrap">代理店URL&nbsp;<font color="blue">※固定URL</font></th>
    <!--<th nowrap="nowrap">認証IPアドレス</th>-->
    <th nowrap="nowrap">代理店への入金額の表示設定</th>
    <!--<th nowrap="nowrap">媒体コード</th>-->
    </tr>
    {foreach from=$baitaiAgencyList item="val"}
        <tr>
        <td><a href="{make_link action="action_baitaiAgency_BaitaiAgencyUpd" getTags="id="|cat:$val.id}">{$val.name}</a></td>
        <td>{$val.login_id}</td>
        <td>{$val.display_password}</td>
        <!--<td>{$selectAuthoritytype[$val.authority_type]}</td>-->
        <td>{$config.define.BAITAI_AGENCY_URL}</td>
        <!--<td>{$val.ip_address}</td>-->
        <td>{$isDisplayPay[$val.is_display_trade_amount]}</td>
        </tr>
    {/foreach}
    </table>
{else}
    <div class="warning ui-widget">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    <p>
    <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    該当データはありません
    </p>
    </div>
    <br>
{/if}
<div class="SubMenu">
    <input type="button" id="add_button" value="追　加" />
</div>

<div id="add_form" style="display:none;">
<form action="./" method="POST">
    {$POSTparam}
    <table class="TableSet01">
        <tr>
            <th>
                代理店名：
            </th>
            <td style="text-align: left;">
                <input type="text" name="name" value="{$param.name}" size="40">
            </td>
        </tr>
        <tr>
            <th>
                ログインID：
            </th>
            <td style="text-align: left;">
                <input type="text" name="login_id" value="{$param.login_id}">
            </td>
        </tr>
        <tr>
            <th>
                パスワード：
            </th>
            <td style="text-align: left;">
                <input type="text" name="display_password" value="{$param.display_password}" style="ime-mode:disabled">
            </td>
        </tr>
        <tr>
            <th>IPアドレス認証：</th>
            <td style="text-align: left;">
                {html_radios name="is_auth_ip_address" options=$isAuthIpAddress selected=$param.is_auth_ip_address|default:1 id="is_auth_ip_address"}
            </td>
        </tr>
        <tr>
            <th>
                代理店への入金額の表示設定：
            </th>
            <td style="text-align: left;">
                {html_options name="is_display" options=$isDisplayPay selected=$param.is_display_trade_amount|default:1}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">
                <input type="submit" value="登　録" name="action_baitaiAgency_BaitaiAgencyRegExec" onClick="return confirm('登録しますか？')">
            </td>
        </tr>
    </table>
</form>
</div>
{include file=$admFooter}
</div>
</body>
</html>