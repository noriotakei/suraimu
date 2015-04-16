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

<h2 class="ContentTitle">フラグコードの名前を編集</h2>
{* 更新時エラーコメント *}
    {if $errMsg|@count}
        <div class="warning ui-widget">
        <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
        <p>
        <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
        { foreach from=$errMsg item="val" }
            {$val|@implode:"<br>"}
        {/foreach}
        </p>
        </div>
        </div>
        <br>
{/if}

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

<div>
    <form action="./" method="post">
        {$POSTparam}
            <table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet04">
                <tr><th colspan="2" style="text-align:center;">フラグコードの名前を編集</th></tr>
                <tr>
                    <th>コード</th>
                    <td><input name="user_profile_flag_code" size="20"/></td>
                </tr>
                <tr>
                    <th>コード名</th>
                    <td><input name="user_profile_flag_name" size="20"/></td>
                </tr>
                <tr>
                    <th>ｱｸｾｽ後の移動先</th>
                    <td>
                       {html_options name="user_profile_flag_convert_code" options=$user_profile_flag_convert_code selected=$val.convert_code}
                    </td>
                </tr>
                <tr>
                    <td  style="text-align: center;" colspan="3">
                        <input type="submit" id="submit" name="action_user_CreateUserProfileFlagExec" value="登　録" />
                    </td>
                </tr>
           </table>
    </form>
</div>
<br>

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

    <div style="padding-bottom: 10px;">
        <font color="red">通常登録時はフラクＯＦＦとなります</font><br>
        <font color="red">コード1は編集出来ません</font>
    </div>

    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet02">
    <tr>
    <th>コード</th>
    <th>コード名</th>
    <th>ｱｸｾｽ後の移動先</th>
    </tr>
    {foreach from=$dataList item="val"}
        <tr>
        {if $val.code == 1}
            <td>{$val.code}</td>
        {else}
            <td><a href="{make_link action="action_user_UserProfileFlagData" getTags="user_profile_flag_code="|cat:$val.code}" target="_blank">{$val.code}</a></td>
        {/if}
        <td>{$val.name}</td>
        <td>{$user_profile_flag_convert_code[$val.convert_code]}</td>
        </tr>
    {/foreach}
    </table>
    <br>
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