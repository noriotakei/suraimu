<script language="JavaScript">
<!--
    $(function() {ldelim}
        {* テーブルストライプ *}
        $("#table tr:even").addClass("BgColor02");
    {rdelim});
// -->
</script>

{*<h2 class="ContentTitle"><font color="red">{$registTitle}&nbsp;{$payTitle}&nbsp;{$preRegistTitle}</font></h2>*}

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
            <span style="color:#FF0000;font-size:20px;"><b>{$title}</b></span>
        </td>
        <td>&nbsp;&nbsp;</td>
    </tr>
</table>
<table cellspacing="0" cellpadding="0" class="TableSet04" id="table" align="center">
    <tr>
        <th>媒体名</th>
        <th>広告コード</th>
        <th>仮登録者数</th>
        <th>本登録者数</th>
        <th>退会者数</th>
        <th>入金額</th>
        <th>入金者数</th>
        <th>アクセス数</th>
    </tr>
    {if $totalCountList}
    {foreach from=$totalCountList key="key" item="val" name="loop"}
    <tr>
        <td>{$val.media_name}</td>
        <td>{$key}</td>
        <td>{$val.pre_regist_count}</td>
        <td>{$val.regist_count}</td>
        <td>{$val.quit_count}</td>
        <td>{$val.trade_amount}</td>
        <td>{$val.trade_user_count}</td>
        <td>{$val.access_count}</td>
    </tr>
    {/foreach}
    {/if}
    <tr class="BgColor02">
        <td colspan="2"><center><b>合計</b></center></td>
        <td>{$preRegistTotalForMediaCd.pre_regist_count|default:0}人</td>
        <td>{$registTotalForMediaCd.regist_count|default:0}人</td>
        <td>{$quitTotalForMediaCd.quit_count|default:0}人</td>
        <td>{$payTotalForMediaCd.trade_amount|default:0}円</td>
        <td>{$payUserTotalForMediaCd.trade_user_count|default:0}人</td>
        <td>{$accessTotalForMediaCd.access_count|default:0}回</td>
    </tr>
</table>
