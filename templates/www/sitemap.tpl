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
<div id="titleSitemap">サイトマップ</div>
<div id="txtSitemap">登録前の当サイト内のページ一覧です。ご登録には情報ページ・コンテンツなど更に充実した内容でご利用しただけます。</div>
{eval var=$sitemapData|emoji}
</div>
</div>
{include file=$side}
</div>
{include file=$footer}
</div>
</body>
</html>