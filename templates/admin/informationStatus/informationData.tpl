{include file=$admHeader}
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
<script type="text/javascript" src="./js/jquery.timepickr.min.js"></script>
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script type="text/javascript" src="./js/watermark/jquery.watermark.min.js"></script>
<link type="text/css" href="./css/pager.css" rel="stylesheet" />

<script type="text/javascript">
<!--

    $(function() {ldelim}
        $('.selectText').click(function(){ldelim}
        $(this).select();
        {rdelim});

        {* テーブルマウスオーバーカラー *}
        $('#list_table').colorize({ldelim}
            altColor :'#CCCCCC',
            hiliteColor :'none'
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

        // テキストエリア文字
        $('.inputBody').watermark('入力時は<body ～>タグを入力してください。※</body>は不要');

        {* キーワード、全画面表示のタグフォームを隠す *}
        $("#set_tag").hide();

        var openIdAry = Array('#all_disp_type option:selected');
        for (var val in openIdAry) {ldelim}
            openSearchInput(openIdAry[val]);
        {rdelim}

        {* 検索条件を変えたとき *}
        $('#all_disp_type').change(function(){ldelim}
            openSearchInput('#all_disp_type option:selected');
        {rdelim});

    {rdelim});

    function openSearchInput(selectId) {ldelim}

        var selectId = $(selectId);

        if (selectId.val() == 1) {ldelim}
            $('#set_tag').show("blind", "slow");
        {rdelim} else {ldelim}
            $('#set_tag').hide("slow");
        {rdelim}
    {rdelim}


//-->
</script>
<style type="text/css">
    .watermark {ldelim}
       color: #999;
    {rdelim}
</style>
</head>
<body>

<div id="ContentsCol">
    <h2 class="ContentTitle">情報更新画面</h2>
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
            <input type="submit" name="action_informationStatus_informationSearchList" value="一覧に戻る" />
        </div>
    </form>
    <br>
    <div>
        <a href="{make_link action="action_keyConvert_DispKeyConvertList" getTags=$getTag}" target="_blank">システム変換管理</a>
    </div>
    <br>
    {if $infoTemplateList}
    <div>
        <a href="{make_link action="action_informationTemplate_DispInformationTemplateList" getTags=$getTag}" target="_blank">情報HTML定型文一覧</a>
    </div>
    {/if}
    <br>
    <form action="./" method="post" enctype="multipart/form-data">
    {$POSTparam}
        <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
            <tr>
                <th>情報ID</th>
                <td style="text-align:left;font-size:large;">
                    <b>{$param.isid|default:$infoStatusData.id}</b>
                </td>
                <td style="text-align:center;">--</td>
            </tr>
            <tr>
                <th>情報アクセスキー</th>
                <td style="text-align:left;font-size:large;">
                    <b>{$param.access_key|default:$infoStatusData.access_key}</b>
                </td>
                <td style="text-align:center;">--</td>
            </tr>
            <tr>
                <th>情報表示場所フォルダ</th>
                <td style="text-align: left;">{html_options name="information_category_id" options=$dispPositionForSelect selected=$param.information_category_id}</td>
                <td style="text-align: center;">--</td>
            </tr>
            <tr>
                <th>管理用情報名</th>
                <td style="text-align: left;">
                    <input type="text" name="name" value="{$param.name}" size="50">
                </td>
                <td style="text-align:center;color:#ff0000;">必須</td>
            </tr>
            <tr>
                <th>消費ポイント</th>
                <td style="text-align: left;">
                    <input type="text" name="point" value="{$param.point}" size="10">&nbsp;Pt
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>付与ポイント</th>
                <td style="text-align: left;">
                    <input type="text" name="bonus_point" value="{$param.bonus_point}" size="10">&nbsp;Pt
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>付与ポイント無制限</th>
                <td style="text-align: left;">{html_options name="bonus_point_limit" options=$bonusPointLimitTypeArray selected=$param.bonus_point_limit|default:0}</td>
                <td style="text-align: center;">--</td>
            </tr>
            <tr>
                <th>表示切り替え</th>
                <td style="text-align: left;">{html_options name="is_display" options=$isDisplay selected=$param.is_display|default:0}</td>
                <td style="text-align: center;">--</td>
            </tr>
            <tr>
                <th>表示開始日時</th>
                <td style="text-align: left;">
                    <input name="display_start_date" class="datepicker" type="text" value="{$param.display_start_datetime|zend_date_format:'yyyy-MM-dd'}" size="15" maxlength="10">
                    <input name="display_start_time" class="time" type="text" value="{$param.display_start_datetime|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
                    &nbsp;<font color="blue">※日付は「0000-00-00 00:00:00」の形で入力してください。</font>
                </td>
                <td style="text-align:center;color:#ff0000;">必須</td>
            </tr>
            <tr>
                <th>表示終了日時</th>
                <td style="text-align: left;">
                    <input name="display_end_date" class="datepicker" type="text" value="{$param.display_end_datetime|zend_date_format:'yyyy-MM-dd'}" size="15" maxlength="10">
                    <input name="display_end_time" class="time" type="text" value="{$param.display_end_datetime|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
                    &nbsp;<font color="blue">※日付は「0000-00-00 00:00:00」の形で入力してください。</font>
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>曜日表示設定</th>
                <td style="text-align: left;">
                    {html_options name="is_display_week" options=$isDisplayWeek selected=$param.is_display_week|default:0}
                    {html_options name="display_week_start_num" options=$config.admin_config.week_array selected=$param.display_week_start_num|default:0}
                    <input name="display_week_start_time" class="time" type="text" value="{$param.display_week_start_time|default:'00:00:00'}" size="10" maxlength="8">から
                    {html_options name="display_week_last_num" options=$config.admin_config.week_array selected=$param.display_week_last_num|default:0}
                    <input name="display_week_last_time" class="time" type="text" value="{$param.display_week_last_time|default:'00:00:00'}" size="10" maxlength="8">まで
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>入金状態</th>
                <td style="text-align: left;">{html_options name="payment_status" options=$paymentStatus selected=$param.payment_status|default:0}</td>
                <td style="text-align: center;">--</td>
            </tr>
            <tr>
                <th>ユニットID(表示)<br>(カンマ区切りで複数可)</th>
                <td style="text-align: left;">
                    <input type="text" name="unit_id" size="80" value="{$param.unit_id}" style="ime-mode:disabled">
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>ユニットID(非表示)<br>(カンマ区切りで複数可)</th>
                <td style="text-align: left;">
                    <input type="text" name="except_unit_id" size="80" value="{$param.except_unit_id}" style="ime-mode:disabled">
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>購入商品ID（表示）<br>(カンマ区切りで複数可)</th>
                <td style="text-align: left;">
                    <input type="text" size="80" name="item_id" value="{$param.item_id}" style="ime-mode:disabled">
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>購入商品ID（非表示）<br>(カンマ区切りで複数可)</th>
                <td style="text-align: left;">
                    <input type="text" size="80" name="except_item_id" value="{$param.except_item_id}" style="ime-mode:disabled">
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>既読表示情報ID<br>(カンマ区切りで複数可)</th>
                <td style="text-align: left;">
                    <input type="text" size="80" name="redirect_information_id" value="{$param.redirect_information_id}" style="ime-mode:disabled">
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>検索条件保存ID(表示)<br>(カンマ区切りで複数可)<br><a href="{make_link action="action_user_SearchConditionList"}" target="_blank">検索条件保存リスト</a></th>
                <td style="text-align: left;">
                    {$searchSaveComment|default:"設定なし"}<br>
                    <input type="text" name="user_search_conditions_id" value="{$param.user_search_conditions_id}" size="80" style="ime-mode:disabled">
                    &nbsp;{html_radios name="user_search_conditions_type" options=$searchConditionsTypeArray selected=$param.user_search_conditions_type|default:0 separator="&nbsp;"}<br>
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>検索条件保存ID(非表示)<br>(カンマ区切りで複数可)<br><a href="{make_link action="action_user_SearchConditionList"}" target="_blank">検索条件保存リスト</a></th>
                <td style="text-align: left;">
                    {$exceptSearchSaveComment|default:"設定なし"}<br>
                    <input type="text" name="except_user_search_conditions_id" value="{$param.except_user_search_conditions_id}" size="80" style="ime-mode:disabled">
                    &nbsp;{html_radios name="except_user_search_conditions_type" options=$searchConditionsTypeArray selected=$param.except_user_search_conditions_type|default:0 separator="&nbsp;"}<br>
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>リダイレクトURL</th>
                <td style="text-align: left;">
                    <input type="text" size="80" name="redirect_url" value="{$param.redirect_url}" ><br>
                    <font color="blue">※「バナー表示内容」から他ページに飛ばしたい場合は、飛ばし先のURLを指定してください。(例)【既読】の場合→他の情報ページなど</font>
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>ﾘﾀﾞｲﾚｸﾄﾕﾆｯﾄ情報ID設定<br>(カンマ区切りで複数可)</th>
                <td style="text-align: left;">
                    ﾘﾀﾞｲﾚｸﾄ情報ID<input type="text" size="80" name="redirect_unit_information_id" value="{$param.redirect_unit_information_id}" style="ime-mode:disabled">
                    </br>
                    ﾘﾀﾞｲﾚｸﾄﾕﾆｯﾄID<input type="text" size="80" name="redirect_unit_id" value="{$param.redirect_unit_id}" style="ime-mode:disabled">
                    </br>
                    <font color="blue">※対になるよう情報ID、ﾕﾆｯﾄIDを設定して下さい。ﾘﾀﾞｲﾚｸﾄﾕﾆｯﾄ情報IDの順番とﾘﾀﾞｲﾚｸﾄﾕﾆｯﾄIDの順番を合わせる必要があります。</font>
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>ユーザー側全画面表示設定</th>
                <td style="text-align: left;">
                    {html_options name="is_all_display" options=$isAllDisplay selected=$param.is_all_display|default:0 id="all_disp_type"}
                </td>
                <td style="text-align: center;">--</td>
            </tr>
            <tr>
                <th>情報詳細アクセスURL<br>{$dispMsg}</th>
                <td style="text-align: left;">
                    <input type="text" class="selectText" size="80" name="access_url" value="{$accessUrl}" readonly><br>
                    <font color="blue">※この情報の「詳細情報」へのアクセスURL。HTML本文のリンクやボタンの飛び先に指定出来ます。※他の情報データにも使用出来ます。</font>
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>バナー表示情報(PC)<br>(bodyタグ不要)<br><br>
                    {if $param.html_text_banner_pc}
                    <a href="{$config.define.SITE_URL}?action_informationPreview=1&banner_pc=1&isid={$param.id|default:$param.isid}" target="_blank">PCバナープレビュー</a>
                    {else}
                    プレビュー設定なし
                    {/if}
                </th>
                <td style="text-align: left;">
                <textarea name="html_text_banner_pc" cols="100" rows="20" id="html_text_banner_pc" wrap="off">{$param.html_text_banner_pc}</textarea>
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>詳細情報(PC)<br><br>
                    {if $param.html_text_pc}
                    <a href="{$config.define.SITE_URL}?action_informationPreview=1&text_pc=1&isid={$param.id|default:$param.isid}" target="_blank">PC本文プレビュー</a>
                    {else}
                    プレビュー設定なし
                    {/if}
                </th>
                <td style="text-align: left;"><br>
                    <div id="set_tag" style="display:none;">
                        <b><font color="blue">bodyタグ設定(PC)</font></b><br>
                        <input type="text" class="selectText" size="150" name="html_body_pc" value="{$htmlTagPC}" readonly><br>
                        <font color="red">※全画面表示「ON」の場合、下記「表示情報(PC)」本文に「&lt;body&gt;」タグを設置して下さい。<br>※「&lt;&frasl;body&gt;」タグは不要です</font><br><br>
                    </div>
                    <textarea name="html_text_pc" class="inputBody" cols="100" rows="20" id="html_text_pc" wrap="off">{$param.html_text_pc}</textarea>
                    </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>バナー表示情報(MB)<br>(bodyタグ不要)<br><br>
                    {if $param.html_text_banner_mb}
                    <a href="{$config.define.SITE_URL_MOBILE}?action_informationPreview=1&banner_mb=1&isid={$param.id|default:$param.isid}" target="_blank">MBバナープレビュー</a>
                    {else}
                    プレビュー設定なし
                    {/if}
                </th>
                <td style="text-align: left;">
                <textarea name="html_text_banner_mb" cols="100" rows="20" id="html_text_banner_mb" wrap="off">{$param.html_text_banner_mb}</textarea>
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>詳細情報(MB)<br>(bodyタグ必須)<br><br>
                    {if $param.html_text_mb}
                    <a href="{$config.define.SITE_URL_MOBILE}?action_informationPreview=1&text_mb=1&isid={$param.id|default:$param.isid}" target="_blank">MB本文プレビュー</a>
                    {else}
                    プレビュー設定なし
                    {/if}
                </th>
                <td style="text-align: left;">
                <b><font color="blue">bodyタグ設定(MB)</font></b><br>
                <textarea  class="selectText" name="html_body_mb" cols="100" rows="4" id="html_text_banner_mb" wrap="off" readonly>{$htmlTagMB}</textarea><br>
                <font color="red">※下記「表示情報(MB)」本文に張り付けて下さい。タグ内の設定は基本設定となっています。</font><br><br>
                <textarea name="html_text_mb" class="inputBody" cols="100" rows="20" id="html_text_mb" wrap="off">{$param.html_text_mb}</textarea>
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>管理用コメント</th>
                <td style="text-align: left;">
                    <textarea name="comment" cols="80" rows="5" id="comment">{$param.comment}</textarea>
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>表示優先度</th>
                <td style="text-align: left;">
                    <input type="text" name="sort_seq" value="{$param.sort_seq|default:$maxSeq}" size="10" style="ime-mode:disabled">
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <td colspan="3"  style="text-align:center;">
                    <div class="SubMenu">
                        <input type="submit" name="action_informationStatus_InformationExec" value="更新する" onClick="return confirm('更新しますか？')"/>&nbsp;&nbsp;
                        <input type="submit" name="action_informationStatus_InformationCopyExec" value="変更内容で新規作成" onClick="return confirm('変更内容で新規作成しますか？')"/>
                    </div>
                </td>
            </tr>

        </table>
    </form>
{include file=$admFooter}
</div>
</body>
</html>