<?php /* Smarty version 2.6.26, created on 2014-08-12 22:51:33
         compiled from /home/suraimu/templates/www/settleTelecomQuick.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'emoji', '/home/suraimu/templates/www/settleTelecomQuick.tpl', 31, false),array('modifier', 'number_format', '/home/suraimu/templates/www/settleTelecomQuick.tpl', 35, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['header'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link rel="stylesheet" href="css/settle.css" type="text/css" media="screen" />
</head>
<body>
<a name="top" id="top"></a>
<div id="wrap">
<div id="contents">
<div id="main">
<div class="mainBox">
<div id="titleItemlist">情報購入　ポイント追加</div>
<div id="settle">
<h3>商品のご確認</h3>
<?php if ($this->_tpl_vars['errMsg']): ?>
    <p class="err"><?php echo $this->_tpl_vars['errMsg']; ?>
</p>
<?php endif; ?>
<dl>
<dt>クレジットカード決済</dt>
<dd>
<span class="attention">※クイックチャージで決済されます</span><br />
下記の内容でよろしければボタンを押して下さい。<br />
</dd>
</dl>
<?php if ($this->_tpl_vars['itemList']): ?>
    <?php $_from = $this->_tpl_vars['itemList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
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
<?php endif; ?>

<form action="./?action_SettleTelecomQuickExec=1" method="post">
<?php echo $this->_tpl_vars['comFORMparam']; ?>

<?php echo $this->_tpl_vars['FORMparam']; ?>

<table class="tableItem" cellspacing="2">
<tr>
<th>決済金額</th>
<td>合計<?php echo ((is_array($_tmp=$this->_tpl_vars['orderingData']['pay_total'])) ? $this->_run_mod_handler('number_format', true, $_tmp, '0') : number_format($_tmp, '0')); ?>
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
<td colspan="2" class="link"><input name="submit" type="submit" value="決済する" /><br />
<span class="attention">※決済ボタンは1度だけ押して下さい</span></td>
</tr>
</table>
</form>
<div id="under">&nbsp;</div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['settleMenu'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
</div>
</div>
<?php echo $this->_tpl_vars['comImgTag']; ?>

</div>
</body>
</html>