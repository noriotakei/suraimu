{include file=$admHeader}
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
<script type="text/javascript" src="./js/jquery.timepickr.min.js"></script>
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<link type="text/css" href="./css/pager.css" rel="stylesheet" />

<script type="text/javascript">
<!--

    $(function() {ldelim}
        $('.selectText').click(function(){ldelim}
        $(this).select();
        {rdelim});

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

        {* 月額データ入力フォームを隠す *}
        $("#monthly_course_plus_limit_date").hide();
        $("#monthly_update_item_id").hide();

        var openIdAry = Array('#monthly_course_id option:selected');
        for (var val in openIdAry) {ldelim}
            openSearchInput(openIdAry[val]);
        {rdelim}

        {* 検索条件を変えたとき *}
        $('#monthly_course_id').change(function(){ldelim}
            openSearchInput('#monthly_course_id option:selected');
        {rdelim});

    {rdelim});

    function openSearchInput(selectId) {ldelim}

        var selectId = $(selectId);

        if (selectId.val() == 0) {ldelim}
            $('#monthly_course_plus_limit_date').hide();
            $('#monthly_update_item_id').hide();
        {rdelim} else {ldelim}
            $('#monthly_course_plus_limit_date').show("blind", "slow");
            $('#monthly_update_item_id').show("blind", "slow");
        {rdelim}
    {rdelim}

//-->
</script>
</head>
<body>

<div id="ContentsCol">
    <h2 class="ContentTitle">月額更新用商品更新画面</h2>
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
    <form action="./" method="post">
    {$POSTparam}
        <div class="SubMenu">
            <input type="submit" name="action_itemManagement_ItemList" value="一覧に戻る" />
        </div>
    </form>
    <form action="./" method="post" enctype="multipart/form-data">
    {$POSTparam}
        <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
            <tr>
                <th>商品ID</th>
                <td style="text-align:left;font-size:large;">
                    <b>{$param.iid|default:$itemData.id}</b>
                </td>
                <td style="text-align: center;">--</td>
            </tr>
            <tr>
                <th>商品アクセスキー</th>
                <td style="text-align:left;font-size:large;">
                    <b>{$param.access_key|default:$itemData.access_key}</b>
                </td>
                <td style="text-align: center;">--</td>
            </tr>
            <tr>
                <th>管理側表示用商品名</th>
                <td style="text-align:left;">
                    <input type="text" name="name" value="{$param.name}" size="100">
                </td>
                <td style="text-align:center;color:#ff0000;">必須</td>
            </tr>
            <tr>
                <th>注文完了リメール表示用商品名</th>
                <td style="text-align:left;">
                    <input type="text" name="remail_name" value="{$param.remail_name}" size="100">
                </td>
                <td style="text-align:center;color:#ff0000;">必須</td>
            </tr>
            <tr>
                <th>カテゴリー</th>
                    <td style="text-align:left;">{html_options name="item_category_id" options=$itemCategoryListForSelect selected=$param.item_category_id}</td>
                    <td style="text-align:center;">--</td>
            </tr>
            <tr>
                <th>検索条件保存ID<br>(カンマ区切りで複数可)<br><a href="{make_link action="action_user_SearchConditionList"}" target="_blank">検索条件保存リスト</a></th>
                <td style="text-align: left;">
                    {$searchSaveComment|default:"設定なし"}<br>
                    <input type="text" name="user_search_conditions_id" value="{$param.user_search_conditions_id}" size="80" style="ime-mode:disabled">
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>販売価格</th>
                <td style="text-align:left;">
                    <input type="text" name="price" value="{$param.price}" size="10">&nbsp;円
                </td>
                <td style="text-align:center;color:#ff0000;">必須</td>
            </tr>
            <tr>
                <th>付与ポイント</th>
                <td style="text-align:left;">
                    <input type="text" name="point" value="{$param.point}" size="10">&nbsp;Pt
                </td>
                <td style="text-align:center;">任意</td>
            </tr>
            <tr>
                <th>付与月額コース</th>
                <td style="text-align: left;">
                    {html_options name="monthly_course_id" options=$monthlyCourseList selected=$param.monthly_course_id|default:0 id="monthly_course_id}
                    <div id="monthly_course_plus_limit_date" style="display:none;">
                        付与月額コース日数:<input type="text" name="monthly_course_plus_limit_date" value="{$param.monthly_course_plus_limit_date}" size="10">日
                    </div>
                    <div id="monthly_update_item_id" style="display:none;">
                        月額更新用商品ID:<input type="text" name="monthly_update_item_id" value="{$param.monthly_update_item_id}" size="10" readonly>
                        &nbsp;<font color="blue">※この商品IDが月額更新で自動決済されます。</font>
                    </div>
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>管理用コメント</th>
                <td style="text-align:left;">
                    <textarea name="comment" cols="80" rows="2" id="comment">{$param.comment}</textarea>
                </td>
                <td style="text-align:center;">任意</td>
            </tr>
            {* 現在は使用してないのでコメント(いつか使うかも)
            <tr>
                <th>強制注文フラグ</th>
                <td style="text-align:left;">
                    {html_options name="is_self_order" options=$isSelfOrder selected=$param.is_self_order|default:0}
                    &nbsp;<font color="blue">※「ON」の場合、ポイント不足による情報閲覧時にこの商品を強制的にカートに入れます。</font>
                    </td>
                <td style="text-align:center;">--</td>
            </tr>
            *}
            <tr>
                <th>表示優先度</th>
                <td style="text-align:left;">
                    <input type="text" name="sort_seq" value="{$param.sort_seq|default:0}" size="10">
                </td>
                <td style="text-align:center;">任意</td>
            </tr>
            <tr>
                <td colspan="3"  style="text-align:center;">
                    <div class="SubMenu">
                        <input type="submit" name="action_itemManagement_itemMonthlyExec" value="更新する" onClick="return confirm('更新しますか？')"/>&nbsp;&nbsp;
                        <input type="submit" name="action_itemManagement_itemMonthlyCopyExec" value="変更内容で新規作成" onClick="return confirm('変更内容で新規作成しますか？')"/>
                    </div>
                </td>
            </tr>
        </table>
    </form>
{include file=$admFooter}
</div>
</body>
</html>