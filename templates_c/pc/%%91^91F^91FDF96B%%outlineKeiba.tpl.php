<?php /* Smarty version 2.6.26, created on 2014-08-09 20:27:42
         compiled from /home/suraimu/templates/www/outlineKeiba.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'eval', '/home/suraimu/templates/www/outlineKeiba.tpl', 16, false),array('modifier', 'emoji', '/home/suraimu/templates/www/outlineKeiba.tpl', 16, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['preHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</head>
<body>
<a name="top" id="top"></a>
<div id="headerWrap">
<div id="header">
<div id="logo"><?php echo $this->_tpl_vars['siteName']; ?>
</div>
</div>
</div>
<div id="wrap">
<div id="mainMenu">&nbsp;</div>
<div id="contents2">
<div id="main2">
<div class="mainBox2"><div id="txtFormat">
<div id="titleOutline_keiba">競馬法に基づく表記</div>
<?php echo smarty_function_eval(array('var' => ((is_array($_tmp=$this->_tpl_vars['outlineKeibaData'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp))), $this);?>

<div id="close"><a href="JavaScript:window.self.close()">閉じる</a></div>
</div>
</div>
</div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['blankFooter'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
</body>
</html>