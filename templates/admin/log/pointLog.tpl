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
<h2 class="ContentTitle">ポイントログリスト</h2>
<table cellspacing="0" cellpadding="0" class="TableSet01" align="center">
    <tr>
        <th>現在ポイント</th>
        <th>合計使用ポイント</th>
        <th>合計付与ポイント</th>
    </tr>
    <tr>
        <td>{$userData.point}pt</td>
        <td>{$userData.total_use_point}pt</td>
        <td>{$userData.total_addition_point}pt</td>
    </tr>
</table>
<br>
<table cellspacing="0" cellpadding="0" class="TableSet01" id="table" align="center">
    <tr>
        <th>処理日時</th>
        <th>種別</th>
        <th>ポイント</th>
        <th>注文ID</th>
        <th>情報ID</th>
    </tr>
    {foreach from=$dataList item="val" key="key" name="loop"}
    <tr>
        <td>{$val.create_datetime}</td>
        <td>{$pointLogType[$val.type]}</td>
        <td>{$val.point}pt</td>
        <td>{$val.ordering_id}</td>
        <td>{$val.information_status_id}</td>
    </tr>
    {/foreach}
</table>

