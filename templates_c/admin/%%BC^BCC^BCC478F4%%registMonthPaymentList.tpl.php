<?php /* Smarty version 2.6.26, created on 2015-02-02 13:57:33
         compiled from /home/suraimu/templates/admin/count/registMonthPaymentList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', '/home/suraimu/templates/admin/count/registMonthPaymentList.tpl', 105, false),array('modifier', 'zend_date_format', '/home/suraimu/templates/admin/count/registMonthPaymentList.tpl', 120, false),array('modifier', 'number_format', '/home/suraimu/templates/admin/count/registMonthPaymentList.tpl', 127, false),array('function', 'cycle', '/home/suraimu/templates/admin/count/registMonthPaymentList.tpl', 121, false),)), $this); ?>
<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.barRenderer.min.js"></script>
<script language="JavaScript">
<!--
    $(function() {

        $.jqplot.config.enablePlugins = false;

                $("#tabs").tabs({ cache: false });

        plot = $.jqplot('barChart', [<?php echo $this->_tpl_vars['jsDispUserCountDataList']; ?>
], {
            height:800,
            width:500,
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
            series: [<?php echo $this->_tpl_vars['jsLabel']; ?>
],
            axes: {
                xaxis: {
                    label: '人数',
                    autoscale:true,
                    tickOptions:{formatString:'%d'}
                },
                yaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks:[<?php echo $this->_tpl_vars['jsDispDay']; ?>
]
                }
            }
        });

        plot2 = $.jqplot('barChart2', [<?php echo $this->_tpl_vars['jsDispPaymentDataList']; ?>
], {
            height:800,
            width:900,
            stackSeries: true,
            title: '当月登録入金金額',
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
            axes: {
                xaxis: {
                    label: '金額',
                    autoscale:true,
                    tickOptions:{formatString:'%d'}
                },
                yaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks:[<?php echo $this->_tpl_vars['jsDispDay']; ?>
]
                }
            }
        });

        $('#tabs').bind('tabsshow', function(event, ui) {
          if (ui.index == 1 && plot._drawCount == 0) {
            plot.replot();
          }
          if (ui.index == 2 && plot2._drawCount == 0) {
            plot2.replot();
          }
        });
                $("#table tr:even").addClass("BgColor02");
    });

// -->
</script>
<h2 class="ContentTitle">当月登録入金者一覧(期間指定で登録日縛りができます)</h2>
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">集計</a></li>
        <li><a href="#tabs-graph">入金者グラフ</a></li>
        <li><a href="#tabs-graph-2">入金金額グラフ</a></li>
    </ul>
    <div id="tabs-1">
        <table cellspacing="0" cellpadding="0" class="TableSet02" id="table" align="center">
            <tr>
                <th>合計入金会員人数</th>
                <th>本登録入金会員人数</th>
                <th>登録解除<br>入金会員人数</th>
            </tr>
            <tr>
                <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['totalData']['all_user'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
人</td>
                <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['totalData']['user'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
人</td>
                <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['totalData']['quit_user'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
人</td>
            </tr>
        </table>
        <br>
        <table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
            <tr>
                <th>日付</th>
                <th>本登録<br>入金会員人数</th>
                <th>登録解除<br>入金会員人数</th>
                <th>合計入金<br>会員人数</th>
                <th>入金金額</th>
            </tr>
            <?php $_from = $this->_tpl_vars['dispDay']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['val']):
        $this->_foreach['loop']['iteration']++;
?>
            <?php $this->assign('weekNum', ((is_array($_tmp=$this->_tpl_vars['val'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'e') : smarty_modifier_zend_date_format($_tmp, 'e'))); ?>
            <?php echo smarty_function_cycle(array('values' => ", class=\"BgColor02\"",'assign' => 'style'), $this);?>

            <tr>
                <td><?php echo ((is_array($_tmp=$this->_tpl_vars['val'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy年MM月dd日') : smarty_modifier_zend_date_format($_tmp, 'yyyy年MM月dd日')); ?>
(<?php echo $this->_tpl_vars['weekArray'][$this->_tpl_vars['weekNum']]; ?>
)</td>
                <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['dispDataList'][$this->_tpl_vars['val']]['user'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
人</td>
                <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['dispDataList'][$this->_tpl_vars['val']]['quit_user'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
人</td>
                <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['dispDataList'][$this->_tpl_vars['val']]['all_user'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
人</td>
                <td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['dispDataList'][$this->_tpl_vars['val']]['total_payment'])) ? $this->_run_mod_handler('number_format', true, $_tmp, '0') : number_format($_tmp, '0')))) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
円</td>
            </tr>
            <?php endforeach; endif; unset($_from); ?>
            <tr class="BgColor03">
                <td>合計</td>
                <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['totalData']['user'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
人</td>
                <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['totalData']['quit_user'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
人</td>
                <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['totalData']['all_user'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
人</td>
                <td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['totalData']['total_payment'])) ? $this->_run_mod_handler('number_format', true, $_tmp, '0') : number_format($_tmp, '0')))) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
円</td>
            </tr>
        </table>
    </div>
    <div id="tabs-graph">
        <table cellspacing="0" cellpadding="0" align="center">
            <tr>
            <td><?php if ($this->_tpl_vars['totalData']['all_user']): ?><div class="jqPlot" id="barChart" style="height:800px; width:500px;"><?php endif; ?></div></td>
            </tr>
        </table>
    </div>
    <div id="tabs-graph-2">
        <table cellspacing="0" cellpadding="0" align="center">
            <tr>
            <td><?php if ($this->_tpl_vars['totalData']['total_payment']): ?><div class="jqPlot" id="barChart2" style="height:800px; width:900px;"><?php endif; ?></div></td>
            </tr>
        </table>
    </div>
</div>