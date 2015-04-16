{if $isAllDisplay}
    {include file=$preHeaderAllDisplay}
    </head>
    {eval var=$displayInfoStatusData|emoji}
{else}
    {include file=$preHeader}
    </head>
    <body>
    {include file=$loginForm}
    <div id="wrap">
    <div id="contents">
    <div id="main">
    {if $param.banner_pc}
    <div class="mainBox">
    {eval var=$displayInfoStatusData|emoji}
    </div>
    {else}
    {eval var=$displayInfoStatusData|emoji}
    {/if}
    </div>
    {include file=$preSide}
    </div>
    {include file=$preFooter}
    </div>
{/if}

</body>
</html>
