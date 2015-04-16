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

        {* 追加フォーム *}
        if (!{$cdSettingParam.return_flag}) {ldelim}
            $("#add_form").hide();
        {rdelim} else {ldelim}
            $("#add_form").show();
        {rdelim}
        $('#add_button').live("click", function(){ldelim}
            $("#add_form").toggle("blind", null, "slow");
        {rdelim});
    {rdelim});

</script>
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">代理店媒体CHK&nbsp;管理者更新画面</h2>
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
    <input type="submit" name="action_baitaiAgency_BaitaiAgencyAdminUserList" value="一覧へ戻る" style="width:8em;"/>
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
                <input type="text" name="name" value="{$agencyAdminParam.name}" size="40">
            </td>
        </tr>
        <tr>
            <th>
                ログインID：
            </th>
            <td style="text-align: left;">
                <input type="text" name="login_id" value="{$agencyAdminParam.login_id}">
            </td>
        </tr>
        <tr>
            <th>
                パスワード：
            </th>
            <td style="text-align: left;">
                <input type="text" name="password" value="" style="ime-mode:disabled">
            </td>
        </tr>
        <tr>
            <th>
                管理区分：
            </th>
            <td style="text-align: left;">
                {html_options name="authority_type" options=$config.admin_config.authority_type selected=$agencyAdminParam.authority_type}
            </td>
        </tr>
        <tr>
            <th>
                削除：
            </th>
            <td style="text-align: left;">
                {html_checkboxes name="disable" options=$disable selected=$agencyAdminParam.disable}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">
                <input type="submit" value="更　新" name="action_baitaiAgency_BaitaiAgencyAdminUserRegExec" onClick="return confirm('更新しますか？')">
            </td>
        </tr>
    </table>
</form>
<br>
{include file=$admFooter}
</div>
</body>
</html>