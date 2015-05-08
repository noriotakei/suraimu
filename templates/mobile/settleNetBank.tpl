<?php
header("Content-Type: text/html; charset=UTF-8");
?>
{include file=$hedinfo_login_sp}
<link rel="stylesheet" type="text/css" href="http://image.ko-haito.com/contents/settle/settle.css" media="all">
</head>

<body class="settle netbank">
<!-- #wrap -->
<div class="wrap">
<a id="top"></a>


<div class="titleBar clearfix">
<ul>
    <li class="ttl">かんたん決済</li>
    <li class="h24">24H対応</li>
</ul>
</div>


<!--合計 -->
<div id="sum" class="block">
{if $showCountDown }
<dl>
    <dt>■締切まで残時間</dt>
    <dd class="alignC">{$countDownDay}{$countDownHour}{$countDownMinute}{$countDownSecond}</dd>
</dl>
{/if}
<dl>
    <dt>■合計金額</dt>
    <dd class="alignC red">{$orderingData.pay_total|number_format:"0"}円</dd>
</dl>
</div>
<!--合計 End-->


<!--かんたん決済へ -->
<form method="post" action="{$netBankLinkUrl}" >
{foreach from=$netBankHiddenTag item="val" key="key"}
<input type="hidden" name="{$key}" value="{$val}">
{/foreach}
<div class="form80 mBtm20">
    <input type="image" src="http://image.ko-haito.com/contents/settle/btnNetBank.png" alt="かんたん決済へ" class="responsive">
</div>
</form>
<!--かんたん決済へ -->


<!-- カート -->
<div id="cartBlock" class="bgYellow">

<div class="text">▼ 商品をご確認下さい ▼</div>
{if $itemList}
    {foreach from=$itemList item="val"}
        <div class="cart">
        <table>
            <tr>
                <th>内容</th>
                <td>{$val.html_text_name_mb|emoji}</td>
            </tr>
            <tr>
                <th>価格</th>
                <td class="red">{$val.price|number_format:"0"}円</td>
            </tr>
        </table>
        </div>
    {/foreach}
{/if}

<!-- キャンセル -->
<div class="cancel responsive">
    <a href="./?action_OrderingDelChk=1&odid={$orderingData.access_key}{if $comURLparam}&{$comURLparam}{/if}"><img src="http://image.ko-haito.com/contents/settle/btnCancel.png" alt="予約をキャンセルする"></a>
</div>

</div><!-- /.block -->
<!-- カートEnd -->


<div class="notes block mBtm50">
<p class="text">注意事項</p>
<ul>
    <li>振り込み手数料はお客様のご負担となります。</li>
    <li>お振込みから{$ticket}追加まで若干時間がかかる場合がございます。</li>
    <li>デジタルコンテンツという商品の性質上、ご購入後の返品・交換・払い戻しは、原則としてお受けできませんのでご了承ください。</li>
    <li>その他、ご不明な点がありましたら<a href="mailto:info@{$operationMailAccount|cat:$config.define.MAIL_DOMAIN}">{$operationMailAccount|cat:$config.define.MAIL_DOMAIN}</a>までご連絡ください。</li>
</ul>
</div>


<div class="mBtm10">
    <img src="http://image.ko-haito.com/contents/settle/txtSettleChange.png" alt="※他の決済方法に変更する場合はコチラ" class="responsive">
</div>

<!-- ******************** 決済メニュー ******************** -->
<div class="settleMenuTitle">
    <img src="http://image.ko-haito.com/contents/settle/ttlSettleSelect.png" alt="決済方法の選択">
</div>
<div class="settleList">

{include file=$settle_sp}

</div><!-- /.settleList -->
<!-- ******************** 決済メニュー End ******************** -->

{include file=$part_footer_sp}
</div><!--end wrap-->

</body>
</html>