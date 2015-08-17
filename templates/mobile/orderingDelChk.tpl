<?php
header("Content-Type: text/html; charset=UTF-8");
?>
{include file=$hedinfo_login_sp}
<link rel="stylesheet" type="text/css" href="http://image.ko-haito.com/contents/settle/settle.css" media="all">
</head>

<body class="settle credit">
<!-- #wrap -->
<div class="wrap">
<a id="top"></a>

{* カート *}
<div id="cartBlock" class="bgYellow">

<div class="text">▼ ご予約商品のキャンセル ▼</div>

{if $itemList}
    {foreach from=$itemList item="val"}
        <div class="cart">
        <table>
            <tr>
                <th>内容</th>
                <td>{$val.html_text_name_mb|emoji}</td>
            </tr>
            <tr>
                <th>価格</th>
                <td class="red">{$val.price|number_format:"0"}円</td>
            </tr>
        </table>
        </div>
    {/foreach}
{/if}

<div class="cart">
<table>
	<tr>
		<th>▼合計金額</th>
		<td>{$orderingData.pay_total|number_format:"0"}円</td>
	</tr>
	<tr>
		<th>▼決済方法</th>
		<td>{$settleName}</td>
	</tr>
</table>
</div>

<div class="cancel responsive">
    <a href="./?action_OrderingDelExec=1{if $URLparam}&{$URLparam}{/if}"><img src="http://image.ko-haito.com/contents/settle/btnCancel.png" alt="予約をキャンセルする"></a>
</div>

</div>
{* /.block *}
{* カートEnd *}


<div class="mBtm10">
    <img src="http://image.ko-haito.com/contents/settle/txtSettleChange.png" alt="※他の決済方法に変更する場合はコチラ" class="responsive">
</div>

<!-- ******************** 決済メニュー ******************** -->
<div class="settleMenuTitle">
    <img src="http://image.ko-haito.com/contents/settle/ttlSettleSelect.png" alt="決済方法の選択">
</div>
<div class="settleList">

{include file=$settle_sp}

</div><!-- /.settleList -->
<!-- ******************** 決済メニュー End ******************** -->

{include file=$part_footer_sp}
</div><!--end wrap-->

</body>
</html>