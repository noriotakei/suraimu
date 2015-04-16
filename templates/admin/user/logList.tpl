{include file=$admHeader}
<script language="JavaScript">
<!--

    $(function() {ldelim}

        $(":radio, :checkbox, :button").live("click", function(env){ldelim}
            if (env.button !== 0) return;
            postAjax();
        {rdelim});

        {* テーブルストライプ *}
        $("#menu_table tr:even").addClass("BgColor02");

    {rdelim});

    function postAjax () {ldelim}
        var data = $("input[name='menu']:checked").val() + "&";
        data += $("#ajaxForm").serialize();

        if ($("input[name='menu']:checked").val()) {ldelim}
            $("#progressbar").show();
            $.ajax({ldelim}
                type: "POST",
                url: "index.php",
                data : data,
                cache: false,
                success: function(html){ldelim}
                    $("#progressbar").hide();
                    $("#results").empty();
                    $("#results").append(html);
                {rdelim},
                error: function(html){ldelim}
                    $("#progressbar").hide();
                    $("#results").empty();
                {rdelim}
            {rdelim});
        {rdelim}
    {rdelim}

// -->
</script>
</head>
<body>
<div class="BlockCol">
    <h2 class="ContentTitle">各種ログ</h2>
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

    <table border="0" cellspacing="0" cellpadding="0" class="TableSet02" align="center">
        <tr>
            <th>ﾕｰｻﾞｰID</th>
            <td style="text-align: left;">{$userData.user_id}</td>
        </tr>
    </table>
    <br>
    <form id="ajaxForm">
        {$POSTparam}
        <table cellspacing="0" cellpadding="0" class="TableSet04" id="menu_table" align="center">
            <tr>
                <th colspan="{$logMenu|@count}" style="text-align: center; font-weight: bold;">ログを選択してください</th>
            </tr>
            <tr>
                {foreach from=$logMenu item="val" key="key"}
                <td align="left">
                    <input type="radio" name="menu" value="{$val.file_name}" class="menu" id="{$key}"><label for="{$key}">{$val.name}</label>
                </td>
                {if $val.blank == "on"}<td>&nbsp;</td>{/if}
                {if $val.changeline == "on"}</tr><tr>{/if}
                {/foreach}
            </tr>
            <tr>
                <td colspan="{$logMenu|@count}" style="text-align: center">
                        <input type="button" name="submit" value="更　新">
                </td>
            </tr>
        </table>
    </form>
    <br>
    <hr>
    <br>
<div id="progressbar" style="width: 20%; text-align:center; margin:0 auto 0 auto; display:none;">{html_image file="./img/roller.gif"} データ受信中です。</div>
<div id="results"></div>
{include file=$admFooter}
</div>
</body>
</html>
