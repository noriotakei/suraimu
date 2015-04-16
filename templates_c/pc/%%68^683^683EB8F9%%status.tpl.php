<?php /* Smarty version 2.6.26, created on 2014-08-08 15:49:33
         compiled from /home/suraimu/templates/www/include/status.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'eval', '/home/suraimu/templates/www/include/status.tpl', 5, false),array('modifier', 'emoji', '/home/suraimu/templates/www/include/status.tpl', 5, false),)), $this); ?>
<div id="headerLoginWrap">
<div id="header">
<h1><a href="./?action_Home=1<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>" title="<?php echo $this->_tpl_vars['siteName']; ?>
"><?php echo $this->_tpl_vars['siteName']; ?>
</a></h1>
<div id="status">
<?php echo smarty_function_eval(array('var' => ((is_array($_tmp=$this->_tpl_vars['memberStatus'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp))), $this);?>

</div>
</div>
<div class="clearfix">
    <img src="./img/header_tel.gif" width="880" height="100" alt="サポートセンター" />
</div>
</div>