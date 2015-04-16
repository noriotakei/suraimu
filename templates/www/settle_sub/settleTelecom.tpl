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
下記の内容でよろしければ決済ページへお進み下さい。
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

<table class="tableItem" cellspacing="2">
<tr>
<th>ご決済金額</th>
<td>合計{$orderingData.pay_total|number_format:"0"}円</td>
</tr>
<tr>
<td colspan="2" class="link">
<form action="{$creditUrl}" method="post">
{$creditHiddenTags}
<input name="submit" type="submit" value="SSL決済ページへ" /><br />
<span class="attention">※決済ボタンは1度だけ押して下さい</span>
</form>
</td>
</tr>
<tr>
<td colspan="2" class="link">
{if $isQuick}
<span class="attention">前回のクレジットカードで決済する</span><br>
<form action="./?action_SettleTelecomQuick=1{if $comURLparam}&{$comURLparam}{/if}" method="post">
{$comFORMparam}
{$FORMparam}
<input name="submit" type="submit" value="確認する" /><br />
</form>
{/if}
</td>
</tr>
</table>

<div id="under">&nbsp;</div>
</div>
<p>
<span class="attention">※注意事項</span><br />
アナタ様の個人情報を守る為、SSL(暗号化)通信を導入しております。<br />
カード会社から発行の明細書には「TELECOM名義」で請求されます。<br />
カード決済に関するお問い合わせ先はTELECOMまで<br />
<span class="attention">※他の決済方法に変更する場合はコチラ</span><br />
</p>
{include file=$settleMenu}
</div>
</div>
{include file=$side}
</div>
{include file=$footer}
</div>
</body>
</html>