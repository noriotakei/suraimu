<?php /* Smarty version 2.6.26, created on 2015-03-17 19:28:54
         compiled from /home/suraimu/templates/admin/itemManagement/itemCategoryList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/itemManagement/itemCategoryList.tpl', 40, false),array('modifier', 'implode', '/home/suraimu/templates/admin/itemManagement/itemCategoryList.tpl', 46, false),array('modifier', 'default', '/home/suraimu/templates/admin/itemManagement/itemCategoryList.tpl', 70, false),array('modifier', 'cat', '/home/suraimu/templates/admin/itemManagement/itemCategoryList.tpl', 121, false),array('function', 'html_options', '/home/suraimu/templates/admin/itemManagement/itemCategoryList.tpl', 70, false),array('function', 'make_link', '/home/suraimu/templates/admin/itemManagement/itemCategoryList.tpl', 121, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<link type="text/css" href="./css/pager.css" rel="stylesheet" />
<script type="text/javascript">
<!--

    $(function() {

                $('#list_table').colorize({
            altColor :'#CCCCCC',
            hiliteColor :'none'
        });

                $("#src_table tr:even").addClass("BgColor02");

                if (!<?php echo $this->_tpl_vars['registParam']['return_flag']; ?>
) {
            $("#add_form").hide();
        } else {
            $("#add_form").show();
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

<h2 class="ContentTitle">商品カテゴリー一覧</h2>
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
<br>

<div class="SubMenu">
    <input type="button" id="add_button" value="追　加" />
</div>

<div id="add_form" style="display:none">
<form action="./" method="post" enctype="multipart/form-data">
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
        <tr>
            <th>管理用商品名</th>
            <td style="text-align: left;">
                <input type="text" name="name" value="<?php echo $this->_tpl_vars['registParam']['name']; ?>
" size="50">
            </td>
            <td style="text-align:center;color:#F00;">必須</td>
        </tr>
        <tr>
            <th>表示切り替え</th>
            <td style="text-align: left;"><?php echo smarty_function_html_options(array('name' => 'is_display','options' => $this->_tpl_vars['isDisplay'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['registParam']['is_display'])) ? $this->_run_mod_handler('default', true, $_tmp, 1) : smarty_modifier_default($_tmp, 1))), $this);?>
</td>
        </tr>
        <tr>
            <th>表示優先度</th>
            <td style="text-align: left;">
                <input type="text" name="sort_seq" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['registParam']['sort_seq'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
" size="10">
            </td>
            <td style="text-align: center;">任意</td>
        </tr>
        <tr>
            <th>カテゴリーグループ</th>
            <td style="text-align: left;">
                <?php echo smarty_function_html_options(array('name' => 'category_group_id','options' => $this->_tpl_vars['categoryGroupSelect'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['registParam']['item_category_group_id'])) ? $this->_run_mod_handler('default', true, $_tmp, 1) : smarty_modifier_default($_tmp, 1))), $this);?>
</td>
            </td>
        </tr>
        <tr>
            <td colspan="3"  style="text-align:center;">
                <div class="SubMenu">
                    <input type="submit" name="action_itemManagement_ItemCategoryExec" value="登録する" onClick="return confirm('登録しますか？')"/>
                </div>
            </td>
        </tr>
    </table>
</form>
</div>
<br>

<?php if ($this->_tpl_vars['itemCategoryList']): ?>
    <div style="padding-bottom: 10px;">
    登録済み：<?php echo $this->_tpl_vars['totalCount']; ?>
件<br />
    <?php echo $this->_tpl_vars['dispFirst']; ?>
～<?php echo $this->_tpl_vars['dispLast']; ?>
件表示しています
    <?php if ($this->_tpl_vars['pager']): ?>
    <ul class="pager">
        <li><?php echo $this->_tpl_vars['pager']['previous']; ?>
</li>
        <li><?php echo implode($this->_tpl_vars['pager']['pages'], "</li><li>"); ?>
</li>
        <li><?php echo $this->_tpl_vars['pager']['next']; ?>
</li>
    </ul>
    <?php endif; ?>
    </div>

    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">
        <tr bgcolor="#FF9933">
            <th>ID</th>
            <th>管理用商品名</th>
            <th>カテゴリーグループ</th>
            <th width="80">表示優先度</th>
            <th width="80">表示状態</th>
            <th>削除</th>
        </tr>
        <?php $_from = $this->_tpl_vars['itemCategoryList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
        <tr>
            <td align="center"><a href="<?php echo smarty_function_make_link(array('action' => 'action_itemManagement_ItemCategoryData','getTags' => ((is_array($_tmp="icid=")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['val']['id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['val']['id']))), $this);?>
"><?php echo $this->_tpl_vars['val']['id']; ?>
</a></td>
            <td align="left"><?php echo $this->_tpl_vars['val']['name']; ?>
</td>
            <td align="center"><?php echo $this->_tpl_vars['categoryGroupSelect'][$this->_tpl_vars['val']['item_category_group_id']]; ?>
</td>
            <td align="center"><?php echo $this->_tpl_vars['val']['sort_seq']; ?>
</td>
            <td align="center"><?php echo $this->_tpl_vars['isDisplay'][$this->_tpl_vars['val']['is_display']]; ?>
</td>
            <td>
                <form action="./" method="post" style="margin:2px 0px;">
                    <input type="hidden" name="icid" value="<?php echo $this->_tpl_vars['val']['id']; ?>
">
                    <input type="hidden" name="disable" value="1">
                    <input type="submit" name="action_itemManagement_ItemCategoryExec" value="削除" onClick="return confirm('削除しますか?')">
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
</body>
</html>