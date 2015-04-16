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

        $('#add_button').live("click", function(env){ldelim}
            if (env.button !== 0) return;
            $("#add_form").toggle("blind", null, "slow");
        {rdelim});

    {rdelim});

//-->
</script>
</head>
<body>

<div id="ContentsCol">

<h2 class="ContentTitle">ログ削除設定一覧</h2>
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
<div class="ui-widget">{$deleteException}は削除設定できません。</div>
<div class="SubMenu">
    <input type="button" id="add_button" value="追　加" />
</div>
<div id="add_form" style="display:none">
<form action="./" method="post" enctype="multipart/form-data">
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
    <tr>
        <th nowrap="nowrap">テーブル名<br>(カンマ区切りで複数可)</th>
        <th nowrap="nowrap">日数</th>
        <th></th>
    </tr>
    <tr>
        <td><input type="text" name="table_name" value="{$param.table_name}" size="60"></td>
        <td><input type="text" name="days" value="{$param.days}" size="5" style="ime-mode:disabled;text-align:right;">日後以降</td>
        <td><input type="submit" name="action_log_LogDeleteSetExec" value="登　録" onClick="return confirm('登録しますか？')" /></td>
    </tr>
    </table>
</form>
<br>
</div>
<br>
{if $dataList}
<form action="./" method="post">
    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">

    <tr>
    <th>id</th>
    <th nowrap="nowrap">テーブル名<br>(カンマ区切りで複数可)</th>
    <th nowrap="nowrap">日数</th>
    <th>削除</th>
    </tr>
    {foreach from=$dataList item="val" key="key"}
        <tr>
        <td><input type="hidden" name="id[{$val.id}]" value="{$val.id}">{$val.id}</td>
        <td><input type="text" name="table_name[{$val.id}]" value="{$val.table_name}" size="60"></td>
        <td><input type="text" name="days[{$val.id}]" value="{$val.days}" size="5" style="ime-mode:disabled;text-align:right;">日後以降</td>
        <td><input type="checkbox" name="disable[{$val.id}]" value="1"></td>
        </tr>
    {/foreach}
    </table>
    <div class="SubMenu">
        <input type="submit" name="action_log_LogDeleteSetExec" value="更　新" onClick="return confirm('更新しますか？')" />
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