<?php
	require_once("_common.php");

	//オブジェクト指定が必要な条件の時のチェック
	function	chkEmptyObject(&$sObjectName)	{
		global	$sObjectKind,$sErrMsg;
		if	(empty($sObjectName))	{
			$sErrMsg	=	$sObjectKind."を選択してね。";
		}
	}

	//選択種類と選択オブジェクトから実行するSQL文を生成
	$sObjectKind		=	$_POST['lstObjectKind'];
	$arsSelectObject	=	$_POST['lstSelectObject'];

	//初期化
	$sObject	=	array();
	$iObjectCnt	=	count($arsSelectObject);
	$sEditMode	=	"";	
	$sReadOnly	=	"";
	$sViewSql	=	"";
	$sModifyObjectName	=	"";
	if	($iObjectCnt == 1)	{
		$sModifyObjectName	=	$arsSelectObject[0];
	}
	$sLabel1	=	$sObjectKind;
	$sLabel2	=	"";
	if	($iObjectCnt == 1)	{
		$sLabel2	=	"－【".$sModifyObjectName."】";
	}	else	{
		$sLabel2	=	"－【複数選択表示】";
	}
	$sLabel3	=	"";
	$sFooterMsg	=	"";
	$sBtnLabel	=	"";
	
	//複数選択時はテキストエリアをReadOnlyにする
	if	($iObjectCnt > 1)	{
		$sReadOnly	=	"readonly";
	}

	//編集モードに依存する制御
	if	(isset($_POST['btnObjectView']))	{
		//表示
		$sEditMode	=	"VIEW";
		chkEmptyObject($arsSelectObject);
		$sViewSql	=	"CREATE VIEW `',TABLE_NAME,'`";
		$sReadOnly	=	"readonly";
		if	($iObjectCnt == 1)	{
			$sLabel3	=	"－【表示】";
		}
	}	else
	if	(isset($_POST['btnObjectModify']))	{
		//編集
		$sEditMode	=	"MODIFY";
		chkEmptyObject($arsSelectObject);
		if	($iObjectCnt == 1)	{
			$sViewSql	=	"CREATE OR REPLACE VIEW `',TABLE_NAME,'`";
			$sLabel3	=	"－【編集】";
			//フッタメッセージの編集
			if	($sObjectKind == "View")	{
				$sFooterMsg	=	"<p><font color=\"#FF0000\">`[View名]`は変更しないでね！<br>";
				$sFooterMsg	.=	"（変更した名前で作成、または、同名のViewを上書きしちゃいます！！）</font></p>";
			}	else
			if	($sObjectKind == "Stored Procedure")	{
				$sFooterMsg	=	"<p><font color=\"#FF0000\">`[Procedure名]`は変更しないでね！<br>";
				$sFooterMsg	.=	"※内部的に、①DROP→②CREATEしているため、名前を変更しても、元のProcedureを削除しちゃいます！！</font></p>";
			}	else
			if	($sObjectKind == "Stored Function")	{
				$sFooterMsg	=	"<p><font color=\"#FF0000\">`[Function名]`は変更しないでね！<br>";
				$sFooterMsg	.=	"※内部的に、①DROP→②CREATEしているため、名前を変更しても、元のFunctionを削除しちゃいます！！</font></p>";
			}			

			$sBtnLabel	=	"更新";
		}	else	{
			$sViewSql	=	"CREATE VIEW `',TABLE_NAME,'`";
		}
	}	else
	if	(isset($_POST['btnObjectCopy']))	{
		//複製
		$sEditMode	=	"COPY";
		chkEmptyObject($arsSelectObject);
		if	($iObjectCnt == 1)	{
			$sViewSql	=	"CREATE VIEW `[View名]`";
			$sModifyObjectName	=	"";
			$sLabel2	=	"－【複製】";
				//フッタメッセージの編集
				$sFooterMsg	=	"<p><font size=\"-1\" color=\"#0000FF\">";
				if	($sObjectKind == "View")	{
					$sFooterMsg	.=	"`[View名]`";
				}	else	if	($sObjectKind == "Stored Procedure")	{
					$sFooterMsg	.=	"`[Procedure名]`";
				}	else	if	($sObjectKind == "Stored Function")	{
					$sFooterMsg	.=	"`[Function名]`";
				}			
				$sFooterMsg	.=	"を正しい名前に修正してから「作成」ボタンを押下してね</font></p>";
			$sBtnLabel	=	"作成";
		}	else	{
			$sViewSql	=	"CREATE VIEW `',TABLE_NAME,'`";
		}
	}	else
	if	(isset($_POST['btnObjectNew']))	{
		//新規
		$sEditMode	=	"NEW";
		$arsSelectObject	=	array();
		$iObjectCnt	=	1;
		$sReadOnly	=	"";
		$sModifyObjectName	=	"";
		$sLabel2	=	"－【新規】";
			//フッタメッセージの編集
			$sFooterMsg	=	"<p><font size=\"-1\" color=\"#0000FF\">";
			if	($sObjectKind == "View")	{
				$sFooterMsg	.=	"`[View名]`";
			}	else	if	($sObjectKind == "Stored Procedure")	{
				$sFooterMsg	.=	"`[Procedure名]`";
			}	else	if	($sObjectKind == "Stored Function")	{
				$sFooterMsg	.=	"`[Function名]`";
			}			
			$sFooterMsg	.=	"を正しい名前に修正してから「作成」ボタンを押下してね</font></p>";
		$sBtnLabel	=	"作成";
	}

	if	(!empty($sObjectKind) && empty($sErrMsg))	{
		//新規の時
		if	($sEditMode == "NEW")	{
			if	($sObjectKind == "View")	{
				$sObject[]	=	"CREATE VIEW `[View名]` AS";
			}	else
			if	($sObjectKind == "Stored Procedure")	{
				$sObject[]	=	"CREATE PROCEDURE `[Procedure名]`\nBEGIN\n\nEND;";
			}	else
			if	($sObjectKind == "Stored Function")	{
				$sObject[]	=	"CREATE FUNCTION `[Function名]`\nBEGIN\n\nEND;";
			}			
		}	else	{
		//ソース表示の時（複数選択に対応）
			$i			=	0;

			$mysqlLink	=	dbCon($sDbHostName,$sDbUserName,$sDbPassword,$sDbName);
			while	($i < $iObjectCnt)	{
				if	($sObjectKind == "View")	{
					$sSql	=	"SELECT ";
					$sSql	.=	"CONCAT('".$sViewSql." AS\n',";
					$sSql	.=	"REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(";
					$sSql	.=	"VIEW_DEFINITION,CONCAT('`',TABLE_SCHEMA,'`.'),''";
					$sSql	.=	"),'select ','select\n'";
					$sSql	.=	"),' from','\nfrom'";
					$sSql	.=	"),' where','\nwhere'";
					$sSql	.=	"),' and','\nand'";
					$sSql	.=	"),' group by','\ngroup by'";
					$sSql	.=	"),' order by','\norder by'";
					$sSql	.=	"),',',',\n'";
					$sSql	.=	"))";
					$sSql	.=	"FROM INFORMATION_SCHEMA.VIEWS ";
					$sSql	.=	"WHERE TABLE_SCHEMA = '".$sDbName."' ";
					$sSql	.=	"AND TABLE_NAME = '".$arsSelectObject[$i]."'";
					$iFieldNum	=	0;
				}	else
				if	($sObjectKind == "Stored Procedure")	{
					$sSql	=	"SHOW CREATE PROCEDURE ".$arsSelectObject[$i];
					$iFieldNum	=	2;
				}	else
				if	($sObjectKind == "Stored Function")	{
					$sSql	=	"SHOW CREATE FUNCTION ".$arsSelectObject[$i];
					$iFieldNum	=	2;
				}
	
				$rs	=	mysqli_query($mysqlLink,$sSql);
				if	((mysqli_errno($mysqlLink)) > 0)	{
					print("<br><br>".mysqli_errno($mysqlLink).":".mysqli_error($mysqlLink)."<br><br>");
					die("ＳＱＬエラーが発生しました。");
				}	else	{
					while	($rec	=	mysqli_fetch_array($rs))	{
						$sObject[]	=	$rec[$iFieldNum];
					}
				}
				mysqli_free_result($rs);
				$i++;
			}
			mysqli_close($mysqlLink);
		}
	}

?>
<html>
<head>
<title>ＭｙＳＱＬ ＤＢＡ オブジェクト編集画面</title>
<style type="text/css">
<!--
.style1 {font-size: x-small}
.style2 {color: #0000FF}
-->
</style>
<?php
	if	(!empty($sObjectKind) && empty($sErrMsg))	{
?>
<script language="JavaScript" type="text/javascript">
<!--
	//ボタン押下時のアクション
	function sendData(sSql)	{
	
		if	(!chkSqlEmpty())	{	return	false;	}
		if	(!confrimMsg())	{	return	false;	}
	
		//XMLhttpObjectの生成
		xmlHttpObject = null;
		if	(window.XMLHttpRequest)	{	//opera,firefox等
				xmlHttpObject=new XMLHttpRequest();
		}	else	if	(window.ActiveXObject)	{	//IE
			try	{
				xmlHttpObject=new ActiveXObject("Msxml2.XMLHTTP");	//IE6
			}	catch(e)	{
				try	{
					xmlHttpObject = new ActiveXObject("Microsoft.XMLHTTP");
				}	catch(e)	{
					return null;
				}
			}
		}

		//XMLhttpObject　状態が変わったら実行される関数を指定。
		if	(xmlHttpObject) xmlHttpObject.onreadystatechange = resultView;
		if	(xmlHttpObject)	{
			xmlHttpObject.open("POST","./object_end.php",true);
			xmlHttpObject.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			xmlHttpObject.send("<?php print(SID);?>&sObjectKind=<?php print($sObjectKind);?>&sModifyObjectName=<?php print($sModifyObjectName);?>&sSql="+sSql);
		}
	}

	//コールバック関数
	function resultView()	{
		if	((xmlHttpObject.readyState ==4 ) && (xmlHttpObject.status ==200))	{
			document.getElementById("resultArea").innerHTML = xmlHttpObject.responseText;
		}	else	{
			document.getElementById("resultArea").innerHTML= "<b>wait</b>";
		}
	}

	//フォーカスをテキストエリアに設定する
	function	setFocus()	{
		document.frmObjectEdit.sSql.focus();
	}
	//更新時確認メッセージ
	function	confrimMsg()	{
		//確認メッセージを表示する
		bResTmp	=	confirm("作成・更新してよろしいですか？");
		if	(!bResTmp)	{
			return	false;
		}
		return	true;
	}
	//必須チェック
	function	chkSqlEmpty()	{
		var sSqlTmp	=	document.frmObjectEdit.sSql.value;
		if	(sSqlTmp == "")	{
			alert("未入力です。");
			setFocus();
			return	false;
		}
		return	true;
	}
-->
</script>
<?php
	}
?>
</head>
<body bgcolor="<?php setBodyColor($sActCd)?>"<?php if (!empty($sObjectKind) && empty($sErrMsg)) {?> onLoad="setFocus()"<?php } ?>>
	<h5>接続先：
<?php
	print($sDbSiteName." : ".$sDbName);

	if	(!empty($sObjectKind) && empty($sErrMsg))	{
?>
	</h5>
	<div align="center">
	<form name="frmObjectEdit" target="mainFrame" id="frmObjectEdit">
		<h4><?php print($sLabel1.$sLabel2.$sLabel3);?></h4>
		<textarea name="sSql" cols="100" rows="30" wrap="off"<?php print($sReadOnly);?>>
<?php
	//ソースの表示（複数選択時は区切り線を入れて表示）
	$i	=	0;
	while	($i < $iObjectCnt)	{
		if	($i > 0)	{
			print("\n\n--------------------------------------------------------------------------------\n\n");
		}
		print($sObject[$i]);
		$i++;
	}
	if	($iObjectCnt > 0)	{
		print("\n");
	}
?></textarea>
<?php
		//管理者権限のみ表示、かつ、ReadOnly時は非表示
		if	(isAdminAct($sActCd) && ($sReadOnly == ""))	{
			print($sFooterMsg);
?>
		<p><font color="#FF0000">日本語は絶対に入力しないでください！（文字化けします）</font></p>
		<input name="btnExecute" type="button" id="btnExecute" value="<?php print($sBtnLabel);?>" onClick="sendData(document.frmObjectEdit.sSql.value); return false;">
<?php
		}
?>
<?php
	}	else
	if	(!empty($sErrMsg))	{
		print("\t<p><font color=\"#FF0000\">".$sErrMsg."</font></p>\n");
	}
?>
	</form>
	<div id="resultArea"></div>
	</div>
</body>
</html>
