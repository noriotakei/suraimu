<?php /* Smarty version 2.6.26, created on 2014-08-08 16:44:38
         compiled from /home/suraimu/templates/mobile/home.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'eval', '/home/suraimu/templates/mobile/home.tpl', 18, false),array('modifier', 'emoji', '/home/suraimu/templates/mobile/home.tpl', 18, false),)), $this); ?>
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

<img src="img/header.gif" alt="<?php echo $this->_tpl_vars['siteName']; ?>
" width="100%" />

<div style="text-align:center; background-color:#050; color:#cf0;">高配当ｻﾎﾟｰﾄｾﾝﾀｰ</div>
<div>
<a href="tel:0570011180"><img src="img/header_tel_kh.gif" width="100%" alt="ｻﾎﾟｰﾄｾﾝﾀｰ" /></a>
</div>

<div style="text-align:center;"><blink>↓</blink>本物の情報だけ厳選公開中<blink>↓</blink></div>

<?php if ($this->_tpl_vars['dispInformationList']): ?>
    <?php $_from = $this->_tpl_vars['dispInformationList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
        <?php echo smarty_function_eval(array('var' => ((is_array($_tmp=$this->_tpl_vars['val']['html_text_banner_mb'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp))), $this);?>

    <?php endforeach; endif; unset($_from); ?>
<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['contentsMenu'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['status'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['footerMenu'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<table width="96%" border="0" align="center" cellpadding="2" cellspacing="0">
<tr>
<td align="right"><span style="font-size:x-small;"><a href="#top" accesskey="2">PageUp▲<?php echo ((is_array($_tmp="")) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>
</a><br /><a href="#down" accesskey="8">PageDown▼<?php echo ((is_array($_tmp="")) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>
</a></span></td>
</tr>
</table>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['copylight'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo $this->_tpl_vars['comImgTag']; ?>

</body>
</html>