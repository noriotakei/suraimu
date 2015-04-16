{include file=$admHeader}
<link type="text/css" href="./css/pager.css" rel="stylesheet" />
<script type="text/javascript">
<!--
    $(function() {ldelim}
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

<h2 class="ContentTitle">情報リストグループ一覧</h2>
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
<div class="SubMenu">
    <input type="button" id="add_button" value="追　加" />
</div>

<div id="add_form" style="display:none">
<form action="./" method="post" enctype="multipart/form-data">
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
        <tr>
            <th>管理用情報リストグループ名</th>
            <td style="text-align: left;">
                <input type="text" name="name" value="{$registParam.name}" size="50">
            </td>
        </tr>
        <tr>
            <th>管理側表示優先度</th>
            <td style="text-align: left;">
                <input type="text" name="sort_seq" value="{$registParam.sort_seq|default:0}" size="10">
            </td>
        </tr>
        <tr>
            <th>表示状態</th>
            <td style="text-align: left;">{html_options name="is_display" options=$isDisplay selected=$registParam.is_display separator="&nbsp;"}</td>
        </tr>
        <tr>
        <td colspan="2" style="text-align: center">
            <input type="submit" name="action_informationListManagement_InformationListGroupExec" value="登　録" onClick="return confirm('登録しますか？')" />
        </td>
        </tr>
    </table>
</form>
</div>
<br>

{if $infoGroupList}
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

    <form action="./" method="post" style="margin:2px 0px;" >
        <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">
            <tr bgcolor="#FF9933">
                <th>ID</th>
                <th>グループ名</th>
                <th width="80">表示優先度</th>
                <th width="80">表示状態</th>
                <th style="text-align:center;">削除<br><input type="checkbox" onclick="$('#list_table input:checkbox').attr('checked', this.checked);" ></th>
            </tr>
            {foreach from=$infoGroupList item="val"}
            {cycle values="#CCCCCC," assign="tr_tag"}
            {if !$val.is_display}
                {assign var="tr_tag" value="#FF3333"}
            {/if}
            <tr bgcolor="{$tr_tag}">
                <td align="center"><a href="{make_link action="action_informationListManagement_InformationListSettingUpd" getTags="gid="|cat:$val.id}">{$val.id}</a></td>
                <td align="left">{$val.name}</td>
                <td align="center">{$val.sort_seq}</td>
                <td align="center">{$isDisplay[$val.is_display]}</td>
                <td style="text-align:center;">
                    <input type="checkbox" name="gid[]" value="{$val.id}">
                </td>
            </tr>
            {/foreach}
        </table>
        <br>チェックしたデータを
        <input type="hidden" name="disable" value="1">
        <input type="submit" name="action_informationListManagement_InformationListGroupExec" value="削除" onClick="return confirm('削除しますか?')">
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
</body>
</html>