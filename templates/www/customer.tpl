{include file=$header}
</head>
<body>
<a name="top" id="top"></a>
{include file=$status}<div id="wrap">
<div id="imageArea">{include file=$headCampaign}</div>
{include file=$headerMenu}
<div id="contents">
<div id="main">
<div class="mainBox">
<div id="titleCustomer">お問い合わせ</div>
<div id="txtCustomer">当サイトへのお問い合わせ・ご意見はこちらから！皆様からお寄せいただきますご質問・ご意見は、より良いサービスに生かしていける様、努力してまいります。</div>
{if $errMsg}
    <p class="err">{$errMsg}</p>
{/if}
<form action="./?action_CustomerExec=1" name="customer" method="post">
{$comFORMparam}
<dl>
<dt>返信をご希望するメールアドレス</dt>
<div id="formBg">
<div id="formIn">
<input name="mail_account" type="text" id="mailCustomer" tabindex="7" value="{$value.mail_account}" style="ime-mode:disabled;" />＠<input name="mail_domain" type="text" id="mailCustomer" tabindex="8" value="{$value.mail_domain}" style="ime-mode:disabled;" />
</div>
</div>
<dt>お問い合わせ内容</dt>
<div id="formBg">
<div id="formIn">
<textarea name="message" rows="5" cols="10" tabindex="9" id="areaCustomer">{$value.message}</textarea>
</div>
</div>
</dl>
<p id="centerP">
<input name="regist3" type="image" tabindex="10" style="text-align:center;" onFocus="this.blur()" onMouseOver="this.src='./img/bt_customer_on.png'" onMouseOut="this.src='./img/bt_customer.png'" src="./img/bt_customer.png" alt="お問い合わせを送信" />
</p>
</form>
<div id="customer">カスタマーサポート</div>
</div>
</div>
{include file=$side}
</div>
{include file=$footer}
</div>
</body>
</html>