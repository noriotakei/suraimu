{include file=$admHeader}
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script type="text/javascript">
<!--

    $(function() {ldelim}

        {* カレンダー *}
        $(".datepicker").datepicker({ldelim}
            numberOfMonths: 2,
            showButtonPanel: true,
            dateFormat: "yy-mm-dd"
        {rdelim});

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
<h2 class="ContentTitle">決済ログファイル確認</h2>

{* -20100806-takuro システムonlyとします *}
{if $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SYSTEM}
	<form action="./" method="POST">
	    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" id="src_table">
	        <tr>
	            <th colspan="2" style="text-align: center; font-weight: bold;">検索条件</th>
	        </tr>
	        <tr>
	            <th>決済日時</th>
	            <td>
	            <input class="datepicker" size="15" type="text" value="{$param.disp_date|default:$smarty.now|zend_date_format:'yyyy-MM-dd'}" name="disp_date" maxlength="10">
	        </tr>
	        <tr>
	            <th>決済種別</th>
	            <td>
	            {html_options name="pay_type" options=$payType selected=$param.pay_type separator="&nbsp;"}
	            </td>
	        </tr>
	        <tr>
	            <td style="text-align:center;" colspan="2">
	                <input type="submit" name="action_log_PaymentLogFileList" value="検 索" style="width:8em;"/>
	            </td>
	        </tr>
	    </table>
	</form>
	<hr>
	<br>

	{if $dataList}
	    <div style="padding-bottom: 10px;">
	    データ件数：{$totalCount}件<br />
	    </div>
	
	    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">
	    <tr>
	    <th>時間</th>
	    <th>種別</th>
	    <th>パラメータ</th>
	    </tr>
	
	    {foreach from=$dataList item="val" key="key"}
	        <tr>
	        <td nowrap="nowrap">{$val.time}</td>
	        <td nowrap="nowrap">{$payTypeNameArray[$val.type]}</td>
	        <td nowrap="nowrap">{$val.value}</td>
	        </tr>
	    {/foreach}
	
	    </table>
	    <br>
	    </div>
	{else}
	    <div class="warning ui-widget">
	    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
	    <p>
	    <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
	    データはありません
	    </p>
	    </div>
	{/if}
{else}
    <div class="warning ui-widget">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    <p>
    <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    システムonly!
    </p>
    </div>
{/if}
{include file=$admFooter}
</div>
</body>
</html>