<?php
	//出力をUTF-8に設定
//	mb_http_output ( 'UTF-8' );	

	require_once("_common.php");

	//選択されたオブジェクト種類の取得
	$sObjectKind	=	$_GET['lstObjectKind'];

	if	($sObjectKind == "View")	{
		$sObjectKind	=	"VIEW";
	}	else	if	($sObjectKind == "Stored Procedure")	{
		$sObjectKind	=	"PROCEDURE";
	}	else	if	($sObjectKind == "Stored Function")	{
		$sObjectKind	=	"FUNCTION";
	}

	//オブジェクト名の一覧取得
	$iRowCnt	=	0;
	if	(!empty($sObjectKind))	{
		$arsObjectName	=	getObjectNameList($sDbHostName,$sDbUserName,$sDbPassword,$sDbName,$sObjectKind);
		$iRowCnt	=	count($arsObjectName);
	}

	//オブジェクト情報が取得できた時だけ表示
	if	($iRowCnt > 0)	{
		print("<span class=\"style2\"><span class=\"style1\">※複数選択可能</span></span><br>\n");
		print("<select name=\"lstSelectObject[]\" size=\"".$iRowCnt."\" multiple id=\"lstSelectObject\">\n");

		foreach	($arsObjectName as $value)	{
			print("<option value=\"".$value[0]."\">".$value[0]."</option>\n");
		}

		print("</select>\n");
		print("<br><br>\n");
		print("<input name=\"btnObjectView\" type=\"submit\" id=\"btnObjectView\" value=\"表示\">\n");
		//管理者権限のみ表示
		if	(isAdminAct($sActCd))	{
			print("<input name=\"btnObjectModify\" type=\"submit\" id=\"btnObjectModify\" value=\"編集\">\n");
			print("<input name=\"btnObjectCopy\" type=\"submit\" id=\"btnObjectCopy\" value=\"複製\">\n");
		}
	}
	//管理者権限のみ表示
	if	(isAdminAct($sActCd))	{
		print("<input name=\"btnObjectNew\" type=\"submit\" id=\"btnObjectNew\" value=\"新規\">\n");
	}
?>
