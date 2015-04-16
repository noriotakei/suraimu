{include file=$admHeader}
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script type="text/javascript">
<!--

    $(function() {ldelim}

        {* テーブルマウスオーバーカラー *}
       $('#list_table').colorize({ldelim}
           altColor :'#CCCCCC',
           hiliteColor :'none'
       {rdelim});

        {* 追加フォーム *}
        if (!{$registSiteData.return_flag}) {ldelim}
            $("#add_form").hide();
        {rdelim} else {ldelim}
            $("#add_form").show();
        {rdelim}
        $('#add_button').live("click", function(env){ldelim}
            if (env.button !== 0) return;
            $("#add_form").toggle("blind", null, "slow");
        {rdelim});

    {rdelim});

//-->
</script>
</head>
<body>
<div class="BlockCol">
    <h2 class="ContentTitle">サイト間登録サイト設定一覧</h2>
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
    <div class="SubMenu">
        <input type="button" id="add_button" value="追　加" />
    </div>
    <div id="add_form" style="display:none">
    <form action="./" method="post">
        {$POSTparam}
        <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
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
                <td><input type="text" name="path" value="{$registSiteData.path|default:"http://"}" size="30"></td>
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
    </div>
    <br>
    <form action="./" method="post">
        {$POSTparam}
        <input type="hidden" name="device_pc" value="1">
        <div class="SubMenu">
            <input type="submit" value="PCメアドCSV出力" name="action_registSite_CsvExec"/>
        </div>
    </form>
    <form action="./" method="post">
        {$POSTparam}
        <div class="SubMenu">
            <input type="submit" value="MBメアドCSV出力" name="action_registSite_CsvExec"/>
        </div>
    </form>
    <br>
    {if $registSiteList}
        <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet01">
        <tr>
            <th style="text-align: center;">サイト名</th>
            <th style="text-align: center;">サイトコード</th>
            <th style="text-align: center;">PATH</th>
            <th style="text-align: center;">使用状況</th>
            <th style="text-align: center;">更新日時</th>
            <th style="text-align: center;">編集</th>
            <th style="text-align: center;">削除</th>
        </tr>
        {foreach from=$registSiteList item="val" name="loop"}
            <tr>
                <td>{$val.name}</td>
                <td>{$val.cd}</td>
                <td>{$val.path}</td>
                <td>{$isUse[$val.is_use]}</td>
                <td>{$val.update_datetime}</td>
                <td>
                    <form action="./" method="post">
                        <input type="hidden" name="regist_site_id" value="{$val.id}">
                        <input type="submit" name="action_registSite_RegistSiteData" value="編 集"/>
                    </form>
                </td>
                <td>
                    <form action="./" method="post">
                        <input type="hidden" name="regist_site_id" value="{$val.id}">
                        <input type="hidden" name="disable" value="1">
                        <input type="submit" name="action_registSite_RegistSiteDataExec" value="削 除" OnClick="return confirm('削除しますか？')"/>
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
