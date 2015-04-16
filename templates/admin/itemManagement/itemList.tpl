{include file=$admHeader}
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
<link type="text/css" href="./css/pager.css" rel="stylesheet" />
</head>
<body>

<div id="ContentsCol">
<h2 class="ContentTitle">商品一覧</h2>
<form action="./" method="POST">
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" id="src_table">
        <tr>
            <th colspan="2" style="text-align: center; font-weight: bold;">検索条件</th>
        </tr>
        <tr>
            <td>商品ID</td>
            <td>
                <input type="text" name="search_item_id" value="{$param.search_item_id}" size="20">&nbsp;(カンマ区切りで複数可)
            </td>
        </tr>
        <tr>
            <td>商品アクセスキー</td>
            <td>
                <input type="text" name="search_item_key" value="{$param.search_item_key}" size="50">&nbsp;(カンマ区切りで複数可)
            </td>
        </tr>
        <tr>
            <td>カテゴリー</td>
            <td>{html_options name="search_category_id" options=$searchItemCategoryList selected=$param.search_category_id}</td>
        </tr>
        <tr>
            <td>表示状態</td>
            <td>{html_radios name="search_is_display" options=$searchIsDisplay selected=$param.search_is_display|default:0}</td>
        </tr>
        <tr>
            <td>表示日時指定</td>
            <td>
                {html_radios name="search_sales_datetime_type" id="search_sales_datetime_type" options=$searchDisplayDateTimeTypeAry selected=$param.search_sales_datetime_type|default:0}
                <div id="search_datetime">
                    開始：<input name="search_datetime_from_date" size="15" class="datepicker" type="text" value="{$param.searchDatetimeFrom|zend_date_format:'yyyy-MM-dd'}" maxlength="10">
                    <input name="search_datetime_from_time" class="time" type="text" value="{$param.searchDatetimeFrom|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
                    ～&nbsp;終了：<input name="search_datetime_to_date" size="15" class="datepicker" type="text" value="{$param.searchDatetimeTo|zend_date_format:'yyyy-MM-dd'}" maxlength="10">
                    <input name="search_datetime_to_time" class="time" type="text" value="{$param.searchDatetimeTo|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
                </div>
            </td>
        </tr>
        <tr>
            <td>その他キーワード検索</td>
            <td>{html_radios name="search_type" options=$searchTypeAry selected=$param.search_type|default:0 id="search_type" separator=&nbsp;}
                <div id="search_condition_id" style="display:none;">
                    {html_radios name="search_conditions_display_type" options=$searchConditionDisplayType selected=$param.search_conditions_display_type|default:0 separator="&nbsp;"}<br>
                    <input type="text" name="search_conditions_id" value="{$param.search_conditions_id}" size="15">(カンマ区切りで複数可)<br>
                    {html_radios name="search_conditions_type" options=$searchConditionsTypeArray selected=$param.search_conditions_type|default:2 separator="&nbsp;"}<br>
                    <a href="{make_link action="action_user_SearchConditionList"}" target="_blank">検索条件保存リスト</a>
                </div>
                <div id="keyword" style="display:none;">
                    {html_checkboxes name="search_item_name_type" options=$searchItemNameAry selected=$param.search_item_name_type|default:$defaultItemNameType separator="&nbsp;"}<br>
                    <input type="text" name="search_string" value="{$param.search_string}" size="30">&nbsp;
                </div>
            </td>
        </tr>
        {* 現在は使用してないのでコメント(いつか使うかも)
        <tr>
            <td>強制注文フラグ</td>
            <td>{html_options name="search_is_self_order" options=$searchIsSelfOrder selected=$param.search_is_self_order}</td>
        </tr>
        *}
        <tr>
            <td style="text-align:center;" colspan="2">
                <input type="hidden" name="sort_id" value="{$param.sort_id}" />
                <input type="hidden" name="sort_seq" value="{$param.sort_seq}">
                <input type="submit" name="action_itemManagement_ItemList" value="検 索" style="width:8em;"/>
            </td>
        </tr>
    </table>
</form>

{* 更新時エラーコメント *}
{if $msg|@count}
    <br>
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
{/if}
<br>

{if $itemList}
    <div style="padding-bottom: 10px;">
    登録済み：{$totalCount}件<br />
    {$dispFirst}～{$dispLast}件表示しています
    {if $pager}
    <ul class="pager">
        <li>{$pager.previous}</li>
        <li>{$pager.pages|@implode:"</li><li>"}</li>
        <li>{$pager.next}</li>
    </ul>
    {/if}
    </div>
    <form action="./" method="post" style="margin:2px 0px;">
    {$searchParam}
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" >
        <tr>
            <th colspan="2" style="text-align: center; font-weight: bold;">商品データ一括操作</th>
            <th colspan="2" style="text-align: center; font-weight: bold;">ダイレクト決済画面飛び先</th>
        </tr>
        <tr>
            <td>操作内容</td>
            <td>{html_options name="update_type" options=$batchOperateItemSelectAry selected=$param.updateSelect|default:0 id="update_type"}
                <div id="category_list" style="display:none;">
                    {html_options name="chg_category_id" options=$categoryList selected=$param.chg_category_id|default:1}&nbsp;に変更
                </div>
                <div id="chg_display" style="display:none;">
                    {html_options name="chg_display_id" options=$isDisplay selected=0}&nbsp;に変更
                </div>
                <div id="item_copy" style="display:none;">
                    コピー数：&nbsp;{html_options name="item_copy_number" options=$selectCopyNumber selected=$param.item_copy_number|default:0}
                </div>
            </td>
            <td>飛び先選択</td>
            <td>{html_options name="settle_select" options=$settleSelectAry selected=$settleControlData.direct_settle_name|default:0}
            </td>
        </tr>
        <tr>
            <td style="text-align:center;" colspan="2">
                <input type="submit" name="action_itemManagement_ItemExec" value="更新" onClick="return confirm('更新しますか?')">
            </td>
            <td style="text-align:center;" colspan="2">
                <input type="submit" name="action_itemManagement_settleSelectExec" value="更新" onClick="return confirm('更新しますか?')">
            </td>
        </tr>
    </table>
    <br>
    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">
        <tr bgcolor="#FF9933">
           <th rowspan="2"><a href="{make_link action="action_itemManagement_ItemList" getTags="sort_id="|cat:$sort.sort_id|cat:$sortParam}">ＩＤ</a></th>
           <th>管理用商品名</th>
           <th rowspan="2">販売金額</th>
           <th>販売開始日時</th>
           <!-- <th rowspan="2">検索条件保存ID</th> -->
           <th rowspan="2">表示設定</th>
           <th rowspan="2">月額コース</th>
           <th rowspan="2"><a href="{make_link action="action_itemManagement_ItemList" getTags="sort_seq="|cat:$sort.sort_seq|cat:$sortParam}">表示優先順位</a></th>
           {* 現在は使用してないのでコメント(いつか使うかも)
           <th rowspan="2">強制注文フラグ</th>
           *}
           <th rowspan="2">管理用コメント</th>
           <th style="text-align:center;" rowspan="2"><input type="checkbox" onclick="$('#list_table input:checkbox').attr('checked', this.checked);" ></th>
        </tr>
        <tr bgcolor="#FF9933">
           <th>カテゴリー</th>
           <th>販売終了日時</th>
        </tr>
        {foreach from=$itemList item="val"}
            {cycle values="#CCCCCC," assign="tr_tag"}
            {if $val.not_display_flag}
                {assign var="tr_tag" value="#FF3333"}
            {/if}
            {if $val.is_copy}
                {assign var="tr_tag" value="#FFFF99"}
            {/if}
            <tr bgcolor="{$tr_tag}">
                <td align="center" rowspan="2">
                {if $val.is_monthly_item}
                    <a href="{make_link action="action_itemManagement_itemMonthlyData" getTags="iid="|cat:$val.id|cat:$URLparam}">{$val.id}</a>
                {else}
                    <a href="{make_link action="action_itemManagement_itemData" getTags="iid="|cat:$val.id|cat:$URLparam}">{$val.id}</a>
                {/if}
                </td>
                <td align="left">{$val.name}</td>
                <td align="center" rowspan="2">{$val.price|number_format}円</td>
                <td align="left">{$val.sales_start_datetime}</td>
                <!-- <td align="center" rowspan="2">{$val.user_search_conditions_id}</td> -->
                <td align="center" rowspan="2">
                {if $val.is_monthly_item}
                    --
                {else}
                    {$isDisplay[$val.is_display]}
                {/if}
                </td>
                <td align="center" rowspan="2">{$monthlyCourseList[$val.monthly_course_id]}</td>
                <td align="center" rowspan="2">{$val.sort_seq}</td>
                {* 現在は使用してないのでコメント(いつか使うかも)
                <td align="center" rowspan="2">{$isSelfOrder[$val.is_self_order]}</td>
                *}
                <td align="center" rowspan="2">{$val.comment}</td>
                <td  style="text-align:center;" rowspan="2">
                    <input type="checkbox" name="check_iid[]" value="{$val.id}">
                </td>
            </tr>
            <tr bgcolor="{$tr_tag}">
                <td align="center">{$val.category_name}</td>
                <td align="left">{$val.sales_end_datetime}</td>
            </tr>
        {/foreach}
    </table>
    </form>
    {if $pager}
    <ul class="pager">
        <li>{$pager.previous}</li>
        <li>{$pager.pages|@implode:"</li><li>"}</li>
        <li>{$pager.next}</li>
    </ul>
    {/if}
{else}
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
            dateFormat: "yy-mm-dd"
        {rdelim});

        {* キーワード、日時フォームを隠す *}
        $("#search_condition_id").hide();
        $("#keyword").hide();
        $("#search_datetime").hide();

        var openIdAry = {ldelim}
            "input[name='search_type']:checked": '#search_condition_id'
            ,"input[name='search_type']:checked": '#keyword'
        {rdelim};

        // 戻ったときに入力されていたら表示する
        for (var key in openIdAry) {ldelim}
            openSearchInput(key, openIdAry[key]);
        {rdelim}

        // キーワード検索指定のとき
        $('#search_type').live("click", function(env){ldelim}
            if (env.button !== 0) return;
            openSearchInput("input[name='search_type']:checked");
        {rdelim});

        // 表示日時指定
        var displayDatetimeIdAry = {ldelim}
            "input[name='search_sales_datetime_type']:checked": '#search_datetime'
        {rdelim};

        // 表示日時指定、戻ったときに入力されていたら表示する
        for (var key in displayDatetimeIdAry) {ldelim}
            openDisplayDatetimeSelect(key, displayDatetimeIdAry[key]);
        {rdelim}

        // 表示日時指定を変えたとき
        $('#search_sales_datetime_type').live("click", function(env){ldelim}
            if (env.button !== 0) return;
            openDisplayDatetimeSelect("input[name='search_sales_datetime_type']:checked");
        {rdelim});

        {* テーブルストライプ *}
        $("#src_table tr:even").addClass("BgColor02");

        {* フォルダ移動 フォルダ一覧を隠す *}
        $("#folder_list").hide();
        $("#display_chg").hide();
        $("#item_copy").hide();

        var updateIdAry = Array('#update_type option:selected');
        for (var val in updateIdAry) {ldelim}
            openFolderSelect(updateIdAry[val]);
        {rdelim}

        {* 更新条件を変えたとき *}
        $('#update_type').change(function(){ldelim}
            openFolderSelect('#update_type option:selected');
        {rdelim});
    {rdelim});

    function openSearchInput(selectId) {ldelim}

        var selectId = $(selectId);

        if (selectId.val() == 3) {ldelim}
            $('#keyword').show("blind", "slow");
            $("#search_condition_id").hide();
        {rdelim} else if (selectId.val() == 5) {ldelim}
            $('#search_condition_id').show("blind", "slow");
            $('#keyword').hide();
        {rdelim} else {ldelim}
            $('#keyword').hide("slow");
            $("#search_condition_id").hide();
        {rdelim}
    {rdelim}

    function openFolderSelect(selectId) {ldelim}

        var selectId = $(selectId);

        if (selectId.val() == 1) {ldelim}
            $('#category_list').hide();
            $('#chg_display').show("blind", "slow");
            $('#item_copy').hide();
        {rdelim} else if (selectId.val() == 2) {ldelim}
            $('#category_list').show("blind", "slow");
            $('#chg_display').hide();
            $('#item_copy').hide();
        {rdelim} else if (selectId.val() == 3) {ldelim}
            $('#category_list').hide();
            $('#chg_display').hide();
            $('#item_copy').show("blind", "slow");
        {rdelim} else {ldelim}
            $('#category_list').hide();
            $('#chg_display').hide();
            $('#item_copy').hide();
        {rdelim}
    {rdelim}

    function openDisplayDatetimeSelect(selectId) {ldelim}

        var selectId = $(selectId);

        if (selectId.val() == 3) {ldelim}
            $('#search_datetime').show("blind", "slow");
        {rdelim} else {ldelim}
            $('#search_datetime').hide();
        {rdelim}
    {rdelim}

//-->
</script>
</body>
</html>