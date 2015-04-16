<?php
	//出力をUTF-8に設定
//	mb_http_output ( 'UTF-8' );	

	require_once("_common.php");
	$sObjectKind		=	$_POST['sObjectKind'];
	$sModifyObjectName	=	$_POST['sModifyObjectName'];
	$sSql				=	$_POST['sSql'];

	$sSqlErr	=	"";

	//エスケープ文字変換
	$sSql	=	stripslashes($sSql);
	$mysqlLink = dbCon($sDbHostName,$sDbUserName,$sDbPassword,$sDbName);
	
	if	(($sModifyObjectName != "") && ($sObjectKind != "View"))	{
		//PROCEDUREとFUNCTIONは、先にDROP文を実行する
		if	($sObjectKind == "Stored Procedure")	{
			$sDropSql	=	"DROP PROCEDURE IF EXISTS ".$sModifyObjectName.";";
		}	else	if	($sObjectKind = "Stored Function")	{
			$sDropSql	=	"DROP FUNCTION IF EXISTS ".$sModifyObjectName.";";
		}

		$rs	=	mysqli_query($mysqlLink,$sDropSql);
		if	(!$rs)	{
			$sSqlErr	=	mysqli_errno($mysqlLink).":".mysqli_error($mysqlLink)."\n";
		}
	}
	
	$rs	=	mysqli_query($mysqlLink,$sSql);
	if	(!$rs)	{
		$sSqlErr	.=	mysqli_errno($mysqlLink).":".mysqli_error($mysqlLink);
	}
	mysqli_close($mysqlLink);

	if	(!empty($sSqlErr))	{
		print("<p><font color=\"#FF0000\">".$sSqlErr."</font></p>\n");
	}	else	{
		print("<p><font color=\"#990000\">作成・更新 成功！</font></p>\n");
	}
?>
