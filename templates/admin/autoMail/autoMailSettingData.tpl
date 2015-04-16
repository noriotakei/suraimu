{include file=$admHeader}
<script language="JavaScript">
<!--

    $(function() {ldelim}

        {* PChtmlメールのプレビュー表示 *}
        $('#pc_html_body').keyup(function(){ldelim}
            $("#disp_pc_html_body").html($('#pc_html_body').val());
        {rdelim});
        $('#pc_html_body').click(function(){ldelim}
            $("#disp_pc_html_body").html($('#pc_html_body').val());
        {rdelim});
        $('#pc_html_body').blur(function(){ldelim}
            $("#disp_pc_html_body").html($('#pc_html_body').val());
        {rdelim});

        {* MBhtmlメールのプレビュー表示 *}
        $('#mb_html_body').keyup(function(){ldelim}
            $("#disp_mb_html_body").html($('#mb_html_body').val());
        {rdelim});
        $('#mb_html_body').click(function(){ldelim}
            $("#disp_mb_html_body").html($('#mb_html_body').val());
        {rdelim});
        $('#mb_html_body').blur(function(){ldelim}
            $("#disp_mb_html_body").html($('#mb_html_body').val());
        {rdelim});

        // 送信確認文言
        $("#mailInput").submit(function(){ldelim}
            return confirm("設定しますか？");
        {rdelim});

    {rdelim});


// -->
</script>
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">{$contentsData.name}リメール文言設定</h2>
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
<form action="./" method="post">
    <input type="submit" name="action_autoMail_AutoMailSettingList" value="一覧へ戻る" style="width:8em;"/>
</form>
<br>
<div>
    <a href="{make_link action="action_keyConvert_DispKeyConvertList" getTags=$getTag}" target="_blank">システム変換管理</a>
</div>
<br>
<div>
<form action="./" method="post" id="mailInput" name="mailInput" enctype="multipart/form-data">
{$POSTparam}
<table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
    <tr>
        <th>使用状況</th>
        <td colspan="2">
            {html_options name="is_use" options=$isUse selected=$param.is_use|default:$data.is_use}
        </td>
    </tr>
    <tr>
        <th>送信アドレス</th>
        <td colspan="2">
            <input type="text" name="from_address" value="{$data.from_address|default:$RemailAddress}" size="50" style="ime-mode: disabled;">
        </td>
    </tr>
    <tr>
        <th>送信名</th>
        <td colspan="2">
            <input type="text" name="from_name" value="{$data.from_name}" size="50">
        </td>
    </tr>
    <tr>
        <th>
             登録リメール添付画像(PC)
        </th>
        <td style="text-align: left;" colspan="2">
            {if $pcImgTagAry.1}
                {$pcImgTagAry.1}<br><input type="checkbox" name="pc_image_del[1]" value="1" {if $data.pc_image_del.1}checked{/if}>削除1<br>
            {/if}
            <input type="text" value='<img src="001">' size="20" class="selectText" readonly> <input type="file" name="pc_image[1]"><br>
            {if $pcImgTagAry.2}
                {$pcImgTagAry.2}<br><input type="checkbox" name="pc_image_del[2]" value="1"{if $data.pc_image_del.2}checked{/if}>削除2<br>
            {/if}
            <input type="text" value='<img src="002">' size="20" class="selectText" readonly> <input type="file" name="pc_image[2]"><br>
            {if $pcImgTagAry.3}
                {$pcImgTagAry.3}<br><input type="checkbox" name="pc_image_del[3]" value="1"{if $data.pc_image_del.3}checked{/if}>削除3<br>
            {/if}
            <input type="text" value='<img src="003">' size="20" class="selectText" readonly> <input type="file" name="pc_image[3]"><br>
            {if $pcImgTagAry.4}
                {$pcImgTagAry.4}<br><input type="checkbox" name="pc_image_del[4]" value="1"{if $data.pc_image_del.4}checked{/if}>削除4<br>
            {/if}
            <input type="text" value='<img src="004">' size="20" class="selectText" readonly> <input type="file" name="pc_image[4]"><br>
            {if $pcImgTagAry.5}
                {$pcImgTagAry.5}<br><input type="checkbox" name="pc_image_del[5]" value="1"{if $data.pc_image_del.5}checked{/if}>削除5<br>
            {/if}
            <input type="text" value='<img src="005">' size="20" class="selectText" readonly> <input type="file" name="pc_image[5]"><br>
        </td>
    </tr>
    <tr>
        <th>
            件名(PC)
        </th>
        <td colspan="2">
            <input type="text" name="pc_subject" value="{$data.pc_subject}" size="50">
        </td>
    </tr>
    <tr>
        <th>
            TEXT本文(PC)
        </th>
        <td colspan="2">
            <textarea name="pc_text_body" cols="50" rows="20" id="pc_text_body">{$data.pc_text_body}</textarea>
        </td>
    </tr>
    <tr>
        <th>
            HTML本文(PC)
        </th>
        <td>
            <textarea name="pc_html_body" cols="50" rows="20" id="pc_html_body">{$data.pc_html_body}</textarea>
        </td>
        <td align="left" valign="top">
            <div id="disp_pc_html_body" align="left">{$pc_html_body}</div>
        </td>
    </tr>
    <tr>
        <th>
             登録リメール添付画像(MB)
        </th>
        <td style="text-align: left;" colspan="2">
            {if $mbImgTagAry.1}
                {$mbImgTagAry.1}<br><input type="checkbox" name="mb_image_del[1]" value="1" {if $data.mb_image_del.1}checked{/if}>削除1<br>
            {/if}
            <input type="text" value='<img src="001">' size="20" class="selectText" readonly> <input type="file" name="mb_image[1]"><br>
            {if $mbImgTagAry.2}
                {$mbImgTagAry.2}<br><input type="checkbox" name="mb_image_del[2]" value="1"{if $data.mb_image_del.2}checked{/if}>削除2<br>
            {/if}
            <input type="text" value='<img src="002">' size="20" class="selectText" readonly> <input type="file" name="mb_image[2]"><br>
            {if $mbImgTagAry.3}
                {$mbImgTagAry.3}<br><input type="checkbox" name="mb_image_del[3]" value="1"{if $data.mb_image_del.3}checked{/if}>削除3<br>
            {/if}
            <input type="text" value='<img src="003">' size="20" class="selectText" readonly> <input type="file" name="mb_image[3]"><br>
            {if $mbImgTagAry.4}
                {$mbImgTagAry.4}<br><input type="checkbox" name="mb_image_del[4]" value="1"{if $data.mb_image_del.4}checked{/if}>削除4<br>
            {/if}
            <input type="text" value='<img src="004">' size="20" class="selectText" readonly> <input type="file" name="mb_image[4]"><br>
            {if $mbImgTagAry.5}
                {$mbImgTagAry.5}<br><input type="checkbox" name="mb_image_del[5]" value="1"{if $data.mb_image_del.5}checked{/if}>削除5<br>
            {/if}
            <input type="text" value='<img src="005">' size="20" class="selectText" readonly> <input type="file" name="mb_image[5]"><br>
        </td>
    </tr>
    <tr>
        <th>
            件名(MB)
        </th>
        <td colspan="2">
            <input type="text" name="mb_subject" value="{$data.mb_subject}" size="50">
        </td>
    </tr>
    <tr>
        <th>
            TEXT本文(MB)
        </th>
        <td colspan="2">
            <textarea name="mb_text_body" cols="50" rows="20" id="mb_text_body">{$data.mb_text_body}</textarea>
        </td>
    </tr>
    <tr>
        <th>
            HTML本文(MB)
        </th>
        <td>
            <textarea name="mb_html_body" cols="50" rows="20" id="mb_html_body">{$data.mb_html_body}</textarea>
        </td>
        <td align="left" valign="top">
            <div id="disp_mb_html_body" align="left">{$mb_html_body}</div>
        </td>
    </tr>
    <tr>
        <td style="text-align: center;" valign="top" colspan="3">
            <input type="submit" name="action_autoMail_AutoMailSettingDataExec" value="設定する" />
        </td>
    </tr>
</table>
</form>
</div>
{include file=$admFooter}
</div>
</body>
</html>
