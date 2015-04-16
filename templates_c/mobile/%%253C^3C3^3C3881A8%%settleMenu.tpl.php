<?php /* Smarty version 2.6.26, created on 2014-08-08 16:56:46
         compiled from /home/suraimu/templates/mobile/include/settleMenu.tpl */ ?>

<div style="background-color:#C00000; font-size:x-small; color:#FFF;" id="payment"><img src="img/settle01.gif" alt="お支払い方法" width="100%" /><br />
    <span class="txt">下記の中からご都合に合わせてお支払い方法のﾎﾞﾀﾝをｸﾘｯｸ</span><br />
    <div class="bank"><span style="font-size:small;"><a href="./?action_SettleBank=1&<?php echo $this->_tpl_vars['URLparam']; ?>
<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>">銀行振込</a></span></div>
    <span class="txt">
    ┗楽天銀行（24時間ＯＫ）<br />
    ┗全国全ての金融機関<br />
    ※平日9時～15時はオススメ</span><br />

<!--
    <div class="netbank"><span style="font-size:small;"><a href="./?action_SettleNetBank=1&<?php echo $this->_tpl_vars['URLparam']; ?>
<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>">ネット銀行(24時間OK)</a></span></div>
    <span class="txt">
    ┗ジャパンネット銀行<br />
    ┗住信SBIネット銀行</span><br />
-->

    <div class="credit"><span style="font-size:small;"><a href="./?action_SettleTelecom=1&<?php echo $this->_tpl_vars['URLparam']; ?>
<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>">クレジットカード</a></span></div>
    <span class="txt">┗各社カードで24時間OK!</span><br />
    <?php if ($this->_tpl_vars['itemTotalMoney'] <= 30000): ?>
    <div class="cvd"><span style="font-size:small;"><a href="./?action_SettleCvd=1&<?php echo $this->_tpl_vars['URLparam']; ?>
<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>">コンビニ決済</a></span></div>
    <span class="txt">┗ご近所のコンビニで24時間OK!</span><br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['itemTotalMoney'] <= 25000): ?>
    <div class="bitcash"><span style="font-size:small;"><a href="./?action_SettleBitcash=1&<?php echo $this->_tpl_vars['URLparam']; ?>
<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>">BITCASH決済</a></span></div>
    <span class="txt">┗ご近所のコンビニで24時間OK!</span><br />
    <?php endif; ?>
    <img src="img/settle02.gif" width="100%" />
</div>
<br>