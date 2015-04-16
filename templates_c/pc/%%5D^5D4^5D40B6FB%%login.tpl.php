<?php /* Smarty version 2.6.26, created on 2014-08-08 16:00:17
         compiled from /home/suraimu/templates/www/include/login.tpl */ ?>
<div id="headerWrap">
<div id="header">
<h1><a href="./" title="<?php echo $this->_tpl_vars['siteName']; ?>
"><?php echo $this->_tpl_vars['siteName']; ?>
</a></h1>
<h2>当社専属契約情報筋からの独占有力情報！特別に1年間【無料モニター700名】募集</h2>
<div id="login">
<form name="login" action="./?action_LoginChk=1" method="post">
<?php echo $this->_tpl_vars['comFORMparam']; ?>

<dl>
<dt><input id="loginId" type="text" name="login_id" tabindex="1" value="" style="ime-mode:disabled;" /></dt>
<dd>
<input id="loginPass" type="password" name="password" tabindex="2" value="" style="ime-mode:disabled;" />
</dd>
</dl>
<input name="regist" type="image" tabindex="3" onFocus="this.blur()" onMouseOver="this.src='./img/bt_login_on.gif'" onMouseOut="this.src='./img/bt_login.gif'" src="./img/bt_login.gif" class="btLogin" alt="MemberLogin" />
</form><br clear="all" />
<div id="txt"><a href="./?action_PreForget=1<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>">会員ID・パスワードをお忘れの方</a></div>
</div>
</div>
</div>