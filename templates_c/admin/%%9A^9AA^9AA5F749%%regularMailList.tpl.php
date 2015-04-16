<?php /* Smarty version 2.6.26, created on 2014-08-10 17:20:08
         compiled from /home/suraimu/templates/admin/mailLog/regularMailList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_checkboxes', '/home/suraimu/templates/admin/mailLog/regularMailList.tpl', 35, false),array('function', 'html_radios', '/home/suraimu/templates/admin/mailLog/regularMailList.tpl', 41, false),array('function', 'make_link', '/home/suraimu/templates/admin/mailLog/regularMailList.tpl', 116, false),array('modifier', 'count', '/home/suraimu/templates/admin/mailLog/regularMailList.tpl', 74, false),array('modifier', 'implode', '/home/suraimu/templates/admin/mailLog/regularMailList.tpl', 80, false),array('modifier', 'cat', '/home/suraimu/templates/admin/mailLog/regularMailList.tpl', 116, false),array('modifier', 'emoji', '/home/suraimu/templates/admin/mailLog/regularMailList.tpl', 120, false),)), $this); ?>
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
        // テーブルマウスオーバーカラー
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

<h2 class="ContentTitle">定期配信一覧</h2>

<form action="./" method="POST">
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" id="src_table">
        <tr>
            <th colspan="2" style="text-align: center; font-weight: bold;">検索条件</th>
        </tr>
        <tr>
            <th>送信条件</th>
            <td>
            <?php echo smarty_function_html_checkboxes(array('name' => 'send_condition_type','options' => $this->_tpl_vars['sendConditionType'],'selected' => $this->_tpl_vars['param']['send_condition_type'],'separator' => "&nbsp;"), $this);?>

            </td>
        </tr>
        <tr>
            <th>稼働状況</th>
            <td>
            <?php echo smarty_function_html_radios(array('name' => 'is_stop','options' => $this->_tpl_vars['stopFlag'],'selected' => $this->_tpl_vars['param']['is_stop'],'separator' => "&nbsp;"), $this);?>

            </td>
        </tr>
        <tr>
            <th>定期メルマガID<br>(カンマ指定で複数可)</th>
            <td>
                <input type="text" name="id" value="<?php echo $this->_tpl_vars['param']['id']; ?>
" size="50" style="ime-mode: disabled;">
            </td>
        </tr>

        <tr>
            <th>メルマガ件名検索</th>
            <td>
                <input type="text" name="mailmagazine_subject" value="<?php echo $this->_tpl_vars['param']['mailmagazine_subject']; ?>
" size="50">
            </td>
        </tr>

        <tr>
            <th>メルマガ本文検索</th>
            <td>
                <input type="text" name="mailmagazine_body" value="<?php echo $this->_tpl_vars['param']['mailmagazine_body']; ?>
" size="50">
            </td>
        </tr>
        <tr>
            <td style="text-align:center;" colspan="2">
                <input type="submit" name="action_mailLog_regularMailList" value="検 索" style="width:8em;"/>
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

    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet02">

    <tr>
    <th>ID</th>
    <th>タイトル</th>
    <th>送信条件</th>
    <th>稼働状況</th>
    <th>PC件名</th>
    <th>MB件名</th>
    <th>強行メール</th>
    <th>作成日時</th>
    <th>削除</th>
    </tr>
    <?php $_from = $this->_tpl_vars['dataList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
        <tr>
        <td><a href="<?php echo smarty_function_make_link(array('action' => 'action_mailLog_RegularMailData','getTags' => ((is_array($_tmp="mail_maga_regular_id=")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['val']['id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['val']['id']))), $this);?>
" target="_blank"><?php echo $this->_tpl_vars['val']['id']; ?>
</a></td>
        <td><?php echo $this->_tpl_vars['val']['title']; ?>
</td>
        <td><?php echo $this->_tpl_vars['val']['send_condition']; ?>
</td>
        <td><?php echo $this->_tpl_vars['stopFlag'][$this->_tpl_vars['val']['is_stop']]; ?>
中</td>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['val']['pc_subject'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>
</td>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['val']['mb_subject'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>
</td>
        <td><?php if ($this->_tpl_vars['val']['reverse_mail_status']): ?>強行メール<?php endif; ?></td>
        <td><?php echo $this->_tpl_vars['val']['update_datetime']; ?>
</td>
        <td>
            <form action="./" method="post" style="margin:2px 0px;">
                <?php echo $this->_tpl_vars['POSTParam']; ?>

                <input type="hidden" name="mail_maga_regular_id" value="<?php echo $this->_tpl_vars['val']['id']; ?>
">
                <input type="submit" name="action_mailLog_RegularMailDelExec" value="削除" onClick="return confirm('削除しますか?')">
            </form>
        </td>
        </tr>
    <?php endforeach; endif; unset($_from); ?>
    </table>
    <br />
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
<?php else: ?>
    <div class="warning ui-widget">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    <p>
    <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    該当ログはありません
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