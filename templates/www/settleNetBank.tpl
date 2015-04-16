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
<form method="post" action="{$netBankLinkUrl}" >
{foreach from=$netBankHiddenTag item="val" key="key"}
<input type="hidden" name="{$key}" value="{$val}">
{/foreach}
<input name="submit" type="submit" value="ネットバンクで決済！" />
</form>
</td>
</tr>
</table>
<div id="under">&nbsp;</div>
</div>
<p>
デジタルコンテンツという商品の性質上、ご購入後の返品・交換・払い戻しは、原則としてお受けできませんのでご了承ください。<br />
<span class="attentionY">※注意事項</span><br />
ジャパンネット銀行口座、楽天銀行口座、住信SBIネット銀行口座からお振込みのお客様はお申し込み手続きと同時にお振込みが完了します。<br />
ジャパンネット銀行からジャパンネット銀行へのお振込み。<br />
楽天銀行から楽天銀行へのお振込み。<br />
住信SBIネット銀行から住信SBIネット銀行へのお振込み。<br />
以上の「同銀行間でのお振込み」は24時間リアルタイム決済が可能です。<br />
※通常の銀行振込と違い、当サイトのＩＤ番号などの入力は不要です。会員様の銀行口座情報を入力いただき決済されるだけで、自動的にネット銀行から当サイトへ決済完了情報が届き情報購入が終了いたします。<br />
<span class="attention">■ ネット銀行決済に関するご注意</span><br />
ネット銀行振込みでのお支払いは、<a href="http://www.axes-payment.co.jp/info/bank/pc/index.html" target="_blink">株式会社アクシズの決済システム</a>を利用しています。<br />
ネット銀行決済・個人情報の入力に不安のある方は<a href="http://www.axes-payment.co.jp/credituser.html" target="_blink">株式会社アクシズ</a>-安心・安全への取り組みをお読み下さい。<br />
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