{if $lastOrderingItemList}
    <div id="reservation">
    <h3>最重要　ご予約中の商品</h3>
    <p>貴方様が予約された商品です。キャンペーン情報は期間限定・完全先着・人数限定ですので、至急の決済お手続きをお願い申し上げます。</p>
    {foreach from=$lastOrderingItemList item="val"}
        <table class="tableItem" cellspacing="2">
        <tr>
        <th>ご予約商品名</th>
        <td class="attention">{$val.html_text_name_pc|emoji}</td>
        </tr>
        <tr>
        <th>商品金額</th>
        <td class="attention">{$val.price|number_format}円</td>
        </tr>
        </table>
    {/foreach}
    <table class="tableItem" cellspacing="2">
    <tr>
    <th>ご決済金額</th>
    <td class="attention">{$lastOrderingData.pay_total|number_format:"0"}円</td>
    </tr>
    <!--カウントダウン追加 -->
    {if $showCountDown }
    <script type="text/javascript" src="js/countDown.js"></script>
    <tr>
        <th>締切まで残時間</th>
        <td align="center"><span id="cntdown1" style="font-size:28px; color:#000; height:40px; line-height:40px;"></span>
            <script type="text/javascript">countdown('cntdown1',{$countDownYear},{$countDownMonth},{$countDownDay},{$countDownHour},{$countDownMinute});</script>
        </td>
    </tr>
    {/if}
    <!--/カウントダウン追加 -->
    <tr>
    <th>ご予約日時</th>
    <td>{$lastOrderingData.create_datetime|zend_date_format:'yyyy年MM月dd日 HH時mm分ss秒'}</td>
    </tr>
    </table>
    <table class="tableItem" cellspacing="2">
    <tr>
    <th>決済種別</th>
    <td>{$settleName}決済</td>
    </tr>
    <tr>
    <td colspan="2" class="end"><a href="./?action_OrderingDelChk=1&odid={$lastOrderingData.access_key}{if $comURLparam}&{$comURLparam}{/if}">ご予約をキャンセルする</a></td>
    </tr>
    </table>
    <table class="tableItem" cellspacing="2">
    <tr>
    <td><a href="./?action_Settle{$settleLinkUrl}=1&odid={$lastOrderingData.access_key}{if $comURLparam}&{$comURLparam}{/if}">詳細はこちら</a></td>
    </tr>
    </table>
    <div id="under">&nbsp;</div>
    </div>
{/if}