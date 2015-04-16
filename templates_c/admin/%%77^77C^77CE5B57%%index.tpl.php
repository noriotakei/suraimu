<?php /* Smarty version 2.6.26, created on 2014-08-08 17:25:23
         compiled from /home/suraimu/templates/admin//index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_image', '/home/suraimu/templates/admin//index.tpl', 11, false),array('modifier', 'count', '/home/suraimu/templates/admin//index.tpl', 20, false),array('modifier', 'implode', '/home/suraimu/templates/admin//index.tpl', 25, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</head>
<body>
<div id="KingCol">
<h1 class="SiteName"><?php echo $this->_tpl_vars['config']['define']['SITE_NAME']; ?>
管理画面</h1>
<div id="QueenCol" class="ClearBox">

<div id="LeftCol">
<h3 class="MenuH3">サイト概要</h3>
<ul class="MenuBox">
<li><?php echo smarty_function_html_image(array('file' => "./img/sitelogo.gif",'border' => '0','width' => '190'), $this);?>
</li>
<li>運営会社：<?php echo $this->_tpl_vars['config']['define']['CAMPANY']; ?>
</li>
</ul>
</div>

<div id="RightCol">
<div id="RightColFloatHack">

<h2 id="LoginTitle">Login...</h2>
<?php if (count($this->_tpl_vars['errMsg'])): ?>
    <div class="ui-widget warning">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    <?php $_from = $this->_tpl_vars['errMsg']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
        <?php echo implode($this->_tpl_vars['val'], "<br>"); ?>

    <?php endforeach; endif; unset($_from); ?>    </p>
    </div>
    </div>
<?php endif; ?>
<form action="./" method="POST" target="_top">
<table border="0" cellspacing="0" cellpadding="0" id="LoginForm">
<tr>
<td>ID<input type="text" name="login_id" size="10" /></td>
<td>Password<input type="password" name="password" size="15" /></td>
<td><input type="submit" name="action_Login" value="++  LOGIN  ++" /></td>
</tr>
</table>
</form>

</div>
</div>

</div>
<div id="FootCol">Powerd by <?php echo $this->_tpl_vars['config']['define']['CAMPANY']; ?>
</div>
</div>
</body>
</html>