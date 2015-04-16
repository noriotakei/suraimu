<?php /* Smarty version 2.6.26, created on 2014-08-08 16:56:48
         compiled from /home/suraimu/templates/mobile/settleBank.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'emoji', '/home/suraimu/templates/mobile/settleBank.tpl', 12, false),array('modifier', 'number_format', '/home/suraimu/templates/mobile/settleBank.tpl', 51, false),array('modifier', 'cat', '/home/suraimu/templates/mobile/settleBank.tpl', 86, false),)), $this); ?>
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
銀行振込
</div>
<hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 />
<?php if ($this->_tpl_vars['errMsg']): ?><span style="color:#f00;font-size:small;"><?php echo $this->_tpl_vars['errMsg']; ?>
</span><br /><hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 /><?php endif; ?>
<?php if ($this->_tpl_vars['mailFlag']): ?><span style="color:#ff0;"><?php echo ((is_array($_tmp="")) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>
</span><?php echo $this->_tpl_vars['mailFlag']; ?>
<br /><?php endif; ?>
<br />
<div style="width:90%;background:#360;color:#CF0;text-align:center;margin:0 auto;font-size:small;">▼商品内容</div>
<div style="width:90%;background:#000;color:#FFF;text-align:center;margin:0 auto;font-size:large;">
<?php if ($this->_tpl_vars['itemList']): ?>
    <?php $_from = $this->_tpl_vars['itemList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
      <?php echo ((is_array($_tmp=$this->_tpl_vars['val']['html_text_name_mb'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>

    <?php endforeach; endif; unset($_from); ?>
<?php endif; ?>
</div>
<div style="width:90%;background:#360;color:#CF0;text-align:center;margin:0 auto;font-size:small;">▼合計金額</div>
<div style="width:90%;background:#000;color:#FFF;text-align:center;margin:0 auto;font-size:large;">
<?php echo ((is_array($_tmp=$this->_tpl_vars['orderingData']['pay_total'])) ? $this->_run_mod_handler('number_format', true, $_tmp, '0') : number_format($_tmp, '0')); ?>
円
</div>
<div style="width:90%;background:#360;color:#CF0;text-align:center;margin:0 auto;font-size:small;">▼振込名義</div>
<div style="width:90%;background:#000;color:#FFF;text-align:center;margin:0 auto;font-size:large;">
<?php echo $this->_tpl_vars['orderingData']['id']; ?>
<br>
<span style="color:#f00;font-size:small;">
※お振込名義IDは毎回違います。</span>
</div>
<!--カウントダウン -->
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
<div style="width:90%;background:#360;color:#CF0;text-align:center;margin:0 auto;font-size:large;">【お振込先】</div>
<div style="width:90%;background:#000;color:#FFF;text-align:center;margin:0 auto;font-size:large;border:1px solid #360;">
<?php echo $this->_tpl_vars['bankName']; ?>
<br>
<?php echo $this->_tpl_vars['branchName']; ?>
<br>
<?php echo $this->_tpl_vars['accountNumber']; ?>
<br>
<?php echo $this->_tpl_vars['transferDestination']; ?>

</div>
<br />
<hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 />
デジタルコンテンツという商品の性質上、ご購入後の返品・交換・払い戻しは、原則としてお受けできませんのでご了承ください。<br />
<span style="color:#fc0;font-size:small;">※注意事項</span><br />
お振り込みは<span style="color:#f00;">電信扱い</span>にてお願いいたします<br />
午後3時をすぎたお振込の場合、ポイントの追加は翌日（金曜、祝日等は銀行の翌営業日）となります<br />
※楽天銀行からのお振込みは24時間365日、即時の自動確認となります。<br />
ポイントの追加がされるまで、振込明細書（振込控え）は捨てずにお持ちください<br />
お振込名義ID（<b><span style="color:#f00;"><?php echo $this->_tpl_vars['orderingData']['id']; ?>
</span></b>）が確認できない場合、弊社では一切責任を負いかねます<br />
振り込み手数料はお客様のご負担となります<br />
お振込からポイント追加まで若干時間がかかる場合がございます<br />
その他、ご不明な点がありましたら<a href="mailto:<?php echo ((is_array($_tmp=$this->_tpl_vars['operationMailAccount'])) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['config']['define']['MAIL_DOMAIN']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['config']['define']['MAIL_DOMAIN'])); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['operationMailAccount'])) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['config']['define']['MAIL_DOMAIN']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['config']['define']['MAIL_DOMAIN'])); ?>
</a>までご連絡ください<br />
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