<?php /* Smarty version 2.6.26, created on 2014-11-26 12:43:28
         compiled from /home/suraimu/templates/admin/ordering/orderingData.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/ordering/orderingData.tpl', 31, false),array('modifier', 'implode', '/home/suraimu/templates/admin/ordering/orderingData.tpl', 37, false),array('modifier', 'in_array', '/home/suraimu/templates/admin/ordering/orderingData.tpl', 274, false),array('modifier', 'cat', '/home/suraimu/templates/admin/ordering/orderingData.tpl', 331, false),array('modifier', 'emoji', '/home/suraimu/templates/admin/ordering/orderingData.tpl', 331, false),array('function', 'html_options', '/home/suraimu/templates/admin/ordering/orderingData.tpl', 206, false),array('function', 'html_radios', '/home/suraimu/templates/admin/ordering/orderingData.tpl', 250, false),array('function', 'make_link', '/home/suraimu/templates/admin/ordering/orderingData.tpl', 331, false),)), $this); ?>
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

    });
// -->
</script>
</head>
<body>
<div class="BlockCol">
    <h2 class="ContentTitle">注文詳細</h2>
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
    <form action="./" method="post">
        <?php echo $this->_tpl_vars['POSTparam']; ?>

        <input type="submit" name="action_ordering_OrderingSearchList" value="一覧へ戻る" style="width:8em;"/>
    </form>
    <br>
    <?php if ($this->_tpl_vars['orderingData']): ?>
        <table border="0" width="90%">
            <tr>
            <td align="left" valign="top">
                <form action="./" method="post">
                    <?php echo $this->_tpl_vars['POSTparam']; ?>

                    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
                        <tr>
                            <th>サポートメール</th>
                        </tr>
                        <tr>
                            <td>
                            <?php if (! ( $this->_tpl_vars['userData']['regist_status'] == $this->_tpl_vars['config']['define']['USER_REGIST_STATUS_MEMBER_QUIT'] || $this->_tpl_vars['userData']['danger_status'] == $this->_tpl_vars['config']['define']['DANGER_VALID'] )): ?>
                                <input type="submit" name="action_ordering_SupportMailInput" value="サポートメールを送る"/>
                            <?php endif; ?>
                            <br><br>
                            <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
                                <caption>メール送信履歴</caption>
                                <tr>
                                    <th>日付</th>
                                    <th>PCタイトル</th>
                                    <th>MBタイトル</th>
                                    <th>確認</th>
                                </tr>
                                <?php $_from = $this->_tpl_vars['supportMailList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
                                    <tr>
                                        <td><?php echo $this->_tpl_vars['val']['create_datetime']; ?>
</td>
                                        <td><?php echo $this->_tpl_vars['val']['pc_subject']; ?>
</td>
                                        <td><?php echo $this->_tpl_vars['val']['mb_subject']; ?>
</td>
                                        <td>
                                            <form action="./" method="post">
                                                <?php echo $this->_tpl_vars['POSTparam']; ?>

                                                <input type="hidden" name="support_mail_id" value="<?php echo $this->_tpl_vars['val']['id']; ?>
">
                                                <input type="submit" name="action_ordering_SupportMailLogData" value="確 認"/>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; endif; unset($_from); ?>
                            </table>
                            </td>
                        </tr>
                    </table>
                </form>
            </td>
            <td align="right" valign="top">
                <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
                    <tr><td><font color="red">※手順2：下記にて「注文ステータス」を決済完了にしてから<br>　　　　　　入金処理を行う</font></td></tr>
                    <tr>
                        <th>入金情報</th>
                    </tr>
                    <tr>
                        <td>
                        <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
                            <tr>
                                <th>入金日</th>
                                <td><?php echo $this->_tpl_vars['orderingData']['paid_datetime']; ?>
</td>
                            </tr>
                        </table>
                        </td>
                    </tr>
                    <?php if (! $this->_tpl_vars['orderingData']['is_cancel']): ?>
                        <tr>
                            <td>
                                <form action="./" method="post">
                                    <?php echo $this->_tpl_vars['POSTparam']; ?>

                                    <?php if ($this->_tpl_vars['orderingData']['is_paid']): ?>
                                        <input type="hidden" name="payment_cancel" value="1"/>
                                        <input type="submit" name="action_ordering_OrderingPaymentExec" value="入金キャンセルをする" OnClick="return confirm('入金キャンセルをしますか？')"/>
                                    <?php else: ?>
                                                                                <input type="submit" name="action_ordering_OrderingPaymentExec" value="入金する" OnClick="return confirm('入金情報を変更しますか？')"/>
                                    <?php endif; ?>
                                </form>
                            </td>
                        </tr>
                    <?php endif; ?>
                </table>
            </td>
            </tr>
        </table>
        <br><br>
        <table border="0" width="90%">
            <tr>
            <td align="left" valign="top">
                <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
                    <tr>
                        <th>注文情報</th>
                    </tr>
                    <tr>
                        <td>
                        <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
                            <tr>
                                <th>注文No</th>
                                <td><?php echo $this->_tpl_vars['orderingData']['id']; ?>
</td>
                            </tr>
                            <tr>
                                <th>注文日時</th>
                                <td><?php echo $this->_tpl_vars['orderingData']['create_datetime']; ?>
</td>
                            </tr>
                            <tr>
                                <th>更新日時</th>
                                <td><?php echo $this->_tpl_vars['orderingData']['update_datetime']; ?>
</td>
                            </tr>
                            <tr>
                                <th>キャンセル</th>
                                <td><?php echo $this->_tpl_vars['cancelFlag'][$this->_tpl_vars['orderingData']['is_cancel']]; ?>
</td>
                            </tr>
                            <tr>
                                <th>キャンセル日時</th>
                                <td><?php echo $this->_tpl_vars['orderingData']['cancel_datetime']; ?>
</td>
                            </tr>
                            <tr>
                                <th>決済完了日時</th>
                                <td><?php echo $this->_tpl_vars['orderingData']['paid_datetime']; ?>
</td>
                            </tr>
                        </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php if (! $this->_tpl_vars['orderingData']['is_cancel']): ?>
                            <form action="./" method="post">
                                <?php echo $this->_tpl_vars['POSTparam']; ?>

                                <input type="submit" name="action_ordering_OrderingDelExec" value="注文をキャンセル" OnClick="return confirm('注文をキャンセルしますか？')"/>
                            </form>
                            <br>
                            <?php else: ?>
                            <form action="./" method="post">
                                <?php echo $this->_tpl_vars['POSTparam']; ?>

                                <input type="submit" name="action_ordering_OrderingDelCancelExec" value="注文キャンセルを取りやめ" OnClick="return confirm('注文キャンセルを取りやめますか？')"/>
                            </form>
                            <br>
                            <?php endif; ?>
                                                        <?php if ($this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SYSTEM'] || $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_MANAGE']): ?>
                            <form action="./" method="post">
                                <?php echo $this->_tpl_vars['POSTparam']; ?>

                                <input type="hidden" name="is_delete" value="1"/>
                                <input type="submit" name="action_ordering_OrderingDelExec" value="注文を削除" OnClick="return confirm('注文を削除しますか？')"/>
                            </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </td>
            <td align="right" valign="top">
                <form action="./" method="post">
                    <?php echo $this->_tpl_vars['POSTparam']; ?>

                    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
                        <tr><td colspan="2"><font color="red">※手順1：「注文ステータス」を決済完了にしてから</br>　　　　　　「入金する」ボタンで入金処理を行う</font></td></tr>
                        <tr>
                            <th>注文ステータス</th>
                            <td><?php echo smarty_function_html_options(array('name' => 'status','options' => $this->_tpl_vars['orderStatus'],'selected' => $this->_tpl_vars['orderingData']['status']), $this);?>
</td>
                        </tr>
                        <tr>
                            <th>対応＆メモ</th>
                            <td><textarea name="description" cols="30" rows="5"><?php echo $this->_tpl_vars['orderingData']['description']; ?>
</textarea></td>
                        </tr>
                        <tr>
                            <td style="text-align:center;" colspan="2">
                                <input type="submit" name="action_ordering_OrderingStatusExec" value="変更する" OnClick="return confirm('注文ステータスを変更しますか？')" style="width:8em;"/>
                            </td>
                        </tr>
                    </table>
                    <br><br>
                    <?php if ($this->_tpl_vars['isAuomationBas']): ?>
                    <table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet04">
                        <tr>
                          <td colspan="2">
                            <font color="red">
                                                                ※商品の期限切れ状態で押すと余り金決済となり</br>
                                                                金額分のポイントが付与されます（リメールは飛びません）
                            </font>
                          </td>
                        </tr>
                        <tr><th colspan="2" style="text-align:center;">銀行振り込み一括手動完済</th></tr>
                        <tr>
                            <td style="text-align:center;">
                                <input type="submit" value="一括完済処理" name="action_ordering_<?php echo $this->_tpl_vars['settleUrl']; ?>
"  onclick="return confirm('一括完済処理しますか？');"/>
                            </td>
                        </tr>
                    </table>
                    <?php endif; ?>
                </form>
            </td>
            </tr>
        </table>
        <br><br>
        <table border="0" width="80%">
            <tr>
            <td align="left" valign="top">
            <form action="./" method="post">
                <?php echo $this->_tpl_vars['POSTparam']; ?>

                <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
                    <tr>
                        <th>支払方法</th>
                        <td><?php echo smarty_function_html_radios(array('name' => 'pay_type','options' => $this->_tpl_vars['payType'],'selected' => $this->_tpl_vars['orderingData']['pay_type'],'separator' => "&nbsp;"), $this);?>
</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;" colspan="2">
                            <input type="submit" name="action_ordering_OrderingPayTypeExec" value="変更する" OnClick="return confirm('支払方法を変更しますか？')" style="width:8em;"/>
                        </td>
                    </tr>
                </table>
            </form>
            </td>
            </tr>
        </table>
        <br><br>
        <table border="0" width="90%">
            <tr>
            <td align="left" valign="top">
                <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
                    <tr>
                        <th colspan="2">お客様情報</th>
                    </tr>
                    <tr>
                        <th>ユーザーID</th>
                        <td><a href="./?action_user_Detail=1&user_id=<?php echo $this->_tpl_vars['userData']['user_id']; ?>
" target="_blank"><?php echo $this->_tpl_vars['userData']['user_id']; ?>
</a></td>
                    </tr>
                    <?php if (((is_array($_tmp='pc_address')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
                    <tr>
                        <th>PCメールアドレス</th>
                        <td><?php echo $this->_tpl_vars['userData']['pc_address']; ?>
</td>
                    </tr>
                    <?php endif; ?>
                    <?php if (((is_array($_tmp='pc_address_no_domain')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
                    <tr>
                        <th>PCメールアドレス(ドメインなし)</th>
                        <td><?php echo $this->_tpl_vars['userData']['pc_address_no_domain']; ?>
</td>
                    </tr>
                    <?php endif; ?>
                    <?php if (((is_array($_tmp='mb_address')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
                    <tr>
                        <th>MBメールアドレス</th>
                        <td><?php echo $this->_tpl_vars['userData']['mb_address']; ?>
</td>
                    </tr>
                    <?php endif; ?>
                    <?php if (((is_array($_tmp='mb_address_no_domain')) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['displayUserDetail']) : in_array($_tmp, $this->_tpl_vars['displayUserDetail']))): ?>
                    <tr>
                        <th>MBメールアドレス(ドメインなし)</th>
                        <td><?php echo $this->_tpl_vars['userData']['mb_address_no_domain']; ?>
</td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <th>ポイント</th>
                        <td><?php echo $this->_tpl_vars['userData']['point']; ?>
pt</td>
                    </tr>
                    <tr>
                        <th>合計付与ポイント</th>
                        <td><?php echo $this->_tpl_vars['userData']['total_addition_point']; ?>
pt</td>
                    </tr>
                </table>
            </td>
            </tr>
        </table>
        <br><br>
        <form action="./" method="post">
            <?php echo $this->_tpl_vars['POSTparam']; ?>

            <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
                <tr>
                    <th colspan="2">注文詳細情報</th>
                </tr>
                <?php if ($this->_tpl_vars['itemList']): ?>
                <tr><td>
                    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
                        <tr>
                            <th width="200">商品</th>
                            <th>価格</th>
                            <th>削除</th>
                        </tr>
                        <?php $_from = $this->_tpl_vars['itemList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['itemLoop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['itemLoop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['itemVal']):
        $this->_foreach['itemLoop']['iteration']++;
?>
                        <tr>
                            <td>
                                <?php if ($this->_tpl_vars['itemVal']['is_rest']): ?>
                                    余り金PT購入
                                <?php else: ?>
                                    <a href="<?php echo smarty_function_make_link(array('action' => 'action_itemManagement_itemData','getTags' => ((is_array($_tmp="iid=")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['itemVal']['id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['itemVal']['id']))), $this);?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['itemVal']['name'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>
</a>
                                <?php endif; ?>
                            </td>
                            <td><input type="text" name="price[<?php echo $this->_tpl_vars['itemVal']['detail_id']; ?>
]" value="<?php echo $this->_tpl_vars['itemVal']['price']; ?>
" size="7" style="ime-mode:disabled;text-align:right;">円</td>
                            <td><input type="checkbox" name="disable[<?php echo $this->_tpl_vars['itemVal']['detail_id']; ?>
]" value="1"></td>
                        </tr>
                        <?php endforeach; endif; unset($_from); ?>
                    </table>
                </td></tr>
                <?php endif; ?>
                <tr><td>
                    <table border="0" cellspacing="0" cellpadding="0" class="TableSet03" align="right">
                        <tr>
                            <th>総合計</th>
                            <td><?php echo $this->_tpl_vars['orderingData']['pay_total']; ?>
円</td>
                        </tr>
                        <?php if ($this->_tpl_vars['itemList']): ?>
                        <tr>
                            <td style="text-align:center;" colspan="2"><input type="submit" name="action_ordering_OrderingDetailExec" value="変更する" OnClick="return confirm('注文詳細を変更しますか？')" style="width:8em;"/></td>
                        </tr>
                        <?php endif; ?>
                    </table>
                </td></tr>
                <?php if ($this->_tpl_vars['changeItemList']): ?>
                <tr><td>
                    注文変更履歴<br>
                    <table border="0" cellspacing="0" cellpadding="0" class="TableSet04">
                        <tr>
                            <th width="200">商品</th>
                            <th>変更時ステータス</th>
                            <th>価格</th>
                        </tr>
                        <?php $_from = $this->_tpl_vars['changeItemList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['changeItemLoop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['changeItemLoop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['changeItemVal']):
        $this->_foreach['changeItemLoop']['iteration']++;
?>
                        <tr>
                            <td>
                                <?php if (! $this->_tpl_vars['changeItemVal']['item_id']): ?>
                                    余り金PT購入
                                <?php else: ?>
                                    <a href="<?php echo smarty_function_make_link(array('action' => 'action_itemManagement_itemData','getTags' => ((is_array($_tmp="iid=")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['changeItemVal']['item_id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['changeItemVal']['item_id']))), $this);?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['changeItemVal']['name'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>
</a>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $this->_tpl_vars['changeStatus'][$this->_tpl_vars['changeItemVal']['status']]; ?>
</td>
                            <td><?php if ($this->_tpl_vars['changeItemVal']['price'] > 0): ?>+<?php endif; ?><?php echo $this->_tpl_vars['changeItemVal']['price']; ?>
円</td>
                        </tr>
                        <?php endforeach; endif; unset($_from); ?>
                    </table>
                </td></tr>
                <tr><td>
                    <table border="0" cellspacing="0" cellpadding="0" class="TableSet03" align="right">
                        <tr>
                            <th>変更合計金額</th>
                            <td><?php if ($this->_tpl_vars['changeItemTotalMoney'] > 0): ?>+<?php endif; ?><?php echo $this->_tpl_vars['changeItemTotalMoney']; ?>
円</td>
                        </tr>
                    </table>
                </td></tr>
                <?php endif; ?>
            </table>
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