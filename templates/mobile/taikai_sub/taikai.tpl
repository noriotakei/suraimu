{include file=$header}
</head>
<body {$bodyTag}>
<a name="top" id="top"></a>
<div style="font-size:x-small; text-align:left; {$limited_width}">
<img src="img/title.gif" alt="{$siteName}" width="100%" />
<div style="text-align:center;">
退会手続き</div>

<hr {$hr_2style} />
{if $errMsg}<span style="color:#f00;font-size:small;">{$errMsg}</span><br /><hr {$hr_2style} />{/if}
<span style="color:#f00;font-size:small;">【注意事項】</span><br />
高配当.comは無料で様々な有益なコンテンツ・情報を入手することが可能です。お客様への利益還元の感謝を込めて定期的な無料抽選会も開催しております。退会されると全ての権利(コンテンツ・情報・抽選会の参加)を全て失うことになります。退会せずメール配信停止だけの手続きも可能です。<br /><br />
<span style="color:#fc0;font-size:small;">▼所有ポイント数</span><br />
<div style="font-size:large;text-align:center;font-weight:bold;">{$comUserData.point} PT</div>
<span style="color:#f00;">
※1ポイント100円分の計算です。<br />
※所有ポイントも全て消滅いたします。
</span>
<hr {$hr_2style} />
<div style="background-color:#06c;color:#fff;font-size:small;">
配信停止
</div>
メール配信が不要な場合は配信停止の設定が可能です。退会せずにお客様ご自身でサイトにログインして全ての権利(コンテンツ・情報・抽選会の参加)を受け取る事ができ所有ポイントも残りますので、退会手続きよりもオススメです。
<br>
<div style="text-align:center;"><a href="./?action_Update=1{if $comURLparam}&{$comURLparam}{/if}"><span style="color:#fff;">配信停止の手続きはこちら!</span></a></div><br>
<hr {$hr_2style} />
<div style="text-align:center;color:#000;">
<form action="./?action_Home=1{if $comURLparam}&{$comURLparam}{/if}" method="post">
<input value="退会手続きを止める" type="submit" />
</form>
<br>
<form action="./?action_Taikai2=1{if $comURLparam}&{$comURLparam}{/if}" method="post">
<input value="退会手続きを進める" type="submit" />
</form>
</div>
<hr {$hr_2style} />
{include file=$pr}
{include file=$footer}
</body>
</html>