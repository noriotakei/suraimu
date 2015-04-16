<?php /* Smarty version 2.6.26, created on 2014-08-09 10:59:46
         compiled from /home/suraimu/templates/admin/registPage/registPageSearchList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', '/home/suraimu/templates/admin/registPage/registPageSearchList.tpl', 32, false),array('function', 'make_link', '/home/suraimu/templates/admin/registPage/registPageSearchList.tpl', 91, false),array('modifier', 'count', '/home/suraimu/templates/admin/registPage/registPageSearchList.tpl', 43, false),array('modifier', 'implode', '/home/suraimu/templates/admin/registPage/registPageSearchList.tpl', 49, false),array('modifier', 'cat', '/home/suraimu/templates/admin/registPage/registPageSearchList.tpl', 91, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" href="./css/pager.css" rel="stylesheet" />
<script language="JavaScript">
<!--
    $(function() {
        $('.selectText').click(function(){
            $(this).select();
        });

                $("#list_table tr:even").addClass("BgColor02");

                $("#src_table tr:even").addClass("BgColor02");

    });
// -->
</script>
</head>
<body>

<div id="ContentsCol">

<h2 class="ContentTitle">登録ページ一覧</h2>
<form action="./" method="POST">
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" id="src_table">
        <tr>
            <th colspan="2" style="text-align: center; font-weight: bold;">検索条件</th>
        </tr>
        <tr>
            <td>カテゴリー</td>
            <td><?php echo smarty_function_html_options(array('name' => 'category_id','options' => $this->_tpl_vars['searchCategoryList'],'selected' => $this->_tpl_vars['param']['category_id']), $this);?>
</td>
        </tr>
        <tr>
            <td style="text-align:center;" colspan="2">
                <input type="submit" name="action_registPage_RegistPageSearchList" value="検 索" style="width:8em;"/>
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
    <br>
<?php endif; ?>
<form action="./" method="post">
    <input type="submit" name="action_registPage_RegistPageCreate" value="登　録"/>
</form>
<br>
<?php if ($this->_tpl_vars['dataList']): ?>
    <div style="padding-bottom: 10px;">
    <?php echo $this->_tpl_vars['totalCount']; ?>
件中<br />
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
    <th>ID</th>
    <th>名前</th>
    <th>カテゴリー</th>
    <th>登録ページ<br>コード</th>
    <th>使用状況</th>
    <th>PC登録ページURL</th>
    <th>MB登録ページURL</th>
    <th>優先順位</th>
    <th>表示開始日時</th>
    <th>表示終了日時</th>
    <th>作成日時</th>
    <th>更新日時</th>
    <th>プレビュー</th>
    <th>削除</th>
    </tr>
    <?php $_from = $this->_tpl_vars['dataList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
        <tr <?php if (! $this->_tpl_vars['val']['is_use']): ?>style="background-color:tomato;"<?php endif; ?>>
        <td><a href="<?php echo smarty_function_make_link(array('action' => 'action_registPage_RegistPageData','getTags' => ((is_array($_tmp="regist_page_id=")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['val']['id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['val']['id']))), $this);?>
"><?php echo $this->_tpl_vars['val']['id']; ?>
</a></td>
        <td><?php echo $this->_tpl_vars['val']['name']; ?>
</td>
        <td><?php echo $this->_tpl_vars['categoryList'][$this->_tpl_vars['val']['regist_page_category_id']]; ?>
</td>
        <td><?php echo $this->_tpl_vars['val']['cd']; ?>
</td>
        <td><?php echo $this->_tpl_vars['isUseAry'][$this->_tpl_vars['val']['is_use']]; ?>
</td>
        <td><?php if ($this->_tpl_vars['val']['page_html_pc']): ?><textarea rows="3" class="selectText" readonly><?php echo $this->_tpl_vars['config']['define']['SITE_URL']; ?>
?pcd=<?php echo $this->_tpl_vars['val']['cd']; ?>
&advcd=[媒体コード]</textarea><?php endif; ?></td>
        <td><?php if ($this->_tpl_vars['val']['page_html_mb']): ?><textarea rows="3" class="selectText" readonly><?php echo $this->_tpl_vars['config']['define']['SITE_URL_MOBILE']; ?>
?pcd=<?php echo $this->_tpl_vars['val']['cd']; ?>
&advcd=[媒体コード]</textarea><?php endif; ?></td>
        <td><?php echo $this->_tpl_vars['val']['sort_seq']; ?>
</td>
        <td><?php echo $this->_tpl_vars['val']['display_start_datetime']; ?>
</td>
        <td><?php echo $this->_tpl_vars['val']['display_end_datetime']; ?>
</td>
        <td><?php echo $this->_tpl_vars['val']['create_datetime']; ?>
</td>
        <td><?php echo $this->_tpl_vars['val']['update_datetime']; ?>
</td>
        <td nowrap><?php if ($this->_tpl_vars['val']['page_html_pc']): ?><a href="<?php echo $this->_tpl_vars['config']['define']['SITE_URL']; ?>
?action_indexPreview=1&<?php echo $this->_tpl_vars['pageCdName']; ?>
=<?php echo $this->_tpl_vars['val']['cd']; ?>
" target="_blank">PCログイン</a><?php endif; ?><br>
                <?php if ($this->_tpl_vars['val']['page_html_mb']): ?><a href="<?php echo $this->_tpl_vars['config']['define']['SITE_URL_MOBILE']; ?>
?action_indexPreview=1&<?php echo $this->_tpl_vars['pageCdName']; ?>
=<?php echo $this->_tpl_vars['val']['cd']; ?>
" target="_blank">MBログイン</a><?php endif; ?></td>
        <td>
            <form action="./" method="post" style="margin:2px 0px;">
                <?php echo $this->_tpl_vars['POSTParam']; ?>

                <input type="hidden" name="regist_page_id" value="<?php echo $this->_tpl_vars['val']['id']; ?>
">
                <input type="hidden" name="disable" value="1">
                <input type="submit" name="action_registPage_RegistPageDataExec" value="削除" onClick="return confirm('削除しますか?')">
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