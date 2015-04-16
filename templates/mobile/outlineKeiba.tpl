{include file=$header}
</head>
<body {$bodyTag}>
<a name="top" id="top"></a>
<div style="font-size:x-small; text-align:left; {$limited_width}">
<img src="img/title.gif" alt="{$siteName}" width="100%" />
{eval var=$outlineKeibaData|emoji}
{include file=$contentsMenu}
{include file=$status}
{include file=$footerMenu}
{include file=$footer}
</body>
</html>