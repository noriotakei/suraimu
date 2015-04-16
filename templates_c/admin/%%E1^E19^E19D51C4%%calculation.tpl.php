<?php /* Smarty version 2.6.26, created on 2014-08-08 16:59:40
         compiled from /home/suraimu/templates/admin/senchaCount/calculation.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/senchaCount/calculation.tpl', 9, false),array('modifier', 'implode', '/home/suraimu/templates/admin/senchaCount/calculation.tpl', 15, false),array('modifier', 'zend_date_format', '/home/suraimu/templates/admin/senchaCount/calculation.tpl', 58, false),array('modifier', 'default', '/home/suraimu/templates/admin/senchaCount/calculation.tpl', 66, false),array('function', 'html_radios', '/home/suraimu/templates/admin/senchaCount/calculation.tpl', 66, false),array('function', 'html_checkboxes', '/home/suraimu/templates/admin/senchaCount/calculation.tpl', 78, false),array('function', 'html_options', '/home/suraimu/templates/admin/senchaCount/calculation.tpl', 122, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link rel="stylesheet" href="./js/ext/resources/css/ext-all.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="./js/jqPlot/jquery.jqplot.min.css" />
</head>
<body>
<div class="BlockCol">
    <h2 class="ContentTitle">一般集計</h2>
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
    <div id="sendForm">
    <table border="0" align="center">
        <tr>
        <td>
                <div id="inlineDatepicker"></div>
        </td>
        </tr>
    </table>
    <br><br>
    <table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet04" align="center">
        <tr>
            <th colspan="5" style="text-align: center; font-weight: bold;">集計方法を選択してください</th>
        </tr>
        <tr>
                <?php $_from = $this->_tpl_vars['culcMenu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
        $this->_foreach['loop']['iteration']++;
?>
                <td align="left">
                    <input type="radio" name="menu" value="<?php echo $this->_tpl_vars['val']['file_name']; ?>
" class="menu" id="<?php echo $this->_tpl_vars['key']; ?>
"><label for="<?php echo $this->_tpl_vars['key']; ?>
"><?php echo $this->_tpl_vars['val']['name']; ?>
</label>
                </td>
                <?php if ($this->_foreach['loop']['iteration'] % 5 == 0): ?>
                </tr>
                <?php if (! ($this->_foreach['loop']['iteration'] == $this->_foreach['loop']['total'])): ?>
                <tr>
                <?php endif; ?>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>
        </tr>
    </table>
    <br><br>
    <form id="ajaxForm">
    <table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet04" align="center">
        <tr>
            <th colspan="2" style="text-align: center; font-weight: bold;">検索条件</th>
        </tr>
        <tr>
            <th>期間指定(<font color="red">※</font>のみ有効)</th>
            <td>
                <input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['value']['start_date'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="start_date" maxlength="10">
                から
                <input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['value']['end_date'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="end_date" maxlength="10">
            </td>
        </tr>
        <tr>
            <th>PCアドレス</th>
            <td>
                <?php echo smarty_function_html_radios(array('label_ids' => true,'name' => 'pc_address_specify','options' => $this->_tpl_vars['specifyArray'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['value']['pc_address_specify'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)),'separator' => "&nbsp;"), $this);?>

            </td>
        </tr>
        <tr>
            <th>MBアドレス</th>
            <td>
                <?php echo smarty_function_html_radios(array('label_ids' => true,'name' => 'mb_address_specify','options' => $this->_tpl_vars['specifyArray'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['value']['mb_address_specify'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)),'separator' => "&nbsp;"), $this);?>

            </td>
        </tr>
        <tr>
            <th>PCデバイス</th>
            <td>
                <?php echo smarty_function_html_checkboxes(array('name' => 'pc_device_cd','options' => $this->_tpl_vars['config']['admin_config']['pc_device'],'selected' => $this->_tpl_vars['value']['pc_device_cd'],'separator' => "&nbsp;"), $this);?>

            </td>
        </tr>
        <tr>
            <th>MBデバイス</th>
            <td>
                <?php echo smarty_function_html_checkboxes(array('name' => 'mb_device_cd','options' => $this->_tpl_vars['config']['admin_config']['mb_device'],'selected' => $this->_tpl_vars['value']['mb_device_cd'],'separator' => "&nbsp;"), $this);?>

            </td>
        </tr>
        <tr>
            <th>性別</th>
            <td>
                <?php echo smarty_function_html_checkboxes(array('name' => 'sex_cd','options' => $this->_tpl_vars['config']['admin_config']['sex_cd'],'selected' => $this->_tpl_vars['value']['sex_cd'],'separator' => "&nbsp;"), $this);?>

            </td>
        </tr>
        <tr>
            <th>媒体コード<br>(カンマ区切りで複数可)<br>[% => 任意の数の文字]<br>[_ =>  1 つの文字]</th>
            <td>
                <input type="text" id="media_cd" name="media_cd" value="<?php echo $this->_tpl_vars['value']['media_cd']; ?>
" size="20" style="ime-mode:disabled;">
            </td>
        </tr>
        <tr>
            <th>登録入口カテゴリー</th>
            <td style="text-align: left;">
                <?php echo smarty_function_html_checkboxes(array('name' => 'regist_page_category_id','options' => $this->_tpl_vars['registPageCategoryList'],'selected' => $this->_tpl_vars['value']['regist_page_category_id'],'separator' => "&nbsp;"), $this);?>

            </td>
        </tr>
        <tr>
        <th>登録入口ID<br>(カンマ区切りで複数可)</th>
            <td style="text-align: left;">
                <div>
                    対象を抽出：<input type="text" id="regist_page_id" name="regist_page_id" value="<?php echo $this->_tpl_vars['value']['regist_page_id']; ?>
" size="20" style="ime-mode:disabled;">
                </div>
                <div>
                    以外を抽出：<input type="text" id="except_regist_page_id" name="except_regist_page_id" value="<?php echo $this->_tpl_vars['value']['except_regist_page_id']; ?>
" size="20" style="ime-mode:disabled;">
                </div>
            </td>
        </tr>
                <?php if ($this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SYSTEM']): ?>
            <?php if (count($this->_tpl_vars['mediaCdAry'])): ?>
                <tr>
                    <th>登録媒体コード</th>
                    <td>
                        <?php echo smarty_function_html_options(array('id' => 'select_media_cd','name' => 'select_media_cd','options' => $this->_tpl_vars['mediaCdAry'],'selected' => $this->_tpl_vars['value']['select_media_cd']), $this);?>

                    </td>
                </tr>
            <?php endif; ?>
        <?php endif; ?>
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
<div id="results" name="results"></div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admFooter'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
<!--[if IE]><script language="javascript" type="text/javascript" src="./js/jqPlot/excanvas.min.js"></script><![endif]-->
<script language="javascript" type="text/javascript" src="./js/jqPlot/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="./js/ext/adapter/jquery/ext-jquery-adapter.js"></script>
<script type="text/javascript" src="./js/ext/ext-all.js"></script>
<script type="text/javascript" src="./js/ext/src/locale/ext-lang-ja.js"></script>
<script type="text/javascript" src="./js/ext/examples/ux/RowExpander.js"></script>
<script type="text/javascript" src="./js/ext/examples/ux/SlidingPager.js"></script>
<script language="JavaScript">
<!--
<?php echo '
    Ext.BLANK_IMAGE_URL = \'./js/ext/resources/images/default/s.gif\';
    $(function() {

        // カレンダー
        $(".datepicker").datepicker({
            showOn: \'button\',
            buttonImage: \'./img/calendar.gif\',
            buttonImageOnly: true,
            dateFormat: "yy-mm-dd"
        });

        // カレンダー
        $("#inlineDatepicker").datepicker({
            numberOfMonths: 2,
            showButtonPanel: true,
            dateFormat: "yy-mm-dd",
            onSelect: function (dateText, inst) {
                postAjax(dateText);
                window.location.hash = "results";
            }
        });

        $("#sendForm :button, .menu").live("click", function(env){
            if (env.button !== 0) return;
            // 日付を作成
            var dateOBJ = new Date($("#inlineDatepicker").datepicker("getDate"))
            var datetext = dateOBJ.getFullYear() + "-" + (dateOBJ.getMonth() + 1) + "-" + dateOBJ.getDate();
            postAjax(datetext);
            window.location.hash = "results";
        });

        // テーブルストライプ
        $("#src_table tr:even").addClass("BgColor02");

        // テーブルストライプ *}
        $("#menu_table tr:even").addClass("BgColor02");

    });

    function postAjax (datetext) {
        var data = $("input[name=\'menu\']:checked").val() + "&date=" + datetext + "&";
        data += $("#ajaxForm").serialize();

        if ($("input[name=\'menu\']:checked").val()) {
            $.ajax({
                type: "POST",
                url: "index.php",
                data : data,
                cache: false,
                success: function(html){
                    $("#results").empty();
                    $("#results").append(html);
                },
                error: function(html){
                    $("#results").empty();
                }
            });
        }
    }
'; ?>

// -->
</script>
</body>
</html>