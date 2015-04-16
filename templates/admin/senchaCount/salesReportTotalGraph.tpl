<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
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
        var plot = $.jqplot('lineChart', [{/literal}{$jsPaymentKeyList}{literal}], {
            height:800,
            width:900,
            legend:{show:true},
            title:'入金金額',
            series:[{/literal}{$jsDispLabelList}{literal}],
            axes:{
                    xaxis:{
                    renderer: $.jqplot.CategoryAxisRenderer,
                    tickRenderer: $.jqplot.CanvasAxisTickRenderer,
                    tickOptions: {
                            angle: -50,
                            formatString:'%d'
                          },
                    ticks:xticks
                    },
                    yaxis: {
                        label: '金額',
                        autoscale:true,
                        min:0,
                        tickOptions:{formatString:'%d'}
                    }
                }
        });
{/literal}
// -->
</script>
<div class="jqPlot" id="lineChart" style="height:800px; width:800px;"></div>
