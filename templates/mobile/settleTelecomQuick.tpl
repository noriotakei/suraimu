{include file=$header}
</head>
<body {$bodyTag}>
<a name="top" id="top"></a>
<div style="font-size:x-small; text-align:left; {$limited_width}">
{*<img src="img/title.gif" alt="{$siteName}" width="100%" />*}
<div style="text-align:center;">
クレジットカード決済
</div>
<hr {$hr_2style} />
{if $errMsg}<span style="color:#f00;font-size:small;">{$errMsg}</span><br />{/if}
<span style="font-size:small;color:#f00;">※クイックチャージで決済されます</span><br />下記の内容でよろしければボタンを押して下さい。<br />
<br />
{if $itemList}
    {foreach from=$itemList item="val"}
        <table border="0" width="100%">
        <tr>
        <td width="20%"><span style="color:#c93;font-size:small;">内容：</span>
        </td>
        <td width="80%"><span style="color:#ffa500;">{$val.html_text_name_mb|emoji}</span>
        </td>
        </tr>
        <tr>
        <td width="20%"><span style="color:#c93;font-size:small;">価格：</span>
        </td>
        <td width="80%">{$val.price|number_format:"0"}円</td>
        </tr>
        </table>
        <img src="img/line_b.gif" width="100%" />
    {/foreach}
{/if}
<br />
<table align="center" bgcolor="#005000" border="0" width="100%">
<tr>
<td align="center">合計 :<span style="color:#ff0;">{$orderingData.pay_total|number_format:"0"}</span>円</td>
</tr>
<!--カウントダウン -->
{if $showCountDown }
<tr>
<td align="center">締切まで残時間 :<span style="color:#ff0;">{$countDownDay}{$countDownHour}{$countDownMinute}{$countDownSecond}</span></td>
</tr>
{/if}
</table>
<span style="color:#f00;font-size:small;">※決済ボタンは1度だけ押して下さい</span>


<form action="./?action_SettleTelecomQuickExec=1{if $comURLparam}&{$comURLparam}{/if}" method="post">
{$FORMparam}
<div style="text-align:center;color:#000;">▼　▼　▼<br /><input value="決済する" type="submit" /></div>
</form>
<br />
<hr {$hr_2style} />
<span style="color:#00ccec;font-size:small;">※他の決済方法に変更する場合はコチラ</span><br />
{include file=$settleMenu}
{*{include file=$footer}*}
{* アフィリエイトタグ *}
{$comImgTag}
</body>
</html>