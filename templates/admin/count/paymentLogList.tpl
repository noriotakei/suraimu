<h2 class="ContentTitle">入金ログリスト</h2>
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th>入金日時</th>
        <th>注文日時</th>
        <th>注文ID</th>
        <th>商品</th>
        <th>ユーザーID</th>
        <th>支払い種別</th>
        <th>金額</th>
        <th>キャンセル</th>
        <th>手動</th>
    </tr>
    {foreach from=$dataList item="val" key="key" name="loop"}
    <tr>
        <td>{$val.create_datetime}</td>
        <td>{$val.ordering_create_datetime}</td>
        <td><a href="{make_link action="action_ordering_OrderingData" getTags="ordering_id="|cat:$val.ordering_id}" target="_blank">{$val.ordering_id}</a></td>
        <td>
            {if $val.ordering_status == $restStatus}
                余り金決済
            {else}
                <table border="0" cellpadding="0" cellspacing="0" style="font-size:11px" class="TableSet04">
                    {foreach from=$itemList[$key] item="itemVal" name="itemLoop"}
                    <tr>
                        <td>ID:<a href="{make_link action="action_itemManagement_itemData" getTags="iid="|cat:$itemVal.id}" target="_blank">{$itemVal.id}</a></td>
                        <td width="150">{if $itemVal.is_rest}余り金PT購入{else}{$itemVal.name|emoji}{/if}</td>
                        <td nowrap>\{$itemVal.price|number_format}</td>
                    </tr>
                    {/foreach}
                </table>
            {/if}
        </td>
        <td><a href="{make_link action="action_User_Detail" getTags="user_id="|cat:$val.user_id}" target="_blank">{$val.user_id}</a></td>
        <td>{$payType[$val.pay_type]}</td>
        <td>{$val.receive_money|number_format:"0"}円</td>
        <td>{if $val.is_cancel}キャンセル{/if}</td>
        <td>{if $val.is_manual}手動{else}自動{/if}</td>
    </tr>
    {/foreach}
    <tr class="BgColor03">
        <td>合計</td>
        <td></td>
        <td>{$total.cnt|default:0}件</td>
        <td></td>
        <td></td>
        <td></td>
        <td>{$total.money|number_format:"0"|default:0}円</td>
        <td></td>
        <td></td>
    </tr>

</table>
<br><br><br>
