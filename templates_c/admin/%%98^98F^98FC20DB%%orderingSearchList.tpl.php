<?php /* Smarty version 2.6.26, created on 2014-11-26 12:42:05
         compiled from /home/suraimu/templates/admin/ordering/orderingSearchList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/ordering/orderingSearchList.tpl', 14, false),array('modifier', 'implode', '/home/suraimu/templates/admin/ordering/orderingSearchList.tpl', 20, false),array('modifier', 'zend_date_format', '/home/suraimu/templates/admin/ordering/orderingSearchList.tpl', 42, false),array('modifier', 'default', '/home/suraimu/templates/admin/ordering/orderingSearchList.tpl', 146, false),array('modifier', 'emoji', '/home/suraimu/templates/admin/ordering/orderingSearchList.tpl', 217, false),array('modifier', 'number_format', '/home/suraimu/templates/admin/ordering/orderingSearchList.tpl', 218, false),array('modifier', 'nl2br', '/home/suraimu/templates/admin/ordering/orderingSearchList.tpl', 248, false),array('function', 'html_radios', '/home/suraimu/templates/admin/ordering/orderingSearchList.tpl', 39, false),array('function', 'html_checkboxes', '/home/suraimu/templates/admin/ordering/orderingSearchList.tpl', 119, false),array('function', 'cycle', '/home/suraimu/templates/admin/ordering/orderingSearchList.tpl', 121, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
<link type="text/css" href="./css/pager.css" rel="stylesheet" />
<style type="text/css">
.watermark {
   color: #999;
}
</style>
</head>
<body>
<div class="BlockCol">
    <h2 class="ContentTitle">注文一覧</h2>
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
    <div class="SubMenu">
        <input type="button" id="search_button" value="検索フォーム表示/非表示" />
    </div>
    <form action="./" method="post" id="search_form">
    <?php echo $this->_tpl_vars['POSTparam']; ?>

        <table border="0" cellspacing="0" cellpadding="0" class="TableSet04" id="src_table">
            <tr>
                <th colspan="2" style="text-align: center; font-weight: bold;">検索条件</th>
            </tr>
            <tr>
                <td>注文日付</td>
                <td style="text-align: left;">
                    <?php echo smarty_function_html_radios(array('id' => 'specify_order_date','name' => 'specify_order_date','options' => $this->_tpl_vars['config']['admin_config']['specify_date_time_select'],'selected' => $this->_tpl_vars['param']['specify_order_date'],'separator' => "&nbsp;"), $this);?>

                    <br>
                    <div id="order_date">
                        <input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['order_start_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="order_start_datetime_Date" maxlength="10">
                        <input name="order_start_datetime_Time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['order_start_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
                        ～&nbsp;<input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['order_end_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="order_end_datetime_Date" maxlength="10">
                        <input name="order_end_datetime_Time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['order_end_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
                    </div>
                    <div id="order_time">
                        <input type="text" class="from" name="order_time_from" value="<?php echo $this->_tpl_vars['param']['order_time_from']; ?>
" size="6" maxlength="3" style="ime-mode:disabled;text-align:right;">
                        時間前以上
                        <input type="text" class="to" name="order_time_to" value="<?php echo $this->_tpl_vars['param']['order_time_to']; ?>
" size="6" maxlength="3" style="ime-mode:disabled;text-align:right;">
                        時間前まで
                    </div>
                </td>
            </tr>
            <tr>
                <td>決済完了日付</td>
                <td style="text-align: left;">
                    <?php echo smarty_function_html_radios(array('id' => 'specify_paid_date','name' => 'specify_paid_date','options' => $this->_tpl_vars['config']['admin_config']['specify_date_time_select'],'selected' => $this->_tpl_vars['param']['specify_paid_date'],'separator' => "&nbsp;"), $this);?>

                    <br>
                    <div id="paid_date">
                        <input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['paid_start_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="paid_start_datetime_Date" maxlength="10">
                        <input name="paid_start_datetime_Time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['paid_start_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
                        ～&nbsp;<input size="15" class="datepicker" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['paid_end_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy-MM-dd') : smarty_modifier_zend_date_format($_tmp, 'yyyy-MM-dd')); ?>
" name="paid_end_datetime_Date" maxlength="10">
                        <input name="paid_end_datetime_Time" class="time" type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['paid_end_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'HH:mm:ss') : smarty_modifier_zend_date_format($_tmp, 'HH:mm:ss')); ?>
" size="10" maxlength="8">
                    </div>
                    <div id="paid_time">
                        <input type="text" class="from" name="paid_time_from" value="<?php echo $this->_tpl_vars['param']['paid_time_from']; ?>
" size="6" maxlength="3" style="ime-mode:disabled;text-align:right;">
                        時間前以上
                        <input type="text" class="to" name="paid_time_to" value="<?php echo $this->_tpl_vars['param']['paid_time_to']; ?>
" size="6" maxlength="3" style="ime-mode:disabled;text-align:right;">
                        時間前まで
                    </div>
                </td>
            </tr>
            <tr>
                <td>ユーザーID</td>
                <td>
                     <input type="text" name="user_id" value="<?php echo $this->_tpl_vars['param']['user_id']; ?>
" size="10" style="ime-mode:disabled;">
                </td>
            </tr>
            <tr>
                <td>会員解除</td>
                <td>
                    <input type="checkbox" name="is_quit" value="1" <?php if ($this->_tpl_vars['param']['is_quit']): ?>checked<?php endif; ?>>会員解除ユーザーも含む
                </td>
            </tr>
            <tr>
                <td>ブラック</td>
                <td>
                    <input type="checkbox" name="is_danger" value="1" <?php if ($this->_tpl_vars['param']['is_danger']): ?>checked<?php endif; ?>>ブラックユーザーも含む
                </td>
            </tr>
            <tr>
                <td>注文NO</td>
                <td>
                     <input type="text" name="search_ordering_id" value="<?php echo $this->_tpl_vars['param']['search_ordering_id']; ?>
" size="10" style="ime-mode:disabled;">
                </td>
            </tr>
            <tr>
                <td>商品ID</td>
                <td>
                     <input type="text" name="search_item_id" value="<?php echo $this->_tpl_vars['param']['search_item_id']; ?>
" size="5" style="ime-mode:disabled;">
                </td>
            </tr>
            <tr>
                <td>PCメールアドレス</td>
                <td>
                     <input type="text" name="pc_address" value="<?php echo $this->_tpl_vars['param']['pc_address']; ?>
" size="50" style="ime-mode:disabled;">
                </td>
            </tr>
            <tr>
                <td>MBメールアドレス</td>
                <td>
                     <input type="text" name="mb_address" value="<?php echo $this->_tpl_vars['param']['mb_address']; ?>
" size="50" style="ime-mode:disabled;">
                </td>
            </tr>
            <tr>
                <td>注文ステータス</td>
                <td>
                    <?php echo smarty_function_html_checkboxes(array('name' => 'order_status','options' => $this->_tpl_vars['orderStatus'],'selected' => $this->_tpl_vars['param']['order_status'],'separator' => "&nbsp;",'assign' => 'checkboxes'), $this);?>

                    <?php $_from = $this->_tpl_vars['checkboxes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['checkbox']):
?>
                        <?php echo $this->_tpl_vars['checkbox']; ?>
<?php echo smarty_function_cycle(array('values' => ",,,<br />"), $this);?>

                    <?php endforeach; endif; unset($_from); ?>
                </td>
            </tr>
            <tr>
                <td>支払方法</td>
                <td>
                    <?php echo smarty_function_html_checkboxes(array('name' => 'pay_type','options' => $this->_tpl_vars['payType'],'selected' => $this->_tpl_vars['param']['pay_type'],'separator' => "&nbsp;"), $this);?>

                </td>
            </tr>
            <tr>
                <td>入金</td>
                <td>
                    <?php echo smarty_function_html_checkboxes(array('name' => 'is_paid','options' => $this->_tpl_vars['paidFlag'],'selected' => $this->_tpl_vars['param']['is_paid'],'separator' => "&nbsp;"), $this);?>

                </td>
            </tr>
            <tr>
                <td>キャンセル</td>
                <td>
                    <?php echo smarty_function_html_checkboxes(array('name' => 'is_cancel','options' => $this->_tpl_vars['cancelFlag'],'selected' => $this->_tpl_vars['param']['is_cancel'],'separator' => "&nbsp;"), $this);?>

                </td>
            </tr>
            <tr>
                <td>重複ユーザー</td>
                <td>
                    <?php echo smarty_function_html_radios(array('name' => 'is_overlap','options' => $this->_tpl_vars['overLapFlag'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['param']['is_overlap'])) ? $this->_run_mod_handler('default', true, $_tmp, 1) : smarty_modifier_default($_tmp, 1)),'separator' => "&nbsp;"), $this);?>

                </td>
            </tr>
            <tr>
                <td>無効商品</td>
                <td>
                    <input type="checkbox" name="is_invalid" value="1" <?php if ($this->_tpl_vars['param']['is_invalid']): ?>checked<?php endif; ?>>無効商品を含む注文を除く
                </td>
            </tr>
            <tr>
                <td style="text-align:center;" colspan="2">
                    <input type="hidden" name="search_flag" value="1">
                    <input type="submit" name="action_ordering_OrderingSearchList" value="検 索" style="width:8em;"/>
                </td>
            </tr>
        </table>
    </form>
    <br>
    <?php if ($this->_tpl_vars['param']['search_flag']): ?>
    <form action="./" method="post">
        <?php echo $this->_tpl_vars['supportPOSTparam']; ?>

        <input type="submit" name="action_ordering_SupportMailBulkInput" value="サポートメール一括送信"/>
    </form>
    <br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['orderingList']): ?>
        <div style="padding-bottom: 10px;">
        件数：<?php echo $this->_tpl_vars['totalCount']; ?>
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
        <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
        <tr>
            <th rowspan="2">&nbsp;</th>
            <th><p>注文NO</p></th>
            <th>ユーザーID</th>
            <th>支払方法</th>
            <th>注文日時</th>
            <th>商品明細</th>
          </tr>
          <tr>
            <th>ステータス</th>
            <th>キャンセル</th>
            <th>入金</th>
            <th colspan="2">メモ</th>
          </tr>

        <?php $_from = $this->_tpl_vars['orderingList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
        $this->_foreach['loop']['iteration']++;
?>
            <tr <?php echo $this->_tpl_vars['val']['style']; ?>
>
                <td rowspan="2">
                    <form action="./" method="post">
                        <?php echo $this->_tpl_vars['POSTparam']; ?>

                        <input type="hidden" name="ordering_id" value="<?php echo $this->_tpl_vars['val']['id']; ?>
">
                        <input type="submit" name="action_ordering_OrderingData" value="編 集"/>
                    </form>
                </td>
                <td><?php echo $this->_tpl_vars['val']['id']; ?>
</td>
                <td><a href="./?action_user_Detail=1&user_id=<?php echo $this->_tpl_vars['val']['user_id']; ?>
" target="_blank"><?php echo $this->_tpl_vars['val']['user_id']; ?>
</a></td>
                <td><?php echo $this->_tpl_vars['payType'][$this->_tpl_vars['val']['pay_type']]; ?>
</td>
                <td><?php echo $this->_tpl_vars['val']['create_datetime']; ?>
</td>
                <td>
                    商品<br>
                    <table border="0" cellpadding="0" cellspacing="0" style="font-size:11px">
                        <?php $_from = $this->_tpl_vars['itemList'][$this->_tpl_vars['key']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['itemLoop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['itemLoop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['itemVal']):
        $this->_foreach['itemLoop']['iteration']++;
?>
                        <tr >
                            <td width="150"><?php if ($this->_tpl_vars['itemVal']['is_rest']): ?>余り金PT購入<?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['itemVal']['name'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>
<?php endif; ?></td>
                            <td nowrap>\<?php echo ((is_array($_tmp=$this->_tpl_vars['itemVal']['price'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
                        </tr>
                        <?php endforeach; endif; unset($_from); ?>
                        <tr>
                            <td nowrap>合計</td>
                            <td nowrap>\<?php echo ((is_array($_tmp=$this->_tpl_vars['val']['pay_total'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
                        </tr>
                    </table>
                    <br>
                    <?php if ($this->_tpl_vars['changeItemList'][$this->_tpl_vars['key']]): ?>
                    注文変更履歴<br>
                    <table border="0" cellpadding="0" cellspacing="0" style="font-size:11px">
                        <?php $_from = $this->_tpl_vars['changeItemList'][$this->_tpl_vars['key']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['changeItemLoop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['changeItemLoop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['changeItemVal']):
        $this->_foreach['changeItemLoop']['iteration']++;
?>
                        <tr >
                            <td width="150"><?php if (! $this->_tpl_vars['changeItemVal']['item_id']): ?>余り金PT購入<?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['changeItemVal']['name'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>
<?php endif; ?></td>
                            <td nowrap>\<?php echo ((is_array($_tmp=$this->_tpl_vars['changeItemVal']['price'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
                        </tr>
                        <?php endforeach; endif; unset($_from); ?>
                        <tr>
                            <td nowrap>合計</td>
                            <td nowrap>\<?php echo ((is_array($_tmp=$this->_tpl_vars['changeItemTotalMoney'][$this->_tpl_vars['key']])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
                        </tr>
                    </table>
                    <?php endif; ?>
                </td>
            </tr>
            <tr <?php echo $this->_tpl_vars['val']['style']; ?>
>
                <td><?php echo $this->_tpl_vars['orderStatus'][$this->_tpl_vars['val']['status']]; ?>
</td>
                <td><?php echo $this->_tpl_vars['cancelFlag'][$this->_tpl_vars['val']['is_cancel']]; ?>
</td>
                <td <?php if ($this->_tpl_vars['val']['is_paid']): ?>style="color:red;"<?php endif; ?>><?php echo $this->_tpl_vars['paidFlag'][$this->_tpl_vars['val']['is_paid']]; ?>
</td>
                <td colspan="2"><?php echo ((is_array($_tmp=$this->_tpl_vars['val']['description'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</td>
            </tr>
        <?php endforeach; endif; unset($_from); ?>
        </table>
        <br>
        <div style="padding-bottom: 10px;">
        件数：<?php echo $this->_tpl_vars['totalCount']; ?>
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
    <?php elseif ($this->_tpl_vars['param']['search_flag']): ?>
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
<script type="text/javascript" src="./js/watermark/jquery.watermark.min.js"></script>
<script language="JavaScript">
<!--
    $(function() {

                $(".time").timepickr({
            format24: "{h:02.d}:{m:02.d}:{s:02.d}",
            seconds: true,
            rangeMin: ["00","05","10","15","20","25","30","35","40","45","50","55","59"],
            rangeSec: ["00","15","30","45","59"],
            convention: 24,
            resetOnBlur : false
        });

                $(".datepicker").datepicker({
            dateFormat: "yy-mm-dd"
        });

        $("#search_button").live("click", function(){
            $("#search_form").slideToggle("slow");
        });

                $("#src_table tr:even").addClass("BgColor02");

        $("#order_date").hide();
        $("#order_time").hide();
        $("#paid_date").hide();
        $("#paid_time").hide();

        var openDateIdAry = {
                            "input[name='specify_order_date']:checked": '#order_date'
                        };

        var openTimeIdAry = {
                            "input[name='specify_order_date']:checked": '#order_time'
                        };

        // 戻ったときに日時フォームが入力されていたら表示する
        for (var key in openDateIdAry) {
            openDateTimeInput(key, openDateIdAry[key], openTimeIdAry[key]);
        }

        var openDateIdAry = {
                            "input[name='specify_paid_date']:checked": '#paid_date'
                            };

        var openTimeIdAry = {
                            "input[name='specify_paid_date']:checked": '#paid_time'
                            };

        // 戻ったときに日時フォームが入力されていたら表示する
        for (var key in openDateIdAry) {
            openDateTimeInput(key, openDateIdAry[key], openTimeIdAry[key]);
        }

        // 日付指定のとき
        $('#specify_order_date').live("click", function(env){
            if (env.button !== 0) return;
            openDateTimeInput("input[name='specify_order_date']:checked", "#order_date", "#order_time");
        });

        $('#specify_paid_date').live("click", function(env){
            if (env.button !== 0) return;
            openDateTimeInput("input[name='specify_paid_date']:checked", "#paid_date", "#paid_time");
        });

        // テキストボックス文字
        $('.from').watermark('例):10');
        $('.to').watermark('例):2');

        // 日付、時間入力フォーム表示
        function openDateTimeInput(selectId, openId, openTimeId) {

            var id = $(openId);
            var selectId = $(selectId);
            var timeId = $(openTimeId);

            if (selectId.val() == 1) {
                id.show("blind", "slow");
                timeId.hide("slow");
            } else if (selectId.val() == 7) {
                timeId.show("blind", "slow");
                id.hide("slow");
            } else {
                id.hide("slow");
                timeId.hide("slow");
            }

        }

    });
// -->
</script>
</body>
</html>