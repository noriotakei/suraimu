<?php /* Smarty version 2.6.26, created on 2011-07-05 17:48:13
         compiled from /home/suraimu/templates/baitaiAdmin/agency/preMonthly.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', '/home/suraimu/templates/baitaiAdmin/agency/preMonthly.tpl', 47, false),)), $this); ?>
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

<table cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td valign="top">
            <span style="color:#00F;font-size:24px;">仮登録者数</span>
        </td>
    </tr>
</table>
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th rowspan="2"><b>広告コード</b></th>
        <th colspan="<?php echo $this->_tpl_vars['dispMonthlyRegistCount']; ?>
"><center><b>仮登録月</b></center></th>
        <th rowspan="2"><b>媒体別仮登録数合計</b></th>
    </tr>
    <tr>
        <?php $_from = $this->_tpl_vars['dispMonthlyRegist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
        $this->_foreach['loop']['iteration']++;
?>
            <th><b><?php echo $this->_tpl_vars['val']; ?>
</b></th>
        <?php endforeach; endif; unset($_from); ?>
    </tr>
    <?php $_from = $this->_tpl_vars['baitaiRegistCountList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['baitaiName'] => $this->_tpl_vars['list']):
        $this->_foreach['loop']['iteration']++;
?>
    <tr>
        <td><?php echo $this->_tpl_vars['baitaiName']; ?>
</td>
        <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['registMonth'] => $this->_tpl_vars['regist']):
        $this->_foreach['loop']['iteration']++;
?>
            <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['regist'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
人</td>
        <?php endforeach; endif; unset($_from); ?>
        <td><?php echo $this->_tpl_vars['registTotalForMediaCd'][$this->_tpl_vars['baitaiName']]; ?>
人</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    <tr class="BgColor02">
        <td><b>月間合計</b></td>
        <?php $_from = $this->_tpl_vars['registTotalForMonthly']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['registonthly'] => $this->_tpl_vars['registTotal']):
        $this->_foreach['loop']['iteration']++;
?>
            <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['registTotal'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
人</td>
        <?php endforeach; endif; unset($_from); ?>
        <td><?php echo $this->_tpl_vars['registAllTotal']; ?>
人</td>
    </tr>
</table>
<br>
<table cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td valign="top">
            <span style="color:#00F;font-size:24px;">アクセス数</span>
        </td>
    </tr>
</table>
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th rowspan="2"><b>広告コード</b></th>
        <th colspan="<?php echo $this->_tpl_vars['dispMonthlyAccessCount']; ?>
"><center><b>仮登録月毎のアクセス数</b></center></th>
        <th rowspan="2"><b>媒体別アクセス数合計</b></th>
    </tr>
    <tr>
        <?php $_from = $this->_tpl_vars['dispMonthlyAccess']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
        $this->_foreach['loop']['iteration']++;
?>
            <th><b><?php echo $this->_tpl_vars['val']; ?>
</b></th>
        <?php endforeach; endif; unset($_from); ?>
    </tr>
    <?php $_from = $this->_tpl_vars['baitaiAccessCountList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['baitaiName'] => $this->_tpl_vars['list']):
        $this->_foreach['loop']['iteration']++;
?>
    <tr>
        <td><?php echo $this->_tpl_vars['baitaiName']; ?>
</td>
        <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['access']):
        $this->_foreach['loop']['iteration']++;
?>
            <td><?php echo $this->_tpl_vars['access']; ?>
</td>
        <?php endforeach; endif; unset($_from); ?>
        <td><?php echo $this->_tpl_vars['accessTotalForMediaCd'][$this->_tpl_vars['baitaiName']]; ?>
回</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    <tr class="BgColor02">
        <td><b>月間合計</b></td>
        <?php $_from = $this->_tpl_vars['accessTotalForMonthly']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['accessTotal']):
        $this->_foreach['loop']['iteration']++;
?>
            <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['accessTotal'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
回</td>
        <?php endforeach; endif; unset($_from); ?>
        <td><?php echo $this->_tpl_vars['accessAllTotal']; ?>
回</td>
    </tr>
</table>