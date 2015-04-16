<?php /* Smarty version 2.6.26, created on 2014-08-13 08:00:46
         compiled from /home/suraimu/templates/www/settleCvd.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'emoji', '/home/suraimu/templates/www/settleCvd.tpl', 27, false),array('modifier', 'number_format', '/home/suraimu/templates/www/settleCvd.tpl', 31, false),array('function', 'html_options', '/home/suraimu/templates/www/settleCvd.tpl', 43, false),)), $this); ?>
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
<dt>コンビニ決済</dt>
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
<form action="./?action_SettleCvdChk=1" method="post">
<?php echo $this->_tpl_vars['comFORMparam']; ?>

<?php echo $this->_tpl_vars['FORMparam']; ?>

<table class="tableItem" cellspacing="2">
<tr>
<th>コンビニ選択</th>
<td>
<?php echo smarty_function_html_options(array('name' => 'cv_cd','options' => $this->_tpl_vars['cvName'],'selected' => $this->_tpl_vars['value']['cv_cd'],'style' => "color:#000;",'tabindex' => '7'), $this);?>

</td>
</tr>
<tr>
<th>姓</th>
<td><input name="name1" style="ime-mode: active;" type="text" value="<?php echo $this->_tpl_vars['value']['name1']; ?>
" tabindex="8" /></td>
</tr>
<tr>
<th>名</th>
<td ><input name="name2" style="ime-mode: active;" type="text" value="<?php echo $this->_tpl_vars['value']['name2']; ?>
" tabindex="9" /></td>
</tr>
<tr>
<th>携帯電話番号</th>
<td><input name="telno" maxlength="11" style="ime-mode: disabled;" type="text" value="<?php echo $this->_tpl_vars['value']['telno']; ?>
" tabindex="10" /></td>
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
<td colspan="2" class="link">
<input name="submit" type="submit" tabindex="11" value="決済内容の確認" /></td>
</tr>
</table>
</form>
<div id="under">&nbsp;</div>
</div>
<p>
デジタルコンテンツという商品の性質上、ご購入後の返品・交換・払い戻しは、原則としてお受けできませんのでご了承ください。<br />
<span class="attentionY">※注意事項</span><br />
万一決済が正常に終了しない場合は、コンビニダイレクトカスタマーサポート(0570-000-555)までご連絡ください。<br />
メールや受付番号の再発行等は一切いたしませんので、削除せず大切に保管してください。<br />
払込後にポイントが追加されない等のトラブルは直接加盟店様へお問い合わせください。<br />
お申し込み後はお早めにお支払いをお願いいたします。お申し込みがキャンセルとなる場合がございます。<br />
ご購入にあたっては<a href="./?action_Rule=1<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>" title="利用規約" target="_blank">利用規約</a>に同意いただく必要があります。 <br />
<?php if ($this->_tpl_vars['isDisp']): ?>
※ご利用可能なコンビニチェーンについて<br>
セブンイレブンでのコンビニダイレクトは「ご利用が停止」となりました。<br>
セブンイレブン以外の他コンビニチェーンでは今まで同様に「ご利用が可能」でございます。<br />
<?php endif; ?>
<br />
※入金反映時間について<br />
ファミリーマート　⇒　ご入金後10～30分程度<br />
ローソン・セイコーマート・ミニストップ　⇒　ご入金後2～3時間程度<br />
※なお回線状況等で反映が遅れる場合がございますので予め時間に余裕を持った早めのお手続きをお願い申し上げます。<br />
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