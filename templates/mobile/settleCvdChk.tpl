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
<span style="color:#f00;font-size:small;">
【決済内容の確認】</span>
<form action="./?action_SettleCvdExec=1{if $comURLparam}&{$comURLparam}{/if}" method="post">
{$FORMparam}
<table align="center" border="0" width="90%">
    <tr>
        <td bgcolor="#336600"><span style="color:#cf0;font-size:small;">▼コンビニ選択</span>
</td>
    </tr>
    <tr>
        <td>{$cvName[$param.cv_cd]}</td>
    </tr>
    <tr>
        <td bgcolor="#336600"><span style="color:#cf0;font-size:small;">▼姓</span>
</td>
    </tr>
    <tr>
        <td>{$param.name1}</td>
    </tr>
    <tr>
        <td bgcolor="#336600"><span style="color:#cf0;font-size:small;">▼名</span>
</td>
    </tr>
    <tr>
        <td>{$param.name2}</td>
    </tr>
    <tr>
        <td bgcolor="#336600"><span style="color:#cf0;font-size:small;">▼携帯電話番号</span>
</td>
    </tr>
    <tr>
        <td>{$param.telno}</td>
    </tr>
    <tr>
        <td bgcolor="#336600"><span style="color:#cf0;font-size:small;">▼決済金額</span>
</td>
    </tr>
    <tr>
        <td>{$orderingData.pay_total|number_format:"0"}円</td>
    </tr>
</table>
<div style="text-align:center;color:#000;">
    ▼　▼　▼<br />
    <input value="申し込む" type="submit" />
</div>
</form>
<br />
<span style="color:#99ec00;">{""|emoji}</span><span style="font-size:small;"><a href="./?action_SettleCvd=1&{$URLparam}{if $comURLparam}&{$comURLparam}{/if}">内容を修正する</a></span><br />
<br />

<hr {$hr_2style} />
<span style="color:#fc0;font-size:small;">※注意事項</span><br />
万一決済が正常に終了しない場合は、コンビニダイレクトカスタマーサポート(0570-000-555)までご連絡ください。<br />
メールや受付番号の再発行等は一切いたしませんので、削除せず大切に保管してください。<br />
払込後にポイントが追加されない等のトラブルは直接加盟店様へお問い合わせください。 <br />
お申し込み後はお早めにお支払いをお願いいたします。お申し込みがキャンセルとなる場合がございます。<br />
ご購入にあたっては<a href="./?action_Rule=1{if $comURLparam}&{$comURLparam}{/if}">利用規約</a>に同意いただく必要があります。 <br />
<br />
※入金反映時間について<br />
ﾌｧﾐﾘｰﾏｰﾄ ⇒ ご入金後10～30分程度<br />
ﾛｰｿﾝ・ｾｲｺｰﾏｰﾄ ⇒ ご入金後2～3時間程度<br />
※なお回線状況等で反映が遅れる場合がございますので予め時間に余裕を持った早めのお手続きをお願い申し上げます。<br />
<hr {$hr_2style} />
{*{include file=$footer}*}
{* アフィリエイトタグ *}
{$comImgTag}
</body>
</html>