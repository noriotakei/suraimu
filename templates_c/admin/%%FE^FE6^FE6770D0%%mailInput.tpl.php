<?php /* Smarty version 2.6.26, created on 2014-08-08 18:06:37
         compiled from /home/suraimu/templates/admin/mail/mailInput.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/mail/mailInput.tpl', 169, false),array('modifier', 'implode', '/home/suraimu/templates/admin/mail/mailInput.tpl', 175, false),array('modifier', 'default', '/home/suraimu/templates/admin/mail/mailInput.tpl', 243, false),array('modifier', 'zend_date_format', '/home/suraimu/templates/admin/mail/mailInput.tpl', 258, false),array('modifier', 'date_format', '/home/suraimu/templates/admin/mail/mailInput.tpl', 259, false),array('function', 'make_link', '/home/suraimu/templates/admin/mail/mailInput.tpl', 201, false),array('function', 'html_radios', '/home/suraimu/templates/admin/mail/mailInput.tpl', 256, false),array('function', 'html_options', '/home/suraimu/templates/admin/mail/mailInput.tpl', 262, false),)), $this); ?>
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

                $(".datepicker").datepicker({
            dateFormat: "yy-mm-dd"
        });

                openInput("input[name='mail_reserve_type']:checked");

        $('.reserve').live("click", function(){
            openInput("input[name='mail_reserve_type']:checked");
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
                    "name": "pc_html_contents",
                    "value": $("#pc_html_contents").val()
                });
                $(form).append(source);
                var source = $("<input/>").attr({
                    "type": "hidden",
                    "name": "action_mail_MailPreview",
                    "value": "1"
                });
                $(form).append(source);
                var source = $("<input/>").attr({
                    "type": "hidden",
                    "name": "pc",
                    "value": "1"
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
                    "name": "mb_html_contents",
                    "value": $("#mb_html_contents").val()
                });
                $(form).append(source);
                var source = $("<input/>").attr({
                    "type": "hidden",
                    "name": "action_mail_MailPreview",
                    "value": "1"
                });
                $(form).append(source);
                $(form).submit();
                setTimeout(function() {
                    $(form).remove();
                }, 100);
        });

        // 送信確認文言
        $("#mailInput").submit(function(){
            if ($("input[name='mail_reserve_type']:checked").val() == 0) {
                return confirm("送信しますか？");
            } else {
                return confirm("設定しますか？");
            }
        });

    });

        function openInput(selectId) {

        var selectId = $(selectId);

        if (selectId.val() == 1) {
            $("#reserve_datetime").show("blind", "slow");
            $("#interval").hide();
            $("#regular").hide();
            $("#submit").val("設定する");
        } else if (selectId.val() == 2) {
            $("#regular").show("blind", "slow");
            $("#reserve_datetime").hide();
            $("#interval").hide();
            $("#submit").val("設定する");
        } else if (selectId.val() == 3) {
            $("#reserve_datetime").show("blind", "slow");
            $("#interval").hide();
            $("#regular").hide();
            $("#submit").val("設定する");
        } else {
            $("#interval").show("blind", "slow");
            $("#reserve_datetime").hide();
            $("#regular").hide();
            $("#submit").val("送信する");
        }

    }

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
<h2 class="ContentTitle">メルマガ</h2>

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
    <br>
<?php endif; ?>
<form action="./" method="post">
<?php echo $this->_tpl_vars['POSTparam']; ?>

<div class="SubMenu">
    <input type="submit" value="一覧へ戻る" name="action_user_List"/>
</div>
</form>
<table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet04">
<tr><th colspan="2" style="text-align:center;">検索条件</th></tr>
<?php $_from = $this->_tpl_vars['whereContents']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
?>
    <tr><td>
    <?php echo $this->_tpl_vars['key']; ?>

    </td>
    <td>
    <?php echo $this->_tpl_vars['val']; ?>

    </td></tr>
<?php endforeach; endif; unset($_from); ?>
</table>
<br>
<div>
    <a href="<?php echo smarty_function_make_link(array('action' => 'action_keyConvert_DispKeyConvertList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="_blank">システム変換管理</a>
</div>
<br>
<div>
    <form action="./" method="post" id="mailInput" name="mailInput" enctype="multipart/form-data">
        <?php echo $this->_tpl_vars['POSTparam']; ?>

        <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
        <tr>
            <th colspan="2" style="text-align: center; font-weight: bold;">メール設定</th>
        </tr>
        <tr>
            <th>現在の送信件数</th>
            <td  style="text-align: left;">
                <table>
                    <tr>
                        <?php if ($this->_tpl_vars['pcCount'] && $this->_tpl_vars['mbCount']): ?>
                            <td colspan="2" style="text-align: center;">
                        <?php else: ?>
                            <td style="text-align: center;">
                        <?php endif; ?>
                      総件数:<?php echo $this->_tpl_vars['totalCount']; ?>
件
                    </td>
                    </tr>
                    <tr>
                    <?php if ($this->_tpl_vars['pcCount']): ?>
                        <td style="text-align: left;">
                            PC総件数:<?php echo $this->_tpl_vars['pcCount']; ?>
件
                        </td>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['mbCount']): ?>
                        <td style="text-align: left;">
                            MB総件数:<?php echo $this->_tpl_vars['mbCount']; ?>
件<br>
                        </td>
                    <?php endif; ?>
                    </tr>
                </table>
                推定送信時間：<?php echo $this->_tpl_vars['sendTime']; ?>
<?php echo $this->_tpl_vars['recommend']; ?>

            </td>
        </tr>
        <tr>
            <th>送信アドレス</th>
            <td style="text-align: left;">
                <input type="text" name="from_address" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['param']['from_address'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['sendAddress']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['sendAddress'])); ?>
" size="50" style="ime-mode: disabled;">
            </td>
        </tr>
        <tr>
            <th>送信名</th>
            <td style="text-align: left;">
                <input type="text" name="from_name" value="<?php echo $this->_tpl_vars['param']['from_name']; ?>
" size="50">
                <br><span style="color:#FF0000;">※iPhoneに送信する場合、「&lt;&gt;」、「【】」、「≪≫」、「半角カタカナ」を含むと送信者名が「不明」または「文字化け」の原因になります。
            </td>
        </tr>
        <tr>
        <th>送信タイプ</th>
        <td style="text-align: left;">
            <?php echo smarty_function_html_radios(array('class' => 'reserve','name' => 'mail_reserve_type','options' => $this->_tpl_vars['mailReserveType'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['param']['mail_reserve_type'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['defaultMailReserveType']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['defaultMailReserveType'])),'separator' => "&nbsp;"), $this);?>

            <div id="reserve_datetime">
                <input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['param']['reserve_datetime_Date'])) ? $this->_run_mod_handler('default', true, $_tmp, time()) : smarty_modifier_default($_tmp, time())))) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="reserve_datetime_Date" maxlength="10">
                <input name="reserve_datetime_Time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['reserve_datetime_Time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%H:%M') : smarty_modifier_date_format($_tmp, '%H:%M')); ?>
" size="7" maxlength="5">
            </div>
            <div id="interval" style="display:none;">
                インターバル(30分を設定してください):<br><?php echo smarty_function_html_options(array('name' => 'interval_second','options' => $this->_tpl_vars['intervalSecond'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['param']['interval_second'])) ? $this->_run_mod_handler('default', true, $_tmp, 2) : smarty_modifier_default($_tmp, 2))), $this);?>
分
            </div>
            <div id="regular">
                <div id="title">
                    タイトル:<input type="text" name="title" value="<?php echo $this->_tpl_vars['param']['title']; ?>
" size="50">
                </div>
                <?php echo smarty_function_html_options(array('class' => 'regular','name' => 'send_condition_type','options' => $this->_tpl_vars['sendConditionType'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['param']['send_condition_type'])) ? $this->_run_mod_handler('default', true, $_tmp, 1) : smarty_modifier_default($_tmp, 1))), $this);?>

                <div id="regular_hour">
                    <input type="text" name="regular_hour_from" value="0" size="2" maxlength="2" style="ime-mode:disabled">時から
                    <input type="text" name="regular_hour_to" value="23" size="2" maxlength="2" style="ime-mode:disabled">時までの
                    <?php echo smarty_function_html_options(array('name' => 'regular_second','options' => $this->_tpl_vars['intervalSecond'],'selected' => $this->_tpl_vars['param']['interval_second']), $this);?>
分に送信する
                </div>
                <div id="regular_week">
                    <?php echo smarty_function_html_options(array('name' => 'regular_week','options' => $this->_tpl_vars['config']['admin_config']['week_array'],'selected' => $this->_tpl_vars['param']['regular_week']), $this);?>

                    <input name="send_time_week" class="time" type="text" value="<?php echo $this->_tpl_vars['param']['send_time_week']; ?>
" size="7" maxlength="5">に送信する
                </div>
                <div id="regular_month">
                    <?php echo smarty_function_html_options(array('name' => 'send_day','options' => $this->_tpl_vars['dayAry'],'selected' => $this->_tpl_vars['param']['send_day']), $this);?>
日
                    <input name="send_time_month" class="time" type="text" value="<?php echo $this->_tpl_vars['param']['send_time_month']; ?>
" size="7" maxlength="5">に送信する
                </div>
                <div id="regular_day">
                    <input name="send_time_day" class="time" type="text" value="<?php echo $this->_tpl_vars['param']['send_time_day']; ?>
" size="7" maxlength="5">に送信する
                </div>
            </div>
        </td>
        </tr>
        <tr>
            <th>
                PCメルマガ添付画像
            </th>
            <td style="text-align: left;">
                <input type="text" value='<img src="001">' size="20" class="selectText" readonly> <input type="file" name="pc_image[1]">  <br>        
                <input type="text" value='<img src="002">' size="20" class="selectText" readonly> <input type="file" name="pc_image[2]">  <br>
                <input type="text" value='<img src="003">' size="20" class="selectText" readonly> <input type="file" name="pc_image[3]">  <br>
                <input type="text" value='<img src="004">' size="20" class="selectText" readonly> <input type="file" name="pc_image[4]">  <br>
                <input type="text" value='<img src="005">' size="20" class="selectText" readonly> <input type="file" name="pc_image[5]">  <br>
                <input type="text" value='<img src="006">' size="20" class="selectText" readonly> <input type="file" name="pc_image[6]">  <br>
                <input type="text" value='<img src="007">' size="20" class="selectText" readonly> <input type="file" name="pc_image[7]">  <br>
                <input type="text" value='<img src="008">' size="20" class="selectText" readonly> <input type="file" name="pc_image[8]">  <br>
                <input type="text" value='<img src="009">' size="20" class="selectText" readonly> <input type="file" name="pc_image[9]">  <br>
                <input type="text" value='<img src="010">' size="20" class="selectText" readonly> <input type="file" name="pc_image[10]"> <br>
            </td>
        </tr>
        <tr>
            <th>
                件名(PC)
            </th>
            <td style="text-align: left;">
                <input type="text" name="pc_title" value="<?php echo $this->_tpl_vars['param']['pc_title']; ?>
" size="50">
            </td>
        </tr>
        <tr>
            <th>
                TEXT本文(PC)
            </th>
            <td style="text-align: left;">
                <textarea name="pc_text_contents" cols="100" rows="30" id="pc_text_contents" wrap="off"><?php echo $this->_tpl_vars['param']['pc_text_contents']; ?>
</textarea>
            </td>
        </tr>
        <tr>
            <th>
                HTML本文(PC)
            </th>
            <td  style="text-align: left;">
                <div id="pc_tabs">
                    <ul>
                        <li><a href="#pc-tabs-1">source</a></li>
                        <li><a href="#pc-tabs-2">html</a></li>
                    </ul>
                    <div id="pc-tabs-1">
                        <textarea name="pc_html_contents" cols="100" rows="30" id="pc_html_contents" wrap="off"><?php echo $this->_tpl_vars['param']['pc_html_contents']; ?>
</textarea>
                    </div>
                    <iframe id="pc-tabs-2" name="pc-tabs-2" src="" height="500px"  width="95%"></iframe>
                </div>
            </td>
        </tr>
        <tr>
            <th>
                MBメルマガ添付画像
            </th>
            <td style="text-align: left;">
                <input type="text" value='<img src="001">' size="20" class="selectText" readonly> <input type="file" name="mb_image[1]">  <br>
                <input type="text" value='<img src="002">' size="20" class="selectText" readonly> <input type="file" name="mb_image[2]">  <br>
                <input type="text" value='<img src="003">' size="20" class="selectText" readonly> <input type="file" name="mb_image[3]">  <br>
                <input type="text" value='<img src="004">' size="20" class="selectText" readonly> <input type="file" name="mb_image[4]">  <br>
                <input type="text" value='<img src="005">' size="20" class="selectText" readonly> <input type="file" name="mb_image[5]">  <br>
                <input type="text" value='<img src="006">' size="20" class="selectText" readonly> <input type="file" name="mb_image[6]">  <br>
                <input type="text" value='<img src="007">' size="20" class="selectText" readonly> <input type="file" name="mb_image[7]">  <br>
                <input type="text" value='<img src="008">' size="20" class="selectText" readonly> <input type="file" name="mb_image[8]">  <br>
                <input type="text" value='<img src="009">' size="20" class="selectText" readonly> <input type="file" name="mb_image[9]">  <br>
                <input type="text" value='<img src="010">' size="20" class="selectText" readonly> <input type="file" name="mb_image[10]"> <br>
            </td>
        </tr>

        <tr>
            <th>
                件名(MB)
            </th>
            <td  style="text-align: left;">
                <input type="text" name="mb_title" value="<?php echo $this->_tpl_vars['param']['mb_title']; ?>
" size="50">
            </td>
        </tr>
        <tr>
            <th>
                TEXT本文(MB)
            </th>
            <td  style="text-align: left;">
                <textarea name="mb_text_contents" cols="100" rows="30" id="mb_text_contents" wrap="off"><?php echo $this->_tpl_vars['param']['mb_text_contents']; ?>
</textarea>
            </td>
        </tr>
        <tr>
            <th>
                HTML本文(MB)
            </th>
            <td  style="text-align: left;">
                <div id="mb_tabs">
                    <ul>
                        <li><a href="#mb-tabs-1">source</a></li>
                        <li><a href="#mb-tabs-2">html</a></li>
                    </ul>
                    <div id="mb-tabs-1">
                        <textarea name="mb_html_contents" cols="100" rows="30" id="mb_html_contents" wrap="off"><?php echo $this->_tpl_vars['param']['mb_html_contents']; ?>
</textarea>
                    </div>
                    <iframe id="mb-tabs-2" name="mb-tabs-2" src="" height="500px"  width="95%"></iframe>
                </div>
            </td>
        </tr>
        <tr>
            <td  style="text-align: center;" colspan="2">
                <input type="checkbox" name="reverse_mail_status" value="1" <?php if ($this->_tpl_vars['param']['reverse_mail_status']): ?>checked<?php endif; ?>/>強行メール
            </td>
        </tr>
        <tr>
            <td  style="text-align: center;" colspan="2">
                ※送信して、何も表示されなくても、<br>バックグラウンドで送信されていますので、注意して下さい。<br>
                <input type="submit" id="submit" name="action_mail_MailSendExec" value="送信する" />
            </td>
        </tr>
        </table>
    </form>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admFooter'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
</body>
</html>