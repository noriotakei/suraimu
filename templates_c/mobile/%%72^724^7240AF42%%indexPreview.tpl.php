<?php /* Smarty version 2.6.26, created on 2014-08-23 13:01:33
         compiled from /home/suraimu/templates/mobile/indexPreview.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'eval', '/home/suraimu/templates/mobile/indexPreview.tpl', 4, false),array('modifier', 'emoji', '/home/suraimu/templates/mobile/indexPreview.tpl', 4, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['preHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</head>

<?php echo smarty_function_eval(array('var' => ((is_array($_tmp=$this->_tpl_vars['registPageData']['page_html_mb'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp))), $this);?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['preContentsMenu'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['easyLogin'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['preFooterMenu'], 'smarty_include_vars' => array()));
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
<img src="img/copyright.gif" alt="copyright" width="100%" />
</div>
<a name="down" id="down"></a>
</body>
</html>