<?php /* Smarty version 2.6.26, created on 2014-11-25 11:05:42
         compiled from /home/suraimu/templates/admin/siteContents/siteContentsList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/siteContents/siteContentsList.tpl', 20, false),array('modifier', 'implode', '/home/suraimu/templates/admin/siteContents/siteContentsList.tpl', 26, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script language="JavaScript">
<!--
    $(function() {
        // テーブルマウスオーバーカラー
        $('#list_table').colorize({
            altColor :'#CCCCCC',
            hiliteColor :'none'
        });
    });

// -->
</script>
</head>
<body>
<div class="BlockCol">
    <h2 class="ContentTitle">サイト表示設定一覧</h2>
        <?php if (count($this->_tpl_vars['execMsg'])): ?>
        <div class="warning ui-widget">
        <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
        <p>
        <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
        <?php $_from = $this->_tpl_vars['execMsg']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
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
        <input type="submit" name="action_siteContents_SiteContentsData" value="追 加"/>
    </form>
    <br>
    <?php if ($this->_tpl_vars['siteContentsList']): ?>
        <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet01">
        <tr>
            <th style="text-align: center;">表示場所</th>
            <th style="text-align: center;">タイトル</th>
            <th style="text-align: center;">表示状態</th>
            <th style="text-align: center;">表示開始日時</th>
            <th style="text-align: center;">表示終了日時</th>
            <th style="text-align: center;">更新日時</th>
            <th style="text-align: center;">編集</th>
            <th style="text-align: center;">削除</th>
        </tr>
        <?php $_from = $this->_tpl_vars['siteContentsList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['val']):
        $this->_foreach['loop']['iteration']++;
?>
            <tr style="<?php echo $this->_tpl_vars['val']['style']; ?>
">
                <td><?php echo $this->_tpl_vars['disableCd'][$this->_tpl_vars['val']['display_cd']]; ?>
</td>
                <td><?php echo $this->_tpl_vars['val']['title']; ?>
</td>
                <td><?php echo $this->_tpl_vars['displayFlag'][$this->_tpl_vars['val']['is_display']]; ?>
</td>
                <td><?php echo $this->_tpl_vars['val']['start_datetime']; ?>
</td>
                <td><?php echo $this->_tpl_vars['val']['end_datetime']; ?>
</td>
                <td><?php echo $this->_tpl_vars['val']['update_datetime']; ?>
</td>
                <td>
                    <form action="./" method="post">
                        <input type="hidden" name="page_banner_id" value="<?php echo $this->_tpl_vars['val']['id']; ?>
">
                        <input type="submit" name="action_siteContents_SiteContentsData" value="編 集"/>
                    </form>
                </td>
                <td>
                    <form action="./" method="post">
                        <input type="hidden" name="page_banner_id" value="<?php echo $this->_tpl_vars['val']['id']; ?>
">
                        <input type="hidden" name="disable" value="1">
                        <input type="submit" name="action_siteContents_SiteContentsDataExec" value="削 除" OnClick="return confirm('削除しますか？')"/>
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