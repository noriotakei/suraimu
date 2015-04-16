<?php /* Smarty version 2.6.26, created on 2014-08-21 13:38:30
         compiled from /home/suraimu/templates/admin/user/registTestAddressDelForm.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', '/home/suraimu/templates/admin/user/registTestAddressDelForm.tpl', 35, false),array('function', 'html_radios', '/home/suraimu/templates/admin/user/registTestAddressDelForm.tpl', 40, false),array('modifier', 'default', '/home/suraimu/templates/admin/user/registTestAddressDelForm.tpl', 40, false),array('modifier', 'count', '/home/suraimu/templates/admin/user/registTestAddressDelForm.tpl', 53, false),array('modifier', 'implode', '/home/suraimu/templates/admin/user/registTestAddressDelForm.tpl', 59, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
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

<h2 class="ContentTitle">テストアドレス一覧</h2>
<form action="./" method="POST">
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" id="src_table">
        <tr>
            <th colspan="2" style="text-align: center; font-weight: bold;">検索条件</th>
        </tr>
        <tr>
            <td>カテゴリー</td>
            <td><?php echo smarty_function_html_options(array('name' => 'regist_test_mail_category_id','options' => $this->_tpl_vars['searchCategoryList'],'selected' => $this->_tpl_vars['param']['regist_test_mail_category_id']), $this);?>
</td>
        </tr>
        <tr>
            <td>メールアドレス</td>
            <td>
                <?php echo smarty_function_html_radios(array('name' => 'specify_keyword','options' => $this->_tpl_vars['specifyKeywordAry'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['param']['specify_keyword'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)),'separator' => "&nbsp;"), $this);?>
<br>
                <input type="text" name="search_string" value="<?php echo $this->_tpl_vars['param']['search_string']; ?>
" size="30">
            </td>
        </tr>
        <tr>
            <td style="text-align:center;" colspan="2">
                <input type="submit" name="action_user_RegistTestAddressDelForm" value="検 索" style="width:8em;"/>
            </td>
        </tr>
    </table>
</form>
<hr>
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
<?php if ($this->_tpl_vars['dataList']): ?>
    <div style="padding-bottom: 10px;">
    データ件数：<?php echo $this->_tpl_vars['totalCount']; ?>
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
    <form action="./" method="post" enctype="multipart/form-data">
        <?php echo $this->_tpl_vars['POSTparam']; ?>

        <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet01">
        <tr>
        <th nowrap="nowrap">カテゴリー</th>
        <th>メールアドレス</th>
        <th>テストアドレス<br>ユーザー削除</th>
        </tr>

        <?php $_from = $this->_tpl_vars['dataList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
            <tr>
            <td><?php echo $this->_tpl_vars['categoryList'][$this->_tpl_vars['val']['regist_test_mail_category_id']]; ?>
</td>
            <td><?php echo $this->_tpl_vars['val']['mail_address']; ?>
</td>
            <td style="text-align:center;"><input type="checkbox" name="disable[<?php echo $this->_tpl_vars['val']['id']; ?>
]" value="1"></td>
            </tr>
        <?php endforeach; endif; unset($_from); ?>
        </table>
        <div class="SubMenu">
            <input type="submit" name="action_user_RegistTestAddressUserDelExec" value="削　除" onClick="return confirm('削除しますか？')" />
        </div>
    </form>
    <br>
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
<?php else: ?>
    <div class="warning ui-widget">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    <p>
    <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    データはありません
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