{include file=$admHeader}
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
<script type="text/javascript" src="./js/jquery.timepickr.min.js"></script>
<script language="JavaScript">
<!--

    $(function() {ldelim}

        $("#src_table tr:even").addClass("BgColor02");

        {* 時刻入力 *}
        $(".time").timepickr({ldelim}
            format24: "{ldelim}h:02.d{rdelim}:{ldelim}m:02.d{rdelim}",
            rangeMin: ["00","15","30","45"]
        {rdelim});

        {* カレンダー *}
        $(".datepicker").datepicker({ldelim}
            dateFormat: "yy-mm-dd"
        {rdelim});

        {* 戻ったときに日時フォームが入力されていたら表示する *}
        openInput("input[name='mail_reserve_type']:checked");

        $('.reserve').live("click", function(){ldelim}
            openInput("input[name='mail_reserve_type']:checked");
        {rdelim});

        {* 戻ったときに定時メルマガフォームが入力されていたら表示する *}
        openRegulerInput($('.regular'));

        $('.regular').change(function(){ldelim}
            openRegulerInput($(this));
        {rdelim});

        {* タブ *}
        $("#pc_tabs").tabs();

        $( "#pc_tabs" ).bind( "tabsselect", function(event, ui) {ldelim}
                var formId = "pc-tabs-2" + (+new Date());
                var form = $('<form action="./" method="POST" name="' + formId + '" id="' + formId + '" target="pc-tabs-2"></form>');
                $(form).appendTo('body');
                var source = $("<input/>").attr({ldelim}
                    "type": "hidden",
                    "name": "pc_html_contents",
                    "value": $("#pc_html_contents").val()
                {rdelim});
                $(form).append(source);
                var source = $("<input/>").attr({ldelim}
                    "type": "hidden",
                    "name": "action_mail_MailPreview",
                    "value": "1"
                {rdelim});
                $(form).append(source);
                var source = $("<input/>").attr({ldelim}
                    "type": "hidden",
                    "name": "pc",
                    "value": "1"
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
                    "name": "mb_html_contents",
                    "value": $("#mb_html_contents").val()
                {rdelim});
                $(form).append(source);
                var source = $("<input/>").attr({ldelim}
                    "type": "hidden",
                    "name": "action_mail_MailPreview",
                    "value": "1"
                {rdelim});
                $(form).append(source);
                $(form).submit();
                setTimeout(function() {ldelim}
                    $(form).remove();
                {rdelim}, 100);
        {rdelim});

        // 送信確認文言
        $("#mailInput").submit(function(){ldelim}
            if ($("input[name='mail_reserve_type']:checked").val() == 0) {ldelim}
                return confirm("送信しますか？");
            {rdelim} else {ldelim}
                return confirm("設定しますか？");
            {rdelim}
        {rdelim});

    {rdelim});

    {* 入力フォーム表示 *}
    function openInput(selectId) {ldelim}

        var selectId = $(selectId);

        if (selectId.val() == 1) {ldelim}
            $("#reserve_datetime").show("blind", "slow");
            $("#interval").hide();
            $("#regular").hide();
            $("#submit").val("設定する");
        {rdelim} else if (selectId.val() == 2) {ldelim}
            $("#regular").show("blind", "slow");
            $("#reserve_datetime").hide();
            $("#interval").hide();
            $("#submit").val("設定する");
        {rdelim} else if (selectId.val() == 3) {ldelim}
            $("#reserve_datetime").show("blind", "slow");
            $("#interval").hide();
            $("#regular").hide();
            $("#submit").val("設定する");
        {rdelim} else {ldelim}
            $("#interval").show("blind", "slow");
            $("#reserve_datetime").hide();
            $("#regular").hide();
            $("#submit").val("送信する");
        {rdelim}

    {rdelim}

    {* 入力フォーム表示 *}
    function openRegulerInput(selectId) {ldelim}

        var selectId = $(selectId);

        if (selectId.val() == 1) {ldelim}
            $("#regular_day").show();
            $("#regular_hour").hide();
            $("#regular_week").hide();
            $("#regular_month").hide();
        {rdelim} else if (selectId.val() == 2) {ldelim}
            $("#regular_week").show();
            $("#regular_day").hide();
            $("#regular_hour").hide();
            $("#regular_month").hide();
        {rdelim} else if (selectId.val() == 3) {ldelim}
            $("#regular_month").show();
            $("#regular_day").hide();
            $("#regular_hour").hide();
            $("#regular_week").hide();
        {rdelim} else {ldelim}
            $("#regular_hour").show();
            $("#regular_day").hide();
            $("#regular_week").hide();
            $("#regular_month").hide();
        {rdelim}

    {rdelim}

// -->
</script>
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">メルマガ</h2>

{* 更新時エラーコメント *}
{if $errMsg|@count}
    <div class="warning ui-widget">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    <p>
    <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    { foreach from=$errMsg item="val" }
        {$val|@implode:"<br>"}
    {/foreach}
    </p>
    </div>
    </div>
    <br>
{/if}
<form action="./" method="post">
{$POSTparam}
<div class="SubMenu">
    <input type="submit" value="一覧へ戻る" name="action_user_List"/>
</div>
</form>
<table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet04">
<tr><th colspan="2" style="text-align:center;">検索条件</th></tr>
{foreach from=$whereContents item="val" key="key"}
    <tr><td>
    {$key}
    </td>
    <td>
    {$val}
    </td></tr>
{/foreach}
</table>
<br>
<div>
    <a href="{make_link action="action_keyConvert_DispKeyConvertList" getTags=$getTag}" target="_blank">システム変換管理</a>
</div>
<br>
<div>
    <form action="./" method="post" id="mailInput" name="mailInput" enctype="multipart/form-data">
        {$POSTparam}
        <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
        <tr>
            <th colspan="2" style="text-align: center; font-weight: bold;">メール設定</th>
        </tr>
        <tr>
            <th>現在の送信件数</th>
            <td  style="text-align: left;">
                <table>
                    <tr>
                        {if $pcCount AND $mbCount}
                            <td colspan="2" style="text-align: center;">
                        {else}
                            <td style="text-align: center;">
                        {/if}
                      総件数:{$totalCount}件
                    </td>
                    </tr>
                    <tr>
                    {if $pcCount}
                        <td style="text-align: left;">
                            PC総件数:{$pcCount}件
                        </td>
                    {/if}
                    {if $mbCount}
                        <td style="text-align: left;">
                            MB総件数:{$mbCount}件<br>
                        </td>
                    {/if}
                    </tr>
                </table>
                推定送信時間：{$sendTime}{$recommend}
            </td>
        </tr>
        <tr>
            <th>送信アドレス</th>
            <td style="text-align: left;">
                <input type="text" name="from_address" value="{$param.from_address|default:$sendAddress}" size="50" style="ime-mode: disabled;">
            </td>
        </tr>
        <tr>
            <th>送信名</th>
            <td style="text-align: left;">
                <input type="text" name="from_name" value="{$param.from_name}" size="50">
                <br><span style="color:#FF0000;">※iPhoneに送信する場合、「&lt;&gt;」、「【】」、「≪≫」、「半角カタカナ」を含むと送信者名が「不明」または「文字化け」の原因になります。
            </td>
        </tr>
        <tr>
        <th>送信タイプ</th>
        <td style="text-align: left;">
            {html_radios class="reserve" name="mail_reserve_type" options=$mailReserveType selected=$param.mail_reserve_type|default:$defaultMailReserveType separator="&nbsp;"}
            <div id="reserve_datetime">
                <input size="15" class="datepicker" type="text" value="{$param.reserve_datetime_Date|default:$smarty.now|zend_date_format:'yyyy-MM-dd'}" name="reserve_datetime_Date" maxlength="10">
                <input name="reserve_datetime_Time" class="time" type="text" value="{$param.reserve_datetime_Time|date_format:'%H:%M'}" size="7" maxlength="5">
            </div>
            <div id="interval" style="display:none;">
                インターバル(30分を設定してください):<br>{html_options name="interval_second" options=$intervalSecond selected=$param.interval_second|default:2}分
            </div>
            <div id="regular">
                <div id="title">
                    タイトル:<input type="text" name="title" value="{$param.title}" size="50">
                </div>
                {html_options class="regular" name="send_condition_type" options=$sendConditionType selected=$param.send_condition_type|default:1}
                <div id="regular_hour">
                    <input type="text" name="regular_hour_from" value="0" size="2" maxlength="2" style="ime-mode:disabled">時から
                    <input type="text" name="regular_hour_to" value="23" size="2" maxlength="2" style="ime-mode:disabled">時までの
                    {html_options name="regular_second" options=$intervalSecond selected=$param.interval_second}分に送信する
                </div>
                <div id="regular_week">
                    {html_options name="regular_week" options=$config.admin_config.week_array selected=$param.regular_week}
                    <input name="send_time_week" class="time" type="text" value="{$param.send_time_week}" size="7" maxlength="5">に送信する
                </div>
                <div id="regular_month">
                    {html_options name="send_day" options=$dayAry selected=$param.send_day}日
                    <input name="send_time_month" class="time" type="text" value="{$param.send_time_month}" size="7" maxlength="5">に送信する
                </div>
                <div id="regular_day">
                    <input name="send_time_day" class="time" type="text" value="{$param.send_time_day}" size="7" maxlength="5">に送信する
                </div>
            </div>
        </td>
        </tr>
        <tr>
            <th>
                PCメルマガ添付画像
            </th>
            <td style="text-align: left;">
                <input type="text" value='<img src="001">' size="20" class="selectText" readonly> <input type="file" name="pc_image[1]">  <br>        
                <input type="text" value='<img src="002">' size="20" class="selectText" readonly> <input type="file" name="pc_image[2]">  <br>
                <input type="text" value='<img src="003">' size="20" class="selectText" readonly> <input type="file" name="pc_image[3]">  <br>
                <input type="text" value='<img src="004">' size="20" class="selectText" readonly> <input type="file" name="pc_image[4]">  <br>
                <input type="text" value='<img src="005">' size="20" class="selectText" readonly> <input type="file" name="pc_image[5]">  <br>
                <input type="text" value='<img src="006">' size="20" class="selectText" readonly> <input type="file" name="pc_image[6]">  <br>
                <input type="text" value='<img src="007">' size="20" class="selectText" readonly> <input type="file" name="pc_image[7]">  <br>
                <input type="text" value='<img src="008">' size="20" class="selectText" readonly> <input type="file" name="pc_image[8]">  <br>
                <input type="text" value='<img src="009">' size="20" class="selectText" readonly> <input type="file" name="pc_image[9]">  <br>
                <input type="text" value='<img src="010">' size="20" class="selectText" readonly> <input type="file" name="pc_image[10]"> <br>
            </td>
        </tr>
        <tr>
            <th>
                件名(PC)
            </th>
            <td style="text-align: left;">
                <input type="text" name="pc_title" value="{$param.pc_title}" size="50">
            </td>
        </tr>
        <tr>
            <th>
                TEXT本文(PC)
            </th>
            <td style="text-align: left;">
                <textarea name="pc_text_contents" cols="100" rows="30" id="pc_text_contents" wrap="off">{$param.pc_text_contents}</textarea>
            </td>
        </tr>
        <tr>
            <th>
                HTML本文(PC)
            </th>
            <td  style="text-align: left;">
                <div id="pc_tabs">
                    <ul>
                        <li><a href="#pc-tabs-1">source</a></li>
                        <li><a href="#pc-tabs-2">html</a></li>
                    </ul>
                    <div id="pc-tabs-1">
                        <textarea name="pc_html_contents" cols="100" rows="30" id="pc_html_contents" wrap="off">{$param.pc_html_contents}</textarea>
                    </div>
                    <iframe id="pc-tabs-2" name="pc-tabs-2" src="" height="500px"  width="95%"></iframe>
                </div>
            </td>
        </tr>
        <tr>
            <th>
                MBメルマガ添付画像
            </th>
            <td style="text-align: left;">
                <input type="text" value='<img src="001">' size="20" class="selectText" readonly> <input type="file" name="mb_image[1]">  <br>
                <input type="text" value='<img src="002">' size="20" class="selectText" readonly> <input type="file" name="mb_image[2]">  <br>
                <input type="text" value='<img src="003">' size="20" class="selectText" readonly> <input type="file" name="mb_image[3]">  <br>
                <input type="text" value='<img src="004">' size="20" class="selectText" readonly> <input type="file" name="mb_image[4]">  <br>
                <input type="text" value='<img src="005">' size="20" class="selectText" readonly> <input type="file" name="mb_image[5]">  <br>
                <input type="text" value='<img src="006">' size="20" class="selectText" readonly> <input type="file" name="mb_image[6]">  <br>
                <input type="text" value='<img src="007">' size="20" class="selectText" readonly> <input type="file" name="mb_image[7]">  <br>
                <input type="text" value='<img src="008">' size="20" class="selectText" readonly> <input type="file" name="mb_image[8]">  <br>
                <input type="text" value='<img src="009">' size="20" class="selectText" readonly> <input type="file" name="mb_image[9]">  <br>
                <input type="text" value='<img src="010">' size="20" class="selectText" readonly> <input type="file" name="mb_image[10]"> <br>
            </td>
        </tr>

        <tr>
            <th>
                件名(MB)
            </th>
            <td  style="text-align: left;">
                <input type="text" name="mb_title" value="{$param.mb_title}" size="50">
            </td>
        </tr>
        <tr>
            <th>
                TEXT本文(MB)
            </th>
            <td  style="text-align: left;">
                <textarea name="mb_text_contents" cols="100" rows="30" id="mb_text_contents" wrap="off">{$param.mb_text_contents}</textarea>
            </td>
        </tr>
        <tr>
            <th>
                HTML本文(MB)
            </th>
            <td  style="text-align: left;">
                <div id="mb_tabs">
                    <ul>
                        <li><a href="#mb-tabs-1">source</a></li>
                        <li><a href="#mb-tabs-2">html</a></li>
                    </ul>
                    <div id="mb-tabs-1">
                        <textarea name="mb_html_contents" cols="100" rows="30" id="mb_html_contents" wrap="off">{$param.mb_html_contents}</textarea>
                    </div>
                    <iframe id="mb-tabs-2" name="mb-tabs-2" src="" height="500px"  width="95%"></iframe>
                </div>
            </td>
        </tr>
        <tr>
            <td  style="text-align: center;" colspan="2">
                <input type="checkbox" name="reverse_mail_status" value="1" {if $param.reverse_mail_status}checked{/if}/>強行メール
            </td>
        </tr>
        <tr>
            <td  style="text-align: center;" colspan="2">
                ※送信して、何も表示されなくても、<br>バックグラウンドで送信されていますので、注意して下さい。<br>
                <input type="submit" id="submit" name="action_mail_MailSendExec" value="送信する" />
{*
{if $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SYSTEM}
                <input type="submit" id="submit" name="action_mail_TestMailSendExec" value="test送信する" />
{/if}
*}
            </td>
        </tr>
        </table>
    </form>
</div>
{include file=$admFooter}
</div>
</body>
</html>
