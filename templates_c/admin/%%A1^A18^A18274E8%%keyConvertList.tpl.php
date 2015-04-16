<?php /* Smarty version 2.6.26, created on 2014-08-26 16:20:20
         compiled from /home/suraimu/templates/admin/keyConvert/keyConvertList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/keyConvert/keyConvertList.tpl', 29, false),array('modifier', 'implode', '/home/suraimu/templates/admin/keyConvert/keyConvertList.tpl', 35, false),array('modifier', 'default', '/home/suraimu/templates/admin/keyConvert/keyConvertList.tpl', 57, false),array('modifier', 'cat', '/home/suraimu/templates/admin/keyConvert/keyConvertList.tpl', 86, false),array('function', 'html_options', '/home/suraimu/templates/admin/keyConvert/keyConvertList.tpl', 58, false),array('function', 'make_link', '/home/suraimu/templates/admin/keyConvert/keyConvertList.tpl', 86, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script language="JavaScript">
<!--

    $(function() {

        if (!<?php echo $this->_tpl_vars['param']['return_flag']; ?>
) {
            $("#add_form").hide();
        }
        $('#add_button').live("click", function(){
            $("#add_form").toggle("blind", null, "slow");
        });

                $('#list_table').colorize({
            altColor :'#CCCCCC',
            hiliteColor :'none'
        });
    });

// -->
</script>
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">システム変換表</h2>
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
<div class="SubMenu">
    <input type="button" id="add_button" value="追　加" />
</div>
<div id="add_form" style="display:none;">
<form action="./" method="POST">
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
        <tr>
            <th>変換キー</th>
            <th>タイプ</th>
            <th>カテゴリー</th>
            <th>備考</th>
            <?php if ($this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SYSTEM']): ?><th>更新不可</th><?php endif; ?>
            <th></th>
        </tr>
        <tr>
            <td><input type="text" name="key_name" size="20" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['param']['key_name'])) ? $this->_run_mod_handler('default', true, $_tmp, "-%-") : smarty_modifier_default($_tmp, "-%-")); ?>
" style="ime-mode:disabled"></td>
            <td><?php echo smarty_function_html_options(array('name' => 'type','options' => $this->_tpl_vars['config']['admin_config']['convert_type_name'],'selected' => $this->_tpl_vars['param']['type']), $this);?>
</td>
            <td><?php echo smarty_function_html_options(array('name' => 'key_convert_list_category_id','options' => $this->_tpl_vars['categoryList'],'selected' => $this->_tpl_vars['param']['key_convert_list_category_id']), $this);?>
</td>
            <td><input type="text" name="description" size="20" value="<?php echo $this->_tpl_vars['param']['description']; ?>
"></td>
            <?php if ($this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SYSTEM']): ?><td><input type="checkbox" name="not_update" value="1" <?php if ($this->_tpl_vars['param']['is_not_update']): ?>checked<?php endif; ?>></td><?php endif; ?>
            <td style="text_align: center;"><input type="submit" name="action_keyConvert_KeyConvertExec" value="登　録" /></td>
        </tr>
    </table>
</form>
</div>
<br>
<?php if ($this->_tpl_vars['keyConvertList']): ?>
    <form action="./" method="POST">
        <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">
            <tr>
                <th>ID</th>
                <th>変換キー</th>
                <th>変換内容</th>
                <th>タイプ</th>
                <th>カテゴリー</th>
                <th>備考</th>
                <?php if ($this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SYSTEM']): ?><th>更新不可</th><?php endif; ?>
                <th>削除</th>
            </tr>
            <?php $_from = $this->_tpl_vars['keyConvertList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
                <tr>
                        <td>
                        <?php if ($this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SYSTEM'] || ( $this->_tpl_vars['loginAdminData']['authority_type'] != $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SYSTEM'] && ! $this->_tpl_vars['val']['is_not_update'] )): ?>
                        <a href="<?php echo smarty_function_make_link(array('action' => 'action_keyConvert_KeyConvertData','getTags' => ((is_array($_tmp="key_convert_list_id=")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['val']['id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['val']['id']))), $this);?>
"><?php echo $this->_tpl_vars['val']['id']; ?>
</a>
                        <?php else: ?>
                        <?php echo $this->_tpl_vars['val']['id']; ?>

                        <?php endif; ?>
                        </td>
                        <td><input type="hidden" name="convert_list_id[]" value="<?php echo $this->_tpl_vars['val']['id']; ?>
"><?php echo $this->_tpl_vars['val']['key_name']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['val']['contents']['contents']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['config']['admin_config']['convert_type_name'][$this->_tpl_vars['val']['type']]; ?>
</td>
                        <td><?php echo $this->_tpl_vars['categoryList'][$this->_tpl_vars['val']['key_convert_list_category_id']]; ?>
</td>
                        <td><?php echo $this->_tpl_vars['val']['description']; ?>
</td>
                        <?php if ($this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SYSTEM']): ?><td><input type="checkbox" name="not_update[<?php echo $this->_tpl_vars['val']['id']; ?>
]" value="1" <?php if ($this->_tpl_vars['val']['is_not_update']): ?>checked<?php endif; ?>></td><?php endif; ?>
                        <?php if ($this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SYSTEM'] || ( $this->_tpl_vars['loginAdminData']['authority_type'] != $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SYSTEM'] && ! $this->_tpl_vars['val']['is_not_update'] )): ?>
                        <td><input type="checkbox" name="disable[<?php echo $this->_tpl_vars['val']['id']; ?>
]" value="1"></td>
                        <?php endif; ?>
                </tr>
            <?php endforeach; endif; unset($_from); ?>
        </table>
        <div class="SubMenu">
        <input type="submit" name="action_keyConvert_KeyConvertExec" value="更　新" onClick="return confirm('更新しますか？')" />
        </div>
    </form>
<?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admFooter'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
</body>
</html>