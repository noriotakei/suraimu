{if $infoStatusData.is_all_display}
{include file=$header}
</head>
{eval var=$infoStatusData.html_text_mb|emoji}
<hr {$hr_1style} />
{include file=$footer}
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