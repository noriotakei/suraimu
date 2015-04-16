<?php /* Smarty version 2.6.26, created on 2014-10-27 12:06:23
         compiled from /home/suraimu/templates/admin/autoMail/autoMailContentsList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/autoMail/autoMailContentsList.tpl', 36, false),array('modifier', 'implode', '/home/suraimu/templates/admin/autoMail/autoMailContentsList.tpl', 42, false),array('modifier', 'default', '/home/suraimu/templates/admin/autoMail/autoMailContentsList.tpl', 65, false),array('function', 'html_options', '/home/suraimu/templates/admin/autoMail/autoMailContentsList.tpl', 92, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script type="text/javascript">
<!--

    $(function() {

        // テーブルマウスオーバーカラー
        $('#list_table').colorize({
            altColor :'#CCCCCC',
            hiliteColor :'none'
        });

                if (<?php echo $this->_tpl_vars['param']['return_type']; ?>
 == 1) {
            $("#add_form").show();
        } else {
            $("#add_form").hide();
        }

        $('#add_button').live("click", function(){
            $("#add_form").toggle("blind", null, "slow");
        });

    });

//-->
</script>
</head>
<body>

<div id="ContentsCol">

<h2 class="ContentTitle">リメールコンテンツ一覧</h2>
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
<div class="SubMenu">
    <input type="button" id="add_button" value="追　加" />
</div>
<div id="add_form" style="display:none">
<form action="./" method="post" enctype="multipart/form-data">
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
    <tr>
        <th nowrap="nowrap">名前</th>
        <th>ページ名</th>
        <th>変数名(配列のキー名)</th>
        <th>表示順</th>
        <th></th>
    </tr>
    <tr>
        <td><input type="text" name="name" value="<?php echo $this->_tpl_vars['param']['name']; ?>
" size="20"></td>
        <td><input type="text" name="page_name" value="<?php echo $this->_tpl_vars['param']['page_name']; ?>
" size="20"></td>
        <td><input type="text" name="variable_name" value="<?php echo $this->_tpl_vars['param']['variable_name']; ?>
" size="20"></td>
        <td><input type="text" name="sort_seq" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['param']['sort_seq'])) ? $this->_run_mod_handler('default', true, $_tmp, 1) : smarty_modifier_default($_tmp, 1)); ?>
" size="3"></td>
        <td><input type="submit" name="action_autoMail_AutoMailContentsAddExec" value="登　録" onClick="return confirm('登録しますか？')" /></td>
    </tr>
    </table>
</form>
</div>
<br>
<?php if ($this->_tpl_vars['dataList']): ?>
<form action="./" method="post" enctype="multipart/form-data">
    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">

    <tr>
    <th nowrap="nowrap">ID</th>
    <th nowrap="nowrap">名前</th>
    <th>ページ名</th>
    <th>変数名(配列のキー名)</th>
    <th>表示順</th>
    <th>使用状況</th>
    <th>削除</th>
    </tr>
    <?php $_from = $this->_tpl_vars['dataList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
?>
        <tr>
        <td><input type="hidden" name="id[]" value="<?php echo $this->_tpl_vars['val']['id']; ?>
"><?php echo $this->_tpl_vars['val']['id']; ?>
</td>
        <td><input type="text" name="name[]" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['paramAry']['name'][$this->_tpl_vars['key']])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['val']['name']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['val']['name'])); ?>
" size="20"></td>
        <td><input type="text" name="page_name[]" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['paramAry']['page_name'][$this->_tpl_vars['key']])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['val']['page_name']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['val']['page_name'])); ?>
" size="20"></td>
        <td><input type="text" name="variable_name[]" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['paramAry']['variable_name'][$this->_tpl_vars['key']])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['val']['variable_name']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['val']['variable_name'])); ?>
" size="20"></td>
        <td><input type="text" name="sort_seq[]" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['paramAry']['sort_seq'][$this->_tpl_vars['key']])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['val']['sort_seq']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['val']['sort_seq'])); ?>
" size="3"></td>
        <td><?php echo smarty_function_html_options(array('name' => "is_use[]",'options' => $this->_tpl_vars['isUse'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['paramAry']['is_use'][$this->_tpl_vars['key']])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['val']['is_use']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['val']['is_use']))), $this);?>
</td>
        <td>
            <form action="./" method="post" style="margin:2px 0px;">
                <?php echo $this->_tpl_vars['POSTParam']; ?>

                <input type="hidden" name="auto_mail_contents_id" value="<?php echo $this->_tpl_vars['val']['id']; ?>
">
                <input type="submit" name="action_autoMail_AutoMailContentsDelExec" value="削除" onClick="return confirm('削除しますか?')">
            </form>
        </td>
        </tr>
    <?php endforeach; endif; unset($_from); ?>
    </table>
    <div class="SubMenu">
        <input type="submit" name="action_autoMail_AutoMailContentsAddExec" value="更　新" onClick="return confirm('更新しますか？')" />
    </div>
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
</body>
</html>