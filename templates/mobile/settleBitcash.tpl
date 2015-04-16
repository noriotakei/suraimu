{include file=$header}
</head>
<body {$bodyTag}>
<a name="top" id="top"></a>
<div style="font-size:x-small; text-align:left; {$limited_width}">
{*<img src="img/title.gif" alt="{$siteName}" width="100%" />*}
<div style="text-align:center;">
BITCASH決済
</div>
<hr {$hr_2style} />
{if $errMsg}<span style="color:#f00;font-size:small;">{$errMsg}</span><br /><hr {$hr_2style} />{/if}
<span style="color:#fc0;"><a href="http://www.bitcash.co.jp/i/sheet/index.html">※詳しい説明はｺﾁﾗから</a></span><br />
<span style="color:#fc0;"><a href="https://secure.bitcash.jp/my/bitcash/merge/">※残高引継ぎ(金額をまとめる)はｺﾁﾗから</a></span><br />
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
<form action="./?action_SettleBitcashExec=1{if $comURLparam}&{$comURLparam}{/if}" method="post">
{$FORMparam}
<table align="center" border="0" width="90%">
<tr>
<td bgcolor="#336600"><span style="color:#cf0;font-size:small;">▼ひらがな16文字のｶｰﾄﾞ番号を入力してください。</span></td>
</tr>
<tr>
<td><input name="card_number" size="32" maxlength="32" type="text" value="{$value.card_number}"/></td>
</tr>
<tr>
<td bgcolor="#336600"><span style="color:#cf0;font-size:small;">▼決済金額</span></td>
</tr>
<tr>
<td>{$orderingData.pay_total|number_format:"0"}円</td>
</tr>
<!--カウントダウン -->
{if $showCountDown }
<tr>
<td bgcolor="#336600"><span style="color:#cf0;font-size:small;">▼締切まで残時間</span></td>
</tr>
<tr>
<td>{$countDownDay}{$countDownHour}{$countDownMinute}{$countDownSecond}</td>
</tr>
{/if}
</table>
<div style="text-align:center;color:#000;">
▼　▼　▼<br />
<input value="BITCASHで決済" type="submit" />
</div>
</form>
<hr {$hr_2style} />
デジタルコンテンツという商品の性質上、ご購入後の返品・交換・払い戻しは、原則としてお受けできませんのでご了承ください。<br />
<span style="color:#fc0;font-size:small;">※注意事項</span><br />
・BITCASHの種類は【EX】をご購入ください。【ST】は御利用いただけません。<br />
・必ず【16桁ひらがたなIDを入力】【BITCASHで決済】をお願いいたします。BITCASHｶｰﾄﾞの購入だけでは決済が完了されません!<br />
・ご購入にあたっては利用規約に同意いただく必要があります。 <br />
・ご購入にあたっては<a href="./?action_Rule=1{if $comURLparam}&{$comURLparam}{/if}">利用規約</a>に同意いただく必要があります。<br />
・<a href="http://m.bitcash.jp/docs/terms/memberstore/">※資金決済法に基づく表示</a>
<br />
<hr {$hr_2style} />
<span style="color:#00ccec;font-size:small;">※他の決済方法に変更する場合はコチラ</span><br />
{include file=$settleMenu}
{*{include file=$footer}*}
{* アフィリエイトタグ *}
{$comImgTag}
</body>
</html>