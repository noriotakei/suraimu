<?php /* Smarty version 2.6.26, created on 2010-05-28 12:09:43
         compiled from /home/suraimu/templates/admin/baitai/top.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'make_link', '/home/suraimu/templates/admin/baitai/top.tpl', 6, false),array('function', 'html_image', '/home/suraimu/templates/admin/baitai/top.tpl', 75, false),array('modifier', 'zend_date_format', '/home/suraimu/templates/admin/baitai/top.tpl', 53, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admBaitaiHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</head>
<body>
<div class="BlockCol">
    <h2 class="ContentTitle">媒体CHK</h2>
    <p id="Logout"><a href="<?php echo smarty_function_make_link(array('action' => 'action_baitai_Logout','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="_top">Logout</a></p>
    <br>
    <table border="0" width="70%" align="center">
        <tr>
        <td align="left" valign="top">
            <table>
            <tr>
                <td valign="top">
                <div id="inlineDatepicker"></div>
                </td>
            </tr>
            </table>
        </td>
        <td align="right" valign="top">
            <table cellspacing="0" cellpadding="0" class="TableSet04" id="menu_table">
            <tr>
                <th colspan="2" style="text-align: center; font-weight: bold;">集計方法を選択してください</th>
            </tr>
            <tr>
                <?php $_from = $this->_tpl_vars['culcMenu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
?>
                <td align="left">
                    <input type="radio" name="menu" value="<?php echo $this->_tpl_vars['val']['file_name']; ?>
" class="menu" id="<?php echo $this->_tpl_vars['key']; ?>
"><label for="<?php echo $this->_tpl_vars['key']; ?>
"><?php echo $this->_tpl_vars['val']['name']; ?>
</label>
                </td>
                <?php if ($this->_tpl_vars['val']['blank'] == 'on'): ?><td>&nbsp;</td><?php endif; ?>
                <?php if ($this->_tpl_vars['val']['changeline'] == 'on'): ?></tr><tr><?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>
            </tr>
            </table>
        </td>
        </tr>
    </table>
    <br>
    <?php if ($this->_tpl_vars['remakeFlag']): ?>
        <div style="text-align:center;">
            <a href="<?php echo smarty_function_make_link(array('action' => 'action_baitai_Remake','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="_blank">再集計へ</a>
        </div>
        <br>
    <?php endif; ?>
    <div id="ajaxForm">
    <form>
    <table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet04" align="center">
        <tr>
            <th colspan="2" style="text-align: center; font-weight: bold;">検索条件</th>
        </tr>
        <tr>
            <th>期間指定</th>
            <td>
                <input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['value']['start_date'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="start_date" maxlength="10">
                から
                <input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['value']['end_date'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="end_date" maxlength="10">
            </td>
        </tr>
        <tr>
            <th>広告コード</th>
            <td>
                <input type="text" id="media_cd" name="media_cd" value="<?php echo $this->_tpl_vars['value']['media_cd']; ?>
" size="20" style="ime-mode:disabled;">
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center">
                    <input type="button" name="submit" value="更　新">
            </td>
        </tr>
    </table>
    </form>
    </div>
    <br>
    <hr>
    <br>
<div id="progressbar" style="width: 20%; text-align:center; margin:0 auto 0 auto; display:none;"><?php echo smarty_function_html_image(array('file' => "./img/roller.gif"), $this);?>
 データ受信中です。</div>
<div id="results"></div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admFooter'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
<script language="JavaScript">
<!--
    $(function() {

                $(".datepicker").datepicker({
            showOn: 'button',
            buttonImage: './img/calendar.gif',
            buttonImageOnly: true,
            dateFormat: "yy-mm-dd"
        });

                $("#inlineDatepicker").datepicker({
            numberOfMonths: 2,
            showButtonPanel: true,
            dateFormat: "yy-mm-dd",
            onSelect: function (dateText, inst) {
                postAjax(dateText);
            }
        });

        $(":radio, :checkbox").live("click", function(env){
            if (env.button !== 0) return;
                        var dateOBJ = new Date($("#inlineDatepicker").datepicker("getDate"))
            var datetext = dateOBJ.getFullYear() + "-" + (dateOBJ.getMonth() + 1) + "-" + dateOBJ.getDate();
            postAjax(datetext);
        });

        $(":button").live("click", function(env){
            if (env.button !== 0) return;
                        var dateOBJ = new Date($("#inlineDatepicker").datepicker("getDate"))
            var datetext = dateOBJ.getFullYear() + "-" + (dateOBJ.getMonth() + 1) + "-" + dateOBJ.getDate();
            postAjax(datetext);
        });

        $(":option").live("change", function(){
                        var dateOBJ = new Date($("#inlineDatepicker").datepicker("getDate"))
            var datetext = dateOBJ.getFullYear() + "-" + (dateOBJ.getMonth() + 1) + "-" + dateOBJ.getDate();
            postAjax(datetext);
        });


        $("#media_cd").live("keyup", function(){
                        var dateOBJ = new Date($("#inlineDatepicker").datepicker("getDate"))
            var datetext = dateOBJ.getFullYear() + "-" + (dateOBJ.getMonth() + 1) + "-" + dateOBJ.getDate();
            postAjax(datetext);
        });

                $("#src_table tr:even").addClass("BgColor02");

                $("#menu_table tr:even").addClass("BgColor02");

    });

    function postAjax (datetext) {
        var data = $("input[name='menu']:checked").val() + "=1&date=" + datetext + "&";
        data += $("#ajaxForm form").serialize();

        if ($("input[name='menu']:checked").val()) {
            $("#progressbar").show();
            $.ajax({
                type: "POST",
                url: "index.php",
                data : data,
                cache: false,
                success: function(html){
                    $("#progressbar").hide();
                    $("#results").empty();
                    $("#results").append(html);
                },
                error: function(html){
                    $("#progressbar").hide();
                    $("#results").empty();
                }
            });
        }
    }
// -->
</script>
</body>
</html>