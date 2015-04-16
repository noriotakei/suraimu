<?php /* Smarty version 2.6.26, created on 2014-08-08 15:49:33
         compiled from /home/suraimu/templates/www/include/cart.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'emoji', '/home/suraimu/templates/www/include/cart.tpl', 9, false),array('modifier', 'number_format', '/home/suraimu/templates/www/include/cart.tpl', 13, false),)), $this); ?>
<?php if ($this->_tpl_vars['cartItemList']): ?>
    <div id="cart">
    <h3>カート内の商品</h3>
    <p>貴方様の「ショッピングカード内」の商品です。ご購入には下記より決済種別のご選択をお願い致します。</p>
    <?php $_from = $this->_tpl_vars['cartItemList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
        <table class="tableItem" cellspacing="2">
        <tr>
        <th>カート内商品名</th>
        <td class="attention"><?php echo ((is_array($_tmp=$this->_tpl_vars['val']['html_text_name_pc'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>
</td>
        </tr>
        <tr>
        <th>商品金額</th>
        <td class="attention"><?php echo ((is_array($_tmp=$this->_tpl_vars['val']['price'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
円</td>
        </tr>
        <tr>
        <td colspan="2" class="end"><a href="./?action_<?php echo $this->_tpl_vars['accessPageName']; ?>
=1&del=1&iid=<?php echo $this->_tpl_vars['val']['access_key']; ?>
<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>">カートからキャンセルする</a></td>
        </tr>
        </table>
    <?php endforeach; endif; unset($_from); ?>
    <table class="tableItem" cellspacing="2">
    <tr>
    <td><a href="./?action_SettleSelect=1<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>">カート内の商品の決済方法を選ぶ</a></td>
    </tr>
    </table>
    <div id="under">&nbsp;</div>
    </div>
<?php endif; ?>