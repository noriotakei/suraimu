{include file=$admHeader}
</head>
<body>
<div class="BlockCol">
    <h2 class="ContentTitle">サイト間登録サイト設定データ</h2>
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
        <input type="submit" name="action_registSite_RegistSiteList" value="一覧へ戻る" style="width:8em;"/>
    </form>
    <br>
    <form action="./" method="post">
        {$POSTparam}
        <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">
            <tr>
                <th>サイト名</th>
                <td><input type="text" name="name" value="{$registSiteData.name}" size="30"></td>
            </tr>
            <tr>
                <th>サイトコード</th>
                <td><input type="text" name="cd" value="{$registSiteData.cd}" size="10"></td>
            </tr>
            <tr>
                <th>PATH</th>
                <td><input type="text" name="path" value="{$registSiteData.path}" size="30"></td>
            </tr>
            <tr>
                <th>使用状況</th>
                <td>{html_radios name="is_use" options=$isUse selected=$registSiteData.is_use|default:0 separator="&nbsp;"}</td>
            </tr>
            <tr>
            <td colspan="2" style="text-align: center">
                <input type="submit" name="action_registSite_RegistSiteDataExec" value="登　録" onClick="return confirm('登録しますか？')" />
            </td>
            </tr>
        </table>
    </form>
    <br><br>
    <form action="./" method="post" >
        {$POSTparam}
        <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">
        <tr>
        <th>CSVファイル名を指定してください<br>({$filePath}<br>にcsvファイルを置いてください。)</th>
        <td><input type="text" name="file_name" size="50" value="" /></td>
        </tr>
        <tr>
        <td colspan="2" style="text-align: center">
        <input type="submit" name="action_registSite_registSiteCsvDataExec" value="CSVファイル読込み" />
        </td>
        </tr>
        </table>
    </form>

{include file=$admFooter}
</div>
</body>
</html>
