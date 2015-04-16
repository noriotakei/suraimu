<?php

//MySQL DBA用共通関数集

//アカウント設定（パスワード認証、権限設定）
//グローバル変数$S_ACTへの設定を行う
//戻り値はboolean（OK：true、NG：false）
	function	setAccount($sPassword,&$sActCd)	{
		global	$ARS_ACT;
		if				($sPassword == D_USER_PASSWORD)	{
			$sActCd	=	$ARS_ACT['cd'][0];
			return	true;
		}	else	if	($sPassword == D_ADMIN_PASSWORD)	{
			$sActCd	=	$ARS_ACT['cd'][1];
			return	true;
		}	else	{
			$sActCd	=	$ARS_ACT['cd'][2];
			return	false;
		}
	}

//DB接続
	function	dbCon($sHostName,$sUserName,$sPassword,$sDbName)	{
		if	(trim($sHostName) == '')	{
			die('サイトを選択するか、Host Nameを入力してください。');
		}
		if	(trim($sUserName) == '')	{
			die('サイトを選択するか、User Nameを入力してください。');
		}
		if	(trim($sPassword) == '')	{
			die('サイトを選択するか、Passwordを入力してください。');
		}
		if	(trim($sDbName) == '')	{
			die('サイトを選択するか、use DBを入力してください。');
		}

		$mysqlLink	=	mysqli_connect($sHostName,$sUserName,$sPassword,$sDbName);
		if	(!$mysqlLink)	{
			print('<br><br>'.mysqli_connect_errno().':'.mysqli_connect_error().'<br><br>');
			die('データベースに接続できません。');
		}
		return	$mysqlLink;
	}

//名前一覧の取得
	function	getObjectNameList($sHostName,$sUserName,$sPassword,$sDbName,$kind)	{
		if	($kind	==	'TABLE')	{
			$sSql	=	D_SHOW_TABLE;
		}	else	if	($kind	==	'VIEW')	{
			$sSql	=	'SELECT TABLE_NAME AS VIEW_NAME ';
			$sSql	.=	'FROM INFORMATION_SCHEMA.VIEWS ';
			$sSql	.=	"WHERE TABLE_SCHEMA = '".$sDbName."'";
		}	else	if	($kind	==	'PROCEDURE')	{
			$sSql	=	'SELECT ROUTINE_NAME AS PROCEDURE_NAME ';
			$sSql	.=	'FROM INFORMATION_SCHEMA.ROUTINES ';
			$sSql	.=	"WHERE ROUTINE_SCHEMA = '".$sDbName."' ";
			$sSql	.=	"AND ROUTINE_TYPE = 'PROCEDURE'";
		}	else	if	($kind	==	'FUNCTION')	{
			$sSql	=	'SELECT ROUTINE_NAME AS PROCEDURE_NAME ';
			$sSql	.=	'FROM INFORMATION_SCHEMA.ROUTINES ';
			$sSql	.=	"WHERE ROUTINE_SCHEMA = '".$sDbName."' ";
			$sSql	.=	"AND ROUTINE_TYPE = 'FUNCTION'";
		};

		$mysqlLink	=	dbCon($sHostName,$sUserName,$sPassword,$sDbName);
		$rs	=	mysqli_query($mysqlLink,$sSql);
		if	(!$rs)	{
			print('<br><br>'.mysqli_errno($mysqlLink).':'.mysqli_error($mysqlLink).'<br><br>');
			die('ＳＱＬエラーが発生しました。');
		}	else	{
			while	($rec	=	mysqli_fetch_array($rs))	{
				$arsName[]	=	$rec;
			}
		}
		mysqli_free_result($rs);
		mysqli_close($mysqlLink);
		return	$arsName;
	}

//フィールド（カラム）名一覧の取得
	function	getFieldName($sHostName,$sUserName,$sPassword,$sDbName,$sTableName)	{
		$mysqlLink	=	dbCon($sHostName,$sUserName,$sPassword,$sDbName);
		$rs	=	mysqli_query($mysqlLink,D_SHOW_COLUMNS.$sTableName);
		if	(!$rs)	{
			print('<br><br>'.mysqli_errno($mysqlLink).':'.mysqli_error($mysqlLink).'<br><br>');
			die('ＳＱＬエラーが発生しました。');
		}	else	{
			while	($rec	=	mysqli_fetch_assoc($rs))	{
				$arsName[]	=	$rec['Field'];
			}
		}
		mysqli_free_result($rs);
		mysqli_close($mysqlLink);
		return	$arsName;
	}


//Body Colorを設定
	function setBodyColor(&$sActCd)	{
		global $ARS_ACT;
		print($ARS_ACT['bgcolor'][array_search($sActCd,$ARS_ACT['cd'])]);
	}

//管理ユーザの判定
//更新権限を持ってればtrueを戻す
	function	isAdminAct(&$sActCd)	{
		global $ARS_ACT;
		return	$ARS_ACT['actAdminFlg'][array_search($sActCd,$ARS_ACT['cd'])];
	}
?>
