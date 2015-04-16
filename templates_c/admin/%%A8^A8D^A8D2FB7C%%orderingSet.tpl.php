<?php /* Smarty version 2.6.26, created on 2014-09-30 09:45:06
         compiled from /home/suraimu/templates/admin/ordering/orderingSet.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/ordering/orderingSet.tpl', 7, false),array('modifier', 'implode', '/home/suraimu/templates/admin/ordering/orderingSet.tpl', 13, false),array('modifier', 'default', '/home/suraimu/templates/admin/ordering/orderingSet.tpl', 37, false),array('function', 'make_link', '/home/suraimu/templates/admin/ordering/orderingSet.tpl', 21, false),array('function', 'html_options', '/home/suraimu/templates/admin/ordering/orderingSet.tpl', 33, false),array('function', 'html_radios', '/home/suraimu/templates/admin/ordering/orderingSet.tpl', 37, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">商品注文画面</h2>
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
<div>
    <a href="<?php echo smarty_function_make_link(array('action' => 'action_itemManagement_ItemList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="_blank">商品一覧</a>
</div>
<br>
<form action="./" method="POST">
    <?php echo $this->_tpl_vars['POSTparam']; ?>

    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">
        <tr>
            <th>商品ID<br>(カンマ区切りで複数可)</th>
            <td><input type="text" name="item_id" value="<?php echo $this->_tpl_vars['returnValue']['item_id']; ?>
" size="20" style="ime-mode:disabled;"></td>
        </tr>
        <tr>
            <th>注文ステータス</th>
            <td><?php echo smarty_function_html_options(array('name' => 'status','options' => $this->_tpl_vars['orderStatus'],'selected' => $this->_tpl_vars['returnValue']['status']), $this);?>
</td>
        </tr>
        <tr>
            <th>支払方法</th>
            <td><?php echo smarty_function_html_radios(array('name' => 'pay_type','options' => $this->_tpl_vars['payType'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['returnValue']['pay_type'])) ? $this->_run_mod_handler('default', true, $_tmp, 1) : smarty_modifier_default($_tmp, 1)),'separator' => "&nbsp;"), $this);?>
</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <input type="submit" name="action_ordering_OrderingSetExec" value="注 文" onClick="return confirm('注文しますか？')" />
            </td>
        </tr>
    </table>
</form>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admFooter'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
</body>
</html>