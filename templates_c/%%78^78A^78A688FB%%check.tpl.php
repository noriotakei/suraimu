<?php /* Smarty version 2.6.26, created on 2010-03-15 15:39:50
         compiled from /home/suraimu/templates/admin/baitai/check.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', '/home/suraimu/templates/admin/baitai/check.tpl', 22, false),)), $this); ?>
<script language="JavaScript">
<!--
    $(function() {
                $("#table tr:even").addClass("BgColor02");
    });
// -->
</script>

<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th>広告コード</th>
        <th>サイト名</th>
        <th>アクセス数</th>
        <th>本登録者数</th>
        <th>入金額</th>
    </tr>
    <?php $_from = $this->_tpl_vars['dispDataList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
        $this->_foreach['loop']['iteration']++;
?>
    <tr>
        <td><?php echo $this->_tpl_vars['val']['media_cd']; ?>
</td>
        <td></td>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['val']['access_count'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</td>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['val']['regist_count'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</td>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['val']['trade_amount'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    <tr class="BgColor02">
        <td>合計</td>
        <td></td>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['totalData']['access_count'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</td>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['totalData']['regist_count'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</td>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['totalData']['trade_amount'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</td>
    </tr>
</table>
