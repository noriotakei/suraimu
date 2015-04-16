<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.pieRenderer.min.js"></script>
<script language="JavaScript">
<!--
{literal}
    $.jqplot.config.enablePlugins = false;

    line1 = [{/literal}{$dispPieChartValue}{literal}];
    plot = $.jqplot('pieChart', [line1], {
        height: 400,
        width: 600,
        title: '{/literal}{$month|default:""}{literal}入金割合リスト',
        seriesDefaults:{renderer:$.jqplot.PieRenderer, rendererOptions:{sliceMargin:8}},
        legend:{show:true}
    });
{/literal}
// -->
</script>
{if $total}<div class="jqPlot" id="pieChart" style="height:400px; width: 700px;"></div>{/if}
