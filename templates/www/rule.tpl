{include file=$preHeader}
<script type="text/javascript" src="js/close.js"></script>
</head>

<body>
<a name="top" id="top"></a>
<div id="headerWrap">
<div id="header">
<div id="logo">{$siteName}</div>
</div>
</div>

<div id="wrap">
<div id="mainMenu">&nbsp;</div>
<div id="contents2">
<div id="main2">
<div class="mainBox2"><div id="txtFormat">
<div id="titleRule">ご利用規約</div>

{eval var=$ruleData|emoji}

<div id="close"><a href="JavaScript:window.self.close()">閉じる</a></div>
</div>
</div>
</div>
</div>
{include file=$blankFooter}
</div>
</body>
</html>