<?php /* Smarty version 2.6.26, created on 2014-08-08 16:00:17
         compiled from /home/suraimu/templates/www/include/preHeadCampaign.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'eval', '/home/suraimu/templates/www/include/preHeadCampaign.tpl', 2, false),array('modifier', 'emoji', '/home/suraimu/templates/www/include/preHeadCampaign.tpl', 2, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['preTopInfoStatusCampList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['infoCamp']):
?>
    <?php echo smarty_function_eval(array('var' => ((is_array($_tmp=$this->_tpl_vars['infoCamp']['html_text_banner_pc'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp))), $this);?>

<?php endforeach; endif; unset($_from); ?>