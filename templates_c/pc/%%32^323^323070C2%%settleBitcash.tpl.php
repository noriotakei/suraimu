<?php /* Smarty version 2.6.26, created on 2014-08-10 08:45:22
         compiled from /home/suraimu/templates/www/settleBitcash.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'emoji', '/home/suraimu/templates/www/settleBitcash.tpl', 31, false),array('modifier', 'number_format', '/home/suraimu/templates/www/settleBitcash.tpl', 35, false),)), $this); ?>
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
<dt>Bitcash決済</dt>
<dd>
<a href="http://www.bitcash.co.jp/i/sheet/index.html">※詳しい説明はｺﾁﾗから</a><br />
<a href="https://secure.bitcash.jp/my/bitcash/merge/">※残高引継ぎ(金額をまとめる)はｺﾁﾗから</a>
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
<form action="./?action_SettleBitcashExec=1" method="post">
<?php echo $this->_tpl_vars['comFORMparam']; ?>

<?php echo $this->_tpl_vars['FORMparam']; ?>

<table class="tableItem" cellspacing="2">
<tr>
<th colspan="2" class="cols">ひらがな16文字のｶｰﾄﾞ番号を入力してください。</th>
</tr>
<tr>
<td colspan="2" class="link"><input name="card_number" size="32" maxlength="32" type="text" value="<?php echo $this->_tpl_vars['value']['card_number']; ?>
" tabindex="7"/></td>
</tr>
<tr>
<th>ご決済金額</th>
<td><?php echo ((is_array($_tmp=$this->_tpl_vars['orderingData']['pay_total'])) ? $this->_run_mod_handler('number_format', true, $_tmp, '0') : number_format($_tmp, '0')); ?>
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
<td colspan="2" class="link"><input name="submit" type="submit" value="BITCASHで決済" /></td>
</tr>
</table>
</form>
<div id="under">&nbsp;</div>
</div>
<p>
デジタルコンテンツという商品の性質上、ご購入後の返品・交換・払い戻しは、原則としてお受けできませんのでご了承ください。<br />
<span class="attentionY">※注意事項</span><br />
・BITCASHの種類は【EX】をご購入ください。【ST】は御利用いただけません。<br />
・必ず【16桁ひらがなIDを入力】【BITCASHで決済】をお願いいたします。BITCASHｶｰﾄﾞの購入だけでは決済が完了されません！<br />
・ご購入にあたっては利用規約に同意いただく必要があります。 <br />
・必ず購入にあたっては<a href="./?action_Rule=1<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>" title="利用規約" target="_blank">利用規約</a>に同意いただく必要があります。<br />
・<a href="http://www.bitcash.jp/docs/terms/memberstore/" target="blank" />※資金決済法に基づく表示</a>
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