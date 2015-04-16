{include file=$header}
</head>
<body>
<a name="top" id="top"></a>
{include file=$status}<div id="wrap">
<div id="imageArea">{include file=$headCampaign}</div>
{include file=$headerMenu}
<div id="contents">
<div id="main">
<div class="mainBox">
<div id="titleMailchange">登録メールアドレスの変更完了</div>
{if $errMsg}
    <p class="err">{$errMsg}</p>
{/if}
{if $param.comp}
<p class="err">
メールアドレスの変更が完了しました。
</p>
{/if}
</div>
</div>
{include file=$side}
</div>
{include file=$footer}
</div>
</body>
</html>