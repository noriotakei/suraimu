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
{if $errMsg}<span style="color:#f00;font-size:small;">{$errMsg}</span><br /><hr {$hr_2style} />{/if}
<span style="color:#f00;font-size:small;">【商品のご確認】</span><br />
下記の内容でよろしければ決済ページへお進み下さい。<br /><br />

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
    <br />
    {*<span style="color:#00ccec;font-size:small;"><a href="./?action_OrderingDelChk=1&odid={$orderingData.access_key}{if $comURLparam}&{$comURLparam}{/if}">ご予約をキャンセルする</a></span>*}
{/if}
{*
<br />
<img src="img/line_b.gif" width="100%" />
*}
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
{if $isQuick}
前回のクレジットカードで決済する<br>
<form action="./?action_SettleCreditQuick=1{if $comURLparam}&{$comURLparam}{/if}" method="post">
{$FORMparam}
<div style="text-align:center;color:#000;">▼　▼　▼<br /><input value="確認する" type="submit" />
</div>
</form>
<hr {$hr_2style} />
別のクレジットカードで決済する
{/if}
<form action="{$creditUrl}" method="post">
{$creditHiddenTags}
<div style="text-align:center;color:#000;">▼　▼　▼<br /><input value="SSL決済ページへ" type="submit" />
</div>
</form>
<hr {$hr_2style} />
デジタルコンテンツという商品の性質上、ご購入後の返品・交換・払い戻しは、原則としてお受けできませんのでご了承ください。<br />
<span style="color:#fc0;font-size:small;">※注意事項</span><br />
アナタ様の個人情報を守る為、SSL(暗号化)通信を導入しております。<br />
カード会社から発行の明細書には「AXES」または「EC PAY」で請求されます。<br />
カード決済に関するお問い合わせ先はAXESまで<br />
<table border="0">
<tr>
<td align="center">
<a href="https://gw.axes-payment.com/cgi-bin/mobile_exp.cgi?clientip={$settleClientIp}" target="_blink">
クレジットカード決済に関するご説明<br>必ずお読みください</a><br><br>
カード決済に関するお問い合わせ<br>
決済システムは（株）アクシズを利用しています<br>
TEL:0570-03-6000（TEL03-3498-6200）<br>
<a href="mailto:creditinfo@axes-payment.co.jp">creditinfo@axes-payment.co.jp</a><br>
ゼロカスタマーサポート（24時間365日)<br>
</td>
</tr>
</table>
<hr {$hr_2style} />
<span style="color:#00ccec;font-size:small;">※他の決済方法に変更する場合はコチラ</span><br />
{include file=$settleMenu}
{*{include file=$footer}*}
{* アフィリエイトタグ *}
{$comImgTag}
</body>
</html>