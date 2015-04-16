{include file=$admHeader}
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<link type="text/css" href="./css/pager.css" rel="stylesheet" />
<script type="text/javascript">
<!--

    $(function() {ldelim}

        {* テーブルマウスオーバーカラー *}
        $('#list_table').colorize({ldelim}
            altColor :'#CCCCCC',
            hiliteColor :'none'
        {rdelim});

        {* テーブルストライプ *}
        $("#src_table tr:even").addClass("BgColor02");


    {rdelim});

//-->
</script>
</head>
<body>

<div id="ContentsCol">

<h2 class="ContentTitle">アドレスCSVアップロード登録フォーム</h2>
<br />
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
{/if}

<form action="./" enctype="multipart/form-data" method="post">
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" id="src_table">
        <tr>
            <th>アドコード</th>
            <td>
            <input size="15" type="text" name="advcd" maxlength="15">
        </tr>
        <tr>
            <th>登録入口コード</th>
            <td>
            <input size="15" type="text" name="registPageId" maxlength="15">
        </tr>
        <tr>
            <th>対象CSVファイル</th>
	        <td>
	            <input type="hidden" name="MAX_FILE_SIZE" value="8000000">
	            <input type="file" name="regCsvFile">
	        </td>
        </tr>
        <tr>
	        <td style="text-align:center;" colspan="2">
	            <input type="submit" name="action_User_RegistCsvExec" value="ユーザー登録" OnClick="return confirm('登録しますか？')">
	        </td>
        </tr>
    </table>
</form>
{include file=$admFooter}
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script type="text/javascript" src="./js/watermark/jquery.watermark.min.js"></script>
<script type="text/javascript" src="./js/userSearch.js"></script>
</div>
</body>
</html>