{include file=$admHeader}
<link rel="stylesheet" href="./js/ext/resources/css/ext-all.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="./js/jqPlot/jquery.jqplot.min.css" />
</head>
<body>
<div class="BlockCol">
    <h2 class="ContentTitle">一般集計</h2>
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
    <div id="sendForm">
    <table border="0" align="center">
        <tr>
        <td>
                <div id="inlineDatepicker"></div>
        </td>
        </tr>
    </table>
    <br><br>
    <table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet04" align="center">
        <tr>
            <th colspan="5" style="text-align: center; font-weight: bold;">集計方法を選択してください</th>
        </tr>
        <tr>
                {foreach from=$culcMenu item="val" key="key" name="loop"}
                <td align="left">
                    <input type="radio" name="menu" value="{$val.file_name}" class="menu" id="{$key}"><label for="{$key}">{$val.name}</label>
                </td>
                {if $smarty.foreach.loop.iteration % 5 == 0}
                </tr>
                {if not $smarty.foreach.loop.last}
                <tr>
                {/if}
                {/if}
                {/foreach}
        </tr>
    </table>
    <br><br>
    <form id="ajaxForm">
    <table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet04" align="center">
        <tr>
            <th colspan="2" style="text-align: center; font-weight: bold;">検索条件</th>
        </tr>
        <tr>
            <th>期間指定(<font color="red">※</font>のみ有効)</th>
            <td>
                <input size="15" class="datepicker" type="text" value="{$value.start_date|zend_date_format:'yyyy-MM-dd'}" name="start_date" maxlength="10">
                から
                <input size="15" class="datepicker" type="text" value="{$value.end_date|zend_date_format:'yyyy-MM-dd'}" name="end_date" maxlength="10">
            </td>
        </tr>
        <tr>
            <th>PCアドレス</th>
            <td>
                {html_radios label_ids=true name="pc_address_specify" options=$specifyArray selected=$value.pc_address_specify|default:0 separator="&nbsp;"}
            </td>
        </tr>
        <tr>
            <th>MBアドレス</th>
            <td>
                {html_radios label_ids=true name="mb_address_specify" options=$specifyArray selected=$value.mb_address_specify|default:0 separator="&nbsp;"}
            </td>
        </tr>
        <tr>
            <th>PCデバイス</th>
            <td>
                {html_checkboxes name="pc_device_cd" options=$config.admin_config.pc_device selected=$value.pc_device_cd separator="&nbsp;"}
            </td>
        </tr>
        <tr>
            <th>MBデバイス</th>
            <td>
                {html_checkboxes name="mb_device_cd" options=$config.admin_config.mb_device selected=$value.mb_device_cd separator="&nbsp;"}
            </td>
        </tr>
        <tr>
            <th>性別</th>
            <td>
                {html_checkboxes name="sex_cd" options=$config.admin_config.sex_cd selected=$value.sex_cd separator="&nbsp;"}
            </td>
        </tr>
        <tr>
            <th>媒体コード<br>(カンマ区切りで複数可)<br>[% => 任意の数の文字]<br>[_ =>  1 つの文字]</th>
            <td>
                <input type="text" id="media_cd" name="media_cd" value="{$value.media_cd}" size="20" style="ime-mode:disabled;">
            </td>
        </tr>
        <tr>
            <th>登録入口カテゴリー</th>
            <td style="text-align: left;">
                {html_checkboxes name="regist_page_category_id" options=$registPageCategoryList selected=$value.regist_page_category_id separator="&nbsp;"}
            </td>
        </tr>
        <tr>
        <th>登録入口ID<br>(カンマ区切りで複数可)</th>
            <td style="text-align: left;">
                <div>
                    対象を抽出：<input type="text" id="regist_page_id" name="regist_page_id" value="{$value.regist_page_id}" size="20" style="ime-mode:disabled;">
                </div>
                <div>
                    以外を抽出：<input type="text" id="except_regist_page_id" name="except_regist_page_id" value="{$value.except_regist_page_id}" size="20" style="ime-mode:disabled;">
                </div>
            </td>
        </tr>
        {* システム用メニュー *}
        {if $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SYSTEM}
            {if $mediaCdAry|@count}
                <tr>
                    <th>登録媒体コード</th>
                    <td>
                        {html_options id="select_media_cd" name="select_media_cd" options=$mediaCdAry selected=$value.select_media_cd}
                    </td>
                </tr>
            {/if}
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
<div id="results" name="results"></div>
{include file=$admFooter}
</div>
<!--[if IE]><script language="javascript" type="text/javascript" src="./js/jqPlot/excanvas.min.js"></script><![endif]-->
<script language="javascript" type="text/javascript" src="./js/jqPlot/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="./js/ext/adapter/jquery/ext-jquery-adapter.js"></script>
<script type="text/javascript" src="./js/ext/ext-all.js"></script>
<script type="text/javascript" src="./js/ext/src/locale/ext-lang-ja.js"></script>
<script type="text/javascript" src="./js/ext/examples/ux/RowExpander.js"></script>
<script type="text/javascript" src="./js/ext/examples/ux/SlidingPager.js"></script>
<script language="JavaScript">
<!--
{literal}
    Ext.BLANK_IMAGE_URL = './js/ext/resources/images/default/s.gif';
    $(function() {

        // カレンダー
        $(".datepicker").datepicker({
            showOn: 'button',
            buttonImage: './img/calendar.gif',
            buttonImageOnly: true,
            dateFormat: "yy-mm-dd"
        });

        // カレンダー
        $("#inlineDatepicker").datepicker({
            numberOfMonths: 2,
            showButtonPanel: true,
            dateFormat: "yy-mm-dd",
            onSelect: function (dateText, inst) {
                postAjax(dateText);
                window.location.hash = "results";
            }
        });

        $("#sendForm :button, .menu").live("click", function(env){
            if (env.button !== 0) return;
            // 日付を作成
            var dateOBJ = new Date($("#inlineDatepicker").datepicker("getDate"))
            var datetext = dateOBJ.getFullYear() + "-" + (dateOBJ.getMonth() + 1) + "-" + dateOBJ.getDate();
            postAjax(datetext);
            window.location.hash = "results";
        });

        // テーブルストライプ
        $("#src_table tr:even").addClass("BgColor02");

        // テーブルストライプ *}
        $("#menu_table tr:even").addClass("BgColor02");

    });

    function postAjax (datetext) {
        var data = $("input[name='menu']:checked").val() + "&date=" + datetext + "&";
        data += $("#ajaxForm").serialize();

        if ($("input[name='menu']:checked").val()) {
            $.ajax({
                type: "POST",
                url: "index.php",
                data : data,
                cache: false,
                success: function(html){
                    $("#results").empty();
                    $("#results").append(html);
                },
                error: function(html){
                    $("#results").empty();
                }
            });
        }
    }
{/literal}
// -->
</script>
</body>
</html>
