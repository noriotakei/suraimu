<?php /* Smarty version 2.6.26, created on 2014-08-08 17:20:02
         compiled from /home/suraimu/templates/admin/itemManagement/itemData.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/itemManagement/itemData.tpl', 66, false),array('modifier', 'implode', '/home/suraimu/templates/admin/itemManagement/itemData.tpl', 72, false),array('modifier', 'default', '/home/suraimu/templates/admin/itemManagement/itemData.tpl', 90, false),array('modifier', 'zend_date_format', '/home/suraimu/templates/admin/itemManagement/itemData.tpl', 144, false),array('function', 'html_options', '/home/suraimu/templates/admin/itemManagement/itemData.tpl', 133, false),array('function', 'make_link', '/home/suraimu/templates/admin/itemManagement/itemData.tpl', 204, false),array('function', 'html_radios', '/home/suraimu/templates/admin/itemManagement/itemData.tpl', 208, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
<script type="text/javascript" src="./js/jquery.timepickr.min.js"></script>
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<link type="text/css" href="./css/pager.css" rel="stylesheet" />

<script type="text/javascript">
<!--

    $(function() {
        $('.selectText').click(function(){
        $(this).select();
        });

                $(".time").timepickr({
            format24: "{h:02.d}:{m:02.d}:{s:02.d}",
            seconds: true,
            rangeMin: ["00","05","10","15","20","25","30","35","40","45","50","55","59"],
            rangeSec: ["00","15","30","45","59"],
            convention: 24
        });

                $(".datepicker").datepicker({
            dateFormat: "yy-mm-dd"
        });

                $("#monthly_course_plus_limit_date").hide();
        $("#monthly_update_item_id").hide();

        var openIdAry = Array('#monthly_course_id option:selected');
        for (var val in openIdAry) {
            openSearchInput(openIdAry[val]);
        }

                $('#monthly_course_id').change(function(){
            openSearchInput('#monthly_course_id option:selected');
        });

    });

    function openSearchInput(selectId) {

        var selectId = $(selectId);

        if (selectId.val() == 0) {
            $('#monthly_course_plus_limit_date').hide();
            $('#monthly_update_item_id').hide();
        } else {
            $('#monthly_course_plus_limit_date').show("blind", "slow");
            $('#monthly_update_item_id').show("blind", "slow");
        }
    }

//-->
</script>
</head>
<body>

<div id="ContentsCol">
    <h2 class="ContentTitle">商品更新画面</h2>
        <?php if (count($this->_tpl_vars['msg'])): ?>
        <div class="warning ui-widget">
        <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
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
            <input type="submit" name="action_itemManagement_ItemList" value="一覧に戻る" />
        </div>
    </form>
    <form action="./" method="post" enctype="multipart/form-data">
    <?php echo $this->_tpl_vars['POSTparam']; ?>

        <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
            <tr>
                <th>商品ID</th>
                <td style="text-align:left;font-size:large;">
                    <b><?php echo ((is_array($_tmp=@$this->_tpl_vars['param']['iid'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['itemData']['id']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['itemData']['id'])); ?>
</b>
                </td>
                <td style="text-align: center;">--</td>
            </tr>
            <tr>
                <th>商品アクセスキー</th>
                <td style="text-align:left;font-size:large;">
                    <b><?php echo ((is_array($_tmp=@$this->_tpl_vars['param']['access_key'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['itemData']['access_key']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['itemData']['access_key'])); ?>
</b>
                </td>
                <td style="text-align: center;">--</td>
            </tr>
            <tr>
                <th>管理側表示用商品名</th>
                <td style="text-align:left;">
                    <input type="text" name="name" value="<?php echo $this->_tpl_vars['param']['name']; ?>
" size="100">
                </td>
                <td style="text-align:center;color:#ff0000;">必須</td>
            </tr>
            <tr>
                <th>注文確認用表示商品名(PC)<br>(ユーザー側)</th>
                <td style="text-align:left;">
                    <input type="text" name="html_text_name_pc" value="<?php echo $this->_tpl_vars['param']['html_text_name_pc']; ?>
" size="100">
                    &nbsp;<font color="blue">※HTMLタグを入力出来ます。</font>
                </td>
                <td style="text-align:center;color:#ff0000;">必須</td>
            </tr>
            <tr>
                <th>注文確認用表示商品名(MB)<br>(ユーザー側)</th>
                <td style="text-align:left;">
                    <input type="text" name="html_text_name_mb" value="<?php echo $this->_tpl_vars['param']['html_text_name_mb']; ?>
" size="100">
                    &nbsp;<font color="blue">※HTMLタグを入力出来ます。</font>
                </td>
                <td style="text-align:center;color:#ff0000;">必須</td>
            </tr>
            <tr>
                <th>注文完了リメール表示用商品名</th>
                <td style="text-align:left;">
                    <input type="text" name="remail_name" value="<?php echo $this->_tpl_vars['param']['remail_name']; ?>
" size="100">
                </td>
                <td style="text-align:center;color:#ff0000;">必須</td>
            </tr>
            <tr>
                <th>カテゴリー</th>
                    <td style="text-align:left;"><?php echo smarty_function_html_options(array('name' => 'item_category_id','options' => $this->_tpl_vars['itemCategoryListForSelect'],'selected' => $this->_tpl_vars['param']['item_category_id']), $this);?>
</td>
                    <td style="text-align:center;">--</td>
            </tr>
            <tr>
                <th>表示切り替え</th>
                <td style="text-align:left;"><?php echo smarty_function_html_options(array('name' => 'is_display','options' => $this->_tpl_vars['isDisplay'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['param']['is_display'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))), $this);?>
</td>
                <td style="text-align:center;">--</td>
            </tr>
            <tr>
                <th>販売開始日時</th>
                <td style="text-align:left;">
                    <input name="sales_start_date" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['sales_start_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" size="15" maxlength="10">
                    <input name="sales_start_time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['sales_start_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
                    &nbsp;<font color="blue">※日付は「0000-00-00 00:00:00」の形で入力してください。</font>
                </td>
                <td style="text-align:center;color:#ff0000;">必須</td>
            </tr>
            <tr>
                <th>販売終了日時</th>
                <td style="text-align:left;">
                    <input name="sales_end_date" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['sales_end_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" size="15" maxlength="10">
                    <input name="sales_end_time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['sales_end_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
                    &nbsp;<font color="blue">※日付は「0000-00-00 00:00:00」の形で入力してください。</font>
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>曜日表示設定</th>
                <td style="text-align: left;">
                    <?php echo smarty_function_html_options(array('name' => 'is_display_week','options' => $this->_tpl_vars['isDisplayWeek'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['param']['is_display_week'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))), $this);?>

                    <?php echo smarty_function_html_options(array('name' => 'display_week_start_num','options' => $this->_tpl_vars['config']['admin_config']['week_array'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['param']['display_week_start_num'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))), $this);?>

                    <input name="display_week_start_time" class="time" type="text" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['param']['display_week_start_time'])) ? $this->_run_mod_handler('default', true, $_tmp, '00:00:00') : smarty_modifier_default($_tmp, '00:00:00')); ?>
" size="10" maxlength="8">から
                    <?php echo smarty_function_html_options(array('name' => 'display_week_last_num','options' => $this->_tpl_vars['config']['admin_config']['week_array'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['param']['display_week_last_num'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))), $this);?>

                    <input name="display_week_last_time" class="time" type="text" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['param']['display_week_last_time'])) ? $this->_run_mod_handler('default', true, $_tmp, '00:00:00') : smarty_modifier_default($_tmp, '00:00:00')); ?>
" size="10" maxlength="8">まで
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>入金状態</th>
                <td style="text-align:left;"><?php echo smarty_function_html_options(array('name' => 'payment_status','options' => $this->_tpl_vars['paymentStatus'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['param']['payment_status'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))), $this);?>
</td>
                <td style="text-align:center;">--</td>
            </tr>
            <tr>
                <th>ユニットID（表示）<br>(カンマ区切りで複数可)</th>
                <td style="text-align:left;">
                    <input type="text" name="unit_id" size="80" value="<?php echo $this->_tpl_vars['param']['unit_id']; ?>
" style="ime-mode:disabled">
                </td>
                <td style="text-align:center;">任意</td>
            </tr>
            <tr>
                <th>ユニットID（非表示）<br>(カンマ区切りで複数可)</th>
                <td style="text-align:left;">
                    <input type="text" name="except_unit_id" size="80" value="<?php echo $this->_tpl_vars['param']['except_unit_id']; ?>
" style="ime-mode:disabled">
                </td>
                <td style="text-align:center;">任意</td>
            </tr>
            <tr>
                <th>購入商品ID（表示）<br>(カンマ区切りで複数可)</th>
                <td style="text-align:left;">
                    <input type="text" size="80" name="item_id" value="<?php echo $this->_tpl_vars['param']['item_id']; ?>
" style="ime-mode:disabled">
                </td>
                <td style="text-align:center;">任意</td>
            </tr>
            <tr>
                <th>購入商品ID（非表示）<br>(カンマ区切りで複数可)</th>
                <td style="text-align:left;">
                    <input type="text" size="80" name="except_item_id" value="<?php echo $this->_tpl_vars['param']['except_item_id']; ?>
" style="ime-mode:disabled">
                </td>
                <td style="text-align:center;">任意</td>
            </tr>
            <tr>
                <th>検索条件保存ID(表示)<br>(カンマ区切りで複数可)<br><a href="<?php echo smarty_function_make_link(array('action' => 'action_user_SearchConditionList'), $this);?>
" target="_blank">検索条件保存リスト</a></th>
                <td style="text-align: left;">
                    <?php echo ((is_array($_tmp=@$this->_tpl_vars['searchSaveComment'])) ? $this->_run_mod_handler('default', true, $_tmp, "設定なし") : smarty_modifier_default($_tmp, "設定なし")); ?>
<br>
                    <input type="text" name="user_search_conditions_id" value="<?php echo $this->_tpl_vars['param']['user_search_conditions_id']; ?>
" size="80" style="ime-mode:disabled">
                    &nbsp;<?php echo smarty_function_html_radios(array('name' => 'user_search_conditions_type','options' => $this->_tpl_vars['searchConditionsTypeArray'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['param']['user_search_conditions_type'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)),'separator' => "&nbsp;"), $this);?>
<br>
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>検索条件保存ID(非表示)<br>(カンマ区切りで複数可)<br><a href="<?php echo smarty_function_make_link(array('action' => 'action_user_SearchConditionList'), $this);?>
" target="_blank">検索条件保存リスト</a></th>
                <td style="text-align: left;">
                    <?php echo ((is_array($_tmp=@$this->_tpl_vars['exceptSearchSaveComment'])) ? $this->_run_mod_handler('default', true, $_tmp, "設定なし") : smarty_modifier_default($_tmp, "設定なし")); ?>
<br>
                    <input type="text" name="except_user_search_conditions_id" value="<?php echo $this->_tpl_vars['param']['except_user_search_conditions_id']; ?>
" size="80" style="ime-mode:disabled">
                    &nbsp;<?php echo smarty_function_html_radios(array('name' => 'except_user_search_conditions_type','options' => $this->_tpl_vars['searchConditionsTypeArray'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['param']['except_user_search_conditions_type'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)),'separator' => "&nbsp;"), $this);?>
<br>
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>ﾘﾀﾞｲﾚｸﾄﾕﾆｯﾄ商品ID設定<br>(カンマ区切りで複数可)</th>
                <td style="text-align: left;">
                    ﾘﾀﾞｲﾚｸﾄ商品ID<input type="text" size="80" name="redirect_unit_item_id" value="<?php echo $this->_tpl_vars['param']['redirect_unit_item_id']; ?>
" style="ime-mode:disabled">
                    </br>
                    ﾘﾀﾞｲﾚｸﾄﾕﾆｯﾄID<input type="text" size="80" name="redirect_unit_id" value="<?php echo $this->_tpl_vars['param']['redirect_unit_id']; ?>
" style="ime-mode:disabled">
                    </br>
                    <font color="blue">※対になるよう商品ID、ﾕﾆｯﾄIDを設定して下さい。ﾘﾀﾞｲﾚｸﾄ商品IDの順番とﾘﾀﾞｲﾚｸﾄﾕﾆｯﾄIDの順番を合わせる必要があります。</font>
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>指定商品ＩＤ注文削除<br>(カンマ区切りで複数可)</th>
                <td style="text-align:left;">
                    <input type="text" size="80" name="target_delete_item_id" value="<?php echo $this->_tpl_vars['param']['target_delete_item_id']; ?>
" style="ime-mode:disabled">
                    </br>
                    <font color="blue">※当商品がある注文で決済が完了した場合、登録した商品ＩＤの注文があったら削除</font>
                </td>
                <td style="text-align:center;">任意</td>
            </tr>
            <tr>
                <th>販売価格</th>
                <td style="text-align:left;">
                    <input type="text" name="price" value="<?php echo $this->_tpl_vars['param']['price']; ?>
" size="10" style="ime-mode:disabled">&nbsp;円
                </td>
                <td style="text-align:center;color:#ff0000;">必須</td>
            </tr>
            <tr>
                <th>付与ポイント</th>
                <td style="text-align:left;">
                    <input type="text" name="point" value="<?php echo $this->_tpl_vars['param']['point']; ?>
" size="10" style="ime-mode:disabled">&nbsp;Pt
                </td>
                <td style="text-align:center;">任意</td>
            </tr>

            <tr>
                <th>付与月額コース</th>
                <td style="text-align: left;">
                    <?php echo smarty_function_html_options(array('name' => 'monthly_course_id','options' => $this->_tpl_vars['monthlyCourseList'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['param']['monthly_course_id'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)),'id' => 'monthly_course_id'), $this);?>

                    <div id="monthly_course_plus_limit_date" style="display:none;">
                        付与月額コース日数:<input type="text" name="monthly_course_plus_limit_date" value="<?php echo $this->_tpl_vars['param']['monthly_course_plus_limit_date']; ?>
" size="10">日
                    </div>
                    <div id="monthly_update_item_id" style="display:none;">
                        月額更新用商品ID:<input type="text" name="monthly_update_item_id" value="<?php echo $this->_tpl_vars['param']['monthly_update_item_id']; ?>
" size="10">
                        &nbsp;<font color="blue">※ここに入力した商品IDが月額更新として自動決済されます。</font>
                    </div>
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>商品URL</th>
                <td style="text-align:left;">
                    <input type="text" class="selectText" size="80" name="access_url" value="<?php echo $this->_tpl_vars['accessUrl']['access_url']; ?>
" readonly><br>
                    <font color="blue">※この商品を注文させたい場合は、上記URLをリンクやボタンの飛び先に指定してください。</font>
                </td>
                <td style="text-align:center;">任意</td>
            </tr>
            <tr>
                <th>管理用コメント</th>
                <td style="text-align:left;">
                    <textarea name="comment" cols="80" rows="2" id="comment"><?php echo $this->_tpl_vars['param']['comment']; ?>
</textarea>
                </td>
                <td style="text-align:center;">任意</td>
            </tr>
                        <tr>
                <th>表示優先度</th>
                <td style="text-align:left;">
                    <input type="text" name="sort_seq" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['param']['sort_seq'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
" size="10" style="ime-mode:disabled">
                </td>
                <td style="text-align:center;">任意</td>
            </tr>
            <tr>
                <td colspan="3"  style="text-align:center;">
                    <div class="SubMenu">
                        <input type="submit" name="action_itemManagement_itemExec" value="更新する" onClick="return confirm('更新しますか？')"/>&nbsp;&nbsp;
                        <input type="submit" name="action_itemManagement_itemCopyExec" value="変更内容で新規作成" onClick="return confirm('変更内容で新規作成しますか？')"/>
                    </div>
                </td>
            </tr>
        </table>
    </form>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admFooter'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
</body>
</html>