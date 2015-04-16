<?php /* Smarty version 2.6.26, created on 2014-08-08 18:38:53
         compiled from /home/suraimu/templates/mobile/itemList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'emoji', '/home/suraimu/templates/mobile/itemList.tpl', 17, false),array('function', 'eval', '/home/suraimu/templates/mobile/itemList.tpl', 39, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['header'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</head>
<body <?php echo $this->_tpl_vars['bodyTag']; ?>
>
<a name="top" id="top"></a>
<div style="font-size:x-small; text-align:left; <?php echo $this->_tpl_vars['limited_width']; ?>
">
<img src="img/title.gif" alt="<?php echo $this->_tpl_vars['siteName']; ?>
" width="100%" />
<div style="text-align:center;">
<?php if (! $this->_tpl_vars['noItemList']): ?>
<span style="color:#f00;">他キャンペーンも<br />入手お手続きが可能です!</span><br />
<?php endif; ?>
</div>
<hr size="1" style="width:100%; color:#963;"/>

<?php if ($this->_tpl_vars['errMsg']): ?>
<span style="color:#f00;">
    <?php $_from = $this->_tpl_vars['errMsg']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
        <?php echo ((is_array($_tmp=$this->_tpl_vars['val'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>

    <?php endforeach; endif; unset($_from); ?>
</span>
<hr size="1" style="width:100%; color:#963;"/>
<?php endif; ?>

<?php if (! $this->_tpl_vars['noItemList']): ?>
キャンペーンとポイント追加を<span style="color:#f00;">同時手続き</span>されると非常にお得です!<br /><br />
<?php endif; ?>

<?php if (! $this->_tpl_vars['itemExpList'] && ! $this->_tpl_vars['itemList']): ?>
        <span style="color:#f00;"><?php echo $this->_tpl_vars['noItemList']; ?>
</span>
<?php else: ?>
    <?php $_from = $this->_tpl_vars['itemDispPosition']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['position'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['position']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['positionKey'] => $this->_tpl_vars['dispPosition']):
        $this->_foreach['position']['iteration']++;
?>
                <?php if (( $this->_tpl_vars['itemExpList'][$this->_tpl_vars['positionKey']] || $this->_tpl_vars['itemList'][$this->_tpl_vars['positionKey']] ) && ! ($this->_foreach['position']['iteration'] <= 1)): ?>
            <hr size="1" style="width:100%; color:#963;"/><br>
        <?php endif; ?>
                        <?php $_from = $this->_tpl_vars['itemExpList'][$this->_tpl_vars['positionKey']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['exp'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['exp']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['expData']):
        $this->_foreach['exp']['iteration']++;
?>
                <?php echo smarty_function_eval(array('var' => ((is_array($_tmp=$this->_tpl_vars['expData']['html_text_banner_mb'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp))), $this);?>

            <?php endforeach; endif; unset($_from); ?>

                        <?php $_from = $this->_tpl_vars['itemList'][$this->_tpl_vars['positionKey']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['item'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['item']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['itemData']):
        $this->_foreach['item']['iteration']++;
?>
                <?php echo smarty_function_eval(array('var' => ((is_array($_tmp=$this->_tpl_vars['itemData']['html_text_banner_mb'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp))), $this);?>

                <?php if (! ($this->_foreach['item']['iteration'] == $this->_foreach['item']['total'])): ?>
                    <img src="img/line_b.gif" width="100%" />
                <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>
    <?php endforeach; endif; unset($_from); ?>
<?php endif; ?>
<hr <?php echo $this->_tpl_vars['hr_1style']; ?>
 />
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['pr'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['footer'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

</body>
</html>