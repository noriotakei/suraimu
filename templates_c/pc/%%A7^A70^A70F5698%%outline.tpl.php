<?php /* Smarty version 2.6.26, created on 2014-08-08 21:08:03
         compiled from /home/suraimu/templates/www/outline.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'eval', '/home/suraimu/templates/www/outline.tpl', 17, false),array('modifier', 'emoji', '/home/suraimu/templates/www/outline.tpl', 17, false),)), $this); ?>
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
<div id="titleOutline">特定商取引法による表記</div>
<?php echo smarty_function_eval(array('var' => ((is_array($_tmp=$this->_tpl_vars['outLineData'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp))), $this);?>

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