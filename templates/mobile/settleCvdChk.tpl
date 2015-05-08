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


<!-- コンビニ決済 -->
<form action="./?action_SettleCvdExec=1{if $comURLparam}&{$comURLparam}{/if}" method="post">
{$FORMparam}
<div id="sum" class="block">
<dl>
    <dt>■コンビニ選択</dt>
    <dd>{$cvName[$param.cv_cd]}</dd>
</dl>
<dl>
    <dt>■姓</dt>
    <dd>{$param.name1}</dd>
</dl>
<dl>
    <dt>■名</dt>
    <dd>{$param.name2}</dd>
</dl>
<dl>
    <dt>■携帯電話番号</dt>
    <dd>{$param.telno}</dd>
</dl>
<dl>
    <dt>■合計金額</dt>
    <dd class="red">{$orderingData.pay_total|number_format:"0"}円</dd>
</dl>
</div><!-- /#sum -->

<div class="form80 mBtm20">
    <input type="image" src="http://image.ko-haito.com/contents/settle/btnCvdChk.png" alt="申し込む" class="responsive">
</div>
</form>
<!-- コンビニ決済 -->


<!-- 修正 -->
<form action="./?action_SettleCvd=1{if $comURLparam}&{$comURLparam}{/if}" method="post">
{$FORMparam}
<div class="form80 mBtm20">
    <input type="image" src="http://image.ko-haito.com/contents/settle/btnCvdBack.png" alt="内容を修正する" class="responsive">
</div>
</form>
<!-- 修正 -->


<div class="notes block mBtm50">
<p class="text">注意事項</p>
<ul>
    <li>万一決済が正常に終了しない場合は、コンビニダイレクトカスタマーサポート（0570-000-555）までご連絡ください｡</li>
    <li>メールや受付番号の再発行等は一切いたしませんので、削除せず大切に保管してください。</li>
    <li>払込後に{$ticket}が追加されない等のトラブルは直接加盟店様へお問い合わせください。</li>
    <li>お申し込み後はお早めにお支払いをお願いいたします。お申し込みがキャンセルとなる場合がございます。</li>
    <li>ご購入にあたっては<a href="./?action_rule=1&{$URLparam}{if $comURLparam}&{$comURLparam}{/if}">利用規約</a>に同意いただく必要があります。</li>
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