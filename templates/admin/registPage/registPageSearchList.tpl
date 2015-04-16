{include file=$admHeader}
<link type="text/css" href="./css/pager.css" rel="stylesheet" />
<script language="JavaScript">
<!--
    $(function() {ldelim}
        $('.selectText').click(function(){ldelim}
            $(this).select();
        {rdelim});

        {* テーブルストライプ *}
        $("#list_table tr:even").addClass("BgColor02");

        {* テーブルストライプ *}
        $("#src_table tr:even").addClass("BgColor02");

    {rdelim});
// -->
</script>
</head>
<body>

<div id="ContentsCol">

<h2 class="ContentTitle">登録ページ一覧</h2>
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
            <td style="text-align:center;" colspan="2">
                <input type="submit" name="action_registPage_RegistPageSearchList" value="検 索" style="width:8em;"/>
            </td>
        </tr>
    </table>
</form>
<hr>
{* コメント *}
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
    <br>
{/if}
<form action="./" method="post">
    <input type="submit" name="action_registPage_RegistPageCreate" value="登　録"/>
</form>
<br>
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
    <th>ID</th>
    <th>名前</th>
    <th>カテゴリー</th>
    <th>登録ページ<br>コード</th>
    <th>使用状況</th>
    <th>PC登録ページURL</th>
    <th>MB登録ページURL</th>
    <th>優先順位</th>
    <th>表示開始日時</th>
    <th>表示終了日時</th>
    <th>作成日時</th>
    <th>更新日時</th>
    <th>プレビュー</th>
    <th>削除</th>
    </tr>
    {foreach from=$dataList item="val"}
        <tr {if !$val.is_use}style="background-color:tomato;"{/if}>
        <td><a href="{make_link action="action_registPage_RegistPageData" getTags="regist_page_id="|cat:$val.id}">{$val.id}</a></td>
        <td>{$val.name}</td>
        <td>{$categoryList[$val.regist_page_category_id]}</td>
        <td>{$val.cd}</td>
        <td>{$isUseAry[$val.is_use]}</td>
        <td>{if $val.page_html_pc}<textarea rows="3" class="selectText" readonly>{$config.define.SITE_URL}?pcd={$val.cd}&advcd=[媒体コード]</textarea>{/if}</td>
        <td>{if $val.page_html_mb}<textarea rows="3" class="selectText" readonly>{$config.define.SITE_URL_MOBILE}?pcd={$val.cd}&advcd=[媒体コード]</textarea>{/if}</td>
        <td>{$val.sort_seq}</td>
        <td>{$val.display_start_datetime}</td>
        <td>{$val.display_end_datetime}</td>
        <td>{$val.create_datetime}</td>
        <td>{$val.update_datetime}</td>
        <td nowrap>{if $val.page_html_pc}<a href="{$config.define.SITE_URL}?action_indexPreview=1&{$pageCdName}={$val.cd}" target="_blank">PCログイン</a>{/if}<br>
                {if $val.page_html_mb}<a href="{$config.define.SITE_URL_MOBILE}?action_indexPreview=1&{$pageCdName}={$val.cd}" target="_blank">MBログイン</a>{/if}</td>
        <td>
            <form action="./" method="post" style="margin:2px 0px;">
                {$POSTParam}
                <input type="hidden" name="regist_page_id" value="{$val.id}">
                <input type="hidden" name="disable" value="1">
                <input type="submit" name="action_registPage_RegistPageDataExec" value="削除" onClick="return confirm('削除しますか?')">
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
    該当データはありません
    </p>
    </div>
    </div>
{/if}
{include file=$admFooter}
</div>
</body>
</html>