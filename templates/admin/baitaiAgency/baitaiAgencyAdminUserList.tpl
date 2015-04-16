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
    {rdelim});

// -->
</script>
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">代理店媒体CHK&nbsp;管理者一覧</h2>
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
{if $agencyAdminList}

    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">

    <tr>
    <th nowrap="nowrap">ログインID</th>
    <th nowrap="nowrap">名前</th>
    <th>権限</th>
    </tr>
    {foreach from=$agencyAdminList item="val"}
        <tr>
        <td><a href="{make_link action="action_baitaiAgency_BaitaiAgencyAdminUserUpd" getTags="id="|cat:$val.id}">{$val.login_id}</a></td>
        <td>{$val.name}</td>
        <td>{$config.admin_config.authority_type[$val.authority_type]}</td>
        </tr>
    {/foreach}
    </table>

{/if}

<div class="SubMenu">
    <input type="button" id="add_button" value="追　加" />
</div>

<div id="add_form" style="display:none;">
<form action="./" method="POST">
    {$POSTparam}
    <table class="TableSet04">
        <tr>
            <th>
                名前：
            </th>
            <td>
                <input type="text" name="name" value="{$param.name}">
            </td>
        </tr>
        <tr>
            <th>
                ログインID：
            </th>
            <td>
                <input type="text" name="login_id" value="{$param.login_id}">
            </td>
        </tr>
        <tr>
            <th>
                パスワード：
            </th>
            <td>
                <input type="text" name="password" value="{$param.password}" style="ime-mode:disabled">
            </td>
        </tr>
        <tr>
            <th>
                管理区分：
            </th>
            <td>
                {html_options name="authority_type" options=$config.admin_config.authority_type selected=$param.authority_type}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">
                <input type="submit" value="登　録" name="action_baitaiAgency_baitaiAgencyAdminUserRegExec" onClick="return confirm('登録しますか？')">
            </td>
        </tr>
    </table>
</form>
</div>
{include file=$admFooter}
</div>
</body>
</html>