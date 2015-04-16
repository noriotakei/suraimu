<?php /* Smarty version 2.6.26, created on 2014-08-11 19:24:22
         compiled from /home/suraimu/templates/mobile/settleCredit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'emoji', '/home/suraimu/templates/mobile/settleCredit.tpl', 21, false),array('modifier', 'number_format', '/home/suraimu/templates/mobile/settleCredit.tpl', 27, false),)), $this); ?>
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
クレジットカード決済
</div>
<hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 />
<?php if ($this->_tpl_vars['errMsg']): ?><span style="color:#f00;font-size:small;"><?php echo $this->_tpl_vars['errMsg']; ?>
</span><br /><hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 /><?php endif; ?>
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
<table align="center" bgcolor="#005000" border="0" width="100%">
<tr>
<td align="center">合計 :<span style="color:#ff0;"><?php echo ((is_array($_tmp=$this->_tpl_vars['orderingData']['pay_total'])) ? $this->_run_mod_handler('number_format', true, $_tmp, '0') : number_format($_tmp, '0')); ?>
</span>円</td>
</tr>
<!--カウントダウン -->
<?php if ($this->_tpl_vars['showCountDown']): ?>
<tr>
<td align="center">締切まで残時間 :<span style="color:#ff0;"><?php echo $this->_tpl_vars['countDownDay']; ?>
<?php echo $this->_tpl_vars['countDownHour']; ?>
<?php echo $this->_tpl_vars['countDownMinute']; ?>
<?php echo $this->_tpl_vars['countDownSecond']; ?>
</span></td>
</tr>
<?php endif; ?>
</table>
<?php if ($this->_tpl_vars['isQuick']): ?>
前回のクレジットカードで決済する<br>
<form action="./?action_SettleCreditQuick=1<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>" method="post">
<?php echo $this->_tpl_vars['FORMparam']; ?>

<div style="text-align:center;color:#000;">▼　▼　▼<br /><input value="確認する" type="submit" />
</div>
</form>
<hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 />
別のクレジットカードで決済する
<?php endif; ?>
<form action="<?php echo $this->_tpl_vars['creditUrl']; ?>
" method="post">
<?php echo $this->_tpl_vars['creditHiddenTags']; ?>

<div style="text-align:center;color:#000;">▼　▼　▼<br /><input value="SSL決済ページへ" type="submit" />
</div>
</form>
<hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 />
デジタルコンテンツという商品の性質上、ご購入後の返品・交換・払い戻しは、原則としてお受けできませんのでご了承ください。<br />
<span style="color:#fc0;font-size:small;">※注意事項</span><br />
アナタ様の個人情報を守る為、SSL(暗号化)通信を導入しております。<br />
カード会社から発行の明細書には「AXES」または「EC PAY」で請求されます。<br />
カード決済に関するお問い合わせ先はAXESまで<br />
<table border="0">
<tr>
<td align="center">
<a href="https://gw.axes-payment.com/cgi-bin/mobile_exp.cgi?clientip=<?php echo $this->_tpl_vars['settleClientIp']; ?>
" target="_blink">
クレジットカード決済に関するご説明<br>必ずお読みください</a><br><br>
カード決済に関するお問い合わせ<br>
決済システムは（株）アクシズを利用しています<br>
TEL:0570-03-6000（TEL03-3498-6200）<br>
<a href="mailto:creditinfo@axes-payment.co.jp">creditinfo@axes-payment.co.jp</a><br>
ゼロカスタマーサポート（24時間365日)<br>
</td>
</tr>
</table>
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