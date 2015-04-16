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
            height:300,
            width:900,
            stackSeries: true,
            legend: {ldelim}show: true, location: 'se'{rdelim},
            title: '{$month|default:""}売り上げ(曜日ごと)',
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
            series: [{$jsPayType}],
            axes: {ldelim}
                xaxis: {ldelim}
                    label: '金額',
                    autoscale:true,
                    tickOptions:{ldelim}formatString:'%d'{rdelim}
                {rdelim},
                yaxis: {ldelim}
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks:[{$jsDispWeek}]
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
<h2 class="ContentTitle">{$month|default:""}売り上げ(曜日ごと)</h2>
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">集計</a></li>
        <li><a href="#tabs-graph">グラフ</a></li>
    </ul>
    <div id="tabs-1">
        <table cellspacing="0" cellpadding="0" class="TableSet02" id="table" align="center">
            <tr>
                <th rowspan="2" width="50px">曜日</th>
                <th>注文件数</th>
                <th rowspan="2" width="70px">注文者数<br>(本登録<br>｜会員解除)</th>
                <th rowspan="2">注文単価</th>
                <th rowspan="2" width="70px">購入者数<br>(本登録<br>｜会員解除)</th>
                <th rowspan="2">客単価</th>
                <th rowspan="2">売上</th>
                {foreach from=$payType item="payTypeVal" name="payTypeLoop"}
                    <th rowspan="2" width="70px">売上<br>({$payTypeVal})</th>
                {/foreach}
            </tr>
            <tr>
                <th>注文金額</th>
            </tr>
            {foreach from=$config.admin_config.week_array key="key" item="val" name="loop"}
                {cycle values=", class=\"BgColor02\"" assign="style"}
                <tr {$style}>
                    <td rowspan="2" nowrap>{$val}</td>
                    <td>{$dispDataList.$key.order_cnt|default:0}件</td>
                    <td rowspan="2">{$dispDataList.$key.user|default:0}人<br>｜{$dispDataList.$key.quit_user|default:0}人</td>
                    <td rowspan="2">{$dispDataList.$key.user_price|number_format:"0"|default:0}円</td>
                    <td rowspan="2">{$dispDataList.$key.sales_user|default:0}人<br>｜{$dispDataList.$key.sales_quit_user|default:0}人</td>
                    <td rowspan="2">{$dispDataList.$key.sales_user_price|number_format:"0"|default:0}円</td>
                    <td rowspan="2">{$dispDataList.$key.pay_total|number_format:"0"|default:0}円</td>
                    {foreach from=$payType key="payTypeKey" item="payTypeVal" name="payTypeLoop"}
                        <td rowspan="2">{$dispDataList.$key[$payTypeKey]|number_format:"0"|default:0}円</td>
                    {/foreach}
                </tr>
                <tr {$style}>
                    <td>{$dispDataList.$key.ordering_pay_total|number_format:"0"|default:0}円</td>
                </tr>
            {/foreach}
            <tr class="BgColor03">
                <td rowspan="2">合計</td>
                <td>{$totalDataList.order_cnt|default:0}件</td>
                <td rowspan="2">{$totalDataList.user|default:0}人<br>｜{$totalDataList.quit_user|default:0}人</td>
                <td rowspan="2">{$totalDataList.user_price|number_format:"0"|default:0}円</td>
                <td rowspan="2">{$totalDataList.sales_user|default:0}人<br>｜{$totalDataList.sales_quit_user|default:0}人</td>
                <td rowspan="2">{$totalDataList.sales_user_price|number_format:"0"|default:0}円</td>
                <td rowspan="2">{$totalDataList.pay_total|number_format:"0"|default:0}円</td>
                {foreach from=$payType key="payTypeKey" item="payTypeVal" name="payTypeLoop"}
                    <td rowspan="2">{$totalDataList.$payTypeKey|number_format:"0"|default:0}円</td>
                {/foreach}
            </tr>
            <tr class="BgColor03">
                <td>{$totalDataList.ordering_pay_total|number_format:"0"|default:0}円</td>
            </tr>
        </table>
    </div>
    <div id="tabs-graph">
        <table cellspacing="0" cellpadding="0" align="center">
            <tr>
            <td>{if $totalDataList.ordering_pay_total}<div class="jqPlot" id="barChart" style="height:300px; width:900px;">{/if}</div></td>
            </tr>
        </table>
    </div>
</div>
