<?php /* Smarty version 2.6.26, created on 2014-08-08 17:47:57
         compiled from /home/suraimu/templates/mobile/include/pr.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'eval', '/home/suraimu/templates/mobile/include/pr.tpl', 1, false),array('modifier', 'emoji', '/home/suraimu/templates/mobile/include/pr.tpl', 1, false),)), $this); ?>
<?php echo smarty_function_eval(array('var' => ((is_array($_tmp=$this->_tpl_vars['prData'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp))), $this);?>

<?php if ($this->_tpl_vars['prData']): ?><hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 /><?php endif; ?>