{include file=$header}
</head>
<body {$bodyTag}>
<a name="top" id="top"></a>
<div style="font-size:x-small; text-align:left; {$limited_width}">
<img src="img/title.gif" alt="{$siteName}" width="100%" />
<div style="text-align:center;">
登録情報の変更
</div>
<hr {$hr_2style} />
<span style="color:#99ec00;font-size:small;">▼月額更新の変更</span><br />
{if $errMsg}<span style="color:#f00;font-size:small;">{$errMsg}</span><br /><hr {$hr_2style} />{/if}
{if $monthlyCourseUserList}
<form action="./?action_MonthlyUpdateQuitExec=1{if $comURLparam}&{$comURLparam}{/if}" method="post">
    <div style="text-align:center;">
        {foreach from=$monthlyCourseUserList key="key" item="val"}
            {$val.course_name}<br />
            {html_options name="monthly_update_change[$key]" options=$monthlyCourseUpdateStatus selected=$returnValue.monthly_update_change.$key|default:0 style="color:#000;font-size:x-small;"}
            <input type="hidden" name="id[{$key}]" value="{$val.id}">
            <br /><br />
        {/foreach}
    </div>
    <div style="text-align:center;color:#000;"><input value="変更内容の変更" type="submit" /></div>
</form>
<hr {$hr_2style} />
{/if}
<span style="color:#fc0;font-size:small;">※注意事項</span><br />
・解約の変更をされると「お得なキャンペーン情報」をお届けできなくなります。<br />
<hr {$hr_1style} />
{include file=$contentsMenu}
{include file=$footerMenu}
{include file=$pr}
{include file=$footer}
</body>
</html>