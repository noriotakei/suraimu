<?php
	//出力をUTF-8に設定
//	mb_http_output ( 'UTF-8' );	

	require_once("_common.php");

	//選択されたテーブル名の取得
	$sTableName	=	$_GET['sTableName'];

	//フィールド名の一覧取得
	$iFieldCnt	=	0;
	if	(!empty($sTableName))	{
		$arsFieldName	=	getFieldName($sDbHostName,$sDbUserName,$sDbPassword,$sDbName,$sTableName);
		$iFieldCnt		=	count($arsFieldName);
	}

	//フィールド情報が取得できた時だけ表示
	if	($iFieldCnt > 0)	{
		print("<table border=\"0\" cellpadding=\"1\" cellspacing=\"1\">\n");
		print("<tr>\n");
		print("<td valign=\"bottom\" nowrap>\n");
		//管理者権限のみ表示
		if	(isAdminAct($sActCd))	{
			print("<span class=\"style1\">SELECT＆<br>INSERT＆<br>UPDATE項目</span></td>\n");
		}	else	{
			print("<span class=\"style1\">SELECT項目</span></td>\n");
		}
		print("<td valign=\"bottom\" nowrap>\n");
		print("<span class=\"style1\">WHERE項目</span></td>");
		print("<td valign=\"bottom\" nowrap>\n");
		print("<span class=\"style1\">GROUP BY項目</span></td>");
		print("<td valign=\"bottom\" nowrap>\n");
		print("<span class=\"style1\">ORDER BY項目</span></td>");
		print("</tr>\n");

		//SELECT,INSERT,UPDATE項目用の表示
		print("<tr><td valign=\"top\" nowrap>\n");
		print("<select name=\"arsSelectField[]\" size=\"".($iFieldCnt+1)."\" multiple id=\"arsSelectField\">\n");
		print("<option value=\"*\" selected>*</option>\n");
		foreach	($arsFieldName as $value)	{
			print("<option value=\"".$value."\">".$value."</option>\n");
		}
		print("</select></td>\n");

		//WHERE項目用の表示
		print("<td valign=\"top\" nowrap>\n");
		print("<select name=\"arsWhereField[]\" size=\"".($iFieldCnt+1)."\" multiple id=\"arsWhereField\">\n");
		print("<option value=\"指定無し\" selected>指定無し</option>\n");
		foreach	($arsFieldName as $value)	{
			print("<option value=\"".$value."\">".$value."</option>\n");
		}
		print("</select></td>\n");

		//GROUP BY項目用の表示
		print("<td valign=\"top\" nowrap>\n");
		print("<select name=\"arsGroupByField[]\" size=\"".($iFieldCnt+1)."\" multiple id=\"arsGroupByField\">\n");
		print("<option value=\"指定無し\" selected>指定無し</option>\n");
		foreach	($arsFieldName as $value)	{
			print("<option value=\"".$value."\">".$value."</option>\n");
		}
		print("</select></td>\n");

		//ORDER BY項目用の表示
		print("<td valign=\"top\" nowrap>\n");
		print("<select name=\"arsOrderByField[]\" size=\"".($iFieldCnt+1)."\" multiple id=\"arsOrderByField\">\n");
		print("<option value=\"指定無し\" selected>指定無し</option>\n");
		foreach	($arsFieldName as $value)	{
			print("<option value=\"".$value."\">".$value."</option>\n");
		}
		print("</select></td></tr></table>\n");
	}
?>

