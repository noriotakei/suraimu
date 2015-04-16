<?php /* Smarty version 2.6.26, created on 2014-11-25 11:49:43
         compiled from /home/suraimu/templates/admin/affiliate/affiliateList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/affiliate/affiliateList.tpl', 64, false),array('modifier', 'implode', '/home/suraimu/templates/admin/affiliate/affiliateList.tpl', 70, false),array('modifier', 'default', '/home/suraimu/templates/admin/affiliate/affiliateList.tpl', 94, false),array('modifier', 'cat', '/home/suraimu/templates/admin/affiliate/affiliateList.tpl', 168, false),array('function', 'html_radios', '/home/suraimu/templates/admin/affiliate/affiliateList.tpl', 94, false),array('function', 'html_checkboxes', '/home/suraimu/templates/admin/affiliate/affiliateList.tpl', 98, false),array('function', 'make_link', '/home/suraimu/templates/admin/affiliate/affiliateList.tpl', 168, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script type="text/javascript" src="./js/watermark/jquery.watermark.min.js"></script>
<script language="JavaScript">
<!--

    $(function() {
        // テーブルマウスオーバーカラー
        $('#list_table').colorize({
            altColor :'#CCCCCC',
            hiliteColor :'none'
        });

        if (<?php echo $this->_tpl_vars['param']['return_flag']; ?>
) {
            $("#add_form").show();
        }

        $('#add_button').live("click", function(env){
            if (env.button !== 0) return;
            $("#add_form").toggle("blind", null, "slow");
        });

        $("#connect_type_1").attr('disabled', 'disabled');

        $("input[name='send_type']").live("click", function(env){
            if (env.button !== 0) return;
            if ($("input[name='send_type']:checked").val() != 0) {
                 $('#connect_type_1').attr('disabled', false);
            } else if ($("input[name='send_type']:checked").val() == 0) {
                 $("input[name='connect_type']").val(['0']);
                 $('#connect_type_1').attr('disabled', 'disabled');
            };
        });

        $("input[name='is_pre_regist']").live("click", function(env){
            if (env.button !== 0) return;
            if ($("input[name='is_pre_regist']:checked").val() != 0) {
                 $('#connect_type_1').attr('disabled', false);
                 $('#send_type_0').attr('disabled', false);
            } else {
                 $("input[name='connect_type']").val(['0']);
                 $('#connect_type_1').attr('disabled', 'disabled');
                 $("input[name='send_type']").val(['1']);
                 $('#send_type_0').attr('disabled', 'disabled');
            };
        });

        $('.path').watermark('「http://」から入力');

    });

// -->
</script>
<style type="text/css">
.watermark {
   color: #999;
}
</style>
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">登録時発行タグ一覧</h2>
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
<?php endif; ?>
<div class="SubMenu">
    <input type="button" id="add_button" value="追　加" />
</div>

<div id="add_form" style="display:none;">
<form action="./" method="POST">
    <?php echo $this->_tpl_vars['POSTparam']; ?>

    <table class="TableSet04">
        <tr>
            <th>広告コード<br>(完全一致か上2桁の前方一致)</th>
            <td><input type="text" name="media_cd" value="<?php echo $this->_tpl_vars['param']['media_cd']; ?>
" style="ime-mode:disabled" size="10"></td>
        </tr>
        <tr>
            <th>サイト名</th>
            <td><input type="text" name="site_name" value="<?php echo $this->_tpl_vars['param']['site_name']; ?>
" size="30"></td>
        </tr>
        <tr>
            <th>登録ステータス</th>
            <td><?php echo smarty_function_html_radios(array('label_ids' => true,'name' => 'is_pre_regist','options' => $this->_tpl_vars['isPreRegist'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['param']['is_pre_regist'])) ? $this->_run_mod_handler('default', true, $_tmp, 1) : smarty_modifier_default($_tmp, 1)),'separator' => "&nbsp;"), $this);?>
</td>
        </tr>
        <tr>
            <th>送信設定</th>
            <td><?php echo smarty_function_html_checkboxes(array('name' => 'is_success_only','options' => $this->_tpl_vars['isSuccessOnly'],'selected' => $this->_tpl_vars['param']['is_success_only'],'separator' => "&nbsp;"), $this);?>
</td>
        </tr>
        <tr>
            <th>戻し先URL(任意)</th>
            <td><input class="path" type="text" name="path" value="<?php echo $this->_tpl_vars['param']['path']; ?>
" style="ime-mode:disabled" size="40"></td>
        </tr>
        <tr>
            <th>送信種別</th>
            <td><?php echo smarty_function_html_radios(array('label_ids' => true,'name' => 'send_type','options' => $this->_tpl_vars['sendType'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['param']['send_type'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)),'separator' => "&nbsp;"), $this);?>
</td>
        </tr>
        <tr>
            <th>発行種別<br>(本登録フローは<br>ソケット通信のみ)</th>
            <td><?php echo smarty_function_html_radios(array('label_ids' => true,'name' => 'connect_type','options' => $this->_tpl_vars['connectType'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['param']['connect_type'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)),'separator' => "&nbsp;"), $this);?>
</td>
        </tr>
        <tr>
            <th>成功時追加<br>パラメータ(任意)</th>
            <td><input type="text" name="success_parameter" value="<?php echo $this->_tpl_vars['param']['success_parameter']; ?>
" style="ime-mode:disabled" size="30"></td>
        </tr>
        <tr>
            <th>失敗時追加<br>パラメータ(任意)</th>
            <td><input type="text" name="failure_parameter" value="<?php echo $this->_tpl_vars['param']['failure_parameter']; ?>
" style="ime-mode:disabled" size="30"></td>
        </tr>
        <tr>
            <th>初入金時追加<br>パラメータ(任意)</th>
            <td><input type="text" name="first_payment_parameter" value="<?php echo $this->_tpl_vars['param']['first_payment_parameter']; ?>
" style="ime-mode:disabled" size="30"></td>
        </tr>
        <tr>
            <th>入金時追加<br>パラメータ(任意  ※ソケット通信のみ)</th>
            <td><input type="text" name="payment_parameter" value="<?php echo $this->_tpl_vars['param']['payment_parameter']; ?>
" style="ime-mode:disabled" size="30"></td>
        </tr>
        <tr>
            <th>送信変数または追加パラメータ<br>ユーザー情報変数：<br>メールアドレス => mail_address<br>メールアドレス(「.」を「_」に変換) => dot_address<br>個体識別番号 => mb_serial_number<br>広告コード => advcd<br>任意パラメータ => 値</th>
            <td>
                <input type="text" name="return_variable[]" value="<?php echo $this->_tpl_vars['param']['return_variable'][0]; ?>
" style="ime-mode:disabled" size="20"> = <input type="text" name="change_variable[]" value="<?php echo $this->_tpl_vars['param']['change_variable'][0]; ?>
" style="ime-mode:disabled" size="20"><br>
                <input type="text" name="return_variable[]" value="<?php echo $this->_tpl_vars['param']['return_variable'][1]; ?>
" style="ime-mode:disabled" size="20"> = <input type="text" name="change_variable[]" value="<?php echo $this->_tpl_vars['param']['change_variable'][1]; ?>
" style="ime-mode:disabled" size="20"><br>
                <input type="text" name="return_variable[]" value="<?php echo $this->_tpl_vars['param']['return_variable'][2]; ?>
" style="ime-mode:disabled" size="20"> = <input type="text" name="change_variable[]" value="<?php echo $this->_tpl_vars['param']['change_variable'][2]; ?>
" style="ime-mode:disabled" size="20"><br>
                <input type="text" name="return_variable[]" value="<?php echo $this->_tpl_vars['param']['return_variable'][3]; ?>
" style="ime-mode:disabled" size="20"> = <input type="text" name="change_variable[]" value="<?php echo $this->_tpl_vars['param']['change_variable'][3]; ?>
" style="ime-mode:disabled" size="20"><br>
                <input type="text" name="return_variable[]" value="<?php echo $this->_tpl_vars['param']['return_variable'][4]; ?>
" style="ime-mode:disabled" size="20"> = <input type="text" name="change_variable[]" value="<?php echo $this->_tpl_vars['param']['change_variable'][4]; ?>
" style="ime-mode:disabled" size="20">
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">
                <input type="submit" value="登　録" name="action_affiliate_AffiliateRegExec" onClick="return confirm('登録しますか？')">
            </td>
        </tr>
    </table>
</form>
</div>
<br>
<?php if ($this->_tpl_vars['affiliateList']): ?>
    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">
    <tr>
    <th nowrap="nowrap">ID</th>
    <th nowrap="nowrap">広告コード</th>
    <th>サイト名</th>
    <th>戻し先URL</th>
    <th nowrap="nowrap">登録ステータス</th>
    <th nowrap="nowrap">送信設定</th>
    <th nowrap="nowrap">送信種別</th>
    <th nowrap="nowrap">発行種別</th>
    <th nowrap="nowrap">成功時追加<br>パラメータ(任意)</th>
    <th nowrap="nowrap">失敗時追加<br>パラメータ(任意)</th>
    <th nowrap="nowrap">初入金時追加<br>パラメータ(任意)</th>
    <th nowrap="nowrap">入金時追加<br>パラメータ(任意)</th>
    <th nowrap="nowrap">送信変数<br>または追加パラメータ(任意)</th>
    <th>更新日時</th>
    <th>削除</th>
    </tr>
    <?php $_from = $this->_tpl_vars['affiliateList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
        <tr>
        <td><a href="<?php echo smarty_function_make_link(array('action' => 'action_affiliate_AffiliateUpd','getTags' => ((is_array($_tmp="id=")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['val']['id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['val']['id']))), $this);?>
"><?php echo $this->_tpl_vars['val']['id']; ?>
</a></td>
        <td><?php echo $this->_tpl_vars['val']['media_cd']; ?>
</td>
        <td><?php echo $this->_tpl_vars['val']['site_name']; ?>
</td>
        <td><?php echo $this->_tpl_vars['val']['path']; ?>
</td>
        <td><?php echo $this->_tpl_vars['isPreRegist'][$this->_tpl_vars['val']['is_pre_regist']]; ?>
</td>
        <td><?php echo $this->_tpl_vars['isSuccessOnly'][$this->_tpl_vars['val']['is_success_only']]; ?>
</td>
        <td><?php echo $this->_tpl_vars['sendType'][$this->_tpl_vars['val']['send_type']]; ?>
</td>
        <td><?php echo $this->_tpl_vars['connectType'][$this->_tpl_vars['val']['connect_type']]; ?>
</td>
        <td><?php echo $this->_tpl_vars['val']['success_parameter']; ?>
</td>
        <td><?php echo $this->_tpl_vars['val']['failure_parameter']; ?>
</td>
        <td><?php echo $this->_tpl_vars['val']['first_payment_parameter']; ?>
</td>
        <td><?php echo $this->_tpl_vars['val']['payment_parameter']; ?>
</td>
        <td nowrap>
            <?php $_from = $this->_tpl_vars['val']['variable']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['variable']):
?>
                <?php echo $this->_tpl_vars['variable']; ?>
<br>
            <?php endforeach; endif; unset($_from); ?>
        </td>
        <td><?php echo $this->_tpl_vars['val']['update_datetime']; ?>
</td>
        <td>
            <form action="./" method="post" style="margin:2px 0px;">
                <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['val']['id']; ?>
">
                <input type="hidden" name="disable" value="1">
                <input type="submit" name="action_affiliate_AffiliateRegExec" value="削除" onClick="return confirm('削除しますか?')">
            </form>
        </td>
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
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admFooter'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
<br>
<br>
</body>
</html>