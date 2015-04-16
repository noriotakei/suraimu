<script language="JavaScript">
<!--
    $(function() {ldelim}
        {* テーブルストライプ *}
        $("#table tr:even").addClass("BgColor02");
    {rdelim});
// -->
</script>

{* 更新時エラーコメント *}
{if $errMsg}
    <div class="warning ui-widget">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    <p>
    <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    {$errMsg}
    </p>
    </div>
    </div>
{/if}
<table cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td>
            <span style="color:#FF0000;font-size:20px;"><b>{$accessTitle}</b></span><br>
        </td>
    </tr>
    <tr>
        <td align="center">
            <span style="color:#00F;font-size:24px;">アクセス数</span>
        </td>
    </tr>
</table>
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th rowspan="2"><b>媒体名</b></th>
        <th rowspan="2"><b>広告コード</b></th>
        <th colspan="{$dispMonthlyAccessCount}"><center><b>本登録月毎のアクセス数</b></center></th>
        <th rowspan="2"><b>媒体別アクセス数合計</b></th>
    </tr>
    <tr>
        {foreach from=$dispMonthlyAccess item="val" key="key" name="loop"}
            <th><b>{$val}</b></th>
        {/foreach}
    </tr>
    {foreach from=$baitaiAccessCountList item="list" key="baitaiName" name="loop"}
    <tr>
        <td>{$mediaCdNameList.$baitaiName}</td>
        <td>{$baitaiName}</td>
        {foreach from=$list item="access" name="loop"}
            <td>{$access}</td>
        {/foreach}
        <td>{$accessTotalForMediaCd.$baitaiName|default:0}回</td>
    </tr>
    {/foreach}
    <tr class="BgColor02">
        <td colspan="2"><b>月間合計</b></td>
        {foreach from=$accessTotalForMonthly item="accessTotal" name="loop"}
            <td>{$accessTotal|default:0}回</td>
        {/foreach}
        <td>{$accessAllTotal|default:0}回</td>
    </tr>
</table>

<br>

<table cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td>
            <span style="color:#FF0000;font-size:20px;"><b>{$preRegistTitle}</b></span>
        </td>
    </tr>
    <tr>
        <td align="center">
            <span style="color:#00F;font-size:24px;">仮登録者数</span>
        </td>
    </tr>
</table>
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th rowspan="2"><b>媒体名</b></th>
        <th rowspan="2"><b>広告コード</b></th>
        <th colspan="{$dispMonthlyPreRegistCount}"><center><b>仮登録月</b></center></th>
        <th rowspan="2"><b>媒体別登録数合計</b></th>
    </tr>
    <tr>
        {foreach from=$dispMonthlyPreRegist item="val" key="key" name="loop"}
            <th><b>{$val}</b></th>
        {/foreach}
    </tr>
    {foreach from=$baitaiPreRegistCountList item="list" key="baitaiName" name="loop"}
    <tr>
        <td>{$mediaCdNameList.$baitaiName}</td>
        <td>{$baitaiName}</td>
        {foreach from=$list item="preRegist" key="preRegistMonth" name="loop"}
            <td>{$preRegist|default:0}</td>
        {/foreach}
        <td>{$preRegistTotalForMediaCd.$baitaiName|default:0}人</td>
    </tr>
    {/foreach}
    <tr class="BgColor02">
        <td colspan="2"><b>月間合計</b></td>
        {foreach from=$preRegistTotalForMonthly item="preRegistTotal" key="preRegistMonthly" name="loop"}
            <td>{$preRegistTotal|default:0}人</td>
        {/foreach}
        <td>{$preRegistAllTotal}人</td>
    </tr>
</table>
<br>
<table cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td>
            <span style="color:#FF0000;font-size:20px;"><b>{$registTitle}</b></span>
        </td>
    </tr>
    <tr>
        <td align="center">
            <span style="color:#00F;font-size:24px;">本登録者数</span>
        </td>
    </tr>
</table>
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th rowspan="2"><b>媒体名</b></th>
        <th rowspan="2"><b>広告コード</b></th>
        <th colspan="{$dispMonthlyRegistCount}"><center><b>本登録月</b></center></th>
        <th rowspan="2"><b>媒体別登録数合計</b></th>
    </tr>
    <tr>
        {foreach from=$dispMonthlyRegist item="val" key="key" name="loop"}
            <th><b>{$val}</b></th>
        {/foreach}
    </tr>
    {foreach from=$baitaiRegistCountList item="list" key="baitaiName" name="loop"}
    <tr>
        <td>{$mediaCdNameList.$baitaiName}</td>
        <td>{$baitaiName}</td>
        {foreach from=$list item="regist" key="registMonth" name="loop"}
            <td>{$regist|default:0}</td>
        {/foreach}
        <td>{$registTotalForMediaCd.$baitaiName|default:0}人</td>
    </tr>
    {/foreach}
    <tr class="BgColor02">
        <td colspan="2"><b>月間合計</b></td>
        {foreach from=$registTotalForMonthly item="registTotal" key="registonthly" name="loop"}
            <td>{$registTotal|default:0}人</td>
        {/foreach}
        <td>{$registAllTotal}人</td>
    </tr>
</table>
<br>
<table cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td>
            <span style="color:#FF0000;font-size:20px;"><b>{$quitUserTitle}</b></span>
        </td>
    </tr>
    <tr>
        <td align="center">
            <span style="color:#00F;font-size:24px;">退会者数</span>
        </td>
    </tr>
</table>
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th rowspan="2"><b>媒体名</b></th>
        <th rowspan="2"><b>広告コード</b></th>
        <th colspan="{$dispMonthlyQuitUserCount}"><center><b>本登録月</b></center></th>
        <th rowspan="2"><b>媒体別登録数合計</b></th>
    </tr>
    <tr>
        {foreach from=$dispMonthlyQuitUser item="val" key="key" name="loop"}
            <th><b>{$val}</b></th>
        {/foreach}
    </tr>
    {foreach from=$baitaiQuitUserCountList item="list" key="baitaiName" name="loop"}
    <tr>
        <td>{$mediaCdNameList.$baitaiName}</td>
        <td>{$baitaiName}</td>
        {foreach from=$list item="regist" key="registMonth" name="loop"}
            <td>{$regist|default:0}</td>
        {/foreach}
        <td>{$quitUserTotalForMediaCd.$baitaiName|default:0}人</td>
    </tr>
    {/foreach}
    <tr class="BgColor02">
        <td colspan="2"><b>月間合計</b></td>
        {foreach from=$quitUserTotalForMonthly item="registTotal" key="registonthly" name="loop"}
            <td>{$registTotal|default:0}人</td>
        {/foreach}
        <td>{$quitUserAllTotal}人</td>
    </tr>
</table>
<br>
<table cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td>
            <span style="color:#FF0000;font-size:20px;"><b>{$payTitle}</b></span><br>
        </td>
    </tr>
    <tr>
        <td align="center">
            <span style="color:#00F;font-size:24px;">入金額</span>
        </td>
    </tr>
</table>
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th rowspan="2"><b>媒体名</b></th>
        <th rowspan="2"><b>広告コード</b></th>
        <th colspan="{$dispMonthlyPayCount}"><center><b>入金月</b></center></th>
        <th rowspan="2"><b>媒体別入金合計</b></th>
    </tr>
    <tr>
        {foreach from=$dispMonthlyPay item="val" key="key" name="loop"}
            <th><b>{$val}</b></th>
        {/foreach}
    </tr>
    {foreach from=$tradeAmountList item="list" key="baitaiName" name="loop"}
    <tr>
        <td>{$mediaCdNameList.$baitaiName}</td>
        <td>{$baitaiName}</td>
        {foreach from=$list item="regist" key="payMonth" name="loop"}
            <td>{$regist|default:0}</td>
        {/foreach}
        <td>{$payTotalForMediaCd.$baitaiName|default:0}円</td>
    </tr>
    {/foreach}
    <tr class="BgColor02">
        <td colspan="2"><center><b>月間合計</b></center></td>
        {foreach from=$payTotalForMonthly item="payTotal" key="payMonthly" name="loop"}
            <td>{$payTotal|default:0}円</td>
        {/foreach}
        <td>{$payAllTotal}円</td>
    </tr>
</table>
<br>



<table cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td>
            <span style="color:#FF0000;font-size:20px;"><b>{$payTitle}</b></span><br>
        </td>
    </tr>
    <tr>
        <td align="center">
            <span style="color:#00F;font-size:24px;">入金者数</span>
        </td>
    </tr>
</table>
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th rowspan="2"><b>媒体名</b></th>
        <th rowspan="2"><b>広告コード</b></th>
        <th colspan="{$dispMonthlyPayUserCount}"><center><b>入金月</b></center></th>
        <th rowspan="2"><b>媒体別入金者数合計</b></th>
    </tr>
    <tr>
        {foreach from=$dispMonthlyPayUser item="val" key="key" name="loop"}
            <th><b>{$val}</b></th>
        {/foreach}
    </tr>
    {foreach from=$tradeUserList item="list" key="baitaiName" name="loop"}
    <tr>
        <td>{$mediaCdNameList.$baitaiName}</td>
        <td>{$baitaiName}</td>
        {foreach from=$list item="regist" key="payMonth" name="loop"}
            <td>{$regist|default:0}</td>
        {/foreach}
        <td>{$payUserTotalForMediaCd.$baitaiName|default:0}人</td>
    </tr>
    {/foreach}
    <tr class="BgColor02">
        <td colspan="2"><center><b>月間合計</b></center></td>
        {foreach from=$payUserTotalForMonthly item="payTotal" key="payMonthly" name="loop"}
            <td>{$payTotal|default:0}人</td>
        {/foreach}
        <td>{$payUserAllTotal}人</td>
    </tr>
</table>
<br>
<table cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td>
            <span style="color:#FF0000;font-size:20px;"><b>{$advertiseTitle}</b></span><br>
        </td>
    </tr>
    <tr>
        <td align="center">
            <span style="color:#00F;font-size:24px;">広告費</span>
        </td>
    </tr>
</table>
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th rowspan="2"><b>媒体名</b></th>
        <th rowspan="2"><b>広告コード</b></th>
        <th colspan="{$dispMonthAdvertiseExpensesCount}"><center><b>広告費月</b></center></th>
        <th rowspan="2"><b>媒体別広告費合計</b></th>
    </tr>
    <tr>
        {foreach from=$dispMonthAdvertiseExpenses item="val" key="key" name="loop"}
            <th><b>{$val}</b></th>
        {/foreach}
    </tr>
    {foreach from=$baitaiAdvertiseExpensesList item="list" key="baitaiName" name="loop"}
    <tr>
        <td>{$mediaCdNameList.$baitaiName}</td>
        <td>{$baitaiName}</td>
        {foreach from=$list item="regist" key="payMonth" name="loop"}
            <td>{$regist|default:0}</td>
        {/foreach}
        <td>{$advertiseExpensesTotalForMediaCd.$baitaiName|default:0}円</td>
    </tr>
    {/foreach}
    <tr class="BgColor02">
        <td colspan="2"><center><b>月間合計</b></center></td>
        {foreach from=$advertiseExpensesTotalForMonthly item="advertiseExpensesMonthTotal" key="advertiseExpenses" name="loop"}
            <td>{$advertiseExpensesMonthTotal|default:0}円</td>
        {/foreach}
        <td>{$advertiseExpensesTotal}円</td>
    </tr>
</table>
<br>
<table cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td>
            <span style="color:#FF0000;font-size:20px;"><b>{$cvrTitle}</b></span><br>
        </td>
    </tr>
    <tr>
        <td align="center">
            <span style="color:#00F;font-size:24px;">CVR(%)Conversion Rate（本登録者数/アクセス数）</span>
        </td>
    </tr>
</table>
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th rowspan="2"><b>媒体名</b></th>
        <th rowspan="2"><b>広告コード</b></th>
        <th colspan="{$dispMonthAdvertiseExpensesCount}"><center><b>CVR算出月</b></center></th>
        <th rowspan="2"><b>媒体別入金合計</b></th>
    </tr>
    <tr>
        {foreach from=$dispMonthAdvertiseExpenses item="val" key="key" name="loop"}
            <th><b>{$val}</b></th>
        {/foreach}
    </tr>
    {foreach from=$baitaiCvrList item="list" key="baitaiName" name="loop"}
    <tr>
        <td>{$mediaCdNameList.$baitaiName}</td>
        <td>{$baitaiName}</td>
        {foreach from=$list item="cvrVal" key="cvrKey" name="loop"}
            <td>{$cvrVal|default:0}%</td>
        {/foreach}
        <td>{$cvrTotalForMediaCd.$baitaiName|default:0}%</td>
    </tr>
    {/foreach}
    <tr class="BgColor02">
        <td colspan="2"><center><b>月間合計</b></center></td>
        {foreach from=$cvrTotalForMonthly item="cvrMonthTotalMonth" key="cvrMonthly" name="loop"}
            <td>{$cvrMonthTotalMonth|default:0}%</td>
        {/foreach}
        <td>{$cvrTotal}%</td>
    </tr>
</table>
<br>
<table cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td>
            <span style="color:#FF0000;font-size:20px;"><b>{$cpcTitle}</b></span><br>
        </td>
    </tr>
    <tr>
        <td align="center">
            <span style="color:#00F;font-size:24px;">CPC(円)Cost Per Click（広告費/アクセス数)</span>
        </td>
    </tr>
</table>
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th rowspan="2"><b>媒体名</b></th>
        <th rowspan="2"><b>広告コード</b></th>
        <th colspan="{$dispMonthAdvertiseExpensesCount}"><center><b>CPC算出月</b></center></th>
        <th rowspan="2"><b>媒体別入金合計</b></th>
    </tr>
    <tr>
        {foreach from=$dispMonthAdvertiseExpenses item="val" key="key" name="loop"}
            <th><b>{$val}</b></th>
        {/foreach}
    </tr>
    {foreach from=$baitaiCpcList item="list" key="baitaiName" name="loop"}
    <tr>
        <td>{$mediaCdNameList.$baitaiName}</td>
        <td>{$baitaiName}</td>
        {foreach from=$list item="cpcVal" key="cpcKey" name="loop"}
            <td>{$cpcVal|default:0}</td>
        {/foreach}
        <td>{$cpcTotalForMediaCd.$baitaiName|default:0}円</td>
    </tr>
    {/foreach}
    <tr class="BgColor02">
        <td colspan="2"><center><b>月間合計</b></center></td>
        {foreach from=$cpcTotalForMonthly item="cpcMonthTotalMonth" key="cpcMonthly" name="loop"}
            <td>{$cpcMonthTotalMonth|default:0}円</td>
        {/foreach}
        <td>{$cpcTotal}円</td>
    </tr>
</table>
<br>
<table cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td>
            <span style="color:#FF0000;font-size:20px;"><b>{$cpaTitle}</b></span><br>
        </td>
    </tr>
    <tr>
        <td align="center">
            <span style="color:#00F;font-size:24px;">CPA(円)Cost Per Action（広告費/本登録者数)</span>
        </td>
    </tr>
</table>
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th rowspan="2"><b>媒体名</b></th>
        <th rowspan="2"><b>広告コード</b></th>
        <th colspan="{$dispMonthAdvertiseExpensesCount}"><center><b>CPA算出月</b></center></th>
        <th rowspan="2"><b>媒体別入金合計</b></th>
    </tr>
    <tr>
        {foreach from=$dispMonthAdvertiseExpenses item="val" key="key" name="loop"}
            <th><b>{$val}</b></th>
        {/foreach}
    </tr>
    {foreach from=$baitaiCpaList item="list" key="baitaiName" name="loop"}
    <tr>
        <td>{$mediaCdNameList.$baitaiName}</td>
        <td>{$baitaiName}</td>
        {foreach from=$list item="cpaVal" key="cpaKey" name="loop"}
            <td>{$cpaVal|default:0}</td>
        {/foreach}
        <td>{$cpaTotalForMediaCd.$baitaiName|default:0}円</td>
    </tr>
    {/foreach}
    <tr class="BgColor02">
        <td colspan="2"><center><b>月間合計</b></center></td>
        {foreach from=$cpaTotalForMonthly item="cpaMonthTotalMonth" key="cpaMonthly" name="loop"}
            <td>{$cpaMonthTotalMonth|default:0}円</td>
        {/foreach}
        <td>{$cpaTotal}円</td>
    </tr>
</table>
<br>
<table cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td>
            <span style="color:#FF0000;font-size:20px;"><b>{$roiTitle}</b></span><br>
        </td>
    </tr>
    <tr>
        <td align="center">
            <span style="color:#00F;font-size:24px;">ROI(%)Return On Investment（入金額/広告費）</span>
        </td>
    </tr>
</table>
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th rowspan="2"><b>媒体名</b></th>
        <th rowspan="2"><b>広告コード</b></th>
        <th colspan="{$dispMonthAdvertiseExpensesCount}"><center><b>ROI算出月</b></center></th>
        <th rowspan="2"><b>媒体別入金合計</b></th>
    </tr>
    <tr>
        {foreach from=$dispMonthAdvertiseExpenses item="val" key="key" name="loop"}
            <th><b>{$val}</b></th>
        {/foreach}
    </tr>
    {foreach from=$baitaiRoiList item="list" key="baitaiName" name="loop"}
    <tr>
        <td>{$mediaCdNameList.$baitaiName}</td>
        <td>{$baitaiName}</td>
        {foreach from=$list item="roiVal" key="roiKey" name="loop"}
            <td>{$roiVal|default:0}%</td>
        {/foreach}
        <td>{$roiTotalForMediaCd.$baitaiName|default:0}%</td>
    </tr>
    {/foreach}
    <tr class="BgColor02">
        <td colspan="2"><center><b>月間合計</b></center></td>
        {foreach from=$roiTotalForMonthly item="roiMonthTotalMonth" key="roiMonthly" name="loop"}
            <td>{$roiMonthTotalMonth|default:0}%</td>
        {/foreach}
        <td>{$roiTotal}%</td>
    </tr>
</table>

