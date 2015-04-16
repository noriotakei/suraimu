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

    {rdelim});

//-->
</script>
</head>
<body>

<div id="ContentsCol">

<h2 class="ContentTitle">月額コースグループ一覧</h2>
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
            <th>管理用グループ名</th>
            <td style="text-align: left;">
                <input type="text" name="name" value="{$registParam.name}" size="50">
            </td>
            <td style="text-align:center;color:#ff0000;">必須</td>
        </tr>
        <tr>
            <th>表示切り替え</th>
            <td style="text-align: left;">{html_options name="is_display" options=$isDisplay selected=$registParam.is_display|default:1}</td>
        </tr>
        <tr>
            <th>表示優先度</th>
            <td style="text-align: left;">
                <input type="text" name="sort_seq" value="{$registParam.sort_seq|default:0}" size="10">
            </td>
            <td style="text-align: center;">任意</td>
        </tr>
        <tr>
            <td colspan="3"  style="text-align:center;">
                <div class="SubMenu">
                    <input type="submit" name="action_MonthlyCourse_GroupExec" value="登録する" onClick="return confirm('登録しますか？')"/>
                </div>
            </td>
        </tr>
    </table>
</form>
</div>
<br>

{if $monthlyCourseGroupList}
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

    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">
        <tr bgcolor="#FF9933">
            <th>ID</th>
            <th>管理用グループ名</th>
            <th width="80">表示優先度</th>
            <th width="80">表示状態</th>
            <th>削除</th>
        </tr>
        {foreach from=$monthlyCourseGroupList item="val"}
        <tr>
            <td align="center"><a href="{make_link action="action_MonthlyCourse_GroupData" getTags="mcgid="|cat:$val.id}">{$val.id}</a></td>
            <td align="left">{$val.name}</td>
            <td align="center">{$val.sort_seq}</td>
            <td align="center">{$isDisplay[$val.is_display]}</td>
            <td>
                <form action="./" method="post" style="margin:2px 0px;">
                    <input type="hidden" name="mcgid" value="{$val.id}">
                    <input type="hidden" name="disable" value="1">
                    <input type="submit" name="action_MonthlyCourse_GroupExec" value="削除" onClick="return confirm('削除しますか?')">
                </form>
            </td>
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
</div>
</body>
</html>