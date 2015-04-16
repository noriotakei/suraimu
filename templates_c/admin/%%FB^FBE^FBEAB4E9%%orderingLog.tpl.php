<?php /* Smarty version 2.6.26, created on 2014-08-08 18:52:13
         compiled from /home/suraimu/templates/admin/log/orderingLog.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/log/orderingLog.tpl', 16, false),array('modifier', 'implode', '/home/suraimu/templates/admin/log/orderingLog.tpl', 22, false),array('modifier', 'cat', '/home/suraimu/templates/admin/log/orderingLog.tpl', 46, false),array('modifier', 'nl2br', '/home/suraimu/templates/admin/log/orderingLog.tpl', 85, false),array('function', 'make_link', '/home/suraimu/templates/admin/log/orderingLog.tpl', 46, false),)), $this); ?>
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
<h2 class="ContentTitle">注文一覧</h2><br>
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
<?php if ($this->_tpl_vars['orderingList']): ?>
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" align="center">
    <tr>
        <th><p>注文NO</p></th>
        <th>支払方法</th>
        <th>注文日時</th>
        <th>商品明細</th>
      </tr>
      <tr>
        <th>ステータス</th>
        <th>キャンセル</th>
        <th>入金</th>
        <th>メモ</th>
      </tr>

    <?php $_from = $this->_tpl_vars['orderingList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
        $this->_foreach['loop']['iteration']++;
?>
        <tr <?php echo $this->_tpl_vars['val']['style']; ?>
>
            <td><a href="<?php echo smarty_function_make_link(array('action' => 'action_ordering_OrderingData','getTags' => ((is_array($_tmp="ordering_id=")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['val']['id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['val']['id']))), $this);?>
" target="_blank"><?php echo $this->_tpl_vars['val']['id']; ?>
</a></td>
            <td><?php echo $this->_tpl_vars['payType'][$this->_tpl_vars['val']['pay_type']]; ?>
</td>
            <td><?php echo $this->_tpl_vars['val']['create_datetime']; ?>
</td>
            <td>
                商品<br>
                <table border="0" cellpadding="0" cellspacing="0" style="font-size:11px">
                    <?php $_from = $this->_tpl_vars['itemList'][$this->_tpl_vars['key']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['itemLoop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['itemLoop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['itemVal']):
        $this->_foreach['itemLoop']['iteration']++;
?>
                    <tr >
                        <td nowrap width="150"><a href="<?php echo smarty_function_make_link(array('action' => 'action_informationStatus_InformationSearchList','getTags' => ((is_array($_tmp=((is_array($_tmp="search_html_text=")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['itemVal']['access_key']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['itemVal']['access_key'])))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['URLparam']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['URLparam']))), $this);?>
" target="_blank"><?php echo $this->_tpl_vars['itemVal']['name']; ?>
</a></td>
                        <td nowrap>\<?php echo $this->_tpl_vars['itemVal']['price']; ?>
</td>
                    </tr>
                    <?php endforeach; endif; unset($_from); ?>
                    <tr>
                        <td nowrap>合計</td>
                        <td nowrap>\<?php echo $this->_tpl_vars['val']['pay_total']; ?>
</td>
                    </tr>
                </table>
                <br>
                <?php if ($this->_tpl_vars['changeItemList'][$this->_tpl_vars['key']]): ?>
                注文変更履歴<br>
                <table border="0" cellpadding="0" cellspacing="0" style="font-size:11px">
                    <?php $_from = $this->_tpl_vars['changeItemList'][$this->_tpl_vars['key']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['changeItemLoop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['changeItemLoop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['changeItemVal']):
        $this->_foreach['changeItemLoop']['iteration']++;
?>
                    <tr >
                        <td nowrap width="150"><a href="<?php echo smarty_function_make_link(array('action' => 'action_informationStatus_InformationSearchList','getTags' => ((is_array($_tmp=((is_array($_tmp="search_html_text=")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['changeItemVal']['access_key']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['changeItemVal']['access_key'])))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['URLparam']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['URLparam']))), $this);?>
" target="_blank"><?php echo $this->_tpl_vars['changeItemVal']['name']; ?>
</a></td>
                        <td nowrap>\<?php echo $this->_tpl_vars['changeItemVal']['price']; ?>
</td>
                    </tr>
                    <?php endforeach; endif; unset($_from); ?>
                    <tr>
                        <td nowrap>合計</td>
                        <td nowrap>\<?php echo $this->_tpl_vars['changeItemTotalMoney'][$this->_tpl_vars['key']]; ?>
</td>
                    </tr>
                </table>
                <?php endif; ?>
            </td>
        </tr>
        <tr <?php echo $this->_tpl_vars['val']['style']; ?>
>
            <td><?php echo $this->_tpl_vars['orderStatus'][$this->_tpl_vars['val']['status']]; ?>
</td>
            <td><?php echo $this->_tpl_vars['cancelFlag'][$this->_tpl_vars['val']['is_cancel']]; ?>
</td>
            <td <?php if ($this->_tpl_vars['val']['is_paid']): ?>style="color:red;"<?php endif; ?>><?php echo $this->_tpl_vars['paidFlag'][$this->_tpl_vars['val']['is_paid']]; ?>
</td>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['val']['description'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</td>
        </tr>
    <?php endforeach; endif; unset($_from); ?>
    </table>
<?php else: ?>
    <div class="warning ui-widget">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    <p>
    <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    該当データはありません
    </p>
    </div>
<?php endif; ?>
