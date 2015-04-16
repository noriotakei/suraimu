<?php /* Smarty version 2.6.26, created on 2014-09-22 11:03:02
         compiled from /home/suraimu/templates/admin/adminUser/adminUserUpd.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/adminUser/adminUserUpd.tpl', 7, false),array('modifier', 'implode', '/home/suraimu/templates/admin/adminUser/adminUserUpd.tpl', 13, false),array('function', 'html_options', '/home/suraimu/templates/admin/adminUser/adminUserUpd.tpl', 63, false),array('function', 'html_checkboxes', '/home/suraimu/templates/admin/adminUser/adminUserUpd.tpl', 71, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">管理ユーザー作成</h2>
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
<form action="./" method="post">
    <input type="submit" name="action_adminUser_AdminUserList" value="一覧へ戻る" style="width:8em;"/>
</form>
<br>
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
                <input type="text" name="password" value="" style="ime-mode:disabled">
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
        <?php if ($this->_tpl_vars['param']['id'] != $this->_tpl_vars['loginAdminData']['id']): ?>
        <tr>
            <th>
                削除：
            </th>
            <td>
                <?php echo smarty_function_html_checkboxes(array('name' => 'disable','options' => $this->_tpl_vars['disable'],'selected' => $this->_tpl_vars['param']['disable']), $this);?>

            </td>
        </tr>
        <?php endif; ?>
        <tr>
            <td colspan="2" style="text-align:center;">
                <input type="submit" value="更　新" name="action_adminUser_AdminUserRegExec" onClick="return confirm('更新しますか？')">
            </td>
        </tr>

    </table>

</form>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admFooter'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
</body>
</html>