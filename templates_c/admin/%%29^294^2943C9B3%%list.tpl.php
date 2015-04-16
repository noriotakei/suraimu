<?php /* Smarty version 2.6.26, created on 2014-12-18 15:39:14
         compiled from /home/suraimu/templates/admin/unit/list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', '/home/suraimu/templates/admin/unit/list.tpl', 31, false),array('function', 'make_link', '/home/suraimu/templates/admin/unit/list.tpl', 86, false),array('modifier', 'count', '/home/suraimu/templates/admin/unit/list.tpl', 48, false),array('modifier', 'implode', '/home/suraimu/templates/admin/unit/list.tpl', 54, false),array('modifier', 'cat', '/home/suraimu/templates/admin/unit/list.tpl', 86, false),)), $this); ?>
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
<h2 class="ContentTitle">ユニット一覧</h2>
<form action="./" method="POST">
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" id="src_table">
        <tr>
            <th colspan="2" style="text-align: center; font-weight: bold;">検索条件</th>
        </tr>
        <tr>
            <th>ログ削除対象フラグ</th>
            <td><?php echo smarty_function_html_options(array('name' => 'is_stay','options' => $this->_tpl_vars['isStay'],'selected' => $this->_tpl_vars['param']['is_stay']), $this);?>
</td>
        </tr>
        <tr>
            <th>コメント</th>
            <td>
                <input type="text" name="search_string" value="<?php echo $this->_tpl_vars['param']['search_string']; ?>
" size="30">
            </td>
        </tr>
        <tr>
            <td style="text-align:center;" colspan="2">
                <input type="submit" name="action_unit_List" value="検 索" style="width:8em;"/>
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

    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet01">
    <tr>
    <th nowrap="nowrap">ID</th>
    <th>コメント</th>
    <th>人数</th>
    <th nowrap="nowrap">ログ削除対象フラグ</th>
    <th>登録時間</th>
    <th>削除</th>
    </tr>

    <?php $_from = $this->_tpl_vars['dataList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
        <tr>
        <td><a href="<?php echo smarty_function_make_link(array('action' => 'action_unit_UnitData','getTags' => ((is_array($_tmp="id=")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['val']['id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['val']['id']))), $this);?>
"><?php echo $this->_tpl_vars['val']['id']; ?>
</a></td>
        <td><?php echo $this->_tpl_vars['val']['comment']; ?>
</td>
        <td><?php echo $this->_tpl_vars['val']['count']; ?>
人</td>
        <td><?php echo $this->_tpl_vars['isStay'][$this->_tpl_vars['val']['is_stay']]; ?>
</td>
        <td><?php echo $this->_tpl_vars['val']['create_datetime']; ?>
</td>
        <td>
            <form action="./" method="post" style="margin:2px 0px;">
                <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['val']['id']; ?>
">
                <input type="hidden" name="disable" value="1">
                <input type="submit" name="action_unit_UnitUpdExec" value="削除" onClick="return confirm('削除しますか?')">
            </form>
        </td>
        </tr>
    <?php endforeach; endif; unset($_from); ?>

    </table>
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