{include file=$admHeader}
<link type="text/css" href="./css/jquery_ui/jquery.timepickr.css" rel="stylesheet" />
<link type="text/css" href="./css/pager.css" rel="stylesheet" />

<script type="text/javascript">
<!--

    $(function() {ldelim}
        $('.selectText').click(function(){ldelim}
        $(this).select();
        {rdelim});

    {rdelim});

    function openSearchInput(selectId) {ldelim}

        var selectId = $(selectId);

        if (selectId.val() == 1 || selectId.val() == 2) {ldelim}
            $('#keyword').show("blind", "slow");
            $('#search_datetime').hide();
        {rdelim} else if (selectId.val() == 3 || selectId.val() == 4) {ldelim}
            $('#search_datetime').show("blind", "slow");
            $('#keyword').hide();
        {rdelim} else {ldelim}
            $('#search_datetime').hide("slow");
            $('#keyword').hide("slow");
        {rdelim}
    {rdelim}

//-->
</script>
</head>
<body>

<div id="ContentsCol">
    <h2 class="ContentTitle">商品カテゴリー更新画面</h2>
    {* 更新時エラーコメント *}
    {if $msg|@count}
        <div class="warning ui-widget">
        <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
        <p>
        <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
        { foreach from=$msg item="val" }
            {$val|@implode:"<br>"}
        {/foreach}
        </p>
        </div>
        </div>
    {/if}
    <form action="./" method="post">
        <div class="SubMenu">
            <input type="submit" name="action_itemManagement_itemCategoryList" value="一覧に戻る" />
        </div>
    </form>
    <form action="./" method="post" enctype="multipart/form-data">
    {$POSTparam}
        <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">
            <tr>
                <th>管理用商品名</th>
                <td style="text-align: left;">
                    <input type="text" name="name" value="{$param.name}" size="50">
                </td>
                <td style="text-align: center;">必須</td>
            </tr>
            <tr>
                <th>表示切り替え</th>
                <td style="text-align: left;">{html_options name="is_display" options=$isDisplay selected=$param.is_display|default:1}</td>
            </tr>
            <tr>
                <th>表示優先度</th>
                <td style="text-align: left;">
                    <input type="text" name="sort_seq" value="{$param.sort_seq|default:0}" size="10">
                </td>
                <td style="text-align: center;">任意</td>
            </tr>
            <tr>
                <th>カテゴリーグループ</th>
                <td style="text-align: left;">{html_options name="category_group_id" options=$categoryGroupSelect selected=$param.item_category_group_id|default:1}</td>
            </tr>
            <tr>
                <td colspan="3"  style="text-align:center;">
                    <div class="SubMenu">
                        <input type="submit" name="action_itemManagement_ItemCategoryExec" value="更新する" onClick="return confirm('更新しますか？')"/>
                    </div>
                </td>
            </tr>
        </table>
    </form>
{include file=$admFooter}
</div>
</body>
</html>