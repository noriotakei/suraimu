<script language="JavaScript">
<!--
    $(function() {ldelim}
        {* テーブルストライプ *}
        $("#table tr:even").addClass("BgColor02");
    {rdelim});
// -->
</script>
<h2 class="ContentTitle">会員数合計</h2>
<table cellspacing="0" cellpadding="0" class="TableSet02" align="center">
    <tr>
        <th colspan="4">メール送信可否</th>
    </tr>
    <tr>
        <th>PCメールOK</th>
        <th>PCメールNG</th>
        <th>MBメールOK</th>
        <th>MBメールNG</th>
    </tr>
    <tr>
        <td>{$dispDataList.send_ok_pc|default:0}件</td>
        <td>{$dispDataList.send_ng_pc|default:0}件</td>
        <td>{$dispDataList.send_ok_mb|default:0}件</td>
        <td>{$dispDataList.send_ng_mb|default:0}件</td>
    </tr>
</table>
<br>
<table cellspacing="0" cellpadding="0" class="TableSet02" id="table" align="center">
    <tr>
        <th>総会員人数</th>
        <th>本登録人数</th>
        <th>仮登録人数</th>
        <th>解除会員人数</th>
    </tr>
    <tr>
        <td>{$dispDataList.all_user|default:0}人</td>
        <td>{$dispDataList.user|default:0}人</td>
        <td>{$dispDataList.pre_user|default:0}人</td>
        <td>{$dispDataList.quit_user|default:0}人</td>
    </tr>
</table>
<br><br><br>