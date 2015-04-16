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
<div id="titleUpdate">月額更新の変更</div>
<br />
{if $errMsg}
<p class="err">{$errMsg}</p>
{else}
<p class="err">月額自動更新キャンセルのお手続きを受付けました。</p>
<p>月額自動更新キャンセルの手続きが完了いたしました。ご利用誠にありがとうございました。 </p>
{/if}
</div>
</div>
{include file=$side}
</div>
{include file=$footer}
</div>
</body>
</html>