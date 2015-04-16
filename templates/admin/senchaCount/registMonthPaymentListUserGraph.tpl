<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.barRenderer.min.js"></script>
<script language="JavaScript">
<!--
{literal}
        $.jqplot.config.enablePlugins = false;

        plot = $.jqplot('barChart', [{/literal}{$jsDispUserCountDataList}{literal}], {
            height:800,
            width:800,
            stackSeries: true,
            legend: {show: true, location: 'se'},
            title: '当月登録入金者',
            seriesDefaults: {renderer: $.jqplot.BarRenderer,
                                    shadowAngle: 135,
                                    rendererOptions: {barDirection: 'horizontal'}
                                    },
            axesDefaults: {
                  tickRenderer: $.jqplot.CanvasAxisTickRenderer ,
                  tickOptions: {
                    enableFontSupport: true,
                    fontFamily: 'ＭＳ Ｐゴシック',
                    fontSize: '9pt'
                  }
          },
            series: [{/literal}{$jsLabel}{literal}],
            axes: {
                xaxis: {
                    label: '人数',
                    autoscale:true,
                    tickOptions:{formatString:'%d'}
                },
                yaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks:[{/literal}{$jsDispDay}{literal}]
                }
            }
        });
{/literal}
// -->
</script>
{if $totalUser}<div class="jqPlot" id="barChart" style="height:800px; width:800px;">{/if}
