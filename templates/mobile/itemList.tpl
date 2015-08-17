{include file=$header}
</head>
<body {$bodyTag}>
<a name="top" id="top"></a>
<div style="font-size:x-small; text-align:left; {$limited_width}">
<img src="img/title.gif" alt="{$siteName}" width="100%" />
<div style="text-align:center;">
{if !$noItemList}
<div style="text-align:center;">
<img src="http://image.ko-haito.com/campaign/150630contents/itemList/pcHead.jpg" width="100%" alt="他キャンペーン部分もお手続きが可能です" /><br />
</div>
{/if}
</div>
<hr size="1" style="width:100%; color:#963;"/>

{if $errMsg}
<span style="color:#f00;">
    {foreach from=$errMsg item="val"}
        {$val|emoji}
    {/foreach}
</span>
<hr size="1" style="width:100%; color:#963;"/>
{/if}

{if !$itemExpList && !$itemList}
    {* データが全く無ければエラーメッセージ *}
    <span style="color:#f00;">{$noItemList}</span>
{else}
{* 説明文の配列を元にループ処理*}
    {foreach from=$itemDispPosition item="dispPosition" key="positionKey" name="position"}
        {* ライン *}
        {if ($itemExpList.$positionKey || $itemList.$positionKey) && !$smarty.foreach.position.first}
            {* <hr size="1" style="width:100%; color:#963;"/><br> *}
        {/if}
            {* 説明文出力 *}
            {foreach from=$itemExpList.$positionKey item="expData" name="exp"}
                {eval var=$expData.html_text_banner_mb|emoji}
            {/foreach}

            {* 商品リスト出力 *}
            {foreach from=$itemList.$positionKey item="itemData" name="item"}
                {eval var=$itemData.html_text_banner_mb|emoji}
                {if !$smarty.foreach.item.last}
                    {* <img src="img/line_b.gif" width="100%" /> *}
                {/if}
            {/foreach}
    {/foreach}
{/if}
<hr {$hr_1style} />
{include file=$pr}
{* {include file=$footer} *}

        <div class="wrap home">

        {include file=$status}
        {include file=$footerMenu}
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

</body>
</html>