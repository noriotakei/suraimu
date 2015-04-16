{include file=$header}
</head>
<body {$bodyTag}>
<a name="top" id="top"></a>
<div style="font-size:x-small; text-align:left; {$limited_width}">
{*<img src="img/title.gif" alt="{$siteName}" width="100%" />*}
<div style="text-align:center;">
ネット銀行
</div>
<hr {$hr_2style} />
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
<table align="center" border="0" width="90%">
<tr><td bgcolor="#336600"><span style="color:#cf0;font-size:small;">▼合計金額</span>
</td></tr>
<tr><td>{$orderingData.pay_total|number_format:"0"}円</td></tr>
<!--カウントダウン -->
{if $showCountDown }
<tr><td bgcolor="#336600"><span style="color:#cf0;font-size:small;">▼締切まで残時間</span>
</td></tr>
<tr><td>{$countDownDay}{$countDownHour}{$countDownMinute}{$countDownSecond}</td></tr>
{/if}
<tr><td>
<form method="post" action="{$netBankLinkUrl}" >
{foreach from=$netBankHiddenTag item="val" key="key"}
<input type="hidden" name="{$key}" value="{$val}">
{/foreach}
<div style="text-align:center;"><input name="submit" type="submit" value="ネットバンクで決済！" /><div>
</form>
</td></tr>
</table>
<br />
<hr {$hr_2style} />
デジタルコンテンツという商品の性質上、ご購入後の返品・交換・払い戻しは、原則としてお受けできませんのでご了承ください。<br />
<span style="color:#fc0; font-size:small;">※注意事項</span><br />
ジャパンネット銀行口座、楽天銀行口座、住信SBIネット銀行口座からお振込みのお客様はお申し込み手続きと同時にお振込みが完了します。<br />
ジャパンネット銀行からジャパンネット銀行へのお振込み。<br />
楽天銀行から楽天銀行へのお振込み。<br />
住信SBIネット銀行から住信SBIネット銀行へのお振込み。<br />
以上の「同銀行間でのお振込み」は24時間リアルタイム決済が可能です。<br />
※通常の銀行振込と違い、当サイトのＩＤ番号などの入力は不要です。会員様の銀行口座情報を入力いただき決済されるだけで、自動的にネット銀行から当サイトへ決済完了情報が届き情報購入が終了いたします。<br />
<span style="color:#f00; font-size:small;">■ ネット銀行決済に関するご注意</span><br />
ネット銀行振込みでのお支払いは、<a href="http://www.axes-payment.co.jp/info/bank/m/index.html">株式会社アクシズの決済システム</a>を利用しています。<br />
ネット銀行決済・個人情報の入力に不安のある方は<a href="http://www.axes-payment.co.jp/credituser.html">株式会社アクシズ</a>-安心・安全への取り組みをお読み下さい。<br />
<hr {$hr_2style} />
<span style="color:#00ccec;font-size:small;">※他の決済方法に変更する場合はコチラ</span><br />
{include file=$settleMenu}
{*{include file=$footer}*}
{* アフィリエイトタグ *}
{$comImgTag}
</body>
</html>