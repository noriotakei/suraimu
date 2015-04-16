{include file=$admHeader}
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<link type="text/css" href="./css/pager.css" rel="stylesheet" />
<script type="text/javascript">
<!--

    $(function() {ldelim}

        {* テーブルマウスオーバーカラー *}
       $('#list_table').colorize({ldelim}
           altColor :'#CCCCCC',
           hiliteColor :'none'
       {rdelim});

        {* テーブルストライプ *}
        $("#src_table tr:even").addClass("BgColor02");


    {rdelim});

//-->
</script>
</head>
<body>

<div id="ContentsCol">
<h2 class="ContentTitle">検索条件一覧</h2>
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
<form action="./" method="POST">
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" id="src_table">
        <tr>
            <th colspan="2" style="text-align: center; font-weight: bold;">検索条件</th>
        </tr>
        <tr>
            <td>カテゴリー</td>
            <td>{html_options name="category_id" options=$searchCategoryList selected=$param.category_id}</td>
        </tr>
        <tr>
            <td>検索条件ID</td>
            <td><input type="text" name="id" value="{$param.id}" size="7" style="ime-mode:disabled"></td>
        </tr>
        <tr>
            <td style="text-align:center;" colspan="2">
                <input type="submit" name="action_user_SearchConditionList" value="検 索" style="width:8em;"/>
            </td>
        </tr>
    </table>
</form>
<hr>
{if $dataList}
    <div style="padding-bottom: 10px;">
    {$totalCount}件中<br />
    {$dispFirst}～{$dispLast}件表示しています
    {if $pager}
    <ul class="pager">
        <li>{$pager.previous}</li>
        <li>{$pager.pages|@implode:"</li><li>"}</li>
        <li>{$pager.next}</li>
    </ul>
    {/if}
    </div>
    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet01">
    <tr>
    <th nowrap="nowrap">ID</th>
    <th nowrap="nowrap">コメント</th>
    <th nowrap="nowrap">カテゴリー</th>
    <th nowrap="nowrap">作成日時</th>
    <th>削除</th>
    </tr>

    {foreach from=$dataList item="val"}
        <tr>
        <td>{$val.id}</td>
        <td><a href="{make_link action="action_user_SearchConditionData" getTags="id="|cat:$val.id}">{$val.comment}</a></td>
        <td>{$categoryList[$val.search_conditions_category_id]}</td>
        <td>{$val.update_datetime}</td>
        <td>
            <form action="./" method="post" style="margin:2px 0px;">
                <input type="hidden" name="id" value="{$val.id}">
                <input type="hidden" name="disable" value="1">
                <input type="submit" name="action_user_SearchConditionUpdExec" value="削除" onClick="return confirm('削除しますか?')">
            </form>
        </td>
        </tr>
    {/foreach}
    </table>
{else}
    <div class="warning ui-widget">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    <p>
    <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    データはありません
    </p>
    </div>
{/if}
{include file=$admFooter}
</div>
</body>
</html>