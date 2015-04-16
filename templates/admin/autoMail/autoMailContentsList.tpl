{include file=$admHeader}
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script type="text/javascript">
<!--

    $(function() {ldelim}

        // テーブルマウスオーバーカラー
        $('#list_table').colorize({ldelim}
            altColor :'#CCCCCC',
            hiliteColor :'none'
        {rdelim});

        {* 追加フォーム *}
        if ({$param.return_type} == 1) {ldelim}
            $("#add_form").show();
        {rdelim} else {ldelim}
            $("#add_form").hide();
        {rdelim}

        $('#add_button').live("click", function(){ldelim}
            $("#add_form").toggle("blind", null, "slow");
        {rdelim});

    {rdelim});

//-->
</script>
</head>
<body>

<div id="ContentsCol">

<h2 class="ContentTitle">リメールコンテンツ一覧</h2>
{* 更新時エラーコメント *}
{if $msg|@count}
    <div class="warning ui-widget">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    <p>
    <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    { foreach from=$msg item="val" }
        {$val|@implode:"<br>"}
    {/foreach}
    </p>
    </div>
    </div>
{/if}
<div class="SubMenu">
    <input type="button" id="add_button" value="追　加" />
</div>
<div id="add_form" style="display:none">
<form action="./" method="post" enctype="multipart/form-data">
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
    <tr>
        <th nowrap="nowrap">名前</th>
        <th>ページ名</th>
        <th>変数名(配列のキー名)</th>
        <th>表示順</th>
        <th></th>
    </tr>
    <tr>
        <td><input type="text" name="name" value="{$param.name}" size="20"></td>
        <td><input type="text" name="page_name" value="{$param.page_name}" size="20"></td>
        <td><input type="text" name="variable_name" value="{$param.variable_name}" size="20"></td>
        <td><input type="text" name="sort_seq" value="{$param.sort_seq|default:1}" size="3"></td>
        <td><input type="submit" name="action_autoMail_AutoMailContentsAddExec" value="登　録" onClick="return confirm('登録しますか？')" /></td>
    </tr>
    </table>
</form>
</div>
<br>
{if $dataList}
<form action="./" method="post" enctype="multipart/form-data">
    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">

    <tr>
    <th nowrap="nowrap">ID</th>
    <th nowrap="nowrap">名前</th>
    <th>ページ名</th>
    <th>変数名(配列のキー名)</th>
    <th>表示順</th>
    <th>使用状況</th>
    <th>削除</th>
    </tr>
    {foreach from=$dataList item="val" key="key"}
        <tr>
        <td><input type="hidden" name="id[]" value="{$val.id}">{$val.id}</td>
        <td><input type="text" name="name[]" value="{$paramAry.name.$key|default:$val.name}" size="20"></td>
        <td><input type="text" name="page_name[]" value="{$paramAry.page_name.$key|default:$val.page_name}" size="20"></td>
        <td><input type="text" name="variable_name[]" value="{$paramAry.variable_name.$key|default:$val.variable_name}" size="20"></td>
        <td><input type="text" name="sort_seq[]" value="{$paramAry.sort_seq.$key|default:$val.sort_seq}" size="3"></td>
        <td>{html_options name="is_use[]" options=$isUse selected=$paramAry.is_use.$key|default:$val.is_use}</td>
        <td>
            <form action="./" method="post" style="margin:2px 0px;">
                {$POSTParam}
                <input type="hidden" name="auto_mail_contents_id" value="{$val.id}">
                <input type="submit" name="action_autoMail_AutoMailContentsDelExec" value="削除" onClick="return confirm('削除しますか?')">
            </form>
        </td>
        </tr>
    {/foreach}
    </table>
    <div class="SubMenu">
        <input type="submit" name="action_autoMail_AutoMailContentsAddExec" value="更　新" onClick="return confirm('更新しますか？')" />
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