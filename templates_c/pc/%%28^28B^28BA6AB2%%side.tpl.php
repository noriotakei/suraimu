<?php /* Smarty version 2.6.26, created on 2014-08-08 15:49:33
         compiled from /home/suraimu/templates/www/include/side.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'eval', '/home/suraimu/templates/www/include/side.tpl', 3, false),array('modifier', 'emoji', '/home/suraimu/templates/www/include/side.tpl', 3, false),)), $this); ?>
<div id="side" class="clearfix">
<?php $_from = $this->_tpl_vars['postSideInfoStatusList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['postInfoSide']):
?>
    <?php echo smarty_function_eval(array('var' => ((is_array($_tmp=$this->_tpl_vars['postInfoSide']['html_text_banner_pc'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp))), $this);?>

<?php endforeach; endif; unset($_from); ?>
<div class="clear"><a href="#top">▲PageUp</a></div>
</div>