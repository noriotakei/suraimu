{include file=$admHeader}
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
<link type="text/css" href="./css/pager.css" rel="stylesheet" />
<style type="text/css">
.watermark {ldelim}
   color: #999;
{rdelim}
</style>
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">月額コースユーザー一覧</h2>
{if $execMsg|@count}
    <div class="warning ui-widget">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    <p>
    <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    { foreach from=$execMsg item="val"}
        {$val|@implode:"<br>"}
    {/foreach}
    </p>
    </div>
    </div>
    <br>
{/if}
<br>
<form action="./" method="post" name="userSearch">
    <table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet01" width="95%">
        <tr>
        <th colspan="2" style="text-align: center; font-weight: bold;">月額コースユーザー検索</th>
        </tr>
        <tr>
            <td>ユーザーID<br>(カンマ区切りで複数可)</td>
            <td style="text-align: left;">
                <input type="text" name="search_user_id" value="{$param.search_user_id}" size="30" style="ime-mode:disabled">&nbsp;&nbsp;{html_radios id="user_id_type" name="user_id_type" options=$config.admin_config.specify_target_select selected=$param.search_user_id_type separator="&nbsp;"}
            </td>
        </tr>
        <tr>
            <td>月額コース名</td>
            <td style="text-align: left;">
                {html_options name="monthly_course_name" options=$monthlyCourseListSelectArray selected=$param.monthly_course_name}
            </td>
        </tr>
        <tr>
            <td>付与月額コースID<br>(カンマ区切りで複数可)</td>
            <td style="text-align: left;">
                <input type="text" name="search_monthly_course_id" value="{$param.search_monthly_course_id}" size="20" style="ime-mode:disabled;">&nbsp;&nbsp;{html_radios id="monthly_course_id_type" name="monthly_course_id_type" options=$config.admin_config.specify_target_select selected=$param.monthly_course_id_type separator="&nbsp;"}
            </td>
        </tr>
        <tr>
            <td>月額コースグループ名</td>
            <td style="text-align: left;">
                {html_options name="monthly_course_group_id" options=$monthlyCourseGroupeListSelectArray selected=$param.monthly_course_group_id}
            </td>
        </tr>
        <tr>
            <td>月額コース更新タイプ</td>
            <td style="text-align: left;">
                {html_options name="create_type" options=$monthlyCourseCreateTypeSelectArray selected=$param.create_type}
            </td>
        </tr>
        <tr>
            <td>月額コース有効日付(開始日～終了日)</td>
            <td style="text-align: left;">
                <input name="monthly_course_start_date" size="15" class="datepicker" type="text" value="{$param.searchDatetimeFrom|zend_date_format:'yyyy-MM-dd'}" maxlength="10">
                ～&nbsp;<input name="monthly_course_end_date" size="15" class="datepicker" type="text" value="{$param.searchDatetimeTo|zend_date_format:'yyyy-MM-dd'}" maxlength="10">
            </td>
        </tr>
        <tr>
            <td>月額更新</td>
            <td style="text-align: left;">
                {html_radios id="specify_monthly_update" name="specify_monthly_update" options=$config.admin_config.specify_monthly_update_select selected=$param.specify_monthly_update|default:0 separator="&nbsp;"}
            </td>
        </tr>
        <tr>
            <td>付与月額更新用商品ID<br>(カンマ区切りで複数可)</td>
            <td style="text-align: left;">
                <input type="text" name="monthly_update_item_id" value="{$param.monthly_update_item_id}" size="20" style="ime-mode:disabled;">&nbsp;&nbsp;{html_radios id="monthly_update_item_type" name="monthly_update_item_type" options=$config.admin_config.specify_target_select selected=$param.monthly_update_item_type separator="&nbsp;"}
            </td>
        </tr>
        <tr>
            <td>作成タイプ</td>
            <td style="text-align: left;">
                {html_options name="admin_id" options=$adminList selected=$param.admin_id}
            </td>
        </tr>
        <tr>
            <td style="text-align:center;" colspan="2">
                <input type="hidden" name="search_flag" value="1">
                <input type="submit" name="action_monthlyCourse_CourseUserSearchList" value="検 索" style="width:8em;"/>
            </td>
        </tr>
    </table>
</form>
<br>
    {if $monthlyCourseUserList}
        <div style="padding-bottom: 10px;">
        件数：{$totalCount}件<br />
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
                <th colspan="2" style="text-align: center; font-weight: bold;">月額コース一括操作</th>
            </tr>
            <tr>
                <td>操作内容</td>
                <td>{html_options name="update_type" options=$batchOperateMonthlyCourseUserSelectAry selected=$param.update_type|default:0 id="update_type"}
                    <div id="monthly_course_list" style="display:none;">
                        {html_options name="chg_monthly_course" options=$batchMonthlyCourseList selected=$param.chg_monthly_course|default:1}&nbsp;に変更
                    </div>
                    <div id="monthly_course_add_days" style="display:none;">
                        付与日数：&nbsp;<input type="text" name="monthly_course_add_days" value="{$param.monthly_course_add_days}" size="10" style="ime-mode:disabled;">
                    </div>
                </td>
            </tr>
            <tr>
                <td style="text-align:center;" colspan="2">
                    <input type="submit" name="action_monthlyCourse_CourseUserExec" value="更新" onClick="return confirm('更新しますか?')">
                </td>
            </tr>
        </table>
        <br>

        <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" id="list_table">
        <tr>
            <th>コース詳細</th>
            <th>ユーザーID</th>
            <th>月額コース名</th>
            <th>月額グループ名</th>
            <th>開始日</th>
            <th>終了日</th>
            <th>更新タイプ</th>
            <th>月額更新用商品名</th>
            <th>作成タイプ</th>
            <th>ユーザー詳細</th>
            <th><input type="checkbox" onclick="$('#list_table input:checkbox').attr('checked', this.checked);" ></th>

        </tr>
        {foreach from=$monthlyCourseUserList key="key" item="val" name="loop"}
        <tr>
            <td align="center"><a href="{make_link action="action_monthlyCourse_CourseUserData" getTags="user_id="|cat:$val.user_id|cat:$URLparam}">詳細</a></td>
            <td align="center">{$val.user_id}</td>
            <td align="center">{$val.course_name}</td>
            <td align="center">{$val.group_name}</td>
            <td align="center">{$val.limit_start_date}</td>
            <td align="center">{$val.limit_end_date}</td>
            <td align="center">{$monthlyCourseCreateTypeSelectArray[$val.create_type]}</td>
            <td align="center">{$val.item_name}</td>
            <td align="center">{$adminList[$val.admin_id]}</td>
            <td align="center"><a href="{make_link action="action_User_Detail" getTags="user_id="|cat:$val.user_id}" target="_blank">変更</a></td>
            <td style="text-align:center;"><input type="checkbox" name="check_mcuid[]" value="{$val.id}"></td>
        </tr>
        {/foreach}
        </table>
        </form>
        <br>
        <div style="padding-bottom: 10px;">
        件数：{$totalCount}件<br />
        {$dispFirst}～{$dispLast}件表示しています
        {if $pager}
        <ul class="pager">
            <li>{$pager.previous}</li>
            <li>{$pager.pages|@implode:"</li><li>"}</li>
            <li>{$pager.next}</li>
        </ul>
        {/if}
        </div>
    {elseif $param.search_flag}
        <div class="warning ui-widget">
        <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
        <p>
        <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
        該当データはありません
        </p>
        </div>
    {/if}
{include file=$admFooter}
<script type="text/javascript" src="./js/jquery.timepickr.min.js"></script>
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script type="text/javascript" src="./js/watermark/jquery.watermark.min.js"></script>
<script type="text/javascript" src="./js/userSearch.js"></script>
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

        $("#search_button").live("click", function(){ldelim}
            $("#search_form").slideToggle("slow");
        {rdelim});

        {* テーブルストライプ *}
        $("#src_table tr:even").addClass("BgColor02");

        {* フォルダを隠す *}
        $("#monthly_course_list").hide();
        $("#monthly_course_add_days").hide();

        var updateIdAry = Array('#update_type option:selected');
        for (var val in updateIdAry) {ldelim}
            openMonthlyCourseSelect(updateIdAry[val]);
        {rdelim}

        {* 更新条件を変えたとき *}
        $('#update_type').change(function(){ldelim}
        openMonthlyCourseSelect('#update_type option:selected');
        {rdelim});

        // テキストボックス文字
        $('.from').watermark('例):10');
        $('.to').watermark('例):2');

        // 月額コース一括操作入力フォーム表示
        function openMonthlyCourseSelect(selectId) {ldelim}

            var selectId = $(selectId);

            if (selectId.val() == 1) {ldelim}
                $('#monthly_course_list').show("blind", "slow");
                $('#monthly_course_add_days').hide();
            {rdelim} else if (selectId.val() == 4) {ldelim}
                $('#monthly_course_list').hide();
                $('#monthly_course_add_days').show("blind", "slow");
            {rdelim} else {ldelim}
                $('#monthly_course_list').hide();
                $('#monthly_course_add_days').hide();
            {rdelim}

        {rdelim}

    {rdelim});
// -->
</script>
</body>
</html>

