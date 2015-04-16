{include file=$admHeader}
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
<link type="text/css" href="./css/pager.css" rel="stylesheet" />
</head>
<body>

<div id="ContentsCol">
<h2 class="ContentTitle">月額コース一覧</h2>
<form action="./" method="POST">
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" id="src_table">
        <tr>
            <th colspan="2" style="text-align: center; font-weight: bold;">検索条件</th>
        </tr>
        <tr>
            <td>グループ</td>
            <td>{html_options name="search_group_id" options=$searchMonthlyCourseGroupList selected=$param.search_group_id}</td>
        </tr>
        <tr>
            <td>検索対象</td>
            <td>{html_options name="search_type" options=$searchTypeAry selected=$param.search_type id="search_type"}
                <div id="keyword_id" style="display:none;">
                    <input type="text" name="search_course_id" value="{$param.search_course_id}" size="15">
                </div>
                <div id="keyword" style="display:none;">
                    {html_radios name="specify_keyword" options=$specifyKeywordAry selected=$param.specify_keyword|default:0 separator="&nbsp;"}
                    <input type="text" name="search_string" value="{$param.search_string}" size="30">
                </div>
            </td>
        </tr>
        <tr>
            <td style="text-align:center;" colspan="2">
                <input type="hidden" name="sort_id" value="{$param.sort_id}" />
                <input type="hidden" name="sort_seq" value="{$param.sort_seq}">
                <input type="submit" name="action_MonthlyCourse_courseSearchList" value="検 索" style="width:8em;"/>
            </td>
        </tr>
    </table>
</form>

{* 更新時エラーコメント *}
{if $msg|@count}
    <br>
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
<br>

{if $monthlyCourseList}
    <div style="padding-bottom: 10px;">
    登録済み：{$totalCount}件<br />
    {$dispFirst}～{$dispLast}件表示しています
    {if $pager}
    <ul class="pager">
        <li>{$pager.previous}</li>
        <li>{$pager.pages|@implode:"</li><li>"}</li>
        <li>{$pager.next}</li>
    </ul>
    {/if}
    </div>
    <form action="./" method="post" style="margin:2px 0px;">
    {$searchParam}
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" >
        <tr>
            <th colspan="2" style="text-align: center; font-weight: bold;">月額コースデータ一括操作</th>
        </tr>
        <tr>
            <td>操作内容</td>
            <td>{html_options name="update_type" options=$batchOperateMonthlyCourseSelectAry selected=$param.updateSelect|default:0 id="update_type"}
                <div id="category_list" style="display:none;">
                    {html_options name="chg_group_id" options=$groupList selected=$param.chg_group_id|default:1}&nbsp;に変更
                </div>
                <div id="chg_display" style="display:none;">
                    {html_options name="chg_display_id" options=$isDisplay selected=0}&nbsp;に変更
                </div>
            </td>
        </tr>
        <tr>
            <td style="text-align:center;" colspan="2">
                <input type="submit" name="action_MonthlyCourse_CourseExec" value="更新" onClick="return confirm('更新しますか?')">
            </td>
        </tr>
    </table>
    <br>
    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">
        <tr bgcolor="#FF9933">
           <th><a href="{make_link action="action_MonthlyCourse_courseSearchList" getTags="sort_id="|cat:$sort.sort_id|cat:$sortParam}">ＩＤ</a></th>
           <th>管理用コース名</th>
           <th>グループ</th>
           <th><a href="{make_link action="action_MonthlyCourse_courseSearchList" getTags="sort_seq="|cat:$sort.sort_seq|cat:$sortParam}">表示優先順位</a></th>
           <th>管理用コメント</th>
           <th style="text-align:center;"><input type="checkbox" onclick="$('#list_table input:checkbox').attr('checked', this.checked);" ></th>
        </tr>
        {foreach from=$monthlyCourseList item="val"}
            {cycle values="#CCCCCC," assign="tr_tag"}
            {if $val.not_display_flag}
                {assign var="tr_tag" value="#FF3333"}
            {/if}
            <tr bgcolor="{$tr_tag}">
                <td align="center"><a href="{make_link action="action_MonthlyCourse_CourseData" getTags="mcid="|cat:$val.id|cat:$URLparam}">{$val.id}</a></td>
                <td align="left">{$val.name}</td>
                <td align="center">{$val.group_name}</td>
                <td align="center">{$val.sort_seq}</td>
                <td align="center">{$val.comment}</td>
                <td  style="text-align:center;">
                    <input type="checkbox" name="check_mcid[]" value="{$val.id}">
                </td>
            </tr>
        {/foreach}
    </table>
    </form>
    {if $pager}
    <ul class="pager">
        <li>{$pager.previous}</li>
        <li>{$pager.pages|@implode:"</li><li>"}</li>
        <li>{$pager.next}</li>
    </ul>
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
<script type="text/javascript" src="./js/jquery.timepickr.min.js"></script>
<script type="text/javascript">
<!--

    $(function() {ldelim}
        {* 時刻入力 *}
        $(".time").timepickr({ldelim}
            format24: "{ldelim}h:02.d{rdelim}:{ldelim}m:02.d{rdelim}:{ldelim}s:02.d{rdelim}",
            seconds: true,
            rangeMin: ["00","05","10","15","20","25","30","35","40","45","50","55","59"],
            rangeSec: ["00","15","30","45","59"],
            convention: 24
        {rdelim});

        {* カレンダー *}
        $(".datepicker").datepicker({ldelim}
            dateFormat: "yy-mm-dd"
        {rdelim});

        {* キーワード、日時フォームを隠す *}
        $("#keyword_id").hide();
        $("#search_condition_id").hide();
        $("#keyword").hide();
        $("#search_datetime").hide();

        var openIdAry = Array('#search_type option:selected');
        for (var val in openIdAry) {ldelim}
            openSearchInput(openIdAry[val]);
        {rdelim}

        {* 検索条件を変えたとき *}
        $('#search_type').change(function(){ldelim}
            openSearchInput('#search_type option:selected');
        {rdelim});

        {* テーブルストライプ *}
        $("#src_table tr:even").addClass("BgColor02");

        {* フォルダ移動 フォルダ一覧を隠す *}
        $("#folder_list").hide();
        $("#display_chg").hide();

        var updateIdAry = Array('#update_type option:selected');
        for (var val in updateIdAry) {ldelim}
            openFolderSelect(updateIdAry[val]);
        {rdelim}

        {* 更新条件を変えたとき *}
        $('#update_type').change(function(){ldelim}
            openFolderSelect('#update_type option:selected');
        {rdelim});
    {rdelim});

    function openSearchInput(selectId) {ldelim}

        var selectId = $(selectId);

        if (selectId.val() == 1) {ldelim}
            $('#keyword_id').show("blind", "slow");
            $('#keyword_key').hide();
            $('#keyword').hide();
            $('#search_datetime').hide();
            $("#search_condition_id").hide();
        {rdelim} else if (selectId.val() == 2) {ldelim}
            $('#keyword_key').show("blind", "slow");
            $('#keyword_id').hide();
            $('#keyword').hide();
            $('#search_datetime').hide();
            $("#search_condition_id").hide();
        {rdelim} else if (selectId.val() == 3) {ldelim}
            $('#keyword').show("blind", "slow");
            $('#keyword_id').hide();
            $('#search_datetime').hide();
            $("#search_condition_id").hide();
        {rdelim} else if (selectId.val() == 4) {ldelim}
            $('#search_datetime').show("blind", "slow");
            $('#keyword').hide();
            $('#keyword_id').hide();
            $("#search_condition_id").hide();
        {rdelim} else if (selectId.val() == 5) {ldelim}
            $('#search_condition_id').show("blind", "slow");
            $('#search_datetime').hide();
            $('#keyword').hide();
            $('#keyword_id').hide();
        {rdelim} else {ldelim}
            $('#search_datetime').hide("slow");
            $('#keyword').hide("slow");
            $('#keyword_id').hide("slow");
            $("#search_condition_id").hide();
        {rdelim}
    {rdelim}

    function openFolderSelect(selectId) {ldelim}

    var selectId = $(selectId);

    if (selectId.val() == 1) {ldelim}
        $('#category_list').hide();
        $('#chg_display').show("blind", "slow");
    {rdelim} else if (selectId.val() == 2) {ldelim}
        $('#category_list').show("blind", "slow");
        $('#chg_display').hide();
    {rdelim} else if (selectId.val() == 3) {ldelim}
        $('#category_list').hide();
        $('#chg_display').hide();
    {rdelim} else {ldelim}
        $('#category_list').hide();
        $('#chg_display').hide();
    {rdelim}

{rdelim}

//-->
</script>
</body>
</html>