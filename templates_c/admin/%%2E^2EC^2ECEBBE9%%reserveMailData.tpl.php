<?php /* Smarty version 2.6.26, created on 2014-08-08 18:08:19
         compiled from /home/suraimu/templates/admin/mailLog/reserveMailData.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/mailLog/reserveMailData.tpl', 107, false),array('modifier', 'implode', '/home/suraimu/templates/admin/mailLog/reserveMailData.tpl', 113, false),array('modifier', 'emoji', '/home/suraimu/templates/admin/mailLog/reserveMailData.tpl', 188, false),array('modifier', 'nl2br', '/home/suraimu/templates/admin/mailLog/reserveMailData.tpl', 196, false),array('modifier', 'zend_date_format', '/home/suraimu/templates/admin/mailLog/reserveMailData.tpl', 290, false),array('modifier', 'date_format', '/home/suraimu/templates/admin/mailLog/reserveMailData.tpl', 291, false),array('function', 'make_link', '/home/suraimu/templates/admin/mailLog/reserveMailData.tpl', 262, false),)), $this); ?>
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

                $(".tabs").tabs();

                $(".datepicker").datepicker({
            dateFormat: "yy-mm-dd"
        });

                $(".time").timepickr({
            format24: "{h:02.d}:{m:02.d}",
            rangeMin: ["00","15","30","45"]
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
                    "name": "rvmlid",
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
                    "name": "rvmlid",
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


// -->
</script>
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">予約配信履歴</h2>
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
    <?php if (! $this->_tpl_vars['data']['is_send']): ?>
        <tr>
            <td  style="text-align: center;" colspan="2">
                <form action="./" method="post" id="search" name="search">
                    <?php echo $this->_tpl_vars['POSTparam']; ?>

                    <input type="submit" id="submit" name="action_user_Search" value="変更する" />
                </form>
            </td>
        </tr>
    <?php endif; ?>
    </table>
</div>
<br>
<?php if ($this->_tpl_vars['data']['is_send']): ?>
<div>
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" width="80%">
        <tr>
            <th>送信予定ユーザー数</th>
            <td>
                <?php echo $this->_tpl_vars['data']['send_plans_count']; ?>
件
            </td>
        </tr>
        <tr>
            <th>作成日時</th>
            <td>
                <?php echo $this->_tpl_vars['data']['create_datetime']; ?>

            </td>
        </tr>
        <tr>
            <th>送信状況</th>
            <td>
                配信済み
            </td>
        </tr>
        <tr>
            <th>送信予定日時</th>
            <td>
                <?php echo $this->_tpl_vars['data']['send_datetime']; ?>

            </td>
        </tr>        <tr>
            <th>送信アドレス</th>
            <td>
                <?php echo $this->_tpl_vars['data']['from_address']; ?>

            </td>
        </tr>
        <tr>
            <th>送信名</th>
            <td>
                <?php echo $this->_tpl_vars['data']['from_name']; ?>

            </td>
        </tr>
        <tr>
            <th>
                件名(PC)
            </th>
            <td>
                <?php echo ((is_array($_tmp=$this->_tpl_vars['data']['pc_subject'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>

            </td>
        </tr>
        <tr>
            <th>
                TEXT本文(PC)
            </th>
            <td>
                <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['data']['pc_text_body'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)))) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>

            </td>
        </tr>
        <tr>
            <th>
                HTML本文(PC)
            </th>
            <td width="70%">
                <div id="pc_tabs">
                    <ul>
                        <li><a href="#pc-tabs-2">html</a></li>
                        <li><a href="#pc-tabs-1">view source</a></li>
                    </ul>
                    <iframe id="pc-tabs-2" name="pc-tabs-2" src="./?action_mailLog_MailLogPreview=1&pc=1&rvmlid=<?php echo $this->_tpl_vars['data']['id']; ?>
" height="500px" width="95%"></iframe>
                    <div id="pc-tabs-1">
                        <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['data']['pc_html_body'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)))) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>

                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <th>
                件名(MB)
            </th>
            <td>
                <?php echo ((is_array($_tmp=$this->_tpl_vars['data']['mb_subject'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>

            </td>
        </tr>
        <tr>
            <th>
                TEXT本文(MB)
            </th>
            <td >
                <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['data']['mb_text_body'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)))) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>

            </td>
        </tr>
        <tr>
            <th>
                HTML本文(MB)
            </th>
            <td width="70%">
                <div id="mb_tabs">
                    <ul>
                        <li><a href="#mb-tabs-2">html</a></li>
                        <li><a href="#mb-tabs-1">view source</a></li>
                    </ul>
                    <iframe id="mb-tabs-2" name="mb-tabs-2" src="./?action_mailLog_MailLogPreview=1&rvmlid=<?php echo $this->_tpl_vars['data']['id']; ?>
" height="500px" width="95%"></iframe>
                    <div id="mb-tabs-1">
                        <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['data']['mb_html_body'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)))) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>

                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <th>
                強行メール
            </th>
            <td>
                <?php if ($this->_tpl_vars['data']['reverse_mail_status']): ?>強行メールする<?php endif; ?>
            </td>
        </tr>
    </table>
    </div>
<?php else: ?>
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
            <th>送信予定ユーザー数</th>
            <td>
                <?php echo $this->_tpl_vars['data']['send_plans_count']; ?>
件
            </td>
        </tr>
        <tr>
            <th>作成日時</th>
            <td>
                <?php echo $this->_tpl_vars['data']['create_datetime']; ?>

            </td>
        </tr>
        <tr>
            <th>送信状況</th>
            <td>
                未配信
            </td>
        </tr>
        <tr>
            <th>送信予定日時</th>
            <td>
                <input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['send_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="reserve_datetime_Date" maxlength="10">
                <input name="reserve_datetime_Time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['send_datetime'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%H:%M') : smarty_modifier_date_format($_tmp, '%H:%M')); ?>
" size="7" maxlength="5">
            </td>
        </tr>
        <tr>
            <th>送信アドレス</th>
            <td>
                <input type="text" name="from_address" value="<?php echo $this->_tpl_vars['data']['from_address']; ?>
" size="50" style="ime-mode: disabled;">
            </td>
        </tr>
        <tr>
            <th>送信名</th>
            <td>
                <input type="text" name="from_name" value="<?php echo $this->_tpl_vars['data']['from_name']; ?>
" size="50">
            </td>
        </tr>
        <tr>
            <th>
                PC添付画像
            </th>
            <td style="text-align: left;">
                <?php if ($this->_tpl_vars['pcImgTagAry']['1']): ?>
                    <?php echo $this->_tpl_vars['pcImgTagAry']['1']; ?>
<br><input type="checkbox" name="pc_image_del[1]" value="1" <?php if ($this->_tpl_vars['data']['pc_image_del']['1']): ?>checked<?php endif; ?>>削除1<br>
                <?php endif; ?>
                <input type="text" value='<img src="001">' size="20" class="selectText" readonly> <input type="file" name="pc_image[1]"><br>
                <?php if ($this->_tpl_vars['pcImgTagAry']['2']): ?>
                    <?php echo $this->_tpl_vars['pcImgTagAry']['2']; ?>
<br><input type="checkbox" name="pc_image_del[2]" value="1"<?php if ($this->_tpl_vars['data']['pc_image_del']['2']): ?>checked<?php endif; ?>>削除2<br>
                <?php endif; ?>
                <input type="text" value='<img src="002">' size="20" class="selectText" readonly> <input type="file" name="pc_image[2]"><br>
                <?php if ($this->_tpl_vars['pcImgTagAry']['3']): ?>
                    <?php echo $this->_tpl_vars['pcImgTagAry']['3']; ?>
<br><input type="checkbox" name="pc_image_del[3]" value="1"<?php if ($this->_tpl_vars['data']['pc_image_del']['3']): ?>checked<?php endif; ?>>削除3<br>
                <?php endif; ?>
                <input type="text" value='<img src="003">' size="20" class="selectText" readonly> <input type="file" name="pc_image[3]"><br>
                <?php if ($this->_tpl_vars['pcImgTagAry']['4']): ?>
                    <?php echo $this->_tpl_vars['pcImgTagAry']['4']; ?>
<br><input type="checkbox" name="pc_image_del[4]" value="1"<?php if ($this->_tpl_vars['data']['pc_image_del']['4']): ?>checked<?php endif; ?>>削除4<br>
                <?php endif; ?>
                <input type="text" value='<img src="004">' size="20" class="selectText" readonly> <input type="file" name="pc_image[4]"><br>
                <?php if ($this->_tpl_vars['pcImgTagAry']['5']): ?>
                    <?php echo $this->_tpl_vars['pcImgTagAry']['5']; ?>
<br><input type="checkbox" name="pc_image_del[5]" value="1"<?php if ($this->_tpl_vars['data']['pc_image_del']['5']): ?>checked<?php endif; ?>>削除5<br>
                <?php endif; ?>
                <input type="text" value='<img src="005">' size="20" class="selectText" readonly> <input type="file" name="pc_image[5]"><br>
            </td>
        </tr>
        <tr>
            <th>
                件名(PC)
            </th>
            <td>
                <input type="text" name="pc_subject" value="<?php echo $this->_tpl_vars['data']['pc_subject']; ?>
" size="50">
            </td>
        </tr>
        <tr>
            <th>
                TEXT本文(PC)
            </th>
            <td>
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
                <?php if ($this->_tpl_vars['mbImgTagAry']['1']): ?>
                    <?php echo $this->_tpl_vars['mbImgTagAry']['1']; ?>
<br><input type="checkbox" name="mb_image_del[1]" value="1" <?php if ($this->_tpl_vars['data']['mb_image_del']['1']): ?>checked<?php endif; ?>>削除1<br>
                <?php endif; ?>
                <input type="text" value='<img src="001">' size="20" class="selectText" readonly> <input type="file" name="mb_image[1]"><br>
                <?php if ($this->_tpl_vars['mbImgTagAry']['2']): ?>
                    <?php echo $this->_tpl_vars['mbImgTagAry']['2']; ?>
<br><input type="checkbox" name="mb_image_del[2]" value="1"<?php if ($this->_tpl_vars['data']['mb_image_del']['2']): ?>checked<?php endif; ?>>削除2<br>
                <?php endif; ?>
                <input type="text" value='<img src="002">' size="20" class="selectText" readonly> <input type="file" name="mb_image[2]"><br>
                <?php if ($this->_tpl_vars['mbImgTagAry']['3']): ?>
                    <?php echo $this->_tpl_vars['mbImgTagAry']['3']; ?>
<br><input type="checkbox" name="mb_image_del[3]" value="1"<?php if ($this->_tpl_vars['data']['mb_image_del']['3']): ?>checked<?php endif; ?>>削除3<br>
                <?php endif; ?>
                <input type="text" value='<img src="003">' size="20" class="selectText" readonly> <input type="file" name="mb_image[3]"><br>
                <?php if ($this->_tpl_vars['mbImgTagAry']['4']): ?>
                    <?php echo $this->_tpl_vars['mbImgTagAry']['4']; ?>
<br><input type="checkbox" name="mb_image_del[4]" value="1"<?php if ($this->_tpl_vars['data']['mb_image_del']['4']): ?>checked<?php endif; ?>>削除4<br>
                <?php endif; ?>
                <input type="text" value='<img src="004">' size="20" class="selectText" readonly> <input type="file" name="mb_image[4]"><br>
                <?php if ($this->_tpl_vars['mbImgTagAry']['5']): ?>
                    <?php echo $this->_tpl_vars['mbImgTagAry']['5']; ?>
<br><input type="checkbox" name="mb_image_del[5]" value="1"<?php if ($this->_tpl_vars['data']['mb_image_del']['5']): ?>checked<?php endif; ?>>削除5<br>
                <?php endif; ?>
                <input type="text" value='<img src="005">' size="20" class="selectText" readonly> <input type="file" name="mb_image[5]"><br>
            </td>
        </tr>
        <tr>
            <th>
                件名(MB)
            </th>
            <td>
                <input type="text" name="mb_subject" value="<?php echo $this->_tpl_vars['data']['mb_subject']; ?>
" size="50">
            </td>
        </tr>
        <tr>
            <th>
                TEXT本文(MB)
            </th>
            <td>
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
            <td  style="text-align: center;" colspan="2">
                <input type="checkbox" name="reverse_mail_status" value="1" <?php if ($this->_tpl_vars['data']['reverse_mail_status']): ?>checked<?php endif; ?>/>強行メール
            </td>
        </tr>
        <tr>
            <td  style="text-align: center;" colspan="3">
                <div class="SubMenu">
                    <input type="submit" id="submit" name="action_mailLog_ReserveMailDataExec" value="設定する" />
                    <input type="submit" id="submit" name="action_mailLog_ReserveMailCopyExec" value="この内容で新規作成" />
                </div>
            </td>
        </tr>
    </table>
    </form>
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