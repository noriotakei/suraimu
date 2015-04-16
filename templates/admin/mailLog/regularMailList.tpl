{include file=$admHeader}
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<link type="text/css" href="./css/pager.css" rel="stylesheet" />
<script type="text/javascript">
<!--


    $(function() {ldelim}
        // テーブルマウスオーバーカラー
        $('#list_table').colorize({ldelim}
            altColor :'#CCCCCC',
            hiliteColor :'none'
        {rdelim});

    {rdelim});


//-->
</script>
</head>
<body>

<div id="ContentsCol">

<h2 class="ContentTitle">定期配信一覧</h2>

<form action="./" method="POST">
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" id="src_table">
        <tr>
            <th colspan="2" style="text-align: center; font-weight: bold;">検索条件</th>
        </tr>
        <tr>
            <th>送信条件</th>
            <td>
            {html_checkboxes name="send_condition_type" options=$sendConditionType selected=$param.send_condition_type separator="&nbsp;"}
            </td>
        </tr>
        <tr>
            <th>稼働状況</th>
            <td>
            {html_radios name="is_stop" options=$stopFlag selected=$param.is_stop separator="&nbsp;"}
            </td>
        </tr>
        <tr>
            <th>定期メルマガID<br>(カンマ指定で複数可)</th>
            <td>
                <input type="text" name="id" value="{$param.id}" size="50" style="ime-mode: disabled;">
            </td>
        </tr>

        <tr>
            <th>メルマガ件名検索</th>
            <td>
                <input type="text" name="mailmagazine_subject" value="{$param.mailmagazine_subject}" size="50">
            </td>
        </tr>

        <tr>
            <th>メルマガ本文検索</th>
            <td>
                <input type="text" name="mailmagazine_body" value="{$param.mailmagazine_body}" size="50">
            </td>
        </tr>
        <tr>
            <td style="text-align:center;" colspan="2">
                <input type="submit" name="action_mailLog_regularMailList" value="検 索" style="width:8em;"/>
            </td>
        </tr>
    </table>
</form>
<hr>

{* コメント *}
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
    <br>
{/if}

{if $dataList}
    <div style="padding-bottom: 10px;">
    {$totalCount}件中<br />
    {$dispFirst}～{$dispLast}件表示しています
    {if $pager}
    <ul class="pager">
        <li>{$pager.previous}</li>
        <li>{$pager.pages|@implode:"</li><li>"}</li>
        <li>{$pager.next}</li>
    </ul>
    {/if}
    </div>

    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet02">

    <tr>
    <th>ID</th>
    <th>タイトル</th>
    <th>送信条件</th>
    <th>稼働状況</th>
    <th>PC件名</th>
    <th>MB件名</th>
    <th>強行メール</th>
    <th>作成日時</th>
    <th>削除</th>
    </tr>
    {foreach from=$dataList item="val"}
        <tr>
        <td><a href="{make_link action="action_mailLog_RegularMailData" getTags="mail_maga_regular_id="|cat:$val.id}" target="_blank">{$val.id}</a></td>
        <td>{$val.title}</td>
        <td>{$val.send_condition}</td>
        <td>{$stopFlag[$val.is_stop]}中</td>
        <td>{$val.pc_subject|emoji}</td>
        <td>{$val.mb_subject|emoji}</td>
        <td>{if $val.reverse_mail_status}強行メール{/if}</td>
        <td>{$val.update_datetime}</td>
        <td>
            <form action="./" method="post" style="margin:2px 0px;">
                {$POSTParam}
                <input type="hidden" name="mail_maga_regular_id" value="{$val.id}">
                <input type="submit" name="action_mailLog_RegularMailDelExec" value="削除" onClick="return confirm('削除しますか?')">
            </form>
        </td>
        </tr>
    {/foreach}
    </table>
    <br />
    <div style="padding-bottom: 10px;">
    {$totalCount}件中<br />
    {$dispFirst}～{$dispLast}件表示しています
    {if $pager}
    <ul class="pager">
        <li>{$pager.previous}</li>
        <li>{$pager.pages|@implode:"</li><li>"}</li>
        <li>{$pager.next}</li>
    </ul>
    {/if}
    </div>
{else}
    <div class="warning ui-widget">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    <p>
    <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    該当ログはありません
    </p>
    </div>
    </div>
{/if}
{include file=$admFooter}
</div>
</body>
</html>