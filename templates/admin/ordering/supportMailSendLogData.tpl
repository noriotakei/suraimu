{include file=$admHeader}
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
<script type="text/javascript" src="./js/jquery.timepickr.min.js"></script>
<script language="JavaScript">
<!--
    $(function() {ldelim}
        {* タブ *}
        $("#pc_tabs").tabs();

        $( "#pc_tabs" ).bind( "tabsselect", function(event, ui) {ldelim}
                var formId = "pc-tabs-2" + (+new Date());
                var form = $('<form action="./" method="POST" name="' + formId + '" id="' + formId + '" target="pc-tabs-2"></form>');
                $(form).appendTo('body');
                var source = $("<input/>").attr({ldelim}
                    "type": "hidden",
                    "name": "pc_html_body",
                    "value": $("#pc_html_body").val()
                {rdelim});
                $(form).append(source);
                var source = $("<input/>").attr({ldelim}
                    "type": "hidden",
                    "name": "action_mailLog_MailLogPreview",
                    "value": "1"
                {rdelim});
                $(form).append(source);
                var source = $("<input/>").attr({ldelim}
                    "type": "hidden",
                    "name": "pc",
                    "value": "1"
                {rdelim});
                $(form).append(source);
                var source = $("<input/>").attr({ldelim}
                    "type": "hidden",
                    "name": "ssmlid",
                    "value": {$logData.id}
                {rdelim});
                $(form).append(source);
                $(form).submit();
                setTimeout(function() {ldelim}
                    $(form).remove();
                {rdelim}, 100);
        {rdelim});

        {* タブ *}
        $("#mb_tabs").tabs();

        $( "#mb_tabs" ).bind( "tabsselect", function(event, ui) {ldelim}
                var formId = "mb-tabs-2" + (+new Date());
                var form = $('<form action="./" method="POST" name="' + formId + '" id="' + formId + '" target="mb-tabs-2"></form>');
                $(form).appendTo('body');
                var source = $("<input/>").attr({ldelim}
                    "type": "hidden",
                    "name": "mb_html_body",
                    "value": $("#mb_html_body").val()
                {rdelim});
                $(form).append(source);
                var source = $("<input/>").attr({ldelim}
                    "type": "hidden",
                    "name": "action_mailLog_MailLogPreview",
                    "value": "1"
                {rdelim});
                $(form).append(source);
                var source = $("<input/>").attr({ldelim}
                    "type": "hidden",
                    "name": "ssmlid",
                    "value": {$logData.id}
                {rdelim});
                $(form).append(source);
                $(form).submit();
                setTimeout(function() {ldelim}
                    $(form).remove();
                {rdelim}, 100);
        {rdelim});

        // 送信確認文言
        $("#mailInput").submit(function(){ldelim}
            return confirm("設定しますか？");
        {rdelim});

    {rdelim});
// -->
</script>

</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">サポートメール配信履歴</h2>
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
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" width="60%">
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
                        その他未送信:{$logData.err_count}件
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
            <td width="100%">
                <div id="pc_tabs">
                    <ul>
                        <li><a href="#pc-tabs-2">html</a></li>
                        <li><a href="#pc-tabs-1">view source</a></li>
                    </ul>
                    <iframe id="pc-tabs-2" name="pc-tabs-2" src="./?action_mailLog_MailLogPreview=1&pc=1&ssmlid={$logData.id}" height="500px" width="95%"></iframe>
                    <div id="pc-tabs-1">
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
            <td width="100%">
                <div id="mb_tabs">
                    <ul>
                        <li><a href="#mb-tabs-2">html</a></li>
                        <li><a href="#mb-tabs-1">view source</a></li>
                    </ul>
                    <iframe id="mb-tabs-2" name="mb-tabs-2" src="./?action_mailLog_MailLogPreview=1&ssmlid={$logData.id}" height="500px" width="95%"></iframe>
                    <div id="mb-tabs-1">
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
