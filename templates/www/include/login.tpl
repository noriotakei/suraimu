<div id="headerWrap">
<div id="header">
<h1><a href="./" title="{$siteName}">{$siteName}</a></h1>
<h2>当社専属契約情報筋からの独占有力情報！特別に1年間【無料モニター700名】募集</h2>
<div id="login">
<form name="login" action="./?action_LoginChk=1" method="post">
{$comFORMparam}
<dl>
<dt><input id="loginId" type="text" name="login_id" tabindex="1" value="" style="ime-mode:disabled;" /></dt>
<dd>
<input id="loginPass" type="password" name="password" tabindex="2" value="" style="ime-mode:disabled;" />
</dd>
</dl>
<input name="regist" type="image" tabindex="3" onFocus="this.blur()" onMouseOver="this.src='./img/bt_login_on.gif'" onMouseOut="this.src='./img/bt_login.gif'" src="./img/bt_login.gif" class="btLogin" alt="MemberLogin" />
</form><br clear="all" />
<div id="txt"><a href="./?action_PreForget=1{if $comURLparam}&{$comURLparam}{/if}">会員ID・パスワードをお忘れの方</a></div>
</div>
</div>
</div>