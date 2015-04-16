<?php /* Smarty version 2.6.26, created on 2014-08-09 02:51:34
         compiled from /home/suraimu/templates/mobile/settleCvd.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'emoji', '/home/suraimu/templates/mobile/settleCvd.tpl', 20, false),array('modifier', 'number_format', '/home/suraimu/templates/mobile/settleCvd.tpl', 26, false),array('function', 'html_options', '/home/suraimu/templates/mobile/settleCvd.tpl', 49, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['header'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</head>
<body <?php echo $this->_tpl_vars['bodyTag']; ?>
>
<a name="top" id="top"></a>
<div style="font-size:x-small; text-align:left; <?php echo $this->_tpl_vars['limited_width']; ?>
">
<div style="text-align:center;">
コンビニ決済
</div>
<hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 />
<?php if ($this->_tpl_vars['errMsg']): ?><span style="color:#f00;font-size:small;"><?php echo $this->_tpl_vars['errMsg']; ?>
</span><br /><hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 /><?php endif; ?>
<span style="color:#f00;font-size:small;">【商品のご確認】</span><br />
下記の内容でよろしければ決済ページへお進み下さい。<br /><br />
<?php if ($this->_tpl_vars['itemList']): ?>
    <?php $_from = $this->_tpl_vars['itemList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
        <table border="0" width="100%">
        <tr>
        <td width="20%"><span style="color:#c93;font-size:small;">内容：</span>
        </td>
        <td width="80%"><span style="color:#ffa500;"><?php echo ((is_array($_tmp=$this->_tpl_vars['val']['html_text_name_mb'])) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>
</span>
        </td>
        </tr>
        <tr>
        <td width="20%"><span style="color:#c93;font-size:small;">価格：</span>
        </td>
        <td width="80%"><?php echo ((is_array($_tmp=$this->_tpl_vars['val']['price'])) ? $this->_run_mod_handler('number_format', true, $_tmp, '0') : number_format($_tmp, '0')); ?>
円</td>
        </tr>
        </table>
        <img src="img/line_b.gif" width="100%" />
    <?php endforeach; endif; unset($_from); ?>
    <br />
    <?php endif; ?>
<br />
<form action="./?action_SettleCvdChk=1<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>" method="post">
<?php echo $this->_tpl_vars['FORMparam']; ?>

<table align="center" border="0" width="90%">
<tr>
<td bgcolor="#336600"><span style="color:#cf0;font-size:small;">▼コンビニ選択</span>
</td>
</tr>
<tr>
<td>
<span style="color:#000;">
<?php echo smarty_function_html_options(array('name' => 'cv_cd','options' => $this->_tpl_vars['cvName'],'selected' => $this->_tpl_vars['value']['cv_cd'],'style' => "color:#000;"), $this);?>

</span><br />
</td>
</tr>
<tr>
<td bgcolor="#336600"><span style="color:#cf0;font-size:small;">▼姓</span>
</td>
</tr>
<tr>
<td>
<input name="name1" style="ime-mode: active;" type="text" value="<?php echo $this->_tpl_vars['value']['name1']; ?>
"/>
<br />
</td>
</tr>
<tr>
<td bgcolor="#336600"><span style="color:#cf0;font-size:small;">▼名</span>
</td>
</tr>
<tr>
<td>
<input name="name2" style="ime-mode: active;" type="text" value="<?php echo $this->_tpl_vars['value']['name2']; ?>
" />
<br />
</td>
</tr>
<tr>
<td bgcolor="#336600"><span style="color:#cf0;font-size:small;">▼携帯電話番号</span>
</td>
</tr>
<tr>
<td>
<input name="telno" maxlength="11" style="ime-mode: disabled;" type="text" value="<?php echo $this->_tpl_vars['value']['telno']; ?>
"/>
<br />
</td>
</tr>
<tr>
<td bgcolor="#336600"><span style="color:#cf0;font-size:small;">▼決済金額</span>
</td>
</tr>
<tr>
<td><?php echo ((is_array($_tmp=$this->_tpl_vars['orderingData']['pay_total'])) ? $this->_run_mod_handler('number_format', true, $_tmp, '0') : number_format($_tmp, '0')); ?>
円</td>
</tr>
<!--カウントダウン -->
<?php if ($this->_tpl_vars['showCountDown']): ?>
<tr>
<td bgcolor="#336600"><span style="color:#cf0;font-size:small;">▼締切まで残時間</span>
</td>
</tr>
<tr>
<td><?php echo $this->_tpl_vars['countDownDay']; ?>
<?php echo $this->_tpl_vars['countDownHour']; ?>
<?php echo $this->_tpl_vars['countDownMinute']; ?>
<?php echo $this->_tpl_vars['countDownSecond']; ?>
/td>
</tr>
<?php endif; ?>
</table>
<div style="text-align:center;color:#000;">
▼　▼　▼<br />
<input value="決済内容の確認" type="submit" />
</div>
</form>
<br />
<hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 />
デジタルコンテンツという商品の性質上、ご購入後の返品・交換・払い戻しは、原則としてお受けできませんのでご了承ください。<br />
<span style="color:#fc0;font-size:small;">※注意事項</span><br />
万一決済が正常に終了しない場合は、コンビニダイレクトカスタマーサポート(0570-000-555)までご連絡ください。<br />
メールや受付番号の再発行等は一切いたしませんので、削除せず大切に保管してください。<br />
払込後にポイントが追加されない等のトラブルは直接加盟店様へお問い合わせください。 <br />
お申し込み後はお早めにお支払いをお願いいたします。お申し込みがキャンセルとなる場合がございます。<br />
ご購入にあたっては<a href="./?action_Rule=1<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>">利用規約</a>に同意いただく必要があります。 <br />
<?php if ($this->_tpl_vars['isDisp']): ?>
※ご利用可能なコンビニチェーンについて<br>
セブンイレブンでのコンビニダイレクトは「ご利用が停止」となりました。<br>
セブンイレブン以外の他コンビニチェーンでは今まで同様に「ご利用が可能」でございます。<br />
<?php endif; ?>
<br />
※入金反映時間について<br />
ﾌｧﾐﾘｰﾏｰﾄ ⇒ ご入金後10～30分程度<br />
ﾛｰｿﾝ・ｾｲｺｰﾏｰﾄ・ﾐﾆｽﾄｯﾌﾟ ⇒ ご入金後2～3時間程度<br />
※なお回線状況等で反映が遅れる場合がございますので予め時間に余裕を持った早めのお手続きをお願い申し上げます。<br />
<hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 />
<span style="color:#00ccec;font-size:small;">※他の決済方法に変更する場合はコチラ</span><br />
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['settleMenu'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo $this->_tpl_vars['comImgTag']; ?>

</body>
</html>