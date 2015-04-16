{include file=$admHeader}
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
<script type="text/javascript" src="./js/jquery.timepickr.min.js"></script>
<script language="JavaScript">
<!--
    $(function() {ldelim}

        {* 時刻入力 *}
        $(".time").timepickr({ldelim}
            format24: "{ldelim}h:02.d{rdelim}:{ldelim}m:02.d{rdelim}:{ldelim}s:02.d{rdelim}",
            seconds: true,
            rangeMin: ["00","05","10","15","20","25","30","35","40","45","50","55","59"],
            rangeSec: ["00","15","30","45","59"],
            convention: 24,
            resetOnBlur : false
        {rdelim});

        {* カレンダー *}
        $(".datepicker").datepicker({ldelim}
            dateFormat: "yy-mm-dd"
        {rdelim});

    {rdelim});
// -->
</script>
</head>
<body>
<div class="BlockCol">
    <h2 class="ContentTitle">サイト表示設定データ</h2>
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
        <input type="submit" name="action_siteContents_SiteContentsList" value="一覧へ戻る" style="width:8em;"/>
    </form>
    <br>
    <div>
        <a href="{make_link action="action_keyConvert_DispKeyConvertList" getTags=$getTag}" target="_blank">システム変換管理</a>
    </div>
    <br>
    <form action="./" method="post">
        {$POSTparam}
        <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">
            <tr>
                <th>表示場所</th>
                <td>{html_options name="display_cd" options=$disableCd selected=$siteContentsData.display_cd separator="&nbsp;"}</td>
            </tr>
            <tr>
                <th>タイトル</th>
                <td><input type="text" name="title" value="{$siteContentsData.title}" size="30"></td>
            </tr>
            <tr>
                <th>HTML内容(PC)</th>
                <td><textarea name="html_contents_pc" rows="30" cols="50">{$siteContentsData.html_contents_pc}</textarea></td>
            </tr>
            <tr>
                <th>HTML内容(MB)</th>
                <td><textarea name="html_contents_mb" rows="30" cols="50">{$siteContentsData.html_contents_mb}</textarea></td>
            </tr>
            <tr>
                <th>表示状態</th>
                <td>{html_radios name="is_display" options=$displayFlag selected=$siteContentsData.is_display|default:0 separator="&nbsp;"}</td>
            </tr>
            <tr>
                <th>表示開始日時</th>
                <td>
                    <input size="15" class="datepicker" type="text" value="{$siteContentsData.start_datetime|zend_date_format:'yyyy-MM-dd'}" name="start_datetime_Date" maxlength="10">
                    <input name="start_datetime_Time" class="time" type="text" value="{$siteContentsData.start_datetime|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
                </td>
            </tr>
            <tr>
                <th>表示終了日時</th>
                <td>
                    <input size="15" class="datepicker" type="text" value="{$siteContentsData.end_datetime|zend_date_format:'yyyy-MM-dd'}" name="end_datetime_Date" maxlength="10">
                    <input name="end_datetime_Time" class="time" type="text" value="{$siteContentsData.end_datetime|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
                </td>
            </tr>
            <tr>
                <td style="text-align:center;" colspan="2">
                    {if $siteContentsData.id}
                        <input type="submit" name="action_siteContents_SiteContentsDataExec" value="変 更" OnClick="return confirm('変更しますか？')" style="width:8em;"/>
                    {else}
                        <input type="submit" name="action_siteContents_SiteContentsDataExec" value="登 録" OnClick="return confirm('登録しますか？')" style="width:8em;"/>
                    {/if}
                </td>
            </tr>
        </table>
    </form>
{include file=$admFooter}
</div>
</body>
</html>
