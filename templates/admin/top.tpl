{$docType}
<head>
<meta http-equiv="Content-Type" content="{$contentType} charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>{$siteName}管理画面</title>
<link rel="shortcut icon" type="image/x-icon"  href="ko-haito_favicon.ico" />
</head>

<frameset cols="250,*" frameborder="no" border="0" framespacing="0">
<frame src="{make_link action="action_menu" getTags=$getTag}" name="menu" id="leftFrame" title="leftFrame" />
<frame src="{make_link action="action_user_Search" getTags=$getTag}" name="contents" id="mainFrame" title="mainFrame" />
</frameset>
<noframes></noframes>

</html>
