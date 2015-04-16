{include file=$preHeader}
</head>
<body>
<a name="top" id="top"></a>
{include file=$loginForm}
<div id="wrap">
{include file=$preHeadCampaign}
{include file=$preHeaderMenu}
{if $errMsg}
    <p class="err">{$errMsg}</p>
{/if}
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

<!-- Brandscreen Remarketing List Addition Code . Advertiser: May.inc. Name: Top -->
<img src="http://tags.rtbidder.net/track?sid=4ed4ba578bc06f15307d3e98" width="0" height="0" border="0" alt="" />

</html>
