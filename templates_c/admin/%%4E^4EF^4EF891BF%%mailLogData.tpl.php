<?php /* Smarty version 2.6.26, created on 2014-08-10 12:03:58
         compiled from /home/suraimu/templates/admin/mailLog/mailLogData.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', '/home/suraimu/templates/admin/mailLog/mailLogData.tpl', 70, false),array('modifier', 'emoji', '/home/suraimu/templates/admin/mailLog/mailLogData.tpl', 119, false),array('modifier', 'nl2br', '/home/suraimu/templates/admin/mailLog/mailLogData.tpl', 127, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script language="JavaScript">
<!--

    $(function() {

                $(".tabs").tabs();

    });

// -->
</script>
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">配信履歴</h2>
<div>
<?php if ($this->_tpl_vars['logData']): ?>
            <table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet04">
            <tr><th colspan="2" style="text-align:center;">検索条件</th></tr>
            <?php $_from = $this->_tpl_vars['logData']['where_contents']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
?>
                <tr><th>
                <?php echo $this->_tpl_vars['key']; ?>

                </th>
                <td>
                <?php echo $this->_tpl_vars['val']; ?>

                </td></tr>
            <?php endforeach; endif; unset($_from); ?>
            </table>
    </div>
    <br>
    <div>
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" width="80%">
        <tr>
            <th>送信件数</th>
            <td >
            <table>
                <tr>
                    <td>
                        PC成功:<?php echo $this->_tpl_vars['logData']['send_total_count_pc']; ?>
件
                    </td>
                    <td>
                        MB成功:<?php echo $this->_tpl_vars['logData']['send_total_count_mb']; ?>
件
                    </td>
                </tr>
                <tr>
                    <td>
                        PC失敗:<?php echo $this->_tpl_vars['logData']['send_err_count_pc']; ?>
件
                    </td>
                    <td>
                        MB失敗:<?php echo $this->_tpl_vars['logData']['send_err_count_mb']; ?>
件
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        退会済み、ﾌﾞﾗｯｸ未送信:<?php echo $this->_tpl_vars['logData']['err_count']; ?>
件
                    </td>
                </tr>
                <tr>
                    <td>
                        PCのべアクセス数:<?php echo $this->_tpl_vars['logData']['access_count_pc']; ?>
件
                    </td>
                    <td>
                        MBのべアクセス数:<?php echo $this->_tpl_vars['logData']['access_count_mb']; ?>
件
                    </td>
                </tr>
                <tr>
                    <td>
                        PCアクセス率:<?php echo ((is_array($_tmp=@$this->_tpl_vars['logData']['pc_access_percent'])) ? $this->_run_mod_handler('default', true, $_tmp, "0.0") : smarty_modifier_default($_tmp, "0.0")); ?>
％
                    </td>
                    <td>
                        MBアクセス率:<?php echo ((is_array($_tmp=@$this->_tpl_vars['logData']['mb_access_percent'])) ? $this->_run_mod_handler('default', true, $_tmp, "0.0") : smarty_modifier_default($_tmp, "0.0")); ?>
％
                    </td>
                </tr>
            </table>
            </td>
        </tr>
        <tr>
            <th>インターバル</th>
            <td>
                <?php echo $this->_tpl_vars['intervalSecond'][$this->_tpl_vars['logData']['interval_second']]; ?>
分
            </td>
        </tr>
        <tr>
            <th>送信開始時間</th>
            <td>
                <?php echo $this->_tpl_vars['logData']['send_start_datetime']; ?>

            </td>
        </tr>
        <tr>
            <th>送信終了時間</th>
            <td>
                <?php echo $this->_tpl_vars['logData']['send_end_datetime']; ?>

            </td>
        </tr>
        <tr>
            <th>送信アドレス</th>
            <td>
                <?php echo $this->_tpl_vars['logData']['from_address']; ?>

            </td>
        </tr>
        <tr>
            <th>送信名</th>
            <td>
                <?php echo $this->_tpl_vars['logData']['from_name']; ?>

            </td>
        </tr>
        <th>送信タイプ</th>
        <td>
            <?php echo $this->_tpl_vars['mailReserveType'][$this->_tpl_vars['logData']['mail_reserve_type']]; ?>

        </td>
        </tr>
        <tr>
            <th>
                件名(PC)
            </th>
            <td>
                <?php echo ((is_array($_tmp=$this->_tpl_vars['logData']['pc_subject'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>

            </td>
        </tr>
        <tr>
            <th>
                TEXT本文(PC)
            </th>
            <td>
                <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['logData']['pc_text_body'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)))) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>

            </td>
        </tr>
        <tr>
            <th>
                HTML本文(PC)
            </th>
            <td>
                <div class="tabs">
                    <ul>
                        <li><a href="#pc-tabs-1">html</a></li>
                        <li><a href="#pc-tabs-2">view source</a></li>
                    </ul>
                    <iframe id="pc-tabs-1" src="./?action_MailLog_MailLogPreview=1&mlid=<?php echo $this->_tpl_vars['logData']['id']; ?>
&pc=1" height="500px"  width="95%"></iframe>
                    <div id="pc-tabs-2">
                        <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['logData']['pc_html_body'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)))) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>

                    </div>
                </div>
            </td>
        </tr>
        <?php if ($this->_tpl_vars['logData']['mb_html_body'] || $this->_tpl_vars['logData']['mb_text_body']): ?>
        <tr>
            <th>
                件名(MB)
            </th>
            <td>
                <?php echo ((is_array($_tmp=$this->_tpl_vars['logData']['mb_subject'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>

            </td>
        </tr>
        <tr>
            <th>
                TEXT本文(MB)
            </th>
            <td >
                <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['logData']['mb_text_body'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)))) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>

            </td>
        </tr>
        <tr>
            <th>
                HTML本文(MB)
            </th>
            <td>
                <div class="tabs">
                    <ul>
                        <li><a href="#mb-tabs-1">html</a></li>
                        <li><a href="#mb-tabs-2">view source</a></li>
                    </ul>
                    <iframe id="mb-tabs-1" src="./?action_MailLog_MailLogPreview=1&mlid=<?php echo $this->_tpl_vars['logData']['id']; ?>
" height="500px"  width="95%"></iframe>
                    <div id="mb-tabs-2">
                        <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['logData']['mb_html_body'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)))) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>

                    </div>
                </div>
            </td>
        </tr>
        <?php endif; ?>
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