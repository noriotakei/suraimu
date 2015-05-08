<?php
header("Content-Type: text/html; charset=UTF-8");
?>
{include file=$hedinfo_login_sp}
<link rel="stylesheet" type="text/css" href="http://image.ko-haito.com/contents/settle/settle.css" media="all">
</head>

<body class="settle credit">
<!-- #wrap -->
<div class="wrap">
<a id="top"></a>


<div class="titleBar clearfix">
<ul>
    <li class="ttl">クレジットカード決済</li>
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
{if $isQuick}
<!--前回決済のカードでスピード決済へ -->
<form action="./?action_SettleTelecomQuick=1{if $comURLparam}&{$comURLparam}{/if}" method="post">
{$FORMparam}
<div class="form80 mBtm20">
    <input type="image" src="http://image.ko-haito.com/contents/settle/btnCreditQuick.gif" alt="前回決済のカードでスピード決済へ" class="responsive">
</div>
</form>
<!--前回決済のカードでスピード決済へ End-->
{/if}
<!--クレジット決済へ -->
<form action="{$creditUrl}" method="post">
{$creditHiddenTags}
<div class="form80 mBtm20">
    <input type="image" src="http://image.ko-haito.com/contents/settle/btnCredit.png" alt="クレジット決済ページへ" class="responsive">
</div>
</form>
<!--クレジット決済へ End-->


<!-- カート -->
<div id="cartBlock" class="bgYellow">

<div class="text">▼ 商品をご確認下さい ▼</div>
<!--1 -->
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
<!--2 End-->

<!-- キャンセル -->
<div class="cancel responsive">
    <a href="./?action_OrderingDelChk=1&odid={$orderingData.access_key}{if $comURLparam}&{$comURLparam}{/if}"><img src="http://image.ko-haito.com/contents/settle/btnCancel.png" alt="予約をキャンセルする"></a>
</div>

</div><!-- /.block -->
<!-- カートEnd -->


<div class="notes block mBtm50">
<p class="text">注意事項</p>
<ul>
    <li>アナタ様の個人情報を守る為、SSL(暗号化)通信を導入しております。</li>
    <li>カード会社から発行の明細書には「TELECOM名義」で請求されます。</li>
    <li>カード決済に関するお問い合わせ先はTELECOM 【TEL】<a href="tel:0334579124">03-3457-9124</a> (24時間365日)&emsp;【E-mail】<a href="mailto:info@telecomcredit.ce.jp">info@telecomcredit.ce.jp</a>までお願い致します。</li>
    <li>デジタルコンテンツという商品の性質上、ご購入後の返品・交換・払い戻しは、原則としてお受けできませんのでご了承ください。</li>
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