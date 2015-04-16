<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.barRenderer.min.js"></script>
<script language="JavaScript">
<!--
{literal}
        $.jqplot.config.enablePlugins = false;

        var plot = $.jqplot('barChart', [{/literal}{$jsDispDataList}{literal}], {
            height:800,
            width:800,
            stackSeries: true,
            legend: {show: true, location: 'se'},
            title: '{/literal}{$month|default:""}{literal}売り上げ(曜日ごと)',
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
            series: [{/literal}{$jsPayType}{literal}],
            axes: {
                xaxis: {
                    label: '金額',
                    autoscale:true,
                    tickOptions:{formatString:'%d'}
                },
                yaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks:[{/literal}{$jsDispWeek}{literal}]
                }
            }
        });
{/literal}
// -->
</script>
{if $totalPay}<div class="jqPlot" id="barChart" style="height:800px; width:800px;"></div>{/if}
