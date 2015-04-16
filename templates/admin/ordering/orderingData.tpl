{include file=$admHeader}
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
<script type="text/javascript" src="./js/jquery.timepickr.min.js"></script>
<script language="JavaScript">
<!--
    $(function() {ldelim}

        {* 時刻入力 *}
        $(".time").timepickr({ldelim}
            format24: "{ldelim}h:02.d{rdelim}:{ldelim}m:02.d{rdelim}:{ldelim}s:02.d{rdelim}",
            seconds: true,
            rangeMin: ["00","05","10","15","20","25","30","35","40","45","50","55","59"],
            rangeSec: ["00","15","30","45","59"],
            convention: 24,
            resetOnBlur : false
        {rdelim});

        {* カレンダー *}
        $(".datepicker").datepicker({ldelim}
            dateFormat: "yy-mm-dd"
        {rdelim});

    {rdelim});
// -->
</script>
</head>
<body>
<div class="BlockCol">
    <h2 class="ContentTitle">注文詳細</h2>
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
    <form action="./" method="post">
        {$POSTparam}
        <input type="submit" name="action_ordering_OrderingSearchList" value="一覧へ戻る" style="width:8em;"/>
    </form>
    <br>
    {if $orderingData}
        <table border="0" width="90%">
            <tr>
            <td align="left" valign="top">
                <form action="./" method="post">
                    {$POSTparam}
                    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
                        <tr>
                            <th>サポートメール</th>
                        </tr>
                        <tr>
                            <td>
                            {if !($userData.regist_status == $config.define.USER_REGIST_STATUS_MEMBER_QUIT OR $userData.danger_status == $config.define.DANGER_VALID)}
                                <input type="submit" name="action_ordering_SupportMailInput" value="サポートメールを送る"/>
                            {/if}
                            <br><br>
                            <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
                                <caption>メール送信履歴</caption>
                                <tr>
                                    <th>日付</th>
                                    <th>PCタイトル</th>
                                    <th>MBタイトル</th>
                                    <th>確認</th>
                                </tr>
                                {foreach from=$supportMailList item="val"}
                                    <tr>
                                        <td>{$val.create_datetime}</td>
                                        <td>{$val.pc_subject}</td>
                                        <td>{$val.mb_subject}</td>
                                        <td>
                                            <form action="./" method="post">
                                                {$POSTparam}
                                                <input type="hidden" name="support_mail_id" value="{$val.id}">
                                                <input type="submit" name="action_ordering_SupportMailLogData" value="確 認"/>
                                            </form>
                                        </td>
                                    </tr>
                                {/foreach}
                            </table>
                            </td>
                        </tr>
                    </table>
                </form>
            </td>
            <td align="right" valign="top">
                <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
                    <tr><td><font color="red">※手順2：下記にて「注文ステータス」を決済完了にしてから<br>　　　　　　入金処理を行う</font></td></tr>
                    <tr>
                        <th>入金情報</th>
                    </tr>
                    <tr>
                        <td>
                        <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
                            <tr>
                                <th>入金日</th>
                                <td>{$orderingData.paid_datetime}</td>
                            </tr>
                        </table>
                        </td>
                    </tr>
                    {if !$orderingData.is_cancel}
                        <tr>
                            <td>
                                <form action="./" method="post">
                                    {$POSTparam}
                                    {if $orderingData.is_paid}
                                        <input type="hidden" name="payment_cancel" value="1"/>
                                        <input type="submit" name="action_ordering_OrderingPaymentExec" value="入金キャンセルをする" OnClick="return confirm('入金キャンセルをしますか？')"/>
                                    {else}
                                        {*
                                        <input name="paid_datetime_Date" size="15" class="datepicker" type="text" value="{$smarty.now|zend_date_format:'yyyy-MM-dd'}" maxlength="10">
                                        <input name="paid_datetime_Time" class="time" type="text" value="{$smarty.now|zend_date_format:'HH:00:00'}" size="10" maxlength="8">
                                        <br><br>
                                        *}
                                        <input type="submit" name="action_ordering_OrderingPaymentExec" value="入金する" OnClick="return confirm('入金情報を変更しますか？')"/>
                                    {/if}
                                </form>
                            </td>
                        </tr>
                    {/if}
                </table>
            </td>
            </tr>
        </table>
        <br><br>
        <table border="0" width="90%">
            <tr>
            <td align="left" valign="top">
                <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
                    <tr>
                        <th>注文情報</th>
                    </tr>
                    <tr>
                        <td>
                        <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
                            <tr>
                                <th>注文No</th>
                                <td>{$orderingData.id}</td>
                            </tr>
                            <tr>
                                <th>注文日時</th>
                                <td>{$orderingData.create_datetime}</td>
                            </tr>
                            <tr>
                                <th>更新日時</th>
                                <td>{$orderingData.update_datetime}</td>
                            </tr>
                            <tr>
                                <th>キャンセル</th>
                                <td>{$cancelFlag[$orderingData.is_cancel]}</td>
                            </tr>
                            <tr>
                                <th>キャンセル日時</th>
                                <td>{$orderingData.cancel_datetime}</td>
                            </tr>
                            <tr>
                                <th>決済完了日時</th>
                                <td>{$orderingData.paid_datetime}</td>
                            </tr>
                        </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {if !$orderingData.is_cancel}
                            <form action="./" method="post">
                                {$POSTparam}
                                <input type="submit" name="action_ordering_OrderingDelExec" value="注文をキャンセル" OnClick="return confirm('注文をキャンセルしますか？')"/>
                            </form>
                            <br>
                            {else}
                            <form action="./" method="post">
                                {$POSTparam}
                                <input type="submit" name="action_ordering_OrderingDelCancelExec" value="注文キャンセルを取りやめ" OnClick="return confirm('注文キャンセルを取りやめますか？')"/>
                            </form>
                            <br>
                            {/if}
                            {* 管理者 システム用メニュー *}
                            {if $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SYSTEM
                                OR $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_MANAGE}
                            <form action="./" method="post">
                                {$POSTparam}
                                <input type="hidden" name="is_delete" value="1"/>
                                <input type="submit" name="action_ordering_OrderingDelExec" value="注文を削除" OnClick="return confirm('注文を削除しますか？')"/>
                            </form>
                            {/if}
                        </td>
                    </tr>
                </table>
            </td>
            <td align="right" valign="top">
                <form action="./" method="post">
                    {$POSTparam}
                    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
                        <tr><td colspan="2"><font color="red">※手順1：「注文ステータス」を決済完了にしてから</br>　　　　　　「入金する」ボタンで入金処理を行う</font></td></tr>
                        <tr>
                            <th>注文ステータス</th>
                            <td>{html_options name="status" options=$orderStatus selected=$orderingData.status}</td>
                        </tr>
                        <tr>
                            <th>対応＆メモ</th>
                            <td><textarea name="description" cols="30" rows="5">{$orderingData.description}</textarea></td>
                        </tr>
                        <tr>
                            <td style="text-align:center;" colspan="2">
                                <input type="submit" name="action_ordering_OrderingStatusExec" value="変更する" OnClick="return confirm('注文ステータスを変更しますか？')" style="width:8em;"/>
                            </td>
                        </tr>
                    </table>
                    <br><br>
                    {if $isAuomationBas}
                    <table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet04">
                        <tr>
                          <td colspan="2">
                            <font color="red">
                                                                ※商品の期限切れ状態で押すと余り金決済となり</br>
                                                                金額分のポイントが付与されます（リメールは飛びません）
                            </font>
                          </td>
                        </tr>
                        <tr><th colspan="2" style="text-align:center;">銀行振り込み一括手動完済</th></tr>
                        <tr>
                            <td style="text-align:center;">
                                <input type="submit" value="一括完済処理" name="action_ordering_{$settleUrl}"  onclick="return confirm('一括完済処理しますか？');"/>
                            </td>
                        </tr>
                    </table>
                    {/if}
                </form>
            </td>
            </tr>
        </table>
        <br><br>
        <table border="0" width="80%">
            <tr>
            <td align="left" valign="top">
            <form action="./" method="post">
                {$POSTparam}
                <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
                    <tr>
                        <th>支払方法</th>
                        <td>{html_radios name="pay_type" options=$payType selected=$orderingData.pay_type separator="&nbsp;"}</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;" colspan="2">
                            <input type="submit" name="action_ordering_OrderingPayTypeExec" value="変更する" OnClick="return confirm('支払方法を変更しますか？')" style="width:8em;"/>
                        </td>
                    </tr>
                </table>
            </form>
            </td>
            </tr>
        </table>
        <br><br>
        <table border="0" width="90%">
            <tr>
            <td align="left" valign="top">
                <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
                    <tr>
                        <th colspan="2">お客様情報</th>
                    </tr>
                    <tr>
                        <th>ユーザーID</th>
                        <td><a href="./?action_user_Detail=1&user_id={$userData.user_id}" target="_blank">{$userData.user_id}</a></td>
                    </tr>
                    {if "pc_address"|in_array:$displayUserDetail}
                    <tr>
                        <th>PCメールアドレス</th>
                        <td>{$userData.pc_address}</td>
                    </tr>
                    {/if}
                    {if "pc_address_no_domain"|in_array:$displayUserDetail}
                    <tr>
                        <th>PCメールアドレス(ドメインなし)</th>
                        <td>{$userData.pc_address_no_domain}</td>
                    </tr>
                    {/if}
                    {if "mb_address"|in_array:$displayUserDetail}
                    <tr>
                        <th>MBメールアドレス</th>
                        <td>{$userData.mb_address}</td>
                    </tr>
                    {/if}
                    {if "mb_address_no_domain"|in_array:$displayUserDetail}
                    <tr>
                        <th>MBメールアドレス(ドメインなし)</th>
                        <td>{$userData.mb_address_no_domain}</td>
                    </tr>
                    {/if}
                    <tr>
                        <th>ポイント</th>
                        <td>{$userData.point}pt</td>
                    </tr>
                    <tr>
                        <th>合計付与ポイント</th>
                        <td>{$userData.total_addition_point}pt</td>
                    </tr>
                </table>
            </td>
            </tr>
        </table>
        <br><br>
        <form action="./" method="post">
            {$POSTparam}
            <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
                <tr>
                    <th colspan="2">注文詳細情報</th>
                </tr>
                {if $itemList}
                <tr><td>
                    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
                        <tr>
                            <th width="200">商品</th>
                            <th>価格</th>
                            <th>削除</th>
                        </tr>
                        {foreach from=$itemList item="itemVal" name="itemLoop"}
                        <tr>
                            <td>
                                {if $itemVal.is_rest}
                                    余り金PT購入
                                {else}
                                    <a href="{make_link action="action_itemManagement_itemData" getTags="iid="|cat:$itemVal.id}">{$itemVal.name|emoji}</a>
                                {/if}
                            </td>
                            <td><input type="text" name="price[{$itemVal.detail_id}]" value="{$itemVal.price}" size="7" style="ime-mode:disabled;text-align:right;">円</td>
                            <td><input type="checkbox" name="disable[{$itemVal.detail_id}]" value="1"></td>
                        </tr>
                        {/foreach}
                    </table>
                </td></tr>
                {/if}
                <tr><td>
                    <table border="0" cellspacing="0" cellpadding="0" class="TableSet03" align="right">
                        <tr>
                            <th>総合計</th>
                            <td>{$orderingData.pay_total}円</td>
                        </tr>
                        {if $itemList}
                        <tr>
                            <td style="text-align:center;" colspan="2"><input type="submit" name="action_ordering_OrderingDetailExec" value="変更する" OnClick="return confirm('注文詳細を変更しますか？')" style="width:8em;"/></td>
                        </tr>
                        {/if}
                    </table>
                </td></tr>
                {if $changeItemList}
                <tr><td>
                    注文変更履歴<br>
                    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
                        <tr>
                            <th width="200">商品</th>
                            <th>変更時ステータス</th>
                            <th>価格</th>
                        </tr>
                        {foreach from=$changeItemList item="changeItemVal" name="changeItemLoop"}
                        <tr>
                            <td>
                                {if !$changeItemVal.item_id}
                                    余り金PT購入
                                {else}
                                    <a href="{make_link action="action_itemManagement_itemData" getTags="iid="|cat:$changeItemVal.item_id}">{$changeItemVal.name|emoji}</a>
                                {/if}
                            </td>
                            <td>{$changeStatus[$changeItemVal.status]}</td>
                            <td>{if $changeItemVal.price > 0}+{/if}{$changeItemVal.price}円</td>
                        </tr>
                        {/foreach}
                    </table>
                </td></tr>
                <tr><td>
                    <table border="0" cellspacing="0" cellpadding="0" class="TableSet03" align="right">
                        <tr>
                            <th>変更合計金額</th>
                            <td>{if $changeItemTotalMoney > 0}+{/if}{$changeItemTotalMoney}円</td>
                        </tr>
                    </table>
                </td></tr>
                {/if}
            </table>
        </form>
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
