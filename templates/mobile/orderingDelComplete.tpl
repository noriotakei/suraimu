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

<!-- カート -->
<div id="cartBlock" class="bgYellow">

<div class="text">▼ ご予約商品のキャンセル ▼</div>

<div class="cart">
<table>
    <tr>
        <th>ご予約商品のキャンセルが完了しました</th>
    </tr>
</table>
</div>

</div><!-- /.block -->
<!-- カートEnd -->



<!-- ******************** 決済メニュー End ******************** -->

{include file=$part_footer_sp}
</div><!--end wrap-->

</body>
</html>