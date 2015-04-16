{include file=$admHeader}
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<link type="text/css" href="./css/pager.css" rel="stylesheet" />
<script type="text/javascript">
<!--

    $(function() {ldelim}

        {* テーブルマウスオーバーカラー *}
        $('#list_table').colorize({ldelim}
            altColor :'#CCCCCC',
            hiliteColor :'none'
        {rdelim});

        {* テーブルストライプ *}
        $("#src_table tr:even").addClass("BgColor02");

        {* 追加フォーム *}
        if (!{$registParam.return_flag}) {ldelim}
            $("#add_form").hide();
        {rdelim} else {ldelim}
            $("#add_form").show();
        {rdelim}
        $('#add_button').live("click", function(){ldelim}
            $("#add_form").toggle("blind", null, "slow");
        {rdelim});

        $("#monthly_update").hide();

        var openMonthlyUpdateIdAry = {ldelim}
                            "input[name='is_monthly_update']:checked": '#monthly_update'
                        {rdelim};

        // 戻ったときに月額フォームが入力されていたら表示する
        for (var key in openMonthlyUpdateIdAry) {ldelim}
            openMonthlyUpdateInput(key, openMonthlyUpdateIdAry[key]);
        {rdelim}

        // 月額更新設定指定のとき
        $('#is_monthly_update').live("click", function(env){ldelim}
            if (env.button !== 0) return;
            openMonthlyUpdateInput("input[name='is_monthly_update']:checked", "#monthly_update");
        {rdelim});

        // 月額更新入力フォーム表示
        function openMonthlyUpdateInput(selectId, openId) {ldelim}

            var id = $(openId);
            var selectId = $(selectId);

            if (selectId.val() == 0) {ldelim}
                id.hide("slow");
            {rdelim} else {ldelim}
                id.show("blind", "slow");
            {rdelim}
        {rdelim}
    {rdelim});


//-->
</script>
</head>
<body>

<div id="ContentsCol">

<h2 class="ContentTitle">月額コースユーザデータ一覧</h2>
<table border="0" cellspacing="0" cellpadding="0" class="TableSet02" align="center">
    <tr>
        <th>ﾕｰｻﾞｰID</th>
        <td style="text-align: left;">{$param.user_id}</td>
    </tr>
</table>
<br>
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
<br>
<div class="SubMenu">
    <input type="button" id="add_button" value="追　加" />
</div>

<div id="add_form" style="display:none">
<form action="./" method="post" enctype="multipart/form-data">
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
        <tr>
            <th>付与月額コース</th>
            <td style="text-align: left;">
                {html_options name="monthly_course_id" options=$monthlyCourseList selected=$registParam.monthly_course_id|default:0}
            </td>
            <td style="text-align: center; color:#ff0000;">必須</td>
        </tr>
        <tr>
            <th>付与日数</th>
            <td style="text-align: left;">
                <input type="text" name="plus_limit_date" value="{$registParam.plus_limit_date}" size="5">
            </td>
            <td style="text-align: center; color:#ff0000;">必須</td>
        </tr>
        <tr>
            <th>月額更新設定</th>
            <td style="text-align: left;">
                {html_radios name="is_monthly_update" options=$isMonthlyUpdate selected=$registParam.is_monthly_update|default:0 separator="&nbsp;" id="is_monthly_update"}
                    <div id="monthly_update" style="display:none;">
                        ユーザー支払い時デバイス種別:&nbsp;{html_radios name="settle_device_type" options=$settleDeviceTypeSelectAry selected=$registParam.settle_device_type|default:"3" separator="&nbsp;"}
                        &nbsp;<font color="blue">※決済種別が「ゼロクレジット」の場合、PC or MBを選択して下さい。</font><br />
                        月額更新用商品ID:&nbsp;<input type="text" name="monthly_update_item_id" value="{$registParam.monthly_update_item_id}" size="10">
                        &nbsp;<font color="blue">※ここに入力した商品IDが月額更新で自動決済されます。</font>
                    </div>
            </td>
            <td style="text-align: center;">任意</td>
        </tr>
        <tr>
            <td colspan="3"  style="text-align:center;">
                <div class="SubMenu">
                    <input type="submit" name="action_User_MonthlyCourseUserExec" value="付与する" onClick="return confirm('付与しますか？')"/>
                </div>
            </td>
        </tr>
    </table>
    <input type="hidden" name="user_id" value="{$param.user_id}">
</form>
</div>
<br>

{if $monthlyCourseUserList}
    <div style="padding-bottom: 10px;">
    データ数：{$totalCount}件<br />
    {$dispFirst}～{$dispLast}件表示しています
    {if $pager}
    <ul class="pager">
        <li>{$pager.previous}</li>
        <li>{$pager.pages|@implode:"</li><li>"}</li>
        <li>{$pager.next}</li>
    </ul>
    {/if}
    </div>
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
        <tr bgcolor="#FF9933">
            <th>ID</th>
            <th>月額コースID</th>
            <th>月額コース名</th>
            <th>月額コースグループ名</th>
            <th>開始日</th>
            <th>終了日</th>
            <th>無効フラグ</th>
            <th>月額更新設定</th>
            <th>月額更新商品ID</th>
            <th>作成タイプ</th>
            <th>手動付与</th>
            <th>作成日時</th>
            <th>更新日時</th>
            <th>更新</th>
        </tr>
        {foreach from=$monthlyCourseUserList item="val"}
        <tr {$val.style}>
            <form action="./" method="post" style="margin:2px 0px;">
                <td align="left">{$val.id}</td>
                <td align="left">{$val.monthly_course_id}</td>
                <td align="left">{$val.course_name}</td>
                <td align="left">{$val.group_name}</td>
                <td align="left"><input type="text" class="datepicker" size="13" maxlength="13" name="limit_start_date" value="{$val.limit_start_date}"></td>
                <td align="left"><input type="text" class="datepicker" size="13" maxlength="13" name="limit_end_date" value="{$val.limit_end_date}"></td>
                <td>{html_options name="is_invalid" options=$isInvalid selected=$val.is_invalid|default:0}</td>
                <td>{html_options name="is_monthly_update" options=$isMonthlyUpdate selected=$val.is_monthly_update|default:0}</td>
                <td align="left">{$val.monthly_update_item_id}</td>
                <td align="left">{$createType[$val.create_type]}</td>
                <td align="left">{$val.admin}</td>
                <td align="left">{$val.create_datetime}</td>
                <td align="left">{$val.update_datetime}</td>
                <td>
                    <input type="submit" name="action_User_MonthlyCourseUserExec" value="更新" onClick="return confirm('更新しますか?')">
                </td>
                <input type="hidden" name="user_id" value="{$param.user_id}">
                <input type="hidden" name="mcuid" value="{$val.id}">
                <input type="hidden" name="edit" value="1">
            </form>
        </tr>
        {/foreach}
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
<script type="text/javascript" src="./js/jquery.timepickr.min.js"></script>
<script type="text/javascript" src="./js/jquery.timepickr.min.js"></script>
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script type="text/javascript" src="./js/watermark/jquery.watermark.min.js"></script>
<script type="text/javascript" src="./js/userSearch.js"></script>
</div>
</body>
</html>