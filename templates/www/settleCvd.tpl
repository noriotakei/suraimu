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
<dt>コンビニ決済</dt>
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
<form action="./?action_SettleCvdChk=1" method="post">
{$comFORMparam}
{$FORMparam}
<table class="tableItem" cellspacing="2">
<tr>
<th>コンビニ選択</th>
<td>
{html_options name="cv_cd" options=$cvName selected=$value.cv_cd   style="color:#000;" tabindex="7"}
</td>
</tr>
<tr>
<th>姓</th>
<td><input name="name1" style="ime-mode: active;" type="text" value="{$value.name1}" tabindex="8" /></td>
</tr>
<tr>
<th>名</th>
<td ><input name="name2" style="ime-mode: active;" type="text" value="{$value.name2}" tabindex="9" /></td>
</tr>
<tr>
<th>携帯電話番号</th>
<td><input name="telno" maxlength="11" style="ime-mode: disabled;" type="text" value="{$value.telno}" tabindex="10" /></td>
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
<td colspan="2" class="link">
<input name="submit" type="submit" tabindex="11" value="決済内容の確認" /></td>
</tr>
</table>
</form>
<div id="under">&nbsp;</div>
</div>
<p>
デジタルコンテンツという商品の性質上、ご購入後の返品・交換・払い戻しは、原則としてお受けできませんのでご了承ください。<br />
<span class="attentionY">※注意事項</span><br />
万一決済が正常に終了しない場合は、コンビニダイレクトカスタマーサポート(0570-000-555)までご連絡ください。<br />
メールや受付番号の再発行等は一切いたしませんので、削除せず大切に保管してください。<br />
払込後にポイントが追加されない等のトラブルは直接加盟店様へお問い合わせください。<br />
お申し込み後はお早めにお支払いをお願いいたします。お申し込みがキャンセルとなる場合がございます。<br />
ご購入にあたっては<a href="./?action_Rule=1{if $comURLparam}&{$comURLparam}{/if}" title="利用規約" target="_blank">利用規約</a>に同意いただく必要があります。 <br />
{if $isDisp}
※ご利用可能なコンビニチェーンについて<br>
セブンイレブンでのコンビニダイレクトは「ご利用が停止」となりました。<br>
セブンイレブン以外の他コンビニチェーンでは今まで同様に「ご利用が可能」でございます。<br />
{/if}
<br />
※入金反映時間について<br />
ファミリーマート　⇒　ご入金後10～30分程度<br />
ローソン・セイコーマート・ミニストップ　⇒　ご入金後2～3時間程度<br />
※なお回線状況等で反映が遅れる場合がございますので予め時間に余裕を持った早めのお手続きをお願い申し上げます。<br />
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