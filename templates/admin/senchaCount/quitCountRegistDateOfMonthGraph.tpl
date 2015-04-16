<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.barRenderer.min.js"></script>
<script language="JavaScript">
<!--
{literal}
        $.jqplot.config.enablePlugins = false;

        plot = $.jqplot('barChart', [{/literal}{$jsDispDataList}{literal}], {
            height:800,
            width:500,
            stackSeries: true,
            legend: {show: true, location: 'se'},
            title: '{/literal}{$month}{literal}登録日毎退会者数(月間)',
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
{if $jsDispDay}<div class="jqPlot" id="barChart" style="height:800px; width:500px;"></div>{/if}