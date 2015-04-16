{if $preInfoStatusData.is_all_display}
    {include file=$preHeaderAllDisplay}
    </head>
    {eval var=$preInfoStatusData.html_text_pc|emoji}
{else}
    {include file=$preHeader}
    </head>
    <body>
    <a name="top" id="top"></a>
    {include file=$loginForm}
    <div id="wrap">
    <div id="imageArea">{include file=$preHeadCampaign}</div>
    {include file=$preHeaderMenu}
    <div id="contents">
    <div id="main">
    {eval var=$preInfoStatusData.html_text_pc|emoji}
    </div>
    {include file=$preSide}
    </div>
    {include file=$preFooter}
    </div>
{/if}
</body>
</html>