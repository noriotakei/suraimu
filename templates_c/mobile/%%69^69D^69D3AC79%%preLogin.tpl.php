<?php /* Smarty version 2.6.26, created on 2014-08-08 18:03:49
         compiled from /home/suraimu/templates/mobile/preLogin.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'emoji', '/home/suraimu/templates/mobile/preLogin.tpl', 14, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['preHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</head>
<body <?php echo $this->_tpl_vars['bodyTag']; ?>
>
<a name="top" id="top"></a>
<div style="font-size:x-small; text-align:left; <?php echo $this->_tpl_vars['limited_width']; ?>
">
<img src="img/title.gif" alt="<?php echo $this->_tpl_vars['siteName']; ?>
" width="100%" />
<div style="text-align:center;">
メンバーログイン
</div>

<hr <?php echo $this->_tpl_vars['hr_1style']; ?>
/>
<?php if ($this->_tpl_vars['errMsg']): ?><span style="color:#f00;font-size:small;"><?php echo $this->_tpl_vars['errMsg']; ?>
</span><br /><hr <?php echo $this->_tpl_vars['hr_1style']; ?>
 /><?php endif; ?>
<form action="./?action_LoginChk=1<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>" method="post">
<span style="color:#f00;"><?php echo ((is_array($_tmp="")) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>
</span><span style="color:#ffa50;font-size:small;">会員ID</span><br />
<div style="text-align:center;"><input name="login_id" size="20" style="ime-mode:disabled;" type="text" /></div>
<span style="color:#f00;"><?php echo ((is_array($_tmp="")) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>
</span><span style="color:ffc000;font-size:small;">パスワード(半角英数字)</span><br />
<div style="text-align:center;"><input name="password" size="10" value="" style="ime-mode:disabled;" type="password" /></div>
<br />
<div style="text-align:center;color:#000;"><input value="ログイン" type="submit" />
</div>
</form>
<hr <?php echo $this->_tpl_vars['hr_1style']; ?>
/>
<div style="text-align:right;"><a href="./?action_PreForget=1<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>">ID・パスワードをお忘れの方</a></div>
<hr <?php echo $this->_tpl_vars['hr_1style']; ?>
/>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['preFooter'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>