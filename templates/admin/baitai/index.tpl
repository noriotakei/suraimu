{include file=$admBaitaiHeader}
</head>
<body>
<div id="KingCol">
<h1 class="SiteName">媒体CHK管理画面</h1>
<div id="QueenCol" class="ClearBox">

<div id="LeftCol">
<h3 class="MenuH3">サイト概要</h3>
<ul class="MenuBox">
<li>{html_image file="./img/sitelogo.gif" border="0" width="190"}</li>
<li>運営会社：{$config.define.CAMPANY}</li>
</ul>
</div>

<div id="RightCol">
<div id="RightColFloatHack">

<h2 id="LoginTitle">Login...</h2>
{if $errMsg|@count }
    <div class="ui-widget warning">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    { foreach from=$errMsg item="val" }
        {$val|@implode:"<br>"}
    {/foreach}    </p>
    </div>
    </div>
{/if}
<form action="./" method="POST" target="_top">
<table border="0" cellspacing="0" cellpadding="0" id="LoginForm">
<tr>
<td>ID<input type="text" name="login_id" size="10" /></td>
<td>Password<input type="password" name="password" size="15" /></td>
<td><input type="submit" name="action_baitai_Login" value="++  LOGIN  ++" /></td>
</tr>
</table>
</form>

</div>
</div>

</div>
<div id="FootCol">Powerd by {$config.define.CAMPANY}</div>
</div>
</body>
</html>