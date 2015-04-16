<?php

//MySQL DBA用 COMMON

//session start
	session_start();

//共通コンスタント集読込
	require_once('_def.php');

//共通関数集読込
	require_once('_func.php');

//session変数読込

	//アカウント情報取得
	$sActCd		=	$_SESSION['sActCd'];

	//ＤＢ情報取得
	$sDbSiteName	=	$_SESSION['sDbSiteName'];
	$sDbHostName	=	$_SESSION['sDbHostName'];
	$sDbUserName	=	$_SESSION['sDbUserName'];
	$sDbPassword	=	$_SESSION['sDbPassword'];
	$sDbName		=	$_SESSION['sDbName'];

?>
