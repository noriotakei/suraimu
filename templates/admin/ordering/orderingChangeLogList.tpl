{include file=$admHeader}
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<link type="text/css" href="./css/pager.css" rel="stylesheet" />
<script language="JavaScript">
<!--
    $(function() {ldelim}

        {* カレンダー *}
        $(".datepicker").datepicker({ldelim}
            dateFormat: "yy-mm-dd"
        {rdelim});

        $("#search_button").live("click", function(){ldelim}
            $("#search_form").slideToggle("slow");
        {rdelim});

        {* テーブルマウスオーバーカラー *}
        $('#list_table').colorize({ldelim}
            altColor :'#CCCCCC',
            hiliteColor :'none'
        {rdelim});

        {* テーブルストライプ *}
        $("#src_table tr:even").addClass("BgColor02");

    {rdelim});
// -->
</script>
</head>
<body>
<div class="BlockCol">
    <h2 class="ContentTitle">注文変更ログ一覧</h2>
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
        <br>
    {/if}
    <div class="SubMenu">
        <input type="button" id="search_button" value="検索フォーム表示/非表示" />
    </div>
    <form action="./" method="post" id="search_form">
        <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" id="src_table">
            <tr>
                <th colspan="2" style="text-align: center; font-weight: bold;">検索条件</th>
            </tr>
            <tr>
                <td>注文日付</td>
                <td>
                    <input size="15" class="datepicker" type="text" value="{$param.order_start_datetime|zend_date_format:'yyyy-MM-dd'}" name="order_start_datetime_Date" maxlength="10">
                    から
                    <input size="15" class="datepicker" type="text" value="{$param.order_end_datetime|zend_date_format:'yyyy-MM-dd'}" name="order_end_datetime_Date" maxlength="10">
                </td>
            </tr>
            <tr>
                <td>注文変更日付</td>
                <td>
                    <input size="15" class="datepicker" type="text" value="{$param.change_start_datetime|zend_date_format:'yyyy-MM-dd'}" name="change_start_datetime_Date" maxlength="10">
                    から
                    <input size="15" class="datepicker" type="text" value="{$param.change_end_datetime|zend_date_format:'yyyy-MM-dd'}" name="change_end_datetime_Date" maxlength="10">
                </td>
            </tr>
            <tr>
                <td>注文NO</td>
                <td>
                     <input type="text" name="search_ordering_id" value="{$param.search_ordering_id}" size="10" style="ime-mode:disabled;">
                </td>
            </tr>
            <tr>
                <td>支払方法</td>
                <td>
                    {html_checkboxes name="pay_type" options=$payType selected=$param.pay_type separator="&nbsp;"}
                </td>
            </tr>
            <tr>
                <td>変更時ステータス</td>
                <td>
                    {html_checkboxes name="status" options=$status selected=$param.status separator="&nbsp;"}
                </td>
            </tr>
            <tr>
                <td style="text-align:center;" colspan="2">
                    <input type="hidden" name="search_flag" value="1">
                    <input type="submit" name="action_ordering_OrderingChangeLogList" value="検 索" style="width:8em;"/>
                </td>
            </tr>
        </table>
    </form>
    <br>
    {if $changeLogList}
        <div style="padding-bottom: 10px;">
        件数：{$totalCount}件<br />
        {$dispFirst}～{$dispLast}件表示しています
        {if $pager}
        <ul class="pager">
            <li>{$pager.previous}</li>
            <li>{$pager.pages|@implode:"</li><li>"}</li>
            <li>{$pager.next}</li>
        </ul>
        {/if}
        </div>
        <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" id="list_table">
        <tr>
            <th>注文ID</th>
            <th>商品</th>
            <th>価格</th>
            <th>変更時ステータス</th>
            <th>注文変更日付</th>
            <th>注文日付</th>
        </tr>

        {foreach from=$changeLogList item="val" name="Loop"}
        <tr>
            <td><a href="{make_link action="action_ordering_OrderingData" getTags="ordering_id="|cat:$val.ordering_id}" target="_blank">{$val.ordering_id}</a></td>
            <td>{$val.name|emoji}</td>
            <td>{if $val.price > 0}+{/if}{$val.price}円</td>
            <td>{$status[$val.status]}</td>
            <td>{$val.order_change_log_create_datetime}</td>
            <td>{$val.ordering_create_datetime}</td>
        </tr>
        {/foreach}
        </table>
    {elseif $param.search_flag}
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
