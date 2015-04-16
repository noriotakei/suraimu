{include file=$header}
</head>
<body>
<a name="top" id="top"></a>
{include file=$status}<div id="wrap">
<div id="imageArea">{include file=$headCampaign}</div>
{include file=$headerMenu}
<div id="contents">
<div id="main">
<div class="mainBox">
<div id="titleTaikai">退会</div>
<form action="./?action_Taikai3=1" method="post">
{$comFORMparam}
<dl>
<p>
アンケート 1<span id="attention">(必須)</span><br />
退会のご理由アンケートにご協力ください。今後のサービス向上に活用させていただきます。※YESかNOを必須</p>
<dt>1)もう十分に儲かった為</dt>
<div id="formBg">
<div id="formIn">
<input name="q1" value="1" type="radio" />YES /
<input name="q1" value="2" type="radio" />NO
</div>
</div>
<dt>2)儲かる情報が多すぎて使いこなせない為</dt>
<div id="formBg">
<div id="formIn">
<input name="q2" value="1" type="radio" />YES /
<input name="q2" value="2" type="radio" />NO
</div>
</div>
<dt>3)メルマガの送信数が不足の為</dt>
<div id="formBg">
<div id="formIn">
<input name="q3" value="1" type="radio" />YES /
<input name="q3" value="2" type="radio" />NO
</div>
</div>
<dt>4)他の情報サイトで損失を出した為</dt>
<div id="formBg">
<div id="formIn">
<input name="q4" value="1" type="radio" />YES /
<input name="q4" value="2" type="radio" />NO
</div>
</div>
<dt>5)他の理由で退会</dt>
<div id="formBg">
<div id="formIn">
<input name="q5" value="1" type="radio" />YES /
<input name="q5" value="2" type="radio" />NO
</div>
</div>
<dt>6)1)で「もう十分に儲かった為」をYESと回答された場合</dt>
<div id="formBg">
<div id="formInLeft" class="current">
<div id="attention">※お幾らほどの利益でしょうか?</div>
<input name="q6" value="1" type="radio" />
〜1万円未満<br />
<input name="q6" value="2" type="radio" />
1万円以上〜10万円未満<br />
<input name="q6" value="3" type="radio" />
10万円以上〜100万円未満<br />
<input name="q6" value="4" type="radio" />
100万円以上〜1000万円未満<br />
<input name="q6" value="5" type="radio" />
1000万円以上〜<br />
</div>
</div>
<dt>7)2)で「儲かる情報が多すぎて使いこなせない為」をYESと回答された場合</dt>
<div id="formBg">
<div id="formInLeft">
<div id="attention">※幾つ情報を入手しましたか?</div>
<input name="q7" value="1" type="radio" />
〜10件未満<br />
<input name="q7" value="2" type="radio" />
10件以上〜20件未満<br />
<input name="q7" value="3" type="radio" />
20件以上〜50件未満<br />
<input name="q7" value="4" type="radio" />
50件以上〜100件未満<br />
<input name="q7" value="5" type="radio" />
100件以上〜
</div>
</div>
<dt>8)3)で「メルマガの送信数が不足の為」をYESと回答された場合</dt>
<div id="formBg">
<div id="formInLeft">
<div id="attention">※1日何通のメルマガを希望しますか?</div>
<input name="q8" value="1" type="radio" />
1通<br />
<input name="q8" value="2" type="radio" />
2通<br />
<input name="q8" value="3" type="radio" />
3通<br />
<input name="q8" value="4" type="radio" />
4通<br />
<input name="q8" value="5" type="radio" />
5通以上〜
</div>
</div>
<dt>9)4)で「他の情報サイトで損失を出した為」をYESと回答された場合</dt>
<div id="formBg">
<div id="formInLeft">
<input name="q9" value="1" type="radio" />
〜1万円未満<br />
<input name="q9" value="2" type="radio" />
1万円以上〜10万円未満<br />
<input name="q9" value="3" type="radio" />
10万円以上〜100万円未満<br />
<input name="q9" value="4" type="radio" />
100万円以上〜1000万円未満<br />
<input name="q9" value="5" type="radio" />
1000万円以上〜
</div>
</div>

<dt>10) 5)で「他の理由で退会」をYESと回答された場合<span id="attention">(必須)</span></dt>
<div id="formBg">
<div id="formIn">
<div id="attention">※理由を教えていただけますか?</div>
<textarea name="q10"  rows="5" cols="10" tabindex="9" id="areaCustomer"></textarea>
</div>
</div>
<br />
<p id="centerP">
<input name="regist3" type="image" tabindex="10" style="text-align:center;" onFocus="this.blur()" onMouseOver="this.src='./img/bt_taikai_on.png'" onMouseOut="this.src='./img/bt_taikai.png'" src="./img/bt_taikai.png" alt="退会手続きを進める" />
</p>
</dl>
</form>
<div id="centerP">
<form action="./?action_Home=1" method="post">
{$comFORMparam}
<input name="regist3" type="image" tabindex="11" style="text-align:center;" onFocus="this.blur()" onMouseOver="this.src='./img/bt_taikaistop_on.png'" onMouseOut="this.src='./img/bt_taikaistop.png'" src="./img/bt_taikaistop.png" alt="退会手続きを止める" />
</form>
</div>
</div>
</div>
{include file=$side}
</div>
{include file=$footer}
</div>
</body>
</html>