<?php /* Smarty version 2.6.26, created on 2014-08-08 16:06:54
         compiled from /home/suraimu/templates/www/update.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', '/home/suraimu/templates/www/update.tpl', 48, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['header'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</head>
<body>
<a name="top" id="top"></a>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['status'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><div id="wrap">
<div id="imageArea"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['headCampaign'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['headerMenu'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="contents">
<div id="main">
<div class="mainBox">
<div id="titleUpdate">登録情報の変更</div>
<?php if ($this->_tpl_vars['errMsg']): ?>
    <p class="err"><?php echo $this->_tpl_vars['errMsg']; ?>
</p>
<?php endif; ?>
<form action="./?action_AddressPreChgExec=1" method="post">
<?php echo $this->_tpl_vars['comFORMparam']; ?>

<dl><dt>PCメールアドレス</dt></dl>
<div id="formBg">
<div id="formIn">
<div id="formLeft">
<input name="pc_mail_account" type="text" id="mail_id1" tabindex="7" value="<?php echo $this->_tpl_vars['value']['pc_mail_account']; ?>
" style="ime-mode:disabled;" />＠<input name="pc_mail_domain" type="text" id="mail_id2" tabindex="8" value="<?php echo $this->_tpl_vars['value']['pc_mail_domain']; ?>
" style="ime-mode:disabled;" />
</div>
<input id="formRight" name="regist3" type="image" tabindex="9" onFocus="this.blur()" onMouseOver="this.src='./img/bt_update_on.png'" onMouseOut="this.src='./img/bt_update.png'" src="./img/bt_update.png" alt="更新する" />
<br clear="all" />
</div>
</div>
</form>
<form action="./?action_AddressPreChgExec=1" method="post">
<?php echo $this->_tpl_vars['comFORMparam']; ?>

 <dl><dt>携帯メールアドレス</dt></dl>
<div id="formBg">
<div id="formIn">
<div id="formLeft">
<input name="mb_mail_account" type="text" id="mail_id1" tabindex="10" value="<?php echo $this->_tpl_vars['value']['mb_mail_account']; ?>
" style="ime-mode:disabled;" />＠<input name="mb_mail_domain" type="text" id="mail_id2" tabindex="11" value="<?php echo $this->_tpl_vars['value']['mb_mail_domain']; ?>
" style="ime-mode:disabled;" />
</div>
<input id="formRight" name="regist3" type="image" tabindex="12" onFocus="this.blur()" onMouseOver="this.src='./img/bt_update_on.png'" onMouseOut="this.src='./img/bt_update.png'" src="./img/bt_update.png" alt="更新する" />
<br clear="all" />
</div>
</div>
</form>
<form action="./?action_UpdateSendStatusExec=1" method="post">
<?php echo $this->_tpl_vars['comFORMparam']; ?>

<dl><dt>配信の変更</dt></dl>
<div id="formBg">
<div id="formIn">
<div id="formLeft">
<?php if ($this->_tpl_vars['comUserData']['pc_address']): ?>
PC：<?php echo smarty_function_html_options(array('name' => 'pc_is_mailmagazine','options' => $this->_tpl_vars['config']['web_config']['address_send_status'],'selected' => $this->_tpl_vars['comUserData']['pc_is_mailmagazine'],'tabindex' => '13'), $this);?>

<?php endif; ?>
<?php if ($this->_tpl_vars['comUserData']['mb_address']): ?>
    &nbsp;&nbsp;携帯：<?php echo smarty_function_html_options(array('name' => 'mb_is_mailmagazine','options' => $this->_tpl_vars['config']['web_config']['address_send_status'],'selected' => $this->_tpl_vars['comUserData']['mb_is_mailmagazine'],'tabindex' => '14'), $this);?>

<?php endif; ?>
</div>
<input id="formRight" name="regist32" type="image" tabindex="15" style="text-align:center;" onFocus="this.blur()" onMouseOver="this.src='./img/bt_update_on.png'" onMouseOut="this.src='./img/bt_update.png'" src="./img/bt_update.png" alt="更新する" />
<br clear="all" />
</div>
</div>
</form>
<form action="./?action_UpdatePasswordChk=1" method="post">
<?php echo $this->_tpl_vars['comFORMparam']; ?>

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
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['side'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['footer'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
</body>
</html>