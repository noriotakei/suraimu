<?php /* Smarty version 2.6.26, created on 2014-08-08 16:00:17
         compiled from /home/suraimu/templates/www/include/preFooter.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'eval', '/home/suraimu/templates/www/include/preFooter.tpl', 3, false),)), $this); ?>
<div id="footerWrap">
<div id="footer">
<?php echo smarty_function_eval(array('var' => $this->_tpl_vars['footerMenu']), $this);?>

<p>Copyright (c) <?php echo $this->_tpl_vars['copyright']; ?>
 All Rights Reserved.</p>
</div>
</div>
<a name="down" id="down"></a>