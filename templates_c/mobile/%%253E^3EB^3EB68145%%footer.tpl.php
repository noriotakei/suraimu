<?php /* Smarty version 2.6.26, created on 2014-08-08 16:47:03
         compiled from /home/suraimu/templates/mobile/include/footer.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'emoji', '/home/suraimu/templates/mobile/include/footer.tpl', 3, false),)), $this); ?>
<table width="96%" border="0" align="center" cellpadding="2" cellspacing="0">
<tr>
<td align="left" valign="bottom"><span style="font-size:x-small;"><span style="color:#f00;"><?php echo ((is_array($_tmp="")) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>
</span><a href="./?action_Home=1<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>" accesskey="0">HOME<?php echo ((is_array($_tmp="")) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>
</a></span></td>
<td align="right"><span style="font-size:x-small;"><a href="#top" accesskey="2">PageUp▲<?php echo ((is_array($_tmp="")) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>
</a><br /><a href="#down" accesskey="8">PageDown▼<?php echo ((is_array($_tmp="")) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>
</a></span></td>
</tr>
</table>
<?php echo $this->_tpl_vars['comImgTag']; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['copylight'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>