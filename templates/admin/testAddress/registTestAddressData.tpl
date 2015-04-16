{include file=$admHeader}
</head>
<body>
<div id="ContentsCol">
    <h2 class="ContentTitle">テストアドレスデータ更新画面</h2>
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
            <input type="submit" name="action_testAddress_RegistTestAddressList" value="一覧に戻る" />
        </div>
    </form>
    {if $param}
        <form action="./" method="post">
            {$POSTparam}
            <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
                <tr>
                <th>カテゴリー</th>
                <td style="text-align: left;">{html_options name="regist_test_mail_category_id" options=$categoryList selected=$param.regist_test_mail_category_id}</td>
                </tr>
                <tr>
                <th>メールアドレス</th>
                <td style="text-align: left;">
                    <input type="text" name="mail_address" value="{$param.mail_address}" size="50" style="ime-mode:disabled">
                </td>
                </tr>
                <tr>
                <th>表示順</th>
                <td style="text-align: left;"><input type="text" name="sort_seq" value="{$param.sort_seq|default:1}" size="3" style="ime-mode:disabled"></td>
                </tr>
                <tr>
                <th>表示状態</th>
                <td style="text-align: left;">{html_options name="is_display" options=$isDisplay selected=$param.isDisplay|default:1}</td>
                </tr>
            </table>
            <div class="SubMenu">
                <input type="submit" name="action_testAddress_RegistTestAddressAddExec" value="更　新" onClick="return confirm('更新しますか？')" />
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
