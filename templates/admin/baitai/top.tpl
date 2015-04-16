{include file=$admBaitaiHeader}
</head>
<body>
<div class="BlockCol">
    <h2 class="ContentTitle">媒体CHK</h2>
    <p id="Logout"><a href="{make_link action="action_baitai_Logout" getTags=$getTag}" target="_top">Logout</a></p>
    <br>
    <table border="0" width="70%" align="center">
        <tr>
        <td align="left" valign="top">
            <table>
            <tr>
                <td valign="top">
                <div id="inlineDatepicker"></div>
                </td>
            </tr>
            </table>
        </td>
        <td align="right" valign="top">
            <table cellspacing="0" cellpadding="0" class="TableSet04" id="menu_table">
            <tr>
                <th colspan="2" style="text-align: center; font-weight: bold;">集計方法を選択してください</th>
            </tr>
            <tr>
                {foreach from=$culcMenu item="val" key="key"}
                <td align="left">
                    <input type="radio" name="menu" value="{$val.file_name}" class="menu" id="{$key}"><label for="{$key}">{$val.name}</label>
                </td>
                {if $val.blank == "on"}<td>&nbsp;</td>{/if}
                {if $val.changeline == "on"}</tr><tr>{/if}
                {/foreach}
            </tr>
            </table>
        </td>
        </tr>
    </table>
    <br>
    {if $remakeFlag}
        <div style="text-align:center;">
            <a href="{make_link action="action_baitai_Remake" getTags=$getTag}" target="_blank">再集計へ</a>
        </div>
        <br>
    {/if}
    <div id="ajaxForm">
    <form>
    <table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet04" align="center">
        <tr>
            <th colspan="2" style="text-align: center; font-weight: bold;">検索条件</th>
        </tr>
        <tr>
            <th>期間指定</th>
            <td>
                <input size="15" class="datepicker" type="text" value="{$value.start_date|zend_date_format:'yyyy-MM-dd'}" name="start_date" maxlength="10">
                から
                <input size="15" class="datepicker" type="text" value="{$value.end_date|zend_date_format:'yyyy-MM-dd'}" name="end_date" maxlength="10">
            </td>
        </tr>
        <tr>
            <th>広告コード</th>
            <td>
                <input type="text" id="media_cd" name="media_cd" value="{$value.media_cd}" size="20" style="ime-mode:disabled;">
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center">
                    <input type="button" name="submit" value="更　新">
            </td>
        </tr>
    </table>
    </form>
    </div>
    <br>
    <hr>
    <br>
<div id="progressbar" style="width: 20%; text-align:center; margin:0 auto 0 auto; display:none;">{html_image file="./img/roller.gif"} データ受信中です。</div>
<div id="results"></div>
{include file=$admFooter}
</div>
{* グラフ作成
<link rel="stylesheet" href="./js/ext/resources/css/ext-all.css" type="text/css" media="all">
<script type="text/javascript" src="./js/ext/ext-jquery-adapter.js"></script>
<script type="text/javascript" src="./js/ext/ext-all.js"></script>
<script type="text/javascript" src="./js/ext/locale/ext-lang-ja.js"></script>
*}
<script language="JavaScript">
<!--
{*
    Ext.SSL_SECURE_URL = 'javascript:void(0)';
    Ext.BLANK_IMAGE_URL = './js/ext/resources/images/default/s.gif';
*}
    $(function() {ldelim}

        {* カレンダー *}
        $(".datepicker").datepicker({ldelim}
            showOn: 'button',
            buttonImage: './img/calendar.gif',
            buttonImageOnly: true,
            dateFormat: "yy-mm-dd"
        {rdelim});

        {* カレンダー *}
        $("#inlineDatepicker").datepicker({ldelim}
            numberOfMonths: 2,
            showButtonPanel: true,
            dateFormat: "yy-mm-dd",
            onSelect: function (dateText, inst) {ldelim}
                postAjax(dateText);
            {rdelim}
        {rdelim});

        $(":radio, :checkbox").live("click", function(env){ldelim}
            if (env.button !== 0) return;
            {* 日付を作成 *}
            var dateOBJ = new Date($("#inlineDatepicker").datepicker("getDate"))
            var datetext = dateOBJ.getFullYear() + "-" + (dateOBJ.getMonth() + 1) + "-" + dateOBJ.getDate();
            postAjax(datetext);
        {rdelim});

        $(":button").live("click", function(env){ldelim}
            if (env.button !== 0) return;
            {* 日付を作成 *}
            var dateOBJ = new Date($("#inlineDatepicker").datepicker("getDate"))
            var datetext = dateOBJ.getFullYear() + "-" + (dateOBJ.getMonth() + 1) + "-" + dateOBJ.getDate();
            postAjax(datetext);
        {rdelim});

        $(":option").live("change", function(){ldelim}
            {* 日付を作成 *}
            var dateOBJ = new Date($("#inlineDatepicker").datepicker("getDate"))
            var datetext = dateOBJ.getFullYear() + "-" + (dateOBJ.getMonth() + 1) + "-" + dateOBJ.getDate();
            postAjax(datetext);
        {rdelim});


        $("#media_cd").live("keyup", function(){ldelim}
            {* 日付を作成 *}
            var dateOBJ = new Date($("#inlineDatepicker").datepicker("getDate"))
            var datetext = dateOBJ.getFullYear() + "-" + (dateOBJ.getMonth() + 1) + "-" + dateOBJ.getDate();
            postAjax(datetext);
        {rdelim});

        {* テーブルストライプ *}
        $("#src_table tr:even").addClass("BgColor02");

        {* テーブルストライプ *}
        $("#menu_table tr:even").addClass("BgColor02");

    {rdelim});

    function postAjax (datetext) {ldelim}
        var data = $("input[name='menu']:checked").val() + "=1&date=" + datetext + "&";
        data += $("#ajaxForm form").serialize();

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
</body>
</html>
