{include file=$admHeader}
</head>
<body>
<div class="BlockCol">
    <h2 class="ContentTitle">ユーザー情報</h2>
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
    {/if}
{include file=$admFooter}
</div>
</body>
</html>
