<?php /* Smarty version 2.6.26, created on 2014-08-12 18:12:39
         compiled from /home/suraimu/templates/admin/banner/bannerImageCategoryList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/banner/bannerImageCategoryList.tpl', 37, false),array('modifier', 'implode', '/home/suraimu/templates/admin/banner/bannerImageCategoryList.tpl', 43, false),)), $this); ?>
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

        $('#add_button').live("click", function(env){
            if (env.button !== 0) return;
            $("#add_form").toggle("blind", null, "slow");
        });

    });

//-->
</script>
</head>
<body>

<div id="ContentsCol">

<h2 class="ContentTitle">バナー画像カテゴリー一覧</h2>
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
<form action="./" method="post">
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
    <tr>
        <th nowrap="nowrap">名前</th>
        <th></th>
    </tr>
    <tr>
        <td><input type="text" name="name" value="<?php echo $this->_tpl_vars['param']['name']; ?>
" size="20"></td>
        <td><input type="submit" name="action_banner_BannerImageCategoryExec" value="登　録" onClick="return confirm('登録しますか？')" /></td>
    </tr>
    </table>
</form>
<br>
</div>
<br>
<?php if ($this->_tpl_vars['dataList']): ?>
<form action="./" method="post">
    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">

    <tr>
    <th nowrap="nowrap">ID</th>
    <th nowrap="nowrap">名前</th>
    <th>削除</th>
    </tr>
    <?php $_from = $this->_tpl_vars['dataList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
?>
        <tr>
        <td><input type="hidden" name="id[<?php echo $this->_tpl_vars['val']['id']; ?>
]" value="<?php echo $this->_tpl_vars['val']['id']; ?>
"><?php echo $this->_tpl_vars['val']['id']; ?>
</td>
        <td><input type="text" name="name[<?php echo $this->_tpl_vars['val']['id']; ?>
]" value="<?php echo $this->_tpl_vars['val']['name']; ?>
" size="20"></td>
        <td><input type="checkbox" name="disable[<?php echo $this->_tpl_vars['val']['id']; ?>
]" value="1"></td>
        </tr>
    <?php endforeach; endif; unset($_from); ?>
    </table>
    <div class="SubMenu">
        <input type="submit" name="action_banner_BannerImageCategoryExec" value="更　新" onClick="return confirm('更新しますか？')" />
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