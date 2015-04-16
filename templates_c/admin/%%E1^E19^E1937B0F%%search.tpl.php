<?php /* Smarty version 2.6.26, created on 2015-02-20 12:28:23
         compiled from /home/suraimu/templates/admin/user/search.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/user/search.tpl', 12, false),array('modifier', 'implode', '/home/suraimu/templates/admin/user/search.tpl', 18, false),array('modifier', 'default', '/home/suraimu/templates/admin/user/search.tpl', 50, false),array('modifier', 'zend_date_format', '/home/suraimu/templates/admin/user/search.tpl', 361, false),array('modifier', 'cat', '/home/suraimu/templates/admin/user/search.tpl', 475, false),array('function', 'make_link', '/home/suraimu/templates/admin/user/search.tpl', 27, false),array('function', 'html_radios', '/home/suraimu/templates/admin/user/search.tpl', 50, false),array('function', 'html_checkboxes', '/home/suraimu/templates/admin/user/search.tpl', 56, false),array('function', 'cycle', '/home/suraimu/templates/admin/user/search.tpl', 196, false),array('function', 'html_options', '/home/suraimu/templates/admin/user/search.tpl', 222, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
<style type="text/css">
.watermark {
   color: #999;
}
</style>
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">ユーザー検索</h2>
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
<table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
    <tr>
        <th style="text-align: center; font-weight: bold;">検索条件ロード<br><a href="<?php echo smarty_function_make_link(array('action' => 'action_user_SearchConditionList'), $this);?>
" target="_blank">検索条件保存リスト</a></th>
    </tr>
        <tr>
            <td>
                <form action="./" method="POST">
                    検索条件保存ID：<input type="text" name="search_conditions_id" value="" size="7" style="ime-mode:disabled">
                    <input type="submit" name="action_user_Search" value="検索条件ロード">
                </form>
            </td>
        </tr>
</table>
<br>
<form action="./" method="post" name="userSearch">
<?php echo $this->_tpl_vars['POSTparam']; ?>

<table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet01" width="95%">

<tr>
<th colspan="2" style="text-align: center; font-weight: bold;">ユーザー情報関連</th>
</tr>

<tr>
    <td>ユーザーID<br>(カンマ区切りで複数可)</td>
    <td style="text-align: left;">
        <input type="text" name="user_id" value="<?php echo $this->_tpl_vars['value']['user_id']; ?>
" size="30" style="ime-mode:disabled">&nbsp;&nbsp;<?php echo smarty_function_html_radios(array('id' => 'user_id_specify_target_including','name' => 'user_id_specify_target_including','options' => $this->_tpl_vars['config']['admin_config']['specify_target_including'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['value']['user_id_specify_target_including'])) ? $this->_run_mod_handler('default', true, $_tmp, '1') : smarty_modifier_default($_tmp, '1')),'separator' => "&nbsp;"), $this);?>

    </td>
</tr>
<tr>
    <td>性別</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_checkboxes(array('name' => 'sex_cd','options' => $this->_tpl_vars['config']['admin_config']['sex_cd'],'selected' => $this->_tpl_vars['value']['sex_cd'],'separator' => "&nbsp;"), $this);?>

    </td>
</tr>
<tr>
    <td>ログインID<br>(前方一致)</td>
    <td style="text-align: left;">
        <div id="login_id">
            <input type="text" name="login_id" value="<?php echo $this->_tpl_vars['value']['login_id']; ?>
" size="30" style="ime-mode:disabled">
        </div>
    </td>
</tr>
<tr>
    <td>PCアドレス</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_radios(array('id' => 'pc_specify_address','name' => 'pc_specify_address','options' => $this->_tpl_vars['config']['admin_config']['specify_address'],'selected' => $this->_tpl_vars['value']['pc_specify_address'],'separator' => "&nbsp;"), $this);?>

        <div id="pc_address">
            <input type="text" name="pc_address" value="<?php echo $this->_tpl_vars['value']['pc_address']; ?>
" size="30" style="ime-mode:disabled">
        </div>
    </td>
</tr>
<tr>
    <td>MBアドレス</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_radios(array('id' => 'mb_specify_address','name' => 'mb_specify_address','options' => $this->_tpl_vars['config']['admin_config']['specify_address'],'selected' => $this->_tpl_vars['value']['mb_specify_address'],'separator' => "&nbsp;"), $this);?>

        <div id="mb_address">
            <input type="text" name="mb_address" value="<?php echo $this->_tpl_vars['value']['mb_address']; ?>
" size="30" style="ime-mode:disabled">
        </div>
    </td>
</tr>
<tr>
    <td>PCデバイス</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_checkboxes(array('name' => 'pc_device_cd','options' => $this->_tpl_vars['config']['admin_config']['pc_device'],'selected' => $this->_tpl_vars['value']['pc_device_cd'],'separator' => "&nbsp;"), $this);?>

    </td>
</tr>
<tr>
    <td>MBデバイス</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_checkboxes(array('name' => 'mb_device_cd','options' => $this->_tpl_vars['config']['admin_config']['mb_device'],'selected' => $this->_tpl_vars['value']['mb_device_cd'],'separator' => "&nbsp;"), $this);?>

    </td>
</tr>
<tr>
    <td>個体識別番号<br>(前方一致)</td>
    <td style="text-align: left;">
        <div id="mb_serial_number">
            <input type="text" name="mb_serial_number" value="<?php echo $this->_tpl_vars['value']['mb_serial_number']; ?>
" size="50" style="ime-mode:disabled">
        </div>
    </td>
</tr>
<tr>
    <td>PC IPｱﾄﾞﾚｽ<br>(前方一致)</td>
    <td style="text-align: left;">
        <div id="pc_ip_address">
            <input type="text" name="pc_ip_address" value="<?php echo $this->_tpl_vars['value']['pc_ip_address']; ?>
" size="50" style="ime-mode:disabled">
        </div>
    </td>
</tr>
<tr>
    <td>ｽﾏｰﾄﾌｫﾝOS</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_checkboxes(array('name' => 'smart_phone_os','options' => $this->_tpl_vars['config']['admin_config']['smart_phone_os'],'selected' => $this->_tpl_vars['value']['smart_phone_os'],'separator' => "&nbsp;"), $this);?>

    </td>
</tr>
<tr>
    <td>ユーザーステイタス</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_checkboxes(array('name' => 'regist_status','options' => $this->_tpl_vars['config']['admin_config']['regist_status'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['value']['regist_status'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['defaultRegistUserStatus']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['defaultRegistUserStatus'])),'separator' => "&nbsp;"), $this);?>

    </td>
</tr>
<tr>
    <td>PCｱﾄﾞﾚｽｽﾃｲﾀｽ</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_checkboxes(array('name' => 'pc_address_status','options' => $this->_tpl_vars['config']['admin_config']['address_status'],'selected' => $this->_tpl_vars['value']['pc_address_status'],'separator' => "&nbsp;"), $this);?>

    </td>
</tr>
<tr>
    <td>PC送信ｽﾃｲﾀｽ</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_checkboxes(array('name' => 'pc_send_status','options' => $this->_tpl_vars['config']['admin_config']['address_send_status'],'selected' => $this->_tpl_vars['value']['pc_send_status'],'separator' => "&nbsp;"), $this);?>

    </td>
</tr>
<tr>
    <td>PCﾒｰﾙ受信設定</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_checkboxes(array('name' => 'pc_is_mailmagazine','options' => $this->_tpl_vars['config']['common_config']['is_mailmagazine'],'selected' => $this->_tpl_vars['value']['pc_is_mailmagazine'],'separator' => "&nbsp;"), $this);?>

    </td>
</tr>
<tr>
    <td>MBｱﾄﾞﾚｽｽﾃｲﾀｽ</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_checkboxes(array('name' => 'mb_address_status','options' => $this->_tpl_vars['config']['admin_config']['address_status'],'selected' => $this->_tpl_vars['value']['mb_address_status'],'separator' => "&nbsp;"), $this);?>

    </td>
</tr>
<tr>
    <td>MB送信ｽﾃｲﾀｽ</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_checkboxes(array('name' => 'mb_send_status','options' => $this->_tpl_vars['config']['admin_config']['address_send_status'],'selected' => $this->_tpl_vars['value']['mb_send_status'],'separator' => "&nbsp;"), $this);?>

    </td>
</tr>
<tr>
    <td>MBﾒｰﾙ受信設定</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_checkboxes(array('name' => 'mb_is_mailmagazine','options' => $this->_tpl_vars['config']['common_config']['is_mailmagazine'],'selected' => $this->_tpl_vars['value']['mb_is_mailmagazine'],'separator' => "&nbsp;"), $this);?>

    </td>
</tr>
<tr>
    <td>ｱﾄﾞﾚｽｽﾃｲﾀｽ</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_checkboxes(array('name' => 'is_address_status_or','options' => $this->_tpl_vars['config']['admin_config']['is_address_send_status_or'],'selected' => $this->_tpl_vars['value']['is_address_status_or'],'separator' => "&nbsp;"), $this);?>

    </td>
</tr>
<tr>
    <td>ﾒｰﾙ送信ｽﾃｲﾀｽ</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_checkboxes(array('name' => 'is_address_send_status_or','options' => $this->_tpl_vars['config']['admin_config']['is_address_send_status_or'],'selected' => $this->_tpl_vars['value']['is_address_send_status_or'],'separator' => "&nbsp;"), $this);?>

    </td>
</tr>
<tr>
    <td>ﾒｰﾙ受信設定</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_checkboxes(array('name' => 'is_mailmagazine_or','options' => $this->_tpl_vars['config']['admin_config']['is_mailmagazine_or'],'selected' => $this->_tpl_vars['value']['is_mailmagazine_or'],'separator' => "&nbsp;"), $this);?>

    </td>
</tr>
<tr>
    <td>PCﾒｰﾙ強行</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_checkboxes(array('name' => 'is_pc_reverse','options' => $this->_tpl_vars['config']['admin_config']['reverse_status'],'selected' => $this->_tpl_vars['value']['is_pc_reverse'],'separator' => "&nbsp;"), $this);?>

    </td>
</tr>
<tr>
    <td>MBﾒｰﾙ強行</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_checkboxes(array('name' => 'is_mb_reverse','options' => $this->_tpl_vars['config']['admin_config']['reverse_status'],'selected' => $this->_tpl_vars['value']['is_mb_reverse'],'separator' => "&nbsp;"), $this);?>

    </td>
</tr>
<tr>
    <td>PC配信ドメイン</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_checkboxes(array('name' => 'pc_send_domain_type','options' => $this->_tpl_vars['sendDomainType'],'selected' => $this->_tpl_vars['value']['pc_send_domain_type'],'separator' => "&nbsp;",'assign' => 'checkboxes'), $this);?>

        <?php $_from = $this->_tpl_vars['checkboxes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['checkbox']):
?>
            <?php echo $this->_tpl_vars['checkbox']; ?>
<?php echo smarty_function_cycle(array('values' => ",,,<br />"), $this);?>

        <?php endforeach; endif; unset($_from); ?>
    </td>
</tr>
<tr>
    <td>MB配信ドメイン</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_checkboxes(array('name' => 'mb_send_domain_type','options' => $this->_tpl_vars['sendDomainType'],'selected' => $this->_tpl_vars['value']['mb_send_domain_type'],'separator' => "&nbsp;",'assign' => 'checkboxes'), $this);?>

        <?php $_from = $this->_tpl_vars['checkboxes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['checkbox']):
?>
            <?php echo $this->_tpl_vars['checkbox']; ?>
<?php echo smarty_function_cycle(array('values' => ",,,<br />"), $this);?>

        <?php endforeach; endif; unset($_from); ?>
    </td>
</tr>
<tr>
    <td>電話番号</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_radios(array('id' => 'specify_phone_number','name' => 'specify_phone_number','options' => $this->_tpl_vars['config']['admin_config']['specify_address'],'selected' => $this->_tpl_vars['value']['specify_phone_number'],'separator' => "&nbsp;"), $this);?>

        <div id="phone_number">
            <input type="text" name="phone_number" value="<?php echo $this->_tpl_vars['value']['phone_number']; ?>
" size="30" style="ime-mode:disabled">
        </div>
    </td>
</tr>

<tr>
    <td>電話受信</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_options(array('name' => 'phone_is_use','options' => $this->_tpl_vars['phoneIsUse'],'selected' => $this->_tpl_vars['value']['phone_is_use']), $this);?>

    </td>
</tr>
<tr>
    <td>ブラック</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_checkboxes(array('name' => 'danger_status','options' => $this->_tpl_vars['config']['admin_config']['danger_status'],'selected' => $this->_tpl_vars['value']['danger_status'],'separator' => "&nbsp;"), $this);?>

    </td>
</tr>
<tr>
    <td>入金種別</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_checkboxes(array('name' => 'pay_type','options' => $this->_tpl_vars['payType'],'selected' => $this->_tpl_vars['value']['pay_type'],'separator' => "&nbsp;",'assign' => 'checkboxes'), $this);?>

        <?php $_from = $this->_tpl_vars['checkboxes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['checkbox']):
?>
            <?php echo $this->_tpl_vars['checkbox']; ?>
<?php echo smarty_function_cycle(array('values' => ",,,<br />"), $this);?>

        <?php endforeach; endif; unset($_from); ?>
    </td>
</tr>
<tr>
<td>購入商品ID<br>(カンマ区切りで複数可)</td>
    <td style="text-align: left;">
        <div>
            対象を抽出：<input type="text" name="item_id" value="<?php echo $this->_tpl_vars['value']['item_id']; ?>
" size="20" style="ime-mode:disabled;">&nbsp;&nbsp;<?php echo smarty_function_html_radios(array('id' => 'item_specify_target_select','name' => 'item_specify_target_select','options' => $this->_tpl_vars['config']['admin_config']['specify_target_select'],'selected' => $this->_tpl_vars['value']['item_specify_target_select'],'separator' => "&nbsp;"), $this);?>

        </div>
        <div>
            以外を抽出：<input type="text" name="except_item_id" value="<?php echo $this->_tpl_vars['value']['except_item_id']; ?>
" size="20" style="ime-mode:disabled;">&nbsp;&nbsp;<?php echo smarty_function_html_radios(array('id' => 'except_item_specify_target_select','name' => 'except_item_specify_target_select','options' => $this->_tpl_vars['config']['admin_config']['specify_target_select'],'selected' => $this->_tpl_vars['value']['except_item_specify_target_select'],'separator' => "&nbsp;"), $this);?>

        </div>
    </td>
</tr>

<tr>
<td>ユニットID<br>(カンマ区切りで複数可)<br>※5個まで(推奨)※</td>
    <td style="text-align: left;">
        <div>
            対象を抽出：<input type="text" name="unit_id" value="<?php echo $this->_tpl_vars['value']['unit_id']; ?>
" size="20" style="ime-mode:disabled;">&nbsp;&nbsp;<?php echo smarty_function_html_radios(array('id' => 'unit_specify_target_select','name' => 'unit_specify_target_select','options' => $this->_tpl_vars['config']['admin_config']['specify_target_select'],'selected' => $this->_tpl_vars['value']['unit_specify_target_select'],'separator' => "&nbsp;"), $this);?>

        </div>
        <div>
            以外を抽出：<input type="text" name="except_unit_id" value="<?php echo $this->_tpl_vars['value']['except_unit_id']; ?>
" size="20" style="ime-mode:disabled;">&nbsp;&nbsp;<?php echo smarty_function_html_radios(array('id' => 'except_unit_specify_target_select','name' => 'except_unit_specify_target_select','options' => $this->_tpl_vars['config']['admin_config']['specify_target_select'],'selected' => $this->_tpl_vars['value']['except_unit_specify_target_select'],'separator' => "&nbsp;"), $this);?>

        </div>
    </td>
</tr>

<tr>
<td>抽選ユニットID<br>(カンマ区切りで複数可)</td>
    <td style="text-align: left;">
        <div>
            対象を抽出：<input type="text" name="lottery_unit_id" value="<?php echo $this->_tpl_vars['value']['lottery_unit_id']; ?>
" size="20" style="ime-mode:disabled;">&nbsp;&nbsp;<?php echo smarty_function_html_radios(array('id' => 'lottery_unit_specify_target_select','name' => 'lottery_unit_specify_target_select','options' => $this->_tpl_vars['config']['admin_config']['specify_target_select'],'selected' => $this->_tpl_vars['value']['lottery_unit_specify_target_select'],'separator' => "&nbsp;"), $this);?>

        </div>
        <div>
            以外を抽出：<input type="text" name="except_lottery_unit_id" value="<?php echo $this->_tpl_vars['value']['except_lottery_unit_id']; ?>
" size="20" style="ime-mode:disabled;">&nbsp;&nbsp;<?php echo smarty_function_html_radios(array('id' => 'except_lottery_unit_specify_target_select','name' => 'except_lottery_unit_specify_target_select','options' => $this->_tpl_vars['config']['admin_config']['specify_target_select'],'selected' => $this->_tpl_vars['value']['except_lottery_unit_specify_target_select'],'separator' => "&nbsp;"), $this);?>

        </div>
    </td>
</tr>

<tr>
<td>既読情報ID<br>(カンマ区切りで複数可)</td>
    <td style="text-align: left;">
        <div>
            対象を抽出：<input type="text" name="information_id" value="<?php echo $this->_tpl_vars['value']['information_id']; ?>
" size="20" style="ime-mode:disabled;">&nbsp;&nbsp;<?php echo smarty_function_html_radios(array('id' => 'information_specify_target_select','name' => 'information_specify_target_select','options' => $this->_tpl_vars['config']['admin_config']['specify_target_select'],'selected' => $this->_tpl_vars['value']['information_specify_target_select'],'separator' => "&nbsp;"), $this);?>

        </div>
        <div>
            以外を抽出：<input type="text" name="except_information_id" value="<?php echo $this->_tpl_vars['value']['except_information_id']; ?>
" size="20" style="ime-mode:disabled;">&nbsp;&nbsp;<?php echo smarty_function_html_radios(array('id' => 'except_information_specify_target_select','name' => 'except_information_specify_target_select','options' => $this->_tpl_vars['config']['admin_config']['specify_target_select'],'selected' => $this->_tpl_vars['value']['except_information_specify_target_select'],'separator' => "&nbsp;"), $this);?>

        </div>
    </td>
</tr>
<!--
<tr>
    <td>注文検索（商品ＩＤ）</td>
    <td style="text-align: left;">
        <div id="ordering_item_id">
            <input type="text" name="ordering_item_id" value="<?php echo $this->_tpl_vars['value']['ordering_item_id']; ?>
" size="10" style="ime-mode:disabled">
            <font color="red">※入金無し対象</font>
        </div>
        <?php echo smarty_function_html_checkboxes(array('name' => 'is_cancel','id' => 'is_cancel','options' => $this->_tpl_vars['cancelFlag'],'selected' => $this->_tpl_vars['value']['is_cancel'],'separator' => "&nbsp;"), $this);?>

    </td>
</tr>
-->

<tr>
    <td>注文検索（商品ＩＤ）</td>
    <td style="text-align: left;">
        <div id="ordering_item_id">
                      対象を抽出：<input type="text" name="ordering_item_id" value="<?php echo $this->_tpl_vars['value']['ordering_item_id']; ?>
" size="20" style="ime-mode:disabled;">&nbsp;&nbsp;<?php echo smarty_function_html_radios(array('id' => 'ordering_item_specify_target_select','name' => 'ordering_item_specify_target_select','options' => $this->_tpl_vars['config']['admin_config']['specify_target_select'],'selected' => $this->_tpl_vars['value']['ordering_item_specify_target_select'],'separator' => "&nbsp;"), $this);?>

        </div>
        <div id="ordering_item_id">
                      以外を抽出：<input type="text" name="except_ordering_item_id" value="<?php echo $this->_tpl_vars['value']['except_ordering_item_id']; ?>
" size="20" style="ime-mode:disabled;">&nbsp;&nbsp;<?php echo smarty_function_html_radios(array('id' => 'except_ordering_item_specify_target_select','name' => 'except_ordering_item_specify_target_select','options' => $this->_tpl_vars['config']['admin_config']['specify_target_select'],'selected' => $this->_tpl_vars['value']['except_ordering_item_specify_target_select'],'separator' => "&nbsp;"), $this);?>

        </div>
        <?php echo smarty_function_html_checkboxes(array('name' => 'is_cancel','id' => 'is_cancel','options' => $this->_tpl_vars['cancelFlag'],'selected' => $this->_tpl_vars['value']['is_cancel'],'separator' => "&nbsp;"), $this);?>

        <font color="red">※入金無し対象</font>
    </td>
</tr>

<tr>
    <td>登録入口カテゴリー</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_checkboxes(array('name' => 'regist_page_category_id','options' => $this->_tpl_vars['registPageCategoryList'],'selected' => $this->_tpl_vars['value']['regist_page_category_id'],'separator' => "&nbsp;",'assign' => 'checkboxes'), $this);?>

        <?php $_from = $this->_tpl_vars['checkboxes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['checkbox']):
?>
            <?php echo $this->_tpl_vars['checkbox']; ?>
<?php echo smarty_function_cycle(array('values' => ",,,<br />"), $this);?>

        <?php endforeach; endif; unset($_from); ?>
    </td>
</tr>

<tr>
<td>登録入口ID<br>(カンマ区切りで複数可)</td>
    <td style="text-align: left;">
        <div>
            対象を抽出：<input type="text" name="regist_page_id" value="<?php echo $this->_tpl_vars['value']['regist_page_id']; ?>
" size="20" style="ime-mode:disabled;">
        </div>
        <div>
            以外を抽出：<input type="text" name="except_regist_page_id" value="<?php echo $this->_tpl_vars['value']['except_regist_page_id']; ?>
" size="20" style="ime-mode:disabled;">
        </div>
    </td>
</tr>
<tr>
<td>検索保存条件を省く(除外)</td>
<td style="text-align: left;">
      <input type="text" name="search_condition_ids" value="<?php echo $this->_tpl_vars['value']['search_condition_ids']; ?>
" size="20" style="ime-mode:disabled;">
    </td>
</tr>
<tr>
<td>ログイン後トップアクセス</td>
    <td style="text-align: left;">
       登録日時とﾛｸﾞｲﾝ後ﾄｯﾌﾟｱｸｾｽ日時の差分
        <input type="text" name="difference_between_regist_and_home_from" value="<?php echo $this->_tpl_vars['value']['difference_between_regist_and_home_from']; ?>
" size="5" style="ime-mode:disabled;text-align:right;">
        秒から
        <input type="text" name="difference_between_regist_and_home_to" value="<?php echo $this->_tpl_vars['value']['difference_between_regist_and_home_to']; ?>
" size="5" style="ime-mode:disabled;text-align:right;">
        秒   <font color="red">※両方のﾌｫｰﾑに値を入れて下さい</font><br>
       <input type="checkbox" name="is_home_acccess_datetime" value="1" <?php if ($this->_tpl_vars['value']['is_home_acccess_datetime']): ?> checked/ <?php endif; ?>>ﾛｸﾞｲﾝ後ﾄｯﾌﾟｱｸｾｽ有り
       <input type="checkbox" name="is_not_home_acccess_datetime" value="1" <?php if ($this->_tpl_vars['value']['is_not_home_acccess_datetime']): ?> checked/ <?php endif; ?>>ﾛｸﾞｲﾝ後ﾄｯﾌﾟｱｸｾｽ無し
    </td>
</tr>
<tr>
    <td>最終アクセス日</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_radios(array('id' => 'last_access','name' => 'specify_last_access','options' => $this->_tpl_vars['config']['admin_config']['specify_date_time_select'],'selected' => $this->_tpl_vars['value']['specify_last_access'],'separator' => "&nbsp;"), $this);?>

        <br>
        <?php echo smarty_function_html_radios(array('id' => 'last_access','name' => 'specify_last_access','options' => $this->_tpl_vars['config']['admin_config']['specify_month_select'],'selected' => $this->_tpl_vars['value']['specify_last_access'],'separator' => "&nbsp;"), $this);?>

        <br>
        <div id="last_access_date">
            <input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['lastAccessDatetimeFrom'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="last_access_from_Date" maxlength="10">
            <input name="last_access_from_Time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['lastAccessDatetimeFrom'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
            ～&nbsp;<input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['lastAccessDatetimeTo'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="last_access_to_Date" maxlength="10">
            <input name="last_access_to_Time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['lastAccessDatetimeTo'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
        </div>
        <div id="last_access_time">
            <input type="text" name="last_access_time_from" value="<?php echo $this->_tpl_vars['value']['last_access_time_from']; ?>
" size="4" maxlength="4" style="ime-mode:disabled;text-align:right;">
            時間前以上
            <input type="text" name="last_access_time_to" value="<?php echo $this->_tpl_vars['value']['last_access_time_to']; ?>
" size="4" maxlength="4" style="ime-mode:disabled;text-align:right;">
            時間前未満
        </div>
    </td>
</tr>
<tr>
    <td>アクセスなし<br> <font color="red">※アクセス  0000-00-00も含みます</font></td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_radios(array('id' => 'not_access','name' => 'specify_not_access','options' => $this->_tpl_vars['config']['admin_config']['specify_date_time_select'],'selected' => $this->_tpl_vars['value']['specify_not_access'],'separator' => "&nbsp;"), $this);?>

        <br>
        <?php echo smarty_function_html_radios(array('id' => 'not_access','name' => 'specify_not_access','options' => $this->_tpl_vars['config']['admin_config']['specify_month_select'],'selected' => $this->_tpl_vars['value']['specify_not_access'],'separator' => "&nbsp;"), $this);?>

        <br>
        <div id="not_access_date">
            <input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['notAccessDatetimeFrom'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="not_access_from_Date" maxlength="10">
            <input name="not_access_from_Time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['notAccessDatetimeFrom'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
            <span style="color:#ff0000;">←のみの入力はNG</span>
            ～&nbsp;<input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['notAccessDatetimeTo'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="not_access_to_Date" maxlength="10">
            <input name="not_access_to_Time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['notAccessDatetimeTo'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
            <span style="color:#ff0000;">←のみの入力はOK</span>
        </div>
        <div id="not_access_time">
            <input type="text" name="not_access_time_from" value="<?php echo $this->_tpl_vars['value']['not_access_time_from']; ?>
" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
            時間前以上<span style="color:#ff0000;">←のみの入力はNG</span>
            <input type="text" name="not_access_time_to" value="<?php echo $this->_tpl_vars['value']['not_access_time_to']; ?>
" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
            時間前未満<span style="color:#ff0000;">←のみの入力はOK</span>
        </div>
    </td>
</tr>
<tr>
    <td>アクセス日時あり</td>
    <td style="text-align: left;">
        <input type="checkbox" name="except_access_no_data" value="1" <?php if ($this->_tpl_vars['value']['except_access_no_data']): ?> checked/ <?php endif; ?>>アクセス日時 0000-00-00
    </td>
</tr>
<tr>
    <td>アクセス日時 0000-00-00</td>
    <td style="text-align: left;">
        <input type="checkbox" name="access_no_data" value="1" <?php if ($this->_tpl_vars['value']['access_no_data']): ?> checked/ <?php endif; ?>>アクセス日時 0000-00-00
    </td>
</tr>
<tr>
    <td>仮登録日</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_radios(array('id' => 'pre_regist','name' => 'specify_pre_regist','options' => $this->_tpl_vars['config']['admin_config']['specify_date_time_select'],'selected' => $this->_tpl_vars['value']['specify_pre_regist'],'separator' => "&nbsp;"), $this);?>

        <br>
        <div id="pre_regist_date">
            <input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['preRegistDatetimeFrom'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="pre_regist_from_Date" maxlength="10">
            <input name="pre_regist_from_Time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['preRegistDatetimeFrom'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
            ～&nbsp;<input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['preRegistDatetimeTo'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="pre_regist_to_Date" maxlength="10">
            <input name="pre_regist_to_Time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['preRegistDatetimeTo'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
        </div>
        <div id="pre_regist_time">
            <input type="text" name="pre_regist_time_from" value="<?php echo $this->_tpl_vars['value']['pre_regist_time_from']; ?>
" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
            時間前以上
            <input type="text" name="pre_regist_time_to" value="<?php echo $this->_tpl_vars['value']['pre_regist_time_to']; ?>
" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
            時間前未満
        </div>
    </td>
</tr>

<tr>
    <td>登録日</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_radios(array('id' => 'regist','name' => 'specify_regist','options' => $this->_tpl_vars['config']['admin_config']['specify_date_time_select'],'selected' => $this->_tpl_vars['value']['specify_regist'],'separator' => "&nbsp;"), $this);?>

        <br>
        <div id="regist_date">
            <input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['registDatetimeFrom'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="regist_from_Date" maxlength="10">
            <input name="regist_from_Time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['registDatetimeFrom'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
            ～&nbsp;<input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['registDatetimeTo'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="regist_to_Date" maxlength="10">
            <input name="regist_to_Time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['registDatetimeTo'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
        </div>
        <div id="regist_time">
            <input type="text" name="regist_time_from" value="<?php echo $this->_tpl_vars['value']['regist_time_from']; ?>
" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
            時間前以上
            <input type="text" name="regist_time_to" value="<?php echo $this->_tpl_vars['value']['regist_time_to']; ?>
" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
            時間前未満
        </div>
    </td>
</tr>

<tr>
<td>仮登録経過日</td>
    <td style="text-align: left;">
        <input type="text" class="from" name="pre_past_date_from" value="<?php echo $this->_tpl_vars['value']['pre_past_date_from']; ?>
" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
        日前以上
        <input type="text" class="to" name="pre_past_date_to" value="<?php echo $this->_tpl_vars['value']['pre_past_date_to']; ?>
" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
        日前まで
    </td>
</tr>
<tr>
<td>登録経過日</td>
    <td style="text-align: left;">
        <input type="text" class="from" name="past_date_from" value="<?php echo $this->_tpl_vars['value']['past_date_from']; ?>
" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
        日前以上
        <input type="text" class="to" name="past_date_to" value="<?php echo $this->_tpl_vars['value']['past_date_to']; ?>
" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
        日前まで
    </td>
</tr>

<tr>
    <td>フリーワード数字(ﾕｰｻﾞｰ選択)</td>
    <td style="text-align: left;">
       <?php echo smarty_function_html_radios(array('id' => 'specify_free_word','name' => 'specify_free_word','options' => $this->_tpl_vars['freeWord'],'selected' => $this->_tpl_vars['value']['specify_free_word'],'separator' => "&nbsp;"), $this);?>

        &nbsp;&nbsp;&nbsp;小～大 は必ず入力して下さい。
        <div id="free_word_data">
            <?php unset($this->_sections['cnt']);
$this->_sections['cnt']['name'] = 'cnt';
$this->_sections['cnt']['start'] = (int)1;
$this->_sections['cnt']['loop'] = is_array($_loop=11) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['cnt']['show'] = true;
$this->_sections['cnt']['max'] = $this->_sections['cnt']['loop'];
$this->_sections['cnt']['step'] = 1;
if ($this->_sections['cnt']['start'] < 0)
    $this->_sections['cnt']['start'] = max($this->_sections['cnt']['step'] > 0 ? 0 : -1, $this->_sections['cnt']['loop'] + $this->_sections['cnt']['start']);
else
    $this->_sections['cnt']['start'] = min($this->_sections['cnt']['start'], $this->_sections['cnt']['step'] > 0 ? $this->_sections['cnt']['loop'] : $this->_sections['cnt']['loop']-1);
if ($this->_sections['cnt']['show']) {
    $this->_sections['cnt']['total'] = min(ceil(($this->_sections['cnt']['step'] > 0 ? $this->_sections['cnt']['loop'] - $this->_sections['cnt']['start'] : $this->_sections['cnt']['start']+1)/abs($this->_sections['cnt']['step'])), $this->_sections['cnt']['max']);
    if ($this->_sections['cnt']['total'] == 0)
        $this->_sections['cnt']['show'] = false;
} else
    $this->_sections['cnt']['total'] = 0;
if ($this->_sections['cnt']['show']):

            for ($this->_sections['cnt']['index'] = $this->_sections['cnt']['start'], $this->_sections['cnt']['iteration'] = 1;
                 $this->_sections['cnt']['iteration'] <= $this->_sections['cnt']['total'];
                 $this->_sections['cnt']['index'] += $this->_sections['cnt']['step'], $this->_sections['cnt']['iteration']++):
$this->_sections['cnt']['rownum'] = $this->_sections['cnt']['iteration'];
$this->_sections['cnt']['index_prev'] = $this->_sections['cnt']['index'] - $this->_sections['cnt']['step'];
$this->_sections['cnt']['index_next'] = $this->_sections['cnt']['index'] + $this->_sections['cnt']['step'];
$this->_sections['cnt']['first']      = ($this->_sections['cnt']['iteration'] == 1);
$this->_sections['cnt']['last']       = ($this->_sections['cnt']['iteration'] == $this->_sections['cnt']['total']);
?>
                <?php $this->assign('countA', ((is_array($_tmp=$this->_tpl_vars['countA'])) ? $this->_run_mod_handler('cat', true, $_tmp, '0') : smarty_modifier_cat($_tmp, '0'))); ?>
                <?php $this->assign('countB', ((is_array($_tmp=$this->_tpl_vars['countB'])) ? $this->_run_mod_handler('cat', true, $_tmp, '9') : smarty_modifier_cat($_tmp, '9'))); ?>

                <?php $this->assign('free_word_type_from', ((is_array($_tmp='free_word_type_from_1__')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_sections['cnt']['index']) : smarty_modifier_cat($_tmp, $this->_sections['cnt']['index']))); ?>
                <?php $this->assign('free_word_type_to', ((is_array($_tmp='free_word_type_to_1__')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_sections['cnt']['index']) : smarty_modifier_cat($_tmp, $this->_sections['cnt']['index']))); ?>
                <?php $this->assign('specify_free_word_type', ((is_array($_tmp='specify_free_word_type_1__')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_sections['cnt']['index']) : smarty_modifier_cat($_tmp, $this->_sections['cnt']['index']))); ?>
                <?php echo smarty_function_html_radios(array('id' => ((is_array($_tmp='free_word_type_1__')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_sections['cnt']['index']) : smarty_modifier_cat($_tmp, $this->_sections['cnt']['index'])),'name' => ((is_array($_tmp='specify_free_word_type_1__')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_sections['cnt']['index']) : smarty_modifier_cat($_tmp, $this->_sections['cnt']['index'])),'options' => $this->_tpl_vars['isSetting'],'selected' => $this->_tpl_vars['value'][$this->_tpl_vars['specify_free_word_type']],'separator' => "&nbsp;"), $this);?>

                &nbsp;
                <input type="text" class="from" name="free_word_type_from_1__<?php echo $this->_sections['cnt']['index']; ?>
" value="<?php echo $this->_tpl_vars['value'][$this->_tpl_vars['free_word_type_from']]; ?>
" size="10" maxlength="<?php echo $this->_sections['cnt']['index']; ?>
" style="ime-mode:disabled;text-align:right;">
                <?php echo $this->_tpl_vars['countA']; ?>
～&nbsp;
                <input type="text" class="to" name="free_word_type_to_1__<?php echo $this->_sections['cnt']['index']; ?>
" value="<?php echo $this->_tpl_vars['value'][$this->_tpl_vars['free_word_type_to']]; ?>
" size="10" maxlength="<?php echo $this->_sections['cnt']['index']; ?>
" style="ime-mode:disabled;text-align:right;">
                <?php echo $this->_tpl_vars['countB']; ?>
&nbsp;<font color="red">-%free_word_1_<?php echo $this->_sections['cnt']['index']; ?>
- &nbsp&nbsp(<?php echo $this->_sections['cnt']['index']; ?>
桁)</font>
                <br>
            <?php endfor; endif; ?>
        </div>
    </td>
</tr>

<tr>
    <td>フリーワード文言(管理選択)</td>
    <td style="text-align: left;">
       <?php echo smarty_function_html_radios(array('id' => 'specify_free_word_set','name' => 'specify_free_word_set','options' => $this->_tpl_vars['freeWord'],'selected' => $this->_tpl_vars['value']['specify_free_word_set'],'separator' => "&nbsp;"), $this);?>

        &nbsp;&nbsp;&nbsp;小～大 は必ず入力して下さい。
        <div id="free_word_data_set">
            <?php $_from = $this->_tpl_vars['freeWordList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                <?php $this->assign('free_word_set_check', ((is_array($_tmp='free_word_type_set_2__')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['key']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['key']))); ?>
                <?php $this->assign('specify_free_word_type_set', ((is_array($_tmp='specify_free_word_type_set_2__')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['key']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['key']))); ?>
                <?php echo smarty_function_html_radios(array('id' => ((is_array($_tmp='specify_free_word_type_set_2__')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['key']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['key'])),'name' => ((is_array($_tmp='specify_free_word_type_set_2__')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['key']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['key'])),'options' => $this->_tpl_vars['isSetting'],'selected' => $this->_tpl_vars['value'][$this->_tpl_vars['specify_free_word_type_set']],'separator' => "&nbsp;"), $this);?>

                  ～&nbsp;<font color="red">-%free_word_2_<?php echo $this->_tpl_vars['key']; ?>
- </font><br>
                <?php echo smarty_function_html_checkboxes(array('name' => ((is_array($_tmp='free_word_type_set_2__')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['key']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['key'])),'options' => $this->_tpl_vars['item'],'selected' => $this->_tpl_vars['value'][$this->_tpl_vars['free_word_set_check']],'separator' => "&nbsp;"), $this);?>
<br><br>
            <?php endforeach; endif; unset($_from); ?>
        </div>
    </td>
</tr>

<tr>
    <td>期間消費ポイント</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_radios(array('id' => 'use_point','name' => 'specify_use_point','options' => $this->_tpl_vars['config']['admin_config']['specify_date_time_select'],'selected' => $this->_tpl_vars['value']['specify_use_point'],'separator' => "&nbsp;"), $this);?>

        <br>
        <div id="use_point_date">
            <input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['usePointDatetimeFrom'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="use_point_from_Date" maxlength="10">
            <input name="use_point_from_Time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['usePointDatetimeFrom'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
            ～&nbsp;<input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['usePointDatetimeTo'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="use_point_to_Date" maxlength="10">
            <input name="use_point_to_Time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['usePointDatetimeTo'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
        </div>
        <div id="use_point_time">
            <input type="text" name="use_point_time_from" value="<?php echo $this->_tpl_vars['value']['use_point_time_from']; ?>
" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
            時間前以上
            <input type="text" name="use_point_time_to" value="<?php echo $this->_tpl_vars['value']['use_point_time_to']; ?>
" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
            時間前未満
        </div>
        <div id="use_point_val">
            <input type="text" class="from" name="use_point_from" value="<?php echo $this->_tpl_vars['value']['use_point_from']; ?>
" size="5" style="ime-mode:disabled;text-align:right;">
            pt以上
            <input type="text" class="to" name="use_point_to" value="<?php echo $this->_tpl_vars['value']['use_point_to']; ?>
" size="5" style="ime-mode:disabled;text-align:right;">
            ptまで
        </div>
    </td>
</tr>

<tr>
<td>保有ポイント</td>
    <td style="text-align: left;">
        <input type="text" class="from" name="point_from" value="<?php echo $this->_tpl_vars['value']['point_from']; ?>
" size="5" style="ime-mode:disabled;text-align:right;">
        pt以上
        <input type="text" class="to" name="point_to" value="<?php echo $this->_tpl_vars['value']['point_to']; ?>
" size="5" style="ime-mode:disabled;text-align:right;">
        ptまで
    </td>
</tr>

<tr>
<td>合計付与ポイント</td>
    <td style="text-align: left;">
        <input type="text" class="from" name="total_addition_point_from" value="<?php echo $this->_tpl_vars['value']['total_addition_point_from']; ?>
" size="5" style="ime-mode:disabled;text-align:right;">
        pt以上
        <input type="text" class="to" name="total_addition_point_to" value="<?php echo $this->_tpl_vars['value']['total_addition_point_to']; ?>
" size="5" style="ime-mode:disabled;text-align:right;">
        ptまで
    </td>
</tr>

<tr>
<td>合計使用ポイント</td>
    <td style="text-align: left;">
        <input type="text" class="from" name="total_use_point_from" value="<?php echo $this->_tpl_vars['value']['total_use_point_from']; ?>
" size="5" style="ime-mode:disabled;text-align:right;">
        pt以上
        <input type="text" class="to" name="total_use_point_to" value="<?php echo $this->_tpl_vars['value']['total_use_point_to']; ?>
" size="5" style="ime-mode:disabled;text-align:right;">
        ptまで
    </td>
</tr>

<tr>
    <td>初回入金日</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_radios(array('id' => 'first_pay','name' => 'specify_first_pay','options' => $this->_tpl_vars['config']['admin_config']['specify_date_time_select'],'selected' => $this->_tpl_vars['value']['specify_first_pay'],'separator' => "&nbsp;"), $this);?>

        <br>
        <div id="first_pay_date">
            <input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['firstPayDatetimeFrom'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="first_pay_from_Date" maxlength="10">
            <input name="first_pay_from_Time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['firstPayDatetimeFrom'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
            ～&nbsp;<input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['firstPayDatetimeTo'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="first_pay_to_Date" maxlength="10">
            <input name="first_pay_to_Time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['firstPayDatetimeTo'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
        </div>
        <div id="first_pay_time">
            <input type="text" name="first_pay_time_from" value="<?php echo $this->_tpl_vars['value']['first_pay_time_from']; ?>
" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
            時間前以上
            <input type="text" name="first_pay_time_to" value="<?php echo $this->_tpl_vars['value']['first_pay_time_to']; ?>
" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
            時間前未満
        </div>
    </td>
</tr>

<tr>
    <td>期間購入金額</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_radios(array('id' => 'terms_pay','name' => 'specify_terms_pay','options' => $this->_tpl_vars['config']['admin_config']['specify_date_time_select'],'selected' => $this->_tpl_vars['value']['specify_terms_pay'],'separator' => "&nbsp;"), $this);?>

        <br>
        <div id="terms_pay_date">
            <input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['termsPayDatetimeFrom'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="terms_pay_from_Date" maxlength="10">
            <input name="terms_pay_from_Time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['termsPayDatetimeFrom'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
            ～&nbsp;<input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['termsPayDatetimeTo'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="terms_pay_to_Date" maxlength="10">
            <input name="terms_pay_to_Time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['termsPayDatetimeTo'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
        </div>
        <div id="terms_pay_time">
            <input type="text" name="terms_pay_time_from" value="<?php echo $this->_tpl_vars['value']['terms_pay_time_from']; ?>
" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
            時間前以上
            <input type="text" name="terms_pay_time_to" value="<?php echo $this->_tpl_vars['value']['terms_pay_time_to']; ?>
" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
            時間前未満
        </div>
        <div id="terms_pay_val">
            <input type="text" class="from" name="terms_pay_from" value="<?php echo $this->_tpl_vars['value']['terms_pay_from']; ?>
" size="10" style="ime-mode:disabled;text-align:right;">
            円以上
            <input type="text" class="to" name="terms_pay_to" value="<?php echo $this->_tpl_vars['value']['terms_pay_to']; ?>
" size="10" style="ime-mode:disabled;text-align:right;">
            円まで
        </div>
    </td>
</tr>

<tr>
<td>平均購入金額</td>
    <td style="text-align: left;">
        <input type="text" class="from" name="average_item_from" value="<?php echo $this->_tpl_vars['value']['average_item_from']; ?>
" size="10" style="ime-mode:disabled;text-align:right;">
        円以上
        <input type="text" class="to" name="average_item_to" value="<?php echo $this->_tpl_vars['value']['average_item_to']; ?>
" size="10" style="ime-mode:disabled;text-align:right;">
        円まで
    </td>
</tr>

<tr>
<td>最高購入金額</td>
    <td style="text-align: left;">
        <input type="text" class="from" name="expensive_item_from" value="<?php echo $this->_tpl_vars['value']['expensive_item_from']; ?>
" size="10" style="ime-mode:disabled;text-align:right;">
        円以上
        <input type="text" class="to" name="expensive_item_to" value="<?php echo $this->_tpl_vars['value']['expensive_item_to']; ?>
" size="10" style="ime-mode:disabled;text-align:right;">
        円まで
    </td>
</tr>

<tr>
<td>最低購入金額</td>
    <td style="text-align: left;">
        <input type="text" class="from" name="cheap_item_from" value="<?php echo $this->_tpl_vars['value']['cheap_item_from']; ?>
" size="10" style="ime-mode:disabled;text-align:right;">
        円以上
        <input type="text" class="to" name="cheap_item_to" value="<?php echo $this->_tpl_vars['value']['cheap_item_to']; ?>
" size="10" style="ime-mode:disabled;text-align:right;">
        円まで
    </td>
</tr>

<tr>
<td>最頻値購入金額</td>
    <td style="text-align: left;">
        <input type="text" class="from" name="frequently_item_from" value="<?php echo $this->_tpl_vars['value']['frequently_item_from']; ?>
" size="10" style="ime-mode:disabled;text-align:right;">
        円以上
        <input type="text" class="to" name="frequently_item_to" value="<?php echo $this->_tpl_vars['value']['frequently_item_to']; ?>
" size="10" style="ime-mode:disabled;text-align:right;">
        円まで
    </td>
</tr>

<tr>
<td>購入金額</td>
    <td style="text-align: left;">
        <input type="text" class="from" name="total_payment_from" value="<?php echo $this->_tpl_vars['value']['total_payment_from']; ?>
" size="10" style="ime-mode:disabled;text-align:right;">
        円以上
        <input type="text" class="to" name="total_payment_to" value="<?php echo $this->_tpl_vars['value']['total_payment_to']; ?>
" size="10" style="ime-mode:disabled;text-align:right;">
        円まで
    </td>
</tr>

<tr>
<td>購入回数</td>
    <td style="text-align: left;">
        <input type="text" class="from" name="buy_count_from" value="<?php echo $this->_tpl_vars['value']['buy_count_from']; ?>
" size="5" style="ime-mode:disabled;text-align:right;">
        回以上
        <input type="text" class="to" name="buy_count_to" value="<?php echo $this->_tpl_vars['value']['buy_count_to']; ?>
" size="5" style="ime-mode:disabled;text-align:right;">
        回まで
    </td>
</tr>

<tr>
<td>キャンセル回数</td>
    <td style="text-align: left;">
        <input type="text" class="from" name="cancel_count_from" value="<?php echo $this->_tpl_vars['value']['cancel_count_from']; ?>
" size="5" style="ime-mode:disabled;text-align:right;">
        回以上
        <input type="text" class="to" name="cancel_count_to" value="<?php echo $this->_tpl_vars['value']['cancel_count_to']; ?>
" size="5" style="ime-mode:disabled;text-align:right;">
        回まで
    </td>
</tr>

<tr>
    <td>最終購入日</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_radios(array('id' => 'last_buy','name' => 'specify_last_buy','options' => $this->_tpl_vars['config']['admin_config']['specify_date_time_select'],'selected' => $this->_tpl_vars['value']['specify_last_buy'],'separator' => "&nbsp;"), $this);?>

        <br>
        <div id="last_buy_date">
            <input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['lastBuyDatetimeFrom'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="last_buy_from_Date" maxlength="10">
            <input name="last_buy_from_Time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['lastBuyDatetimeFrom'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
            ～&nbsp;<input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['lastBuyDatetimeTo'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="last_buy_to_Date" maxlength="10">
            <input name="last_buy_to_Time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['lastBuyDatetimeTo'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
        </div>
        <div id="last_buy_time">
            <input type="text" name="last_buy_time_from" value="<?php echo $this->_tpl_vars['value']['last_buy_time_from']; ?>
" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
            時間前以上
            <input type="text" name="last_buy_time_to" value="<?php echo $this->_tpl_vars['value']['last_buy_time_to']; ?>
" size="3" maxlength="3" style="ime-mode:disabled;text-align:right;">
            時間前未満
        </div>
    </td>
</tr>
<tr>
    <td>付与月額コース</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_radios(array('id' => 'specify_monthly_course','name' => 'specify_monthly_course','options' => $this->_tpl_vars['config']['admin_config']['specify_monthly_course_select'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['value']['specify_monthly_course'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)),'separator' => "&nbsp;"), $this);?>

        <div id="monthly_course_remainder_days">
            残り期限
            <input type="text" class="from" name="monthly_rest_date_from" value="<?php echo $this->_tpl_vars['value']['monthly_rest_date_from']; ?>
" size="6" style="ime-mode:disabled;text-align:right;">
            日以上
            <input type="text" class="to" name="monthly_rest_date_to" value="<?php echo $this->_tpl_vars['value']['monthly_rest_date_to']; ?>
" size="6" style="ime-mode:disabled;text-align:right;">
            日まで
        </div>
    </td>
</tr>
<tr>
    <td>付与月額コースID<br>(カンマ区切りで複数可)</td>
    <td style="text-align: left;">
        対象を抽出：<input type="text" name="monthly_course_id" value="<?php echo $this->_tpl_vars['value']['monthly_course_id']; ?>
" size="20" style="ime-mode:disabled;">&nbsp;&nbsp;<?php echo smarty_function_html_radios(array('id' => 'search_monthly_course_id_type','name' => 'search_monthly_course_id_type','options' => $this->_tpl_vars['config']['admin_config']['specify_target_select'],'selected' => $this->_tpl_vars['value']['search_monthly_course_id_type'],'separator' => "&nbsp;"), $this);?>

        <br>
        以外を抽出：<input type="text" name="except_monthly_course_id" value="<?php echo $this->_tpl_vars['value']['except_monthly_course_id']; ?>
" size="20" style="ime-mode:disabled;">&nbsp;&nbsp;<?php echo smarty_function_html_radios(array('id' => 'except_search_monthly_course_id_type','name' => 'except_search_monthly_course_id_type','options' => $this->_tpl_vars['config']['admin_config']['specify_target_select'],'selected' => $this->_tpl_vars['value']['except_search_monthly_course_id_type'],'separator' => "&nbsp;"), $this);?>

    </td>
</tr>
<tr>
    <td>付与月額更新用商品</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_radios(array('id' => 'specify_monthly_update','name' => 'specify_monthly_update','options' => $this->_tpl_vars['config']['admin_config']['specify_monthly_update_select'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['value']['specify_monthly_update'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)),'separator' => "&nbsp;"), $this);?>

        <div id="monthly_course_update_item">
            対象を抽出：<input type="text" name="monthly_update_item_id" value="<?php echo $this->_tpl_vars['value']['monthly_update_item_id']; ?>
" size="20" style="ime-mode:disabled;">&nbsp;&nbsp;<?php echo smarty_function_html_radios(array('id' => 'search_monthly_update_item_type','name' => 'search_monthly_update_item_type','options' => $this->_tpl_vars['config']['admin_config']['specify_target_select'],'selected' => $this->_tpl_vars['value']['search_monthly_update_item_type'],'separator' => "&nbsp;"), $this);?>

            <br>
            以外を抽出：<input type="text" name="except_monthly_update_item_id" value="<?php echo $this->_tpl_vars['value']['except_monthly_update_item_id']; ?>
" size="20" style="ime-mode:disabled;">&nbsp;&nbsp;<?php echo smarty_function_html_radios(array('id' => 'except_search_monthly_update_item_id_type','name' => 'except_search_monthly_update_item_id_type','options' => $this->_tpl_vars['config']['admin_config']['specify_target_select'],'selected' => $this->_tpl_vars['value']['except_search_monthly_update_item_id_type'],'separator' => "&nbsp;"), $this);?>

        </div>
    </td>
</tr>

<tr>
<td>通常メール回数</td>
    <td style="text-align: left;">
        <input type="text" class="from" name="mail_count_from" value="<?php echo $this->_tpl_vars['value']['mail_count_from']; ?>
" size="5" style="ime-mode:disabled;text-align:right;">
        回以上
        <input type="text" class="to" name="mail_count_to" value="<?php echo $this->_tpl_vars['value']['mail_count_to']; ?>
" size="5" style="ime-mode:disabled;text-align:right;">
        回まで
    </td>
</tr>

<tr>
<td>予約メール回数</td>
    <td style="text-align: left;">
        <input type="text" class="from" name="mail_reserve_count_from" value="<?php echo $this->_tpl_vars['value']['mail_reserve_count_from']; ?>
" size="5" style="ime-mode:disabled;text-align:right;">
        回以上
        <input type="text" class="to" name="mail_reserve_count_to" value="<?php echo $this->_tpl_vars['value']['mail_reserve_count_to']; ?>
" size="5" style="ime-mode:disabled;text-align:right;">
        回まで
    </td>
</tr>

<tr>
<td>定期メール回数</td>
    <td style="text-align: left;">
        <input type="text" class="from" name="mail_regular_count_from" value="<?php echo $this->_tpl_vars['value']['mail_regular_count_from']; ?>
" size="5" style="ime-mode:disabled;text-align:right;">
        回以上
        <input type="text" class="to" name="mail_regular_count_to" value="<?php echo $this->_tpl_vars['value']['mail_regular_count_to']; ?>
" size="5" style="ime-mode:disabled;text-align:right;">
        回まで
    </td>
</tr>

<tr>
<td>強行メール回数</td>
    <td style="text-align: left;">
        <input type="text" class="from" name="reverse_mail_status_count_from" value="<?php echo $this->_tpl_vars['value']['reverse_mail_status_count_from']; ?>
" size="5" style="ime-mode:disabled;text-align:right;">
        回以上
        <input type="text" class="to" name="reverse_mail_status_count_to" value="<?php echo $this->_tpl_vars['value']['reverse_mail_status_count_to']; ?>
" size="5" style="ime-mode:disabled;text-align:right;">
        回まで
    </td>
</tr>
<tr>
    <td>銀行口座</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_radios(array('id' => 'bank_detail','name' => 'bank_detail','options' => $this->_tpl_vars['isSetting'],'selected' => $this->_tpl_vars['value']['bank_detail'],'separator' => "&nbsp;"), $this);?>

    </td>
</tr>
<tr>
    <td>住所</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_radios(array('id' => 'address_detail','name' => 'address_detail','options' => $this->_tpl_vars['isSetting'],'selected' => $this->_tpl_vars['value']['address_detail'],'separator' => "&nbsp;"), $this);?>

    </td>
</tr>
<tr>
    <td>ﾕｰｻﾞｰﾌﾟﾗｲﾊﾞｼｰ</td>
    <td style="text-align: left;">
       <?php echo smarty_function_html_checkboxes(array('name' => 'address_detail','options' => $this->_tpl_vars['addressDetail'],'selected' => $this->_tpl_vars['value']['address_detail'],'separator' => "&nbsp;"), $this);?>

       <?php echo smarty_function_html_checkboxes(array('name' => 'bank_detail','options' => $this->_tpl_vars['bankDetail'],'selected' => $this->_tpl_vars['value']['bank_detail'],'separator' => "&nbsp;"), $this);?>

       <?php echo smarty_function_html_radios(array('id' => 'specify_userPrivacy','name' => 'specify_userPrivacy','options' => $this->_tpl_vars['config']['admin_config']['is_setting'],'selected' => $this->_tpl_vars['value']['specify_userPrivacy'],'separator' => "&nbsp;"), $this);?>

    </td>
</tr>
<tr>
    <td>生年月日</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_radios(array('id' => 'specify_birth_day','name' => 'specify_birth_day','options' => $this->_tpl_vars['config']['admin_config']['specify_birth_day_select'],'selected' => $this->_tpl_vars['value']['specify_birth_day'],'separator' => "&nbsp;"), $this);?>

        <br>
        <div id="birth_day_date">
            <input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['birthDayDatetimeFrom'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="birth_day_from_Date" maxlength="10">
            ～&nbsp;<input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['birthDayDatetimeTo'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="birth_day_to_Date" maxlength="10">
        </div>
    </td>
</tr>
<tr>
<td>年齢</td>
    <td style="text-align: left;">
        <input type="text" class="from" name="user_age_from" value="<?php echo $this->_tpl_vars['value']['user_age_from']; ?>
" size="5" style="ime-mode:disabled;text-align:right;">
        歳以上
        <input type="text" class="to" name="user_age_to" value="<?php echo $this->_tpl_vars['value']['user_age_to']; ?>
" size="5" style="ime-mode:disabled;text-align:right;">
        歳まで
       <input type="checkbox" name="user_age_no_data" value="1" <?php if ($this->_tpl_vars['value']['user_age_no_data']): ?> checked/ <?php endif; ?>>入力無し含む
    </td>
</tr>
<tr>
    <td>干支</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_checkboxes(array('name' => 'sexagenary_cycle','options' => $this->_tpl_vars['config']['admin_config']['specify_sexagenary_cycle_select'],'selected' => $this->_tpl_vars['value']['sexagenary_cycle'],'separator' => "&nbsp;"), $this);?>

    </td>
</tr>
<tr>
    <td>星座</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_checkboxes(array('name' => 'constellation','options' => $this->_tpl_vars['config']['admin_config']['specify_constellation_select'],'selected' => $this->_tpl_vars['value']['constellation'],'separator' => "&nbsp;"), $this);?>

    </td>
</tr>

<tr>
    <td>血液型</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_checkboxes(array('name' => 'blood_type','options' => $this->_tpl_vars['bloodType'],'selected' => $this->_tpl_vars['value']['blood_type'],'separator' => "&nbsp;"), $this);?>

    </td>
</tr>
<tr>
    <td>媒体コード<br>(カンマ区切りで複数可)<br>[% => 任意の数の文字]<br>[_ =>  1 つの文字]</td>
    <td style="text-align: left;">
        <div id="media_cd">
            対象を抽出：<input type="text" name="media_cd" value="<?php echo $this->_tpl_vars['value']['media_cd']; ?>
" size="30" style="ime-mode:disabled;">&nbsp;&nbsp;<?php echo smarty_function_html_radios(array('id' => 'search_media_cd_type','name' => 'search_media_cd_type','options' => $this->_tpl_vars['config']['admin_config']['specify_target_select'],'selected' => $this->_tpl_vars['value']['search_media_cd_type'],'separator' => "&nbsp;"), $this);?>

        </div>
        <div id="except_media_cd">
            以外を抽出：<input type="text" name="except_media_cd" value="<?php echo $this->_tpl_vars['value']['except_media_cd']; ?>
" size="30" style="ime-mode:disabled;">&nbsp;&nbsp;<?php echo smarty_function_html_radios(array('id' => 'search_except_media_cd_type','name' => 'search_except_media_cd_type','options' => $this->_tpl_vars['config']['admin_config']['specify_target_select'],'selected' => $this->_tpl_vars['value']['search_except_media_cd_type'],'separator' => "&nbsp;"), $this);?>

        </div>
    </td>
</tr>
<tr>
    <td>管理ﾎﾞｯｸｽ</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_options(array('name' => 'admin_id','options' => $this->_tpl_vars['adminList'],'selected' => $this->_tpl_vars['value']['admin_id']), $this);?>

    </td>
</tr>

<tr>
    <td>サイト間登録</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_radios(array('id' => 'specify_regist_site','name' => 'specify_regist_site','options' => $this->_tpl_vars['specifyRegistSite'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['value']['specify_regist_site'])) ? $this->_run_mod_handler('default', true, $_tmp, '0') : smarty_modifier_default($_tmp, '0')),'separator' => "&nbsp;"), $this);?>
<br>
        <?php echo smarty_function_html_checkboxes(array('name' => 'regist_site','options' => $this->_tpl_vars['registSiteList'],'selected' => $this->_tpl_vars['value']['regist_site'],'separator' => "&nbsp;"), $this);?>

    </td>
</tr>
<?php if ($this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SYSTEM']): ?>
<tr>
    <td>ユーザー検索タイプ</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_radios(array('id' => 'specify_convert_type','name' => 'specify_convert_type','options' => $this->_tpl_vars['selectSearchType'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['value']['specify_convert_type'])) ? $this->_run_mod_handler('default', true, $_tmp, 1) : smarty_modifier_default($_tmp, 1)),'separator' => "&nbsp;"), $this);?>

        <div id="specify_convert_type_input">
            &nbsp;&nbsp;⇒入金条件指定：&nbsp;&nbsp;<?php echo smarty_function_html_radios(array('name' => 'convert_pay_type','options' => $this->_tpl_vars['config']['admin_config']['specify_payment_input_select'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['value']['convert_pay_type'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)),'separator' => "&nbsp;"), $this);?>

            <font color="blue">※入金条件指定は「KH⇒EM,OK,TS または AG⇒EM,OK,TS」のみ有効</font>
            <br>
            &nbsp;&nbsp;⇒コンバート先指定：&nbsp;&nbsp;<?php echo smarty_function_html_radios(array('name' => 'to_convert_sites','options' => $this->_tpl_vars['convertSitesAry'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['value']['to_convert_sites'])) ? $this->_run_mod_handler('default', true, $_tmp, ($this->_tpl_vars['convertSiteSelectDefault'])) : smarty_modifier_default($_tmp, ($this->_tpl_vars['convertSiteSelectDefault']))),'separator' => "&nbsp;"), $this);?>

        </div>
    </td>
</tr>
<?php endif; ?>

<tr>
    <td>ユーザー識別フラグ</td>
    <td style="text-align: left;">
        <?php echo smarty_function_html_checkboxes(array('name' => 'user_profile_flag_code','options' => $this->_tpl_vars['user_profile_flag_code'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['value']['user_profile_flag_code'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)),'separator' => "&nbsp;"), $this);?>
<br>
        <font color="red">※チェックが無い場合はフラグに関係なく検索(全てにチェックを入れた場合と同じ)</font>
    </td>
</tr>

<tr>
   <td>備考<br>(部分一致)</td>
       <td style="text-align: left;">
          <textarea name="description" rows="3" cols="51"><?php echo $this->_tpl_vars['value']['description']; ?>
</textarea>
      </td>
</tr>

</table>

<div class="SubMenu">
    <?php echo smarty_function_html_options(array('name' => 'limit','options' => $this->_tpl_vars['limit'],'selected' => $this->_tpl_vars['value']['limit']), $this);?>

件ずつ
    <?php echo smarty_function_html_options(array('name' => 'order','options' => $this->_tpl_vars['order'],'selected' => $this->_tpl_vars['value']['order']), $this);?>

順に
<input type="submit" value="検索!!" name="action_User_List"/>
</div>
</form>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admFooter'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="./js/jquery.timepickr.min.js"></script>
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script type="text/javascript" src="./js/watermark/jquery.watermark.min.js"></script>
<script type="text/javascript" src="./js/userSearch.js"></script>
</body>
</html>
