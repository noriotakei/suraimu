<?php /* Smarty version 2.6.26, created on 2014-10-19 15:06:25
         compiled from /home/suraimu/templates/admin/lotteryUnit/unitCreate.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/lotteryUnit/unitCreate.tpl', 7, false),array('modifier', 'implode', '/home/suraimu/templates/admin/lotteryUnit/unitCreate.tpl', 13, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</head>
<body>
<div id="ContentsCol">
    <h2 class="ContentTitle">抽選ユニットデータ作成</h2>
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
    <input type="submit" value="一覧へ戻る" name="action_user_List"/>
</div>
</form>
<table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet04">
<tr><th colspan="2" style="text-align:center;">検索条件</th></tr>
<?php $_from = $this->_tpl_vars['whereContents']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
?>
    <tr><th>
    <?php echo $this->_tpl_vars['key']; ?>

    </th>
    <td>
    <?php echo $this->_tpl_vars['val']; ?>

    </td></tr>
<?php endforeach; endif; unset($_from); ?>
</table>
<br><br>
<?php if ($this->_tpl_vars['totalCount']): ?>
    <form action="./" method="post">
        <?php echo $this->_tpl_vars['POSTparam']; ?>

        <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
            <tr>
                <th>該当件数</th>
                <td><?php echo $this->_tpl_vars['totalCount']; ?>
件</td>
            </tr>
            <tr>
                <th>抽出件数</th>
                <td><input type="text" name="number" size="5" value="<?php echo $this->_tpl_vars['returnValue']['number']; ?>
" style="ime-mode:disabled">件</td>
            </tr>
            <tr>
                <th>抽選ユニット名</th>
                <td><input type="text" name="comment" size="30" value="<?php echo $this->_tpl_vars['returnValue']['comment']; ?>
"></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center;"><input type="submit" value="抽選ユニット作成" name="action_lotteryUnit_UnitCreateExec"  onClick="return confirm('抽選ユニット作成しますか？')"/></td>
            </tr>
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
</body>
</html>