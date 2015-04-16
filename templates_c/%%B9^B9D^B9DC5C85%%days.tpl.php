<?php /* Smarty version 2.6.26, created on 2012-10-15 11:45:47
         compiled from /home/suraimu/templates/baitaiAdmin/agency/days.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', '/home/suraimu/templates/baitaiAdmin/agency/days.tpl', 58, false),)), $this); ?>
<script language="JavaScript">
<!--
    $(function() {
                $("#table tr:even").addClass("BgColor02");
    });
// -->
</script>


<?php if ($this->_tpl_vars['errMsg']): ?>
    <div class="warning ui-widget">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    <p>
    <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    <?php echo $this->_tpl_vars['errMsg']; ?>

    </p>
    </div>
    </div>
<?php endif; ?>
<table cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td>
            <span style="color:#FF0000;font-size:20px;"><b><?php echo $this->_tpl_vars['title']; ?>
</b></span>
        </td>
        <td>&nbsp;&nbsp;</td>
    </tr>
</table>
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th>媒体名</th>
        <th>広告コード</th>
        <th>仮登録者数</th>
        <th>本登録者数</th>
        <th>退会者数</th>
        <th>入金額</th>
        <th>入金者数</th>
        <th>アクセス数</th>
    </tr>
    <?php if ($this->_tpl_vars['totalCountList']): ?>
    <?php $_from = $this->_tpl_vars['totalCountList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
        $this->_foreach['loop']['iteration']++;
?>
    <tr>
        <td><?php echo $this->_tpl_vars['val']['media_name']; ?>
</td>
        <td><?php echo $this->_tpl_vars['key']; ?>
</td>
        <td><?php echo $this->_tpl_vars['val']['pre_regist_count']; ?>
</td>
        <td><?php echo $this->_tpl_vars['val']['regist_count']; ?>
</td>
        <td><?php echo $this->_tpl_vars['val']['quit_count']; ?>
</td>
        <td><?php echo $this->_tpl_vars['val']['trade_amount']; ?>
</td>
        <td><?php echo $this->_tpl_vars['val']['trade_user_count']; ?>
</td>
        <td><?php echo $this->_tpl_vars['val']['access_count']; ?>
</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    <?php endif; ?>
    <tr class="BgColor02">
        <td colspan="2"><center><b>合計</b></center></td>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['preRegistTotalForMediaCd']['pre_regist_count'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
人</td>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['registTotalForMediaCd']['regist_count'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
人</td>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['quitTotalForMediaCd']['quit_count'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
人</td>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['payTotalForMediaCd']['trade_amount'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
円</td>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['payUserTotalForMediaCd']['trade_user_count'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
人</td>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['accessTotalForMediaCd']['access_count'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
回</td>
    </tr>
</table>