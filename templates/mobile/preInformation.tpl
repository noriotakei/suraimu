{if $preInfoStatusData.is_all_display}
    {include file=$preHeader}
    </head>
    {eval var=$preInfoStatusData.html_text_mb|emoji}
{else}
    {include file=$preHeader}
    </head>
    {eval var=$preInfoStatusData.html_text_mb|emoji}
    {include file=$preContentsMenu}
    {include file=$easyLogin}
    {include file=$preFooterMenu}
    {include file=$preFooter}
{/if}
</body>
</html>