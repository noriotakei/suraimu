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
<h2 class="ContentTitle">フリーワードデータ</h2>
<br>
<table cellspacing="0" cellpadding="0" class="TableSet01" id="table" align="center">
    <tr>
        <th colspan="3" style="text-align: center; font-weight: bold;">数字選択</th>
    </tr>
    {foreach from=$freeWord item="val" key="key" name="loop"}
    <tr>
        <th>ﾕｰｻﾞｰ表示％変換</th>
        <th>ﾕｰｻﾞｰ入力値</th>
        <th>処理日時</th>
    </tr>
    <tr>
        <td>-%free_word_1_{$val.free_word_cd}-</td>
        <td>{$val.free_word_value}</td>
        <td>{$val.update_datetime}</td>
    </tr>
    {/foreach}
</table>
<br>
<br>
<table cellspacing="0" cellpadding="0" class="TableSet01" id="table" align="center">
    <tr>
        <th colspan="3" style="text-align: center; font-weight: bold;">文言選択</th>
    </tr>
    {foreach from=$freeWordSet item="val" key="key" name="loop"}
    <tr>
        <th>ﾕｰｻﾞｰ表示％変換</th>
        <th>ﾕｰｻﾞｰ入力値</th>
        <th>処理日時</th>
    </tr>
    <tr>
        <td>-%free_word_2_{$val.free_word_cd}-</td>
        <td>{$val.free_word_text}</td>
        <td>{$val.update_datetime}</td>
    </tr>
    {/foreach}
</table>

