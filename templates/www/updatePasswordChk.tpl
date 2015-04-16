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
<div id="titleUpdate">登録情報の変更</div>
<p>【変更内容の確認】<br />
下記の内容でよろしければ「変更する」ボタンを押して下さい。</p>
<form action="./?action_UpdatePasswordExec=1" method="post">
{$comFORMparam}
{$POSTparam}
<dl>
<dt>現パスワード</dt>
<div id="formBg">
<div id="formIn">{$oldPassword}</div>
</div>
<dt>新パスワード</dt>
<div id="formBg">
<div id="formIn">{$newPassword}</div>
</div>
</dl>
<p id="centerP">
<input name="regist3" type="image" tabindex="10" style="text-align:center;" onFocus="this.blur()" onMouseOver="this.src='./img/bt_updatechk_on.png'" onMouseOut="this.src='./img/bt_updatechk.png'" src="./img/bt_updatechk.png" alt="変更する" />
</p>
</form>
<br />
</div>
</div>
{include file=$side}
</div>
{include file=$footer}
</div>
</body>
</html>