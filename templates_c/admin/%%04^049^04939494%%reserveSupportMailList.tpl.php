<?php /* Smarty version 2.6.26, created on 2015-02-03 14:05:59
         compiled from /home/suraimu/templates/admin/ordering/reserveSupportMailList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', '/home/suraimu/templates/admin/ordering/reserveSupportMailList.tpl', 52, false),array('modifier', 'zend_date_format', '/home/suraimu/templates/admin/ordering/reserveSupportMailList.tpl', 52, false),array('modifier', 'count', '/home/suraimu/templates/admin/ordering/reserveSupportMailList.tpl', 64, false),array('modifier', 'implode', '/home/suraimu/templates/admin/ordering/reserveSupportMailList.tpl', 70, false),array('modifier', 'cat', '/home/suraimu/templates/admin/ordering/reserveSupportMailList.tpl', 104, false),array('modifier', 'emoji', '/home/suraimu/templates/admin/ordering/reserveSupportMailList.tpl', 106, false),array('function', 'make_link', '/home/suraimu/templates/admin/ordering/reserveSupportMailList.tpl', 104, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
<script type="text/javascript" src="./js/jquery.timepickr.min.js"></script>
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<link type="text/css" href="./css/pager.css" rel="stylesheet" />
<script type="text/javascript">
<!--


    $(function() {
                $(".time").timepickr({
            format24: "{h:02.d}:{m:02.d}:{s:02.d}",
            seconds: true,
            rangeMin: ["00","05","10","15","20","25","30","35","40","45","50","55","59"],
            rangeSec: ["00","15","30","45","59"],
            convention: 24
        });

                $(".datepicker").datepicker({
            numberOfMonths: 2,
            showButtonPanel: true,
            dateFormat: "yy-mm-dd"
        });

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

<h2 class="ContentTitle">サポートメール予約配信一覧</h2>
<form action="./" method="POST">
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" id="src_table">
        <tr>
            <th colspan="2" style="text-align: center; font-weight: bold;">検索条件</th>
        </tr>
        <tr>
            <th>配信予定時間</th>
            <td>
            <input class="datepicker" size="15" type="text" value="<?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['param']['dispDatetimeFrom'])) ? $this->_run_mod_handler('default', true, $_tmp, time()) : smarty_modifier_default($_tmp, time())))) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="disp_date_from"maxlength="10">&nbsp;<input name="disp_time_from" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['dispDatetimeFrom'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10"maxlength="8">
                ～&nbsp;<input class="datepicker" size="15" type="text" value="<?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['param']['dispDatetimeTo'])) ? $this->_run_mod_handler('default', true, $_tmp, time()) : smarty_modifier_default($_tmp, time())))) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="disp_date_to"maxlength="10">&nbsp;<input name="disp_time_to" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['dispDatetimeTo'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10"maxlength="8"></td>
        </tr>
        <tr>
            <td style="text-align:center;" colspan="2">
                <input type="submit" name="action_ordering_ReserveSupportMailList" value="検 索" style="width:8em;"/>
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
    <th>配信予定時間</th>
    <th>PC件名</th>
    <th>MB件名</th>
    <th>配信状況</th>
    <th>作成日時</th>
    <th>削除</th>
    </tr>
    <?php $_from = $this->_tpl_vars['dataList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
        <tr>
        <td><a href="<?php echo smarty_function_make_link(array('action' => 'action_ordering_ReserveSupportMailData','getTags' => ((is_array($_tmp="support_mail_reserve_id=")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['val']['id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['val']['id']))), $this);?>
" target="_blank"><?php echo $this->_tpl_vars['val']['id']; ?>
</a></td>
        <td><?php echo $this->_tpl_vars['val']['send_datetime']; ?>
</td>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['val']['pc_subject'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>
</td>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['val']['mb_subject'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>
</td>
        <td><?php if ($this->_tpl_vars['val']['is_send']): ?>配信済み<?php else: ?>未配信<?php endif; ?></td>
        <td><?php echo $this->_tpl_vars['val']['create_datetime']; ?>
</td>
        <td>
            <form action="./" method="post" style="margin:2px 0px;">
                <?php echo $this->_tpl_vars['POSTParam']; ?>

                <input type="hidden" name="support_mail_reserve_id" value="<?php echo $this->_tpl_vars['val']['id']; ?>
">
                <input type="submit" name="action_ordering_ReserveSupportMailDelExec" value="削除" onClick="return confirm('削除しますか?')">
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