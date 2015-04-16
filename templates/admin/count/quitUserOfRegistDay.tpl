<script language="JavaScript">
<!--
    $(function() {ldelim}
        {* テーブルストライプ *}
        $("#table tr:even").addClass("BgColor02");
    {rdelim});
    $(function() {ldelim}
        {* テーブルストライプ *}
        $("#table2 tr:even").addClass("BgColor02");
    {rdelim});
// -->
</script>
<h2 class="ContentTitle">退会者人数(登録日)</h2>
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table2" align="center">
    <tr>
        <th></th>
        <th>ID</th>
        <th>会員登録日</th>
        <th>PCデバイス</th>
        <th>MBデバイス</th>
        <th>ステータス</th>
    </tr>
    {foreach from=$dispDataList item="val" key="key" name="loop"}
    <tr>
        <td>{$smarty.foreach.loop.iteration}</td>
        <td><a href="{make_link action="action_User_Detail" getTags="user_id="|cat:$val.user_id}" target="_blank">{$val.user_id}</a></td>
        <td>{$val.regist_datetime}</td>
        <td>{$config.admin_config.pc_device[$val.pc_device_cd]}</td>
        <td>{$config.admin_config.mb_device[$val.mb_device_cd]}</td>
        <td>{$config.admin_config.regist_status[$val.regist_status]}</td>
    </tr>
    {/foreach}
</table>
<br><br><br>
