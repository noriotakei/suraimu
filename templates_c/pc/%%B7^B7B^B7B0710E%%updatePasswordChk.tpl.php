<?php /* Smarty version 2.6.26, created on 2014-08-13 00:40:44
         compiled from /home/suraimu/templates/www/updatePasswordChk.tpl */ ?>
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
<div id="titleUpdate">登録情報の変更</div>
<p>【変更内容の確認】<br />
下記の内容でよろしければ「変更する」ボタンを押して下さい。</p>
<form action="./?action_UpdatePasswordExec=1" method="post">
<?php echo $this->_tpl_vars['comFORMparam']; ?>

<?php echo $this->_tpl_vars['POSTparam']; ?>

<dl>
<dt>現パスワード</dt>
<div id="formBg">
<div id="formIn"><?php echo $this->_tpl_vars['oldPassword']; ?>
</div>
</div>
<dt>新パスワード</dt>
<div id="formBg">
<div id="formIn"><?php echo $this->_tpl_vars['newPassword']; ?>
</div>
</div>
</dl>
<p id="centerP">
<input name="regist3" type="image" tabindex="10" style="text-align:center;" onFocus="this.blur()" onMouseOver="this.src='./img/bt_updatechk_on.png'" onMouseOut="this.src='./img/bt_updatechk.png'" src="./img/bt_updatechk.png" alt="変更する" />
</p>
</form>
<br />
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