{include file=$admHeader}
</head>
<body>
<div id="ContentsCol">
    <h2 class="ContentTitle">ユニットデータ更新画面</h2>
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
            <input type="submit" name="action_unit_List" value="一覧に戻る" />
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
        <hr>
        <br>
        <form action="./" method="post">
            {$POSTparam}
            <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
                <tr>
                <th>人数</th>
                <td>{$param.count}人</td>
                </tr>
                <tr>
                <th>ログ削除対象フラグ</th>
                <td style="text-align: left;">{html_options name="is_stay" options=$isStay selected=$param.is_stay}</td>
                </tr>
                <tr>
                <th>コメント</th>
                <td style="text-align: left;">
                    <input type="text" name="comment" value="{$param.comment}" size="50">
                </td>
                </tr>
                <tr>
                <th>登録時間</th>
                <td>{$param.create_datetime}</td>
                </tr>
            </table>
            <div class="SubMenu">
                <input type="submit" name="action_unit_UnitUpdExec" value="更　新" onClick="return confirm('更新しますか？')" />
            </div>
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
