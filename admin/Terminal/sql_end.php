<?php
	require_once('_common.php');

	//受け取ったSQL文のクリーニング（コメント部分の切り取り）
	function	setCleanSqlComment(&$sSql,$sComment)	{
		//	/*! */のヒントに対応するためのオフセット（この場合以外は常に0）
		$iOffset		=	0;
		$iStartPos	=	strpos($sSql,$sComment,$iOffset);
		while	($iStartPos !== false)	{
//			if	($sComment == "/*")	{
//				//	/*の直ぐ次に!が来た場合はヒントだからクリーニングしない
//				if	(substr($sSql,$iStartPos+2,1) == "!")	{
//					$iOffset		=	$iStartPos+2;
//				}	else	{
//					//ブロックコメントの時の終了位置（*/）
//					$iEndPos	=	strpos($sSql,"*/",$iStartPos);
//					if	($iEndPos === false)	{
//						$iEndPos	=	strlen($sSql);
//					}
//					$sSql	=	substr_replace($sSql,"",$iStartPos,($iEndPos-$iStartPos+2));
//				}
//			}	else	{
				//ブロックコメント以外の終了位置（改行）
				$iEndPos	=	strpos($sSql,"\n",$iStartPos);
				if	($iEndPos === false)	{
					$iEndPos	=	strlen($sSql);
				}
				$sSql	=	substr_replace($sSql,'',$iStartPos,($iEndPos-$iStartPos));
//			}
			$iStartPos	=	strpos($sSql,$sComment,$iOffset);
		}
		//２個連続の空白を１個の空白に修正
		$sSql	=	str_replace('  ',' ',$sSql);
		//前後の空白やタブ文字の削除
		$sSql	=	trim($sSql);
	}

	//受け取ったSQL文のクリーニング（改行などを空白へ）
	function	setCleanSqlEsc(&$sSql,$sEsc)	{
		$sSql	=	str_replace($sEsc,' ',$sSql);
		$sSql	=	str_replace('  ',' ',$sSql);
	}

	//管理者権限じゃないと更新系の処理は認めないチェック
	function	chkSqlAct(&$sSql)	{
		global	$sActCd, $sErrMsg;
		if	(!isAdminAct($sActCd))	{
			$sSqlTmp4	=	mb_strtoupper(substr($sSql, 0, 4));
			$sSqlTmp6	=	mb_strtoupper(substr($sSql, 0, 6));
			if	($sSqlTmp4 != 'SHOW'	&&	$sSqlTmp6 != 'SELECT' )	{
				$sErrMsg	=	'権限が無いので、「SELECT」か「SHOW」しか実行出来ません。';
			}
		}
	}

	//ＳＱＬが入力されている必要がある時のチェック
	function	chkEmptySql(&$sSql)	{
		global	$sErrMsg;
		if	(empty($sSql))	{
			$sErrMsg	=	'ＳＱＬ文を入力してね。';
		}
	}

	//SELECT文にLIMITを付加する処理
	function	setLimited(&$sSql)	{
		//SQL文中にLIMITがあればそれを優先し、無いときはラジオの値を設定（SELECT文にのみ適用）
		$sSqlTmp	=	mb_strtoupper(substr($sSql, 0, 6));
		if	($sSqlTmp == 'SELECT')	{
			$iPos			=	strpos(mb_strtoupper($sSql),'LIMIT');
			if	($iPos === false)	{
				if	(isset($_POST['rdoLimited']))	{
					$sqlLimitVal	=	$_POST['rdoLimited'];
					if	($sqlLimitVal > 0)	{
						$sSql		.=	' LIMIT '.$sqlLimitVal;
					}
				}
			}
		}
	}

	//SELECT文のループカウント初期化
	function	setLoopCnt(&$sSql,&$iSqlLoopCnt)	{
		//SELECT文にのみ適用
		$sSqlTmp	=	mb_strtoupper(substr($sSql, 0, 6));
		if	($sSqlTmp == 'SELECT')	{
			if	(isset($_POST['rdoLoopCnt']))	{
				$iSqlLoopCnt	=	$_POST['rdoLoopCnt'];
			}
		}
	}

	//テーブル指定が必要な条件の時のチェック
	function	chkEmptyTable(&$sTableName)	{
		global	$sErrMsg;
		if	(empty($sTableName))	{
			$sErrMsg	=	'テーブルを選択してね。';
		}
	}

	//複数テーブル指定で,区切りで連結する処理
	function	setMultiTable(&$sSql,&$arsTableName)	{
		$i		=	0;
		$iMax	=	count($arsTableName);
		while	($i < $iMax)	{
			if	($i == ($iMax-1))	{
				$sSql	.=	$arsTableName[$i];
			}	else	{
				$sSql	.=	$arsTableName[$i].',';
			}
			$i++;
		}
	}

	//マイクロ秒数への変換関数
	function	getMicrotime($sTime){
		list($usec,$sec)	=	explode(' ',$sTime);
		return	((float)$sec + (float)$usec);
	}

/*------------------------------------------------------------------------------
 *	このページは共有しているため、どこから来たかをボタン名で判定
 *	btnSqlExecute			sql_edit.php：ＳＱＬ実行
 *	btnSqlExplain			sql_edit.php：ＥＸＰＬＡＩＮ
 *	btnAllTableName		db_mnt.php：ﾃｰﾌﾞﾙ名一覧表示（全ﾃｰﾌﾞﾙ）
 *	btnAllTableStatus	db_mnt.php：ﾃｰﾌﾞﾙｽﾃｰﾀｽ表示（全ﾃｰﾌﾞﾙ）
 *	btnTableStatus		db_mnt.php：ﾃｰﾌﾞﾙｽﾃｰﾀｽ表示（指定ﾃｰﾌﾞﾙ）
 *	btnColumns				db_mnt.php：ﾌｨｰﾙﾄﾞ情報表示（指定ﾃｰﾌﾞﾙ）
 *	btnIndex				db_mnt.php：ｲﾝﾃﾞｯｸｽ情報表示（指定ﾃｰﾌﾞﾙ）
 *	btnDataSelect			db_mnt.php：ﾃﾞｰﾀ表示
 *	btnOptimizeMulti		db_mnt.php：ﾃｰﾌﾞﾙの最適化（複数ﾃｰﾌﾞﾙ）
 *	btnAnalyzeMulti		db_mnt.php：ｲﾝﾃﾞｯｸｽ情報の更新（複数ﾃｰﾌﾞﾙ）
------------------------------------------------------------------------------*/

	//sql_edit.phpから来た時は、SQL文が設定されてくる
	$sSql	=	'';
	if	(isset($_POST['sSql']))	{
		$sSql	=	$_POST['sSql'];

		//前後改行・空白のカット
		$sSql	=	trim($sSql);
		//エスケープ文字変換
		$sSql	=	stripslashes($sSql);
		//受け取ったSQL文のクリーニング（コメント部分の切り取り）
//		setCleanSqlComment($sSql,"/*");
		setCleanSqlComment($sSql,"--");
		setCleanSqlComment($sSql,"#");
		//受け取ったSQL文のクリーニング（改行などを空白へ）
//		setCleanSqlEsc($sSql,"\n");
//		setCleanSqlEsc($sSql,"\r");
//		setCleanSqlEsc($sSql,"\t");
	}

	//db_mnt.phpから来た時は、テーブル名が選択されてくる
	if	(isset($_POST['sTableName']))	{
		$sTableName	=	$_POST['sTableName'];
	}	else	{
		$sTableName	=	'';
	}

//実行するＳＱＬの設定

	//初期化
	$sErrMsg	=	null;
	$bSqlSet	=	true;
	$iSqlLoopCnt	=	1;

	//ＳＱＬ実行
	if	(isset($_POST['btnSqlExecute']))	{
		chkSqlAct($sSql);
		chkEmptySql($sSql);
		setLimited($sSql);
		setLoopCnt($sSql,$iSqlLoopCnt);
	//ＥＸＰＬＡＩＮ
	}	else	if	(isset($_POST['btnSqlExplain']))	{
		chkEmptySql($sSql);
		$sSql	=	D_EXPLAIN.$sSql;
	//ﾃｰﾌﾞﾙ名一覧表示（全ﾃｰﾌﾞﾙ）
	}	else	if	(isset($_POST['btnAllTableName']))	{
		$sSql	=	D_SHOW_TABLE;
	//ﾃｰﾌﾞﾙｽﾃｰﾀｽ表示（全ﾃｰﾌﾞﾙ）
	}	else	if	(isset($_POST['btnAllTableStatus']))	{
		$sSql	=	D_SHOW_TABLE_STATUS;
	//ﾃｰﾌﾞﾙｽﾃｰﾀｽ表示（指定ﾃｰﾌﾞﾙ）
	}	else	if	(isset($_POST['btnTableStatus']))	{
		chkEmptyTable($sTableName);
		$sSql	=	D_SHOW_TABLE_STATUS." LIKE '".$sTableName."'";
	//ﾌｨｰﾙﾄﾞ(ｶﾗﾑ)情報表示（指定ﾃｰﾌﾞﾙ）
	}	else	if	(isset($_POST['btnColumns']))	{
		chkEmptyTable($sTableName);
		$sSql	=	D_SHOW_COLUMNS.$sTableName;
	//ｲﾝﾃﾞｯｸｽ情報表示（指定ﾃｰﾌﾞﾙ）
	}	else	if	(isset($_POST['btnIndex']))	{
		chkEmptyTable($sTableName);
		$sSql	=	D_SHOW_INDEX.$sTableName;
	//CREATE TABLE文表示（指定ﾃｰﾌﾞﾙ）
	}	else	if	(isset($_POST['btnCreateTable']))	{
		chkEmptyTable($sTableName);
		$sSql	=	D_SHOW_CREATE_TABLE.$sTableName;
	//ﾃﾞｰﾀ表示（指定ﾃｰﾌﾞﾙ）
	}	else	if	(isset($_POST['btnDataSelect']))	{
		chkEmptyTable($sTableName);
		$sSql	=	D_SELECT_AST.$sTableName.' '.D_LIMIT_DATA;
	//ﾃｰﾌﾞﾙの最適化（複数ﾃｰﾌﾞﾙ）
	}	else	if	(isset($_POST['btnOptimizeMulti']))	{
		$arsTableName	=	$_POST['arsTableNameMulti'];
		chkEmptyTable($arsTableName);
		$sSql	=	D_OPTIMIZE;
		setMultiTable($sSql,$arsTableName);
	//ｲﾝﾃﾞｯｸｽ情報の更新（複数ﾃｰﾌﾞﾙ）
	}	else	if	(isset($_POST['btnAnalyzeMulti']))	{
		$arsTableName	=	$_POST['arsTableNameMulti'];
		chkEmptyTable($arsTableName);
		$sSql	=	D_ANALYZE;
		setMultiTable($sSql,$arsTableName);
	}	else	{
		$bSqlSet	=	false;
		$sErrMsg	=	'バグってます。ごめんなさい。';
	}

//ＳＱＬを実行する
	if	($bSqlSet	&&	empty($sErrMsg))	{
		//時間計測（ＤＢ接続前ＳＱＬ発行直前）
		$timeDbConnect	=	microtime();
		//ＤＢ接続
		$mysqlLink = dbCon($sDbHostName,$sDbUserName,$sDbPassword,$sDbName);

		//loopカウント回数分ＳＱＬを発行する
		$i	=	0;
		while	($i	<	$iSqlLoopCnt)	{
			//ＳＱＬ実行
			if	($i!=0)	{
				mysqli_free_result($rs);
			}
			$rs	=	mysqli_query($mysqlLink,$sSql);
			$i++;
		}
		//時間計測（ＳＱＬ発行直後）
		$timeSqlResult	=	microtime();
		//ＳＱＬ結果表示編集
		$sSqlErr	=	'';
		if	(!$rs)	{
			$sSqlErr	=	mysqli_errno($mysqlLink).":".mysqli_error($mysqlLink);
		}	else	{
			//SQL文の先頭文字を大文字で取得
			$sSqlTmp4	=	mb_strtoupper(substr($sSql, 0, 4));
			$sSqlTmp5	=	mb_strtoupper(substr($sSql, 0, 5));
			$sSqlTmp6	=	mb_strtoupper(substr($sSql, 0, 6));
			$sSqlTmp7	=	mb_strtoupper(substr($sSql, 0, 7));
			$sSqlTmp8	=	mb_strtoupper(substr($sSql, 0, 8));
			//CREATE、ALTER、DROP文の場合、何も表示しない
			if	(	$sSqlTmp6 == 'CREATE'	||	$sSqlTmp5 == 'ALTER'	||
					$sSqlTmp4 == 'DROP'		||	$sSqlTmp8 == 'TRUNCATE'	)	{
			}
			//UPDATE、DELETE、INSERT文の場合は影響を受けたレコード件数を取得
			else	if	(	$sSqlTmp6 == 'UPDATE'	||	$sSqlTmp6 == 'DELETE'	||
							$sSqlTmp6 == 'INSERT'	||	$sSqlTmp7 == 'REPLACE'	)	{
				//影響を受けた件数を取得
				$iRowCnt = mysqli_affected_rows($mysqlLink);
			}	else	{
				//表示件数を取得。
				$iRowCnt	= mysqli_num_rows($rs);
				//取得したフィールド数を元にテーブルのヘッダ情報を出力
				$iFieldCnt	=	mysqli_num_fields($rs);
				//取得したフィールド情報をテーブルのヘッダとして出力
				$sTh	=	"\t\t<tr>\n";
				while	($finfo = mysqli_fetch_field($rs))	{
					$sTh	.=	"\t\t\t<th nowrap bgcolor=\"#00FF00\"><b>";
					$sTh	.=	$finfo->name."</b></th>\n";
				}
				$sTh	.=	"\t\t</tr>\n";
				//レコードセットの内容を出力
				$sTd	=	'';
				while	($arsRec = mysqli_fetch_row($rs))	{
					$sTd	.=	"\t\t<tr>\n";
					$i		=	0;
					while	($i < $iFieldCnt)	{
						if	(trim($arsRec[$i]) == '')	{
							$sTd .= "\t\t\t<td>&nbsp</td>\n";
						}	else	{
							$sTd .= "\t\t\t<td nowrap>".$arsRec[$i]."</td>\n";
						}
						$i++;
					}
					$sTd .= "\t\t</tr>\n";
				}
				if	($iRowCnt>0)	{
					mysqli_free_result($rs);
				}
			}
		}
		mysqli_close($mysqlLink);
		//時間計測（ＤＢ切断）
		$timeDbDisconnect	=	microtime();
	}
?>
<html>
<head>
<title>ＭｙＳＱＬ ＤＢＡ ＳＱＬ実行結果</title>
</head>
<body bgcolor="<?php setBodyColor($sActCd)?>">
<?php
	if	($bSqlSet	&&	empty($sErrMsg))	{
?>
	【実行ＳＱＬ】<br>
<?php
		print($sSql."\n");
?>
	<h3>【ＳＱＬ実行結果】</h3>
<?php
		if	(!empty($sSqlErr))	{
			print("\t<p><font color=\"#FF0000\">".$sSqlErr."</font></p>\n");
		}	else	{
?>
	<table border="1" bordercolor="#999999">
		<tr>
			<th nowrap bgcolor="#00CCFF">
				<font color="#0000FF">対象行数</font>
			</th>
			<th nowrap bgcolor="#00CCFF">
				<font color="#0000FF">DB接続～SQL発行直後まで</font>
			</th>
			<th nowrap bgcolor="#00CCFF">
				<font color="#0000FF">DB接続～SQL発行～全件読込（配列）～DB切断まで</font>
			</th>
		</tr>
		<tr>
			<td nowrap>
				<font color="#0000FF">
				<?php print($iRowCnt);?></font>
			</td>
			<td nowrap>
				<font color="#0000FF">
				<?php print((getMicrotime($timeSqlResult)-getMicrotime($timeDbConnect)));?></font>
			</td>
			<td nowrap>
				<font color="#0000FF">
				<?php print((getMicrotime($timeDbDisconnect)-getMicrotime($timeDbConnect)));?></font>
			</td>
		</tr>
	</table>
	<br>
<?php
			print("\t<table border=\"1\" bordercolor=\"#999999\">\n");
			print($sTh);
			print($sTd);
			print("\t</table>\n");
		}
?>
<?php
	}	else
	if	($bSqlSet	&&	!empty($sErrMsg))	{
		print("\t<p><font color=\"#FF0000\">".$sErrMsg."</font></p>\n");
	}
?>
</body>
</html>
