<?php
header("Content-Type: text/html; charset=UTF-8");
?>
{include file=$hedinfo_login_sp}
<link rel="stylesheet" type="text/css" href="http://image.ko-haito.com/contents/settle/settle.css" media="all">
</head>

<body class="settle cvd">
<!-- #wrap -->
<div class="wrap">
<a id="top"></a>


<div class="titleBar clearfix">
<ul>
    <li class="ttl">コンビニ決済</li>
    <li class="h24">24H対応</li>
</ul>
</div>

<div class="block mBtm20">
    {if $errMsg}<span style="color:#f00;font-size:142.9%;">{$errMsg}</span><br /><hr {$hr_1style} />{/if}
</div>
<!-- コンビニ決済 -->
<form action="./?action_SettleCvdChk=1{if $comURLparam}&{$comURLparam}{/if}" method="post">
{$FORMparam}
<div id="sum" class="block">
<dl>
    <dt>■コンビニ選択</dt>
    <dd class="formBlock">
        {html_options name="cv_cd" options=$cvName selected=$value.cv_cd  style="color:#000;"}
    </dd>
</dl>
<dl>
    <dt>■姓</dt>
    <dd class="formBlock"><input type="text" name="name1" style="ime-mode: active;" value="{$value.name1}" placeholder="姓を入力して下さい"></dd>
</dl>
<dl>
    <dt>■名</dt>
    <dd class="formBlock"><input type="text" name="name2" style="ime-mode: active;" value="{$value.name2}" placeholder="名を入力して下さい"></dd>
</dl>
<dl>
    <dt>■携帯電話番号</dt>
    <dd class="formBlock"><input type="tel" maxlength="11" style="ime-mode: disabled;" name="telno" value="{$value.telno}" placeholder="携帯番号を入力して下さい" maxlength="11"></dd>
</dl>
{if $showCountDown }
<dl>
    <dt>■締切まで残時間</dt>
    <dd>{$countDownDay}{$countDownHour}{$countDownMinute}{$countDownSecond}</dd>
</dl>
{/if}
<dl>
    <dt>■合計金額</dt>
    <dd class="red">{$orderingData.pay_total|number_format:"0"}円</dd>
</dl>
</div><!-- /#sum -->

<div class="form80 mBtm20">
    <input type="image" src="http://image.ko-haito.com/contents/settle/btnCvd.png" alt="決済内容の確認" class="responsive">
</div>
</form>
<!-- コンビニ決済 -->


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
    <li>万一決済が正常に終了しない場合は、コンビニダイレクトカスタマーサポート（0570-000-555）までご連絡ください｡</li>
    <li>メールや受付番号の再発行等は一切いたしませんので、削除せず大切に保管してください。</li>
    <li>払込後に{$ticket}が追加されない等のトラブルは直接加盟店様へお問い合わせください。</li>
    <li>お申し込み後はお早めにお支払いをお願いいたします。お申し込みがキャンセルとなる場合がございます。</li>
    <li>ご購入にあたっては<a href="./?action_Rule=1{if $comURLparam}&{$comURLparam}{/if}">利用規約</a>に同意いただく必要があります。</li>
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