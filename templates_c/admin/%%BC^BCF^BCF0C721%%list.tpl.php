<?php /* Smarty version 2.6.26, created on 2015-01-13 18:07:43
         compiled from /home/suraimu/templates/admin/user/list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/user/list.tpl', 14, false),array('modifier', 'implode', '/home/suraimu/templates/admin/user/list.tpl', 20, false),array('modifier', 'default', '/home/suraimu/templates/admin/user/list.tpl', 154, false),array('modifier', 'zend_date_format', '/home/suraimu/templates/admin/user/list.tpl', 154, false),array('modifier', 'cat', '/home/suraimu/templates/admin/user/list.tpl', 267, false),array('function', 'make_link', '/home/suraimu/templates/admin/user/list.tpl', 57, false),array('function', 'html_options', '/home/suraimu/templates/admin/user/list.tpl', 60, false),array('function', 'cycle', '/home/suraimu/templates/admin/user/list.tpl', 265, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" href="./css/pager.css" rel="stylesheet" />
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
<style type="text/css">
.watermark {
   color: #999;
}
</style>
</head>
<body>
<div id="ContentsCol">
    <h2 class="ContentTitle">ユーザー一覧</h2>
        <?php if (count($this->_tpl_vars['msg'])): ?>
        <div class="warning ui-widget">
        <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;width: 400px;">
        <p>
        <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
        <?php $_from = $this->_tpl_vars['msg']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
            <?php echo implode($this->_tpl_vars['val'], "<br>"); ?>

        <?php endforeach; endif; unset($_from); ?>
        </p>
        </div>
        </div>
    <?php endif; ?>
<form action="./" method="post">
<?php echo $this->_tpl_vars['POSTparam']; ?>

<div class="SubMenu">
    <input type="submit" value="検索へ戻る" name="action_User_Search"/>
</div>
</form>
<form action="./" method="post" target="_blank">
<?php echo $this->_tpl_vars['POSTparam']; ?>

<table border="0" width="80%">
    <tr>
    <td align="left" valign="top">
        <table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet04">
        <tr><th colspan="2" style="text-align:center;">検索条件</th></tr>
        <?php $_from = $this->_tpl_vars['whereContents']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
?>
            <tr>
            <th><?php echo $this->_tpl_vars['key']; ?>
</th>
            <td><?php echo $this->_tpl_vars['val']; ?>
</td>
            </tr>
        <?php endforeach; endif; unset($_from); ?>
                <?php if ($this->_tpl_vars['cnvType']): ?>
            <tr>
            <th>競馬間コンバート対象客</th>
            <td><?php echo $this->_tpl_vars['cnvType']; ?>
</td>
            </tr>
        <?php endif; ?>
                <?php if (! ( $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_INFORMATION'] || $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_ADVERTISING'] || $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SHUKEI'] )): ?>
            <tr>
            <th>検索条件保存<br>(更新ならIDを入力)<br><a href="<?php echo smarty_function_make_link(array('action' => 'action_user_SearchConditionList'), $this);?>
" target="_blank">検索条件保存リスト</a></th>
            <td>
                更新する検索条件保存ID：<input type="text" size="7" value="<?php echo $this->_tpl_vars['searchConditionReturn']['search_conditions_id']; ?>
" name="search_conditions_id" id="searchConditionsId" style="ime-mode:disabled;"><br>
                <?php echo smarty_function_html_options(array('name' => 'search_conditions_category_id','options' => $this->_tpl_vars['categoryList'],'selected' => $this->_tpl_vars['searchConditionReturn']['search_conditions_category_id']), $this);?>

                <br><input type="text" size="20" name="comment" id="comment" value="<?php echo $this->_tpl_vars['searchConditionReturn']['comment']; ?>
">
                <br>更新禁止  <?php echo smarty_function_html_options(array('name' => 'update_permission','options' => $this->_tpl_vars['update_permission'],'selected' => $this->_tpl_vars['param']['update_permission']), $this);?>


<?php if (! $this->_tpl_vars['update_permission_flag']): ?>
                <input type="submit" value="検索条件保存" name="action_user_SearchSaveExec"  onclick="return confirm('現在の検索条件を保存しますか？');"/>
<?php endif; ?>
            </td>
            </tr>
        <?php endif; ?>
        </table>

                <?php if (! ( $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_INFORMATION'] || $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_ADVERTISING'] || $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SHUKEI'] )): ?>
            <br>
            <table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet04">
                <tr><th colspan="2" style="text-align:center;">ﾌﾘｰﾜｰﾄﾞ削除<br>-%free_word_(TYPE)_(CD)-</th></tr>
                <tr>
                    <td>
                        TYPE：&nbsp;<?php echo smarty_function_html_options(array('name' => 'free_word_type','options' => $this->_tpl_vars['freeWordType']), $this);?>

                    </td>
                </tr>
                <tr>
                    <td>
                        CD：&nbsp;<?php echo smarty_function_html_options(array('name' => 'free_word_cd','options' => $this->_tpl_vars['freeWordCd']), $this);?>

                    </td>
                </tr>
                <tr>
                    <td style="text-align:center;">
                        <input type="submit" value="削除" name="action_user_FreeWordDeleteExec"  onclick="return confirm('ﾌﾘｰﾜｰﾄﾞ削除致しますか？');"/>
                    </td>
                </tr>
            </table>
        <?php endif; ?>

                <?php if (! ( $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_INFORMATION'] || $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_ADVERTISING'] || $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SHUKEI'] )): ?>
            <br>
            <table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet04">
                <tr><th colspan="2" style="text-align:center;">ユーザー識別フラグ</th></tr>
                <tr>
                    <td>
                        TYPE：&nbsp;<?php echo smarty_function_html_options(array('name' => 'user_profile_flag_code_update','options' => $this->_tpl_vars['user_profile_flag_code']), $this);?>

                    </td>
                </tr>
                <tr>
                    <td style="text-align:center;">
                        <input type="submit" value="更新" name="action_user_UpdateUserProfileFlagExec"  onclick="return confirm('ユーザー識別フラグを変更致しますか？');"/>
                    </td>
                </tr>
            </table>
        <?php endif; ?>
    </td>
        <?php if (! ( $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_INFORMATION'] || $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_ADVERTISING'] || $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SHUKEI'] )): ?>
        <td align="left" valign="top">
            <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
            <tr><th style="text-align:center;">メルマガ条件更新</th></tr>
            <tr>
                <td>
                更新する予約メルマガID<br>(カンマ区切りで複数可)：<br><input type="text" size="15" value="<?php echo $this->_tpl_vars['mailMagaReserveId']; ?>
" name="mail_maga_reserve_id" id="mailMagaReserveId" style="ime-mode:disabled;">
                <input type="submit" value="予約メルマガ条件更新" name="action_mail_ReserveSearchSaveExec"  onclick="return confirm('現在の検索条件を予約メルマガ条件に更新しますか？');"/>
                </td>
            </tr>
            <tr>
                <td>
                更新する定期メルマガID<br>(カンマ区切りで複数可)：<br><input type="text" size="15" value="<?php echo $this->_tpl_vars['mailMagaRegularId']; ?>
" name="mail_maga_regular_id" id="mailMagaRegularId" style="ime-mode:disabled;">
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
                         <input class="datepicker" size="15" type="text" value="<?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['param']['dispDatetimeFrom'])) ? $this->_run_mod_handler('default', true, $_tmp, time()) : smarty_modifier_default($_tmp, time())))) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="disp_date"maxlength="10">&nbsp;<input name="disp_time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['dispDatetimeFrom'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10"maxlength="8">
                    </td>
                </tr>
            </table>
            <br>
            <table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet04">
                <tr><th colspan="2" style="text-align:center;">一括月額コース付与(コースのみの付与)</th></tr>
                <tr>
                    <td>
                        月額コース：&nbsp;<?php echo smarty_function_html_options(array('name' => 'monthly_course','options' => $this->_tpl_vars['monthlyCourseList'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['searchConditionReturn']['monthly_course'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))), $this);?>

                    </td>
                </tr>
                <tr>
                    <td>
                        月額コース有効日数：&nbsp;<input type="text" size="7" value="<?php echo $this->_tpl_vars['searchConditionReturn']['monthly_course_days']; ?>
" name="monthly_course_days" id="" style="ime-mode:disabled;">&nbsp;日
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
                        PC：&nbsp;<?php echo smarty_function_html_options(array('name' => 'is_pc_reverse','options' => $this->_tpl_vars['isPcReverse'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['searchConditionReturn']['is_pc_reverse'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))), $this);?>

                    </td>
                </tr>
                <tr>
                    <td>
                        MB：&nbsp;<?php echo smarty_function_html_options(array('name' => 'is_mb_reverse','options' => $this->_tpl_vars['isMbReverse'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['searchConditionReturn']['is_mb_reverse'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))), $this);?>

                    </td>
                </tr>
                <tr>
                    <td style="text-align:center;">
                        <input type="submit" value="設定" name="action_user_ReverseMailSettingExec"  onclick="return confirm('強行メール設定しますか？');"/>
                    </td>
                </tr>
            </table>
        </td>
    <?php endif; ?>
    </tr>
</table>
</form>
<br>
<hr>
<?php if ($this->_tpl_vars['userList']): ?>
    <div style="padding-bottom: 10px;">
    件数：<?php echo $this->_tpl_vars['totalCount']; ?>
件<br />
    <?php echo $this->_tpl_vars['dispFirst']; ?>
～<?php echo $this->_tpl_vars['dispLast']; ?>
件表示しています
    </div>
<?php endif; ?>
<?php if ($this->_tpl_vars['pager']): ?>
<ul class="pager">
    <li><?php echo $this->_tpl_vars['pager']['previous']; ?>
</li>
    <li><?php echo implode($this->_tpl_vars['pager']['pages'], "</li><li>"); ?>
</li>
    <li><?php echo $this->_tpl_vars['pager']['next']; ?>
</li>
</ul>
<?php endif; ?>
<?php if (! ( $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_ADVERTISING'] || $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SHUKEI'] )): ?>
    <form action="./" method="post">
        <?php echo $this->_tpl_vars['POSTparam']; ?>

                <div class="SubMenu">
            <?php if ($this->_tpl_vars['totalCount'] < 100000): ?><input type="submit" value="メルマガ作成" name="action_mail_MailInput"/><?php endif; ?>
            <?php if ($this->_tpl_vars['userList']): ?><input type="submit" value="ユニット作成" name="action_unit_UnitCreate"/><?php endif; ?>
            <?php if ($this->_tpl_vars['userList']): ?><input type="submit" value="抽選ユニット作成" name="action_lotteryUnit_UnitCreate"/><?php endif; ?>
            <?php if ($this->_tpl_vars['userList']): ?><input type="submit" value="抽選ユニット作成(賞品名入力)" name="action_lotteryUnitPrize_UnitCreate"/><?php endif; ?>
        </div>
        <div class="SubMenu">
            <?php if ($this->_tpl_vars['loginAdminData']['authority_type'] != $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_DESIGN']): ?>
                <?php if ($this->_tpl_vars['userList']): ?><input type="submit" value="振込先銀行口座CSV出力" name="action_user_BankCsvExec"/><?php endif; ?>
            <?php endif; ?>
                        <?php if ($this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SYSTEM'] || $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_MANAGE']): ?>
                <?php if ($this->_tpl_vars['userList']): ?><input type="submit" value="住所CSV出力" name="action_user_AddressCsvExec"/><?php endif; ?>
                <?php if ($this->_tpl_vars['userList']): ?><input type="submit" value="年齢・男女・ログインＩＤCSV出力" name="action_user_UserStatusCsvExec"/><?php endif; ?>
                <?php if ($this->_tpl_vars['userList']): ?><input type="submit" value="年齢・男女・MBアドレス・PCアドレス出力" name="action_user_UserStatusCsvExec2"/><?php endif; ?>
                <?php if ($this->_tpl_vars['userList']): ?><input type="submit" value="貢献金額CSV出力" name="action_user_payAmountCsvExec"/><?php endif; ?>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SYSTEM']): ?>
                <?php if ($this->_tpl_vars['userList']): ?>
                    <input type="submit" value="コンバートCSV出力" name="action_user_convertCsvExec"/>
                    <input type="hidden" name="regist_page_id" value="<?php echo $this->_tpl_vars['convertList']['regist_page_id']; ?>
">
                    <input type="hidden" name="media_cd" value="<?php echo $this->_tpl_vars['convertList']['media_cd']; ?>
">
                <?php endif; ?>

            <?php endif; ?>
        </div>
    </form>
<?php endif; ?>
<?php if ($this->_tpl_vars['userList']): ?>
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
    <?php $_from = $this->_tpl_vars['userList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
    <?php echo smarty_function_cycle(array('values' => ", class=\"BgColor02\"",'assign' => 'style'), $this);?>

        <tr <?php echo $this->_tpl_vars['style']; ?>
>
            <td><a href="<?php echo smarty_function_make_link(array('action' => 'action_User_Detail','getTags' => ((is_array($_tmp="user_id=")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['val']['user_id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['val']['user_id']))), $this);?>
" target="_blank">変更</a></td>
            <td><?php echo $this->_tpl_vars['val']['user_id']; ?>
</td>
            <td><?php echo $this->_tpl_vars['config']['admin_config']['regist_status'][$this->_tpl_vars['val']['regist_status']]; ?>
</td>
            <td><?php echo $this->_tpl_vars['config']['admin_config']['sex_cd'][$this->_tpl_vars['val']['sex_cd']]; ?>
</td>
            <td><?php echo $this->_tpl_vars['val']['last_access_datetime']; ?>
</td>
            <td><?php echo $this->_tpl_vars['val']['pre_regist_datetime']; ?>
</td>
            <td><?php echo $this->_tpl_vars['val']['regist_datetime']; ?>
</td>
            <td><a href="<?php echo $this->_tpl_vars['config']['define']['SITE_URL']; ?>
?action_Home=1&<?php echo $this->_tpl_vars['accessKeyName']; ?>
=<?php echo $this->_tpl_vars['val']['access_key']; ?>
" target="_blank">PCログイン</a><br>
                    <a href="<?php echo $this->_tpl_vars['config']['define']['SITE_URL_MOBILE']; ?>
?action_Home=1&<?php echo $this->_tpl_vars['accessKeyName']; ?>
=<?php echo $this->_tpl_vars['val']['access_key']; ?>
" target="_blank">MBログイン</a></td>
            <td><a href="<?php echo smarty_function_make_link(array('action' => 'action_user_LogList','getTags' => ((is_array($_tmp="user_id=")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['val']['user_id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['val']['user_id']))), $this);?>
" target="_blank">各種ログ</a></td>
        </tr>
    <?php endforeach; endif; unset($_from); ?>
    </table>
<?php else: ?>
    <div class="warning ui-widget">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    <p>
    <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    該当データはありません
    </p>
    </div>
<?php endif; ?>
<br />
<?php if ($this->_tpl_vars['userList']): ?>
    <div style="padding-bottom: 10px;">
    件数：<?php echo $this->_tpl_vars['totalCount']; ?>
件<br />
    <?php echo $this->_tpl_vars['dispFirst']; ?>
～<?php echo $this->_tpl_vars['dispLast']; ?>
件表示しています
    </div>
<?php endif; ?>
<?php if ($this->_tpl_vars['pager']): ?>
<ul class="pager">
    <li><?php echo $this->_tpl_vars['pager']['previous']; ?>
</li>
    <li><?php echo implode($this->_tpl_vars['pager']['pages'], "</li><li>"); ?>
</li>
    <li><?php echo $this->_tpl_vars['pager']['next']; ?>
</li>
</ul>
<?php endif; ?>
<br />
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admFooter'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script type="text/javascript" src="./js/watermark/jquery.watermark.min.js"></script>
<script type="text/javascript" src="./js/jquery.timepickr.min.js"></script>
<script language="JavaScript">
<!--
    $(function() {
                $('#list_table').colorize({
            altColor :'#CCCCCC',
            hiliteColor :'none'
        });

                $('#comment').watermark('保存名を入力');

        $(".time").timepickr({
            format24: "{h:02.d}:{m:02.d}:{s:02.d}",
            seconds: true,
            rangeMin: ["00","05","10","15","20","25","30","35","40","45","50","55","59"],
            rangeSec: ["00","15","30","45","59"],
            convention: 24
        });

        $(".datepicker").datepicker({
            numberOfMonths: 2,
            showButtonPanel: true,
            dateFormat: "yy-mm-dd"
        });

        $('#list_table').colorize({
            altColor :'#CCCCCC',
            hiliteColor :'none'
        });
    });
// -->
</script>
</body>
</html>