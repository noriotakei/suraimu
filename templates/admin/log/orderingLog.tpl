<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script language="JavaScript">
<!--
    $(function() {ldelim}
        {* テーブルマウスオーバーカラー *}
        $('#table').colorize({ldelim}
            altColor :'#E5E5E5',
            hiliteColor :'none'
        {rdelim});

    {rdelim});
// -->
</script>
<h2 class="ContentTitle">注文一覧</h2><br>
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
{if $orderingList}
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" align="center">
    <tr>
        <th><p>注文NO</p></th>
        <th>支払方法</th>
        <th>注文日時</th>
        <th>商品明細</th>
      </tr>
      <tr>
        <th>ステータス</th>
        <th>キャンセル</th>
        <th>入金</th>
        <th>メモ</th>
      </tr>

    {foreach from=$orderingList key="key" item="val" name="loop"}
        <tr {$val.style}>
            <td><a href="{make_link action="action_ordering_OrderingData" getTags="ordering_id="|cat:$val.id}" target="_blank">{$val.id}</a></td>
            <td>{$payType[$val.pay_type]}</td>
            <td>{$val.create_datetime}</td>
            <td>
                商品<br>
                <table border="0" cellpadding="0" cellspacing="0" style="font-size:11px">
                    {foreach from=$itemList[$key] item="itemVal" name="itemLoop"}
                    <tr >
                        <td nowrap width="150"><a href="{make_link action="action_informationStatus_InformationSearchList" getTags="search_html_text="|cat:$itemVal.access_key|cat:$URLparam}" target="_blank">{$itemVal.name}</a></td>
                        <td nowrap>\{$itemVal.price}</td>
                    </tr>
                    {/foreach}
                    <tr>
                        <td nowrap>合計</td>
                        <td nowrap>\{$val.pay_total}</td>
                    </tr>
                </table>
                <br>
                {if $changeItemList[$key]}
                注文変更履歴<br>
                <table border="0" cellpadding="0" cellspacing="0" style="font-size:11px">
                    {foreach from=$changeItemList[$key] item="changeItemVal" name="changeItemLoop"}
                    <tr >
                        <td nowrap width="150"><a href="{make_link action="action_informationStatus_InformationSearchList" getTags="search_html_text="|cat:$changeItemVal.access_key|cat:$URLparam}" target="_blank">{$changeItemVal.name}</a></td>
                        <td nowrap>\{$changeItemVal.price}</td>
                    </tr>
                    {/foreach}
                    <tr>
                        <td nowrap>合計</td>
                        <td nowrap>\{$changeItemTotalMoney[$key]}</td>
                    </tr>
                </table>
                {/if}
            </td>
        </tr>
        <tr {$val.style}>
            <td>{$orderStatus[$val.status]}</td>
            <td>{$cancelFlag[$val.is_cancel]}</td>
            <td {if $val.is_paid}style="color:red;"{/if}>{$paidFlag[$val.is_paid]}</td>
            <td>{$val.description|nl2br}</td>
        </tr>
    {/foreach}
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

