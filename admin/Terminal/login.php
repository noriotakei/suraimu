<?php
	$sUpdate	=	"最終更新日：2006/05/04";
?>
<html>
<head>
<title>ＭｙＳＱＬ ＤＢＡ ログイン</title>
<script language="JavaScript" type="text/javascript">
<!--
	//フォーカスをテキストエリアに設定する
	function	setFocus()	{
		document.frmLogin.sPassword.focus();
	}
-->
</script>
</head>
<body bgcolor="#FFFFCC" onLoad="setFocus()">
	<form action="main.php" method="post" name="frmLogin" id="frmLogin" onReset="setFocus()">
		
		<p align="center"><strong><font color="#FF0000" size="+2"><em>パスワードを入力してください</em></font></strong>
		</p>
		<p align="center">
			<input name="sPassword" type="password" id="sPassword" value="">
		</p>
		<p align="center">
			<input name="btnLogin" type="submit" id="btnLogin" value="ログイン">&nbsp;
			<input name="btnCancel" type="reset" id="btnCancel" value="キャンセル">
		<br><br>
<?php
		print($sUpdate);
?>
		</p>
	</form>

	<h4>■注意事項</h4>
	<p>
		・「Ｖｉｅｗ＆Ｓｔｏｒｅｄメンテ用画面」では、日本語を入力しないでください。（文字化けします）<br>
		※Ｖｉｅｗには日本語が入りますが、Ｓｔｏｒｅｄだと文字化けします（Ｍｙｓｑｌの仕様かも？です。。。）
	</p>

	<h4>■現在未対応のバグ</h4>
	<p>
		・特に見つかっていません。何か見つけたら河原までご連絡ください。
	</p>
</body>
</html>
