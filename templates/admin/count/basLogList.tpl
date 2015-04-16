<script language="JavaScript">
<!--
    $(function() {ldelim}
        {* テーブルストライプ *}
        $("#table tr:even").addClass("BgColor02");
    {rdelim});
// -->
</script>
<h2 class="ContentTitle">銀行振込ログリスト</h2>
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th>ID</th>
        <th>注文ID</th>
         <th>ユーザーID</th>
        <th>入金金額</th>
        <th>入力振込み人名</th>
        <th>銀行名</th>
        <th>支店名</th>
        <th>振込先口座</th>
        <th>処理方法</th>
        <th>BAS処理日時</th>
    </tr>
    {foreach from=$dataList item="val" key="key" name="loop"}
    <tr>
        <td>{$val.id}</td>
        <td><a href="{make_link action="action_ordering_OrderingData" getTags="ordering_id="|cat:$val.ordering_id}" target="_blank">{$val.ordering_id}</a></td>
        <td><a href="{make_link action="action_User_Detail" getTags="user_id="|cat:$val.user_id}" target="_blank">{$val.user_id}</a></td>
        <td>{$val.receive_money}</td>
        <td>{$val.telno}</td>
        <td>{$val.bank_name}</td>
        <td>{$val.branch_name}</td>
        <td>{$val.fkoza}</td>
        <td>{if $val.is_manual}手動{else}自動{/if}</td>
        <td>{$val.create_datetime}</td>
    </tr>
    {/foreach}
</table>
<br><br><br>