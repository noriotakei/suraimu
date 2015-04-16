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
<div id="titleUpdate">登録情報の変更</div>
<dl><dt>月額更新の変更</dt></dl>
{if $errMsg}
    <p class="err">{$errMsg}</p>
{/if}
{if $monthlyCourseUserList}
    <form action="./?action_MonthlyUpdateQuitExec=1" method="post">
        {$comFORMparam}
        <div id="formBg">
            <div id="formIn">
            {foreach from=$monthlyCourseUserList key="key" item="val"}
                <div id="formLeft">{$val.course_name}</div>
                <div id="formRight">{html_options name="monthly_update_change[$key]" options=$monthlyCourseUpdateStatus selected=$returnValue.monthly_update_change.$key|default:0 tabindex="13"}</div>
                <input type="hidden" name="id[{$key}]" value="{$val.id}">
                <br>
                <br clear="all" />
            {/foreach}
                <input id="formCenter" name="regist3" type="image" tabindex="9" onFocus="this.blur()" onMouseOver="this.src='./img/bt_update_on.png'" onMouseOut="this.src='./img/bt_update.png'" src="./img/bt_update.png" alt="更新する" />
            </div>
        </div>
    </form>
    <br />
    <span class="attention">※注意事項</span><br />
    ・解約の変更をされると「お得なキャンペーン情報」をお届けできなくなります。<br />
{/if}
</div>
</div>
{include file=$side}
</div>
{include file=$footer}
</div>
</body>
</html>