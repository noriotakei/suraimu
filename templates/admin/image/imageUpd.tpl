{include file=$admHeader}
</head>
<body>
<div id="ContentsCol">
    <h2 class="ContentTitle">画像データ更新画面</h2>
    {* 更新時エラーコメント *}
    {if $msg|@count}
        <div class="warning ui-widget">
        <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
        <p>
        <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
        { foreach from=$msg item="val" }
            {$val|@implode:"<br>"}
        {/foreach}
        </p>
        </div>
        </div>
    {/if}
    <form action="./" method="post">
        <div class="SubMenu">
            <input type="submit" name="action_image_List" value="一覧に戻る" />
        </div>
    </form>
    {if $param}
        <form action="./" method="post" enctype="multipart/form-data">
            {$POSTparam}
            <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
                <tr>
                <th>画像ID</th>
                <td style="text-align: left;font-size:large;">
                    <b>{$param.id}</b>
                </td>
                </tr>
                <tr>
                <th>画像</th>
                <td style="text-align: left;">
                {if $param.extension_type == IMAGETYPE_SWF || $param.extension_type == IMAGETYPE_SWC}
                    {html_image file="./img/thumbnails/swf.jpg" width="150" height="94" alt=$param.name}
                {else}
                    <img src="./{$imagePath}{$param.file_name}.{$extensionTypeArray[$param.extension_type]}?{$smarty.now}" alt ="画像">
                {/if}
                </td>
                </tr>
                <tr>
                    <th>カテゴリー</th>
                    <td style="text-align: left;">{html_options name="image_category_id" options=$categoryList selected=$param.image_category_id}</td>
                </tr>
                <tr>
                <th>名前</th>
                <td style="text-align: left;">
                    <input type="text" name="name" value="{$param.name}" size="20">
                </td>
                </tr>
                <tr>
                <th>コメント</th>
                <td style="text-align: left;">
                    <input type="text" name="comment" value="{$param.comment}" size="20">
                </td>
                </tr>

                <tr>
                <th>FILE</th>
                <td style="text-align: left;">
                <input type="file" name="design_file">
                </td>
                </tr>
            </table>
            <div class="SubMenu">
                <input type="submit" name="action_image_ImageAddExec" value="更 新" OnClick="return confirm('更新しますか？')" />
            </div>
        </form>
    {else}
        <div class="warning ui-widget">
        <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
        <p>
        <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
        該当データはありません
        </p>
        </div>
    {/if}
{include file=$admFooter}
</div>
</body>
</html>
