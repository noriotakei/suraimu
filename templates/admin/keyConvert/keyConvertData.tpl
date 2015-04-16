{include file=$admHeader}
<script language="JavaScript">
<!--
    $(function() {ldelim}

        if ({$keyConvertContentsData.return_flag}) {ldelim}
            $("#add_form").show();
        {rdelim}
        $('#add_button').live("click", function(){ldelim}
            $("#add_form").toggle("blind", null, "slow");
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
<div id="ContentsCol">
<h2 class="ContentTitle">システム変換更新</h2>
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
<div>
<form action="./" method="post">
    <input type="submit" name="action_keyConvert_KeyConvertList" value="一覧へ戻る" style="width:8em;"/>
</form>
<br>
<form action="./" method="POST">
    {$POSTparam}
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
        <tr>
            <th>変換キー</th>
            <td><input type="text" name="key_name" size="30" value="{$keyConvertData.key_name}" style="ime-mode:disabled"></td>
        </tr>
        <tr>
            <th>タイプ</th>
            <td>{html_options name="type" options=$config.admin_config.convert_type_name selected=$keyConvertData.type id="type"}</td>
        </tr>
        <tr>
            <th>カテゴリー</th>
            <td>{html_options name="key_convert_list_category_id" options=$categoryList selected=$keyConvertData.key_convert_list_category_id}</td>
        </tr>
        <tr>
            <th>備考</th>
            <td><input type="text" name="description" size="50" value="{$keyConvertData.description}"></td>
        </tr>
        {if $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SYSTEM}
        <tr>
            <th>更新不可</th>
            <td><input type="checkbox" name="is_not_update" value="1" {if $keyConvertData.is_not_update}checked{/if}></td>
        </tr>
        {/if}
        <tr>
            <td colspan="2" style="text-align:center"><input type="submit" name="action_keyConvert_KeyConvertDataExec" value="更 新" onClick="return confirm('更新しますか？')"/></td>
        </tr>
    </table>
</form>
<br>
<div class="SubMenu">
    <input type="button" id="add_button" value="追　加" />
</div>
<div id="add_form" style="display:none;">
    <form action="./" method="POST">
        {$POSTparam}
        <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
            <tr>
                <th>変換内容</th>
                <th>表示開始日時</th>
                <th>表示終了日時</th>
                <th></th>
            </tr>
            <tr>
                <td><input type="text" name="contents" size="60" value="{$keyConvertContentsData.contents}" class="contents"></td>
                <td>
                        <input name="disp_datetime_from_date" size="15" class="datepicker" type="text" value="{$keyConvertContentsData.display_start_datetime|zend_date_format:'yyyy-MM-dd'}" maxlength="10">
                        <input name="disp_datetime_from_time" class="time" type="text" value="{$keyConvertContentsData.display_start_datetime|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
                </td>
                <td>
                        <input name="disp_datetime_to_date" size="15" class="datepicker" type="text" value="{$keyConvertContentsData.display_end_datetime|zend_date_format:'yyyy-MM-dd'}" maxlength="10">
                        <input name="disp_datetime_to_time" class="time" type="text" value="{$keyConvertContentsData.display_end_datetime|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
                </td>
                <td style="text-align:center"><input type="submit" name="action_keyConvert_KeyConvertContentsDataExec" value="登 録" onClick="return confirm('登録しますか？')"/></td>
            </tr>
        </table>
    </form>
</div>
<br>
{if $keyConvertContentsList}
        <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
            <tr>
                <th>変換内容</th>
                <th>表示開始日時</th>
                <th>表示終了日時</th>
                <th>削除</th>
                <th></th>
            </tr>
            {foreach from=$keyConvertContentsList item="val"}
            <tr>
            <form action="./" method="POST">
                {$POSTparam}
                    <td><input type="hidden" name="convert_contents_id" value="{$val.id}"><input type="text" name="contents" size="60" value="{$val.contents}" class="contents"></td>
                    <td>
                            <input name="disp_datetime_from_date" size="15" class="datepicker" type="text" value="{$val.display_start_datetime|zend_date_format:'yyyy-MM-dd'}" maxlength="10">
                            <input name="disp_datetime_from_time" class="time" type="text" value="{$val.display_start_datetime|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
                    </td>
                    <td>
                            <input name="disp_datetime_to_date" size="15" class="datepicker" type="text" value="{$val.display_end_datetime|zend_date_format:'yyyy-MM-dd'}" maxlength="10">
                            <input name="disp_datetime_to_time" class="time" type="text" value="{$val.display_end_datetime|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
                    </td>
                    <td><input type="checkbox" name="disable" value="1"></td>
                    <td style="text-align:center"><input type="submit" name="action_keyConvert_KeyConvertContentsDataExec" value="更 新" onClick="return confirm('更新しますか？')"/></td>
            </form>
            </tr>
            {/foreach}
        </table>
{/if}
</div>
{include file=$admFooter}
</div>
</body>
</html>