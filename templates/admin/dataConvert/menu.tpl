{include file=$admHeader}
</head>
<body>
<div class="BlockCol">
    <h2 class="ContentTitle">データコンバートメニュー</h2>
    <table>
        <tr>
            <td style="padding:5px">
                <form action="./" method="POST" target="_blank">
                    <input type="submit" name="action_dataConvert_UserConvert" value="ユーザーデータコンバート" onclick="return confirm('ユーザーデータコンバートしますか？')">
                </form>
            </td>
            <td style="padding:5px">
                <form action="./" method="POST" target="_blank">
                    <input type="submit" name="action_dataConvert_ProfileConvert" value="プロフィールデータコンバート" onclick="return confirm('プロフィールデータコンバートしますか？')">
                </form>
            </td>
            <td style="padding:5px">
                <form action="./" method="POST" target="_blank">
                    <input type="submit" name="action_dataConvert_OrderingConvert" value="注文データコンバート" onclick="return confirm('注文データコンバートしますか？')">
                </form>
            </td>
            <td style="padding:5px">
                <form action="./" method="POST" target="_blank">
                    <input type="submit" name="action_dataConvert_OrderingDetailConvert" value="注文詳細データコンバート" onclick="return confirm('注文詳細データコンバートしますか？')">
                </form>
            </td>
            <td style="padding:5px">
                <form action="./" method="POST" target="_blank">
                    <input type="submit" name="action_dataConvert_UnitConvert" value="ユニットデータコンバート" onclick="return confirm('ユニットデータコンバートしますか？')">
                </form>
            </td>
            <td style="padding:5px">
                <form action="./" method="POST" target="_blank">
                    <input type="submit" name="action_dataConvert_BaitaiConvert" value="集計関連データコンバート" onclick="return confirm('集計関連データコンバートしますか？')">
                </form>
            </td>
        </tr>
        <tr>
            <td style="padding:5px">
                <form action="./" method="POST" target="_blank">
                    <input type="submit" name="action_dataConvert_TestAddressConvert" value="登録テストアドレスデータコンバート" onclick="return confirm('登録テストアドレスデータコンバートしますか？')">
                </form>
            </td>
            <td style="padding:5px">
                <form action="./" method="POST" target="_blank">
                    <input type="submit" name="action_dataConvert_itemConvert" value="商品データコンバート" onclick="return confirm('商品テストデータコンバートしますか？')">
                </form>
            </td>
            <td style="padding:5px">
                <form action="./" method="POST" target="_blank">
                    <input type="submit" name="action_dataConvert_OrderingLogConvert" value="各種注文ログデータコンバート" onclick="return confirm('各種注文ログデータコンバートしますか？')">
                </form>
            </td>
            <td style="padding:5px">
                <form action="./" method="POST" target="_blank">
                    <input type="submit" name="action_dataConvert_MailLogConvert" value="メール系データコンバート" onclick="return confirm('メール系データコンバートしますか？')">
                </form>
            </td>
            <td style="padding:5px">
                <form action="./" method="POST" target="_blank">
                    <input type="submit" name="action_dataConvert_TaikaiConvert" value="退会予約データコンバート" onclick="return confirm('退会予約データコンバートしますか？')">
                </form>
            </td>
            <td style="padding:5px">
                <form action="./" method="POST" target="_blank">
                    <input type="submit" name="action_dataConvert_InfoMailConvert" value="インフォメールデータコンバート" onclick="return confirm('インフォメールデータコンバートしますか？')">
                </form>
            </td>
        </tr>
        <tr>
            <td style="padding:5px">
                <form action="./" method="POST" target="_blank">
                    <input type="submit" name="action_dataConvert_AdminConvert" value="管理ユーザーデータコンバート" onclick="return confirm('管理ユーザーデータコンバートしますか？')">
                </form>
            </td>
            <td style="padding:5px">
                <form action="./" method="POST" target="_blank">
                    <input type="submit" name="action_dataConvert_PreRegistConvert" value="仮登録データコンバート" onclick="return confirm('仮登録データコンバートしますか？')">
                </form>
            </td>
            <td style="padding:5px">
                <form action="./" method="POST" target="_blank">
                    <input type="submit" name="action_dataConvert_PointLogConvert" value="ポイントログデータコンバート" onclick="return confirm('ポイントログデータコンバートしますか？')">
                </form>
            </td>
        </tr>

    </table>
{include file=$admFooter}
</div>
</body>
</html>
