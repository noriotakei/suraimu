{include file=$header}
</head>
<body {$bodyTag}>
<a name="top" id="top"></a>
<div style="font-size:x-small; text-align:left; {$limited_width}">
<img src="img/title.gif" alt="{$siteName}" width="100%" />
<div style="text-align:center;">
登録情報の変更
</div>
<hr {$hr_2style} />
<span style="color:#fc0;font-size:small;">【変更内容の確認】</span><br />
下記の内容でよろしければ「変更する」ボタンを押して下さい。
<hr {$hr_2style} />
<form action="./?action_AddressPreChgExec=1{if $comURLparam}&{$comURLparam}{/if}" method="post">
{$POSTparam}
<span style="color:#99ec00;font-size:small;">▼PCメールアドレス</span><br />
<div style="text-align:center;">{$param.pc_mail_address}<br /><br /></div>
<br />
<div style="text-align:center;"><input value="変更する" type="submit" /></div>
</form>
<br />
<hr {$hr_2style} />
{include file=$footer}
</body>
</html>
