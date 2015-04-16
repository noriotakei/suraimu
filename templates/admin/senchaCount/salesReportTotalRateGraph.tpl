<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.barRenderer.min.js"></script>
<script language="JavaScript">
<!--
{literal}
        $.jqplot.config.enablePlugins = false;

        {/literal}
            {foreach from=$jsDispDataList key="jsDispDataListKey" item="jsDispDataListVal" name="jsDispDataListLoop"}
                {$jsDispDataListKey} = [{$jsDispDataListVal}];
            {/foreach}
        {literal}
        xticks = [{/literal}{$jsMonthList}{literal}];
        var plot3 = $.jqplot('barChart', [{/literal}{$jsPaymentKeyList}{literal}], {
            height:800,
            width:900,
            stackSeries: true,
            legend:{show:true, location:'ne'},
            title:'入金割合(%)',
            seriesDefaults: {renderer: $.jqplot.BarRenderer,rendererOptions: {barWidth: 50}},
            series:[{/literal}{$jsDispLabelList}{literal}],
            axes:{
                    xaxis:{
                    renderer: $.jqplot.CategoryAxisRenderer,
                    tickRenderer: $.jqplot.CanvasAxisTickRenderer,
                    tickOptions: {
                            angle: -30
                          },
                    ticks:xticks
                    },
                    yaxis: {
                        label: '入金割合(%)',
                        min:0,
                        max:100,
                        numberTicks:11
                    }
                }
        });
{/literal}
// -->
</script>
<div class="jqPlot" id="barChart" style="height:800px; width:800px;"></div>
