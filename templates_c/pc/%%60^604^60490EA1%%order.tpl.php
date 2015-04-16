<?php /* Smarty version 2.6.26, created on 2014-08-08 15:49:33
         compiled from /home/suraimu/templates/www/include/order.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'emoji', '/home/suraimu/templates/www/include/order.tpl', 9, false),array('modifier', 'number_format', '/home/suraimu/templates/www/include/order.tpl', 13, false),array('modifier', 'zend_date_format', '/home/suraimu/templates/www/include/order.tpl', 35, false),)), $this); ?>
<?php if ($this->_tpl_vars['lastOrderingItemList']): ?>
    <div id="reservation">
    <h3>最重要　ご予約中の商品</h3>
    <p>貴方様が予約された商品です。キャンペーン情報は期間限定・完全先着・人数限定ですので、至急の決済お手続きをお願い申し上げます。</p>
    <?php $_from = $this->_tpl_vars['lastOrderingItemList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
        <table class="tableItem" cellspacing="2">
        <tr>
        <th>ご予約商品名</th>
        <td class="attention"><?php echo ((is_array($_tmp=$this->_tpl_vars['val']['html_text_name_pc'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>
</td>
        </tr>
        <tr>
        <th>商品金額</th>
        <td class="attention"><?php echo ((is_array($_tmp=$this->_tpl_vars['val']['price'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
円</td>
        </tr>
        </table>
    <?php endforeach; endif; unset($_from); ?>
    <table class="tableItem" cellspacing="2">
    <tr>
    <th>ご決済金額</th>
    <td class="attention"><?php echo ((is_array($_tmp=$this->_tpl_vars['lastOrderingData']['pay_total'])) ? $this->_run_mod_handler('number_format', true, $_tmp, '0') : number_format($_tmp, '0')); ?>
円</td>
    </tr>
    <!--カウントダウン追加 -->
    <?php if ($this->_tpl_vars['showCountDown']): ?>
    <script type="text/javascript" src="js/countDown.js"></script>
    <tr>
        <th>締切まで残時間</th>
        <td align="center"><span id="cntdown1" style="font-size:28px; color:#000; height:40px; line-height:40px;"></span>
            <script type="text/javascript">countdown('cntdown1',<?php echo $this->_tpl_vars['countDownYear']; ?>
,<?php echo $this->_tpl_vars['countDownMonth']; ?>
,<?php echo $this->_tpl_vars['countDownDay']; ?>
,<?php echo $this->_tpl_vars['countDownHour']; ?>
,<?php echo $this->_tpl_vars['countDownMinute']; ?>
);</script>
        </td>
    </tr>
    <?php endif; ?>
    <!--/カウントダウン追加 -->
    <tr>
    <th>ご予約日時</th>
    <td><?php echo ((is_array($_tmp=$this->_tpl_vars['lastOrderingData']['create_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy年MM月dd日 HH時mm分ss秒') : smarty_modifier_zend_date_format($_tmp, 'yyyy年MM月dd日 HH時mm分ss秒')); ?>
</td>
    </tr>
    </table>
    <table class="tableItem" cellspacing="2">
    <tr>
    <th>決済種別</th>
    <td><?php echo $this->_tpl_vars['settleName']; ?>
決済</td>
    </tr>
    <tr>
    <td colspan="2" class="end"><a href="./?action_OrderingDelChk=1&odid=<?php echo $this->_tpl_vars['lastOrderingData']['access_key']; ?>
<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>">ご予約をキャンセルする</a></td>
    </tr>
    </table>
    <table class="tableItem" cellspacing="2">
    <tr>
    <td><a href="./?action_Settle<?php echo $this->_tpl_vars['settleLinkUrl']; ?>
=1&odid=<?php echo $this->_tpl_vars['lastOrderingData']['access_key']; ?>
<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>">詳細はこちら</a></td>
    </tr>
    </table>
    <div id="under">&nbsp;</div>
    </div>
<?php endif; ?>