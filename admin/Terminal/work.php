<?php
	require_once('_common.php');

	//ＤＢ情報取得
	$sDbSiteName	=	$_POST['sSiteName'];
	$sDbHostName	=	$_POST['sHostName'];
	$sDbUserName	=	$_POST['sUserName'];
	$sDbPassword	=	$_POST['sPassword'];
	$sDbName		=	$_POST['sDbName'];

	//ＤＢ接続確認（接続できるかを確認）
	$mysqlLink	=	dbCon($sDbHostName,$sDbUserName,$sDbPassword,$sDbName);
	mysqli_close($mysqlLink);

	//ＤＢ情報退避
	$_SESSION['sDbSiteName']	=	$sDbSiteName;
	$_SESSION['sDbHostName']	=	$sDbHostName;
	$_SESSION['sDbUserName']	=	$sDbUserName;
	$_SESSION['sDbPassword']	=	$sDbPassword;
	$_SESSION['sDbName']		=	$sDbName;

	//メインメニューにて押下されたボタンにより、フレーム表示を分ける
	$freamePattern	=	'0';
	if	(isset($_POST['btnSqlEdit']))	{
		$freamePattern	=	'1';
	}	else
	if	(isset($_POST['btnViewStoredEdit']))	{
		$freamePattern	=	'2';
	}	else
	if	(isset($_POST['btnDbMnt']))	{
		$freamePattern	=	'3';
	}
?>

<html>
<head>
<title>ＭｙＳＱＬ ＤＢＡ</title>
</head>

<?php
	//ＳＱＬ実行の時
	if	($freamePattern == '1')	{
?>
	<frameset cols="250,*" border="1">
		<frame src="table_list.php" name="leftFrame" title="Table Select" frameborder="1">
		<frameset rows="50%,*" border="1">
			<frame src="sql_edit.php" name="mainFrame" title="SQL Edit" frameborder="1">
			<frame src="sql_end.php" name="resultFrame" title="SQL Result" frameborder="1">
		</frameset>
	</frameset>
	<noframes><body>
	</body></noframes>
<?php
	}	else
	//Ｖｉｅｗ＆Ｓｔｏｒｅｄメンテの時
	if	($freamePattern == '2')	{
?>
	<frameset cols="250,*" border="1">
		<frame src="object_kind_list.php" name="leftFrame" title="Object Kind Select" frameborder="1">
		<frame src="object_edit.php" name="mainFrame" title="Object Edit" frameborder="1">
	</frameset>
	<noframes><body>
	</body></noframes>
<?php
	}	else
	//ＤＢ情報表示＆メンテ作業用の時
	if	($freamePattern == '3')	{
?>
	<frameset rows="50%,*" border="1">
		<frame src="db_mnt.php" name="mainFrame" title="mntFrame" frameborder="1">
		<frame src="sql_end.php" name="resultFrame" title="SQL Result" frameborder="1">
	</frameset>
	<noframes><body>
	</body></noframes>
<?php
	}
?>

</html>
