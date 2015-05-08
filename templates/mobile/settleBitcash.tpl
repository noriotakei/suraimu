<?php
header("Content-Type: text/html; charset=UTF-8");
?>
{include file=$hedinfo_login_sp}
<link rel="stylesheet" type="text/css" href="http://image.ko-haito.com/contents/settle/settle.css" media="all">
</head>

<body class="settle bitcash">
<!-- #wrap -->
<div class="wrap">
<a id="top"></a>


<div class="titleBar clearfix">
<ul>
    <li class="ttl">ビットキャッシュ決済</li>
    <li class="h24">24H対応</li>
</ul>
</div>


<div class="block mBtm20">
{if $errMsg}<span style="color:#f00;font-size:142.9%;">{$errMsg}</span><br /><hr {$hr_1style} />{/if}
<a href="http://www.bitcash.co.jp/i/sheet/index.html" target="_blank">※詳しい説明はコチラから</a><br />
<a href="https://secure.bitcash.jp/my/bitcash/merge/" target="_blank">※残高引継ぎ（金額をまとめる）はコチラから</a><br />
</div>


<!-- ビットキャッシュ決済 -->
<form action="./?action_SettleBitcashExec=1{if $comURLparam}&{$comURLparam}{/if}" method="post">
{$FORMparam}
<div id="sum" class="block">
<dl>
    <dt>■ひらがな16文字のカード番号を入力してください。</dt>
    <dd class="formBlock"><input type="text" name="card_number" maxlength="32" value="{$value.card_number}" placeholder="ひらがな16文字のカード番号"></dd>
</dl>
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

<div class="form80 mTop10">
    <input type="image" src="http://image.ko-haito.com/contents/settle/btnBitcash.png" alt="BITCASHで決済する" class="responsive">
</div>

</div><!-- /#sum -->
</form>
<!-- ビットキャッシュ決済 -->


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
<!-- キャンセル -->
<div class="cancel responsive">
    <a href="./?action_OrderingDelChk=1&odid={$orderingData.access_key}{if $comURLparam}&{$comURLparam}{/if}"><img src="http://image.ko-haito.com/contents/settle/btnCancel.png" alt="予約をキャンセルする"></a>
</div>

</div><!-- /.block -->
<!-- カートEnd -->


<div class="notes block mBtm50">
<p class="text">注意事項</p>
<ul>
    <li>必ず【IDを入力】【金額選択】まで完了させて下さい。カード購入だけでは{$ticket}追加されません！</li>
    <li>ご購入にあたっては<a href="./?action_Rule=1{if $comURLparam}&{$comURLparam}{/if}">利用規約</a>に同意いただく必要があります。</li>
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