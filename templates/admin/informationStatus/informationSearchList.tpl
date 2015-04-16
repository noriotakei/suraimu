{include file=$admHeader}
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
<link type="text/css" href="./css/pager.css" rel="stylesheet" />
</head>
<body>

<div id="ContentsCol">
<h2 class="ContentTitle">情報一覧</h2>
<form action="./" method="POST">
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" id="src_table">
        <tr>
            <th colspan="2" style="text-align: center; font-weight: bold;">検索条件</th>
        </tr>
        <tr>
            <td>登録フォルダ</td>
            <td>{html_options name="folder_id" options=$searchFolderList selected=$param.folder_id}</td>
        </tr>
        <tr>
            <td>情報表示場所</td>
            <td>{html_options name="position_id" options=$displayPositionList selected=$param.position_id}</td>
        </tr>
        <tr>
            <td>情報ID</td>
            <td>
                <input type="text" name="search_information_id" value="{$param.search_information_id}" size="20">&nbsp;(カンマ区切りで複数可)
            </td>
        </tr>
        <tr>
            <td>情報アクセスキー</td>
            <td>
                <input type="text" name="search_information_key" value="{$param.search_information_key}" size="50">&nbsp;(カンマ区切りで複数可)
            </td>
        </tr>
        <tr>
            <td>表示状態</td>
            <td>{html_radios name="search_is_display" options=$searchIsDisplay selected=$param.search_is_display|default:0}</td>
        </tr>
        <tr>
            <td>表示日時指定</td>
            <td>
                {html_radios name="search_display_datetime_type" id="search_display_datetime_type" options=$searchDisplayDateTimeTypeAry selected=$param.search_display_datetime_type|default:0}
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
                <!--
                <div id="keyword_id" style="display:none;">
                    <input type="text" name="search_information_id" value="{$param.search_information_id}" size="15">(カンマ区切りで複数可)
                </div>
                -->
                <div id="search_condition_id" style="display:none;">
                    {html_radios name="search_conditions_display_type" options=$searchConditionDisplayType selected=$param.search_conditions_display_type|default:0 separator="&nbsp;"}<br>
                    <input type="text" name="search_conditions_id" value="{$param.search_conditions_id}" size="15">(カンマ区切りで複数可)<br>
                    {html_radios name="search_conditions_type" options=$searchConditionsTypeArray selected=$param.search_conditions_type|default:2 separator="&nbsp;"}<br>
                    <a href="{make_link action="action_user_SearchConditionList"}" target="_blank">検索条件保存リスト</a>
                </div>
                <!--
                <div id="keyword_access_key" style="display:none;">
                    <input type="text" name="search_information_key" value="{$param.search_information_key}" size="20">
                </div>
                -->
                <div id="keyword" style="display:none;">
                    <input type="text" name="search_string" value="{$param.search_string}" size="30">&nbsp;
                </div>
                <div id="keyword_html_text" style="display:none;">
                    {html_checkboxes name="search_html_text_type" options=$searchHtmlTextTypeAry selected=$param.search_html_text_type|default:$defaultHtmlTextType separator="&nbsp;"}<br>
                    <input type="text" name="search_html_text" value="{$param.search_html_text}" size="80">
                </div>
            </td>
        </tr>
        <tr>
            <td style="text-align:center;" colspan="2">
                <input type="hidden" name="sort_id" value="{$param.sort_id}" />
                <input type="hidden" name="sort_seq" value="{$param.sort_seq}">
                <input type="submit" name="action_informationStatus_InformationSearchList" value="検 索" style="width:8em;"/>
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

{if $infoStatusList}
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
            <th colspan="2" style="text-align: center; font-weight: bold;">情報データ一括操作</th>
        </tr>
        <tr>
            <td>操作内容</td>
            <td>{html_options name="update_type" options=$batchOperateInfoSelectAry selected=$param.update_type|default:0 id="update_type"}
                <div id="folder_list" style="display:none;">
                    {html_options name="chg_folder_id" options=$infoDispPositionForSelectList selected=$param.folder_id|default:1}&nbsp;に移動
                </div>
                <div id="chg_display" style="display:none;">
                    {html_options name="chg_display_id" options=$isDisplay selected=0}&nbsp;に変更
                </div>
                <div id="info_copy" style="display:none;">
                    コピー数：&nbsp;{html_options name="info_copy_number" options=$selectCopyNumber selected=$param.info_copy_number|default:0}
                </div>
            </td>
        </tr>
        <tr>
            <td style="text-align:center;" colspan="2">
                <input type="submit" name="action_informationStatus_InformationExec" value="更新" onClick="return confirm('更新しますか?')">
            </td>
        </tr>
    </table>
    <br>
    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">
        <tr bgcolor="#FF9933">
           <th rowspan="2"><a href="{make_link action="action_informationStatus_informationSearchList" getTags="sort_id="|cat:$sort.sort_id|cat:$sortParam}">ＩＤ</a></th>
           <th>管理用情報名</th>
           <th>表示開始日時</th>
           <!-- <th rowspan="2">検索条件保存ID</th> -->
           <th rowspan="2">表示設定</th>
           <th rowspan="2"><a href="{make_link action="action_informationStatus_informationSearchList" getTags="sort_seq="|cat:$sort.sort_seq|cat:$sortParam}">表示優先順位</a></th>
           <th rowspan="2">管理用コメント</th>
           <th rowspan="2">PCプレビュー</th>
           <th rowspan="2">MBプレビュー</th>
           <th style="text-align:center;" rowspan="2"><input type="checkbox" onclick="$('#list_table input:checkbox').attr('checked', this.checked);" ></th>
        </tr>
        <tr bgcolor="#FF9933">
           <th>情報表示場所フォルダ</th>
           <th>表示終了日時</th>
        </tr>
        {foreach from=$infoStatusList item="val"}
            {cycle values="#CCCCCC," assign="tr_tag"}
            {if $val.not_display_flag}
                {assign var="tr_tag" value="#FF3333"}
            {/if}
            {if $val.is_copy}
                {assign var="tr_tag" value="#FFFF99"}
            {/if}
            <tr bgcolor="{$tr_tag}">
                <td align="center" rowspan="2"><a href="{make_link action="action_informationStatus_informationData" getTags="isid="|cat:$val.id|cat:$URLparam}">{$val.id}</a></td>
                <td align="left">{$val.name}</td>
                <td align="left">{$val.display_start_datetime}</td>
                <!-- <td align="center" rowspan="2">{$val.user_search_conditions_id}</td> -->
                <td align="center" rowspan="2">{$isDisplay[$val.is_display]}</td>
                <td align="center" rowspan="2">{$val.sort_seq}</td>
                <td align="center" rowspan="2">{$val.comment}</td>
                <td align="center">
                {if $val.html_text_banner_pc}
                <a href="{$config.define.SITE_URL}?action_informationPreview=1&banner_pc=1&isid={$val.id}" target="_blank">PCバナープレビュー</a>
                {else}
                設定なし
                {/if}
                </td>
                <td align="center">
                {if $val.html_text_banner_mb}
                <a href="{$config.define.SITE_URL_MOBILE}?action_informationPreview=1&banner_mb=1&isid={$val.id}" target="_blank">MBバナープレビュー</a>
                {else}
                設定なし
                {/if}
                </td>
                <td style="text-align:center;" rowspan="2">
                    <input type="checkbox" name="check_isid[]" value="{$val.id}">
                </td>
            </tr>
            <tr bgcolor="{$tr_tag}">
                <td align="center">{$infoDispPositionForSelectList[$val.information_category_id]}</td>
                <td align="left">{$val.display_end_datetime}</td>
                <td align="center">
                {if $val.html_text_pc}
                <a href="{$config.define.SITE_URL}?action_informationPreview=1&text_pc=1&isid={$val.id}" target="_blank">PC本文プレビュー</a>
                {else}
                設定なし
                {/if}
                </td>
                <td align="center">
                {if $val.html_text_mb}
                <a href="{$config.define.SITE_URL_MOBILE}?action_informationPreview=1&text_mb=1&isid={$val.id}" target="_blank">MB本文プレビュー</a>
                {else}
                設定なし
                {/if}
                </td>
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
        //$("#keyword_id").hide();
        $("#search_condition_id").hide();
        $("#keyword").hide();
        $("#search_datetime").hide();
        $("#keyword_html_text").hide();
        //$("#keyword_access_key").hide();

        var openIdAry = {ldelim}
            //"input[name='search_type']:checked": '#keyword_id'
            "input[name='search_type']:checked": '#search_condition_id'
            ,"input[name='search_type']:checked": '#keyword'
            ,"input[name='search_type']:checked": '#keyword_html_text'
            //,"input[name='search_type']:checked": '#keyword_access_key'
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
            "input[name='search_display_datetime_type']:checked": '#search_datetime'
        {rdelim};

        // 表示日時指定、戻ったときに入力されていたら表示する
        for (var key in displayDatetimeIdAry) {ldelim}
            openDisplayDatetimeSelect(key, displayDatetimeIdAry[key]);
        {rdelim}

        // 表示日時指定を変えたとき
        $('#search_display_datetime_type').live("click", function(env){ldelim}
            if (env.button !== 0) return;
            openDisplayDatetimeSelect("input[name='search_display_datetime_type']:checked");
        {rdelim});

        {* テーブルストライプ *}
        $("#src_table tr:even").addClass("BgColor02");

        {* フォルダ移動 フォルダ一覧を隠す *}
        $("#folder_list").hide();
        $("#chg_display").hide();
        $("#info_copy").hide();

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

        if (selectId.val() == 1) {ldelim}
            //$('#keyword_id').show("blind", "slow");
            //$('#keyword_access_key').hide();
            $("#search_condition_id").hide();
            $('#keyword').hide();
            $('#keyword_html_text').hide();
        {rdelim} else if (selectId.val() == 2) {ldelim}
            //$('#keyword_access_key').show("blind", "slow");
            //$('#keyword_id').hide();
            $("#search_condition_id").hide();
            $('#keyword').hide();
            $('#keyword_html_text').hide();
        {rdelim} else if (selectId.val() == 3) {ldelim}
            $('#keyword').show("blind", "slow");
            //$('#keyword_access_key').hide();
            //$('#keyword_id').hide();
            $("#search_condition_id").hide();
            $('#keyword_html_text').hide();
        {rdelim} else if (selectId.val() == 5) {ldelim}
            $('#search_condition_id').show("blind", "slow");
            //$('#keyword_access_key').hide();
            $('#keyword').hide();
            //$('#keyword_id').hide();
            $('#keyword_html_text').hide();
        {rdelim} else if (selectId.val() == 6) {ldelim}
            $('#keyword_html_text').show("blind", "slow");
            $('#search_condition_id').hide();
            //$('#keyword_access_key').hide();
            $('#keyword').hide();
            //$('#keyword_id').hide();
        {rdelim} else {ldelim}
            //$('#keyword_access_key').hide();
            $('#keyword').hide("slow");
            //$('#keyword_id').hide("slow");
            $("#search_condition_id").hide();
            $('#keyword_html_text').hide();
        {rdelim}
    {rdelim}

    function openFolderSelect(selectId) {ldelim}

        var selectId = $(selectId);

        if (selectId.val() == 1) {ldelim}
            $('#folder_list').hide();
            $('#chg_display').show("blind", "slow");
            $('#info_copy').hide();
        {rdelim} else if (selectId.val() == 2) {ldelim}
            $('#folder_list').show("blind", "slow");
            $('#chg_display').hide();
            $('#info_copy').hide();
        {rdelim} else if (selectId.val() == 3) {ldelim}
            $('#folder_list').hide();
            $('#chg_display').hide();
            $('#info_copy').show("blind", "slow");
        {rdelim} else {ldelim}
            $('#folder_list').hide();
            $('#chg_display').hide();
            $('#info_copy').hide();
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