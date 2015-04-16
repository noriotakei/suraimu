<?php /* Smarty version 2.6.26, created on 2014-08-14 19:56:07
         compiled from /home/suraimu/templates/mobile/include/quitPr.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'eval', '/home/suraimu/templates/mobile/include/quitPr.tpl', 1, false),array('modifier', 'emoji', '/home/suraimu/templates/mobile/include/quitPr.tpl', 1, false),)), $this); ?>
<?php echo smarty_function_eval(array('var' => ((is_array($_tmp=$this->_tpl_vars['quitPrData'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp))), $this);?>

<?php if ($this->_tpl_vars['quitPrData']): ?><hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 /><?php endif; ?>