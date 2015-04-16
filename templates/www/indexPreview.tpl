{include file=$preHeader}
</head>
<body>
<a name="top" id="top"></a>
{include file=$loginForm}
<div id="wrap">
{include file=$preHeadCampaign}
{include file=$preHeaderMenu}
{include file=$registForm}
<div id="contents">
<div id="main">
<div class="mainBox">
{eval var=$registPageData.page_html_pc|emoji}
</div>
</div>
{include file=$preSide}
</div>
{include file=$preFooter}
</div>
</body>
</html>
