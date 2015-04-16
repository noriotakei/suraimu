<h2 class="ContentTitle">{$month|default:""}売り上げ(曜日ごと)</h2>
<div id="tabs">
    <ul>
        <li><a href="./?action_senchaCount_SalesReportDayCalc=1&{$getParam}">集計</a></li>
        <li><a href="./?action_senchaCount_SalesReportDayGraph=1&{$getParam}">グラフ</a></li>
    </ul>
</div>
<script language="JavaScript">
<!--
{literal}
    $("#tabs").tabs({ cache: false });
    $('#tabs').bind('tabsshow', function(event, ui) {
      if (ui.index == 1 && plot._drawCount == 0) {
        plot.replot();
      }
    });
{/literal}
// -->
</script>