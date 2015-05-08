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


<div class="bgRed alignC mBtm10">
※まだ決済は完了しておりません
</div>
<div class="block mBtm20">
ご利用ありがとうございます。<br>
下記の内容でお申込みを受け付けました。お申込み番号を確認の上、お支払いください。<br>
下記の内容をメールでお送りしますのであわせてご確認ください。<br>
お支払いのご不明な点等は、<a href="mailto:info@{$operationMailAccount|cat:$config.define.MAIL_DOMAIN}">{$operationMailAccount|cat:$config.define.MAIL_DOMAIN}</a>までお問い合わせください。<br>
</div>


<!-- コンビニ決済 -->
<div id="sum" class="block">
<div class="bgBlue mBtm10">【お申込み内容】</div>
<dl>
    <dt>■コンビニ選択</dt>
    <dd>{$cvName[$cvdData.store_cd]}</dd>
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
    <dd class="red">{$param.pay_total|number_format:"0"}円</dd>
</dl>
</div>
<!-- コンビニ決済 -->


<div class="notes block mTop30 mBtm50">
<p class="text">注意事項</p>
<ul>
    <li>万一決済が正常に終了しない場合は、コンビニダイレクトカスタマーサポート（0570-000-555）までご連絡ください｡</li>
    <li>メールや受付番号の再発行等は一切いたしませんので、削除せず大切に保管してください。</li>
    <li>払込後に{$ticket}が追加されない等のトラブルは直接加盟店様へお問い合わせください。</li>
    <li>お申し込み後はお早めにお支払いをお願いいたします。お申し込みがキャンセルとなる場合がございます。</li>
    <li>ご購入にあたっては<a href="./?action_rule=1&{$URLparam}{if $comURLparam}&{$comURLparam}{/if}">利用規約</a>に同意いただく必要があります。</li>
</ul>
</div>

{include file=$part_footer_sp}
</div><!--end wrap-->

</body>
</html>