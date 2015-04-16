{include file=$admHeader}
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
<script type="text/javascript" src="./js/jquery.timepickr.min.js"></script>
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<link type="text/css" href="./css/pager.css" rel="stylesheet" />
<script type="text/javascript">
<!--


    $(function() {ldelim}
        {* 時刻入力 *}
        $(".time").timepickr({ldelim}
            format24: "{ldelim}h:02.d{rdelim}:{ldelim}m:02.d{rdelim}:{ldelim}s:02.d{rdelim}",
            seconds: true,
            rangeMin: ["00","05","10","15","20","25","30","35","40","45","50","55","59"],
            rangeSec: ["00","15","30","45","59"],
            convention: 24
        {rdelim});

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

<h2 class="ContentTitle">サポートメール予約配信一覧</h2>
<form action="./" method="POST">
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" id="src_table">
        <tr>
            <th colspan="2" style="text-align: center; font-weight: bold;">検索条件</th>
        </tr>
        <tr>
            <th>配信予定時間</th>
            <td>
            <input class="datepicker" size="15" type="text" value="{$param.dispDatetimeFrom|default:$smarty.now|zend_date_format:'yyyy-MM-dd'}" name="disp_date_from"maxlength="10">&nbsp;<input name="disp_time_from" class="time" type="text" value="{$param.dispDatetimeFrom|zend_date_format:'HH:mm:ss'}" size="10"maxlength="8">
                ～&nbsp;<input class="datepicker" size="15" type="text" value="{$param.dispDatetimeTo|default:$smarty.now|zend_date_format:'yyyy-MM-dd'}" name="disp_date_to"maxlength="10">&nbsp;<input name="disp_time_to" class="time" type="text" value="{$param.dispDatetimeTo|zend_date_format:'HH:mm:ss'}" size="10"maxlength="8"></td>
        </tr>
        <tr>
            <td style="text-align:center;" colspan="2">
                <input type="submit" name="action_ordering_ReserveSupportMailList" value="検 索" style="width:8em;"/>
            </td>
        </tr>
    </table>
</form>
<hr>
{* コメント *}
{if $msg|@count}
    <div class="warning ui-widget">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    <p>
    <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    { foreach from=$msg item="val" }
        {$val|@implode:"<br>"}
    {/foreach}
    </p>
    </div>
    </div>
    <br>
{/if}

{if $dataList}
    <div style="padding-bottom: 10px;">
    {$totalCount}件中<br />
    {$dispFirst}～{$dispLast}件表示しています
    {if $pager}
    <ul class="pager">
        <li>{$pager.previous}</li>
        <li>{$pager.pages|@implode:"</li><li>"}</li>
        <li>{$pager.next}</li>
    </ul>
    {/if}
    </div>

    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet02">

    <tr>
    <th>ID</th>
    <th>配信予定時間</th>
    <th>PC件名</th>
    <th>MB件名</th>
    <th>配信状況</th>
    <th>作成日時</th>
    <th>削除</th>
    </tr>
    {foreach from=$dataList item="val"}
        <tr>
        <td><a href="{make_link action="action_ordering_ReserveSupportMailData" getTags="support_mail_reserve_id="|cat:$val.id}" target="_blank">{$val.id}</a></td>
        <td>{$val.send_datetime}</td>
        <td>{$val.pc_subject|emoji}</td>
        <td>{$val.mb_subject|emoji}</td>
        <td>{if $val.is_send}配信済み{else}未配信{/if}</td>
        <td>{$val.create_datetime}</td>
        <td>
            <form action="./" method="post" style="margin:2px 0px;">
                {$POSTParam}
                <input type="hidden" name="support_mail_reserve_id" value="{$val.id}">
                <input type="submit" name="action_ordering_ReserveSupportMailDelExec" value="削除" onClick="return confirm('削除しますか?')">
            </form>
        </td>
        </tr>
    {/foreach}
    </table>
    <br />
    <div style="padding-bottom: 10px;">
    {$totalCount}件中<br />
    {$dispFirst}～{$dispLast}件表示しています
    {if $pager}
    <ul class="pager">
        <li>{$pager.previous}</li>
        <li>{$pager.pages|@implode:"</li><li>"}</li>
        <li>{$pager.next}</li>
    </ul>
    {/if}
    </div>

{else}
    <div class="warning ui-widget">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    <p>
    <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    該当ログはありません
    </p>
    </div>
    </div>
{/if}
{include file=$admFooter}
</div>
</body>
</html>