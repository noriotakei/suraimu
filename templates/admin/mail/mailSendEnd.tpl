{include file=$admHeader}
</head>
<body>
<div id="ContentsCol">
{if $execMsg|@count}
<h2 class="ContentTitle">メルマガ：設定完了</h2>
    <div class="warning ui-widget">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    <p>
    <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    { foreach from=$execMsg item="val" }
        {$val|@implode:"<br>"}
    {/foreach}
    </p>
    </div>
    </div>
{else}
<h2 class="ContentTitle">メルマガ：送信完了</h2>
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
        <tr>
            <th>PC送信成功</th>
            <th>PC送信失敗</th>
            <th>MB送信成功</th>
            <th>MB送信失敗</th>
            <th>退会済み、ﾌﾞﾗｯｸ未送信</th>
        </tr>
        <tr>
            <td>{$logData.send_total_count_pc}件</td>
            <td>{$logData.send_err_count_pc}件</td>
            <td>{$logData.send_total_count_mb}件</td>
            <td>{$logData.send_err_count_mb}件</td>
            <td>{$logData.err_count}件</td>
        </tr>
    </table>
{/if}
<form action="./" method="post">
{$POSTparam}
<div class="SubMenu">
    <input type="submit" value="一覧へ戻る" name="action_user_List"/>
</div>
</form>
{include file=$admFooter}
</div>
</body>
</html>