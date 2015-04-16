{include file=$admHeader}
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">広告コード一覧</h2>
{* 更新時エラーコメント *}
{if $execMsg|@count}
    <div class="warning ui-widget">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    <p>
    <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    { foreach from=$execMsg item="val" }
        {$val|@implode:"<br>"}
    {/foreach}
    </p>
    </div>
    </div>
{/if}
<form action="./" method="POST">
    {$POSTparam}
    <table class="TableSet04">
        <tr>
            <th>
                広告コード：
            </th>
            <td>
                <input type="text" name="name" size="20" value="{$param.name}">
            </td>
        </tr>
        <tr>
            <th>
                備考：
            </th>
            <td>
                <input type="text" name="description" size="30" value="{$param.description}">
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">
                <input type="submit" value="更　新" name="action_Count_MediaCdRegistExec" onClick="return confirm('更新しますか？')">
            </td>
        </tr>
    </table>
</form>
{include file=$admFooter}
</div>
</body>
</html>