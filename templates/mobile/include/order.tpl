{if $lastOrderingItemList}
    {foreach from=$lastOrderingItemList item="val"}
        <div class="cart">
            <table>
                <tr>
                    <th>内容</th>
                    <td>{$val.html_text_name_mb|emoji}</td>
                </tr>
                <tr>
                    <th>価格</th>
                    <td class="red">{$val.price|number_format}円</td>
                </tr>
            </table>
        </div>
    {/foreach}

    <!--カウントダウン追加 -->
    {if $showCountDown }
        <div class="cart">
            <script type="text/javascript" src="js/countDown.js"></script>
            <table>
                <tr>
                    <th>締切まで残時間</th>
                    <td align="center"><span id="cntdown1" style="font-size:34px; color:#000; height:40px; line-height:40px;"></span>
                        <script type="text/javascript">countdown('cntdown1',{$countDownYear},{$countDownMonth},{$countDownDay},{$countDownHour},{$countDownMinute});</script>
                    </td>
                </tr>
            </table>
        </div>
    {/if}
    <!--/カウントダウン追加 -->

    <!-- ボタン -->
    <div class="btnSettle">
        <a href="./?action_Settle{$settleLinkUrl}=1&odid={$lastOrderingData.access_key}{if $comURLparam}&{$comURLparam}{/if}"><img src="http://image.ko-haito.com/contents/loginSp/btnSettle.gif" alt="決済する" class="responsive"></a>
    </div>
{/if}