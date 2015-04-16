{include file=$preHeader}
</head>

{if $param.banner_mb}
<body {$bodyTag}>
<div style="font-size:x-small; text-align:left; {$limited_width}">
<img src="img/title.gif" alt="{$siteName}" width="100%" />
{/if}

{eval var=$displayInfoStatusData|emoji}

<hr {$hr_1style} />

{include file=$preFooter}
</body>
</html>