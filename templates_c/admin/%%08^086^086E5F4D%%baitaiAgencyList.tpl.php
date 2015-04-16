<?php /* Smarty version 2.6.26, created on 2014-08-08 23:25:45
         compiled from /home/suraimu/templates/admin/baitaiAgency/baitaiAgencyList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/baitaiAgency/baitaiAgencyList.tpl', 56, false),array('modifier', 'implode', '/home/suraimu/templates/admin/baitaiAgency/baitaiAgencyList.tpl', 62, false),array('modifier', 'cat', '/home/suraimu/templates/admin/baitaiAgency/baitaiAgencyList.tpl', 83, false),array('modifier', 'default', '/home/suraimu/templates/admin/baitaiAgency/baitaiAgencyList.tpl', 138, false),array('function', 'make_link', '/home/suraimu/templates/admin/baitaiAgency/baitaiAgencyList.tpl', 83, false),array('function', 'html_radios', '/home/suraimu/templates/admin/baitaiAgency/baitaiAgencyList.tpl', 138, false),array('function', 'html_options', '/home/suraimu/templates/admin/baitaiAgency/baitaiAgencyList.tpl', 146, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script language="JavaScript">
<!--

    $(function() {
        // テーブルマウスオーバーカラー
        $('#list_table').colorize({
            altColor :'#CCCCCC',
            hiliteColor :'none'
        });

        if (!<?php echo $this->_tpl_vars['param']['return_flag']; ?>
) {
            $("#add_form").hide();
        }

        $('#add_button').live("click", function(env){
            if (env.button !== 0) return;
            $("#add_form").toggle("clip", null, "slow");
        });

                $("#input_form").hide();

        var updateIdAry = Array('#authority_type option:selected');
        for (var val in updateIdAry) {
            openFolderSelect(updateIdAry[val]);
        }

                $('#authority_type').change(function(){
            openFolderSelect('#authority_type option:selected');
        });

    });

    function openFolderSelect(selectId) {

        var selectId = $(selectId);

        if (selectId.val() == 6) {
            $('#input_form').show("blind", "slow");
        } else {
            $('#input_form').hide();
        }

    }

// -->
</script>
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">代理店媒体管理</h2>
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
<br>
<?php if ($this->_tpl_vars['baitaiAgencyList']): ?>
    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">
    <tr>
    <th nowrap="nowrap">代理店名</th>
    <th nowrap="nowrap">ログインID</th>
    <th nowrap="nowrap">パスワード</th>
    <!--<th nowrap="nowrap">管理区分</th>-->
    <th nowrap="nowrap">代理店URL&nbsp;<font color="blue">※固定URL</font></th>
    <!--<th nowrap="nowrap">認証IPアドレス</th>-->
    <th nowrap="nowrap">代理店への入金額の表示設定</th>
    <!--<th nowrap="nowrap">媒体コード</th>-->
    </tr>
    <?php $_from = $this->_tpl_vars['baitaiAgencyList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
        <tr>
        <td><a href="<?php echo smarty_function_make_link(array('action' => 'action_baitaiAgency_BaitaiAgencyUpd','getTags' => ((is_array($_tmp="id=")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['val']['id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['val']['id']))), $this);?>
"><?php echo $this->_tpl_vars['val']['name']; ?>
</a></td>
        <td><?php echo $this->_tpl_vars['val']['login_id']; ?>
</td>
        <td><?php echo $this->_tpl_vars['val']['display_password']; ?>
</td>
        <!--<td><?php echo $this->_tpl_vars['selectAuthoritytype'][$this->_tpl_vars['val']['authority_type']]; ?>
</td>-->
        <td><?php echo $this->_tpl_vars['config']['define']['BAITAI_AGENCY_URL']; ?>
</td>
        <!--<td><?php echo $this->_tpl_vars['val']['ip_address']; ?>
</td>-->
        <td><?php echo $this->_tpl_vars['isDisplayPay'][$this->_tpl_vars['val']['is_display_trade_amount']]; ?>
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
    <br>
<?php endif; ?>
<div class="SubMenu">
    <input type="button" id="add_button" value="追　加" />
</div>

<div id="add_form" style="display:none;">
<form action="./" method="POST">
    <?php echo $this->_tpl_vars['POSTparam']; ?>

    <table class="TableSet01">
        <tr>
            <th>
                代理店名：
            </th>
            <td style="text-align: left;">
                <input type="text" name="name" value="<?php echo $this->_tpl_vars['param']['name']; ?>
" size="40">
            </td>
        </tr>
        <tr>
            <th>
                ログインID：
            </th>
            <td style="text-align: left;">
                <input type="text" name="login_id" value="<?php echo $this->_tpl_vars['param']['login_id']; ?>
">
            </td>
        </tr>
        <tr>
            <th>
                パスワード：
            </th>
            <td style="text-align: left;">
                <input type="text" name="display_password" value="<?php echo $this->_tpl_vars['param']['display_password']; ?>
" style="ime-mode:disabled">
            </td>
        </tr>
        <tr>
            <th>IPアドレス認証：</th>
            <td style="text-align: left;">
                <?php echo smarty_function_html_radios(array('name' => 'is_auth_ip_address','options' => $this->_tpl_vars['isAuthIpAddress'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['param']['is_auth_ip_address'])) ? $this->_run_mod_handler('default', true, $_tmp, 1) : smarty_modifier_default($_tmp, 1)),'id' => 'is_auth_ip_address'), $this);?>

            </td>
        </tr>
        <tr>
            <th>
                代理店への入金額の表示設定：
            </th>
            <td style="text-align: left;">
                <?php echo smarty_function_html_options(array('name' => 'is_display','options' => $this->_tpl_vars['isDisplayPay'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['param']['is_display_trade_amount'])) ? $this->_run_mod_handler('default', true, $_tmp, 1) : smarty_modifier_default($_tmp, 1))), $this);?>

            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">
                <input type="submit" value="登　録" name="action_baitaiAgency_BaitaiAgencyRegExec" onClick="return confirm('登録しますか？')">
            </td>
        </tr>
    </table>
</form>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admFooter'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
</body>
</html>