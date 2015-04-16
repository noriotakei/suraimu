<script type="text/javascript" src="./js/jqPlot/plugins/jqplot.pieRenderer.min.js"></script>
<script language="JavaScript">
<!--
    $(function() {ldelim}
        $.jqplot.config.enablePlugins = false;

        {* テーブルストライプ *}
        $("#table tr:even").addClass("BgColor02");
        {* タブ *}
        $("#tabs").tabs({ldelim} cache: false {rdelim});
        line1 = [{$dispPieChartValue}];
        plot = $.jqplot('pieChart', [line1], {ldelim}
            height: 400,
            width: 600,
            title: '{$month|default:""}入金割合リスト',
            seriesDefaults:{ldelim}renderer:$.jqplot.PieRenderer, rendererOptions:{ldelim}sliceMargin:8{rdelim}{rdelim},
            legend:{ldelim}show:true{rdelim}
        {rdelim});
        $('#tabs').bind('tabsshow', function(event, ui) {ldelim}
          if (ui.index == 1 && plot._drawCount == 0) {ldelim}
            plot.replot();
          {rdelim}
        {rdelim});
    {rdelim});

// -->
</script>
<h2 class="ContentTitle">{$month|default:""}入金割合リスト</h2>
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">集計</a></li>
        <li><a href="#tabs-graph">グラフ</a></li>
    </ul>
    <div id="tabs-1">
        <table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
            <tr>
                <th>支払い種別</th>
                <th>入金額</th>
                <th>レート</th>
            </tr>
            {foreach from=$payType item="val" key="key" name="loop"}
            <tr>
                <td>{$val}</td>
                <td>{$dispDataList.$key.sum_total_payment|number_format:"0"|default:0}円</td>
                <td>{$dispDataList.$key.rate|default:0}%</td>
            </tr>
            {/foreach}
            <tr class="BgColor03">
                <td>合計</td>
                <td>{$total.total_money|number_format:"0"|default:0}円</td>
                <td>{$total.rate|default:0}%</td>
            </tr>
        </table>
    </div>
    <div id="tabs-graph">
        <table cellspacing="0" cellpadding="0" align="center">
            <tr>
            <td><div class="jqPlot" id="pieChart" style="height:400px; width:600px;"></div></td>
            </tr>
        </table>
    </div>
</div>
