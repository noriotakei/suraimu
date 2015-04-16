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
<div class="mainBox">
{include file=$order}
<br>
{include file=$cart}
<br>
{foreach from=$dispInformationList item="infoList"}
    {eval var=$infoList.html_text_banner_pc|emoji}
{/foreach}
</div>
</div>
{include file=$side}
</div>
{include file=$footer}
</div>
</body>
</html>