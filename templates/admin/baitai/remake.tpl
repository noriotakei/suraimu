{include file=$admBaitaiHeader}

<script language="JavaScript">
<!--

    $(function() {ldelim}

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
    <h2 class="ContentTitle">媒体CHK再集計</h2>
    <p id="Logout"><a href="{make_link action="action_baitai_Logout" getTags=$getTag}" target="_top">Logout</a></p>
    <br>
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
        <table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet04">
            <tr>
                <th colspan="2" style="text-align: center; font-weight: bold;">集計条件</th>
            </tr>
            <tr>
                <th>日付</th>
                <td>
                    <input size="15" class="datepicker" type="text" value="{$value.date|zend_date_format:'yyyy-MM-dd'}" name="date" maxlength="10">
                </td>
            </tr>
            <tr>
                <th>広告コード(任意)</th>
                <td>
                    <input type="text" id="media_cd" name="media_cd" value="{$value.media_cd}" size="20" style="ime-mode:disabled;">
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center">
                        <input type="submit" name="action_baitai_RemakeExec" value="再集計" OnClick="return confirm('再集計しますか？')">
                </td>
            </tr>
        </table>
    </form>
    <br>
{include file=$admFooter}
</div>
</body>
</html>
