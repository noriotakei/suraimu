{include file=$admHeader}
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">商品注文画面</h2>
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
<div>
    <a href="{make_link action="action_itemManagement_ItemList" getTags=$getTag}" target="_blank">商品一覧</a>
</div>
<br>
<form action="./" method="POST">
    {$POSTparam}
    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">
        <tr>
            <th>商品ID<br>(カンマ区切りで複数可)</th>
            <td><input type="text" name="item_id" value="{$returnValue.item_id}" size="20" style="ime-mode:disabled;"></td>
        </tr>
        <tr>
            <th>注文ステータス</th>
            <td>{html_options name="status" options=$orderStatus selected=$returnValue.status}</td>
        </tr>
        <tr>
            <th>支払方法</th>
            <td>{html_radios name="pay_type" options=$payType selected=$returnValue.pay_type|default:1 separator="&nbsp;"}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <input type="submit" name="action_ordering_OrderingSetExec" value="注 文" onClick="return confirm('注文しますか？')" />
            </td>
        </tr>
    </table>
</form>
{include file=$admFooter}
</div>
</body>
</html>