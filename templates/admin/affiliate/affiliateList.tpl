{include file=$admHeader}
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script type="text/javascript" src="./js/watermark/jquery.watermark.min.js"></script>
<script language="JavaScript">
<!--

    $(function() {ldelim}
        // テーブルマウスオーバーカラー
        $('#list_table').colorize({ldelim}
            altColor :'#CCCCCC',
            hiliteColor :'none'
        {rdelim});

        if ({$param.return_flag}) {ldelim}
            $("#add_form").show();
        {rdelim}

        $('#add_button').live("click", function(env){ldelim}
            if (env.button !== 0) return;
            $("#add_form").toggle("blind", null, "slow");
        {rdelim});

        $("#connect_type_1").attr('disabled', 'disabled');

        $("input[name='send_type']").live("click", function(env){ldelim}
            if (env.button !== 0) return;
            if ($("input[name='send_type']:checked").val() != 0) {ldelim}
                 $('#connect_type_1').attr('disabled', false);
            {rdelim} else if ($("input[name='send_type']:checked").val() == 0) {ldelim}
                 $("input[name='connect_type']").val(['0']);
                 $('#connect_type_1').attr('disabled', 'disabled');
            {rdelim};
        {rdelim});

        $("input[name='is_pre_regist']").live("click", function(env){ldelim}
            if (env.button !== 0) return;
            if ($("input[name='is_pre_regist']:checked").val() != 0) {ldelim}
                 $('#connect_type_1').attr('disabled', false);
                 $('#send_type_0').attr('disabled', false);
            {rdelim} else {ldelim}
                 $("input[name='connect_type']").val(['0']);
                 $('#connect_type_1').attr('disabled', 'disabled');
                 $("input[name='send_type']").val(['1']);
                 $('#send_type_0').attr('disabled', 'disabled');
            {rdelim};
        {rdelim});

        $('.path').watermark('「http://」から入力');

    {rdelim});

// -->
</script>
<style type="text/css">
.watermark {ldelim}
   color: #999;
{rdelim}
</style>
</head>
<body>
<div id="ContentsCol">
<h2 class="ContentTitle">登録時発行タグ一覧</h2>
{* 更新時エラーコメント *}
{if $execMsg|@count}
    <div class="warning ui-widget">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    <p>
    <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    { foreach from=$execMsg item="val" }
        {$val|@implode:"<br>"}
    {/foreach}
    </p>
    </div>
    </div>
{/if}
<div class="SubMenu">
    <input type="button" id="add_button" value="追　加" />
</div>

<div id="add_form" style="display:none;">
<form action="./" method="POST">
    {$POSTparam}
    <table class="TableSet04">
        <tr>
            <th>広告コード<br>(完全一致か上2桁の前方一致)</th>
            <td><input type="text" name="media_cd" value="{$param.media_cd}" style="ime-mode:disabled" size="10"></td>
        </tr>
        <tr>
            <th>サイト名</th>
            <td><input type="text" name="site_name" value="{$param.site_name}" size="30"></td>
        </tr>
        <tr>
            <th>登録ステータス</th>
            <td>{html_radios label_ids=true name="is_pre_regist" options=$isPreRegist selected=$param.is_pre_regist|default:1 separator="&nbsp;"}</td>
        </tr>
        <tr>
            <th>送信設定</th>
            <td>{html_checkboxes name="is_success_only" options=$isSuccessOnly selected=$param.is_success_only separator="&nbsp;"}</td>
        </tr>
        <tr>
            <th>戻し先URL(任意)</th>
            <td><input class="path" type="text" name="path" value="{$param.path}" style="ime-mode:disabled" size="40"></td>
        </tr>
        <tr>
            <th>送信種別</th>
            <td>{html_radios label_ids=true name="send_type" options=$sendType selected=$param.send_type|default:0 separator="&nbsp;"}</td>
        </tr>
        <tr>
            <th>発行種別<br>(本登録フローは<br>ソケット通信のみ)</th>
            <td>{html_radios label_ids=true name="connect_type" options=$connectType selected=$param.connect_type|default:0 separator="&nbsp;"}</td>
        </tr>
        <tr>
            <th>成功時追加<br>パラメータ(任意)</th>
            <td><input type="text" name="success_parameter" value="{$param.success_parameter}" style="ime-mode:disabled" size="30"></td>
        </tr>
        <tr>
            <th>失敗時追加<br>パラメータ(任意)</th>
            <td><input type="text" name="failure_parameter" value="{$param.failure_parameter}" style="ime-mode:disabled" size="30"></td>
        </tr>
        <tr>
            <th>初入金時追加<br>パラメータ(任意)</th>
            <td><input type="text" name="first_payment_parameter" value="{$param.first_payment_parameter}" style="ime-mode:disabled" size="30"></td>
        </tr>
        <tr>
            <th>入金時追加<br>パラメータ(任意  ※ソケット通信のみ)</th>
            <td><input type="text" name="payment_parameter" value="{$param.payment_parameter}" style="ime-mode:disabled" size="30"></td>
        </tr>
        <tr>
            <th>送信変数または追加パラメータ<br>ユーザー情報変数：<br>メールアドレス => mail_address<br>メールアドレス(「.」を「_」に変換) => dot_address<br>個体識別番号 => mb_serial_number<br>広告コード => advcd<br>任意パラメータ => 値</th>
            <td>
                <input type="text" name="return_variable[]" value="{$param.return_variable[0]}" style="ime-mode:disabled" size="20"> = <input type="text" name="change_variable[]" value="{$param.change_variable[0]}" style="ime-mode:disabled" size="20"><br>
                <input type="text" name="return_variable[]" value="{$param.return_variable[1]}" style="ime-mode:disabled" size="20"> = <input type="text" name="change_variable[]" value="{$param.change_variable[1]}" style="ime-mode:disabled" size="20"><br>
                <input type="text" name="return_variable[]" value="{$param.return_variable[2]}" style="ime-mode:disabled" size="20"> = <input type="text" name="change_variable[]" value="{$param.change_variable[2]}" style="ime-mode:disabled" size="20"><br>
                <input type="text" name="return_variable[]" value="{$param.return_variable[3]}" style="ime-mode:disabled" size="20"> = <input type="text" name="change_variable[]" value="{$param.change_variable[3]}" style="ime-mode:disabled" size="20"><br>
                <input type="text" name="return_variable[]" value="{$param.return_variable[4]}" style="ime-mode:disabled" size="20"> = <input type="text" name="change_variable[]" value="{$param.change_variable[4]}" style="ime-mode:disabled" size="20">
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">
                <input type="submit" value="登　録" name="action_affiliate_AffiliateRegExec" onClick="return confirm('登録しますか？')">
            </td>
        </tr>
    </table>
</form>
</div>
<br>
{if $affiliateList}
    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">
    <tr>
    <th nowrap="nowrap">ID</th>
    <th nowrap="nowrap">広告コード</th>
    <th>サイト名</th>
    <th>戻し先URL</th>
    <th nowrap="nowrap">登録ステータス</th>
    <th nowrap="nowrap">送信設定</th>
    <th nowrap="nowrap">送信種別</th>
    <th nowrap="nowrap">発行種別</th>
    <th nowrap="nowrap">成功時追加<br>パラメータ(任意)</th>
    <th nowrap="nowrap">失敗時追加<br>パラメータ(任意)</th>
    <th nowrap="nowrap">初入金時追加<br>パラメータ(任意)</th>
    <th nowrap="nowrap">入金時追加<br>パラメータ(任意)</th>
    <th nowrap="nowrap">送信変数<br>または追加パラメータ(任意)</th>
    <th>更新日時</th>
    <th>削除</th>
    </tr>
    {foreach from=$affiliateList item="val"}
        <tr>
        <td><a href="{make_link action="action_affiliate_AffiliateUpd" getTags="id="|cat:$val.id}">{$val.id}</a></td>
        <td>{$val.media_cd}</td>
        <td>{$val.site_name}</td>
        <td>{$val.path}</td>
        <td>{$isPreRegist[$val.is_pre_regist]}</td>
        <td>{$isSuccessOnly[$val.is_success_only]}</td>
        <td>{$sendType[$val.send_type]}</td>
        <td>{$connectType[$val.connect_type]}</td>
        <td>{$val.success_parameter}</td>
        <td>{$val.failure_parameter}</td>
        <td>{$val.first_payment_parameter}</td>
        <td>{$val.payment_parameter}</td>
        <td nowrap>
            {foreach from=$val.variable item="variable"}
                {$variable}<br>
            {/foreach}
        </td>
        <td>{$val.update_datetime}</td>
        <td>
            <form action="./" method="post" style="margin:2px 0px;">
                <input type="hidden" name="id" value="{$val.id}">
                <input type="hidden" name="disable" value="1">
                <input type="submit" name="action_affiliate_AffiliateRegExec" value="削除" onClick="return confirm('削除しますか?')">
            </form>
        </td>
        </tr>
    {/foreach}
    </table>
{else}
    <div class="warning ui-widget">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    <p>
    <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    該当データはありません
    </p>
    </div>
{/if}
{include file=$admFooter}
</div>
<br>
<br>
</body>
</html>