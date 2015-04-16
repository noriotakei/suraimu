<?php /* Smarty version 2.6.26, created on 2014-08-09 10:59:50
         compiled from /home/suraimu/templates/admin/registPage/registPageData.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/registPage/registPageData.tpl', 92, false),array('modifier', 'implode', '/home/suraimu/templates/admin/registPage/registPageData.tpl', 98, false),array('modifier', 'emoji', '/home/suraimu/templates/admin/registPage/registPageData.tpl', 292, false),array('modifier', 'zend_date_format', '/home/suraimu/templates/admin/registPage/registPageData.tpl', 298, false),array('function', 'make_link', '/home/suraimu/templates/admin/registPage/registPageData.tpl', 107, false),array('function', 'html_radios', '/home/suraimu/templates/admin/registPage/registPageData.tpl', 116, false),array('function', 'html_options', '/home/suraimu/templates/admin/registPage/registPageData.tpl', 124, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="./js/watermark/jquery.watermark.min.js"></script>
<style type="text/css">
.watermark {
   color: #999;
}
</style>
<script language="JavaScript">
<!--
    $(function() {

        $('.selectText').click(function(env){
            if (env.button !== 0) return;
            $(this).select();
        });

        // カレンダー
        $(".datepicker").datepicker({
            showOn: 'button',
            buttonImage: './img/calendar.gif',
            buttonImageOnly: true,
            dateFormat: "yy-mm-dd"
        });


                $('#page_html_pc').keyup(function(){
            $("#disp_page_html_pc").html($('#page_html_pc').val());
        });
        $('#page_html_pc').click(function(env){
            if (env.button !== 0) return;
            $("#disp_page_html_pc").html($('#page_html_pc').val());
        });
        $('#page_html_pc').blur(function(){
            $("#disp_page_html_pc").html($('#page_html_pc').val());
        });

                $('#page_html_mb').keyup(function(){
            $("#disp_page_html_mb").html($('#page_html_mb').val());
        });
        $('#page_html_mb').click(function(env){
            if (env.button !== 0) return;
            $("#disp_page_html_mb").html($('#page_html_mb').val());
        });
        $('#page_html_mb').blur(function(){
            $("#disp_page_html_mb").html($('#page_html_mb').val());
        });

                $('#pc_html_body').keyup(function(){
            $("#disp_pc_html_body").html($('#pc_html_body').val());
        });
        $('#pc_html_body').click(function(env){
            if (env.button !== 0) return;
            $("#disp_pc_html_body").html($('#pc_html_body').val());
        });
        $('#pc_html_body').blur(function(){
            $("#disp_pc_html_body").html($('#pc_html_body').val());
        });

                $('#mb_html_body').keyup(function(){
            $("#disp_mb_html_body").html($('#mb_html_body').val());
        });
        $('#mb_html_body').click(function(env){
            if (env.button !== 0) return;
            $("#disp_mb_html_body").html($('#mb_html_body').val());
        });
        $('#mb_html_body').blur(function(){
            $("#disp_mb_html_body").html($('#mb_html_body').val());
        });

        // 送信確認文言
        $("#mailInput").submit(function(){
            return confirm("設定しますか？");
        });

    });
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
<?php if (count($this->_tpl_vars['msg'])): ?>
    <div class="warning ui-widget">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    <p>
    <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    <?php $_from = $this->_tpl_vars['msg']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
        <?php echo implode($this->_tpl_vars['val'], "<br>"); ?>

    <?php endforeach; endif; unset($_from); ?>
    </p>
    </div>
    </div>
    <br>
<?php endif; ?>
<?php if ($this->_tpl_vars['data']): ?>
    <div>
        <a href="<?php echo smarty_function_make_link(array('action' => 'action_keyConvert_DispKeyConvertList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="_blank">システム変換管理</a>
    </div>
    <br>
    <div>
    <form action="./" method="post" id="mailInput" name="mailInput" enctype="multipart/form-data">
    <?php echo $this->_tpl_vars['POSTparam']; ?>

        <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
            <tr>
                <th>使用状況</th>
                <td colspan="2"><?php echo smarty_function_html_radios(array('name' => 'is_use','options' => $this->_tpl_vars['isUseAry'],'selected' => $this->_tpl_vars['data']['is_use'],'separator' => "&nbsp;"), $this);?>
</td>
            </tr>
            <tr>
                <th>PC本登録用リダイレクトURL</th>
                <td colspan="2"><input type="text" class="regist_url" name="regist_url_pc" value="<?php echo $this->_tpl_vars['data']['regist_url_pc']; ?>
" size="80"></td>
            </tr>
            <tr>
                <th>カテゴリー</th>
                <td colspan="2"><?php echo smarty_function_html_options(array('name' => 'regist_page_category_id','options' => $this->_tpl_vars['categoryList'],'selected' => $this->_tpl_vars['data']['regist_page_category_id']), $this);?>
</td>
            </tr>
            <tr>
                <th>登録ページ名</th>
                <td colspan="2"><input type="text" name="name" value="<?php echo $this->_tpl_vars['data']['name']; ?>
" size="50"></td>
            </tr>
            <tr>
                <th>登録ページコード</th>
                <td colspan="2"><input type="text" name="cd" value="<?php echo $this->_tpl_vars['data']['cd']; ?>
" size="50"></td>
            </tr>
            <tr>
                <th>優先順位</th>
                <td colspan="2"><input type="text" name="sort_seq" value="<?php echo $this->_tpl_vars['data']['sort_seq']; ?>
" size="3"></td>
            </tr>
            <tr>
                <th>
                    登録ページ表示内容(PC)<br><font color="red">※</font>ファイセムでは使いません
                    <br><a href="<?php echo $this->_tpl_vars['config']['define']['SITE_URL']; ?>
?action_indexPreview=1&<?php echo $this->_tpl_vars['pageCdName']; ?>
=<?php echo $this->_tpl_vars['data']['cd']; ?>
" target="_blank">PCプレビュー</a>
                </th>
                <td colspan="2">
                    <textarea name="page_html_pc" cols="60" rows="30" id="page_html_pc" wrap="off"><?php echo $this->_tpl_vars['data']['page_html_pc']; ?>
</textarea>
                </td>
            </tr>
            <tr>
                <th>
                    登録ページ表示内容(MB)<br><font color="red">※</font>ファイセムでは使いません
                    <br><a href="<?php echo $this->_tpl_vars['config']['define']['SITE_URL_MOBILE']; ?>
?action_indexPreview=1&<?php echo $this->_tpl_vars['pageCdName']; ?>
=<?php echo $this->_tpl_vars['data']['cd']; ?>
" target="_blank">MBプレビュー</a>
                </th>
                <td colspan="2">
                    基本bodyタグ<br>
                    <input type="text" class="selectText" size="100" value='<body link="#ffcc99" vlink="#cc9966" alink="#ffcc99" text="#ffffff" style="color:#ffffff; background:#000000;" bgcolor="#000000">' readonly><br>
                    <textarea name="page_html_mb" cols="60" rows="30" id="page_html_mb" wrap="off"><?php echo $this->_tpl_vars['data']['page_html_mb']; ?>
</textarea>
                </td>
            </tr>
            <tr>
                <th>登録リメール送信アドレス</th>
                <td colspan="2">
                    <input type="text" name="from_address" value="<?php echo $this->_tpl_vars['data']['from_address']; ?>
" size="50" style="ime-mode: disabled;">
                </td>
            </tr>
            <tr>
                <th>登録リメール送信名</th>
                <td colspan="2">
                    <input type="text" name="from_name" value="<?php echo $this->_tpl_vars['data']['from_name']; ?>
" size="50">
                </td>
            </tr>
            <tr>
                <th>
                    登録リメール添付画像(PC)
                </th>
                <td style="text-align: left;" colspan="2">
                    <?php if ($this->_tpl_vars['pcImgTagAry']['1']): ?>
                        <?php echo $this->_tpl_vars['pcImgTagAry']['1']; ?>
<br><input type="checkbox" name="pc_image_del[1]" value="1" <?php if ($this->_tpl_vars['data']['pc_image_del']['1']): ?>checked<?php endif; ?>>削除1<br>
                    <?php endif; ?>
                    <input type="text" value='<img src="001">' size="20" class="selectText" readonly> <input type="file" name="pc_image[1]"><br>
                    <?php if ($this->_tpl_vars['pcImgTagAry']['2']): ?>
                        <?php echo $this->_tpl_vars['pcImgTagAry']['2']; ?>
<br><input type="checkbox" name="pc_image_del[2]" value="1"<?php if ($this->_tpl_vars['data']['pc_image_del']['2']): ?>checked<?php endif; ?>>削除2<br>
                    <?php endif; ?>
                    <input type="text" value='<img src="002">' size="20" class="selectText" readonly> <input type="file" name="pc_image[2]"><br>
                    <?php if ($this->_tpl_vars['pcImgTagAry']['3']): ?>
                        <?php echo $this->_tpl_vars['pcImgTagAry']['3']; ?>
<br><input type="checkbox" name="pc_image_del[3]" value="1"<?php if ($this->_tpl_vars['data']['pc_image_del']['3']): ?>checked<?php endif; ?>>削除3<br>
                    <?php endif; ?>
                    <input type="text" value='<img src="003">' size="20" class="selectText" readonly> <input type="file" name="pc_image[3]"><br>
                    <?php if ($this->_tpl_vars['pcImgTagAry']['4']): ?>
                        <?php echo $this->_tpl_vars['pcImgTagAry']['4']; ?>
<br><input type="checkbox" name="pc_image_del[4]" value="1"<?php if ($this->_tpl_vars['data']['pc_image_del']['4']): ?>checked<?php endif; ?>>削除4<br>
                    <?php endif; ?>
                    <input type="text" value='<img src="004">' size="20" class="selectText" readonly> <input type="file" name="pc_image[4]"><br>
                    <?php if ($this->_tpl_vars['pcImgTagAry']['5']): ?>
                        <?php echo $this->_tpl_vars['pcImgTagAry']['5']; ?>
<br><input type="checkbox" name="pc_image_del[5]" value="1"<?php if ($this->_tpl_vars['data']['pc_image_del']['5']): ?>checked<?php endif; ?>>削除5<br>
                    <?php endif; ?>
                    <input type="text" value='<img src="005">' size="20" class="selectText" readonly> <input type="file" name="pc_image[5]"><br>
                </td>
            </tr>
            <tr>
                <th>
                    登録リメール件名(PC)
                </th>
                <td colspan="2">
                    <input type="text" name="pc_subject" value="<?php echo $this->_tpl_vars['data']['pc_subject']; ?>
" size="50">
                </td>
            </tr>
            <tr>
                <th>
                    登録リメールTEXT本文(PC)
                </th>
                <td colspan="2">
                    <textarea name="pc_text_body" cols="60" rows="30" id="pc_text_body" wrap="off"><?php echo $this->_tpl_vars['data']['pc_text_body']; ?>
</textarea>
                </td>
            </tr>
            <tr>
                <th>
                    登録リメールTEXT本文パート2(PC)
                </th>
                <td colspan="2">
                    <textarea name="pc_text_body_second" cols="60" rows="30" id="pc_text_body_second" wrap="off"><?php echo $this->_tpl_vars['data']['pc_text_body_second']; ?>
</textarea>
                </td>
            </tr>
            <tr>
                <th>
                    登録リメールHTML本文(PC)
                </th>
                <td>
                    <textarea name="pc_html_body" cols="60" rows="30" id="pc_html_body" wrap="off"><?php echo $this->_tpl_vars['data']['pc_html_body']; ?>
</textarea>
                </td>
                <td align="left" valign="top">
                    <div id="disp_pc_html_body" align="left"><?php echo $this->_tpl_vars['pc_html_body']; ?>
</div>
                </td>
            </tr>
            <tr>
                <th>
                     登録リメール添付画像(MB)
                </th>
                <td style="text-align: left;" colspan="2">
                    <?php if ($this->_tpl_vars['mbImgTagAry']['1']): ?>
                        <?php echo $this->_tpl_vars['mbImgTagAry']['1']; ?>
<br><input type="checkbox" name="mb_image_del[1]" value="1" <?php if ($this->_tpl_vars['data']['mb_image_del']['1']): ?>checked<?php endif; ?>>削除1<br>
                    <?php endif; ?>
                    <input type="text" value='<img src="001">' size="20" class="selectText" readonly> <input type="file" name="mb_image[1]"><br>
                    <?php if ($this->_tpl_vars['mbImgTagAry']['2']): ?>
                        <?php echo $this->_tpl_vars['mbImgTagAry']['2']; ?>
<br><input type="checkbox" name="mb_image_del[2]" value="1"<?php if ($this->_tpl_vars['data']['mb_image_del']['2']): ?>checked<?php endif; ?>>削除2<br>
                    <?php endif; ?>
                    <input type="text" value='<img src="002">' size="20" class="selectText" readonly> <input type="file" name="mb_image[2]"><br>
                    <?php if ($this->_tpl_vars['mbImgTagAry']['3']): ?>
                        <?php echo $this->_tpl_vars['mbImgTagAry']['3']; ?>
<br><input type="checkbox" name="mb_image_del[3]" value="1"<?php if ($this->_tpl_vars['data']['mb_image_del']['3']): ?>checked<?php endif; ?>>削除3<br>
                    <?php endif; ?>
                    <input type="text" value='<img src="003">' size="20" class="selectText" readonly> <input type="file" name="mb_image[3]"><br>
                    <?php if ($this->_tpl_vars['mbImgTagAry']['4']): ?>
                        <?php echo $this->_tpl_vars['mbImgTagAry']['4']; ?>
<br><input type="checkbox" name="mb_image_del[4]" value="1"<?php if ($this->_tpl_vars['data']['mb_image_del']['4']): ?>checked<?php endif; ?>>削除4<br>
                    <?php endif; ?>
                    <input type="text" value='<img src="004">' size="20" class="selectText" readonly> <input type="file" name="mb_image[4]"><br>
                    <?php if ($this->_tpl_vars['mbImgTagAry']['5']): ?>
                        <?php echo $this->_tpl_vars['mbImgTagAry']['5']; ?>
<br><input type="checkbox" name="mb_image_del[5]" value="1"<?php if ($this->_tpl_vars['data']['mb_image_del']['5']): ?>checked<?php endif; ?>>削除5<br>
                    <?php endif; ?>
                    <input type="text" value='<img src="005">' size="20" class="selectText" readonly> <input type="file" name="mb_image[5]"><br>
                </td>
            </tr>
            <tr>
                <th>
                    登録リメール件名(MB)
                </th>
                <td colspan="2">
                    <input type="text" name="mb_subject" value="<?php echo $this->_tpl_vars['data']['mb_subject']; ?>
" size="50">
                </td>
            </tr>
            <tr>
                <th>
                    登録リメールTEXT本文(MB)
                </th>
                <td colspan="2">
                    <textarea name="mb_text_body" cols="60" rows="30" id="mb_text_body" wrap="off"><?php echo $this->_tpl_vars['data']['mb_text_body']; ?>
</textarea>
                </td>
            </tr>
            <tr>
                <th>
                    登録リメールTEXT本文パート2(MB)
                </th>
                <td colspan="2">
                    <textarea name="mb_text_body_second" cols="60" rows="30" id="mb_text_body_second" wrap="off"><?php echo $this->_tpl_vars['data']['mb_text_body_second']; ?>
</textarea>
                </td>
            </tr>

            <tr>
                <th>
                    登録リメールHTML本文(MB)
                </th>
                <td>
                    <textarea name="mb_html_body" cols="60" rows="30" id="mb_html_body" wrap="off"><?php echo $this->_tpl_vars['data']['mb_html_body']; ?>
</textarea>
                </td>
                <td align="left" valign="top">
                    <div id="disp_mb_html_body" align="left"><?php echo ((is_array($_tmp=$this->_tpl_vars['mb_html_body'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>
</div>
                </td>
            </tr>
            <tr>
                <th>表示日時(任意)</th>
                <td>
                    <input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['display_start_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="display_start_datetime_Date" maxlength="10">
                    <input name="display_start_datetime_Time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['display_start_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
                    から
                    <input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['display_end_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="display_end_datetime_Date" maxlength="10">
                    <input name="display_end_datetime_Time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['display_end_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
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
<?php endif; ?>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admFooter'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
</body>
</html>