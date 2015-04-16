<?php /* Smarty version 2.6.26, created on 2010-03-24 12:07:48
         compiled from /home/suraimu/templates/admin/baitai/remake.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'make_link', '/home/suraimu/templates/admin/baitai/remake.tpl', 21, false),array('modifier', 'count', '/home/suraimu/templates/admin/baitai/remake.tpl', 24, false),array('modifier', 'implode', '/home/suraimu/templates/admin/baitai/remake.tpl', 30, false),array('modifier', 'zend_date_format', '/home/suraimu/templates/admin/baitai/remake.tpl', 46, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admBaitaiHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<script language="JavaScript">
<!--

    $(function() {

                $(".datepicker").datepicker({
            dateFormat: "yy-mm-dd"
        });

    });

// -->
</script>
</head>
<body>
<div class="BlockCol">
    <h2 class="ContentTitle">媒体CHK再集計</h2>
    <p id="Logout"><a href="<?php echo smarty_function_make_link(array('action' => 'action_baitai_Logout','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="_top">Logout</a></p>
    <br>
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

        <table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet04">
            <tr>
                <th colspan="2" style="text-align: center; font-weight: bold;">集計条件</th>
            </tr>
            <tr>
                <th>日付</th>
                <td>
                    <input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['value']['date'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="date" maxlength="10">
                </td>
            </tr>
            <tr>
                <th>広告コード(任意)</th>
                <td>
                    <input type="text" id="media_cd" name="media_cd" value="<?php echo $this->_tpl_vars['value']['media_cd']; ?>
" size="20" style="ime-mode:disabled;">
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center">
                        <input type="submit" name="action_baitai_RemakeExec" value="再集計" OnClick="return confirm('再集計しますか？')">
                </td>
            </tr>
        </table>
    </form>
    <br>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admFooter'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
</body>
</html>