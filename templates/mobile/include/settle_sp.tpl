<!-- 銀行振込 -->
<ul class="bank mBtm20">
    <li class="title clearfix">
        <div>銀行振込でお支払い</div>
        <p class="h24">楽天のみ<br>24H対応</p>
    </li>
    <li class="text">
        <p class="sLogo"><img src="http://image.ko-haito.com/contents/settle/logoBank.png" alt="各社銀行" class="responsive"></p>
        <div class="btn">
            <a href="./?action_SettleBank=1&odid={$orderingData.access_key}{if $comURLparam}&{$comURLparam}{/if}"><img src="http://image.ko-haito.com/contents/settle/btnSettleBank.png" alt="銀行振込" class="responsive"></a>
        </div>
    </li>
</ul>

<!-- クレジット -->
<ul class="credit mBtm20">
    <li class="title clearfix">
        <div>クレジットカードでお支払い</div>
        <p class="h24">24H対応</p>
    </li>
    <li class="text">
        <p>各社クレジットカードにて賞品の購入が24時間可能です。VISA、JCB、MasterCard、American Express、Diners Clubのマークが付いているカードがご利用になれます。</p>
        <p class="sLogo"><img src="http://image.ko-haito.com/contents/settle/logoCredit.png" alt="各社クレジット" class="responsive"></p>
        <div class="btn">
            <a href="./?action_SettleTelecom=1&odid={$orderingData.access_key}{if $comURLparam}&{$comURLparam}{/if}"><img src="http://image.ko-haito.com/contents/settle/btnSettleCredit.png" alt="クレジット決済" class="responsive"></a>
        </div>
    </li>
</ul>

<!-- ネットバンク -->
<ul class="netbank mBtm20">
    <li class="title clearfix">
        <div>ネット銀行でお支払い</div>
        <p class="h24">24H対応</p>
    </li>
    <li class="text">
        <p>24時間365日の即時入金が出来る便利なネット銀行決済です。<br><span class="blue">※但し、ジャパンネット銀行、住信SBIネット銀行のみ24時間365日の即時入金が可能です。</span></p>
        <p class="sLogo"><img src="http://image.ko-haito.com/contents/settle/logoNetbank.png" alt="ネットバンク" class="responsive"></p>
        <div class="btn">
            <a href="./?action_SettleNetBank=1&odid={$orderingData.access_key}{if $comURLparam}&{$comURLparam}{/if}"><img src="http://image.ko-haito.com/contents/settle/btnSettleNetbank.png" alt="かんたん決済" class="responsive"></a>
        </div>
    </li>
</ul>
{if $itemTotalMoney <= 25000}
<!-- ビットキャッシュ -->
<ul class="bitcash mBtm20">
    <li class="title clearfix">
        <div>ビットキャッシュでお支払い</div>
        <p class="h24">24H対応</p>
    </li>
    <li class="text">
        <p>インターネット上での決済を行えるプリペイド式の電子マネーです。ビットキャッシュは、お近くのコンビニエンスストア、又はインターネットで購入できます。</p>
        <p><span class="blue">※STカード・EXカードどちらもご利用になれます。</span><a href="http://bitcash.jp/docs/purchase/index?sv=2">ビットキャッシュ購入方法はコチラ</a></p>
        <p class="sLogo"><img src="http://image.ko-haito.com/contents/settle/logoBitcash.png" alt="ビットキャッシュ" class="responsive"></p>
        <div class="btn">
            <a href="./?action_SettleBitcash=1&odid={$orderingData.access_key}{if $comURLparam}&{$comURLparam}{/if}"><img src="http://image.ko-haito.com/contents/settle/btnSettleBitcash.png" alt="ビットキャッシュ決済" class="responsive"></a>
        </div>
    </li>
</ul>
{/if}

{if $itemTotalMoney <= 30000}
<!-- コンビニ -->
<ul class="cvd mBtm20">
    <li class="title clearfix">
        <div>コンビニ決済でお支払い</div>
        <p class="h24">24H対応</p>
    </li>
    <li class="text">
        <p>ユーザー様が購入したい料金分だけをコンビニエンスストアで支払うことの出来る新しい決済方法です。他の電子マネーと異なり、金額の設定がないため、ユーザー様の利便性を重視した支払い方法です。</p>
        <p class="sLogo"><img src="http://image.ko-haito.com/contents/settle/logoCvd.png" alt="コンビニ" class="responsive"></p>
        <div class="btn">
            <a href="./?action_SettleCvd=1&odid={$orderingData.access_key}{if $comURLparam}&{$comURLparam}{/if}"><img src="http://image.ko-haito.com/contents/settle/btnSettleCvd.png" alt="コンビニ決済" class="responsive"></a>
        </div>
    </li>
</ul>
{/if}