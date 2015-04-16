<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script language="JavaScript">
<!--
    $(function() {ldelim}
        {* テーブルマウスオーバーカラー *}
        $('#table').colorize({ldelim}
            altColor :'#E5E5E5',
            hiliteColor :'none'
        {rdelim});

    {rdelim});
// -->
</script>
<h2 class="ContentTitle">入金ログリスト</h2>
<table cellspacing="0" cellpadding="0" class="TableSet01" id="table" align="center">
    <tr>
        <th>注文ID</th>
        <th>支払方法</th>
        <th>金額</th>
        <th>キャンセル</th>
        <th>手動入金</th>
        <th>入金日時</th>
    </tr>
    {foreach from=$dataList item="val" key="key" name="loop"}
    <tr>
        <td><a href="{make_link action="action_ordering_OrderingData" getTags="ordering_id="|cat:$val.ordering_id}" target="_blank">{$val.ordering_id}</a></td>
        <td>{$payType[$val.pay_type]}</td>
        <td>{$val.receive_money|number_format}円</td>
        <td>{if $val.is_cancel}キャンセル{/if}</td>
        <td>{if $val.is_manual}手動入金{/if}</td>
        <td>{$val.create_datetime}</td>
    </tr>
    {/foreach}
</table>

