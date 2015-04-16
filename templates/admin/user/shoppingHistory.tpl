{include file=$admHeader}
<link type="text/css" href="./css/pager.css" rel="stylesheet" />
<script language="JavaScript">
<!--
    $(function() {ldelim}
        {* テーブルマウスオーバーカラー *}
        $('#list_table tr:even').addClass("BgColor02");
    {rdelim});

// -->
</script>
</head>
<body>
<div class="BlockCol">
    <h2 class="ContentTitle">{$userData.name}様　購入履歴</h2>
    {if $orderingHistoryList}
        <div style="padding-bottom: 10px;">
            件数：{$totalCount}件<br />
            {$dispFirst}～{$dispLast}件表示しています
        </div>
        {if $pager}
        <ul class="pager">
            <li>{$pager.previous}</li>
            <li>{$pager.pages|@implode:"</li><li>"}</li>
            <li>{$pager.next}</li>
        </ul>
        {/if}
        <hr>
        <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet01">
        <tr>
        <th>購入日時</th>
        <th>商品名/商品ID</th>
        <th>数量</th>
        </tr>
        {foreach from=$orderingHistoryList item="val"}
            <tr>
            <td>{$val.order_create_datetime}</td>
            <td>{$val.talent_name} <br />
            【{$val.cd}】( \{$val.price} )<br />
            </td>
            <td>{$val.quantity}枚</td>
            </tr>
        {/foreach}
        </table>
    {else}
        <p>今までにお買い上げ頂いた商品はありません。</p>
        <br class="clear" />
    {/if}
{include file=$admFooter}
</div>
</body>
</html>
