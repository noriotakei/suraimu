<?php
header("Content-Type: text/html; charset=UTF-8");
?>
{include file=$hedinfo_login_sp}
<link rel="stylesheet" type="text/css" href="http://image.ko-haito.com/contents/settle/settle.css" media="all">
</head>

<body class="settle bank">
<!-- #wrap -->
<div class="wrap">
<a id="top"></a>


<div class="titleBar clearfix">
<ul>
    <li class="ttl">銀行振込</li>
    <li class="h24">楽天のみ<br>24H対応</li>
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
<dl>
    <dt>■お振込名義ID（振込人名義は必ず下記IDに変更してください）</dt>
    <dd class="transfer red"><strong>{$orderingData.id}</strong><br><span>※お振込名義IDは毎回違います｡</span></dd>
</dl>
</div>
<!--合計 End-->


<!--お振込先 -->
<div id="account">
<dl>
    <dt>【お振込先】</dt>
    <dd>
        <div class="mBtm10">
        {$bankName}<br>
{$branchName}<br>
{$accountNumber}
</div>
        <span>{$transferDestination}</span>
    </dd>
</dl>
<p class="alignC responsive">
    <a href="./?action_SettleBank=1&{$URLparam}&mail=1{if $comURLparam}&{$comURLparam}{/if}"><img src="http://image.ko-haito.com/contents/settle/btnSendmail.png" alt="登録メールアドレスに送信する"></a>
</p>
</div><!-- /#account -->
<!--お振込先 End-->


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


<!-- ネットバンク リンクボタン -->
<div id="bankList" class="mBtm30">
<table class="mBtm10">
    <tr>
        <td><a href="https://direct.smbc.co.jp/aib/aibgsjsw1001.jsp" target="_blank"><img src="http://image.ko-haito.com/contents/settle/btnBank1.png" alt="三井住友銀行"></a></td>
        <td><a href="https://entry11.bk.mufg.jp/ibg/dfw/APLIN/loginib/login?_TRANID=AA000_002" target="_blank"><img src="http://image.ko-haito.com/contents/settle/btnBank2.png" alt="東京三菱UFJ銀行"></a></td>
        <td><a href="https://web.ib.mizuhobank.co.jp/servlet/LOGBNK0000000B.do" target="_blank"><img src="http://image.ko-haito.com/contents/settle/btnBank3.png" alt="みずほ銀行"></a></td>
    </tr>
    <tr>
        <td><a href="http://www.rakuten-bank.co.jp/smartphone/" target="_blank"><img src="http://image.ko-haito.com/contents/settle/btnBank4.png" alt="楽天銀行"></a></td>
        <td><a href="https://login.japannetbank.co.jp/wctx/LoginAction.do?loginIdFlg=0" target="_blank"><img src="http://image.ko-haito.com/contents/settle/btnBank5.png" alt="ジャパンネット銀行"></a></td>
        <td><a href="http://www.resona-gr.co.jp/resonabank/sp/index.html" target="_blank"><img src="http://image.ko-haito.com/contents/settle/btnBank6.png" alt="りそな銀行"></a></td>
    </tr>
</table>
<p>上記より各銀行のネットバンクへログインして決済できます。</p>
</div>
<!-- ネットバンク リンクボタンEnd -->


<div class="notes block mBtm50">
<p class="text">注意事項</p>
<ul>
    <li>お振込ID（<strong style="color:#f00;">{$orderingData.id}</strong>）はお間違えないようにお願いします。</li>
    <li>必ずお振込人名義を変更して振込してください。</li>
    <li>楽天銀行間の振込手数料は無料です。</li>
    <li>その他、ご不明な点がありましたら<a href="mailto:{$operationMailAccount|cat:$config.define.MAIL_DOMAIN}">{$operationMailAccount|cat:$config.define.MAIL_DOMAIN}</a>までご連絡ください</li>
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