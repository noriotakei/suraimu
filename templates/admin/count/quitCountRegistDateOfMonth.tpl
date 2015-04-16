<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.barRenderer.min.js"></script>
<script language="JavaScript">
<!--
    $(function() {ldelim}
        $.jqplot.config.enablePlugins = false;

        {* タブ *}
        $("#tabs").tabs({ldelim} cache: false {rdelim});

        plot = $.jqplot('barChart', [{$jsDispDataList}], {ldelim}
            height:800,
            width:500,
            stackSeries: true,
            legend: {ldelim}show: true, location: 'se'{rdelim},
            title: '{$month}登録日毎退会者数(月間)',
            seriesDefaults: {ldelim}renderer: $.jqplot.BarRenderer,
                                    shadowAngle: 135,
                                    rendererOptions: {ldelim}barDirection: 'horizontal'{rdelim}
                                    {rdelim},
            axesDefaults: {ldelim}
                  tickRenderer: $.jqplot.CanvasAxisTickRenderer ,
                  tickOptions: {ldelim}
                    enableFontSupport: true,
                    fontFamily: 'ＭＳ Ｐゴシック',
                    fontSize: '9pt'
                  {rdelim}
          {rdelim},
            series: [{$jsLabel}],
            axes: {ldelim}
                xaxis: {ldelim}
                    label: '人数',
                    autoscale:true,
                    tickOptions:{ldelim}formatString:'%d'{rdelim}
                {rdelim},
                yaxis: {ldelim}
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks:[{$jsDispDay}]
                {rdelim}
            {rdelim}
        {rdelim});

        $('#tabs').bind('tabsshow', function(event, ui) {ldelim}
          if (ui.index == 1 && plot._drawCount == 0) {ldelim}
            plot.replot();
          {rdelim}
        {rdelim});
        {* テーブルストライプ *}
        $("#table tr:even").addClass("BgColor02");
    {rdelim});

// -->
</script>
<h2 class="ContentTitle">{$month}登録日毎退会者数(月間)</h2>
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">集計</a></li>
        <li><a href="#tabs-graph">グラフ</a></li>
    </ul>
    <div id="tabs-1">
        <table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
            <tr>
                <th>日付</th>
                <th>登録人数</th>
                <th>退会者数</th>
                <th>残会員数</th>
                <th>会員残留率</th>
            </tr>
            {foreach from=$dispDataList item="val" key="key" name="loop"}
            {assign var="weekNum" value=$key|zend_date_format:'e'}
            <tr>
                <td>{$key|zend_date_format:'yyyy年MM月dd日'}({$weekArray[$weekNum]})</td>
                <td>{$val.regist_cnt|default:0}人</td>
                <td>{$val.quit_cnt|default:0}人</td>
                <td>{$val.remain_total_cnt|default:0}人</td>
                <td>{$val.survival_rate|default:0}%</td>
            </tr>
            {/foreach}
            <tr class="BgColor03">
                <td>平均</td>
                <td>{$totalCnt.avg_regist_cnt|default:0}人</td>
                <td>{$totalCnt.avg_quit_cnt|default:0}人</td>
                <td>{$totalCnt.avg_remain_total_cnt|default:0}人</td>
                <td>{$totalCnt.avg_survival_rate|default:0}%</td>
            </tr>
            <tr class="BgColor03">
                <td>合計</td>
                <td>{$totalCnt.regist_cnt|default:0}人</td>
                <td>{$totalCnt.quit_cnt|default:0}人</td>
                <td>{$totalCnt.remain_total_cnt|default:0}人</td>
                <td>---</td>
            </tr>
        </table>
    </div>
    <div id="tabs-graph">
        <table cellspacing="0" cellpadding="0" align="center">
            <tr>
            <td>{if $dispDataList}<div class="jqPlot" id="barChart" style="height:800px; width:500px;">{/if}</div></td>
            </tr>
        </table>
    </div>
</div>

