<?php /* Smarty version 2.6.26, created on 2014-08-08 16:45:30
         compiled from /home/suraimu/templates/admin/informationStatus/informationSearchList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', '/home/suraimu/templates/admin/informationStatus/informationSearchList.tpl', 16, false),array('function', 'html_radios', '/home/suraimu/templates/admin/informationStatus/informationSearchList.tpl', 36, false),array('function', 'make_link', '/home/suraimu/templates/admin/informationStatus/informationSearchList.tpl', 62, false),array('function', 'html_checkboxes', '/home/suraimu/templates/admin/informationStatus/informationSearchList.tpl', 73, false),array('function', 'cycle', '/home/suraimu/templates/admin/informationStatus/informationSearchList.tpl', 162, false),array('modifier', 'default', '/home/suraimu/templates/admin/informationStatus/informationSearchList.tpl', 36, false),array('modifier', 'zend_date_format', '/home/suraimu/templates/admin/informationStatus/informationSearchList.tpl', 43, false),array('modifier', 'count', '/home/suraimu/templates/admin/informationStatus/informationSearchList.tpl', 90, false),array('modifier', 'implode', '/home/suraimu/templates/admin/informationStatus/informationSearchList.tpl', 97, false),array('modifier', 'cat', '/home/suraimu/templates/admin/informationStatus/informationSearchList.tpl', 146, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
<link type="text/css" href="./css/pager.css" rel="stylesheet" />
</head>
<body>

<div id="ContentsCol">
<h2 class="ContentTitle">情報一覧</h2>
<form action="./" method="POST">
    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" id="src_table">
        <tr>
            <th colspan="2" style="text-align: center; font-weight: bold;">検索条件</th>
        </tr>
        <tr>
            <td>登録フォルダ</td>
            <td><?php echo smarty_function_html_options(array('name' => 'folder_id','options' => $this->_tpl_vars['searchFolderList'],'selected' => $this->_tpl_vars['param']['folder_id']), $this);?>
</td>
        </tr>
        <tr>
            <td>情報表示場所</td>
            <td><?php echo smarty_function_html_options(array('name' => 'position_id','options' => $this->_tpl_vars['displayPositionList'],'selected' => $this->_tpl_vars['param']['position_id']), $this);?>
</td>
        </tr>
        <tr>
            <td>情報ID</td>
            <td>
                <input type="text" name="search_information_id" value="<?php echo $this->_tpl_vars['param']['search_information_id']; ?>
" size="20">&nbsp;(カンマ区切りで複数可)
            </td>
        </tr>
        <tr>
            <td>情報アクセスキー</td>
            <td>
                <input type="text" name="search_information_key" value="<?php echo $this->_tpl_vars['param']['search_information_key']; ?>
" size="50">&nbsp;(カンマ区切りで複数可)
            </td>
        </tr>
        <tr>
            <td>表示状態</td>
            <td><?php echo smarty_function_html_radios(array('name' => 'search_is_display','options' => $this->_tpl_vars['searchIsDisplay'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['param']['search_is_display'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))), $this);?>
</td>
        </tr>
        <tr>
            <td>表示日時指定</td>
            <td>
                <?php echo smarty_function_html_radios(array('name' => 'search_display_datetime_type','id' => 'search_display_datetime_type','options' => $this->_tpl_vars['searchDisplayDateTimeTypeAry'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['param']['search_display_datetime_type'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))), $this);?>

                <div id="search_datetime">
                    開始：<input name="search_datetime_from_date" size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['searchDatetimeFrom'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" maxlength="10">
                    <input name="search_datetime_from_time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['searchDatetimeFrom'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
                    ～&nbsp;終了：<input name="search_datetime_to_date" size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['searchDatetimeTo'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" maxlength="10">
                    <input name="search_datetime_to_time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['searchDatetimeTo'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
                </div>
            </td>
        </tr>
        <tr>
            <td>その他キーワード検索</td>
            <td><?php echo smarty_function_html_radios(array('name' => 'search_type','options' => $this->_tpl_vars['searchTypeAry'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['param']['search_type'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)),'id' => 'search_type','separator' => "&nbsp;"), $this);?>

                <!--
                <div id="keyword_id" style="display:none;">
                    <input type="text" name="search_information_id" value="<?php echo $this->_tpl_vars['param']['search_information_id']; ?>
" size="15">(カンマ区切りで複数可)
                </div>
                -->
                <div id="search_condition_id" style="display:none;">
                    <?php echo smarty_function_html_radios(array('name' => 'search_conditions_display_type','options' => $this->_tpl_vars['searchConditionDisplayType'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['param']['search_conditions_display_type'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)),'separator' => "&nbsp;"), $this);?>
<br>
                    <input type="text" name="search_conditions_id" value="<?php echo $this->_tpl_vars['param']['search_conditions_id']; ?>
" size="15">(カンマ区切りで複数可)<br>
                    <?php echo smarty_function_html_radios(array('name' => 'search_conditions_type','options' => $this->_tpl_vars['searchConditionsTypeArray'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['param']['search_conditions_type'])) ? $this->_run_mod_handler('default', true, $_tmp, 2) : smarty_modifier_default($_tmp, 2)),'separator' => "&nbsp;"), $this);?>
<br>
                    <a href="<?php echo smarty_function_make_link(array('action' => 'action_user_SearchConditionList'), $this);?>
" target="_blank">検索条件保存リスト</a>
                </div>
                <!--
                <div id="keyword_access_key" style="display:none;">
                    <input type="text" name="search_information_key" value="<?php echo $this->_tpl_vars['param']['search_information_key']; ?>
" size="20">
                </div>
                -->
                <div id="keyword" style="display:none;">
                    <input type="text" name="search_string" value="<?php echo $this->_tpl_vars['param']['search_string']; ?>
" size="30">&nbsp;
                </div>
                <div id="keyword_html_text" style="display:none;">
                    <?php echo smarty_function_html_checkboxes(array('name' => 'search_html_text_type','options' => $this->_tpl_vars['searchHtmlTextTypeAry'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['param']['search_html_text_type'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['defaultHtmlTextType']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['defaultHtmlTextType'])),'separator' => "&nbsp;"), $this);?>
<br>
                    <input type="text" name="search_html_text" value="<?php echo $this->_tpl_vars['param']['search_html_text']; ?>
" size="80">
                </div>
            </td>
        </tr>
        <tr>
            <td style="text-align:center;" colspan="2">
                <input type="hidden" name="sort_id" value="<?php echo $this->_tpl_vars['param']['sort_id']; ?>
" />
                <input type="hidden" name="sort_seq" value="<?php echo $this->_tpl_vars['param']['sort_seq']; ?>
">
                <input type="submit" name="action_informationStatus_InformationSearchList" value="検 索" style="width:8em;"/>
            </td>
        </tr>
    </table>
</form>


<?php if (count($this->_tpl_vars['msg'])): ?>
    <br>
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
<br>

<?php if ($this->_tpl_vars['infoStatusList']): ?>
    <div style="padding-bottom: 10px;">
    登録済み：<?php echo $this->_tpl_vars['totalCount']; ?>
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
    <form action="./" method="post" style="margin:2px 0px;">
    <?php echo $this->_tpl_vars['searchParam']; ?>

    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" >
        <tr>
            <th colspan="2" style="text-align: center; font-weight: bold;">情報データ一括操作</th>
        </tr>
        <tr>
            <td>操作内容</td>
            <td><?php echo smarty_function_html_options(array('name' => 'update_type','options' => $this->_tpl_vars['batchOperateInfoSelectAry'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['param']['update_type'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)),'id' => 'update_type'), $this);?>

                <div id="folder_list" style="display:none;">
                    <?php echo smarty_function_html_options(array('name' => 'chg_folder_id','options' => $this->_tpl_vars['infoDispPositionForSelectList'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['param']['folder_id'])) ? $this->_run_mod_handler('default', true, $_tmp, 1) : smarty_modifier_default($_tmp, 1))), $this);?>
&nbsp;に移動
                </div>
                <div id="chg_display" style="display:none;">
                    <?php echo smarty_function_html_options(array('name' => 'chg_display_id','options' => $this->_tpl_vars['isDisplay'],'selected' => 0), $this);?>
&nbsp;に変更
                </div>
                <div id="info_copy" style="display:none;">
                    コピー数：&nbsp;<?php echo smarty_function_html_options(array('name' => 'info_copy_number','options' => $this->_tpl_vars['selectCopyNumber'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['param']['info_copy_number'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))), $this);?>

                </div>
            </td>
        </tr>
        <tr>
            <td style="text-align:center;" colspan="2">
                <input type="submit" name="action_informationStatus_InformationExec" value="更新" onClick="return confirm('更新しますか?')">
            </td>
        </tr>
    </table>
    <br>
    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">
        <tr bgcolor="#FF9933">
           <th rowspan="2"><a href="<?php echo smarty_function_make_link(array('action' => 'action_informationStatus_informationSearchList','getTags' => ((is_array($_tmp=((is_array($_tmp="sort_id=")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['sort']['sort_id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['sort']['sort_id'])))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['sortParam']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['sortParam']))), $this);?>
">ＩＤ</a></th>
           <th>管理用情報名</th>
           <th>表示開始日時</th>
           <!-- <th rowspan="2">検索条件保存ID</th> -->
           <th rowspan="2">表示設定</th>
           <th rowspan="2"><a href="<?php echo smarty_function_make_link(array('action' => 'action_informationStatus_informationSearchList','getTags' => ((is_array($_tmp=((is_array($_tmp="sort_seq=")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['sort']['sort_seq']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['sort']['sort_seq'])))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['sortParam']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['sortParam']))), $this);?>
">表示優先順位</a></th>
           <th rowspan="2">管理用コメント</th>
           <th rowspan="2">PCプレビュー</th>
           <th rowspan="2">MBプレビュー</th>
           <th style="text-align:center;" rowspan="2"><input type="checkbox" onclick="$('#list_table input:checkbox').attr('checked', this.checked);" ></th>
        </tr>
        <tr bgcolor="#FF9933">
           <th>情報表示場所フォルダ</th>
           <th>表示終了日時</th>
        </tr>
        <?php $_from = $this->_tpl_vars['infoStatusList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
            <?php echo smarty_function_cycle(array('values' => "#CCCCCC,",'assign' => 'tr_tag'), $this);?>

            <?php if ($this->_tpl_vars['val']['not_display_flag']): ?>
                <?php $this->assign('tr_tag', "#FF3333"); ?>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['val']['is_copy']): ?>
                <?php $this->assign('tr_tag', "#FFFF99"); ?>
            <?php endif; ?>
            <tr bgcolor="<?php echo $this->_tpl_vars['tr_tag']; ?>
">
                <td align="center" rowspan="2"><a href="<?php echo smarty_function_make_link(array('action' => 'action_informationStatus_informationData','getTags' => ((is_array($_tmp=((is_array($_tmp="isid=")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['val']['id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['val']['id'])))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['URLparam']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['URLparam']))), $this);?>
"><?php echo $this->_tpl_vars['val']['id']; ?>
</a></td>
                <td align="left"><?php echo $this->_tpl_vars['val']['name']; ?>
</td>
                <td align="left"><?php echo $this->_tpl_vars['val']['display_start_datetime']; ?>
</td>
                <!-- <td align="center" rowspan="2"><?php echo $this->_tpl_vars['val']['user_search_conditions_id']; ?>
</td> -->
                <td align="center" rowspan="2"><?php echo $this->_tpl_vars['isDisplay'][$this->_tpl_vars['val']['is_display']]; ?>
</td>
                <td align="center" rowspan="2"><?php echo $this->_tpl_vars['val']['sort_seq']; ?>
</td>
                <td align="center" rowspan="2"><?php echo $this->_tpl_vars['val']['comment']; ?>
</td>
                <td align="center">
                <?php if ($this->_tpl_vars['val']['html_text_banner_pc']): ?>
                <a href="<?php echo $this->_tpl_vars['config']['define']['SITE_URL']; ?>
?action_informationPreview=1&banner_pc=1&isid=<?php echo $this->_tpl_vars['val']['id']; ?>
" target="_blank">PCバナープレビュー</a>
                <?php else: ?>
                設定なし
                <?php endif; ?>
                </td>
                <td align="center">
                <?php if ($this->_tpl_vars['val']['html_text_banner_mb']): ?>
                <a href="<?php echo $this->_tpl_vars['config']['define']['SITE_URL_MOBILE']; ?>
?action_informationPreview=1&banner_mb=1&isid=<?php echo $this->_tpl_vars['val']['id']; ?>
" target="_blank">MBバナープレビュー</a>
                <?php else: ?>
                設定なし
                <?php endif; ?>
                </td>
                <td style="text-align:center;" rowspan="2">
                    <input type="checkbox" name="check_isid[]" value="<?php echo $this->_tpl_vars['val']['id']; ?>
">
                </td>
            </tr>
            <tr bgcolor="<?php echo $this->_tpl_vars['tr_tag']; ?>
">
                <td align="center"><?php echo $this->_tpl_vars['infoDispPositionForSelectList'][$this->_tpl_vars['val']['information_category_id']]; ?>
</td>
                <td align="left"><?php echo $this->_tpl_vars['val']['display_end_datetime']; ?>
</td>
                <td align="center">
                <?php if ($this->_tpl_vars['val']['html_text_pc']): ?>
                <a href="<?php echo $this->_tpl_vars['config']['define']['SITE_URL']; ?>
?action_informationPreview=1&text_pc=1&isid=<?php echo $this->_tpl_vars['val']['id']; ?>
" target="_blank">PC本文プレビュー</a>
                <?php else: ?>
                設定なし
                <?php endif; ?>
                </td>
                <td align="center">
                <?php if ($this->_tpl_vars['val']['html_text_mb']): ?>
                <a href="<?php echo $this->_tpl_vars['config']['define']['SITE_URL_MOBILE']; ?>
?action_informationPreview=1&text_mb=1&isid=<?php echo $this->_tpl_vars['val']['id']; ?>
" target="_blank">MB本文プレビュー</a>
                <?php else: ?>
                設定なし
                <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; endif; unset($_from); ?>

    </table>
    </form>
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
<script type="text/javascript" src="./js/jquery.timepickr.min.js"></script>
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
            dateFormat: "yy-mm-dd"
        });

                //$("#keyword_id").hide();
        $("#search_condition_id").hide();
        $("#keyword").hide();
        $("#search_datetime").hide();
        $("#keyword_html_text").hide();
        //$("#keyword_access_key").hide();

        var openIdAry = {
            //"input[name='search_type']:checked": '#keyword_id'
            "input[name='search_type']:checked": '#search_condition_id'
            ,"input[name='search_type']:checked": '#keyword'
            ,"input[name='search_type']:checked": '#keyword_html_text'
            //,"input[name='search_type']:checked": '#keyword_access_key'
        };

        // 戻ったときに入力されていたら表示する
        for (var key in openIdAry) {
            openSearchInput(key, openIdAry[key]);
        }

        // キーワード検索指定のとき
        $('#search_type').live("click", function(env){
            if (env.button !== 0) return;
            openSearchInput("input[name='search_type']:checked");
        });

        // 表示日時指定
        var displayDatetimeIdAry = {
            "input[name='search_display_datetime_type']:checked": '#search_datetime'
        };

        // 表示日時指定、戻ったときに入力されていたら表示する
        for (var key in displayDatetimeIdAry) {
            openDisplayDatetimeSelect(key, displayDatetimeIdAry[key]);
        }

        // 表示日時指定を変えたとき
        $('#search_display_datetime_type').live("click", function(env){
            if (env.button !== 0) return;
            openDisplayDatetimeSelect("input[name='search_display_datetime_type']:checked");
        });

                $("#src_table tr:even").addClass("BgColor02");

                $("#folder_list").hide();
        $("#chg_display").hide();
        $("#info_copy").hide();

        var updateIdAry = Array('#update_type option:selected');
        for (var val in updateIdAry) {
            openFolderSelect(updateIdAry[val]);
        }

                $('#update_type').change(function(){
            openFolderSelect('#update_type option:selected');
        });
    });

    function openSearchInput(selectId) {

        var selectId = $(selectId);

        if (selectId.val() == 1) {
            //$('#keyword_id').show("blind", "slow");
            //$('#keyword_access_key').hide();
            $("#search_condition_id").hide();
            $('#keyword').hide();
            $('#keyword_html_text').hide();
        } else if (selectId.val() == 2) {
            //$('#keyword_access_key').show("blind", "slow");
            //$('#keyword_id').hide();
            $("#search_condition_id").hide();
            $('#keyword').hide();
            $('#keyword_html_text').hide();
        } else if (selectId.val() == 3) {
            $('#keyword').show("blind", "slow");
            //$('#keyword_access_key').hide();
            //$('#keyword_id').hide();
            $("#search_condition_id").hide();
            $('#keyword_html_text').hide();
        } else if (selectId.val() == 5) {
            $('#search_condition_id').show("blind", "slow");
            //$('#keyword_access_key').hide();
            $('#keyword').hide();
            //$('#keyword_id').hide();
            $('#keyword_html_text').hide();
        } else if (selectId.val() == 6) {
            $('#keyword_html_text').show("blind", "slow");
            $('#search_condition_id').hide();
            //$('#keyword_access_key').hide();
            $('#keyword').hide();
            //$('#keyword_id').hide();
        } else {
            //$('#keyword_access_key').hide();
            $('#keyword').hide("slow");
            //$('#keyword_id').hide("slow");
            $("#search_condition_id").hide();
            $('#keyword_html_text').hide();
        }
    }

    function openFolderSelect(selectId) {

        var selectId = $(selectId);

        if (selectId.val() == 1) {
            $('#folder_list').hide();
            $('#chg_display').show("blind", "slow");
            $('#info_copy').hide();
        } else if (selectId.val() == 2) {
            $('#folder_list').show("blind", "slow");
            $('#chg_display').hide();
            $('#info_copy').hide();
        } else if (selectId.val() == 3) {
            $('#folder_list').hide();
            $('#chg_display').hide();
            $('#info_copy').show("blind", "slow");
        } else {
            $('#folder_list').hide();
            $('#chg_display').hide();
            $('#info_copy').hide();
        }
    }

    function openDisplayDatetimeSelect(selectId) {

        var selectId = $(selectId);

        if (selectId.val() == 3) {
            $('#search_datetime').show("blind", "slow");
        } else {
            $('#search_datetime').hide();
        }
    }

//-->
</script>
</body>
</html>