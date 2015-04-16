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
<div id="titleUpdate">登録情報の変更</div>
{if $errMsg}
    <p class="err">{$errMsg}</p>
{/if}
<form action="./?action_AddressPreChgExec=1" method="post">
{$comFORMparam}
<dl><dt>PCメールアドレス</dt></dl>
<div id="formBg">
<div id="formIn">
<div id="formLeft">
<input name="pc_mail_account" type="text" id="mail_id1" tabindex="7" value="{$value.pc_mail_account}" style="ime-mode:disabled;" />＠<input name="pc_mail_domain" type="text" id="mail_id2" tabindex="8" value="{$value.pc_mail_domain}" style="ime-mode:disabled;" />
</div>
<input id="formRight" name="regist3" type="image" tabindex="9" onFocus="this.blur()" onMouseOver="this.src='./img/bt_update_on.png'" onMouseOut="this.src='./img/bt_update.png'" src="./img/bt_update.png" alt="更新する" />
<br clear="all" />
</div>
</div>
</form>
<form action="./?action_AddressPreChgExec=1" method="post">
{$comFORMparam}
 <dl><dt>携帯メールアドレス</dt></dl>
<div id="formBg">
<div id="formIn">
<div id="formLeft">
<input name="mb_mail_account" type="text" id="mail_id1" tabindex="10" value="{$value.mb_mail_account}" style="ime-mode:disabled;" />＠<input name="mb_mail_domain" type="text" id="mail_id2" tabindex="11" value="{$value.mb_mail_domain}" style="ime-mode:disabled;" />
</div>
<input id="formRight" name="regist3" type="image" tabindex="12" onFocus="this.blur()" onMouseOver="this.src='./img/bt_update_on.png'" onMouseOut="this.src='./img/bt_update.png'" src="./img/bt_update.png" alt="更新する" />
<br clear="all" />
</div>
</div>
</form>
<form action="./?action_UpdateSendStatusExec=1" method="post">
{$comFORMparam}
<dl><dt>配信の変更</dt></dl>
<div id="formBg">
<div id="formIn">
<div id="formLeft">
{if $comUserData.pc_address}
PC：{html_options name="pc_is_mailmagazine" options=$config.web_config.address_send_status selected=$comUserData.pc_is_mailmagazine  tabindex="13"}
{/if}
{if $comUserData.mb_address}
    &nbsp;&nbsp;携帯：{html_options name="mb_is_mailmagazine" options=$config.web_config.address_send_status selected=$comUserData.mb_is_mailmagazine  tabindex="14"}
{/if}
</div>
<input id="formRight" name="regist32" type="image" tabindex="15" style="text-align:center;" onFocus="this.blur()" onMouseOver="this.src='./img/bt_update_on.png'" onMouseOut="this.src='./img/bt_update.png'" src="./img/bt_update.png" alt="更新する" />
<br clear="all" />
</div>
</div>
</form>
<form action="./?action_UpdatePasswordChk=1" method="post">
{$comFORMparam}
<dl><dt>パスワード変更(半角英数字4桁以上8桁以内)</dt></dl>
<div id="formBg">
<div id="formIn">
現パスワード：<input name="old_password" size="4" style="ime-mode:disabled;" type="text" tabindex="16" id="loginId" maxlength="8" /><br /><br />
新パスワード：<input name="new_password" size="4" style="ime-mode:disabled;" type="text" tabindex="17" id="loginId" maxlength="8" />
<p id="centerP">
<input name="regist3" type="image" tabindex="18" onFocus="this.blur()" onMouseOver="this.src='./img/bt_update_on.png'" onMouseOut="this.src='./img/bt_update.png'" src="./img/bt_update.png" alt="更新する" />
</p>
</div>
</div>
</form>
<br />
<span class="attention">※注意事項</span><br />
・配信の変更をされると「お得なキャンペーン情報」をお届けできなくなります。<br />
</div>
</div>
{include file=$side}
</div>
{include file=$footer}
</div>
</body>
</html>