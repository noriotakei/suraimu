<?php /* Smarty version 2.6.26, created on 2014-08-14 19:55:27
         compiled from /home/suraimu/templates/mobile/taikai.tpl */ ?>
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
<img src="img/title.gif" alt="<?php echo $this->_tpl_vars['siteName']; ?>
" width="100%" />
<div style="text-align:center;">退会手続き</div>
<hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 />
<?php if ($this->_tpl_vars['errMsg']): ?><span style="color:#f00;font-size:small;"><?php echo $this->_tpl_vars['errMsg']; ?>
</span><br /><hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 /><?php endif; ?>
高配当.comは無料で様々な有益なコンテンツ・情報を入手することが可能です。お客様への利益還元の感謝を込めて定期的な無料抽選会も開催しております。退会されると全ての権利(コンテンツ・情報・抽選会の参加)を全て失うことになります。退会せずメール配信停止だけの手続きも可能です。<br />
<hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 />
<div style="background-color:#06c;color:#fff;font-size:small;">
配信停止
</div>
メール配信が不要な場合は配信停止の設定が可能です。退会せずにお客様ご自身でサイトにログインして全ての権利(コンテンツ・情報・抽選会の参加)を受け取る事ができ所有ポイントも残りますので、退会手続きよりもオススメです。
<br>
<div style="text-align:center;"><a href="./?action_Update=1<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>"><span style="color:#fff;">配信停止の手続きはこちら!</span></a></div><br>
<hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 />
<div style="text-align:center;color:#000;">
<form action="./?action_Home=1<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>" method="post">
<input value="退会手続きを止める" type="submit" />
</form>
</div>
<hr <?php echo $this->_tpl_vars['hr_1style']; ?>
 />
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['quitPrStart'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div style="text-align:center;color:#000;">
<form action="./?action_TaikaiChk=1<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>" method="post">
<input value="退会手続きを進める" type="submit" />
</form>
</div>
<hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 />
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['footer'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>