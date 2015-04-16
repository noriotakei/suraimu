<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.barRenderer.min.js"></script>
<script language="JavaScript">
<!--
{literal}
        $.jqplot.config.enablePlugins = false;
        var line1 = [{/literal}{$jsDispPreUser}{literal}];
        var line2 = [{/literal}{$jsDispUser}{literal}];
        var line3 = [{/literal}{$jsDispQuitUser}{literal}];
        var plot = $.jqplot('barChart', [line1, line2, line3], {
            height:800,
            width:800,
            stackSeries: true,
            legend: {show: true, location: 'se'},
            title: 'ユーザー登録数(月間)',
            seriesDefaults: {renderer: $.jqplot.BarRenderer,
                                    shadowAngle: 135,
                                    rendererOptions: {barDirection: 'horizontal'}
                                    },
            series: [{label: '仮登録会員人数'}, {label: '本登録会員人数'}, {label: '退会会員人数'}],
            axesDefaults: {
                  tickRenderer: $.jqplot.CanvasAxisTickRenderer ,
                  tickOptions: {
                    enableFontSupport: true,
                    fontFamily: 'ＭＳ Ｐゴシック',
                    fontSize: '9pt'
                  }
          },
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
{if $totalCnt}<div class="jqPlot" id="barChart" style="height:800px; width:800px;"></div>{/if}
