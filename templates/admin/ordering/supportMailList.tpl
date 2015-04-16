{include file=$admHeader}
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">サポートメール一覧</h2>
{* 更新時コメント *}
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
<form action="./" method="post">
    <input type="submit" name="action_ordering_SupportMailData" value="追 加" style="width:8em;"/>
</form>
<br>
{if $supportMailList}
    <table>
        <tr>
            {foreach name="dataLoop" from=$supportMailList item="val" key="key"}
                <td style="padding:5px">
                    <form action="./" method="POST">
                        <input type="submit" name="action_ordering_SupportMailData" value="{$val.name}" style="width:15em;">
                        <input type="hidden" name="support_mail_id" value="{$val.id}">
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