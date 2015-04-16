<?php /* Smarty version 2.6.26, created on 2012-10-15 11:12:31
         compiled from /home/suraimu/templates/baitaiAdmin/agency/monthly.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', '/home/suraimu/templates/baitaiAdmin/agency/monthly.tpl', 52, false),)), $this); ?>
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
            <span style="color:#FF0000;font-size:20px;"><b><?php echo $this->_tpl_vars['accessTitle']; ?>
</b></span><br>
        </td>
    </tr>
    <tr>
        <td align="center">
            <span style="color:#00F;font-size:24px;">アクセス数</span>
        </td>
    </tr>
</table>
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th rowspan="2"><b>媒体名</b></th>
        <th rowspan="2"><b>広告コード</b></th>
        <th colspan="<?php echo $this->_tpl_vars['dispMonthlyAccessCount']; ?>
"><center><b>本登録月毎のアクセス数</b></center></th>
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
        <td><?php echo $this->_tpl_vars['mediaCdNameList'][$this->_tpl_vars['baitaiName']]; ?>
</td>
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
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['accessTotalForMediaCd'][$this->_tpl_vars['baitaiName']])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
回</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    <tr class="BgColor02">
        <td colspan="2"><b>月間合計</b></td>
        <?php $_from = $this->_tpl_vars['accessTotalForMonthly']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['accessTotal']):
        $this->_foreach['loop']['iteration']++;
?>
            <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['accessTotal'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
回</td>
        <?php endforeach; endif; unset($_from); ?>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['accessAllTotal'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
回</td>
    </tr>
</table>

<br>

<table cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td>
            <span style="color:#FF0000;font-size:20px;"><b><?php echo $this->_tpl_vars['preRegistTitle']; ?>
</b></span>
        </td>
    </tr>
    <tr>
        <td align="center">
            <span style="color:#00F;font-size:24px;">仮登録者数</span>
        </td>
    </tr>
</table>
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th rowspan="2"><b>媒体名</b></th>
        <th rowspan="2"><b>広告コード</b></th>
        <th colspan="<?php echo $this->_tpl_vars['dispMonthlyPreRegistCount']; ?>
"><center><b>仮登録月</b></center></th>
        <th rowspan="2"><b>媒体別登録数合計</b></th>
    </tr>
    <tr>
        <?php $_from = $this->_tpl_vars['dispMonthlyPreRegist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
        $this->_foreach['loop']['iteration']++;
?>
            <th><b><?php echo $this->_tpl_vars['val']; ?>
</b></th>
        <?php endforeach; endif; unset($_from); ?>
    </tr>
    <?php $_from = $this->_tpl_vars['baitaiPreRegistCountList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['baitaiName'] => $this->_tpl_vars['list']):
        $this->_foreach['loop']['iteration']++;
?>
    <tr>
        <td><?php echo $this->_tpl_vars['mediaCdNameList'][$this->_tpl_vars['baitaiName']]; ?>
</td>
        <td><?php echo $this->_tpl_vars['baitaiName']; ?>
</td>
        <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['preRegistMonth'] => $this->_tpl_vars['preRegist']):
        $this->_foreach['loop']['iteration']++;
?>
            <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['preRegist'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</td>
        <?php endforeach; endif; unset($_from); ?>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['preRegistTotalForMediaCd'][$this->_tpl_vars['baitaiName']])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
人</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    <tr class="BgColor02">
        <td colspan="2"><b>月間合計</b></td>
        <?php $_from = $this->_tpl_vars['preRegistTotalForMonthly']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['preRegistMonthly'] => $this->_tpl_vars['preRegistTotal']):
        $this->_foreach['loop']['iteration']++;
?>
            <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['preRegistTotal'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
人</td>
        <?php endforeach; endif; unset($_from); ?>
        <td><?php echo $this->_tpl_vars['preRegistAllTotal']; ?>
人</td>
    </tr>
</table>
<br>
<table cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td>
            <span style="color:#FF0000;font-size:20px;"><b><?php echo $this->_tpl_vars['registTitle']; ?>
</b></span>
        </td>
    </tr>
    <tr>
        <td align="center">
            <span style="color:#00F;font-size:24px;">本登録者数</span>
        </td>
    </tr>
</table>
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th rowspan="2"><b>媒体名</b></th>
        <th rowspan="2"><b>広告コード</b></th>
        <th colspan="<?php echo $this->_tpl_vars['dispMonthlyRegistCount']; ?>
"><center><b>本登録月</b></center></th>
        <th rowspan="2"><b>媒体別登録数合計</b></th>
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
        <td><?php echo $this->_tpl_vars['mediaCdNameList'][$this->_tpl_vars['baitaiName']]; ?>
</td>
        <td><?php echo $this->_tpl_vars['baitaiName']; ?>
</td>
        <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['registMonth'] => $this->_tpl_vars['regist']):
        $this->_foreach['loop']['iteration']++;
?>
            <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['regist'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</td>
        <?php endforeach; endif; unset($_from); ?>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['registTotalForMediaCd'][$this->_tpl_vars['baitaiName']])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
人</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    <tr class="BgColor02">
        <td colspan="2"><b>月間合計</b></td>
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
        <td>
            <span style="color:#FF0000;font-size:20px;"><b><?php echo $this->_tpl_vars['quitUserTitle']; ?>
</b></span>
        </td>
    </tr>
    <tr>
        <td align="center">
            <span style="color:#00F;font-size:24px;">退会者数</span>
        </td>
    </tr>
</table>
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th rowspan="2"><b>媒体名</b></th>
        <th rowspan="2"><b>広告コード</b></th>
        <th colspan="<?php echo $this->_tpl_vars['dispMonthlyQuitUserCount']; ?>
"><center><b>本登録月</b></center></th>
        <th rowspan="2"><b>媒体別登録数合計</b></th>
    </tr>
    <tr>
        <?php $_from = $this->_tpl_vars['dispMonthlyQuitUser']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
        $this->_foreach['loop']['iteration']++;
?>
            <th><b><?php echo $this->_tpl_vars['val']; ?>
</b></th>
        <?php endforeach; endif; unset($_from); ?>
    </tr>
    <?php $_from = $this->_tpl_vars['baitaiQuitUserCountList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['baitaiName'] => $this->_tpl_vars['list']):
        $this->_foreach['loop']['iteration']++;
?>
    <tr>
        <td><?php echo $this->_tpl_vars['mediaCdNameList'][$this->_tpl_vars['baitaiName']]; ?>
</td>
        <td><?php echo $this->_tpl_vars['baitaiName']; ?>
</td>
        <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['registMonth'] => $this->_tpl_vars['regist']):
        $this->_foreach['loop']['iteration']++;
?>
            <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['regist'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</td>
        <?php endforeach; endif; unset($_from); ?>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['quitUserTotalForMediaCd'][$this->_tpl_vars['baitaiName']])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
人</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    <tr class="BgColor02">
        <td colspan="2"><b>月間合計</b></td>
        <?php $_from = $this->_tpl_vars['quitUserTotalForMonthly']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['registonthly'] => $this->_tpl_vars['registTotal']):
        $this->_foreach['loop']['iteration']++;
?>
            <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['registTotal'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
人</td>
        <?php endforeach; endif; unset($_from); ?>
        <td><?php echo $this->_tpl_vars['quitUserAllTotal']; ?>
人</td>
    </tr>
</table>
<br>
<table cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td>
            <span style="color:#FF0000;font-size:20px;"><b><?php echo $this->_tpl_vars['payTitle']; ?>
</b></span><br>
        </td>
    </tr>
    <tr>
        <td align="center">
            <span style="color:#00F;font-size:24px;">入金額</span>
        </td>
    </tr>
</table>
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th rowspan="2"><b>媒体名</b></th>
        <th rowspan="2"><b>広告コード</b></th>
        <th colspan="<?php echo $this->_tpl_vars['dispMonthlyPayCount']; ?>
"><center><b>入金月</b></center></th>
        <th rowspan="2"><b>媒体別入金合計</b></th>
    </tr>
    <tr>
        <?php $_from = $this->_tpl_vars['dispMonthlyPay']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
        $this->_foreach['loop']['iteration']++;
?>
            <th><b><?php echo $this->_tpl_vars['val']; ?>
</b></th>
        <?php endforeach; endif; unset($_from); ?>
    </tr>
    <?php $_from = $this->_tpl_vars['tradeAmountList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['baitaiName'] => $this->_tpl_vars['list']):
        $this->_foreach['loop']['iteration']++;
?>
    <tr>
        <td><?php echo $this->_tpl_vars['mediaCdNameList'][$this->_tpl_vars['baitaiName']]; ?>
</td>
        <td><?php echo $this->_tpl_vars['baitaiName']; ?>
</td>
        <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['payMonth'] => $this->_tpl_vars['regist']):
        $this->_foreach['loop']['iteration']++;
?>
            <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['regist'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</td>
        <?php endforeach; endif; unset($_from); ?>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['payTotalForMediaCd'][$this->_tpl_vars['baitaiName']])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
円</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    <tr class="BgColor02">
        <td colspan="2"><center><b>月間合計</b></center></td>
        <?php $_from = $this->_tpl_vars['payTotalForMonthly']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['payMonthly'] => $this->_tpl_vars['payTotal']):
        $this->_foreach['loop']['iteration']++;
?>
            <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['payTotal'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
円</td>
        <?php endforeach; endif; unset($_from); ?>
        <td><?php echo $this->_tpl_vars['payAllTotal']; ?>
円</td>
    </tr>
</table>
<br>



<table cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td>
            <span style="color:#FF0000;font-size:20px;"><b><?php echo $this->_tpl_vars['payTitle']; ?>
</b></span><br>
        </td>
    </tr>
    <tr>
        <td align="center">
            <span style="color:#00F;font-size:24px;">入金者数</span>
        </td>
    </tr>
</table>
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th rowspan="2"><b>媒体名</b></th>
        <th rowspan="2"><b>広告コード</b></th>
        <th colspan="<?php echo $this->_tpl_vars['dispMonthlyPayUserCount']; ?>
"><center><b>入金月</b></center></th>
        <th rowspan="2"><b>媒体別入金者数合計</b></th>
    </tr>
    <tr>
        <?php $_from = $this->_tpl_vars['dispMonthlyPayUser']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
        $this->_foreach['loop']['iteration']++;
?>
            <th><b><?php echo $this->_tpl_vars['val']; ?>
</b></th>
        <?php endforeach; endif; unset($_from); ?>
    </tr>
    <?php $_from = $this->_tpl_vars['tradeUserList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['baitaiName'] => $this->_tpl_vars['list']):
        $this->_foreach['loop']['iteration']++;
?>
    <tr>
        <td><?php echo $this->_tpl_vars['mediaCdNameList'][$this->_tpl_vars['baitaiName']]; ?>
</td>
        <td><?php echo $this->_tpl_vars['baitaiName']; ?>
</td>
        <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['payMonth'] => $this->_tpl_vars['regist']):
        $this->_foreach['loop']['iteration']++;
?>
            <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['regist'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</td>
        <?php endforeach; endif; unset($_from); ?>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['payUserTotalForMediaCd'][$this->_tpl_vars['baitaiName']])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
人</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    <tr class="BgColor02">
        <td colspan="2"><center><b>月間合計</b></center></td>
        <?php $_from = $this->_tpl_vars['payUserTotalForMonthly']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['payMonthly'] => $this->_tpl_vars['payTotal']):
        $this->_foreach['loop']['iteration']++;
?>
            <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['payTotal'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
人</td>
        <?php endforeach; endif; unset($_from); ?>
        <td><?php echo $this->_tpl_vars['payUserAllTotal']; ?>
人</td>
    </tr>
</table>
<br>
<table cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td>
            <span style="color:#FF0000;font-size:20px;"><b><?php echo $this->_tpl_vars['advertiseTitle']; ?>
</b></span><br>
        </td>
    </tr>
    <tr>
        <td align="center">
            <span style="color:#00F;font-size:24px;">広告費</span>
        </td>
    </tr>
</table>
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th rowspan="2"><b>媒体名</b></th>
        <th rowspan="2"><b>広告コード</b></th>
        <th colspan="<?php echo $this->_tpl_vars['dispMonthAdvertiseExpensesCount']; ?>
"><center><b>広告費月</b></center></th>
        <th rowspan="2"><b>媒体別広告費合計</b></th>
    </tr>
    <tr>
        <?php $_from = $this->_tpl_vars['dispMonthAdvertiseExpenses']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
        $this->_foreach['loop']['iteration']++;
?>
            <th><b><?php echo $this->_tpl_vars['val']; ?>
</b></th>
        <?php endforeach; endif; unset($_from); ?>
    </tr>
    <?php $_from = $this->_tpl_vars['baitaiAdvertiseExpensesList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['baitaiName'] => $this->_tpl_vars['list']):
        $this->_foreach['loop']['iteration']++;
?>
    <tr>
        <td><?php echo $this->_tpl_vars['mediaCdNameList'][$this->_tpl_vars['baitaiName']]; ?>
</td>
        <td><?php echo $this->_tpl_vars['baitaiName']; ?>
</td>
        <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['payMonth'] => $this->_tpl_vars['regist']):
        $this->_foreach['loop']['iteration']++;
?>
            <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['regist'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</td>
        <?php endforeach; endif; unset($_from); ?>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['advertiseExpensesTotalForMediaCd'][$this->_tpl_vars['baitaiName']])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
円</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    <tr class="BgColor02">
        <td colspan="2"><center><b>月間合計</b></center></td>
        <?php $_from = $this->_tpl_vars['advertiseExpensesTotalForMonthly']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['advertiseExpenses'] => $this->_tpl_vars['advertiseExpensesMonthTotal']):
        $this->_foreach['loop']['iteration']++;
?>
            <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['advertiseExpensesMonthTotal'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
円</td>
        <?php endforeach; endif; unset($_from); ?>
        <td><?php echo $this->_tpl_vars['advertiseExpensesTotal']; ?>
円</td>
    </tr>
</table>
<br>
<table cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td>
            <span style="color:#FF0000;font-size:20px;"><b><?php echo $this->_tpl_vars['cvrTitle']; ?>
</b></span><br>
        </td>
    </tr>
    <tr>
        <td align="center">
            <span style="color:#00F;font-size:24px;">CVR(%)Conversion Rate（本登録者数/アクセス数）</span>
        </td>
    </tr>
</table>
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th rowspan="2"><b>媒体名</b></th>
        <th rowspan="2"><b>広告コード</b></th>
        <th colspan="<?php echo $this->_tpl_vars['dispMonthAdvertiseExpensesCount']; ?>
"><center><b>CVR算出月</b></center></th>
        <th rowspan="2"><b>媒体別入金合計</b></th>
    </tr>
    <tr>
        <?php $_from = $this->_tpl_vars['dispMonthAdvertiseExpenses']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
        $this->_foreach['loop']['iteration']++;
?>
            <th><b><?php echo $this->_tpl_vars['val']; ?>
</b></th>
        <?php endforeach; endif; unset($_from); ?>
    </tr>
    <?php $_from = $this->_tpl_vars['baitaiCvrList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['baitaiName'] => $this->_tpl_vars['list']):
        $this->_foreach['loop']['iteration']++;
?>
    <tr>
        <td><?php echo $this->_tpl_vars['mediaCdNameList'][$this->_tpl_vars['baitaiName']]; ?>
</td>
        <td><?php echo $this->_tpl_vars['baitaiName']; ?>
</td>
        <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['cvrKey'] => $this->_tpl_vars['cvrVal']):
        $this->_foreach['loop']['iteration']++;
?>
            <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['cvrVal'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
%</td>
        <?php endforeach; endif; unset($_from); ?>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['cvrTotalForMediaCd'][$this->_tpl_vars['baitaiName']])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
%</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    <tr class="BgColor02">
        <td colspan="2"><center><b>月間合計</b></center></td>
        <?php $_from = $this->_tpl_vars['cvrTotalForMonthly']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['cvrMonthly'] => $this->_tpl_vars['cvrMonthTotalMonth']):
        $this->_foreach['loop']['iteration']++;
?>
            <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['cvrMonthTotalMonth'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
%</td>
        <?php endforeach; endif; unset($_from); ?>
        <td><?php echo $this->_tpl_vars['cvrTotal']; ?>
%</td>
    </tr>
</table>
<br>
<table cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td>
            <span style="color:#FF0000;font-size:20px;"><b><?php echo $this->_tpl_vars['cpcTitle']; ?>
</b></span><br>
        </td>
    </tr>
    <tr>
        <td align="center">
            <span style="color:#00F;font-size:24px;">CPC(円)Cost Per Click（広告費/アクセス数)</span>
        </td>
    </tr>
</table>
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th rowspan="2"><b>媒体名</b></th>
        <th rowspan="2"><b>広告コード</b></th>
        <th colspan="<?php echo $this->_tpl_vars['dispMonthAdvertiseExpensesCount']; ?>
"><center><b>CPC算出月</b></center></th>
        <th rowspan="2"><b>媒体別入金合計</b></th>
    </tr>
    <tr>
        <?php $_from = $this->_tpl_vars['dispMonthAdvertiseExpenses']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
        $this->_foreach['loop']['iteration']++;
?>
            <th><b><?php echo $this->_tpl_vars['val']; ?>
</b></th>
        <?php endforeach; endif; unset($_from); ?>
    </tr>
    <?php $_from = $this->_tpl_vars['baitaiCpcList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['baitaiName'] => $this->_tpl_vars['list']):
        $this->_foreach['loop']['iteration']++;
?>
    <tr>
        <td><?php echo $this->_tpl_vars['mediaCdNameList'][$this->_tpl_vars['baitaiName']]; ?>
</td>
        <td><?php echo $this->_tpl_vars['baitaiName']; ?>
</td>
        <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['cpcKey'] => $this->_tpl_vars['cpcVal']):
        $this->_foreach['loop']['iteration']++;
?>
            <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['cpcVal'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</td>
        <?php endforeach; endif; unset($_from); ?>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['cpcTotalForMediaCd'][$this->_tpl_vars['baitaiName']])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
円</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    <tr class="BgColor02">
        <td colspan="2"><center><b>月間合計</b></center></td>
        <?php $_from = $this->_tpl_vars['cpcTotalForMonthly']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['cpcMonthly'] => $this->_tpl_vars['cpcMonthTotalMonth']):
        $this->_foreach['loop']['iteration']++;
?>
            <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['cpcMonthTotalMonth'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
円</td>
        <?php endforeach; endif; unset($_from); ?>
        <td><?php echo $this->_tpl_vars['cpcTotal']; ?>
円</td>
    </tr>
</table>
<br>
<table cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td>
            <span style="color:#FF0000;font-size:20px;"><b><?php echo $this->_tpl_vars['cpaTitle']; ?>
</b></span><br>
        </td>
    </tr>
    <tr>
        <td align="center">
            <span style="color:#00F;font-size:24px;">CPA(円)Cost Per Action（広告費/本登録者数)</span>
        </td>
    </tr>
</table>
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th rowspan="2"><b>媒体名</b></th>
        <th rowspan="2"><b>広告コード</b></th>
        <th colspan="<?php echo $this->_tpl_vars['dispMonthAdvertiseExpensesCount']; ?>
"><center><b>CPA算出月</b></center></th>
        <th rowspan="2"><b>媒体別入金合計</b></th>
    </tr>
    <tr>
        <?php $_from = $this->_tpl_vars['dispMonthAdvertiseExpenses']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
        $this->_foreach['loop']['iteration']++;
?>
            <th><b><?php echo $this->_tpl_vars['val']; ?>
</b></th>
        <?php endforeach; endif; unset($_from); ?>
    </tr>
    <?php $_from = $this->_tpl_vars['baitaiCpaList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['baitaiName'] => $this->_tpl_vars['list']):
        $this->_foreach['loop']['iteration']++;
?>
    <tr>
        <td><?php echo $this->_tpl_vars['mediaCdNameList'][$this->_tpl_vars['baitaiName']]; ?>
</td>
        <td><?php echo $this->_tpl_vars['baitaiName']; ?>
</td>
        <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['cpaKey'] => $this->_tpl_vars['cpaVal']):
        $this->_foreach['loop']['iteration']++;
?>
            <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['cpaVal'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</td>
        <?php endforeach; endif; unset($_from); ?>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['cpaTotalForMediaCd'][$this->_tpl_vars['baitaiName']])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
円</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    <tr class="BgColor02">
        <td colspan="2"><center><b>月間合計</b></center></td>
        <?php $_from = $this->_tpl_vars['cpaTotalForMonthly']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['cpaMonthly'] => $this->_tpl_vars['cpaMonthTotalMonth']):
        $this->_foreach['loop']['iteration']++;
?>
            <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['cpaMonthTotalMonth'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
円</td>
        <?php endforeach; endif; unset($_from); ?>
        <td><?php echo $this->_tpl_vars['cpaTotal']; ?>
円</td>
    </tr>
</table>
<br>
<table cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td>
            <span style="color:#FF0000;font-size:20px;"><b><?php echo $this->_tpl_vars['roiTitle']; ?>
</b></span><br>
        </td>
    </tr>
    <tr>
        <td align="center">
            <span style="color:#00F;font-size:24px;">ROI(%)Return On Investment（入金額/広告費）</span>
        </td>
    </tr>
</table>
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th rowspan="2"><b>媒体名</b></th>
        <th rowspan="2"><b>広告コード</b></th>
        <th colspan="<?php echo $this->_tpl_vars['dispMonthAdvertiseExpensesCount']; ?>
"><center><b>ROI算出月</b></center></th>
        <th rowspan="2"><b>媒体別入金合計</b></th>
    </tr>
    <tr>
        <?php $_from = $this->_tpl_vars['dispMonthAdvertiseExpenses']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
        $this->_foreach['loop']['iteration']++;
?>
            <th><b><?php echo $this->_tpl_vars['val']; ?>
</b></th>
        <?php endforeach; endif; unset($_from); ?>
    </tr>
    <?php $_from = $this->_tpl_vars['baitaiRoiList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['baitaiName'] => $this->_tpl_vars['list']):
        $this->_foreach['loop']['iteration']++;
?>
    <tr>
        <td><?php echo $this->_tpl_vars['mediaCdNameList'][$this->_tpl_vars['baitaiName']]; ?>
</td>
        <td><?php echo $this->_tpl_vars['baitaiName']; ?>
</td>
        <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['roiKey'] => $this->_tpl_vars['roiVal']):
        $this->_foreach['loop']['iteration']++;
?>
            <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['roiVal'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
%</td>
        <?php endforeach; endif; unset($_from); ?>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['roiTotalForMediaCd'][$this->_tpl_vars['baitaiName']])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
%</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    <tr class="BgColor02">
        <td colspan="2"><center><b>月間合計</b></center></td>
        <?php $_from = $this->_tpl_vars['roiTotalForMonthly']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['roiMonthly'] => $this->_tpl_vars['roiMonthTotalMonth']):
        $this->_foreach['loop']['iteration']++;
?>
            <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['roiMonthTotalMonth'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
%</td>
        <?php endforeach; endif; unset($_from); ?>
        <td><?php echo $this->_tpl_vars['roiTotal']; ?>
%</td>
    </tr>
</table>
