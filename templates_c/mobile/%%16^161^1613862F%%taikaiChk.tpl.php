<?php /* Smarty version 2.6.26, created on 2014-08-14 19:56:07
         compiled from /home/suraimu/templates/mobile/taikaiChk.tpl */ ?>
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
<hr <?php echo $this->_tpl_vars['hr_1style']; ?>
 />
<?php if ($this->_tpl_vars['errMsg']): ?><span style="color:#f00;font-size:small;"><?php echo $this->_tpl_vars['errMsg']; ?>
</span><br /><hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 /><?php endif; ?>
ページ最下部の『※退会する※』のボタンを押せば退会処理が完了します。
<br /><br />
<span style="color:#f00;">が！その前に･･･</span>
<br /><br />
競馬はギャンブル、ギャンブルは負ける、とお考えの方が多いですが、当サイトは競馬をギャンブルとしてではなく、投資と考えております。下記の的中証明をご覧ください。<br /><img src="img/verification.gif" alt="的中証明" width="200px" height="170px"/><br />
競馬という投資で、わずか１００円玉１枚が、<span style="color:#f00;">２３８万１６６０円</span>に化けるのです。
<br /><br />
イメージしてみてください。わずか１分でこのような大金を獲得できる自分を。初心者の方、未経験の方でも最初からわかりやすく、競馬の楽しみ方、携帯での馬券の買い方を丁寧に説明いたします。まずは一度、無料情報・ポイント情報・キャンペーン情報などで的中を体感してみてください。
<br /><br />
きっと競馬の楽しみ方、儲け方がわかって頂けると思います。<span style="color:#f00;">明日、１００万馬券を的中させるのは貴方です！</span>
<br /><br />
<div style="text-align:center;color:#000;">
<form action="./?action_Home=1<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>" method="post">
<input value="退会手続きを止める" type="submit" />
</form></div>
<hr <?php echo $this->_tpl_vars['hr_1style']; ?>
 />
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['quitPr'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div style="text-align:center;color:#000;">
<form action="./?action_TaikaiExec=1<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>" method="post">
<input value="※退会する※" type="submit" />
</form>
</div>
<hr <?php echo $this->_tpl_vars['hr_1style']; ?>
 />
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['footer'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>