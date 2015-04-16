{include file=$header}
</head>
<body {$bodyTag}>
<a name="top" id="top"></a>
<div style="font-size:x-small; text-align:left; {$limited_width}">

<img src="img/header.gif" alt="{$siteName}" width="100%" />

<div style="text-align:center; background-color:#050; color:#cf0;">高配当ｻﾎﾟｰﾄｾﾝﾀｰ</div>
<div>
<a href="tel:0570011180"><img src="img/header_tel_kh.gif" width="100%" alt="ｻﾎﾟｰﾄｾﾝﾀｰ" /></a>
</div>

<div style="text-align:center;"><blink>↓</blink>本物の情報だけ厳選公開中<blink>↓</blink></div>

{if $dispInformationList}
    {foreach from=$dispInformationList item="val"}
        {eval var=$val.html_text_banner_mb|emoji}
    {/foreach}
{/if}

{include file=$contentsMenu}

{include file=$status}

{include file=$footerMenu}

<table width="96%" border="0" align="center" cellpadding="2" cellspacing="0">
<tr>
<td align="right"><span style="font-size:x-small;"><a href="#top" accesskey="2">PageUp▲{""|emoji}</a><br /><a href="#down" accesskey="8">PageDown▼{""|emoji}</a></span></td>
</tr>
</table>
{include file=$copylight}
{$comImgTag}
</body>
</html>