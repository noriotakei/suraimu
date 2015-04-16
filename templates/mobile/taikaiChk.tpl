{include file=$header}
</head>
<body {$bodyTag}>
<a name="top" id="top"></a>
<div style="font-size:x-small; text-align:left; {$limited_width}">
<img src="img/title.gif" alt="{$siteName}" width="100%" />
<div style="text-align:center;">退会手続き</div>
<hr {$hr_1style} />
{if $errMsg}<span style="color:#f00;font-size:small;">{$errMsg}</span><br /><hr {$hr_2style} />{/if}
ページ最下部の『※退会する※』のボタンを押せば退会処理が完了します。
<br /><br />
<span style="color:#f00;">が！その前に･･･</span>
<br /><br />
競馬はギャンブル、ギャンブルは負ける、とお考えの方が多いですが、当サイトは競馬をギャンブルとしてではなく、投資と考えております。下記の的中証明をご覧ください。<br /><img src="img/verification.gif" alt="的中証明" width="200px" height="170px"/><br />
競馬という投資で、わずか１００円玉１枚が、<span style="color:#f00;">２３８万１６６０円</span>に化けるのです。
<br /><br />
イメージしてみてください。わずか１分でこのような大金を獲得できる自分を。初心者の方、未経験の方でも最初からわかりやすく、競馬の楽しみ方、携帯での馬券の買い方を丁寧に説明いたします。まずは一度、無料情報・ポイント情報・キャンペーン情報などで的中を体感してみてください。
<br /><br />
きっと競馬の楽しみ方、儲け方がわかって頂けると思います。<span style="color:#f00;">明日、１００万馬券を的中させるのは貴方です！</span>
<br /><br />
<div style="text-align:center;color:#000;">
<form action="./?action_Home=1{if $comURLparam}&{$comURLparam}{/if}" method="post">
<input value="退会手続きを止める" type="submit" />
</form></div>
<hr {$hr_1style} />
{include file=$quitPr}
<div style="text-align:center;color:#000;">
<form action="./?action_TaikaiExec=1{if $comURLparam}&{$comURLparam}{/if}" method="post">
<input value="※退会する※" type="submit" />
</form>
</div>
<hr {$hr_1style} />
{include file=$footer}
</body>
</html>