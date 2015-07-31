<?php
header("Content-Type: text/html; charset=UTF-8");
?>
{include file=$hedinfo_login_sp}

<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="http://image.ko-haito.com/contents/loginSp/login.css">

</head>


<body>

<div class="wrap home">
<a id="top"></a>

<!-- ********************** ヘッダー ********************** -->
<div class="header">
	<p class="block10 mBtm10"><img src="http://image.ko-haito.com/contents/loginSp/txtBookmark.png" class="responsive" alt="このページをブックマーク登録しておくと便利です"></p>
	<h1 class="block15 mBtm10"><img src="http://image.ko-haito.com/contents/loginSp/ttlSitelogo.png" class="responsive" alt="<?php echo $title ?>"></h1>
	<div class="block15"><img src="http://image.ko-haito.com/contents/loginSp/txtNavidial.png" class="responsive" alt="ナビダイヤル"></div>
</div><!-- /.header -->

<!-- ********************** ヘッダーナビボタン ********************** -->

{include file=$contentsMenu}

<!-- ********************** プロフィール ********************** -->

{include file=$status}

<!-- ********************** 予約中のプラン ここから ********************** -->
<div id="cartBlock" class="block pGreenContent">
<p class="ttl">予約中のプラン</p>
<div class="whContent">

<!-- {$ticket}不足時表示ソース -->
<!--
<div class="error mBtm10" style="background:#fff !important">
{$ticket}不足のため情報を閲覧できません。
ご覧になる為に{$ticket}追加をお願い致します！<br>
</div>
-->
<!-- {$ticket}不足時表示ソース -->
{include file=$order}

</div><!-- /.whContent -->
</div><!-- /#cartBlock -->
<!-- ********************** 予約中のプラン ここまで ********************** -->

<!-- ********************** 購入キャンペーン公開中 ここから ********************** -->
{if $dispInformationListMiddle}
<div class="openCampaign campaignSec block dGreenContent">
<p class="ttl">購入キャンペーンの情報公開中</p>


    {foreach from=$dispInformationListMiddle item="val"}
        {eval var=$val.html_text_banner_mb|emoji}
    {/foreach}


</div><!-- /.openCampaign -->
{/if}
<!-- ********************** 購入キャンペーン公開中 ここまで ********************** -->


<!-- ********************** 今週の注目レース ********************** -->
{if $dispInformationListQuitWeeklyRace}
<div class="pickupRace block pGreenContent">
<p class="ttl">今週の注目レース</p>
<div class="whContent">

{if $dispInformationListQuitWeeklyRace}
    {foreach from=$dispInformationListQuitWeeklyRace item="val"}
        {eval var=$val.html_text_banner_mb|emoji}
    {/foreach}
{/if}


</div><!-- /.whContent -->
</div><!-- /.pickupRace -->
{/if}

<!-- ********************** 今週の注目レース ここまで ********************** -->

<!-- ********************** 情報メニュー ここから ********************** -->
{if $dispInformationList}
<div class="informationSec campaignSec block dGreenContent">
<p class="ttl">情報メニュー</p>


    {foreach from=$dispInformationList item="val"}
        {eval var=$val.html_text_banner_mb|emoji}
    {/foreach}


</div><!-- /.informationSec -->
{/if}
<!-- ********************** 情報メニュー ここまで ********************** -->


<!-- ********************** チケット情報 ここから ********************** -->
{if $dispInformationListHomeInformationOpen}
<div class="tkCampaign campaignSec block dGreenContent">
<p class="ttl"><?php echo $point; ?>情報 公開中</p>

    {foreach from=$dispInformationListHomeInformationOpen item="val"}
        {eval var=$val.html_text_banner_mb|emoji}
    {/foreach}

</div><!-- /.tkCampaign -->
{/if}
<!-- ********************** チケット情報 ここまで ********************** -->

<!-- ********************** サイトメニュー ここから ********************** -->

{include file=$part_menu_login_sp}

<!-- ********************** サイトメニュー ここまで ********************** -->


<!-- ********************** 関連リンク ********************** -->
<div id="linkmenu" class="block pGreenContent">
<p class="ttl">関連リンク</p>
<ul class="clearfix">
<li><a target="_blank" href="http://www.jra.go.jp/"><img src="http://image.ko-haito.com/contents/loginSp/btnLinkmenu01.png" alt="JRA" class="responsive"></a></li>
<li><a target="_blank" href="https://www.direct.jra.go.jp/"><img src="http://image.ko-haito.com/contents/loginSp/btnLinkmenu02.png" alt="JRAダイレクト" class="responsive"></a></li>
<li><a target="_blank" href="http://www.nankankeiba.com/"><img src="http://image.ko-haito.com/contents/loginSp/btnLinkmenu03.png" alt="nankankeiba" class="responsive"></a></li>
<li><a target="_blank" href="http://www.rakuten-bank.co.jp/"><img src="http://image.ko-haito.com/contents/loginSp/btnLinkmenu04.png" alt="楽天銀行" class="responsive"></a></li>
</ul>
<ul class="clearfix">
<li><a target="_blank" href="http://www.japannetbank.co.jp/"><img src="http://image.ko-haito.com/contents/loginSp/btnLinkmenu05.png" alt="ジャパンネット銀行" class="responsive"></a></li>
<li><a target="_blank" href="http://www.smbc.co.jp/kojin/direct/"><img src="http://image.ko-haito.com/contents/loginSp/btnLinkmenu06.png" alt="三井住友銀行" class="responsive"></a></li>
<li><a target="_blank" href="http://direct.bk.mufg.jp/"><img src="http://image.ko-haito.com/contents/loginSp/btnLinkmenu07.png" alt="三菱東京UFJ銀行" class="responsive"></a></li>
<li><a target="_blank" href="http://www.netbk.co.jp/"><img src="http://image.ko-haito.com/contents/loginSp/btnLinkmenu08.png" alt="住信SBIネット銀行" class="responsive"></a></li>
</ul>
</div><!-- /.linkmenu -->

<!-- ********************** フッターリンク ********************** -->
<div class="menu">
<ul class="clearfix">
<li><a href="./?action_Rule=1">利用規約</a></li>
<li><a href="./?action_Company=1">会社概要</a></li>
<li><a href="./?action_Privacy=1">プライバシーポリシー</a></li>
<li><a href="./?action_Outline=1">特定商取引法に基づく表記</a></li>
<li><a href="./?action_OutlineKeiba=1">競馬法に基づく表記</a></li>
</ul>
</div>

<div class="pageTop block15">
	<a href="#top"><i class="fa fa-arrow-up"></i> ページ上部へ</a>
</div>

<div class="footer">
	&copy; 高配当.com<br>All Rights Reserved.
</div>

</div><!--End wrap-->

{$comImgTag}

</body>
</html>
