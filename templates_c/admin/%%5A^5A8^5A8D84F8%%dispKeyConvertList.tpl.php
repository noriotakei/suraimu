<?php /* Smarty version 2.6.26, created on 2015-04-09 10:45:03
         compiled from /home/suraimu/templates/admin/keyConvert/dispKeyConvertList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', '/home/suraimu/templates/admin/keyConvert/dispKeyConvertList.tpl', 31, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script language="JavaScript">
<!--

    $(function() {
        $('.selectText').click(function(){
            $(this).select();
        });

                $('#list_table').colorize({
            altColor :'#CCCCCC',
            hiliteColor :'none'
        });
    });

// -->
</script>
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">システム変換表</h2>
<form action="./" method="POST">
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" id="src_table">
        <tr>
            <th colspan="2" style="text-align: center; font-weight: bold;">検索条件</th>
        </tr>
        <tr>
            <td>カテゴリー</td>
            <td><?php echo smarty_function_html_options(array('name' => 'key_convert_list_category_id','options' => $this->_tpl_vars['categoryList'],'selected' => $this->_tpl_vars['param']['key_convert_list_category_id']), $this);?>
</td>
        </tr>
        <tr>
            <td style="text-align:center;" colspan="2">
                <input type="submit" name="action_keyConvert_DispKeyConvertList" value="検 索" style="width:8em;"/>
            </td>
        </tr>
    </table>
</form>
<hr>
<br>
<?php if ($this->_tpl_vars['keyConvertList']): ?>
    <form action="./" method="POST">
        <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">
            <tr>
                <th>変換キー</th>
                <th>変換内容</th>
                <th>タイプ</th>
                <th>カテゴリー</th>
                <th>備考</th>
            </tr>
            <?php $_from = $this->_tpl_vars['keyConvertList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
                <tr>
                    <td><input type="text" class="selectText" name="key_name[<?php echo $this->_tpl_vars['val']['id']; ?>
]" size="20" value="<?php echo $this->_tpl_vars['val']['key_name']; ?>
" readonly></td>
                    <td><?php echo $this->_tpl_vars['val']['contents']['contents']; ?>
</td>
                    <td><?php echo $this->_tpl_vars['config']['admin_config']['convert_type_name'][$this->_tpl_vars['val']['type']]; ?>
</td>
                    <td><?php echo $this->_tpl_vars['categoryList'][$this->_tpl_vars['val']['key_convert_list_category_id']]; ?>
</td>
                    <td><?php echo $this->_tpl_vars['val']['description']; ?>
</td>
                </tr>
            <?php endforeach; endif; unset($_from); ?>
        </table>
    </form>
<?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admFooter'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
</body>
</html>