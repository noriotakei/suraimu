<script language="JavaScript">
<!--
    $(function() {ldelim}
        {* テーブルストライプ *}
        $("#table tr:even").addClass("BgColor02");
    {rdelim});
// -->
</script>
<h2 class="ContentTitle">情報ランキングベスト100</h2>
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th>順位</th>
        <th>ID</th>
        <th>管理用情報名</th>
        <th>表示開始日時</th>
        <th>表示終了日時</th>
        <th>閲覧回数</th>
    </tr>
    {foreach from=$dataList item="val" key="key" name="loop"}
    <tr>
        <td>{$smarty.foreach.loop.iteration}</td>
        <td><a href="{make_link action="action_informationStatus_informationData" getTags="isid="|cat:$val.id}" target="_blank">{$val.id}</a></td>
        <td>{$val.name}</td>
        <td>{$val.display_start_datetime}</td>
        <td>{$val.display_end_datetime}</td>
        <td style="text-align:right">{$val.cnt}回</td>
    </tr>
    {/foreach}
</table>
<br><br><br>