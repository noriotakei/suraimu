{include file=$admHeader}
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script language="JavaScript">
<!--

    $(function() {ldelim}
        $('.selectText').click(function(){ldelim}
            $(this).select();
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
<form action="./" method="POST">
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" id="src_table">
        <tr>
            <th colspan="2" style="text-align: center; font-weight: bold;">検索条件</th>
        </tr>
        <tr>
            <td>カテゴリー</td>
            <td>{html_options name="key_convert_list_category_id" options=$categoryList selected=$param.key_convert_list_category_id}</td>
        </tr>
        <tr>
            <td style="text-align:center;" colspan="2">
                <input type="submit" name="action_keyConvert_DispKeyConvertList" value="検 索" style="width:8em;"/>
            </td>
        </tr>
    </table>
</form>
<hr>
<br>
{if $keyConvertList}
    <form action="./" method="POST">
        <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">
            <tr>
                <th>変換キー</th>
                <th>変換内容</th>
                <th>タイプ</th>
                <th>カテゴリー</th>
                <th>備考</th>
            </tr>
            {foreach from=$keyConvertList item="val"}
                <tr>
                    <td><input type="text" class="selectText" name="key_name[{$val.id}]" size="20" value="{$val.key_name}" readonly></td>
                    <td>{$val.contents.contents}</td>
                    <td>{$config.admin_config.convert_type_name[$val.type]}</td>
                    <td>{$categoryList[$val.key_convert_list_category_id]}</td>
                    <td>{$val.description}</td>
                </tr>
            {/foreach}
        </table>
    </form>
{/if}
{include file=$admFooter}
</div>
</body>
</html>