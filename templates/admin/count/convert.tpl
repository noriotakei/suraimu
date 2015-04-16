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

<h2 class="ContentTitle">コンバートユーザー集計</h2>
<form action="./" method="POST">
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" id="src_table">
        <tr>
            <th colspan="2" style="text-align: center; font-weight: bold;">検索条件</th>
        </tr>
        <tr>
            <th>期間指定</th>
            <td>
                <input size="15" class="datepicker" type="text" value="{$param.start_date|zend_date_format:'yyyy-MM-dd'}" name="start_date" maxlength="10">
                から
                <input size="15" class="datepicker" type="text" value="{$param.end_date|zend_date_format:'yyyy-MM-dd'}" name="end_date" maxlength="10">
            </td>
        </tr>
		<tr>
		    <td>媒体コード<br>(カンマ区切りで複数可)<br>[% => 任意の数の文字]<br>[_ =>  1 つの文字]</td>
		    <td style="text-align: left;">
		        <div id="media_cd">
		            <input type="text" name="media_cd" value="{$param.media_cd}" size="30" style="ime-mode:disabled;">
		        </div>
		    </td>
		</tr>
        <tr>
            <td style="text-align:center;" colspan="2">
                <input type="submit" name="action_count_convert" value="検 索" style="width:8em;"/>
            </td>
        </tr>
    </table>
</form>
<hr>
<br>




<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr class="BgColor03">
        <th></th>
{*
        <th colspan="4">合計</th>
        <th colspan="4">元サイト</th>
*}
        <th colspan="4">コンバート先</th>
    </tr>
    <tr>
        <th>媒体コード</th>
{*
        <th>新規合計</th>
        <th>売上合計</th>
        <th>当月合計</th>
        <th>過去三ヶ月合計</th>
        <th>新規</th>
        <th>売上</th>
        <th>当月</th>
        <th>過去三ヶ月</th>
*}
        <th>新規</th>
        <th>売上</th>
        <th>当月</th>
        <th>過去三ヶ月</th>
    </tr>
    {foreach from=$mediaCdDataArray item="val" key="key" name="loop"}
    <tr>
        <td>{$key}</td>
{*
        <td>{$val.countUser}</td>
        <td>{$val.trade_amount_all}</td>
        <td>{$val.regist_amount_all}</td>
        <td>{$val.3month_amount_all}</td>
        <td>{$val.countUser}</td>
        <td>{$val.trade_amount}</td>
        <td>{$val.regist_amount}</td>
        <td>{$val.3month_amount}</td>
*}
        <td>0</td>
        <td>{$val.convert_trade_amount}</td>
        <td>{$val.convert_regist_amount}</td>
        <td>{$val.convert_3month_amount}</td>
    </tr>
    {/foreach}
    <tr>
    <tr>
        <th>合計</th>
{*
        <th>{$synthesisRegistCount}</th>
        <th>{$synthesisTradeAmount}</th>
        <th>{$synthesisRegistAmount}</th>
        <th>{$synthesis3MonthAmount}</th>
        <th>{$allRegistCount}</th>
        <th>{$allTradeAmount}</th>
        <th>{$allRegistAmount}</th>
        <th>{$all3MonthAmount}</th>
*}
        <th>0</th>
        <th>{$allConvertTradeAmount}</th>
        <th>{$allConvertRegistAmount}</th>
        <th>{$allConvert3MonthAmount}</th>
    </tr>
</table>
<br><br><br>