<?php /* Smarty version 2.6.26, created on 2014-09-07 13:05:25
         compiled from /home/suraimu/templates/admin/autoMail/autoMailSettingData.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/autoMail/autoMailSettingData.tpl', 44, false),array('modifier', 'implode', '/home/suraimu/templates/admin/autoMail/autoMailSettingData.tpl', 50, false),array('modifier', 'default', '/home/suraimu/templates/admin/autoMail/autoMailSettingData.tpl', 72, false),array('function', 'make_link', '/home/suraimu/templates/admin/autoMail/autoMailSettingData.tpl', 62, false),array('function', 'html_options', '/home/suraimu/templates/admin/autoMail/autoMailSettingData.tpl', 72, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script language="JavaScript">
<!--

    $(function() {

                $('#pc_html_body').keyup(function(){
            $("#disp_pc_html_body").html($('#pc_html_body').val());
        });
        $('#pc_html_body').click(function(){
            $("#disp_pc_html_body").html($('#pc_html_body').val());
        });
        $('#pc_html_body').blur(function(){
            $("#disp_pc_html_body").html($('#pc_html_body').val());
        });

                $('#mb_html_body').keyup(function(){
            $("#disp_mb_html_body").html($('#mb_html_body').val());
        });
        $('#mb_html_body').click(function(){
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
<h2 class="ContentTitle"><?php echo $this->_tpl_vars['contentsData']['name']; ?>
リメール文言設定</h2>
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
<form action="./" method="post">
    <input type="submit" name="action_autoMail_AutoMailSettingList" value="一覧へ戻る" style="width:8em;"/>
</form>
<br>
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
        <td colspan="2">
            <?php echo smarty_function_html_options(array('name' => 'is_use','options' => $this->_tpl_vars['isUse'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['param']['is_use'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['data']['is_use']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['data']['is_use']))), $this);?>

        </td>
    </tr>
    <tr>
        <th>送信アドレス</th>
        <td colspan="2">
            <input type="text" name="from_address" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['data']['from_address'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['RemailAddress']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['RemailAddress'])); ?>
" size="50" style="ime-mode: disabled;">
        </td>
    </tr>
    <tr>
        <th>送信名</th>
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
            件名(PC)
        </th>
        <td colspan="2">
            <input type="text" name="pc_subject" value="<?php echo $this->_tpl_vars['data']['pc_subject']; ?>
" size="50">
        </td>
    </tr>
    <tr>
        <th>
            TEXT本文(PC)
        </th>
        <td colspan="2">
            <textarea name="pc_text_body" cols="50" rows="20" id="pc_text_body"><?php echo $this->_tpl_vars['data']['pc_text_body']; ?>
</textarea>
        </td>
    </tr>
    <tr>
        <th>
            HTML本文(PC)
        </th>
        <td>
            <textarea name="pc_html_body" cols="50" rows="20" id="pc_html_body"><?php echo $this->_tpl_vars['data']['pc_html_body']; ?>
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
            件名(MB)
        </th>
        <td colspan="2">
            <input type="text" name="mb_subject" value="<?php echo $this->_tpl_vars['data']['mb_subject']; ?>
" size="50">
        </td>
    </tr>
    <tr>
        <th>
            TEXT本文(MB)
        </th>
        <td colspan="2">
            <textarea name="mb_text_body" cols="50" rows="20" id="mb_text_body"><?php echo $this->_tpl_vars['data']['mb_text_body']; ?>
</textarea>
        </td>
    </tr>
    <tr>
        <th>
            HTML本文(MB)
        </th>
        <td>
            <textarea name="mb_html_body" cols="50" rows="20" id="mb_html_body"><?php echo $this->_tpl_vars['data']['mb_html_body']; ?>
</textarea>
        </td>
        <td align="left" valign="top">
            <div id="disp_mb_html_body" align="left"><?php echo $this->_tpl_vars['mb_html_body']; ?>
</div>
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
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admFooter'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
</body>
</html>