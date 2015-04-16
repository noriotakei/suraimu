{include file=$admHeader}
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script language="JavaScript">
<!--
    $(function() {ldelim}
        // テーブルマウスオーバーカラー
        $('#list_table').colorize({ldelim}
            altColor :'#CCCCCC',
            hiliteColor :'none'
        {rdelim});
    {rdelim});

// -->
</script>
</head>
<body>
<div class="BlockCol">
    <h2 class="ContentTitle">サイト表示設定一覧</h2>
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
        <input type="submit" name="action_siteContents_SiteContentsData" value="追 加"/>
    </form>
    <br>
    {if $siteContentsList}
        <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet01">
        <tr>
            <th style="text-align: center;">表示場所</th>
            <th style="text-align: center;">タイトル</th>
            <th style="text-align: center;">表示状態</th>
            <th style="text-align: center;">表示開始日時</th>
            <th style="text-align: center;">表示終了日時</th>
            <th style="text-align: center;">更新日時</th>
            <th style="text-align: center;">編集</th>
            <th style="text-align: center;">削除</th>
        </tr>
        {foreach from=$siteContentsList item="val" name="loop"}
            <tr style="{$val.style}">
                <td>{$disableCd[$val.display_cd]}</td>
                <td>{$val.title}</td>
                <td>{$displayFlag[$val.is_display]}</td>
                <td>{$val.start_datetime}</td>
                <td>{$val.end_datetime}</td>
                <td>{$val.update_datetime}</td>
                <td>
                    <form action="./" method="post">
                        <input type="hidden" name="page_banner_id" value="{$val.id}">
                        <input type="submit" name="action_siteContents_SiteContentsData" value="編 集"/>
                    </form>
                </td>
                <td>
                    <form action="./" method="post">
                        <input type="hidden" name="page_banner_id" value="{$val.id}">
                        <input type="hidden" name="disable" value="1">
                        <input type="submit" name="action_siteContents_SiteContentsDataExec" value="削 除" OnClick="return confirm('削除しますか？')"/>
                    </form>
                </td>
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
