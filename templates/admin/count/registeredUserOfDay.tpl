<script language="JavaScript">
<!--
    $(function() {ldelim}
        {* テーブルストライプ *}
        $("#table tr:even").addClass("BgColor02");
    {rdelim});
// -->
</script>
<h2 class="ContentTitle">ユーザー登録数(日毎)</h2>
<table cellspacing="0" cellpadding="0" class="TableSet02" id="table" align="center">
    <tr>
        <th>総会員人数</th>
        <th>仮登録会員人数</th>
        <th>本登録会員人数</th>
        <th>登録解除<br>会員人数</th>
    </tr>
    <tr>
        <td>{$totalData.all_user|default:0}人</td>
        <td>{$totalData.pre_user|default:0}人</td>
        <td>{$totalData.user|default:0}人</td>
        <td>{$totalData.quit_user|default:0}人</td>
    </tr>
</table>
<br>
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th></th>
        <th>ID</th>
        <th>会員仮登録日</th>
        <th>会員登録日</th>
        <th>広告コード</th>
        <th>PCIPアドレス</th>
        <th>MBIPアドレス</th>
        <th>固体識別番号</th>
        <th>PCデバイス</th>
        <th>MBデバイス</th>
        <th>ステータス</th>
    </tr>
    {foreach from=$dataList item="val" key="key" name="loop"}
    <tr>
        <td>{$smarty.foreach.loop.iteration}</td>
        <td><a href="{make_link action="action_User_Detail" getTags="user_id="|cat:$val.user_id}" target="_blank">{$val.user_id}</a></td>
        <td>{$val.pre_regist_datetime}</td>
        <td>{$val.regist_datetime}</td>
        <td>{$val.media_cd}</td>
        <td>{$val.pc_ip_address}</td>
        <td>{$val.mb_ip_address}</td>
        <td>{$val.mb_identify}</td>
        <td>{$config.admin_config.pc_device[$val.pc_device_cd]}</td>
        <td>{$config.admin_config.mb_device[$val.mb_device_cd]}</td>
        <td>{$config.admin_config.regist_status[$val.regist_status]}</td>
    </tr>
    {/foreach}
</table>
<br><br><br>
