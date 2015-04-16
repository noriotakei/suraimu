{include file=$admHeader}
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
<script type="text/javascript" src="./js/jquery.timepickr.min.js"></script>
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<link type="text/css" href="./css/pager.css" rel="stylesheet" />
<script type="text/javascript">
<!--

    $(function() {ldelim}

        {* テーブルマウスオーバーカラー *}
        $('#list_table').colorize({ldelim}
            altColor :'#CCCCCC',
            hiliteColor :'none'
        {rdelim});

        {* テーブルストライプ *}
        $("#src_table tr:even").addClass("BgColor02");

    {rdelim});

//-->
</script>
</head>
<body>

<div id="ContentsCol">

<h2 class="ContentTitle">情報定型文一覧</h2>
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
<br>
<form action="./" method="post">
    <input type="submit" name="action_informationTemplate_InformationTemplateCreate" value="追 加" style="width:8em;"/>
</form>
<br>

{if $infoTemplateList}
    <div style="padding-bottom: 10px;">
    登録済み：{$totalCount}件<br />
    {$dispFirst}～{$dispLast}件表示しています
    </div>
    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">
        <tr bgcolor="#FF9933">
            <th>ID</th>
            <th>管理用定型文名</th>
            <th width="80">表示優先度</th>
            <th width="140">PC情報バナープレビュー</th>
            <th width="140">PC情報詳細プレビュー</th>
            <th width="140">MB情報バナープレビュー</th>
            <th width="140">MB情報詳細プレビュー</th>
            <th>削除</th>
        </tr>
        {foreach from=$infoTemplateList item="val"}
        <tr>
            <td align="center"><a href="{make_link action="action_informationTemplate_InformationTemplateData" getTags="itid="|cat:$val.id}">{$val.id}</a></td>
            <td align="left">{$val.name}</td>
            <td align="center">{$val.sort_seq}</td>
            <td align="center">
            {if $val.html_text_banner_pc}
            <a href="{$config.define.SITE_URL}?action_informationPreview=1&banner_pc=1&itid={$val.id}" target="_blank">プレビュー</a>
            {else}
            設定なし
            {/if}
            </td>
            <td>
            {if $val.html_text_pc}
            <a href="{$config.define.SITE_URL}?action_informationPreview=1&text_pc=1&itid={$val.id}" target="_blank">プレビュー</a>
            {else}
            設定なし
            {/if}
            </td>
            <td align="center">
            {if $val.html_text_banner_mb}
            <a href="{$config.define.SITE_URL_MOBILE}?action_informationPreview=1&banner_mb=1&itid={$val.id}" target="_blank">プレビュー</a>
            {else}
            設定なし
            {/if}
            </td>
            <td align="center">
            {if $val.html_text_mb}
            <a href="{$config.define.SITE_URL_MOBILE}?action_informationPreview=1&text_mb=1&itid={$val.id}" target="_blank">プレビュー</a>
            {else}
            設定なし
            {/if}
            </td>
            <td>
                <form action="./" method="post" style="margin:2px 0px;">
                    <input type="hidden" name="itid" value="{$val.id}">
                    <input type="hidden" name="disable" value="1">
                    <input type="submit" name="action_informationTemplate_InformationTemplateExec" value="削除" onClick="return confirm('削除しますか?')">
                </form>
            </td>
        </tr>
        {/foreach}
    </table>
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