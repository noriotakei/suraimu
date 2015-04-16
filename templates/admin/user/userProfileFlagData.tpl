{include file=$admHeader}
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
<script type="text/javascript" src="./js/jquery.timepickr.min.js"></script>
<script type="text/javascript">
<!--


    $(function() {ldelim}
        // テーブルマウスオーバーカラー
        $('#list_table').colorize({ldelim}
            altColor :'#CCCCCC',
            hiliteColor :'none'
        {rdelim});

    {rdelim});


//-->
</script>
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">フラグコードの名前を編集</h2>
{* 更新時エラーコメント *}
    {if $errMsg|@count}
        <div class="warning ui-widget">
        <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
        <p>
        <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
        { foreach from=$errMsg item="val" }
            {$val|@implode:"<br>"}
        {/foreach}
        </p>
        </div>
        </div>
        <br>
{/if}
{if $data}
    <div>
        <form action="./" method="post">
            {$POSTparam}
            <table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet04">
                <tr><th colspan="2" style="text-align:center;">フラグコードの名前を編集</th></tr>
                <tr>
                    <th>コード</th>
                    <td>{$data.code}</td>
                </tr>
                <tr>
                    <th>コード名</th>
                    <td><input name="user_profile_flag_name" value="{$data.name}" size="20"/></td>
                </tr>
                <tr>
                    <th>ｱｸｾｽ後の移動先</th>
                    <td>{html_options name="convert_code" options=$user_profile_flag_code_convert selected=$data.convert_code}</td>
                </tr>
                <tr>
                    <td  style="text-align: center;" colspan="3">
                        <input type="submit" id="submit" name="action_user_UpdateUserProfileFlagDataExec" value="更新" />
                    </td>
                </tr>
           </table>
        </form>
    </div>
    <br>
{/if}
</div>
{include file=$admFooter}
</div>
</body>
</html>
