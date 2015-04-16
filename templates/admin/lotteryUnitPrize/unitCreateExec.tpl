{include file=$admHeader}
</head>
<body>
<div id="ContentsCol">
    <h2 class="ContentTitle">抽選ユニットデータ作成完了画面</h2>
    {* メッセージ *}
    {if $msg|@count}
        <div class="warning ui-widget">
        <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
        <p>
        <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
        { foreach from=$msg item="val" }
            {$val "<br>"}
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
{if $displayLotteryResult|@count}
        <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
            <tr>
                <th>該当件数</th>
                <td>{$totalCount}件</td>
            </tr>
        </table>

        <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
            {foreach from=$displayLotteryResult item="val" key="key"}
                <tr>
                    <th>当選</th>
                    <th>賞品名</th>
                    <td>{$val.comment}</td>
                    <th>当選確率</th>
                    <td>{$val.number}%</td>
                    <th>当選ユーザー数</th>
                    <td>{$val.lotteryUserCount}</td>
                    <th>抽選ユニットID</th>
                    <td>{$val.lotteryUnitId}</td>
                </tr>
            {/foreach}
        </table>
{/if}
</br>
</br>
{if $displayNotLotteryResult|@count}
        <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
            <tr>
                <th>該当件数</th>
                <td>{$totalCount}件</td>
            </tr>
        </table>

        <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
            {foreach from=$displayNotLotteryResult item="val" key="key"}
                <tr>
                    <th>落選</th>
                    <th>賞品名</th>
                    <td>{$val.comment}</td>
                    <th>当選確率</th>
                    <td>{$val.number}%</td>
                    <th>当選ユーザー数</th>
                    <td>{$val.lotteryUserCount}</td>
                    <th>抽選ユニットID</th>
                    <td>{$val.lotteryUnitId}</td>
                </tr>
            {/foreach}
        </table>
{/if}


{include file=$admFooter}
</div>
</body>
</html>
