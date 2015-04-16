<script language="JavaScript">
<!--
    $(function() {ldelim}
        {* テーブルストライプ *}
        $("#table tr:even").addClass("BgColor02");
    {rdelim});
// -->
</script>
<h2 class="ContentTitle">{$month}購入回数別集計(月間)</h2>
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th>購入<br>回数</th>
        <th>購入<br>人数</th>
        <th>購入額</th>
        <th>1人当りの<br>平均購入額</th>
        <th>---</th>
        <th>購入<br>会員数</th>
        <th>---</th>
        <th>退会<br>会員数</th>
        <th>---</th>
        <th>検索</th>
    </tr>
    {foreach from=$dispDataList item="val" key="key" name="loop"}
    <tr>
        <td>{$key|default:0}回</td>
        <td>{$val.user_cnt|default:0}人</td>
        <td>{$val.pay_total|number_format:"0"|default:0}円</td>
        <td>{$val.user_price|number_format:"0"|default:0}円</td>
        <td>{$val.pay_total_rate|default:0}%</td>
        <td>{$val.user|default:0}人</td>
        <td>{$val.user_cnt_rate|default:0}%</td>
        <td>{$val.quit_user|default:0}人</td>
        <td>{$val.quit_user_rate|default:0}%</td>
        <td>
        <form action="./" method="post" name="userSearch">
            <input type="hidden" name="user_id_specify_target_including" value="1">
            <input type="hidden" name="user_id" value="{$val.user_id}">
            <input type="submit" value="検索する" name="action_User_List">
        </form>
        </td>
    </tr>
    {/foreach}
    <tr class="BgColor03">
        <td>合計</td>
        <td>{$totalCnt.user_cnt|default:0}人</td>
        <td>{$totalCnt.pay_total|number_format:"0"|default:0}円</td>
        <td>{$totalCnt.user_price|number_format:"0"|default:0}円</td>
        <td>{$totalCnt.pay_total_rate|default:0}%</td>
        <td>{$totalCnt.user|default:0}人</td>
        <td>{$totalCnt.user_cnt_rate|default:0}%</td>
        <td>{$totalCnt.quit_user|default:0}人</td>
        <td>{$totalCnt.quit_user_rate|default:0}%</td>
        <td></td>
    </tr>
</table>
<br><br><br>