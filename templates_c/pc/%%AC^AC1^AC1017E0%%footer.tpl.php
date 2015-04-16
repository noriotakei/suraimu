<?php /* Smarty version 2.6.26, created on 2014-08-08 15:49:33
         compiled from /home/suraimu/templates/www/include/footer.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'eval', '/home/suraimu/templates/www/include/footer.tpl', 3, false),)), $this); ?>
<div id="footerWrap">
<div id="footer">
<?php echo smarty_function_eval(array('var' => $this->_tpl_vars['footerMenu']), $this);?>

<p>Copyright (c) <?php echo $this->_tpl_vars['copyright']; ?>
 All Rights Reserved.</p>
</div>
</div>
<a name="down" id="down"></a>
<?php echo $this->_tpl_vars['comImgTag']; ?>