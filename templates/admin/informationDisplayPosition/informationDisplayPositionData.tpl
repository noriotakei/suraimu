{include file=$admHeader}
</head>
<body>
<div id="ContentsCol">
    <h2 class="ContentTitle">情報表示場所フォルダ一覧</h2>
    <form action="./" method="post">
        <div class="SubMenu">
            <input type="submit" name="action_informationDisplayPosition_InformationDisplayPositionList" value="一覧に戻る" />
        </div>
    </form>
    {if $dispFolderList}
        <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet01">
            <caption>[{$displayPositionNameList[$param.position_id]}]</caption>
            <tr>
                <th>情報フォルダ名</th>
                <th><a href="{make_link action="action_informationDisplayPosition_InformationDisplayPositionData" getTags=$URLparam}">PC表示優先度</a></th>
                <th><a href="{make_link action="action_informationDisplayPosition_InformationDisplayPositionData" getTags=$URLparam|cat:"&sort=mb"}">MB表示優先度</a></th>
                <th>表示状態</th>
            </tr>
            {foreach from=$dispFolderList item="val"}
            {cycle values="#CCCCCC," assign="tr_tag"}
            {if !$val.is_display}
                {assign var="tr_tag" value="#FF3333"}
            {/if}
            <tr bgcolor="{$tr_tag}">
                <td style="text-align: left;"><a href="{make_link action="action_informationDisplayPosition_InformationDisplayPositionUpd" getTags="fid="|cat:$val.information_category_id}">{$val.name}</a></td>
                <td style="text-align: left;">{$val.pc_sort_seq}</td>
                <td style="text-align: left;">{$val.mb_sort_seq}</td>
                <td style="text-align: left;">{$isDisplay[$val.is_display]}</td>
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
