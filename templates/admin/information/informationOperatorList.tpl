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
<h2 class="ContentTitle">問い合わせ対応者一覧</h2>
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
{if $adminInfoOperatorList}

    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">

    <tr>
    <th nowrap="nowrap">ID</th>
    <th nowrap="nowrap">担当者</th>
    <th>表示設定</th>
    <th nowrap="nowrap">管理ログインユーザー</th>
    </tr>
    {foreach from=$adminInfoOperatorList item="val"}
        <tr>
        <td><a href="{make_link action="action_information_InformationOperatorUpd" getTags="id="|cat:$val.id}">{$val.id}</a></td>
        <td>{$val.name}</td>
        <td>{$isDisplay[$val.is_display]}</td>
        <td>{$adminRelationUserList[$val.admin_id]}</td>
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
                {html_options name="admin_id" options=$adminRelationUserList selected=$param.id}
                &nbsp;<font color="blue">※管理画面ログインユーザー(管理者またはオペレーター)⇔問い合わせ担当者<br>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">
                <input type="submit" value="登　録" name="action_information_InformationOperatorRegExec" onClick="return confirm('登録しますか？')">
            </td>
        </tr>
    </table>
</form>
</div>
{include file=$admFooter}
</div>
</body>
</html>