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
    <h2 class="ContentTitle">予約ばらまき条件</h2>
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
            <th colspan="2" style="text-align: center">変更</th>
        </tr>
        <tr>
            <td><textarea name="description" rows="10" cols="50">{$param.description}</textarea></td>
        </tr>
        <tr>
            <td>
                <input type="hidden" name="reserve_point_grant_id" value="{$param.id}"/>
                <input type="submit" name="action_mailLog_ReservePointGrantUpdExec" value="変更する" onClick="return confirm('登録しますか？')" />
            </td>
        </tr>
        </table>
    </form>
    </div>
    <br>

    {if $param}
        <table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet04">
        <tr><th colspan="2" style="text-align:center;">検索条件</th></tr>
        {foreach from=$param.where_contents item="val" key="key"}
            <tr><th>
            {$key}
            </th>
            <td>
            {$val}
            </td></tr>
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
    {/if}
{include file=$admFooter}
</div>
</body>
</html>
