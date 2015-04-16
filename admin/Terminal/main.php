<?php
	$sUpdate	=	'最終更新日：2006/05/04';

	require_once('_common.php');
	$sPassword	=	$_POST['sPassword'];

	//アカウント設定（パスワード認証、権限設定）
	$bAct	=	setAccount($sPassword,$sActCd);
	$_SESSION['sActCd']	=	$sActCd;
?>
<html>
<head>
<title>ＭｙＳＱＬ ＤＢＡ メインメニュー</title>
<?php
	//パスワード認証ＯＫの時だけ表示
	if	($bAct)	{
?>
<script language="JavaScript" type="text/javascript">
<!--
	//フォーカスをサイト選択リストに設定する
	function	setFocus()	{
		document.frmSelect.sSiteName.focus();
	}
-->
</script>
<?php
	}
?>
</head>
<body bgcolor="<?php setBodyColor($sActCd);?>"<?php if ($bAct) { print(" onLoad=\"setFocus()\""); }?>>
<?php
	//パスワード認証ＯＫの時だけ表示
	if	($bAct)	{
?>
<script language="JavaScript" type="text/javascript">
<!--
	//サイト名を選択した時、Host名などを自動で設定
	function	setDbText()	{
		var val = document.frmSelect.sSiteName.options[document.frmSelect.sSiteName.selectedIndex].value;
<?php
		//宣言済み配列からjavaのソースを生成
		$i		=	0;
		$iMax	=	count($ARS_DB['siteName']);
		while	($i < $iMax)	{
			//１行目は普通のif文
			if	($i	==	0)	{
?>
		if	(val == "<?php print($ARS_DB['siteName'][$i]);?>")	{
<?php
			//２行目以降はelse if
			}	else	{
?>
		}	else	if	(val == "<?php print($ARS_DB['siteName'][$i]);?>")	{
<?php
			}
?>
			document.frmSelect.sHostName.value	=	"<?php print($ARS_DB['hostName'][$i]);?>";
			document.frmSelect.sUserName.value	=	"<?php print($ARS_DB['userName'][$i]);?>";
			document.frmSelect.sPassword.value	=	"<?php print($ARS_DB['password'][$i]);?>";
			document.frmSelect.sDbName.value	=	"<?php print($ARS_DB['dbName'][$i]);?>";
<?php
			$i++;
		}
?>
		}
	}
-->
</script>

	<h3><font color="#0000FF"><?php print($ARS_ACT['msg'][array_search($sActCd,$ARS_ACT['cd'])]);?></font></h3>
	<form action="work.php" method="post" name="frmSelect" target="_blank" id="frmSelect">
		<div align="center">
			<table border="1" cellpadding="5" cellspacing="5">
				<tr>
					<th colspan="2" nowrap>接続先を選択するか、入力して下さい</th>
				</tr>
				<tr>
					<td>Site Select</td>
					<td>
						<select name="sSiteName" id="sSiteName" onChange="setDbText()">
<?php
		//サイト名の配列から取得
		foreach	($ARS_DB['siteName'] as $value)	{
?>
							<option value="<?php print($value)?>"><?php print($value)?> </option>
<?php
		}
?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Host Name / IP Address </td>
					<td><input name="sHostName" type="text" size="30" maxlength="30"></td>
				</tr>
				<tr>
					<td>User Name</td>
					<td><input name="sUserName" type="text" size="30" maxlength="30"></td>
				</tr>
				<tr>
					<td>Password</td>
					<td><input name="sPassword" type="text" size="30" maxlength="30"></td>
				</tr>
				<tr>
					<td>use DB</td>
					<td><input name="sDbName" type="text" size="30" maxlength="30"></td>
				</tr>
			</table>
			<br><br>
<?php
		print($sUpdate);
?>
			<br><br>
			<input name="btnSqlEdit" type="submit" id="btnSqlEdit" value="ＳＱＬ実行画面">
			<br><br>
			<input name="btnViewStoredEdit" type="submit" id="btnViewStoredEdit" value="Ｖｉｅｗ＆Ｓｔｏｒｅｄメンテ用画面">
			<br><br>
			<input name="btnDbMnt" type="submit" id="btnDbMnt" value="ＤＢ情報表示＆メンテ作業用画面">
            <br><br>
            <a href="./db_shiyousyo/db_show_tables.php" target="_blank">テーブル仕様一覧</a>
            <br><br>
            <a href="./phpMinAdmin.php" target="_blank">phpMinAdmin</a>
		</div>
	</form>
<?php
	}	else	{
	//パスワードがＮＧの時
?>
	<p align="center"><strong><font color="#FF0000" size="+2"><em>パスワードが違います。</em></font></strong></p>
	<form>
		<p align="center">
		<input name="btnBack" type="button" value="ログイン画面へ戻る" onClick="history.back()">
		</p>
	</form>
<?php
	}
?>
</body>
</html>
