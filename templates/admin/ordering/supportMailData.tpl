{include file=$admHeader}
</head>
<body>
<div class="BlockCol">
    <h2 class="ContentTitle">サポートメール定型文作成</h2>
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
        <input type="submit" name="action_ordering_SupportMailList" value="一覧へ戻る" style="width:8em;"/>
    </form>
    <br>
    <div>
        <a href="{make_link action="action_keyConvert_DispKeyConvertList" getTags=$getTag}" target="_blank">システム変換管理</a>
    </div>
    <br>
    {if $supportMailData.id}
    <div>
        <form action="./" method="post">
            {$POSTparam}
            <input type="hidden" name="disable" value="1">
            <input type="submit" name="action_ordering_SupportMailDataExec" value="削 除" OnClick="return confirm('削除しますか？')" style="width:8em;"/>
        </form>
    </div>
    <br>
    {/if}
    <form action="./" method="post">
        {$POSTparam}
        <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">
            <tr>
                <th colspan="2" style="text-align:center;">サポートメール定型文作成</th>
            </tr>
            <tr>
                <th>定型文名</th>
                <td style="text-align: left;">
                    <input type="text" name="name" value="{$supportMailData.name}" size="20">
                </td>
            </tr>
            <tr>
                <th>優先順位</th>
                <td style="text-align: left;">
                    <input type="text" name="sort_seq" value="{$supportMailData.sort_seq|default:0}" size="3" style="ime-mode: disabled;">
                </td>
            </tr>
            <tr>
                <th>PC件名</th>
                <td style="text-align: left;">
                    <input type="text" name="pc_subject" value="{$supportMailData.pc_subject}" size="50">
                </td>
            </tr>
            <tr>
                <th>PCTEXT本文</th>
                <td style="text-align: left;">
                    <textarea name="pc_text_body" cols="100" rows="30" id="pc_text_body" wrap="off">{$supportMailData.pc_text_body}</textarea>
                </td>
            </tr>
            <tr>
                <th>MB件名</th>
                <td style="text-align: left;">
                    <input type="text" name="mb_subject" value="{$supportMailData.mb_subject}" size="50">
                </td>
            </tr>
            <tr>
                <th>MBTEXT本文</th>
                <td style="text-align: left;">
                    <textarea name="mb_text_body" cols="100" rows="30" id="mb_text_body" wrap="off">{$supportMailData.mb_text_body}</textarea>
                </td>
            </tr>
            <tr>
                <td style="text-align:center;" colspan="2">
                    {if $supportMailData.id}
                        <input type="submit" name="action_ordering_SupportMailDataExec" value="更 新" OnClick="return confirm('更新しますか？')" style="width:8em;"/>
                    {else}
                        <input type="submit" name="action_ordering_SupportMailDataExec" value="登 録" OnClick="return confirm('登録しますか？')" style="width:8em;"/>
                    {/if}
                </td>
            </tr>
        </table>
    </form>
{include file=$admFooter}
</div>
</body>
</html>
