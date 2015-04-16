{include file=$preHeader}
</head>
<body {$bodyTag}>
<a name="top" id="top"></a>
<div style="font-size:x-small; text-align:left; {$limited_width}">
<img src="img/title.gif" alt="{$siteName}" width="100%" />
<div style="text-align:center;">
エラー
</div>
<hr {$hr_1style} />
{if $errMsg}
    <span style="color:#f00;font-size:small;">{$errMsg}</span><br />
{/if}
<hr {$hr_1style} />
{include file=$preFooter}
</body>
</html>