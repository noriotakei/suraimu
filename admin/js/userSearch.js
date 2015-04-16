    $(function() {

        // 時刻入力
        $(".time").timepickr({
            format24: "{h:02.d}:{m:02.d}:{s:02.d}",
            seconds: true,
            rangeMin: ["00","05","10","15","20","25","30","35","40","45","50","55","59"],
            rangeSec: ["00","15","30","45","59"],
            convention: 24
        });

        // カレンダー
        $(".datepicker").datepicker({
            dateFormat: "yy-mm-dd"
        });

        // テーブルマウスオーバーカラー
        $('#src_table').colorize({
            altColor :'#CCCCCC',
            hiliteColor :'none'
        });

        $("#last_access_date").hide();
        $("#not_access_date").hide();
        $("#regist_date").hide();
        $("#pre_regist_date").hide();
        $("#last_buy_date").hide();
        $("#first_pay_date").hide();
        $("#use_point_date").hide();
        $("#terms_pay_date").hide();

        $("#last_access_time").hide();
        $("#not_access_time").hide();
        $("#regist_time").hide();
        $("#pre_regist_time").hide();
        $("#last_buy_time").hide();
        $("#first_pay_time").hide();
        $("#use_point_time").hide();
        $("#terms_pay_time").hide();

        $("#use_point_val").hide();
        $("#terms_pay_val").hide();
        $("#monthly_course_id").hide();
        $("#monthly_course_remainder_days").hide();
        $("#monthly_course_update_item").hide();

        var openDateIdAry = {
                            "input[name='specify_last_access']:checked": '#last_access_date'
                            ,"input[name='specify_not_access']:checked": '#not_access_date'
                            , "input[name='specify_regist']:checked": '#regist_date'
                            , "input[name='specify_pre_regist']:checked": '#pre_regist_date'
                            , "input[name='specify_last_buy']:checked": '#last_buy_date'
                            , "input[name='specify_first_pay']:checked": '#first_pay_date'
                            , "input[name='specify_use_point']:checked": '#use_point_date'
                            , "input[name='specify_terms_pay']:checked": '#terms_pay_date'
                        };

        var openTimeIdAry = {
                            "input[name='specify_last_access']:checked": '#last_access_time'
                            ,"input[name='specify_not_access']:checked": '#not_access_time'
                            , "input[name='specify_regist']:checked": '#regist_time'
                            , "input[name='specify_pre_regist']:checked": '#pre_regist_time'
                            , "input[name='specify_last_buy']:checked": '#last_buy_time'
                            , "input[name='specify_first_pay']:checked": '#first_pay_time'
                            , "input[name='specify_use_point']:checked": '#use_point_time'
                            , "input[name='specify_terms_pay']:checked": '#terms_pay_time'
                        };

        // 戻ったときに日時フォームが入力されていたら表示する
        for (var key in openDateIdAry) {
            openDateTimeInput(key, openDateIdAry[key], openTimeIdAry[key]);
        }


        // 日付指定のとき
        $('#last_access').live("click", function(env){
            if (env.button !== 0) return;
            openDateTimeInput("input[name='specify_last_access']:checked", "#last_access_date", "#last_access_time");
        });
        $('#not_access').live("click", function(env){
            if (env.button !== 0) return;
            openDateTimeInput("input[name='specify_not_access']:checked", "#not_access_date", "#not_access_time");
        });
        $('#regist').live("click", function(env){
            if (env.button !== 0) return;
            openDateTimeInput("input[name='specify_regist']:checked", "#regist_date", "#regist_time");
        });
        $('#pre_regist').live("click", function(env){
            if (env.button !== 0) return;
            openDateTimeInput("input[name='specify_pre_regist']:checked", "#pre_regist_date", "#pre_regist_time");
        });
        $('#last_buy').live("click", function(env){
            if (env.button !== 0) return;
            openDateTimeInput("input[name='specify_last_buy']:checked", "#last_buy_date", "#last_buy_time");
        });
        $('#first_pay').live("click", function(env){
            if (env.button !== 0) return;
            openDateTimeInput("input[name='specify_first_pay']:checked", "#first_pay_date", "#first_pay_time");
        });
        $('#use_point').live("click", function(env){
            if (env.button !== 0) return;
            openDateTimeInput("input[name='specify_use_point']:checked", "#use_point_date", "#use_point_time");
            openInput("input[name='specify_use_point']:checked", "#use_point_val");
        });
        $('#terms_pay').live("click", function(env){
            if (env.button !== 0) return;
            openDateTimeInput("input[name='specify_terms_pay']:checked", "#terms_pay_date", "#terms_pay_time");
            openInput("input[name='specify_terms_pay']:checked", "#terms_pay_val");
        });

        $("#pc_address").hide();
        $("#mb_address").hide();

        var openIdAry = {
                            "input[name='specify_use_point']:checked": '#use_point_val'
                            ,"input[name='specify_terms_pay']:checked": '#terms_pay_val'
                        };

        // 戻ったときにフォームが入力されていたら表示する
        for (var key in openIdAry) {
            openInput(key, openIdAry[key]);
        }

        var openAddressIdAry = {
                            "input[name='pc_specify_address']:checked": '#pc_address'
                            ,"input[name='mb_specify_address']:checked": '#mb_address'
                        };

        // 戻ったときにフォームが入力されていたら表示する
        for (var key in openAddressIdAry) {
            openAddressInput(key, openAddressIdAry[key]);
        }


        // PCメアド指定のとき
        $('#pc_specify_address').live("click", function(env){
            if (env.button !== 0) return;
            openAddressInput("input[name='pc_specify_address']:checked", "#pc_address");
        });

        // MBメアド指定のとき
        $('#mb_specify_address').live("click", function(env){
            if (env.button !== 0) return;
            openAddressInput("input[name='mb_specify_address']:checked", "#mb_address");
        });

        var openMonthlyCourseIdAry = {
                            "input[name='specify_monthly_course']:checked": '#monthly_course_remainder_days'
                        };

        var openMonthlyCourseUpdateItemIdAry = {
                "input[name='specify_monthly_update']:checked": '#monthly_course_update_item'
            };

        var openConvertTypeInputAry = {
                "input[name='specify_convert_type']:checked": '#specify_convert_type_input'
            };

        var openBirthDayInputAry = {
                "input[name='specify_birth_day']:checked": '#birth_day_date'
            };

        var openFreeWordInputAry = {
                "input[name='specify_free_word']:checked": '#free_word_data'
            };

        var openFreeWordSetInputAry = {
                "input[name='specify_free_word_set']:checked": '#free_word_data_set'
            };

        // 戻ったときにフォームが入力されていたら表示する
        for (var key in openMonthlyCourseIdAry) {
            openMonthlyCourseInput("input[name='specify_monthly_course']:checked", "#monthly_course_remainder_days");
        }
        for (var key in openMonthlyCourseUpdateItemIdAry) {
            openMonthlyCourseUpdateItemInput("input[name='specify_monthly_update']:checked", "#monthly_course_update_item");
        }
        for (var key in openConvertTypeInputAry) {
            openConvertTypeInput("input[name='specify_convert_type']:checked", "#specify_convert_type_input");
        }

        for (var key in openBirthDayInputAry) {
            openBirthDayInput("input[name='specify_birth_day']:checked", "#birth_day_date");
        }

        for (var key in openFreeWordInputAry) {
            openFreeWordInput("input[name='specify_free_word']:checked", "#free_word_data");
        }

        for (var key in openFreeWordSetInputAry) {
            openFreeWordSetInput("input[name='specify_free_word_set']:checked", "#free_word_data_set");
        }

        var openPhoneNumberIdAry = {
                            "input[name='specify_phone_number']:checked": '#phone_number'
                        };

        // 戻ったときにフォームが入力されていたら表示する
        for (var key in openPhoneNumberIdAry) {
            openPhoneNumberInput(key, openPhoneNumberIdAry[key]);
        }

        // PCメアド指定のとき
        $('#specify_phone_number').live("click", function(env){
            if (env.button !== 0) return;
            openPhoneNumberInput("input[name='specify_phone_number']:checked", "#phone_number");
        });

        // 保有月額コース指定の時
        $('#specify_monthly_course').live("click", function(env){
            if (env.button !== 0) return;
            openMonthlyCourseInput("input[name='specify_monthly_course']:checked", "#monthly_course_remainder_days");
        });

        // 月額更新商品ID指定の時
        $('#specify_monthly_update').live("click", function(env){
            if (env.button !== 0) return;
            openMonthlyCourseUpdateItemInput("input[name='specify_monthly_update']:checked", "#monthly_course_update_item");
        });

        // 競馬間コンバート指定の時
        $('#specify_convert_type').live("click", function(env){
            if (env.button !== 0) return;
            openConvertTypeInput("input[name='specify_convert_type']:checked", "#specify_convert_type_input");
        });

        // 生年月日指定の時
        $('#specify_birth_day').live("click", function(env){
            if (env.button !== 0) return;
            openBirthDayInput("input[name='specify_birth_day']:checked", "#birth_day_date");
        });

        // ﾌﾘｰﾜｰﾄﾞ指定の時
        $('#specify_free_word').live("click", function(env){
            if (env.button !== 0) return;
            openFreeWordInput("input[name='specify_free_word']:checked", "#free_word_data");
        });

        // ﾌﾘｰﾜｰﾄﾞ管理設定指定の時
        $('#specify_free_word_set').live("click", function(env){
            if (env.button !== 0) return;
            openFreeWordSetInput("input[name='specify_free_word_set']:checked", "#free_word_data_set");
        });

        // 追加フォーム
        $('#load_button').live("click", function(env){
            if (env.button !== 0) return;
            $("#add_form").toggle("blind", null, "slow");
        });

        // テーブルストライプ
        $("#src_table tr:even").addClass("BgColor02");

        // テキストボックス文字
        $('.from').watermark('小');
        $('.to').watermark('大');

    });

    // システムIP入力
    function easyInput(){
        document.userSearch.pc_ip_address.value = '{$config.define.SYSTEM_IP_ADDRESS}';
    };

    // 日付、時間入力フォーム表示
    function openDateTimeInput(selectId, openId, openTimeId) {

        var id = $(openId);
        var selectId = $(selectId);
        var timeId = $(openTimeId);

        if (selectId.val() == 1) {
            id.show("blind", "slow");
            timeId.hide("slow");
        } else if (selectId.val() == 7) {
            timeId.show("blind", "slow");
            id.hide("slow");
        } else {
            id.hide("slow");
            timeId.hide("slow");
        }

    }

    // 日付入力フォーム表示
    function openDateInput(selectId, openId) {

        var id = $(openId);
        var selectId = $(selectId);

        if (selectId.val() == 1) {
            id.show("blind", "slow");
        } else {
            id.hide("slow");
        }

    }

    // 入力フォーム表示
    function openInput(selectId, openId) {

        var id = $(openId);
        var selectId = $(selectId);
        if (selectId.val() > 0) {
            id.show("blind", "slow");
        } else {
            id.hide("slow");
        }
    }

    // 入力フォーム表示
    function openAddressInput(selectId, openId) {

        var id = $(openId);
        var selectId = $(selectId);
        if (selectId.val() > 0 && selectId.val() < 4) {
            id.show("blind", "slow");
        } else {
            id.hide("slow");
        }
    }

    // 月額コース入力フォーム表示
    function openMonthlyCourseInput(selectId, openId) {

        var id = $(openId);
        var selectId = $(selectId);

        if (selectId.val() == 2) {
            id.show("blind", "slow");
        } else {
            id.hide("slow");
        }
    }

    // 月額更新商品ID入力フォーム表示
    function openMonthlyCourseUpdateItemInput(selectId, openId) {

        var id = $(openId);
        var selectId = $(selectId);

        if (selectId.val() == 3) {
            id.show("blind", "slow");
        } else {
            id.hide("slow");
        }
    }

    // 競馬間コンバート入力フォーム表示
    function openConvertTypeInput(selectId, openId) {

        var id = $(openId);
        var selectId = $(selectId);

        if (selectId.val() == 2) {
            id.show("blind", "slow");
        } else {
            id.hide("slow");
        }
    }

    // 生年月日入力フォーム表示
    function openBirthDayInput(selectId, openId) {

        var id = $(openId);
        var selectId = $(selectId);

        if (selectId.val() == 3) {
            id.show("blind", "slow");
        } else {
            id.hide("slow");
        }
    }

    // ﾌﾘｰﾜｰﾄﾞ入力フォーム表示
    function openFreeWordInput(selectId, openId) {

        var id = $(openId);
        var selectId = $(selectId);

        if (selectId.val() == 1) {
            id.show("blind", "slow");
        } else {
            id.hide("slow");
        }
    }

    // ﾌﾘｰﾜｰﾄﾞ管理設定入力フォーム表示
    function openFreeWordSetInput(selectId, openId) {

        var id = $(openId);
        var selectId = $(selectId);

        if (selectId.val() == 1) {
            id.show("blind", "slow");
        } else {
            id.hide("slow");
        }
    }

    // 電話番号入力フォーム表示
    function openPhoneNumberInput(selectId, openId) {

        var id = $(openId);
        var selectId = $(selectId);
        if (selectId.val() > 0 && selectId.val() < 4) {
            id.show("blind", "slow");
        } else {
            id.hide("slow");
        }
    }
