{include file=$admHeader}
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
<style type="text/css">
.watermark {ldelim}
   color: #999;
{rdelim}
</style>
</head>
<body>
<div class="BlockCol">
    <h2 class="ContentTitle">ユーザー情報</h2>
    {* 更新時エラーコメント *}
    {if $errMsg|@count}
        <div class="warning ui-widget">
        <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
        <p>
        <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
        { foreach from=$errMsg item="val" }
            {$val|@implode:"<br>"}
        {/foreach}
        </p>
        </div>
        </div>
    {/if}
    <form action="./" method="post">
        <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
            <tr>
                <th>ｽﾃｰﾀｽ</th>
                <td style="text-align: left;">
                    {html_options name="regist_status" options=$config.admin_config.regist_status selected=$param.regist_status}
                </td>
            </tr>
            <tr>
                <th>性別</th>
                <td style="text-align: left;">
                    {html_options name="sex_cd" options=$config.web_config.sex_cd selected=$param.sex_cd}
                </td>
            </tr>
            <tr>
                <th>PCﾒｰﾙ強行</th>
                <td style="text-align: left;">
                    {html_options name="is_pc_reverse" options=$config.admin_config.reverse_status selected=$userData.is_pc_reverse}
                </td>
            </tr>
            <tr>
                <th>MBﾒｰﾙ強行</th>
                <td style="text-align: left;">
                    {html_options name="is_mb_reverse" options=$config.admin_config.reverse_status selected=$userData.is_mb_reverse}
                </td>
            </tr>
            <tr>
                <th>ブラック</th>
                <td style="text-align: left;">
                    {html_options name="danger_status" options=$config.admin_config.danger_status selected=$param.danger_status}
                </td>
            </tr>
            <tr>
                <th>PCﾒｰﾙｱﾄﾞﾚｽ</th>
                <td style="text-align: left;">
                    <input type="text" class="mail_address" name="pc_address" value="{$param.pc_address}" style="ime-mode:disabled" size="50">
                </td>
            </tr>
            <tr>
                <th>PCｱﾄﾞﾚｽｽﾃ-ﾀｽ</th>
                <td style="text-align: left;">
                    {html_options name="pc_address_status" options=$config.admin_config.address_status selected=$param.pc_address_status}
                 </td>
            </tr>
            <tr>
                <th>PC送信ｽﾃ-ﾀｽ</th>
                <td style="text-align: left;">
                    {html_options name="pc_send_status" options=$config.admin_config.address_send_status selected=$param.pc_send_status}
                 </td>
            </tr>
            <tr>
                <th>PCﾒｰﾙ受信設定</th>
                <td style="text-align: left;">
                    {html_options name="pc_is_mailmagazine" options=$config.common_config.is_mailmagazine selected=$param.pc_is_mailmagazine}
                 </td>
            </tr>
            <tr>
                <th>MBﾒｰﾙｱﾄﾞﾚｽ</th>
                <td style="text-align: left;">
                    <input type="text" class="mail_address" name="mb_address" value="{$param.mb_address}" style="ime-mode:disabled" size="50">
                </td>
            </tr>
            <tr>
                <th>MBｱﾄﾞﾚｽｽﾃｰﾀｽ</th>
                <td style="text-align: left;">
                    {html_options name="mb_address_status" options=$config.admin_config.address_status selected=$param.mb_address_status}
                </td>
            </tr>
            <tr>
                <th>MB送信ｽﾃ-ﾀｽ</th>
                <td style="text-align: left;">
                    {html_options name="mb_send_status" options=$config.admin_config.address_send_status selected=$param.mb_send_status}
                 </td>
            </tr>
            <tr>
                <th>MBﾒｰﾙ受信設定</th>
                <td style="text-align: left;">
                    {html_options name="mb_is_mailmagazine" options=$config.common_config.is_mailmagazine selected=$param.mb_is_mailmagazine}
                 </td>
            </tr>
            <tr>
                <th>媒体ｺｰﾄﾞ</th>
                <td style="text-align: left;">
                    <input type="text" name="media_cd" value="{$param.media_cd}" style="ime-mode:disabled" size="10"style="text-align:right;">
                </td>
            </tr>
            <tr>
                <th>登録入口ID</th>
                <td style="text-align: left;">
                    <input type="text" name="regist_page_id" value="{$param.regist_page_id}" style="ime-mode:disabled" size="3"style="text-align:right;">
                </td>
            </tr>
            <tr>
                <th>保有ポイント</th>
                <td style="text-align: left;">
                    <input type="text" name="point" value="{$param.point}" style="ime-mode:disabled" size="7"style="text-align:right;"> pt
                </td>
            </tr>
            <tr>
                <th>備考</th>
                <td style="text-align: left;">
                    <textarea name="description" rows="5" cols="50">{$param.description}</textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="vertical-align:top;text-align:center;">
                    <input type="submit" name="action_user_CreateExec" value="登 録" OnClick="return confirm('登録しますか？')" style="width:8em;"/>
                </td>
            </tr>
        </table>
    </form>
{include file=$admFooter}
</div>
<script type="text/javascript" src="./js/jquery.timepickr.min.js"></script>
<script type="text/javascript" src="./js/watermark/jquery.watermark.min.js"></script>
<script language="JavaScript">
<!--
    $(function() {ldelim}

        // カレンダー
        $(".datepicker").datepicker({ldelim}
            showOn: 'button',
            buttonImage: './img/calendar.gif',
            buttonImageOnly: true,
            dateFormat: "yy-mm-dd"
        {rdelim});

        {* テキストボックス文字 *}
        $('.mail_address').watermark('PC,MBどちらか必須');
    {rdelim});

// -->
</script>
</body>
</html>
