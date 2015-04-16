<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.barRenderer.min.js"></script>
<script language="JavaScript">
<!--
{literal}
        $.jqplot.config.enablePlugins = false;

        plot = $.jqplot('barChart', [{/literal}{$jsDataList}{literal}], {
            height:800,
            width:700,
            stackSeries: true,
            title: 'アクティブ会員リスト',
            seriesDefaults: {renderer: $.jqplot.BarRenderer,
                                    shadowAngle: 135
                                    },
            axesDefaults: {
                  tickRenderer: $.jqplot.CanvasAxisTickRenderer ,
                  tickOptions: {
                    enableFontSupport: true,
                    fontFamily: 'ＭＳ Ｐゴシック',
                    fontSize: '9pt'
                  }
          },
            axes: {
                yaxis: {
                    label: '人数',
                    autoscale:true,
                    tickOptions:{formatString:'%d'}
                },
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks:[{/literal}{$jsDispName}{literal}],
                    tickOptions:{angle: -50}
                }
            }
        });
{/literal}
// -->
</script>
{if $total}<div class="jqPlot" id="barChart" style="height:800px; width:500px;"></div>{/if}