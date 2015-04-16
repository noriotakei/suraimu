{include file=$header}
</head>
<body {$bodyTag}>
<a name="top" id="top"></a>
<div style="font-size:x-small; text-align:left; {$limited_width}">
<img src="img/title.gif" alt="{$siteName}" width="100%" />
<div style="text-align:center;">
退会手続き
</div>
<hr {$hr_2style} />
<span style="color:#99ec00;font-size:small;">アンケート 1</span>(<span style="color:#f00;">必須</span>)
<br />
退会のご理由アンケートにご協力ください。今後のサービス向上に活用させていただきます。※YESかNOを必須<br /><br />
<form action="./?action_Taikai3=1{if $comURLparam}&{$comURLparam}{/if}" method="post">

<span style="color:#f90;font-size:small;">1)<span style="color:#eccc66;">もう十分に儲かった為</span></span><br />
<div style="text-align:center;">
<input name="q1" value="1" type="radio" />YES /
<input name="q1" value="2" type="radio" />NO<br /><br />
</div>
<span style="color:#f90;font-size:small;">2)<span style="color:#eccc66;">儲かる情報が多すぎて使いこなせない為</span></span><br />
<div style="text-align:center;">
<input name="q2" value="1" type="radio" />YES /
<input name="q2" value="2" type="radio" />NO<br /><br />
</div>
<span style="color:#f90;font-size:small;">3)<span style="color:#eccc66;">メルマガの送信数が不足の為</span></span><br />
<div style="text-align:center;">
<input name="q3" value="1" type="radio" />YES /
<input name="q3" value="2" type="radio" />NO<br /><br />
</div>
<span style="color:#f90;font-size:small;">4)<span style="color:#eccc66;">他の情報サイトで損失を出した為</span></span><br />
<div style="text-align:center;">
<input name="q4" value="1" type="radio" />YES /
<input name="q4" value="2" type="radio" />NO<br /><br />
</div>
<span style="color:#f90;font-size:small;">5)<span style="color:#eccc66;">他の理由で退会</span></span><br />
<div style="text-align:center;">
<input name="q5" value="1" type="radio" />YES /
<input name="q5" value="2" type="radio" />NO<br /><br />
</div>

<div style="text-align:center;color:#000;"><input value="退会手続きを進める" type="submit" /></div>
</form>
<br />
<form action="./?action_Home=1{if $comURLparam}&{$comURLparam}{/if}" method="post">
<div style="text-align:center;color:#000;"><input value="退会手続きを止める" type="submit" /></div>
</form>
<hr {$hr_2style} />
{include file=$pr}
{include file=$footer}
</body>
</html>