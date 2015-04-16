<?php /* Smarty version 2.6.26, created on 2014-08-08 17:19:40
         compiled from /home/suraimu/templates/admin/top.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'make_link', '/home/suraimu/templates/admin/top.tpl', 11, false),)), $this); ?>
<?php echo $this->_tpl_vars['docType']; ?>

<head>
<meta http-equiv="Content-Type" content="<?php echo $this->_tpl_vars['contentType']; ?>
 charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title><?php echo $this->_tpl_vars['siteName']; ?>
管理画面</title>
<link rel="shortcut icon" type="image/x-icon"  href="ko-haito_favicon.ico" />
</head>

<frameset cols="250,*" frameborder="no" border="0" framespacing="0">
<frame src="<?php echo smarty_function_make_link(array('action' => 'action_menu','getTags' => $this->_tpl_vars['getTag']), $this);?>
" name="menu" id="leftFrame" title="leftFrame" />
<frame src="<?php echo smarty_function_make_link(array('action' => 'action_user_Search','getTags' => $this->_tpl_vars['getTag']), $this);?>
" name="contents" id="mainFrame" title="mainFrame" />
</frameset>
<noframes></noframes>

</html>