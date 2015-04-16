<?php /* Smarty version 2.6.26, created on 2014-10-25 12:13:20
         compiled from /home/suraimu/templates/admin/monthlyCourse/courseUserSearchList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/monthlyCourse/courseUserSearchList.tpl', 13, false),array('modifier', 'implode', '/home/suraimu/templates/admin/monthlyCourse/courseUserSearchList.tpl', 19, false),array('modifier', 'zend_date_format', '/home/suraimu/templates/admin/monthlyCourse/courseUserSearchList.tpl', 65, false),array('modifier', 'default', '/home/suraimu/templates/admin/monthlyCourse/courseUserSearchList.tpl', 72, false),array('modifier', 'cat', '/home/suraimu/templates/admin/monthlyCourse/courseUserSearchList.tpl', 151, false),array('function', 'html_radios', '/home/suraimu/templates/admin/monthlyCourse/courseUserSearchList.tpl', 35, false),array('function', 'html_options', '/home/suraimu/templates/admin/monthlyCourse/courseUserSearchList.tpl', 41, false),array('function', 'make_link', '/home/suraimu/templates/admin/monthlyCourse/courseUserSearchList.tpl', 151, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
<link type="text/css" href="./css/pager.css" rel="stylesheet" />
<style type="text/css">
.watermark {
   color: #999;
}
</style>
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">月額コースユーザー一覧</h2>
<?php if (count($this->_tpl_vars['execMsg'])): ?>
    <div class="warning ui-widget">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    <p>
    <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    <?php $_from = $this->_tpl_vars['execMsg']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
        <?php echo implode($this->_tpl_vars['val'], "<br>"); ?>

    <?php endforeach; endif; unset($_from); ?>
    </p>
    </div>
    </div>
    <br>
<?php endif; ?>
<br>
<form action="./" method="post" name="userSearch">
    <table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet01" width="95%">
        <tr>
        <th colspan="2" style="text-align: center; font-weight: bold;">月額コースユーザー検索</th>
        </tr>
        <tr>
            <td>ユーザーID<br>(カンマ区切りで複数可)</td>
            <td style="text-align: left;">
                <input type="text" name="search_user_id" value="<?php echo $this->_tpl_vars['param']['search_user_id']; ?>
" size="30" style="ime-mode:disabled">&nbsp;&nbsp;<?php echo smarty_function_html_radios(array('id' => 'user_id_type','name' => 'user_id_type','options' => $this->_tpl_vars['config']['admin_config']['specify_target_select'],'selected' => $this->_tpl_vars['param']['search_user_id_type'],'separator' => "&nbsp;"), $this);?>

            </td>
        </tr>
        <tr>
            <td>月額コース名</td>
            <td style="text-align: left;">
                <?php echo smarty_function_html_options(array('name' => 'monthly_course_name','options' => $this->_tpl_vars['monthlyCourseListSelectArray'],'selected' => $this->_tpl_vars['param']['monthly_course_name']), $this);?>

            </td>
        </tr>
        <tr>
            <td>付与月額コースID<br>(カンマ区切りで複数可)</td>
            <td style="text-align: left;">
                <input type="text" name="search_monthly_course_id" value="<?php echo $this->_tpl_vars['param']['search_monthly_course_id']; ?>
" size="20" style="ime-mode:disabled;">&nbsp;&nbsp;<?php echo smarty_function_html_radios(array('id' => 'monthly_course_id_type','name' => 'monthly_course_id_type','options' => $this->_tpl_vars['config']['admin_config']['specify_target_select'],'selected' => $this->_tpl_vars['param']['monthly_course_id_type'],'separator' => "&nbsp;"), $this);?>

            </td>
        </tr>
        <tr>
            <td>月額コースグループ名</td>
            <td style="text-align: left;">
                <?php echo smarty_function_html_options(array('name' => 'monthly_course_group_id','options' => $this->_tpl_vars['monthlyCourseGroupeListSelectArray'],'selected' => $this->_tpl_vars['param']['monthly_course_group_id']), $this);?>

            </td>
        </tr>
        <tr>
            <td>月額コース更新タイプ</td>
            <td style="text-align: left;">
                <?php echo smarty_function_html_options(array('name' => 'create_type','options' => $this->_tpl_vars['monthlyCourseCreateTypeSelectArray'],'selected' => $this->_tpl_vars['param']['create_type']), $this);?>

            </td>
        </tr>
        <tr>
            <td>月額コース有効日付(開始日～終了日)</td>
            <td style="text-align: left;">
                <input name="monthly_course_start_date" size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['searchDatetimeFrom'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" maxlength="10">
                ～&nbsp;<input name="monthly_course_end_date" size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['searchDatetimeTo'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" maxlength="10">
            </td>
        </tr>
        <tr>
            <td>月額更新</td>
            <td style="text-align: left;">
                <?php echo smarty_function_html_radios(array('id' => 'specify_monthly_update','name' => 'specify_monthly_update','options' => $this->_tpl_vars['config']['admin_config']['specify_monthly_update_select'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['param']['specify_monthly_update'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)),'separator' => "&nbsp;"), $this);?>

            </td>
        </tr>
        <tr>
            <td>付与月額更新用商品ID<br>(カンマ区切りで複数可)</td>
            <td style="text-align: left;">
                <input type="text" name="monthly_update_item_id" value="<?php echo $this->_tpl_vars['param']['monthly_update_item_id']; ?>
" size="20" style="ime-mode:disabled;">&nbsp;&nbsp;<?php echo smarty_function_html_radios(array('id' => 'monthly_update_item_type','name' => 'monthly_update_item_type','options' => $this->_tpl_vars['config']['admin_config']['specify_target_select'],'selected' => $this->_tpl_vars['param']['monthly_update_item_type'],'separator' => "&nbsp;"), $this);?>

            </td>
        </tr>
        <tr>
            <td>作成タイプ</td>
            <td style="text-align: left;">
                <?php echo smarty_function_html_options(array('name' => 'admin_id','options' => $this->_tpl_vars['adminList'],'selected' => $this->_tpl_vars['param']['admin_id']), $this);?>

            </td>
        </tr>
        <tr>
            <td style="text-align:center;" colspan="2">
                <input type="hidden" name="search_flag" value="1">
                <input type="submit" name="action_monthlyCourse_CourseUserSearchList" value="検 索" style="width:8em;"/>
            </td>
        </tr>
    </table>
</form>
<br>
    <?php if ($this->_tpl_vars['monthlyCourseUserList']): ?>
        <div style="padding-bottom: 10px;">
        件数：<?php echo $this->_tpl_vars['totalCount']; ?>
件<br />
        <?php echo $this->_tpl_vars['dispFirst']; ?>
～<?php echo $this->_tpl_vars['dispLast']; ?>
件表示しています
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
        </div>

        <form action="./" method="post" style="margin:2px 0px;">
        <?php echo $this->_tpl_vars['searchParam']; ?>

        <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" >
            <tr>
                <th colspan="2" style="text-align: center; font-weight: bold;">月額コース一括操作</th>
            </tr>
            <tr>
                <td>操作内容</td>
                <td><?php echo smarty_function_html_options(array('name' => 'update_type','options' => $this->_tpl_vars['batchOperateMonthlyCourseUserSelectAry'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['param']['update_type'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)),'id' => 'update_type'), $this);?>

                    <div id="monthly_course_list" style="display:none;">
                        <?php echo smarty_function_html_options(array('name' => 'chg_monthly_course','options' => $this->_tpl_vars['batchMonthlyCourseList'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['param']['chg_monthly_course'])) ? $this->_run_mod_handler('default', true, $_tmp, 1) : smarty_modifier_default($_tmp, 1))), $this);?>
&nbsp;に変更
                    </div>
                    <div id="monthly_course_add_days" style="display:none;">
                        付与日数：&nbsp;<input type="text" name="monthly_course_add_days" value="<?php echo $this->_tpl_vars['param']['monthly_course_add_days']; ?>
" size="10" style="ime-mode:disabled;">
                    </div>
                </td>
            </tr>
            <tr>
                <td style="text-align:center;" colspan="2">
                    <input type="submit" name="action_monthlyCourse_CourseUserExec" value="更新" onClick="return confirm('更新しますか?')">
                </td>
            </tr>
        </table>
        <br>

        <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" id="list_table">
        <tr>
            <th>コース詳細</th>
            <th>ユーザーID</th>
            <th>月額コース名</th>
            <th>月額グループ名</th>
            <th>開始日</th>
            <th>終了日</th>
            <th>更新タイプ</th>
            <th>月額更新用商品名</th>
            <th>作成タイプ</th>
            <th>ユーザー詳細</th>
            <th><input type="checkbox" onclick="$('#list_table input:checkbox').attr('checked', this.checked);" ></th>

        </tr>
        <?php $_from = $this->_tpl_vars['monthlyCourseUserList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
        $this->_foreach['loop']['iteration']++;
?>
        <tr>
            <td align="center"><a href="<?php echo smarty_function_make_link(array('action' => 'action_monthlyCourse_CourseUserData','getTags' => ((is_array($_tmp=((is_array($_tmp="user_id=")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['val']['user_id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['val']['user_id'])))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['URLparam']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['URLparam']))), $this);?>
">詳細</a></td>
            <td align="center"><?php echo $this->_tpl_vars['val']['user_id']; ?>
</td>
            <td align="center"><?php echo $this->_tpl_vars['val']['course_name']; ?>
</td>
            <td align="center"><?php echo $this->_tpl_vars['val']['group_name']; ?>
</td>
            <td align="center"><?php echo $this->_tpl_vars['val']['limit_start_date']; ?>
</td>
            <td align="center"><?php echo $this->_tpl_vars['val']['limit_end_date']; ?>
</td>
            <td align="center"><?php echo $this->_tpl_vars['monthlyCourseCreateTypeSelectArray'][$this->_tpl_vars['val']['create_type']]; ?>
</td>
            <td align="center"><?php echo $this->_tpl_vars['val']['item_name']; ?>
</td>
            <td align="center"><?php echo $this->_tpl_vars['adminList'][$this->_tpl_vars['val']['admin_id']]; ?>
</td>
            <td align="center"><a href="<?php echo smarty_function_make_link(array('action' => 'action_User_Detail','getTags' => ((is_array($_tmp="user_id=")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['val']['user_id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['val']['user_id']))), $this);?>
" target="_blank">変更</a></td>
            <td style="text-align:center;"><input type="checkbox" name="check_mcuid[]" value="<?php echo $this->_tpl_vars['val']['id']; ?>
"></td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
        </table>
        </form>
        <br>
        <div style="padding-bottom: 10px;">
        件数：<?php echo $this->_tpl_vars['totalCount']; ?>
件<br />
        <?php echo $this->_tpl_vars['dispFirst']; ?>
～<?php echo $this->_tpl_vars['dispLast']; ?>
件表示しています
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
        </div>
    <?php elseif ($this->_tpl_vars['param']['search_flag']): ?>
        <div class="warning ui-widget">
        <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
        <p>
        <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
        該当データはありません
        </p>
        </div>
    <?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admFooter'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="./js/jquery.timepickr.min.js"></script>
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script type="text/javascript" src="./js/watermark/jquery.watermark.min.js"></script>
<script type="text/javascript" src="./js/userSearch.js"></script>
<script language="JavaScript">
<!--
    $(function() {

                $(".time").timepickr({
            format24: "{h:02.d}:{m:02.d}:{s:02.d}",
            seconds: true,
            rangeMin: ["00","05","10","15","20","25","30","35","40","45","50","55","59"],
            rangeSec: ["00","15","30","45","59"],
            convention: 24,
            resetOnBlur : false
        });

                $(".datepicker").datepicker({
            dateFormat: "yy-mm-dd"
        });

        $("#search_button").live("click", function(){
            $("#search_form").slideToggle("slow");
        });

                $("#src_table tr:even").addClass("BgColor02");

                $("#monthly_course_list").hide();
        $("#monthly_course_add_days").hide();

        var updateIdAry = Array('#update_type option:selected');
        for (var val in updateIdAry) {
            openMonthlyCourseSelect(updateIdAry[val]);
        }

                $('#update_type').change(function(){
        openMonthlyCourseSelect('#update_type option:selected');
        });

        // テキストボックス文字
        $('.from').watermark('例):10');
        $('.to').watermark('例):2');

        // 月額コース一括操作入力フォーム表示
        function openMonthlyCourseSelect(selectId) {

            var selectId = $(selectId);

            if (selectId.val() == 1) {
                $('#monthly_course_list').show("blind", "slow");
                $('#monthly_course_add_days').hide();
            } else if (selectId.val() == 4) {
                $('#monthly_course_list').hide();
                $('#monthly_course_add_days').show("blind", "slow");
            } else {
                $('#monthly_course_list').hide();
                $('#monthly_course_add_days').hide();
            }

        }

    });
// -->
</script>
</body>
</html>
