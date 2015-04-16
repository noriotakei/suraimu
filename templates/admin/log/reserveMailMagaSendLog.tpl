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
<h2 class="ContentTitle">予約送信メルマガログ</h2>
<table cellspacing="0" cellpadding="0" class="TableSet01" id="table" align="center">
    <tr>
        <th>メルマガログID</th>
        <th>送信開始時間</th>
        <th>送信終了時間</th>
    </tr>
    {foreach from=$dataList item="val" key="key" name="loop"}
    <tr>
        <td><a href="{make_link action="action_mailLog_MailLogData" getTags="mail_maga_id="|cat:$val.mailmagazine_log_id_reserve}" target="_blank">{$val.mailmagazine_log_id_reserve}</a></td>
        <td>{$val.send_start_datetime}</td>
        <td>{$val.send_end_datetime}</td>
    </tr>
    {/foreach}
</table>

