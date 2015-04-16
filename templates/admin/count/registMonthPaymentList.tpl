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

        plot = $.jqplot('barChart', [{$jsDispUserCountDataList}], {ldelim}
            height:800,
            width:500,
            stackSeries: true,
            legend: {ldelim}show: true, location: 'se'{rdelim},
            title: '当月登録入金者',
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

        plot2 = $.jqplot('barChart2', [{$jsDispPaymentDataList}], {ldelim}
            height:800,
            width:900,
            stackSeries: true,
            title: '当月登録入金金額',
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
            axes: {ldelim}
                xaxis: {ldelim}
                    label: '金額',
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
          if (ui.index == 2 && plot2._drawCount == 0) {ldelim}
            plot2.replot();
          {rdelim}
        {rdelim});
        {* テーブルストライプ *}
        $("#table tr:even").addClass("BgColor02");
    {rdelim});

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
                <td>{$totalData.all_user|default:0}人</td>
                <td>{$totalData.user|default:0}人</td>
                <td>{$totalData.quit_user|default:0}人</td>
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
            {foreach from=$dispDay item="val" name="loop"}
            {assign var="weekNum" value=$val|zend_date_format:'e'}
            {cycle values=", class=\"BgColor02\"" assign="style"}
            <tr>
                <td>{$val|zend_date_format:'yyyy年MM月dd日'}({$weekArray[$weekNum]})</td>
                <td>{$dispDataList.$val.user|default:0}人</td>
                <td>{$dispDataList.$val.quit_user|default:0}人</td>
                <td>{$dispDataList.$val.all_user|default:0}人</td>
                <td>{$dispDataList.$val.total_payment|number_format:"0"|default:0}円</td>
            </tr>
            {/foreach}
            <tr class="BgColor03">
                <td>合計</td>
                <td>{$totalData.user|default:0}人</td>
                <td>{$totalData.quit_user|default:0}人</td>
                <td>{$totalData.all_user|default:0}人</td>
                <td>{$totalData.total_payment|number_format:"0"|default:0}円</td>
            </tr>
        </table>
    </div>
    <div id="tabs-graph">
        <table cellspacing="0" cellpadding="0" align="center">
            <tr>
            <td>{if $totalData.all_user}<div class="jqPlot" id="barChart" style="height:800px; width:500px;">{/if}</div></td>
            </tr>
        </table>
    </div>
    <div id="tabs-graph-2">
        <table cellspacing="0" cellpadding="0" align="center">
            <tr>
            <td>{if $totalData.total_payment}<div class="jqPlot" id="barChart2" style="height:800px; width:900px;">{/if}</div></td>
            </tr>
        </table>
    </div>
</div>
