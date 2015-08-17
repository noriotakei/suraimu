{include file=$hedinfo_login_sp}

</head>

<body>

<div class="wrap home">
<a id="top"></a>

<div style="background-color:#000;">
<body link="#ffcc99" vlink="#cc9966" alink="#ff3399" text="#ffffff" style="color:#ffffff; background:#000000; " bgcolor="#000000">
<a name="top" id="top"></a>
<div style="text-align:left; width:100%;">
<img src="img/title.gif" alt="高配当.com" width="100%" />

<div style="text-align:center;">

<img src="http://image.ko-haito.com/campaign/150630contents/info/pcHead.jpg" width="100%" alt="会員情報の変更" />

</div>
<hr size="1" style="width:100%; color:#963;" />

{if $errMsg}<span style="color:#f00;font-size:small;">{$errMsg}</span><br /><hr {$hr_2style} />{/if}

<form action="./?action_UpdateChkPc=1{if $comURLparam}&{$comURLparam}{/if}" method="post">
<span><img src="http://image.ko-haito.com/campaign/150630contents/info/pcCont01.jpg" width="100%" alt="PCメールアドレスの登録と変更"/></span><br />
<div style="text-align:center;">
{if !$comUserData.pc_address}
<span style="color:#f00;"><blink>PCｱﾄﾞﾚｽ登録で20ptGET!</blink></span><br />
{/if}
<input name="pc_mail_address" size="20" type="text" value="{$comUserData.pc_address}"/><br /><br />
<input name="submit" type="image" alt="登録・変更する" src="http://image.ko-haito.com/campaign/150630contents/info/pcBtn1_01.jpg" width="80%"/><br /><br />
</div>
</form>

<hr size="1" style="width:100%; color:#963;" />


<form action="./?action_UpdateExec=1{if $comURLparam}&{$comURLparam}{/if}" method="post">

<span><img src="http://image.ko-haito.com/campaign/150630contents/info/pcCont02.jpg" width="100%" alt="携帯メールアドレス"/></span><br />
<div style="text-align:center;">{$comUserData.mb_address|default:"未登録"}<br /><br /></div>

<div style="text-align:center;"><a href="mailto:{$mailto}"><img src="http://image.ko-haito.com/campaign/150630contents/info/pcBtn2_01.jpg" width="80%" /></a><br /><br /></div>

<hr size="1" style="width:100%; color:#963;" />

{if $comUserData.mb_address}
<span><img src="http://image.ko-haito.com/campaign/150630contents/info/pcCont03.jpg" width="100%" alt="携帯メールの配信の変更"/></span><br />
<div style="text-align:center;color:#000;">
{html_options name="mb_is_mailmagazine" options=$config.web_config.address_send_status selected=$comUserData.mb_is_mailmagazine  style="color:#000;"}
<br /><br /></div>
{/if}

{if $comUserData.pc_address}
<span><img src="http://image.ko-haito.com/campaign/150630contents/info/pcCont04_2.jpg" width="100%" alt="PCメール配信の変更"/></span><br />
<div style="text-align:center;color:#000;">
{html_options name="pc_is_mailmagazine" options=$config.web_config.address_send_status selected=$comUserData.pc_is_mailmagazine  style="color:#000;"}
<br /><br /></div>
{/if}
<div style="text-align:center;color:#000;"><input name="submit" type="image" alt="変更内容の確認" src="http://image.ko-haito.com/campaign/150630contents/info/pcBtn1_02.jpg" width="80%" /></div>
</form>

<hr size="1" style="width:100%; color:#963;" />

<span><img src="http://image.ko-haito.com/campaign/150630contents/info/pcCont04.jpg" width="100%" alt="所有ポイント数"/></span><br />

<div style="text-align:center;">{$comUserData.point}  PT<br /><br /></div>

<span><img src="http://image.ko-haito.com/campaign/150630contents/info/pcCont05.jpg" width="100%" alt="会員ID"/></span><br />

<div style="text-align:center;">{$comUserData.login_id}<br /><br /></div>
<span><img src="http://image.ko-haito.com/campaign/150630contents/info/pcCont06.jpg" width="100%" alt="パスワード変更"/></span><br />

<div style="text-align:center;"><a href="./?action_Passchange=1{if $comURLparam}&{$comURLparam}{/if}"><img src="http://image.ko-haito.com/campaign/150630contents/info/pcBtn2_02.jpg" width="80%" alt="パスワード変更はこちら！" /></a><br /><br /></div>

<br />

<hr size="1" style="width:100%; color:#963;" />

<span><img src="http://image.ko-haito.com/campaign/150630contents/info/pcCont07.jpg" width="100%" alt="※注意事項・携帯メールアドレスの変更は空メール送信のみで完了いたします。変更するメールアドレスとログインIdが同じなら、ログインidも変更されます。配信の変更をされると「お得なキャンペーン情報」をお届けできなくなります。" /></span><br />

</div></div>


<!-- ********************** ユーザーステータス ここから ********************** -->
{include file=$status}
<!-- ********************** ユーザーステータス ここまで ********************** -->

<!-- ********************** サイトメニュー ここから ********************** -->

{include file=$part_menu_login_sp}

<!-- ********************** サイトメニュー ここまで ********************** -->


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
        <ul class="footNavi clearfix">
            <li class="back">
                <a href="./?action_Home=1"><img src="http://image.ko-haito.com/contents/settle/btnBackTop.png" alt="ログインTOPへ" class="responsive"></a>
            </li>
            <li class="topPage">
                <a href="#top"><img src="http://image.ko-haito.com/contents/settle/btnPageTop.png" alt="ページ上部へ" class="responsive"></a>
            </li>
        </ul>

        <div class="footer">
            &copy; オフィシャル競馬情報サイト-高配当.com-<br>All Rights Reserved.
        </div>

</div><!--End wrap-->

        {* アフィリエイトタグ *}
        {$comImgTag}
</body>
</html>