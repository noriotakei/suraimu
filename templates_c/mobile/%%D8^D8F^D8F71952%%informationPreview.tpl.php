<?php /* Smarty version 2.6.26, created on 2014-08-08 18:25:08
         compiled from /home/suraimu/templates/mobile/informationPreview.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'eval', '/home/suraimu/templates/mobile/informationPreview.tpl', 10, false),array('modifier', 'emoji', '/home/suraimu/templates/mobile/informationPreview.tpl', 10, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['preHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</head>

<?php if ($this->_tpl_vars['param']['banner_mb']): ?>
<body <?php echo $this->_tpl_vars['bodyTag']; ?>
>
<div style="font-size:x-small; text-align:left; <?php echo $this->_tpl_vars['limited_width']; ?>
">
<img src="img/title.gif" alt="<?php echo $this->_tpl_vars['siteName']; ?>
" width="100%" />
<?php endif; ?>

<?php echo smarty_function_eval(array('var' => ((is_array($_tmp=$this->_tpl_vars['displayInfoStatusData'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp))), $this);?>


<hr <?php echo $this->_tpl_vars['hr_1style']; ?>
 />

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['preFooter'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>