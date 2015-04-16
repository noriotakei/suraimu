{include file=$header}
</head>
<body {$bodyTag}>
<a name="top" id="top"></a>
<div style="font-size:x-small; text-align:left; {$limited_width}">
{*<img src="img/title.gif" alt="{$siteName}" width="100%" />*}
<div style="text-align:center;">
銀行振込
</div>
<hr {$hr_2style} />
{if $errMsg}<span style="color:#f00;font-size:small;">{$errMsg}</span><br /><hr {$hr_2style} />{/if}
{if $mailFlag}<span style="color:#ff0;">{""|emoji}</span>{$mailFlag}<br />{/if}
{*
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
    <br />
    <span style="color:#00ccec;font-size:small;"><a href="./?action_OrderingDelChk=1&odid={$orderingData.access_key}{if $comURLparam}&{$comURLparam}{/if}">ご予約をキャンセルする</a></span>
{/if}
*}
{*
<br />
<img src="img/line_b.gif" width="100%" />
*}
<br />
<div style="width:90%;background:#360;color:#CF0;text-align:center;margin:0 auto;font-size:small;">▼商品内容</div>
<div style="width:90%;background:#000;color:#FFF;text-align:center;margin:0 auto;font-size:large;">
{if $itemList}
    {foreach from=$itemList item="val"}
      {$val.html_text_name_mb|emoji}
    {/foreach}
{/if}
</div>
<div style="width:90%;background:#360;color:#CF0;text-align:center;margin:0 auto;font-size:small;">▼合計金額</div>
<div style="width:90%;background:#000;color:#FFF;text-align:center;margin:0 auto;font-size:large;">
{$orderingData.pay_total|number_format:"0"}円
</div>
<div style="width:90%;background:#360;color:#CF0;text-align:center;margin:0 auto;font-size:small;">▼振込名義</div>
<div style="width:90%;background:#000;color:#FFF;text-align:center;margin:0 auto;font-size:large;">
{$orderingData.id}<br>
<span style="color:#f00;font-size:small;">
※お振込名義IDは毎回違います。</span>
</div>
<!--カウントダウン -->
{if $showCountDown }
<div style="width:90%;background:#360;color:#CF0;text-align:center;margin:0 auto;font-size:small;">▼締切まで残時間</div>
<div style="width:90%;background:#000;color:#FFF;text-align:center;margin:0 auto;font-size:large;">
{$countDownDay}{$countDownHour}{$countDownMinute}{$countDownSecond}
</div>
{/if}
<br />
<div style="width:90%;background:#360;color:#CF0;text-align:center;margin:0 auto;font-size:large;">【お振込先】</div>
<div style="width:90%;background:#000;color:#FFF;text-align:center;margin:0 auto;font-size:large;border:1px solid #360;">
{$bankName}<br>
{$branchName}<br>
{$accountNumber}<br>
{$transferDestination}
</div>
<br />
{*<span style="color:#00ccec;font-size:small;"><a href="./?action_SettleBank=1&{$URLparam}&mail=1{if $comURLparam}&{$comURLparam}{/if}">登録メールアドレスに送信する</a></span><br />*}
<hr {$hr_2style} />
デジタルコンテンツという商品の性質上、ご購入後の返品・交換・払い戻しは、原則としてお受けできませんのでご了承ください。<br />
<span style="color:#fc0;font-size:small;">※注意事項</span><br />
お振り込みは<span style="color:#f00;">電信扱い</span>にてお願いいたします<br />
午後3時をすぎたお振込の場合、ポイントの追加は翌日（金曜、祝日等は銀行の翌営業日）となります<br />
※楽天銀行からのお振込みは24時間365日、即時の自動確認となります。<br />
ポイントの追加がされるまで、振込明細書（振込控え）は捨てずにお持ちください<br />
お振込名義ID（<b><span style="color:#f00;">{$orderingData.id}</span></b>）が確認できない場合、弊社では一切責任を負いかねます<br />
振り込み手数料はお客様のご負担となります<br />
お振込からポイント追加まで若干時間がかかる場合がございます<br />
その他、ご不明な点がありましたら<a href="mailto:{$operationMailAccount|cat:$config.define.MAIL_DOMAIN}">{$operationMailAccount|cat:$config.define.MAIL_DOMAIN}</a>までご連絡ください<br />
<hr {$hr_2style} />
<span style="color:#00ccec;font-size:small;">※他の決済方法に変更する場合はコチラ</span><br />
{include file=$settleMenu}
{*{include file=$footer}*}
{* アフィリエイトタグ *}
{$comImgTag}
</body>
</html>