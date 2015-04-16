{include file=$admHeader}
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script type="text/javascript">
<!--
    $(function() {ldelim}
        $('.selectText').click(function(){ldelim}
        $(this).select();
        {rdelim});

        {* テーブルマウスオーバーカラー *}
        $('#list_table').colorize({ldelim}
            altColor :'#CCCCCC',
            hiliteColor :'none'
        {rdelim});

        {* 追加フォーム *}
        if (!{$infoFolderParam.return_flag}) {ldelim}
            $("#add_form").hide();
        {rdelim} else {ldelim}
            $("#add_form").show();
        {rdelim}
        $('#add_button').live("click", function(){ldelim}
            $("#add_form").toggle("blind", null, "slow");
        {rdelim});
    {rdelim});
//-->
</script>
</head>
<body>
<div id="ContentsCol">
    <h2 class="ContentTitle">情報リストグループ更新画面</h2>
    {* 更新時エラーコメント *}
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
    {/if}
    <form action="./" method="post">
        <div class="SubMenu">
            <input type="submit" name="action_informationListManagement_InformationListGroup" value="一覧に戻る" />
        </div>
    </form>
    <br>
    {if $dispParam}
        <form action="./" method="post" enctype="multipart/form-data">
            {$POSTparam}
                <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
                    <tr>
                        <th>ID</th>
                        <td style="text-align: left;font-size:large;">
                            <b>{$dispParam.id}</b>
                        </td>
                    </tr>
                    <tr>
                        <th>アクセスキー</th>
                        <td style="text-align: left;font-size:large;">
                            <b>{$dispParam.access_key}</b>
                        </td>
                    </tr>
                    <tr>
                        <th>アクセスURL</th>
                        <td style="text-align: left;">
                            <b><input type="text" class="selectText" size="80" name="" value="{$accessUrl}" readonly></b>
                        </td>
                    </tr>
                    <tr>
                        <th>グループ名</th>
                        <td style="text-align: left;">
                            <input type="text" name="name" value="{$dispParam.name}" size="50">
                        </td>
                    </tr>
                    <tr>
                        <th>表示優先度</th>
                        <td style="text-align: left;">
                            <input type="text" name="sort_seq" value="{$dispParam.sort_seq}" size="10">
                        </td>
                    </tr>
                    <tr>
                        <th>表示状態</th>
                        <td style="text-align: left;">{html_options name="is_display" options=$isDisplay selected=$dispParam.is_display separator="&nbsp;"}</td>
                    </tr>
                    <tr>
                        <td style="text-align: center;" colspan="2">
                            <input type="hidden" name="id" value="{$dispParam.id}">
                            <input type="hidden" name="access_key" value="{$dispParam.access_key}">
                            <input type="submit" name="action_informationListManagement_InformationListGroupExec" value="更 新" OnClick="return confirm('更新しますか？')" />
                        </td>
                    </tr>
                </table>
        </form>
        <br>
        <hr>
        <br>
        <div>
           <a href="{make_link action="action_informationDisplayPosition_InformationCategoryList" getTags=$getTag}" target="_blank">フォルダ一覧へ</a>
        </div>
        <br>
        <div class="SubMenu">
            <input type="button" id="add_button" value="情報フォルダ関連付け" />
        </div>
        <div id="add_form" style="display:none">
        <form action="./" method="post" enctype="multipart/form-data">
            {$POSTparam}
            <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
                <tr>
                    <th>情報フォルダ</th>
                    <th>PC表示優先度</th>
                    <th>MB表示優先度</th>
                    <th>表示状態</th>
                    <th></th>
                </tr>
                <tr>
                    <td style="text-align: left;">{html_options name="folder_id" options=$infoFolderList selected=$infoFolderParam.id}</td>
                    <td style="text-align: left;">
                        <input type="text" name="pc_sort_seq" value="{$infoFolderParam.pc_sort_seq|default:0}" size="10">
                    </td>
                    <td style="text-align: left;">
                        <input type="text" name="mb_sort_seq" value="{$infoFolderParam.mb_sort_seq|default:0}" size="10">
                    </td>
                    <td style="text-align: left;">{html_options name="is_display" options=$isDisplay selected=$infoFolderParam.is_display separator="&nbsp;"}</td>
                    <td><input type="submit" name="action_informationListManagement_InformationListSettingExec" value="登 録" OnClick="return confirm('登録しますか？')" /></td>
                </tr>
            </table>
        </form>
        </div>
        <br>
        {if $infomationListSettingList}
            <form action="./" method="post" enctype="multipart/form-data">
                {$POSTparam}
                    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet01">
                        <tr>
                            <th>情報フォルダ</th>
                            <th>PC表示優先度</th>
                            <th>MB表示優先度</th>
                            <th>表示状態</th>
                            <th style="text-align:center;">削除<br><input type="checkbox" onclick="$('#list_table input:checkbox').attr('checked', this.checked);" ></th>
                        </tr>
                        {foreach from=$infomationListSettingList item="val"}
                        <tr>
                            <td style="text-align: left;"><input type="hidden" name="sid[{$val.id}]" value="{$val.id}">{html_options name=$val.id|string_format:"fid[%s]" options=$infoFolderList selected=$val.information_category_id}</td>
                            <td style="text-align: left;">
                                <input type="text" name="pc_sort_seq[{$val.id}]" value="{$val.pc_sort_seq}" size="10">
                            </td>
                            <td style="text-align: left;">
                                <input type="text" name="mb_sort_seq[{$val.id}]" value="{$val.mb_sort_seq}" size="10">
                            </td>
                            <td style="text-align: left;">{html_options name=$val.id|string_format:"is_display[%s]" options=$isDisplay selected=$val.is_display|default:1 separator="&nbsp;"}</td>
                            <td style="text-align:center;">
                                <input type="checkbox" name="disable[{$val.id}]" value="1">
                            </td>
                        </tr>
                        {/foreach}
                    </table>
                    <div class="SubMenu">
                        <input type="submit" name="action_informationListManagement_InformationListSettingExec" value="更 新" OnClick="return confirm('更新しますか？')" />
                    </div>
            </form>
        {/if}
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
