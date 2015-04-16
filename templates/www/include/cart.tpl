{if $cartItemList}
    <div id="cart">
    <h3>カート内の商品</h3>
    <p>貴方様の「ショッピングカード内」の商品です。ご購入には下記より決済種別のご選択をお願い致します。</p>
    {foreach from=$cartItemList item="val"}
        <table class="tableItem" cellspacing="2">
        <tr>
        <th>カート内商品名</th>
        <td class="attention">{$val.html_text_name_pc|emoji}</td>
        </tr>
        <tr>
        <th>商品金額</th>
        <td class="attention">{$val.price|number_format}円</td>
        </tr>
        <tr>
        <td colspan="2" class="end"><a href="./?action_{$accessPageName}=1&del=1&iid={$val.access_key}{if $comURLparam}&{$comURLparam}{/if}">カートからキャンセルする</a></td>
        </tr>
        </table>
    {/foreach}
    <table class="tableItem" cellspacing="2">
    <tr>
    <td><a href="./?action_SettleSelect=1{if $comURLparam}&{$comURLparam}{/if}">カート内の商品の決済方法を選ぶ</a></td>
    </tr>
    </table>
    <div id="under">&nbsp;</div>
    </div>
{/if}