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
<div class="mainBox">
<div id="titleAbout">当ｻｲﾄについて</div>
{eval var=$preAboutData|emoji}
</div>
</div>
{include file=$preSide}
</div>
{include file=$preFooter}
</div>
</body>
</html>