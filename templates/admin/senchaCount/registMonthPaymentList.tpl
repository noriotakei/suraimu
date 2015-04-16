<h2 class="ContentTitle">当月登録入金者</h2>
<div id="tabs">
    <ul>
        <li><a href="./?action_senchaCount_RegistMonthPaymentListCalc=1&{$getParam}">集計</a></li>
        <li><a href="./?action_senchaCount_RegistMonthPaymentListUserGraph=1&{$getParam}">入金者グラフ</a></li>
        <li><a href="./?action_senchaCount_RegistMonthPaymentListPayGraph=1&{$getParam}">入金金額グラフ</a></li>
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
      if (ui.index == 2 && plot2._drawCount == 0) {
        plot2.replot();
      }
    });
{/literal}
// -->
</script>

