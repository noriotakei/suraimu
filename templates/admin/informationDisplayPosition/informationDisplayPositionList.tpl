{include file=$admHeader}
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script type="text/javascript">
<!--
    $(function() {ldelim}
        {* テーブルマウスオーバーカラー *}
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

<h2 class="ContentTitle">情報表示場所一覧</h2>
<table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">
    <tr bgcolor="#FF9933">
        <th>情報表示場所</th>
    </tr>
    {foreach from=$displayPositionList key="key" item="val"}
        <tr>
            <td align="center"><a href="{make_link action="action_informationDisplayPosition_InformationDisplayPositionData" getTags="position_id="|cat:$key}">{$val}</a></td>
        </tr>
    {/foreach}
</table>
{include file=$admFooter}
</div>
</body>
</html>