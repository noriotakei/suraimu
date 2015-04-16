{include file=$admHeader}
<link type="text/css" href="./css/pager.css" rel="stylesheet" />
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
<style type="text/css">
.watermark {ldelim}
   color: #999;
{rdelim}
</style>
</head>
<body>
<div id="ContentsCol">
    <h2 class="ContentTitle">ユーザー一覧</h2>
    {* メッセージ *}
    {if $msg|@count}
        <div class="warning ui-widget">
        <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;width: 400px;">
        <p>
        <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
        { foreach from=$msg item="val" }
            {$val|@implode:"<br>"}
        {/foreach}
        </p>
        </div>
        </div>
    {/if}
<form action="./" method="post">
{$POSTparam}
<div class="SubMenu">
    <input type="submit" value="検索へ戻る" name="action_User_Search"/>
</div>
</form>
<form action="./" method="post" target="_blank">
{$POSTparam}
<table border="0" width="80%">
    <tr>
    <td align="left" valign="top">
        <table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet04">
        <tr><th colspan="2" style="text-align:center;">検索条件</th></tr>
        {foreach from=$whereContents item="val" key="key"}
            <tr>
            <th>{$key}</th>
            <td>{$val}</td>
            </tr>
        {/foreach}
        {* 競馬間コンバート用 *}
        {if $cnvType}
            <tr>
            <th>競馬間コンバート対象客</th>
            <td>{$cnvType}</td>
            </tr>
        {/if}
        {* info 広告 集計以外*}
        {if !($loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_INFORMATION
            OR $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_ADVERTISING
            OR $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SHUKEI)}
            <tr>
            <th>検索条件保存<br>(更新ならIDを入力)<br><a href="{make_link action="action_user_SearchConditionList"}" target="_blank">検索条件保存リスト</a></th>
            <td>
                更新する検索条件保存ID：<input type="text" size="7" value="{$searchConditionReturn.search_conditions_id}" name="search_conditions_id" id="searchConditionsId" style="ime-mode:disabled;"><br>
                {html_options name="search_conditions_category_id" options=$categoryList selected=$searchConditionReturn.search_conditions_category_id}
                <br><input type="text" size="20" name="comment" id="comment" value="{$searchConditionReturn.comment}">
                <br>更新禁止  {html_options name="update_permission" options=$update_permission selected=$param.update_permission}

{if !$update_permission_flag}
                <input type="submit" value="検索条件保存" name="action_user_SearchSaveExec"  onclick="return confirm('現在の検索条件を保存しますか？');"/>
{/if}
            </td>
            </tr>
        {/if}
        </table>

        {* info 広告 集計以外*}
        {if !($loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_INFORMATION
            OR $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_ADVERTISING
            OR $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SHUKEI)}
            <br>
            <table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet04">
                <tr><th colspan="2" style="text-align:center;">ﾌﾘｰﾜｰﾄﾞ削除<br>-%free_word_(TYPE)_(CD)-</th></tr>
                <tr>
                    <td>
                        TYPE：&nbsp;{html_options name="free_word_type" options=$freeWordType}
                    </td>
                </tr>
                <tr>
                    <td>
                        CD：&nbsp;{html_options name="free_word_cd" options=$freeWordCd}
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center;">
                        <input type="submit" value="削除" name="action_user_FreeWordDeleteExec"  onclick="return confirm('ﾌﾘｰﾜｰﾄﾞ削除致しますか？');"/>
                    </td>
                </tr>
            </table>
        {/if}

        {* info ユーザー識別フラグ*}
        {if !($loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_INFORMATION
            OR $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_ADVERTISING
            OR $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SHUKEI)}
            <br>
            <table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet04">
                <tr><th colspan="2" style="text-align:center;">ユーザー識別フラグ</th></tr>
                <tr>
                    <td>
                        TYPE：&nbsp;{html_options name="user_profile_flag_code_update" options=$user_profile_flag_code}
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center;">
                        <input type="submit" value="更新" name="action_user_UpdateUserProfileFlagExec"  onclick="return confirm('ユーザー識別フラグを変更致しますか？');"/>
                    </td>
                </tr>
            </table>
        {/if}
    </td>
    {* info 広告 集計以外*}
    {if !($loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_INFORMATION
        OR $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_ADVERTISING
        OR $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SHUKEI)}
        <td align="left" valign="top">
            <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
            <tr><th style="text-align:center;">メルマガ条件更新</th></tr>
            <tr>
                <td>
                更新する予約メルマガID<br>(カンマ区切りで複数可)：<br><input type="text" size="15" value="{$mailMagaReserveId}" name="mail_maga_reserve_id" id="mailMagaReserveId" style="ime-mode:disabled;">
                <input type="submit" value="予約メルマガ条件更新" name="action_mail_ReserveSearchSaveExec"  onclick="return confirm('現在の検索条件を予約メルマガ条件に更新しますか？');"/>
                </td>
            </tr>
            <tr>
                <td>
                更新する定期メルマガID<br>(カンマ区切りで複数可)：<br><input type="text" size="15" value="{$mailMagaRegularId}" name="mail_maga_regular_id" id="mailMagaRegularId" style="ime-mode:disabled;">
                <input type="submit" value="定期メルマガ条件更新" name="action_mail_RegularSearchSaveExec"  onclick="return confirm('現在の検索条件を定期メルマガ条件に更新しますか？');"/>
                </td>
            </tr>
            </table>
            <br>
            <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
                <tr><th style="text-align:center;">ポイントばらまき/回収<br>(回収の場合はマイナス値を入力)</th></tr>
                <tr>
                    <td>
                        <input type="text" size="5" name="point" id="point" style="ime-mode:disabled;text-align:right;"> pt
                        <input type="submit" value="ポイントばらまき/回収" name="action_user_PointGrantExec"  onclick="return confirm('ポイントをばらまき/回収ますか？');"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" size="5" name="auto_point" id="auto_point" style="ime-mode:disabled;text-align:right;"> pt
                        <input type="submit" value="自動ポイントばらまき/回収" name="action_user_autoPointGrantExec"  onclick="return confirm('自動ポイントばらまき/回収ますか？');"/>
                    </td>
                </tr>
                <tr>
                    <td>
                         <input class="datepicker" size="15" type="text" value="{$param.dispDatetimeFrom|default:$smarty.now|zend_date_format:'yyyy-MM-dd'}" name="disp_date"maxlength="10">&nbsp;<input name="disp_time" class="time" type="text" value="{$param.dispDatetimeFrom|zend_date_format:'HH:mm:ss'}" size="10"maxlength="8">
                    </td>
                </tr>
            </table>
            <br>
            <table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet04">
                <tr><th colspan="2" style="text-align:center;">一括月額コース付与(コースのみの付与)</th></tr>
                <tr>
                    <td>
                        月額コース：&nbsp;{html_options name="monthly_course" options=$monthlyCourseList selected=$searchConditionReturn.monthly_course|default:0}
                    </td>
                </tr>
                <tr>
                    <td>
                        月額コース有効日数：&nbsp;<input type="text" size="7" value="{$searchConditionReturn.monthly_course_days}" name="monthly_course_days" id="" style="ime-mode:disabled;">&nbsp;日
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center;">

                        <input type="submit" value="月額コース付与" name="action_user_BatchMonthlyCourseUserExec"  onclick="return confirm('月額コース付与しますか？');"/>
                    </td>
                </tr>
            </table>
            <br>
            <table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet04">
                <tr><th colspan="2" style="text-align:center;">強行メール設定</th></tr>
                <tr>
                    <td>
                        PC：&nbsp;{html_options name="is_pc_reverse" options=$isPcReverse selected=$searchConditionReturn.is_pc_reverse|default:0}
                    </td>
                </tr>
                <tr>
                    <td>
                        MB：&nbsp;{html_options name="is_mb_reverse" options=$isMbReverse selected=$searchConditionReturn.is_mb_reverse|default:0}
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center;">
                        <input type="submit" value="設定" name="action_user_ReverseMailSettingExec"  onclick="return confirm('強行メール設定しますか？');"/>
                    </td>
                </tr>
            </table>
        </td>
    {/if}
    </tr>
</table>
</form>
<br>
<hr>
{if $userList}
    <div style="padding-bottom: 10px;">
    件数：{$totalCount}件<br />
    {$dispFirst}～{$dispLast}件表示しています
    </div>
{/if}
{if $pager}
<ul class="pager">
    <li>{$pager.previous}</li>
    <li>{$pager.pages|@implode:"</li><li>"}</li>
    <li>{$pager.next}</li>
</ul>
{/if}
{* 広告 集計以外*}
{if !($loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_ADVERTISING
    OR $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SHUKEI)}
    <form action="./" method="post">
        {$POSTparam}
        {* メルマガは10万件以上は送信不可*}
        <div class="SubMenu">
            {if $totalCount < 100000}<input type="submit" value="メルマガ作成" name="action_mail_MailInput"/>{/if}
            {if $userList}<input type="submit" value="ユニット作成" name="action_unit_UnitCreate"/>{/if}
            {if $userList}<input type="submit" value="抽選ユニット作成" name="action_lotteryUnit_UnitCreate"/>{/if}
            {if $userList}<input type="submit" value="抽選ユニット作成(賞品名入力)" name="action_lotteryUnitPrize_UnitCreate"/>{/if}
        </div>
        <div class="SubMenu">
            {if $loginAdminData.authority_type != $config.define.AUTHORITY_TYPE_DESIGN}
                {if $userList}<input type="submit" value="振込先銀行口座CSV出力" name="action_user_BankCsvExec"/>{/if}
            {/if}
            {* -20100908-takuro 管理者権限+システム *}
            {if $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SYSTEM OR $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_MANAGE}
                {if $userList}<input type="submit" value="住所CSV出力" name="action_user_AddressCsvExec"/>{/if}
                {if $userList}<input type="submit" value="年齢・男女・ログインＩＤCSV出力" name="action_user_UserStatusCsvExec"/>{/if}
                {if $userList}<input type="submit" value="年齢・男女・MBアドレス・PCアドレス出力" name="action_user_UserStatusCsvExec2"/>{/if}
                {if $userList}<input type="submit" value="貢献金額CSV出力" name="action_user_payAmountCsvExec"/>{/if}
            {/if}
            {if $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SYSTEM}
                {if $userList}
                    <input type="submit" value="コンバートCSV出力" name="action_user_convertCsvExec"/>
                    <input type="hidden" name="regist_page_id" value="{$convertList.regist_page_id}">
                    <input type="hidden" name="media_cd" value="{$convertList.media_cd}">
                {/if}

            {/if}
        </div>
    </form>
{/if}
{if $userList}
    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">
    <tr>
        <th></th>
        <th>ユーザーID</th>
        <th>登録状態</th>
        <th>性別</th>
        <th>アクセス日時</th>
        <th>仮登録日時</th>
        <th>登録日時</th>
        <th>ログイン</th>
        <th>各種ログ</th>
    </tr>
    {foreach from=$userList item="val"}
    {cycle values=", class=\"BgColor02\"" assign="style"}
        <tr {$style}>
            <td><a href="{make_link action="action_User_Detail" getTags="user_id="|cat:$val.user_id}" target="_blank">変更</a></td>
            <td>{$val.user_id}</td>
            <td>{$config.admin_config.regist_status[$val.regist_status]}</td>
            <td>{$config.admin_config.sex_cd[$val.sex_cd]}</td>
            <td>{$val.last_access_datetime}</td>
            <td>{$val.pre_regist_datetime}</td>
            <td>{$val.regist_datetime}</td>
            <td><a href="{$config.define.SITE_URL}?action_Home=1&{$accessKeyName}={$val.access_key}" target="_blank">PCログイン</a><br>
                    <a href="{$config.define.SITE_URL_MOBILE}?action_Home=1&{$accessKeyName}={$val.access_key}" target="_blank">MBログイン</a></td>
            <td><a href="{make_link action="action_user_LogList" getTags="user_id="|cat:$val.user_id}" target="_blank">各種ログ</a></td>
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
<br />
{if $userList}
    <div style="padding-bottom: 10px;">
    件数：{$totalCount}件<br />
    {$dispFirst}～{$dispLast}件表示しています
    </div>
{/if}
{if $pager}
<ul class="pager">
    <li>{$pager.previous}</li>
    <li>{$pager.pages|@implode:"</li><li>"}</li>
    <li>{$pager.next}</li>
</ul>
{/if}
<br />
{include file=$admFooter}
</div>
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script type="text/javascript" src="./js/watermark/jquery.watermark.min.js"></script>
<script type="text/javascript" src="./js/jquery.timepickr.min.js"></script>
<script language="JavaScript">
<!--
    $(function() {ldelim}
        {* テーブルマウスオーバーカラー *}
        $('#list_table').colorize({ldelim}
            altColor :'#CCCCCC',
            hiliteColor :'none'
        {rdelim});

        {* テキストボックス文字 *}
        $('#comment').watermark('保存名を入力');

        $(".time").timepickr({ldelim}
            format24: "{ldelim}h:02.d{rdelim}:{ldelim}m:02.d{rdelim}:{ldelim}s:02.d{rdelim}",
            seconds: true,
            rangeMin: ["00","05","10","15","20","25","30","35","40","45","50","55","59"],
            rangeSec: ["00","15","30","45","59"],
            convention: 24
        {rdelim});

        $(".datepicker").datepicker({ldelim}
            numberOfMonths: 2,
            showButtonPanel: true,
            dateFormat: "yy-mm-dd"
        {rdelim});

        $('#list_table').colorize({ldelim}
            altColor :'#CCCCCC',
            hiliteColor :'none'
        {rdelim});
    {rdelim});
// -->
</script>
</body>
</html>
