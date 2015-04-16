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
<h2 class="ContentTitle">情報アクセスログリスト</h2>
<table cellspacing="0" cellpadding="0" class="TableSet01" id="table" align="center">
    <tr>
        <th>情報ID</th>
        <th>タイトル</th>
        <th>消費ポイント</th>
        <th>付与ポイント</th>
        <th>既読日時</th>
    </tr>
    {foreach from=$dataList item="val" key="key" name="loop"}
    <tr>
        <td><a href="{make_link action="action_informationStatus_informationData" getTags="isid="|cat:$val.id|cat:$URLparam}" target="_blank">{$val.id}</a></td>
        <td>{$val.name}pt</td>
        <td>{$val.point}</td>
        <td>{$val.bonus_point}</td>
        <td>{$val.log_create_datetime}</td>
    </tr>
    {/foreach}
</table>

