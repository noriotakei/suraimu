<?php /* Smarty version 2.6.26, created on 2014-08-10 06:16:27
         compiled from /home/suraimu/templates/mobile/settleBitcash.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'emoji', '/home/suraimu/templates/mobile/settleBitcash.tpl', 23, false),array('modifier', 'number_format', '/home/suraimu/templates/mobile/settleBitcash.tpl', 29, false),)), $this); ?>
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
<div style="text-align:center;">
BITCASH決済
</div>
<hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 />
<?php if ($this->_tpl_vars['errMsg']): ?><span style="color:#f00;font-size:small;"><?php echo $this->_tpl_vars['errMsg']; ?>
</span><br /><hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 /><?php endif; ?>
<span style="color:#fc0;"><a href="http://www.bitcash.co.jp/i/sheet/index.html">※詳しい説明はｺﾁﾗから</a></span><br />
<span style="color:#fc0;"><a href="https://secure.bitcash.jp/my/bitcash/merge/">※残高引継ぎ(金額をまとめる)はｺﾁﾗから</a></span><br />
<hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 />
<span style="color:#f00;font-size:small;">【商品のご確認】</span><br />
下記の内容でよろしければ決済ページへお進み下さい。<br /><br />
<?php if ($this->_tpl_vars['itemList']): ?>
    <?php $_from = $this->_tpl_vars['itemList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
        <table border="0" width="100%">
        <tr>
        <td width="20%"><span style="color:#c93;font-size:small;">内容：</span>
        </td>
        <td width="80%"><span style="color:#ffa500;"><?php echo ((is_array($_tmp=$this->_tpl_vars['val']['html_text_name_mb'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>
</span>
        </td>
        </tr>
        <tr>
        <td width="20%"><span style="color:#c93;font-size:small;">価格：</span>
        </td>
        <td width="80%"><?php echo ((is_array($_tmp=$this->_tpl_vars['val']['price'])) ? $this->_run_mod_handler('number_format', true, $_tmp, '0') : number_format($_tmp, '0')); ?>
円</td>
        </tr>
        </table>
        <img src="img/line_b.gif" width="100%" />
    <?php endforeach; endif; unset($_from); ?>
    <br />
    <?php endif; ?>
<br />
<form action="./?action_SettleBitcashExec=1<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>" method="post">
<?php echo $this->_tpl_vars['FORMparam']; ?>

<table align="center" border="0" width="90%">
<tr>
<td bgcolor="#336600"><span style="color:#cf0;font-size:small;">▼ひらがな16文字のｶｰﾄﾞ番号を入力してください。</span></td>
</tr>
<tr>
<td><input name="card_number" size="32" maxlength="32" type="text" value="<?php echo $this->_tpl_vars['value']['card_number']; ?>
"/></td>
</tr>
<tr>
<td bgcolor="#336600"><span style="color:#cf0;font-size:small;">▼決済金額</span></td>
</tr>
<tr>
<td><?php echo ((is_array($_tmp=$this->_tpl_vars['orderingData']['pay_total'])) ? $this->_run_mod_handler('number_format', true, $_tmp, '0') : number_format($_tmp, '0')); ?>
円</td>
</tr>
<!--カウントダウン -->
<?php if ($this->_tpl_vars['showCountDown']): ?>
<tr>
<td bgcolor="#336600"><span style="color:#cf0;font-size:small;">▼締切まで残時間</span></td>
</tr>
<tr>
<td><?php echo $this->_tpl_vars['countDownDay']; ?>
<?php echo $this->_tpl_vars['countDownHour']; ?>
<?php echo $this->_tpl_vars['countDownMinute']; ?>
<?php echo $this->_tpl_vars['countDownSecond']; ?>
</td>
</tr>
<?php endif; ?>
</table>
<div style="text-align:center;color:#000;">
▼　▼　▼<br />
<input value="BITCASHで決済" type="submit" />
</div>
</form>
<hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 />
デジタルコンテンツという商品の性質上、ご購入後の返品・交換・払い戻しは、原則としてお受けできませんのでご了承ください。<br />
<span style="color:#fc0;font-size:small;">※注意事項</span><br />
・BITCASHの種類は【EX】をご購入ください。【ST】は御利用いただけません。<br />
・必ず【16桁ひらがたなIDを入力】【BITCASHで決済】をお願いいたします。BITCASHｶｰﾄﾞの購入だけでは決済が完了されません!<br />
・ご購入にあたっては利用規約に同意いただく必要があります。 <br />
・ご購入にあたっては<a href="./?action_Rule=1<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>">利用規約</a>に同意いただく必要があります。<br />
・<a href="http://m.bitcash.jp/docs/terms/memberstore/">※資金決済法に基づく表示</a>
<br />
<hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 />
<span style="color:#00ccec;font-size:small;">※他の決済方法に変更する場合はコチラ</span><br />
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['settleMenu'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo $this->_tpl_vars['comImgTag']; ?>

</body>
</html>