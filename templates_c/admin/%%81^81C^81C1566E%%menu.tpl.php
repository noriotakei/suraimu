<?php /* Smarty version 2.6.26, created on 2015-01-13 18:24:53
         compiled from /home/suraimu/templates/admin/menu.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_image', '/home/suraimu/templates/admin/menu.tpl', 7, false),array('function', 'make_link', '/home/suraimu/templates/admin/menu.tpl', 17, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</head>

<body>
<div id="MenuCol">
<div id="HeadCol">
    <a href="./" target="_top"><?php echo smarty_function_html_image(array('file' => "./img/sitelogo.gif",'border' => '0','width' => '220'), $this);?>
</a>
</div>
<div>
    管理ユーザー名：<?php echo $this->_tpl_vars['loginAdminData']['name']; ?>

</div>
<br>

<h3 class="MenuH3">ユーザー管理</h3>
<ul class="MenuBox">

    <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_user_Search','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">ユーザー検索</a></li>
    <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_user_Create','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">ユーザー作成</a></li>
        <?php if (! ( $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SHUKEI'] )): ?>
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_user_RegistTestAddressDelForm','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">テストユーザー削除フォーム</a></li>
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_user_SearchConditionList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">検索条件保存リスト</a></li>
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_user_SearchConditionCategoryList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">検索条件保存カテゴリー設定</a></li>
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_user_UserProfileFlagList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">フラグコードの名前を編集</a></li>
                <?php if (! ( $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_ADVERTISING'] )): ?>
            <li><a href="./Information/Information.php<?php echo $this->_tpl_vars['infoParamURL']; ?>
" target="_blank">問い合わせ</a></li>
        <?php endif; ?>
    <?php endif; ?>
</ul>
<?php if (! ( $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_ADVERTISING'] || $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SHUKEI'] )): ?>
    <h3 class="MenuH3">注文管理</h3>
    <ul class="MenuBox">
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_ordering_OrderingSearchList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">注文管理</a></li>
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_ordering_OrderingChangeLogList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">注文変更ログ</a></li>
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_ordering_SupportMailSendLogList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">サポートメール配信確認</a></li>
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_ordering_ReserveSupportMailList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">サポートメール予約配信確認</a></li>
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_ordering_RegularSupportMailList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">サポートメール定期配信確認</a></li>
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_ordering_SupportMailList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">サポートメール定型文設定</a></li>
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_ordering_OrderingDisplaySetting','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">予約注文表示場所設定</a></li>
    </ul>
<?php endif; ?>

<h3 class="MenuH3">集計管理</h3>
<ul class="MenuBox">
        <?php if (! ( $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SHUKEI'] )): ?>
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_senchaCount_Calculation','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">一般集計</a></li>
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_count_Calculation','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">旧一般集計</a></li>
    <?php endif; ?>
    <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_baitai_Index','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="_blank">媒体CHK</a></li>
    </ul>

<?php if (! ( $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_ADVERTISING'] || $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SHUKEI'] )): ?>
    <h3 class="MenuH3">メルマガ管理</h3>
    <ul class="MenuBox">
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_user_Search','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">ユーザー検索</a></li>
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_mailLog_MailLogList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">配信履歴</a></li>
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_mailLog_MailLogGroupList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">定期メルマガID毎配信履歴</a></li>
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_mailLog_ReserveMailList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">予約配信確認</a></li>
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_mailLog_RegularMailList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">定期配信確認</a></li>
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_mailLog_ReservePointGrantList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">予約ばらまきの一覧</a></li>
        <!--
            <li><a href="http://p-send.com/" target="_blank">配信状況確認(通常)</a></li>
            <li><a href="http://p-send.com/" target="_blank">配信状況確認(反転)</a></li>
         -->
         <li><a href="http://p-send.com/" target="_blank">配信状況確認</a></li>
    </ul>
<?php endif; ?>
<?php if (! ( $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_ADVERTISING'] || $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SHUKEI'] )): ?>
<h3 class="MenuH3">商品管理</h3>
<ul class="MenuBox">
    <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_itemManagement_ItemList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">商品一覧</a></li>
    <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_itemManagement_ItemCreate','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">商品登録</a></li>
    <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_itemManagement_ItemMonthlyCreate','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">月額更新用商品登録</a></li>
    <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_itemManagement_ItemCategoryList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">カテゴリー設定</a></li>
</ul>
<?php endif; ?>
<?php if (! ( $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_ADVERTISING'] || $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SHUKEI'] )): ?>
<h3 class="MenuH3">情報管理</h3>
<ul class="MenuBox">
    <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_informationStatus_InformationSearchList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">情報一覧</a></li>
    <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_informationStatus_InformationCreate','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">情報登録</a></li>
    <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_informationDisplayPosition_InformationCategoryList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">フォルダ設定</a></li>
    <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_informationDisplayPosition_InformationDisplayPositionList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">表示場所一覧</a></li>
    <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_informationTemplate_InformationTemplateList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">情報定型文設定</a></li>
</ul>
<?php endif; ?>
<?php if (! ( $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_ADVERTISING'] || $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SHUKEI'] )): ?>
<h3 class="MenuH3">情報リスト管理</h3>
<ul class="MenuBox">
    <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_informationListManagement_InformationListGroup','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">情報リスト設定</a></li>
</ul>
<?php endif; ?>
<?php if (! ( $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_ADVERTISING'] || $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SHUKEI'] )): ?>
<h3 class="MenuH3">月額コース管理</h3>
<ul class="MenuBox">
    <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_MonthlyCourse_CourseUserSearchList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">月額コースユーザー一覧</a></li>
    <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_MonthlyCourse_CourseSearchList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">月額コース一覧</a></li>
    <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_MonthlyCourse_CourseCreate','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">月額コース登録</a></li>
    <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_MonthlyCourse_GroupList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">グループ設定</a></li>
</ul>
<?php endif; ?>
<?php if (! ( $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_ADVERTISING'] || $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SHUKEI'] )): ?>
<h3 class="MenuH3">ユニット管理</h3>
<ul class="MenuBox">
    <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_unit_List','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">ユニット一覧</a></li>
    <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_lotteryUnit_List','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">抽選ユニット一覧</a></li>
</ul>
<?php endif; ?>
<?php if (! ( $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SHUKEI'] )): ?>
<h3 class="MenuH3">画像管理</h3>
<ul class="MenuBox">
                <?php if ($this->_tpl_vars['loginAdminData']['authority_type'] != $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_ADVERTISING']): ?>
            <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_image_List','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">画像データ管理</a></li>
            <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_image_ImageCategoryList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">画像データカテゴリー管理</a></li>
        <?php endif; ?>
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_banner_List','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">バナー画像管理</a></li>
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_banner_BannerImageCategoryList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">バナー画像カテゴリー管理</a></li>
</ul>
<?php endif; ?>
<?php if (! ( $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SHUKEI'] )): ?>
<h3 class="MenuH3">登録ページ管理</h3>
<ul class="MenuBox">
        <?php if ($this->_tpl_vars['loginAdminData']['authority_type'] != $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_ADVERTISING']): ?>
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_registPage_RegistPageSearchList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">登録ページ一覧</a></li>
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_registPage_RegistPageCategoryList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">登録ページカテゴリー設定</a></li>
    <?php endif; ?>
    <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_registPage_DispRegistPageList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">登録ページ一覧表示</a></li>
</ul>
<?php endif; ?>
<?php if ($this->_tpl_vars['loginAdminData']['authority_type'] != $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SHUKEI']): ?>
<h3 class="MenuH3">テストアドレス管理</h3>
<ul class="MenuBox">
    <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_testAddress_RegistTestAddressList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">テストアドレス一覧</a></li>
    <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_testAddress_RegistTestAddressCategoryList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">テストアドレスカテゴリー設定</a></li>
</ul>
<?php endif; ?>
<?php if (! ( $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SHUKEI'] )): ?>
<h3 class="MenuH3">その他</h3>
<ul class="MenuBox">
    <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_affiliate_AffiliateList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">登録時発行タグ設定</a></li>
    <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_affiliate16_AffiliateList16','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">登録時発行タグ設定(16桁用)</a></li>
        <?php if (! ( $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_ADVERTISING'] || $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SHUKEI'] )): ?>
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_siteContents_SiteContentsList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">サイト表示内容設定</a></li>
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_autoMail_AutoMailSettingList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">リメール文設定</a></li>
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_autoMail_AutoMailContentsList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">リメールコンテンツ設定</a></li>
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_keyConvert_KeyConvertCategoryList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">システム変換管理カテゴリ設定</a></li>
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_keyConvert_KeyConvertList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">システム変換管理</a></li>

    <?php endif; ?>
        <?php if ($this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SYSTEM'] || $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_MANAGE']): ?>
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_maintenance_Maintenance','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">メンテナンス</a></li>
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_adminUser_AdminUserList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">管理者一覧</a></li>
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_adminUser_AdminUserAccessLog','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">管理者アクセスログ</a></li>
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_baitai_BaitaiUserList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">媒体CHK管理者一覧</a></li>
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_information_InformationOperatorList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">問い合わせ対応者一覧</a></li>
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_user_registCsv','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">CSVｱｯﾌﾟﾛｰﾄﾞ登録</a></li>
    <?php endif; ?>
        <?php if ($this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SYSTEM']): ?>
                <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_log_LogDeleteSetList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">ログ消し設定</a></li>
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_registSite_RegistSiteList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">サイト間登録サイト設定</a></li>
        <li><a href="./Terminal/phpMinAdmin.php?server=<?php echo $this->_tpl_vars['config']['define']['DATABASE']['params']['host']; ?>
" target="_blank">Adminer</a>
    <?php endif; ?>
    <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_freeWord_FreeWordList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">フリーワード設定</a></li>
        <?php if ($this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SYSTEM']): ?>
        <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_log_PaymentLogFileList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">決済ﾛｸﾞﾌｧｲﾙ確認</a></li>
    <?php endif; ?>
        <?php if (! ( $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_ADVERTISING'] || $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SHUKEI'] )): ?>
    <li><a href="http://www.nttdocomo.co.jp/service/imode/make/content/pictograph/tool/index.html" target="_blank">絵文字ダウンロード</a>
    <br>・絵文字入力はコチラのソフトをインストールしてください</li>
    <li><a href="http://kokogiko.s3.amazonaws.com/pict/pictgram_convert.html#docomo" target="_blank">絵文字対応表</a>
    <?php endif; ?>
</ul>
<?php endif; ?>
<?php if (! ( $this->_tpl_vars['loginAdminData']['authority_type'] == $this->_tpl_vars['config']['define']['AUTHORITY_TYPE_SHUKEI'] )): ?>
<h3 class="MenuH3">代理店媒体集計管理</h3>
<ul class="MenuBox">
    <li><a href="<?php echo $this->_tpl_vars['config']['define']['BAITAI_AGENCY_URL']; ?>
?action_Index=1<?php echo $this->_tpl_vars['agencyParamURL']; ?>
" target="_blank">代理店用媒体CHK</a></li>
    <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_baitaiAgency_BaitaiAgencyList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">代理店管理</a></li>
    <li><a href="<?php echo smarty_function_make_link(array('action' => 'action_baitaiAgency_BaitaiAgencyAdminUserList','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="contents">代理店媒体CHK管理者一覧</a></li>
</ul>
<?php endif; ?>

<p id="Logout"><a href="<?php echo smarty_function_make_link(array('action' => 'action_Logout','getTags' => $this->_tpl_vars['getTag']), $this);?>
" target="_top">Logout</a></p>
</div>

</body>
</html>