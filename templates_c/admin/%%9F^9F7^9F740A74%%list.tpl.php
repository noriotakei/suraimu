<?php /* Smarty version 2.6.26, created on 2014-08-09 17:14:48
         compiled from /home/suraimu/templates/admin/banner/list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', '/home/suraimu/templates/admin/banner/list.tpl', 105, false),array('function', 'html_radios', '/home/suraimu/templates/admin/banner/list.tpl', 115, false),array('function', 'make_link', '/home/suraimu/templates/admin/banner/list.tpl', 216, false),array('function', 'html_image', '/home/suraimu/templates/admin/banner/list.tpl', 221, false),array('modifier', 'default', '/home/suraimu/templates/admin/banner/list.tpl', 115, false),array('modifier', 'zend_date_format', '/home/suraimu/templates/admin/banner/list.tpl', 120, false),array('modifier', 'count', '/home/suraimu/templates/admin/banner/list.tpl', 136, false),array('modifier', 'implode', '/home/suraimu/templates/admin/banner/list.tpl', 142, false),array('modifier', 'cat', '/home/suraimu/templates/admin/banner/list.tpl', 216, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
<script type="text/javascript" src="./js/jquery.timepickr.min.js"></script>
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script type="text/javascript" src="./js/topUp/javascripts/top_up-min.js"></script>
<link type="text/css" href="./css/pager.css" rel="stylesheet" />
<script type="text/javascript">
<!--
        TopUp.images_path = "js/topUp/images/top_up/";
    TopUp.players_path = "js/topUp/assets/players/";
    TopUp.addPresets({
            ".images a": {
              fixed: 0,
              effect: "appear",
              layout: "quicklook"
            }
    });

    $(function() {
                $(".time").timepickr({
            format24: "{h:02.d}:{m:02.d}:{s:02.d}",
            seconds: true,
            rangeMin: ["00","05","10","15","20","25","30","35","40","45","50","55","59"],
            rangeSec: ["00","15","30","45","59"],
            convention: 24
        });

                $(".datepicker").datepicker({
            dateFormat: "yy-mm-dd"
        });

                $('#list_table').colorize({
            altColor :'#CCCCCC',
            hiliteColor :'none'
        });

                $("#keyword").hide();
        $("#search_datetime").hide();

        var openIdAry = Array('#search_type option:selected');
        for (var val in openIdAry) {
            openSearchInput(openIdAry[val]);
        }

                $('#search_type').change(function(){
            openSearchInput('#search_type option:selected');
        });

                if (!<?php echo $this->_tpl_vars['registParam']['return_flag']; ?>
) {
            $("#add_form").hide();
        } else {
            $("#add_form").show();
        }
        $('#add_button').live("click", function(){
            $("#add_form").toggle("blind", null, "slow");
        });

                $("#src_table tr:even").addClass("BgColor02");
    });

    function openSearchInput(selectId) {

        var selectId = $(selectId);

        if (selectId.val() == 1 || selectId.val() == 2) {
            $('#keyword').show("blind", "slow");
            $('#search_datetime').hide();
        } else if (selectId.val() == 3 || selectId.val() == 4) {
            $('#search_datetime').show("blind", "slow");
            $('#keyword').hide();
        } else {
            $('#search_datetime').hide("slow");
            $('#keyword').hide("slow");
        }
    }

//-->
</script>
</head>
<body>

<div id="ContentsCol">

<h2 class="ContentTitle">バナー画像一覧</h2>
<form action="./" method="POST">
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" id="src_table">
        <tr>
            <th colspan="2" style="text-align: center; font-weight: bold;">検索条件</th>
        </tr>
        <tr>
            <td>カテゴリー</td>
            <td><?php echo smarty_function_html_options(array('name' => 'category_id','options' => $this->_tpl_vars['searchCategoryList'],'selected' => $this->_tpl_vars['param']['category_id']), $this);?>
</td>
        </tr>
        <tr>
            <td>デザイン種類</td>
            <td><?php echo smarty_function_html_options(array('name' => 'extension_type','options' => $this->_tpl_vars['searchExtensionTypeArray'],'selected' => $this->_tpl_vars['param']['extension_type']), $this);?>
</td>
        </tr>
        <tr>
            <td>検索対象</td>
            <td><?php echo smarty_function_html_options(array('name' => 'search_type','options' => $this->_tpl_vars['searchTypeAry'],'selected' => $this->_tpl_vars['param']['search_type'],'id' => 'search_type'), $this);?>

                <div id="keyword" style="display:none;">
                    <?php echo smarty_function_html_radios(array('name' => 'specify_keyword','options' => $this->_tpl_vars['specifyKeywordAry'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['param']['specify_keyword'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)),'separator' => "&nbsp;"), $this);?>

                    <input type="text" name="search_string" value="<?php echo $this->_tpl_vars['param']['search_string']; ?>
" size="30">
                </div>

                <div id="search_datetime">
                    <input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['searchDatetimeFrom'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="search_datetime_from_Date" maxlength="10">
                    <input name="search_datetime_from_Time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['searchDatetimeFrom'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
                    ～&nbsp;<input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['searchDatetimeTo'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="search_datetime_to_Date" maxlength="10">
                    <input name="search_datetime_to_Time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['searchDatetimeTo'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
                </div>
            </td>
        </tr>
        <tr>
            <td style="text-align:center;" colspan="2">
                <input type="submit" name="action_banner_List" value="検 索" style="width:8em;"/>
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
<?php endif; ?>
<div class="SubMenu">
    <input type="button" id="add_button" value="追　加" />
</div>
<div id="add_form" style="display:none">
<form action="./" method="post" enctype="multipart/form-data">
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
        <tr>
            <th>カテゴリー</th>
            <td style="text-align: left;"><?php echo smarty_function_html_options(array('name' => 'banner_image_category_id','options' => $this->_tpl_vars['categoryList'],'selected' => $this->_tpl_vars['registParam']['banner_image_category_id']), $this);?>
</td>
        </tr>
        <tr>
        <th >名前</th>
            <td style="text-align: left;">
                <input type="text" name="name" value="<?php echo $this->_tpl_vars['registParam']['name']; ?>
" size="20">
            </td>
        </tr>
        <tr>
        <th>コメント</th>
            <td style="text-align: left;">
                <input type="text" name="comment" value="<?php echo $this->_tpl_vars['registParam']['comment']; ?>
" size="50">
            </td>
        </tr>
        <tr>
            <th>ファイル名</th>
            <td style="text-align: left;"><input type="text" name="file_name" value="<?php echo $this->_tpl_vars['registParam']['file_name']; ?>
" size="50" style="ime-mode:disabled"></td>
        </tr>
        <tr>
        <th>FILE</th>
            <td style="text-align: left;">
                <input type="file" name="design_file">
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center">
                <input type="submit" name="action_banner_BannerAddExec" value="登　録" onClick="return confirm('登録しますか？')" />
            </td>
        </tr>
    </table>
</form>
</div>
<br>
<?php if ($this->_tpl_vars['bannerList']): ?>
    <div style="padding-bottom: 10px;">
    登録済み画像：<?php echo $this->_tpl_vars['totalCount']; ?>
件<br />
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

    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">

    <tr>
    <th nowrap="nowrap">ID</th>
    <th nowrap="nowrap">画像</th>
    <th>名前</th>
    <th>カテゴリー</th>
    <th>コメント</th>
    <th>PATH</th>
    <th>登録時間</th>
    <th>更新時間</th>
    </tr>
    <?php $_from = $this->_tpl_vars['bannerList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
        <tr>
        <td><a href="<?php echo smarty_function_make_link(array('action' => 'action_banner_BannerUpd','getTags' => ((is_array($_tmp="banner_id=")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['val']['id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['val']['id']))), $this);?>
"><?php echo $this->_tpl_vars['val']['id']; ?>
</a></td>
        <td>
        <div class="images">
            <?php if ($this->_tpl_vars['val']['extension_type'] == IMAGETYPE_SWF || $this->_tpl_vars['val']['extension_type'] == IMAGETYPE_SWC): ?>
                <a href="./<?php echo $this->_tpl_vars['bannerPath']; ?>
<?php echo $this->_tpl_vars['val']['file_name']; ?>
.<?php echo $this->_tpl_vars['extensionTypeArray'][$this->_tpl_vars['val']['extension_type']]; ?>
" toptions="type = flash, group = 'images', width = 550, height = 400, parameters = '<?php echo time(); ?>
 =1', title=<?php echo $this->_tpl_vars['val']['name']; ?>
">
                <?php echo smarty_function_html_image(array('file' => "./img/thumbnails/swf.jpg",'width' => '150','height' => '94','alt' => $this->_tpl_vars['val']['name']), $this);?>
</a>
            <?php else: ?>
                <a href="./<?php echo $this->_tpl_vars['bannerPath']; ?>
<?php echo $this->_tpl_vars['val']['file_name']; ?>
.<?php echo $this->_tpl_vars['extensionTypeArray'][$this->_tpl_vars['val']['extension_type']]; ?>
" toptions="type = image, group = 'images', parameters = '<?php echo time(); ?>
 =1', title=<?php echo $this->_tpl_vars['val']['name']; ?>
">
                <?php echo smarty_function_html_image(array('file' => ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp="./")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['bannerPath']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['bannerPath'])))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['val']['file_name']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['val']['file_name'])))) ? $this->_run_mod_handler('cat', true, $_tmp, ".") : smarty_modifier_cat($_tmp, ".")))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['extensionTypeArray'][$this->_tpl_vars['val']['extension_type']]) : smarty_modifier_cat($_tmp, $this->_tpl_vars['extensionTypeArray'][$this->_tpl_vars['val']['extension_type']])))) ? $this->_run_mod_handler('cat', true, $_tmp, "?") : smarty_modifier_cat($_tmp, "?")))) ? $this->_run_mod_handler('cat', true, $_tmp, time()) : smarty_modifier_cat($_tmp, time())),'width' => '150','height' => '60','alt' => $this->_tpl_vars['val']['name']), $this);?>
</a>
            <?php endif; ?>
        </div>
        </td>
        <td><?php echo $this->_tpl_vars['val']['name']; ?>
</td>
        <td><?php echo $this->_tpl_vars['categoryList'][$this->_tpl_vars['val']['banner_image_category_id']]; ?>
</td>
        <td><?php echo $this->_tpl_vars['val']['comment']; ?>
</td>
        <td>
            <?php if ($this->_tpl_vars['val']['extension_type'] == IMAGETYPE_SWF || $this->_tpl_vars['val']['extension_type'] == IMAGETYPE_SWC): ?>
                <textarea class="selectText" readonly cols="50"><?php echo $this->_tpl_vars['config']['define']['SITE_URL']; ?>
<?php echo $this->_tpl_vars['bannerPath']; ?>
<?php echo $this->_tpl_vars['val']['file_name']; ?>
.<?php echo $this->_tpl_vars['extensionTypeArray'][$this->_tpl_vars['val']['extension_type']]; ?>
</textarea></td>
            <?php else: ?>
                <textarea class="selectText" readonly cols="50"><img src="<?php echo $this->_tpl_vars['config']['define']['SITE_URL']; ?>
<?php echo $this->_tpl_vars['bannerPath']; ?>
<?php echo $this->_tpl_vars['val']['file_name']; ?>
.<?php echo $this->_tpl_vars['extensionTypeArray'][$this->_tpl_vars['val']['extension_type']]; ?>
"></textarea></td>
            <?php endif; ?>
        <td><?php echo $this->_tpl_vars['val']['create_datetime']; ?>
</td>
        <td><?php echo $this->_tpl_vars['val']['update_datetime']; ?>
</td>
        </tr>
    <?php endforeach; endif; unset($_from); ?>
    </table>
<?php else: ?>
    <div class="warning ui-widget">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    <p>
    <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    該当画像はありません
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