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
<div id="titleTaikai">退会</div>
<br />
<p class="err">退会お手続きを受付けました。</p>
<p>退会手続きが完了いたしました。ご利用誠にありがとうございました。 </p>
{$quitPrData|emoji}
</div>
</div>
{include file=$preSide}
</div>
{include file=$preFooter}
</div>
</body>
</html>