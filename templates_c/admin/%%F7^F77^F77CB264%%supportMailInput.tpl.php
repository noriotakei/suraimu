<?php /* Smarty version 2.6.26, created on 2014-08-08 16:45:07
         compiled from /home/suraimu/templates/admin/ordering/supportMailInput.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/ordering/supportMailInput.tpl', 7, false),array('modifier', 'implode', '/home/suraimu/templates/admin/ordering/supportMailInput.tpl', 13, false),array('modifier', 'default', '/home/suraimu/templates/admin/ordering/supportMailInput.tpl', 47, false),array('modifier', 'in_array', '/home/suraimu/templates/admin/ordering/supportMailInput.tpl', 60, false),array('function', 'make_link', '/home/suraimu/templates/admin/ordering/supportMailInput.tpl', 27, false),array('function', 'html_options', '/home/suraimu/templates/admin/ordering/supportMailInput.tpl', 33, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</head>
<body>
<div class="BlockCol">
    <h2 class="ContentTitle">サポートメール作成</h2>
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
        <?php echo $this->_tpl_vars['POSTparam']; ?>

        <input type="submit" name="action_ordering_OrderingData" value="注文詳細へ戻る" style="width:8em;"/>
    </form>
    <br>
    <?php if ($this->_tpl_vars['mailElements']): ?>
        <div>
            <a href="<?php echo smarty_function_make_link(array('action' => 'action_keyConvert_DispKeyConvertList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="_blank">システム変換管理</a>
        </div>
        <?php if ($this->_tpl_vars['supportMailList']): ?>
            <br>
            <form action="./" method="post">
                <?php echo $this->_tpl_vars['POSTparam']; ?>

                <?php echo smarty_function_html_options(array('name' => 'support_mail_id','options' => $this->_tpl_vars['supportMailList']), $this);?>

                <input type="submit" name="action_ordering_SupportMailInput" value="サポートメール定型文を呼び出す"/>
            </form>
        <?php endif; ?>
        <form action="./" method="post">
            <?php echo $this->_tpl_vars['POSTparam']; ?>

            <br><br>
            <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">
                <tr>
                    <th colspan="2" style="text-align:center;">サポートメール作成</th>
                </tr>
                <tr>
                    <th>送信元アドレス</th>
                    <td style="text-align: left;">
                        <input type="text" name="from_address" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['mailElements']['from_address'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['sendAddress']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['sendAddress'])); ?>
" size="50" style="ime-mode: disabled;">
                    </td>
                </tr>
                <tr>
                    <th>送信者名</th>
                    <td style="text-align: left;">
                        <input type="text" name="from_name" value="<?php echo $this->_tpl_vars['mailElements']['from_name']; ?>
" size="50">
                        <br><span style="color:#FF0000;">※iPhoneに送信する場合、「&lt;&gt;」、「【】」、「≪≫」、「半角カタカナ」を含むと送信者名が「不明」または「文字化け」の原因になります。
                    </td>
                </tr>
                <tr>
                    <th>送信先アドレス</th>
                    <td style="text-align: left;">
                        <?php if (((is_array($_tmp='pc_address')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
                        PC:<?php echo $this->_tpl_vars['userData']['pc_address']; ?>

                        <?php endif; ?>
                        <?php if (((is_array($_tmp='pc_address_no_domain')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
                        PC(ドメインなし):<?php echo $this->_tpl_vars['userData']['pc_address_no_domain']; ?>

                        <?php endif; ?>
                        <br>
                        <?php if (((is_array($_tmp='mb_address')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
                        MB:<?php echo $this->_tpl_vars['userData']['mb_address']; ?>

                        <?php endif; ?>
                        <?php if (((is_array($_tmp='mb_address_no_domain')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
                        MB(ドメインなし):<?php echo $this->_tpl_vars['userData']['mb_address_no_domain']; ?>

                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>PC件名</th>
                    <td style="text-align: left;">
                        <input type="text" name="pc_subject" value="<?php echo $this->_tpl_vars['mailElements']['pc_subject']; ?>
" size="50">
                    </td>
                </tr>
                <tr>
                    <th>PCTEXT本文</th>
                    <td style="text-align: left;">
                        <textarea name="pc_text_body" cols="100" rows="30" id="pc_text_body" wrap="off"><?php echo $this->_tpl_vars['mailElements']['pc_text_body']; ?>
</textarea>
                    </td>
                </tr>
                <tr>
                    <th>MB件名</th>
                    <td style="text-align: left;">
                        <input type="text" name="mb_subject" value="<?php echo $this->_tpl_vars['mailElements']['mb_subject']; ?>
" size="50">
                    </td>
                </tr>
                <tr>
                    <th>MBTEXT本文</th>
                    <td style="text-align: left;">
                        <textarea name="mb_text_body" cols="100" rows="30" id="mb_text_body" wrap="off"><?php echo $this->_tpl_vars['mailElements']['mb_text_body']; ?>
</textarea>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center;" colspan="2">
                        <input type="submit" id="submit" name="action_ordering_SupportMailSendExec" value="送 信"  onclick="return confirm('送信しますか？')" style="width:8em; margin-left: 30px;"/>
                                            </td>
                </tr>
            </table>
        </form>
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