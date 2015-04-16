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
<div id="titleItemlist">情報購入　ポイント追加</div>
{include file=$order}
<br>
{include file=$cart}
<br>
{* エラー表示 *}
{if $errMsg}
<p class="err">
    {foreach from=$errMsg item="val"}
        {$val|emoji}
    {/foreach}
</p>
{/if}
{* ここから商品表示 *}
{if !$itemExpList && !$itemList}
    {* データが全く無ければエラーメッセージ *}
    <span style="color:#f00;">{$noItemList}</span>
{else}
{* 説明文の配列を元にループ処理*}
    {foreach from=$itemDispPosition item="dispPosition" key="positionKey" name="position"}
        {* 説明文出力 *}
        {foreach from=$itemExpList.$positionKey item="expData" name="exp"}
            {eval var=$expData.html_text_banner_pc|emoji}
        {/foreach}

        {* 商品リスト出力 *}
        {foreach from=$itemList.$positionKey item="itemData" name="item"}
            {eval var=$itemData.html_text_banner_pc|emoji}
        {/foreach}
    {/foreach}
{/if}

</div><!--#mainBox End-->
</div><!--#main End-->
{include file=$side}
</div>
{include file=$footer}
</div>
</body>
</html>