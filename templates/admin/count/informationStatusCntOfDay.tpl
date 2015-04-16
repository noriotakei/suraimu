<script language="JavaScript">
<!--
    $(function() {ldelim}
        {* テーブルストライプ *}
        $("#table tr:even").addClass("BgColor02");
    {rdelim});
// -->
</script>
<h2 class="ContentTitle">情報閲覧回数リスト(日毎)</h2>
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th>閲覧日付</th>
        <th>ID</th>
        <th>管理用情報名</th>
        <th>閲覧回数</th>
    </tr>
    {foreach from=$dataList item="val" key="key" name="loop"}
    {assign var="weekNum" value=$val.create_date|zend_date_format:'e'}
    <tr>
        <td>{$val.create_date|zend_date_format:'yyyy年MM月dd日'}({$weekArray[$weekNum]})</td>
        <td><a href="{make_link action="action_informationStatus_informationData" getTags="isid="|cat:$val.id}" target="_blank">{$val.id}</a></td>
        <td>{$val.name}</td>
        <td style="text-align:right">{$val.cnt}回</td>
    </tr>
    {/foreach}
</table>
<br><br><br>