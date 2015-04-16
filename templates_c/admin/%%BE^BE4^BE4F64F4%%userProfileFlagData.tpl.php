<?php /* Smarty version 2.6.26, created on 2015-01-13 18:31:21
         compiled from /home/suraimu/templates/admin/user/userProfileFlagData.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/user/userProfileFlagData.tpl', 25, false),array('modifier', 'implode', '/home/suraimu/templates/admin/user/userProfileFlagData.tpl', 31, false),array('function', 'html_options', '/home/suraimu/templates/admin/user/userProfileFlagData.tpl', 54, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
<script type="text/javascript" src="./js/jquery.timepickr.min.js"></script>
<script type="text/javascript">
<!--


    $(function() {
        // テーブルマウスオーバーカラー
        $('#list_table').colorize({
            altColor :'#CCCCCC',
            hiliteColor :'none'
        });

    });


//-->
</script>
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">フラグコードの名前を編集</h2>
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
<?php if ($this->_tpl_vars['data']): ?>
    <div>
        <form action="./" method="post">
            <?php echo $this->_tpl_vars['POSTparam']; ?>

            <table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet04">
                <tr><th colspan="2" style="text-align:center;">フラグコードの名前を編集</th></tr>
                <tr>
                    <th>コード</th>
                    <td><?php echo $this->_tpl_vars['data']['code']; ?>
</td>
                </tr>
                <tr>
                    <th>コード名</th>
                    <td><input name="user_profile_flag_name" value="<?php echo $this->_tpl_vars['data']['name']; ?>
" size="20"/></td>
                </tr>
                <tr>
                    <th>ｱｸｾｽ後の移動先</th>
                    <td><?php echo smarty_function_html_options(array('name' => 'convert_code','options' => $this->_tpl_vars['user_profile_flag_code_convert'],'selected' => $this->_tpl_vars['data']['convert_code']), $this);?>
</td>
                </tr>
                <tr>
                    <td  style="text-align: center;" colspan="3">
                        <input type="submit" id="submit" name="action_user_UpdateUserProfileFlagDataExec" value="更新" />
                    </td>
                </tr>
           </table>
        </form>
    </div>
    <br>
<?php endif; ?>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admFooter'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
</body>
</html>