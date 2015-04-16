<?php /* Smarty version 2.6.26, created on 2014-08-08 17:23:34
         compiled from /home/suraimu/templates/mobile/include/preRuleFooter.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'emoji', '/home/suraimu/templates/mobile/include/preRuleFooter.tpl', 1, false),)), $this); ?>
<span style="font-size:x-small;"><span style="color:#f00;"><?php echo ((is_array($_tmp="")) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>
</span>携帯の戻るﾎﾞﾀﾝでお戻り下さい</span><br>
<table width="96%" border="0" align="center" cellpadding="2" cellspacing="0">
<td align="right"><span style="font-size:x-small;"><a href="#top" accesskey="2">PageUp▲<?php echo ((is_array($_tmp="")) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>
</a><br /><a href="#down" accesskey="8">PageDown▼<?php echo ((is_array($_tmp="")) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>
</a></span>
</td>
</tr>
</table>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['preCopylight'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>