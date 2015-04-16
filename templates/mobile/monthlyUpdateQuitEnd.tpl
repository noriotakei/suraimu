{include file=$header}
</head>
<body {$bodyTag}>
<a name="top" id="top"></a>
<div style="font-size:x-small; text-align:left; {$limited_width}">
<img src="img/title.gif" alt="{$siteName}" width="100%" />
<div style="text-align:center;">
登録情報の変更
</div>
<hr {$hr_1style} />
{if $errMsg}
    <span style="color:#f00;font-size:small;">{$errMsg}</span><br /><hr {$hr_2style} />
{else}
<span style="color:#f00;font-size:small;">{""|emoji}月額自動更新の変更が完了しました。</span><br />
{/if}
<hr {$hr_1style} />
{include file=$contentsMenu}
{include file=$status}
{include file=$footerMenu}
{include file=$pr}
{include file=$footer}
</body>
</html>
