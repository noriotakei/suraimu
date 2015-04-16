{include file=$admHeader}
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script language="JavaScript">
<!--

    $(function() {ldelim}

        {* テーブルマウスオーバーカラー *}
        $('#list_table').colorize({ldelim}
            altColor :'#CCCCCC',
            hiliteColor :'none'
        {rdelim});
    {rdelim});

// -->
</script>
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">予約注文表示場所設定</h2>
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
{if $ordringDisplayCd}
    <form action="./" method="POST">
        <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">
            <tr>
                <th>表示場所</th>
                <th>表示状態</th>
            </tr>
            {foreach from=$ordringDisplayCd key="key"  item="val"}
                <tr>
                    <td><input type="hidden" name="display_cd[]" value="{$key}" style="ime-mode:disabled">{$val}</td>
                    <td>{html_options name=$key|string_format:"is_display[%s]" options=$isDisplay selected=$orderingDisplayData.$key.is_display}</td>
                </tr>
            {/foreach}
            <tr>
                <td colspan="2" style="text-align: center;">
                    <input type="submit" name="action_ordering_OrderingDisplaySettingExec" value="更　新" onClick="return confirm('更新しますか？')" />
                </td>
            </tr>
        </table>
    </form>
{/if}
{include file=$admFooter}
</div>
</body>
</html>