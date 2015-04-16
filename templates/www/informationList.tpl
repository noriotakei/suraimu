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
{if $informationOpenList}
    {foreach from=$informationOpenList item="infoList"}
        {eval var=$infoList.html_text_banner_pc|emoji}
    {/foreach}
{else}
    <p class="err">
        申し訳ありません。<br>
        現在、公開出来る情報がありません。
        もうしばらくお待ちください。
    </p>
{/if}
</div>
</div>
{include file=$side}
</div>
{include file=$footer}
</div>
</body>
</html>