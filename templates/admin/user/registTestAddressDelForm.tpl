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

<h2 class="ContentTitle">テストアドレス一覧</h2>
<form action="./" method="POST">
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" id="src_table">
        <tr>
            <th colspan="2" style="text-align: center; font-weight: bold;">検索条件</th>
        </tr>
        <tr>
            <td>カテゴリー</td>
            <td>{html_options name="regist_test_mail_category_id" options=$searchCategoryList selected=$param.regist_test_mail_category_id}</td>
        </tr>
        <tr>
            <td>メールアドレス</td>
            <td>
                {html_radios name="specify_keyword" options=$specifyKeywordAry selected=$param.specify_keyword|default:0 separator="&nbsp;"}<br>
                <input type="text" name="search_string" value="{$param.search_string}" size="30">
            </td>
        </tr>
        <tr>
            <td style="text-align:center;" colspan="2">
                <input type="submit" name="action_user_RegistTestAddressDelForm" value="検 索" style="width:8em;"/>
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
    <form action="./" method="post" enctype="multipart/form-data">
        {$POSTparam}
        <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet01">
        <tr>
        <th nowrap="nowrap">カテゴリー</th>
        <th>メールアドレス</th>
        <th>テストアドレス<br>ユーザー削除</th>
        </tr>

        {foreach from=$dataList item="val"}
            <tr>
            <td>{$categoryList[$val.regist_test_mail_category_id]}</td>
            <td>{$val.mail_address}</td>
            <td style="text-align:center;"><input type="checkbox" name="disable[{$val.id}]" value="1"></td>
            </tr>
        {/foreach}
        </table>
        <div class="SubMenu">
            <input type="submit" name="action_user_RegistTestAddressUserDelExec" value="削　除" onClick="return confirm('削除しますか？')" />
        </div>
    </form>
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