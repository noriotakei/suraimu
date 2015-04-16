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
<div id="titleTaikai">退会</div>
{if $errMsg}
    <p class="err">{$errMsg}</p>
{/if}
{$quitPrData|emoji}
<div id="centerP">
<form action="./?action_Home=1" method="post">
{$comFORMparam}
<input name="regist3" type="image" tabindex="10" style="text-align:center;" onFocus="this.blur()" onMouseOver="this.src='./img/bt_taikaistop_on.png'" onMouseOut="this.src='./img/bt_taikaistop.png'" src="./img/bt_taikaistop.png" alt="退会手続きを止める" />
</form>
<form action="./?action_TaikaiExec=1" method="post">
{$comFORMparam}
<input name="regist3" type="image" tabindex="11" style="text-align:center;" onFocus="this.blur()" onMouseOver="this.src='./img/bt_taikai_on.png'" onMouseOut="this.src='./img/bt_taikai.png'" src="./img/bt_taikai.png" alt="退会手続きを進める" />
</form>
</div>
</div>
</div>
{include file=$side}
</div>
{include file=$footer}
</div>
</body>
</html>