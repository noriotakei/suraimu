<?php /* Smarty version 2.6.26, created on 2015-02-02 14:41:54
         compiled from /home/suraimu/templates/admin/information/informationOperatorList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/information/informationOperatorList.tpl', 29, false),array('modifier', 'implode', '/home/suraimu/templates/admin/information/informationOperatorList.tpl', 35, false),array('modifier', 'cat', '/home/suraimu/templates/admin/information/informationOperatorList.tpl', 54, false),array('modifier', 'default', '/home/suraimu/templates/admin/information/informationOperatorList.tpl', 85, false),array('function', 'make_link', '/home/suraimu/templates/admin/information/informationOperatorList.tpl', 54, false),array('function', 'html_options', '/home/suraimu/templates/admin/information/informationOperatorList.tpl', 85, false),)), $this); ?>
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
    });

// -->
</script>
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">問い合わせ対応者一覧</h2>
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
<?php if ($this->_tpl_vars['adminInfoOperatorList']): ?>

    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">

    <tr>
    <th nowrap="nowrap">ID</th>
    <th nowrap="nowrap">担当者</th>
    <th>表示設定</th>
    <th nowrap="nowrap">管理ログインユーザー</th>
    </tr>
    <?php $_from = $this->_tpl_vars['adminInfoOperatorList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
        <tr>
        <td><a href="<?php echo smarty_function_make_link(array('action' => 'action_information_InformationOperatorUpd','getTags' => ((is_array($_tmp="id=")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['val']['id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['val']['id']))), $this);?>
"><?php echo $this->_tpl_vars['val']['id']; ?>
</a></td>
        <td><?php echo $this->_tpl_vars['val']['name']; ?>
</td>
        <td><?php echo $this->_tpl_vars['isDisplay'][$this->_tpl_vars['val']['is_display']]; ?>
</td>
        <td><?php echo $this->_tpl_vars['adminRelationUserList'][$this->_tpl_vars['val']['admin_id']]; ?>
</td>
        </tr>
    <?php endforeach; endif; unset($_from); ?>
    </table>

<?php endif; ?>

<div class="SubMenu">
    <input type="button" id="add_button" value="追　加" />
</div>

<div id="add_form" style="display:none;">
<form action="./" method="POST">
    <?php echo $this->_tpl_vars['POSTparam']; ?>

    <table class="TableSet04">
        <tr>
            <th>
                担当者：<br>(表示名)
            </th>
            <td>
                <input type="text" name="name" value="<?php echo $this->_tpl_vars['param']['name']; ?>
">
            </td>
        </tr>
        <tr>
            <th>
                表示設定：
            </th>
            <td>
                <?php echo smarty_function_html_options(array('name' => 'is_display','options' => $this->_tpl_vars['isDisplay'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['param']['is_display'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))), $this);?>

            </td>
        </tr>
        <tr>
            <th>
                管理ログインユーザー
            </th>
            <td>
                <?php echo smarty_function_html_options(array('name' => 'admin_id','options' => $this->_tpl_vars['adminRelationUserList'],'selected' => $this->_tpl_vars['param']['id']), $this);?>

                &nbsp;<font color="blue">※管理画面ログインユーザー(管理者またはオペレーター)⇔問い合わせ担当者<br>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">
                <input type="submit" value="登　録" name="action_information_InformationOperatorRegExec" onClick="return confirm('登録しますか？')">
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