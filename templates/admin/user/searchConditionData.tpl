{include file=$admHeader}
</head>
<body>
<div id="ContentsCol">
    <h2 class="ContentTitle">検索条件データ更新</h2>
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
            <input type="submit" name="action_user_SearchConditionList" value="一覧に戻る" />
        </div>
    </form>
    {if $param}
        <table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet04">
        <tr><th colspan="2" style="text-align:center;">検索条件</th></tr>
        {foreach from=$param.where_contents item="val" key="key"}
            <tr><th>
            {$key}
            </th>
            <td>
            {$val}
            </td></tr>
        {/foreach}
        </table>
        <br>
        <form action="./" method="post">
            {$POSTparam}
            <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
                <tr><th>ID</th><td>{$param.id}</td></tr>
                <tr>
                <th>コメント</th>
                    <td><input type="text" name="comment" value="{$param.comment}" size="20"></td>
                </tr>
                <tr>
                <th>タイプ</th>
                    <td>{html_options name="search_conditions_category_id" options=$categoryList selected=$param.search_conditions_category_id}</td>
                </tr>
                <th>更新禁止</th>
                    <td>{html_options name="update_permission" options=$update_permission selected=$param.update_permission}</td>
                </tr>
                <tr>
                <td colspan="2" style="text-align:center;">
                    <input type="submit" name="action_user_SearchConditionUpdExec" value="更　新" onClick="return confirm('更新しますか？')" />
                </td>
                </tr>
            </table>
        </form>
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
