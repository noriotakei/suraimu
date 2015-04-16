<?php /* Smarty version 2.6.26, created on 2014-11-04 17:50:29
         compiled from /home/suraimu/templates/admin/senchaCount/activeUserGraph.tpl */ ?>
<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.barRenderer.min.js"></script>
<script language="JavaScript">
<!--
<?php echo '
        $.jqplot.config.enablePlugins = false;

        plot = $.jqplot(\'barChart\', ['; ?>
<?php echo $this->_tpl_vars['jsDataList']; ?>
<?php echo '], {
            height:800,
            width:700,
            stackSeries: true,
            title: \'アクティブ会員リスト\',
            seriesDefaults: {renderer: $.jqplot.BarRenderer,
                                    shadowAngle: 135
                                    },
            axesDefaults: {
                  tickRenderer: $.jqplot.CanvasAxisTickRenderer ,
                  tickOptions: {
                    enableFontSupport: true,
                    fontFamily: \'ＭＳ Ｐゴシック\',
                    fontSize: \'9pt\'
                  }
          },
            axes: {
                yaxis: {
                    label: \'人数\',
                    autoscale:true,
                    tickOptions:{formatString:\'%d\'}
                },
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks:['; ?>
<?php echo $this->_tpl_vars['jsDispName']; ?>
<?php echo '],
                    tickOptions:{angle: -50}
                }
            }
        });
'; ?>

// -->
</script>
<?php if ($this->_tpl_vars['total']): ?><div class="jqPlot" id="barChart" style="height:800px; width:500px;"></div><?php endif; ?>