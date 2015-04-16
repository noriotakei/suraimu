<?php /* Smarty version 2.6.26, created on 2015-01-22 12:11:19
         compiled from /home/suraimu/templates/admin/ordering/supportMailList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/ordering/supportMailList.tpl', 7, false),array('modifier', 'implode', '/home/suraimu/templates/admin/ordering/supportMailList.tpl', 13, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">サポートメール一覧</h2>
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
<form action="./" method="post">
    <input type="submit" name="action_ordering_SupportMailData" value="追 加" style="width:8em;"/>
</form>
<br>
<?php if ($this->_tpl_vars['supportMailList']): ?>
    <table>
        <tr>
            <?php $_from = $this->_tpl_vars['supportMailList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['dataLoop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['dataLoop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
        $this->_foreach['dataLoop']['iteration']++;
?>
                <td style="padding:5px">
                    <form action="./" method="POST">
                        <input type="submit" name="action_ordering_SupportMailData" value="<?php echo $this->_tpl_vars['val']['name']; ?>
" style="width:15em;">
                        <input type="hidden" name="support_mail_id" value="<?php echo $this->_tpl_vars['val']['id']; ?>
">
                    </form>
                </td>
                <?php if ($this->_foreach['dataLoop']['iteration'] % 5 == 0): ?>
                    </tr><tr>
                <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>
        </tr>
    </table>
<?php else: ?>
    <div class="warning ui-widget">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    <p>
    <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    該当データはありません
    </p>
    </div>
<?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admFooter'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
</body>
</html>