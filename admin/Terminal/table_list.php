<?php
	require_once('_common.php');

	//テーブル名の一覧取得
	$arsTableName	=	getObjectNameList($sDbHostName,$sDbUserName,$sDbPassword,$sDbName,'TABLE');
?>

<html>
<head>
<title>ＭｙＳＱＬ ＤＢＡ テーブル選択画面</title>
<style type="text/css">
<!--
.style1 {font-size: x-small}
.style2 {color: #0000FF}
-->
</style>
<script language="JavaScript" type="text/javascript">
<!--
	//リスト変更時のアクション
	function sendData()	{
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
		if	(xmlHttpObject) xmlHttpObject.onreadystatechange = fieldListView;
		if	(xmlHttpObject)	{
			xmlHttpObject.open("GET","./field_list.php?<?php print(SID);?>&sTableName="+encodeURI(document.frmSelect.sTableName.value),true);
			xmlHttpObject.send("");
		}
	}

	//コールバック関数
	function fieldListView()	{
		if	((xmlHttpObject.readyState ==4 ) && (xmlHttpObject.status ==200))	{
			document.getElementById("fieldList").innerHTML = xmlHttpObject.responseText;
		}	else	{
			document.getElementById("fieldList").innerHTML= "<b>wait</b>";
		}
	}
-->
</script>
</head>
<body bgcolor="<?php setBodyColor($sActCd)?>" onLoad="sendData(); return false;">
	<h5>【テーブル選択】</h5>
	<form action="sql_edit.php" method="post" name="frmSelect" target="mainFrame" id="frmSelect">
		<select name="sTableName" id="sTableName" onChange="sendData(); return false;">
<?php
	foreach	($arsTableName as $value)	{
?>
			<option value="<?php print($value[0]) ?>"><?php print($value[0]) ?></option>
<?php
	}
?>		</select>
		<p><hr></p>
		<h5>【フィールド選択】</h5>
		<span class="style2"><span class="style1">※複数選択可能</span></span><br>
		<div id="fieldList"></div>
		<br>
		<input name="btnFieldSelect" type="submit" id="btnFieldSelect" value="SELECT"><br>
<?php
		//管理者権限のみ表示
		if	(isAdminAct($sActCd))	{
?>
		<input name="btnFieldInsert" type="submit" id="btnFieldInsert" value="INSERT"><br>
		<input name="btnFieldUpdate" type="submit" id="btnFieldUpdate" value="UPDATE"><br>
		<input name="btnFieldDelete" type="submit" id="btnFieldDelete" value="DELETE">
<?php
		}
?>
	</form>
</body>
</html>
