{include file=$header}
<link rel="stylesheet" href="css/settle.css" type="text/css" media="screen" />
</head>
<body>
<a name="top" id="top"></a>
{*{include file=$status}*}
<div id="wrap">
{*<div id="imageArea">{include file=$headCampaign}</div>*}
{*{include file=$headerMenu}*}
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
<!--カウントダウン追加 -->
{if $showCountDown }
<script type="text/javascript" src="js/countDown.js"></script>
<tr>
    <th>締切まで残時間</th>
    <td align="center"><span id="cntdown1" style="font-size:28px; color:#000; height:40px; line-height:40px;"></span>
        <script type="text/javascript">countdown('cntdown1',{$countDownYear},{$countDownMonth},{$countDownDay},{$countDownHour},{$countDownMinute});</script>
    </td>
</tr>
{/if}
<!--/カウントダウン追加 -->
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
<form action="./?action_SettleCreditQuick=1{if $comURLparam}&{$comURLparam}{/if}" method="post">
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
デジタルコンテンツという商品の性質上、ご購入後の返品・交換・払い戻しは、原則としてお受けできませんのでご了承ください。<br />
<span class="attention">※注意事項</span><br />
アナタ様の個人情報を守る為、SSL(暗号化)通信を導入しております。<br />
カード会社から発行の明細書には「AXES」または「EC PAY」で請求されます。<br />
カード決済に関するお問い合わせ先はAXESまで<br />
</p>
<table border="0">
<tr>
<td align="center">
<a href="https://gw.axes-payment.com/cgi-bin/pc_exp.cgi?clientip={$settleClientIp}" target="_blink">
クレジットカード決済に関するご説明<br>必ずお読みください</a><br><br>
カード決済に関するお問い合わせ<br>
決済システムは(株)アクシズを利用しています<br>
TEL:0570-03-6000（TEL03-3498-6200）<br>
<a href="mailto:creditinfo@axes-payment.co.jp">creditinfo@axes-payment.co.jp</a><br>
アクシズカスタマーサポート（24時間365日)<br>
</td>
</tr>
</table>
<p>
<span class="attention">※他の決済方法に変更する場合はコチラ</span><br />
</p>
{include file=$settleMenu}
</div>
</div>
{*{include file=$side}*}
</div>
{*{include file=$footer}*}
{$comImgTag}
</div>
</body>
</html>