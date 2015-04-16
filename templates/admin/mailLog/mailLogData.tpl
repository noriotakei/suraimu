{include file=$admHeader}
<script language="JavaScript">
<!--

    $(function() {ldelim}

        {* タブ *}
        $(".tabs").tabs();

    {rdelim});

// -->
</script>
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">配信履歴</h2>
<div>
{if $logData}
            <table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet04">
            <tr><th colspan="2" style="text-align:center;">検索条件</th></tr>
            {foreach from=$logData.where_contents item="val" key="key"}
                <tr><th>
                {$key}
                </th>
                <td>
                {$val}
                </td></tr>
            {/foreach}
            </table>
    </div>
    <br>
    <div>
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" width="80%">
        <tr>
            <th>送信件数</th>
            <td >
            <table>
                <tr>
                    <td>
                        PC成功:{$logData.send_total_count_pc}件
                    </td>
                    <td>
                        MB成功:{$logData.send_total_count_mb}件
                    </td>
                </tr>
                <tr>
                    <td>
                        PC失敗:{$logData.send_err_count_pc}件
                    </td>
                    <td>
                        MB失敗:{$logData.send_err_count_mb}件
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        退会済み、ﾌﾞﾗｯｸ未送信:{$logData.err_count}件
                    </td>
                </tr>
                <tr>
                    <td>
                        PCのべアクセス数:{$logData.access_count_pc}件
                    </td>
                    <td>
                        MBのべアクセス数:{$logData.access_count_mb}件
                    </td>
                </tr>
                <tr>
                    <td>
                        PCアクセス率:{$logData.pc_access_percent|default:"0.0"}％
                    </td>
                    <td>
                        MBアクセス率:{$logData.mb_access_percent|default:"0.0"}％
                    </td>
                </tr>
            </table>
            </td>
        </tr>
        <tr>
            <th>インターバル</th>
            <td>
                {$intervalSecond[$logData.interval_second]}分
            </td>
        </tr>
        <tr>
            <th>送信開始時間</th>
            <td>
                {$logData.send_start_datetime}
            </td>
        </tr>
        <tr>
            <th>送信終了時間</th>
            <td>
                {$logData.send_end_datetime}
            </td>
        </tr>
        <tr>
            <th>送信アドレス</th>
            <td>
                {$logData.from_address}
            </td>
        </tr>
        <tr>
            <th>送信名</th>
            <td>
                {$logData.from_name}
            </td>
        </tr>
        <th>送信タイプ</th>
        <td>
            {$mailReserveType[$logData.mail_reserve_type]}
        </td>
        </tr>
        <tr>
            <th>
                件名(PC)
            </th>
            <td>
                {$logData.pc_subject|emoji}
            </td>
        </tr>
        <tr>
            <th>
                TEXT本文(PC)
            </th>
            <td>
                {$logData.pc_text_body|nl2br|emoji}
            </td>
        </tr>
        <tr>
            <th>
                HTML本文(PC)
            </th>
            <td>
                <div class="tabs">
                    <ul>
                        <li><a href="#pc-tabs-1">html</a></li>
                        <li><a href="#pc-tabs-2">view source</a></li>
                    </ul>
                    <iframe id="pc-tabs-1" src="./?action_MailLog_MailLogPreview=1&mlid={$logData.id}&pc=1" height="500px"  width="95%"></iframe>
                    <div id="pc-tabs-2">
                        {$logData.pc_html_body|nl2br|emoji}
                    </div>
                </div>
            </td>
        </tr>
        {if $logData.mb_html_body OR $logData.mb_text_body}
        <tr>
            <th>
                件名(MB)
            </th>
            <td>
                {$logData.mb_subject|emoji}
            </td>
        </tr>
        <tr>
            <th>
                TEXT本文(MB)
            </th>
            <td >
                {$logData.mb_text_body|nl2br|emoji}
            </td>
        </tr>
        <tr>
            <th>
                HTML本文(MB)
            </th>
            <td>
                <div class="tabs">
                    <ul>
                        <li><a href="#mb-tabs-1">html</a></li>
                        <li><a href="#mb-tabs-2">view source</a></li>
                    </ul>
                    <iframe id="mb-tabs-1" src="./?action_MailLog_MailLogPreview=1&mlid={$logData.id}" height="500px"  width="95%"></iframe>
                    <div id="mb-tabs-2">
                        {$logData.mb_html_body|nl2br|emoji}
                    </div>
                </div>
            </td>
        </tr>
        {/if}
    </table>
{/if}
</div>
{include file=$admFooter}
</div>
</body>
</html>
