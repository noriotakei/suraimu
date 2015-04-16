{include file=$admHeader}
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
<script type="text/javascript" src="./js/jquery.timepickr.min.js"></script>
<script language="JavaScript">
<!--

    $(function() {ldelim}

        $("#src_table tr:even").addClass("BgColor02");

        {* タブ *}
        $(".tabs").tabs();

        {* カレンダー *}
        $(".datepicker").datepicker({ldelim}
            dateFormat: "yy-mm-dd"
        {rdelim});

        {* 時刻入力 *}
        $(".time").timepickr({ldelim}
            format24: "{ldelim}h:02.d{rdelim}:{ldelim}m:02.d{rdelim}",
            rangeMin: ["00","15","30","45"]
        {rdelim});

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
                    "name": "rvsmlid",
                    "value": {$data.id}
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
                    "name": "rvsmlid",
                    "value": {$data.id}
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
<h2 class="ContentTitle">サポートメール予約配信履歴</h2>
{* コメント *}
{if $msg|@count}
    <div class="warning ui-widget">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    <p>
    <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    { foreach from=$msg item="val" }
        {$val|@implode:"<br>"}
    {/foreach}
    </p>
    </div>
    </div>
    <br>
{/if}
<div>
    <table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet04">
    <tr><th colspan="2" style="text-align:center;">検索条件</th></tr>
    {foreach from=$data.where_contents item="val" key="key"}
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
{* 配信済みなら編集不可 *}
{if $data.is_send}
<div>
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" width="80%">
        <tr>
            <th>送信予定ユーザー数</th>
            <td>
                {$data.send_plans_count}件
            </td>
        </tr>
        <tr>
            <th>作成日時</th>
            <td>
                {$data.create_datetime}
            </td>
        </tr>
        <tr>
            <th>送信状況</th>
            <td>
                配信済み
            </td>
        </tr>
        <tr>
            <th>送信予定日時</th>
            <td>
                {$data.send_datetime}
            </td>
        </tr>        <tr>
            <th>送信アドレス</th>
            <td>
                {$data.from_address}
            </td>
        </tr>
        <tr>
            <th>送信名</th>
            <td>
                {$data.from_name}
            </td>
        </tr>
        <tr>
            <th>
                件名(PC)
            </th>
            <td>
                {$data.pc_subject|emoji}
            </td>
        </tr>
        <tr>
            <th>
                TEXT本文(PC)
            </th>
            <td>
                {$data.pc_text_body|nl2br|emoji}
            </td>
        </tr>
        <tr>
            <th>
                HTML本文(PC)
            </th>
            <td width="70%">
                <div id="pc_tabs">
                    <ul>
                        <li><a href="#pc-tabs-2">html</a></li>
                        <li><a href="#pc-tabs-1">view source</a></li>
                    </ul>
                    <iframe id="pc-tabs-2" name="pc-tabs-2" src="./?action_mailLog_MailLogPreview=1&pc=1&rvsmlid={$data.id}" height="500px" width="95%"></iframe>
                    <div id="pc-tabs-1">
                        {$data.pc_html_body|nl2br|emoji}
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <th>
                件名(MB)
            </th>
            <td>
                {$data.mb_subject|emoji}
            </td>
        </tr>
        <tr>
            <th>
                TEXT本文(MB)
            </th>
            <td >
                {$data.mb_text_body|nl2br|emoji}
            </td>
        </tr>
        <tr>
            <th>
                HTML本文(MB)
            </th>
            <td width="70%">
                <div id="mb_tabs">
                    <ul>
                        <li><a href="#mb-tabs-2">html</a></li>
                        <li><a href="#mb-tabs-1">view source</a></li>
                    </ul>
                    <iframe id="mb-tabs-2" name="mb-tabs-2" src="./?action_mailLog_MailLogPreview=1&rvsmlid={$data.id}" height="500px" width="95%"></iframe>
                    <div id="mb-tabs-1">
                        {$data.mb_html_body|nl2br|emoji}
                    </div>
                </div>
            </td>
        </tr>
    </table>
    </div>
{* 未配信 *}
{else if $data}
    <div>
        <a href="{make_link action="action_keyConvert_DispKeyConvertList" getTags=$getTag}" target="_blank">システム変換管理</a>
    </div>
    <br>
    <div>
    <form action="./" method="post" id="mailInput" name="mailInput" enctype="multipart/form-data">
    {$POSTparam}
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
        <tr>
            <th>送信予定ユーザー数</th>
            <td colspan="2">
                {$data.send_plans_count}件
            </td>
        </tr>
        <tr>
            <th>作成日時</th>
            <td colspan="2">
                {$data.create_datetime}
            </td>
        </tr>
        <tr>
            <th>送信状況</th>
            <td colspan="2">
                未配信
            </td>
        </tr>
        <tr>
            <th>送信予定日時</th>
            <td colspan="2">
                <input size="15" class="datepicker" type="text" value="{$data.send_datetime|zend_date_format:'yyyy-MM-dd'}" name="reserve_datetime_Date" maxlength="10">
                <input name="reserve_datetime_Time" class="time" type="text" value="{$data.send_datetime|date_format:'%H:%M'}" size="7" maxlength="5">
            </td>
        </tr>
        <tr>
            <th>送信アドレス</th>
            <td colspan="2">
                <input type="text" name="from_address" value="{$data.from_address}" size="50" style="ime-mode: disabled;">
            </td>
        </tr>
        <tr>
            <th>送信名</th>
            <td colspan="2">
                <input type="text" name="from_name" value="{$data.from_name}" size="50">
            </td>
        </tr>
        <tr>
            <th>
                PC添付画像
            </th>
            <td style="text-align: left;">
                <input type="text" value='<img src="001">' size="20" class="selectText" readonly> <input type="file" name="pc_image[1]"><br>
                <input type="text" value='<img src="002">' size="20" class="selectText" readonly> <input type="file" name="pc_image[2]"><br>
                <input type="text" value='<img src="003">' size="20" class="selectText" readonly> <input type="file" name="pc_image[3]"><br>
                <input type="text" value='<img src="004">' size="20" class="selectText" readonly> <input type="file" name="pc_image[4]"><br>
                <input type="text" value='<img src="005">' size="20" class="selectText" readonly> <input type="file" name="pc_image[5]"><br>
            </td>
        </tr>
        <tr>
            <th>
                件名(PC)
            </th>
            <td colspan="2">
                <input type="text" name="pc_subject" value="{$data.pc_subject}" size="50">
            </td>
        </tr>
        <tr>
            <th>
                TEXT本文(PC)
            </th>
            <td colspan="2">
                <textarea name="pc_text_body" cols="100" rows="30" id="pc_text_body" wrap="off">{$data.pc_text_body}</textarea>
            </td>
        </tr>
        <tr>
            <th>
                HTML本文(PC)
            </th>
            <td>
                <div id="pc_tabs">
                    <ul>
                        <li><a href="#pc-tabs-1">source</a></li>
                        <li><a href="#pc-tabs-2">html</a></li>
                    </ul>
                    <div id="pc-tabs-1">
                        <textarea name="pc_html_body" cols="100" rows="30" id="pc_html_body" wrap="off">{$data.pc_html_body}</textarea>
                    </div>
                    <iframe id="pc-tabs-2" name="pc-tabs-2" src="" height="500px"  width="95%"></iframe>
                </div>
            </td>
        </tr>
        <tr>
            <th>
                MB添付画像
            </th>
            <td style="text-align: left;">
                <input type="text" value='<img src="001">' size="20" class="selectText" readonly> <input type="file" name="mb_image[1]"><br>
                <input type="text" value='<img src="002">' size="20" class="selectText" readonly> <input type="file" name="mb_image[2]"><br>
                <input type="text" value='<img src="003">' size="20" class="selectText" readonly> <input type="file" name="mb_image[3]"><br>
                <input type="text" value='<img src="004">' size="20" class="selectText" readonly> <input type="file" name="mb_image[4]"><br>
                <input type="text" value='<img src="005">' size="20" class="selectText" readonly> <input type="file" name="mb_image[5]"><br>
            </td>
        </tr>
        <tr>
            <th>
                件名(MB)
            </th>
            <td colspan="2">
                <input type="text" name="mb_subject" value="{$data.mb_subject}" size="50">
            </td>
        </tr>
        <tr>
            <th>
                TEXT本文(MB)
            </th>
            <td colspan="2">
                <textarea name="mb_text_body" cols="100" rows="30" id="mb_text_body" wrap="off">{$data.mb_text_body}</textarea>
            </td>
        </tr>
        <tr>
            <th>
                HTML本文(MB)
            </th>
            <td>
                <div id="mb_tabs">
                    <ul>
                        <li><a href="#mb-tabs-1">source</a></li>
                        <li><a href="#mb-tabs-2">html</a></li>
                    </ul>
                    <div id="mb-tabs-1">
                        <textarea name="mb_html_body" cols="100" rows="30" id="mb_html_body" wrap="off">{$data.mb_html_body}</textarea>
                    </div>
                    <iframe id="mb-tabs-2" name="mb-tabs-2" src="" height="500px"  width="95%"></iframe>
                </div>
            </td>
        </tr>
        <tr>
            <td  style="text-align: center;" colspan="3">
                <input type="submit" id="submit" name="action_ordering_ReserveSupportMailDataExec" value="設定する" />
            </td>
        </tr>
    </table>
    </form>
    </div>
{/if}
{include file=$admFooter}
</div>
</body>
</html>
