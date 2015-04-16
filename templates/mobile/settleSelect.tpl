{include file=$header}
</head>
<body {$bodyTag}>
<a name="top" id="top"></a>
<div style="font-size:x-small; text-align:left; {$limited_width}">
<img src="img/title.gif" alt="{$siteName}" width="100%" />
<div style="text-align:center;">
商品の確認
</div>
<hr {$hr_2style} />

{if $errMsg}
<span style="color:#f00;">
    {foreach from=$errMsg item="val"}
        {$val|emoji}
    {/foreach}
</span>
<hr {$hr_2style} />

{/if}

{if $itemList}
<div style="text-align:center;font-size:small;">ご確認後にお支払い方法をご選択ください。<br /><span style="color:#f00;">▼　▼　▼</span></div>
    {foreach from=$itemList item="val"}
        <table border="0" width="100%">
            <tr>
                <td width="20%"><span style="color:#c93;font-size:xx-small;">内容：</span></td>
                <td width="80%"><span style="color:#ffa500;">{$val.html_text_name_mb|emoji}</span></td>
            </tr>
            <tr>
                <td width="20%"><span style="color:#c93;font-size:xx-small;">価格：</span></td>
                <td width="80%">{$val.price|number_format}円</td>
            </tr>
        </table>
        {*<div style="text-align:right;"><a href="./?action_SettleSelect=1&del=1&iid={$val.access_key}{if $comURLparam}&{$comURLparam}{/if}"><span style="color:#00bccc;">[削除する]</span></a></div>*}
        <img src="img/line_b.gif" width="100%" />
    {/foreach}
    <br /><br />
    {if $showCountDown }
        <div style="width:90%;background:#360;color:#CF0;text-align:center;margin:0 auto;font-size:small;">▼締切まで残時間</div>
        <div style="width:90%;background:#000;color:#FFF;text-align:center;margin:0 auto;font-size:large;">
            {$countDownDay}{$countDownHour}{$countDownMinute}{$countDownSecond}
        </div>
    {/if}
<br />
<hr {$hr_2style} />
{include file=$settleMenu}
{/if}
{include file=$footer}
</body>
</html>