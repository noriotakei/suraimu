<script language="JavaScript">
<!--
    $(function() {ldelim}
        {* テーブルストライプ *}
        $("#table tr:even").addClass("BgColor02");
    {rdelim});
// -->
</script>

<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th>日付</th>
        <th>広告コード</th>
        <th>アクセス数</th>
        <th>本登録者数</th>
        <th>入金額</th>
    </tr>
    {foreach from=$dispDataList item="val" key="key" name="loop"}
    <tr>
        <td>{$val.analyze_datetime}</td>
        <td>{$val.media_cd}</td>
        <td>{$val.access_count|default:0}</td>
        <td>{$val.regist_count|default:0}</td>
        <td>{$val.trade_amount|default:0}</td>
    </tr>
    {/foreach}
    <tr class="BgColor02">
        <td>合計</td>
        <td></td>
        <td>{$totalData.access_count|default:0}</td>
        <td>{$totalData.regist_count|default:0}</td>
        <td>{$totalData.trade_amount|default:0}</td>
    </tr>
</table>

