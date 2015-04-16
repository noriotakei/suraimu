<?php /* Smarty version 2.6.26, created on 2014-08-09 09:45:09
         compiled from /home/suraimu/templates/www/customer.tpl */ ?>
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
<div id="titleCustomer">お問い合わせ</div>
<div id="txtCustomer">当サイトへのお問い合わせ・ご意見はこちらから！皆様からお寄せいただきますご質問・ご意見は、より良いサービスに生かしていける様、努力してまいります。</div>
<?php if ($this->_tpl_vars['errMsg']): ?>
    <p class="err"><?php echo $this->_tpl_vars['errMsg']; ?>
</p>
<?php endif; ?>
<form action="./?action_CustomerExec=1" name="customer" method="post">
<?php echo $this->_tpl_vars['comFORMparam']; ?>

<dl>
<dt>返信をご希望するメールアドレス</dt>
<div id="formBg">
<div id="formIn">
<input name="mail_account" type="text" id="mailCustomer" tabindex="7" value="<?php echo $this->_tpl_vars['value']['mail_account']; ?>
" style="ime-mode:disabled;" />＠<input name="mail_domain" type="text" id="mailCustomer" tabindex="8" value="<?php echo $this->_tpl_vars['value']['mail_domain']; ?>
" style="ime-mode:disabled;" />
</div>
</div>
<dt>お問い合わせ内容</dt>
<div id="formBg">
<div id="formIn">
<textarea name="message" rows="5" cols="10" tabindex="9" id="areaCustomer"><?php echo $this->_tpl_vars['value']['message']; ?>
</textarea>
</div>
</div>
</dl>
<p id="centerP">
<input name="regist3" type="image" tabindex="10" style="text-align:center;" onFocus="this.blur()" onMouseOver="this.src='./img/bt_customer_on.png'" onMouseOut="this.src='./img/bt_customer.png'" src="./img/bt_customer.png" alt="お問い合わせを送信" />
</p>
</form>
<div id="customer">カスタマーサポート</div>
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