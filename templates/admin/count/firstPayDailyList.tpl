<script language="JavaScript">
<!--
    $(function() {ldelim}
        {* テーブルストライプ *}
        $("#table tr:even").addClass("BgColor02");
    {rdelim});
// -->
</script>
<h2 class="ContentTitle">初入金者一覧(日毎)</h2>
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th></th>
        <th>ID</th>
        <th>初入金日時</th>
        <th>会員仮登録日</th>
        <th>会員登録日</th>
        <th>広告コード</th>
        <th>合計購入金額</th>
        <th>購入回数</th>
        <th>PCデバイス</th>
        <th>MBデバイス</th>
        <th>ステータス</th>
    </tr>
    {foreach from=$dispDataList item="val" key="key" name="loop"}
    <tr>
        <td>{$smarty.foreach.loop.iteration}</td>
        <td><a href="{make_link action="action_User_Detail" getTags="user_id="|cat:$val.user_id}" target="_blank">{$val.user_id}</a></td>
        <td>{$val.first_pay_datetime}</td>
        <td>{$val.pre_regist_datetime}</td>
        <td>{$val.regist_datetime}</td>
        <td>{$val.media_cd}</td>
        <td>{$val.total_payment|number_format:"0"|default:0}円</td>
        <td>{$val.buy_count|default:0}回</td>
        <td>{$config.admin_config.pc_device[$val.pc_device_cd]}</td>
        <td>{$config.admin_config.mb_device[$val.mb_device_cd]}</td>
        <td>{$config.admin_config.regist_status[$val.regist_status]}</td>
    </tr>
    {/foreach}
</table>
<br><br><br>
