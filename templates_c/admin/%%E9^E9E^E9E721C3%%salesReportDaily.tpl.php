<?php /* Smarty version 2.6.26, created on 2014-08-08 16:54:49
         compiled from /home/suraimu/templates/admin/count/salesReportDaily.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'zend_date_format', '/home/suraimu/templates/admin/count/salesReportDaily.tpl', 19, false),array('modifier', 'default', '/home/suraimu/templates/admin/count/salesReportDaily.tpl', 23, false),array('modifier', 'number_format', '/home/suraimu/templates/admin/count/salesReportDaily.tpl', 25, false),array('function', 'cycle', '/home/suraimu/templates/admin/count/salesReportDaily.tpl', 20, false),)), $this); ?>
<h2 class="ContentTitle">売り上げ(日毎)</h2>
<table cellspacing="0" cellpadding="0" class="TableSet02" id="table" align="center">
    <tr>
        <th rowspan="2">日付</th>
        <th>注文件数</th>
        <th rowspan="2">注文者数<br>(本登録｜会員解除)</th>
        <th rowspan="2">注文単価</th>
        <th rowspan="2">購入者数<br>(本登録｜会員解除)</th>
        <th rowspan="2">客単価</th>
        <th rowspan="2">売上</th>
        <?php $_from = $this->_tpl_vars['payType']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['payTypeLoop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['payTypeLoop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['payTypeVal']):
        $this->_foreach['payTypeLoop']['iteration']++;
?>
            <th rowspan="2">売上<br>(<?php echo $this->_tpl_vars['payTypeVal']; ?>
)</th>
        <?php endforeach; endif; unset($_from); ?>
    </tr>
    <tr>
        <th>注文金額</th>
    </tr>
    <?php $_from = $this->_tpl_vars['dispDataList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
        $this->_foreach['loop']['iteration']++;
?>
    <?php $this->assign('weekNum', ((is_array($_tmp=$this->_tpl_vars['key'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'e') : smarty_modifier_zend_date_format($_tmp, 'e'))); ?>
    <?php echo smarty_function_cycle(array('values' => ", class=\"BgColor02\"",'assign' => 'style'), $this);?>

    <tr <?php echo $this->_tpl_vars['style']; ?>
>
        <td rowspan="2"><?php echo ((is_array($_tmp=$this->_tpl_vars['key'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy年MM月dd日') : smarty_modifier_zend_date_format($_tmp, 'yyyy年MM月dd日')); ?>
(<?php echo $this->_tpl_vars['weekArray'][$this->_tpl_vars['weekNum']]; ?>
)</td>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['val']['order_cnt'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
件</td>
        <td rowspan="2"><?php echo ((is_array($_tmp=@$this->_tpl_vars['val']['user'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
人｜<?php echo ((is_array($_tmp=@$this->_tpl_vars['val']['quit_user'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
人</td>
        <td rowspan="2"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['val']['user_price'])) ? $this->_run_mod_handler('number_format', true, $_tmp, '0') : number_format($_tmp, '0')))) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
円</td>
        <td rowspan="2"><?php echo ((is_array($_tmp=@$this->_tpl_vars['val']['sales_user'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
人｜<?php echo ((is_array($_tmp=@$this->_tpl_vars['val']['sales_quit_user'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
人</td>
        <td rowspan="2"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['val']['sales_user_price'])) ? $this->_run_mod_handler('number_format', true, $_tmp, '0') : number_format($_tmp, '0')))) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
円</td>
        <td rowspan="2"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['val']['pay_total'])) ? $this->_run_mod_handler('number_format', true, $_tmp, '0') : number_format($_tmp, '0')))) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
円</td>
        <?php $_from = $this->_tpl_vars['payType']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['payTypeLoop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['payTypeLoop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['payTypeKey'] => $this->_tpl_vars['payTypeVal']):
        $this->_foreach['payTypeLoop']['iteration']++;
?>
            <td rowspan="2"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['val'][$this->_tpl_vars['payTypeKey']])) ? $this->_run_mod_handler('number_format', true, $_tmp, '0') : number_format($_tmp, '0')))) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
円</td>
        <?php endforeach; endif; unset($_from); ?>

    </tr>
    <tr <?php echo $this->_tpl_vars['style']; ?>
>
        <td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['val']['ordering_pay_total'])) ? $this->_run_mod_handler('number_format', true, $_tmp, '0') : number_format($_tmp, '0')))) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
円</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>
<br><br><br>