{include file=$admHeader}
<script type="text/javascript" src="./js/watermark/jquery.watermark.min.js"></script>
<style type="text/css">
.watermark {ldelim}
   color: #999;
{rdelim}
</style>
<script language="JavaScript">
<!--
    $(function() {ldelim}

        $('.selectText').click(function(env){ldelim}
            if (env.button !== 0) return;
            $(this).select();
        {rdelim});

        // カレンダー
        $(".datepicker").datepicker({ldelim}
            showOn: 'button',
            buttonImage: './img/calendar.gif',
            buttonImageOnly: true,
            dateFormat: "yy-mm-dd"
        {rdelim});

{*       $('.regist_url').watermark('「http://」から入力'); *}

        {* 登録ページ表示内容のプレビュー表示 *}
        $('#page_html_pc').keyup(function(){ldelim}
            $("#disp_page_html_pc").html($('#page_html_pc').val());
        {rdelim});
        $('#page_html_pc').click(function(env){ldelim}
            if (env.button !== 0) return;
            $("#disp_page_html_pc").html($('#page_html_pc').val());
        {rdelim});
        $('#page_html_pc').blur(function(){ldelim}
            $("#disp_page_html_pc").html($('#page_html_pc').val());
        {rdelim});

        {* 登録ページ表示内容のプレビュー表示 *}
        $('#page_html_mb').keyup(function(){ldelim}
            $("#disp_page_html_mb").html($('#page_html_mb').val());
        {rdelim});
        $('#page_html_mb').click(function(env){ldelim}
            if (env.button !== 0) return;
            $("#disp_page_html_mb").html($('#page_html_mb').val());
        {rdelim});
        $('#page_html_mb').blur(function(){ldelim}
            $("#disp_page_html_mb").html($('#page_html_mb').val());
        {rdelim});

        {* PChtmlメールのプレビュー表示 *}
        $('#pc_html_body').keyup(function(){ldelim}
            $("#disp_pc_html_body").html($('#pc_html_body').val());
        {rdelim});
        $('#pc_html_body').click(function(env){ldelim}
            if (env.button !== 0) return;
            $("#disp_pc_html_body").html($('#pc_html_body').val());
        {rdelim});
        $('#pc_html_body').blur(function(){ldelim}
            $("#disp_pc_html_body").html($('#pc_html_body').val());
        {rdelim});

        {* MBhtmlメールのプレビュー表示 *}
        $('#mb_html_body').keyup(function(){ldelim}
            $("#disp_mb_html_body").html($('#mb_html_body').val());
        {rdelim});
        $('#mb_html_body').click(function(env){ldelim}
            if (env.button !== 0) return;
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
<h2 class="ContentTitle">登録ページ更新</h2>
<form action="./" method="post">
    <input type="submit" name="action_registPage_RegistPageSearchList" value="一覧へ戻る"/>
</form>
<br>
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
{if $data}
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
                <td colspan="2">{html_radios name="is_use" options=$isUseAry selected=$data.is_use separator="&nbsp;"}</td>
            </tr>
            <tr>
                <th>PC本登録用リダイレクトURL</th>
                <td colspan="2"><input type="text" class="regist_url" name="regist_url_pc" value="{$data.regist_url_pc}" size="80"></td>
            </tr>
            <tr>
                <th>カテゴリー</th>
                <td colspan="2">{html_options name="regist_page_category_id" options=$categoryList selected=$data.regist_page_category_id}</td>
            </tr>
            <tr>
                <th>登録ページ名</th>
                <td colspan="2"><input type="text" name="name" value="{$data.name}" size="50"></td>
            </tr>
            <tr>
                <th>登録ページコード</th>
                <td colspan="2"><input type="text" name="cd" value="{$data.cd}" size="50"></td>
            </tr>
            <tr>
                <th>優先順位</th>
                <td colspan="2"><input type="text" name="sort_seq" value="{$data.sort_seq}" size="3"></td>
            </tr>
            <tr>
                <th>
                    登録ページ表示内容(PC)<br><font color="red">※</font>ファイセムでは使いません
                    <br><a href="{$config.define.SITE_URL}?action_indexPreview=1&{$pageCdName}={$data.cd}" target="_blank">PCプレビュー</a>
                </th>
                <td colspan="2">
                    <textarea name="page_html_pc" cols="60" rows="30" id="page_html_pc" wrap="off">{$data.page_html_pc}</textarea>
                </td>
            </tr>
            <tr>
                <th>
                    登録ページ表示内容(MB)<br><font color="red">※</font>ファイセムでは使いません
                    <br><a href="{$config.define.SITE_URL_MOBILE}?action_indexPreview=1&{$pageCdName}={$data.cd}" target="_blank">MBプレビュー</a>
                </th>
                <td colspan="2">
                    基本bodyタグ<br>
                    <input type="text" class="selectText" size="100" value='<body link="#ffcc99" vlink="#cc9966" alink="#ffcc99" text="#ffffff" style="color:#ffffff; background:#000000;" bgcolor="#000000">' readonly><br>
                    <textarea name="page_html_mb" cols="60" rows="30" id="page_html_mb" wrap="off">{$data.page_html_mb}</textarea>
                </td>
            </tr>
            <tr>
                <th>登録リメール送信アドレス</th>
                <td colspan="2">
                    <input type="text" name="from_address" value="{$data.from_address}" size="50" style="ime-mode: disabled;">
                </td>
            </tr>
            <tr>
                <th>登録リメール送信名</th>
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
                    登録リメール件名(PC)
                </th>
                <td colspan="2">
                    <input type="text" name="pc_subject" value="{$data.pc_subject}" size="50">
                </td>
            </tr>
            <tr>
                <th>
                    登録リメールTEXT本文(PC)
                </th>
                <td colspan="2">
                    <textarea name="pc_text_body" cols="60" rows="30" id="pc_text_body" wrap="off">{$data.pc_text_body}</textarea>
                </td>
            </tr>
            <tr>
                <th>
                    登録リメールTEXT本文パート2(PC)
                </th>
                <td colspan="2">
                    <textarea name="pc_text_body_second" cols="60" rows="30" id="pc_text_body_second" wrap="off">{$data.pc_text_body_second}</textarea>
                </td>
            </tr>
            <tr>
                <th>
                    登録リメールHTML本文(PC)
                </th>
                <td>
                    <textarea name="pc_html_body" cols="60" rows="30" id="pc_html_body" wrap="off">{$data.pc_html_body}</textarea>
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
                    登録リメール件名(MB)
                </th>
                <td colspan="2">
                    <input type="text" name="mb_subject" value="{$data.mb_subject}" size="50">
                </td>
            </tr>
            <tr>
                <th>
                    登録リメールTEXT本文(MB)
                </th>
                <td colspan="2">
                    <textarea name="mb_text_body" cols="60" rows="30" id="mb_text_body" wrap="off">{$data.mb_text_body}</textarea>
                </td>
            </tr>
            <tr>
                <th>
                    登録リメールTEXT本文パート2(MB)
                </th>
                <td colspan="2">
                    <textarea name="mb_text_body_second" cols="60" rows="30" id="mb_text_body_second" wrap="off">{$data.mb_text_body_second}</textarea>
                </td>
            </tr>

            <tr>
                <th>
                    登録リメールHTML本文(MB)
                </th>
                <td>
                    <textarea name="mb_html_body" cols="60" rows="30" id="mb_html_body" wrap="off">{$data.mb_html_body}</textarea>
                </td>
                <td align="left" valign="top">
                    <div id="disp_mb_html_body" align="left">{$mb_html_body|emoji}</div>
                </td>
            </tr>
            <tr>
                <th>表示日時(任意)</th>
                <td>
                    <input size="15" class="datepicker" type="text" value="{$data.display_start_datetime|zend_date_format:'yyyy-MM-dd'}" name="display_start_datetime_Date" maxlength="10">
                    <input name="display_start_datetime_Time" class="time" type="text" value="{$data.display_start_datetime|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
                    から
                    <input size="15" class="datepicker" type="text" value="{$data.display_end_datetime|zend_date_format:'yyyy-MM-dd'}" name="display_end_datetime_Date" maxlength="10">
                    <input name="display_end_datetime_Time" class="time" type="text" value="{$data.display_end_datetime|zend_date_format:'HH:mm:ss'}" size="10" maxlength="8">
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align:center;">
                    <div class="SubMenu">
                        <input type="submit" name="action_registPage_RegistPageDataExec" value="変更する" />
                    </div>
                </td>
            </tr>
        </table>

    </form>
{/if}
</div>
{include file=$admFooter}
</div>
</body>
</html>
