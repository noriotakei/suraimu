{include file=$admHeader}
</head>
<body>
<div class="BlockCol">
    <h2 class="ContentTitle">フリーワード設定データ</h2>
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
        <br>
    {/if}
    <form action="./" method="post">
        <input type="submit" name="action_freeWord_FreeWordList" value="一覧へ戻る" style="width:8em;"/>
    </form>
    <br>
    <form action="./" method="post">
        <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">
            {section name=cnt start=1  loop=11}
                {math assign=free_word_key equation="x - y" x=$smarty.section.cnt.index y=1}
                <tr>
                    <th>フリーワード{$smarty.section.cnt.index}</th>
                    <td><input type="text" name="free_word_value__{$smarty.section.cnt.index}" value="{$freeWordList.$free_word_key.free_word_text}" size="30"></td>
                </tr>
            {/section}
            <tr>
            <td colspan="2" style="text-align: center">
                <input type="submit" name="action_freeWord_FreeWordDataExec" value="登　録" onClick="return confirm('登録しますか？')" />
            </td>
            </tr>
        </table>
        <input type="hidden" name="fwc" value="{$fwc}">
    </form>

{include file=$admFooter}
</div>
</body>
</html>
