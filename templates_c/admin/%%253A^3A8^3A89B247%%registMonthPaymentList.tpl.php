<?php /* Smarty version 2.6.26, created on 2014-08-15 10:01:40
         compiled from /home/suraimu/templates/admin/senchaCount/registMonthPaymentList.tpl */ ?>
<h2 class="ContentTitle">当月登録入金者</h2>
<div id="tabs">
    <ul>
        <li><a href="./?action_senchaCount_RegistMonthPaymentListCalc=1&<?php echo $this->_tpl_vars['getParam']; ?>
">集計</a></li>
        <li><a href="./?action_senchaCount_RegistMonthPaymentListUserGraph=1&<?php echo $this->_tpl_vars['getParam']; ?>
">入金者グラフ</a></li>
        <li><a href="./?action_senchaCount_RegistMonthPaymentListPayGraph=1&<?php echo $this->_tpl_vars['getParam']; ?>
">入金金額グラフ</a></li>
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
      if (ui.index == 2 && plot2._drawCount == 0) {
        plot2.replot();
      }
    });
'; ?>

// -->
</script>
