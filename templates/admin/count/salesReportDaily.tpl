<h2 class="ContentTitle">売り上げ(日毎)</h2>
<table cellspacing="0" cellpadding="0" class="TableSet02" id="table" align="center">
    <tr>
        <th rowspan="2">日付</th>
        <th>注文件数</th>
        <th rowspan="2">注文者数<br>(本登録｜会員解除)</th>
        <th rowspan="2">注文単価</th>
        <th rowspan="2">購入者数<br>(本登録｜会員解除)</th>
        <th rowspan="2">客単価</th>
        <th rowspan="2">売上</th>
        {foreach from=$payType item="payTypeVal" name="payTypeLoop"}
            <th rowspan="2">売上<br>({$payTypeVal})</th>
        {/foreach}
    </tr>
    <tr>
        <th>注文金額</th>
    </tr>
    {foreach from=$dispDataList item="val" key="key" name="loop"}
    {assign var="weekNum" value=$key|zend_date_format:'e'}
    {cycle values=", class=\"BgColor02\"" assign="style"}
    <tr {$style}>
        <td rowspan="2">{$key|zend_date_format:'yyyy年MM月dd日'}({$weekArray[$weekNum]})</td>
        <td>{$val.order_cnt|default:0}件</td>
        <td rowspan="2">{$val.user|default:0}人｜{$val.quit_user|default:0}人</td>
        <td rowspan="2">{$val.user_price|number_format:"0"|default:0}円</td>
        <td rowspan="2">{$val.sales_user|default:0}人｜{$val.sales_quit_user|default:0}人</td>
        <td rowspan="2">{$val.sales_user_price|number_format:"0"|default:0}円</td>
        <td rowspan="2">{$val.pay_total|number_format:"0"|default:0}円</td>
        {foreach from=$payType item="payTypeVal" key="payTypeKey" name="payTypeLoop"}
            <td rowspan="2">{$val[$payTypeKey]|number_format:"0"|default:0}円</td>
        {/foreach}

    </tr>
    <tr {$style}>
        <td>{$val.ordering_pay_total|number_format:"0"|default:0}円</td>
    </tr>
    {/foreach}
</table>
<br><br><br>
