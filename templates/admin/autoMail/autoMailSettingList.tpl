{include file=$admHeader}
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">リメール設定一覧</h2>
{if $dataList}
    <table>
        <tr>
            {foreach name="dataLoop" from=$dataList item="val" key="key"}
                <td style="padding:5px">
                    <form action="./" method="POST">
                        <input type="submit" name="action_autoMail_AutoMailSettingData" value="【{$isUse[$val.is_use]}】 {$val.name}" style="{if !$val.is_use}background-color:red;{/if}">
                        <input type="hidden" name="auto_mail_contents_id" value="{$val.id}">
                    </form>
                </td>
                {if $smarty.foreach.dataLoop.iteration % 5 == 0}
                    </tr><tr>
                {/if}
            {/foreach}
        </tr>
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