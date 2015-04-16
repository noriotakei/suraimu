<?php /* Smarty version 2.6.26, created on 2015-04-05 17:08:00
         compiled from /home/suraimu/templates/admin/ordering/supportMailData.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/ordering/supportMailData.tpl', 7, false),array('modifier', 'implode', '/home/suraimu/templates/admin/ordering/supportMailData.tpl', 13, false),array('modifier', 'default', '/home/suraimu/templates/admin/ordering/supportMailData.tpl', 53, false),array('function', 'make_link', '/home/suraimu/templates/admin/ordering/supportMailData.tpl', 25, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</head>
<body>
<div class="BlockCol">
    <h2 class="ContentTitle">サポートメール定型文作成</h2>
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
        <input type="submit" name="action_ordering_SupportMailList" value="一覧へ戻る" style="width:8em;"/>
    </form>
    <br>
    <div>
        <a href="<?php echo smarty_function_make_link(array('action' => 'action_keyConvert_DispKeyConvertList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="_blank">システム変換管理</a>
    </div>
    <br>
    <?php if ($this->_tpl_vars['supportMailData']['id']): ?>
    <div>
        <form action="./" method="post">
            <?php echo $this->_tpl_vars['POSTparam']; ?>

            <input type="hidden" name="disable" value="1">
            <input type="submit" name="action_ordering_SupportMailDataExec" value="削 除" OnClick="return confirm('削除しますか？')" style="width:8em;"/>
        </form>
    </div>
    <br>
    <?php endif; ?>
    <form action="./" method="post">
        <?php echo $this->_tpl_vars['POSTparam']; ?>

        <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">
            <tr>
                <th colspan="2" style="text-align:center;">サポートメール定型文作成</th>
            </tr>
            <tr>
                <th>定型文名</th>
                <td style="text-align: left;">
                    <input type="text" name="name" value="<?php echo $this->_tpl_vars['supportMailData']['name']; ?>
" size="20">
                </td>
            </tr>
            <tr>
                <th>優先順位</th>
                <td style="text-align: left;">
                    <input type="text" name="sort_seq" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['supportMailData']['sort_seq'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
" size="3" style="ime-mode: disabled;">
                </td>
            </tr>
            <tr>
                <th>PC件名</th>
                <td style="text-align: left;">
                    <input type="text" name="pc_subject" value="<?php echo $this->_tpl_vars['supportMailData']['pc_subject']; ?>
" size="50">
                </td>
            </tr>
            <tr>
                <th>PCTEXT本文</th>
                <td style="text-align: left;">
                    <textarea name="pc_text_body" cols="100" rows="30" id="pc_text_body" wrap="off"><?php echo $this->_tpl_vars['supportMailData']['pc_text_body']; ?>
</textarea>
                </td>
            </tr>
            <tr>
                <th>MB件名</th>
                <td style="text-align: left;">
                    <input type="text" name="mb_subject" value="<?php echo $this->_tpl_vars['supportMailData']['mb_subject']; ?>
" size="50">
                </td>
            </tr>
            <tr>
                <th>MBTEXT本文</th>
                <td style="text-align: left;">
                    <textarea name="mb_text_body" cols="100" rows="30" id="mb_text_body" wrap="off"><?php echo $this->_tpl_vars['supportMailData']['mb_text_body']; ?>
</textarea>
                </td>
            </tr>
            <tr>
                <td style="text-align:center;" colspan="2">
                    <?php if ($this->_tpl_vars['supportMailData']['id']): ?>
                        <input type="submit" name="action_ordering_SupportMailDataExec" value="更 新" OnClick="return confirm('更新しますか？')" style="width:8em;"/>
                    <?php else: ?>
                        <input type="submit" name="action_ordering_SupportMailDataExec" value="登 録" OnClick="return confirm('登録しますか？')" style="width:8em;"/>
                    <?php endif; ?>
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