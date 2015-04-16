{include file=$preHeader}
</head>
<body>
<a name="top" id="top"></a>
{include file=$loginForm}
<div id="wrap">
<div id="imageArea">{include file=$preHeadCampaign}</div>
{include file=$preHeaderMenu}
<div id="contents">
<div id="main">
<div class="mainBox">
<div id="titleForget">会員ID/パスワード再送</div>
{if $errMsg}
    <p class="err">{$errMsg}</p>
{/if}
<form action="./?action_PreForgetExec=1" method="post">
{$comFORMparam}
<p>パスワードをお忘れの方は、ご登録のメールアドレスを下記フォームに入力して「送信」ボタンを押して下さい。折り返しご登録のメールアドレスにパスワードを送信致します。</p>
<dl>
<dt>ご登録のメールアドレス</dt>
<div id="formBg">
<div id="formIn"><input name="mail_account" type="text" id="mailCustomer" tabindex="7" value="{$value.mail_account}" style="ime-mode:disabled;" />＠<input name="mail_domain" type="text" id="mailCustomer" tabindex="8" value="{$value.mail_domain}" style="ime-mode:disabled;" /></div>
</div>
</dl>
<p id="centerP">
<input name="regist22" type="image" tabindex="9" onFocus="this.blur()" onMouseOver="this.src='./img/bt_forget_on.png'" onMouseOut="this.src='./img/bt_forget.png'" src="./img/bt_forget.png" alt="送信" />
</p>
</form>
</div>
</div>
{include file=$preSide}
</div>
{include file=$preFooter}
</div>
</body>
</html>