<?php /* Smarty version 2.6.26, created on 2014-08-11 16:03:25
         compiled from /home/suraimu/templates/www/settleTelecom.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'emoji', '/home/suraimu/templates/www/settleTelecom.tpl', 30, false),array('modifier', 'number_format', '/home/suraimu/templates/www/settleTelecom.tpl', 34, false),)), $this); ?>
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
下記の内容でよろしければ決済ページへお進み下さい。
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

<table class="tableItem" cellspacing="2">
<tr>
<th>ご決済金額</th>
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
<td colspan="2" class="link">
<form action="<?php echo $this->_tpl_vars['creditUrl']; ?>
" method="post">
<?php echo $this->_tpl_vars['creditHiddenTags']; ?>

<input name="submit" type="submit" value="SSL決済ページへ" /><br />
<span class="attention">※決済ボタンは1度だけ押して下さい</span>
</form>
</td>
</tr>
<tr>
<td colspan="2" class="link">
<?php if ($this->_tpl_vars['isQuick']): ?>
<span class="attention">前回のクレジットカードで決済する</span><br>
<form action="./?action_SettleTelecomQuick=1<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>" method="post">
<?php echo $this->_tpl_vars['comFORMparam']; ?>

<?php echo $this->_tpl_vars['FORMparam']; ?>

<input name="submit" type="submit" value="確認する" /><br />
</form>
<?php endif; ?>
</td>
</tr>
</table>

<div id="under">&nbsp;</div>
</div>
<p>
デジタルコンテンツという商品の性質上、ご購入後の返品・交換・払い戻しは、原則としてお受けできませんのでご了承ください。<br />
<span class="attention">※注意事項</span><br />
アナタ様の個人情報を守る為、SSL(暗号化)通信を導入しております。<br />
カード会社から発行の明細書には｢TELECOM名義｣で請求されます。<br />
カード決済に関するお問い合わせ先はTELECOM【TEL】03-3457-9124（24時間365日）<br />
【E-mail】info@telecomcredit.co.jpまでお願い致します。<br />
</p>
<table border="0">
<tr>
<td align="center">
カード決済に関するお問い合わせ<br>
決済システムは(株)テレコムを利用しています<br>
TEL:03-3457-9124（24時間365日）<br>
<a href="mailto:info@telecomcredit.co.jp">info@telecomcredit.co.jp</a><br>
情報の利用・内容の如何にかかわらず会員が支払った料金の<br>
返金は一切行わないものとします。<br>
</td>
</tr>
</table>
<p>
<span class="attention">※他の決済方法に変更する場合はコチラ</span><br />
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