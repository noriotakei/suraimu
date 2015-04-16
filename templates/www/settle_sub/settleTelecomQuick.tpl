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
<div id="titleItemlist">情報購入　ポイント追加</div>
<div id="settle">
<h3>商品のご確認</h3>
{if $errMsg}
    <p class="err">{$errMsg}</p>
{/if}
<dl>
<dt>クレジットカード決済</dt>
<dd>
<span class="attention">※クイックチャージで決済されます</span><br />
下記の内容でよろしければボタンを押して下さい。<br />
</dd>
</dl>
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

<form action="./?action_SettleTelecomQuickExec=1" method="post">
{$comFORMparam}
{$FORMparam}
<table class="tableItem" cellspacing="2">
<tr>
<th>決済金額</th>
<td>合計{$orderingData.pay_total|number_format:"0"}円</td>
</tr>
<tr>
<td colspan="2" class="link"><input name="submit" type="submit" value="決済する" /><br />
<span class="attention">※決済ボタンは1度だけ押して下さい</span></td>
</tr>
</table>
</form>
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