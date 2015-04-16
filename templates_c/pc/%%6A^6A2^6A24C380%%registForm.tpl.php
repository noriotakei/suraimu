<?php /* Smarty version 2.6.26, created on 2014-08-08 16:00:17
         compiled from /home/suraimu/templates/www/include/registForm.tpl */ ?>
<div id="registForm">
    <form action="./?action_PreRegistExec=1" method="POST" >
        <?php echo $this->_tpl_vars['comFORMparam']; ?>

        <input name="mail_account" type="text" id="mailRegist" tabindex="7" value="" style="ime-mode:disabled;" /><span>＠</span><input name="mail_domain" type="text" id="mailRegist" tabindex="8" value="" style="ime-mode:disabled;" /><br />
        <div id="txtLeft">
            ※この応募で<?php echo $this->_tpl_vars['config']['define']['SITE_NAME']; ?>
に登録となりメルマガ会員になります。<br />
            ※当サイトの<a href="./?action_Privacy=1<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>" target="_blank" id="privacy">プライバシーポリシーはコチラ</a>から<br />
            ※<a href="./?action_Rule=1<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>" title="ご利用規約" target="_blank">ご利用規約</a>に同意してください。※未成年者のご利用はできません。<br />
        </div>
        <div id="txtRight">
            <input name="send_status" type="checkbox" value="1" checked="checked" id="spcheck" /><?php echo $this->_tpl_vars['config']['define']['SITE_NAME']; ?>
からのメルマガを受け取る<br />
        </div>
        <br clear="all">
        <input name="regist3" type="image" tabindex="9" onFocus="this.blur()" onMouseOver="this.src='./img/bt_regist_on.gif'" onMouseOut="this.src='./img/bt_regist.gif'" src="./img/bt_regist.gif" class="btLogin" alt="MemberLogin" />
    </form>
    <div id="setting">
        <a href="./?action_Setting=1<?php if ($this->_tpl_vars['comURLparam']): ?>&<?php echo $this->_tpl_vars['comURLparam']; ?>
<?php endif; ?>" title="ドメイン指定受信" target="_blank" id="setting">ドメイン指定受信　携帯にメールが届かない場合は？※メールの受信制限（ドメイン指定設定・迷惑メール設定）を設定されていると情報を受け取れないことがあります。</a>
    </div>
</div>