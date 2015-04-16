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
<h2 class="ContentTitle">入金発行タグログリスト</h2>
<table cellspacing="0" cellpadding="0" class="TableSet01" id="table" align="center">
    <tr>
        <th>媒体コード</th>
        <th>発行タグURL</th>
        <th>発行日時</th>
    </tr>
    {foreach from=$dataList item="val" key="key" name="loop"}
    <tr>
        <td>{$val.media_cd}</td>
        <td>{$val.affiliate_tag_url}</td>
        <td>{$val.create_datetime}</td>
    </tr>
    {/foreach}
</table>

