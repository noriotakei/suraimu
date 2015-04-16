<?php /* Smarty version 2.6.26, created on 2014-08-08 17:47:57
         compiled from /home/suraimu/templates/mobile/update.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', '/home/suraimu/templates/mobile/update.tpl', 25, false),array('modifier', 'emoji', '/home/suraimu/templates/mobile/update.tpl', 26, false),array('function', 'html_options', '/home/suraimu/templates/mobile/update.tpl', 31, false),)), $this); ?>
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
<?php if ($this->_tpl_vars['errMsg']): ?><span style="color:#f00;font-size:small;"><?php echo $this->_tpl_vars['errMsg']; ?>
</span><br /><hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 /><?php endif; ?>
<form action="./?action_UpdateChkPc=1<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>" method="post">
<span style="color:#99ec00;font-size:small;">▼PCﾒｰﾙｱﾄﾞﾚｽの登録と変更</span><br />
<div style="text-align:center;">
<?php if (! $this->_tpl_vars['comUserData']['pc_address']): ?>
<span style="color:#f00;"><blink>PCｱﾄﾞﾚｽ登録で20ptGET!</blink></span><br />
<?php endif; ?>
<input name="pc_mail_address" size="20" type="text" value="<?php echo $this->_tpl_vars['comUserData']['pc_address']; ?>
"/><br /><br />
<input name="submit" type="submit" value="登録・変更する" /><br /><br />
</div>
</form>
<hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 />
<form action="./?action_UpdateExec=1<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>" method="post">
<span style="color:#99ec00;font-size:small;">▼携帯メールアドレス</span><br />
<div style="text-align:center;"><?php echo ((is_array($_tmp=@$this->_tpl_vars['comUserData']['mb_address'])) ? $this->_run_mod_handler('default', true, $_tmp, "未登録") : smarty_modifier_default($_tmp, "未登録")); ?>
<br /><br /></div>
<div style="text-align:center;"><span style="color:#fff;"><?php echo ((is_array($_tmp="")) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>
</span><a href="mailto:<?php echo $this->_tpl_vars['mailto']; ?>
">メールアドレス変更はこちら!</a><br /><br /></div>
<hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 />
<?php if ($this->_tpl_vars['comUserData']['mb_address']): ?>
<span style="color:#99ec00;font-size:small;">▼携帯メールの配信の変更</span><br />
<div style="text-align:center;color:#000;">
<?php echo smarty_function_html_options(array('name' => 'mb_is_mailmagazine','options' => $this->_tpl_vars['config']['web_config']['address_send_status'],'selected' => $this->_tpl_vars['comUserData']['mb_is_mailmagazine'],'style' => "color:#000;font-size:x-small;"), $this);?>

<br /><br /></div>
<?php endif; ?>
<?php if ($this->_tpl_vars['comUserData']['pc_address']): ?>
<span style="color:#99ec00;font-size:small;">▼PCメールの配信の変更</span><br />
<div style="text-align:center;color:#000;">
<?php echo smarty_function_html_options(array('name' => 'pc_is_mailmagazine','options' => $this->_tpl_vars['config']['web_config']['address_send_status'],'selected' => $this->_tpl_vars['comUserData']['pc_is_mailmagazine'],'style' => "color:#000;font-size:x-small;"), $this);?>

<br /><br /></div>
<?php endif; ?>
<div style="text-align:center;color:#000;"><input value="変更内容の確認" type="submit" /></div>
</form>
<hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 />
<span style="color:#99ec00;font-size:small;">▼ポイント数</span><br />
<div style="text-align:center;"><?php echo $this->_tpl_vars['comUserData']['point']; ?>
 PT<br /><br /></div>
<span style="color:#99ec00;font-size:small;">▼会員ID</span><br />
<div style="text-align:center;"><?php echo $this->_tpl_vars['comUserData']['login_id']; ?>
<br /><br /></div>
<span style="color:#99ec00;font-size:small;">▼パスワード変更</span><br />
<div style="text-align:center;"><span style="color:#f00;"><?php echo ((is_array($_tmp="")) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>
</span><a href="./?action_Passchange=1<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>">パスワード変更はこちら!</a><br /><br /></div>
<br />
<hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 />
<span style="color:#fc0;font-size:small;">※注意事項</span><br />
・携帯メールアドレスの変更は空メール送信のみで完了いたします。<br />
・変更するメールアドレスとログインIDが同じなら、ログインIDも変更されます。<br />
・配信の変更をされると「お得なキャンペーン情報」をお届けできなくなります。<br />
<hr <?php echo $this->_tpl_vars['hr_1style']; ?>
 />
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['contentsMenu'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['footerMenu'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['pr'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['footer'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>