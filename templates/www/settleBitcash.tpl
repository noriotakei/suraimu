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
<dt>Bitcash決済</dt>
<dd>
<a href="http://www.bitcash.co.jp/i/sheet/index.html">※詳しい説明はｺﾁﾗから</a><br />
<a href="https://secure.bitcash.jp/my/bitcash/merge/">※残高引継ぎ(金額をまとめる)はｺﾁﾗから</a>
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
<form action="./?action_SettleBitcashExec=1" method="post">
{$comFORMparam}
{$FORMparam}
<table class="tableItem" cellspacing="2">
<tr>
<th colspan="2" class="cols">ひらがな16文字のｶｰﾄﾞ番号を入力してください。</th>
</tr>
<tr>
<td colspan="2" class="link"><input name="card_number" size="32" maxlength="32" type="text" value="{$value.card_number}" tabindex="7"/></td>
</tr>
<tr>
<th>ご決済金額</th>
<td>{$orderingData.pay_total|number_format:"0"}円</td>
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
<td colspan="2" class="link"><input name="submit" type="submit" value="BITCASHで決済" /></td>
</tr>
</table>
</form>
<div id="under">&nbsp;</div>
</div>
<p>
デジタルコンテンツという商品の性質上、ご購入後の返品・交換・払い戻しは、原則としてお受けできませんのでご了承ください。<br />
<span class="attentionY">※注意事項</span><br />
・BITCASHの種類は【EX】をご購入ください。【ST】は御利用いただけません。<br />
・必ず【16桁ひらがなIDを入力】【BITCASHで決済】をお願いいたします。BITCASHｶｰﾄﾞの購入だけでは決済が完了されません！<br />
・ご購入にあたっては利用規約に同意いただく必要があります。 <br />
・必ず購入にあたっては<a href="./?action_Rule=1{if $comURLparam}&{$comURLparam}{/if}" title="利用規約" target="_blank">利用規約</a>に同意いただく必要があります。<br />
・<a href="http://www.bitcash.jp/docs/terms/memberstore/" target="blank" />※資金決済法に基づく表示</a>
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