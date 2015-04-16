<?php /* Smarty version 2.6.26, created on 2015-01-13 18:25:27
         compiled from /home/suraimu/templates/admin/user/detail.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/user/detail.tpl', 8, false),array('modifier', 'implode', '/home/suraimu/templates/admin/user/detail.tpl', 14, false),array('modifier', 'cat', '/home/suraimu/templates/admin/user/detail.tpl', 24, false),array('modifier', 'in_array', '/home/suraimu/templates/admin/user/detail.tpl', 61, false),array('modifier', 'default', '/home/suraimu/templates/admin/user/detail.tpl', 210, false),array('modifier', 'zend_date_format', '/home/suraimu/templates/admin/user/detail.tpl', 370, false),array('function', 'make_link', '/home/suraimu/templates/admin/user/detail.tpl', 24, false),array('function', 'math', '/home/suraimu/templates/admin/user/detail.tpl', 35, false),array('function', 'html_options', '/home/suraimu/templates/admin/user/detail.tpl', 114, false),array('function', 'html_checkboxes', '/home/suraimu/templates/admin/user/detail.tpl', 210, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
</head>
<body>
<div class="BlockCol">
    <h2 class="ContentTitle">ユーザー情報</h2>
        <?php if (count($this->_tpl_vars['errMsg'])): ?>
        <div class="warning ui-widget">
        <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
        <p>
        <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
        <?php $_from = $this->_tpl_vars['errMsg']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
            <?php echo implode($this->_tpl_vars['val'], "<br>"); ?>

        <?php endforeach; endif; unset($_from); ?>
        </p>
        </div>
        </div>
        <br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['userData']): ?>
        <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
            <tr>
                <td style="padding:5px;"><a href="<?php echo smarty_function_make_link(array('action' => 'action_user_LogList','getTags' => ((is_array($_tmp="user_id=")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['userData']['user_id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['userData']['user_id']))), $this);?>
" target="_blank">各種ログ</a></td>
                <td style="padding:5px;"><a href="<?php echo smarty_function_make_link(array('action' => 'action_ordering_OrderingSet','getTags' => ((is_array($_tmp="user_id=")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['userData']['user_id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['userData']['user_id']))), $this);?>
" target="_blank">商品予約</a></td>
                <td><a href="<?php echo $this->_tpl_vars['config']['define']['SITE_URL']; ?>
?action_Home=1&<?php echo $this->_tpl_vars['accessKeyName']; ?>
=<?php echo $this->_tpl_vars['userData']['access_key']; ?>
" target="_blank">PCログイン</a></td>
                <td><a href="<?php echo $this->_tpl_vars['config']['define']['SITE_URL_MOBILE']; ?>
?action_Home=1&<?php echo $this->_tpl_vars['accessKeyName']; ?>
=<?php echo $this->_tpl_vars['userData']['access_key']; ?>
" target="_blank">MBログイン</a></td>
                <td style="padding:5px;"><a href="<?php echo smarty_function_make_link(array('action' => 'action_user_MonthlyCourseUserList','getTags' => ((is_array($_tmp="user_id=")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['userData']['user_id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['userData']['user_id']))), $this);?>
" target="_blank">月額コース管理</a></td>
            </tr>
        </table>
        <br>
        <?php if ($this->_tpl_vars['duplicateUserDataList']): ?>
            <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
                <tr>
                    <th rowspan="<?php echo smarty_function_math(array('equation' => "(x / y) + 1",'x' => count($this->_tpl_vars['duplicateUserDataList']),'y' => 10,'format' => "%.0f"), $this);?>
">重複ユーザーID</th>
                    <?php $_from = $this->_tpl_vars['duplicateUserDataList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['dataLoop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['dataLoop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['val']):
        $this->_foreach['dataLoop']['iteration']++;
?>
                    <td style="padding:5px;">
                        <a href="<?php echo smarty_function_make_link(array('action' => 'action_User_Detail','getTags' => ((is_array($_tmp="user_id=")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['val']['user_id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['val']['user_id']))), $this);?>
" target="_blank"><?php echo $this->_tpl_vars['val']['user_id']; ?>
</a>
                    </td>
                    <?php if ($this->_foreach['dataLoop']['iteration'] % 10 == 0): ?>
                        </tr><tr>
                    <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?>
                </tr>
            </table>
            <br>
        <?php endif; ?>
        <form action="./" method="post">
            <?php echo $this->_tpl_vars['POSTparam']; ?>

            <table>
                <tr>
                    <td style="vertical-align:top;">
                        <table>
                            <tr>
                                <td style="vertical-align:top;">
                                    <table border="0" cellspacing="0" cellpadding="0" class="TableSet02">
                                        <tr>
                                            <th>ﾕｰｻﾞｰID</th>
                                            <td style="text-align: left;"><?php echo $this->_tpl_vars['userData']['user_id']; ?>
</td>
                                        </tr>
                                        <?php if (((is_array($_tmp='login_id')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
                                        <tr>
                                            <th>ﾛｸﾞｲﾝID</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="login_id" value="<?php echo $this->_tpl_vars['userData']['login_id']; ?>
" style="ime-mode:disabled" size="50">
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if (((is_array($_tmp='login_id_no_domain')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
                                        <tr>
                                            <th>ﾛｸﾞｲﾝID(ドメインなし)</th>
                                            <td style="text-align: left;">
                                                <?php echo $this->_tpl_vars['userData']['login_id_no_domain']; ?>

                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <tr>
                                            <th>ﾕｰｻﾞｰPASS</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="password" value="" style="ime-mode:disabled" size="16">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>ﾕｰｻﾞｰ識別ｷｰ</th>
                                            <td style="text-align: left;"><?php echo $this->_tpl_vars['userData']['access_key']; ?>
</td>
                                        </tr>
                                        <?php if (((is_array($_tmp='credit_certify_phone_number')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
                                        <tr>
                                            <th>ｾﾞﾛｸﾚｼﾞｯﾄ登録電話番号</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="credit_certify_phone_number" value="<?php echo $this->_tpl_vars['userData']['credit_certify_phone_number']; ?>
" style="ime-mode:disabled" maxlength="13" size="15">
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if (((is_array($_tmp='credit_certify_phone_number_mb')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
                                        <tr>
                                            <th>ｾﾞﾛｸﾚｼﾞｯﾄMB登録電話番号</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="credit_certify_phone_number_mb" value="<?php echo $this->_tpl_vars['userData']['credit_certify_phone_number_mb']; ?>
" style="ime-mode:disabled" maxlength="13" size="15">
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if (((is_array($_tmp='telecom_certify_phone_number')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
                                        <tr>
                                            <th>ﾃﾚｺﾑｸﾚｼﾞｯﾄ登録電話番号</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="telecom_certify_phone_number" value="<?php echo $this->_tpl_vars['userData']['telecom_certify_phone_number']; ?>
" style="ime-mode:disabled" maxlength="13" size="15">
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <tr>
                                            <th>ｽﾃｰﾀｽ</th>
                                            <td style="text-align: left;">
                                                <?php echo smarty_function_html_options(array('name' => 'regist_status','options' => $this->_tpl_vars['config']['admin_config']['regist_status'],'selected' => $this->_tpl_vars['userData']['regist_status']), $this);?>

                                            </td>
                                        </tr>
                                        <tr>
                                            <th>性別</th>
                                            <td style="text-align: left;">
                                                <?php echo smarty_function_html_options(array('name' => 'sex_cd','options' => $this->_tpl_vars['config']['admin_config']['sex_cd'],'selected' => $this->_tpl_vars['userData']['sex_cd']), $this);?>

                                            </td>
                                        </tr>
                                        <tr>
                                            <th>血液型</th>
                                            <td style="text-align: left;">
                                                <?php echo smarty_function_html_options(array('name' => 'blood_type','options' => $this->_tpl_vars['config']['admin_config']['blood_type'],'selected' => $this->_tpl_vars['userData']['blood_type']), $this);?>

                                            </td>
                                        </tr>
                                        <tr>
                                            <th>PCﾒｰﾙ強行</th>
                                            <td style="text-align: left;">
                                                <?php echo smarty_function_html_options(array('name' => 'is_pc_reverse','options' => $this->_tpl_vars['config']['admin_config']['reverse_status'],'selected' => $this->_tpl_vars['userData']['is_pc_reverse']), $this);?>

                                            </td>
                                        </tr>
                                        <tr>
                                            <th>MBﾒｰﾙ強行</th>
                                            <td style="text-align: left;">
                                                <?php echo smarty_function_html_options(array('name' => 'is_mb_reverse','options' => $this->_tpl_vars['config']['admin_config']['reverse_status'],'selected' => $this->_tpl_vars['userData']['is_mb_reverse']), $this);?>

                                            </td>
                                        </tr>

                                        <tr>
                                            <th>ブラック</th>
                                            <td style="text-align: left;">
                                                <?php echo smarty_function_html_options(array('name' => 'danger_status','options' => $this->_tpl_vars['config']['admin_config']['danger_status'],'selected' => $this->_tpl_vars['userData']['danger_status']), $this);?>

                                            </td>
                                        </tr>
                                        <tr>
                                            <th>ユーザー識別フラグ</th>
                                            <td style="text-align: left;">
                                                <?php echo smarty_function_html_options(array('name' => 'user_profile_flag_code_update','options' => $this->_tpl_vars['user_profile_flag_code'],'selected' => $this->_tpl_vars['userData']['user_profile_flag']), $this);?>

                                            </td>
                                        </tr>
                                        <tr>
                                            <th>PCﾃﾞﾊﾞｲｽ</th>
                                            <td style="text-align: left;"><?php echo $this->_tpl_vars['config']['admin_config']['pc_device'][$this->_tpl_vars['userData']['pc_device_cd']]; ?>
</td>
                                        </tr>
                                        <tr>
                                            <th>PC IPｱﾄﾞﾚｽ</th>
                                            <td style="text-align: left;"><?php echo $this->_tpl_vars['userData']['pc_ip_address']; ?>
</td>
                                        </tr>
                                        <?php if (((is_array($_tmp='pc_address')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
                                        <tr>
                                            <th>PCﾒｰﾙｱﾄﾞﾚｽ</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="pc_address" value="<?php echo $this->_tpl_vars['userData']['pc_address']; ?>
" style="ime-mode:disabled" size="50">
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if (((is_array($_tmp='pc_address_no_domain')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
                                        <tr>
                                            <th>PCﾒｰﾙｱﾄﾞﾚｽ(ドメインなし)</th>
                                            <td style="text-align: left;">
                                                <?php echo $this->_tpl_vars['userData']['pc_address_no_domain']; ?>

                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <tr>
                                            <th>PCｱﾄﾞﾚｽｽﾃ-ﾀｽ</th>
                                            <td style="text-align: left;">
                                                <?php echo smarty_function_html_options(array('name' => 'pc_address_status','options' => $this->_tpl_vars['config']['admin_config']['address_status'],'selected' => $this->_tpl_vars['userData']['pc_address_status']), $this);?>

                                             </td>
                                        </tr>
                                        <tr>
                                            <th>PC送信ｽﾃ-ﾀｽ</th>
                                            <td style="text-align: left;">
                                                <?php echo smarty_function_html_options(array('name' => 'pc_send_status','options' => $this->_tpl_vars['config']['admin_config']['address_send_status'],'selected' => $this->_tpl_vars['userData']['pc_send_status']), $this);?>

                                             </td>
                                        </tr>
                                        <tr>
                                            <th>PCﾒｰﾙ受信設定</th>
                                            <td style="text-align: left;">
                                                <?php echo smarty_function_html_options(array('name' => 'pc_is_mailmagazine','options' => $this->_tpl_vars['config']['common_config']['is_mailmagazine'],'selected' => $this->_tpl_vars['userData']['pc_is_mailmagazine']), $this);?>

                                             </td>
                                        </tr>
                                        <tr>
                                            <th>PCﾕｰｻﾞｰｴｰｼﾞｪﾝﾄ</th>
                                            <td style="text-align: left;"><?php echo $this->_tpl_vars['userData']['pc_user_agent']; ?>
</td>
                                        </tr>
                                        <tr>
                                            <th>PCｴﾗｰﾒｰﾙ数</th>
                                            <td style="text-align: left;"><?php echo $this->_tpl_vars['userData']['pc_emsys_count']; ?>
回</td>
                                        </tr>
                                        <?php if (((is_array($_tmp='mb_serial_number')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
                                        <tr>
                                            <th>個体識別番号</th>
                                            <td style="text-align: left;">
                                                <?php echo $this->_tpl_vars['userData']['mb_serial_number']; ?>
&nbsp;&nbsp;&nbsp;
                                                <?php if ($this->_tpl_vars['userData']['mb_serial_number']): ?>
                                                    <?php echo smarty_function_html_checkboxes(array('name' => 'serial_number_delete','options' => $this->_tpl_vars['serialNumberDelete'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['value']['serial_number_delete'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)),'separator' => "&nbsp;"), $this);?>

                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if (((is_array($_tmp='mb_device_cd')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
                                        <tr>
                                            <th>MBﾃﾞﾊﾞｲｽ</th>
                                            <td style="text-align: left;"><?php echo $this->_tpl_vars['config']['admin_config']['mb_device'][$this->_tpl_vars['userData']['mb_device_cd']]; ?>
</td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if (((is_array($_tmp='mb_address')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
                                        <tr>
                                            <th>MBﾒｰﾙｱﾄﾞﾚｽ</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="mb_address" value="<?php echo $this->_tpl_vars['userData']['mb_address']; ?>
" style="ime-mode:disabled" size="50">
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if (((is_array($_tmp='mb_address_no_domain')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
                                        <tr>
                                            <th>MBﾒｰﾙｱﾄﾞﾚｽ(ドメインなし)</th>
                                            <td style="text-align: left;">
                                                <?php echo $this->_tpl_vars['userData']['mb_address_no_domain']; ?>

                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <tr>
                                            <th>MBｱﾄﾞﾚｽｽﾃｰﾀｽ</th>
                                            <td style="text-align: left;">
                                                <?php echo smarty_function_html_options(array('name' => 'mb_address_status','options' => $this->_tpl_vars['config']['admin_config']['address_status'],'selected' => $this->_tpl_vars['userData']['mb_address_status']), $this);?>

                                            </td>
                                        </tr>
                                        <tr>
                                            <th>MB送信ｽﾃ-ﾀｽ</th>
                                            <td style="text-align: left;">
                                                <?php echo smarty_function_html_options(array('name' => 'mb_send_status','options' => $this->_tpl_vars['config']['admin_config']['address_send_status'],'selected' => $this->_tpl_vars['userData']['mb_send_status']), $this);?>

                                             </td>
                                        </tr>
                                        <tr>
                                            <th>MBﾒｰﾙ受信設定</th>
                                            <td style="text-align: left;">
                                                <?php echo smarty_function_html_options(array('name' => 'mb_is_mailmagazine','options' => $this->_tpl_vars['config']['common_config']['is_mailmagazine'],'selected' => $this->_tpl_vars['userData']['mb_is_mailmagazine']), $this);?>

                                             </td>
                                        </tr>
                                        <?php if (((is_array($_tmp='mb_user_agent')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
                                        <tr>
                                            <th>MBﾕｰｻﾞｰｴｰｼﾞｪﾝﾄ</th>
                                            <td style="text-align: left;"><?php echo $this->_tpl_vars['userData']['mb_user_agent']; ?>
</td>
                                        </tr>
                                        <?php endif; ?>
                                        <tr>
                                            <th>MBｴﾗｰﾒｰﾙ数</th>
                                            <td style="text-align: left;"><?php echo $this->_tpl_vars['userData']['mb_emsys_count']; ?>
回</td>
                                        </tr>
                                        <?php if (((is_array($_tmp='mb_ip_address')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
                                        <tr>
                                            <th>MBIPｱﾄﾞﾚｽ</th>
                                            <td style="text-align: left;"><?php echo $this->_tpl_vars['userData']['mb_ip_address']; ?>
</td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if (((is_array($_tmp='mb_model')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
                                        <tr>
                                            <th>ﾕｰｻﾞｰ携帯機種名</th>
                                            <td style="text-align: left;"><?php echo $this->_tpl_vars['userData']['mb_model']; ?>
</td>
                                        </tr>
                                        <?php endif; ?>
                                        <tr>
                                            <th>媒体ｺｰﾄﾞ</th>
                                            <td style="text-align: left;"><input type="text" name="media_cd" value="<?php echo $this->_tpl_vars['userData']['media_cd']; ?>
" style="ime-mode:disabled" size="10"style="text-align:right;"></td>
                                        </tr>
                                        <tr>
                                            <th>保有ﾎﾟｲﾝﾄ</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="point" value="<?php echo $this->_tpl_vars['userData']['point']; ?>
" style="ime-mode:disabled" size="7"style="text-align:right;">pt
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>合計付与ﾎﾟｲﾝﾄ</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="total_addition_point" value="<?php echo $this->_tpl_vars['userData']['total_addition_point']; ?>
" style="ime-mode:disabled" size="7"style="text-align:right;">pt
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>合計使用ﾎﾟｲﾝﾄ</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="total_use_point" value="<?php echo $this->_tpl_vars['userData']['total_use_point']; ?>
" style="ime-mode:disabled" size="7"style="text-align:right;">pt
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>管理ﾎﾞｯｸｽ</th>
                                            <td style="text-align: left;">
                                                <?php echo smarty_function_html_options(array('name' => 'admin_id','options' => $this->_tpl_vars['adminList'],'selected' => $this->_tpl_vars['userData']['admin_id']), $this);?>

                                            </td>
                                        </tr>
                                        <tr>
                                            <th>購入金額</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="total_payment" value="<?php echo $this->_tpl_vars['userData']['total_payment']; ?>
" style="ime-mode:disabled" size="7"style="text-align:right;">円
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>購入回数</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="buy_count" value="<?php echo $this->_tpl_vars['userData']['buy_count']; ?>
" style="ime-mode:disabled" size="3"style="text-align:right;">回
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>キャンセル回数</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="cancel_count" value="<?php echo $this->_tpl_vars['userData']['cancel_count']; ?>
" style="ime-mode:disabled" size="3"style="text-align:right;">回
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>平均購入金額</th>
                                            <td style="text-align: left;">
                                                <input type="text" value="<?php echo $this->_tpl_vars['userData']['average_item']; ?>
" style="ime-mode:disabled" size="3"style="text-align:right;" readonly>円
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>最高購入金額</th>
                                            <td style="text-align: left;">
                                                <input type="text" value="<?php echo $this->_tpl_vars['userData']['expensive_item']; ?>
" style="ime-mode:disabled" size="3"style="text-align:right;" readonly>円
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>最低購入金額</th>
                                            <td style="text-align: left;">
                                                <input type="text" value="<?php echo $this->_tpl_vars['userData']['cheap_item']; ?>
" style="ime-mode:disabled" size="3"style="text-align:right;" readonly>円
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>中央値</th>
                                            <td style="text-align: left;">
                                                <input type="text" value="<?php echo $this->_tpl_vars['userData']['median_item']; ?>
" style="ime-mode:disabled" size="3"style="text-align:right;" readonly>円
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>最頻値</th>
                                            <td style="text-align: left;">
                                                <input type="text" value="<?php echo $this->_tpl_vars['userData']['frequently_item']; ?>
" style="ime-mode:disabled" size="3"style="text-align:right;" readonly>円
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>登録時発行状況</th>
                                            <td style="text-align: left;"><?php if ($this->_tpl_vars['userData']['affiliate_tag_status']): ?>発行済<?php else: ?>未発行<?php endif; ?></td>
                                        </tr>
                                        <?php if (((is_array($_tmp='affiliate_tag_url')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
                                        <tr>
                                            <th>登録時発行タグ</th>
                                            <td style="text-align: left;"><?php echo $this->_tpl_vars['userData']['affiliate_tag_url']; ?>
</td>
                                        </tr>
                                        <?php endif; ?>
                                        <tr>
                                            <th>登録入口ID</th>
                                            <td style="text-align: left;"><input type="text" name="regist_page_id" value="<?php echo $this->_tpl_vars['userData']['regist_page_id']; ?>
" style="ime-mode:disabled" size="3"style="text-align:right;"></td>
                                        </tr>
                                        <tr>
                                            <th>仮登録日時</th>
                                            <td style="text-align: left;">
                                                <input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['userData']['pre_regist_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="pre_regist_datetime_Date" maxlength="10">
                                                <input name="pre_regist_datetime_Time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['userData']['pre_regist_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>登録日時</th>
                                            <td style="text-align: left;">
                                                <input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['userData']['regist_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="regist_datetime_Date" maxlength="10">
                                                <input name="regist_datetime_Time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['userData']['regist_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>初回入金日時</th>
                                            <td style="text-align: left;">
                                                <input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['userData']['first_pay_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="first_pay_datetime_Date" maxlength="10">
                                                <input name="first_pay_datetime_Time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['userData']['first_pay_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>最終購入日時</th>
                                            <td style="text-align: left;">
                                                <input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['userData']['last_buy_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="last_buy_datetime_Date" maxlength="10">
                                                <input name="last_buy_datetime_Time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['userData']['last_buy_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>最終ｱｸｾｽ日時</th>
                                            <td style="text-align: left;">
                                                <input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['userData']['last_access_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="last_access_datetime_Date" maxlength="10">
                                                <input name="last_access_datetime_Time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['userData']['last_access_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>ﾛｸﾞｲﾝ後ﾄｯﾌﾟｱｸｾｽ日時</th>
                                            <td style="text-align: left;">
                                                <input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['userData']['home_access_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="home_access_datetime_date" maxlength="10">
                                                <input name="home_access_datetime_time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['userData']['home_access_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>退会日時</th>
                                            <td style="text-align: left;">
                                                <input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['userData']['quit_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="quit_datetime_Date" maxlength="10">
                                                <input name="quit_datetime_Time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['userData']['quit_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>生年月日</th>
                                            <td style="text-align: left;">
                                                <input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['userData']['birth_date'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="birth_date" maxlength="10">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>強行メール回数</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="reverse_mail_status_count" value="<?php echo $this->_tpl_vars['userData']['reverse_mail_status_count']; ?>
" style="ime-mode:disabled" size="3" style="text-align:right;">回
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>PC配信ドメイン</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="pc_mailmagazine_from_domain" value="<?php echo $this->_tpl_vars['userData']['pc_mailmagazine_from_domain']; ?>
" style="ime-mode:disabled" size="25" style="text-align:right;">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>MB配信ドメイン</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="mb_mailmagazine_from_domain" value="<?php echo $this->_tpl_vars['userData']['mb_mailmagazine_from_domain']; ?>
" style="ime-mode:disabled" size="25" style="text-align:right;">
                                            </td>
                                        </tr>
                                        <?php if (((is_array($_tmp='bank_name')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
                                        <tr>
                                            <th>銀行名</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="bank_name" value="<?php echo $this->_tpl_vars['userData']['bank_name']; ?>
" size="20">
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if (((is_array($_tmp='bank_code')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
                                        <tr>
                                            <th>銀行コード</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="bank_code" value="<?php echo $this->_tpl_vars['userData']['bank_code']; ?>
" style="ime-mode:disabled" size="7">
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if (((is_array($_tmp='branch_name')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
                                        <tr>
                                            <th>支店名</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="branch_name" value="<?php echo $this->_tpl_vars['userData']['branch_name']; ?>
" size="20">
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if (((is_array($_tmp='branch_code')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
                                        <tr>
                                            <th>支店コード</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="branch_code" value="<?php echo $this->_tpl_vars['userData']['branch_code']; ?>
" style="ime-mode:disabled" size="7">
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if (((is_array($_tmp='type')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
                                        <tr>
                                            <th>種別</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="type" value="<?php echo $this->_tpl_vars['userData']['type']; ?>
" size="6">
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if (((is_array($_tmp='account_number')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
                                        <tr>
                                            <th>口座番号</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="account_number" value="<?php echo $this->_tpl_vars['userData']['account_number']; ?>
" style="ime-mode:disabled" size="10" maxlength="7">
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if (((is_array($_tmp='account_holder_name')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
                                        <tr>
                                            <th>名義人</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="account_holder_name" value="<?php echo $this->_tpl_vars['userData']['account_holder_name']; ?>
" size="20">
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if (((is_array($_tmp='postal_code')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
                                        <tr>
                                            <th>郵便番号</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="postal_code" value="<?php echo $this->_tpl_vars['userData']['postal_code']; ?>
" style="ime-mode:disabled" size="10" maxlength="7">
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if (((is_array($_tmp='address')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
                                        <tr>
                                            <th>住所</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="address" value="<?php echo $this->_tpl_vars['userData']['address']; ?>
" size="70">
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if (((is_array($_tmp='address_name')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
                                        <tr>
                                            <th>名前</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="address_name" value="<?php echo $this->_tpl_vars['userData']['address_name']; ?>
" size="20">
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if (((is_array($_tmp='phone_number')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
                                        <tr>
                                            <th>電話番号1</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="phone_number" value="<?php echo $this->_tpl_vars['userData']['phone_number']; ?>
" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>電話番号2</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="phone_number2" value="<?php echo $this->_tpl_vars['userData']['phone_number2']; ?>
" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>電話番号3</th>
                                            <td style="text-align: left;">
                                                <input type="text" name="phone_number3" value="<?php echo $this->_tpl_vars['userData']['phone_number3']; ?>
" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>電話受信設定</th>
                                            <td style="text-align: left;">
                                                <?php echo smarty_function_html_options(array('name' => 'phone_is_use','options' => $this->_tpl_vars['phoneIsUse'],'selected' => $this->_tpl_vars['userData']['phone_is_use']), $this);?>

                                             </td>
                                        </tr>
                                        <?php endif; ?>
                                        <tr>
                                            <th>備考</th>
                                            <td style="text-align: left;">
                                                <textarea name="description" rows="5" cols="50"><?php echo $this->_tpl_vars['userData']['description']; ?>
</textarea>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align:top;text-align:right;">
                        <input type="submit" name="action_user_UpdateExec" value="更新" OnClick="return confirm('更新しますか？')" style="width:8em;"/>
                    </td>
                </tr>
                                <?php if ($this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SYSTEM'] || $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_MANAGE']): ?>
                <tr>
                    <td style="vertical-align:top;">
                        <input type="submit" name="action_user_DeleteExec" value="削除" OnClick="return confirm('本当に削除しますか？')" style="width:8em;"/>
                    </td>
                </tr>
                <?php endif; ?>
            </table>
        </form>
    <?php else: ?>
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
</div>
<script type="text/javascript" src="./js/jquery.timepickr.min.js"></script>
<script language="JavaScript">
<!--
    $(function() {

        // カレンダー
        $(".datepicker").datepicker({
            showOn: 'button',
            buttonImage: './img/calendar.gif',
            buttonImageOnly: true,
            dateFormat: "yy-mm-dd"
        });

    });

// -->
</script>
</body>
</html>