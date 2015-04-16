{include file=$header}
</head>
<body {$bodyTag}>
<a name="top" id="top"></a>
<div style="font-size:x-small; text-align:left; {$limited_width}">
{*<img src="img/title.gif" alt="{$siteName}" width="100%" />*}
<div style="text-align:center;">
コンビニ決済
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
<form action="./?action_SettleCvdChk=1{if $comURLparam}&{$comURLparam}{/if}" method="post">
{$FORMparam}
<table align="center" border="0" width="90%">
<tr>
<td bgcolor="#336600"><span style="color:#cf0;font-size:small;">▼コンビニ選択</span>
</td>
</tr>
<tr>
<td>
<span style="color:#000;">
{html_options name="cv_cd" options=$cvName selected=$value.cv_cd  style="color:#000;"}
</span><br />
</td>
</tr>
<tr>
<td bgcolor="#336600"><span style="color:#cf0;font-size:small;">▼姓</span>
</td>
</tr>
<tr>
<td>
<input name="name1" style="ime-mode: active;" type="text" value="{$value.name1}"/>
<br />
</td>
</tr>
<tr>
<td bgcolor="#336600"><span style="color:#cf0;font-size:small;">▼名</span>
</td>
</tr>
<tr>
<td>
<input name="name2" style="ime-mode: active;" type="text" value="{$value.name2}" />
<br />
</td>
</tr>
<tr>
<td bgcolor="#336600"><span style="color:#cf0;font-size:small;">▼携帯電話番号</span>
</td>
</tr>
<tr>
<td>
<input name="telno" maxlength="11" style="ime-mode: disabled;" type="text" value="{$value.telno}"/>
<br />
</td>
</tr>
<tr>
<td bgcolor="#336600"><span style="color:#cf0;font-size:small;">▼決済金額</span>
</td>
</tr>
<tr>
<td>{$orderingData.pay_total|number_format:"0"}円</td>
</tr>
<!--カウントダウン -->
{if $showCountDown }
<tr>
<td bgcolor="#336600"><span style="color:#cf0;font-size:small;">▼締切まで残時間</span>
</td>
</tr>
<tr>
<td>{$countDownDay}{$countDownHour}{$countDownMinute}{$countDownSecond}/td>
</tr>
{/if}
</table>
<div style="text-align:center;color:#000;">
▼　▼　▼<br />
<input value="決済内容の確認" type="submit" />
</div>
</form>
<br />
<hr {$hr_2style} />
デジタルコンテンツという商品の性質上、ご購入後の返品・交換・払い戻しは、原則としてお受けできませんのでご了承ください。<br />
<span style="color:#fc0;font-size:small;">※注意事項</span><br />
万一決済が正常に終了しない場合は、コンビニダイレクトカスタマーサポート(0570-000-555)までご連絡ください。<br />
メールや受付番号の再発行等は一切いたしませんので、削除せず大切に保管してください。<br />
払込後にポイントが追加されない等のトラブルは直接加盟店様へお問い合わせください。 <br />
お申し込み後はお早めにお支払いをお願いいたします。お申し込みがキャンセルとなる場合がございます。<br />
ご購入にあたっては<a href="./?action_Rule=1{if $comURLparam}&{$comURLparam}{/if}">利用規約</a>に同意いただく必要があります。 <br />
{if $isDisp}
※ご利用可能なコンビニチェーンについて<br>
セブンイレブンでのコンビニダイレクトは「ご利用が停止」となりました。<br>
セブンイレブン以外の他コンビニチェーンでは今まで同様に「ご利用が可能」でございます。<br />
{/if}
<br />
※入金反映時間について<br />
ﾌｧﾐﾘｰﾏｰﾄ ⇒ ご入金後10～30分程度<br />
ﾛｰｿﾝ・ｾｲｺｰﾏｰﾄ・ﾐﾆｽﾄｯﾌﾟ ⇒ ご入金後2～3時間程度<br />
※なお回線状況等で反映が遅れる場合がございますので予め時間に余裕を持った早めのお手続きをお願い申し上げます。<br />
<hr {$hr_2style} />
<span style="color:#00ccec;font-size:small;">※他の決済方法に変更する場合はコチラ</span><br />
{include file=$settleMenu}
{*{include file=$footer}*}
{* アフィリエイトタグ *}
{$comImgTag}
</body>
</html>