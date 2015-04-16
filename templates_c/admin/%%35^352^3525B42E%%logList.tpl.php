<?php /* Smarty version 2.6.26, created on 2014-08-08 18:40:08
         compiled from /home/suraimu/templates/admin/user/logList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/user/logList.tpl', 48, false),array('modifier', 'implode', '/home/suraimu/templates/admin/user/logList.tpl', 54, false),array('function', 'html_image', '/home/suraimu/templates/admin/user/logList.tpl', 94, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script language="JavaScript">
<!--

    $(function() {

        $(":radio, :checkbox, :button").live("click", function(env){
            if (env.button !== 0) return;
            postAjax();
        });

                $("#menu_table tr:even").addClass("BgColor02");

    });

    function postAjax () {
        var data = $("input[name='menu']:checked").val() + "&";
        data += $("#ajaxForm").serialize();

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
</head>
<body>
<div class="BlockCol">
    <h2 class="ContentTitle">各種ログ</h2>
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

    <table border="0" cellspacing="0" cellpadding="0" class="TableSet02" align="center">
        <tr>
            <th>ﾕｰｻﾞｰID</th>
            <td style="text-align: left;"><?php echo $this->_tpl_vars['userData']['user_id']; ?>
</td>
        </tr>
    </table>
    <br>
    <form id="ajaxForm">
        <?php echo $this->_tpl_vars['POSTparam']; ?>

        <table cellspacing="0" cellpadding="0" class="TableSet04" id="menu_table" align="center">
            <tr>
                <th colspan="<?php echo count($this->_tpl_vars['logMenu']); ?>
" style="text-align: center; font-weight: bold;">ログを選択してください</th>
            </tr>
            <tr>
                <?php $_from = $this->_tpl_vars['logMenu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
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
            <tr>
                <td colspan="<?php echo count($this->_tpl_vars['logMenu']); ?>
" style="text-align: center">
                        <input type="button" name="submit" value="更　新">
                </td>
            </tr>
        </table>
    </form>
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
</body>
</html>