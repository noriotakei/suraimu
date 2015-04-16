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

        {* 追加フォーム *}
        if (!{$registParam.return_flag}) {ldelim}
            $("#add_form").hide();
        {rdelim} else {ldelim}
            $("#add_form").show();
        {rdelim}
        $('#add_button').live("click", function(env){ldelim}
            if (env.button !== 0) return;
            $("#add_form").toggle("blind", null, "slow");
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
                <input type="text" name="search_string" value="{$param.search_string}" size="30" style="ime-mode:disabled">
            </td>
        </tr>
        <tr>
            <td style="text-align:center;" colspan="2">
                <input type="submit" name="action_testAddress_RegistTestAddressList" value="検 索" style="width:8em;"/>
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
<div class="SubMenu">
    <input type="button" id="add_button" value="追　加" />
</div>
<div id="add_form" style="display:none">
<form action="./" method="post">
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
        <tr>
        <th>カテゴリー</th>
        <td style="text-align: left;">{html_options name="regist_test_mail_category_id" options=$categoryList selected=$registParam.regist_test_mail_category_id}</td>
        </tr>
        <tr>
        <th>メールアドレス</th>
        <td style="text-align: left;">
            <input type="text" name="mail_address" value="{$registParam.mail_address}" size="50" style="ime-mode:disabled">
        </td>
        </tr>
        <tr>
        <th>表示順</th>
        <td style="text-align: left;"><input type="text" name="sort_seq" value="{$registParam.sort_seq|default:1}" size="3"></td>
        </tr>
        <tr>
        <th>表示状態</th>
        <td style="text-align: left;">{html_options name="is_display" options=$isDisplay selected=$registParam.isDisplay|default:1}</td>
        </tr>
        <tr>
        <td colspan="2" style="text-align: center">
            <input type="submit" name="action_testAddress_RegistTestAddressAddExec" value="登　録" onClick="return confirm('登録しますか？')" />
        </td>
        </tr>
    </table>
</form>
</div>
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
    <th nowrap="nowrap">カテゴリー</th>
    <th>メールアドレス</th>
    <th>表示状態</th>
    <th>表示順</th>
    <th>登録時間</th>
    <th>削除</th>
    </tr>

    {foreach from=$dataList item="val"}
        <tr>
        <td><a href="{make_link action="action_testAddress_RegistTestAddressData" getTags="id="|cat:$val.id}">{$val.id}</a></td>
        <td>{$categoryList[$val.regist_test_mail_category_id]}</td>
        <td>{$val.mail_address}</td>
        <td>{$isDisplay[$val.is_display]}</td>
        <td>{$val.sort_seq}</td>
        <td>{$val.update_datetime}</td>
        <td>
            <form action="./" method="post" style="margin:2px 0px;">
                <input type="hidden" name="id" value="{$val.id}">
                <input type="hidden" name="disable" value="1">
                <input type="submit" name="action_testAddress_RegistTestAddressAddExec" value="削除" onClick="return confirm('削除しますか?')">
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