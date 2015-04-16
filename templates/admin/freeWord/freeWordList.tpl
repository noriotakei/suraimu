{include file=$admHeader}

</head>
<body>
<div class="BlockCol">
    <h2 class="ContentTitle">フリーワード設定一覧</h2>
    <br>
    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet01">
        <tr>
            {section name=cnt start=1  loop=11}
                {if $smarty.section.cnt.index == "6"}
        </tr>
        <tr>
                {/if}
                <td><a href="./?action_freeWord_FreeWordData=1&fwc={$smarty.section.cnt.index}">ﾌﾘﾜｰﾄﾞ設定{$smarty.section.cnt.index}(-%free～{$smarty.section.cnt.index}-)</a></td>
            {/section}
        </tr>
    </table>
{include file=$admFooter}
</div>
</body>
</html>
