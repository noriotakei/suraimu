<?php
	require_once('_common.php');

	//テーブル名の一覧取得
	$arsTableName	=	getObjectNameList($sDbHostName,$sDbUserName,$sDbPassword,$sDbName,"TABLE");
?>
<html>
<head>
<title>ＭｙＳＱＬ ＤＢＡ ＳＱＬ ＤＢ情報表示＆メンテ作業用画面</title>
<script language="JavaScript" type="text/javascript">
<!--
	function	chkConfirm()	{
		res	=	confirm("実行してよろしいですか？");
		return	res;
	}
-->
</script>
</head>
<body bgcolor="<?php setBodyColor($sActCd)?>">
	<h5>接続先：
<?php
		print($sDbSiteName." : ".$sDbName);
?>
	</h5>
	<div align="center">
		<hr>
		<form action="sql_end.php" method="post" name="frmAllTable" target="resultFrame" id="frmAllTable">
			<h4><font color="#0000FF">全テーブルに対しての処理</font></h4>
			<table border="0" cellpadding="3" cellspacing="3">
				<tr>
					<td>
						<input name="btnAllTableName" type="submit" value="ﾃｰﾌﾞﾙ名一覧表示">
					</td>
				</tr>
				<tr>
					<td>
						<input name="btnAllTableStatus" type="submit" value="ﾃｰﾌﾞﾙｽﾃｰﾀｽ表示">
					</td>
				</tr>
			</table>
		</form>
		<hr>
		<form action="sql_end.php" method="post" name="frmTableSelect" target="resultFrame" id="frmTableSelect">
			<h4><font color="#0000FF">テーブル単位の処理</font></h4>
			（テーブル名を選択後、ボタンを押下）<br>
			<table border="0" cellpadding="3" cellspacing="3">
				<tr>
					<td valign="top" rowspan="2">
						<select name="sTableName" id="sTableName">
<?php
	foreach	($arsTableName as $value)	{
?>
							<option value="<?php print($value[0]) ?>"><?php print($value[0]) ?></option>
<?php
	}
?>
						</select>
					</td>
					<td valign="top">
							<input name="btnTableStatus" type="submit" value="ﾃｰﾌﾞﾙｽﾃｰﾀｽ表示">
							<br>
							<input name="btnColumns" type="submit" value="ﾌｨｰﾙﾄﾞ情報表示">
							<br>
							<input name="btnIndex" type="submit" value="ｲﾝﾃﾞｯｸｽ情報表示">
							<br>
							<input name="btnCreateTable" type="submit" value="CREATE TABLE文表示">
					</td>
				</tr>
				<tr>
					<td nowrap>
							<input name="btnDataSelect" type="submit" value="ﾃﾞｰﾀSAMPLE表示"> (<?php print(strtoupper(D_LIMIT_DATA));?>)
					</td>
				</tr>
			</table>
		</form>
<?php
	//管理者権限のみ表示
	if	(isAdminAct($sActCd))	{
?>
		<hr>
		<form action="sql_end.php" method="post" name="frmMntMenu" target="resultFrame" id="frmMntMenu">
			<h4><font color="#FF0000">保守作業用</font></h4>
			<table border="0" cellpadding="3" cellspacing="3">
				<tr>
					<td valign="top">
						<font color="#0000FF">※複数選択可能</font><br>
						<select name="arsTableNameMulti[]" size="<?php print(count($arsTableName));?>" multiple id="arsTableNameMulti">
<?php
		foreach	($arsTableName as $value)	{
?>
							<option value="<?php print($value[0]) ?>"><?php print($value[0]) ?></option>
<?php
		}
?>
						</select>
					</td>
					<td valign="top">
						<br>
						<input name="btnOptimizeMulti" type="submit" id="btnOptimizeMulti" onClick="return chkConfirm()" value="ﾃｰﾌﾞﾙの最適化"> 
						(OPTIMIZE)
						<br>
						<input name="btnAnalyzeMulti" type="submit" id="btnAnalyzeMulti" onClick="return chkConfirm()" value="ｲﾝﾃﾞｯｸｽ情報の更新"> 
						(ANALYZE)
					</td>
				</tr>
			</table>
		</form>
<?php
	}
?>
	</div>
</body>
</html>
