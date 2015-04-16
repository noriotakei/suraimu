<?php /* Smarty version 2.6.26, created on 2014-09-07 13:05:20
         compiled from /home/suraimu/templates/admin/autoMail/autoMailSettingList.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">リメール設定一覧</h2>
<?php if ($this->_tpl_vars['dataList']): ?>
    <table>
        <tr>
            <?php $_from = $this->_tpl_vars['dataList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['dataLoop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['dataLoop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
        $this->_foreach['dataLoop']['iteration']++;
?>
                <td style="padding:5px">
                    <form action="./" method="POST">
                        <input type="submit" name="action_autoMail_AutoMailSettingData" value="【<?php echo $this->_tpl_vars['isUse'][$this->_tpl_vars['val']['is_use']]; ?>
】 <?php echo $this->_tpl_vars['val']['name']; ?>
" style="<?php if (! $this->_tpl_vars['val']['is_use']): ?>background-color:red;<?php endif; ?>">
                        <input type="hidden" name="auto_mail_contents_id" value="<?php echo $this->_tpl_vars['val']['id']; ?>
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