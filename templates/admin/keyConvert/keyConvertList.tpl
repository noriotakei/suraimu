{include file=$admHeader}
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script language="JavaScript">
<!--

    $(function() {ldelim}

        if (!{$param.return_flag}) {ldelim}
            $("#add_form").hide();
        {rdelim}
        $('#add_button').live("click", function(){ldelim}
            $("#add_form").toggle("blind", null, "slow");
        {rdelim});

        {* テーブルマウスオーバーカラー *}
        $('#list_table').colorize({ldelim}
            altColor :'#CCCCCC',
            hiliteColor :'none'
        {rdelim});
    {rdelim});

// -->
</script>
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">システム変換表</h2>
{* 更新時エラーコメント *}
{if $execMsg|@count}
    <div class="warning ui-widget">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    <p>
    <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    { foreach from=$execMsg item="val" }
        {$val|@implode:"<br>"}
    {/foreach}
    </p>
    </div>
    </div>
    <br>
{/if}
<div class="SubMenu">
    <input type="button" id="add_button" value="追　加" />
</div>
<div id="add_form" style="display:none;">
<form action="./" method="POST">
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
        <tr>
            <th>変換キー</th>
            <th>タイプ</th>
            <th>カテゴリー</th>
            <th>備考</th>
            {if $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SYSTEM}<th>更新不可</th>{/if}
            <th></th>
        </tr>
        <tr>
            <td><input type="text" name="key_name" size="20" value="{$param.key_name|default:"-%-"}" style="ime-mode:disabled"></td>
            <td>{html_options name="type" options=$config.admin_config.convert_type_name selected=$param.type}</td>
            <td>{html_options name="key_convert_list_category_id" options=$categoryList selected=$param.key_convert_list_category_id}</td>
            <td><input type="text" name="description" size="20" value="{$param.description}"></td>
            {if $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SYSTEM}<td><input type="checkbox" name="not_update" value="1" {if $param.is_not_update}checked{/if}></td>{/if}
            <td style="text_align: center;"><input type="submit" name="action_keyConvert_KeyConvertExec" value="登　録" /></td>
        </tr>
    </table>
</form>
</div>
<br>
{if $keyConvertList}
    <form action="./" method="POST">
        <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">
            <tr>
                <th>ID</th>
                <th>変換キー</th>
                <th>変換内容</th>
                <th>タイプ</th>
                <th>カテゴリー</th>
                <th>備考</th>
                {if $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SYSTEM}<th>更新不可</th>{/if}
                <th>削除</th>
            </tr>
            {foreach from=$keyConvertList item="val"}
                <tr>
                        <td>
                        {if $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SYSTEM
                             OR ($loginAdminData.authority_type != $config.define.AUTHORITY_TYPE_SYSTEM AND !$val.is_not_update)}
                        <a href="{make_link action="action_keyConvert_KeyConvertData" getTags="key_convert_list_id="|cat:$val.id}">{$val.id}</a>
                        {else}
                        {$val.id}
                        {/if}
                        </td>
                        <td><input type="hidden" name="convert_list_id[]" value="{$val.id}">{$val.key_name}</td>
                        <td>{$val.contents.contents}</td>
                        <td>{$config.admin_config.convert_type_name[$val.type]}</td>
                        <td>{$categoryList[$val.key_convert_list_category_id]}</td>
                        <td>{$val.description}</td>
                        {if $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SYSTEM}<td><input type="checkbox" name="not_update[{$val.id}]" value="1" {if $val.is_not_update}checked{/if}></td>{/if}
                        {if $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SYSTEM
                             OR ($loginAdminData.authority_type != $config.define.AUTHORITY_TYPE_SYSTEM AND !$val.is_not_update)}
                        <td><input type="checkbox" name="disable[{$val.id}]" value="1"></td>
                        {/if}
                </tr>
            {/foreach}
        </table>
        <div class="SubMenu">
        <input type="submit" name="action_keyConvert_KeyConvertExec" value="更　新" onClick="return confirm('更新しますか？')" />
        </div>
    </form>
{/if}
{include file=$admFooter}
</div>
</body>
</html>