{include file=$admHeader}
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
<link type="text/css" href="./css/pager.css" rel="stylesheet" />
<style type="text/css">
.watermark {ldelim}
   color: #999;
{rdelim}
</style>
</head>
<body>
<div class="BlockCol">
    <h2 class="ContentTitle">注文一覧</h2>
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
        <input type="button" id="search_button" value="検索フォーム表示/非表示" />
    </div>
    <form action="./" method="post" id="search_form">
    {$POSTparam}
        <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" id="src_table">
            <tr>
                <th colspan="2" style="text-align: center; font-weight: bold;">検索条件</th>
            </tr>
            <tr>
                <td>注文日付</td>
                <td style="text-align: left;">
                    {html_radios id="specify_order_date" name="specify_order_date" options=$config.admin_config.specify_date_time_select selected=$param.specify_order_date separator="&nbsp;"}
                    <br>
                    <div id="order_date">
                        <input size="15" class="datepicker" type="text" value="{$param.order_start_datetime|zend_date_format:'yyyy-MM-dd'}" name="order_start_datetime_Date" maxlength="10">
                        <input name="order_start_datetime_Time" class="time" type="text" value="{$param.order_start_datetime|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
                        ～&nbsp;<input size="15" class="datepicker" type="text" value="{$param.order_end_datetime|zend_date_format:'yyyy-MM-dd'}" name="order_end_datetime_Date" maxlength="10">
                        <input name="order_end_datetime_Time" class="time" type="text" value="{$param.order_end_datetime|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
                    </div>
                    <div id="order_time">
                        <input type="text" class="from" name="order_time_from" value="{$param.order_time_from}" size="6" maxlength="3" style="ime-mode:disabled;text-align:right;">
                        時間前以上
                        <input type="text" class="to" name="order_time_to" value="{$param.order_time_to}" size="6" maxlength="3" style="ime-mode:disabled;text-align:right;">
                        時間前まで
                    </div>
                </td>
            </tr>
            <tr>
                <td>決済完了日付</td>
                <td style="text-align: left;">
                    {html_radios id="specify_paid_date" name="specify_paid_date" options=$config.admin_config.specify_date_time_select selected=$param.specify_paid_date separator="&nbsp;"}
                    <br>
                    <div id="paid_date">
                        <input size="15" class="datepicker" type="text" value="{$param.paid_start_datetime|zend_date_format:'yyyy-MM-dd'}" name="paid_start_datetime_Date" maxlength="10">
                        <input name="paid_start_datetime_Time" class="time" type="text" value="{$param.paid_start_datetime|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
                        ～&nbsp;<input size="15" class="datepicker" type="text" value="{$param.paid_end_datetime|zend_date_format:'yyyy-MM-dd'}" name="paid_end_datetime_Date" maxlength="10">
                        <input name="paid_end_datetime_Time" class="time" type="text" value="{$param.paid_end_datetime|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
                    </div>
                    <div id="paid_time">
                        <input type="text" class="from" name="paid_time_from" value="{$param.paid_time_from}" size="6" maxlength="3" style="ime-mode:disabled;text-align:right;">
                        時間前以上
                        <input type="text" class="to" name="paid_time_to" value="{$param.paid_time_to}" size="6" maxlength="3" style="ime-mode:disabled;text-align:right;">
                        時間前まで
                    </div>
                </td>
            </tr>
            <tr>
                <td>ユーザーID</td>
                <td>
                     <input type="text" name="user_id" value="{$param.user_id}" size="10" style="ime-mode:disabled;">
                </td>
            </tr>
            <tr>
                <td>会員解除</td>
                <td>
                    <input type="checkbox" name="is_quit" value="1" {if $param.is_quit}checked{/if}>会員解除ユーザーも含む
                </td>
            </tr>
            <tr>
                <td>ブラック</td>
                <td>
                    <input type="checkbox" name="is_danger" value="1" {if $param.is_danger}checked{/if}>ブラックユーザーも含む
                </td>
            </tr>
            <tr>
                <td>注文NO</td>
                <td>
                     <input type="text" name="search_ordering_id" value="{$param.search_ordering_id}" size="10" style="ime-mode:disabled;">
                </td>
            </tr>
            <tr>
                <td>商品ID</td>
                <td>
                     <input type="text" name="search_item_id" value="{$param.search_item_id}" size="5" style="ime-mode:disabled;">
                </td>
            </tr>
            <tr>
                <td>PCメールアドレス</td>
                <td>
                     <input type="text" name="pc_address" value="{$param.pc_address}" size="50" style="ime-mode:disabled;">
                </td>
            </tr>
            <tr>
                <td>MBメールアドレス</td>
                <td>
                     <input type="text" name="mb_address" value="{$param.mb_address}" size="50" style="ime-mode:disabled;">
                </td>
            </tr>
            <tr>
                <td>注文ステータス</td>
                <td>
                    {html_checkboxes name="order_status" options=$orderStatus selected=$param.order_status separator="&nbsp;" assign="checkboxes"}
                    {foreach from=$checkboxes item="checkbox"}
                        {$checkbox}{cycle values=",,,<br />"}
                    {/foreach}
                </td>
            </tr>
            <tr>
                <td>支払方法</td>
                <td>
                    {html_checkboxes name="pay_type" options=$payType selected=$param.pay_type separator="&nbsp;"}
                </td>
            </tr>
            <tr>
                <td>入金</td>
                <td>
                    {html_checkboxes name="is_paid" options=$paidFlag selected=$param.is_paid separator="&nbsp;"}
                </td>
            </tr>
            <tr>
                <td>キャンセル</td>
                <td>
                    {html_checkboxes name="is_cancel" options=$cancelFlag selected=$param.is_cancel separator="&nbsp;"}
                </td>
            </tr>
            <tr>
                <td>重複ユーザー</td>
                <td>
                    {html_radios name="is_overlap" options=$overLapFlag selected=$param.is_overlap|default:1 separator="&nbsp;"}
                </td>
            </tr>
            <tr>
                <td>無効商品</td>
                <td>
                    <input type="checkbox" name="is_invalid" value="1" {if $param.is_invalid}checked{/if}>無効商品を含む注文を除く
                </td>
            </tr>
            <tr>
                <td style="text-align:center;" colspan="2">
                    <input type="hidden" name="search_flag" value="1">
                    <input type="submit" name="action_ordering_OrderingSearchList" value="検 索" style="width:8em;"/>
                </td>
            </tr>
        </table>
    </form>
    <br>
    {if $param.search_flag}
    <form action="./" method="post">
        {$supportPOSTparam}
        <input type="submit" name="action_ordering_SupportMailBulkInput" value="サポートメール一括送信"/>
    </form>
    <br>
    {/if}
    {if $orderingList}
        <div style="padding-bottom: 10px;">
        件数：{$totalCount}件<br />
        {$dispFirst}～{$dispLast}件表示しています
        {if $pager}
        <ul class="pager">
            <li>{$pager.previous}</li>
            <li>{$pager.pages|@implode:"</li><li>"}</li>
            <li>{$pager.next}</li>
        </ul>
        {/if}
        </div>
        <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
        <tr>
            <th rowspan="2">&nbsp;</th>
            <th><p>注文NO</p></th>
            <th>ユーザーID</th>
            <th>支払方法</th>
            <th>注文日時</th>
            <th>商品明細</th>
          </tr>
          <tr>
            <th>ステータス</th>
            <th>キャンセル</th>
            <th>入金</th>
            <th colspan="2">メモ</th>
          </tr>

        {foreach from=$orderingList key="key" item="val" name="loop"}
            <tr {$val.style}>
                <td rowspan="2">
                    <form action="./" method="post">
                        {$POSTparam}
                        <input type="hidden" name="ordering_id" value="{$val.id}">
                        <input type="submit" name="action_ordering_OrderingData" value="編 集"/>
                    </form>
                </td>
                <td>{$val.id}</td>
                <td><a href="./?action_user_Detail=1&user_id={$val.user_id}" target="_blank">{$val.user_id}</a></td>
                <td>{$payType[$val.pay_type]}</td>
                <td>{$val.create_datetime}</td>
                <td>
                    商品<br>
                    <table border="0" cellpadding="0" cellspacing="0" style="font-size:11px">
                        {foreach from=$itemList[$key] item="itemVal" name="itemLoop"}
                        <tr >
                            <td width="150">{if $itemVal.is_rest}余り金PT購入{else}{$itemVal.name|emoji}{/if}</td>
                            <td nowrap>\{$itemVal.price|number_format}</td>
                        </tr>
                        {/foreach}
                        <tr>
                            <td nowrap>合計</td>
                            <td nowrap>\{$val.pay_total|number_format}</td>
                        </tr>
                    </table>
                    <br>
                    {if $changeItemList[$key]}
                    注文変更履歴<br>
                    <table border="0" cellpadding="0" cellspacing="0" style="font-size:11px">
                        {foreach from=$changeItemList[$key] item="changeItemVal" name="changeItemLoop"}
                        <tr >
                            <td width="150">{if !$changeItemVal.item_id}余り金PT購入{else}{$changeItemVal.name|emoji}{/if}</td>
                            <td nowrap>\{$changeItemVal.price|number_format}</td>
                        </tr>
                        {/foreach}
                        <tr>
                            <td nowrap>合計</td>
                            <td nowrap>\{$changeItemTotalMoney[$key]|number_format}</td>
                        </tr>
                    </table>
                    {/if}
                </td>
            </tr>
            <tr {$val.style}>
                <td>{$orderStatus[$val.status]}</td>
                <td>{$cancelFlag[$val.is_cancel]}</td>
                <td {if $val.is_paid}style="color:red;"{/if}>{$paidFlag[$val.is_paid]}</td>
                <td colspan="2">{$val.description|nl2br}</td>
            </tr>
        {/foreach}
        </table>
        <br>
        <div style="padding-bottom: 10px;">
        件数：{$totalCount}件<br />
        {$dispFirst}～{$dispLast}件表示しています
        {if $pager}
        <ul class="pager">
            <li>{$pager.previous}</li>
            <li>{$pager.pages|@implode:"</li><li>"}</li>
            <li>{$pager.next}</li>
        </ul>
        {/if}
        </div>
    {elseif $param.search_flag}
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
<script type="text/javascript" src="./js/jquery.timepickr.min.js"></script>
<script type="text/javascript" src="./js/watermark/jquery.watermark.min.js"></script>
<script language="JavaScript">
<!--
    $(function() {ldelim}

        {* 時刻入力 *}
        $(".time").timepickr({ldelim}
            format24: "{ldelim}h:02.d{rdelim}:{ldelim}m:02.d{rdelim}:{ldelim}s:02.d{rdelim}",
            seconds: true,
            rangeMin: ["00","05","10","15","20","25","30","35","40","45","50","55","59"],
            rangeSec: ["00","15","30","45","59"],
            convention: 24,
            resetOnBlur : false
        {rdelim});

        {* カレンダー *}
        $(".datepicker").datepicker({ldelim}
            dateFormat: "yy-mm-dd"
        {rdelim});

        $("#search_button").live("click", function(){ldelim}
            $("#search_form").slideToggle("slow");
        {rdelim});

        {* テーブルストライプ *}
        $("#src_table tr:even").addClass("BgColor02");

        $("#order_date").hide();
        $("#order_time").hide();
        $("#paid_date").hide();
        $("#paid_time").hide();

        var openDateIdAry = {ldelim}
                            "input[name='specify_order_date']:checked": '#order_date'
                        {rdelim};

        var openTimeIdAry = {ldelim}
                            "input[name='specify_order_date']:checked": '#order_time'
                        {rdelim};

        // 戻ったときに日時フォームが入力されていたら表示する
        for (var key in openDateIdAry) {ldelim}
            openDateTimeInput(key, openDateIdAry[key], openTimeIdAry[key]);
        {rdelim}

        var openDateIdAry = {ldelim}
                            "input[name='specify_paid_date']:checked": '#paid_date'
                            {rdelim};

        var openTimeIdAry = {ldelim}
                            "input[name='specify_paid_date']:checked": '#paid_time'
                            {rdelim};

        // 戻ったときに日時フォームが入力されていたら表示する
        for (var key in openDateIdAry) {ldelim}
            openDateTimeInput(key, openDateIdAry[key], openTimeIdAry[key]);
        {rdelim}

        // 日付指定のとき
        $('#specify_order_date').live("click", function(env){ldelim}
            if (env.button !== 0) return;
            openDateTimeInput("input[name='specify_order_date']:checked", "#order_date", "#order_time");
        {rdelim});

        $('#specify_paid_date').live("click", function(env){ldelim}
            if (env.button !== 0) return;
            openDateTimeInput("input[name='specify_paid_date']:checked", "#paid_date", "#paid_time");
        {rdelim});

        // テキストボックス文字
        $('.from').watermark('例):10');
        $('.to').watermark('例):2');

        // 日付、時間入力フォーム表示
        function openDateTimeInput(selectId, openId, openTimeId) {ldelim}

            var id = $(openId);
            var selectId = $(selectId);
            var timeId = $(openTimeId);

            if (selectId.val() == 1) {ldelim}
                id.show("blind", "slow");
                timeId.hide("slow");
            {rdelim} else if (selectId.val() == 7) {ldelim}
                timeId.show("blind", "slow");
                id.hide("slow");
            {rdelim} else {ldelim}
                id.hide("slow");
                timeId.hide("slow");
            {rdelim}

        {rdelim}

    {rdelim});
// -->
</script>
</body>
</html>
