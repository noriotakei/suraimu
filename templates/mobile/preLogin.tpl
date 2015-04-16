{include file=$preHeader}
</head>
<body {$bodyTag}>
<a name="top" id="top"></a>
<div style="font-size:x-small; text-align:left; {$limited_width}">
<img src="img/title.gif" alt="{$siteName}" width="100%" />
<div style="text-align:center;">
メンバーログイン
</div>

<hr {$hr_1style}/>
{if $errMsg}<span style="color:#f00;font-size:small;">{$errMsg}</span><br /><hr {$hr_1style} />{/if}
<form action="./?action_LoginChk=1{if $comURLparam}&{$comURLparam}{/if}" method="post">
<span style="color:#f00;">{""|emoji}</span><span style="color:#ffa50;font-size:small;">会員ID</span><br />
<div style="text-align:center;"><input name="login_id" size="20" style="ime-mode:disabled;" type="text" /></div>
<span style="color:#f00;">{""|emoji}</span><span style="color:ffc000;font-size:small;">パスワード(半角英数字)</span><br />
<div style="text-align:center;"><input name="password" size="10" value="" style="ime-mode:disabled;" type="password" /></div>
<br />
<div style="text-align:center;color:#000;"><input value="ログイン" type="submit" />
</div>
</form>
<hr {$hr_1style}/>
<div style="text-align:right;"><a href="./?action_PreForget=1{if $comURLparam}&{$comURLparam}{/if}">ID・パスワードをお忘れの方</a></div>
<hr {$hr_1style}/>
{include file=$preFooter}
</body>
</html>