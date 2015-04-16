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
                    "name": "smlid",
                    "value": {$supportMailData.id}
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
                    "name": "smlid",
                    "value": {$supportMailData.id}
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
<div class="BlockCol">
    <h2 class="ContentTitle">サポートメールログ</h2>
    {* 更新時エラーコメント *}
    {if $execMsg|@count}
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
        <br>
    {/if}
    <form action="./" method="post">
        {$POSTparam}
        <input type="submit" name="action_ordering_OrderingData" value="注文詳細へ戻る" style="width:8em;"/>
    </form>
    <br>
    {if $supportMailData}
        <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">
            <tr>
                <th>作成日時</th>
                <td style="text-align: left;">
                    {$supportMailData.create_datetime}
                </td>
            </tr>
            <tr>
                <th>送信元アドレス</th>
                <td style="text-align: left;">
                    {$supportMailData.from_address}
                </td>
            </tr>
            <tr>
                <th>送信者名</th>
                <td style="text-align: left;">
                    {$supportMailData.from_name}
                </td>
            </tr>
            {if "pc_address"|in_array:$displayUserDetail}
            <tr>
                <th>送信PCアドレス</th>
                <td style="text-align: left;">{$supportMailData.pc_to_address}</td>
            </tr>
            {/if}
            {if "mb_address"|in_array:$displayUserDetail}
            <tr>
                <th>送信MBアドレス</th>
                <td style="text-align: left;">{$supportMailData.mb_to_address}</td>
            </tr>
            {/if}
            <tr>
                <th>PC件名</th>
                <td style="text-align: left;">
                    {$supportMailData.pc_subject}
                </td>
            </tr>
            <tr>
                <th>PCTEXT本文</th>
                <td style="text-align: left;">
                    {$supportMailData.pc_text_body|nl2br}
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
                        <iframe id="pc-tabs-2" name="pc-tabs-2" src="./?action_mailLog_MailLogPreview=1&pc=1&smlid={$supportMailData.id}" height="500px" width="95%"></iframe>
                        <div id="pc-tabs-1">
                            {$supportMailData.pc_html_body|emoji|escape:'html'}
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th>MB件名</th>
                <td style="text-align: left;">
                    {$supportMailData.mb_subject}
                </td>
            </tr>
            <tr>
                <th>MBTEXT本文</th>
                <td style="text-align: left;">
                    {$supportMailData.mb_text_body|nl2br}
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
                        <iframe id="mb-tabs-2" name="mb-tabs-2" src="./?action_mailLog_MailLogPreview=1&smlid={$supportMailData.id}" height="500px" width="95%"></iframe>
                        <div id="mb-tabs-1">
                            {$supportMailData.mb_html_body|emoji|escape:'html'}
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    {else}
        <div class="warning ui-widget">
        <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
        <p>
        <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
        該当データはありません
        </p>
        </div>
    {/if}
{include file=$admFooter}
</div>
</body>
</html>
