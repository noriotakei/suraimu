<?php /* Smarty version 2.6.26, created on 2014-08-10 14:38:42
         compiled from /home/suraimu/templates/admin/informationStatus/informationCreate.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/informationStatus/informationCreate.tpl', 76, false),array('modifier', 'implode', '/home/suraimu/templates/admin/informationStatus/informationCreate.tpl', 82, false),array('modifier', 'default', '/home/suraimu/templates/admin/informationStatus/informationCreate.tpl', 134, false),array('modifier', 'zend_date_format', '/home/suraimu/templates/admin/informationStatus/informationCreate.tpl', 145, false),array('function', 'make_link', '/home/suraimu/templates/admin/informationStatus/informationCreate.tpl', 94, false),array('function', 'html_options', '/home/suraimu/templates/admin/informationStatus/informationCreate.tpl', 108, false),array('function', 'html_radios', '/home/suraimu/templates/admin/informationStatus/informationCreate.tpl', 215, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
<script type="text/javascript" src="./js/jquery.timepickr.min.js"></script>
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script type="text/javascript" src="./js/watermark/jquery.watermark.min.js"></script>
<link type="text/css" href="./css/pager.css" rel="stylesheet" />
<script type="text/javascript">
<!--

    $(function() {
        $('.selectText').click(function(){
        $(this).select();
        });

                $('#list_table').colorize({
            altColor :'#CCCCCC',
            hiliteColor :'none'
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

        // テキストエリア文字
        $('.inputBody').watermark('入力時は<body>タグを入力してください。※</body>は不要');

                $("#set_tag").hide();

        var openIdAry = Array('#all_disp_type option:selected');
        for (var val in openIdAry) {
            openSearchInput(openIdAry[val]);
        }

                $('#all_disp_type').change(function(){
            openSearchInput('#all_disp_type option:selected');
        });

    });

    function openSearchInput(selectId) {

        var selectId = $(selectId);

        if (selectId.val() == 1) {
            $('#set_tag').show("blind", "slow");
        } else {
            $('#set_tag').hide("slow");
        }
    }
//-->
</script>
<style type="text/css">
    .watermark {
       color: #999;
    }
</style>
</head>
<body>

<div id="ContentsCol">
    <h2 class="ContentTitle">情報登録画面</h2>
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
        <div class="SubMenu">
            <input type="submit" name="action_informationStatus_InformationSearchList" value="一覧に戻る" />
        </div>
    </form>
    <div>
        <a href="<?php echo smarty_function_make_link(array('action' => 'action_keyConvert_DispKeyConvertList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="_blank">システム変換管理</a>
    </div>
    <br>
    <?php if ($this->_tpl_vars['infoTemplateList']): ?>
    <div>
        <a href="<?php echo smarty_function_make_link(array('action' => 'action_informationTemplate_DispInformationTemplateList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="_blank">情報HTML定型文一覧</a>
    </div>
    <?php endif; ?>
    <br>
    <form action="./" method="post" enctype="multipart/form-data">
    <?php echo $this->_tpl_vars['POSTparam']; ?>

        <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
            <tr>
                <th>情報表示場所フォルダ</th>
                <td style="text-align: left;"><?php echo smarty_function_html_options(array('name' => 'information_category_id','options' => $this->_tpl_vars['infoDispPositionForSelect'],'selected' => $this->_tpl_vars['returnParam']['information_category_id']), $this);?>
</td>
                <td style="text-align: center;">--</td>
            </tr>
            <tr>
                <th>管理用情報名</th>
                <td style="text-align: left;">
                    <input type="text" name="name" value="<?php echo $this->_tpl_vars['returnParam']['name']; ?>
" size="50">
                </td>
                <td style="text-align:center;color:#ff0000;">必須</td>
            </tr>
            <tr>
                <th>消費ポイント</th>
                <td style="text-align: left;">
                    <input type="text" name="point" value="<?php echo $this->_tpl_vars['returnParam']['point']; ?>
" size="10" style="ime-mode:disabled">&nbsp;Pt
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>付与ポイント</th>
                <td style="text-align: left;">
                    <input type="text" name="bonus_point" value="<?php echo $this->_tpl_vars['returnParam']['bonus_point']; ?>
" size="10" style="ime-mode:disabled">&nbsp;Pt
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>付与ポイント無制限</th>
                <td style="text-align: left;"><?php echo smarty_function_html_options(array('name' => 'bonus_point_limit','options' => $this->_tpl_vars['bonusPointLimitTypeArray'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['returnParam']['bonus_point_limit'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))), $this);?>
</td>
                <td style="text-align: center;">--</td>
            </tr>
            <tr>
                <th>表示切り替え</th>
                <td style="text-align: left;"><?php echo smarty_function_html_options(array('name' => 'is_display','options' => $this->_tpl_vars['isDisplay'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['returnParam']['is_display'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))), $this);?>
</td>
                <td style="text-align: center;">--</td>
            </tr>
            <tr>
                <th>表示開始日時</th>
                <td style="text-align: left;">
                    <input name="display_start_date" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['returnParam']['display_start_date'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" size="15" maxlength="10">
                    <input name="display_start_time" class="time" type="text" value="<?php echo $this->_tpl_vars['returnParam']['display_start_time']; ?>
" size="10" maxlength="8">
                    &nbsp;<font color="blue">※日付は「0000-00-00 00:00:00」の形で入力してください。</font>
                </td>
                <td style="text-align:center;color:#ff0000;">必須</td>
            </tr>
            <tr>
                <th>表示終了日時</th>
                <td style="text-align: left;">
                    <input name="display_end_date" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['returnParam']['display_end_date'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" size="15" maxlength="10">
                    <input name="display_end_time" class="time" type="text" value="<?php echo $this->_tpl_vars['returnParam']['display_end_time']; ?>
" size="10" maxlength="8">
                    &nbsp;<font color="blue">※日付は「0000-00-00 00:00:00」の形で入力してください。</font>
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>曜日表示設定</th>
                <td style="text-align: left;">
                    <?php echo smarty_function_html_options(array('name' => 'is_display_week','options' => $this->_tpl_vars['isDisplayWeek'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['returnParam']['is_display_week'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))), $this);?>

                    <?php echo smarty_function_html_options(array('name' => 'display_week_start_num','options' => $this->_tpl_vars['config']['admin_config']['week_array'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['returnParam']['display_week_start_num'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))), $this);?>

                    <input name="display_week_start_time" class="time" type="text" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['returnParam']['display_week_start_time'])) ? $this->_run_mod_handler('default', true, $_tmp, '00:00:00') : smarty_modifier_default($_tmp, '00:00:00')); ?>
" size="10" maxlength="8">から
                    <?php echo smarty_function_html_options(array('name' => 'display_week_last_num','options' => $this->_tpl_vars['config']['admin_config']['week_array'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['returnParam']['display_week_last_num'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))), $this);?>

                    <input name="display_week_last_time" class="time" type="text" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['returnParam']['display_week_last_time'])) ? $this->_run_mod_handler('default', true, $_tmp, '00:00:00') : smarty_modifier_default($_tmp, '00:00:00')); ?>
" size="10" maxlength="8">まで
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>入金状態</th>
                <td style="text-align: left;"><?php echo smarty_function_html_options(array('name' => 'payment_status','options' => $this->_tpl_vars['paymentStatus'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['returnParam']['payment_status'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))), $this);?>
</td>
                <td style="text-align: center;">--</td>
            </tr>
            <tr>
                <th>ユニットID（表示）<br>(カンマ区切りで複数可)</th>
                <td style="text-align: left;">
                    <input type="text" name="unit_id" size="80" value="<?php echo $this->_tpl_vars['returnParam']['unit_id']; ?>
" style="ime-mode:disabled">
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>ユニットID（非表示）<br>(カンマ区切りで複数可)</th>
                <td style="text-align: left;">
                    <input type="text" name="except_unit_id" size="80" value="<?php echo $this->_tpl_vars['returnParam']['except_unit_id']; ?>
" style="ime-mode:disabled">
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>購入商品ID（表示）<br>(カンマ区切りで複数可)</th>
                <td style="text-align: left;">
                    <input type="text" size="80" name="item_id" value="<?php echo $this->_tpl_vars['returnParam']['item_id']; ?>
" style="ime-mode:disabled">
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>購入商品ID（非表示）<br>(カンマ区切りで複数可)</th>
                <td style="text-align: left;">
                    <input type="text" size="80" name="except_item_id" value="<?php echo $this->_tpl_vars['returnParam']['except_item_id']; ?>
" style="ime-mode:disabled">
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>既読時表示情報ID<br>(カンマ区切りで複数可)</th>
                <td style="text-align: left;">
                    <input type="text" size="80" name="redirect_information_id" value="<?php echo $this->_tpl_vars['returnParam']['redirect_information_id']; ?>
" style="ime-mode:disabled">
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>検索条件保存ID(表示)<br>(カンマ区切りで複数可)<br><a href="<?php echo smarty_function_make_link(array('action' => 'action_user_SearchConditionList'), $this);?>
" target="_blank">検索条件保存リスト</a></th>
                <td style="text-align: left;">
                    <input type="text" name="user_search_conditions_id" value="<?php echo $this->_tpl_vars['returnParam']['user_search_conditions_id']; ?>
" size="80" style="ime-mode:disabled">
                    &nbsp;<?php echo smarty_function_html_radios(array('name' => 'user_search_conditions_type','options' => $this->_tpl_vars['searchConditionsTypeArray'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['returnParam']['user_search_conditions_type'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)),'separator' => "&nbsp;"), $this);?>
<br>
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>検索条件保存ID(非表示)<br>(カンマ区切りで複数可)<br><a href="<?php echo smarty_function_make_link(array('action' => 'action_user_SearchConditionList'), $this);?>
" target="_blank">検索条件保存リスト</a></th>
                <td style="text-align: left;">
                    <input type="text" name="except_user_search_conditions_id" value="<?php echo $this->_tpl_vars['returnParam']['except_user_search_conditions_id']; ?>
" size="80" style="ime-mode:disabled">
                    &nbsp;<?php echo smarty_function_html_radios(array('name' => 'except_user_search_conditions_type','options' => $this->_tpl_vars['searchConditionsTypeArray'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['returnParam']['except_user_search_conditions_type'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)),'separator' => "&nbsp;"), $this);?>
<br>
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>リダイレクトURL</th>
                <td style="text-align: left;">
                    <input type="text" size="80" name="redirect_url" value="<?php echo $this->_tpl_vars['returnParam']['redirect_url']; ?>
" ><br>
                    <font color="blue">※「バナー表示情報」から他ページに飛ばしたい場合は、飛ばし先のURLを指定してください。(例)【既読】の場合→他の情報ページなど</font>
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>ﾘﾀﾞｲﾚｸﾄﾕﾆｯﾄ情報ID設定<br>(カンマ区切りで複数可)</th>
                <td style="text-align: left;">
                    ﾘﾀﾞｲﾚｸﾄ情報ID<input type="text" size="80" name="redirect_unit_information_id" value="<?php echo $this->_tpl_vars['returnParam']['redirect_unit_information_id']; ?>
" style="ime-mode:disabled">
                    </br>
                    ﾘﾀﾞｲﾚｸﾄﾕﾆｯﾄID<input type="text" size="80" name="redirect_unit_id" value="<?php echo $this->_tpl_vars['returnParam']['redirect_unit_id']; ?>
" style="ime-mode:disabled">
                    </br>
                    <font color="blue">※対になるよう情報ID、ﾕﾆｯﾄIDを設定して下さい。ﾘﾀﾞｲﾚｸﾄﾕﾆｯﾄ情報IDの順番とﾘﾀﾞｲﾚｸﾄﾕﾆｯﾄIDの順番を合わせる必要があります。</font>
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>ユーザー側全画面表示設定</th>
                <td style="text-align: left;">
                   <b><?php echo smarty_function_html_options(array('name' => 'is_all_display','options' => $this->_tpl_vars['isAllDisplay'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['returnParam']['is_all_display'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)),'id' => 'all_disp_type'), $this);?>

                </td>
                <td style="text-align: center;">--</td>
            </tr>
            <tr>
                <th>バナー表示情報(PC)<br>(bodyタグ不要)</th>
                <td style="text-align: left;">
                    <textarea name="html_text_banner_pc" cols="100" rows="20" id="html_text_banner_pc" wrap="off"><?php echo $this->_tpl_vars['returnParam']['html_text_banner_pc']; ?>
</textarea>
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>詳細情報(PC)</th>
                <td style="text-align: left;"><br>
                <div id="set_tag" style="display:none;">
                    <b><font color="blue">bodyタグ設定(PC)</font></b><br>
                    <input type="text" size="150" class="selectText" name="html_body_pc" value="<?php echo $this->_tpl_vars['htmlTagPC']; ?>
" readonly><br>
                    <font color="red">※全画面表示「ON」の場合、下記「表示情報(PC)」本文に「&lt;body&gt;」タグを設置して下さい。<br>※「&lt;&frasl;body&gt;」タグは不要です</font><br><br>
                </div>
                <textarea name="html_text_pc" cols="100" rows="20" id="html_text_pc" wrap="off"><?php echo $this->_tpl_vars['returnParam']['html_text_pc']; ?>
</textarea><br>
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>バナー表示情報(MB)<br>(bodyタグ不要)</th>
                <td style="text-align: left;">
                <textarea name="html_text_banner_mb" cols="100" rows="20" id="html_text_banner_mb" wrap="off"><?php echo $this->_tpl_vars['returnParam']['html_text_banner_mb']; ?>
</textarea>
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>詳細情報(MB)<br>(bodyタグ必須)</th>
                <td style="text-align: left;">
                <b><font color="blue">タグ設定(MB)</font></b><br>
                <textarea  class="selectText" name="html_body_mb" cols="100" rows="4" id="html_text_banner_mb" wrap="off" readonly><?php echo $this->_tpl_vars['htmlTagMB']; ?>
</textarea><br>
                <font color="red">※下記「表示情報(MB)」本文に張り付けて下さい。タグ内の設定は基本設定となっています。</font><br><br>
                    <textarea name="html_text_mb" class="inputBody" cols="100" rows="20" id="html_text_mb" wrap="off"><?php echo $this->_tpl_vars['returnParam']['html_text_mb']; ?>
</textarea>
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>管理用コメント</th>
                <td style="text-align: left;">
                    <textarea name="comment" cols="80" rows="5" id="comment"><?php echo $this->_tpl_vars['returnParam']['comment']; ?>
</textarea>
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>表示優先度</th>
                <td style="text-align: left;">
                    <input type="text" name="sort_seq" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['returnParam']['sort_seq'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
" size="10" style="ime-mode:disabled">
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <td colspan="3"  style="text-align:center;">
                    <div class="SubMenu">
                        <input type="submit" name="action_informationStatus_informationExec" value="登録する" onClick="return confirm('登録しますか？')"/>
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