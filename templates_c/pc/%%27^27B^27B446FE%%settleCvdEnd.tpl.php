<?php /* Smarty version 2.6.26, created on 2014-08-13 08:01:17
         compiled from /home/suraimu/templates/www/settleCvdEnd.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'zend_date_format', '/home/suraimu/templates/www/settleCvdEnd.tpl', 31, false),array('modifier', 'number_format', '/home/suraimu/templates/www/settleCvdEnd.tpl', 35, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['header'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</head>
<body>
<a name="top" id="top"></a>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['status'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="wrap">
<div id="imageArea"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['headCampaign'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['headerMenu'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="contents">
<div id="main">
<div class="mainBox">
<div id="titleItemlist">情報購入 ポイント追加</div>
<div id="settle">
<h3>コンビニ決済のご確認</h3>
<dl>
<dt>コンビニ決済</dt>
<dd>お申込み内容</dd>
</dl>

<table class="tableItem" cellspacing="2">
<tr>
<th>コンビニ選択</th>
<td><?php echo $this->_tpl_vars['cvName'][$this->_tpl_vars['cvdData']['store_cd']]; ?>
 </td>
</tr>
<tr>
<th>お申込み番号</th>
<td><?php echo $this->_tpl_vars['cvdData']['number']; ?>
</td>
</tr>
<tr>
<th>お申込み有効期限</th>
<td ><?php echo ((is_array($_tmp=$this->_tpl_vars['cvdData']['pay_limit_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy年MM月dd日') : smarty_modifier_zend_date_format($_tmp, 'yyyy年MM月dd日')); ?>
</td>
</tr>
<tr>
<th>決済金額</th>
<td><?php echo ((is_array($_tmp=$this->_tpl_vars['cvdData']['pay_money'])) ? $this->_run_mod_handler('number_format', true, $_tmp, '0') : number_format($_tmp, '0')); ?>
円</td>
</tr>
</table>
<div id="under">&nbsp;</div>
</div>
<p class="attention">※まだ決済は完了しておりません</p>
<p>
<span class="attentionY">※注意事項</span><br />
万一決済が正常に終了しない場合は、コンビニダイレクトカスタマーサポート(0570-000-555)までご連絡ください。<br />
メールや受付番号の再発行等は一切いたしませんので、削除せず大切に保管してください。<br />
払込後にポイントが追加されない等のトラブルは直接加盟店様へお問い合わせください。<br />
お申し込み後はお早めにお支払いをお願いいたします。お申し込みがキャンセルとなる場合がございます。<br />
ご購入にあたっては<a href="./?action_Rule=1<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>" title="利用規約" target="_blank">利用規約</a>に同意いただく必要があります。 <br />
<br />
※入金反映時間について<br />
ファミリーマート　⇒　ご入金後10～30分程度<br />
ローソン・セイコーマート　⇒　ご入金後2～3時間程度<br />
※なお回線状況等で反映が遅れる場合がございますので予め時間に余裕を持った早めのお手続きをお願い申し上げます。<br />
</p>
</div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['side'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['footer'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
</body>
</html>