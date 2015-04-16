<?php /* Smarty version 2.6.26, created on 2014-08-08 16:56:46
         compiled from /home/suraimu/templates/mobile/settleSelect.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'emoji', '/home/suraimu/templates/mobile/settleSelect.tpl', 15, false),array('modifier', 'number_format', '/home/suraimu/templates/mobile/settleSelect.tpl', 32, false),)), $this); ?>
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
商品の確認
</div>
<hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 />

<?php if ($this->_tpl_vars['errMsg']): ?>
<span style="color:#f00;">
    <?php $_from = $this->_tpl_vars['errMsg']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
        <?php echo ((is_array($_tmp=$this->_tpl_vars['val'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>

    <?php endforeach; endif; unset($_from); ?>
</span>
<hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 />

<?php endif; ?>

<?php if ($this->_tpl_vars['itemList']): ?>
<div style="text-align:center;font-size:small;">ご確認後にお支払い方法をご選択ください。<br /><span style="color:#f00;">▼　▼　▼</span></div>
    <?php $_from = $this->_tpl_vars['itemList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
        <table border="0" width="100%">
            <tr>
                <td width="20%"><span style="color:#c93;font-size:xx-small;">内容：</span></td>
                <td width="80%"><span style="color:#ffa500;"><?php echo ((is_array($_tmp=$this->_tpl_vars['val']['html_text_name_mb'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>
</span></td>
            </tr>
            <tr>
                <td width="20%"><span style="color:#c93;font-size:xx-small;">価格：</span></td>
                <td width="80%"><?php echo ((is_array($_tmp=$this->_tpl_vars['val']['price'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
円</td>
            </tr>
        </table>
                <img src="img/line_b.gif" width="100%" />
    <?php endforeach; endif; unset($_from); ?>
    <br /><br />
    <?php if ($this->_tpl_vars['showCountDown']): ?>
        <div style="width:90%;background:#360;color:#CF0;text-align:center;margin:0 auto;font-size:small;">▼締切まで残時間</div>
        <div style="width:90%;background:#000;color:#FFF;text-align:center;margin:0 auto;font-size:large;">
            <?php echo $this->_tpl_vars['countDownDay']; ?>
<?php echo $this->_tpl_vars['countDownHour']; ?>
<?php echo $this->_tpl_vars['countDownMinute']; ?>
<?php echo $this->_tpl_vars['countDownSecond']; ?>

        </div>
    <?php endif; ?>
<br />
<hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 />
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['settleMenu'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['footer'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>