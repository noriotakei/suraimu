<?php /* Smarty version 2.6.26, created on 2014-09-10 13:53:21
         compiled from /home/suraimu/templates/admin/ordering/supportMailLogData.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/ordering/supportMailLogData.tpl', 92, false),array('modifier', 'implode', '/home/suraimu/templates/admin/ordering/supportMailLogData.tpl', 98, false),array('modifier', 'in_array', '/home/suraimu/templates/admin/ordering/supportMailLogData.tpl', 130, false),array('modifier', 'nl2br', '/home/suraimu/templates/admin/ordering/supportMailLogData.tpl', 151, false),array('modifier', 'emoji', '/home/suraimu/templates/admin/ordering/supportMailLogData.tpl', 166, false),array('modifier', 'escape', '/home/suraimu/templates/admin/ordering/supportMailLogData.tpl', 166, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
<script type="text/javascript" src="./js/jquery.timepickr.min.js"></script>
<script language="JavaScript">
<!--

    $(function() {
                $("#pc_tabs").tabs();

        $( "#pc_tabs" ).bind( "tabsselect", function(event, ui) {
                var formId = "pc-tabs-2" + (+new Date());
                var form = $('<form action="./" method="POST" name="' + formId + '" id="' + formId + '" target="pc-tabs-2"></form>');
                $(form).appendTo('body');
                var source = $("<input/>").attr({
                    "type": "hidden",
                    "name": "pc_html_body",
                    "value": $("#pc_html_body").val()
                });
                $(form).append(source);
                var source = $("<input/>").attr({
                    "type": "hidden",
                    "name": "action_mailLog_MailLogPreview",
                    "value": "1"
                });
                $(form).append(source);
                var source = $("<input/>").attr({
                    "type": "hidden",
                    "name": "pc",
                    "value": "1"
                });
                $(form).append(source);
                var source = $("<input/>").attr({
                    "type": "hidden",
                    "name": "smlid",
                    "value": <?php echo $this->_tpl_vars['supportMailData']['id']; ?>

                });
                $(form).append(source);
                $(form).submit();
                setTimeout(function() {
                    $(form).remove();
                }, 100);
        });

                $("#mb_tabs").tabs();

        $( "#mb_tabs" ).bind( "tabsselect", function(event, ui) {
                var formId = "mb-tabs-2" + (+new Date());
                var form = $('<form action="./" method="POST" name="' + formId + '" id="' + formId + '" target="mb-tabs-2"></form>');
                $(form).appendTo('body');
                var source = $("<input/>").attr({
                    "type": "hidden",
                    "name": "mb_html_body",
                    "value": $("#mb_html_body").val()
                });
                $(form).append(source);
                var source = $("<input/>").attr({
                    "type": "hidden",
                    "name": "action_mailLog_MailLogPreview",
                    "value": "1"
                });
                $(form).append(source);
                var source = $("<input/>").attr({
                    "type": "hidden",
                    "name": "smlid",
                    "value": <?php echo $this->_tpl_vars['supportMailData']['id']; ?>

                });
                $(form).append(source);
                $(form).submit();
                setTimeout(function() {
                    $(form).remove();
                }, 100);
        });

        // 送信確認文言
        $("#mailInput").submit(function(){
            return confirm("設定しますか？");
        });

    });


// -->
</script>

</head>
<body>
<div class="BlockCol">
    <h2 class="ContentTitle">サポートメールログ</h2>
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
        <?php echo $this->_tpl_vars['POSTparam']; ?>

        <input type="submit" name="action_ordering_OrderingData" value="注文詳細へ戻る" style="width:8em;"/>
    </form>
    <br>
    <?php if ($this->_tpl_vars['supportMailData']): ?>
        <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">
            <tr>
                <th>作成日時</th>
                <td style="text-align: left;">
                    <?php echo $this->_tpl_vars['supportMailData']['create_datetime']; ?>

                </td>
            </tr>
            <tr>
                <th>送信元アドレス</th>
                <td style="text-align: left;">
                    <?php echo $this->_tpl_vars['supportMailData']['from_address']; ?>

                </td>
            </tr>
            <tr>
                <th>送信者名</th>
                <td style="text-align: left;">
                    <?php echo $this->_tpl_vars['supportMailData']['from_name']; ?>

                </td>
            </tr>
            <?php if (((is_array($_tmp='pc_address')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
            <tr>
                <th>送信PCアドレス</th>
                <td style="text-align: left;"><?php echo $this->_tpl_vars['supportMailData']['pc_to_address']; ?>
</td>
            </tr>
            <?php endif; ?>
            <?php if (((is_array($_tmp='mb_address')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
            <tr>
                <th>送信MBアドレス</th>
                <td style="text-align: left;"><?php echo $this->_tpl_vars['supportMailData']['mb_to_address']; ?>
</td>
            </tr>
            <?php endif; ?>
            <tr>
                <th>PC件名</th>
                <td style="text-align: left;">
                    <?php echo $this->_tpl_vars['supportMailData']['pc_subject']; ?>

                </td>
            </tr>
            <tr>
                <th>PCTEXT本文</th>
                <td style="text-align: left;">
                    <?php echo ((is_array($_tmp=$this->_tpl_vars['supportMailData']['pc_text_body'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>

                </td>
            </tr>
            <tr>
                <th>
                    HTML本文(PC)
                </th>
                <td width="100%">
                    <div id="pc_tabs">
                        <ul>
                            <li><a href="#pc-tabs-2">html</a></li>
                            <li><a href="#pc-tabs-1">view source</a></li>
                        </ul>
                        <iframe id="pc-tabs-2" name="pc-tabs-2" src="./?action_mailLog_MailLogPreview=1&pc=1&smlid=<?php echo $this->_tpl_vars['supportMailData']['id']; ?>
" height="500px" width="95%"></iframe>
                        <div id="pc-tabs-1">
                            <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['supportMailData']['pc_html_body'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>

                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th>MB件名</th>
                <td style="text-align: left;">
                    <?php echo $this->_tpl_vars['supportMailData']['mb_subject']; ?>

                </td>
            </tr>
            <tr>
                <th>MBTEXT本文</th>
                <td style="text-align: left;">
                    <?php echo ((is_array($_tmp=$this->_tpl_vars['supportMailData']['mb_text_body'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>

                </td>
            </tr>
            <tr>
                <th>
                    HTML本文(MB)
                </th>
                <td width="100%">
                    <div id="mb_tabs">
                        <ul>
                            <li><a href="#mb-tabs-2">html</a></li>
                            <li><a href="#mb-tabs-1">view source</a></li>
                        </ul>
                        <iframe id="mb-tabs-2" name="mb-tabs-2" src="./?action_mailLog_MailLogPreview=1&smlid=<?php echo $this->_tpl_vars['supportMailData']['id']; ?>
" height="500px" width="95%"></iframe>
                        <div id="mb-tabs-1">
                            <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['supportMailData']['mb_html_body'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>

                        </div>
                    </div>
                </td>
            </tr>
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