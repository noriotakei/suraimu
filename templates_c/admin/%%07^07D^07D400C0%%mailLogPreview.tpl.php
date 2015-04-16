<?php /* Smarty version 2.6.26, created on 2014-08-09 10:11:37
         compiled from /home/suraimu/templates/admin/mailLog/mailLogPreview.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'emoji', '/home/suraimu/templates/admin/mailLog/mailLogPreview.tpl', 1, false),)), $this); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['html_body'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>
