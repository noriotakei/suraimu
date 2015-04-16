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
    <input type="submit" name="action_information_InformationOperatorList" value="一覧へ戻る" style="width:8em;"/>
</form>
<br>
<form action="./" method="POST">
    {$POSTparam}
    <table class="TableSet04">
        <tr>
            <th>
                担当者：<br>(表示名)
            </th>
            <td>
                <input type="text" name="name" value="{$param.name}">
            </td>
        </tr>
        <tr>
            <th>
                表示設定：
            </th>
            <td>
                {html_options name="is_display" options=$isDisplay selected=$param.is_display|default:0}
            </td>
        </tr>
        <tr>
            <th>
               管理ログインユーザー
            </th>
            <td>
                {html_options name="admin_id" options=$adminRelationUserList selected=$param.admin_id}
                &nbsp;<font color="blue">※管理画面ログインユーザー(管理者またはオペレーター)⇔問い合わせ担当者<br>
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
                <input type="submit" value="更　新" name="action_information_InformationOperatorRegExec" onClick="return confirm('更新しますか？')">
            </td>
        </tr>

    </table>

</form>
{include file=$admFooter}
</div>
</body>
</html>