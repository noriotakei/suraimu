<?php /* Smarty version 2.6.26, created on 2014-08-09 02:53:35
         compiled from /home/suraimu/templates/mobile/settleCvdEnd.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', '/home/suraimu/templates/mobile/settleCvdEnd.tpl', 17, false),array('modifier', 'zend_date_format', '/home/suraimu/templates/mobile/settleCvdEnd.tpl', 40, false),array('modifier', 'number_format', '/home/suraimu/templates/mobile/settleCvdEnd.tpl', 47, false),)), $this); ?>
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
<img src="img/title.gif" alt="<?php echo $this->_tpl_vars['siteName']; ?>
" width="100%" />
<div style="text-align:center;">
コンビニ決済
</div>
<hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 />
<span style="color:#f00;font-size:small;">
※まだ決済は完了しておりません</span><br /><br />
<span style="font-size:small;">
ご利用ありがとうございます。<br />
下記の内容でお申込みを受け付けました。お申込み番号を確認の上、お支払いください。<br />
下記の内容をメールでお送りしますのであわせてご確認ください。<br /><br />
お支払いのご不明な点等は、<a href="mailto:<?php echo ((is_array($_tmp=$this->_tpl_vars['operationMailAccount'])) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['config']['define']['MAIL_DOMAIN']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['config']['define']['MAIL_DOMAIN'])); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['operationMailAccount'])) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['config']['define']['MAIL_DOMAIN']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['config']['define']['MAIL_DOMAIN'])); ?>
</a>までお問い合わせください。<br />
</span><br />
<span style="color:#fc0;font-size:small;">【お申込み内容】</span>
<table align="center" border="0" width="90%">
    <tr>
        <td bgcolor="#336600"><span style="color:#cf0;font-size:small;">▼コンビニ選択</span>
</td>
    </tr>
    <tr>
        <td><?php echo $this->_tpl_vars['cvName'][$this->_tpl_vars['cvdData']['store_cd']]; ?>
</td>
    </tr>
    <tr>
        <td bgcolor="#336600"><span style="color:#cf0;font-size:small;">▼お申込み番号</span>
</td>
    </tr>
    <tr>
        <td><?php echo $this->_tpl_vars['cvdData']['number']; ?>
</td>
    </tr>
    <tr>
        <td bgcolor="#336600"><span style="color:#cf0;font-size:small;">▼お申込み有効期限</span>
</td>
    </tr>
    <tr>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['cvdData']['pay_limit_datetime'])) ? $this->_run_mod_handler('zend_date_format', true, $_tmp, 'yyyy年MM月dd日') : smarty_modifier_zend_date_format($_tmp, 'yyyy年MM月dd日')); ?>
</td>
    </tr>
    <tr>
        <td bgcolor="#336600"><span style="color:#cf0;font-size:small;">▼決済金額</span>
</td>
    </tr>
    <tr>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['cvdData']['pay_money'])) ? $this->_run_mod_handler('number_format', true, $_tmp, '0') : number_format($_tmp, '0')); ?>
円</td>
    </tr>
</table>
<br />
<hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 />
<span style="color:#fc0;font-size:small;">※注意事項</span><br />
万一決済が正常に終了しない場合は、コンビニダイレクトカスタマーサポート(0570-000-555)までご連絡ください。<br />
メールや受付番号の再発行等は一切いたしませんので、削除せず大切に保管してください。<br />
払込後にポイントが追加されない等のトラブルは直接加盟店様へお問い合わせください。 <br />
お申し込み後はお早めにお支払いをお願いいたします。お申し込みがキャンセルとなる場合がございます。<br />
ご購入にあたっては<a href="./?action_Rule=1<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>">利用規約</a>に同意いただく必要があります。 <br />
<br />
※入金反映時間について<br />
ﾌｧﾐﾘｰﾏｰﾄ ⇒ ご入金後10～30分程度<br />
ﾛｰｿﾝ・ｾｲｺｰﾏｰﾄ ⇒ ご入金後2～3時間程度<br />
※なお回線状況等で反映が遅れる場合がございますので予め時間に余裕を持った早めのお手続きをお願い申し上げます。<br />
<hr <?php echo $this->_tpl_vars['hr_2style']; ?>
 />
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['footer'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>