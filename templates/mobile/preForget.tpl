{include file=$preHeader}
</head>
<body {$bodyTag}>
<a name="top" id="top"></a>
<div style="font-size:x-small; text-align:left; {$limited_width}">
<img src="img/title.gif" alt="{$siteName}" width="100%" />
<div style="text-align:center;">
ID・パスワードをお忘れの方
</div>
<hr {$hr_1style}/>
{if $errMsg}<span style="color:#f00;font-size:small;">{$errMsg}</span><br /><hr {$hr_1style} />{/if}
<form action="./?action_PreForgetExec=1{if $comURLparam}&{$comURLparam}{/if}" method="post">
<span style="color:#fff;">{""|emoji}</span><span style="color:#ffa50;font-size:small;">登録メールアドレス</span><br />
<div style="text-align:center;color:#000;"><input name="mail_address" size="25" style="ime-mode:disabled;" type="text" /></div>
<br />
<div style="text-align:center;color:#000;"><input value="送信" type="submit" />
</div>
</form>
<hr {$hr_1style}/>
<span style="color:#fc0;font-size:small;">※注意事項</span><br />
・登録メールアドレスを送信するとパスワードが変更されます。<br />
・旧パスワードではログインできなくなります。<br />
<hr {$hr_1style}/>
{include file=$preFooter}
</body>
</html>