<h2 class="ContentTitle">全体売り上げ</h2>
<div id="tabs">
    <ul>
        <li><a href="./?action_senchaCount_SalesReportTotalCalc=1&{$getParam}">集計</a></li>
        <li><a href="./?action_senchaCount_SalesReportTotalGraph=1&{$getParam}">入金金額</a></li>
        <li><a href="./?action_senchaCount_SalesReportTotalUserGraph=1&{$getParam}">入金者数</a></li>
        <li><a href="./?action_senchaCount_SalesReportTotalRateGraph=1&{$getParam}">入金割合</a></li>
    </ul>
</div>
<script language="JavaScript">
<!--
{literal}
    $("#tabs").tabs({ cache: false });
    $('#tabs').bind('tabsshow', function(event, ui) {
      if (ui.index == 1 && plot._drawCount == 0) {
        plot.replot();
      } else if (ui.index == 2 && plot2._drawCount == 0) {
        plot2.replot();
      } else if (ui.index == 3 && plot3._drawCount == 0) {
        plot3.replot();
      }
    });
{/literal}
// -->
</script>