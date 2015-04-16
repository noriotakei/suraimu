<?php /* Smarty version 2.6.26, created on 2014-08-08 23:26:29
         compiled from /home/suraimu/templates/admin/baitaiAgency/baitaiAgencyUpd.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/baitaiAgency/baitaiAgencyUpd.tpl', 39, false),array('modifier', 'implode', '/home/suraimu/templates/admin/baitaiAgency/baitaiAgencyUpd.tpl', 45, false),array('modifier', 'default', '/home/suraimu/templates/admin/baitaiAgency/baitaiAgencyUpd.tpl', 94, false),array('function', 'html_radios', '/home/suraimu/templates/admin/baitaiAgency/baitaiAgencyUpd.tpl', 86, false),array('function', 'html_options', '/home/suraimu/templates/admin/baitaiAgency/baitaiAgencyUpd.tpl', 94, false),array('function', 'html_checkboxes', '/home/suraimu/templates/admin/baitaiAgency/baitaiAgencyUpd.tpl', 102, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script language="JavaScript">
<!--
    $(function() {
                $('#list_table').colorize({
            altColor :'#CCCCCC',
            hiliteColor :'none'
        });

                if (!<?php echo $this->_tpl_vars['cdSettingParam']['return_flag']; ?>
) {
            $("#add_form_cd").hide();
        } else {
            $("#add_form_cd").show();
        }
        $('#add_button_cd').live("click", function(){
            $("#add_form_cd").toggle("blind", null, "slow");
        });

                if (!<?php echo $this->_tpl_vars['ipSettingParam']['return_flag']; ?>
) {
            $("#add_form_ip_address").hide();
        } else {
            $("#add_form_ip_address").show();
        }
        $('#add_button_ip_address').live("click", function(){
            $("#add_form_ip_address").toggle("blind", null, "slow");
        });
    });

</script>
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">代理店媒体更新画面</h2>
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
<?php endif; ?>
<br>
<form action="./" method="post">
    <input type="submit" name="action_baitaiAgency_BaitaiAgencyList" value="一覧へ戻る" style="width:8em;"/>
</form>
<br>
<form action="./" method="POST">
    <?php echo $this->_tpl_vars['POSTparam']; ?>

    <table class="TableSet01">
        <tr>
            <th>
                名前：
            </th>
            <td style="text-align: left;">
                <input type="text" name="name" value="<?php echo $this->_tpl_vars['agencyParam']['name']; ?>
" size="40">
            </td>
        </tr>
        <tr>
            <th>
                ログインID：
            </th>
            <td style="text-align: left;">
                <input type="text" name="login_id" value="<?php echo $this->_tpl_vars['agencyParam']['login_id']; ?>
">
            </td>
        </tr>
        <tr>
            <th>
                パスワード：
            </th>
            <td style="text-align: left;">
                <input type="text" name="display_password" value="<?php echo $this->_tpl_vars['agencyParam']['display_password']; ?>
" style="ime-mode:disabled">
            </td>
        </tr>
        <tr>
            <th>IPアドレス認証：</th>
            <td style="text-align: left;">
                <?php echo smarty_function_html_radios(array('name' => 'is_auth_ip_address','options' => $this->_tpl_vars['isAuthIpAddress'],'selected' => $this->_tpl_vars['agencyParam']['is_auth_ip_address'],'id' => 'is_auth_ip_address'), $this);?>

            </td>
        </tr>
        <tr>
            <th>
                入金額の表示設定：
            </th>
            <td style="text-align: left;">
                <?php echo smarty_function_html_options(array('name' => 'is_display','options' => $this->_tpl_vars['isDisplayPay'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['agencyParam']['is_display_trade_amount'])) ? $this->_run_mod_handler('default', true, $_tmp, 1) : smarty_modifier_default($_tmp, 1))), $this);?>

            </td>
        </tr>
        <tr>
            <th>
                削除：
            </th>
            <td style="text-align: left;">
                <?php echo smarty_function_html_checkboxes(array('name' => 'disable','options' => $this->_tpl_vars['disable'],'selected' => $this->_tpl_vars['agencyParam']['disable']), $this);?>

            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">
                <input type="hidden" name="agency_upd" value="1">
                <input type="submit" value="更　新" name="action_baitaiAgency_BaitaiAgencyRegExec" onClick="return confirm('更新しますか？')">
            </td>
        </tr>
    </table>
</form>
<br>
<hr>
<div class="SubMenu">
    <input type="button" id="add_button_cd" value="媒体コード追加" />&nbsp;
</div>
<div id="add_form_cd" style="display:none">
<form action="./" method="post" enctype="multipart/form-data">
    <?php echo $this->_tpl_vars['POSTparam']; ?>

    <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
        <tr>
            <th>媒体名</th>
            <th>媒体コード</th>
            <th></th>
        </tr>
        <tr>
            <td style="text-align: left;">
                <input type="text" name="media_name" value="<?php echo $this->_tpl_vars['cdSettingParam']['media_name']; ?>
" size="25">
            </td>
            <td style="text-align: left;">
                <input type="text" name="media_cd" value="<?php echo $this->_tpl_vars['cdSettingParam']['media_cd']; ?>
" size="25">
            </td>
            <td><input type="submit" name="action_baitaiAgency_BaitaiAgencyCdSettingExec" value="登 録" OnClick="return confirm('登録しますか？')" /></td>
        </tr>
    </table>
</form>
</div>
<br>


<table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet01">
<tr>
<td style="text-align: left;">

■広告費関連項目の説明</br>

・広告費タイプ</br>
  └媒体毎の広告費のタイプを選択</br></br>
・広告費毎の入力フォーム</br>
  └広告費タイプで選択した広告費タイプのフォームのみ適切な数値を入力して下さい</br>
  　複数個所に入力があると正常な集計が行われません。</br></br>
・広告期間　　　2012-03～2012-07と年月のみ入力</br>
  └広告費(毎月)・・広告期間from～広告期間toの間に集計対象年月が含まれている場合は広告費を計上。</br>
  └広告費(一回払い)・・広告期間from～広告期間to共に同じ年月を入力。集計対象年月が含まれている場合は広告費を計上。</br>
  └広告費（単価）・・広告期間from～広告期間toの間に集計対象年月が含まれている場合は広告費を計上。</br>
  └成果報酬・・広告期間from～広告期間toの間に集計対象年月が含まれている場合は広告費を計上。</br>
　　　　　　　　　無期限の場合は「広告期間to」を遠い未来にして下さい。</br>
</td>
</tr>
</table>



<?php if ($this->_tpl_vars['cdSettingList']): ?>
    <form action="./" method="post" enctype="multipart/form-data">
        <?php echo $this->_tpl_vars['POSTparam']; ?>

            <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet01">
                <tr>
                    <th>媒体名</th>
                    <th>媒体コード</th>
                    <th>広告費タイプ</th>
                    <th>広告費(毎月)</th>
                    <th>広告費(一回払い)</th>
                    <th>広告費（単価）</th>
                    <th>成果報酬</th>
                    <th>広告期間from</th>
                    <th>広告期間to</th>
                    <th style="text-align:center;">削除<br><input type="checkbox" onclick="$('#list_table input:checkbox').attr('checked', this.checked);" ></th>
                </tr>
                <?php $_from = $this->_tpl_vars['cdSettingList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
                <tr>
                    <td style="text-align: left;">
                        <input type="text" name="media_name[<?php echo $this->_tpl_vars['val']['id']; ?>
]" value="<?php echo $this->_tpl_vars['val']['media_name']; ?>
" size="15">
                    </td>
                    <td style="text-align: left;">
                        <input type="text" name="media_cd[<?php echo $this->_tpl_vars['val']['id']; ?>
]" value="<?php echo $this->_tpl_vars['val']['media_cd']; ?>
" size="15">
                    </td>
                    <td style="text-align: left;">
                        <?php echo smarty_function_html_options(array('name' => "advertise_expenses_type[".($this->_tpl_vars['val']['id'])."]",'options' => $this->_tpl_vars['advertiseExpensesType'],'selected' => ($this->_tpl_vars['val']['advertise_expenses_type'])), $this);?>

                    </td>
                    <td style="text-align: left;">
                        <input type="text" name="advertise_expenses[<?php echo $this->_tpl_vars['val']['id']; ?>
]" value="<?php echo $this->_tpl_vars['val']['advertise_expenses']; ?>
" size="15">
                    </td>
                    <td style="text-align: left;">
                        <input type="text" name="advertise_expenses_once[<?php echo $this->_tpl_vars['val']['id']; ?>
]" value="<?php echo $this->_tpl_vars['val']['advertise_expenses_once']; ?>
" size="15">
                    </td>
                    <td style="text-align: left;">
                        <input type="text" name="advertise_expenses_apiece[<?php echo $this->_tpl_vars['val']['id']; ?>
]" value="<?php echo $this->_tpl_vars['val']['advertise_expenses_apiece']; ?>
" size="15">
                    </td>
                    <td style="text-align: left;">
                        <input type="text" name="advertise_expenses_percent[<?php echo $this->_tpl_vars['val']['id']; ?>
]" value="<?php echo $this->_tpl_vars['val']['advertise_expenses_percent']; ?>
" size="2">%　　
                                            </td>
                    <td style="text-align: left;">
                        <input type="text" name="advertise_period_from[<?php echo $this->_tpl_vars['val']['id']; ?>
]" value="<?php echo $this->_tpl_vars['val']['advertise_period_from']; ?>
" size="15">
                    </td>
                    <td style="text-align: left;">
                        <input type="text" name="advertise_period_to[<?php echo $this->_tpl_vars['val']['id']; ?>
]" value="<?php echo $this->_tpl_vars['val']['advertise_period_to']; ?>
" size="15">
                    </td>
                    <td style="text-align:center;">
                        <input type="checkbox" name="disable[<?php echo $this->_tpl_vars['val']['id']; ?>
]" value="1">
                        <input type="hidden" name="agency_id[]" value="<?php echo $this->_tpl_vars['val']['id']; ?>
">
                    </td>
                </tr>
                <?php endforeach; endif; unset($_from); ?>
            </table>
            <div class="SubMenu">
                <input type="submit" name="action_baitaiAgency_BaitaiAgencyCdSettingExec" value="更 新" OnClick="return confirm('更新しますか？')" />
            </div>
    </form>
<?php else: ?>
    <div class="warning ui-widget">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    <p>
    <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    該当データはありません
    </p>
    </div>
<?php endif; ?>
<hr>
<div class="SubMenu">
    <input type="button" id="add_button_ip_address" value="認証IPアドレス追加" />
</div>
<div id="add_form_ip_address" style="display:none">
<form action="./" method="post" enctype="multipart/form-data">
    <?php echo $this->_tpl_vars['POSTparam']; ?>

    <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
        <tr>
            <th>認証IPアドレス</th>
            <th>使用状況</th>
            <th></th>
        </tr>
        <tr>
            <td style="text-align: left;" nowrap>
                <input type="text" name="ip_address[]" value="<?php echo $this->_tpl_vars['ipSettingParam']['ip_address']['0']; ?>
" style="ime-mode:disabled" size="5">．
                <input type="text" name="ip_address[]" value="<?php echo $this->_tpl_vars['ipSettingParam']['ip_address']['1']; ?>
" style="ime-mode:disabled" size="5">．
                <input type="text" name="ip_address[]" value="<?php echo $this->_tpl_vars['ipSettingParam']['ip_address']['2']; ?>
" style="ime-mode:disabled" size="5">．
                <input type="text" name="ip_address[]" value="<?php echo $this->_tpl_vars['ipSettingParam']['ip_address']['3']; ?>
" style="ime-mode:disabled" size="5">
            </td>
            <td style="text-align: left;">
                <?php echo smarty_function_html_options(array('name' => 'is_use','options' => $this->_tpl_vars['isUse'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['ipSettingParam']['is_use'][$this->_tpl_vars['key']])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['val']['is_use']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['val']['is_use']))), $this);?>

            </td>
            <td rowspan="2" style="text-align:center;">
                <input type="submit" name="action_baitaiAgency_BaitaiAgencyIpAddressSettingExec" value="登 録" OnClick="return confirm('登録しますか？')" />
            </td>
        </tr>
    </table>
</form>
</div>
<br>
<?php if ($this->_tpl_vars['ipSettingList']): ?>
    <form action="./" method="post" enctype="multipart/form-data">
        <?php echo $this->_tpl_vars['POSTparam']; ?>

            <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet01">
                <tr>
                    <th>認証IPアドレス</th>
                    <th>使用状況</th>
                    <th style="text-align:center;">削除<br><input type="checkbox" onclick="$('#list_table input:checkbox').attr('checked', this.checked);" ></th>
                </tr>
                <?php $_from = $this->_tpl_vars['ipSettingList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
                <tr>
                    <td style="text-align: left;" nowrap>
                        <input type="text" name="ip_address[<?php echo $this->_tpl_vars['val']['id']; ?>
][]" value="<?php echo $this->_tpl_vars['val']['ip_address']['0']; ?>
" style="ime-mode:disabled" size="5">．
                        <input type="text" name="ip_address[<?php echo $this->_tpl_vars['val']['id']; ?>
][]" value="<?php echo $this->_tpl_vars['val']['ip_address']['1']; ?>
" style="ime-mode:disabled" size="5">．
                        <input type="text" name="ip_address[<?php echo $this->_tpl_vars['val']['id']; ?>
][]" value="<?php echo $this->_tpl_vars['val']['ip_address']['2']; ?>
" style="ime-mode:disabled" size="5">．
                        <input type="text" name="ip_address[<?php echo $this->_tpl_vars['val']['id']; ?>
][]" value="<?php echo $this->_tpl_vars['val']['ip_address']['3']; ?>
" style="ime-mode:disabled" size="5">
                    </td>
                    <td style="text-align: left;">
                        <?php echo smarty_function_html_options(array('name' => "is_use[]",'options' => $this->_tpl_vars['isUse'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['val']['is_use'][$this->_tpl_vars['key']])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['val']['is_use']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['val']['is_use']))), $this);?>

                    </td>
                    <td style="text-align:center;">
                        <input type="checkbox" name="disable[<?php echo $this->_tpl_vars['val']['id']; ?>
]" value="1">
                        <input type="hidden" name="ip_address_setting_id[]" value="<?php echo $this->_tpl_vars['val']['id']; ?>
">
                    </td>
                </tr>
                <?php endforeach; endif; unset($_from); ?>
            </table>
            <div class="SubMenu">
                <input type="submit" name="action_baitaiAgency_BaitaiAgencyIpAddressSettingExec" value="更 新" OnClick="return confirm('更新しますか？')" />
            </div>
    </form>
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