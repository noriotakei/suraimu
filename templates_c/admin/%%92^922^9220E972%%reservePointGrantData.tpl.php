<?php /* Smarty version 2.6.26, created on 2014-10-23 12:25:16
         compiled from /home/suraimu/templates/admin/mailLog/reservePointGrantData.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/mailLog/reservePointGrantData.tpl', 34, false),array('modifier', 'implode', '/home/suraimu/templates/admin/mailLog/reservePointGrantData.tpl', 40, false),)), $this); ?>
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
    <h2 class="ContentTitle">予約ばらまき条件</h2>
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
            <th colspan="2" style="text-align: center">変更</th>
        </tr>
        <tr>
            <td><textarea name="description" rows="10" cols="50"><?php echo $this->_tpl_vars['param']['description']; ?>
</textarea></td>
        </tr>
        <tr>
            <td>
                <input type="hidden" name="reserve_point_grant_id" value="<?php echo $this->_tpl_vars['param']['id']; ?>
"/>
                <input type="submit" name="action_mailLog_ReservePointGrantUpdExec" value="変更する" onClick="return confirm('登録しますか？')" />
            </td>
        </tr>
        </table>
    </form>
    </div>
    <br>

    <?php if ($this->_tpl_vars['param']): ?>
        <table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet04">
        <tr><th colspan="2" style="text-align:center;">検索条件</th></tr>
        <?php $_from = $this->_tpl_vars['param']['where_contents']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
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