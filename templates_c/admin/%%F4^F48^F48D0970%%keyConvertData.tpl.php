<?php /* Smarty version 2.6.26, created on 2014-08-26 19:08:23
         compiled from /home/suraimu/templates/admin/keyConvert/keyConvertData.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/keyConvert/keyConvertData.tpl', 26, false),array('modifier', 'implode', '/home/suraimu/templates/admin/keyConvert/keyConvertData.tpl', 32, false),array('modifier', 'zend_date_format', '/home/suraimu/templates/admin/keyConvert/keyConvertData.tpl', 91, false),array('function', 'html_options', '/home/suraimu/templates/admin/keyConvert/keyConvertData.tpl', 53, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script language="JavaScript">
<!--
    $(function() {

        if (<?php echo $this->_tpl_vars['keyConvertContentsData']['return_flag']; ?>
) {
            $("#add_form").show();
        }
        $('#add_button').live("click", function(){
            $("#add_form").toggle("blind", null, "slow");
        });

                $(".datepicker").datepicker({
            dateFormat: "yy-mm-dd"
        });

    });
// -->
</script>
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">システム変換更新</h2>
<?php if (count($this->_tpl_vars['execMsg'])): ?>
    <div class="warning ui-widget">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    <p>
    <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    <?php $_from = $this->_tpl_vars['execMsg']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
        <?php echo implode($this->_tpl_vars['val'], "<br>"); ?>

    <?php endforeach; endif; unset($_from); ?>
    </p>
    </div>
    </div>
    <br>
<?php endif; ?>
<div>
<form action="./" method="post">
    <input type="submit" name="action_keyConvert_KeyConvertList" value="一覧へ戻る" style="width:8em;"/>
</form>
<br>
<form action="./" method="POST">
    <?php echo $this->_tpl_vars['POSTparam']; ?>

    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
        <tr>
            <th>変換キー</th>
            <td><input type="text" name="key_name" size="30" value="<?php echo $this->_tpl_vars['keyConvertData']['key_name']; ?>
" style="ime-mode:disabled"></td>
        </tr>
        <tr>
            <th>タイプ</th>
            <td><?php echo smarty_function_html_options(array('name' => 'type','options' => $this->_tpl_vars['config']['admin_config']['convert_type_name'],'selected' => $this->_tpl_vars['keyConvertData']['type'],'id' => 'type'), $this);?>
</td>
        </tr>
        <tr>
            <th>カテゴリー</th>
            <td><?php echo smarty_function_html_options(array('name' => 'key_convert_list_category_id','options' => $this->_tpl_vars['categoryList'],'selected' => $this->_tpl_vars['keyConvertData']['key_convert_list_category_id']), $this);?>
</td>
        </tr>
        <tr>
            <th>備考</th>
            <td><input type="text" name="description" size="50" value="<?php echo $this->_tpl_vars['keyConvertData']['description']; ?>
"></td>
        </tr>
        <?php if ($this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SYSTEM']): ?>
        <tr>
            <th>更新不可</th>
            <td><input type="checkbox" name="is_not_update" value="1" <?php if ($this->_tpl_vars['keyConvertData']['is_not_update']): ?>checked<?php endif; ?>></td>
        </tr>
        <?php endif; ?>
        <tr>
            <td colspan="2" style="text-align:center"><input type="submit" name="action_keyConvert_KeyConvertDataExec" value="更 新" onClick="return confirm('更新しますか？')"/></td>
        </tr>
    </table>
</form>
<br>
<div class="SubMenu">
    <input type="button" id="add_button" value="追　加" />
</div>
<div id="add_form" style="display:none;">
    <form action="./" method="POST">
        <?php echo $this->_tpl_vars['POSTparam']; ?>

        <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
            <tr>
                <th>変換内容</th>
                <th>表示開始日時</th>
                <th>表示終了日時</th>
                <th></th>
            </tr>
            <tr>
                <td><input type="text" name="contents" size="60" value="<?php echo $this->_tpl_vars['keyConvertContentsData']['contents']; ?>
" class="contents"></td>
                <td>
                        <input name="disp_datetime_from_date" size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['keyConvertContentsData']['display_start_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" maxlength="10">
                        <input name="disp_datetime_from_time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['keyConvertContentsData']['display_start_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
                </td>
                <td>
                        <input name="disp_datetime_to_date" size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['keyConvertContentsData']['display_end_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" maxlength="10">
                        <input name="disp_datetime_to_time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['keyConvertContentsData']['display_end_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
                </td>
                <td style="text-align:center"><input type="submit" name="action_keyConvert_KeyConvertContentsDataExec" value="登 録" onClick="return confirm('登録しますか？')"/></td>
            </tr>
        </table>
    </form>
</div>
<br>
<?php if ($this->_tpl_vars['keyConvertContentsList']): ?>
        <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
            <tr>
                <th>変換内容</th>
                <th>表示開始日時</th>
                <th>表示終了日時</th>
                <th>削除</th>
                <th></th>
            </tr>
            <?php $_from = $this->_tpl_vars['keyConvertContentsList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
            <tr>
            <form action="./" method="POST">
                <?php echo $this->_tpl_vars['POSTparam']; ?>

                    <td><input type="hidden" name="convert_contents_id" value="<?php echo $this->_tpl_vars['val']['id']; ?>
"><input type="text" name="contents" size="60" value="<?php echo $this->_tpl_vars['val']['contents']; ?>
" class="contents"></td>
                    <td>
                            <input name="disp_datetime_from_date" size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['val']['display_start_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" maxlength="10">
                            <input name="disp_datetime_from_time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['val']['display_start_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
                    </td>
                    <td>
                            <input name="disp_datetime_to_date" size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['val']['display_end_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" maxlength="10">
                            <input name="disp_datetime_to_time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['val']['display_end_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
                    </td>
                    <td><input type="checkbox" name="disable" value="1"></td>
                    <td style="text-align:center"><input type="submit" name="action_keyConvert_KeyConvertContentsDataExec" value="更 新" onClick="return confirm('更新しますか？')"/></td>
            </form>
            </tr>
            <?php endforeach; endif; unset($_from); ?>
        </table>
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