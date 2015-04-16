{include file=$header}
</head>
<body>
<a name="top" id="top"></a>
{include file=$status}<div id="wrap">
<div id="imageArea">{include file=$headCampaign}</div>
{include file=$headerMenu}
<div id="contents">
<div id="main">
<div class="mainBox">
<div id="titleTaikai">退会</div>
{if $errMsg}
    <p class="err">{$errMsg}</p>
{/if}
<p>
{$config.define.SITE_NAME}は無料で様々な有益なコンテンツ・情報を入手することが可能です。<br>
お客様への利益還元の感謝を込めて定期的な無料抽選会も開催しております。退会されると全ての権利(コンテンツ・情報・抽選会の参加)を全て失うことになります。<br>
<span style="color:#F00;font-size:24px;">退会せずメール配信停止だけの手続きも可能</span>です。
</p>
<div id="titleMailstop">配信停止</div>
<p>退会せずにお客様ご自身でサイトにログインして全ての権利(コンテンツ・情報・抽選会の参加)を受け取る事ができ<span style="color:#F00;font-size:24px;">所有ポイントも残りますので、退会手続きよりもオススメ</span>です。</p>
<form action="./?action_UpdateSendStatusExec=1" method="post">
{$comFORMparam}
<dl>
<dt>配信の変更</dt>
<div id="formBg">
<div id="formIn">
{if $comUserData.pc_address}
    PC：{html_options name="pc_is_mailmagazine" options=$config.web_config.address_send_status selected=$comUserData.pc_is_mailmagazine  id="mailSelect" tabindex="7"}
{/if}
{if $comUserData.mb_address}
    &nbsp;&nbsp;携帯：{html_options name="mb_is_mailmagazine" options=$config.web_config.address_send_status selected=$comUserData.mb_is_mailmagazine  id="mailSelect" tabindex="8"}
{/if}
<br />
<input name="regist3" type="image" tabindex="9" style="text-align:center;" onFocus="this.blur()" onMouseOver="this.src='./img/bt_updatechk_on.png'" onMouseOut="this.src='./img/bt_updatechk.png'" src="./img/bt_updatechk.png" alt="変更する" />
</div>
</div>
</dl>
</form>
<br />
{$quitPrStartData|emoji}
<div id="centerP">
<form action="./?action_Home=1" method="post">
{$comFORMparam}
<input name="regist3" type="image" tabindex="10" style="text-align:center;" onFocus="this.blur()" onMouseOver="this.src='./img/bt_taikaistop_on.png'" onMouseOut="this.src='./img/bt_taikaistop.png'" src="./img/bt_taikaistop.png" alt="退会手続きを止める" />
</form>
<form action="./?action_TaikaiChk=1" method="post">
{$comFORMparam}
<input name="regist3" type="image" tabindex="11" style="text-align:center;" onFocus="this.blur()" onMouseOver="this.src='./img/bt_taikai_on.png'" onMouseOut="this.src='./img/bt_taikai.png'" src="./img/bt_taikai.png" alt="退会手続きを進める" />
</form>
</div>
</div>
</div>
{include file=$side}
</div>
{include file=$footer}
</div>
</body>
</html>