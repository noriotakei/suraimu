<?php /* Smarty version 2.6.26, created on 2014-08-10 10:44:04
         compiled from /home/suraimu/templates/mobile/updateChkPc.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['header'], 'smarty_include_vars' => array()));
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
登録情報の変更
</div>
<hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 />
<span style="color:#fc0;font-size:small;">【変更内容の確認】</span><br />
下記の内容でよろしければ「変更する」ボタンを押して下さい。
<hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 />
<form action="./?action_AddressPreChgExec=1<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>" method="post">
<?php echo $this->_tpl_vars['POSTparam']; ?>

<span style="color:#99ec00;font-size:small;">▼PCメールアドレス</span><br />
<div style="text-align:center;"><?php echo $this->_tpl_vars['param']['pc_mail_address']; ?>
<br /><br /></div>
<br />
<div style="text-align:center;"><input value="変更する" type="submit" /></div>
</form>
<br />
<hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 />
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['footer'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>