{if $infoStatusData.is_all_display}
    {include file=$headerAllDisplay}
    </head>
    {eval var=$infoStatusData.html_text_pc|emoji}
    {$comImgTag}
{else}
    {include file=$header}
    </head>
    <body>
    <a name="top" id="top"></a>
    {include file=$status}
    <div id="wrap">
    <div id="imageArea">{include file=$headCampaign}</div>
    {include file=$headerMenu}
    <div id="contents">
    <div id="main">

    {eval var=$infoStatusData.html_text_pc|emoji}

    </div>
    {include file=$side}
    </div>
    {include file=$footer}
    </div>
{/if}
</body>
</html>