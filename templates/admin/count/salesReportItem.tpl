<h2 class="ContentTitle">{$month|default:""}商品別売上(月間)</h2>
<table cellspacing="0" cellpadding="0" class="TableSet02" id="table" align="center">
    <tr>
        <th>商品ID</th>
        <th>商品</th>
        <th>価格</th>
        <th>件数</th>
        <th>合計</th>
    </tr>
    {foreach from=$dispDataList key="key" item="val" name="Loop"}
    <tr>
        <td>{$val.item_id}</td>
        <td width="200">{if $val.is_rest}余り金PT購入{else}{$val.item_name|emoji}{/if}</td>
        <td>{$val.price|number_format:"0"}円</td>
        <td>{$val.ordering_cnt}件</td>
        <td>{$val.total_pay|number_format:"0"}円</td>
    </tr>
    {/foreach}
    <tr class="BgColor03">
        <td>総合計</td>
        <td></td>
        <td></td>
        <td>{$totalDataList.ordering_cnt|default:0}件</td>
        <td>{$totalDataList.total_pay|number_format:"0"|default:0}円</td>
    </tr>
</table>
<br><br><br>
