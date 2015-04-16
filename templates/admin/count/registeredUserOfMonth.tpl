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

        line1 = [{$jsDispPreUser}];
        line2 = [{$jsDispUser}];
        line3 = [{$jsDispQuitUser}];
        plot = $.jqplot('barChart', [line1, line2, line3], {ldelim}
            height:800,
            width:700,
            stackSeries: true,
            legend: {ldelim}show: true, location: 'se'{rdelim},
            title: 'ユーザー登録数(月間)',
            seriesDefaults: {ldelim}renderer: $.jqplot.BarRenderer,
                                    shadowAngle: 135,
                                    rendererOptions: {ldelim}barDirection: 'horizontal'{rdelim}
                                    {rdelim},
            series: [{ldelim}label: '仮登録会員人数'{rdelim}, {ldelim}label: '本登録会員人数'{rdelim}, {ldelim}label: '退会会員人数'{rdelim}],
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

    {rdelim});

// -->
</script>
<h2 class="ContentTitle">{$month}ユーザー登録数(月間)</h2>
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">集計</a></li>
        <li><a href="#tabs-graph">グラフ</a></li>
    </ul>
    <div id="tabs-1">
        <table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
            <tr>
                <th rowspan="2" style="text-align:center;">日付</th>
                <th colspan="4" style="text-align:center;">会員</th>
                <th colspan="3" style="text-align:center;">注文</th>
            </tr>
            <tr>
                <th>合計会員人数</th>
                <th>仮登録会員人数</th>
                <th>本登録会員人数</th>
                <th>登録解除<br>会員人数</th>
                <th>注文件数</th>
                <th>注文金額<br>/入金額</th>
                <th>平均単価<br>注文額<br>÷注文件数</th>
            </tr>
            {foreach from=$dispDay item="val" name="loop"}
            {assign var="weekNum" value=$val|zend_date_format:'e'}
            {cycle values=", class=\"BgColor02\"" assign="style"}
            <tr {$style}>
                <td>{$val|zend_date_format:'yyyy年MM月dd日'}({$weekArray[$weekNum]})</td>
                <td>{$dispDataList.$val.all_user|default:0}人</td>
                <td>{$dispDataList.$val.pre_user|default:0}人</td>
                <td>{$dispDataList.$val.user|default:0}人</td>
                <td>{$dispDataList.$val.quit_user|default:0}人</td>
                <td>{$dispDataList.$val.order_cnt|default:0}件</td>
                <td>{$dispDataList.$val.pay_total|number_format:"0"|default:0}円<br>/{$dispDataList.$val.receive_money|number_format:"0"|default:0}円</td>
                <td>{$dispDataList.$val.user_price|number_format:"0"|default:0}円</td>
            </tr>
            {/foreach}
            <tr class="BgColor03">
                <td>合計</td>
                <td>{$totalData.all_user|default:0}人</td>
                <td>{$totalData.pre_user|default:0}人</td>
                <td>{$totalData.user|default:0}人</td>
                <td>{$totalData.quit_user|default:0}人</td>
                <td>{$totalData.order_cnt|default:0}件</td>
                <td>{$totalData.pay_total|number_format:"0"|default:0}円<br>/{$totalData.receive_money|number_format:"0"|default:0}円</td>
                <td>{$totalData.user_price|number_format:"0"|default:0}円</td>
            </tr>
        </table>
    </div>
    <div id="tabs-graph">
        <table cellspacing="0" cellpadding="0" align="center">
            <tr>
            <td>{if $totalData.all_user}<div class="jqPlot" id="barChart" style="height:800px; width:700px;"></div>{/if}</td>
            </tr>
        </table>
    </div>
</div>
