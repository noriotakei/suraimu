{include file=$header}
</head>
<body {$bodyTag}>
<div style="font-size:x-small; text-align:left; {$limited_width}">
<img src="img/title.gif" alt="{$siteName}" width="100%" />

{if $informationOpenList}
    {foreach from=$informationOpenList item="infoList"}
        {eval var=$infoList.html_text_banner_mb|emoji}
    {/foreach}
{else}
    <p class="err">
        申し訳ありません。<br>
        現在、公開出来る情報がありません。
        もうしばらくお待ちください。
    </p>
{/if}

{include file=$contentsMenu}
{include file=$status}
{include file=$footerMenu}
{include file=$footer}
</body>
</html>