<?php /* Smarty version 2.6.26, created on 2014-08-08 18:08:07
         compiled from /home/suraimu/templates/admin/mail/mailSendEnd.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/mail/mailSendEnd.tpl', 5, false),array('modifier', 'implode', '/home/suraimu/templates/admin/mail/mailSendEnd.tpl', 12, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</head>
<body>
<div id="ContentsCol">
<?php if (count($this->_tpl_vars['execMsg'])): ?>
<h2 class="ContentTitle">メルマガ：設定完了</h2>
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
<?php else: ?>
<h2 class="ContentTitle">メルマガ：送信完了</h2>
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
        <tr>
            <th>PC送信成功</th>
            <th>PC送信失敗</th>
            <th>MB送信成功</th>
            <th>MB送信失敗</th>
            <th>退会済み、ﾌﾞﾗｯｸ未送信</th>
        </tr>
        <tr>
            <td><?php echo $this->_tpl_vars['logData']['send_total_count_pc']; ?>
件</td>
            <td><?php echo $this->_tpl_vars['logData']['send_err_count_pc']; ?>
件</td>
            <td><?php echo $this->_tpl_vars['logData']['send_total_count_mb']; ?>
件</td>
            <td><?php echo $this->_tpl_vars['logData']['send_err_count_mb']; ?>
件</td>
            <td><?php echo $this->_tpl_vars['logData']['err_count']; ?>
件</td>
        </tr>
    </table>
<?php endif; ?>
<form action="./" method="post">
<?php echo $this->_tpl_vars['POSTparam']; ?>

<div class="SubMenu">
    <input type="submit" value="一覧へ戻る" name="action_user_List"/>
</div>
</form>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admFooter'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
</body>
</html>