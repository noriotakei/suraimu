{include file=$admHeader}
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">管理ユーザー作成</h2>
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
<form action="./" method="post">
    <input type="submit" name="action_adminUser_AdminUserList" value="一覧へ戻る" style="width:8em;"/>
</form>
<br>
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
                <input type="text" name="password" value="" style="ime-mode:disabled">
            </td>
        </tr>
        <tr>
            <th>
                メールアドレス：
            </th>
            <td>
                <input type="text" name="send_mail_address" value="{$param.send_mail_address}" style="ime-mode:disabled">
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
            <th>
                自動更新：
            </th>
            <td>
                {html_checkboxes name="auto_update_flag" options=$autoUpdateFlag selected=$param.auto_update_flag}
            </td>
        </tr>
        {if $param.id != $loginAdminData.id}
        <tr>
            <th>
                削除：
            </th>
            <td>
                {html_checkboxes name="disable" options=$disable selected=$param.disable}
            </td>
        </tr>
        {/if}
        <tr>
            <td colspan="2" style="text-align:center;">
                <input type="submit" value="更　新" name="action_adminUser_AdminUserRegExec" onClick="return confirm('更新しますか？')">
            </td>
        </tr>

    </table>

</form>
{include file=$admFooter}
</div>
</body>
</html>