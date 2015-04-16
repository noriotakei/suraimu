<?php /* Smarty version 2.6.26, created on 2014-08-09 02:53:27
         compiled from /home/suraimu/templates/mobile/settleCvdChk.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', '/home/suraimu/templates/mobile/settleCvdChk.tpl', 49, false),array('modifier', 'emoji', '/home/suraimu/templates/mobile/settleCvdChk.tpl', 58, false),)), $this); ?>
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
<span style="color:#f00;font-size:small;">
【決済内容の確認】</span>
<form action="./?action_SettleCvdExec=1<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>" method="post">
<?php echo $this->_tpl_vars['FORMparam']; ?>

<table align="center" border="0" width="90%">
    <tr>
        <td bgcolor="#336600"><span style="color:#cf0;font-size:small;">▼コンビニ選択</span>
</td>
    </tr>
    <tr>
        <td><?php echo $this->_tpl_vars['cvName'][$this->_tpl_vars['param']['cv_cd']]; ?>
</td>
    </tr>
    <tr>
        <td bgcolor="#336600"><span style="color:#cf0;font-size:small;">▼姓</span>
</td>
    </tr>
    <tr>
        <td><?php echo $this->_tpl_vars['param']['name1']; ?>
</td>
    </tr>
    <tr>
        <td bgcolor="#336600"><span style="color:#cf0;font-size:small;">▼名</span>
</td>
    </tr>
    <tr>
        <td><?php echo $this->_tpl_vars['param']['name2']; ?>
</td>
    </tr>
    <tr>
        <td bgcolor="#336600"><span style="color:#cf0;font-size:small;">▼携帯電話番号</span>
</td>
    </tr>
    <tr>
        <td><?php echo $this->_tpl_vars['param']['telno']; ?>
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
</table>
<div style="text-align:center;color:#000;">
    ▼　▼　▼<br />
    <input value="申し込む" type="submit" />
</div>
</form>
<br />
<span style="color:#99ec00;"><?php echo ((is_array($_tmp="")) ? $this->_run_mod_handler('emoji', true, $_tmp) : smarty_modifier_emoji($_tmp)); ?>
</span><span style="font-size:small;"><a href="./?action_SettleCvd=1&<?php echo $this->_tpl_vars['URLparam']; ?>
<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>">内容を修正する</a></span><br />
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
<?php echo $this->_tpl_vars['comImgTag']; ?>

</body>
</html>