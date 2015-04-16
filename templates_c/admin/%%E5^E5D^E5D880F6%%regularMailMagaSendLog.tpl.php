<?php /* Smarty version 2.6.26, created on 2014-10-08 10:38:36
         compiled from /home/suraimu/templates/admin/log/regularMailMagaSendLog.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'make_link', '/home/suraimu/templates/admin/log/regularMailMagaSendLog.tpl', 23, false),array('modifier', 'cat', '/home/suraimu/templates/admin/log/regularMailMagaSendLog.tpl', 23, false),)), $this); ?>
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script language="JavaScript">
<!--
    $(function() {
                $('#table').colorize({
            altColor :'#E5E5E5',
            hiliteColor :'none'
        });

    });
// -->
</script>
<h2 class="ContentTitle">定期送信メルマガログ</h2>
<table cellspacing="0" cellpadding="0" class="TableSet01" id="table" align="center">
    <tr>
        <th>メルマガログID</th>
        <th>送信開始時間</th>
        <th>送信終了時間</th>
    </tr>
    <?php $_from = $this->_tpl_vars['dataList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
        $this->_foreach['loop']['iteration']++;
?>
    <tr>
        <td><a href="<?php echo smarty_function_make_link(array('action' => 'action_mailLog_MailLogData','getTags' => ((is_array($_tmp="mail_maga_id=")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['val']['mailmagazine_log_id_regular']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['val']['mailmagazine_log_id_regular']))), $this);?>
" target="_blank"><?php echo $this->_tpl_vars['val']['mailmagazine_log_id_regular']; ?>
</a></td>
        <td><?php echo $this->_tpl_vars['val']['send_start_datetime']; ?>
</td>
        <td><?php echo $this->_tpl_vars['val']['send_end_datetime']; ?>
</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>
