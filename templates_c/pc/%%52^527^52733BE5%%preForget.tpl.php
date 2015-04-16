<?php /* Smarty version 2.6.26, created on 2014-08-09 11:54:47
         compiled from /home/suraimu/templates/www/preForget.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['preHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</head>
<body>
<a name="top" id="top"></a>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['loginForm'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="wrap">
<div id="imageArea"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['preHeadCampaign'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['preHeaderMenu'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="contents">
<div id="main">
<div class="mainBox">
<div id="titleForget">会員ID/パスワード再送</div>
<?php if ($this->_tpl_vars['errMsg']): ?>
    <p class="err"><?php echo $this->_tpl_vars['errMsg']; ?>
</p>
<?php endif; ?>
<form action="./?action_PreForgetExec=1" method="post">
<?php echo $this->_tpl_vars['comFORMparam']; ?>

<p>パスワードをお忘れの方は、ご登録のメールアドレスを下記フォームに入力して「送信」ボタンを押して下さい。折り返しご登録のメールアドレスにパスワードを送信致します。</p>
<dl>
<dt>ご登録のメールアドレス</dt>
<div id="formBg">
<div id="formIn"><input name="mail_account" type="text" id="mailCustomer" tabindex="7" value="<?php echo $this->_tpl_vars['value']['mail_account']; ?>
" style="ime-mode:disabled;" />＠<input name="mail_domain" type="text" id="mailCustomer" tabindex="8" value="<?php echo $this->_tpl_vars['value']['mail_domain']; ?>
" style="ime-mode:disabled;" /></div>
</div>
</dl>
<p id="centerP">
<input name="regist22" type="image" tabindex="9" onFocus="this.blur()" onMouseOver="this.src='./img/bt_forget_on.png'" onMouseOut="this.src='./img/bt_forget.png'" src="./img/bt_forget.png" alt="送信" />
</p>
</form>
</div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['preSide'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['preFooter'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
</body>
</html>