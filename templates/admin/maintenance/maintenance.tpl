{include file=$admHeader}
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">メンテナンス画面切り替え</h2>
    <center>
    {if $currentMaintenance}
        現在、メンテナンス画面表示中です。
    {else}
        現在、通常表示中です。
    {/if}
    </center>
    <br><br>
    <table border="0" align="center">
        <tr>
            <td style="padding-right: 20px;">
                <form action="./" method="POST">
                <input type="hidden" name="is_maintenance" value="1">
                <input type="submit" value="メンテナンス画面に切り替え" name="action_maintenance_MaintenanceExec" onclick="return confirm('本当に止めますか？');">
                </form>
            </td>
            <td>
                <form action="./" method="POST">
                <input type="hidden" name="is_maintenance" value="0">
                <input type="submit" value="通常画面に切り替え" name="action_maintenance_MaintenanceExec" onclick="return confirm('本当に動かしますか？');">
                </form>
            </td>
        </tr>
    </table>
{include file=$admFooter}
</div>
</body>
</html>