{include file=$header}
</head>
<body {$bodyTag}>
<a name="top" id="top"></a>
<div style="font-size:x-small; text-align:left; {$limited_width}">
<img src="img/title.gif" alt="{$siteName}" width="100%" />
<div style="text-align:center;">
退会手続き
</div>

<hr {$hr_2style} />
<span style="color:#99ec00;font-size:small;">ID・パスワード入力</span>(<span style="color:#f00;">必須</span>)
<br />
<form action="./?action_TaikaiCompleteExec=1{if $comURLparam}&{$comURLparam}{/if}" method="post">
{$POSTparam}
<span style="color:#f90;font-size:small;">▼<span style="color:#eccc66;">会員ID</span></span><br />
<div style="text-align:center;"><input name="login_id" size="20" style="ime-mode:disabled;" type="text" /></div>
<br />
<br />
<span style="color:#f90;font-size:small;">▼<span style="color:#eccc66;">パスワード(半角英数字)</span></span><br />
<div style="text-align:center;"><input name="password" size="10" value="" style="ime-mode:disabled;" type="password" maxlength="8" /></div>
<br />
<br />
<span style="color:#f90;font-size:small;">▼<span style="color:#eccc66;">携帯メールアドレス</span></span><br />
<div style="text-align:center;">
<input name="mb_mail_account" size="15" style="ime-mode:disabled;" type="text"/>
@
<input name="mb_mail_domain" size="15" style="ime-mode:disabled;" type="text"/>
</div>
<br />
退会をご希望のメールアドレスをご入力ください。退会お手続き完了のメールを1通だけ送信いたしますので、メール内URLをクリックされると退会お手続きが完了いたします。<br />
<div style="text-align:center;color:#000;"><input value="退会手続きを進める" type="submit" /></div>
</form>
<br />
<form action="./?action_Home=1{if $comURLparam}&{$comURLparam}{/if}" method="post">
<div style="text-align:center;color:#000;"><input value="退会手続きを止める" type="submit" /></div>
</form>
<hr {$hr_2style} />
{include file=$pr}
{include file=$footer}
</body>
</html>