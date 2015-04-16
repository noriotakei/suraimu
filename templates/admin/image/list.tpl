{include file=$admHeader}
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
<script type="text/javascript" src="./js/jquery.timepickr.min.js"></script>
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script type="text/javascript" src="./js/topUp/javascripts/top_up-min.js"></script>
<link type="text/css" href="./css/pager.css" rel="stylesheet" />
<script type="text/javascript">
<!--
    {* lightbox的なもの *}
    TopUp.images_path = "js/topUp/images/top_up/";
    TopUp.players_path = "js/topUp/assets/players/";
    TopUp.addPresets({ldelim}
            ".images a": {ldelim}
              fixed: 0,
              effect: "appear",
              layout: "quicklook"
            {rdelim}
    {rdelim});

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

        {* テーブルマウスオーバーカラー *}
        $('#list_table').colorize({ldelim}
            altColor :'#CCCCCC',
            hiliteColor :'none'
        {rdelim});

        {* キーワード、日時フォームを隠す *}
        $("#keyword").hide();
        $("#search_datetime").hide();

        var openIdAry = Array('#search_type option:selected');
        for (var val in openIdAry) {ldelim}
            openSearchInput(openIdAry[val]);
        {rdelim}

        {* 検索条件を変えたとき *}
        $('#search_type').change(function(){ldelim}
            openSearchInput('#search_type option:selected');
        {rdelim});

        {* 追加フォーム *}
        if (!{$registParam.return_flag}) {ldelim}
            $("#add_form").hide();
        {rdelim} else {ldelim}
            $("#add_form").show();
        {rdelim}
        $('#add_button').live("click", function(env){ldelim}
            if (env.button !== 0) return;
            $("#add_form").toggle("blind", null, "slow");
        {rdelim});

        {* テーブルストライプ *}
        $("#src_table tr:even").addClass("BgColor02");
{*
        $('.selectText').click(function(){ldelim}
            $(this).select();
        {rdelim});
*}
    {rdelim});

    function openSearchInput(selectId) {ldelim}

        var selectId = $(selectId);

        if (selectId.val() == 1 || selectId.val() == 2) {ldelim}
            $('#keyword').show("blind", "slow");
            $('#search_datetime').hide();
        {rdelim} else if (selectId.val() == 3 || selectId.val() == 4) {ldelim}
            $('#search_datetime').show("blind", "slow");
            $('#keyword').hide();
        {rdelim} else {ldelim}
            $('#search_datetime').hide("slow");
            $('#keyword').hide("slow");
        {rdelim}
    {rdelim}

//-->
</script>
</head>
<body>

<div id="ContentsCol">

<h2 class="ContentTitle">画像一覧</h2>
<form action="./" method="POST">
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" id="src_table">
        <tr>
            <th colspan="2" style="text-align: center; font-weight: bold;">検索条件</th>
        </tr>
        <tr>
            <td>カテゴリー</td>
            <td>{html_options name="category_id" options=$searchCategoryList selected=$param.category_id}</td>
        </tr>
        <tr>
            <td>デザイン種類</td>
            <td>{html_options name="extension_type" options=$searchExtensionTypeArray selected=$param.extension_type}</td>
        </tr>
        <tr>
            <td>検索対象</td>
            <td>{html_options name="search_type" options=$searchTypeAry selected=$param.search_type id="search_type"}
                <div id="keyword" style="display:none;">
                    {html_radios name="specify_keyword" options=$specifyKeywordAry selected=$param.specify_keyword|default:0 separator="&nbsp;"}
                    <input type="text" name="search_string" value="{$param.search_string}" size="30">
                </div>

                <div id="search_datetime">
                    <input size="15" class="datepicker" type="text" value="{$param.searchDatetimeFrom|zend_date_format:'yyyy-MM-dd'}" name="search_datetime_from_Date" maxlength="10">
                    <input name="search_datetime_from_Time" class="time" type="text" value="{$param.searchDatetimeFrom|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
                    ～&nbsp;<input size="15" class="datepicker" type="text" value="{$param.searchDatetimeTo|zend_date_format:'yyyy-MM-dd'}" name="search_datetime_to_Date" maxlength="10">
                    <input name="search_datetime_to_Time" class="time" type="text" value="{$param.searchDatetimeTo|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
                </div>
            </td>
        </tr>
        <tr>
            <td style="text-align:center;" colspan="2">
                <input type="submit" name="action_image_List" value="検 索" style="width:8em;"/>
            </td>
        </tr>
    </table>
</form>
<hr>
{* 更新時エラーコメント *}
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
{/if}
<div class="SubMenu">
    <input type="button" id="add_button" value="追　加" />
</div>
<div id="add_form" style="display:none">
<form action="./" method="post" enctype="multipart/form-data">
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
        <tr>
            <th>カテゴリー</th>
            <td style="text-align: left;">{html_options name="image_category_id" options=$categoryList selected=$registParam.image_category_id}</td>
        </tr>
        <tr>
            <th>名前</th>
            <td style="text-align: left;">
                <input type="text" name="name" value="{$registParam.name}" size="20">
            </td>
        </tr>
        <tr>
            <th>コメント</th>
            <td style="text-align: left;">
                <input type="text" name="comment" value="{$registParam.comment}" size="50">
            </td>
        </tr>
        <tr>
            <th>FILE</th>
            <td style="text-align: left;">
                <input type="file" name="design_file">
            </td>
        </tr>
        <tr>
        <td colspan="2" style="text-align: center">
            <input type="submit" name="action_image_ImageAddExec" value="登　録" onClick="return confirm('登録しますか？')" />
        </td>
        </tr>
    </table>
</form>
</div>
<br>
{if $imageList}
    <div style="padding-bottom: 10px;">
    登録済み画像：{$totalCount}件<br />
    {$dispFirst}～{$dispLast}件表示しています
    {if $pager}
    <ul class="pager">
        <li>{$pager.previous}</li>
        <li>{$pager.pages|@implode:"</li><li>"}</li>
        <li>{$pager.next}</li>
    </ul>
    {/if}
    </div>

    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">

    <tr>
    <th nowrap="nowrap">ID</th>
    <th nowrap="nowrap">画像</th>
    <th>名前</th>
    <th>カテゴリー</th>
    <th>PATH</th>
    <th>コメント</th>
    <th>登録時間</th>
    <th>更新時間</th>
    </tr>
    {foreach from=$imageList item="val"}
        <tr>
        <td><a href="{make_link action="action_image_ImageUpd" getTags="image_id="|cat:$val.id}">{$val.id}</a></td>
        <td>
        <div class="images">
            {if $val.extension_type == IMAGETYPE_SWF || $val.extension_type == IMAGETYPE_SWC}
                <a href="./{$imagePath}{$val.file_name}.{$extensionTypeArray[$val.extension_type]}" toptions="type = flash, group = 'images', width = 550, height = 400, parameters = '{$smarty.now} =1', title={$val.name}">
                {html_image file="./img/thumbnails/swf.jpg" width="80" height="60" alt=$val.name}</a>
            {else}
                <a href="./{$imagePath}{$val.file_name}.{$extensionTypeArray[$val.extension_type]}" toptions="type = image, group = 'images', parameters = '{$smarty.now} =1', title={$val.name}">
                {html_image file="./"|cat:$imagePath|cat:$val.file_name|cat:"."|cat:$extensionTypeArray[$val.extension_type]|cat:"?"|cat:$smarty.now width="100" height="70" alt=$val.name}</a>
            {/if}
        </div>
        </td>
        <td>{$val.name}</td>
        <td>{$categoryList[$val.image_category_id]}</td>
        <td>
            {if $val.extension_type == IMAGETYPE_SWF || $val.extension_type == IMAGETYPE_SWC}
                <textarea class="selectText" readonly cols="50">{$imagePath}{$val.file_name}.{$extensionTypeArray[$val.extension_type]}</textarea>
            {else}
                <textarea class="selectText" readonly cols="50"><img src="{$imagePath}{$val.file_name}.{$extensionTypeArray[$val.extension_type]}"></textarea>
            {/if}
        </td>
        <td>{$val.comment}</td>
        <td>{$val.create_datetime}</td>
        <td>{$val.update_datetime}</td>
        </tr>
    {/foreach}
    </table>
{else}
    <div class="warning ui-widget">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    <p>
    <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    該当画像はありません
    </p>
    </div>
{/if}
{include file=$admFooter}
</div>
</body>
</html>