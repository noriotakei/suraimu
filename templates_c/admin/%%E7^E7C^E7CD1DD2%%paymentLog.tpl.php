<?php /* Smarty version 2.6.26, created on 2014-08-08 18:40:09
         compiled from /home/suraimu/templates/admin/log/paymentLog.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'make_link', '/home/suraimu/templates/admin/log/paymentLog.tpl', 26, false),array('modifier', 'cat', '/home/suraimu/templates/admin/log/paymentLog.tpl', 26, false),array('modifier', 'number_format', '/home/suraimu/templates/admin/log/paymentLog.tpl', 28, false),)), $this); ?>
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
<h2 class="ContentTitle">入金ログリスト</h2>
<table cellspacing="0" cellpadding="0" class="TableSet01" id="table" align="center">
    <tr>
        <th>注文ID</th>
        <th>支払方法</th>
        <th>金額</th>
        <th>キャンセル</th>
        <th>手動入金</th>
        <th>入金日時</th>
    </tr>
    <?php $_from = $this->_tpl_vars['dataList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
        $this->_foreach['loop']['iteration']++;
?>
    <tr>
        <td><a href="<?php echo smarty_function_make_link(array('action' => 'action_ordering_OrderingData','getTags' => ((is_array($_tmp="ordering_id=")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['val']['ordering_id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['val']['ordering_id']))), $this);?>
" target="_blank"><?php echo $this->_tpl_vars['val']['ordering_id']; ?>
</a></td>
        <td><?php echo $this->_tpl_vars['payType'][$this->_tpl_vars['val']['pay_type']]; ?>
</td>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['val']['receive_money'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
円</td>
        <td><?php if ($this->_tpl_vars['val']['is_cancel']): ?>キャンセル<?php endif; ?></td>
        <td><?php if ($this->_tpl_vars['val']['is_manual']): ?>手動入金<?php endif; ?></td>
        <td><?php echo $this->_tpl_vars['val']['create_datetime']; ?>
</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>
