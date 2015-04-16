<?php /* Smarty version 2.6.26, created on 2014-09-22 11:02:55
         compiled from /home/suraimu/templates/admin/adminUser/adminUserList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/adminUser/adminUserList.tpl', 29, false),array('modifier', 'implode', '/home/suraimu/templates/admin/adminUser/adminUserList.tpl', 35, false),array('modifier', 'cat', '/home/suraimu/templates/admin/adminUser/adminUserList.tpl', 53, false),array('function', 'make_link', '/home/suraimu/templates/admin/adminUser/adminUserList.tpl', 53, false),array('function', 'html_options', '/home/suraimu/templates/admin/adminUser/adminUserList.tpl', 107, false),array('function', 'html_checkboxes', '/home/suraimu/templates/admin/adminUser/adminUserList.tpl', 115, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script language="JavaScript">
<!--

    $(function() {
        // テーブルマウスオーバーカラー
        $('#list_table').colorize({
            altColor :'#CCCCCC',
            hiliteColor :'none'
        });

        if (!<?php echo $this->_tpl_vars['param']['return_flag']; ?>
) {
            $("#add_form").hide();
        }
        $('#add_button').live("click", function(env){
            if (env.button !== 0) return;
            $("#add_form").toggle("clip", null, "slow");
        });
    });

// -->
</script>
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">管理者一覧</h2>
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
<?php endif; ?>
<br>
<?php if ($this->_tpl_vars['adminList']): ?>

    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">

    <tr>
    <th nowrap="nowrap">ログインID</th>
    <th nowrap="nowrap">名前</th>
    <th>権限</th>
    </tr>
    <?php $_from = $this->_tpl_vars['adminList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
        <tr>
        <td><a href="<?php echo smarty_function_make_link(array('action' => 'action_adminUser_AdminUserUpd','getTags' => ((is_array($_tmp="id=")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['val']['id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['val']['id']))), $this);?>
"><?php echo $this->_tpl_vars['val']['login_id']; ?>
</a></td>
        <td><?php echo $this->_tpl_vars['val']['name']; ?>
</td>
        <td><?php echo $this->_tpl_vars['config']['admin_config']['authority_type'][$this->_tpl_vars['val']['authority_type']]; ?>
</td>
        </tr>
    <?php endforeach; endif; unset($_from); ?>
    </table>

<?php endif; ?>

<div class="SubMenu">
    <input type="button" id="add_button" value="追　加" />
</div>

<div id="add_form" style="display:none;">
<form action="./" method="POST">
    <?php echo $this->_tpl_vars['POSTparam']; ?>

    <table class="TableSet04">
        <tr>
            <th>
                名前：
            </th>
            <td>
                <input type="text" name="name" value="<?php echo $this->_tpl_vars['param']['name']; ?>
">
            </td>
        </tr>
        <tr>
            <th>
                ログインID：
            </th>
            <td>
                <input type="text" name="login_id" value="<?php echo $this->_tpl_vars['param']['login_id']; ?>
">
            </td>
        </tr>
        <tr>
            <th>
                パスワード：
            </th>
            <td>
                <input type="text" name="password" value="<?php echo $this->_tpl_vars['param']['password']; ?>
" style="ime-mode:disabled">
            </td>
        </tr>
        <tr>
            <th>
                メールアドレス：
            </th>
            <td>
                <input type="text" name="send_mail_address" value="<?php echo $this->_tpl_vars['param']['send_mail_address']; ?>
" style="ime-mode:disabled">
            </td>
        </tr>
        <tr>
            <th>
                管理区分：
            </th>
            <td>
                <?php echo smarty_function_html_options(array('name' => 'authority_type','options' => $this->_tpl_vars['config']['admin_config']['authority_type'],'selected' => $this->_tpl_vars['param']['authority_type']), $this);?>

            </td>
        </tr>
        <tr>
            <th>
                自動更新：
            </th>
            <td>
                <?php echo smarty_function_html_checkboxes(array('name' => 'auto_update_flag','options' => $this->_tpl_vars['autoUpdateFlag'],'selected' => $this->_tpl_vars['param']['auto_update_flag']), $this);?>

            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">
                <input type="submit" value="登　録" name="action_adminUser_AdminUserRegExec" onClick="return confirm('登録しますか？')">
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