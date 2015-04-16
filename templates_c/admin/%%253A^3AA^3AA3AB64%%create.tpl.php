<?php /* Smarty version 2.6.26, created on 2014-08-14 11:13:26
         compiled from /home/suraimu/templates/admin/user/create.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/user/create.tpl', 13, false),array('modifier', 'implode', '/home/suraimu/templates/admin/user/create.tpl', 19, false),array('function', 'html_options', '/home/suraimu/templates/admin/user/create.tpl', 30, false),)), $this); ?>
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
    <?php endif; ?>
    <form action="./" method="post">
        <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
            <tr>
                <th>ｽﾃｰﾀｽ</th>
                <td style="text-align: left;">
                    <?php echo smarty_function_html_options(array('name' => 'regist_status','options' => $this->_tpl_vars['config']['admin_config']['regist_status'],'selected' => $this->_tpl_vars['param']['regist_status']), $this);?>

                </td>
            </tr>
            <tr>
                <th>性別</th>
                <td style="text-align: left;">
                    <?php echo smarty_function_html_options(array('name' => 'sex_cd','options' => $this->_tpl_vars['config']['web_config']['sex_cd'],'selected' => $this->_tpl_vars['param']['sex_cd']), $this);?>

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
                    <?php echo smarty_function_html_options(array('name' => 'danger_status','options' => $this->_tpl_vars['config']['admin_config']['danger_status'],'selected' => $this->_tpl_vars['param']['danger_status']), $this);?>

                </td>
            </tr>
            <tr>
                <th>PCﾒｰﾙｱﾄﾞﾚｽ</th>
                <td style="text-align: left;">
                    <input type="text" class="mail_address" name="pc_address" value="<?php echo $this->_tpl_vars['param']['pc_address']; ?>
" style="ime-mode:disabled" size="50">
                </td>
            </tr>
            <tr>
                <th>PCｱﾄﾞﾚｽｽﾃ-ﾀｽ</th>
                <td style="text-align: left;">
                    <?php echo smarty_function_html_options(array('name' => 'pc_address_status','options' => $this->_tpl_vars['config']['admin_config']['address_status'],'selected' => $this->_tpl_vars['param']['pc_address_status']), $this);?>

                 </td>
            </tr>
            <tr>
                <th>PC送信ｽﾃ-ﾀｽ</th>
                <td style="text-align: left;">
                    <?php echo smarty_function_html_options(array('name' => 'pc_send_status','options' => $this->_tpl_vars['config']['admin_config']['address_send_status'],'selected' => $this->_tpl_vars['param']['pc_send_status']), $this);?>

                 </td>
            </tr>
            <tr>
                <th>PCﾒｰﾙ受信設定</th>
                <td style="text-align: left;">
                    <?php echo smarty_function_html_options(array('name' => 'pc_is_mailmagazine','options' => $this->_tpl_vars['config']['common_config']['is_mailmagazine'],'selected' => $this->_tpl_vars['param']['pc_is_mailmagazine']), $this);?>

                 </td>
            </tr>
            <tr>
                <th>MBﾒｰﾙｱﾄﾞﾚｽ</th>
                <td style="text-align: left;">
                    <input type="text" class="mail_address" name="mb_address" value="<?php echo $this->_tpl_vars['param']['mb_address']; ?>
" style="ime-mode:disabled" size="50">
                </td>
            </tr>
            <tr>
                <th>MBｱﾄﾞﾚｽｽﾃｰﾀｽ</th>
                <td style="text-align: left;">
                    <?php echo smarty_function_html_options(array('name' => 'mb_address_status','options' => $this->_tpl_vars['config']['admin_config']['address_status'],'selected' => $this->_tpl_vars['param']['mb_address_status']), $this);?>

                </td>
            </tr>
            <tr>
                <th>MB送信ｽﾃ-ﾀｽ</th>
                <td style="text-align: left;">
                    <?php echo smarty_function_html_options(array('name' => 'mb_send_status','options' => $this->_tpl_vars['config']['admin_config']['address_send_status'],'selected' => $this->_tpl_vars['param']['mb_send_status']), $this);?>

                 </td>
            </tr>
            <tr>
                <th>MBﾒｰﾙ受信設定</th>
                <td style="text-align: left;">
                    <?php echo smarty_function_html_options(array('name' => 'mb_is_mailmagazine','options' => $this->_tpl_vars['config']['common_config']['is_mailmagazine'],'selected' => $this->_tpl_vars['param']['mb_is_mailmagazine']), $this);?>

                 </td>
            </tr>
            <tr>
                <th>媒体ｺｰﾄﾞ</th>
                <td style="text-align: left;">
                    <input type="text" name="media_cd" value="<?php echo $this->_tpl_vars['param']['media_cd']; ?>
" style="ime-mode:disabled" size="10"style="text-align:right;">
                </td>
            </tr>
            <tr>
                <th>登録入口ID</th>
                <td style="text-align: left;">
                    <input type="text" name="regist_page_id" value="<?php echo $this->_tpl_vars['param']['regist_page_id']; ?>
" style="ime-mode:disabled" size="3"style="text-align:right;">
                </td>
            </tr>
            <tr>
                <th>保有ポイント</th>
                <td style="text-align: left;">
                    <input type="text" name="point" value="<?php echo $this->_tpl_vars['param']['point']; ?>
" style="ime-mode:disabled" size="7"style="text-align:right;"> pt
                </td>
            </tr>
            <tr>
                <th>備考</th>
                <td style="text-align: left;">
                    <textarea name="description" rows="5" cols="50"><?php echo $this->_tpl_vars['param']['description']; ?>
</textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="vertical-align:top;text-align:center;">
                    <input type="submit" name="action_user_CreateExec" value="登 録" OnClick="return confirm('登録しますか？')" style="width:8em;"/>
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
<script type="text/javascript" src="./js/jquery.timepickr.min.js"></script>
<script type="text/javascript" src="./js/watermark/jquery.watermark.min.js"></script>
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

                $('.mail_address').watermark('PC,MBどちらか必須');
    });

// -->
</script>
</body>
</html>