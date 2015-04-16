{include file=$admHeader}
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
<script type="text/javascript" src="./js/jquery.timepickr.min.js"></script>
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<link type="text/css" href="./css/pager.css" rel="stylesheet" />

<script type="text/javascript">
<!--

    $(function() {ldelim}
        $('.selectText').click(function(){ldelim}
        $(this).select();
        {rdelim});

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

    {rdelim});

//-->
</script>
</head>
<body>

<div id="ContentsCol">
    <h2 class="ContentTitle">月額コース更新画面</h2>
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
    {$POSTparam}
        <div class="SubMenu">
            <input type="submit" name="action_MonthlyCourse_courseSearchList" value="一覧に戻る" />
        </div>
    </form>
    <form action="./" method="post" enctype="multipart/form-data">
    {$POSTparam}
        <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
            <tr>
                <th>月額コースID</th>
                <td style="text-align:left;font-size:large;">
                    <b>{$param.iid|default:$monthlyCourseData.id}</b>
                </td>
                <td style="text-align: center;">--</td>
            </tr>
            <tr>
                <th>管理側表示用コース名</th>
                <td style="text-align:left;">
                    <input type="text" name="name" value="{$param.name}" size="80">
                </td>
                <td style="text-align:center;color:#ff0000;">必須</td>
            </tr>
            <tr>
                <th>グループ</th>
                    <td style="text-align:left;">{html_options name="monthly_course_group_id" options=$monthlyCourseGroupListForSelect selected=$param.monthly_course_group_id}</td>
                    <td style="text-align:center;">--</td>
            </tr>
            <tr>
                <th>同月額コース更新タイプ</th>
                <td style="text-align: left;">
                    {html_options name="same_monthly_course_type" options=$sameMonthlyCourseType selected=$param.same_monthly_course_type|default:0}
                    <br /><font color="blue">※更新：既存コースに対して更新<br />※新規：新規でコース作成(既存コースは無効にします)</font>
                </td>
                <td style="text-align: center;">-----</td>
            </tr>
            <tr>
                <th>別月額コース更新タイプ</th>
                <td style="text-align: left;">
                    {html_options name="different_monthly_course_type" options=$differentMonthlyCourseType selected=$param.different_monthly_course_type|default:0}
                    <br /><font color="blue">※更新：既存コースに対して更新<br />※新規：新規でコース作成(既存コースは無効にします)</font>
                </td>
                <td style="text-align: center;">-----</td>
            </tr>
            <tr>
                <th>表示優先度</th>
                <td style="text-align:left;">
                    <input type="text" name="sort_seq" value="{$param.sort_seq|default:0}" size="10">
                </td>
                <td style="text-align:center;">任意</td>
            </tr>
            <tr>
                <td colspan="3"  style="text-align:center;">
                    <div class="SubMenu">
                        <input type="submit" name="action_MonthlyCourse_CourseExec" value="更新する" onClick="return confirm('更新しますか？')"/>
                    </div>
                </td>
            </tr>
        </table>
    </form>
{include file=$admFooter}
</div>
</body>
</html>