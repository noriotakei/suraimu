<?php /* Smarty version 2.6.26, created on 2014-10-14 14:02:51
         compiled from /home/suraimu/templates/admin/user/registCsv.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/user/registCsv.tpl', 32, false),array('modifier', 'implode', '/home/suraimu/templates/admin/user/registCsv.tpl', 38, false),)), $this); ?>
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


    });

//-->
</script>
</head>
<body>

<div id="ContentsCol">

<h2 class="ContentTitle">アドレスCSVアップロード登録フォーム</h2>
<br />
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
<?php endif; ?>

<form action="./" enctype="multipart/form-data" method="post">
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" id="src_table">
        <tr>
            <th>アドコード</th>
            <td>
            <input size="15" type="text" name="advcd" maxlength="15">
        </tr>
        <tr>
            <th>登録入口コード</th>
            <td>
            <input size="15" type="text" name="registPageId" maxlength="15">
        </tr>
        <tr>
            <th>対象CSVファイル</th>
	        <td>
	            <input type="hidden" name="MAX_FILE_SIZE" value="8000000">
	            <input type="file" name="regCsvFile">
	        </td>
        </tr>
        <tr>
	        <td style="text-align:center;" colspan="2">
	            <input type="submit" name="action_User_RegistCsvExec" value="ユーザー登録" OnClick="return confirm('登録しますか？')">
	        </td>
        </tr>
    </table>
</form>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admFooter'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script type="text/javascript" src="./js/watermark/jquery.watermark.min.js"></script>
<script type="text/javascript" src="./js/userSearch.js"></script>
</div>
</body>
</html>