{include file=$header}
</head>
<body>
<a name="top" id="top"></a>
{include file=$status}
<div id="wrap">
<div id="imageArea">{include file=$headCampaign}</div>
{include file=$headerMenu}
<div id="contents">
<div id="main">
<div class="mainBox">
<div id="titleItemlist">情報購入　ポイント追加</div>

<div id="settle">
<h3>商品のご確認</h3>
<p>商品をご確認のうえ、お支払い方法をお選びください！</p>

{* エラー表示 *}
{if $errMsg}
<p class="err">
    {foreach from=$errMsg item="val"}
        {$val|emoji}
    {/foreach}
</p>
{/if}

{foreach from=$itemList item="val"}
<table class="tableItem" cellspacing="2">
<tr>
<th>ご予約商品名</th>
<td class="attention">{$val.html_text_name_pc|emoji}</td>
</tr>
<tr>
<th>ご決済金額</th>
<td class="attention">{$val.price|number_format}円</td>
</tr>
<!--カウントダウン追加 -->
{if $showCountDown == $val.id}
<script type="text/javascript" src="js/countDown.js"></script>
<tr>
    <th>締切まで残時間</th>
    <td align="center"><span id="cntdown1" style="font-size:28px; color:#000; height:40px; line-height:40px;"></span>
        <script type="text/javascript">countdown('cntdown1',{$countDownYear},{$countDownMonth},{$countDownDay},{$countDownHour},{$countDownMinute});</script>
    </td>
</tr>
{/if}
<!--/カウントダウン追加 -->
<tr>
<td colspan="2" class="end"><a href="./?action_SettleSelect=1&del=1&iid={$val.access_key}{if $comURLparam}&{$comURLparam}{/if}">[削除する]</a></td>
</tr>
</table>
{/foreach}
<div id="under">&nbsp;</div>
</div>
{include file=$settleMenu}
</div>
</div>
{include file=$side}
</div>
{include file=$footer}
</div>
</body>
</html>