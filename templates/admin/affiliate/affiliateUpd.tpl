{include file=$admHeader}
<script type="text/javascript" src="./js/watermark/jquery.watermark.min.js"></script>
<script language="JavaScript">
<!--

    $(function() {ldelim}

        if ($("input[name='send_type']:checked").val() == 0) {ldelim}
            $("#connect_type_1").attr('disabled', 'disabled');
        {rdelim};

        if ($("input[name='is_pre_regist']:checked").val() == 0) {ldelim}
                 $("input[name='connect_type']").val(['0']);
                 $('#connect_type_1').attr('disabled', 'disabled');
                 $("input[name='send_type']").val(['1']);
                 $('#send_type_0').attr('disabled', 'disabled');
        {rdelim};

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
<h2 class="ContentTitle">登録時発行タグ更新</h2>
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
    <br>
{/if}
<form action="./" method="post">
    <input type="submit" name="action_affiliate_AffiliateList" value="一覧へ戻る" style="width:8em;"/>
</form>
<br>
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
            <th>戻し先URL(任意)</th>
            <td><input class="path" type="text" name="path" value="{$param.path}" style="ime-mode:disabled" size="40"></td>
        </tr>
        <tr>
            <th>登録ステータス</th>
            <td>{html_radios label_ids=true name="is_pre_regist" options=$isPreRegist selected=$param.is_pre_regist separator="&nbsp;"}</td>
        </tr>
        <tr>
            <th>送信設定</th>
            <td>{html_checkboxes name="is_success_only" options=$isSuccessOnly selected=$param.is_success_only separator="&nbsp;"}</td>
        </tr>
        <tr>
            <th>送信種別</th>
            <td>{html_radios label_ids=true name="send_type" options=$sendType selected=$param.send_type separator="&nbsp;"}</td>
        </tr>
        <tr>
            <th>発行種別<br>(本登録フローは<br>ソケット通信のみ)</th>
            <td>{html_radios label_ids=true name="connect_type" options=$connectType selected=$param.connect_type separator="&nbsp;"}</td>
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
                <input type="submit" value="更　新" name="action_affiliate_AffiliateRegExec" onClick="return confirm('更新しますか？')">
            </td>
        </tr>
    </table>
</form>
{include file=$admFooter}
</div>
</body>
</html>