<?php
	require_once('_common.php');

//フィールド（カラム）選択画面から来た場合
	//SQL種類の識別
	$sSqlMode	=	'';
	if				(isset($_POST['btnFieldSelect']))	{
		$sSqlMode	=	'SELECT';
	}	else	if	(isset($_POST['btnFieldInsert']))	{
		$sSqlMode	=	'INSERT';
	}	else	if	(isset($_POST['btnFieldUpdate']))	{
		$sSqlMode	=	'UPDATE';
	}	else	if	(isset($_POST['btnFieldDelete']))	{
		$sSqlMode	=	'DELETE';
	}

	//選択テーブルと選択フィールドからSQL文を生成
	$sTableName			=	$_POST['sTableName'];
	$arsSelectField		=	$_POST['arsSelectField'];
	$arsWhereField		=	$_POST['arsWhereField'];
	$arsGroupByField	=	$_POST['arsGroupByField'];
	$arsOrderByField	=	$_POST['arsOrderByField'];

	if	(!empty($sTableName))	{
		if	($sSqlMode == 'SELECT')	{
		//SELECT文を生成
			$sSql	=	"SELECT\n";
			$i			=	0;
			$iMax		=	count($arsSelectField);
			while	($i < $iMax)	{
				if	($i == ($iMax-1))	{
					$sSql	.=	$arsSelectField[$i]."\n";
				}	else	{
					$sSql	.=	$arsSelectField[$i].",\n";
				}
				$i++;
			}
			$sSql	.=	"FROM ".$sTableName."\n";
		}	else
		if	($sSqlMode == 'INSERT')	{
		//INSERT文を生成
			$sSql	=	"INSERT INTO ".$sTableName."\n(";
			$i			=	0;
			$iMax		=	count($arsSelectField);
			while	($i < $iMax)	{
				if	($i == ($iMax-1))	{
					$sSql	.=	$arsSelectField[$i].")\n";
				}	else	{
					$sSql	.=	$arsSelectField[$i].",";
				}
				$i++;
			}
			$sSql	.=	"VALUES\n(";
			$i	=	0;
			while	($i < ($iMax-1))	{
				$sSql	.=	",";
				$i++;
			}
			$sSql	.=	")\n";
		}	else
		if	($sSqlMode == 'UPDATE')	{
		//UPDATE文を生成
			$sSql	=	"UPDATE ".$sTableName." SET\n";
			$i			=	0;
			$iMax		=	count($arsSelectField);
			while	($i < $iMax)	{
				if	($i == ($iMax-1))	{
					$sSql	.=	$arsSelectField[$i]." = \n";
				}	else	{
					$sSql	.=	$arsSelectField[$i]." = ,\n";
				}
				$i++;
			}
		}	else
		if	($sSqlMode == 'DELETE')	{
		//DELETE文を生成
			$sSql	=	"DELETE FROM ".$sTableName."\n";
		}
		//WHERE句を生成
		if	($sSqlMode != 'INSERT'	&&	$arsWhereField[0] != "指定無し")	{
			$i		=	0;
			$iMax	=	count($arsWhereField);
			if	($iMax == 1)	{
					$sSql	.=	"WHERE ".$arsWhereField[$i]." = \n";
			}	else	{
				while	($i < $iMax)	{
					if	($i == 0)	{
							$sSql	.=	"WHERE ".$arsWhereField[$i]." = \n";
					}	else	{
						$sSql	.=	"AND ".$arsWhereField[$i]." = \n";
					}
					$i++;
				}
			}
		}
		//GROUP BY句を生成
		if	($sSqlMode != 'INSERT'	&&	$arsGroupByField[0] != "指定無し")	{
			$i		=	0;
			$iMax	=	count($arsGroupByField);
			if	($iMax == 1)	{
					$sSql	.=	"GROUP BY ".$arsGroupByField[$i]."\n";
			}	else	{
				while	($i < $iMax)	{
					if	($i == 0)	{
							$sSql	.=	"GROUP BY ".$arsGroupByField[$i];
					}	else	{
						$sSql	.=	",".$arsGroupByField[$i];
					}
					$i++;
				}
				if	($iMax > 1)	{
					$sSql	.=	"\n";
				}
			}
		}
		//ORDER BY句を生成
		if	($sSqlMode != 'INSERT'	&&	$arsOrderByField[0] != "指定無し")	{
			$i		=	0;
			$iMax	=	count($arsOrderByField);
			if	($iMax == 1)	{
					$sSql	.=	"ORDER BY ".$arsOrderByField[$i]."\n";
			}	else	{
				while	($i < $iMax)	{
					if	($i == 0)	{
							$sSql	.=	"ORDER BY ".$arsOrderByField[$i];
					}	else	{
						$sSql	.=	",".$arsOrderByField[$i];
					}
					$i++;
				}
				if	($iMax > 1)	{
					$sSql	.=	"\n";
				}
			}
		}
	}
?>

<html>
<head>
<title>ＭｙＳＱＬ ＤＢＡ ＳＱＬ実行画面</title>
<script language="JavaScript" type="text/javascript">
<!--
	//フォーカスをテキストエリアに設定する
	function	setFocus()	{
		document.frmSql.sSql.focus();
	}
	//テキストエリアをクリアする
	function	sqlClear()	{
		document.frmSql.sSql.value="";
		setFocus();
	}
	//SQL文をチェックする
	function	chkSql()	{
		var bEmpty		=	chkSqlEmpty();
		if	(!bEmpty)	{
			return	false;
		}
		var sSqlTmp	=	document.frmSql.sSql.value;
		//SQL文の先頭で簡易チェック（権限チェックはsql_end.phpで実装）
		var sSqlTmp4	=	sSqlTmp.substr(0,4).toUpperCase();
		var sSqlTmp6	=	sSqlTmp.substr(0,6).toUpperCase();
		//確認メッセージを表示する
		if	((sSqlTmp4 != "SHOW")	&&	(sSqlTmp6 != "SELECT"))	{
			bResTmp	=	confirm("「SELECT，SHOW」以外の処理ですが、実行してよろしいですか？");
			if	(!bResTmp)	{
				return	false;
			}
		}
		if	(sSqlTmp6 == "UPDATE"	||	sSqlTmp6 == "DELETE")	{
			iWherePos	=sSqlTmp.toUpperCase().indexOf("WHERE");
			if	(iWherePos <= 0)	{
				bResTmp	=	confirm("「WHERE」がありませんが、実行してよろしいですか？");
				if	(!bResTmp)	{
					return	false;
				}
			}
		}
		return	true;
	}
	//SQL文の必須チェック
	function	chkSqlEmpty()	{
		var sSqlTmp	=	document.frmSql.sSql.value;
		if	(sSqlTmp == "")	{
			alert("ＳＱＬ文が未入力です。");
			setFocus();
			return	false;
		}
		return	true;
	}
-->
</script>
</head>
<body bgcolor="<?php setBodyColor($sActCd)?>" onLoad="setFocus()">
	<h5>接続先：
<?php
		print($sDbSiteName." : ".$sDbName);
?>
	</h5>
	<form action="sql_end.php" method="post" name="frmSql" target="resultFrame" id="frmSql" onSubmit="return chkSqlEmpty()">
	<div align="center">
		<h4>ＳＱＬ文</h4>
		<textarea name="sSql" cols="100" rows="10" wrap="off"><?php print($sSql);?></textarea>
			<br>
			<font size="-1">
			<label><font color="#0000FF">※↓SELECT文にのみ適用（SQL文中のLIMIT指定を優先）</font> </label>
			</font>
			<table width="200" cellpadding="3" cellspacing="0">
				<tr>
					<td nowrap valign="top">
						<input name="rdoLimited" id="rdoLimited1" type="radio" value="10" checked>
						<label for="rdoLimited1">LIMIT 10</label>
					</td>
					<td nowrap valign="top">
						<input name="rdoLimited" id="rdoLimited2" type="radio" value="100">
						<label for="rdoLimited2">LIMIT 100</label>
					</td>
					<td nowrap valign="top">
						<input name="rdoLimited" id="rdoLimited3" type="radio" value="0">
						<label for="rdoLimited3">UNLIMITED</label>
					</td>
				</tr>
			</table>
			<font size="-1">
			<label><font color="#0000FF">※↓SELECT文にのみ適用（レスポンステストに使用）</font> </label>
			</font>
			<table width="200" cellpadding="3" cellspacing="0">
				<tr>
					<td nowrap valign="top">
						<input name="rdoLoopCnt" id="rdoLoopCnt1" type="radio" value="1" checked>
						<label for="rdoLoopCnt1">UNLOOP</label>
					</td>
					<td nowrap valign="top">
						<input name="rdoLoopCnt" id="rdoLoopCnt2" type="radio" value="1000">
						<label for="rdoLoopCnt2">LOOP 1000</label>
					</td>
					<td nowrap valign="top">
						<input name="rdoLoopCnt" id="rdoLoopCnt3" type="radio" value="10000">
						<label for="rdoLoopCnt3">LOOP 10000</label>
					</td>
				</tr>
		</table>
		<input name="btnSqlExecute" type="submit" id="btnSqlExecute" value="ＳＱＬ実行" onClick="return chkSql()">&nbsp;
		<input name="btnSqlExplain" type="submit" id="btnSqlExplain" value="ＥＸＰＬＡＩＮ">&nbsp;
		<input name="btnSqlClear" type="button" id="btnSqlClear" value="ＳＱＬクリア" onClick="sqlClear()">
<?php
		//管理者権限のみ表示
		if	(isAdminAct($sActCd))	{
?>
		<p><font size="-1" color="#0000FF">
			Stored Procedure / Stored Function の作成・更新は、「Ｖｉｅｗ＆Ｓｔｏｒｅｄメンテ用画面」から行ってください。<br>
			この画面からも作成はできますが、この画面だと、タブや改行コード、連続するスペースを全てスペース１つに補正してしまいます。
		</font></p>
<?php
		}
?>
	</div>
</form>
</body>
</html>
