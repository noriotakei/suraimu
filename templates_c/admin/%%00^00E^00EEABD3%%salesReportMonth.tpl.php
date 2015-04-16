<?php /* Smarty version 2.6.26, created on 2014-08-08 16:59:42
         compiled from /home/suraimu/templates/admin/senchaCount/salesReportMonth.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', '/home/suraimu/templates/admin/senchaCount/salesReportMonth.tpl', 1, false),)), $this); ?>
<h2 class="ContentTitle"><?php echo ((is_array($_tmp=@$this->_tpl_vars['month'])) ? $this->_run_mod_handler('default', true, $_tmp, "") : smarty_modifier_default($_tmp, "")); ?>
売り上げ(月毎)</h2>
<div id="tabs">
    <ul>
        <li><a href="./?action_senchaCount_SalesReportMonthCalc=1&<?php echo $this->_tpl_vars['getParam']; ?>
">集計</a></li>
        <li><a href="./?action_senchaCount_SalesReportMonthGraph=1&<?php echo $this->_tpl_vars['getParam']; ?>
">グラフ</a></li>
    </ul>
</div>
<script language="JavaScript">
<!--
<?php echo '
    $("#tabs").tabs({ cache: false });
    $(\'#tabs\').bind(\'tabsshow\', function(event, ui) {
      if (ui.index == 1 && plot._drawCount == 0) {
        plot.replot();
      }
    });
'; ?>

// -->
</script>