{if $infoStatusData.is_all_display}

    {$xml}
    {$docType}
    <head>
    <title>CLOSED　DECRYPTION　SYSTEM</title>
    <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="cache-control" content="no-cache" />
    <link rel="shortcut icon" type="image/x-icon"  href="" />
    <script type="text/javascript" src="js/swfobject.js"></script>
    <!--[if lte IE 6]>
    <script type="text/javascript" src="./js/DD_belatedPNG_0.0.7a.js"></script>
    <script type="text/javascript">
    DD_belatedPNG.fix('.transparent');
    </script><![endif]-->

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