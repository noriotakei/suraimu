{include file=$header}
</head>
<body>
<a name="top" id="top"></a>
{include file=$status}
<div id="wrap">
<div id="imageArea">{include file=$headCampaign}</div>
{include file=$headerMenu}
<div id="contents">
<div id="main">
<div class="mainBox">
{include file=$order}
<br>
{include file=$cart}
<br>
{foreach from=$dispInformationList item="infoList"}
    {eval var=$infoList.html_text_banner_pc|emoji}
{/foreach}

<!-- ********************** 関連リンク ********************** -->
<div style="background-color: #850;font-size:small;">関連リンク</div>
<img src="http://image.ko-haito.com/campaign/common/spacer.gif" height="2px">
<div id="linkmenu" class="pGreenContent">
<ul class="clearfix">
<li><a target="_blank" href="http://www.jra.go.jp/"><img src="./img/btnLinkmenu01.gif" alt="JRA" class="responsive"></a></li>
<li><a target="_blank" href="https://www.direct.jra.go.jp/"><img src="./img/btnLinkmenu02.gif" alt="JRAダイレクト" class="responsive"></a></li>
<li><a target="_blank" href="https://www.a-pat.jra.go.jp/"><img src="./img/btnLinkmenu03.gif" alt="nankankeiba" class="responsive"></a></li>
<li><a target="_blank" href="http://www.rakuten-bank.co.jp/"><img src="./img/btnLinkmenu04.gif" alt="楽天銀行" class="responsive"></a></li>
</ul>
<ul class="clearfix">
<li><a target="_blank" href="http://www.japannetbank.co.jp/"><img src="./img/btnLinkmenu05.gif" alt="ジャパンネット銀行" class="responsive"></a></li>
<li><a target="_blank" href="http://www.smbc.co.jp/kojin/direct/"><img src="./img/btnLinkmenu06.gif" alt="三井住友銀行" class="responsive"></a></li>
<li><a target="_blank" href="http://direct.bk.mufg.jp/"><img src="./img/btnLinkmenu07.gif" alt="三菱東京UFJ銀行" class="responsive"></a></li>
<li><a target="_blank" href="http://www.jp-bank.japanpost.jp/"><img src="./img/btnLinkmenu08.gif" alt="ゆうty銀行" class="responsive"></a></li>
</ul>
</div><!-- /.linkmenu -->

</div>
</div>
{include file=$side}
</div>
{include file=$footer}
</div>
</body>
</html>