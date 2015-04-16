<?php /* Smarty version 2.6.26, created on 2014-08-09 15:43:11
         compiled from /home/suraimu/templates/admin/senchaCount/activeUser.tpl */ ?>
<h2 class="ContentTitle">アクティブ会員リスト</h2>
<div id="tabs">
    <ul>
        <li><a href="./?action_senchaCount_ActiveUserCalc=1&<?php echo $this->_tpl_vars['getParam']; ?>
">集計</a></li>
        <li><a href="./?action_senchaCount_ActiveUserGraph=1&<?php echo $this->_tpl_vars['getParam']; ?>
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