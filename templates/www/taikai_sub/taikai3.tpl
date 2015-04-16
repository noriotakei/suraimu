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
<div id="titleTaikai">退会</div>
<form action="./?action_TaikaiCompleteExec=1" method="post">
{$comFORMparam}
{$POSTparam}
<dl>
<p>
ID・パスワード入力<span id="attention">(必須)</span><br />
退会のご理由アンケートにご協力ください。今後のサービス向上に活用させていただきます。
</p>
<dt>会員ID</dt>
<div id="formBg">
<div id="formIn">
<input id="loginId" name="login_id"  tabindex="7" style="ime-mode:disabled;" type="text" value="" />
</div>
</div>
<dt>パスワード</dt>
<div id="formBg">
<div id="formIn">
<input id="loginPass" name="password" tabindex="8" value="" style="ime-mode:disabled;" type="password" maxlength="8" />
</div>
</div>
<dt>ご登録メールアドレス</dt>
<div id="formBg">
<div id="formIn">
<input name="mail_account" type="text" id="mailCustomer" tabindex="9" value="" />
＠
<input name="mail_domain" type="text" id="mailCustomer" tabindex="10" value="" />
</div>
</div>
<p>退会をご希望のメールアドレスをご入力ください。退会お手続き完了のメールを1通送信いたしますので、メール内URLをクリックされると退会お手続きが完了いたします。</p>
<p id="centerP">
<input name="regist3" type="image" tabindex="11" style="text-align:center;" onFocus="this.blur()" onMouseOver="this.src='./img/bt_taikai_on.png'" onMouseOut="this.src='./img/bt_taikai.png'" src="./img/bt_taikai.png" alt="退会手続きを進める" />
</p>
</dl>
</form>
<div id="centerP">
<form action="./?action_Home=1" method="post">
{$comFORMparam}
<input name="regist3" type="image" tabindex="12" style="text-align:center;" onFocus="this.blur()" onMouseOver="this.src='./img/bt_taikaistop_on.png'" onMouseOut="this.src='./img/bt_taikaistop.png'" src="./img/bt_taikaistop.png" alt="退会手続きを止める" />
</form>
</div>
</div>
</div>
{include file=$side}
</div>
{include file=$footer}
</div>
</body>
</html>