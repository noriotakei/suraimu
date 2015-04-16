<?php /* Smarty version 2.6.26, created on 2015-03-17 19:28:46
         compiled from /home/suraimu/templates/admin/informationDisplayPosition/informationDisplayPositionList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'make_link', '/home/suraimu/templates/admin/informationDisplayPosition/informationDisplayPositionList.tpl', 26, false),array('modifier', 'cat', '/home/suraimu/templates/admin/informationDisplayPosition/informationDisplayPositionList.tpl', 26, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script type="text/javascript">
<!--
    $(function() {
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

<h2 class="ContentTitle">情報表示場所一覧</h2>
<table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">
    <tr bgcolor="#FF9933">
        <th>情報表示場所</th>
    </tr>
    <?php $_from = $this->_tpl_vars['displayPositionList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
?>
        <tr>
            <td align="center"><a href="<?php echo smarty_function_make_link(array('action' => 'action_informationDisplayPosition_InformationDisplayPositionData','getTags' => ((is_array($_tmp="position_id=")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['key']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['key']))), $this);?>
"><?php echo $this->_tpl_vars['val']; ?>
</a></td>
        </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admFooter'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
</body>
</html>