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
    <h2 class="ContentTitle">情報定型文更新画面</h2>
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
    <br>
    <form action="./" method="post">
    {$POSTparam}
        <div class="SubMenu">
            <input type="submit" name="action_informationTemplate_InformationTemplateList" value="一覧に戻る" />
        </div>
    </form>
    <br>
    <div>
        <a href="{make_link action="action_keyConvert_DispKeyConvertList" getTags=$getTag}" target="_blank">システム変換管理</a>
    </div>
    <br>
    <form action="./" method="post" enctype="multipart/form-data">
    {$POSTparam}
        <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
            <tr>
                <th>管理用定型文名</th>
                <td style="text-align: left;">
                    <input type="text" name="name" value="{$param.name}" size="50">
                </td>
                <td style="text-align:center;color:#ff0000;">必須</td>
            </tr>
            <tr>
                <th>表示優先度</th>
                <td style="text-align: left;">
                    <input type="text" name="sort_seq" value="{$param.sort_seq|default:0}" size="10">
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>バナー表示情報(PC)<br>(bodyタグ不要)<br><br>
                    {if $param.html_text_banner_pc}
                    <a href="{$config.define.SITE_URL}?action_informationPreview=1&banner_pc=1&itid={$param.id|default:$param.itid}" target="_blank">PCバナープレビュー</a>
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
                    <a href="{$config.define.SITE_URL}?action_informationPreview=1&text_pc=1&itid={$param.id|default:$param.itid}" target="_blank">PC本文プレビュー</a>
                    {else}
                    プレビュー設定なし
                    {/if}
                </th>
                <td style="text-align: left;"><br>
                    <b><font color="blue">ユーザー側全画面表示設定(PCのみ)：</font></b>{html_options name="is_all_display" options=$isAllDisplay selected=$param.is_all_display|default:0 id="all_disp_type}<br><br>
                    <div id="set_tag" style="display:none;">
                        <b><font color="blue">bodyタグ設定(MB)</font></b><br>
                        <input type="text" class="selectText" size="150" name="html_body_pc" value="{$htmlBodyPC}" readonly><br>
                        <font color="red">※全画面表示「ON」の場合、下記「表示情報(MB)」本文に「&lt;body&gt;」タグを設置して下さい。</font><br><br>
                    </div>
                    <textarea name="html_text_pc" class="inputBody" cols="100" rows="20" id="html_text_pc" wrap="off">{$param.html_text_pc}</textarea>
                    </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>バナー表示情報(MB)<br>(bodyタグ不要)<br><br>
                    {if $param.html_text_banner_mb}
                    <a href="{$config.define.SITE_URL_MOBILE}?action_informationPreview=1&banner_mb=1&itid={$param.id|default:$param.itid}" target="_blank">MBバナープレビュー</a>
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
                    <a href="{$config.define.SITE_URL_MOBILE}?action_informationPreview=1&text_mb=1&itid={$param.id|default:$param.itid}" target="_blank">MB本文プレビュー</a>
                    {else}
                    プレビュー設定なし
                    {/if}
                </th>
                <td style="text-align: left;">
                <b><font color="blue">タグ設定(MB)</font></b><br>
                <textarea  class="selectText" name="html_body_mb" cols="100" rows="4" id="html_text_banner_mb" wrap="off" readonly>{$htmlBodyMB}</textarea><br>
                <font color="red">※下記「表示情報(MB)」本文に張り付けて下さい。タグ内の設定は基本設定となっています。</font><br><br>
                <textarea name="html_text_mb" class="inputBody" cols="100" rows="20" id="html_text_mb" wrap="off">{$param.html_text_mb}</textarea>
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <td colspan="3"  style="text-align:center;">
                    <div class="SubMenu">
                        <input type="submit" name="action_informationTemplate_InformationTemplateExec" value="更新する" onClick="return confirm('更新しますか？')"/>
                    </div>
                </td>
            </tr>
        </table>
    </form>
{include file=$admFooter}
</div>
</body>
</html>