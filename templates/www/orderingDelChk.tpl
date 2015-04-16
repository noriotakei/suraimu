{include file=$header}
</head>
<body>
<a name="top" id="top"></a>
{include file=$status}
<div id="wrap">
<div id="imageArea">{include file=$headCampaign}</div>
{include file=$headerMenu}
<div id="contents">
<div id="main">
<div class="mainBox">
<div id="settle">
<h3>商品のご確認</h3>
{if $errMsg}
    <p class="err">{$errMsg}</p>
{/if}
{if $itemList}
    {foreach from=$itemList item="val"}
    <table class="tableItem" cellspacing="2">
    <tr>
    <th>ご予約商品名</th>
    <td class="attention">{$val.html_text_name_pc|emoji}</td>
    </tr>
    <tr>
    <th>商品金額</th>
    <td class="attention">{$val.price|number_format}円</td>
    </tr>
    </table>
    {/foreach}
{/if}

<table class="tableItem" cellspacing="2">
<tr>
<th>ご決済金額</th>
<td class="attention">{$orderingData.pay_total|number_format:"0"}円</td>
</tr>
<tr>
<th>ご予約日時</th>
<td>{$orderingData.create_datetime|zend_date_format:'yyyy年MM月dd日 HH時mm分ss秒'}</td>
</tr>
</table>
<table class="tableItem" cellspacing="2">
<tr>
<th>決済種別</th>
<td>{$settleName}決済</td>
</tr>
</table>
<table class="tableItem" cellspacing="2">
<tr>
<td><a href="./?action_OrderingDelExec=1{if $URLparam}&{$URLparam}{/if}">キャンセルする</a></td>
</tr>
</table>
<div id="under">&nbsp;</div>
</div>
{include file=$settleMenu}
</div>
</div>
{include file=$side}
</div>
{include file=$footer}
</div>
</body>
</html>