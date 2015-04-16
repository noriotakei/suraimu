<script language="JavaScript">
<!--
    $(function() {ldelim}
        {* テーブルストライプ *}
        $("#table tr:even").addClass("BgColor02");
    {rdelim});
// -->
</script>
<h2 class="ContentTitle">商品ランキングベスト100(金額順)</h2>
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th>順位</th>
        <th>ID</th>
        <th>商品名</th>
        <th>表示開始日時</th>
        <th>表示終了日時</th>
        <th>購入回数</th>
        <th>金額</th>
    </tr>
    {foreach from=$dataList item="val" key="key" name="loop"}
    <tr>
        <td>{$smarty.foreach.loop.iteration}</td>
        <td><a href="{make_link action="action_itemManagement_itemData" getTags="iid="|cat:$val.item_id}" target="_blank">{$val.item_id}</a></td>
        <td>{$val.item_name}</td>
        <td>{$val.sales_start_datetime}</td>
        <td>{$val.sales_end_datetime}</td>
        <td nowrap style="text-align:right">{$val.item_cnt}回</td>
        <td nowrap style="text-align:right">{$val.price|number_format:"0"|default:0}円</td>
    </tr>
    {/foreach}
</table>
<br><br><br>