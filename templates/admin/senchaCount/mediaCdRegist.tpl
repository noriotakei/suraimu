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
        $('#add_button').live("click", function(){ldelim}
            $("#add_form").toggle("clip", null, "slow");
        {rdelim});
    {rdelim});

// -->
</script>
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">広告コード一覧</h2>
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

<div class="SubMenu">
    <input type="button" id="add_button" value="追　加" />
</div>

<div id="add_form" style="display:none;">
<form action="./" method="POST">
    {$POSTparam}
    <table class="TableSet04">
        <tr>
            <th>
                広告コード：
            </th>
            <td>
                <input type="text" name="name" size="20" value="{$param.name}">
            </td>
        </tr>
        <tr>
            <th>
                備考：
            </th>
            <td>
                <input type="text" name="description" size="30" value="{$param.description}">
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">
                <input type="submit" value="登　録" name="action_Count_MediaCdRegistExec" onClick="return confirm('登録しますか？')">
            </td>
        </tr>
    </table>
</form>
</div>
<br>
{if $mediaCdList}

    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">

    <tr>
    <th nowrap="nowrap">広告コード</th>
    <th>備考</th>
    <th>削除</th>
    </tr>
    {foreach from=$mediaCdList item="val"}
        <tr>
        <td><a href="{make_link action="action_Count_MediaCdData" getTags="media_cd_id="|cat:$val.id}">{$val.name}</a></td>
        <td>{$val.description}</td>
        <td>
        <form action="./" method="post">
            <input type="hidden" name="media_cd_id" value="{$val.id}">
            <input type="hidden" name="disable" value="1">
            <input type="submit" name="action_Count_MediaCdRegistExec" value="削除" OnClick="return confirm('削除しますか？')"/>
        </form>
        </td>
        </tr>
    {/foreach}
    </table>
{/if}


{include file=$admFooter}
</div>
</body>
</html>