<?php /* Smarty version 2.6.26, created on 2015-04-09 11:24:39
         compiled from /home/suraimu/templates/admin/ordering/regularSupportMailData.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/ordering/regularSupportMailData.tpl', 135, false),array('modifier', 'implode', '/home/suraimu/templates/admin/ordering/regularSupportMailData.tpl', 141, false),array('modifier', 'date_format', '/home/suraimu/templates/admin/ordering/regularSupportMailData.tpl', 198, false),array('function', 'make_link', '/home/suraimu/templates/admin/ordering/regularSupportMailData.tpl', 164, false),array('function', 'html_radios', '/home/suraimu/templates/admin/ordering/regularSupportMailData.tpl', 180, false),array('function', 'html_options', '/home/suraimu/templates/admin/ordering/regularSupportMailData.tpl', 190, false),)), $this); ?>
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

        $("#src_table tr:even").addClass("BgColor02");

                $(".time").timepickr({
            format24: "{h:02.d}:{m:02.d}",
            rangeMin: ["00","15","30","45"]
        });

                openRegulerInput($('.regular'));

        $('.regular').change(function(){
            openRegulerInput($(this));
        });

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
                    "name": "rgsmlid",
                    "value": <?php echo $this->_tpl_vars['data']['id']; ?>

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
                    "name": "rgsmlid",
                    "value": <?php echo $this->_tpl_vars['data']['id']; ?>

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

        function openRegulerInput(selectId) {

        var selectId = $(selectId);

        if (selectId.val() == 1) {
            $("#regular_day").show();
            $("#regular_hour").hide();
            $("#regular_week").hide();
            $("#regular_month").hide();
        } else if (selectId.val() == 2) {
            $("#regular_week").show();
            $("#regular_day").hide();
            $("#regular_hour").hide();
            $("#regular_month").hide();
        } else if (selectId.val() == 3) {
            $("#regular_month").show();
            $("#regular_day").hide();
            $("#regular_hour").hide();
            $("#regular_week").hide();
        } else {
            $("#regular_hour").show();
            $("#regular_day").hide();
            $("#regular_week").hide();
            $("#regular_month").hide();
        }

    }

// -->
</script>
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">サポートメール定期配信履歴</h2>
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
<?php if ($this->_tpl_vars['data']): ?>
    <div>
        <table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet04">
        <tr><th colspan="2" style="text-align:center;">検索条件</th></tr>
        <?php $_from = $this->_tpl_vars['data']['where_contents']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
?>
            <tr><th>
            <?php echo $this->_tpl_vars['key']; ?>

            </th>
            <td>
            <?php echo $this->_tpl_vars['val']; ?>

            </td></tr>
        <?php endforeach; endif; unset($_from); ?>
        </table>
    </div>
    <br>
    <div>
        <a href="<?php echo smarty_function_make_link(array('action' => 'action_keyConvert_DispKeyConvertList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="_blank">システム変換管理</a>
    </div>
    <br>
    <div>
    <form action="./" method="post" id="mailInput" name="mailInput" enctype="multipart/form-data">
    <?php echo $this->_tpl_vars['POSTparam']; ?>

        <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
            <tr>
                <th>作成日時</th>
                <td colspan="2">
                    <?php echo $this->_tpl_vars['data']['update_datetime']; ?>

                </td>
            </tr>
            <tr>
                <th>稼働状況</th>
                <td colspan="2">
                    <?php echo smarty_function_html_radios(array('name' => 'is_stop','options' => $this->_tpl_vars['stopFlag'],'selected' => $this->_tpl_vars['data']['is_stop'],'separator' => "&nbsp;"), $this);?>

                </td>
            </tr>
            <tr>
            <th>送信条件</th>
            <td style="text-align: left;" colspan="2">
                <div id="regular">
                    <div id="title">
                        タイトル:<input type="text" name="title" value="<?php echo $this->_tpl_vars['data']['title']; ?>
" size="50">
                    </div>
                    <?php echo smarty_function_html_options(array('class' => 'regular','name' => 'send_condition_type','options' => $this->_tpl_vars['sendConditionType'],'selected' => $this->_tpl_vars['data']['send_condition_type']), $this);?>

                    <div id="regular_hour">
                        <input type="text" name="hour_from" value="<?php echo $this->_tpl_vars['data']['hour_from']; ?>
" size="2" maxlength="2" style="ime-mode:disabled">時から
                        <input type="text" name="hour_to" value="<?php echo $this->_tpl_vars['data']['hour_to']; ?>
" size="2" maxlength="2" style="ime-mode:disabled">時までの
                        <?php echo smarty_function_html_options(array('name' => 'second','options' => $this->_tpl_vars['sendConditionTypeHourSecond'],'selected' => $this->_tpl_vars['data']['second']), $this);?>
分に送信する
                    </div>
                    <div id="regular_week">
                        <?php echo smarty_function_html_options(array('name' => 'week','options' => $this->_tpl_vars['config']['admin_config']['week_array'],'selected' => $this->_tpl_vars['data']['week']), $this);?>

                        <input name="send_time_week" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['send_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%H:%M') : smarty_modifier_date_format($_tmp, '%H:%M')); ?>
" size="7" maxlength="5">に送信する
                    </div>
                    <div id="regular_month">
                        <?php echo smarty_function_html_options(array('name' => 'send_day','options' => $this->_tpl_vars['dayAry'],'selected' => $this->_tpl_vars['data']['send_day']), $this);?>
日
                        <input name="send_time_month" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['send_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%H:%M') : smarty_modifier_date_format($_tmp, '%H:%M')); ?>
" size="7" maxlength="5">に送信する
                    </div>
                    <div id="regular_day">
                        <input name="send_time_day" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['send_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%H:%M') : smarty_modifier_date_format($_tmp, '%H:%M')); ?>
" size="7" maxlength="5">に送信する
                    </div>
                </div>
            </td>
            </tr>
            <tr>
                <th>送信アドレス</th>
                <td colspan="2">
                    <input type="text" name="from_address" value="<?php echo $this->_tpl_vars['data']['from_address']; ?>
" size="50" style="ime-mode: disabled;">
                </td>
            </tr>
            <tr>
                <th>送信名</th>
                <td colspan="2">
                    <input type="text" name="from_name" value="<?php echo $this->_tpl_vars['data']['from_name']; ?>
" size="50">
                </td>
            </tr>
            <tr>
                <th>
                    PC添付画像
                </th>
                <td style="text-align: left;">
                    <input type="text" value='<img src="001">' size="20" class="selectText" readonly> <input type="file" name="pc_image[1]"><br>
                    <input type="text" value='<img src="002">' size="20" class="selectText" readonly> <input type="file" name="pc_image[2]"><br>
                    <input type="text" value='<img src="003">' size="20" class="selectText" readonly> <input type="file" name="pc_image[3]"><br>
                    <input type="text" value='<img src="004">' size="20" class="selectText" readonly> <input type="file" name="pc_image[4]"><br>
                    <input type="text" value='<img src="005">' size="20" class="selectText" readonly> <input type="file" name="pc_image[5]"><br>
                </td>
            </tr>
            <tr>
                <th>
                    件名(PC)
                </th>
                <td colspan="2">
                    <input type="text" name="pc_subject" value="<?php echo $this->_tpl_vars['data']['pc_subject']; ?>
" size="50">
                </td>
            </tr>
            <tr>
                <th>
                    TEXT本文(PC)
                </th>
                <td colspan="2">
                    <textarea name="pc_text_body" cols="100" rows="30" id="pc_text_body" wrap="off"><?php echo $this->_tpl_vars['data']['pc_text_body']; ?>
</textarea>
                </td>
            </tr>
            <tr>
                <th>
                    HTML本文(PC)
                </th>
                <td>
                    <div id="pc_tabs">
                        <ul>
                            <li><a href="#pc-tabs-1">source</a></li>
                            <li><a href="#pc-tabs-2">html</a></li>
                        </ul>
                        <div id="pc-tabs-1">
                            <textarea name="pc_html_body" cols="100" rows="30" id="pc_html_body" wrap="off"><?php echo $this->_tpl_vars['data']['pc_html_body']; ?>
</textarea>
                        </div>
                        <iframe id="pc-tabs-2" name="pc-tabs-2" src="" height="500px"  width="95%"></iframe>
                    </div>
                </td>
            </tr>
            <tr>
                <th>
                    MB添付画像
                </th>
                <td style="text-align: left;">
                    <input type="text" value='<img src="001">' size="20" class="selectText" readonly> <input type="file" name="mb_image[1]"><br>
                    <input type="text" value='<img src="002">' size="20" class="selectText" readonly> <input type="file" name="mb_image[2]"><br>
                    <input type="text" value='<img src="003">' size="20" class="selectText" readonly> <input type="file" name="mb_image[3]"><br>
                    <input type="text" value='<img src="004">' size="20" class="selectText" readonly> <input type="file" name="mb_image[4]"><br>
                    <input type="text" value='<img src="005">' size="20" class="selectText" readonly> <input type="file" name="mb_image[5]"><br>
                </td>
            </tr>
            <tr>
                <th>
                    件名(MB)
                </th>
                <td colspan="2">
                    <input type="text" name="mb_subject" value="<?php echo $this->_tpl_vars['data']['mb_subject']; ?>
" size="50">
                </td>
            </tr>
            <tr>
                <th>
                    TEXT本文(MB)
                </th>
                <td colspan="2">
                    <textarea name="mb_text_body" cols="100" rows="30" id="mb_text_body" wrap="off"><?php echo $this->_tpl_vars['data']['mb_text_body']; ?>
</textarea>
                </td>
            </tr>
            <tr>
                <th>
                    HTML本文(MB)
                </th>
                <td>
                    <div id="mb_tabs">
                        <ul>
                            <li><a href="#mb-tabs-1">source</a></li>
                            <li><a href="#mb-tabs-2">html</a></li>
                        </ul>
                        <div id="mb-tabs-1">
                            <textarea name="mb_html_body" cols="100" rows="30" id="mb_html_body" wrap="off"><?php echo $this->_tpl_vars['data']['mb_html_body']; ?>
</textarea>
                        </div>
                        <iframe id="mb-tabs-2" name="mb-tabs-2" src="" height="500px"  width="95%"></iframe>
                    </div>
                </td>
            </tr>
            <tr>
                <td  style="text-align: center;" colspan="3">
                    <input type="submit" id="submit" name="action_ordering_RegularSupportMailDataExec" value="変更する" />
                </td>
            </tr>
        </table>
    </form>
<?php endif; ?>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admFooter'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
</body>
</html>