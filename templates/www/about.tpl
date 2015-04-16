{include file=$header}
</head>
<body>
<a name="top" id="top"></a>
{include file=$status}<div id="wrap">
<div id="imageArea">{include file=$headCampaign}</div>
{include file=$headerMenu}
<div id="contents">
<div id="main">
<div class="mainBox">
<div id="titleAbout">当ｻｲﾄについて</div>
{eval var=$aboutData|emoji}
</div>
</div>
{include file=$side}
</div>
{include file=$footer}
</div>
</body>
</html>