{include file=$header}
</head>
<body {$bodyTag}>
<a name="top" id="top"></a>
<div style="font-size:x-small; text-align:left; {$limited_width}">
<img src="img/title.gif" alt="{$siteName}" width="100%" />
<div style="text-align:center;">
ご予約商品のキャンセル
</div>
<hr {$hr_2style} />
{if $errMsg}<span style="color:#f00;font-size:small;">{$errMsg}</span><br /><hr {$hr_2style} />{/if}
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
<table align="center" border="0" width="90%">
<tr><td bgcolor="#336600"><span style="color:#cf0;font-size:small;">▼合計金額</span>
</td></tr>
<tr><td>{$orderingData.pay_total|number_format:"0"}円</td></tr>
<tr><td bgcolor="#336600"><span style="color:#cf0;font-size:small;">▼決済方法</span>
</td></tr>
<tr><td>{$settleName}</td></tr>
<tr><td>
<form action="./?action_OrderingDelExec=1{if $comURLparam}&{$comURLparam}{/if}" method="post">
{$FORMparam}
<div style="color:#000;"><input value="予約をキャンセルする" type="submit" /></div>
</form>
</td></tr>
</table>
<br />
<hr {$hr_2style} />
<span style="color:#00ccec;font-size:small;">※他の決済方法に変更する場合はコチラ</span><br />
{include file=$settleMenu}
{include file=$footer}
</body>
</html>