<?php
	require_once("_common.php");

	//オブジェクト種類の配列生成
	$arsObjectKindName	=	array("View","Stored Procedure","Stored Function");
?>

<html>
<head>
<title>ＭｙＳＱＬ ＤＢＡ オブジェクト選択画面</title>
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
		if	(xmlHttpObject) xmlHttpObject.onreadystatechange = objectListView;
		if	(xmlHttpObject)	{
			xmlHttpObject.open("GET","./object_list.php?<?php print(SID);?>&lstObjectKind="+encodeURI(document.frmSelect.lstObjectKind.value),true);
			xmlHttpObject.send("");
		}
	}

	//コールバック関数
	function objectListView()	{
		if	((xmlHttpObject.readyState ==4 ) && (xmlHttpObject.status ==200))	{
			document.getElementById("objectList").innerHTML = xmlHttpObject.responseText;
		}	else	{
			document.getElementById("objectList").innerHTML= "<b>wait</b>";
		}
	}
-->
</script>
</head>
<body bgcolor="<?php setBodyColor($sActCd)?>" onLoad="sendData(); return false;">
	<h5>【オブジェクト選択】</h5>
	<form action="object_edit.php" method="post" name="frmSelect" target="mainFrame" id="frmSelect">
		<select name="lstObjectKind" id="lstObjectKind" onChange="sendData(); return false;">
<?php
	foreach	($arsObjectKindName as $value)	{
?>
			<option value="<?php print($value) ?>"><?php print($value) ?></option>
<?php
	}
?>		</select>
		<p><hr></p>
		<div id="objectList"></div>
	</form>
</body>
</html>
