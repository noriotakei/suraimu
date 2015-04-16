{include file=$admHeader}
</head>
<body>
<div id="ContentsCol">
    <h2 class="ContentTitle">抽選ユニットデータ作成</h2>
    {* メッセージ *}
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
    <input type="submit" value="一覧へ戻る" name="action_user_List"/>
</div>
</form>
<table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet04">
<tr><th colspan="2" style="text-align:center;">検索条件</th></tr>
{foreach from=$whereContents item="val" key="key"}
    <tr><th>
    {$key}
    </th>
    <td>
    {$val}
    </td></tr>
{/foreach}
</table>
<br><br>
{if $totalCount}
    <form action="./" method="post">
        {$POSTparam}
        <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
            <tr>
                <th>該当件数</th>
                <td>{$totalCount}件</td>
            </tr>
            <tr>
                <th>抽出件数</th>
                <td><input type="text" name="number" size="5" value="{$returnValue.number}" style="ime-mode:disabled">件</td>
            </tr>
            <tr>
                <th>抽選ユニット名</th>
                <td><input type="text" name="comment" size="30" value="{$returnValue.comment}"></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center;"><input type="submit" value="抽選ユニット作成" name="action_lotteryUnit_UnitCreateExec"  onClick="return confirm('抽選ユニット作成しますか？')"/></td>
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
