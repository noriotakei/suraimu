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
<div id="titleItemlist">情報購入 ポイント追加</div>
<div id="settle">
<h3>商品のご確認</h3>
{if $errMsg}
    <p class="err">{$errMsg}</p>
{/if}
<dl>
<dt>銀行振り込み</dt>
<dd>お早めにご決済完了をお願い致します！</dd>
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
<div style="font-size:large;">
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
</table>
<table class="tableItem" cellspacing="2">
<tr>
<th>お振込み先</th>
<td>{$bankName}<br>{$branchName}<br>{$accountNumber}<br>{$transferDestination}</td>
</tr>
<tr>
<th>振込名義</th>
<td>{$orderingData.id}</td>
</tr>
</table>
</div>
<p class="attentionY">※お振込み名義ID【{$orderingData.id}】は商品ごと･注文ごとに、毎回違います。</p>

<form action="./?action_SettleBank=1&mail=1" method="post">
{$comFORMparam}
{$FORMparam}
<table class="tableItem" cellspacing="2">
<tr>
<td class="link">
<span style="color:#339900;">携帯アドレスを登録すればメモいらずで大変便利。<br>登録もここから無料でできます!!</span><br>
{if $mailMsg}
<span class="attentionR">{$mailMsg}</span><br>
{/if}
<input type="text" name="mb_mail_account" value="{$mb_mail_account}" style="width:200px; margin:10px 5px 0 0;" tabindex="7">＠{html_options name="mb_mail_domain" options=$config.web_config.mobile_mail_domain selected=$mb_mail_domain tabindex="8"}
<br>
<input name="submit" type="submit" value="振込先を携帯電話にメールする" style="margin-top:10px;" /></td>
</tr>
</table>
</form>
<div id="under">&nbsp;</div>
</div>
<p>
デジタルコンテンツという商品の性質上、ご購入後の返品・交換・払い戻しは、原則としてお受けできませんのでご了承ください。<br />
<span class="attentionY">※注意事項</span><br />
お振り込みは<span class="attention">電信扱い</span>にてお願いいたします<br />
午後3時をすぎたお振込の場合、ポイントの追加は翌日（金曜、祝日等は銀行の翌営業日）となります<br />
※楽天銀行からのお振込みは24時間365日、即時の自動確認となります。<br />
ポイントの追加がされるまで、振込明細書（振込控え）は捨てずにお持ちください<br />
お振込名義ID（<span class="attention">{$orderingData.id}</span>）が確認できない場合、弊社では一切責任を負いかねます<br />
振り込み手数料はお客様のご負担となります<br />
お振込からポイント追加まで若干時間がかかる場合がございます<br />
その他、ご不明な点がありましたら<a href="mailto:{$operationMailAccount|cat:$config.define.MAIL_DOMAIN}">{$operationMailAccount|cat:$config.define.MAIL_DOMAIN}</a>までご連絡ください<br />
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