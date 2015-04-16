{include file=$admHeader}
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script type="text/javascript">
<!--
    $(function() {ldelim}
        {* テーブルマウスオーバーカラー *}
        $('#list_table').colorize({ldelim}
            altColor :'#CCCCCC',
            hiliteColor :'none'
        {rdelim});

        {* 追加フォーム *}
        if (!{$dispPositionParam.return_flag}) {ldelim}
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
    <h2 class="ContentTitle">情報表示フォルダ更新画面</h2>
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
            <input type="submit" name="action_informationDisplayPosition_InformationCategoryList" value="一覧に戻る" />
        </div>
    </form>
    <br>
    {if $dispParam}
        <form action="./" method="post" enctype="multipart/form-data">
            {$POSTparam}
                <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
                    <tr>
                        <th>フォルダ名</th>
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
                            <input type="submit" name="action_informationDisplayPosition_InformationCategoryExec" value="更 新" OnClick="return confirm('更新しますか？')" />
                        </td>
                    </tr>
                </table>
        </form>
        <br>
        <hr>
        <br>
        <div>
           <a href="{make_link action="action_informationDisplayPosition_InformationDisplayPositionList" getTags=$getTag}" target="contents">表示場所一覧へ</a>
        </div>
        <br>
        <div class="SubMenu">
            <input type="button" id="add_button" value="表示場所追加" />
        </div>
        <div id="add_form" style="display:none">
        <form action="./" method="post" enctype="multipart/form-data">
            {$POSTparam}
            <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
                <tr>
                    <th>表示場所</th>
                    <th>PC表示優先度</th>
                    <th>MB表示優先度</th>
                    <th>表示状態</th>
                    <th></th>
                </tr>
                <tr>
                    <td style="text-align: left;">{html_options name="cd" options=$displayPositionNameList selected=$dispPositionParam.cd}</td>
                    <td style="text-align: left;">
                        <input type="text" name="pc_sort_seq" value="{$dispPositionParam.pc_sort_seq|default:0}" size="10">
                    </td>
                    <td style="text-align: left;">
                        <input type="text" name="mb_sort_seq" value="{$dispPositionParam.mb_sort_seq|default:0}" size="10">
                    </td>
                    <td style="text-align: left;">{html_options name="is_display" options=$isDisplay selected=$dispPositionParam.is_display separator="&nbsp;"}</td>
                    <td><input type="submit" name="action_informationDisplayPosition_InformationDisplayPositionExec" value="登 録" OnClick="return confirm('登録しますか？')" /></td>
                </tr>
            </table>
        </form>
        </div>
        <br>
        {if $dispPositionList}
            <form action="./" method="post" enctype="multipart/form-data">
                {$POSTparam}
                    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet01">
                        <tr>
                            <th>表示場所</th>
                            <th>PC表示優先度</th>
                            <th>MB表示優先度</th>
                            <th>表示状態</th>
                            <th style="text-align:center;">削除<br><input type="checkbox" onclick="$('#list_table input:checkbox').attr('checked', this.checked);" ></th>
                        </tr>
                        {foreach from=$dispPositionList item="val"}
                        <tr>
                            <td style="text-align: left;"><input type="hidden" name="position_id[]" value="{$val.id}">{html_options name=$val.id|string_format:"cd[%s]" options=$displayPositionNameList selected=$val.cd}</td>
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
                        <input type="submit" name="action_informationDisplayPosition_InformationDisplayPositionExec" value="更 新" OnClick="return confirm('更新しますか？')" />
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
