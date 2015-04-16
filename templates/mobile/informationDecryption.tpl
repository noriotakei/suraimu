{if $infoStatusData.is_all_display}
{$xml}
{$docType}
<title>{$siteName}</title>
<meta http-equiv="Content-Type" content="{$contentType} charset=Shift_JIS" />
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta name="robots" content="all" />
<meta name="robots" content="index,follow" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<link rel="alternate" media="handheld" href="" />
<style type="text/css" media="handheld">
<![CDATA[
a:link   {ldelim}color:{$bodyLink};{rdelim}
a:focus  {ldelim}color:{$bodyFocus};{rdelim}
a:visited{ldelim}color:{$bodyVisited};{rdelim}
]]>
</style>

</head>
{eval var=$infoStatusData.html_text_mb|emoji}

{* アフィリエイトタグ *}
{$comImgTag}


{else}
{include file=$header}
</head> 
{eval var=$infoStatusData.html_text_mb|emoji}
{include file=$contentsMenu}
{include file=$status}
{include file=$footerMenu}
{include file=$footer}
{/if}
</body>
</html>