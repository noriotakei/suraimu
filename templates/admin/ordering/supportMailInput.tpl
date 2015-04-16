{include file=$admHeader}
</head>
<body>
<div class="BlockCol">
    <h2 class="ContentTitle">サポートメール作成</h2>
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
        {$POSTparam}
        <input type="submit" name="action_ordering_OrderingData" value="注文詳細へ戻る" style="width:8em;"/>
    </form>
    <br>
    {if $mailElements}
        <div>
            <a href="{make_link action="action_keyConvert_DispKeyConvertList" getTags=$getTag}" target="_blank">システム変換管理</a>
        </div>
        {if $supportMailList}
            <br>
            <form action="./" method="post">
                {$POSTparam}
                {html_options name="support_mail_id" options=$supportMailList}
                <input type="submit" name="action_ordering_SupportMailInput" value="サポートメール定型文を呼び出す"/>
            </form>
        {/if}
        <form action="./" method="post">
            {$POSTparam}
            <br><br>
            <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet04">
                <tr>
                    <th colspan="2" style="text-align:center;">サポートメール作成</th>
                </tr>
                <tr>
                    <th>送信元アドレス</th>
                    <td style="text-align: left;">
                        <input type="text" name="from_address" value="{$mailElements.from_address|default:$sendAddress}" size="50" style="ime-mode: disabled;">
                    </td>
                </tr>
                <tr>
                    <th>送信者名</th>
                    <td style="text-align: left;">
                        <input type="text" name="from_name" value="{$mailElements.from_name}" size="50">
                        <br><span style="color:#FF0000;">※iPhoneに送信する場合、「&lt;&gt;」、「【】」、「≪≫」、「半角カタカナ」を含むと送信者名が「不明」または「文字化け」の原因になります。
                    </td>
                </tr>
                <tr>
                    <th>送信先アドレス</th>
                    <td style="text-align: left;">
                        {if "pc_address"|in_array:$displayUserDetail}
                        PC:{$userData.pc_address}
                        {/if}
                        {if "pc_address_no_domain"|in_array:$displayUserDetail}
                        PC(ドメインなし):{$userData.pc_address_no_domain}
                        {/if}
                        <br>
                        {if "mb_address"|in_array:$displayUserDetail}
                        MB:{$userData.mb_address}
                        {/if}
                        {if "mb_address_no_domain"|in_array:$displayUserDetail}
                        MB(ドメインなし):{$userData.mb_address_no_domain}
                        {/if}
                    </td>
                </tr>
                <tr>
                    <th>PC件名</th>
                    <td style="text-align: left;">
                        <input type="text" name="pc_subject" value="{$mailElements.pc_subject}" size="50">
                    </td>
                </tr>
                <tr>
                    <th>PCTEXT本文</th>
                    <td style="text-align: left;">
                        <textarea name="pc_text_body" cols="100" rows="30" id="pc_text_body" wrap="off">{$mailElements.pc_text_body}</textarea>
                    </td>
                </tr>
                <tr>
                    <th>MB件名</th>
                    <td style="text-align: left;">
                        <input type="text" name="mb_subject" value="{$mailElements.mb_subject}" size="50">
                    </td>
                </tr>
                <tr>
                    <th>MBTEXT本文</th>
                    <td style="text-align: left;">
                        <textarea name="mb_text_body" cols="100" rows="30" id="mb_text_body" wrap="off">{$mailElements.mb_text_body}</textarea>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center;" colspan="2">
                        <input type="submit" id="submit" name="action_ordering_SupportMailSendExec" value="送 信"  onclick="return confirm('送信しますか？')" style="width:8em; margin-left: 30px;"/>
                        {*&nbsp;&nbsp;&nbsp;<input type="submit" id="submit" name="action_ordering_TestSupportMailSendExec" value="TEST送 信"  onclick="return confirm('SMTP送信しますか？')" style="width:8em; margin-left: 30px;"/>*}
                    </td>
                </tr>
            </table>
        </form>
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
</body>
</html>
