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
    <h2 class="ContentTitle">情報定型文更新画面</h2>
    <br>
    <form action="./" method="post">
    {$POSTparam}
        <div class="SubMenu">
            <input type="submit" name="action_informationTemplate_DispInformationTemplateList" value="一覧に戻る" />
        </div>
    </form>
    <br>
    <form action="./" method="post" enctype="multipart/form-data">
    {$POSTparam}
        <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
            <tr>
                <th>バナー表示情報(PC)<br><br>
                    {if $param.html_text_banner_pc}
                    <a href="{$config.define.SITE_URL}?action_informationPreview=1&banner_pc=1&itid={$param.id}" target="_blank">PCバナープレビュー</a>
                    {else}
                    プレビュー設定なし
                    {/if}
                </th>
                <td style="text-align: left;">
                <textarea name="html_text_banner_pc" cols="100" rows="20" id="html_text_banner_pc" wrap="off" readonly>{$param.html_text_banner_pc}</textarea>
                </td>
            </tr>
            <tr>
                <th>詳細情報(PC)<br><br>
                    {if $param.html_text_pc}
                    <a href="{$config.define.SITE_URL}?action_informationPreview=1&text_pc=1&itid={$param.id}" target="_blank">PC本文プレビュー</a>
                    {else}
                    プレビュー設定なし
                    {/if}
                </th>
                <td style="text-align: left;"><br>
                    <b><font color="blue">ユーザー側全画面表示状態(PCのみ)：</font></b>&nbsp;<b>{$isAllDisplay}<b><br><br>
                    <textarea name="html_text_pc" cols="100" rows="20" id="html_text_pc" wrap="off" readonly>{$param.html_text_pc}</textarea>
                    </td>
            </tr>
            <tr>
                <th>バナー表示情報(MB)<br><br>
                    {if $param.html_text_banner_mb}
                    <a href="{$config.define.SITE_URL_MOBILE}?action_informationPreview=1&banner_mb=1&itid={$param.id}" target="_blank">MBバナープレビュー</a>
                    {else}
                    プレビュー設定なし
                    {/if}
                </th>
                <td style="text-align: left;">
                <textarea name="html_text_banner_mb" cols="100" rows="20" id="html_text_banner_mb" wrap="off" readonly>{$param.html_text_banner_mb}</textarea>
                </td>
            </tr>
            <tr>
                <th>詳細情報(MB)<br><br>
                    {if $param.html_text_mb}
                    <a href="{$config.define.SITE_URL_MOBILE}?action_informationPreview=1&text_mb=1&itid={$param.id}" target="_blank">MB本文プレビュー</a>
                    {else}
                    プレビュー設定なし
                    {/if}
                </th>
                <td style="text-align: left;">
                <textarea name="html_text_mb" cols="100" rows="20" id="html_text_mb" wrap="off" readonly>{$param.html_text_mb}</textarea>
                </td>
            </tr>
        </table>
    </form>
{include file=$admFooter}
</div>
</body>
</html>