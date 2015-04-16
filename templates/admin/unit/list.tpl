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
<h2 class="ContentTitle">ユニット一覧</h2>
<form action="./" method="POST">
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" id="src_table">
        <tr>
            <th colspan="2" style="text-align: center; font-weight: bold;">検索条件</th>
        </tr>
        <tr>
            <th>ログ削除対象フラグ</th>
            <td>{html_options name="is_stay" options=$isStay selected=$param.is_stay}</td>
        </tr>
        <tr>
            <th>コメント</th>
            <td>
                <input type="text" name="search_string" value="{$param.search_string}" size="30">
            </td>
        </tr>
        <tr>
            <td style="text-align:center;" colspan="2">
                <input type="submit" name="action_unit_List" value="検 索" style="width:8em;"/>
            </td>
        </tr>
    </table>
</form>
<hr>
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
<br>
{if $dataList}
    <div style="padding-bottom: 10px;">
    データ件数：{$totalCount}件<br />
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
    <th>コメント</th>
    <th>人数</th>
    <th nowrap="nowrap">ログ削除対象フラグ</th>
    <th>登録時間</th>
    <th>削除</th>
    </tr>

    {foreach from=$dataList item="val"}
        <tr>
        <td><a href="{make_link action="action_unit_UnitData" getTags="id="|cat:$val.id}">{$val.id}</a></td>
        <td>{$val.comment}</td>
        <td>{$val.count}人</td>
        <td>{$isStay[$val.is_stay]}</td>
        <td>{$val.create_datetime}</td>
        <td>
            <form action="./" method="post" style="margin:2px 0px;">
                <input type="hidden" name="id" value="{$val.id}">
                <input type="hidden" name="disable" value="1">
                <input type="submit" name="action_unit_UnitUpdExec" value="削除" onClick="return confirm('削除しますか?')">
            </form>
        </td>
        </tr>
    {/foreach}

    </table>
    <br>
    {if $pager}
    <ul class="pager">
        <li>{$pager.previous}</li>
        <li>{$pager.pages|@implode:"</li><li>"}</li>
        <li>{$pager.next}</li>
    </ul>
    {/if}
    </div>
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