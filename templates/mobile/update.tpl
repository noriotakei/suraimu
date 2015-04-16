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
{if $errMsg}<span style="color:#f00;font-size:small;">{$errMsg}</span><br /><hr {$hr_2style} />{/if}
<form action="./?action_UpdateChkPc=1{if $comURLparam}&{$comURLparam}{/if}" method="post">
<span style="color:#99ec00;font-size:small;">▼PCﾒｰﾙｱﾄﾞﾚｽの登録と変更</span><br />
<div style="text-align:center;">
{if !$comUserData.pc_address}
<span style="color:#f00;"><blink>PCｱﾄﾞﾚｽ登録で20ptGET!</blink></span><br />
{/if}
<input name="pc_mail_address" size="20" type="text" value="{$comUserData.pc_address}"/><br /><br />
<input name="submit" type="submit" value="登録・変更する" /><br /><br />
</div>
</form>
<hr {$hr_2style} />
<form action="./?action_UpdateExec=1{if $comURLparam}&{$comURLparam}{/if}" method="post">
<span style="color:#99ec00;font-size:small;">▼携帯メールアドレス</span><br />
<div style="text-align:center;">{$comUserData.mb_address|default:"未登録"}<br /><br /></div>
<div style="text-align:center;"><span style="color:#fff;">{""|emoji}</span><a href="mailto:{$mailto}">メールアドレス変更はこちら!</a><br /><br /></div>
<hr {$hr_2style} />
{if $comUserData.mb_address}
<span style="color:#99ec00;font-size:small;">▼携帯メールの配信の変更</span><br />
<div style="text-align:center;color:#000;">
{html_options name="mb_is_mailmagazine" options=$config.web_config.address_send_status selected=$comUserData.mb_is_mailmagazine  style="color:#000;font-size:x-small;"}
<br /><br /></div>
{/if}
{if $comUserData.pc_address}
<span style="color:#99ec00;font-size:small;">▼PCメールの配信の変更</span><br />
<div style="text-align:center;color:#000;">
{html_options name="pc_is_mailmagazine" options=$config.web_config.address_send_status selected=$comUserData.pc_is_mailmagazine  style="color:#000;font-size:x-small;"}
<br /><br /></div>
{/if}
<div style="text-align:center;color:#000;"><input value="変更内容の確認" type="submit" /></div>
</form>
<hr {$hr_2style} />
<span style="color:#99ec00;font-size:small;">▼ポイント数</span><br />
<div style="text-align:center;">{$comUserData.point} PT<br /><br /></div>
<span style="color:#99ec00;font-size:small;">▼会員ID</span><br />
<div style="text-align:center;">{$comUserData.login_id}<br /><br /></div>
<span style="color:#99ec00;font-size:small;">▼パスワード変更</span><br />
<div style="text-align:center;"><span style="color:#f00;">{""|emoji}</span><a href="./?action_Passchange=1{if $comURLparam}&{$comURLparam}{/if}">パスワード変更はこちら!</a><br /><br /></div>
<br />
<hr {$hr_2style} />
<span style="color:#fc0;font-size:small;">※注意事項</span><br />
・携帯メールアドレスの変更は空メール送信のみで完了いたします。<br />
・変更するメールアドレスとログインIDが同じなら、ログインIDも変更されます。<br />
・配信の変更をされると「お得なキャンペーン情報」をお届けできなくなります。<br />
<hr {$hr_1style} />
{include file=$contentsMenu}
{include file=$footerMenu}
{include file=$pr}
{include file=$footer}
</body>
</html>