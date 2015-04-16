<div id="pay">
<div id="titleSettle">お支払い方法の選択</div>
<div id="bank"><a href="./?action_SettleBank=1&{$URLparam}{if $comURLparam}&{$comURLparam}{/if}">銀行振込</a></div>
<div id="txt">お振込み手数料は、お客様のご負担となります。<br />
また、午後3時以降のお振込みは、翌銀行営業日の確認となりますので、あらかじめご了承ください。<br />
※楽天銀行からのお振込みは24時間365日、即時の自動確認となります。<br />
<span class="attentionY">※銀行営業時間外のお振込み確認に関しては明細書のFAXをお願い致します。</span><br />
FAX番号：03-6674-2857<br />
<span class="attentionY">又は写メールで明細書を撮影した画像を添付し、弊社サポートセンターまでご送付ください。</span><br />
メールアドレス：
<a href="mailto:info@{$config.define.MAIL_DOMAIN}">
<span style="color:white;text-align:left;">
info@{$config.define.MAIL_DOMAIN}
</span>
</a>
<br />
<img src="img/settle_banknet02.png" alt="銀行振込"/>
</div>
<hr />

<!-- NET銀行 
<div id="banknet"><a href="./?action_SettleNetBank=1&{$URLparam}{if $comURLparam}&{$comURLparam}{/if}">ネット銀行(24時間OK)</a><img src="img/settle_24h.gif" alt="24時間対応" /></div>
<div id="txt">24時間即時入金が出来る便利なネット銀行決済です。<br />
<span style="color:#F8F035;text-align:left;">
・ジャパンネット銀行<br />
・住信SBIネット銀行<br />
がご利用可能です。</span>
<img src="img/settle_banknet01.png" alt="ネット銀行" /></div>
<hr />
-->
<div id="credit"><a href="./?action_SettleTelecom=1&{$URLparam}{if $comURLparam}&{$comURLparam}{/if}">クレジットカード</a><img src="img/settle_24h.gif" alt="24時間対応" /></div>
<div id="txt">各社クレジットカードにて商品の購入が24時間可能です。VISA、JCB、MasterCardのマークが付いてるカードがご利用になれます。
<img src="img/icon_credit01.png" alt="ネット銀行" /></div>
<hr />

{if $itemTotalMoney <= 30000}
<div id="cvd"><a href="./?action_SettleCvd=1&{$URLparam}{if $comURLparam}&{$comURLparam}{/if}">コンビニ決済</a><img src="img/settle_24h.gif" alt="24時間対応" /></div>
<div id="txt">ユーザー様が購入したい料金分だけをコンビニエンスストアで支払うことの出来る新しい決済方法です。他の電子マネーと異なり、金額の設定がないため、ユーザー様の利便性を重視した支払い方法です。<img src="img/settle_cv.gif" alt="コンビニ" width="312" height="30" /></div>
<hr />
{/if}
{if $itemTotalMoney <= 25000}
<div id="bitcash"><a href="./?action_SettleBitcash=1&{$URLparam}{if $comURLparam}&{$comURLparam}{/if}">BITCASH決済</a><img src="img/settle_24h.gif" alt="24時間対応" /></div>
<div id="txt">インターネット上での決済を行えるプリペイド式の電子マネーです。ビットキャッシュは、お近くのコンビニエンスストア、又はインターネットで購入できます。<img src="img/settle_bitcash.gif" alt="コンビニ" width="312" height="64" /><br />
<img src="img/settle_ex.gif" alt="Bitcash" style="float:right;" />
<a href="http://www.bitcash.co.jp/i/sheet/index.html"><span class="attentionY">※EXカードのみご利用になれます。<br />
ビットキャッシュ購入方法はコチラ＞＞</span></a>
</div>
<hr />
{/if}
</div>
<p class="attention"><a href="./?action_ItemList=1{if $comURLparam}&{$comURLparam}{/if}">他のキャンペーンを見てみる</a></p>