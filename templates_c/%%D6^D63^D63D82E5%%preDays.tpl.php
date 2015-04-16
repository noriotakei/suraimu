<?php /* Smarty version 2.6.26, created on 2011-07-05 17:48:14
         compiled from /home/suraimu/templates/baitaiAdmin/agency/preDays.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', '/home/suraimu/templates/baitaiAdmin/agency/preDays.tpl', 33, false),)), $this); ?>
<script language="JavaScript">
<!--
    $(function() {
                $("#table tr:even").addClass("BgColor02");
    });
// -->
</script>

<h2 class="ContentTitle"><font color="red"><?php echo $this->_tpl_vars['registTitle']; ?>
&nbsp;<?php echo $this->_tpl_vars['payTitle']; ?>
</font></h2>


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
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th>広告コード</th>
        <th>仮登録者数</th>
        <th>アクセス数</th>
    </tr>
    <?php $_from = $this->_tpl_vars['resultBaitaiList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['val']):
        $this->_foreach['loop']['iteration']++;
?>
    <tr>
        <td><?php echo $this->_tpl_vars['val']['media_cd']; ?>
</td>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['val']['pre_regist_count'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
人</td>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['val']['total_access_count'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
回</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    <tr class="BgColor02">
        <td><b>合計</b></td>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['registTotalForMediaCd']['pre_regist_count'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
人</td>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['accessTotalForMediaCd']['total_access_count'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
回</td>
    </tr>
</table>