{include file=$admHeader}
</head>

<body>
<div id="MenuCol">
<div id="HeadCol">
    <a href="./" target="_top">{html_image file="./img/sitelogo.gif" border="0" width="220"}</a>
</div>
<div>
    管理ユーザー名：{$loginAdminData.name}
</div>
<br>

<h3 class="MenuH3">ユーザー管理</h3>
<ul class="MenuBox">

    <li><a href="{make_link action="action_user_Search" getTags=$getTag}" target="contents">ユーザー検索</a></li>
    <li><a href="{make_link action="action_user_Create" getTags=$getTag}" target="contents">ユーザー作成</a></li>
    {* 集計以外*}
    {if !($loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SHUKEI)}
        <li><a href="{make_link action="action_user_RegistTestAddressDelForm" getTags=$getTag}" target="contents">テストユーザー削除フォーム</a></li>
        <li><a href="{make_link action="action_user_SearchConditionList" getTags=$getTag}" target="contents">検索条件保存リスト</a></li>
        <li><a href="{make_link action="action_user_SearchConditionCategoryList" getTags=$getTag}" target="contents">検索条件保存カテゴリー設定</a></li>
        <li><a href="{make_link action="action_user_UserProfileFlagList" getTags=$getTag}" target="contents">フラグコードの名前を編集</a></li>
        {* 広告以外*}
        {if !($loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_ADVERTISING)}
            <li><a href="./Information/Information.php{$infoParamURL}" target="_blank">問い合わせ</a></li>
        {/if}
    {/if}
</ul>
{* 広告 集計以外*}
{if !($loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_ADVERTISING
    OR $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SHUKEI)}
    <h3 class="MenuH3">注文管理</h3>
    <ul class="MenuBox">
        <li><a href="{make_link action="action_ordering_OrderingSearchList" getTags=$getTag}" target="contents">注文管理</a></li>
        <li><a href="{make_link action="action_ordering_OrderingChangeLogList" getTags=$getTag}" target="contents">注文変更ログ</a></li>
        <li><a href="{make_link action="action_ordering_SupportMailSendLogList" getTags=$getTag}" target="contents">サポートメール配信確認</a></li>
        <li><a href="{make_link action="action_ordering_ReserveSupportMailList" getTags=$getTag}" target="contents">サポートメール予約配信確認</a></li>
        <li><a href="{make_link action="action_ordering_RegularSupportMailList" getTags=$getTag}" target="contents">サポートメール定期配信確認</a></li>
        <li><a href="{make_link action="action_ordering_SupportMailList" getTags=$getTag}" target="contents">サポートメール定型文設定</a></li>
        <li><a href="{make_link action="action_ordering_OrderingDisplaySetting" getTags=$getTag}" target="contents">予約注文表示場所設定</a></li>
    </ul>
{/if}

<h3 class="MenuH3">集計管理</h3>
<ul class="MenuBox">
    {* 集計以外*}
    {if !($loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SHUKEI)}
        <li><a href="{make_link action="action_senchaCount_Calculation" getTags=$getTag}" target="contents">一般集計</a></li>
        <li><a href="{make_link action="action_count_Calculation" getTags=$getTag}" target="contents">旧一般集計</a></li>
    {/if}
{*    <li><a href="{make_link action="action_count_MediaCdRegist" getTags=$getTag}" target="contents">広告コード登録</a></li> *}
    <li><a href="{make_link action="action_baitai_Index" getTags=$getTag}" target="_blank">媒体CHK</a></li>
    {* 管理者 システム用メニュー
    {if $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SYSTEM
        OR $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_MANAGE}
        <li><a href="http://dio.fraise.jp/" target="_blank">Dio(アクセス解析)</a></li>
        <li><a href="http://delyzer.fraise.jp/" target="_blank">Trish(売上集計)</a></li>
    {/if}
    *}
</ul>

{* 広告 集計以外*}
{if !($loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_ADVERTISING
    OR $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SHUKEI)}
    <h3 class="MenuH3">メルマガ管理</h3>
    <ul class="MenuBox">
        <li><a href="{make_link action="action_user_Search" getTags=$getTag}" target="contents">ユーザー検索</a></li>
        <li><a href="{make_link action="action_mailLog_MailLogList" getTags=$getTag}" target="contents">配信履歴</a></li>
        <li><a href="{make_link action="action_mailLog_MailLogGroupList" getTags=$getTag}" target="contents">定期メルマガID毎配信履歴</a></li>
        <li><a href="{make_link action="action_mailLog_ReserveMailList" getTags=$getTag}" target="contents">予約配信確認</a></li>
        <li><a href="{make_link action="action_mailLog_RegularMailList" getTags=$getTag}" target="contents">定期配信確認</a></li>
        <li><a href="{make_link action="action_mailLog_ReservePointGrantList" getTags=$getTag}" target="contents">予約ばらまきの一覧</a></li>
        <!--
            <li><a href="http://p-send.com/" target="_blank">配信状況確認(通常)</a></li>
            <li><a href="http://p-send.com/" target="_blank">配信状況確認(反転)</a></li>
         -->
         <li><a href="http://p-send.com/" target="_blank">配信状況確認</a></li>
         <li>
             <a href="http://u0182.acemail.jp" target="_blank">配信状況確認(ACE)</a><br>
            ID:administrator  PASS:L16zaSHwhC
         </li>
         <li>
             <a href="http://sv58-2.mngsystem.com/user/" target="_blank">配信状況確認(セレナーデ)</a><br>
           　ID sv58-2  <br>PASS Pof9kGd7jrS
         </li>
    </ul>
{/if}
{* 広告 集計以外*}
{if !($loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_ADVERTISING
    OR $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SHUKEI)}
<h3 class="MenuH3">商品管理</h3>
<ul class="MenuBox">
    <li><a href="{make_link action="action_itemManagement_ItemList" getTags=$getTag}" target="contents">商品一覧</a></li>
    <li><a href="{make_link action="action_itemManagement_ItemCreate" getTags=$getTag}" target="contents">商品登録</a></li>
    <li><a href="{make_link action="action_itemManagement_ItemMonthlyCreate" getTags=$getTag}" target="contents">月額更新用商品登録</a></li>
    <li><a href="{make_link action="action_itemManagement_ItemCategoryList" getTags=$getTag}" target="contents">カテゴリー設定</a></li>
</ul>
{/if}
{* 広告 集計以外*}
{if !($loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_ADVERTISING
    OR $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SHUKEI)}
<h3 class="MenuH3">情報管理</h3>
<ul class="MenuBox">
    <li><a href="{make_link action="action_informationStatus_InformationSearchList" getTags=$getTag}" target="contents">情報一覧</a></li>
    <li><a href="{make_link action="action_informationStatus_InformationCreate" getTags=$getTag}" target="contents">情報登録</a></li>
    <li><a href="{make_link action="action_informationDisplayPosition_InformationCategoryList" getTags=$getTag}" target="contents">フォルダ設定</a></li>
    <li><a href="{make_link action="action_informationDisplayPosition_InformationDisplayPositionList" getTags=$getTag}" target="contents">表示場所一覧</a></li>
    <li><a href="{make_link action="action_informationTemplate_InformationTemplateList" getTags=$getTag}" target="contents">情報定型文設定</a></li>
</ul>
{/if}
{* 広告 集計以外*}
{if !($loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_ADVERTISING
    OR $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SHUKEI)}
<h3 class="MenuH3">情報リスト管理</h3>
<ul class="MenuBox">
    <li><a href="{make_link action="action_informationListManagement_InformationListGroup" getTags=$getTag}" target="contents">情報リスト設定</a></li>
</ul>
{/if}
{* 広告 集計以外*}
{if !($loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_ADVERTISING
    OR $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SHUKEI)}
<h3 class="MenuH3">月額コース管理</h3>
<ul class="MenuBox">
    <li><a href="{make_link action="action_MonthlyCourse_CourseUserSearchList" getTags=$getTag}" target="contents">月額コースユーザー一覧</a></li>
    <li><a href="{make_link action="action_MonthlyCourse_CourseSearchList" getTags=$getTag}" target="contents">月額コース一覧</a></li>
    <li><a href="{make_link action="action_MonthlyCourse_CourseCreate" getTags=$getTag}" target="contents">月額コース登録</a></li>
    <li><a href="{make_link action="action_MonthlyCourse_GroupList" getTags=$getTag}" target="contents">グループ設定</a></li>
</ul>
{/if}
{* 広告 集計以外*}
{if !($loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_ADVERTISING
    OR $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SHUKEI)}
<h3 class="MenuH3">ユニット管理</h3>
<ul class="MenuBox">
    <li><a href="{make_link action="action_unit_List" getTags=$getTag}" target="contents">ユニット一覧</a></li>
    <li><a href="{make_link action="action_lotteryUnit_List" getTags=$getTag}" target="contents">抽選ユニット一覧</a></li>
</ul>
{/if}
{* 集計以外*}
{if !($loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SHUKEI)}
<h3 class="MenuH3">画像管理</h3>
<ul class="MenuBox">
        {* 広告以外*}
        {if $loginAdminData.authority_type != $config.define.AUTHORITY_TYPE_ADVERTISING}
            <li><a href="{make_link action="action_image_List" getTags=$getTag}" target="contents">画像データ管理</a></li>
            <li><a href="{make_link action="action_image_ImageCategoryList" getTags=$getTag}" target="contents">画像データカテゴリー管理</a></li>
        {/if}
        <li><a href="{make_link action="action_banner_List" getTags=$getTag}" target="contents">バナー画像管理</a></li>
        <li><a href="{make_link action="action_banner_BannerImageCategoryList" getTags=$getTag}" target="contents">バナー画像カテゴリー管理</a></li>
</ul>
{/if}
{*　集計以外*}
{if !($loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SHUKEI)}
<h3 class="MenuH3">登録ページ管理</h3>
<ul class="MenuBox">
    {* 広告以外*}
    {if $loginAdminData.authority_type != $config.define.AUTHORITY_TYPE_ADVERTISING}
        <li><a href="{make_link action="action_registPage_RegistPageSearchList" getTags=$getTag}" target="contents">登録ページ一覧</a></li>
        <li><a href="{make_link action="action_registPage_RegistPageCategoryList" getTags=$getTag}" target="contents">登録ページカテゴリー設定</a></li>
    {/if}
    <li><a href="{make_link action="action_registPage_DispRegistPageList" getTags=$getTag}" target="contents">登録ページ一覧表示</a></li>
</ul>
{/if}
{* 集計以外*}
{if $loginAdminData.authority_type != $config.define.AUTHORITY_TYPE_SHUKEI}
<h3 class="MenuH3">テストアドレス管理</h3>
<ul class="MenuBox">
    <li><a href="{make_link action="action_testAddress_RegistTestAddressList" getTags=$getTag}" target="contents">テストアドレス一覧</a></li>
    <li><a href="{make_link action="action_testAddress_RegistTestAddressCategoryList" getTags=$getTag}" target="contents">テストアドレスカテゴリー設定</a></li>
</ul>
{/if}
{* 集計以外*}
{if !($loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SHUKEI)}
<h3 class="MenuH3">その他</h3>
<ul class="MenuBox">
    <li><a href="{make_link action="action_affiliate_AffiliateList" getTags=$getTag}" target="contents">登録時発行タグ設定</a></li>
    <li><a href="{make_link action="action_affiliate16_AffiliateList16" getTags=$getTag}" target="contents">登録時発行タグ設定(16桁用)</a></li>
    {* 広告 集計以外*}
    {if !($loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_ADVERTISING
        OR $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SHUKEI)}
        <li><a href="{make_link action="action_siteContents_SiteContentsList" getTags=$getTag}" target="contents">サイト表示内容設定</a></li>
        <li><a href="{make_link action="action_autoMail_AutoMailSettingList" getTags=$getTag}" target="contents">リメール文設定</a></li>
        <li><a href="{make_link action="action_autoMail_AutoMailContentsList" getTags=$getTag}" target="contents">リメールコンテンツ設定</a></li>
        <li><a href="{make_link action="action_keyConvert_KeyConvertCategoryList" getTags=$getTag}" target="contents">システム変換管理カテゴリ設定</a></li>
        <li><a href="{make_link action="action_keyConvert_KeyConvertList" getTags=$getTag}" target="contents">システム変換管理</a></li>

    {/if}
    {* 管理者 システム用メニュー *}
    {if $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SYSTEM
        OR $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_MANAGE}
        <li><a href="{make_link action="action_maintenance_Maintenance" getTags=$getTag}" target="contents">メンテナンス</a></li>
        <li><a href="{make_link action="action_adminUser_AdminUserList" getTags=$getTag}" target="contents">管理者一覧</a></li>
        <li><a href="{make_link action="action_adminUser_AdminUserAccessLog" getTags=$getTag}" target="contents">管理者アクセスログ</a></li>
        <li><a href="{make_link action="action_baitai_BaitaiUserList" getTags=$getTag}" target="contents">媒体CHK管理者一覧</a></li>
        <li><a href="{make_link action="action_information_InformationOperatorList" getTags=$getTag}" target="contents">問い合わせ対応者一覧</a></li>
        <li><a href="{make_link action="action_user_registCsv" getTags=$getTag}" target="contents">CSVｱｯﾌﾟﾛｰﾄﾞ登録</a></li>
    {/if}
    {* システム用メニュー *}
    {if $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SYSTEM}
        {* <li><a href="{make_link action="action_dataConvert_Menu" getTags=$getTag}" target="contents">データコンバートメニュー</a></li>*}
        <li><a href="{make_link action="action_log_LogDeleteSetList" getTags=$getTag}" target="contents">ログ消し設定</a></li>
        <li><a href="{make_link action="action_registSite_RegistSiteList" getTags=$getTag}" target="contents">サイト間登録サイト設定</a></li>
        <li><a href="./Terminal/phpMinAdmin.php?server={$config.define.DATABASE.params.host}" target="_blank">Adminer</a>
    {/if}
    <li><a href="{make_link action="action_freeWord_FreeWordList" getTags=$getTag}" target="contents">フリーワード設定</a></li>
    {* システム用メニュー *}
    {if $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SYSTEM}
        <li><a href="{make_link action="action_log_PaymentLogFileList" getTags=$getTag}" target="contents">決済ﾛｸﾞﾌｧｲﾙ確認</a></li>
    {/if}
    {* 広告 集計以外*}
    {if !($loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_ADVERTISING
        OR $loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SHUKEI)}
    <li><a href="http://www.nttdocomo.co.jp/service/imode/make/content/pictograph/tool/index.html" target="_blank">絵文字ダウンロード</a>
    <br>・絵文字入力はコチラのソフトをインストールしてください</li>
    <li><a href="http://kokogiko.s3.amazonaws.com/pict/pictgram_convert.html#docomo" target="_blank">絵文字対応表</a>
    {/if}
</ul>
{/if}
{* 集計以外*}
{if !($loginAdminData.authority_type == $config.define.AUTHORITY_TYPE_SHUKEI)}
<h3 class="MenuH3">代理店媒体集計管理</h3>
<ul class="MenuBox">
    <li><a href="{$config.define.BAITAI_AGENCY_URL}?action_Index=1{$agencyParamURL}" target="_blank">代理店用媒体CHK</a></li>
    <li><a href="{make_link action="action_baitaiAgency_BaitaiAgencyList" getTags=$getTag}" target="contents">代理店管理</a></li>
    <li><a href="{make_link action="action_baitaiAgency_BaitaiAgencyAdminUserList" getTags=$getTag}" target="contents">代理店媒体CHK管理者一覧</a></li>
</ul>
{/if}

<p id="Logout"><a href="{make_link action="action_Logout" getTags=$getTag}" target="_top">Logout</a></p>
</div>

</body>
</html>
