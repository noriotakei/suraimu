<?php /* Smarty version 2.6.26, created on 2014-08-08 15:50:39
         compiled from /home/suraimu/templates/www/settleBank.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'emoji', '/home/suraimu/templates/www/settleBank.tpl', 28, false),array('modifier', 'number_format', '/home/suraimu/templates/www/settleBank.tpl', 32, false),array('modifier', 'cat', '/home/suraimu/templates/www/settleBank.tpl', 97, false),array('function', 'html_options', '/home/suraimu/templates/www/settleBank.tpl', 79, false),)), $this); ?>
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
<div id="titleItemlist">情報購入 ポイント追加</div>
<div id="settle">
<h3>商品のご確認</h3>
<?php if ($this->_tpl_vars['errMsg']): ?>
    <p class="err"><?php echo $this->_tpl_vars['errMsg']; ?>
</p>
<?php endif; ?>
<dl>
<dt>銀行振り込み</dt>
<dd>お早めにご決済完了をお願い致します！</dd>
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
<div style="font-size:large;">
<table class="tableItem" cellspacing="2">
<tr>
<th>ご決済金額</th>
<td class="attention"><?php echo ((is_array($_tmp=$this->_tpl_vars['orderingData']['pay_total'])) ? $this->_run_mod_handler('number_format', true, $_tmp, '0') : number_format($_tmp, '0')); ?>
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
</table>
<table class="tableItem" cellspacing="2">
<tr>
<th>お振込み先</th>
<td><?php echo $this->_tpl_vars['bankName']; ?>
<br><?php echo $this->_tpl_vars['branchName']; ?>
<br><?php echo $this->_tpl_vars['accountNumber']; ?>
<br><?php echo $this->_tpl_vars['transferDestination']; ?>
</td>
</tr>
<tr>
<th>振込名義</th>
<td><?php echo $this->_tpl_vars['orderingData']['id']; ?>
</td>
</tr>
</table>
</div>
<p class="attentionY">※お振込み名義ID【<?php echo $this->_tpl_vars['orderingData']['id']; ?>
】は商品ごと･注文ごとに、毎回違います。</p>

<form action="./?action_SettleBank=1&mail=1" method="post">
<?php echo $this->_tpl_vars['comFORMparam']; ?>

<?php echo $this->_tpl_vars['FORMparam']; ?>

<table class="tableItem" cellspacing="2">
<tr>
<td class="link">
<span style="color:#339900;">携帯アドレスを登録すればメモいらずで大変便利。<br>登録もここから無料でできます!!</span><br>
<?php if ($this->_tpl_vars['mailMsg']): ?>
<span class="attentionR"><?php echo $this->_tpl_vars['mailMsg']; ?>
</span><br>
<?php endif; ?>
<input type="text" name="mb_mail_account" value="<?php echo $this->_tpl_vars['mb_mail_account']; ?>
" style="width:200px; margin:10px 5px 0 0;" tabindex="7">＠<?php echo smarty_function_html_options(array('name' => 'mb_mail_domain','options' => $this->_tpl_vars['config']['web_config']['mobile_mail_domain'],'selected' => $this->_tpl_vars['mb_mail_domain'],'tabindex' => '8'), $this);?>

<br>
<input name="submit" type="submit" value="振込先を携帯電話にメールする" style="margin-top:10px;" /></td>
</tr>
</table>
</form>
<div id="under">&nbsp;</div>
</div>
<p>
デジタルコンテンツという商品の性質上、ご購入後の返品・交換・払い戻しは、原則としてお受けできませんのでご了承ください。<br />
<span class="attentionY">※注意事項</span><br />
お振り込みは<span class="attention">電信扱い</span>にてお願いいたします<br />
午後3時をすぎたお振込の場合、ポイントの追加は翌日（金曜、祝日等は銀行の翌営業日）となります<br />
※楽天銀行からのお振込みは24時間365日、即時の自動確認となります。<br />
ポイントの追加がされるまで、振込明細書（振込控え）は捨てずにお持ちください<br />
お振込名義ID（<span class="attention"><?php echo $this->_tpl_vars['orderingData']['id']; ?>
</span>）が確認できない場合、弊社では一切責任を負いかねます<br />
振り込み手数料はお客様のご負担となります<br />
お振込からポイント追加まで若干時間がかかる場合がございます<br />
その他、ご不明な点がありましたら<a href="mailto:<?php echo ((is_array($_tmp=$this->_tpl_vars['operationMailAccount'])) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['config']['define']['MAIL_DOMAIN']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['config']['define']['MAIL_DOMAIN'])); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['operationMailAccount'])) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['config']['define']['MAIL_DOMAIN']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['config']['define']['MAIL_DOMAIN'])); ?>
</a>までご連絡ください<br />
</p>
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