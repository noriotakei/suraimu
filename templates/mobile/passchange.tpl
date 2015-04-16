{include file=$header}
</head>
<body {$bodyTag}>
<a name="top" id="top"></a>
<div style="font-size:x-small; text-align:left; {$limited_width}">
<img src="img/title.gif" alt="{$siteName}" width="100%" />
<div style="text-align:center;">
パスワードの変更
</div>
<hr {$hr_2style} />
{* 更新時エラーコメント *}
{if $errMsg}<span style="color:#f00;font-size:small;">{$errMsg}</span><br /><hr {$hr_2style} />{/if}
<form action="./?action_PasschangeExec=1{if $comURLparam}&{$comURLparam}{/if}" method="post">
<span style="color:#f00;">{""|emoji}</span><span style="color:ffc000;font-size:small;">現パスワード<br>(半角英数字4桁以上8桁以内)</span><br />
<div style="text-align:center;"><input name="old_password" size="10" value="" style="ime-mode:disabled;" type="password" maxlength="8" /></div>
<span style="color:#f00;">{""|emoji}</span><span style="color:ffc000;font-size:small;">新パスワード<br>(半角英数字4桁以上8桁以内)</span><br />
<div style="text-align:center;"><input name="new_password" size="10" value="" style="ime-mode:disabled;" type="text" maxlength="8"/></div>
<br />
<div style="text-align:center;color:#000;"><input value="変更する" type="submit" /></div>
</form>
<br />
<hr {$hr_2style} />
{include file=$contentsMenu}
{include file=$footerMenu}
{include file=$pr}
{include file=$footer}
</body>
</html>