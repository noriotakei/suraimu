{include file=$admBaitaiAgencyHeader}
</head>
<body>
<div class="BlockCol">
    <h2 class="ContentTitle">代理店媒体CHK</h2>
    <p id="Logout"><a href="{make_link action="action_Logout" getTags=$URLparam}" target="_top">Logout</a></p>
    <br>
    <table cellspacing="0" cellpadding="0" align="center">
        <tr>
            <td valign="top">
                <span style="color:#000;font-size:24px;">{if !$adminId}代理店：{/if}{$loginBaitaiUserData.name}</span>
            </td>
        </tr>
    </table>
    <br>
    <table cellspacing="0" cellpadding="0" align="center">
        <tr>
            <td valign="top">
                <div id="inlineDatepicker"></div>
            </td>
        </tr>
    </table>
    <br>
    <table cellspacing="0" cellpadding="0" class="TableSet04" id="menu_table" align="center">
        <tr>
            <th colspan="{$culcMenu|@count}" style="text-align: center; font-weight: bold;">集計方法を選択してください</th>
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
    <br>
    <div id="ajaxForm">
    <form>
    <table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet04" align="center">
        <tr>
            <th colspan="2" style="text-align: center; font-weight: bold;">検索条件</th>
        </tr>
        <tr>
            <th>期間指定(<font color="red">※</font>のみ有効)</th>
            <td>
                <input size="15" class="datepicker" type="text" value="{$value.start_date|zend_date_format:'yyyy-MM-dd'}" name="start_date" maxlength="10">
                &nbsp;から&nbsp;
                <input size="15" class="datepicker" type="text" value="{$value.end_date|zend_date_format:'yyyy-MM-dd'}" name="end_date" maxlength="10">
                &nbsp;<font color="blue">※「起点日集計」の場合、「開始～終了」は同一日付のみ有効。</font>
            </td>
        </tr>
        <tr>
            <th>入金額、入金者数限定期間指定</th>
            <td>
                <input size="15" class="datepicker" type="text" value="{$value.start_date_trade|zend_date_format:'yyyy-MM-dd'}" name="start_date_trade" maxlength="10">
                &nbsp;から&nbsp;
                <input size="15" class="datepicker" type="text" value="{$value.end_date_trade|zend_date_format:'yyyy-MM-dd'}" name="end_date_trade" maxlength="10">
                &nbsp;<font color="blue">※from～to両方入力で登録日時の指定が出来ます。</font>
            </td>
        </tr>
        {*
        <tr>
            <th>仮登録登録期間(<font color="red">※</font>のみ有効)</th>
            <td>
                <input size="15" class="datepicker" type="text" value="{$value.start_pre_regist_date|zend_date_format:'yyyy-MM-dd'}" name="start_pre_regist_date" maxlength="10">
                &nbsp;から&nbsp;
                <input size="15" class="datepicker" type="text" value="{$value.end_pre_regist_date|zend_date_format:'yyyy-MM-dd'}" name="end_pre_regist_date" maxlength="10">
                &nbsp;<font color="blue">※「起点日集計」の場合、「開始～終了」は同一日付のみ有効。</font>
            </td>
        </tr>
        <tr>
            <th>売上集計期間<br>(入金期間)</th>
            <td>
                <input size="15" class="datepicker" type="text" value="{$value.start_pay_date|zend_date_format:'yyyy-MM-dd'}" name="start_pay_date" maxlength="10">
                &nbsp;から&nbsp;
                <input size="15" class="datepicker" type="text" value="{$value.end_pay_date|zend_date_format:'yyyy-MM-dd'}" name="end_pay_date" maxlength="10">
            </td>
        </tr>
        *}
        <tr>
            <th>媒体コード<br>(カンマ区切りで複数可)</th>
            <td>
                <input type="text" id="media_cd" name="media_cd" value="{$value.media_cd}" size="20" style="ime-mode:disabled;">
                &nbsp;{html_radios id="specify_baitai_chk" name="specify_baitai_chk" options=$config.admin_config.specify_baitai_chk selected=$value.specify_baitai_chk separator="&nbsp;"}
            </td>
        </tr>
        <tr>
            <th>年齢(<font color="red">本登録者数</font>のみ有効)</th>
            <td style="text-align: left;">
                <input type="text" class="from" name="user_age_from" value="{$value.user_age_from}" size="5" style="ime-mode:disabled;text-align:right;">
                歳以上
                <input type="text" class="to" name="user_age_to" value="{$value.user_age_to}" size="5" style="ime-mode:disabled;text-align:right;">
                歳まで
            </td>
        </tr>
        {if $corporation}
            <tr>
                <td colspan="2" style="text-align: center">
                    広告代理店媒体ＡＬＬ<input type="checkbox" name="advertise_all" value="1">
                 </td>
            </tr>
        {/if}
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
{include file=$admBaitaiAgencyFooter}
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
