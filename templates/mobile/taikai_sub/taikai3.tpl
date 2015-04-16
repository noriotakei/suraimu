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
<span style="color:#99ec00;font-size:small;">アンケート 2</span>(<span style="color:#f00;">必須</span>)
<br />
<form action="./?action_Taikai4=1{if $comURLparam}&{$comURLparam}{/if}" method="post">
{$POSTparam}
<span style="color:#f90;">6)<span style="color:#eccc66;">1)で「もう十分に儲かった為」をYESと回答された場合</span></span><br />
<span style="color:#ffa500;">※お幾らほどの利益でしょうか?</span><br />
<span style="color:#000;"><input name="q6" value="1" type="radio" /></span>
〜1万円未満<br />
<span style="color:#000;"><input name="q6" value="2" type="radio" /></span>
1万円以上〜10万円未満<br />
<span style="color:#000;"><input name="q6" value="3" type="radio" /></span>
10万円以上〜100万円未満<br />
<span style="color:#000;"><input name="q6" value="4" type="radio" /></span>
100万円以上〜1000万円未満<br />
<span style="color:#000;"><input name="q6" value="5" type="radio" /></span>
1000万円以上〜<br />
<br />
<span style="color:#f90;">7)<span style="color:#eccc66;">2)で「儲かる情報が多すぎて使いこなせない為」をYESと回答された場合</span></span><br />
<span style="color:#ffa500;">※幾つ情報を入手しましたか?</span><br />
<span style="color:#000;"><input name="q7" value="1" type="radio" /></span>
〜10件未満<br />
<span style="color:#000;"><input name="q7" value="2" type="radio" /></span>
10件以上〜20件未満<br />
<span style="color:#000;"><input name="q7" value="3" type="radio" /></span>
20件以上〜50件未満<br />
<span style="color:#000;"><input name="q7" value="4" type="radio" /></span>
50件以上〜100件未満<br />
<span style="color:#000;"><input name="q7" value="5" type="radio" /></span>
100件以上〜<br />
<br />
<span style="color:#f90;">8)<span style="color:#eccc66;">3)で「メルマガの送信数が不足の為」をYESと回答された場合</span></span><br />
<span style="color:#ffa500;">※1日何通のメルマガを希望しますか?</span><br />
<span style="color:#000;"><input name="q8" value="1" type="radio" /></span>
1通<br />
<span style="color:#000;"><input name="q8" value="2" type="radio" /></span>
2通<br />
<span style="color:#000;"><input name="q8" value="3" type="radio" /></span>
3通<br />
<span style="color:#000;"><input name="q8" value="4" type="radio" /></span>
4通<br />
<span style="color:#000;"><input name="q8" value="5" type="radio" /></span>
5通以上〜<br />
<br />
<span style="color:#f90;">9)<span style="color:#eccc66;">4)で「他の情報サイトで損失を出した為」をYESと回答された場合</span></span><br />
<span style="color:#000;"><input name="q9" value="1" type="radio" /></span>
〜1万円未満<br />
<span style="color:#000;"><input name="q9" value="2" type="radio" /></span>
1万円以上〜10万円未満<br />
<span style="color:#000;"><input name="q9" value="3" type="radio" /></span>
10万円以上〜100万円未満<br />
<span style="color:#000;"><input name="q9" value="4" type="radio" /></span>
100万円以上〜1000万円未満<br />
<span style="color:#000;"><input name="q9" value="5" type="radio" /></span>
1000万円以上〜<br />
<br />
<span style="color:#f90;">10)<span style="color:#eccc66;">5)で「他の理由で退会」をYESと回答された場合</span></span><br />
<span style="color:#ffa500;">※理由を教えていただけますか?</span><br />
<textarea name="q10" rows="3"></textarea>
<br />
<br />

<div style="text-align:center;"><input value="退会手続きを進める" type="submit" /></div>
</form>
<br />
<form action="./?action_Home=1{if $comURLparam}&{$comURLparam}{/if}" method="post">
<div style="text-align:center;"><input value="退会手続きを止める" type="submit" /></div>
</form>

<hr {$hr_2style} />
{include file=$pr}
{include file=$footer}
</body>
</html>