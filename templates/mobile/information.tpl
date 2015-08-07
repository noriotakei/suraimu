{if $infoStatusData.is_smart_phone}

    {if $infoStatusData.is_all_display}

        {include file=$hedinfo_login_sp}
         <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
         <link rel="stylesheet" type="text/css" href="http://image.ko-haito.com/contents/loginSp/login.css">

        </head>
        <div class="wrap home">
        {eval var=$infoStatusData.html_text_mb|emoji}
        <hr {$hr_1style} />
        {* {include file=$footer} *}
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
        </div>

        {* アフィリエイトタグ *}
        {$comImgTag}

    {else}
         {include file=$hedinfo_login_sp}
         <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
         <link rel="stylesheet" type="text/css" href="http://image.ko-haito.com/contents/loginSp/login.css">

        </head>

        {eval var=$infoStatusData.html_text_mb|emoji}
        {* {include file=$status} *}
        <div class="wrap home">
        {include file=$footerMenu}

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
        </div>

        {* アフィリエイトタグ *}
        {$comImgTag}
    {/if}

{else}

    {if $infoStatusData.is_all_display}
        {include file=$header}
        <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="http://image.ko-haito.com/contents/loginSp/login.css">
        </head>
         <div class="wrap home">
        {eval var=$infoStatusData.html_text_mb|emoji}
        <hr {$hr_1style} />
       {* {include file=$footer} *}
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
        </div>

        {* アフィリエイトタグ *}
        {$comImgTag}

    {else}
        {include file=$header}
        <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="http://image.ko-haito.com/contents/loginSp/login.css">
        </head>
        {eval var=$infoStatusData.html_text_mb|emoji}
        {*  {include file=$contentsMenu} *}
        <div class="wrap home">
        {include file=$status}
        {include file=$footerMenu}
        {* {include file=$footer} *}

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
        </div>
        {* アフィリエイトタグ *}
        {$comImgTag}

    {/if}
{/if}
</body>
</html>