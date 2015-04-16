<?php /* Smarty version 2.6.26, created on 2014-08-16 09:51:34
         compiled from /home/suraimu/templates/www/taikai.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', '/home/suraimu/templates/www/taikai.tpl', 29, false),array('modifier', 'emoji', '/home/suraimu/templates/www/taikai.tpl', 41, false),)), $this); ?>
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
 ?><div id="wrap">
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
<div id="titleTaikai">退会</div>
<?php if ($this->_tpl_vars['errMsg']): ?>
    <p class="err"><?php echo $this->_tpl_vars['errMsg']; ?>
</p>
<?php endif; ?>
<p>
<?php echo $this->_tpl_vars['config']['define']['SITE_NAME']; ?>
は無料で様々な有益なコンテンツ・情報を入手することが可能です。<br>
お客様への利益還元の感謝を込めて定期的な無料抽選会も開催しております。退会されると全ての権利(コンテンツ・情報・抽選会の参加)を全て失うことになります。<br>
<span style="color:#F00;font-size:24px;">退会せずメール配信停止だけの手続きも可能</span>です。
</p>
<div id="titleMailstop">配信停止</div>
<p>退会せずにお客様ご自身でサイトにログインして全ての権利(コンテンツ・情報・抽選会の参加)を受け取る事ができ<span style="color:#F00;font-size:24px;">所有ポイントも残りますので、退会手続きよりもオススメ</span>です。</p>
<form action="./?action_UpdateSendStatusExec=1" method="post">
<?php echo $this->_tpl_vars['comFORMparam']; ?>

<dl>
<dt>配信の変更</dt>
<div id="formBg">
<div id="formIn">
<?php if ($this->_tpl_vars['comUserData']['pc_address']): ?>
    PC：<?php echo smarty_function_html_options(array('name' => 'pc_is_mailmagazine','options' => $this->_tpl_vars['config']['web_config']['address_send_status'],'selected' => $this->_tpl_vars['comUserData']['pc_is_mailmagazine'],'id' => 'mailSelect','tabindex' => '7'), $this);?>

<?php endif; ?>
<?php if ($this->_tpl_vars['comUserData']['mb_address']): ?>
    &nbsp;&nbsp;携帯：<?php echo smarty_function_html_options(array('name' => 'mb_is_mailmagazine','options' => $this->_tpl_vars['config']['web_config']['address_send_status'],'selected' => $this->_tpl_vars['comUserData']['mb_is_mailmagazine'],'id' => 'mailSelect','tabindex' => '8'), $this);?>

<?php endif; ?>
<br />
<input name="regist3" type="image" tabindex="9" style="text-align:center;" onFocus="this.blur()" onMouseOver="this.src='./img/bt_updatechk_on.png'" onMouseOut="this.src='./img/bt_updatechk.png'" src="./img/bt_updatechk.png" alt="変更する" />
</div>
</div>
</dl>
</form>
<br />
<?php echo ((is_array($_tmp=$this->_tpl_vars['quitPrStartData'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>

<div id="centerP">
<form action="./?action_Home=1" method="post">
<?php echo $this->_tpl_vars['comFORMparam']; ?>

<input name="regist3" type="image" tabindex="10" style="text-align:center;" onFocus="this.blur()" onMouseOver="this.src='./img/bt_taikaistop_on.png'" onMouseOut="this.src='./img/bt_taikaistop.png'" src="./img/bt_taikaistop.png" alt="退会手続きを止める" />
</form>
<form action="./?action_TaikaiChk=1" method="post">
<?php echo $this->_tpl_vars['comFORMparam']; ?>

<input name="regist3" type="image" tabindex="11" style="text-align:center;" onFocus="this.blur()" onMouseOver="this.src='./img/bt_taikai_on.png'" onMouseOut="this.src='./img/bt_taikai.png'" src="./img/bt_taikai.png" alt="退会手続きを進める" />
</form>
</div>
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