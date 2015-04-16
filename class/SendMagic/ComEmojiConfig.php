<?php
/**
 * ComEmojiConfigクラス
 *
 * 携帯絵文字のキャリア毎に対応した絵文字を格納している配列を取得するクラスです。
 * 内部的に何か処理を行うということはありません。
 *
 * 2010/09/15 nakamura
 */
class SendMagic_ComEmojiConfig {
    /**
     * コンストラクタ
     *
     */
    public function __construct() {
        // 何もしない
    }

    /**
     * デストラクタ
     *
     */
    public function __destruct() {
        // 何もしない
    }

    /**
     * getDocomoEmojiメソッド
     *
     * Docomo用の変換文字をキーにしたDocomo絵文字データ配列を返します。
     *
     * @return $docomoEmoji Docomo絵文字配列
     */
    public static function getDocomoEmoji() {
        static $docomoEmoji;

        if (!isset($docomoEmoji)) {
            $docomoEmoji["%i1%"] = "\xf8\x9f";
            $docomoEmoji["%i2%"] = "\xf8\xa0";
            $docomoEmoji["%i3%"] = "\xf8\xa1";
            $docomoEmoji["%i4%"] = "\xf8\xa2";
            $docomoEmoji["%i5%"] = "\xf8\xa3";
            $docomoEmoji["%i6%"] = "\xf8\xa4";
            $docomoEmoji["%i7%"] = "\xf8\xa5";
            $docomoEmoji["%i8%"] = "\xf8\xa6";
            $docomoEmoji["%i9%"] = "\xf8\xa7";
            $docomoEmoji["%i10%"] = "\xf8\xa8";
            $docomoEmoji["%i11%"] = "\xf8\xa9";
            $docomoEmoji["%i12%"] = "\xf8\xaa";
            $docomoEmoji["%i13%"] = "\xf8\xab";
            $docomoEmoji["%i14%"] = "\xf8\xac";
            $docomoEmoji["%i15%"] = "\xf8\xad";
            $docomoEmoji["%i16%"] = "\xf8\xae";
            $docomoEmoji["%i17%"] = "\xf8\xaf";
            $docomoEmoji["%i18%"] = "\xf8\xb0";
            $docomoEmoji["%i19%"] = "\xf8\xb1";
            $docomoEmoji["%i20%"] = "\xf8\xb2";
            $docomoEmoji["%i21%"] = "\xf8\xb3";
            $docomoEmoji["%i22%"] = "\xf8\xb4";
            $docomoEmoji["%i23%"] = "\xf8\xb5";
            $docomoEmoji["%i24%"] = "\xf8\xb6";
            $docomoEmoji["%i25%"] = "\xf8\xb7";
            $docomoEmoji["%i26%"] = "\xf8\xb8";
            $docomoEmoji["%i27%"] = "\xf8\xb9";
            $docomoEmoji["%i28%"] = "\xf8\xba";
            $docomoEmoji["%i29%"] = "\xf8\xbb";
            $docomoEmoji["%i30%"] = "\xf8\xbc";
            $docomoEmoji["%i31%"] = "\xf8\xbd";
            $docomoEmoji["%i32%"] = "\xf8\xbe";
            $docomoEmoji["%i33%"] = "\xf8\xbf";
            $docomoEmoji["%i34%"] = "\xf8\xc0";
            $docomoEmoji["%i35%"] = "\xf8\xc1";
            $docomoEmoji["%i36%"] = "\xf8\xc2";
            $docomoEmoji["%i37%"] = "\xf8\xc3";
            $docomoEmoji["%i38%"] = "\xf8\xc4";
            $docomoEmoji["%i39%"] = "\xf8\xc5";
            $docomoEmoji["%i40%"] = "\xf8\xc6";
            $docomoEmoji["%i41%"] = "\xf8\xc7";
            $docomoEmoji["%i42%"] = "\xf8\xc8";
            $docomoEmoji["%i43%"] = "\xf8\xc9";
            $docomoEmoji["%i44%"] = "\xf8\xca";
            $docomoEmoji["%i45%"] = "\xf8\xcb";
            $docomoEmoji["%i46%"] = "\xf8\xcc";
            $docomoEmoji["%i47%"] = "\xf8\xcd";
            $docomoEmoji["%i48%"] = "\xf8\xce";
            $docomoEmoji["%i49%"] = "\xf8\xcf";
            $docomoEmoji["%i50%"] = "\xf8\xd0";
            $docomoEmoji["%i51%"] = "\xf8\xd1";
            $docomoEmoji["%i52%"] = "\xf8\xd2";
            $docomoEmoji["%i53%"] = "\xf8\xd3";
            $docomoEmoji["%i54%"] = "\xf8\xd4";
            $docomoEmoji["%i55%"] = "\xf8\xd5";
            $docomoEmoji["%i56%"] = "\xf8\xd6";
            $docomoEmoji["%i57%"] = "\xf8\xd7";
            $docomoEmoji["%i58%"] = "\xf8\xd8";
            $docomoEmoji["%i59%"] = "\xf8\xd9";
            $docomoEmoji["%i60%"] = "\xf8\xda";
            $docomoEmoji["%i61%"] = "\xf8\xdb";
            $docomoEmoji["%i62%"] = "\xf8\xdc";
            $docomoEmoji["%i63%"] = "\xf8\xdd";
            $docomoEmoji["%i64%"] = "\xf8\xde";
            $docomoEmoji["%i65%"] = "\xf8\xdf";
            $docomoEmoji["%i66%"] = "\xf8\xe0";
            $docomoEmoji["%i67%"] = "\xf8\xe1";
            $docomoEmoji["%i68%"] = "\xf8\xe2";
            $docomoEmoji["%i69%"] = "\xf8\xe3";
            $docomoEmoji["%i70%"] = "\xf8\xe4";
            $docomoEmoji["%i71%"] = "\xf8\xe5";
            $docomoEmoji["%i72%"] = "\xf8\xe6";
            $docomoEmoji["%i73%"] = "\xf8\xe7";
            $docomoEmoji["%i74%"] = "\xf8\xe8";
            $docomoEmoji["%i75%"] = "\xf8\xe9";
            $docomoEmoji["%i76%"] = "\xf8\xea";
            $docomoEmoji["%i77%"] = "\xf8\xeb";
            $docomoEmoji["%i78%"] = "\xf8\xec";
            $docomoEmoji["%i79%"] = "\xf8\xed";
            $docomoEmoji["%i80%"] = "\xf8\xee";
            $docomoEmoji["%i81%"] = "\xf8\xef";
            $docomoEmoji["%i82%"] = "\xf8\xf0";
            $docomoEmoji["%i83%"] = "\xf8\xf1";
            $docomoEmoji["%i84%"] = "\xf8\xf2";
            $docomoEmoji["%i85%"] = "\xf8\xf3";
            $docomoEmoji["%i86%"] = "\xf8\xf4";
            $docomoEmoji["%i87%"] = "\xf8\xf5";
            $docomoEmoji["%i88%"] = "\xf8\xf6";
            $docomoEmoji["%i89%"] = "\xf8\xf7";
            $docomoEmoji["%i90%"] = "\xf8\xf8";
            $docomoEmoji["%i91%"] = "\xf8\xf9";
            $docomoEmoji["%i92%"] = "\xf8\xfa";
            $docomoEmoji["%i93%"] = "\xf8\xfb";
            $docomoEmoji["%i94%"] = "\xf8\xfc";
            $docomoEmoji["%i95%"] = "\xf9\x40";
            $docomoEmoji["%i96%"] = "\xf9\x41";
            $docomoEmoji["%i97%"] = "\xf9\x42";
            $docomoEmoji["%i98%"] = "\xf9\x43";
            $docomoEmoji["%i99%"] = "\xf9\x44";
            $docomoEmoji["%i100%"] = "\xf9\x45";
            $docomoEmoji["%i101%"] = "\xf9\x46";
            $docomoEmoji["%i102%"] = "\xf9\x47";
            $docomoEmoji["%i103%"] = "\xf9\x48";
            $docomoEmoji["%i104%"] = "\xf9\x49";
            $docomoEmoji["%i105%"] = "\xf9\x72";
            $docomoEmoji["%i106%"] = "\xf9\x73";
            $docomoEmoji["%i107%"] = "\xf9\x74";
            $docomoEmoji["%i108%"] = "\xf9\x75";
            $docomoEmoji["%i109%"] = "\xf9\x76";
            $docomoEmoji["%i110%"] = "\xf9\x77";
            $docomoEmoji["%i111%"] = "\xf9\x78";
            $docomoEmoji["%i112%"] = "\xf9\x79";
            $docomoEmoji["%i113%"] = "\xf9\x7a";
            $docomoEmoji["%i114%"] = "\xf9\x7b";
            $docomoEmoji["%i115%"] = "\xf9\x7c";
            $docomoEmoji["%i116%"] = "\xf9\x7d";
            $docomoEmoji["%i117%"] = "\xf9\x7e";
            $docomoEmoji["%i118%"] = "\xf9\x80";
            $docomoEmoji["%i119%"] = "\xf9\x81";
            $docomoEmoji["%i120%"] = "\xf9\x82";
            $docomoEmoji["%i121%"] = "\xf9\x83";
            $docomoEmoji["%i122%"] = "\xf9\x84";
            $docomoEmoji["%i123%"] = "\xf9\x85";
            $docomoEmoji["%i124%"] = "\xf9\x86";
            $docomoEmoji["%i125%"] = "\xf9\x87";
            $docomoEmoji["%i126%"] = "\xf9\x88";
            $docomoEmoji["%i127%"] = "\xf9\x89";
            $docomoEmoji["%i128%"] = "\xf9\x8a";
            $docomoEmoji["%i129%"] = "\xf9\x8b";
            $docomoEmoji["%i130%"] = "\xf9\x8c";
            $docomoEmoji["%i131%"] = "\xf9\x8d";
            $docomoEmoji["%i132%"] = "\xf9\x8e";
            $docomoEmoji["%i133%"] = "\xf9\x8f";
            $docomoEmoji["%i134%"] = "\xf9\x90";
            $docomoEmoji["%i135%"] = "\xf9\xb0";
            $docomoEmoji["%i136%"] = "\xf9\x91";
            $docomoEmoji["%i137%"] = "\xf9\x92";
            $docomoEmoji["%i138%"] = "\xf9\x93";
            $docomoEmoji["%i139%"] = "\xf9\x94";
            $docomoEmoji["%i140%"] = "\xf9\x95";
            $docomoEmoji["%i141%"] = "\xf9\x96";
            $docomoEmoji["%i142%"] = "\xf9\x97";
            $docomoEmoji["%i143%"] = "\xf9\x98";
            $docomoEmoji["%i144%"] = "\xf9\x99";
            $docomoEmoji["%i145%"] = "\xf9\x9a";
            $docomoEmoji["%i146%"] = "\xf9\x9b";
            $docomoEmoji["%i147%"] = "\xf9\x9c";
            $docomoEmoji["%i148%"] = "\xf9\x9d";
            $docomoEmoji["%i149%"] = "\xf9\x9e";
            $docomoEmoji["%i150%"] = "\xf9\x9f";
            $docomoEmoji["%i151%"] = "\xf9\xa0";
            $docomoEmoji["%i152%"] = "\xf9\xa1";
            $docomoEmoji["%i153%"] = "\xf9\xa2";
            $docomoEmoji["%i154%"] = "\xf9\xa3";
            $docomoEmoji["%i155%"] = "\xf9\xa4";
            $docomoEmoji["%i156%"] = "\xf9\xa5";
            $docomoEmoji["%i157%"] = "\xf9\xa6";
            $docomoEmoji["%i158%"] = "\xf9\xa7";
            $docomoEmoji["%i159%"] = "\xf9\xa8";
            $docomoEmoji["%i160%"] = "\xf9\xa9";
            $docomoEmoji["%i161%"] = "\xf9\xaa";
            $docomoEmoji["%i162%"] = "\xf9\xab";
            $docomoEmoji["%i163%"] = "\xf9\xac";
            $docomoEmoji["%i164%"] = "\xf9\xad";
            $docomoEmoji["%i165%"] = "\xf9\xae";
            $docomoEmoji["%i166%"] = "\xf9\xaf";
            $docomoEmoji["%i167%"] = "\xf9\x50";
            $docomoEmoji["%i168%"] = "\xf9\x51";
            $docomoEmoji["%i169%"] = "\xf9\x52";
            $docomoEmoji["%i170%"] = "\xf9\x55";
            $docomoEmoji["%i171%"] = "\xf9\x56";
            $docomoEmoji["%i172%"] = "\xf9\x57";
            $docomoEmoji["%i173%"] = "\xf9\x5b";
            $docomoEmoji["%i174%"] = "\xf9\x5c";
            $docomoEmoji["%i175%"] = "\xf9\x5d";
            $docomoEmoji["%i176%"] = "\xf9\x5e";
            $docomoEmoji["%i1001%"] = "\xf9\xb1";
            $docomoEmoji["%i1002%"] = "\xf9\xb2";
            $docomoEmoji["%i1003%"] = "\xf9\xb3";
            $docomoEmoji["%i1004%"] = "\xf9\xb4";
            $docomoEmoji["%i1005%"] = "\xf9\xb5";
            $docomoEmoji["%i1006%"] = "\xf9\xb6";
            $docomoEmoji["%i1007%"] = "\xf9\xb7";
            $docomoEmoji["%i1008%"] = "\xf9\xb8";
            $docomoEmoji["%i1009%"] = "\xf9\xb9";
            $docomoEmoji["%i1010%"] = "\xf9\xba";
            $docomoEmoji["%i1011%"] = "\xf9\xbb";
            $docomoEmoji["%i1012%"] = "\xf9\xbc";
            $docomoEmoji["%i1013%"] = "\xf9\xbd";
            $docomoEmoji["%i1014%"] = "\xf9\xbe";
            $docomoEmoji["%i1015%"] = "\xf9\xbf";
            $docomoEmoji["%i1016%"] = "\xf9\xc0";
            $docomoEmoji["%i1017%"] = "\xf9\xc1";
            $docomoEmoji["%i1018%"] = "\xf9\xc2";
            $docomoEmoji["%i1019%"] = "\xf9\xc3";
            $docomoEmoji["%i1020%"] = "\xf9\xc4";
            $docomoEmoji["%i1021%"] = "\xf9\xc5";
            $docomoEmoji["%i1022%"] = "\xf9\xc6";
            $docomoEmoji["%i1023%"] = "\xf9\xc7";
            $docomoEmoji["%i1024%"] = "\xf9\xc8";
            $docomoEmoji["%i1025%"] = "\xf9\xc9";
            $docomoEmoji["%i1026%"] = "\xf9\xca";
            $docomoEmoji["%i1027%"] = "\xf9\xcb";
            $docomoEmoji["%i1028%"] = "\xf9\xcc";
            $docomoEmoji["%i1029%"] = "\xf9\xcd";
            $docomoEmoji["%i1030%"] = "\xf9\xce";
            $docomoEmoji["%i1031%"] = "\xf9\xcf";
            $docomoEmoji["%i1032%"] = "\xf9\xd0";
            $docomoEmoji["%i1033%"] = "\xf9\xd1";
            $docomoEmoji["%i1034%"] = "\xf9\xd2";
            $docomoEmoji["%i1035%"] = "\xf9\xd3";
            $docomoEmoji["%i1036%"] = "\xf9\xd4";
            $docomoEmoji["%i1037%"] = "\xf9\xd5";
            $docomoEmoji["%i1038%"] = "\xf9\xd6";
            $docomoEmoji["%i1039%"] = "\xf9\xd7";
            $docomoEmoji["%i1040%"] = "\xf9\xd8";
            $docomoEmoji["%i1041%"] = "\xf9\xd9";
            $docomoEmoji["%i1042%"] = "\xf9\xda";
            $docomoEmoji["%i1043%"] = "\xf9\xdb";
            $docomoEmoji["%i1044%"] = "\xf9\xdc";
            $docomoEmoji["%i1045%"] = "\xf9\xdd";
            $docomoEmoji["%i1046%"] = "\xf9\xde";
            $docomoEmoji["%i1047%"] = "\xf9\xdf";
            $docomoEmoji["%i1048%"] = "\xf9\xe0";
            $docomoEmoji["%i1049%"] = "\xf9\xe1";
            $docomoEmoji["%i1050%"] = "\xf9\xe2";
            $docomoEmoji["%i1051%"] = "\xf9\xe3";
            $docomoEmoji["%i1052%"] = "\xf9\xe4";
            $docomoEmoji["%i1053%"] = "\xf9\xe5";
            $docomoEmoji["%i1054%"] = "\xf9\xe6";
            $docomoEmoji["%i1055%"] = "\xf9\xe7";
            $docomoEmoji["%i1056%"] = "\xf9\xe8";
            $docomoEmoji["%i1057%"] = "\xf9\xe9";
            $docomoEmoji["%i1058%"] = "\xf9\xea";
            $docomoEmoji["%i1059%"] = "\xf9\xeb";
            $docomoEmoji["%i1060%"] = "\xf9\xec";
            $docomoEmoji["%i1061%"] = "\xf9\xed";
            $docomoEmoji["%i1062%"] = "\xf9\xee";
            $docomoEmoji["%i1063%"] = "\xf9\xef";
            $docomoEmoji["%i1064%"] = "\xf9\xf0";
            $docomoEmoji["%i1065%"] = "\xf9\xf1";
            $docomoEmoji["%i1066%"] = "\xf9\xf2";
            $docomoEmoji["%i1067%"] = "\xf9\xf3";
            $docomoEmoji["%i1068%"] = "\xf9\xf4";
            $docomoEmoji["%i1069%"] = "\xf9\xf5";
            $docomoEmoji["%i1070%"] = "\xf9\xf6";
            $docomoEmoji["%i1071%"] = "\xf9\xf7";
            $docomoEmoji["%i1072%"] = "\xf9\xf8";
            $docomoEmoji["%i1073%"] = "\xf9\xf9";
            $docomoEmoji["%i1074%"] = "\xf9\xfa";
            $docomoEmoji["%i1075%"] = "\xf9\xfb";
            $docomoEmoji["%i1076%"] = "\xf9\xfc";
        }

        return $docomoEmoji;
    }

    /**
     * getDocomoToDocomoメソッド
     *
     * Docomo用の変換文字をキーにしたDocomo絵文字データ配列を返します。
     *
     * @return $docomoToDocomo Docomo絵文字配列
     */
    public static function getDocomoToDocomo() {
        static $docomoToDocomo;

        if (!isset($docomoToDocomo)) {
            $docomoToDocomo["%i1%"] = "<span style=\"color:red;\">&#xE63E;</span>";    // 晴れ
            $docomoToDocomo["%i2%"] = "<span style=\"color:blue;\">&#xE63F;</span>";    // 曇り
            $docomoToDocomo["%i3%"] = "<span style=\"color:blue;\">&#xE640;</span>";    // 雨
            $docomoToDocomo["%i4%"] = "<span style=\"color:blue;\">&#xE641;</span>";    // 雪
            $docomoToDocomo["%i5%"] = "<span style=\"color:gold;\">&#xE642;</span>";    // 雷
            $docomoToDocomo["%i6%"] = "<span style=\"color:red;\">&#xE643;</span>";    // 台風
            $docomoToDocomo["%i7%"] = "<span style=\"color:blue;\">&#xE644;</span>";    // 霧
            $docomoToDocomo["%i8%"] = "<span style=\"color:blue;\">&#xE645;</span>";    // 小雨
            $docomoToDocomo["%i9%"] = "<span style=\"color:red;\">&#xE646;</span>";    // 牡羊座
            $docomoToDocomo["%i10%"] = "<span style=\"color:orange;\">&#xE647;</span>";    // 牡牛座
            $docomoToDocomo["%i11%"] = "<span style=\"color:green;\">&#xE648;</span>";    // 双子座
            $docomoToDocomo["%i12%"] = "<span style=\"color:blue;\">&#xE649;</span>";    // 蟹座
            $docomoToDocomo["%i13%"] = "<span style=\"color:red;\">&#xE64A;</span>";    // 獅子座
            $docomoToDocomo["%i14%"] = "<span style=\"color:orange;\">&#xE64B;</span>";    // 乙女座
            $docomoToDocomo["%i15%"] = "<span style=\"color:green;\">&#xE64C;</span>";    // 天秤座
            $docomoToDocomo["%i16%"] = "<span style=\"color:blue;\">&#xE64D;</span>";    // 蠍座
            $docomoToDocomo["%i17%"] = "<span style=\"color:red;\">&#xE64E;</span>";    // 射手座
            $docomoToDocomo["%i18%"] = "<span style=\"color:orange;\">&#xE64F;</span>";    // 山羊座
            $docomoToDocomo["%i19%"] = "<span style=\"color:green;\">&#xE650;</span>";    // 水瓶座
            $docomoToDocomo["%i20%"] = "<span style=\"color:blue;\">&#xE651;</span>";    // 魚座
            $docomoToDocomo["%i21%"] = "<span style=\"color:plum;\">&#xE652;</span>";    // スポーツ
            $docomoToDocomo["%i22%"] = "&#xE653;";    // 野球
            $docomoToDocomo["%i23%"] = "<span style=\"color:blue;\">&#xE654;</span>";    // ゴルフ
            $docomoToDocomo["%i24%"] = "<span style=\"color:green;\">&#xE655;</span>";    // テニス
            $docomoToDocomo["%i25%"] = "&#xE656;";    // サッカー
            $docomoToDocomo["%i26%"] = "<span style=\"color:blue;\">&#xE657;</span>";    // スキー
            $docomoToDocomo["%i27%"] = "<span style=\"color:gold;\">&#xE658;</span>";    // バスケットボール
            $docomoToDocomo["%i28%"] = "&#xE659;";    // モータースポーツ
            $docomoToDocomo["%i29%"] = "<span style=\"color:plum;\">&#xE65A;</span>";    // ポケットベル
            $docomoToDocomo["%i30%"] = "<span style=\"color:green;\">&#xE65B;</span>";    // 電車
            $docomoToDocomo["%i31%"] = "<span style=\"color:orange;\">&#xE65C;</span>";    // 地下鉄
            $docomoToDocomo["%i32%"] = "<span style=\"color:blue;\">&#xE65D;</span>";    // 新幹線
            $docomoToDocomo["%i33%"] = "&#xE65E;";    // 車（セダン）
            $docomoToDocomo["%i34%"] = "<span style=\"color:green;\">&#xE65F;</span>";    // 車（ＲＶ）
            $docomoToDocomo["%i35%"] = "<span style=\"color:red;\">&#xE660;</span>";    // バス
            $docomoToDocomo["%i36%"] = "<span style=\"color:blue;\">&#xE661;</span>";    // 船
            $docomoToDocomo["%i37%"] = "<span style=\"color:blue;\">&#xE662;</span>";    // 飛行機
            $docomoToDocomo["%i38%"] = "<span style=\"color:red;\">&#xE663;</span>";    // 家
            $docomoToDocomo["%i39%"] = "<span style=\"color:blue;\">&#xE664;</span>";    // ビル
            $docomoToDocomo["%i40%"] = "<span style=\"color:red;\">&#xE665;</span>";    // 郵便局
            $docomoToDocomo["%i41%"] = "<span style=\"color:red;\">&#xE666;</span>";    // 病院
            $docomoToDocomo["%i42%"] = "<span style=\"color:plum;\">&#xE667;</span>";    // 銀行
            $docomoToDocomo["%i43%"] = "<span style=\"color:red;\">&#xE668;</span>";    // ＡＴＭ
            $docomoToDocomo["%i44%"] = "<span style=\"color:green;\">&#xE669;</span>";    // ホテル
            $docomoToDocomo["%i45%"] = "<span style=\"color:blue;\">&#xE66A;</span>";    // コンビニ
            $docomoToDocomo["%i46%"] = "<span style=\"color:plum;\">&#xE66B;</span>";    // ガソリンスタンド
            $docomoToDocomo["%i47%"] = "<span style=\"color:blue;\">&#xE66C;</span>";    // 駐車場
            $docomoToDocomo["%i48%"] = "&#xE66D;";    // 信号
            $docomoToDocomo["%i49%"] = "&#xE66E;";    // トイレ
            $docomoToDocomo["%i50%"] = "&#xE66F;";    // レストラン
            $docomoToDocomo["%i51%"] = "<span style=\"color:green;\">&#xE670;</span>";    // 喫茶店
            $docomoToDocomo["%i52%"] = "<span style=\"color:plum;\">&#xE671;</span>";    // バー
            $docomoToDocomo["%i53%"] = "<span style=\"color:gold;\">&#xE672;</span>";    // ビール
            $docomoToDocomo["%i54%"] = "<span style=\"color:gold;\">&#xE673;</span>";    // ファーストフード
            $docomoToDocomo["%i55%"] = "<span style=\"color:red;\">&#xE674;</span>";    // ブティック
            $docomoToDocomo["%i56%"] = "<span style=\"color:blue;\">&#xE675;</span>";    // 美容院
            $docomoToDocomo["%i57%"] = "&#xE676;";    // カラオケ
            $docomoToDocomo["%i58%"] = "&#xE677;";    // 映画
            $docomoToDocomo["%i59%"] = "&#xE678;";    // 右斜め上
            $docomoToDocomo["%i60%"] = "<span style=\"color:gold;\">&#xE679;</span>";    // 遊園地
            $docomoToDocomo["%i61%"] = "<span style=\"color:blue;\">&#xE67A;</span>";    // 音楽
            $docomoToDocomo["%i62%"] = "<span style=\"color:plum;\">&#xE67B;</span>";    // アート
            $docomoToDocomo["%i63%"] = "&#xE67C;";    // 演劇
            $docomoToDocomo["%i64%"] = "<span style=\"color:red;\">&#xE67D;</span>";    // イベント
            $docomoToDocomo["%i65%"] = "<span style=\"color:gold;\">&#xE67E;</span>";    // チケット
            $docomoToDocomo["%i66%"] = "&#xE67F;";    // 喫煙
            $docomoToDocomo["%i67%"] = "<span style=\"color:red;\">&#xE680;</span>";    // 禁煙
            $docomoToDocomo["%i68%"] = "&#xE681;";    // カメラ
            $docomoToDocomo["%i69%"] = "<span style=\"color:red;\">&#xE682;</span>";    // カバン
            $docomoToDocomo["%i70%"] = "<span style=\"color:gold;\">&#xE683;</span>";    // 本
            $docomoToDocomo["%i71%"] = "<span style=\"color:red;\">&#xE684;</span>";    // リボン
            $docomoToDocomo["%i72%"] = "<span style=\"color:red;\">&#xE685;</span>";    // プレゼント
            $docomoToDocomo["%i73%"] = "<span style=\"color:red;\">&#xE686;</span>";    // バースデー
            $docomoToDocomo["%i74%"] = "&#xE687;";    // 電話
            $docomoToDocomo["%i75%"] = "&#xE688;";    // 携帯電話
            $docomoToDocomo["%i76%"] = "<span style=\"color:gold;\">&#xE689;</span>";    // メモ
            $docomoToDocomo["%i77%"] = "<span style=\"color:blue;\">&#xE68A;</span>";    // ＴＶ
            $docomoToDocomo["%i78%"] = "&#xE68B;";    // ゲーム
            $docomoToDocomo["%i79%"] = "<span style=\"color:blue;\">&#xE68C;</span>";    // ＣＤ
            $docomoToDocomo["%i80%"] = "<span style=\"color:red;\">&#xE68D;</span>";    // ハート
            $docomoToDocomo["%i81%"] = "&#xE68E;";    // スペード
            $docomoToDocomo["%i82%"] = "<span style=\"color:red;\">&#xE68F;</span>";    // ダイヤ
            $docomoToDocomo["%i83%"] = "&#xE690;";    // クラブ
            $docomoToDocomo["%i84%"] = "&#xE691;";    // 目
            $docomoToDocomo["%i85%"] = "<span style=\"color:orange;\">&#xE692;</span>";    // 耳
            $docomoToDocomo["%i86%"] = "<span style=\"color:orange;\">&#xE693;</span>";    // 手（グー）
            $docomoToDocomo["%i87%"] = "<span style=\"color:orange;\">&#xE694;</span>";    // 手（チョキ）
            $docomoToDocomo["%i88%"] = "<span style=\"color:orange;\">&#xE695;</span>";    // 手（パー）
            $docomoToDocomo["%i89%"] = "&#xE696;";    // 右斜め下
            $docomoToDocomo["%i90%"] = "&#xE697;";    // 左斜め上
            $docomoToDocomo["%i91%"] = "<span style=\"color:orange;\">&#xE698;</span>";    // 足
            $docomoToDocomo["%i92%"] = "&#xE699;";    // くつ
            $docomoToDocomo["%i93%"] = "&#xE69A;";    // 眼鏡
            $docomoToDocomo["%i94%"] = "<span style=\"color:blue;\">&#xE69B;</span>";    // 車椅子
            $docomoToDocomo["%i95%"] = "&#xE69C;";    // 新月
            $docomoToDocomo["%i96%"] = "&#xE69D;";    // やや欠け月
            $docomoToDocomo["%i97%"] = "&#xE69E;";    // 半月
            $docomoToDocomo["%i98%"] = "&#xE69F;";    // 三日月
            $docomoToDocomo["%i99%"] = "&#xE6A0;";    // 満月
            $docomoToDocomo["%i100%"] = "<span style=\"color:orange;\">&#xE6A1;</span>";    // 犬
            $docomoToDocomo["%i101%"] = "<span style=\"color:orange;\">&#xE6A2;</span>";    // 猫
            $docomoToDocomo["%i102%"] = "<span style=\"color:blue;\">&#xE6A3;</span>";    // リゾート
            $docomoToDocomo["%i103%"] = "<span style=\"color:green;\">&#xE6A4;</span>";    // クリスマス
            $docomoToDocomo["%i104%"] = "&#xE6A5;";    // 左斜め下
            $docomoToDocomo["%i105%"] = "&#xE6CE;";    // phone to
            $docomoToDocomo["%i106%"] = "&#xE6CF;";    // mail to
            $docomoToDocomo["%i107%"] = "&#xE6D0;";    // fax to
            $docomoToDocomo["%i108%"] = "<span style=\"color:gold;\">&#xE6D1;</span>";    // iモード
            $docomoToDocomo["%i109%"] = "<span style=\"color:gold;\">&#xE6D2;</span>";    // iモード（枠付き）
            $docomoToDocomo["%i110%"] = "&#xE6D3;";    // メール
            $docomoToDocomo["%i111%"] = "&#xE6D4;";    // ドコモ提供
            $docomoToDocomo["%i112%"] = "&#xE6D5;";    // ドコモポイント
            $docomoToDocomo["%i113%"] = "<span style=\"color:red;\">&#xE6D6;</span>";    // 有料
            $docomoToDocomo["%i114%"] = "<span style=\"color:red;\">&#xE6D7;</span>";    // 無料
            $docomoToDocomo["%i115%"] = "<span style=\"color:red;\">&#xE6D8;</span>";    // ID
            $docomoToDocomo["%i116%"] = "<span style=\"color:red;\">&#xE6D9;</span>";    // パスワード
            $docomoToDocomo["%i117%"] = "<span style=\"color:red;\">&#xE6DA;</span>";    // 次項有
            $docomoToDocomo["%i118%"] = "<span style=\"color:red;\">&#xE6DB;</span>";    // クリア
            $docomoToDocomo["%i119%"] = "<span style=\"color:blue;\">&#xE6DC;</span>";    // サーチ（調べる）
            $docomoToDocomo["%i120%"] = "<span style=\"color:red;\">&#xE6DD;</span>";    // ＮＥＷ
            $docomoToDocomo["%i121%"] = "<span style=\"color:red;\">&#xE6DE;</span>";    // 位置情報
            $docomoToDocomo["%i122%"] = "&#xE6DF;";    // フリーダイヤル
            $docomoToDocomo["%i123%"] = "&#xE6E0;";    // シャープダイヤル
            $docomoToDocomo["%i124%"] = "&#xE6E1;";    // モバＱ
            $docomoToDocomo["%i125%"] = "&#xE6E2;";    // 1
            $docomoToDocomo["%i126%"] = "&#xE6E3;";    // 2
            $docomoToDocomo["%i127%"] = "&#xE6E4;";    // 3
            $docomoToDocomo["%i128%"] = "&#xE6E5;";    // 4
            $docomoToDocomo["%i129%"] = "&#xE6E6;";    // 5
            $docomoToDocomo["%i130%"] = "&#xE6E7;";    // 6
            $docomoToDocomo["%i131%"] = "&#xE6E8;";    // 7
            $docomoToDocomo["%i132%"] = "&#xE6E9;";    // 8
            $docomoToDocomo["%i133%"] = "&#xE6EA;";    // 9
            $docomoToDocomo["%i134%"] = "&#xE6EB;";    // 0
            $docomoToDocomo["%i135%"] = "<span style=\"color:red;\">&#xE70B;</span>";    // 決定
            $docomoToDocomo["%i136%"] = "<span style=\"color:red;\">&#xE6EC;</span>";    // 黒ハート
            $docomoToDocomo["%i137%"] = "<span style=\"color:red;\">&#xE6ED;</span>";    // 揺れるハート
            $docomoToDocomo["%i138%"] = "<span style=\"color:red;\">&#xE6EE;</span>";    // 失恋
            $docomoToDocomo["%i139%"] = "<span style=\"color:red;\">&#xE6EF;</span>";    // ハートたち（複数ハート）
            $docomoToDocomo["%i140%"] = "<span style=\"color:pink;\">&#xE6F0;</span>";    // わーい（嬉しい顔）
            $docomoToDocomo["%i141%"] = "<span style=\"color:red;\">&#xE6F1;</span>";    // ちっ（怒った顔）
            $docomoToDocomo["%i142%"] = "<span style=\"color:blue;\">&#xE6F2;</span>";    // がく～（落胆した顔）
            $docomoToDocomo["%i143%"] = "<span style=\"color:green;\">&#xE6F3;</span>";    // もうやだ～（悲しい顔）
            $docomoToDocomo["%i144%"] = "<span style=\"color:blue;\">&#xE6F4;</span>";    // ふらふら
            $docomoToDocomo["%i145%"] = "<span style=\"color:red;\">&#xE6F5;</span>";    // グッド（上向き矢印）
            $docomoToDocomo["%i146%"] = "<span style=\"color:red;\">&#xE6F6;</span>";    // るんるん
            $docomoToDocomo["%i147%"] = "<span style=\"color:red;\">&#xE6F7;</span>";    // いい気分（温泉）
            $docomoToDocomo["%i148%"] = "<span style=\"color:plum;\">&#xE6F8;</span>";    // かわいい
            $docomoToDocomo["%i149%"] = "<span style=\"color:red;\">&#xE6F9;</span>";    // キスマーク
            $docomoToDocomo["%i150%"] = "<span style=\"color:gold;\">&#xE6FA;</span>";    // ぴかぴか（新しい）
            $docomoToDocomo["%i151%"] = "<span style=\"color:gold;\">&#xE6FB;</span>";    // ひらめき
            $docomoToDocomo["%i152%"] = "&#xE6FC;";    // むかっ（怒り）
            $docomoToDocomo["%i153%"] = "<span style=\"color:red;\">&#xE6FD;</span>";    // パンチ
            $docomoToDocomo["%i154%"] = "&#xE6FE;";    // 爆弾
            $docomoToDocomo["%i155%"] = "<span style=\"color:red;\">&#xE6FF;</span>";    // ムード
            $docomoToDocomo["%i156%"] = "<span style=\"color:blue;\">&#xE700;</span>";    // バッド（下向き矢印）
            $docomoToDocomo["%i157%"] = "<span style=\"color:blue;\">&#xE701;</span>";    // 眠い(睡眠)
            $docomoToDocomo["%i158%"] = "<span style=\"color:red;\">&#xE702;</span>";    // exclamation
            $docomoToDocomo["%i159%"] = "<span style=\"color:plum;\">&#xE703;</span>";    // exclamation&question
            $docomoToDocomo["%i160%"] = "<span style=\"color:red;\">&#xE704;</span>";    // exclamation×2
            $docomoToDocomo["%i161%"] = "<span style=\"color:red;\">&#xE705;</span>";    // どんっ（衝撃）
            $docomoToDocomo["%i162%"] = "&#xE706;";    // あせあせ（飛び散る汗）
            $docomoToDocomo["%i163%"] = "&#xE707;";    // たらーっ（汗）
            $docomoToDocomo["%i164%"] = "&#xE708;";    // ダッシュ（走り出すさま）
            $docomoToDocomo["%i165%"] = "&#xE709;";    // ー（長音記号１）
            $docomoToDocomo["%i166%"] = "&#xE70A;";    // ー（長音記号２）
            $docomoToDocomo["%i167%"] = "&#xE6AC;";    // カチンコ
            $docomoToDocomo["%i168%"] = "&#xE6AD;";    // ふくろ
            $docomoToDocomo["%i169%"] = "&#xE6AE;";    // ペン
            $docomoToDocomo["%i170%"] = "&#xE6B1;";    // 人影
            $docomoToDocomo["%i171%"] = "&#xE6B2;";    // いす
            $docomoToDocomo["%i172%"] = "&#xE6B3;";    // 夜
            $docomoToDocomo["%i173%"] = "&#xE6B7;";    // soon
            $docomoToDocomo["%i174%"] = "&#xE6B8;";    // on
            $docomoToDocomo["%i175%"] = "&#xE6B9;";    // end
            $docomoToDocomo["%i176%"] = "&#xE6BA;";    // 時計
            $docomoToDocomo["%i1001%"] = "<span style=\"color:orange;\">&#xE70C;</span>";    // iアプリ
            $docomoToDocomo["%i1002%"] = "<span style=\"color:orange;\">&#xE70D;</span>";    // iアプリ（枠付き）
            $docomoToDocomo["%i1003%"] = "<span style=\"color:blue;\">&#xE70E;</span>";    // Tシャツ（ボーダー）
            $docomoToDocomo["%i1004%"] = "&#xE70F;";    // がま口財布
            $docomoToDocomo["%i1005%"] = "<span style=\"color:red;\">&#xE710;</span>";    // 化粧
            $docomoToDocomo["%i1006%"] = "<span style=\"color:blue;\">&#xE711;</span>";    // ジーンズ
            $docomoToDocomo["%i1007%"] = "<span style=\"color:blue;\">&#xE712;</span>";    // スノボ
            $docomoToDocomo["%i1008%"] = "<span style=\"color:gold;\">&#xE713;</span>";    // チャペル
            $docomoToDocomo["%i1009%"] = "<span style=\"color:salmon;\">&#xE714;</span>";    // ドア
            $docomoToDocomo["%i1010%"] = "<span style=\"color:salmon;\">&#xE715;</span>";    // ドル袋
            $docomoToDocomo["%i1011%"] = "&#xE716;";    // パソコン
            $docomoToDocomo["%i1012%"] = "<span style=\"color:red;\">&#xE717;</span>";    // ラブレター
            $docomoToDocomo["%i1013%"] = "&#xE718;";    // レンチ
            $docomoToDocomo["%i1014%"] = "<span style=\"color:green;\">&#xE719;</span>";    // 鉛筆
            $docomoToDocomo["%i1015%"] = "<span style=\"color:gold;\">&#xE71A;</span>";    // 王冠
            $docomoToDocomo["%i1016%"] = "<span style=\"color:plum;\">&#xE71B;</span>";    // 指輪
            $docomoToDocomo["%i1017%"] = "&#xE71C;";    // 砂時計
            $docomoToDocomo["%i1018%"] = "&#xE71D;";    // 自転車
            $docomoToDocomo["%i1019%"] = "<span style=\"color:green;\">&#xE71E;</span>";    // 湯のみ
            $docomoToDocomo["%i1020%"] = "&#xE71F;";    // 腕時計
            $docomoToDocomo["%i1021%"] = "<span style=\"color:green;\">&#xE720;</span>";    // 考えてる顔
            $docomoToDocomo["%i1022%"] = "<span style=\"color:pink;\">&#xE721;</span>";    // ほっとした顔
            $docomoToDocomo["%i1023%"] = "<span style=\"color:blue;\">&#xE722;</span>";    // 冷や汗
            $docomoToDocomo["%i1024%"] = "<span style=\"color:blue;\">&#xE723;</span>";    // 冷や汗2
            $docomoToDocomo["%i1025%"] = "<span style=\"color:red;\">&#xE724;</span>";    // ぷっくっくな顔
            $docomoToDocomo["%i1026%"] = "<span style=\"color:blueviolet;\">&#xE725;</span>";    // ボケーっとした顔
            $docomoToDocomo["%i1027%"] = "<span style=\"color:pink;\">&#xE726;</span>";    // 目がハート
            $docomoToDocomo["%i1028%"] = "<span style=\"color:orange;\">&#xE727;</span>";    // 指でOK
            //$docomoToDocomo["%i1028%"] = "\xE727";
            $docomoToDocomo["%i1029%"] = "<span style=\"color:red;\">&#xE728;</span>";    // あっかんべー
            $docomoToDocomo["%i1030%"] = "<span style=\"color:pink;\">&#xE729;</span>";    // ウィンク
            $docomoToDocomo["%i1031%"] = "<span style=\"color:pink;\">&#xE72A;</span>";    // うれしい顔
            $docomoToDocomo["%i1032%"] = "<span style=\"color:blue;\">&#xE72B;</span>";    // がまん顔
            $docomoToDocomo["%i1033%"] = "<span style=\"color:orange;\">&#xE72C;</span>";    // 猫2
            $docomoToDocomo["%i1034%"] = "<span style=\"color:blue;\">&#xE72D;</span>";    // 泣き顔
            $docomoToDocomo["%i1035%"] = "<span style=\"color:blue;\">&#xE72E;</span>";    // 涙
            $docomoToDocomo["%i1036%"] = "<span style=\"color:red;\">&#xE72F;</span>";    // NG
            $docomoToDocomo["%i1037%"] = "<span style=\"color:blue;\">&#xE730;</span>";    // クリップ
            $docomoToDocomo["%i1038%"] = "&#xE731;";    // コピーライト
            $docomoToDocomo["%i1039%"] = "&#xE732;";    // トレードマーク
            $docomoToDocomo["%i1040%"] = "&#xE733;";    // 走る人
            $docomoToDocomo["%i1041%"] = "<span style=\"color:red;\">&#xE734;</span>";    // マル秘
            $docomoToDocomo["%i1042%"] = "<span style=\"color:green;\">&#xE735;</span>";    // リサイクル
            $docomoToDocomo["%i1043%"] = "&#xE736;";    // レジスタードトレードマーク
            $docomoToDocomo["%i1044%"] = "<span style=\"color:orange;\">&#xE737;</span>";    // 危険・警告
            $docomoToDocomo["%i1045%"] = "<span style=\"color:red;\">&#xE738;</span>";    // 禁止
            $docomoToDocomo["%i1046%"] = "<span style=\"color:blue;\">&#xE739;</span>";    // 空室・空席・空車
            $docomoToDocomo["%i1047%"] = "<span style=\"color:red;\">&#xE73A;</span>";    // 合格マーク
            $docomoToDocomo["%i1048%"] = "<span style=\"color:red;\">&#xE73B;</span>";    // 満室・満席・満車
            $docomoToDocomo["%i1049%"] = "&#xE73C;";    // 矢印左右
            $docomoToDocomo["%i1050%"] = "&#xE73D;";    // 矢印上下
            $docomoToDocomo["%i1051%"] = "<span style=\"color:green;\">&#xE73E;</span>";    // 学校
            $docomoToDocomo["%i1052%"] = "<span style=\"color:blue;\">&#xE73F;</span>";    // 波
            $docomoToDocomo["%i1053%"] = "<span style=\"color:blue;\">&#xE740;</span>";    // 富士山
            $docomoToDocomo["%i1054%"] = "<span style=\"color:green;\">&#xE741;</span>";    // クローバー
            $docomoToDocomo["%i1055%"] = "<span style=\"color:red;\">&#xE742;</span>";    // さくらんぼ
            $docomoToDocomo["%i1056%"] = "<span style=\"color:red;\">&#xE743;</span>";    // チューリップ
            $docomoToDocomo["%i1057%"] = "<span style=\"color:gold;\">&#xE744;</span>";    // バナナ
            $docomoToDocomo["%i1058%"] = "<span style=\"color:red;\">&#xE745;</span>";    // りんご
            $docomoToDocomo["%i1059%"] = "<span style=\"color:green;\">&#xE746;</span>";    // 芽
            $docomoToDocomo["%i1060%"] = "<span style=\"color:red;\">&#xE747;</span>";    // もみじ
            $docomoToDocomo["%i1061%"] = "<span style=\"color:pink;\">&#xE748;</span>";    // 桜
            $docomoToDocomo["%i1062%"] = "&#xE749;";    // おにぎり
            $docomoToDocomo["%i1063%"] = "<span style=\"color:red;\">&#xE74A;</span>";    // ショートケーキ
            $docomoToDocomo["%i1064%"] = "<span style=\"color:salmon;\">&#xE74B;</span>";    // とっくり（おちょこ付き）
            $docomoToDocomo["%i1065%"] = "<span style=\"color:gold;\">&#xE74C;</span>";    // どんぶり
            $docomoToDocomo["%i1066%"] = "<span style=\"color:salmon;\">&#xE74D;</span>";    // パン
            $docomoToDocomo["%i1067%"] = "<span style=\"color:salmon;\">&#xE74E;</span>";    // かたつむり
            $docomoToDocomo["%i1068%"] = "<span style=\"color:gold;\">&#xE74F;</span>";    // ひよこ
            $docomoToDocomo["%i1069%"] = "<span style=\"color:blue;\">&#xE750;</span>";    // ペンギン
            $docomoToDocomo["%i1070%"] = "<span style=\"color:blue;\">&#xE751;</span>";    // 魚
            $docomoToDocomo["%i1071%"] = "<span style=\"color:orange;\">&#xE752;</span>";    // うまい！
            $docomoToDocomo["%i1072%"] = "<span style=\"color:orange;\">&#xE753;</span>";    // ウッシッシ
            $docomoToDocomo["%i1073%"] = "<span style=\"color:salmon;\">&#xE754;</span>";    // ウマ
            $docomoToDocomo["%i1074%"] = "<span style=\"color:orange;\">&#xE755;</span>";    // ブタ
            $docomoToDocomo["%i1075%"] = "<span style=\"color:blueviolet;\">&#xE756;</span>";    // ワイングラス
            $docomoToDocomo["%i1076%"] = "<span style=\"color:blueviolet;\">&#xE757;</span>";    // げっそり
        }

        return $docomoToDocomo;
    }

    /**
     * getDocomoToEzwebメソッド
     *
     * Docomo用の変換文字をキーにしたEzweb絵文字データ配列を返します。
     *
     * @return $docomoToEzweb Ezweb絵文字配列
     */
    public static function getDocomoToEzweb() {
        static $docomoToEzweb;

        if (!isset($docomoToEzweb)) {
            $docomoToEzweb["%i1%"] = "<IMG LOCALSRC=44>";
            $docomoToEzweb["%i2%"] = "<IMG LOCALSRC=107>";
            $docomoToEzweb["%i3%"] = "<IMG LOCALSRC=95>";
            $docomoToEzweb["%i4%"] = "<IMG LOCALSRC=191>";
            $docomoToEzweb["%i5%"] = "<IMG LOCALSRC=16>";
            $docomoToEzweb["%i6%"] = "<IMG LOCALSRC=190>";
            $docomoToEzweb["%i7%"] = "<IMG LOCALSRC=305>";
            $docomoToEzweb["%i8%"] = "<IMG LOCALSRC=481>";
            $docomoToEzweb["%i9%"] = "<IMG LOCALSRC=192>";
            $docomoToEzweb["%i10%"] = "<IMG LOCALSRC=193>";
            $docomoToEzweb["%i11%"] = "<IMG LOCALSRC=194>";
            $docomoToEzweb["%i12%"] = "<IMG LOCALSRC=195>";
            $docomoToEzweb["%i13%"] = "<IMG LOCALSRC=196>";
            $docomoToEzweb["%i14%"] = "<IMG LOCALSRC=197>";
            $docomoToEzweb["%i15%"] = "<IMG LOCALSRC=198>";
            $docomoToEzweb["%i16%"] = "<IMG LOCALSRC=199>";
            $docomoToEzweb["%i17%"] = "<IMG LOCALSRC=200>";
            $docomoToEzweb["%i18%"] = "<IMG LOCALSRC=201>";
            $docomoToEzweb["%i19%"] = "<IMG LOCALSRC=202>";
            $docomoToEzweb["%i20%"] = "<IMG LOCALSRC=203>";
            $docomoToEzweb["%i21%"] = "[ｽﾎﾟｰﾂ]";
            $docomoToEzweb["%i22%"] = "<IMG LOCALSRC=45>";
            $docomoToEzweb["%i23%"] = "<IMG LOCALSRC=306>";
            $docomoToEzweb["%i24%"] = "<IMG LOCALSRC=220>";
            $docomoToEzweb["%i25%"] = "<IMG LOCALSRC=219>";
            $docomoToEzweb["%i26%"] = "<IMG LOCALSRC=421>";
            $docomoToEzweb["%i27%"] = "<IMG LOCALSRC=307>";
            $docomoToEzweb["%i28%"] = "<IMG LOCALSRC=222>";
            $docomoToEzweb["%i29%"] = "<IMG LOCALSRC=308>";
            $docomoToEzweb["%i30%"] = "<IMG LOCALSRC=172>";
            $docomoToEzweb["%i31%"] = "<IMG LOCALSRC=341>";
            $docomoToEzweb["%i32%"] = "<IMG LOCALSRC=217>";
            $docomoToEzweb["%i33%"] = "<IMG LOCALSRC=125>";
            $docomoToEzweb["%i34%"] = "<IMG LOCALSRC=125>";
            $docomoToEzweb["%i35%"] = "<IMG LOCALSRC=216>";
            $docomoToEzweb["%i36%"] = "<IMG LOCALSRC=379>";
            $docomoToEzweb["%i37%"] = "<IMG LOCALSRC=168>";
            $docomoToEzweb["%i38%"] = "<IMG LOCALSRC=112>";
            $docomoToEzweb["%i39%"] = "<IMG LOCALSRC=156>";
            $docomoToEzweb["%i40%"] = "<IMG LOCALSRC=375>";
            $docomoToEzweb["%i41%"] = "<IMG LOCALSRC=376>";
            $docomoToEzweb["%i42%"] = "<IMG LOCALSRC=212>";
            $docomoToEzweb["%i43%"] = "<IMG LOCALSRC=205>";
            $docomoToEzweb["%i44%"] = "<IMG LOCALSRC=378>";
            $docomoToEzweb["%i45%"] = "<IMG LOCALSRC=206>";
            $docomoToEzweb["%i46%"] = "<IMG LOCALSRC=213>";
            $docomoToEzweb["%i47%"] = "<IMG LOCALSRC=208>";
            $docomoToEzweb["%i48%"] = "<IMG LOCALSRC=99>";
            $docomoToEzweb["%i49%"] = "<IMG LOCALSRC=207>";
            $docomoToEzweb["%i50%"] = "<IMG LOCALSRC=146>";
            $docomoToEzweb["%i51%"] = "<IMG LOCALSRC=93>";
            $docomoToEzweb["%i52%"] = "<IMG LOCALSRC=52>";
            $docomoToEzweb["%i53%"] = "<IMG LOCALSRC=65>";
            $docomoToEzweb["%i54%"] = "<IMG LOCALSRC=245>";
            $docomoToEzweb["%i55%"] = "<IMG LOCALSRC=124>";
            $docomoToEzweb["%i56%"] = "<IMG LOCALSRC=104>";
            $docomoToEzweb["%i57%"] = "<IMG LOCALSRC=289>";
            $docomoToEzweb["%i58%"] = "<IMG LOCALSRC=110>";
            $docomoToEzweb["%i59%"] = "<IMG LOCALSRC=70>";
            $docomoToEzweb["%i60%"] = "[遊園地]";
            $docomoToEzweb["%i61%"] = "<IMG LOCALSRC=294>";
            $docomoToEzweb["%i62%"] = "<IMG LOCALSRC=309>";
            $docomoToEzweb["%i63%"] = "<IMG LOCALSRC=494>";
            $docomoToEzweb["%i64%"] = "<IMG LOCALSRC=311>";
            $docomoToEzweb["%i65%"] = "<IMG LOCALSRC=106>";
            $docomoToEzweb["%i66%"] = "<IMG LOCALSRC=176>";
            $docomoToEzweb["%i67%"] = "<IMG LOCALSRC=177>";
            $docomoToEzweb["%i68%"] = "<IMG LOCALSRC=94>";
            $docomoToEzweb["%i69%"] = "<IMG LOCALSRC=83>";
            $docomoToEzweb["%i70%"] = "<IMG LOCALSRC=122>";
            $docomoToEzweb["%i71%"] = "<IMG LOCALSRC=312>";
            $docomoToEzweb["%i72%"] = "<IMG LOCALSRC=144>";
            $docomoToEzweb["%i73%"] = "<IMG LOCALSRC=313>";
            $docomoToEzweb["%i74%"] = "<IMG LOCALSRC=85>";
            $docomoToEzweb["%i75%"] = "<IMG LOCALSRC=161>";
            $docomoToEzweb["%i76%"] = "<IMG LOCALSRC=395>";
            $docomoToEzweb["%i77%"] = "<IMG LOCALSRC=288>";
            $docomoToEzweb["%i78%"] = "<IMG LOCALSRC=232>";
            $docomoToEzweb["%i79%"] = "<IMG LOCALSRC=300>";
            $docomoToEzweb["%i80%"] = "<IMG LOCALSRC=414>";
            $docomoToEzweb["%i81%"] = "<IMG LOCALSRC=314>";
            $docomoToEzweb["%i82%"] = "<IMG LOCALSRC=315>";
            $docomoToEzweb["%i83%"] = "<IMG LOCALSRC=316>";
            $docomoToEzweb["%i84%"] = "<IMG LOCALSRC=317>";
            $docomoToEzweb["%i85%"] = "<IMG LOCALSRC=318>";
            $docomoToEzweb["%i86%"] = "<IMG LOCALSRC=817>";
            $docomoToEzweb["%i87%"] = "<IMG LOCALSRC=319>";
            $docomoToEzweb["%i88%"] = "<IMG LOCALSRC=320>";
            $docomoToEzweb["%i89%"] = "<IMG LOCALSRC=43>";
            $docomoToEzweb["%i90%"] = "<IMG LOCALSRC=42>";
            $docomoToEzweb["%i91%"] = "<IMG LOCALSRC=728>";
            $docomoToEzweb["%i92%"] = "<IMG LOCALSRC=729>";
            $docomoToEzweb["%i93%"] = "<IMG LOCALSRC=116>";
            $docomoToEzweb["%i94%"] = "<IMG LOCALSRC=178>";
            $docomoToEzweb["%i95%"] = "<IMG LOCALSRC=321>";
            $docomoToEzweb["%i96%"] = "<IMG LOCALSRC=322>";
            $docomoToEzweb["%i97%"] = "<IMG LOCALSRC=323>";
            $docomoToEzweb["%i98%"] = "<IMG LOCALSRC=15>";
            $docomoToEzweb["%i99%"] = "○";
            $docomoToEzweb["%i100%"] = "<IMG LOCALSRC=134>";
            $docomoToEzweb["%i101%"] = "<IMG LOCALSRC=251>";
            $docomoToEzweb["%i102%"] = "<IMG LOCALSRC=169>";
            $docomoToEzweb["%i103%"] = "<IMG LOCALSRC=234>";
            $docomoToEzweb["%i104%"] = "<IMG LOCALSRC=71>";
            $docomoToEzweb["%i105%"] = "<IMG LOCALSRC=513>";
            $docomoToEzweb["%i106%"] = "<IMG LOCALSRC=784>";
            $docomoToEzweb["%i107%"] = "<IMG LOCALSRC=166>";
            $docomoToEzweb["%i108%"] = "[iﾓｰﾄﾞ]";
            $docomoToEzweb["%i109%"] = "[iﾓｰﾄﾞ]";
            $docomoToEzweb["%i110%"] = "<IMG LOCALSRC=108>";
            $docomoToEzweb["%i111%"] = "[ﾄﾞｺﾓ]";
            $docomoToEzweb["%i112%"] = "[ﾄﾞｺﾓﾎﾟｲﾝﾄ]";
            $docomoToEzweb["%i113%"] = "<IMG LOCALSRC=109>";
            $docomoToEzweb["%i114%"] = "<IMG LOCALSRC=299>";
            $docomoToEzweb["%i115%"] = "<IMG LOCALSRC=385>";
            $docomoToEzweb["%i116%"] = "<IMG LOCALSRC=120>";
            $docomoToEzweb["%i117%"] = "<IMG LOCALSRC=118>";
            $docomoToEzweb["%i118%"] = "<IMG LOCALSRC=324>";
            $docomoToEzweb["%i119%"] = "<IMG LOCALSRC=119>";
            $docomoToEzweb["%i120%"] = "<IMG LOCALSRC=334>";
            $docomoToEzweb["%i121%"] = "<IMG LOCALSRC=730>";
            $docomoToEzweb["%i122%"] = "[ﾌﾘｰﾀﾞｲﾔﾙ]";
            $docomoToEzweb["%i123%"] = "<IMG LOCALSRC=818>";
            $docomoToEzweb["%i124%"] = "<IMG LOCALSRC=4>";
            $docomoToEzweb["%i125%"] = "<IMG LOCALSRC=180>";
            $docomoToEzweb["%i126%"] = "<IMG LOCALSRC=181>";
            $docomoToEzweb["%i127%"] = "<IMG LOCALSRC=182>";
            $docomoToEzweb["%i128%"] = "<IMG LOCALSRC=183>";
            $docomoToEzweb["%i129%"] = "<IMG LOCALSRC=184>";
            $docomoToEzweb["%i130%"] = "<IMG LOCALSRC=185>";
            $docomoToEzweb["%i131%"] = "<IMG LOCALSRC=186>";
            $docomoToEzweb["%i132%"] = "<IMG LOCALSRC=187>";
            $docomoToEzweb["%i133%"] = "<IMG LOCALSRC=188>";
            $docomoToEzweb["%i134%"] = "<IMG LOCALSRC=325>";
            $docomoToEzweb["%i135%"] = "<IMG LOCALSRC=326>";
            $docomoToEzweb["%i136%"] = "<IMG LOCALSRC=51>";
            $docomoToEzweb["%i137%"] = "<IMG LOCALSRC=803>";
            $docomoToEzweb["%i138%"] = "<IMG LOCALSRC=265>";
            $docomoToEzweb["%i139%"] = "<IMG LOCALSRC=266>";
            $docomoToEzweb["%i140%"] = "<IMG LOCALSRC=257>";
            $docomoToEzweb["%i141%"] = "<IMG LOCALSRC=258>";
            $docomoToEzweb["%i142%"] = "<IMG LOCALSRC=441>";
            $docomoToEzweb["%i143%"] = "<IMG LOCALSRC=444>";
            $docomoToEzweb["%i144%"] = "<IMG LOCALSRC=327>";
            $docomoToEzweb["%i145%"] = "<IMG LOCALSRC=731>";
            $docomoToEzweb["%i146%"] = "<IMG LOCALSRC=343>";
            $docomoToEzweb["%i147%"] = "<IMG LOCALSRC=224>";
            $docomoToEzweb["%i148%"] = "[かわいい]";
            $docomoToEzweb["%i149%"] = "<IMG LOCALSRC=273>";
            $docomoToEzweb["%i150%"] = "<IMG LOCALSRC=420>";
            $docomoToEzweb["%i151%"] = "<IMG LOCALSRC=77>";
            $docomoToEzweb["%i152%"] = "<IMG LOCALSRC=262>";
            $docomoToEzweb["%i153%"] = "<IMG LOCALSRC=281>";
            $docomoToEzweb["%i154%"] = "<IMG LOCALSRC=268>";
            $docomoToEzweb["%i155%"] = "<IMG LOCALSRC=291>";
            $docomoToEzweb["%i156%"] = "<IMG LOCALSRC=732>";
            $docomoToEzweb["%i157%"] = "<IMG LOCALSRC=261>";
            $docomoToEzweb["%i158%"] = "<IMG LOCALSRC=2>";
            $docomoToEzweb["%i159%"] = "<IMG LOCALSRC=733>";
            $docomoToEzweb["%i160%"] = "<IMG LOCALSRC=734>";
            $docomoToEzweb["%i161%"] = "<IMG LOCALSRC=329>";
            $docomoToEzweb["%i162%"] = "<IMG LOCALSRC=330>";
            $docomoToEzweb["%i163%"] = "<IMG LOCALSRC=263>";
            $docomoToEzweb["%i164%"] = "<IMG LOCALSRC=282>";
            $docomoToEzweb["%i165%"] = "ｰ";
            $docomoToEzweb["%i166%"] = "<IMG LOCALSRC=735>";
            $docomoToEzweb["%i167%"] = "<IMG LOCALSRC=226>";
            $docomoToEzweb["%i168%"] = "[ふくろ]";
            $docomoToEzweb["%i169%"] = "<IMG LOCALSRC=508>";
            $docomoToEzweb["%i170%"] = "[人影]";
            $docomoToEzweb["%i171%"] = "[いす]";
            $docomoToEzweb["%i172%"] = "<IMG LOCALSRC=490>";
            $docomoToEzweb["%i173%"] = "[soon]";
            $docomoToEzweb["%i174%"] = "[on]";
            $docomoToEzweb["%i175%"] = "[end]";
            $docomoToEzweb["%i176%"] = "<IMG LOCALSRC=46>";
            $docomoToEzweb["%i1001%"] = "[iｱﾌﾟﾘ]";
            $docomoToEzweb["%i1002%"] = "[iｱﾌﾟﾘ]";
            $docomoToEzweb["%i1003%"] = "<IMG LOCALSRC=335>";
            $docomoToEzweb["%i1004%"] = "<IMG LOCALSRC=290>";
            $docomoToEzweb["%i1005%"] = "<IMG LOCALSRC=295>";
            $docomoToEzweb["%i1006%"] = "<IMG LOCALSRC=805>";
            $docomoToEzweb["%i1007%"] = "<IMG LOCALSRC=221>";
            $docomoToEzweb["%i1008%"] = "<IMG LOCALSRC=48>";
            $docomoToEzweb["%i1009%"] = "[ﾄﾞｱ]";
            $docomoToEzweb["%i1010%"] = "<IMG LOCALSRC=233>";
            $docomoToEzweb["%i1011%"] = "<IMG LOCALSRC=337>";
            $docomoToEzweb["%i1012%"] = "<IMG LOCALSRC=806>";
            $docomoToEzweb["%i1013%"] = "<IMG LOCALSRC=152>";
            $docomoToEzweb["%i1014%"] = "<IMG LOCALSRC=149>";
            $docomoToEzweb["%i1015%"] = "<IMG LOCALSRC=354>";
            $docomoToEzweb["%i1016%"] = "<IMG LOCALSRC=72>";
            $docomoToEzweb["%i1017%"] = "<IMG LOCALSRC=58>";
            $docomoToEzweb["%i1018%"] = "<IMG LOCALSRC=215>";
            $docomoToEzweb["%i1019%"] = "<IMG LOCALSRC=423>";
            $docomoToEzweb["%i1020%"] = "<IMG LOCALSRC=25>";
            $docomoToEzweb["%i1021%"] = "<IMG LOCALSRC=441>";
            $docomoToEzweb["%i1022%"] = "<IMG LOCALSRC=446>";
            $docomoToEzweb["%i1023%"] = "<IMG LOCALSRC=257><IMG LOCALSRC=330>";
            $docomoToEzweb["%i1024%"] = "<IMG LOCALSRC=351>";
            $docomoToEzweb["%i1025%"] = "<IMG LOCALSRC=779>";
            $docomoToEzweb["%i1026%"] = "<IMG LOCALSRC=450>";
            $docomoToEzweb["%i1027%"] = "<IMG LOCALSRC=349>";
            $docomoToEzweb["%i1028%"] = "<IMG LOCALSRC=287>";
            $docomoToEzweb["%i1029%"] = "<IMG LOCALSRC=264>";
            $docomoToEzweb["%i1030%"] = "<IMG LOCALSRC=348>";
            $docomoToEzweb["%i1031%"] = "<IMG LOCALSRC=446>";
            $docomoToEzweb["%i1032%"] = "<IMG LOCALSRC=443>";
            $docomoToEzweb["%i1033%"] = "<IMG LOCALSRC=440>";
            $docomoToEzweb["%i1034%"] = "<IMG LOCALSRC=259>";
            $docomoToEzweb["%i1035%"] = "<IMG LOCALSRC=791>";
            $docomoToEzweb["%i1036%"] = "[NG]";
            $docomoToEzweb["%i1037%"] = "<IMG LOCALSRC=143>";
            $docomoToEzweb["%i1038%"] = "<IMG LOCALSRC=81>";
            $docomoToEzweb["%i1039%"] = "<IMG LOCALSRC=54>";
            $docomoToEzweb["%i1040%"] = "<IMG LOCALSRC=218>";
            $docomoToEzweb["%i1041%"] = "<IMG LOCALSRC=279>";
            $docomoToEzweb["%i1042%"] = "<IMG LOCALSRC=807>";
            $docomoToEzweb["%i1043%"] = "<IMG LOCALSRC=82>";
            $docomoToEzweb["%i1044%"] = "<IMG LOCALSRC=1>";
            $docomoToEzweb["%i1045%"] = "[禁止]";
            $docomoToEzweb["%i1046%"] = "<IMG LOCALSRC=387>";
            $docomoToEzweb["%i1047%"] = "[合格]";
            $docomoToEzweb["%i1048%"] = "<IMG LOCALSRC=386>";
            $docomoToEzweb["%i1049%"] = "<IMG LOCALSRC=808>";
            $docomoToEzweb["%i1050%"] = "<IMG LOCALSRC=809>";
            $docomoToEzweb["%i1051%"] = "<IMG LOCALSRC=377>";
            $docomoToEzweb["%i1052%"] = "<IMG LOCALSRC=810>";
            $docomoToEzweb["%i1053%"] = "<IMG LOCALSRC=342>";
            $docomoToEzweb["%i1054%"] = "<IMG LOCALSRC=53>";
            $docomoToEzweb["%i1055%"] = "<IMG LOCALSRC=241>";
            $docomoToEzweb["%i1056%"] = "<IMG LOCALSRC=113>";
            $docomoToEzweb["%i1057%"] = "<IMG LOCALSRC=739>";
            $docomoToEzweb["%i1058%"] = "<IMG LOCALSRC=434>";
            $docomoToEzweb["%i1059%"] = "<IMG LOCALSRC=811>";
            $docomoToEzweb["%i1060%"] = "<IMG LOCALSRC=133>";
            $docomoToEzweb["%i1061%"] = "<IMG LOCALSRC=235>";
            $docomoToEzweb["%i1062%"] = "<IMG LOCALSRC=244>";
            $docomoToEzweb["%i1063%"] = "<IMG LOCALSRC=239>";
            $docomoToEzweb["%i1064%"] = "<IMG LOCALSRC=400>";
            $docomoToEzweb["%i1065%"] = "<IMG LOCALSRC=333>";
            $docomoToEzweb["%i1066%"] = "<IMG LOCALSRC=424>";
            $docomoToEzweb["%i1067%"] = "<IMG LOCALSRC=812>";
            $docomoToEzweb["%i1068%"] = "<IMG LOCALSRC=78>";
            $docomoToEzweb["%i1069%"] = "<IMG LOCALSRC=252>";
            $docomoToEzweb["%i1070%"] = "<IMG LOCALSRC=203>";
            $docomoToEzweb["%i1071%"] = "<IMG LOCALSRC=454>";
            $docomoToEzweb["%i1072%"] = "<IMG LOCALSRC=814>";
            $docomoToEzweb["%i1073%"] = "<IMG LOCALSRC=248>";
            $docomoToEzweb["%i1074%"] = "<IMG LOCALSRC=254>";
            $docomoToEzweb["%i1075%"] = "<IMG LOCALSRC=12>";
            $docomoToEzweb["%i1076%"] = "<IMG LOCALSRC=350>";
        }

        return $docomoToEzweb;
    }

    /**
     * getDocomoToSoftbankメソッド
     *
     * Docomo用の変換文字をキーにしたSoftbank絵文字データ配列を返します。
     *
     * @return $docomoToSoftbank Softbank絵文字配列
     */
    public static function getDocomoToSoftbank() {
        static $docomoToSoftbank;

        if (!isset($docomoToSoftbank)) {
            $docomoToSoftbank["%i1%"] = "\x1b\$Gj\x0f";
            $docomoToSoftbank["%i2%"] = "\x1b\$Gi\x0f";
            $docomoToSoftbank["%i3%"] = "\x1b\$Gk\x0f";
            $docomoToSoftbank["%i4%"] = "\x1b\$Gh\x0f";
            $docomoToSoftbank["%i5%"] = "\x1b\$E]\x0f";
            $docomoToSoftbank["%i6%"] = "\x1b\$Pc\x0f";
            $docomoToSoftbank["%i7%"] = "[霧]";
            $docomoToSoftbank["%i8%"] = "\x1b\$P\\x0f";
            $docomoToSoftbank["%i9%"] = "\x1b\$F_\x0f";
            $docomoToSoftbank["%i10%"] = "\x1b\$F`\x0f";
            $docomoToSoftbank["%i11%"] = "\x1b\$Fa\x0f";
            $docomoToSoftbank["%i12%"] = "\x1b\$Fb\x0f";
            $docomoToSoftbank["%i13%"] = "\x1b\$Fc\x0f";
            $docomoToSoftbank["%i14%"] = "\x1b\$Fd\x0f";
            $docomoToSoftbank["%i15%"] = "\x1b\$Fe\x0f";
            $docomoToSoftbank["%i16%"] = "\x1b\$Ff\x0f";
            $docomoToSoftbank["%i17%"] = "\x1b\$Fg\x0f";
            $docomoToSoftbank["%i18%"] = "\x1b\$Fh\x0f";
            $docomoToSoftbank["%i19%"] = "\x1b\$Fi\x0f";
            $docomoToSoftbank["%i20%"] = "\x1b\$Fj\x0f";
            $docomoToSoftbank["%i21%"] = "[ｽﾎﾟｰﾂ]";
            $docomoToSoftbank["%i22%"] = "\x1b\$G6\x0f";
            $docomoToSoftbank["%i23%"] = "\x1b\$G4\x0f";
            $docomoToSoftbank["%i24%"] = "\x1b\$G5\x0f";
            $docomoToSoftbank["%i25%"] = "\x1b\$G8\x0f";
            $docomoToSoftbank["%i26%"] = "\x1b\$G3\x0f";
            $docomoToSoftbank["%i27%"] = "\x1b\$PJ\x0f";
            $docomoToSoftbank["%i28%"] = "\x1b\$ER\x0f";
            $docomoToSoftbank["%i29%"] = "[ﾎﾟｹﾍﾞﾙ]";
            $docomoToSoftbank["%i30%"] = "\x1b\$G>\x0f";
            $docomoToSoftbank["%i31%"] = "\x1b\$PT\x0f";
            $docomoToSoftbank["%i32%"] = "\x1b\$PU\x0f";
            $docomoToSoftbank["%i33%"] = "\x1b\$G;\x0f";
            $docomoToSoftbank["%i34%"] = "\x1b\$PN\x0f";
            $docomoToSoftbank["%i35%"] = "\x1b\$Ey\x0f";
            $docomoToSoftbank["%i36%"] = "\x1b\$F\"\x0f";
            $docomoToSoftbank["%i37%"] = "\x1b\$G=\x0f";
            $docomoToSoftbank["%i38%"] = "\x1b\$GV\x0f";
            $docomoToSoftbank["%i39%"] = "\x1b\$GX\x0f";
            $docomoToSoftbank["%i40%"] = "\x1b\$Es\x0f";
            $docomoToSoftbank["%i41%"] = "\x1b\$Eu\x0f";
            $docomoToSoftbank["%i42%"] = "\x1b\$Em\x0f";
            $docomoToSoftbank["%i43%"] = "\x1b\$Et\x0f";
            $docomoToSoftbank["%i44%"] = "\x1b\$Ex\x0f";
            $docomoToSoftbank["%i45%"] = "\x1b\$Ev\x0f";
            $docomoToSoftbank["%i46%"] = "\x1b\$GZ\x0f";
            $docomoToSoftbank["%i47%"] = "\x1b\$Eo\x0f";
            $docomoToSoftbank["%i48%"] = "\x1b\$En\x0f";
            $docomoToSoftbank["%i49%"] = "\x1b\$Eq\x0f";
            $docomoToSoftbank["%i50%"] = "\x1b\$Gc\x0f";
            $docomoToSoftbank["%i51%"] = "\x1b\$Ge\x0f";
            $docomoToSoftbank["%i52%"] = "\x1b\$Gd\x0f";
            $docomoToSoftbank["%i53%"] = "\x1b\$Gg\x0f";
            $docomoToSoftbank["%i54%"] = "\x1b\$E@\x0f";
            $docomoToSoftbank["%i55%"] = "\x1b\$E^\x0f";
            $docomoToSoftbank["%i56%"] = "\x1b\$O3\x0f";
            $docomoToSoftbank["%i57%"] = "\x1b\$G\\x0f";
            $docomoToSoftbank["%i58%"] = "\x1b\$G]\x0f";
            $docomoToSoftbank["%i59%"] = "\x1b\$FV\x0f";
            $docomoToSoftbank["%i60%"] = "[遊園地]";
            $docomoToSoftbank["%i61%"] = "\x1b\$O*\x0f";
            $docomoToSoftbank["%i62%"] = "\x1b\$Q\"\x0f";
            $docomoToSoftbank["%i63%"] = "\x1b\$Q#\x0f";
            $docomoToSoftbank["%i64%"] = "[ｲﾍﾞﾝﾄ]";
            $docomoToSoftbank["%i65%"] = "\x1b\$EE\x0f";
            $docomoToSoftbank["%i66%"] = "\x1b\$O.\x0f";
            $docomoToSoftbank["%i67%"] = "\x1b\$F(\x0f";
            $docomoToSoftbank["%i68%"] = "\x1b\$G(\x0f";
            $docomoToSoftbank["%i69%"] = "\x1b\$OC\x0f";
            $docomoToSoftbank["%i70%"] = "\x1b\$Eh\x0f";
            $docomoToSoftbank["%i71%"] = "\x1b\$O4\x0f";
            $docomoToSoftbank["%i72%"] = "\x1b\$E2\x0f";
            $docomoToSoftbank["%i73%"] = "\x1b\$Ok\x0f";
            $docomoToSoftbank["%i74%"] = "\x1b\$G)\x0f";
            $docomoToSoftbank["%i75%"] = "\x1b\$G*\x0f";
            $docomoToSoftbank["%i76%"] = "\x1b\$O!\x0f";
            $docomoToSoftbank["%i77%"] = "\x1b\$EJ\x0f";
            $docomoToSoftbank["%i78%"] = "[ｹﾞｰﾑ]";
            $docomoToSoftbank["%i79%"] = "\x1b\$EF\x0f";
            $docomoToSoftbank["%i80%"] = "\x1b\$F,\x0f";
            $docomoToSoftbank["%i81%"] = "\x1b\$F.\x0f";
            $docomoToSoftbank["%i82%"] = "\x1b\$F-\x0f";
            $docomoToSoftbank["%i83%"] = "\x1b\$F/\x0f";
            $docomoToSoftbank["%i84%"] = "\x1b\$P9\x0f";
            $docomoToSoftbank["%i85%"] = "\x1b\$P;\x0f";
            $docomoToSoftbank["%i86%"] = "\x1b\$G0\x0f";
            $docomoToSoftbank["%i87%"] = "\x1b\$G1\x0f";
            $docomoToSoftbank["%i88%"] = "\x1b\$G2\x0f";
            $docomoToSoftbank["%i89%"] = "\x1b\$FX\x0f";
            $docomoToSoftbank["%i90%"] = "\x1b\$FW\x0f";
            $docomoToSoftbank["%i91%"] = "\x1b\$QV\x0f";
            $docomoToSoftbank["%i92%"] = "\x1b\$G'\x0f";
            $docomoToSoftbank["%i93%"] = "[ﾒｶﾞﾈ]";
            $docomoToSoftbank["%i94%"] = "\x1b\$F*\x0f";
            $docomoToSoftbank["%i95%"] = "●";
            $docomoToSoftbank["%i96%"] = "\x1b\$Gl\x0f";
            $docomoToSoftbank["%i97%"] = "\x1b\$Gl\x0f";
            $docomoToSoftbank["%i98%"] = "\x1b\$Gl\x0f";
            $docomoToSoftbank["%i99%"] = "○";
            $docomoToSoftbank["%i100%"] = "\x1b\$Gr\x0f";
            $docomoToSoftbank["%i101%"] = "\x1b\$Go\x0f";
            $docomoToSoftbank["%i102%"] = "\x1b\$G<\x0f";
            $docomoToSoftbank["%i103%"] = "\x1b\$GS\x0f";
            $docomoToSoftbank["%i104%"] = "\x1b\$FY\x0f";
            $docomoToSoftbank["%i105%"] = "\x1b\$E\$\x0f";
            $docomoToSoftbank["%i106%"] = "\x1b\$E#\x0f";
            $docomoToSoftbank["%i107%"] = "\x1b\$G+\x0f";
            $docomoToSoftbank["%i108%"] = "[iﾓｰﾄﾞ]";
            $docomoToSoftbank["%i109%"] = "[iﾓｰﾄﾞ]";
            $docomoToSoftbank["%i110%"] = "\x1b\$E#\x0f";
            $docomoToSoftbank["%i111%"] = "[ﾄﾞｺﾓ]";
            $docomoToSoftbank["%i112%"] = "[ﾄﾞｺﾓﾎﾟｲﾝﾄ]";
            $docomoToSoftbank["%i113%"] = "[有料]";
            $docomoToSoftbank["%i114%"] = "[無料]";
            $docomoToSoftbank["%i115%"] = "\x1b\$FI\x0f";
            $docomoToSoftbank["%i116%"] = "\x1b\$G_\x0f";
            $docomoToSoftbank["%i117%"] = "[次]";
            $docomoToSoftbank["%i118%"] = "[ｸﾘｱ]";
            $docomoToSoftbank["%i119%"] = "\x1b\$E4\x0f";
            $docomoToSoftbank["%i120%"] = "\x1b\$F2\x0f";
            $docomoToSoftbank["%i121%"] = "[位置情報]";
            $docomoToSoftbank["%i122%"] = "\x1b\$F1\x0f";
            $docomoToSoftbank["%i123%"] = "\x1b\$F0\x0f";
            $docomoToSoftbank["%i124%"] = "[ﾓﾊﾞQ]";
            $docomoToSoftbank["%i125%"] = "\x1b\$F<\x0f";
            $docomoToSoftbank["%i126%"] = "\x1b\$F=\x0f";
            $docomoToSoftbank["%i127%"] = "\x1b\$F>\x0f";
            $docomoToSoftbank["%i128%"] = "\x1b\$F?\x0f";
            $docomoToSoftbank["%i129%"] = "\x1b\$F@\x0f";
            $docomoToSoftbank["%i130%"] = "\x1b\$FA\x0f";
            $docomoToSoftbank["%i131%"] = "\x1b\$FB\x0f";
            $docomoToSoftbank["%i132%"] = "\x1b\$FC\x0f";
            $docomoToSoftbank["%i133%"] = "\x1b\$FD\x0f";
            $docomoToSoftbank["%i134%"] = "\x1b\$FE\x0f";
            $docomoToSoftbank["%i135%"] = "\x1b\$Fm\x0f";
            $docomoToSoftbank["%i136%"] = "\x1b\$GB\x0f";
            $docomoToSoftbank["%i137%"] = "\x1b\$OG\x0f";
            $docomoToSoftbank["%i138%"] = "\x1b\$GC\x0f";
            $docomoToSoftbank["%i139%"] = "\x1b\$OG\x0f";
            $docomoToSoftbank["%i140%"] = "\x1b\$Gw\x0f";
            $docomoToSoftbank["%i141%"] = "\x1b\$Gy\x0f";
            $docomoToSoftbank["%i142%"] = "\x1b\$Gx\x0f";
            $docomoToSoftbank["%i143%"] = "\x1b\$P'\x0f";
            $docomoToSoftbank["%i144%"] = "\x1b\$P&\x0f";
            $docomoToSoftbank["%i145%"] = "\x1b\$FV\x0f";
            $docomoToSoftbank["%i146%"] = "\x1b\$G^\x0f";
            $docomoToSoftbank["%i147%"] = "\x1b\$EC\x0f";
            $docomoToSoftbank["%i148%"] = "[かわいい]";
            $docomoToSoftbank["%i149%"] = "\x1b\$G#\x0f";
            $docomoToSoftbank["%i150%"] = "\x1b\$ON\x0f";
            $docomoToSoftbank["%i151%"] = "\x1b\$E/\x0f";
            $docomoToSoftbank["%i152%"] = "\x1b\$OT\x0f";
            $docomoToSoftbank["%i153%"] = "\x1b\$G-\x0f";
            $docomoToSoftbank["%i154%"] = "\x1b\$O1\x0f";
            $docomoToSoftbank["%i155%"] = "\x1b\$OF\x0f";
            $docomoToSoftbank["%i156%"] = "\x1b\$FX\x0f";
            $docomoToSoftbank["%i157%"] = "\x1b\$E\\x0f";
            $docomoToSoftbank["%i158%"] = "\x1b\$GA\x0f";
            $docomoToSoftbank["%i159%"] = "\x1b\$!?\x0f";
            $docomoToSoftbank["%i160%"] = "\x1b\$!!\x0f";
            $docomoToSoftbank["%i161%"] = "[衝撃]";
            $docomoToSoftbank["%i162%"] = "\x1b\$OQ\x0f";
            $docomoToSoftbank["%i163%"] = "\x1b\$OQ\x0f";
            $docomoToSoftbank["%i164%"] = "\x1b\$OP\x0f";
            $docomoToSoftbank["%i165%"] = "ｰ";
            $docomoToSoftbank["%i166%"] = "ｰ";
            $docomoToSoftbank["%i167%"] = "\x1b\$OD\x0f";
            $docomoToSoftbank["%i168%"] = "[ふくろ]";
            $docomoToSoftbank["%i169%"] = "[ﾍﾟﾝ]";
            $docomoToSoftbank["%i170%"] = "[人影]";
            $docomoToSoftbank["%i171%"] = "\x1b\$E?\x0f";
            $docomoToSoftbank["%i172%"] = "\x1b\$Pk\x0f";
            $docomoToSoftbank["%i173%"] = "[soon]";
            $docomoToSoftbank["%i174%"] = "[on]";
            $docomoToSoftbank["%i175%"] = "[end]";
            $docomoToSoftbank["%i176%"] = "\x1b\$GM\x0f";
            $docomoToSoftbank["%i1001%"] = "[iｱﾌﾟﾘ]";
            $docomoToSoftbank["%i1002%"] = "[iｱﾌﾟﾘ]";
            $docomoToSoftbank["%i1003%"] = "\x1b\$G&\x0f";
            $docomoToSoftbank["%i1004%"] = "[財布]";
            $docomoToSoftbank["%i1005%"] = "\x1b\$O<\x0f";
            $docomoToSoftbank["%i1006%"] = "[ｼﾞｰﾝｽﾞ]";
            $docomoToSoftbank["%i1007%"] = "[ｽﾉﾎﾞ]";
            $docomoToSoftbank["%i1008%"] = "\x1b\$OE\x0f";
            $docomoToSoftbank["%i1009%"] = "[ﾄﾞｱ]";
            $docomoToSoftbank["%i1010%"] = "\x1b\$EO\x0f";
            $docomoToSoftbank["%i1011%"] = "\x1b\$G,\x0f";
            $docomoToSoftbank["%i1012%"] = "\x1b\$E#\x0f\$OH\x0f";
            $docomoToSoftbank["%i1013%"] = "[ﾚﾝﾁ]";
            $docomoToSoftbank["%i1014%"] = "\x1b\$O!\x0f";
            $docomoToSoftbank["%i1015%"] = "\x1b\$E.\x0f";
            $docomoToSoftbank["%i1016%"] = "\x1b\$GT\x0f";
            $docomoToSoftbank["%i1017%"] = "[砂時計]";
            $docomoToSoftbank["%i1018%"] = "\x1b\$EV\x0f";
            $docomoToSoftbank["%i1019%"] = "\x1b\$OX\x0f";
            $docomoToSoftbank["%i1020%"] = "[腕時計]";
            $docomoToSoftbank["%i1021%"] = "\x1b\$P#\x0f";
            $docomoToSoftbank["%i1022%"] = "\x1b\$P*\x0f";
            $docomoToSoftbank["%i1023%"] = "\x1b\$P5\x0f\$OQ\x0f";
            $docomoToSoftbank["%i1024%"] = "\x1b\$E(\x0f";
            $docomoToSoftbank["%i1025%"] = "\x1b\$P6\x0f";
            $docomoToSoftbank["%i1026%"] = "\x1b\$P.\x0f";
            $docomoToSoftbank["%i1027%"] = "\x1b\$E&\x0f";
            $docomoToSoftbank["%i1028%"] = "\x1b\$G.\x0f";
            $docomoToSoftbank["%i1029%"] = "\x1b\$E%\x0f";
            $docomoToSoftbank["%i1030%"] = "\x1b\$P%\x0f";
            $docomoToSoftbank["%i1031%"] = "\x1b\$P*\x0f";
            $docomoToSoftbank["%i1032%"] = "\x1b\$P&\x0f";
            $docomoToSoftbank["%i1033%"] = "\x1b\$P\"\x0f";
            $docomoToSoftbank["%i1034%"] = "\x1b\$P1\x0f";
            $docomoToSoftbank["%i1035%"] = "\x1b\$P3\x0f";
            $docomoToSoftbank["%i1036%"] = "[NG]";
            $docomoToSoftbank["%i1037%"] = "[ｸﾘｯﾌﾟ]";
            $docomoToSoftbank["%i1038%"] = "\x1b\$Fn\x0f";
            $docomoToSoftbank["%i1039%"] = "\x1b\$QW\x0f";
            $docomoToSoftbank["%i1040%"] = "\x1b\$E5\x0f";
            $docomoToSoftbank["%i1041%"] = "\x1b\$O5\x0f";
            $docomoToSoftbank["%i1042%"] = "[ﾘｻｲｸﾙ]";
            $docomoToSoftbank["%i1043%"] = "\x1b\$Fo\x0f";
            $docomoToSoftbank["%i1044%"] = "\x1b\$Fr\x0f";
            $docomoToSoftbank["%i1045%"] = "[禁止]";
            $docomoToSoftbank["%i1046%"] = "\x1b\$FK\x0f";
            $docomoToSoftbank["%i1047%"] = "[合格]";
            $docomoToSoftbank["%i1048%"] = "\x1b\$FJ\x0f";
            $docomoToSoftbank["%i1049%"] = "⇔";
            $docomoToSoftbank["%i1050%"] = "↑↓";
            $docomoToSoftbank["%i1051%"] = "\x1b\$Ew\x0f";
            $docomoToSoftbank["%i1052%"] = "\x1b\$P^\x0f";
            $docomoToSoftbank["%i1053%"] = "\x1b\$G[\x0f";
            $docomoToSoftbank["%i1054%"] = "\x1b\$E0\x0f";
            $docomoToSoftbank["%i1055%"] = "[さくらんぼ]";
            $docomoToSoftbank["%i1056%"] = "\x1b\$O\$\x0f";
            $docomoToSoftbank["%i1057%"] = "[ﾊﾞﾅﾅ]";
            $docomoToSoftbank["%i1058%"] = "\x1b\$Oe\x0f";
            $docomoToSoftbank["%i1059%"] = "\x1b\$E0\x0f";
            $docomoToSoftbank["%i1060%"] = "\x1b\$E8\x0f";
            $docomoToSoftbank["%i1061%"] = "\x1b\$GP\x0f";
            $docomoToSoftbank["%i1062%"] = "\x1b\$Ob\x0f";
            $docomoToSoftbank["%i1063%"] = "\x1b\$Gf\x0f";
            $docomoToSoftbank["%i1064%"] = "\x1b\$O+\x0f";
            $docomoToSoftbank["%i1065%"] = "\x1b\$O`\x0f";
            $docomoToSoftbank["%i1066%"] = "\x1b\$OY\x0f";
            $docomoToSoftbank["%i1067%"] = "[ｶﾀﾂﾑﾘ]";
            $docomoToSoftbank["%i1068%"] = "\x1b\$QC\x0f";
            $docomoToSoftbank["%i1069%"] = "\x1b\$Gu\x0f";
            $docomoToSoftbank["%i1070%"] = "\x1b\$G9\x0f";
            $docomoToSoftbank["%i1071%"] = "\x1b\$Gv\x0f";
            $docomoToSoftbank["%i1072%"] = "\x1b\$P\$\x0f";
            $docomoToSoftbank["%i1073%"] = "\x1b\$G:\x0f";
            $docomoToSoftbank["%i1074%"] = "\x1b\$E+\x0f";
            $docomoToSoftbank["%i1075%"] = "\x1b\$Gd\x0f";
            $docomoToSoftbank["%i1076%"] = "\x1b\$E'\x0f";
        }

        return $docomoToSoftbank;
    }

    /**
     * getEzwebEmojiメソッド
     *
     * Ezweb用の変換文字をキーにしたEzweb絵文字データ配列を返します。
     *
     * @return $ezwebEmoji Ezweb絵文字配列
     */
    public static function getEzwebEmoji() {
        static $ezwebEmoji;

        if (!isset($ezwebEmoji)) {
            $ezwebEmoji["%e1%"] = "\xf6\x59";
            $ezwebEmoji["%e2%"] = "\xf6\x5a";
            $ezwebEmoji["%e3%"] = "\xf6\x5b";
            $ezwebEmoji["%e4%"] = "\xf7\x48";
            $ezwebEmoji["%e5%"] = "\xf7\x49";
            $ezwebEmoji["%e6%"] = "\xf7\x4a";
            $ezwebEmoji["%e7%"] = "\xf7\x4b";
            $ezwebEmoji["%e8%"] = "\xf7\x4c";
            $ezwebEmoji["%e9%"] = "\xf7\x4d";
            $ezwebEmoji["%e10%"] = "\xf7\x4e";
            $ezwebEmoji["%e11%"] = "\xf7\x4f";
            $ezwebEmoji["%e12%"] = "\xf6\x9a";
            $ezwebEmoji["%e13%"] = "\xf6\xea";
            $ezwebEmoji["%e14%"] = "\xf7\x96";
            $ezwebEmoji["%e15%"] = "\xf6\x5e";
            $ezwebEmoji["%e16%"] = "\xf6\x5f";
            $ezwebEmoji["%e17%"] = "\xf7\x50";
            $ezwebEmoji["%e18%"] = "\xf7\x51";
            $ezwebEmoji["%e19%"] = "\xf7\x52";
            $ezwebEmoji["%e20%"] = "\xf7\x53";
            $ezwebEmoji["%e21%"] = "\xf7\x54";
            $ezwebEmoji["%e22%"] = "\xf7\x55";
            $ezwebEmoji["%e23%"] = "\xf7\x56";
            $ezwebEmoji["%e24%"] = "\xf7\x57";
            $ezwebEmoji["%e25%"] = "\xf7\x97";
            $ezwebEmoji["%e26%"] = "\xf7\x58";
            $ezwebEmoji["%e27%"] = "\xf7\x59";
            $ezwebEmoji["%e28%"] = "\xf7\x5a";
            $ezwebEmoji["%e29%"] = "\xf7\x5b";
            $ezwebEmoji["%e30%"] = "\xf7\x5c";
            $ezwebEmoji["%e31%"] = "\xf7\x5d";
            $ezwebEmoji["%e32%"] = "\xf7\x5e";
            $ezwebEmoji["%e33%"] = "\xf7\x5f";
            $ezwebEmoji["%e34%"] = "\xf7\x60";
            $ezwebEmoji["%e35%"] = "\xf7\x61";
            $ezwebEmoji["%e36%"] = "\xf7\x62";
            $ezwebEmoji["%e37%"] = "\xf7\x63";
            $ezwebEmoji["%e38%"] = "\xf7\x64";
            $ezwebEmoji["%e39%"] = "\xf7\x65";
            $ezwebEmoji["%e40%"] = "\xf7\x66";
            $ezwebEmoji["%e41%"] = "\xf7\x67";
            $ezwebEmoji["%e42%"] = "\xf7\x68";
            $ezwebEmoji["%e43%"] = "\xf7\x69";
            $ezwebEmoji["%e44%"] = "\xf6\x60";
            $ezwebEmoji["%e45%"] = "\xf6\x93";
            $ezwebEmoji["%e46%"] = "\xf7\xb1";
            $ezwebEmoji["%e47%"] = "\xf6\x61";
            $ezwebEmoji["%e48%"] = "\xf6\xeb";
            $ezwebEmoji["%e49%"] = "\xf7\x7c";
            $ezwebEmoji["%e50%"] = "\xf6\xd3";
            $ezwebEmoji["%e51%"] = "\xf7\xb2";
            $ezwebEmoji["%e52%"] = "\xf6\x9b";
            $ezwebEmoji["%e53%"] = "\xf6\xec";
            $ezwebEmoji["%e54%"] = "\xf7\x6a";
            $ezwebEmoji["%e55%"] = "\xf7\x6b";
            $ezwebEmoji["%e56%"] = "\xf7\x7d";
            $ezwebEmoji["%e57%"] = "\xf7\x98";
            $ezwebEmoji["%e58%"] = "\xf6\x54";
            $ezwebEmoji["%e59%"] = "\xf7\x7e";
            $ezwebEmoji["%e60%"] = "\xf6\x62";
            $ezwebEmoji["%e61%"] = "\xf7\x6c";
            $ezwebEmoji["%e62%"] = "\xf7\x6d";
            $ezwebEmoji["%e63%"] = "\xf7\x6e";
            $ezwebEmoji["%e64%"] = "\xf7\x6f";
            $ezwebEmoji["%e65%"] = "\xf6\x9c";
            $ezwebEmoji["%e66%"] = "\xf7\x70";
            $ezwebEmoji["%e67%"] = "\xf7\x80";
            $ezwebEmoji["%e68%"] = "\xf6\xd4";
            $ezwebEmoji["%e69%"] = "\xf6\x63";
            $ezwebEmoji["%e70%"] = "\xf7\x71";
            $ezwebEmoji["%e71%"] = "\xf7\x72";
            $ezwebEmoji["%e72%"] = "\xf6\xed";
            $ezwebEmoji["%e73%"] = "\xf7\x73";
            $ezwebEmoji["%e74%"] = "\xf6\xb8";
            $ezwebEmoji["%e75%"] = "\xf6\x40";
            $ezwebEmoji["%e76%"] = "\xf6\x44";
            $ezwebEmoji["%e77%"] = "\xf6\x4e";
            $ezwebEmoji["%e78%"] = "\xf6\xb9";
            $ezwebEmoji["%e79%"] = "\xf7\xac";
            $ezwebEmoji["%e80%"] = "\xf6\xd5";
            $ezwebEmoji["%e81%"] = "\xf7\x74";
            $ezwebEmoji["%e82%"] = "\xf7\x75";
            $ezwebEmoji["%e83%"] = "\xf6\x74";
            $ezwebEmoji["%e84%"] = "\xf7\xad";
            $ezwebEmoji["%e85%"] = "\xf7\xb3";
            $ezwebEmoji["%e86%"] = "\xf6\xd6";
            $ezwebEmoji["%e87%"] = "\xf7\x99";
            $ezwebEmoji["%e88%"] = "\xf7\x76";
            $ezwebEmoji["%e89%"] = "\xf7\x77";
            $ezwebEmoji["%e90%"] = "\xf7\x90";
            $ezwebEmoji["%e91%"] = "\xf6\x75";
            $ezwebEmoji["%e92%"] = "\xf7\x81";
            $ezwebEmoji["%e93%"] = "\xf7\xb4";
            $ezwebEmoji["%e94%"] = "\xf6\xee";
            $ezwebEmoji["%e95%"] = "\xf6\x64";
            $ezwebEmoji["%e96%"] = "\xf6\x94";
            $ezwebEmoji["%e97%"] = "\xf7\x82";
            $ezwebEmoji["%e98%"] = "\xf6\x5c";
            $ezwebEmoji["%e99%"] = "\xf6\x42";
            $ezwebEmoji["%e100%"] = "\xf7\x83";
            $ezwebEmoji["%e101%"] = "\xf7\x84";
            $ezwebEmoji["%e102%"] = "\xf7\x85";
            $ezwebEmoji["%e103%"] = "\xf7\x86";
            $ezwebEmoji["%e104%"] = "\xf6\xef";
            $ezwebEmoji["%e105%"] = "\xf7\x87";
            $ezwebEmoji["%e106%"] = "\xf6\x76";
            $ezwebEmoji["%e107%"] = "\xf6\x65";
            $ezwebEmoji["%e108%"] = "\xf6\xfa";
            $ezwebEmoji["%e109%"] = "\xf7\x9a";
            $ezwebEmoji["%e110%"] = "\xf6\xf0";
            $ezwebEmoji["%e111%"] = "\xf7\x9b";
            $ezwebEmoji["%e112%"] = "\xf6\x84";
            $ezwebEmoji["%e113%"] = "\xf6\xbd";
            $ezwebEmoji["%e114%"] = "\xf7\x9c";
            $ezwebEmoji["%e115%"] = "\xf7\x9d";
            $ezwebEmoji["%e116%"] = "\xf6\xd7";
            $ezwebEmoji["%e117%"] = "\xf7\x78";
            $ezwebEmoji["%e118%"] = "\xf7\x79";
            $ezwebEmoji["%e119%"] = "\xf6\xf1";
            $ezwebEmoji["%e120%"] = "\xf6\xf2";
            $ezwebEmoji["%e121%"] = "\xf7\x88";
            $ezwebEmoji["%e122%"] = "\xf6\x77";
            $ezwebEmoji["%e123%"] = "\xf7\x9e";
            $ezwebEmoji["%e124%"] = "\xf6\xf3";
            $ezwebEmoji["%e125%"] = "\xf6\x8a";
            $ezwebEmoji["%e126%"] = "\xf7\x9f";
            $ezwebEmoji["%e127%"] = "\xf7\x91";
            $ezwebEmoji["%e128%"] = "\xf7\x92";
            $ezwebEmoji["%e129%"] = "\xf6\xf4";
            $ezwebEmoji["%e130%"] = "\xf7\xa0";
            $ezwebEmoji["%e131%"] = "\xf7\x89";
            $ezwebEmoji["%e132%"] = "\xf7\x7a";
            $ezwebEmoji["%e133%"] = "\xf6\xa7";
            $ezwebEmoji["%e134%"] = "\xf6\xba";
            $ezwebEmoji["%e135%"] = "\xf7\xa1";
            $ezwebEmoji["%e136%"] = "\xf7\x7b";
            $ezwebEmoji["%e137%"] = "\xf7\x8a";
            $ezwebEmoji["%e138%"] = "\xf6\xf5";
            $ezwebEmoji["%e139%"] = "\xf7\xa2";
            $ezwebEmoji["%e140%"] = "\xf6\xd8";
            $ezwebEmoji["%e141%"] = "\xf6\xd9";
            $ezwebEmoji["%e142%"] = "\xf7\x8b";
            $ezwebEmoji["%e143%"] = "\xf6\x78";
            $ezwebEmoji["%e144%"] = "\xf6\xa8";
            $ezwebEmoji["%e145%"] = "\xf6\xf6";
            $ezwebEmoji["%e146%"] = "\xf6\x85";
            $ezwebEmoji["%e147%"] = "\xf7\x8c";
            $ezwebEmoji["%e148%"] = "\xf6\x8b";
            $ezwebEmoji["%e149%"] = "\xf6\x79";
            $ezwebEmoji["%e150%"] = "\xf7\xa3";
            $ezwebEmoji["%e151%"] = "\xf7\xae";
            $ezwebEmoji["%e152%"] = "\xf7\xa4";
            $ezwebEmoji["%e153%"] = "\xf7\xaf";
            $ezwebEmoji["%e154%"] = "\xf7\xb0";
            $ezwebEmoji["%e155%"] = "\xf6\xf7";
            $ezwebEmoji["%e156%"] = "\xf6\x86";
            $ezwebEmoji["%e157%"] = "\xf7\x8d";
            $ezwebEmoji["%e158%"] = "\xf6\x7a";
            $ezwebEmoji["%e159%"] = "\xf7\x93";
            $ezwebEmoji["%e160%"] = "\xf6\x9d";
            $ezwebEmoji["%e161%"] = "\xf7\xa5";
            $ezwebEmoji["%e162%"] = "\xf7\xa6";
            $ezwebEmoji["%e163%"] = "\xf6\xda";
            $ezwebEmoji["%e164%"] = "\xf7\xa7";
            $ezwebEmoji["%e165%"] = "\xf6\xf8";
            $ezwebEmoji["%e166%"] = "\xf6\xf9";
            $ezwebEmoji["%e167%"] = "\xf6\x66";
            $ezwebEmoji["%e168%"] = "\xf6\x8c";
            $ezwebEmoji["%e169%"] = "\xf6\x8d";
            $ezwebEmoji["%e170%"] = "\xf6\xa1";
            $ezwebEmoji["%e171%"] = "\xf7\xa8";
            $ezwebEmoji["%e172%"] = "\xf6\x8e";
            $ezwebEmoji["%e173%"] = "\xf7\xa9";
            $ezwebEmoji["%e174%"] = "\xf7\xaa";
            $ezwebEmoji["%e175%"] = "\xf7\xab";
            $ezwebEmoji["%e176%"] = "\xf6\x55";
            $ezwebEmoji["%e177%"] = "\xf6\x56";
            $ezwebEmoji["%e178%"] = "\xf6\x57";
            $ezwebEmoji["%e179%"] = "\xf6\x58";
            $ezwebEmoji["%e180%"] = "\xf6\xfb";
            $ezwebEmoji["%e181%"] = "\xf6\xfc";
            $ezwebEmoji["%e182%"] = "\xf7\x40";
            $ezwebEmoji["%e183%"] = "\xf7\x41";
            $ezwebEmoji["%e184%"] = "\xf7\x42";
            $ezwebEmoji["%e185%"] = "\xf7\x43";
            $ezwebEmoji["%e186%"] = "\xf7\x44";
            $ezwebEmoji["%e187%"] = "\xf7\x45";
            $ezwebEmoji["%e188%"] = "\xf7\x46";
            $ezwebEmoji["%e189%"] = "\xf7\x47";
            $ezwebEmoji["%e190%"] = "\xf6\x41";
            $ezwebEmoji["%e191%"] = "\xf6\x5d";
            $ezwebEmoji["%e192%"] = "\xf6\x67";
            $ezwebEmoji["%e193%"] = "\xf6\x68";
            $ezwebEmoji["%e194%"] = "\xf6\x69";
            $ezwebEmoji["%e195%"] = "\xf6\x6a";
            $ezwebEmoji["%e196%"] = "\xf6\x6b";
            $ezwebEmoji["%e197%"] = "\xf6\x6c";
            $ezwebEmoji["%e198%"] = "\xf6\x6d";
            $ezwebEmoji["%e199%"] = "\xf6\x6e";
            $ezwebEmoji["%e200%"] = "\xf6\x6f";
            $ezwebEmoji["%e201%"] = "\xf6\x70";
            $ezwebEmoji["%e202%"] = "\xf6\x71";
            $ezwebEmoji["%e203%"] = "\xf6\x72";
            $ezwebEmoji["%e204%"] = "\xf6\x73";
            $ezwebEmoji["%e205%"] = "\xf6\x7b";
            $ezwebEmoji["%e206%"] = "\xf6\x7c";
            $ezwebEmoji["%e207%"] = "\xf6\x7d";
            $ezwebEmoji["%e208%"] = "\xf6\x7e";
            $ezwebEmoji["%e209%"] = "\xf6\x80";
            $ezwebEmoji["%e210%"] = "\xf6\x81";
            $ezwebEmoji["%e211%"] = "\xf6\x82";
            $ezwebEmoji["%e212%"] = "\xf6\x83";
            $ezwebEmoji["%e213%"] = "\xf7\x8e";
            $ezwebEmoji["%e214%"] = "\xf7\x8f";
            $ezwebEmoji["%e215%"] = "\xf6\x87";
            $ezwebEmoji["%e216%"] = "\xf6\x88";
            $ezwebEmoji["%e217%"] = "\xf6\x89";
            $ezwebEmoji["%e218%"] = "\xf6\x43";
            $ezwebEmoji["%e219%"] = "\xf6\x8f";
            $ezwebEmoji["%e220%"] = "\xf6\x90";
            $ezwebEmoji["%e221%"] = "\xf6\x91";
            $ezwebEmoji["%e222%"] = "\xf6\x92";
            $ezwebEmoji["%e223%"] = "\xf6\x45";
            $ezwebEmoji["%e224%"] = "\xf6\x95";
            $ezwebEmoji["%e225%"] = "\xf6\x96";
            $ezwebEmoji["%e226%"] = "\xf6\x97";
            $ezwebEmoji["%e227%"] = "\xf6\x98";
            $ezwebEmoji["%e228%"] = "\xf6\x99";
            $ezwebEmoji["%e229%"] = "\xf6\x46";
            $ezwebEmoji["%e230%"] = "\xf6\x47";
            $ezwebEmoji["%e231%"] = "\xf6\x9e";
            $ezwebEmoji["%e232%"] = "\xf6\x9f";
            $ezwebEmoji["%e233%"] = "\xf6\xa0";
            $ezwebEmoji["%e234%"] = "\xf6\xa2";
            $ezwebEmoji["%e235%"] = "\xf6\xa3";
            $ezwebEmoji["%e236%"] = "\xf6\xa4";
            $ezwebEmoji["%e237%"] = "\xf6\xa5";
            $ezwebEmoji["%e238%"] = "\xf6\xa6";
            $ezwebEmoji["%e239%"] = "\xf6\xa9";
            $ezwebEmoji["%e240%"] = "\xf6\xaa";
            $ezwebEmoji["%e241%"] = "\xf6\xab";
            $ezwebEmoji["%e242%"] = "\xf6\xac";
            $ezwebEmoji["%e243%"] = "\xf6\xad";
            $ezwebEmoji["%e244%"] = "\xf6\xae";
            $ezwebEmoji["%e245%"] = "\xf6\xaf";
            $ezwebEmoji["%e246%"] = "\xf6\x48";
            $ezwebEmoji["%e247%"] = "\xf6\xb0";
            $ezwebEmoji["%e248%"] = "\xf6\xb1";
            $ezwebEmoji["%e249%"] = "\xf6\xb2";
            $ezwebEmoji["%e250%"] = "\xf6\xb3";
            $ezwebEmoji["%e251%"] = "\xf6\xb4";
            $ezwebEmoji["%e252%"] = "\xf6\xb5";
            $ezwebEmoji["%e253%"] = "\xf6\xb6";
            $ezwebEmoji["%e254%"] = "\xf6\xb7";
            $ezwebEmoji["%e255%"] = "\xf6\xbb";
            $ezwebEmoji["%e256%"] = "\xf6\xbc";
            $ezwebEmoji["%e257%"] = "\xf6\x49";
            $ezwebEmoji["%e258%"] = "\xf6\x4a";
            $ezwebEmoji["%e259%"] = "\xf6\x4b";
            $ezwebEmoji["%e260%"] = "\xf6\x4c";
            $ezwebEmoji["%e261%"] = "\xf6\x4d";
            $ezwebEmoji["%e262%"] = "\xf6\xbe";
            $ezwebEmoji["%e263%"] = "\xf6\xbf";
            $ezwebEmoji["%e264%"] = "\xf6\xc0";
            $ezwebEmoji["%e265%"] = "\xf6\x4f";
            $ezwebEmoji["%e266%"] = "\xf6\x50";
            $ezwebEmoji["%e267%"] = "\xf6\x51";
            $ezwebEmoji["%e268%"] = "\xf6\x52";
            $ezwebEmoji["%e269%"] = "\xf6\x53";
            $ezwebEmoji["%e270%"] = "\xf6\xc1";
            $ezwebEmoji["%e271%"] = "\xf6\xc2";
            $ezwebEmoji["%e272%"] = "\xf6\xc3";
            $ezwebEmoji["%e273%"] = "\xf6\xc4";
            $ezwebEmoji["%e274%"] = "\xf6\xc5";
            $ezwebEmoji["%e275%"] = "\xf6\xc6";
            $ezwebEmoji["%e276%"] = "\xf6\xc7";
            $ezwebEmoji["%e277%"] = "\xf6\xc8";
            $ezwebEmoji["%e278%"] = "\xf6\xc9";
            $ezwebEmoji["%e279%"] = "\xf6\xca";
            $ezwebEmoji["%e280%"] = "\xf6\xcb";
            $ezwebEmoji["%e281%"] = "\xf6\xcc";
            $ezwebEmoji["%e282%"] = "\xf6\xcd";
            $ezwebEmoji["%e283%"] = "\xf6\xce";
            $ezwebEmoji["%e284%"] = "\xf6\xcf";
            $ezwebEmoji["%e285%"] = "\xf6\xd0";
            $ezwebEmoji["%e286%"] = "\xf6\xd1";
            $ezwebEmoji["%e287%"] = "\xf6\xd2";
            $ezwebEmoji["%e288%"] = "\xf6\xdb";
            $ezwebEmoji["%e289%"] = "\xf6\xdc";
            $ezwebEmoji["%e290%"] = "\xf6\xdd";
            $ezwebEmoji["%e291%"] = "\xf6\xde";
            $ezwebEmoji["%e292%"] = "\xf6\xdf";
            $ezwebEmoji["%e293%"] = "\xf6\xe0";
            $ezwebEmoji["%e294%"] = "\xf6\xe1";
            $ezwebEmoji["%e295%"] = "\xf6\xe2";
            $ezwebEmoji["%e296%"] = "\xf6\xe3";
            $ezwebEmoji["%e297%"] = "\xf6\xe4";
            $ezwebEmoji["%e298%"] = "\xf7\x94";
            $ezwebEmoji["%e299%"] = "\xf7\x95";
            $ezwebEmoji["%e300%"] = "\xf6\xe5";
            $ezwebEmoji["%e301%"] = "\xf6\xe6";
            $ezwebEmoji["%e302%"] = "\xf6\xe7";
            $ezwebEmoji["%e303%"] = "\xf6\xe8";
            $ezwebEmoji["%e304%"] = "\xf6\xe9";
            $ezwebEmoji["%e305%"] = "\xf7\xb5";
            $ezwebEmoji["%e306%"] = "\xf7\xb6";
            $ezwebEmoji["%e307%"] = "\xf7\xb7";
            $ezwebEmoji["%e308%"] = "\xf7\xb8";
            $ezwebEmoji["%e309%"] = "\xf7\xb9";
            $ezwebEmoji["%e310%"] = "\xf7\xba";
            $ezwebEmoji["%e311%"] = "\xf7\xbb";
            $ezwebEmoji["%e312%"] = "\xf7\xbc";
            $ezwebEmoji["%e313%"] = "\xf7\xbd";
            $ezwebEmoji["%e314%"] = "\xf7\xbe";
            $ezwebEmoji["%e315%"] = "\xf7\xbf";
            $ezwebEmoji["%e316%"] = "\xf7\xc0";
            $ezwebEmoji["%e317%"] = "\xf7\xc1";
            $ezwebEmoji["%e318%"] = "\xf7\xc2";
            $ezwebEmoji["%e319%"] = "\xf7\xc3";
            $ezwebEmoji["%e320%"] = "\xf7\xc4";
            $ezwebEmoji["%e321%"] = "\xf7\xc5";
            $ezwebEmoji["%e322%"] = "\xf7\xc6";
            $ezwebEmoji["%e323%"] = "\xf7\xc7";
            $ezwebEmoji["%e324%"] = "\xf7\xc8";
            $ezwebEmoji["%e325%"] = "\xf7\xc9";
            $ezwebEmoji["%e326%"] = "\xf7\xca";
            $ezwebEmoji["%e327%"] = "\xf7\xcb";
            $ezwebEmoji["%e328%"] = "\xf7\xcc";
            $ezwebEmoji["%e329%"] = "\xf7\xcd";
            $ezwebEmoji["%e330%"] = "\xf7\xce";
            $ezwebEmoji["%e331%"] = "\xf7\xcf";
            $ezwebEmoji["%e332%"] = "\xf7\xd0";
            $ezwebEmoji["%e333%"] = "\xf7\xd1";
            $ezwebEmoji["%e334%"] = "\xf7\xe5";
            $ezwebEmoji["%e335%"] = "\xf7\xe6";
            $ezwebEmoji["%e336%"] = "\xf7\xe7";
            $ezwebEmoji["%e337%"] = "\xf7\xe8";
            $ezwebEmoji["%e338%"] = "\xf7\xe9";
            $ezwebEmoji["%e339%"] = "\xf7\xea";
            $ezwebEmoji["%e340%"] = "\xf7\xeb";
            $ezwebEmoji["%e341%"] = "\xf7\xec";
            $ezwebEmoji["%e342%"] = "\xf7\xed";
            $ezwebEmoji["%e343%"] = "\xf7\xee";
            $ezwebEmoji["%e344%"] = "\xf7\xef";
            $ezwebEmoji["%e345%"] = "\xf7\xf0";
            $ezwebEmoji["%e346%"] = "\xf7\xf1";
            $ezwebEmoji["%e347%"] = "\xf7\xf2";
            $ezwebEmoji["%e348%"] = "\xf7\xf3";
            $ezwebEmoji["%e349%"] = "\xf7\xf4";
            $ezwebEmoji["%e350%"] = "\xf7\xf5";
            $ezwebEmoji["%e351%"] = "\xf7\xf6";
            $ezwebEmoji["%e352%"] = "\xf7\xf7";
            $ezwebEmoji["%e353%"] = "\xf7\xf8";
            $ezwebEmoji["%e354%"] = "\xf7\xf9";
            $ezwebEmoji["%e355%"] = "\xf7\xfa";
            $ezwebEmoji["%e356%"] = "\xf7\xfb";
            $ezwebEmoji["%e357%"] = "\xf7\xfc";
            $ezwebEmoji["%e358%"] = "\xf3\x40";
            $ezwebEmoji["%e359%"] = "\xf3\x41";
            $ezwebEmoji["%e360%"] = "\xf3\x42";
            $ezwebEmoji["%e361%"] = "\xf3\x43";
            $ezwebEmoji["%e362%"] = "\xf3\x44";
            $ezwebEmoji["%e363%"] = "\xf3\x45";
            $ezwebEmoji["%e364%"] = "\xf3\x46";
            $ezwebEmoji["%e365%"] = "\xf3\x47";
            $ezwebEmoji["%e366%"] = "\xf3\x48";
            $ezwebEmoji["%e367%"] = "\xf3\x49";
            $ezwebEmoji["%e368%"] = "\xf3\x4a";
            $ezwebEmoji["%e369%"] = "\xf3\x4b";
            $ezwebEmoji["%e370%"] = "\xf3\x4c";
            $ezwebEmoji["%e371%"] = "\xf3\x4d";
            $ezwebEmoji["%e372%"] = "\xf3\x4e";
            $ezwebEmoji["%e373%"] = "\xf3\x4f";
            $ezwebEmoji["%e374%"] = "\xf3\x50";
            $ezwebEmoji["%e375%"] = "\xf3\x51";
            $ezwebEmoji["%e376%"] = "\xf3\x52";
            $ezwebEmoji["%e377%"] = "\xf3\x53";
            $ezwebEmoji["%e378%"] = "\xf3\x54";
            $ezwebEmoji["%e379%"] = "\xf3\x55";
            $ezwebEmoji["%e380%"] = "\xf3\x56";
            $ezwebEmoji["%e381%"] = "\xf3\x57";
            $ezwebEmoji["%e382%"] = "\xf3\x58";
            $ezwebEmoji["%e383%"] = "\xf3\x59";
            $ezwebEmoji["%e384%"] = "\xf3\x5a";
            $ezwebEmoji["%e385%"] = "\xf3\x5b";
            $ezwebEmoji["%e386%"] = "\xf3\x5c";
            $ezwebEmoji["%e387%"] = "\xf3\x5d";
            $ezwebEmoji["%e388%"] = "\xf3\x5e";
            $ezwebEmoji["%e389%"] = "\xf3\x5f";
            $ezwebEmoji["%e390%"] = "\xf3\x60";
            $ezwebEmoji["%e391%"] = "\xf3\x61";
            $ezwebEmoji["%e392%"] = "\xf3\x62";
            $ezwebEmoji["%e393%"] = "\xf3\x63";
            $ezwebEmoji["%e394%"] = "\xf3\x64";
            $ezwebEmoji["%e395%"] = "\xf3\x65";
            $ezwebEmoji["%e396%"] = "\xf3\x66";
            $ezwebEmoji["%e397%"] = "\xf3\x67";
            $ezwebEmoji["%e398%"] = "\xf3\x68";
            $ezwebEmoji["%e399%"] = "\xf3\x69";
            $ezwebEmoji["%e400%"] = "\xf3\x6a";
            $ezwebEmoji["%e401%"] = "\xf3\x6b";
            $ezwebEmoji["%e402%"] = "\xf3\x6c";
            $ezwebEmoji["%e403%"] = "\xf3\x6d";
            $ezwebEmoji["%e404%"] = "\xf3\x6e";
            $ezwebEmoji["%e405%"] = "\xf3\x6f";
            $ezwebEmoji["%e406%"] = "\xf3\x70";
            $ezwebEmoji["%e407%"] = "\xf3\x71";
            $ezwebEmoji["%e408%"] = "\xf3\x72";
            $ezwebEmoji["%e409%"] = "\xf3\x73";
            $ezwebEmoji["%e410%"] = "\xf3\x74";
            $ezwebEmoji["%e411%"] = "\xf3\x75";
            $ezwebEmoji["%e412%"] = "\xf3\x76";
            $ezwebEmoji["%e413%"] = "\xf3\x77";
            $ezwebEmoji["%e414%"] = "\xf3\x78";
            $ezwebEmoji["%e415%"] = "\xf3\x79";
            $ezwebEmoji["%e416%"] = "\xf3\x7a";
            $ezwebEmoji["%e417%"] = "\xf3\x7b";
            $ezwebEmoji["%e418%"] = "\xf3\x7c";
            $ezwebEmoji["%e419%"] = "\xf3\x7d";
            $ezwebEmoji["%e420%"] = "\xf3\x7e";
            $ezwebEmoji["%e421%"] = "\xf3\x80";
            $ezwebEmoji["%e422%"] = "\xf3\x81";
            $ezwebEmoji["%e423%"] = "\xf3\x82";
            $ezwebEmoji["%e424%"] = "\xf3\x83";
            $ezwebEmoji["%e425%"] = "\xf3\x84";
            $ezwebEmoji["%e426%"] = "\xf3\x85";
            $ezwebEmoji["%e427%"] = "\xf3\x86";
            $ezwebEmoji["%e428%"] = "\xf3\x87";
            $ezwebEmoji["%e429%"] = "\xf3\x88";
            $ezwebEmoji["%e430%"] = "\xf3\x89";
            $ezwebEmoji["%e431%"] = "\xf3\x8a";
            $ezwebEmoji["%e432%"] = "\xf3\x8b";
            $ezwebEmoji["%e433%"] = "\xf3\x8c";
            $ezwebEmoji["%e434%"] = "\xf3\x8d";
            $ezwebEmoji["%e435%"] = "\xf3\x8e";
            $ezwebEmoji["%e436%"] = "\xf3\x8f";
            $ezwebEmoji["%e437%"] = "\xf3\x90";
            $ezwebEmoji["%e438%"] = "\xf3\x91";
            $ezwebEmoji["%e439%"] = "\xf3\x92";
            $ezwebEmoji["%e440%"] = "\xf3\x93";
            $ezwebEmoji["%e441%"] = "\xf3\x94";
            $ezwebEmoji["%e442%"] = "\xf3\x95";
            $ezwebEmoji["%e443%"] = "\xf3\x96";
            $ezwebEmoji["%e444%"] = "\xf3\x97";
            $ezwebEmoji["%e445%"] = "\xf3\x98";
            $ezwebEmoji["%e446%"] = "\xf3\x99";
            $ezwebEmoji["%e447%"] = "\xf3\x9a";
            $ezwebEmoji["%e448%"] = "\xf3\x9b";
            $ezwebEmoji["%e449%"] = "\xf3\x9c";
            $ezwebEmoji["%e450%"] = "\xf3\x9d";
            $ezwebEmoji["%e451%"] = "\xf3\x9e";
            $ezwebEmoji["%e452%"] = "\xf3\x9f";
            $ezwebEmoji["%e453%"] = "\xf3\xa0";
            $ezwebEmoji["%e454%"] = "\xf3\xa1";
            $ezwebEmoji["%e455%"] = "\xf3\xa2";
            $ezwebEmoji["%e456%"] = "\xf3\xa3";
            $ezwebEmoji["%e457%"] = "\xf3\xa4";
            $ezwebEmoji["%e458%"] = "\xf3\xa5";
            $ezwebEmoji["%e459%"] = "\xf3\xa6";
            $ezwebEmoji["%e460%"] = "\xf3\xa7";
            $ezwebEmoji["%e461%"] = "\xf3\xa8";
            $ezwebEmoji["%e462%"] = "\xf3\xa9";
            $ezwebEmoji["%e463%"] = "\xf3\xaa";
            $ezwebEmoji["%e464%"] = "\xf3\xab";
            $ezwebEmoji["%e465%"] = "\xf3\xac";
            $ezwebEmoji["%e466%"] = "\xf3\xad";
            $ezwebEmoji["%e467%"] = "\xf3\xae";
            $ezwebEmoji["%e468%"] = "\xf3\xaf";
            $ezwebEmoji["%e469%"] = "\xf3\xb0";
            $ezwebEmoji["%e470%"] = "\xf3\xb1";
            $ezwebEmoji["%e471%"] = "\xf3\xb2";
            $ezwebEmoji["%e472%"] = "\xf3\xb3";
            $ezwebEmoji["%e473%"] = "\xf3\xb4";
            $ezwebEmoji["%e474%"] = "\xf3\xb5";
            $ezwebEmoji["%e475%"] = "\xf3\xb6";
            $ezwebEmoji["%e476%"] = "\xf3\xb7";
            $ezwebEmoji["%e477%"] = "\xf3\xb8";
            $ezwebEmoji["%e478%"] = "\xf3\xb9";
            $ezwebEmoji["%e479%"] = "\xf3\xba";
            $ezwebEmoji["%e480%"] = "\xf3\xbb";
            $ezwebEmoji["%e481%"] = "\xf3\xbc";
            $ezwebEmoji["%e482%"] = "\xf3\xbd";
            $ezwebEmoji["%e483%"] = "\xf3\xbe";
            $ezwebEmoji["%e484%"] = "\xf3\xbf";
            $ezwebEmoji["%e485%"] = "\xf3\xc0";
            $ezwebEmoji["%e486%"] = "\xf3\xc1";
            $ezwebEmoji["%e487%"] = "\xf3\xc2";
            $ezwebEmoji["%e488%"] = "\xf3\xc3";
            $ezwebEmoji["%e489%"] = "\xf3\xc4";
            $ezwebEmoji["%e490%"] = "\xf3\xc5";
            $ezwebEmoji["%e491%"] = "\xf3\xc6";
            $ezwebEmoji["%e492%"] = "\xf3\xc7";
            $ezwebEmoji["%e493%"] = "\xf3\xc8";
            $ezwebEmoji["%e494%"] = "\xf3\xc9";
            $ezwebEmoji["%e495%"] = "\xf3\xca";
            $ezwebEmoji["%e496%"] = "\xf3\xcb";
            $ezwebEmoji["%e497%"] = "\xf3\xcc";
            $ezwebEmoji["%e498%"] = "\xf3\xcd";
            $ezwebEmoji["%e499%"] = "\xf3\xce";
            $ezwebEmoji["%e500%"] = "\xf7\xd2";
            $ezwebEmoji["%e501%"] = "\xf7\xd3";
            $ezwebEmoji["%e502%"] = "\xf7\xd4";
            $ezwebEmoji["%e503%"] = "\xf7\xd5";
            $ezwebEmoji["%e504%"] = "\xf7\xd6";
            $ezwebEmoji["%e505%"] = "\xf7\xd7";
            $ezwebEmoji["%e506%"] = "\xf7\xd8";
            $ezwebEmoji["%e507%"] = "\xf7\xd9";
            $ezwebEmoji["%e508%"] = "\xf7\xda";
            $ezwebEmoji["%e509%"] = "\xf7\xdb";
            $ezwebEmoji["%e510%"] = "\xf7\xdc";
            $ezwebEmoji["%e511%"] = "\xf7\xdd";
            $ezwebEmoji["%e512%"] = "\xf7\xde";
            $ezwebEmoji["%e513%"] = "\xf7\xdf";
            $ezwebEmoji["%e514%"] = "\xf7\xe0";
            $ezwebEmoji["%e515%"] = "\xf7\xe1";
            $ezwebEmoji["%e516%"] = "\xf7\xe2";
            $ezwebEmoji["%e517%"] = "\xf7\xe3";
            $ezwebEmoji["%e518%"] = "\xf7\xe4";
            $ezwebEmoji["%e700%"] = "\xf3\xcf";
            $ezwebEmoji["%e701%"] = "\xf3\xd0";
            $ezwebEmoji["%e702%"] = "\xf3\xd1";
            $ezwebEmoji["%e703%"] = "\xf3\xd2";
            $ezwebEmoji["%e704%"] = "\xf3\xd3";
            $ezwebEmoji["%e705%"] = "\xf3\xd4";
            $ezwebEmoji["%e706%"] = "\xf3\xd5";
            $ezwebEmoji["%e707%"] = "\xf3\xd6";
            $ezwebEmoji["%e708%"] = "\xf3\xd7";
            $ezwebEmoji["%e709%"] = "\xf3\xd8";
            $ezwebEmoji["%e710%"] = "\xf3\xd9";
            $ezwebEmoji["%e711%"] = "\xf3\xda";
            $ezwebEmoji["%e712%"] = "\xf3\xdb";
            $ezwebEmoji["%e713%"] = "\xf3\xdc";
            $ezwebEmoji["%e714%"] = "\xf3\xdd";
            $ezwebEmoji["%e715%"] = "\xf3\xde";
            $ezwebEmoji["%e716%"] = "\xf3\xdf";
            $ezwebEmoji["%e717%"] = "\xf3\xe0";
            $ezwebEmoji["%e718%"] = "\xf3\xe1";
            $ezwebEmoji["%e719%"] = "\xf3\xe2";
            $ezwebEmoji["%e720%"] = "\xf3\xe3";
            $ezwebEmoji["%e721%"] = "\xf3\xe4";
            $ezwebEmoji["%e722%"] = "\xf3\xe5";
            $ezwebEmoji["%e723%"] = "\xf3\xe6";
            $ezwebEmoji["%e724%"] = "\xf3\xe7";
            $ezwebEmoji["%e725%"] = "\xf3\xe8";
            $ezwebEmoji["%e726%"] = "\xf3\xe9";
            $ezwebEmoji["%e727%"] = "\xf3\xea";
            $ezwebEmoji["%e728%"] = "\xf3\xeb";
            $ezwebEmoji["%e729%"] = "\xf3\xec";
            $ezwebEmoji["%e730%"] = "\xf3\xed";
            $ezwebEmoji["%e731%"] = "\xf3\xee";
            $ezwebEmoji["%e732%"] = "\xf3\xef";
            $ezwebEmoji["%e733%"] = "\xf3\xf0";
            $ezwebEmoji["%e734%"] = "\xf3\xf1";
            $ezwebEmoji["%e735%"] = "\xf3\xf2";
            $ezwebEmoji["%e736%"] = "\xf3\xf3";
            $ezwebEmoji["%e737%"] = "\xf3\xf4";
            $ezwebEmoji["%e738%"] = "\xf3\xf5";
            $ezwebEmoji["%e739%"] = "\xf3\xf6";
            $ezwebEmoji["%e740%"] = "\xf3\xf7";
            $ezwebEmoji["%e741%"] = "\xf3\xf8";
            $ezwebEmoji["%e742%"] = "\xf3\xf9";
            $ezwebEmoji["%e743%"] = "\xf3\xfa";
            $ezwebEmoji["%e744%"] = "\xf3\xfb";
            $ezwebEmoji["%e745%"] = "\xf3\xfc";
            $ezwebEmoji["%e746%"] = "\xf4\x40";
            $ezwebEmoji["%e747%"] = "\xf4\x41";
            $ezwebEmoji["%e748%"] = "\xf4\x42";
            $ezwebEmoji["%e749%"] = "\xf4\x43";
            $ezwebEmoji["%e750%"] = "\xf4\x44";
            $ezwebEmoji["%e751%"] = "\xf4\x45";
            $ezwebEmoji["%e752%"] = "\xf4\x46";
            $ezwebEmoji["%e753%"] = "\xf4\x47";
            $ezwebEmoji["%e754%"] = "\xf4\x48";
            $ezwebEmoji["%e755%"] = "\xf4\x49";
            $ezwebEmoji["%e756%"] = "\xf4\x4a";
            $ezwebEmoji["%e757%"] = "\xf4\x4b";
            $ezwebEmoji["%e758%"] = "\xf4\x4c";
            $ezwebEmoji["%e759%"] = "\xf4\x4d";
            $ezwebEmoji["%e760%"] = "\xf4\x4e";
            $ezwebEmoji["%e761%"] = "\xf4\x4f";
            $ezwebEmoji["%e762%"] = "\xf4\x50";
            $ezwebEmoji["%e763%"] = "\xf4\x51";
            $ezwebEmoji["%e764%"] = "\xf4\x52";
            $ezwebEmoji["%e765%"] = "\xf4\x53";
            $ezwebEmoji["%e766%"] = "\xf4\x54";
            $ezwebEmoji["%e767%"] = "\xf4\x55";
            $ezwebEmoji["%e768%"] = "\xf4\x56";
            $ezwebEmoji["%e769%"] = "\xf4\x57";
            $ezwebEmoji["%e770%"] = "\xf4\x58";
            $ezwebEmoji["%e771%"] = "\xf4\x59";
            $ezwebEmoji["%e772%"] = "\xf4\x5a";
            $ezwebEmoji["%e773%"] = "\xf4\x5b";
            $ezwebEmoji["%e774%"] = "\xf4\x5c";
            $ezwebEmoji["%e775%"] = "\xf4\x5d";
            $ezwebEmoji["%e776%"] = "\xf4\x5e";
            $ezwebEmoji["%e777%"] = "\xf4\x5f";
            $ezwebEmoji["%e778%"] = "\xf4\x60";
            $ezwebEmoji["%e779%"] = "\xf4\x61";
            $ezwebEmoji["%e780%"] = "\xf4\x62";
            $ezwebEmoji["%e781%"] = "\xf4\x63";
            $ezwebEmoji["%e782%"] = "\xf4\x64";
            $ezwebEmoji["%e783%"] = "\xf4\x65";
            $ezwebEmoji["%e784%"] = "\xf4\x66";
            $ezwebEmoji["%e785%"] = "\xf4\x67";
            $ezwebEmoji["%e786%"] = "\xf4\x68";
            $ezwebEmoji["%e787%"] = "\xf4\x69";
            $ezwebEmoji["%e788%"] = "\xf4\x6a";
            $ezwebEmoji["%e789%"] = "\xf4\x6b";
            $ezwebEmoji["%e790%"] = "\xf4\x6c";
            $ezwebEmoji["%e791%"] = "\xf4\x6d";
            $ezwebEmoji["%e792%"] = "\xf4\x6e";
            $ezwebEmoji["%e793%"] = "\xf4\x6f";
            $ezwebEmoji["%e794%"] = "\xf4\x70";
            $ezwebEmoji["%e795%"] = "\xf4\x71";
            $ezwebEmoji["%e796%"] = "\xf4\x72";
            $ezwebEmoji["%e797%"] = "\xf4\x73";
            $ezwebEmoji["%e798%"] = "\xf4\x74";
            $ezwebEmoji["%e799%"] = "\xf4\x75";
            $ezwebEmoji["%e800%"] = "\xf4\x76";
            $ezwebEmoji["%e801%"] = "\xf4\x77";
            $ezwebEmoji["%e802%"] = "\xf4\x78";
            $ezwebEmoji["%e803%"] = "\xf4\x79";
            $ezwebEmoji["%e804%"] = "\xf4\x7a";
            $ezwebEmoji["%e805%"] = "\xf4\x7b";
            $ezwebEmoji["%e806%"] = "\xf4\x7c";
            $ezwebEmoji["%e807%"] = "\xf4\x7d";
            $ezwebEmoji["%e808%"] = "\xf4\x7e";
            $ezwebEmoji["%e809%"] = "\xf4\x80";
            $ezwebEmoji["%e810%"] = "\xf4\x81";
            $ezwebEmoji["%e811%"] = "\xf4\x82";
            $ezwebEmoji["%e812%"] = "\xf4\x83";
            $ezwebEmoji["%e813%"] = "\xf4\x84";
            $ezwebEmoji["%e814%"] = "\xf4\x85";
            $ezwebEmoji["%e815%"] = "\xf4\x86";
            $ezwebEmoji["%e816%"] = "\xf4\x87";
            $ezwebEmoji["%e817%"] = "\xf4\x88";
            $ezwebEmoji["%e818%"] = "\xf4\x89";
            $ezwebEmoji["%e819%"] = "\xf4\x8a";
            $ezwebEmoji["%e820%"] = "\xf4\x8b";
            $ezwebEmoji["%e821%"] = "\xf4\x8c";
            $ezwebEmoji["%e822%"] = "\xf4\x8d";
        }

        return $ezwebEmoji;
    }

    /**
     * getEzwebToEzwebメソッド
     *
     * Ezweb用の変換文字をキーにしたEzweb絵文字データ配列を返します。
     *
     * @return $ezwebToEzweb Ezweb絵文字配列
     */
    public static function getEzwebToEzweb() {
        static $ezwebToEzweb;

        if (!isset($ezwebToEzweb)) {
            $ezwebToEzweb["%e1%"] = "<IMG LOCALSRC=1>";
            $ezwebToEzweb["%e2%"] = "<IMG LOCALSRC=2>";
            $ezwebToEzweb["%e3%"] = "<IMG LOCALSRC=3>";
            $ezwebToEzweb["%e4%"] = "<IMG LOCALSRC=4>";
            $ezwebToEzweb["%e5%"] = "<IMG LOCALSRC=5>";
            $ezwebToEzweb["%e6%"] = "<IMG LOCALSRC=6>";
            $ezwebToEzweb["%e7%"] = "<IMG LOCALSRC=7>";
            $ezwebToEzweb["%e8%"] = "<IMG LOCALSRC=8>";
            $ezwebToEzweb["%e9%"] = "<IMG LOCALSRC=9>";
            $ezwebToEzweb["%e10%"] = "<IMG LOCALSRC=10>";
            $ezwebToEzweb["%e11%"] = "<IMG LOCALSRC=11>";
            $ezwebToEzweb["%e12%"] = "<IMG LOCALSRC=12>";
            $ezwebToEzweb["%e13%"] = "<IMG LOCALSRC=13>";
            $ezwebToEzweb["%e14%"] = "<IMG LOCALSRC=14>";
            $ezwebToEzweb["%e15%"] = "<IMG LOCALSRC=15>";
            $ezwebToEzweb["%e16%"] = "<IMG LOCALSRC=16>";
            $ezwebToEzweb["%e17%"] = "<IMG LOCALSRC=17>";
            $ezwebToEzweb["%e18%"] = "<IMG LOCALSRC=18>";
            $ezwebToEzweb["%e19%"] = "<IMG LOCALSRC=19>";
            $ezwebToEzweb["%e20%"] = "<IMG LOCALSRC=20>";
            $ezwebToEzweb["%e21%"] = "<IMG LOCALSRC=21>";
            $ezwebToEzweb["%e22%"] = "<IMG LOCALSRC=22>";
            $ezwebToEzweb["%e23%"] = "<IMG LOCALSRC=23>";
            $ezwebToEzweb["%e24%"] = "<IMG LOCALSRC=24>";
            $ezwebToEzweb["%e25%"] = "<IMG LOCALSRC=25>";
            $ezwebToEzweb["%e26%"] = "<IMG LOCALSRC=26>";
            $ezwebToEzweb["%e27%"] = "<IMG LOCALSRC=27>";
            $ezwebToEzweb["%e28%"] = "<IMG LOCALSRC=28>";
            $ezwebToEzweb["%e29%"] = "<IMG LOCALSRC=29>";
            $ezwebToEzweb["%e30%"] = "<IMG LOCALSRC=30>";
            $ezwebToEzweb["%e31%"] = "<IMG LOCALSRC=31>";
            $ezwebToEzweb["%e32%"] = "<IMG LOCALSRC=32>";
            $ezwebToEzweb["%e33%"] = "<IMG LOCALSRC=33>";
            $ezwebToEzweb["%e34%"] = "<IMG LOCALSRC=34>";
            $ezwebToEzweb["%e35%"] = "<IMG LOCALSRC=35>";
            $ezwebToEzweb["%e36%"] = "<IMG LOCALSRC=36>";
            $ezwebToEzweb["%e37%"] = "<IMG LOCALSRC=37>";
            $ezwebToEzweb["%e38%"] = "<IMG LOCALSRC=38>";
            $ezwebToEzweb["%e39%"] = "<IMG LOCALSRC=39>";
            $ezwebToEzweb["%e40%"] = "<IMG LOCALSRC=40>";
            $ezwebToEzweb["%e41%"] = "<IMG LOCALSRC=41>";
            $ezwebToEzweb["%e42%"] = "<IMG LOCALSRC=42>";
            $ezwebToEzweb["%e43%"] = "<IMG LOCALSRC=43>";
            $ezwebToEzweb["%e44%"] = "<IMG LOCALSRC=44>";
            $ezwebToEzweb["%e45%"] = "<IMG LOCALSRC=45>";
            $ezwebToEzweb["%e46%"] = "<IMG LOCALSRC=46>";
            $ezwebToEzweb["%e47%"] = "<IMG LOCALSRC=47>";
            $ezwebToEzweb["%e48%"] = "<IMG LOCALSRC=48>";
            $ezwebToEzweb["%e49%"] = "<IMG LOCALSRC=49>";
            $ezwebToEzweb["%e50%"] = "<IMG LOCALSRC=50>";
            $ezwebToEzweb["%e51%"] = "<IMG LOCALSRC=51>";
            $ezwebToEzweb["%e52%"] = "<IMG LOCALSRC=52>";
            $ezwebToEzweb["%e53%"] = "<IMG LOCALSRC=53>";
            $ezwebToEzweb["%e54%"] = "<IMG LOCALSRC=54>";
            $ezwebToEzweb["%e55%"] = "<IMG LOCALSRC=55>";
            $ezwebToEzweb["%e56%"] = "<IMG LOCALSRC=56>";
            $ezwebToEzweb["%e57%"] = "<IMG LOCALSRC=57>";
            $ezwebToEzweb["%e58%"] = "<IMG LOCALSRC=58>";
            $ezwebToEzweb["%e59%"] = "<IMG LOCALSRC=59>";
            $ezwebToEzweb["%e60%"] = "<IMG LOCALSRC=60>";
            $ezwebToEzweb["%e61%"] = "<IMG LOCALSRC=61>";
            $ezwebToEzweb["%e62%"] = "<IMG LOCALSRC=62>";
            $ezwebToEzweb["%e63%"] = "<IMG LOCALSRC=63>";
            $ezwebToEzweb["%e64%"] = "<IMG LOCALSRC=64>";
            $ezwebToEzweb["%e65%"] = "<IMG LOCALSRC=65>";
            $ezwebToEzweb["%e66%"] = "<IMG LOCALSRC=66>";
            $ezwebToEzweb["%e67%"] = "<IMG LOCALSRC=67>";
            $ezwebToEzweb["%e68%"] = "<IMG LOCALSRC=68>";
            $ezwebToEzweb["%e69%"] = "<IMG LOCALSRC=69>";
            $ezwebToEzweb["%e70%"] = "<IMG LOCALSRC=70>";
            $ezwebToEzweb["%e71%"] = "<IMG LOCALSRC=71>";
            $ezwebToEzweb["%e72%"] = "<IMG LOCALSRC=72>";
            $ezwebToEzweb["%e73%"] = "<IMG LOCALSRC=73>";
            $ezwebToEzweb["%e74%"] = "<IMG LOCALSRC=74>";
            $ezwebToEzweb["%e75%"] = "<IMG LOCALSRC=75>";
            $ezwebToEzweb["%e76%"] = "<IMG LOCALSRC=76>";
            $ezwebToEzweb["%e77%"] = "<IMG LOCALSRC=77>";
            $ezwebToEzweb["%e78%"] = "<IMG LOCALSRC=78>";
            $ezwebToEzweb["%e79%"] = "<IMG LOCALSRC=79>";
            $ezwebToEzweb["%e80%"] = "<IMG LOCALSRC=80>";
            $ezwebToEzweb["%e81%"] = "<IMG LOCALSRC=81>";
            $ezwebToEzweb["%e82%"] = "<IMG LOCALSRC=82>";
            $ezwebToEzweb["%e83%"] = "<IMG LOCALSRC=83>";
            $ezwebToEzweb["%e84%"] = "<IMG LOCALSRC=84>";
            $ezwebToEzweb["%e85%"] = "<IMG LOCALSRC=85>";
            $ezwebToEzweb["%e86%"] = "<IMG LOCALSRC=86>";
            $ezwebToEzweb["%e87%"] = "<IMG LOCALSRC=87>";
            $ezwebToEzweb["%e88%"] = "<IMG LOCALSRC=88>";
            $ezwebToEzweb["%e89%"] = "<IMG LOCALSRC=89>";
            $ezwebToEzweb["%e90%"] = "<IMG LOCALSRC=90>";
            $ezwebToEzweb["%e91%"] = "<IMG LOCALSRC=91>";
            $ezwebToEzweb["%e92%"] = "<IMG LOCALSRC=92>";
            $ezwebToEzweb["%e93%"] = "<IMG LOCALSRC=93>";
            $ezwebToEzweb["%e94%"] = "<IMG LOCALSRC=94>";
            $ezwebToEzweb["%e95%"] = "<IMG LOCALSRC=95>";
            $ezwebToEzweb["%e96%"] = "<IMG LOCALSRC=96>";
            $ezwebToEzweb["%e97%"] = "<IMG LOCALSRC=97>";
            $ezwebToEzweb["%e98%"] = "<IMG LOCALSRC=98>";
            $ezwebToEzweb["%e99%"] = "<IMG LOCALSRC=99>";
            $ezwebToEzweb["%e100%"] = "<IMG LOCALSRC=100>";
            $ezwebToEzweb["%e101%"] = "<IMG LOCALSRC=101>";
            $ezwebToEzweb["%e102%"] = "<IMG LOCALSRC=102>";
            $ezwebToEzweb["%e103%"] = "<IMG LOCALSRC=103>";
            $ezwebToEzweb["%e104%"] = "<IMG LOCALSRC=104>";
            $ezwebToEzweb["%e105%"] = "<IMG LOCALSRC=105>";
            $ezwebToEzweb["%e106%"] = "<IMG LOCALSRC=106>";
            $ezwebToEzweb["%e107%"] = "<IMG LOCALSRC=107>";
            $ezwebToEzweb["%e108%"] = "<IMG LOCALSRC=108>";
            $ezwebToEzweb["%e109%"] = "<IMG LOCALSRC=109>";
            $ezwebToEzweb["%e110%"] = "<IMG LOCALSRC=110>";
            $ezwebToEzweb["%e111%"] = "<IMG LOCALSRC=111>";
            $ezwebToEzweb["%e112%"] = "<IMG LOCALSRC=112>";
            $ezwebToEzweb["%e113%"] = "<IMG LOCALSRC=113>";
            $ezwebToEzweb["%e114%"] = "<IMG LOCALSRC=114>";
            $ezwebToEzweb["%e115%"] = "<IMG LOCALSRC=115>";
            $ezwebToEzweb["%e116%"] = "<IMG LOCALSRC=116>";
            $ezwebToEzweb["%e117%"] = "<IMG LOCALSRC=117>";
            $ezwebToEzweb["%e118%"] = "<IMG LOCALSRC=118>";
            $ezwebToEzweb["%e119%"] = "<IMG LOCALSRC=119>";
            $ezwebToEzweb["%e120%"] = "<IMG LOCALSRC=120>";
            $ezwebToEzweb["%e121%"] = "<IMG LOCALSRC=121>";
            $ezwebToEzweb["%e122%"] = "<IMG LOCALSRC=122>";
            $ezwebToEzweb["%e123%"] = "<IMG LOCALSRC=123>";
            $ezwebToEzweb["%e124%"] = "<IMG LOCALSRC=124>";
            $ezwebToEzweb["%e125%"] = "<IMG LOCALSRC=125>";
            $ezwebToEzweb["%e126%"] = "<IMG LOCALSRC=126>";
            $ezwebToEzweb["%e127%"] = "<IMG LOCALSRC=127>";
            $ezwebToEzweb["%e128%"] = "<IMG LOCALSRC=128>";
            $ezwebToEzweb["%e129%"] = "<IMG LOCALSRC=129>";
            $ezwebToEzweb["%e130%"] = "<IMG LOCALSRC=130>";
            $ezwebToEzweb["%e131%"] = "<IMG LOCALSRC=131>";
            $ezwebToEzweb["%e132%"] = "<IMG LOCALSRC=132>";
            $ezwebToEzweb["%e133%"] = "<IMG LOCALSRC=133>";
            $ezwebToEzweb["%e134%"] = "<IMG LOCALSRC=134>";
            $ezwebToEzweb["%e135%"] = "<IMG LOCALSRC=135>";
            $ezwebToEzweb["%e136%"] = "<IMG LOCALSRC=136>";
            $ezwebToEzweb["%e137%"] = "<IMG LOCALSRC=137>";
            $ezwebToEzweb["%e138%"] = "<IMG LOCALSRC=138>";
            $ezwebToEzweb["%e139%"] = "<IMG LOCALSRC=139>";
            $ezwebToEzweb["%e140%"] = "<IMG LOCALSRC=140>";
            $ezwebToEzweb["%e141%"] = "<IMG LOCALSRC=141>";
            $ezwebToEzweb["%e142%"] = "<IMG LOCALSRC=142>";
            $ezwebToEzweb["%e143%"] = "<IMG LOCALSRC=143>";
            $ezwebToEzweb["%e144%"] = "<IMG LOCALSRC=144>";
            $ezwebToEzweb["%e145%"] = "<IMG LOCALSRC=145>";
            $ezwebToEzweb["%e146%"] = "<IMG LOCALSRC=146>";
            $ezwebToEzweb["%e147%"] = "<IMG LOCALSRC=147>";
            $ezwebToEzweb["%e148%"] = "<IMG LOCALSRC=148>";
            $ezwebToEzweb["%e149%"] = "<IMG LOCALSRC=149>";
            $ezwebToEzweb["%e150%"] = "<IMG LOCALSRC=150>";
            $ezwebToEzweb["%e151%"] = "<IMG LOCALSRC=151>";
            $ezwebToEzweb["%e152%"] = "<IMG LOCALSRC=152>";
            $ezwebToEzweb["%e153%"] = "<IMG LOCALSRC=153>";
            $ezwebToEzweb["%e154%"] = "<IMG LOCALSRC=154>";
            $ezwebToEzweb["%e155%"] = "<IMG LOCALSRC=155>";
            $ezwebToEzweb["%e156%"] = "<IMG LOCALSRC=156>";
            $ezwebToEzweb["%e157%"] = "<IMG LOCALSRC=157>";
            $ezwebToEzweb["%e158%"] = "<IMG LOCALSRC=158>";
            $ezwebToEzweb["%e159%"] = "<IMG LOCALSRC=159>";
            $ezwebToEzweb["%e160%"] = "<IMG LOCALSRC=160>";
            $ezwebToEzweb["%e161%"] = "<IMG LOCALSRC=161>";
            $ezwebToEzweb["%e162%"] = "<IMG LOCALSRC=162>";
            $ezwebToEzweb["%e163%"] = "<IMG LOCALSRC=163>";
            $ezwebToEzweb["%e164%"] = "<IMG LOCALSRC=164>";
            $ezwebToEzweb["%e165%"] = "<IMG LOCALSRC=165>";
            $ezwebToEzweb["%e166%"] = "<IMG LOCALSRC=166>";
            $ezwebToEzweb["%e167%"] = "<IMG LOCALSRC=167>";
            $ezwebToEzweb["%e168%"] = "<IMG LOCALSRC=168>";
            $ezwebToEzweb["%e169%"] = "<IMG LOCALSRC=169>";
            $ezwebToEzweb["%e170%"] = "<IMG LOCALSRC=170>";
            $ezwebToEzweb["%e171%"] = "<IMG LOCALSRC=171>";
            $ezwebToEzweb["%e172%"] = "<IMG LOCALSRC=172>";
            $ezwebToEzweb["%e173%"] = "<IMG LOCALSRC=173>";
            $ezwebToEzweb["%e174%"] = "<IMG LOCALSRC=174>";
            $ezwebToEzweb["%e175%"] = "<IMG LOCALSRC=175>";
            $ezwebToEzweb["%e176%"] = "<IMG LOCALSRC=176>";
            $ezwebToEzweb["%e177%"] = "<IMG LOCALSRC=177>";
            $ezwebToEzweb["%e178%"] = "<IMG LOCALSRC=178>";
            $ezwebToEzweb["%e179%"] = "<IMG LOCALSRC=179>";
            $ezwebToEzweb["%e180%"] = "<IMG LOCALSRC=180>";
            $ezwebToEzweb["%e181%"] = "<IMG LOCALSRC=181>";
            $ezwebToEzweb["%e182%"] = "<IMG LOCALSRC=182>";
            $ezwebToEzweb["%e183%"] = "<IMG LOCALSRC=183>";
            $ezwebToEzweb["%e184%"] = "<IMG LOCALSRC=184>";
            $ezwebToEzweb["%e185%"] = "<IMG LOCALSRC=185>";
            $ezwebToEzweb["%e186%"] = "<IMG LOCALSRC=186>";
            $ezwebToEzweb["%e187%"] = "<IMG LOCALSRC=187>";
            $ezwebToEzweb["%e188%"] = "<IMG LOCALSRC=188>";
            $ezwebToEzweb["%e189%"] = "<IMG LOCALSRC=189>";
            $ezwebToEzweb["%e190%"] = "<IMG LOCALSRC=190>";
            $ezwebToEzweb["%e191%"] = "<IMG LOCALSRC=191>";
            $ezwebToEzweb["%e192%"] = "<IMG LOCALSRC=192>";
            $ezwebToEzweb["%e193%"] = "<IMG LOCALSRC=193>";
            $ezwebToEzweb["%e194%"] = "<IMG LOCALSRC=194>";
            $ezwebToEzweb["%e195%"] = "<IMG LOCALSRC=195>";
            $ezwebToEzweb["%e196%"] = "<IMG LOCALSRC=196>";
            $ezwebToEzweb["%e197%"] = "<IMG LOCALSRC=197>";
            $ezwebToEzweb["%e198%"] = "<IMG LOCALSRC=198>";
            $ezwebToEzweb["%e199%"] = "<IMG LOCALSRC=199>";
            $ezwebToEzweb["%e200%"] = "<IMG LOCALSRC=200>";
            $ezwebToEzweb["%e201%"] = "<IMG LOCALSRC=201>";
            $ezwebToEzweb["%e202%"] = "<IMG LOCALSRC=202>";
            $ezwebToEzweb["%e203%"] = "<IMG LOCALSRC=203>";
            $ezwebToEzweb["%e204%"] = "<IMG LOCALSRC=204>";
            $ezwebToEzweb["%e205%"] = "<IMG LOCALSRC=205>";
            $ezwebToEzweb["%e206%"] = "<IMG LOCALSRC=206>";
            $ezwebToEzweb["%e207%"] = "<IMG LOCALSRC=207>";
            $ezwebToEzweb["%e208%"] = "<IMG LOCALSRC=208>";
            $ezwebToEzweb["%e209%"] = "<IMG LOCALSRC=209>";
            $ezwebToEzweb["%e210%"] = "<IMG LOCALSRC=210>";
            $ezwebToEzweb["%e211%"] = "<IMG LOCALSRC=211>";
            $ezwebToEzweb["%e212%"] = "<IMG LOCALSRC=212>";
            $ezwebToEzweb["%e213%"] = "<IMG LOCALSRC=213>";
            $ezwebToEzweb["%e214%"] = "<IMG LOCALSRC=214>";
            $ezwebToEzweb["%e215%"] = "<IMG LOCALSRC=215>";
            $ezwebToEzweb["%e216%"] = "<IMG LOCALSRC=216>";
            $ezwebToEzweb["%e217%"] = "<IMG LOCALSRC=217>";
            $ezwebToEzweb["%e218%"] = "<IMG LOCALSRC=218>";
            $ezwebToEzweb["%e219%"] = "<IMG LOCALSRC=219>";
            $ezwebToEzweb["%e220%"] = "<IMG LOCALSRC=220>";
            $ezwebToEzweb["%e221%"] = "<IMG LOCALSRC=221>";
            $ezwebToEzweb["%e222%"] = "<IMG LOCALSRC=222>";
            $ezwebToEzweb["%e223%"] = "<IMG LOCALSRC=223>";
            $ezwebToEzweb["%e224%"] = "<IMG LOCALSRC=224>";
            $ezwebToEzweb["%e225%"] = "<IMG LOCALSRC=225>";
            $ezwebToEzweb["%e226%"] = "<IMG LOCALSRC=226>";
            $ezwebToEzweb["%e227%"] = "<IMG LOCALSRC=227>";
            $ezwebToEzweb["%e228%"] = "<IMG LOCALSRC=228>";
            $ezwebToEzweb["%e229%"] = "<IMG LOCALSRC=229>";
            $ezwebToEzweb["%e230%"] = "<IMG LOCALSRC=230>";
            $ezwebToEzweb["%e231%"] = "<IMG LOCALSRC=231>";
            $ezwebToEzweb["%e232%"] = "<IMG LOCALSRC=232>";
            $ezwebToEzweb["%e233%"] = "<IMG LOCALSRC=233>";
            $ezwebToEzweb["%e234%"] = "<IMG LOCALSRC=234>";
            $ezwebToEzweb["%e235%"] = "<IMG LOCALSRC=235>";
            $ezwebToEzweb["%e236%"] = "<IMG LOCALSRC=236>";
            $ezwebToEzweb["%e237%"] = "<IMG LOCALSRC=237>";
            $ezwebToEzweb["%e238%"] = "<IMG LOCALSRC=238>";
            $ezwebToEzweb["%e239%"] = "<IMG LOCALSRC=239>";
            $ezwebToEzweb["%e240%"] = "<IMG LOCALSRC=240>";
            $ezwebToEzweb["%e241%"] = "<IMG LOCALSRC=241>";
            $ezwebToEzweb["%e242%"] = "<IMG LOCALSRC=242>";
            $ezwebToEzweb["%e243%"] = "<IMG LOCALSRC=243>";
            $ezwebToEzweb["%e244%"] = "<IMG LOCALSRC=244>";
            $ezwebToEzweb["%e245%"] = "<IMG LOCALSRC=245>";
            $ezwebToEzweb["%e246%"] = "<IMG LOCALSRC=246>";
            $ezwebToEzweb["%e247%"] = "<IMG LOCALSRC=247>";
            $ezwebToEzweb["%e248%"] = "<IMG LOCALSRC=248>";
            $ezwebToEzweb["%e249%"] = "<IMG LOCALSRC=249>";
            $ezwebToEzweb["%e250%"] = "<IMG LOCALSRC=250>";
            $ezwebToEzweb["%e251%"] = "<IMG LOCALSRC=251>";
            $ezwebToEzweb["%e252%"] = "<IMG LOCALSRC=252>";
            $ezwebToEzweb["%e253%"] = "<IMG LOCALSRC=253>";
            $ezwebToEzweb["%e254%"] = "<IMG LOCALSRC=254>";
            $ezwebToEzweb["%e255%"] = "<IMG LOCALSRC=255>";
            $ezwebToEzweb["%e256%"] = "<IMG LOCALSRC=256>";
            $ezwebToEzweb["%e257%"] = "<IMG LOCALSRC=257>";
            $ezwebToEzweb["%e258%"] = "<IMG LOCALSRC=258>";
            $ezwebToEzweb["%e259%"] = "<IMG LOCALSRC=259>";
            $ezwebToEzweb["%e260%"] = "<IMG LOCALSRC=260>";
            $ezwebToEzweb["%e261%"] = "<IMG LOCALSRC=261>";
            $ezwebToEzweb["%e262%"] = "<IMG LOCALSRC=262>";
            $ezwebToEzweb["%e263%"] = "<IMG LOCALSRC=263>";
            $ezwebToEzweb["%e264%"] = "<IMG LOCALSRC=264>";
            $ezwebToEzweb["%e265%"] = "<IMG LOCALSRC=265>";
            $ezwebToEzweb["%e266%"] = "<IMG LOCALSRC=266>";
            $ezwebToEzweb["%e267%"] = "<IMG LOCALSRC=267>";
            $ezwebToEzweb["%e268%"] = "<IMG LOCALSRC=268>";
            $ezwebToEzweb["%e269%"] = "<IMG LOCALSRC=269>";
            $ezwebToEzweb["%e270%"] = "<IMG LOCALSRC=270>";
            $ezwebToEzweb["%e271%"] = "<IMG LOCALSRC=271>";
            $ezwebToEzweb["%e272%"] = "<IMG LOCALSRC=272>";
            $ezwebToEzweb["%e273%"] = "<IMG LOCALSRC=273>";
            $ezwebToEzweb["%e274%"] = "<IMG LOCALSRC=274>";
            $ezwebToEzweb["%e275%"] = "<IMG LOCALSRC=275>";
            $ezwebToEzweb["%e276%"] = "<IMG LOCALSRC=276>";
            $ezwebToEzweb["%e277%"] = "<IMG LOCALSRC=277>";
            $ezwebToEzweb["%e278%"] = "<IMG LOCALSRC=278>";
            $ezwebToEzweb["%e279%"] = "<IMG LOCALSRC=279>";
            $ezwebToEzweb["%e280%"] = "<IMG LOCALSRC=280>";
            $ezwebToEzweb["%e281%"] = "<IMG LOCALSRC=281>";
            $ezwebToEzweb["%e282%"] = "<IMG LOCALSRC=282>";
            $ezwebToEzweb["%e283%"] = "<IMG LOCALSRC=283>";
            $ezwebToEzweb["%e284%"] = "<IMG LOCALSRC=284>";
            $ezwebToEzweb["%e285%"] = "<IMG LOCALSRC=285>";
            $ezwebToEzweb["%e286%"] = "<IMG LOCALSRC=286>";
            $ezwebToEzweb["%e287%"] = "<IMG LOCALSRC=287>";
            $ezwebToEzweb["%e288%"] = "<IMG LOCALSRC=288>";
            $ezwebToEzweb["%e289%"] = "<IMG LOCALSRC=289>";
            $ezwebToEzweb["%e290%"] = "<IMG LOCALSRC=290>";
            $ezwebToEzweb["%e291%"] = "<IMG LOCALSRC=291>";
            $ezwebToEzweb["%e292%"] = "<IMG LOCALSRC=292>";
            $ezwebToEzweb["%e293%"] = "<IMG LOCALSRC=293>";
            $ezwebToEzweb["%e294%"] = "<IMG LOCALSRC=294>";
            $ezwebToEzweb["%e295%"] = "<IMG LOCALSRC=295>";
            $ezwebToEzweb["%e296%"] = "<IMG LOCALSRC=296>";
            $ezwebToEzweb["%e297%"] = "<IMG LOCALSRC=297>";
            $ezwebToEzweb["%e298%"] = "<IMG LOCALSRC=298>";
            $ezwebToEzweb["%e299%"] = "<IMG LOCALSRC=299>";
            $ezwebToEzweb["%e300%"] = "<IMG LOCALSRC=300>";
            $ezwebToEzweb["%e301%"] = "<IMG LOCALSRC=301>";
            $ezwebToEzweb["%e302%"] = "<IMG LOCALSRC=302>";
            $ezwebToEzweb["%e303%"] = "<IMG LOCALSRC=303>";
            $ezwebToEzweb["%e304%"] = "<IMG LOCALSRC=304>";
            $ezwebToEzweb["%e305%"] = "<IMG LOCALSRC=305>";
            $ezwebToEzweb["%e306%"] = "<IMG LOCALSRC=306>";
            $ezwebToEzweb["%e307%"] = "<IMG LOCALSRC=307>";
            $ezwebToEzweb["%e308%"] = "<IMG LOCALSRC=308>";
            $ezwebToEzweb["%e309%"] = "<IMG LOCALSRC=309>";
            $ezwebToEzweb["%e310%"] = "<IMG LOCALSRC=310>";
            $ezwebToEzweb["%e311%"] = "<IMG LOCALSRC=311>";
            $ezwebToEzweb["%e312%"] = "<IMG LOCALSRC=312>";
            $ezwebToEzweb["%e313%"] = "<IMG LOCALSRC=313>";
            $ezwebToEzweb["%e314%"] = "<IMG LOCALSRC=314>";
            $ezwebToEzweb["%e315%"] = "<IMG LOCALSRC=315>";
            $ezwebToEzweb["%e316%"] = "<IMG LOCALSRC=316>";
            $ezwebToEzweb["%e317%"] = "<IMG LOCALSRC=317>";
            $ezwebToEzweb["%e318%"] = "<IMG LOCALSRC=318>";
            $ezwebToEzweb["%e319%"] = "<IMG LOCALSRC=319>";
            $ezwebToEzweb["%e320%"] = "<IMG LOCALSRC=320>";
            $ezwebToEzweb["%e321%"] = "<IMG LOCALSRC=321>";
            $ezwebToEzweb["%e322%"] = "<IMG LOCALSRC=322>";
            $ezwebToEzweb["%e323%"] = "<IMG LOCALSRC=323>";
            $ezwebToEzweb["%e324%"] = "<IMG LOCALSRC=324>";
            $ezwebToEzweb["%e325%"] = "<IMG LOCALSRC=325>";
            $ezwebToEzweb["%e326%"] = "<IMG LOCALSRC=326>";
            $ezwebToEzweb["%e327%"] = "<IMG LOCALSRC=327>";
            $ezwebToEzweb["%e328%"] = "<IMG LOCALSRC=328>";
            $ezwebToEzweb["%e329%"] = "<IMG LOCALSRC=329>";
            $ezwebToEzweb["%e330%"] = "<IMG LOCALSRC=330>";
            $ezwebToEzweb["%e331%"] = "<IMG LOCALSRC=331>";
            $ezwebToEzweb["%e332%"] = "<IMG LOCALSRC=332>";
            $ezwebToEzweb["%e333%"] = "<IMG LOCALSRC=333>";
            $ezwebToEzweb["%e334%"] = "<IMG LOCALSRC=334>";
            $ezwebToEzweb["%e335%"] = "<IMG LOCALSRC=335>";
            $ezwebToEzweb["%e336%"] = "<IMG LOCALSRC=336>";
            $ezwebToEzweb["%e337%"] = "<IMG LOCALSRC=337>";
            $ezwebToEzweb["%e338%"] = "<IMG LOCALSRC=338>";
            $ezwebToEzweb["%e339%"] = "<IMG LOCALSRC=339>";
            $ezwebToEzweb["%e340%"] = "<IMG LOCALSRC=340>";
            $ezwebToEzweb["%e341%"] = "<IMG LOCALSRC=341>";
            $ezwebToEzweb["%e342%"] = "<IMG LOCALSRC=342>";
            $ezwebToEzweb["%e343%"] = "<IMG LOCALSRC=343>";
            $ezwebToEzweb["%e344%"] = "<IMG LOCALSRC=344>";
            $ezwebToEzweb["%e345%"] = "<IMG LOCALSRC=345>";
            $ezwebToEzweb["%e346%"] = "<IMG LOCALSRC=346>";
            $ezwebToEzweb["%e347%"] = "<IMG LOCALSRC=347>";
            $ezwebToEzweb["%e348%"] = "<IMG LOCALSRC=348>";
            $ezwebToEzweb["%e349%"] = "<IMG LOCALSRC=349>";
            $ezwebToEzweb["%e350%"] = "<IMG LOCALSRC=350>";
            $ezwebToEzweb["%e351%"] = "<IMG LOCALSRC=351>";
            $ezwebToEzweb["%e352%"] = "<IMG LOCALSRC=352>";
            $ezwebToEzweb["%e353%"] = "<IMG LOCALSRC=353>";
            $ezwebToEzweb["%e354%"] = "<IMG LOCALSRC=354>";
            $ezwebToEzweb["%e355%"] = "<IMG LOCALSRC=355>";
            $ezwebToEzweb["%e356%"] = "<IMG LOCALSRC=356>";
            $ezwebToEzweb["%e357%"] = "<IMG LOCALSRC=357>";
            $ezwebToEzweb["%e358%"] = "<IMG LOCALSRC=358>";
            $ezwebToEzweb["%e359%"] = "<IMG LOCALSRC=359>";
            $ezwebToEzweb["%e360%"] = "<IMG LOCALSRC=360>";
            $ezwebToEzweb["%e361%"] = "<IMG LOCALSRC=361>";
            $ezwebToEzweb["%e362%"] = "<IMG LOCALSRC=362>";
            $ezwebToEzweb["%e363%"] = "<IMG LOCALSRC=363>";
            $ezwebToEzweb["%e364%"] = "<IMG LOCALSRC=364>";
            $ezwebToEzweb["%e365%"] = "<IMG LOCALSRC=365>";
            $ezwebToEzweb["%e366%"] = "<IMG LOCALSRC=366>";
            $ezwebToEzweb["%e367%"] = "<IMG LOCALSRC=367>";
            $ezwebToEzweb["%e368%"] = "<IMG LOCALSRC=368>";
            $ezwebToEzweb["%e369%"] = "<IMG LOCALSRC=369>";
            $ezwebToEzweb["%e370%"] = "<IMG LOCALSRC=370>";
            $ezwebToEzweb["%e371%"] = "<IMG LOCALSRC=371>";
            $ezwebToEzweb["%e372%"] = "<IMG LOCALSRC=372>";
            $ezwebToEzweb["%e373%"] = "<IMG LOCALSRC=373>";
            $ezwebToEzweb["%e374%"] = "<IMG LOCALSRC=374>";
            $ezwebToEzweb["%e375%"] = "<IMG LOCALSRC=375>";
            $ezwebToEzweb["%e376%"] = "<IMG LOCALSRC=376>";
            $ezwebToEzweb["%e377%"] = "<IMG LOCALSRC=377>";
            $ezwebToEzweb["%e378%"] = "<IMG LOCALSRC=378>";
            $ezwebToEzweb["%e379%"] = "<IMG LOCALSRC=379>";
            $ezwebToEzweb["%e380%"] = "<IMG LOCALSRC=380>";
            $ezwebToEzweb["%e381%"] = "<IMG LOCALSRC=381>";
            $ezwebToEzweb["%e382%"] = "<IMG LOCALSRC=382>";
            $ezwebToEzweb["%e383%"] = "<IMG LOCALSRC=383>";
            $ezwebToEzweb["%e384%"] = "<IMG LOCALSRC=384>";
            $ezwebToEzweb["%e385%"] = "<IMG LOCALSRC=385>";
            $ezwebToEzweb["%e386%"] = "<IMG LOCALSRC=386>";
            $ezwebToEzweb["%e387%"] = "<IMG LOCALSRC=387>";
            $ezwebToEzweb["%e388%"] = "<IMG LOCALSRC=388>";
            $ezwebToEzweb["%e389%"] = "<IMG LOCALSRC=389>";
            $ezwebToEzweb["%e390%"] = "<IMG LOCALSRC=390>";
            $ezwebToEzweb["%e391%"] = "<IMG LOCALSRC=391>";
            $ezwebToEzweb["%e392%"] = "<IMG LOCALSRC=392>";
            $ezwebToEzweb["%e393%"] = "<IMG LOCALSRC=393>";
            $ezwebToEzweb["%e394%"] = "<IMG LOCALSRC=394>";
            $ezwebToEzweb["%e395%"] = "<IMG LOCALSRC=395>";
            $ezwebToEzweb["%e396%"] = "<IMG LOCALSRC=396>";
            $ezwebToEzweb["%e397%"] = "<IMG LOCALSRC=397>";
            $ezwebToEzweb["%e398%"] = "<IMG LOCALSRC=398>";
            $ezwebToEzweb["%e399%"] = "<IMG LOCALSRC=399>";
            $ezwebToEzweb["%e400%"] = "<IMG LOCALSRC=400>";
            $ezwebToEzweb["%e401%"] = "<IMG LOCALSRC=401>";
            $ezwebToEzweb["%e402%"] = "<IMG LOCALSRC=402>";
            $ezwebToEzweb["%e403%"] = "<IMG LOCALSRC=403>";
            $ezwebToEzweb["%e404%"] = "<IMG LOCALSRC=404>";
            $ezwebToEzweb["%e405%"] = "<IMG LOCALSRC=405>";
            $ezwebToEzweb["%e406%"] = "<IMG LOCALSRC=406>";
            $ezwebToEzweb["%e407%"] = "<IMG LOCALSRC=407>";
            $ezwebToEzweb["%e408%"] = "<IMG LOCALSRC=408>";
            $ezwebToEzweb["%e409%"] = "<IMG LOCALSRC=409>";
            $ezwebToEzweb["%e410%"] = "<IMG LOCALSRC=410>";
            $ezwebToEzweb["%e411%"] = "<IMG LOCALSRC=411>";
            $ezwebToEzweb["%e412%"] = "<IMG LOCALSRC=412>";
            $ezwebToEzweb["%e413%"] = "<IMG LOCALSRC=413>";
            $ezwebToEzweb["%e414%"] = "<IMG LOCALSRC=414>";
            $ezwebToEzweb["%e415%"] = "<IMG LOCALSRC=415>";
            $ezwebToEzweb["%e416%"] = "<IMG LOCALSRC=416>";
            $ezwebToEzweb["%e417%"] = "<IMG LOCALSRC=417>";
            $ezwebToEzweb["%e418%"] = "<IMG LOCALSRC=418>";
            $ezwebToEzweb["%e419%"] = "<IMG LOCALSRC=419>";
            $ezwebToEzweb["%e420%"] = "<IMG LOCALSRC=420>";
            $ezwebToEzweb["%e421%"] = "<IMG LOCALSRC=421>";
            $ezwebToEzweb["%e422%"] = "<IMG LOCALSRC=422>";
            $ezwebToEzweb["%e423%"] = "<IMG LOCALSRC=423>";
            $ezwebToEzweb["%e424%"] = "<IMG LOCALSRC=424>";
            $ezwebToEzweb["%e425%"] = "<IMG LOCALSRC=425>";
            $ezwebToEzweb["%e426%"] = "<IMG LOCALSRC=426>";
            $ezwebToEzweb["%e427%"] = "<IMG LOCALSRC=427>";
            $ezwebToEzweb["%e428%"] = "<IMG LOCALSRC=428>";
            $ezwebToEzweb["%e429%"] = "<IMG LOCALSRC=429>";
            $ezwebToEzweb["%e430%"] = "<IMG LOCALSRC=430>";
            $ezwebToEzweb["%e431%"] = "<IMG LOCALSRC=431>";
            $ezwebToEzweb["%e432%"] = "<IMG LOCALSRC=432>";
            $ezwebToEzweb["%e433%"] = "<IMG LOCALSRC=433>";
            $ezwebToEzweb["%e434%"] = "<IMG LOCALSRC=434>";
            $ezwebToEzweb["%e435%"] = "<IMG LOCALSRC=435>";
            $ezwebToEzweb["%e436%"] = "<IMG LOCALSRC=436>";
            $ezwebToEzweb["%e437%"] = "<IMG LOCALSRC=437>";
            $ezwebToEzweb["%e438%"] = "<IMG LOCALSRC=438>";
            $ezwebToEzweb["%e439%"] = "<IMG LOCALSRC=439>";
            $ezwebToEzweb["%e440%"] = "<IMG LOCALSRC=440>";
            $ezwebToEzweb["%e441%"] = "<IMG LOCALSRC=441>";
            $ezwebToEzweb["%e442%"] = "<IMG LOCALSRC=442>";
            $ezwebToEzweb["%e443%"] = "<IMG LOCALSRC=443>";
            $ezwebToEzweb["%e444%"] = "<IMG LOCALSRC=444>";
            $ezwebToEzweb["%e445%"] = "<IMG LOCALSRC=445>";
            $ezwebToEzweb["%e446%"] = "<IMG LOCALSRC=446>";
            $ezwebToEzweb["%e447%"] = "<IMG LOCALSRC=447>";
            $ezwebToEzweb["%e448%"] = "<IMG LOCALSRC=448>";
            $ezwebToEzweb["%e449%"] = "<IMG LOCALSRC=449>";
            $ezwebToEzweb["%e450%"] = "<IMG LOCALSRC=450>";
            $ezwebToEzweb["%e451%"] = "<IMG LOCALSRC=451>";
            $ezwebToEzweb["%e452%"] = "<IMG LOCALSRC=452>";
            $ezwebToEzweb["%e453%"] = "<IMG LOCALSRC=453>";
            $ezwebToEzweb["%e454%"] = "<IMG LOCALSRC=454>";
            $ezwebToEzweb["%e455%"] = "<IMG LOCALSRC=455>";
            $ezwebToEzweb["%e456%"] = "<IMG LOCALSRC=456>";
            $ezwebToEzweb["%e457%"] = "<IMG LOCALSRC=457>";
            $ezwebToEzweb["%e458%"] = "<IMG LOCALSRC=458>";
            $ezwebToEzweb["%e459%"] = "<IMG LOCALSRC=459>";
            $ezwebToEzweb["%e460%"] = "<IMG LOCALSRC=460>";
            $ezwebToEzweb["%e461%"] = "<IMG LOCALSRC=461>";
            $ezwebToEzweb["%e462%"] = "<IMG LOCALSRC=462>";
            $ezwebToEzweb["%e463%"] = "<IMG LOCALSRC=463>";
            $ezwebToEzweb["%e464%"] = "<IMG LOCALSRC=464>";
            $ezwebToEzweb["%e465%"] = "<IMG LOCALSRC=465>";
            $ezwebToEzweb["%e466%"] = "<IMG LOCALSRC=466>";
            $ezwebToEzweb["%e467%"] = "<IMG LOCALSRC=467>";
            $ezwebToEzweb["%e468%"] = "<IMG LOCALSRC=468>";
            $ezwebToEzweb["%e469%"] = "<IMG LOCALSRC=469>";
            $ezwebToEzweb["%e470%"] = "<IMG LOCALSRC=470>";
            $ezwebToEzweb["%e471%"] = "<IMG LOCALSRC=471>";
            $ezwebToEzweb["%e472%"] = "<IMG LOCALSRC=472>";
            $ezwebToEzweb["%e473%"] = "<IMG LOCALSRC=473>";
            $ezwebToEzweb["%e474%"] = "<IMG LOCALSRC=474>";
            $ezwebToEzweb["%e475%"] = "<IMG LOCALSRC=475>";
            $ezwebToEzweb["%e476%"] = "<IMG LOCALSRC=476>";
            $ezwebToEzweb["%e477%"] = "<IMG LOCALSRC=477>";
            $ezwebToEzweb["%e478%"] = "<IMG LOCALSRC=478>";
            $ezwebToEzweb["%e479%"] = "<IMG LOCALSRC=479>";
            $ezwebToEzweb["%e480%"] = "<IMG LOCALSRC=480>";
            $ezwebToEzweb["%e481%"] = "<IMG LOCALSRC=481>";
            $ezwebToEzweb["%e482%"] = "<IMG LOCALSRC=482>";
            $ezwebToEzweb["%e483%"] = "<IMG LOCALSRC=483>";
            $ezwebToEzweb["%e484%"] = "<IMG LOCALSRC=484>";
            $ezwebToEzweb["%e485%"] = "<IMG LOCALSRC=485>";
            $ezwebToEzweb["%e486%"] = "<IMG LOCALSRC=486>";
            $ezwebToEzweb["%e487%"] = "<IMG LOCALSRC=487>";
            $ezwebToEzweb["%e488%"] = "<IMG LOCALSRC=488>";
            $ezwebToEzweb["%e489%"] = "<IMG LOCALSRC=489>";
            $ezwebToEzweb["%e490%"] = "<IMG LOCALSRC=490>";
            $ezwebToEzweb["%e491%"] = "<IMG LOCALSRC=491>";
            $ezwebToEzweb["%e492%"] = "<IMG LOCALSRC=492>";
            $ezwebToEzweb["%e493%"] = "<IMG LOCALSRC=493>";
            $ezwebToEzweb["%e494%"] = "<IMG LOCALSRC=494>";
            $ezwebToEzweb["%e495%"] = "<IMG LOCALSRC=495>";
            $ezwebToEzweb["%e496%"] = "<IMG LOCALSRC=496>";
            $ezwebToEzweb["%e497%"] = "<IMG LOCALSRC=497>";
            $ezwebToEzweb["%e498%"] = "<IMG LOCALSRC=498>";
            $ezwebToEzweb["%e499%"] = "<IMG LOCALSRC=499>";
            $ezwebToEzweb["%e500%"] = "<IMG LOCALSRC=500>";
            $ezwebToEzweb["%e501%"] = "<IMG LOCALSRC=501>";
            $ezwebToEzweb["%e502%"] = "<IMG LOCALSRC=502>";
            $ezwebToEzweb["%e503%"] = "<IMG LOCALSRC=503>";
            $ezwebToEzweb["%e504%"] = "<IMG LOCALSRC=504>";
            $ezwebToEzweb["%e505%"] = "<IMG LOCALSRC=505>";
            $ezwebToEzweb["%e506%"] = "<IMG LOCALSRC=506>";
            $ezwebToEzweb["%e507%"] = "<IMG LOCALSRC=507>";
            $ezwebToEzweb["%e508%"] = "<IMG LOCALSRC=508>";
            $ezwebToEzweb["%e509%"] = "<IMG LOCALSRC=509>";
            $ezwebToEzweb["%e510%"] = "<IMG LOCALSRC=510>";
            $ezwebToEzweb["%e511%"] = "<IMG LOCALSRC=511>";
            $ezwebToEzweb["%e512%"] = "<IMG LOCALSRC=512>";
            $ezwebToEzweb["%e513%"] = "<IMG LOCALSRC=513>";
            $ezwebToEzweb["%e514%"] = "<IMG LOCALSRC=514>";
            $ezwebToEzweb["%e515%"] = "<IMG LOCALSRC=515>";
            $ezwebToEzweb["%e516%"] = "<IMG LOCALSRC=516>";
            $ezwebToEzweb["%e517%"] = "<IMG LOCALSRC=517>";
            $ezwebToEzweb["%e518%"] = "<IMG LOCALSRC=518>";
            $ezwebToEzweb["%e700%"] = "<IMG LOCALSRC=700>";
            $ezwebToEzweb["%e701%"] = "<IMG LOCALSRC=701>";
            $ezwebToEzweb["%e702%"] = "<IMG LOCALSRC=702>";
            $ezwebToEzweb["%e703%"] = "<IMG LOCALSRC=703>";
            $ezwebToEzweb["%e704%"] = "<IMG LOCALSRC=704>";
            $ezwebToEzweb["%e705%"] = "<IMG LOCALSRC=705>";
            $ezwebToEzweb["%e706%"] = "<IMG LOCALSRC=706>";
            $ezwebToEzweb["%e707%"] = "<IMG LOCALSRC=707>";
            $ezwebToEzweb["%e708%"] = "<IMG LOCALSRC=708>";
            $ezwebToEzweb["%e709%"] = "<IMG LOCALSRC=709>";
            $ezwebToEzweb["%e710%"] = "<IMG LOCALSRC=710>";
            $ezwebToEzweb["%e711%"] = "<IMG LOCALSRC=711>";
            $ezwebToEzweb["%e712%"] = "<IMG LOCALSRC=712>";
            $ezwebToEzweb["%e713%"] = "<IMG LOCALSRC=713>";
            $ezwebToEzweb["%e714%"] = "<IMG LOCALSRC=714>";
            $ezwebToEzweb["%e715%"] = "<IMG LOCALSRC=715>";
            $ezwebToEzweb["%e716%"] = "<IMG LOCALSRC=716>";
            $ezwebToEzweb["%e717%"] = "<IMG LOCALSRC=717>";
            $ezwebToEzweb["%e718%"] = "<IMG LOCALSRC=718>";
            $ezwebToEzweb["%e719%"] = "<IMG LOCALSRC=719>";
            $ezwebToEzweb["%e720%"] = "<IMG LOCALSRC=720>";
            $ezwebToEzweb["%e721%"] = "<IMG LOCALSRC=721>";
            $ezwebToEzweb["%e722%"] = "<IMG LOCALSRC=722>";
            $ezwebToEzweb["%e723%"] = "<IMG LOCALSRC=723>";
            $ezwebToEzweb["%e724%"] = "<IMG LOCALSRC=724>";
            $ezwebToEzweb["%e725%"] = "<IMG LOCALSRC=725>";
            $ezwebToEzweb["%e726%"] = "<IMG LOCALSRC=726>";
            $ezwebToEzweb["%e727%"] = "<IMG LOCALSRC=727>";
            $ezwebToEzweb["%e728%"] = "<IMG LOCALSRC=728>";
            $ezwebToEzweb["%e729%"] = "<IMG LOCALSRC=729>";
            $ezwebToEzweb["%e730%"] = "<IMG LOCALSRC=730>";
            $ezwebToEzweb["%e731%"] = "<IMG LOCALSRC=731>";
            $ezwebToEzweb["%e732%"] = "<IMG LOCALSRC=732>";
            $ezwebToEzweb["%e733%"] = "<IMG LOCALSRC=733>";
            $ezwebToEzweb["%e734%"] = "<IMG LOCALSRC=734>";
            $ezwebToEzweb["%e735%"] = "<IMG LOCALSRC=735>";
            $ezwebToEzweb["%e736%"] = "<IMG LOCALSRC=736>";
            $ezwebToEzweb["%e737%"] = "<IMG LOCALSRC=737>";
            $ezwebToEzweb["%e738%"] = "<IMG LOCALSRC=738>";
            $ezwebToEzweb["%e739%"] = "<IMG LOCALSRC=739>";
            $ezwebToEzweb["%e740%"] = "<IMG LOCALSRC=740>";
            $ezwebToEzweb["%e741%"] = "<IMG LOCALSRC=741>";
            $ezwebToEzweb["%e742%"] = "<IMG LOCALSRC=742>";
            $ezwebToEzweb["%e743%"] = "<IMG LOCALSRC=743>";
            $ezwebToEzweb["%e744%"] = "<IMG LOCALSRC=744>";
            $ezwebToEzweb["%e745%"] = "<IMG LOCALSRC=745>";
            $ezwebToEzweb["%e746%"] = "<IMG LOCALSRC=746>";
            $ezwebToEzweb["%e747%"] = "<IMG LOCALSRC=747>";
            $ezwebToEzweb["%e748%"] = "<IMG LOCALSRC=748>";
            $ezwebToEzweb["%e749%"] = "<IMG LOCALSRC=749>";
            $ezwebToEzweb["%e750%"] = "<IMG LOCALSRC=750>";
            $ezwebToEzweb["%e751%"] = "<IMG LOCALSRC=751>";
            $ezwebToEzweb["%e752%"] = "<IMG LOCALSRC=752>";
            $ezwebToEzweb["%e753%"] = "<IMG LOCALSRC=753>";
            $ezwebToEzweb["%e754%"] = "<IMG LOCALSRC=754>";
            $ezwebToEzweb["%e755%"] = "<IMG LOCALSRC=755>";
            $ezwebToEzweb["%e756%"] = "<IMG LOCALSRC=756>";
            $ezwebToEzweb["%e757%"] = "<IMG LOCALSRC=757>";
            $ezwebToEzweb["%e758%"] = "<IMG LOCALSRC=758>";
            $ezwebToEzweb["%e759%"] = "<IMG LOCALSRC=759>";
            $ezwebToEzweb["%e760%"] = "<IMG LOCALSRC=760>";
            $ezwebToEzweb["%e761%"] = "<IMG LOCALSRC=761>";
            $ezwebToEzweb["%e762%"] = "<IMG LOCALSRC=762>";
            $ezwebToEzweb["%e763%"] = "<IMG LOCALSRC=763>";
            $ezwebToEzweb["%e764%"] = "<IMG LOCALSRC=764>";
            $ezwebToEzweb["%e765%"] = "<IMG LOCALSRC=765>";
            $ezwebToEzweb["%e766%"] = "<IMG LOCALSRC=766>";
            $ezwebToEzweb["%e767%"] = "<IMG LOCALSRC=767>";
            $ezwebToEzweb["%e768%"] = "<IMG LOCALSRC=768>";
            $ezwebToEzweb["%e769%"] = "<IMG LOCALSRC=769>";
            $ezwebToEzweb["%e770%"] = "<IMG LOCALSRC=770>";
            $ezwebToEzweb["%e771%"] = "<IMG LOCALSRC=771>";
            $ezwebToEzweb["%e772%"] = "<IMG LOCALSRC=772>";
            $ezwebToEzweb["%e773%"] = "<IMG LOCALSRC=773>";
            $ezwebToEzweb["%e774%"] = "<IMG LOCALSRC=774>";
            $ezwebToEzweb["%e775%"] = "<IMG LOCALSRC=775>";
            $ezwebToEzweb["%e776%"] = "<IMG LOCALSRC=776>";
            $ezwebToEzweb["%e777%"] = "<IMG LOCALSRC=777>";
            $ezwebToEzweb["%e778%"] = "<IMG LOCALSRC=778>";
            $ezwebToEzweb["%e779%"] = "<IMG LOCALSRC=779>";
            $ezwebToEzweb["%e780%"] = "<IMG LOCALSRC=780>";
            $ezwebToEzweb["%e781%"] = "<IMG LOCALSRC=781>";
            $ezwebToEzweb["%e782%"] = "<IMG LOCALSRC=782>";
            $ezwebToEzweb["%e783%"] = "<IMG LOCALSRC=783>";
            $ezwebToEzweb["%e784%"] = "<IMG LOCALSRC=784>";
            $ezwebToEzweb["%e785%"] = "<IMG LOCALSRC=785>";
            $ezwebToEzweb["%e786%"] = "<IMG LOCALSRC=786>";
            $ezwebToEzweb["%e787%"] = "<IMG LOCALSRC=787>";
            $ezwebToEzweb["%e788%"] = "<IMG LOCALSRC=788>";
            $ezwebToEzweb["%e789%"] = "<IMG LOCALSRC=789>";
            $ezwebToEzweb["%e790%"] = "<IMG LOCALSRC=790>";
            $ezwebToEzweb["%e791%"] = "<IMG LOCALSRC=791>";
            $ezwebToEzweb["%e792%"] = "<IMG LOCALSRC=792>";
            $ezwebToEzweb["%e793%"] = "<IMG LOCALSRC=793>";
            $ezwebToEzweb["%e794%"] = "<IMG LOCALSRC=794>";
            $ezwebToEzweb["%e795%"] = "<IMG LOCALSRC=795>";
            $ezwebToEzweb["%e796%"] = "<IMG LOCALSRC=796>";
            $ezwebToEzweb["%e797%"] = "<IMG LOCALSRC=797>";
            $ezwebToEzweb["%e798%"] = "<IMG LOCALSRC=798>";
            $ezwebToEzweb["%e799%"] = "<IMG LOCALSRC=799>";
            $ezwebToEzweb["%e800%"] = "<IMG LOCALSRC=800>";
            $ezwebToEzweb["%e801%"] = "<IMG LOCALSRC=801>";
            $ezwebToEzweb["%e802%"] = "<IMG LOCALSRC=802>";
            $ezwebToEzweb["%e803%"] = "<IMG LOCALSRC=803>";
            $ezwebToEzweb["%e804%"] = "<IMG LOCALSRC=804>";
            $ezwebToEzweb["%e805%"] = "<IMG LOCALSRC=805>";
            $ezwebToEzweb["%e806%"] = "<IMG LOCALSRC=806>";
            $ezwebToEzweb["%e807%"] = "<IMG LOCALSRC=807>";
            $ezwebToEzweb["%e808%"] = "<IMG LOCALSRC=808>";
            $ezwebToEzweb["%e809%"] = "<IMG LOCALSRC=809>";
            $ezwebToEzweb["%e810%"] = "<IMG LOCALSRC=810>";
            $ezwebToEzweb["%e811%"] = "<IMG LOCALSRC=811>";
            $ezwebToEzweb["%e812%"] = "<IMG LOCALSRC=812>";
            $ezwebToEzweb["%e813%"] = "<IMG LOCALSRC=813>";
            $ezwebToEzweb["%e814%"] = "<IMG LOCALSRC=814>";
            $ezwebToEzweb["%e815%"] = "<IMG LOCALSRC=815>";
            $ezwebToEzweb["%e816%"] = "<IMG LOCALSRC=816>";
            $ezwebToEzweb["%e817%"] = "<IMG LOCALSRC=817>";
            $ezwebToEzweb["%e818%"] = "<IMG LOCALSRC=818>";
            $ezwebToEzweb["%e819%"] = "<IMG LOCALSRC=819>";
            $ezwebToEzweb["%e820%"] = "<IMG LOCALSRC=820>";
            $ezwebToEzweb["%e821%"] = "<IMG LOCALSRC=821>";
            $ezwebToEzweb["%e822%"] = "<IMG LOCALSRC=822>";
        }

        return $ezwebToEzweb;
    }

    /**
     * getEzwebToDocomoメソッド
     *
     * Ezweb用の変換文字をキーにしたDocomo絵文字データ配列を返します。
     *
     * @return $ezwebToDocomo Docomo絵文字配列
     */
    public static function getEzwebToDocomo() {
        static $ezwebToDocomo;

        if (!isset($ezwebToDocomo)) {
            $ezwebToDocomo["%e1%"] = "<span style=\"color:orange;\">&#xE737;</span>";    // 危険・警告
            $ezwebToDocomo["%e2%"] = "<span style=\"color:red;\">&#xE702;</span>";    // exclamation
            $ezwebToDocomo["%e3%"] = "?";
            $ezwebToDocomo["%e4%"] = "&#xE6E1;";    // モバＱ
            $ezwebToDocomo["%e5%"] = "<";
            $ezwebToDocomo["%e6%"] = ">";
            $ezwebToDocomo["%e7%"] = "<<";
            $ezwebToDocomo["%e8%"] = ">>";
            $ezwebToDocomo["%e9%"] = "■";
            $ezwebToDocomo["%e10%"] = "■";
            $ezwebToDocomo["%e11%"] = "[i]";
            $ezwebToDocomo["%e12%"] = "<span style=\"color:blueviolet;\">&#xE756;</span>";    // ワイングラス
            $ezwebToDocomo["%e13%"] = "[ｽﾋﾟｰｶ]";
            $ezwebToDocomo["%e14%"] = "<span style=\"color:salmon;\">&#xE715;</span>";    // ドル袋
            $ezwebToDocomo["%e15%"] = "&#xE69F;";    // 三日月
            $ezwebToDocomo["%e16%"] = "<span style=\"color:gold;\">&#xE642;</span>";    // 雷
            $ezwebToDocomo["%e17%"] = "■";
            $ezwebToDocomo["%e18%"] = "■";
            $ezwebToDocomo["%e19%"] = "◆";
            $ezwebToDocomo["%e20%"] = "◆";
            $ezwebToDocomo["%e21%"] = "■";
            $ezwebToDocomo["%e22%"] = "■";
            $ezwebToDocomo["%e23%"] = "&#xE69C;";    // 新月
            $ezwebToDocomo["%e24%"] = "&#xE69C;";    // 新月
            $ezwebToDocomo["%e25%"] = "&#xE71F;";    // 腕時計
            $ezwebToDocomo["%e26%"] = "＋";
            $ezwebToDocomo["%e27%"] = "－";
            $ezwebToDocomo["%e28%"] = "＊";
            $ezwebToDocomo["%e29%"] = "↑";
            $ezwebToDocomo["%e30%"] = "↓";
            $ezwebToDocomo["%e31%"] = "<span style=\"color:red;\">&#xE738;</span>";    // 禁止
            $ezwebToDocomo["%e32%"] = "▼";
            $ezwebToDocomo["%e33%"] = "▲";
            $ezwebToDocomo["%e34%"] = "▼";
            $ezwebToDocomo["%e35%"] = "▲";
            $ezwebToDocomo["%e36%"] = "◆";
            $ezwebToDocomo["%e37%"] = "◆";
            $ezwebToDocomo["%e38%"] = "■";
            $ezwebToDocomo["%e39%"] = "■";
            $ezwebToDocomo["%e40%"] = "&#xE69C;";    // 新月
            $ezwebToDocomo["%e41%"] = "&#xE69C;";    // 新月
            $ezwebToDocomo["%e42%"] = "&#xE697;";    // 左斜め上
            $ezwebToDocomo["%e43%"] = "&#xE696;";    // 右斜め下
            $ezwebToDocomo["%e44%"] = "<span style=\"color:red;\">&#xE63E;</span>";    // 晴れ
            $ezwebToDocomo["%e45%"] = "&#xE653;";    // 野球
            $ezwebToDocomo["%e46%"] = "&#xE6BA;";    // 時計
            $ezwebToDocomo["%e47%"] = "&#xE69E;";    // 半月
            $ezwebToDocomo["%e48%"] = "<span style=\"color:gold;\">&#xE713;</span>";    // チャペル
            $ezwebToDocomo["%e49%"] = "φ";
            $ezwebToDocomo["%e50%"] = "<span style=\"color:pink;\">&#xE6F0;</span>";    // わーい（嬉しい顔）
            $ezwebToDocomo["%e51%"] = "<span style=\"color:red;\">&#xE6EC;</span>";    // 黒ハート
            $ezwebToDocomo["%e52%"] = "<span style=\"color:plum;\">&#xE671;</span>";    // バー
            $ezwebToDocomo["%e53%"] = "<span style=\"color:green;\">&#xE741;</span>";    // クローバー
            $ezwebToDocomo["%e54%"] = "&#xE732;";    // トレードマーク
            $ezwebToDocomo["%e55%"] = "×";
            $ezwebToDocomo["%e56%"] = "<span style=\"color:gold;\">&#xE689;</span>";    // メモ
            $ezwebToDocomo["%e57%"] = "&#xE71C;";    // 砂時計
            $ezwebToDocomo["%e58%"] = "&#xE71C;";    // 砂時計
            $ezwebToDocomo["%e59%"] = "[ﾌﾛｯﾋﾟｰ]";
            $ezwebToDocomo["%e60%"] = "[雪結晶]";
            $ezwebToDocomo["%e61%"] = "×";
            $ezwebToDocomo["%e62%"] = "×";
            $ezwebToDocomo["%e63%"] = "→";
            $ezwebToDocomo["%e64%"] = "←";
            $ezwebToDocomo["%e65%"] = "<span style=\"color:gold;\">&#xE672;</span>";    // ビール
            $ezwebToDocomo["%e66%"] = "÷";
            $ezwebToDocomo["%e67%"] = "[ｶﾚﾝﾀﾞｰ]";
            $ezwebToDocomo["%e68%"] = "<span style=\"color:pink;\">&#xE6F0;</span>";    // わーい（嬉しい顔）
            $ezwebToDocomo["%e69%"] = "☆";
            $ezwebToDocomo["%e70%"] = "&#xE678;";    // 右斜め上
            $ezwebToDocomo["%e71%"] = "&#xE6A5;";    // 左斜め下
            $ezwebToDocomo["%e72%"] = "<span style=\"color:plum;\">&#xE71B;</span>";    // 指輪
            $ezwebToDocomo["%e73%"] = "[ﾁｪｯｸﾏｰｸ]";
            $ezwebToDocomo["%e74%"] = "<span style=\"color:orange;\">&#xE6A1;</span>";    // 犬
            $ezwebToDocomo["%e75%"] = "☆彡";
            $ezwebToDocomo["%e76%"] = "<span style=\"color:gold;\">&#xE6FA;</span>";    // ぴかぴか（新しい）
            $ezwebToDocomo["%e77%"] = "<span style=\"color:gold;\">&#xE6FB;</span>";    // ひらめき
            $ezwebToDocomo["%e78%"] = "<span style=\"color:gold;\">&#xE74F;</span>";    // ひよこ
            $ezwebToDocomo["%e79%"] = "[ﾌｫﾙﾀﾞ]";
            $ezwebToDocomo["%e80%"] = "<span style=\"color:pink;\">&#xE6F0;</span>";    // わーい（嬉しい顔）
            $ezwebToDocomo["%e81%"] = "&#xE731;";    // コピーライト
            $ezwebToDocomo["%e82%"] = "&#xE736;";    // レジスタードトレードマーク
            $ezwebToDocomo["%e83%"] = "<span style=\"color:red;\">&#xE682;</span>";    // カバン
            $ezwebToDocomo["%e84%"] = "[ﾌｫﾙﾀﾞ]";
            $ezwebToDocomo["%e85%"] = "&#xE687;";    // 電話
            $ezwebToDocomo["%e86%"] = "[ﾌｷﾀﾞｼ]";
            $ezwebToDocomo["%e87%"] = "[ｶｰﾄﾞ]";
            $ezwebToDocomo["%e88%"] = "▲";
            $ezwebToDocomo["%e89%"] = "▼";
            $ezwebToDocomo["%e90%"] = "[USA]";
            $ezwebToDocomo["%e91%"] = "<span style=\"color:gold;\">&#xE683;</span>";    // 本
            $ezwebToDocomo["%e92%"] = "<span style=\"color:gold;\">&#xE689;</span>";    // メモ
            $ezwebToDocomo["%e93%"] = "<span style=\"color:green;\">&#xE670;</span>";    // 喫茶店
            $ezwebToDocomo["%e94%"] = "&#xE681;";    // カメラ
            $ezwebToDocomo["%e95%"] = "<span style=\"color:blue;\">&#xE640;</span>";    // 雨
            $ezwebToDocomo["%e96%"] = "[ﾌｯﾄﾎﾞｰﾙ]";
            $ezwebToDocomo["%e97%"] = "<span style=\"color:gold;\">&#xE683;</span>";    // 本
            $ezwebToDocomo["%e98%"] = "<span style=\"color:red;\">&#xE72F;</span>";    // NG
            $ezwebToDocomo["%e99%"] = "&#xE66D;";    // 信号
            $ezwebToDocomo["%e100%"] = "<span style=\"color:gold;\">&#xE683;</span>";    // 本
            $ezwebToDocomo["%e101%"] = "<span style=\"color:gold;\">&#xE683;</span>";    // 本
            $ezwebToDocomo["%e102%"] = "<span style=\"color:gold;\">&#xE683;</span>";    // 本
            $ezwebToDocomo["%e103%"] = "<span style=\"color:gold;\">&#xE689;</span>";    // メモ
            $ezwebToDocomo["%e104%"] = "<span style=\"color:blue;\">&#xE675;</span>";    // 美容院
            $ezwebToDocomo["%e105%"] = "[ｶﾚﾝﾀﾞｰ]";
            $ezwebToDocomo["%e106%"] = "<span style=\"color:gold;\">&#xE67E;</span>";    // チケット
            $ezwebToDocomo["%e107%"] = "<span style=\"color:blue;\">&#xE63F;</span>";    // 曇り
            $ezwebToDocomo["%e108%"] = "&#xE6D3;";    // メール
            $ezwebToDocomo["%e109%"] = "<span style=\"color:red;\">&#xE6D6;</span>";    // 有料
            $ezwebToDocomo["%e110%"] = "&#xE677;";    // 映画
            $ezwebToDocomo["%e111%"] = "&#xE677;";    // 映画
            $ezwebToDocomo["%e112%"] = "<span style=\"color:red;\">&#xE663;</span>";    // 家
            $ezwebToDocomo["%e113%"] = "<span style=\"color:red;\">&#xE743;</span>";    // チューリップ
            $ezwebToDocomo["%e114%"] = "[包丁]";
            $ezwebToDocomo["%e115%"] = "[ﾋﾞﾃﾞｵ]";
            $ezwebToDocomo["%e116%"] = "&#xE69A;";    // 眼鏡
            $ezwebToDocomo["%e117%"] = "└→";
            $ezwebToDocomo["%e118%"] = "<span style=\"color:red;\">&#xE6DA;</span>";    // 次項有
            $ezwebToDocomo["%e119%"] = "<span style=\"color:blue;\">&#xE6DC;</span>";    // サーチ（調べる）
            $ezwebToDocomo["%e120%"] = "<span style=\"color:red;\">&#xE6D9;</span>";    // パスワード
            $ezwebToDocomo["%e121%"] = "<span style=\"color:gold;\">&#xE683;</span>";    // 本
            $ezwebToDocomo["%e122%"] = "<span style=\"color:gold;\">&#xE683;</span>";    // 本
            $ezwebToDocomo["%e123%"] = "[ﾈｼﾞ]";
            $ezwebToDocomo["%e124%"] = "<span style=\"color:red;\">&#xE674;</span>";    // ブティック
            $ezwebToDocomo["%e125%"] = "&#xE65E;";    // 車（セダン）
            $ezwebToDocomo["%e126%"] = "[ﾌﾛｯﾋﾟｰ]";
            $ezwebToDocomo["%e127%"] = "[ｸﾞﾗﾌ]";
            $ezwebToDocomo["%e128%"] = "[ｸﾞﾗﾌ]";
            $ezwebToDocomo["%e129%"] = "<span style=\"color:red;\">&#xE665;</span>";    // 郵便局
            $ezwebToDocomo["%e130%"] = "<span style=\"color:gold;\">&#xE6FB;</span>";    // ひらめき
            $ezwebToDocomo["%e131%"] = "<span style=\"color:gold;\">&#xE683;</span>";    // 本
            $ezwebToDocomo["%e132%"] = "[ﾁｪｯｸﾏｰｸ]";
            $ezwebToDocomo["%e133%"] = "<span style=\"color:red;\">&#xE747;</span>";    // もみじ
            $ezwebToDocomo["%e134%"] = "<span style=\"color:orange;\">&#xE6A1;</span>";    // 犬
            $ezwebToDocomo["%e135%"] = "[電池]";
            $ezwebToDocomo["%e136%"] = "&#xE70A;";    // ー（長音記号２）
            $ezwebToDocomo["%e137%"] = "[画びょう]";
            $ezwebToDocomo["%e138%"] = "<span style=\"color:red;\">&#xE6D9;</span>";    // パスワード
            $ezwebToDocomo["%e139%"] = "<span style=\"color:salmon;\">&#xE715;</span>";    // ドル袋
            $ezwebToDocomo["%e140%"] = "←";
            $ezwebToDocomo["%e141%"] = "→";
            $ezwebToDocomo["%e142%"] = "<span style=\"color:gold;\">&#xE683;</span>";    // 本
            $ezwebToDocomo["%e143%"] = "<span style=\"color:blue;\">&#xE730;</span>";    // クリップ
            $ezwebToDocomo["%e144%"] = "<span style=\"color:red;\">&#xE685;</span>";    // プレゼント
            $ezwebToDocomo["%e145%"] = "[名札]";
            $ezwebToDocomo["%e146%"] = "&#xE66F;";    // レストラン
            $ezwebToDocomo["%e147%"] = "<span style=\"color:gold;\">&#xE683;</span>";    // 本
            $ezwebToDocomo["%e148%"] = "[ﾄﾗｯｸ]";
            $ezwebToDocomo["%e149%"] = "<span style=\"color:green;\">&#xE719;</span>";    // 鉛筆
            $ezwebToDocomo["%e150%"] = "[PDC]";
            $ezwebToDocomo["%e151%"] = "&#xE6CF;";    // mail to
            $ezwebToDocomo["%e152%"] = "&#xE718;";    // レンチ
            $ezwebToDocomo["%e153%"] = "[送信BOX]";
            $ezwebToDocomo["%e154%"] = "[受信BOX]";
            $ezwebToDocomo["%e155%"] = "&#xE687;";    // 電話
            $ezwebToDocomo["%e156%"] = "<span style=\"color:blue;\">&#xE664;</span>";    // ビル
            $ezwebToDocomo["%e157%"] = "[定規]";
            $ezwebToDocomo["%e158%"] = "[三角定規]";
            $ezwebToDocomo["%e159%"] = "[ｸﾞﾗﾌ]";
            $ezwebToDocomo["%e160%"] = "[肉]";
            $ezwebToDocomo["%e161%"] = "&#xE688;";    // 携帯電話
            $ezwebToDocomo["%e162%"] = "[ｺﾝｾﾝﾄ]";
            $ezwebToDocomo["%e163%"] = "[家族]";
            $ezwebToDocomo["%e164%"] = "[ﾘﾝｸ]";
            $ezwebToDocomo["%e165%"] = "<span style=\"color:red;\">&#xE685;</span>";    // プレゼント
            $ezwebToDocomo["%e166%"] = "&#xE6D0;";    // fax to
            $ezwebToDocomo["%e167%"] = "%i1%%i2%";
            $ezwebToDocomo["%e168%"] = "<span style=\"color:blue;\">&#xE662;</span>";    // 飛行機
            $ezwebToDocomo["%e169%"] = "<span style=\"color:blue;\">&#xE6A3;</span>";    // リゾート
            $ezwebToDocomo["%e170%"] = "[ｻｲｺﾛ]";
            $ezwebToDocomo["%e171%"] = "[新聞]";
            $ezwebToDocomo["%e172%"] = "<span style=\"color:green;\">&#xE65B;</span>";    // 電車
            $ezwebToDocomo["%e173%"] = "　";
            $ezwebToDocomo["%e174%"] = "";
            $ezwebToDocomo["%e175%"] = "";
            $ezwebToDocomo["%e176%"] = "&#xE67F;";    // 喫煙
            $ezwebToDocomo["%e177%"] = "<span style=\"color:red;\">&#xE680;</span>";    // 禁煙
            $ezwebToDocomo["%e178%"] = "<span style=\"color:blue;\">&#xE69B;</span>";    // 車椅子
            $ezwebToDocomo["%e179%"] = "[若葉ﾏｰｸ]";
            $ezwebToDocomo["%e180%"] = "&#xE6E2;";    // 1
            $ezwebToDocomo["%e181%"] = "&#xE6E3;";    // 2
            $ezwebToDocomo["%e182%"] = "&#xE6E4;";    // 3
            $ezwebToDocomo["%e183%"] = "&#xE6E5;";    // 4
            $ezwebToDocomo["%e184%"] = "&#xE6E6;";    // 5
            $ezwebToDocomo["%e185%"] = "&#xE6E7;";    // 6
            $ezwebToDocomo["%e186%"] = "&#xE6E8;";    // 7
            $ezwebToDocomo["%e187%"] = "&#xE6E9;";    // 8
            $ezwebToDocomo["%e188%"] = "&#xE6EA;";    // 9
            $ezwebToDocomo["%e189%"] = "[10]";
            $ezwebToDocomo["%e190%"] = "<span style=\"color:red;\">&#xE643;</span>";    // 台風
            $ezwebToDocomo["%e191%"] = "<span style=\"color:blue;\">&#xE641;</span>";    // 雪
            $ezwebToDocomo["%e192%"] = "<span style=\"color:red;\">&#xE646;</span>";    // 牡羊座
            $ezwebToDocomo["%e193%"] = "<span style=\"color:orange;\">&#xE647;</span>";    // 牡牛座
            $ezwebToDocomo["%e194%"] = "<span style=\"color:green;\">&#xE648;</span>";    // 双子座
            $ezwebToDocomo["%e195%"] = "<span style=\"color:blue;\">&#xE649;</span>";    // 蟹座
            $ezwebToDocomo["%e196%"] = "<span style=\"color:red;\">&#xE64A;</span>";    // 獅子座
            $ezwebToDocomo["%e197%"] = "<span style=\"color:orange;\">&#xE64B;</span>";    // 乙女座
            $ezwebToDocomo["%e198%"] = "<span style=\"color:green;\">&#xE64C;</span>";    // 天秤座
            $ezwebToDocomo["%e199%"] = "<span style=\"color:blue;\">&#xE64D;</span>";    // 蠍座
            $ezwebToDocomo["%e200%"] = "<span style=\"color:red;\">&#xE64E;</span>";    // 射手座
            $ezwebToDocomo["%e201%"] = "<span style=\"color:orange;\">&#xE64F;</span>";    // 山羊座
            $ezwebToDocomo["%e202%"] = "<span style=\"color:green;\">&#xE650;</span>";    // 水瓶座
            $ezwebToDocomo["%e203%"] = "<span style=\"color:blue;\">&#xE651;</span>";    // 魚座
            $ezwebToDocomo["%e204%"] = "[蛇使座]";
            $ezwebToDocomo["%e205%"] = "<span style=\"color:red;\">&#xE668;</span>";    // ＡＴＭ
            $ezwebToDocomo["%e206%"] = "<span style=\"color:blue;\">&#xE66A;</span>";    // コンビニ
            $ezwebToDocomo["%e207%"] = "&#xE66E;";    // トイレ
            $ezwebToDocomo["%e208%"] = "<span style=\"color:blue;\">&#xE66C;</span>";    // 駐車場
            $ezwebToDocomo["%e209%"] = "[ﾊﾞｽ停]";
            $ezwebToDocomo["%e210%"] = "[ｱﾝﾃﾅ]";
            $ezwebToDocomo["%e211%"] = "<span style=\"color:blue;\">&#xE661;</span>";    // 船
            $ezwebToDocomo["%e212%"] = "<span style=\"color:plum;\">&#xE667;</span>";    // 銀行
            $ezwebToDocomo["%e213%"] = "<span style=\"color:plum;\">&#xE66B;</span>";    // ガソリンスタンド
            $ezwebToDocomo["%e214%"] = "[地図]";
            $ezwebToDocomo["%e215%"] = "&#xE71D;";    // 自転車
            $ezwebToDocomo["%e216%"] = "<span style=\"color:red;\">&#xE660;</span>";    // バス
            $ezwebToDocomo["%e217%"] = "<span style=\"color:blue;\">&#xE65D;</span>";    // 新幹線
            $ezwebToDocomo["%e218%"] = "&#xE733;";    // 走る人
            $ezwebToDocomo["%e219%"] = "&#xE656;";    // サッカー
            $ezwebToDocomo["%e220%"] = "<span style=\"color:green;\">&#xE655;</span>";    // テニス
            $ezwebToDocomo["%e221%"] = "<span style=\"color:blue;\">&#xE712;</span>";    // スノボ
            $ezwebToDocomo["%e222%"] = "&#xE659;";    // モータースポーツ
            $ezwebToDocomo["%e223%"] = "[観覧車]";
            $ezwebToDocomo["%e224%"] = "<span style=\"color:red;\">&#xE6F7;</span>";    // いい気分（温泉）
            $ezwebToDocomo["%e225%"] = "<span style=\"color:salmon;\">&#xE74B;</span>";    // とっくり（おちょこ付き）
            $ezwebToDocomo["%e226%"] = "&#xE6AC;";    // カチンコ
            $ezwebToDocomo["%e227%"] = "&#xE6B3;";    // 夜
            $ezwebToDocomo["%e228%"] = "[東京ﾀﾜｰ]";
            $ezwebToDocomo["%e229%"] = "[777]";
            $ezwebToDocomo["%e230%"] = "[ｵﾒﾃﾞﾄｳ]";
            $ezwebToDocomo["%e231%"] = "[的中]";
            $ezwebToDocomo["%e232%"] = "&#xE68B;";    // ゲーム
            $ezwebToDocomo["%e233%"] = "<span style=\"color:salmon;\">&#xE715;</span>";    // ドル袋
            $ezwebToDocomo["%e234%"] = "<span style=\"color:green;\">&#xE6A4;</span>";    // クリスマス
            $ezwebToDocomo["%e235%"] = "<span style=\"color:pink;\">&#xE748;</span>";    // 桜
            $ezwebToDocomo["%e236%"] = "[お化け]";
            $ezwebToDocomo["%e237%"] = "[日の丸]";
            $ezwebToDocomo["%e238%"] = "[ｽｲｶ]";
            $ezwebToDocomo["%e239%"] = "<span style=\"color:red;\">&#xE74A;</span>";    // ショートケーキ
            $ezwebToDocomo["%e240%"] = "[ﾌﾗｲﾊﾟﾝ]";
            $ezwebToDocomo["%e241%"] = "<span style=\"color:red;\">&#xE742;</span>";    // さくらんぼ
            $ezwebToDocomo["%e242%"] = "<span style=\"color:blue;\">&#xE751;</span>";    // 魚
            $ezwebToDocomo["%e243%"] = "[ｲﾁｺﾞ]";
            $ezwebToDocomo["%e244%"] = "&#xE749;";    // おにぎり
            $ezwebToDocomo["%e245%"] = "<span style=\"color:gold;\">&#xE673;</span>";    // ファーストフード
            $ezwebToDocomo["%e246%"] = "[ｸｼﾞﾗ]";
            $ezwebToDocomo["%e247%"] = "[ｳｻｷﾞ]";
            $ezwebToDocomo["%e248%"] = "<span style=\"color:salmon;\">&#xE754;</span>";    // ウマ
            $ezwebToDocomo["%e249%"] = "[ｻﾙ]";
            $ezwebToDocomo["%e250%"] = "[ｶｴﾙ]";
            $ezwebToDocomo["%e251%"] = "<span style=\"color:orange;\">&#xE6A2;</span>";    // 猫
            $ezwebToDocomo["%e252%"] = "<span style=\"color:blue;\">&#xE750;</span>";    // ペンギン
            $ezwebToDocomo["%e253%"] = "[ｱﾘ]";
            $ezwebToDocomo["%e254%"] = "<span style=\"color:orange;\">&#xE755;</span>";    // ブタ
            $ezwebToDocomo["%e255%"] = "[ﾋﾞｰﾁ]";
            $ezwebToDocomo["%e256%"] = "[ひまわり]";
            $ezwebToDocomo["%e257%"] = "<span style=\"color:pink;\">&#xE6F0;</span>";    // わーい（嬉しい顔）
            $ezwebToDocomo["%e258%"] = "<span style=\"color:red;\">&#xE6F1;</span>";    // ちっ（怒った顔）
            $ezwebToDocomo["%e259%"] = "<span style=\"color:blue;\">&#xE72D;</span>";    // 泣き顔
            $ezwebToDocomo["%e260%"] = "<span style=\"color:blue;\">&#xE72B;</span>";    // がまん顔
            $ezwebToDocomo["%e261%"] = "<span style=\"color:blue;\">&#xE701;</span>";    // 眠い(睡眠)
            $ezwebToDocomo["%e262%"] = "&#xE6FC;";    // むかっ（怒り）
            $ezwebToDocomo["%e263%"] = "&#xE707;";    // たらーっ（汗）
            $ezwebToDocomo["%e264%"] = "<span style=\"color:red;\">&#xE728;</span>";    // あっかんべー
            $ezwebToDocomo["%e265%"] = "<span style=\"color:red;\">&#xE6EE;</span>";    // 失恋
            $ezwebToDocomo["%e266%"] = "<span style=\"color:red;\">&#xE6EF;</span>";    // ハートたち（複数ハート）
            $ezwebToDocomo["%e267%"] = "<span style=\"color:gold;\">&#xE6FA;</span>";    // ぴかぴか（新しい）
            $ezwebToDocomo["%e268%"] = "&#xE6FE;";    // 爆弾
            $ezwebToDocomo["%e269%"] = "[炎]";
            $ezwebToDocomo["%e270%"] = "[SOS]";
            $ezwebToDocomo["%e271%"] = "[力こぶ]";
            $ezwebToDocomo["%e272%"] = "<span style=\"color:red;\">&#xE6EC;</span>";    // 黒ハート
            $ezwebToDocomo["%e273%"] = "<span style=\"color:red;\">&#xE6F9;</span>";    // キスマーク
            $ezwebToDocomo["%e274%"] = "[宇宙人]";
            $ezwebToDocomo["%e275%"] = "<span style=\"color:red;\">&#xE643;</span>";    // 台風
            $ezwebToDocomo["%e276%"] = "<span style=\"color:orange;\">&#xE698;</span>";    // 足
            $ezwebToDocomo["%e277%"] = "[ｱｸﾏ]";
            $ezwebToDocomo["%e278%"] = "[花丸]";
            $ezwebToDocomo["%e279%"] = "<span style=\"color:red;\">&#xE734;</span>";    // マル秘
            $ezwebToDocomo["%e280%"] = "[100点]";
            $ezwebToDocomo["%e281%"] = "<span style=\"color:red;\">&#xE6FD;</span>";    // パンチ
            $ezwebToDocomo["%e282%"] = "&#xE708;";    // ダッシュ（走り出すさま）
            $ezwebToDocomo["%e283%"] = "[ｳﾝﾁ]";
            $ezwebToDocomo["%e284%"] = "[人差し指]";
            $ezwebToDocomo["%e285%"] = "[得]";
            $ezwebToDocomo["%e286%"] = "[ﾄﾞｸﾛ]";
            $ezwebToDocomo["%e287%"] = "<span style=\"color:orange;\">&#xE727;</span>";    // 指でOK
            $ezwebToDocomo["%e288%"] = "<span style=\"color:blue;\">&#xE68A;</span>";    // ＴＶ
            $ezwebToDocomo["%e289%"] = "&#xE676;";    // カラオケ
            $ezwebToDocomo["%e290%"] = "&#xE70F;";    // がま口財布
            $ezwebToDocomo["%e291%"] = "<span style=\"color:red;\">&#xE6FF;</span>";    // ムード
            $ezwebToDocomo["%e292%"] = "[ｷﾞﾀｰ]";
            $ezwebToDocomo["%e293%"] = "[ﾊﾞｲｵﾘﾝ]";
            $ezwebToDocomo["%e294%"] = "<span style=\"color:blue;\">&#xE67A;</span>";    // 音楽
            $ezwebToDocomo["%e295%"] = "<span style=\"color:red;\">&#xE710;</span>";    // 化粧
            $ezwebToDocomo["%e296%"] = "[ﾋﾟｽﾄﾙ]";
            $ezwebToDocomo["%e297%"] = "[ｴｽﾃ]";
            $ezwebToDocomo["%e298%"] = "[EZ]";
            $ezwebToDocomo["%e299%"] = "<span style=\"color:red;\">&#xE6D7;</span>";    // 無料
            $ezwebToDocomo["%e300%"] = "<span style=\"color:blue;\">&#xE68C;</span>";    // ＣＤ
            $ezwebToDocomo["%e301%"] = "<span style=\"color:blue;\">&#xE70E;</span>";    // Tシャツ（ボーダー）
            $ezwebToDocomo["%e302%"] = "[UFO]";
            $ezwebToDocomo["%e303%"] = "[UP!]";
            $ezwebToDocomo["%e304%"] = "[注射]";
            $ezwebToDocomo["%e305%"] = "<span style=\"color:blue;\">&#xE644;</span>";    // 霧
            $ezwebToDocomo["%e306%"] = "<span style=\"color:blue;\">&#xE654;</span>";    // ゴルフ
            $ezwebToDocomo["%e307%"] = "<span style=\"color:gold;\">&#xE658;</span>";    // バスケットボール
            $ezwebToDocomo["%e308%"] = "<span style=\"color:plum;\">&#xE65A;</span>";    // ポケットベル
            $ezwebToDocomo["%e309%"] = "<span style=\"color:plum;\">&#xE67B;</span>";    // アート
            $ezwebToDocomo["%e310%"] = "[演劇]";
            $ezwebToDocomo["%e311%"] = "<span style=\"color:red;\">&#xE67D;</span>";    // イベント
            $ezwebToDocomo["%e312%"] = "<span style=\"color:red;\">&#xE684;</span>";    // リボン
            $ezwebToDocomo["%e313%"] = "<span style=\"color:red;\">&#xE686;</span>";    // バースデー
            $ezwebToDocomo["%e314%"] = "&#xE68E;";    // スペード
            $ezwebToDocomo["%e315%"] = "<span style=\"color:red;\">&#xE68F;</span>";    // ダイヤ
            $ezwebToDocomo["%e316%"] = "&#xE690;";    // クラブ
            $ezwebToDocomo["%e317%"] = "&#xE691;";    // 目
            $ezwebToDocomo["%e318%"] = "<span style=\"color:orange;\">&#xE692;</span>";    // 耳
            $ezwebToDocomo["%e319%"] = "<span style=\"color:orange;\">&#xE694;</span>";    // 手（チョキ）
            $ezwebToDocomo["%e320%"] = "<span style=\"color:orange;\">&#xE695;</span>";    // 手（パー）
            $ezwebToDocomo["%e321%"] = "&#xE69C;";    // 新月
            $ezwebToDocomo["%e322%"] = "&#xE69D;";    // やや欠け月
            $ezwebToDocomo["%e323%"] = "&#xE69E;";    // 半月
            $ezwebToDocomo["%e324%"] = "<span style=\"color:red;\">&#xE6DB;</span>";    // クリア
            $ezwebToDocomo["%e325%"] = "&#xE6EB;";    // 0
            $ezwebToDocomo["%e326%"] = "<span style=\"color:red;\">&#xE70B;</span>";    // 決定
            $ezwebToDocomo["%e327%"] = "<span style=\"color:blue;\">&#xE6F4;</span>";    // ふらふら
            $ezwebToDocomo["%e328%"] = "<span style=\"color:red;\">&#xE6ED;</span>";    // 揺れるハート
            $ezwebToDocomo["%e329%"] = "<span style=\"color:red;\">&#xE705;</span>";    // どんっ（衝撃）
            $ezwebToDocomo["%e330%"] = "&#xE706;";    // あせあせ（飛び散る汗）
            $ezwebToDocomo["%e331%"] = "[ezplus]";
            $ezwebToDocomo["%e332%"] = "[地球]";
            $ezwebToDocomo["%e333%"] = "<span style=\"color:gold;\">&#xE74C;</span>";    // どんぶり
            $ezwebToDocomo["%e334%"] = "<span style=\"color:red;\">&#xE6DD;</span>";    // ＮＥＷ
            $ezwebToDocomo["%e335%"] = "<span style=\"color:blue;\">&#xE70E;</span>";    // Tシャツ（ボーダー）
            $ezwebToDocomo["%e336%"] = "&#xE699;";    // くつ
            $ezwebToDocomo["%e337%"] = "&#xE716;";    // パソコン
            $ezwebToDocomo["%e338%"] = "[ﾗｼﾞｵ]";
            $ezwebToDocomo["%e339%"] = "[ﾊﾞﾗ]";
            $ezwebToDocomo["%e340%"] = "[教会]";
            $ezwebToDocomo["%e341%"] = "<span style=\"color:orange;\">&#xE65C;</span>";    // 地下鉄
            $ezwebToDocomo["%e342%"] = "<span style=\"color:blue;\">&#xE740;</span>";    // 富士山
            $ezwebToDocomo["%e343%"] = "<span style=\"color:red;\">&#xE6F6;</span>";    // るんるん
            $ezwebToDocomo["%e344%"] = "[天使]";
            $ezwebToDocomo["%e345%"] = "[ﾄﾗ]";
            $ezwebToDocomo["%e346%"] = "[ｸﾏ]";
            $ezwebToDocomo["%e347%"] = "[ﾈｽﾞﾐ]";
            $ezwebToDocomo["%e348%"] = "<span style=\"color:pink;\">&#xE729;</span>";    // ウィンク
            $ezwebToDocomo["%e349%"] = "<span style=\"color:pink;\">&#xE726;</span>";    // 目がハート
            $ezwebToDocomo["%e350%"] = "<span style=\"color:blueviolet;\">&#xE757;</span>";    // げっそり
            $ezwebToDocomo["%e351%"] = "<span style=\"color:blue;\">&#xE723;</span>";    // 冷や汗2
            $ezwebToDocomo["%e352%"] = "[ﾀｺ]";
            $ezwebToDocomo["%e353%"] = "[ﾛｹｯﾄ]";
            $ezwebToDocomo["%e354%"] = "<span style=\"color:gold;\">&#xE71A;</span>";    // 王冠
            $ezwebToDocomo["%e355%"] = "<span style=\"color:red;\">&#xE6F9;</span>";    // キスマーク
            $ezwebToDocomo["%e356%"] = "[ﾊﾝﾏｰ]";
            $ezwebToDocomo["%e357%"] = "[花火]";
            $ezwebToDocomo["%e358%"] = "<span style=\"color:red;\">&#xE747;</span>";    // もみじ
            $ezwebToDocomo["%e359%"] = "<span style=\"color:red;\">&#xE682;</span>";    // カバン
            $ezwebToDocomo["%e360%"] = "[噴水]";
            $ezwebToDocomo["%e361%"] = "[ｷｬﾝﾌﾟ]";
            $ezwebToDocomo["%e362%"] = "[麻雀]";
            $ezwebToDocomo["%e363%"] = "[VS]";
            $ezwebToDocomo["%e364%"] = "[ﾄﾛﾌｨｰ]";
            $ezwebToDocomo["%e365%"] = "[ｶﾒ]";
            $ezwebToDocomo["%e366%"] = "[ｽﾍﾟｲﾝ]";
            $ezwebToDocomo["%e367%"] = "[ﾛｼｱ]";
            $ezwebToDocomo["%e368%"] = "[工事中]";
            $ezwebToDocomo["%e369%"] = "<span style=\"color:red;\">&#xE6F7;</span>";    // いい気分（温泉）
            $ezwebToDocomo["%e370%"] = "[祝日]";
            $ezwebToDocomo["%e371%"] = "[夕焼け]";
            $ezwebToDocomo["%e372%"] = "<span style=\"color:gold;\">&#xE74F;</span>";    // ひよこ
            $ezwebToDocomo["%e373%"] = "[株価]";
            $ezwebToDocomo["%e374%"] = "[警官]";
            $ezwebToDocomo["%e375%"] = "<span style=\"color:red;\">&#xE665;</span>";    // 郵便局
            $ezwebToDocomo["%e376%"] = "<span style=\"color:red;\">&#xE666;</span>";    // 病院
            $ezwebToDocomo["%e377%"] = "<span style=\"color:green;\">&#xE73E;</span>";    // 学校
            $ezwebToDocomo["%e378%"] = "<span style=\"color:green;\">&#xE669;</span>";    // ホテル
            $ezwebToDocomo["%e379%"] = "<span style=\"color:blue;\">&#xE661;</span>";    // 船
            $ezwebToDocomo["%e380%"] = "[18禁]";
            $ezwebToDocomo["%e381%"] = "[ﾊﾞﾘ3]";
            $ezwebToDocomo["%e382%"] = "[COOL]";
            $ezwebToDocomo["%e383%"] = "[割]";
            $ezwebToDocomo["%e384%"] = "[ｻｰﾋﾞｽ]";
            $ezwebToDocomo["%e385%"] = "<span style=\"color:red;\">&#xE6D8;</span>";    // ID
            $ezwebToDocomo["%e386%"] = "<span style=\"color:red;\">&#xE73B;</span>";    // 満室・満席・満車
            $ezwebToDocomo["%e387%"] = "<span style=\"color:blue;\">&#xE739;</span>";    // 空室・空席・空車
            $ezwebToDocomo["%e388%"] = "[指]";
            $ezwebToDocomo["%e389%"] = "[営]";
            $ezwebToDocomo["%e390%"] = "↑";
            $ezwebToDocomo["%e391%"] = "↓";
            $ezwebToDocomo["%e392%"] = "[占い]";
            $ezwebToDocomo["%e393%"] = "[ﾏﾅｰﾓｰﾄﾞ]";
            $ezwebToDocomo["%e394%"] = "[ｹｰﾀｲOFF]";
            $ezwebToDocomo["%e395%"] = "<span style=\"color:gold;\">&#xE689;</span>";    // メモ
            $ezwebToDocomo["%e396%"] = "[ﾈｸﾀｲ]";
            $ezwebToDocomo["%e397%"] = "[ﾊｲﾋﾞｽｶｽ]";
            $ezwebToDocomo["%e398%"] = "[花束]";
            $ezwebToDocomo["%e399%"] = "[ｻﾎﾞﾃﾝ]";
            $ezwebToDocomo["%e400%"] = "<span style=\"color:salmon;\">&#xE74B;</span>";    // とっくり（おちょこ付き）
            $ezwebToDocomo["%e401%"] = "<span style=\"color:gold;\">&#xE672;</span>";    // ビール
            $ezwebToDocomo["%e402%"] = "[祝]";
            $ezwebToDocomo["%e403%"] = "[薬]";
            $ezwebToDocomo["%e404%"] = "[風船]";
            $ezwebToDocomo["%e405%"] = "[ｸﾗｯｶｰ]";
            $ezwebToDocomo["%e406%"] = "[EZﾅﾋﾞ]";
            $ezwebToDocomo["%e407%"] = "[帽子]";
            $ezwebToDocomo["%e408%"] = "[ﾌﾞｰﾂ]";
            $ezwebToDocomo["%e409%"] = "[ﾏﾆｷｭｱ]";
            $ezwebToDocomo["%e410%"] = "[美容院]";
            $ezwebToDocomo["%e411%"] = "[床屋]";
            $ezwebToDocomo["%e412%"] = "[着物]";
            $ezwebToDocomo["%e413%"] = "[ﾋﾞｷﾆ]";
            $ezwebToDocomo["%e414%"] = "<span style=\"color:red;\">&#xE68D;</span>";    // ハート
            $ezwebToDocomo["%e415%"] = "<span style=\"color:red;\">&#xE6EC;</span>";    // 黒ハート
            $ezwebToDocomo["%e416%"] = "<span style=\"color:red;\">&#xE6EC;</span>";    // 黒ハート
            $ezwebToDocomo["%e417%"] = "<span style=\"color:red;\">&#xE6EC;</span>";    // 黒ハート
            $ezwebToDocomo["%e418%"] = "<span style=\"color:red;\">&#xE6EC;</span>";    // 黒ハート
            $ezwebToDocomo["%e419%"] = "<span style=\"color:red;\">&#xE6EC;</span>";    // 黒ハート
            $ezwebToDocomo["%e420%"] = "<span style=\"color:gold;\">&#xE6FA;</span>";    // ぴかぴか（新しい）
            $ezwebToDocomo["%e421%"] = "<span style=\"color:blue;\">&#xE657;</span>";    // スキー
            $ezwebToDocomo["%e422%"] = "&#xE6A0;";    // 満月
            $ezwebToDocomo["%e423%"] = "<span style=\"color:green;\">&#xE71E;</span>";    // 湯のみ
            $ezwebToDocomo["%e424%"] = "<span style=\"color:salmon;\">&#xE74D;</span>";    // パン
            $ezwebToDocomo["%e425%"] = "[ｿﾌﾄｸﾘｰﾑ]";
            $ezwebToDocomo["%e426%"] = "[ﾎﾟﾃﾄ]";
            $ezwebToDocomo["%e427%"] = "[だんご]";
            $ezwebToDocomo["%e428%"] = "[せんべい]";
            $ezwebToDocomo["%e429%"] = "<span style=\"color:gold;\">&#xE74C;</span>";    // どんぶり
            $ezwebToDocomo["%e430%"] = "[ﾊﾟｽﾀ]";
            $ezwebToDocomo["%e431%"] = "[ｶﾚｰ]";
            $ezwebToDocomo["%e432%"] = "[おでん]";
            $ezwebToDocomo["%e433%"] = "[すし]";
            $ezwebToDocomo["%e434%"] = "<span style=\"color:red;\">&#xE745;</span>";    // りんご
            $ezwebToDocomo["%e435%"] = "[みかん]";
            $ezwebToDocomo["%e436%"] = "[ﾄﾏﾄ]";
            $ezwebToDocomo["%e437%"] = "[ﾅｽ]";
            $ezwebToDocomo["%e438%"] = "[弁当]";
            $ezwebToDocomo["%e439%"] = "[鍋]";
            $ezwebToDocomo["%e440%"] = "<span style=\"color:orange;\">&#xE72C;</span>";    // 猫2
            $ezwebToDocomo["%e441%"] = "<span style=\"color:green;\">&#xE720;</span>";    // 考えてる顔
            $ezwebToDocomo["%e442%"] = "<span style=\"color:orange;\">&#xE753;</span>";    // ウッシッシ
            $ezwebToDocomo["%e443%"] = "<span style=\"color:blue;\">&#xE72B;</span>";    // がまん顔
            $ezwebToDocomo["%e444%"] = "<span style=\"color:green;\">&#xE6F3;</span>";    // もうやだ～（悲しい顔）
            $ezwebToDocomo["%e445%"] = "<span style=\"color:blue;\">&#xE701;</span>";    // 眠い(睡眠)
            $ezwebToDocomo["%e446%"] = "<span style=\"color:pink;\">&#xE721;</span>";    // ほっとした顔
            $ezwebToDocomo["%e447%"] = "<span style=\"color:blueviolet;\">&#xE757;</span>";    // げっそり
            $ezwebToDocomo["%e448%"] = "[風邪ひき]";
            $ezwebToDocomo["%e449%"] = "[熱]";
            $ezwebToDocomo["%e450%"] = "<span style=\"color:blueviolet;\">&#xE725;</span>";    // ボケーっとした顔
            $ezwebToDocomo["%e451%"] = "<span style=\"color:blue;\">&#xE6F4;</span>";    // ふらふら
            $ezwebToDocomo["%e452%"] = "<span style=\"color:blue;\">&#xE723;</span>";    // 冷や汗2
            $ezwebToDocomo["%e453%"] = "<span style=\"color:red;\">&#xE6FF;</span>";    // ムード
            $ezwebToDocomo["%e454%"] = "<span style=\"color:pink;\">&#xE6F0;</span>";    // わーい（嬉しい顔）
            $ezwebToDocomo["%e455%"] = "(>３<)";
            $ezwebToDocomo["%e456%"] = "(´３｀)";
            $ezwebToDocomo["%e457%"] = "[鼻]";
            $ezwebToDocomo["%e458%"] = "<span style=\"color:red;\">&#xE6F9;</span>";    // キスマーク
            $ezwebToDocomo["%e459%"] = "(>人<)";
            $ezwebToDocomo["%e460%"] = "[拍手]";
            $ezwebToDocomo["%e461%"] = "<span style=\"color:red;\">&#xE70B;</span>";    // 決定
            $ezwebToDocomo["%e462%"] = "<span style=\"color:blue;\">&#xE700;</span>";    // バッド（下向き矢印）
            $ezwebToDocomo["%e463%"] = "<span style=\"color:orange;\">&#xE695;</span>";    // 手（パー）
            $ezwebToDocomo["%e464%"] = "<span style=\"color:red;\">&#xE72F;</span>";    // NG
            $ezwebToDocomo["%e465%"] = "<span style=\"color:red;\">&#xE70B;</span>";    // 決定
            $ezwebToDocomo["%e466%"] = "m(_ _)m";
            $ezwebToDocomo["%e467%"] = "<span style=\"color:red;\">&#xE6ED;</span>";    // 揺れるハート
            $ezwebToDocomo["%e468%"] = "[ﾊﾞﾆｰ]";
            $ezwebToDocomo["%e469%"] = "[ﾄﾗﾝﾍﾟｯﾄ]";
            $ezwebToDocomo["%e470%"] = "[ﾋﾞﾘﾔｰﾄﾞ]";
            $ezwebToDocomo["%e471%"] = "[水泳]";
            $ezwebToDocomo["%e472%"] = "[消防車]";
            $ezwebToDocomo["%e473%"] = "[救急車]";
            $ezwebToDocomo["%e474%"] = "[ﾊﾟﾄｶｰ]";
            $ezwebToDocomo["%e475%"] = "[ｼﾞｪｯﾄｺｰｽﾀｰ]";
            $ezwebToDocomo["%e476%"] = "[門松]";
            $ezwebToDocomo["%e477%"] = "[ひな祭り]";
            $ezwebToDocomo["%e478%"] = "[卒業式]";
            $ezwebToDocomo["%e479%"] = "[ﾗﾝﾄﾞｾﾙ]";
            $ezwebToDocomo["%e480%"] = "[こいのぼり]";
            $ezwebToDocomo["%e481%"] = "<span style=\"color:blue;\">&#xE645;</span>";    // 小雨
            $ezwebToDocomo["%e482%"] = "[花嫁]";
            $ezwebToDocomo["%e483%"] = "[ｶｷ氷]";
            $ezwebToDocomo["%e484%"] = "[線香花火]";
            $ezwebToDocomo["%e485%"] = "[巻貝]";
            $ezwebToDocomo["%e486%"] = "[風鈴]";
            $ezwebToDocomo["%e487%"] = "[ﾊﾛｳｨﾝ]";
            $ezwebToDocomo["%e488%"] = "[お月見]";
            $ezwebToDocomo["%e489%"] = "[ｻﾝﾀ]";
            $ezwebToDocomo["%e490%"] = "&#xE6B3;";    // 夜
            $ezwebToDocomo["%e491%"] = "[虹]";
            $ezwebToDocomo["%e492%"] = "<span style=\"color:green;\">&#xE669;</span><span style=\"color:red;\">&#xE6EF;</span>";    // ホテル ハートたち（複数ハート）
            $ezwebToDocomo["%e493%"] = "<span style=\"color:red;\">&#xE63E;</span>";    // 晴れ
            $ezwebToDocomo["%e494%"] = "&#xE67C;";    // 演劇
            $ezwebToDocomo["%e495%"] = "[ﾃﾞﾊﾟｰﾄ]";
            $ezwebToDocomo["%e496%"] = "[城]";
            $ezwebToDocomo["%e497%"] = "[城]";
            $ezwebToDocomo["%e498%"] = "[工場]";
            $ezwebToDocomo["%e499%"] = "[ﾌﾗﾝｽ]";
            $ezwebToDocomo["%e500%"] = "[ｵｰﾌﾟﾝｳｪﾌﾞ]";
            $ezwebToDocomo["%e501%"] = "[ｶｷﾞ]";
            $ezwebToDocomo["%e502%"] = "[ABCD]";
            $ezwebToDocomo["%e503%"] = "[abcd]";
            $ezwebToDocomo["%e504%"] = "[1234]";
            $ezwebToDocomo["%e505%"] = "[記号]";
            $ezwebToDocomo["%e506%"] = "[可]";
            $ezwebToDocomo["%e507%"] = "[ﾁｪｯｸﾏｰｸ]";
            $ezwebToDocomo["%e508%"] = "&#xE6AE;";    // ペン
            $ezwebToDocomo["%e509%"] = "[ﾗｼﾞｵﾎﾞﾀﾝ]";
            $ezwebToDocomo["%e510%"] = "<span style=\"color:blue;\">&#xE6DC;</span>";    // サーチ（調べる）
            $ezwebToDocomo["%e511%"] = "[←BACK]";
            $ezwebToDocomo["%e512%"] = "[ﾌﾞｯｸﾏｰｸ]";
            $ezwebToDocomo["%e513%"] = "&#xE6CE;";    // phone to
            $ezwebToDocomo["%e514%"] = "<span style=\"color:red;\">&#xE663;</span>";    // 家
            $ezwebToDocomo["%e515%"] = "<span style=\"color:red;\">&#xE665;</span>";    // 郵便局
            $ezwebToDocomo["%e516%"] = "<span style=\"color:gold;\">&#xE689;</span>";    // メモ
            $ezwebToDocomo["%e517%"] = "<span style=\"color:red;\">&#xE6D9;</span>";    // パスワード
            $ezwebToDocomo["%e518%"] = "<span style=\"color:green;\">&#xE735;</span>";    // リサイクル
            $ezwebToDocomo["%e700%"] = "[ﾄﾞｲﾂ]";
            $ezwebToDocomo["%e701%"] = "[ｲﾀﾘｱ]";
            $ezwebToDocomo["%e702%"] = "[ｲｷﾞﾘｽ]";
            $ezwebToDocomo["%e703%"] = "[中国]";
            $ezwebToDocomo["%e704%"] = "[韓国]";
            $ezwebToDocomo["%e705%"] = "[白人]";
            $ezwebToDocomo["%e706%"] = "[中国人]";
            $ezwebToDocomo["%e707%"] = "[ｲﾝﾄﾞ人]";
            $ezwebToDocomo["%e708%"] = "[おじいさん]";
            $ezwebToDocomo["%e709%"] = "[おばあさん]";
            $ezwebToDocomo["%e710%"] = "[赤ちゃん]";
            $ezwebToDocomo["%e711%"] = "[工事現場の人]";
            $ezwebToDocomo["%e712%"] = "[お姫様]";
            $ezwebToDocomo["%e713%"] = "[ｲﾙｶ]";
            $ezwebToDocomo["%e714%"] = "[ﾀﾞﾝｽ]";
            $ezwebToDocomo["%e715%"] = "<span style=\"color:blue;\">&#xE751;</span>";    // 魚
            $ezwebToDocomo["%e716%"] = "[ｹﾞｼﾞｹﾞｼﾞ]";
            $ezwebToDocomo["%e717%"] = "[ｿﾞｳ]";
            $ezwebToDocomo["%e718%"] = "[ｺｱﾗ]";
            $ezwebToDocomo["%e719%"] = "[牛]";
            $ezwebToDocomo["%e720%"] = "[ﾍﾋﾞ]";
            $ezwebToDocomo["%e721%"] = "[ﾆﾜﾄﾘ]";
            $ezwebToDocomo["%e722%"] = "[ｲﾉｼｼ]";
            $ezwebToDocomo["%e723%"] = "[ﾗｸﾀﾞ]";
            $ezwebToDocomo["%e724%"] = "[A]";
            $ezwebToDocomo["%e725%"] = "[B]";
            $ezwebToDocomo["%e726%"] = "[O]";
            $ezwebToDocomo["%e727%"] = "[AB]";
            $ezwebToDocomo["%e728%"] = "<span style=\"color:orange;\">&#xE698;</span>";    // 足
            $ezwebToDocomo["%e729%"] = "&#xE699;";    // くつ
            $ezwebToDocomo["%e730%"] = "<span style=\"color:red;\">&#xE6DE;</span>";    // 位置情報
            $ezwebToDocomo["%e731%"] = "<span style=\"color:red;\">&#xE6F5;</span>";    // グッド（上向き矢印）
            $ezwebToDocomo["%e732%"] = "<span style=\"color:blue;\">&#xE700;</span>";    // バッド（下向き矢印）
            $ezwebToDocomo["%e733%"] = "<span style=\"color:plum;\">&#xE703;</span>";    // exclamation&question
            $ezwebToDocomo["%e734%"] = "<span style=\"color:red;\">&#xE704;</span>";    // exclamation×2
            $ezwebToDocomo["%e735%"] = "&#xE70A;";    // ー（長音記号２）
            $ezwebToDocomo["%e736%"] = "[ﾒﾛﾝ]";
            $ezwebToDocomo["%e737%"] = "[ﾊﾟｲﾅｯﾌﾟﾙ]";
            $ezwebToDocomo["%e738%"] = "[ﾌﾞﾄﾞｳ]";
            $ezwebToDocomo["%e739%"] = "<span style=\"color:gold;\">&#xE744;</span>";    // バナナ
            $ezwebToDocomo["%e740%"] = "[とうもろこし]";
            $ezwebToDocomo["%e741%"] = "[ｷﾉｺ]";
            $ezwebToDocomo["%e742%"] = "[栗]";
            $ezwebToDocomo["%e743%"] = "[ﾓﾓ]";
            $ezwebToDocomo["%e744%"] = "[やきいも]";
            $ezwebToDocomo["%e745%"] = "[ﾋﾟｻﾞ]";
            $ezwebToDocomo["%e746%"] = "[ﾁｷﾝ]";
            $ezwebToDocomo["%e747%"] = "[七夕]";
            $ezwebToDocomo["%e748%"] = "<span style=\"color:plum;\">&#xE671;</span>";    // バー
            $ezwebToDocomo["%e749%"] = "[辰]";
            $ezwebToDocomo["%e750%"] = "[ﾋﾟｱﾉ]";
            $ezwebToDocomo["%e751%"] = "<span style=\"color:blue;\">&#xE712;</span>";    // スノボ
            $ezwebToDocomo["%e752%"] = "<span style=\"color:blue;\">&#xE751;</span>";    // 魚
            $ezwebToDocomo["%e753%"] = "[ﾎﾞｰﾘﾝｸﾞ]";
            $ezwebToDocomo["%e754%"] = "[なまはげ]";
            $ezwebToDocomo["%e755%"] = "[天狗]";
            $ezwebToDocomo["%e756%"] = "[ﾊﾟﾝﾀﾞ]";
            $ezwebToDocomo["%e757%"] = "<span style=\"color:red;\">&#xE728;</span>";    // あっかんべー
            $ezwebToDocomo["%e758%"] = "<span style=\"color:orange;\">&#xE755;</span>";    // ブタ
            $ezwebToDocomo["%e759%"] = "[花]";
            $ezwebToDocomo["%e760%"] = "[ｱｲｽｸﾘｰﾑ]";
            $ezwebToDocomo["%e761%"] = "[ﾄﾞｰﾅﾂ]";
            $ezwebToDocomo["%e762%"] = "[ｸｯｷｰ]";
            $ezwebToDocomo["%e763%"] = "[ﾁｮｺ]";
            $ezwebToDocomo["%e764%"] = "[ｷｬﾝﾃﾞｨ]";
            $ezwebToDocomo["%e765%"] = "[ｷｬﾝﾃﾞｨ]";
            $ezwebToDocomo["%e766%"] = "(/_＼)";
            $ezwebToDocomo["%e767%"] = "(・×・)";
            $ezwebToDocomo["%e768%"] = "|(・×・)|";
            $ezwebToDocomo["%e769%"] = "[火山]";
            $ezwebToDocomo["%e770%"] = "<span style=\"color:red;\">&#xE6EC;</span>";    // 黒ハート
            $ezwebToDocomo["%e771%"] = "[ABC]";
            $ezwebToDocomo["%e772%"] = "[ﾌﾟﾘﾝ]";
            $ezwebToDocomo["%e773%"] = "[ﾐﾂﾊﾞﾁ]";
            $ezwebToDocomo["%e774%"] = "[てんとう虫]";
            $ezwebToDocomo["%e775%"] = "[ﾊﾁﾐﾂ]";
            $ezwebToDocomo["%e776%"] = "<span style=\"color:red;\">&#xE745;</span>";    // りんご
            $ezwebToDocomo["%e777%"] = "[飛んでいくお金]";
            $ezwebToDocomo["%e778%"] = "[ｸﾗｸﾗ]";
            $ezwebToDocomo["%e779%"] = "<span style=\"color:red;\">&#xE724;</span>";    // ぷっくっくな顔
            $ezwebToDocomo["%e780%"] = "<span style=\"color:red;\">&#xE724;</span>";    // ぷっくっくな顔
            $ezwebToDocomo["%e781%"] = "&#xE6B3;";    // 夜
            $ezwebToDocomo["%e782%"] = "(´３｀)";
            $ezwebToDocomo["%e783%"] = "<span style=\"color:pink;\">&#xE6F0;</span>";    // わーい（嬉しい顔）
            $ezwebToDocomo["%e784%"] = "&#xE6CF;";    // mail to
            $ezwebToDocomo["%e785%"] = "<span style=\"color:pink;\">&#xE72A;</span>";    // うれしい顔
            $ezwebToDocomo["%e786%"] = "<span style=\"color:pink;\">&#xE72A;</span>";    // うれしい顔
            $ezwebToDocomo["%e787%"] = "<span style=\"color:pink;\">&#xE726;</span>";    // 目がハート
            $ezwebToDocomo["%e788%"] = "<span style=\"color:green;\">&#xE6F3;</span>";    // もうやだ～（悲しい顔）
            $ezwebToDocomo["%e789%"] = "<span style=\"color:green;\">&#xE6F3;</span>";    // もうやだ～（悲しい顔）
            $ezwebToDocomo["%e790%"] = "<span style=\"color:blue;\">&#xE72E;</span>";    // 涙
            $ezwebToDocomo["%e791%"] = "<span style=\"color:blue;\">&#xE72E;</span>";    // 涙
            $ezwebToDocomo["%e792%"] = "<span style=\"color:orange;\">&#xE753;</span>";    // ウッシッシ
            $ezwebToDocomo["%e793%"] = "[ﾄﾞﾚｽ]";
            $ezwebToDocomo["%e794%"] = "[ﾓｱｲ]";
            $ezwebToDocomo["%e795%"] = "[駅]";
            $ezwebToDocomo["%e796%"] = "[花札]";
            $ezwebToDocomo["%e797%"] = "[ｼﾞｮｰｶｰ]";
            $ezwebToDocomo["%e798%"] = "[ｴﾋﾞﾌﾗｲ]";
            $ezwebToDocomo["%e799%"] = "&#xE6D3;";    // メール
            $ezwebToDocomo["%e800%"] = "&#xE733;";    // 走る人
            $ezwebToDocomo["%e801%"] = "[ﾊﾟﾄｶｰ]";
            $ezwebToDocomo["%e802%"] = "[EZﾑｰﾋﾞｰ]";
            $ezwebToDocomo["%e803%"] = "<span style=\"color:red;\">&#xE6ED;</span>";    // 揺れるハート
            $ezwebToDocomo["%e804%"] = "<span style=\"color:gold;\">&#xE74F;</span>";    // ひよこ
            $ezwebToDocomo["%e805%"] = "<span style=\"color:blue;\">&#xE711;</span>";    // ジーンズ
            $ezwebToDocomo["%e806%"] = "<span style=\"color:red;\">&#xE717;</span>";    // ラブレター
            $ezwebToDocomo["%e807%"] = "<span style=\"color:green;\">&#xE735;</span>";    // リサイクル
            $ezwebToDocomo["%e808%"] = "&#xE73C;";    // 矢印左右
            $ezwebToDocomo["%e809%"] = "&#xE73D;";    // 矢印上下
            $ezwebToDocomo["%e810%"] = "<span style=\"color:blue;\">&#xE73F;</span>";    // 波
            $ezwebToDocomo["%e811%"] = "<span style=\"color:green;\">&#xE746;</span>";    // 芽
            $ezwebToDocomo["%e812%"] = "<span style=\"color:salmon;\">&#xE74E;</span>";    // かたつむり
            $ezwebToDocomo["%e813%"] = "<span style=\"color:orange;\">&#xE753;</span>";    // ウッシッシ
            $ezwebToDocomo["%e814%"] = "<span style=\"color:orange;\">&#xE753;</span>";    // ウッシッシ
            $ezwebToDocomo["%e815%"] = "[Cﾒｰﾙ]";
            $ezwebToDocomo["%e816%"] = "<span style=\"color:green;\">&#xE741;</span>";    // クローバー
            $ezwebToDocomo["%e817%"] = "<span style=\"color:orange;\">&#xE693;</span>";    // 手（グー）
            $ezwebToDocomo["%e818%"] = "&#xE6E0;";    // シャープダイヤル
            $ezwebToDocomo["%e819%"] = "(^-^)/";
            $ezwebToDocomo["%e820%"] = "＼(^o^)／";
            $ezwebToDocomo["%e821%"] = "<span style=\"color:green;\">&#xE6F3;</span>";    // もうやだ～（悲しい顔）
            $ezwebToDocomo["%e822%"] = "<span style=\"color:red;\">&#xE724;</span>";    // ぷっくっくな顔
        }

        return $ezwebToDocomo;
    }

    /**
     * getEzwebToSoftbankメソッド
     *
     * Ezweb用の変換文字をキーにしたSoftbank絵文字データ配列を返します。
     *
     * @return $ezwebToSoftbank Softbank絵文字配列
     */

    public static function getEzwebToSoftbank() {
        static $ezwebToSoftbank;

        if (!isset($ezwebToSoftbank)) {
            $ezwebToSoftbank["%e1%"] = "\x1b\$Fr\x0f";
            $ezwebToSoftbank["%e2%"] = "\x1b\$GA\x0f";
            $ezwebToSoftbank["%e3%"] = "\x1b\$G@\x0f";
            $ezwebToSoftbank["%e4%"] = "[Q]";
            $ezwebToSoftbank["%e5%"] = "\x1b\$F[\x0f";
            $ezwebToSoftbank["%e6%"] = "\x1b\$FZ\x0f";
            $ezwebToSoftbank["%e7%"] = "\x1b\$F]\x0f";
            $ezwebToSoftbank["%e8%"] = "\x1b\$F\\x0f";
            $ezwebToSoftbank["%e9%"] = "\x1b\$F;\x0f";
            $ezwebToSoftbank["%e10%"] = "\x1b\$F:\x0f";
            $ezwebToSoftbank["%e11%"] = "[i]";
            $ezwebToSoftbank["%e12%"] = "\x1b\$Gd\x0f";
            $ezwebToSoftbank["%e13%"] = "\x1b\$Ea\x0f";
            $ezwebToSoftbank["%e14%"] = "\x1b\$EO\x0f";
            $ezwebToSoftbank["%e15%"] = "\x1b\$Gl\x0f";
            $ezwebToSoftbank["%e16%"] = "\x1b\$E]\x0f";
            $ezwebToSoftbank["%e17%"] = "\x1b\$F;\x0f";
            $ezwebToSoftbank["%e18%"] = "\x1b\$F:\x0f";
            $ezwebToSoftbank["%e19%"] = "\x1b\$F;\x0f";
            $ezwebToSoftbank["%e20%"] = "\x1b\$F;\x0f";
            $ezwebToSoftbank["%e21%"] = "\x1b\$F;\x0f";
            $ezwebToSoftbank["%e22%"] = "\x1b\$F:\x0f";
            $ezwebToSoftbank["%e23%"] = "\x1b\$F9\x0f";
            $ezwebToSoftbank["%e24%"] = "\x1b\$F9\x0f";
            $ezwebToSoftbank["%e25%"] = "[腕時計]";
            $ezwebToSoftbank["%e26%"] = "＋";
            $ezwebToSoftbank["%e27%"] = "－";
            $ezwebToSoftbank["%e28%"] = "＊";
            $ezwebToSoftbank["%e29%"] = "\x1b\$FR\x0f";
            $ezwebToSoftbank["%e30%"] = "\x1b\$FS\x0f";
            $ezwebToSoftbank["%e31%"] = "[禁]";
            $ezwebToSoftbank["%e32%"] = "▼";
            $ezwebToSoftbank["%e33%"] = "▲";
            $ezwebToSoftbank["%e34%"] = "▼";
            $ezwebToSoftbank["%e35%"] = "▲";
            $ezwebToSoftbank["%e36%"] = "\x1b\$F;\x0f";
            $ezwebToSoftbank["%e37%"] = "\x1b\$F;\x0f";
            $ezwebToSoftbank["%e38%"] = "\x1b\$F;\x0f";
            $ezwebToSoftbank["%e39%"] = "\x1b\$F:\x0f";
            $ezwebToSoftbank["%e40%"] = "\x1b\$F9\x0f";
            $ezwebToSoftbank["%e41%"] = "\x1b\$F9\x0f";
            $ezwebToSoftbank["%e42%"] = "\x1b\$FW\x0f";
            $ezwebToSoftbank["%e43%"] = "\x1b\$FX\x0f";
            $ezwebToSoftbank["%e44%"] = "\x1b\$Gj\x0f";
            $ezwebToSoftbank["%e45%"] = "\x1b\$G6\x0f";
            $ezwebToSoftbank["%e46%"] = "\x1b\$GM\x0f";
            $ezwebToSoftbank["%e47%"] = "\x1b\$Gl\x0f";
            $ezwebToSoftbank["%e48%"] = "\x1b\$OE\x0f";
            $ezwebToSoftbank["%e49%"] = "φ";
            $ezwebToSoftbank["%e50%"] = "\x1b\$G\"\x0f";
            $ezwebToSoftbank["%e51%"] = "\x1b\$GB\x0f";
            $ezwebToSoftbank["%e52%"] = "\x1b\$Gd\x0f";
            $ezwebToSoftbank["%e53%"] = "\x1b\$E0\x0f";
            $ezwebToSoftbank["%e54%"] = "\x1b\$QW\x0f";
            $ezwebToSoftbank["%e55%"] = "\x1b\$OS\x0f";
            $ezwebToSoftbank["%e56%"] = "\x1b\$O!\x0f";
            $ezwebToSoftbank["%e57%"] = "[砂時計]";
            $ezwebToSoftbank["%e58%"] = "[砂時計]";
            $ezwebToSoftbank["%e59%"] = "\x1b\$O6\x0f";
            $ezwebToSoftbank["%e60%"] = "[雪結晶]";
            $ezwebToSoftbank["%e61%"] = "\x1b\$OS\x0f";
            $ezwebToSoftbank["%e62%"] = "\x1b\$OS\x0f";
            $ezwebToSoftbank["%e63%"] = "\x1b\$FT\x0f";
            $ezwebToSoftbank["%e64%"] = "\x1b\$FU\x0f";
            $ezwebToSoftbank["%e65%"] = "\x1b\$Gg\x0f";
            $ezwebToSoftbank["%e66%"] = "÷";
            $ezwebToSoftbank["%e67%"] = "[ｶﾚﾝﾀﾞｰ]";
            $ezwebToSoftbank["%e68%"] = "\x1b\$Gv\x0f";
            $ezwebToSoftbank["%e69%"] = "\x1b\$OO\x0f";
            $ezwebToSoftbank["%e70%"] = "\x1b\$FV\x0f";
            $ezwebToSoftbank["%e71%"] = "\x1b\$FY\x0f";
            $ezwebToSoftbank["%e72%"] = "\x1b\$GT\x0f";
            $ezwebToSoftbank["%e73%"] = "[ﾁｪｯｸﾏｰｸ]";
            $ezwebToSoftbank["%e74%"] = "\x1b\$Gr\x0f";
            $ezwebToSoftbank["%e75%"] = "☆彡";
            $ezwebToSoftbank["%e76%"] = "\x1b\$ON\x0f";
            $ezwebToSoftbank["%e77%"] = "\x1b\$E/\x0f";
            $ezwebToSoftbank["%e78%"] = "\x1b\$QC\x0f";
            $ezwebToSoftbank["%e79%"] = "[ﾌｫﾙﾀﾞ]";
            $ezwebToSoftbank["%e80%"] = "\x1b\$G!\x0f";
            $ezwebToSoftbank["%e81%"] = "\x1b\$Fn\x0f";
            $ezwebToSoftbank["%e82%"] = "\x1b\$Fo\x0f";
            $ezwebToSoftbank["%e83%"] = "\x1b\$OC\x0f";
            $ezwebToSoftbank["%e84%"] = "[ﾌｫﾙﾀﾞ]";
            $ezwebToSoftbank["%e85%"] = "\x1b\$G)\x0f";
            $ezwebToSoftbank["%e86%"] = "[ﾌｷﾀﾞｼ]";
            $ezwebToSoftbank["%e87%"] = "[ｶｰﾄﾞ]";
            $ezwebToSoftbank["%e88%"] = "▲";
            $ezwebToSoftbank["%e89%"] = "▼";
            $ezwebToSoftbank["%e90%"] = "\x1b\$Q,\x0f";
            $ezwebToSoftbank["%e91%"] = "\x1b\$Eh\x0f";
            $ezwebToSoftbank["%e92%"] = "\x1b\$O!\x0f";
            $ezwebToSoftbank["%e93%"] = "\x1b\$Ge\x0f";
            $ezwebToSoftbank["%e94%"] = "\x1b\$G(\x0f";
            $ezwebToSoftbank["%e95%"] = "\x1b\$Gk\x0f";
            $ezwebToSoftbank["%e96%"] = "\x1b\$PK\x0f";
            $ezwebToSoftbank["%e97%"] = "\x1b\$Eh\x0f";
            $ezwebToSoftbank["%e98%"] = "\x1b\$EW\x0f";
            $ezwebToSoftbank["%e99%"] = "\x1b\$En\x0f";
            $ezwebToSoftbank["%e100%"] = "\x1b\$Eh\x0f";
            $ezwebToSoftbank["%e101%"] = "\x1b\$Eh\x0f";
            $ezwebToSoftbank["%e102%"] = "\x1b\$Eh\x0f";
            $ezwebToSoftbank["%e103%"] = "\x1b\$O!\x0f";
            $ezwebToSoftbank["%e104%"] = "\x1b\$O3\x0f";
            $ezwebToSoftbank["%e105%"] = "[ｶﾚﾝﾀﾞｰ]";
            $ezwebToSoftbank["%e106%"] = "\x1b\$EE\x0f";
            $ezwebToSoftbank["%e107%"] = "\x1b\$Gi\x0f";
            $ezwebToSoftbank["%e108%"] = "\x1b\$E#\x0f";
            $ezwebToSoftbank["%e109%"] = "￥";
            $ezwebToSoftbank["%e110%"] = "\x1b\$G]\x0f";
            $ezwebToSoftbank["%e111%"] = "\x1b\$G]\x0f";
            $ezwebToSoftbank["%e112%"] = "\x1b\$GV\x0f";
            $ezwebToSoftbank["%e113%"] = "\x1b\$O\$\x0f";
            $ezwebToSoftbank["%e114%"] = "[包丁]";
            $ezwebToSoftbank["%e115%"] = "\x1b\$EI\x0f";
            $ezwebToSoftbank["%e116%"] = "[ﾒｶﾞﾈ]";
            $ezwebToSoftbank["%e117%"] = "└→";
            $ezwebToSoftbank["%e118%"] = "←┘";
            $ezwebToSoftbank["%e119%"] = "\x1b\$E4\x0f";
            $ezwebToSoftbank["%e120%"] = "\x1b\$G_\x0f";
            $ezwebToSoftbank["%e121%"] = "\x1b\$Eh\x0f";
            $ezwebToSoftbank["%e122%"] = "\x1b\$Eh\x0f";
            $ezwebToSoftbank["%e123%"] = "[ﾈｼﾞ]";
            $ezwebToSoftbank["%e124%"] = "\x1b\$E^\x0f";
            $ezwebToSoftbank["%e125%"] = "\x1b\$G;\x0f";
            $ezwebToSoftbank["%e126%"] = "\x1b\$O6\x0f";
            $ezwebToSoftbank["%e127%"] = "\x1b\$Ej\x0f";
            $ezwebToSoftbank["%e128%"] = "\x1b\$Ej\x0f";
            $ezwebToSoftbank["%e129%"] = "\x1b\$E!\x0f";
            $ezwebToSoftbank["%e130%"] = "[懐中電灯]";
            $ezwebToSoftbank["%e131%"] = "\x1b\$Eh\x0f";
            $ezwebToSoftbank["%e132%"] = "[ﾁｪｯｸﾏｰｸ]";
            $ezwebToSoftbank["%e133%"] = "\x1b\$E8\x0f";
            $ezwebToSoftbank["%e134%"] = "\x1b\$Gr\x0f";
            $ezwebToSoftbank["%e135%"] = "[電池]";
            $ezwebToSoftbank["%e136%"] = "[ｽｸﾛｰﾙ]";
            $ezwebToSoftbank["%e137%"] = "[画びょう]";
            $ezwebToSoftbank["%e138%"] = "\x1b\$Ed\x0f";
            $ezwebToSoftbank["%e139%"] = "\x1b\$EO\x0f";
            $ezwebToSoftbank["%e140%"] = "\x1b\$FP\x0f";
            $ezwebToSoftbank["%e141%"] = "\x1b\$FQ\x0f";
            $ezwebToSoftbank["%e142%"] = "\x1b\$Eh\x0f";
            $ezwebToSoftbank["%e143%"] = "[ｸﾘｯﾌﾟ]";
            $ezwebToSoftbank["%e144%"] = "\x1b\$E2\x0f";
            $ezwebToSoftbank["%e145%"] = "[名札]";
            $ezwebToSoftbank["%e146%"] = "\x1b\$Gc\x0f";
            $ezwebToSoftbank["%e147%"] = "\x1b\$Eh\x0f";
            $ezwebToSoftbank["%e148%"] = "\x1b\$PO\x0f";
            $ezwebToSoftbank["%e149%"] = "\x1b\$O!\x0f";
            $ezwebToSoftbank["%e150%"] = "[PDC]";
            $ezwebToSoftbank["%e151%"] = "\x1b\$E#\x0f";
            $ezwebToSoftbank["%e152%"] = "[ﾚﾝﾁ]";
            $ezwebToSoftbank["%e153%"] = "[送信BOX]";
            $ezwebToSoftbank["%e154%"] = "[受信BOX]";
            $ezwebToSoftbank["%e155%"] = "\x1b\$G)\x0f";
            $ezwebToSoftbank["%e156%"] = "\x1b\$GX\x0f";
            $ezwebToSoftbank["%e157%"] = "[定規]";
            $ezwebToSoftbank["%e158%"] = "[三角定規]";
            $ezwebToSoftbank["%e159%"] = "[ｸﾞﾗﾌ]";
            $ezwebToSoftbank["%e160%"] = "[肉]";
            $ezwebToSoftbank["%e161%"] = "\x1b\$G*\x0f";
            $ezwebToSoftbank["%e162%"] = "[ｺﾝｾﾝﾄ]";
            $ezwebToSoftbank["%e163%"] = "[家族]";
            $ezwebToSoftbank["%e164%"] = "[ﾘﾝｸ]";
            $ezwebToSoftbank["%e165%"] = "\x1b\$E2\x0f";
            $ezwebToSoftbank["%e166%"] = "\x1b\$G+\x0f";
            $ezwebToSoftbank["%e167%"] = "%s74%%s73%";
            $ezwebToSoftbank["%e168%"] = "\x1b\$G=\x0f";
            $ezwebToSoftbank["%e169%"] = "\x1b\$G<\x0f";
            $ezwebToSoftbank["%e170%"] = "[ｻｲｺﾛ]";
            $ezwebToSoftbank["%e171%"] = "[新聞]";
            $ezwebToSoftbank["%e172%"] = "\x1b\$G>\x0f";
            $ezwebToSoftbank["%e173%"] = "　";
            $ezwebToSoftbank["%e174%"] = "";
            $ezwebToSoftbank["%e175%"] = "";
            $ezwebToSoftbank["%e176%"] = "\x1b\$O.\x0f";
            $ezwebToSoftbank["%e177%"] = "\x1b\$F(\x0f";
            $ezwebToSoftbank["%e178%"] = "\x1b\$F*\x0f";
            $ezwebToSoftbank["%e179%"] = "\x1b\$F)\x0f";
            $ezwebToSoftbank["%e180%"] = "\x1b\$F<\x0f";
            $ezwebToSoftbank["%e181%"] = "\x1b\$F=\x0f";
            $ezwebToSoftbank["%e182%"] = "\x1b\$F>\x0f";
            $ezwebToSoftbank["%e183%"] = "\x1b\$F?\x0f";
            $ezwebToSoftbank["%e184%"] = "\x1b\$F@\x0f";
            $ezwebToSoftbank["%e185%"] = "\x1b\$FA\x0f";
            $ezwebToSoftbank["%e186%"] = "\x1b\$FB\x0f";
            $ezwebToSoftbank["%e187%"] = "\x1b\$FC\x0f";
            $ezwebToSoftbank["%e188%"] = "\x1b\$FD\x0f";
            $ezwebToSoftbank["%e189%"] = "[10]";
            $ezwebToSoftbank["%e190%"] = "\x1b\$Pc\x0f";
            $ezwebToSoftbank["%e191%"] = "\x1b\$Gh\x0f";
            $ezwebToSoftbank["%e192%"] = "\x1b\$F_\x0f";
            $ezwebToSoftbank["%e193%"] = "\x1b\$F`\x0f";
            $ezwebToSoftbank["%e194%"] = "\x1b\$Fa\x0f";
            $ezwebToSoftbank["%e195%"] = "\x1b\$Fb\x0f";
            $ezwebToSoftbank["%e196%"] = "\x1b\$Fc\x0f";
            $ezwebToSoftbank["%e197%"] = "\x1b\$Fd\x0f";
            $ezwebToSoftbank["%e198%"] = "\x1b\$Fe\x0f";
            $ezwebToSoftbank["%e199%"] = "\x1b\$Ff\x0f";
            $ezwebToSoftbank["%e200%"] = "\x1b\$Fg\x0f";
            $ezwebToSoftbank["%e201%"] = "\x1b\$Fh\x0f";
            $ezwebToSoftbank["%e202%"] = "\x1b\$Fi\x0f";
            $ezwebToSoftbank["%e203%"] = "\x1b\$Fj\x0f";
            $ezwebToSoftbank["%e204%"] = "\x1b\$Fk\x0f";
            $ezwebToSoftbank["%e205%"] = "\x1b\$Et\x0f";
            $ezwebToSoftbank["%e206%"] = "\x1b\$Ev\x0f";
            $ezwebToSoftbank["%e207%"] = "\x1b\$Eq\x0f";
            $ezwebToSoftbank["%e208%"] = "\x1b\$Eo\x0f";
            $ezwebToSoftbank["%e209%"] = "\x1b\$Ep\x0f";
            $ezwebToSoftbank["%e210%"] = "\x1b\$Ek\x0f";
            $ezwebToSoftbank["%e211%"] = "\x1b\$F\"\x0f";
            $ezwebToSoftbank["%e212%"] = "\x1b\$Em\x0f";
            $ezwebToSoftbank["%e213%"] = "\x1b\$GZ\x0f";
            $ezwebToSoftbank["%e214%"] = "[地図]";
            $ezwebToSoftbank["%e215%"] = "\x1b\$EV\x0f";
            $ezwebToSoftbank["%e216%"] = "\x1b\$Ey\x0f";
            $ezwebToSoftbank["%e217%"] = "\x1b\$G?\x0f";
            $ezwebToSoftbank["%e218%"] = "\x1b\$E5\x0f";
            $ezwebToSoftbank["%e219%"] = "\x1b\$G8\x0f";
            $ezwebToSoftbank["%e220%"] = "\x1b\$G5\x0f";
            $ezwebToSoftbank["%e221%"] = "[ｽﾉﾎﾞ]";
            $ezwebToSoftbank["%e222%"] = "\x1b\$ER\x0f";
            $ezwebToSoftbank["%e223%"] = "\x1b\$ED\x0f";
            $ezwebToSoftbank["%e224%"] = "\x1b\$EC\x0f";
            $ezwebToSoftbank["%e225%"] = "\x1b\$O+\x0f";
            $ezwebToSoftbank["%e226%"] = "\x1b\$OD\x0f";
            $ezwebToSoftbank["%e227%"] = "\x1b\$Pk\x0f";
            $ezwebToSoftbank["%e228%"] = "\x1b\$Q)\x0f";
            $ezwebToSoftbank["%e229%"] = "\x1b\$ES\x0f";
            $ezwebToSoftbank["%e230%"] = "[ｵﾒﾃﾞﾄｳ]";
            $ezwebToSoftbank["%e231%"] = "\x1b\$EP\x0f";
            $ezwebToSoftbank["%e232%"] = "[ｹﾞｰﾑ]";
            $ezwebToSoftbank["%e233%"] = "\x1b\$EO\x0f";
            $ezwebToSoftbank["%e234%"] = "\x1b\$GS\x0f";
            $ezwebToSoftbank["%e235%"] = "\x1b\$GP\x0f";
            $ezwebToSoftbank["%e236%"] = "\x1b\$E;\x0f";
            $ezwebToSoftbank["%e237%"] = "\x1b\$Q+\x0f";
            $ezwebToSoftbank["%e238%"] = "\x1b\$Oh\x0f";
            $ezwebToSoftbank["%e239%"] = "\x1b\$Gf\x0f";
            $ezwebToSoftbank["%e240%"] = "\x1b\$Eg\x0f";
            $ezwebToSoftbank["%e241%"] = "[さくらんぼ]";
            $ezwebToSoftbank["%e242%"] = "\x1b\$G9\x0f";
            $ezwebToSoftbank["%e243%"] = "\x1b\$Og\x0f";
            $ezwebToSoftbank["%e244%"] = "\x1b\$Ob\x0f";
            $ezwebToSoftbank["%e245%"] = "\x1b\$E@\x0f";
            $ezwebToSoftbank["%e246%"] = "\x1b\$Gt\x0f";
            $ezwebToSoftbank["%e247%"] = "\x1b\$QL\x0f";
            $ezwebToSoftbank["%e248%"] = "\x1b\$G:\x0f";
            $ezwebToSoftbank["%e249%"] = "\x1b\$E)\x0f";
            $ezwebToSoftbank["%e250%"] = "\x1b\$QQ\x0f";
            $ezwebToSoftbank["%e251%"] = "\x1b\$Go\x0f";
            $ezwebToSoftbank["%e252%"] = "\x1b\$Gu\x0f";
            $ezwebToSoftbank["%e253%"] = "[ｱﾘ]";
            $ezwebToSoftbank["%e254%"] = "\x1b\$E+\x0f";
            $ezwebToSoftbank["%e255%"] = "\x1b\$O'\x0f";
            $ezwebToSoftbank["%e256%"] = "\x1b\$O%\x0f";
            $ezwebToSoftbank["%e257%"] = "\x1b\$Gw\x0f";
            $ezwebToSoftbank["%e258%"] = "\x1b\$Gy\x0f";
            $ezwebToSoftbank["%e259%"] = "\x1b\$P1\x0f";
            $ezwebToSoftbank["%e260%"] = "\x1b\$P&\x0f";
            $ezwebToSoftbank["%e261%"] = "\x1b\$E\\x0f";
            $ezwebToSoftbank["%e262%"] = "\x1b\$OT\x0f";
            $ezwebToSoftbank["%e263%"] = "\x1b\$OQ\x0f";
            $ezwebToSoftbank["%e264%"] = "\x1b\$E%\x0f";
            $ezwebToSoftbank["%e265%"] = "\x1b\$GC\x0f";
            $ezwebToSoftbank["%e266%"] = "\x1b\$OG\x0f";
            $ezwebToSoftbank["%e267%"] = "\x1b\$ON\x0f";
            $ezwebToSoftbank["%e268%"] = "\x1b\$O1\x0f";
            $ezwebToSoftbank["%e269%"] = "\x1b\$E=\x0f";
            $ezwebToSoftbank["%e270%"] = "[SOS]";
            $ezwebToSoftbank["%e271%"] = "\x1b\$El\x0f";
            $ezwebToSoftbank["%e272%"] = "\x1b\$OI\x0f";
            $ezwebToSoftbank["%e273%"] = "\x1b\$G#\x0f";
            $ezwebToSoftbank["%e274%"] = "\x1b\$E,\x0f";
            $ezwebToSoftbank["%e275%"] = "[なると]";
            $ezwebToSoftbank["%e276%"] = "\x1b\$QV\x0f";
            $ezwebToSoftbank["%e277%"] = "\x1b\$E:\x0f";
            $ezwebToSoftbank["%e278%"] = "[花丸]";
            $ezwebToSoftbank["%e279%"] = "\x1b\$O5\x0f";
            $ezwebToSoftbank["%e280%"] = "[100点]";
            $ezwebToSoftbank["%e281%"] = "\x1b\$G-\x0f";
            $ezwebToSoftbank["%e282%"] = "\x1b\$OP\x0f";
            $ezwebToSoftbank["%e283%"] = "\x1b\$Gz\x0f";
            $ezwebToSoftbank["%e284%"] = "\x1b\$G/\x0f";
            $ezwebToSoftbank["%e285%"] = "\x1b\$FF\x0f";
            $ezwebToSoftbank["%e286%"] = "\x1b\$E<\x0f";
            $ezwebToSoftbank["%e287%"] = "\x1b\$G.\x0f";
            $ezwebToSoftbank["%e288%"] = "\x1b\$EJ\x0f";
            $ezwebToSoftbank["%e289%"] = "\x1b\$G\\x0f";
            $ezwebToSoftbank["%e290%"] = "[財布]";
            $ezwebToSoftbank["%e291%"] = "\x1b\$OF\x0f";
            $ezwebToSoftbank["%e292%"] = "\x1b\$Ga\x0f";
            $ezwebToSoftbank["%e293%"] = "[ﾊﾞｲｵﾘﾝ]";
            $ezwebToSoftbank["%e294%"] = "\x1b\$O*\x0f";
            $ezwebToSoftbank["%e295%"] = "\x1b\$O<\x0f";
            $ezwebToSoftbank["%e296%"] = "\x1b\$E3\x0f";
            $ezwebToSoftbank["%e297%"] = "\x1b\$O>\x0f";
            $ezwebToSoftbank["%e298%"] = "[EZ]";
            $ezwebToSoftbank["%e299%"] = "[FREE]";
            $ezwebToSoftbank["%e300%"] = "\x1b\$EF\x0f";
            $ezwebToSoftbank["%e301%"] = "\x1b\$G&\x0f";
            $ezwebToSoftbank["%e302%"] = "\x1b\$E,\x0f";
            $ezwebToSoftbank["%e303%"] = "\x1b\$F3\x0f";
            $ezwebToSoftbank["%e304%"] = "\x1b\$E[\x0f";
            $ezwebToSoftbank["%e305%"] = "[霧]";
            $ezwebToSoftbank["%e306%"] = "\x1b\$G4\x0f";
            $ezwebToSoftbank["%e307%"] = "\x1b\$PJ\x0f";
            $ezwebToSoftbank["%e308%"] = "[ﾎﾟｹﾍﾞﾙ]";
            $ezwebToSoftbank["%e309%"] = "\x1b\$Q\"\x0f";
            $ezwebToSoftbank["%e310%"] = "\x1b\$Q#\x0f";
            $ezwebToSoftbank["%e311%"] = "[ｲﾍﾞﾝﾄ]";
            $ezwebToSoftbank["%e312%"] = "\x1b\$O4\x0f";
            $ezwebToSoftbank["%e313%"] = "\x1b\$Ok\x0f";
            $ezwebToSoftbank["%e314%"] = "\x1b\$F.\x0f";
            $ezwebToSoftbank["%e315%"] = "\x1b\$F-\x0f";
            $ezwebToSoftbank["%e316%"] = "\x1b\$F/\x0f";
            $ezwebToSoftbank["%e317%"] = "\x1b\$P9\x0f";
            $ezwebToSoftbank["%e318%"] = "\x1b\$P;\x0f";
            $ezwebToSoftbank["%e319%"] = "\x1b\$G1\x0f";
            $ezwebToSoftbank["%e320%"] = "\x1b\$G2\x0f";
            $ezwebToSoftbank["%e321%"] = "●";
            $ezwebToSoftbank["%e322%"] = "\x1b\$Gl\x0f";
            $ezwebToSoftbank["%e323%"] = "\x1b\$Gl\x0f";
            $ezwebToSoftbank["%e324%"] = "[CL]";
            $ezwebToSoftbank["%e325%"] = "\x1b\$FE\x0f";
            $ezwebToSoftbank["%e326%"] = "\x1b\$Fm\x0f";
            $ezwebToSoftbank["%e327%"] = "\x1b\$P&\x0f";
            $ezwebToSoftbank["%e328%"] = "\x1b\$OG\x0f";
            $ezwebToSoftbank["%e329%"] = "[ﾄﾞﾝｯ]";
            $ezwebToSoftbank["%e330%"] = "\x1b\$OQ\x0f";
            $ezwebToSoftbank["%e331%"] = "[ezplus]";
            $ezwebToSoftbank["%e332%"] = "[地球]";
            $ezwebToSoftbank["%e333%"] = "\x1b\$O`\x0f";
            $ezwebToSoftbank["%e334%"] = "\x1b\$F2\x0f";
            $ezwebToSoftbank["%e335%"] = "\x1b\$G&\x0f";
            $ezwebToSoftbank["%e336%"] = "\x1b\$G'\x0f";
            $ezwebToSoftbank["%e337%"] = "\x1b\$G,\x0f";
            $ezwebToSoftbank["%e338%"] = "\x1b\$EH\x0f";
            $ezwebToSoftbank["%e339%"] = "\x1b\$GR\x0f";
            $ezwebToSoftbank["%e340%"] = "\x1b\$GW\x0f";
            $ezwebToSoftbank["%e341%"] = "\x1b\$PT\x0f";
            $ezwebToSoftbank["%e342%"] = "\x1b\$G[\x0f";
            $ezwebToSoftbank["%e343%"] = "\x1b\$G^\x0f";
            $ezwebToSoftbank["%e344%"] = "\x1b\$Gn\x0f";
            $ezwebToSoftbank["%e345%"] = "\x1b\$Gp\x0f";
            $ezwebToSoftbank["%e346%"] = "\x1b\$Gq\x0f";
            $ezwebToSoftbank["%e347%"] = "\x1b\$Gs\x0f";
            $ezwebToSoftbank["%e348%"] = "\x1b\$P%\x0f";
            $ezwebToSoftbank["%e349%"] = "\x1b\$E&\x0f";
            $ezwebToSoftbank["%e350%"] = "\x1b\$P0\x0f";
            $ezwebToSoftbank["%e351%"] = "\x1b\$E(\x0f";
            $ezwebToSoftbank["%e352%"] = "\x1b\$E*\x0f";
            $ezwebToSoftbank["%e353%"] = "\x1b\$E-\x0f";
            $ezwebToSoftbank["%e354%"] = "\x1b\$E.\x0f";
            $ezwebToSoftbank["%e355%"] = "\x1b\$E1\x0f";
            $ezwebToSoftbank["%e356%"] = "\x1b\$E6\x0f";
            $ezwebToSoftbank["%e357%"] = "\x1b\$E7\x0f";
            $ezwebToSoftbank["%e358%"] = "\x1b\$E9\x0f";
            $ezwebToSoftbank["%e359%"] = "\x1b\$E>\x0f";
            $ezwebToSoftbank["%e360%"] = "\x1b\$EA\x0f";
            $ezwebToSoftbank["%e361%"] = "\x1b\$EB\x0f";
            $ezwebToSoftbank["%e362%"] = "\x1b\$EM\x0f";
            $ezwebToSoftbank["%e363%"] = "\x1b\$EN\x0f";
            $ezwebToSoftbank["%e364%"] = "\x1b\$EQ\x0f";
            $ezwebToSoftbank["%e365%"] = "[ｶﾒ]";
            $ezwebToSoftbank["%e366%"] = "\x1b\$Q1\x0f";
            $ezwebToSoftbank["%e367%"] = "\x1b\$Q2\x0f";
            $ezwebToSoftbank["%e368%"] = "\x1b\$EW\x0f";
            $ezwebToSoftbank["%e369%"] = "\x1b\$E_\x0f";
            $ezwebToSoftbank["%e370%"] = "\x1b\$Ec\x0f";
            $ezwebToSoftbank["%e371%"] = "\x1b\$Ef\x0f";
            $ezwebToSoftbank["%e372%"] = "\x1b\$QC\x0f";
            $ezwebToSoftbank["%e373%"] = "\x1b\$Ej\x0f";
            $ezwebToSoftbank["%e374%"] = "\x1b\$Er\x0f";
            $ezwebToSoftbank["%e375%"] = "\x1b\$Es\x0f";
            $ezwebToSoftbank["%e376%"] = "\x1b\$Eu\x0f";
            $ezwebToSoftbank["%e377%"] = "\x1b\$Ew\x0f";
            $ezwebToSoftbank["%e378%"] = "\x1b\$Ex\x0f";
            $ezwebToSoftbank["%e379%"] = "\x1b\$F\"\x0f";
            $ezwebToSoftbank["%e380%"] = "\x1b\$F'\x0f";
            $ezwebToSoftbank["%e381%"] = "\x1b\$F+\x0f";
            $ezwebToSoftbank["%e382%"] = "\x1b\$F4\x0f";
            $ezwebToSoftbank["%e383%"] = "\x1b\$FG\x0f";
            $ezwebToSoftbank["%e384%"] = "\x1b\$FH\x0f";
            $ezwebToSoftbank["%e385%"] = "\x1b\$FI\x0f";
            $ezwebToSoftbank["%e386%"] = "\x1b\$FJ\x0f";
            $ezwebToSoftbank["%e387%"] = "\x1b\$FK\x0f";
            $ezwebToSoftbank["%e388%"] = "\x1b\$FL\x0f";
            $ezwebToSoftbank["%e389%"] = "\x1b\$FM\x0f";
            $ezwebToSoftbank["%e390%"] = "\x1b\$FN\x0f";
            $ezwebToSoftbank["%e391%"] = "\x1b\$FO\x0f";
            $ezwebToSoftbank["%e392%"] = "\x1b\$F^\x0f";
            $ezwebToSoftbank["%e393%"] = "\x1b\$Fp\x0f";
            $ezwebToSoftbank["%e394%"] = "\x1b\$Fq\x0f";
            $ezwebToSoftbank["%e395%"] = "\x1b\$O!\x0f";
            $ezwebToSoftbank["%e396%"] = "\x1b\$O\"\x0f";
            $ezwebToSoftbank["%e397%"] = "\x1b\$O#\x0f";
            $ezwebToSoftbank["%e398%"] = "\x1b\$O&\x0f";
            $ezwebToSoftbank["%e399%"] = "\x1b\$O(\x0f";
            $ezwebToSoftbank["%e400%"] = "\x1b\$O+\x0f";
            $ezwebToSoftbank["%e401%"] = "\x1b\$O,\x0f";
            $ezwebToSoftbank["%e402%"] = "\x1b\$O-\x0f";
            $ezwebToSoftbank["%e403%"] = "\x1b\$O/\x0f";
            $ezwebToSoftbank["%e404%"] = "\x1b\$O0\x0f";
            $ezwebToSoftbank["%e405%"] = "\x1b\$O2\x0f";
            $ezwebToSoftbank["%e406%"] = "[EZﾅﾋﾞ]";
            $ezwebToSoftbank["%e407%"] = "\x1b\$O8\x0f";
            $ezwebToSoftbank["%e408%"] = "\x1b\$O;\x0f";
            $ezwebToSoftbank["%e409%"] = "\x1b\$O=\x0f";
            $ezwebToSoftbank["%e410%"] = "\x1b\$O?\x0f";
            $ezwebToSoftbank["%e411%"] = "\x1b\$O@\x0f";
            $ezwebToSoftbank["%e412%"] = "\x1b\$OA\x0f";
            $ezwebToSoftbank["%e413%"] = "\x1b\$OB\x0f";
            $ezwebToSoftbank["%e414%"] = "\x1b\$F,\x0f";
            $ezwebToSoftbank["%e415%"] = "\x1b\$OG\x0f";
            $ezwebToSoftbank["%e416%"] = "\x1b\$OJ\x0f";
            $ezwebToSoftbank["%e417%"] = "\x1b\$OK\x0f";
            $ezwebToSoftbank["%e418%"] = "\x1b\$OL\x0f";
            $ezwebToSoftbank["%e419%"] = "\x1b\$OM\x0f";
            $ezwebToSoftbank["%e420%"] = "\x1b\$ON\x0f";
            $ezwebToSoftbank["%e421%"] = "\x1b\$G3\x0f";
            $ezwebToSoftbank["%e422%"] = "\x1b\$OR\x0f";
            $ezwebToSoftbank["%e423%"] = "\x1b\$OX\x0f";
            $ezwebToSoftbank["%e424%"] = "\x1b\$OY\x0f";
            $ezwebToSoftbank["%e425%"] = "\x1b\$OZ\x0f";
            $ezwebToSoftbank["%e426%"] = "\x1b\$O[\x0f";
            $ezwebToSoftbank["%e427%"] = "\x1b\$O\\x0f";
            $ezwebToSoftbank["%e428%"] = "\x1b\$O]\x0f";
            $ezwebToSoftbank["%e429%"] = "\x1b\$O^\x0f";
            $ezwebToSoftbank["%e430%"] = "\x1b\$O_\x0f";
            $ezwebToSoftbank["%e431%"] = "\x1b\$Oa\x0f";
            $ezwebToSoftbank["%e432%"] = "\x1b\$Oc\x0f";
            $ezwebToSoftbank["%e433%"] = "\x1b\$Od\x0f";
            $ezwebToSoftbank["%e434%"] = "\x1b\$Oe\x0f";
            $ezwebToSoftbank["%e435%"] = "\x1b\$Of\x0f";
            $ezwebToSoftbank["%e436%"] = "\x1b\$Oi\x0f";
            $ezwebToSoftbank["%e437%"] = "\x1b\$Oj\x0f";
            $ezwebToSoftbank["%e438%"] = "\x1b\$Ol\x0f";
            $ezwebToSoftbank["%e439%"] = "\x1b\$Om\x0f";
            $ezwebToSoftbank["%e440%"] = "\x1b\$P\"\x0f";
            $ezwebToSoftbank["%e441%"] = "\x1b\$P#\x0f";
            $ezwebToSoftbank["%e442%"] = "\x1b\$P\$\x0f";
            $ezwebToSoftbank["%e443%"] = "\x1b\$P&\x0f";
            $ezwebToSoftbank["%e444%"] = "\x1b\$P'\x0f";
            $ezwebToSoftbank["%e445%"] = "\x1b\$P(\x0f";
            $ezwebToSoftbank["%e446%"] = "\x1b\$P*\x0f";
            $ezwebToSoftbank["%e447%"] = "\x1b\$P+\x0f";
            $ezwebToSoftbank["%e448%"] = "\x1b\$P,\x0f";
            $ezwebToSoftbank["%e449%"] = "\x1b\$P-\x0f";
            $ezwebToSoftbank["%e450%"] = "\x1b\$P.\x0f";
            $ezwebToSoftbank["%e451%"] = "\x1b\$P0\x0f";
            $ezwebToSoftbank["%e452%"] = "\x1b\$P/\x0f";
            $ezwebToSoftbank["%e453%"] = "\x1b\$OF\x0f";
            $ezwebToSoftbank["%e454%"] = "\x1b\$Gv\x0f";
            $ezwebToSoftbank["%e455%"] = "\x1b\$P7\x0f";
            $ezwebToSoftbank["%e456%"] = "\x1b\$P8\x0f";
            $ezwebToSoftbank["%e457%"] = "\x1b\$P:\x0f";
            $ezwebToSoftbank["%e458%"] = "\x1b\$P<\x0f";
            $ezwebToSoftbank["%e459%"] = "\x1b\$P=\x0f";
            $ezwebToSoftbank["%e460%"] = "\x1b\$P?\x0f";
            $ezwebToSoftbank["%e461%"] = "\x1b\$P@\x0f";
            $ezwebToSoftbank["%e462%"] = "\x1b\$PA\x0f";
            $ezwebToSoftbank["%e463%"] = "\x1b\$P>\x0f";
            $ezwebToSoftbank["%e464%"] = "\x1b\$PC\x0f";
            $ezwebToSoftbank["%e465%"] = "\x1b\$PD\x0f";
            $ezwebToSoftbank["%e466%"] = "\x1b\$PF\x0f";
            $ezwebToSoftbank["%e467%"] = "\x1b\$PE\x0f";
            $ezwebToSoftbank["%e468%"] = "\x1b\$PI\x0f";
            $ezwebToSoftbank["%e469%"] = "\x1b\$Gb\x0f";
            $ezwebToSoftbank["%e470%"] = "\x1b\$PL\x0f";
            $ezwebToSoftbank["%e471%"] = "\x1b\$PM\x0f";
            $ezwebToSoftbank["%e472%"] = "\x1b\$PP\x0f";
            $ezwebToSoftbank["%e473%"] = "\x1b\$PQ\x0f";
            $ezwebToSoftbank["%e474%"] = "\x1b\$PR\x0f";
            $ezwebToSoftbank["%e475%"] = "\x1b\$PS\x0f";
            $ezwebToSoftbank["%e476%"] = "\x1b\$PV\x0f";
            $ezwebToSoftbank["%e477%"] = "\x1b\$PX\x0f";
            $ezwebToSoftbank["%e478%"] = "\x1b\$PY\x0f";
            $ezwebToSoftbank["%e479%"] = "\x1b\$PZ\x0f";
            $ezwebToSoftbank["%e480%"] = "\x1b\$P[\x0f";
            $ezwebToSoftbank["%e481%"] = "\x1b\$P\\x0f";
            $ezwebToSoftbank["%e482%"] = "[花嫁]";
            $ezwebToSoftbank["%e483%"] = "\x1b\$P_\x0f";
            $ezwebToSoftbank["%e484%"] = "\x1b\$P`\x0f";
            $ezwebToSoftbank["%e485%"] = "\x1b\$Pa\x0f";
            $ezwebToSoftbank["%e486%"] = "\x1b\$Pb\x0f";
            $ezwebToSoftbank["%e487%"] = "\x1b\$Pe\x0f";
            $ezwebToSoftbank["%e488%"] = "\x1b\$Pf\x0f";
            $ezwebToSoftbank["%e489%"] = "\x1b\$Ph\x0f";
            $ezwebToSoftbank["%e490%"] = "\x1b\$Pk\x0f";
            $ezwebToSoftbank["%e491%"] = "\x1b\$Pl\x0f";
            $ezwebToSoftbank["%e492%"] = "\x1b\$Q!\x0f";
            $ezwebToSoftbank["%e493%"] = "\x1b\$Pi\x0f";
            $ezwebToSoftbank["%e494%"] = "\x1b\$Q#\x0f";
            $ezwebToSoftbank["%e495%"] = "\x1b\$Q\$\x0f";
            $ezwebToSoftbank["%e496%"] = "\x1b\$Q%\x0f";
            $ezwebToSoftbank["%e497%"] = "\x1b\$Q&\x0f";
            $ezwebToSoftbank["%e498%"] = "\x1b\$Q(\x0f";
            $ezwebToSoftbank["%e499%"] = "\x1b\$Q-\x0f";
            $ezwebToSoftbank["%e500%"] = "[ｵｰﾌﾟﾝｳｪﾌﾞ]";
            $ezwebToSoftbank["%e501%"] = "\x1b\$Ed\x0f";
            $ezwebToSoftbank["%e502%"] = "[ABCD]";
            $ezwebToSoftbank["%e503%"] = "[abcd]";
            $ezwebToSoftbank["%e504%"] = "[1234]";
            $ezwebToSoftbank["%e505%"] = "[記号]";
            $ezwebToSoftbank["%e506%"] = "[可]";
            $ezwebToSoftbank["%e507%"] = "[ﾁｪｯｸﾏｰｸ]";
            $ezwebToSoftbank["%e508%"] = "[ﾍﾟﾝ]";
            $ezwebToSoftbank["%e509%"] = "[ﾗｼﾞｵﾎﾞﾀﾝ]";
            $ezwebToSoftbank["%e510%"] = "\x1b\$E4\x0f";
            $ezwebToSoftbank["%e511%"] = "\x1b\$FU\x0f";
            $ezwebToSoftbank["%e512%"] = "[ﾌﾞｯｸﾏｰｸ]";
            $ezwebToSoftbank["%e513%"] = "\x1b\$E\$\x0f";
            $ezwebToSoftbank["%e514%"] = "\x1b\$GV\x0f";
            $ezwebToSoftbank["%e515%"] = "\x1b\$E!\x0f";
            $ezwebToSoftbank["%e516%"] = "\x1b\$O!\x0f";
            $ezwebToSoftbank["%e517%"] = "\x1b\$Ed\x0f";
            $ezwebToSoftbank["%e518%"] = "↑↓";
            $ezwebToSoftbank["%e700%"] = "\x1b\$Q.\x0f";
            $ezwebToSoftbank["%e701%"] = "\x1b\$Q/\x0f";
            $ezwebToSoftbank["%e702%"] = "\x1b\$Q0\x0f";
            $ezwebToSoftbank["%e703%"] = "\x1b\$Q3\x0f";
            $ezwebToSoftbank["%e704%"] = "\x1b\$Q4\x0f";
            $ezwebToSoftbank["%e705%"] = "\x1b\$Q5\x0f";
            $ezwebToSoftbank["%e706%"] = "\x1b\$Q6\x0f";
            $ezwebToSoftbank["%e707%"] = "\x1b\$Q7\x0f";
            $ezwebToSoftbank["%e708%"] = "\x1b\$Q8\x0f";
            $ezwebToSoftbank["%e709%"] = "\x1b\$Q9\x0f";
            $ezwebToSoftbank["%e710%"] = "\x1b\$Q:\x0f";
            $ezwebToSoftbank["%e711%"] = "\x1b\$Q;\x0f";
            $ezwebToSoftbank["%e712%"] = "\x1b\$Q<\x0f";
            $ezwebToSoftbank["%e713%"] = "\x1b\$Q@\x0f";
            $ezwebToSoftbank["%e714%"] = "\x1b\$Q?\x0f";
            $ezwebToSoftbank["%e715%"] = "\x1b\$QB\x0f";
            $ezwebToSoftbank["%e716%"] = "\x1b\$QE\x0f";
            $ezwebToSoftbank["%e717%"] = "\x1b\$QF\x0f";
            $ezwebToSoftbank["%e718%"] = "\x1b\$QG\x0f";
            $ezwebToSoftbank["%e719%"] = "\x1b\$QK\x0f";
            $ezwebToSoftbank["%e720%"] = "\x1b\$QM\x0f";
            $ezwebToSoftbank["%e721%"] = "\x1b\$QN\x0f";
            $ezwebToSoftbank["%e722%"] = "\x1b\$QO\x0f";
            $ezwebToSoftbank["%e723%"] = "\x1b\$QP\x0f";
            $ezwebToSoftbank["%e724%"] = "\x1b\$QR\x0f";
            $ezwebToSoftbank["%e725%"] = "\x1b\$QS\x0f";
            $ezwebToSoftbank["%e726%"] = "\x1b\$QU\x0f";
            $ezwebToSoftbank["%e727%"] = "\x1b\$QT\x0f";
            $ezwebToSoftbank["%e728%"] = "\x1b\$QV\x0f";
            $ezwebToSoftbank["%e729%"] = "\x1b\$G'\x0f";
            $ezwebToSoftbank["%e730%"] = "[旗]";
            $ezwebToSoftbank["%e731%"] = "\x1b\$FV\x0f";
            $ezwebToSoftbank["%e732%"] = "\x1b\$FX\x0f";
            $ezwebToSoftbank["%e733%"] = "!?";
            $ezwebToSoftbank["%e734%"] = "!!";
            $ezwebToSoftbank["%e735%"] = "～";
            $ezwebToSoftbank["%e736%"] = "[ﾒﾛﾝ]";
            $ezwebToSoftbank["%e737%"] = "[ﾊﾟｲﾅｯﾌﾟﾙ]";
            $ezwebToSoftbank["%e738%"] = "[ﾌﾞﾄﾞｳ]";
            $ezwebToSoftbank["%e739%"] = "[ﾊﾞﾅﾅ]";
            $ezwebToSoftbank["%e740%"] = "[とうもろこし]";
            $ezwebToSoftbank["%e741%"] = "[ｷﾉｺ]";
            $ezwebToSoftbank["%e742%"] = "[栗]";
            $ezwebToSoftbank["%e743%"] = "[ﾓﾓ]";
            $ezwebToSoftbank["%e744%"] = "[やきいも]";
            $ezwebToSoftbank["%e745%"] = "[ﾋﾟｻﾞ]";
            $ezwebToSoftbank["%e746%"] = "[ﾁｷﾝ]";
            $ezwebToSoftbank["%e747%"] = "[七夕]";
            $ezwebToSoftbank["%e748%"] = "\x1b\$Gd\x0f";
            $ezwebToSoftbank["%e749%"] = "[辰]";
            $ezwebToSoftbank["%e750%"] = "[ﾋﾟｱﾉ]";
            $ezwebToSoftbank["%e751%"] = "\x1b\$G7\x0f";
            $ezwebToSoftbank["%e752%"] = "\x1b\$G9\x0f";
            $ezwebToSoftbank["%e753%"] = "[ﾎﾞｰﾘﾝｸﾞ]";
            $ezwebToSoftbank["%e754%"] = "[なまはげ]";
            $ezwebToSoftbank["%e755%"] = "[天狗]";
            $ezwebToSoftbank["%e756%"] = "[ﾊﾟﾝﾀﾞ]";
            $ezwebToSoftbank["%e757%"] = "\x1b\$P)\x0f";
            $ezwebToSoftbank["%e758%"] = "\x1b\$E+\x0f";
            $ezwebToSoftbank["%e759%"] = "\x1b\$O%\x0f";
            $ezwebToSoftbank["%e760%"] = "[ｱｲｽｸﾘｰﾑ]";
            $ezwebToSoftbank["%e761%"] = "[ﾄﾞｰﾅﾂ]";
            $ezwebToSoftbank["%e762%"] = "[ｸｯｷｰ]";
            $ezwebToSoftbank["%e763%"] = "[ﾁｮｺ]";
            $ezwebToSoftbank["%e764%"] = "[ｷｬﾝﾃﾞｨ]";
            $ezwebToSoftbank["%e765%"] = "[ｷｬﾝﾃﾞｨ]";
            $ezwebToSoftbank["%e766%"] = "(/_＼)";
            $ezwebToSoftbank["%e767%"] = "(・×・)";
            $ezwebToSoftbank["%e768%"] = "|(・×・)|";
            $ezwebToSoftbank["%e769%"] = "[火山]";
            $ezwebToSoftbank["%e770%"] = "\x1b\$OH\x0f";
            $ezwebToSoftbank["%e771%"] = "[ABC]";
            $ezwebToSoftbank["%e772%"] = "[ﾌﾟﾘﾝ]";
            $ezwebToSoftbank["%e773%"] = "[ﾐﾂﾊﾞﾁ]";
            $ezwebToSoftbank["%e774%"] = "[てんとう虫]";
            $ezwebToSoftbank["%e775%"] = "[ﾊﾁﾐﾂ]";
            $ezwebToSoftbank["%e776%"] = "\x1b\$Oe\x0f";
            $ezwebToSoftbank["%e777%"] = "[飛んでいくお金]";
            $ezwebToSoftbank["%e778%"] = "\x1b\$P'\x0f";
            $ezwebToSoftbank["%e779%"] = "\x1b\$P6\x0f";
            $ezwebToSoftbank["%e780%"] = "\x1b\$P6\x0f";
            $ezwebToSoftbank["%e781%"] = "\x1b\$Pk\x0f";
            $ezwebToSoftbank["%e782%"] = "\x1b\$P8\x0f";
            $ezwebToSoftbank["%e783%"] = "\x1b\$Gw\x0f";
            $ezwebToSoftbank["%e784%"] = "\x1b\$E#\x0f";
            $ezwebToSoftbank["%e785%"] = "\x1b\$P2\x0f";
            $ezwebToSoftbank["%e786%"] = "\x1b\$P2\x0f";
            $ezwebToSoftbank["%e787%"] = "\x1b\$E&\x0f";
            $ezwebToSoftbank["%e788%"] = "\x1b\$P#\x0f";
            $ezwebToSoftbank["%e789%"] = "\x1b\$P#\x0f";
            $ezwebToSoftbank["%e790%"] = "\x1b\$P3\x0f";
            $ezwebToSoftbank["%e791%"] = "\x1b\$P3\x0f";
            $ezwebToSoftbank["%e792%"] = "\x1b\$P\$\x0f";
            $ezwebToSoftbank["%e793%"] = "\x1b\$O9\x0f";
            $ezwebToSoftbank["%e794%"] = "[ﾓｱｲ]";
            $ezwebToSoftbank["%e795%"] = "\x1b\$GY\x0f";
            $ezwebToSoftbank["%e796%"] = "[花札]";
            $ezwebToSoftbank["%e797%"] = "[ｼﾞｮｰｶｰ]";
            $ezwebToSoftbank["%e798%"] = "[ｴﾋﾞﾌﾗｲ]";
            $ezwebToSoftbank["%e799%"] = "\x1b\$E#\x0f";
            $ezwebToSoftbank["%e800%"] = "\x1b\$F!\x0f";
            $ezwebToSoftbank["%e801%"] = "\x1b\$PR\x0f";
            $ezwebToSoftbank["%e802%"] = "[EZﾑｰﾋﾞｰ]";
            $ezwebToSoftbank["%e803%"] = "\x1b\$OG\x0f";
            $ezwebToSoftbank["%e804%"] = "\x1b\$QC\x0f";
            $ezwebToSoftbank["%e805%"] = "[ｼﾞｰﾝｽﾞ]";
            $ezwebToSoftbank["%e806%"] = "E#OH";
            $ezwebToSoftbank["%e807%"] = "↑↓";
            $ezwebToSoftbank["%e808%"] = "⇔";
            $ezwebToSoftbank["%e809%"] = "↑↓";
            $ezwebToSoftbank["%e810%"] = "\x1b\$P^\x0f";
            $ezwebToSoftbank["%e811%"] = "\x1b\$E0\x0f";
            $ezwebToSoftbank["%e812%"] = "[ｶﾀﾂﾑﾘ]";
            $ezwebToSoftbank["%e813%"] = "\x1b\$P\$\x0f";
            $ezwebToSoftbank["%e814%"] = "\x1b\$P\$\x0f";
            $ezwebToSoftbank["%e815%"] = "[Cﾒｰﾙ]";
            $ezwebToSoftbank["%e816%"] = "\x1b\$E0\x0f";
            $ezwebToSoftbank["%e817%"] = "\x1b\$G0\x0f";
            $ezwebToSoftbank["%e818%"] = "\x1b\$F0\x0f";
            $ezwebToSoftbank["%e819%"] = "\x1b\$G2\x0f";
            $ezwebToSoftbank["%e820%"] = "\x1b\$PG\x0f";
            $ezwebToSoftbank["%e821%"] = "\x1b\$P#\x0f";
            $ezwebToSoftbank["%e822%"] = "\x1b\$P6\x0f";
        }

        return $ezwebToSoftbank;
    }

    /**
     * getSoftbankEmojiメソッド
     *
     * Softbank用の変換文字をキーにしたSoftbank絵文字データ配列を返します。
     *
     * @return $softbankEmoji Softbank絵文字配列
     */

    public static function getSoftbankEmoji() {
        static $softbankEmoji;

        if (!isset($softbankEmoji)) {
            $softbankEmoji["%s1%"] = "\xf9\x41";
            $softbankEmoji["%s2%"] = "\xf9\x42";
            $softbankEmoji["%s3%"] = "\xf9\x43";
            $softbankEmoji["%s4%"] = "\xf9\x44";
            $softbankEmoji["%s5%"] = "\xf9\x45";
            $softbankEmoji["%s6%"] = "\xf9\x46";
            $softbankEmoji["%s7%"] = "\xf9\x47";
            $softbankEmoji["%s8%"] = "\xf9\x48";
            $softbankEmoji["%s9%"] = "\xf9\x49";
            $softbankEmoji["%s10%"] = "\xf9\x4a";
            $softbankEmoji["%s11%"] = "\xf9\x4b";
            $softbankEmoji["%s12%"] = "\xf9\x4c";
            $softbankEmoji["%s13%"] = "\xf9\x4d";
            $softbankEmoji["%s14%"] = "\xf9\x4e";
            $softbankEmoji["%s15%"] = "\xf9\x4f";
            $softbankEmoji["%s16%"] = "\xf9\x50";
            $softbankEmoji["%s17%"] = "\xf9\x51";
            $softbankEmoji["%s18%"] = "\xf9\x52";
            $softbankEmoji["%s19%"] = "\xf9\x53";
            $softbankEmoji["%s20%"] = "\xf9\x54";
            $softbankEmoji["%s21%"] = "\xf9\x55";
            $softbankEmoji["%s22%"] = "\xf9\x56";
            $softbankEmoji["%s23%"] = "\xf9\x57";
            $softbankEmoji["%s24%"] = "\xf9\x58";
            $softbankEmoji["%s25%"] = "\xf9\x59";
            $softbankEmoji["%s26%"] = "\xf9\x5a";
            $softbankEmoji["%s27%"] = "\xf9\x5b";
            $softbankEmoji["%s28%"] = "\xf9\x5c";
            $softbankEmoji["%s29%"] = "\xf9\x5d";
            $softbankEmoji["%s30%"] = "\xf9\x5e";
            $softbankEmoji["%s31%"] = "\xf9\x5f";
            $softbankEmoji["%s32%"] = "\xf9\x60";
            $softbankEmoji["%s33%"] = "\xf9\x61";
            $softbankEmoji["%s34%"] = "\xf9\x62";
            $softbankEmoji["%s35%"] = "\xf9\x63";
            $softbankEmoji["%s36%"] = "\xf9\x64";
            $softbankEmoji["%s37%"] = "\xf9\x65";
            $softbankEmoji["%s38%"] = "\xf9\x66";
            $softbankEmoji["%s39%"] = "\xf9\x67";
            $softbankEmoji["%s40%"] = "\xf9\x68";
            $softbankEmoji["%s41%"] = "\xf9\x69";
            $softbankEmoji["%s42%"] = "\xf9\x6a";
            $softbankEmoji["%s43%"] = "\xf9\x6b";
            $softbankEmoji["%s44%"] = "\xf9\x6c";
            $softbankEmoji["%s45%"] = "\xf9\x6d";
            $softbankEmoji["%s46%"] = "\xf9\x6e";
            $softbankEmoji["%s47%"] = "\xf9\x6f";
            $softbankEmoji["%s48%"] = "\xf9\x70";
            $softbankEmoji["%s49%"] = "\xf9\x71";
            $softbankEmoji["%s50%"] = "\xf9\x72";
            $softbankEmoji["%s51%"] = "\xf9\x73";
            $softbankEmoji["%s52%"] = "\xf9\x74";
            $softbankEmoji["%s53%"] = "\xf9\x75";
            $softbankEmoji["%s54%"] = "\xf9\x76";
            $softbankEmoji["%s55%"] = "\xf9\x77";
            $softbankEmoji["%s56%"] = "\xf9\x78";
            $softbankEmoji["%s57%"] = "\xf9\x79";
            $softbankEmoji["%s58%"] = "\xf9\x7a";
            $softbankEmoji["%s59%"] = "\xf9\x7b";
            $softbankEmoji["%s60%"] = "\xf9\x7c";
            $softbankEmoji["%s61%"] = "\xf9\x7d";
            $softbankEmoji["%s62%"] = "\xf9\x7e";
            $softbankEmoji["%s63%"] = "\xf9\x80";
            $softbankEmoji["%s64%"] = "\xf9\x81";
            $softbankEmoji["%s65%"] = "\xf9\x82";
            $softbankEmoji["%s66%"] = "\xf9\x83";
            $softbankEmoji["%s67%"] = "\xf9\x84";
            $softbankEmoji["%s68%"] = "\xf9\x85";
            $softbankEmoji["%s69%"] = "\xf9\x86";
            $softbankEmoji["%s70%"] = "\xf9\x87";
            $softbankEmoji["%s71%"] = "\xf9\x88";
            $softbankEmoji["%s72%"] = "\xf9\x89";
            $softbankEmoji["%s73%"] = "\xf9\x8a";
            $softbankEmoji["%s74%"] = "\xf9\x8b";
            $softbankEmoji["%s75%"] = "\xf9\x8c";
            $softbankEmoji["%s76%"] = "\xf9\x8d";
            $softbankEmoji["%s77%"] = "\xf9\x8e";
            $softbankEmoji["%s78%"] = "\xf9\x8f";
            $softbankEmoji["%s79%"] = "\xf9\x90";
            $softbankEmoji["%s80%"] = "\xf9\x91";
            $softbankEmoji["%s81%"] = "\xf9\x92";
            $softbankEmoji["%s82%"] = "\xf9\x93";
            $softbankEmoji["%s83%"] = "\xf9\x94";
            $softbankEmoji["%s84%"] = "\xf9\x95";
            $softbankEmoji["%s85%"] = "\xf9\x96";
            $softbankEmoji["%s86%"] = "\xf9\x97";
            $softbankEmoji["%s87%"] = "\xf9\x98";
            $softbankEmoji["%s88%"] = "\xf9\x99";
            $softbankEmoji["%s89%"] = "\xf9\x9a";
            $softbankEmoji["%s90%"] = "\xf9\x9b";
            $softbankEmoji["%s101%"] = "\xf7\x41";
            $softbankEmoji["%s102%"] = "\xf7\x42";
            $softbankEmoji["%s103%"] = "\xf7\x43";
            $softbankEmoji["%s104%"] = "\xf7\x44";
            $softbankEmoji["%s105%"] = "\xf7\x45";
            $softbankEmoji["%s106%"] = "\xf7\x46";
            $softbankEmoji["%s107%"] = "\xf7\x47";
            $softbankEmoji["%s108%"] = "\xf7\x48";
            $softbankEmoji["%s109%"] = "\xf7\x49";
            $softbankEmoji["%s110%"] = "\xf7\x4a";
            $softbankEmoji["%s111%"] = "\xf7\x4b";
            $softbankEmoji["%s112%"] = "\xf7\x4c";
            $softbankEmoji["%s113%"] = "\xf7\x4d";
            $softbankEmoji["%s114%"] = "\xf7\x4e";
            $softbankEmoji["%s115%"] = "\xf7\x4f";
            $softbankEmoji["%s116%"] = "\xf7\x50";
            $softbankEmoji["%s117%"] = "\xf7\x51";
            $softbankEmoji["%s118%"] = "\xf7\x52";
            $softbankEmoji["%s119%"] = "\xf7\x53";
            $softbankEmoji["%s120%"] = "\xf7\x54";
            $softbankEmoji["%s121%"] = "\xf7\x55";
            $softbankEmoji["%s122%"] = "\xf7\x56";
            $softbankEmoji["%s123%"] = "\xf7\x57";
            $softbankEmoji["%s124%"] = "\xf7\x58";
            $softbankEmoji["%s125%"] = "\xf7\x59";
            $softbankEmoji["%s126%"] = "\xf7\x5a";
            $softbankEmoji["%s127%"] = "\xf7\x5b";
            $softbankEmoji["%s128%"] = "\xf7\x5c";
            $softbankEmoji["%s129%"] = "\xf7\x5d";
            $softbankEmoji["%s130%"] = "\xf7\x5e";
            $softbankEmoji["%s131%"] = "\xf7\x5f";
            $softbankEmoji["%s132%"] = "\xf7\x60";
            $softbankEmoji["%s133%"] = "\xf7\x61";
            $softbankEmoji["%s134%"] = "\xf7\x62";
            $softbankEmoji["%s135%"] = "\xf7\x63";
            $softbankEmoji["%s136%"] = "\xf7\x64";
            $softbankEmoji["%s137%"] = "\xf7\x65";
            $softbankEmoji["%s138%"] = "\xf7\x66";
            $softbankEmoji["%s139%"] = "\xf7\x67";
            $softbankEmoji["%s140%"] = "\xf7\x68";
            $softbankEmoji["%s141%"] = "\xf7\x69";
            $softbankEmoji["%s142%"] = "\xf7\x6a";
            $softbankEmoji["%s143%"] = "\xf7\x6b";
            $softbankEmoji["%s144%"] = "\xf7\x6c";
            $softbankEmoji["%s145%"] = "\xf7\x6d";
            $softbankEmoji["%s146%"] = "\xf7\x6e";
            $softbankEmoji["%s147%"] = "\xf7\x6f";
            $softbankEmoji["%s148%"] = "\xf7\x70";
            $softbankEmoji["%s149%"] = "\xf7\x71";
            $softbankEmoji["%s150%"] = "\xf7\x72";
            $softbankEmoji["%s151%"] = "\xf7\x73";
            $softbankEmoji["%s152%"] = "\xf7\x74";
            $softbankEmoji["%s153%"] = "\xf7\x75";
            $softbankEmoji["%s154%"] = "\xf7\x76";
            $softbankEmoji["%s155%"] = "\xf7\x77";
            $softbankEmoji["%s156%"] = "\xf7\x78";
            $softbankEmoji["%s157%"] = "\xf7\x79";
            $softbankEmoji["%s158%"] = "\xf7\x7a";
            $softbankEmoji["%s159%"] = "\xf7\x7b";
            $softbankEmoji["%s160%"] = "\xf7\x7c";
            $softbankEmoji["%s161%"] = "\xf7\x7d";
            $softbankEmoji["%s162%"] = "\xf7\x7e";
            $softbankEmoji["%s163%"] = "\xf7\x80";
            $softbankEmoji["%s164%"] = "\xf7\x81";
            $softbankEmoji["%s165%"] = "\xf7\x82";
            $softbankEmoji["%s166%"] = "\xf7\x83";
            $softbankEmoji["%s167%"] = "\xf7\x84";
            $softbankEmoji["%s168%"] = "\xf7\x85";
            $softbankEmoji["%s169%"] = "\xf7\x86";
            $softbankEmoji["%s170%"] = "\xf7\x87";
            $softbankEmoji["%s171%"] = "\xf7\x88";
            $softbankEmoji["%s172%"] = "\xf7\x89";
            $softbankEmoji["%s173%"] = "\xf7\x8a";
            $softbankEmoji["%s174%"] = "\xf7\x8b";
            $softbankEmoji["%s175%"] = "\xf7\x8c";
            $softbankEmoji["%s176%"] = "\xf7\x8d";
            $softbankEmoji["%s177%"] = "\xf7\x8e";
            $softbankEmoji["%s178%"] = "\xf7\x8f";
            $softbankEmoji["%s179%"] = "\xf7\x90";
            $softbankEmoji["%s180%"] = "\xf7\x91";
            $softbankEmoji["%s181%"] = "\xf7\x92";
            $softbankEmoji["%s182%"] = "\xf7\x93";
            $softbankEmoji["%s183%"] = "\xf7\x94";
            $softbankEmoji["%s184%"] = "\xf7\x95";
            $softbankEmoji["%s185%"] = "\xf7\x96";
            $softbankEmoji["%s186%"] = "\xf7\x97";
            $softbankEmoji["%s187%"] = "\xf7\x98";
            $softbankEmoji["%s188%"] = "\xf7\x99";
            $softbankEmoji["%s189%"] = "\xf7\x9a";
            $softbankEmoji["%s190%"] = "\xf7\x9b";
            $softbankEmoji["%s201%"] = "\xf7\xa1";
            $softbankEmoji["%s202%"] = "\xf7\xa2";
            $softbankEmoji["%s203%"] = "\xf7\xa3";
            $softbankEmoji["%s204%"] = "\xf7\xa4";
            $softbankEmoji["%s205%"] = "\xf7\xa5";
            $softbankEmoji["%s206%"] = "\xf7\xa6";
            $softbankEmoji["%s207%"] = "\xf7\xa7";
            $softbankEmoji["%s208%"] = "\xf7\xa8";
            $softbankEmoji["%s209%"] = "\xf7\xa9";
            $softbankEmoji["%s210%"] = "\xf7\xaa";
            $softbankEmoji["%s211%"] = "\xf7\xab";
            $softbankEmoji["%s212%"] = "\xf7\xac";
            $softbankEmoji["%s213%"] = "\xf7\xad";
            $softbankEmoji["%s214%"] = "\xf7\xae";
            $softbankEmoji["%s215%"] = "\xf7\xaf";
            $softbankEmoji["%s216%"] = "\xf7\xb0";
            $softbankEmoji["%s217%"] = "\xf7\xb1";
            $softbankEmoji["%s218%"] = "\xf7\xb2";
            $softbankEmoji["%s219%"] = "\xf7\xb3";
            $softbankEmoji["%s220%"] = "\xf7\xb4";
            $softbankEmoji["%s221%"] = "\xf7\xb5";
            $softbankEmoji["%s222%"] = "\xf7\xb6";
            $softbankEmoji["%s223%"] = "\xf7\xb7";
            $softbankEmoji["%s224%"] = "\xf7\xb8";
            $softbankEmoji["%s225%"] = "\xf7\xb9";
            $softbankEmoji["%s226%"] = "\xf7\xba";
            $softbankEmoji["%s227%"] = "\xf7\xbb";
            $softbankEmoji["%s228%"] = "\xf7\xbc";
            $softbankEmoji["%s229%"] = "\xf7\xbd";
            $softbankEmoji["%s230%"] = "\xf7\xbe";
            $softbankEmoji["%s231%"] = "\xf7\xbf";
            $softbankEmoji["%s232%"] = "\xf7\xc0";
            $softbankEmoji["%s233%"] = "\xf7\xc1";
            $softbankEmoji["%s234%"] = "\xf7\xc2";
            $softbankEmoji["%s235%"] = "\xf7\xc3";
            $softbankEmoji["%s236%"] = "\xf7\xc4";
            $softbankEmoji["%s237%"] = "\xf7\xc5";
            $softbankEmoji["%s238%"] = "\xf7\xc6";
            $softbankEmoji["%s239%"] = "\xf7\xc7";
            $softbankEmoji["%s240%"] = "\xf7\xc8";
            $softbankEmoji["%s241%"] = "\xf7\xc9";
            $softbankEmoji["%s242%"] = "\xf7\xca";
            $softbankEmoji["%s243%"] = "\xf7\xcb";
            $softbankEmoji["%s244%"] = "\xf7\xcc";
            $softbankEmoji["%s245%"] = "\xf7\xcd";
            $softbankEmoji["%s246%"] = "\xf7\xce";
            $softbankEmoji["%s247%"] = "\xf7\xcf";
            $softbankEmoji["%s248%"] = "\xf7\xd0";
            $softbankEmoji["%s249%"] = "\xf7\xd1";
            $softbankEmoji["%s250%"] = "\xf7\xd2";
            $softbankEmoji["%s251%"] = "\xf7\xd3";
            $softbankEmoji["%s252%"] = "\xf7\xd4";
            $softbankEmoji["%s253%"] = "\xf7\xd5";
            $softbankEmoji["%s254%"] = "\xf7\xd6";
            $softbankEmoji["%s255%"] = "\xf7\xd7";
            $softbankEmoji["%s256%"] = "\xf7\xd8";
            $softbankEmoji["%s257%"] = "\xf7\xd9";
            $softbankEmoji["%s258%"] = "\xf7\xda";
            $softbankEmoji["%s259%"] = "\xf7\xdb";
            $softbankEmoji["%s260%"] = "\xf7\xdc";
            $softbankEmoji["%s261%"] = "\xf7\xdd";
            $softbankEmoji["%s262%"] = "\xf7\xde";
            $softbankEmoji["%s263%"] = "\xf7\xdf";
            $softbankEmoji["%s264%"] = "\xf7\xe0";
            $softbankEmoji["%s265%"] = "\xf7\xe1";
            $softbankEmoji["%s266%"] = "\xf7\xe2";
            $softbankEmoji["%s267%"] = "\xf7\xe3";
            $softbankEmoji["%s268%"] = "\xf7\xe4";
            $softbankEmoji["%s269%"] = "\xf7\xe5";
            $softbankEmoji["%s270%"] = "\xf7\xe6";
            $softbankEmoji["%s271%"] = "\xf7\xe7";
            $softbankEmoji["%s272%"] = "\xf7\xe8";
            $softbankEmoji["%s273%"] = "\xf7\xe9";
            $softbankEmoji["%s274%"] = "\xf7\xea";
            $softbankEmoji["%s275%"] = "\xf7\xeb";
            $softbankEmoji["%s276%"] = "\xf7\xec";
            $softbankEmoji["%s277%"] = "\xf7\xed";
            $softbankEmoji["%s278%"] = "\xf7\xee";
            $softbankEmoji["%s279%"] = "\xf7\xef";
            $softbankEmoji["%s280%"] = "\xf7\xf0";
            $softbankEmoji["%s281%"] = "\xf7\xf1";
            $softbankEmoji["%s282%"] = "\xf7\xf2";
            $softbankEmoji["%s283%"] = "\xf7\xf3";
            $softbankEmoji["%s285%"] = "";
            $softbankEmoji["%s286%"] = "";
            $softbankEmoji["%s287%"] = "";
            $softbankEmoji["%s301%"] = "\xf9\xa1";
            $softbankEmoji["%s302%"] = "\xf9\xa2";
            $softbankEmoji["%s303%"] = "\xf9\xa3";
            $softbankEmoji["%s304%"] = "\xf9\xa4";
            $softbankEmoji["%s305%"] = "\xf9\xa5";
            $softbankEmoji["%s306%"] = "\xf9\xa6";
            $softbankEmoji["%s307%"] = "\xf9\xa7";
            $softbankEmoji["%s308%"] = "\xf9\xa8";
            $softbankEmoji["%s309%"] = "\xf9\xa9";
            $softbankEmoji["%s310%"] = "\xf9\xaa";
            $softbankEmoji["%s311%"] = "\xf9\xab";
            $softbankEmoji["%s312%"] = "\xf9\xac";
            $softbankEmoji["%s313%"] = "\xf9\xad";
            $softbankEmoji["%s314%"] = "\xf9\xae";
            $softbankEmoji["%s315%"] = "\xf9\xaf";
            $softbankEmoji["%s316%"] = "\xf9\xb0";
            $softbankEmoji["%s317%"] = "\xf9\xb1";
            $softbankEmoji["%s318%"] = "\xf9\xb2";
            $softbankEmoji["%s319%"] = "\xf9\xb3";
            $softbankEmoji["%s320%"] = "\xf9\xb4";
            $softbankEmoji["%s321%"] = "\xf9\xb5";
            $softbankEmoji["%s322%"] = "\xf9\xb6";
            $softbankEmoji["%s323%"] = "\xf9\xb7";
            $softbankEmoji["%s324%"] = "\xf9\xb8";
            $softbankEmoji["%s325%"] = "\xf9\xb9";
            $softbankEmoji["%s326%"] = "\xf9\xba";
            $softbankEmoji["%s327%"] = "\xf9\xbb";
            $softbankEmoji["%s328%"] = "\xf9\xbc";
            $softbankEmoji["%s329%"] = "\xf9\xbd";
            $softbankEmoji["%s330%"] = "\xf9\xbe";
            $softbankEmoji["%s331%"] = "\xf9\xbf";
            $softbankEmoji["%s332%"] = "\xf9\xc0";
            $softbankEmoji["%s333%"] = "\xf9\xc1";
            $softbankEmoji["%s334%"] = "\xf9\xc2";
            $softbankEmoji["%s335%"] = "\xf9\xc3";
            $softbankEmoji["%s336%"] = "\xf9\xc4";
            $softbankEmoji["%s337%"] = "\xf9\xc5";
            $softbankEmoji["%s338%"] = "\xf9\xc6";
            $softbankEmoji["%s339%"] = "\xf9\xc7";
            $softbankEmoji["%s340%"] = "\xf9\xc8";
            $softbankEmoji["%s341%"] = "\xf9\xc9";
            $softbankEmoji["%s342%"] = "\xf9\xca";
            $softbankEmoji["%s343%"] = "\xf9\xcb";
            $softbankEmoji["%s344%"] = "\xf9\xcc";
            $softbankEmoji["%s345%"] = "\xf9\xcd";
            $softbankEmoji["%s346%"] = "\xf9\xce";
            $softbankEmoji["%s347%"] = "\xf9\xcf";
            $softbankEmoji["%s348%"] = "\xf9\xd0";
            $softbankEmoji["%s349%"] = "\xf9\xd1";
            $softbankEmoji["%s350%"] = "\xf9\xd2";
            $softbankEmoji["%s351%"] = "\xf9\xd3";
            $softbankEmoji["%s352%"] = "\xf9\xd4";
            $softbankEmoji["%s353%"] = "\xf9\xd5";
            $softbankEmoji["%s354%"] = "\xf9\xd6";
            $softbankEmoji["%s355%"] = "\xf9\xd7";
            $softbankEmoji["%s356%"] = "\xf9\xd8";
            $softbankEmoji["%s357%"] = "\xf9\xd9";
            $softbankEmoji["%s358%"] = "\xf9\xda";
            $softbankEmoji["%s359%"] = "\xf9\xdb";
            $softbankEmoji["%s360%"] = "\xf9\xdc";
            $softbankEmoji["%s361%"] = "\xf9\xdd";
            $softbankEmoji["%s362%"] = "\xf9\xde";
            $softbankEmoji["%s363%"] = "\xf9\xdf";
            $softbankEmoji["%s364%"] = "\xf9\xe0";
            $softbankEmoji["%s365%"] = "\xf9\xe1";
            $softbankEmoji["%s366%"] = "\xf9\xe2";
            $softbankEmoji["%s367%"] = "\xf9\xe3";
            $softbankEmoji["%s368%"] = "\xf9\xe4";
            $softbankEmoji["%s369%"] = "\xf9\xe5";
            $softbankEmoji["%s370%"] = "\xf9\xe6";
            $softbankEmoji["%s371%"] = "\xf9\xe7";
            $softbankEmoji["%s372%"] = "\xf9\xe8";
            $softbankEmoji["%s373%"] = "\xf9\xe9";
            $softbankEmoji["%s374%"] = "\xf9\xea";
            $softbankEmoji["%s375%"] = "\xf9\xeb";
            $softbankEmoji["%s376%"] = "\xf9\xec";
            $softbankEmoji["%s377%"] = "\xf9\xed";
            $softbankEmoji["%s401%"] = "\xfb\x41";
            $softbankEmoji["%s402%"] = "\xfb\x42";
            $softbankEmoji["%s403%"] = "\xfb\x43";
            $softbankEmoji["%s404%"] = "\xfb\x44";
            $softbankEmoji["%s405%"] = "\xfb\x45";
            $softbankEmoji["%s406%"] = "\xfb\x46";
            $softbankEmoji["%s407%"] = "\xfb\x47";
            $softbankEmoji["%s408%"] = "\xfb\x48";
            $softbankEmoji["%s409%"] = "\xfb\x49";
            $softbankEmoji["%s410%"] = "\xfb\x4a";
            $softbankEmoji["%s411%"] = "\xfb\x4b";
            $softbankEmoji["%s412%"] = "\xfb\x4c";
            $softbankEmoji["%s413%"] = "\xfb\x4d";
            $softbankEmoji["%s414%"] = "\xfb\x4e";
            $softbankEmoji["%s415%"] = "\xfb\x4f";
            $softbankEmoji["%s416%"] = "\xfb\x50";
            $softbankEmoji["%s417%"] = "\xfb\x51";
            $softbankEmoji["%s418%"] = "\xfb\x52";
            $softbankEmoji["%s419%"] = "\xfb\x53";
            $softbankEmoji["%s420%"] = "\xfb\x54";
            $softbankEmoji["%s421%"] = "\xfb\x55";
            $softbankEmoji["%s422%"] = "\xfb\x56";
            $softbankEmoji["%s423%"] = "\xfb\x57";
            $softbankEmoji["%s424%"] = "\xfb\x58";
            $softbankEmoji["%s425%"] = "\xfb\x59";
            $softbankEmoji["%s426%"] = "\xfb\x5a";
            $softbankEmoji["%s427%"] = "\xfb\x5b";
            $softbankEmoji["%s428%"] = "\xfb\x5c";
            $softbankEmoji["%s429%"] = "\xfb\x5d";
            $softbankEmoji["%s430%"] = "\xfb\x5e";
            $softbankEmoji["%s431%"] = "\xfb\x5f";
            $softbankEmoji["%s432%"] = "\xfb\x60";
            $softbankEmoji["%s433%"] = "\xfb\x61";
            $softbankEmoji["%s434%"] = "\xfb\x62";
            $softbankEmoji["%s435%"] = "\xfb\x63";
            $softbankEmoji["%s436%"] = "\xfb\x64";
            $softbankEmoji["%s437%"] = "\xfb\x65";
            $softbankEmoji["%s438%"] = "\xfb\x66";
            $softbankEmoji["%s439%"] = "\xfb\x67";
            $softbankEmoji["%s440%"] = "\xfb\x68";
            $softbankEmoji["%s441%"] = "\xfb\x69";
            $softbankEmoji["%s442%"] = "\xfb\x6a";
            $softbankEmoji["%s443%"] = "\xfb\x6b";
            $softbankEmoji["%s444%"] = "\xfb\x6c";
            $softbankEmoji["%s445%"] = "\xfb\x6d";
            $softbankEmoji["%s446%"] = "\xfb\x6e";
            $softbankEmoji["%s447%"] = "\xfb\x6f";
            $softbankEmoji["%s448%"] = "\xfb\x70";
            $softbankEmoji["%s449%"] = "\xfb\x71";
            $softbankEmoji["%s450%"] = "\xfb\x72";
            $softbankEmoji["%s451%"] = "\xfb\x73";
            $softbankEmoji["%s452%"] = "\xfb\x74";
            $softbankEmoji["%s453%"] = "\xfb\x75";
            $softbankEmoji["%s454%"] = "\xfb\x76";
            $softbankEmoji["%s455%"] = "\xfb\x77";
            $softbankEmoji["%s456%"] = "\xfb\x78";
            $softbankEmoji["%s457%"] = "\xfb\x79";
            $softbankEmoji["%s458%"] = "\xfb\x7a";
            $softbankEmoji["%s459%"] = "\xfb\x7b";
            $softbankEmoji["%s460%"] = "\xfb\x7c";
            $softbankEmoji["%s461%"] = "\xfb\x7d";
            $softbankEmoji["%s462%"] = "\xfb\x7e";
            $softbankEmoji["%s463%"] = "\xfb\x80";
            $softbankEmoji["%s464%"] = "\xfb\x81";
            $softbankEmoji["%s465%"] = "\xfb\x82";
            $softbankEmoji["%s466%"] = "\xfb\x83";
            $softbankEmoji["%s467%"] = "\xfb\x84";
            $softbankEmoji["%s468%"] = "\xfb\x85";
            $softbankEmoji["%s469%"] = "\xfb\x86";
            $softbankEmoji["%s470%"] = "\xfb\x87";
            $softbankEmoji["%s471%"] = "\xfb\x88";
            $softbankEmoji["%s472%"] = "\xfb\x89";
            $softbankEmoji["%s473%"] = "\xfb\x8a";
            $softbankEmoji["%s474%"] = "\xfb\x8b";
            $softbankEmoji["%s475%"] = "\xfb\x8c";
            $softbankEmoji["%s476%"] = "\xfb\x8d";
            $softbankEmoji["%s501%"] = "\xfb\xa1";
            $softbankEmoji["%s502%"] = "\xfb\xa2";
            $softbankEmoji["%s503%"] = "\xfb\xa3";
            $softbankEmoji["%s504%"] = "\xfb\xa4";
            $softbankEmoji["%s505%"] = "\xfb\xa5";
            $softbankEmoji["%s506%"] = "\xfb\xa6";
            $softbankEmoji["%s507%"] = "\xfb\xa7";
            $softbankEmoji["%s508%"] = "\xfb\xa8";
            $softbankEmoji["%s509%"] = "\xfb\xa9";
            $softbankEmoji["%s510%"] = "\xfb\xaa";
            $softbankEmoji["%s511%"] = "\xfb\xab";
            $softbankEmoji["%s512%"] = "\xfb\xac";
            $softbankEmoji["%s513%"] = "\xfb\xad";
            $softbankEmoji["%s514%"] = "\xfb\xae";
            $softbankEmoji["%s515%"] = "\xfb\xaf";
            $softbankEmoji["%s516%"] = "\xfb\xb0";
            $softbankEmoji["%s517%"] = "\xfb\xb1";
            $softbankEmoji["%s518%"] = "\xfb\xb2";
            $softbankEmoji["%s519%"] = "\xfb\xb3";
            $softbankEmoji["%s520%"] = "\xfb\xb4";
            $softbankEmoji["%s521%"] = "\xfb\xb5";
            $softbankEmoji["%s522%"] = "\xfb\xb6";
            $softbankEmoji["%s523%"] = "\xfb\xb7";
            $softbankEmoji["%s524%"] = "\xfb\xb8";
            $softbankEmoji["%s525%"] = "\xfb\xb9";
            $softbankEmoji["%s526%"] = "\xfb\xba";
            $softbankEmoji["%s527%"] = "\xfb\xbb";
            $softbankEmoji["%s528%"] = "\xfb\xbc";
            $softbankEmoji["%s529%"] = "\xfb\xbd";
            $softbankEmoji["%s530%"] = "\xfb\xbe";
            $softbankEmoji["%s531%"] = "\xfb\xbf";
            $softbankEmoji["%s532%"] = "\xfb\xc0";
            $softbankEmoji["%s533%"] = "\xfb\xc1";
            $softbankEmoji["%s534%"] = "\xfb\xc2";
            $softbankEmoji["%s535%"] = "\xfb\xc3";
            $softbankEmoji["%s536%"] = "\xfb\xc4";
            $softbankEmoji["%s537%"] = "\xfb\xc5";
            $softbankEmoji["%s538%"] = "\xfb\xc6";
            $softbankEmoji["%s539%"] = "\xfb\xc7";
            $softbankEmoji["%s540%"] = "\xfb\xc8";
            $softbankEmoji["%s541%"] = "\xfb\xc9";
            $softbankEmoji["%s542%"] = "\xfb\xca";
            $softbankEmoji["%s543%"] = "\xfb\xcb";
            $softbankEmoji["%s544%"] = "\xfb\xcc";
            $softbankEmoji["%s545%"] = "\xfb\xcd";
            $softbankEmoji["%s546%"] = "\xfb\xce";
            $softbankEmoji["%s547%"] = "\xfb\xcf";
            $softbankEmoji["%s548%"] = "\xfb\xd0";
            $softbankEmoji["%s549%"] = "\xfb\xd1";
            $softbankEmoji["%s550%"] = "\xfb\xd2";
            $softbankEmoji["%s551%"] = "\xfb\xd3";
            $softbankEmoji["%s552%"] = "\xfb\xd4";
            $softbankEmoji["%s553%"] = "\xfb\xd5";
            $softbankEmoji["%s554%"] = "\xfb\xd6";
            $softbankEmoji["%s555%"] = "\xfb\xd7";
        }

        return $softbankEmoji;
    }

    /**
     * getSoftbankToSoftbankメソッド
     *
     * getJphoneEmojiのエイリアス(出力時はJphoneコード)
     * ※可変関数を使用する都合上必要
     *
     * @return $softbankEmoji Docomo絵文字配列
     */
    public static function getSoftbankToSoftbank() {
        return self::getJphoneEmoji();
    }

    /**
     * getSoftbankToDocomoメソッド
     *
     * Softbank用の変換文字をキーにしたDocomo絵文字データ配列を返します。
     *
     * @return $softbankToDocomo Docomo絵文字配列
     */

    public static function getSoftbankToDocomo() {
        static $softbankToDocomo;

        if (!isset($softbankToDocomo)) {
            $softbankToDocomo["%s1%"] = "<span style=\"color:pink;\">&#xE6F0;</span>";    // わーい（嬉しい顔）
            $softbankToDocomo["%s2%"] = "<span style=\"color:pink;\">&#xE6F0;</span>";    // わーい（嬉しい顔）
            $softbankToDocomo["%s3%"] = "<span style=\"color:red;\">&#xE6F9;</span>";    // キスマーク
            $softbankToDocomo["%s4%"] = "<span style=\"color:pink;\">&#xE6F0;</span>";    // わーい（嬉しい顔）
            $softbankToDocomo["%s5%"] = "<span style=\"color:pink;\">&#xE6F0;</span>";    // わーい（嬉しい顔）
            $softbankToDocomo["%s6%"] = "<span style=\"color:blue;\">&#xE70E;</span>";    // Tシャツ（ボーダー）
            $softbankToDocomo["%s7%"] = "&#xE699;";    // くつ
            $softbankToDocomo["%s8%"] = "&#xE681;";    // カメラ
            $softbankToDocomo["%s9%"] = "&#xE687;";    // 電話
            $softbankToDocomo["%s10%"] = "&#xE688;";    // 携帯電話
            $softbankToDocomo["%s11%"] = "&#xE6D0;";    // fax to
            $softbankToDocomo["%s12%"] = "&#xE716;";    // パソコン
            $softbankToDocomo["%s13%"] = "<span style=\"color:red;\">&#xE6FD;</span>";    // パンチ
            $softbankToDocomo["%s14%"] = "<span style=\"color:orange;\">&#xE727;</span>";    // 指でOK
            $softbankToDocomo["%s15%"] = "[人差し指]";
            $softbankToDocomo["%s16%"] = "<span style=\"color:orange;\">&#xE693;</span>";    // 手（グー）
            $softbankToDocomo["%s17%"] = "<span style=\"color:orange;\">&#xE694;</span>";    // 手（チョキ）
            $softbankToDocomo["%s18%"] = "<span style=\"color:orange;\">&#xE695;</span>";    // 手（パー）
            $softbankToDocomo["%s19%"] = "<span style=\"color:blue;\">&#xE657;</span>";    // スキー
            $softbankToDocomo["%s20%"] = "<span style=\"color:blue;\">&#xE654;</span>";    // ゴルフ
            $softbankToDocomo["%s21%"] = "<span style=\"color:green;\">&#xE655;</span>";    // テニス
            $softbankToDocomo["%s22%"] = "&#xE653;";    // 野球
            $softbankToDocomo["%s23%"] = "<span style=\"color:blue;\">&#xE712;</span>";    // スノボ
            $softbankToDocomo["%s24%"] = "&#xE656;";    // サッカー
            $softbankToDocomo["%s25%"] = "<span style=\"color:blue;\">&#xE751;</span>";    // 魚
            $softbankToDocomo["%s26%"] = "<span style=\"color:salmon;\">&#xE754;</span>";    // ウマ
            $softbankToDocomo["%s27%"] = "&#xE65E;";    // 車（セダン）
            $softbankToDocomo["%s28%"] = "<span style=\"color:blue;\">&#xE6A3;</span>";    // リゾート
            $softbankToDocomo["%s29%"] = "<span style=\"color:blue;\">&#xE662;</span>";    // 飛行機
            $softbankToDocomo["%s30%"] = "<span style=\"color:green;\">&#xE65B;</span>";    // 電車
            $softbankToDocomo["%s31%"] = "<span style=\"color:blue;\">&#xE65D;</span>";    // 新幹線
            $softbankToDocomo["%s32%"] = "?";
            $softbankToDocomo["%s33%"] = "<span style=\"color:red;\">&#xE702;</span>";    // exclamation
            $softbankToDocomo["%s34%"] = "<span style=\"color:red;\">&#xE6EC;</span>";    // 黒ハート
            $softbankToDocomo["%s35%"] = "<span style=\"color:red;\">&#xE6EE;</span>";    // 失恋
            $softbankToDocomo["%s36%"] = "&#xE6BA;";    // 時計
            $softbankToDocomo["%s37%"] = "&#xE6BA;";    // 時計
            $softbankToDocomo["%s38%"] = "&#xE6BA;";    // 時計
            $softbankToDocomo["%s39%"] = "&#xE6BA;";    // 時計
            $softbankToDocomo["%s40%"] = "&#xE6BA;";    // 時計
            $softbankToDocomo["%s41%"] = "&#xE6BA;";    // 時計
            $softbankToDocomo["%s42%"] = "&#xE6BA;";    // 時計
            $softbankToDocomo["%s43%"] = "&#xE6BA;";    // 時計
            $softbankToDocomo["%s44%"] = "&#xE6BA;";    // 時計
            $softbankToDocomo["%s45%"] = "&#xE6BA;";    // 時計
            $softbankToDocomo["%s46%"] = "&#xE6BA;";    // 時計
            $softbankToDocomo["%s47%"] = "&#xE6BA;";    // 時計
            $softbankToDocomo["%s48%"] = "<span style=\"color:pink;\">&#xE748;</span>";    // 桜
            $softbankToDocomo["%s49%"] = "<span style=\"color:gold;\">&#xE71A;</span>";    // 王冠
            $softbankToDocomo["%s50%"] = "[ﾊﾞﾗ]";
            $softbankToDocomo["%s51%"] = "<span style=\"color:green;\">&#xE6A4;</span>";    // クリスマス
            $softbankToDocomo["%s52%"] = "<span style=\"color:plum;\">&#xE71B;</span>";    // 指輪
            $softbankToDocomo["%s53%"] = "<span style=\"color:plum;\">&#xE71B;</span>";    // 指輪
            $softbankToDocomo["%s54%"] = "<span style=\"color:red;\">&#xE663;</span>";    // 家
            $softbankToDocomo["%s55%"] = "[教会]";
            $softbankToDocomo["%s56%"] = "<span style=\"color:blue;\">&#xE664;</span>";    // ビル
            $softbankToDocomo["%s57%"] = "[駅]";
            $softbankToDocomo["%s58%"] = "<span style=\"color:plum;\">&#xE66B;</span>";    // ガソリンスタンド
            $softbankToDocomo["%s59%"] = "<span style=\"color:blue;\">&#xE740;</span>";    // 富士山
            $softbankToDocomo["%s60%"] = "&#xE676;";    // カラオケ
            $softbankToDocomo["%s61%"] = "&#xE677;";    // 映画
            $softbankToDocomo["%s62%"] = "<span style=\"color:red;\">&#xE6F6;</span>";    // るんるん
            $softbankToDocomo["%s63%"] = "<span style=\"color:red;\">&#xE6D9;</span>";    // パスワード
            $softbankToDocomo["%s64%"] = "[ﾊﾟｲﾌﾟ]";
            $softbankToDocomo["%s65%"] = "[ｷﾞﾀｰ]";
            $softbankToDocomo["%s66%"] = "[ﾄﾗﾝﾍﾟｯﾄ]";
            $softbankToDocomo["%s67%"] = "&#xE66F;";    // レストラン
            $softbankToDocomo["%s68%"] = "<span style=\"color:plum;\">&#xE671;</span>";    // バー
            $softbankToDocomo["%s69%"] = "<span style=\"color:green;\">&#xE670;</span>";    // 喫茶店
            $softbankToDocomo["%s70%"] = "<span style=\"color:red;\">&#xE74A;</span>";    // ショートケーキ
            $softbankToDocomo["%s71%"] = "<span style=\"color:gold;\">&#xE672;</span>";    // ビール
            $softbankToDocomo["%s72%"] = "<span style=\"color:blue;\">&#xE641;</span>";    // 雪
            $softbankToDocomo["%s73%"] = "<span style=\"color:blue;\">&#xE63F;</span>";    // 曇り
            $softbankToDocomo["%s74%"] = "<span style=\"color:red;\">&#xE63E;</span>";    // 晴れ
            $softbankToDocomo["%s75%"] = "<span style=\"color:blue;\">&#xE640;</span>";    // 雨
            $softbankToDocomo["%s76%"] = "&#xE69F;";    // 三日月
            $softbankToDocomo["%s77%"] = "<span style=\"color:red;\">&#xE63E;</span>";    // 晴れ
            $softbankToDocomo["%s78%"] = "[天使]";
            $softbankToDocomo["%s79%"] = "<span style=\"color:orange;\">&#xE6A2;</span>";    // 猫
            $softbankToDocomo["%s80%"] = "[ﾄﾗ]";
            $softbankToDocomo["%s81%"] = "[ｸﾏ]";
            $softbankToDocomo["%s82%"] = "<span style=\"color:orange;\">&#xE6A1;</span>";    // 犬
            $softbankToDocomo["%s83%"] = "[ﾈｽﾞﾐ]";
            $softbankToDocomo["%s84%"] = "[ｸｼﾞﾗ]";
            $softbankToDocomo["%s85%"] = "<span style=\"color:blue;\">&#xE750;</span>";    // ペンギン
            $softbankToDocomo["%s86%"] = "<span style=\"color:pink;\">&#xE6F0;</span>";    // わーい（嬉しい顔）
            $softbankToDocomo["%s87%"] = "<span style=\"color:pink;\">&#xE6F0;</span>";    // わーい（嬉しい顔）
            $softbankToDocomo["%s88%"] = "<span style=\"color:blue;\">&#xE6F2;</span>";    // がく～（落胆した顔）
            $softbankToDocomo["%s89%"] = "<span style=\"color:red;\">&#xE6F1;</span>";    // ちっ（怒った顔）
            $softbankToDocomo["%s90%"] = "[ｳﾝﾁ]";
            $softbankToDocomo["%s101%"] = "<span style=\"color:red;\">&#xE665;</span>";    // 郵便局
            $softbankToDocomo["%s102%"] = "<span style=\"color:red;\">&#xE665;</span>";    // 郵便局
            $softbankToDocomo["%s103%"] = "&#xE6CF;";    // mail to
            $softbankToDocomo["%s104%"] = "&#xE6CE;";    // phone to
            $softbankToDocomo["%s105%"] = "<span style=\"color:red;\">&#xE728;</span>";    // あっかんべー
            $softbankToDocomo["%s106%"] = "<span style=\"color:pink;\">&#xE726;</span>";    // 目がハート
            $softbankToDocomo["%s107%"] = "<span style=\"color:blueviolet;\">&#xE757;</span>";    // げっそり
            $softbankToDocomo["%s108%"] = "<span style=\"color:blue;\">&#xE723;</span>";    // 冷や汗2
            $softbankToDocomo["%s109%"] = "[ｻﾙ]";
            $softbankToDocomo["%s110%"] = "[ﾀｺ]";
            $softbankToDocomo["%s111%"] = "<span style=\"color:orange;\">&#xE755;</span>";    // ブタ
            $softbankToDocomo["%s112%"] = "[宇宙人]";
            $softbankToDocomo["%s113%"] = "[ﾛｹｯﾄ]";
            $softbankToDocomo["%s114%"] = "<span style=\"color:gold;\">&#xE71A;</span>";    // 王冠
            $softbankToDocomo["%s115%"] = "<span style=\"color:gold;\">&#xE6FB;</span>";    // ひらめき
            $softbankToDocomo["%s116%"] = "<span style=\"color:green;\">&#xE741;</span>";    // クローバー
            $softbankToDocomo["%s117%"] = "<span style=\"color:red;\">&#xE6F9;</span>";    // キスマーク
            $softbankToDocomo["%s118%"] = "<span style=\"color:red;\">&#xE685;</span>";    // プレゼント
            $softbankToDocomo["%s119%"] = "[ﾋﾟｽﾄﾙ]";
            $softbankToDocomo["%s120%"] = "<span style=\"color:blue;\">&#xE6DC;</span>";    // サーチ（調べる）
            $softbankToDocomo["%s121%"] = "&#xE733;";    // 走る人
            $softbankToDocomo["%s122%"] = "[ﾊﾝﾏｰ]";
            $softbankToDocomo["%s123%"] = "[花火]";
            $softbankToDocomo["%s124%"] = "<span style=\"color:red;\">&#xE747;</span>";    // もみじ
            $softbankToDocomo["%s125%"] = "[落ち葉]";
            $softbankToDocomo["%s126%"] = "[ｱｸﾏ]";
            $softbankToDocomo["%s127%"] = "[お化け]";
            $softbankToDocomo["%s128%"] = "[ﾄﾞｸﾛ]";
            $softbankToDocomo["%s129%"] = "[炎]";
            $softbankToDocomo["%s130%"] = "<span style=\"color:red;\">&#xE682;</span>";    // カバン
            $softbankToDocomo["%s131%"] = "&#xE6B2;";    // いす
            $softbankToDocomo["%s132%"] = "<span style=\"color:gold;\">&#xE673;</span>";    // ファーストフード
            $softbankToDocomo["%s133%"] = "[噴水]";
            $softbankToDocomo["%s134%"] = "[ｷｬﾝﾌﾟ]";
            $softbankToDocomo["%s135%"] = "<span style=\"color:red;\">&#xE6F7;</span>";    // いい気分（温泉）
            $softbankToDocomo["%s136%"] = "[観覧車]";
            $softbankToDocomo["%s137%"] = "<span style=\"color:gold;\">&#xE67E;</span>";    // チケット
            $softbankToDocomo["%s138%"] = "<span style=\"color:blue;\">&#xE68C;</span>";    // ＣＤ
            $softbankToDocomo["%s139%"] = "<span style=\"color:blue;\">&#xE68C;</span>";    // ＣＤ
            $softbankToDocomo["%s140%"] = "[ﾗｼﾞｵ]";
            $softbankToDocomo["%s141%"] = "[ﾋﾞﾃﾞｵ]";
            $softbankToDocomo["%s142%"] = "<span style=\"color:blue;\">&#xE68A;</span>";    // ＴＶ
            $softbankToDocomo["%s143%"] = "[宇宙人]";
            $softbankToDocomo["%s144%"] = "[指定]";
            $softbankToDocomo["%s145%"] = "[麻雀]";
            $softbankToDocomo["%s146%"] = "[VS]";
            $softbankToDocomo["%s147%"] = "<span style=\"color:salmon;\">&#xE715;</span>";    // ドル袋
            $softbankToDocomo["%s148%"] = "[的中]";
            $softbankToDocomo["%s149%"] = "[ﾄﾛﾌｨｰ]";
            $softbankToDocomo["%s150%"] = "&#xE659;";    // モータースポーツ
            $softbankToDocomo["%s151%"] = "[777]";
            $softbankToDocomo["%s152%"] = "<span style=\"color:salmon;\">&#xE754;</span>";    // ウマ
            $softbankToDocomo["%s153%"] = "<span style=\"color:blue;\">&#xE6A3;</span>";    // リゾート
            $softbankToDocomo["%s154%"] = "&#xE71D;";    // 自転車
            $softbankToDocomo["%s155%"] = "[工事中]";
            $softbankToDocomo["%s156%"] = "[♂]";
            $softbankToDocomo["%s157%"] = "[♀]";
            $softbankToDocomo["%s158%"] = "[赤ちゃん]";
            $softbankToDocomo["%s159%"] = "[注射]";
            $softbankToDocomo["%s160%"] = "<span style=\"color:blue;\">&#xE701;</span>";    // 眠い(睡眠)
            $softbankToDocomo["%s161%"] = "<span style=\"color:gold;\">&#xE642;</span>";    // 雷
            $softbankToDocomo["%s162%"] = "<span style=\"color:red;\">&#xE674;</span>";    // ブティック
            $softbankToDocomo["%s163%"] = "<span style=\"color:red;\">&#xE6F7;</span>";    // いい気分（温泉）
            $softbankToDocomo["%s164%"] = "&#xE66E;";    // トイレ
            $softbankToDocomo["%s165%"] = "[ｽﾋﾟｰｶ]";
            $softbankToDocomo["%s166%"] = "[ｽﾋﾟｰｶ]";
            $softbankToDocomo["%s167%"] = "[祝日]";
            $softbankToDocomo["%s168%"] = "<span style=\"color:red;\">&#xE6D9;</span>";    // パスワード
            $softbankToDocomo["%s169%"] = "<span style=\"color:red;\">&#xE6D9;</span>";    // パスワード
            $softbankToDocomo["%s170%"] = "[夕焼け]";
            $softbankToDocomo["%s171%"] = "[ﾌﾗｲﾊﾟﾝ]";
            $softbankToDocomo["%s172%"] = "<span style=\"color:gold;\">&#xE683;</span>";    // 本
            $softbankToDocomo["%s173%"] = "[$\]";
            $softbankToDocomo["%s174%"] = "[株価]";
            $softbankToDocomo["%s175%"] = "[ｱﾝﾃﾅ]";
            $softbankToDocomo["%s176%"] = "[力こぶ]";
            $softbankToDocomo["%s177%"] = "<span style=\"color:plum;\">&#xE667;</span>";    // 銀行
            $softbankToDocomo["%s178%"] = "&#xE66D;";    // 信号
            $softbankToDocomo["%s179%"] = "<span style=\"color:blue;\">&#xE66C;</span>";    // 駐車場
            $softbankToDocomo["%s180%"] = "[ﾊﾞｽ停]";
            $softbankToDocomo["%s181%"] = "&#xE66E;";    // トイレ
            $softbankToDocomo["%s182%"] = "[警官]";
            $softbankToDocomo["%s183%"] = "<span style=\"color:red;\">&#xE665;</span>";    // 郵便局
            $softbankToDocomo["%s184%"] = "<span style=\"color:red;\">&#xE668;</span>";    // ＡＴＭ
            $softbankToDocomo["%s185%"] = "<span style=\"color:red;\">&#xE666;</span>";    // 病院
            $softbankToDocomo["%s186%"] = "<span style=\"color:blue;\">&#xE66A;</span>";    // コンビニ
            $softbankToDocomo["%s187%"] = "<span style=\"color:green;\">&#xE73E;</span>";    // 学校
            $softbankToDocomo["%s188%"] = "<span style=\"color:green;\">&#xE669;</span>";    // ホテル
            $softbankToDocomo["%s189%"] = "<span style=\"color:red;\">&#xE660;</span>";    // バス
            $softbankToDocomo["%s190%"] = "&#xE65E;";    // 車（セダン）
            $softbankToDocomo["%s201%"] = "&#xE733;";    // 走る人
            $softbankToDocomo["%s202%"] = "<span style=\"color:blue;\">&#xE661;</span>";    // 船
            $softbankToDocomo["%s203%"] = "[ココ]";
            $softbankToDocomo["%s204%"] = "<span style=\"color:plum;\">&#xE6F8;</span>";    // かわいい
            $softbankToDocomo["%s205%"] = "<span style=\"color:plum;\">&#xE6F8;</span>";    // かわいい
            $softbankToDocomo["%s206%"] = "<span style=\"color:plum;\">&#xE6F8;</span>";    // かわいい
            $softbankToDocomo["%s207%"] = "[18禁]";
            $softbankToDocomo["%s208%"] = "<span style=\"color:red;\">&#xE680;</span>";    // 禁煙
            $softbankToDocomo["%s209%"] = "[若葉ﾏｰｸ]";
            $softbankToDocomo["%s210%"] = "<span style=\"color:blue;\">&#xE69B;</span>";    // 車椅子
            $softbankToDocomo["%s211%"] = "[ﾊﾞﾘ3]";
            $softbankToDocomo["%s212%"] = "<span style=\"color:red;\">&#xE68D;</span>";    // ハート
            $softbankToDocomo["%s213%"] = "<span style=\"color:red;\">&#xE68F;</span>";    // ダイヤ
            $softbankToDocomo["%s214%"] = "&#xE68E;";    // スペード
            $softbankToDocomo["%s215%"] = "&#xE690;";    // クラブ
            $softbankToDocomo["%s216%"] = "&#xE6E0;";    // シャープダイヤル
            $softbankToDocomo["%s217%"] = "&#xE6DF;";    // フリーダイヤル
            $softbankToDocomo["%s218%"] = "<span style=\"color:red;\">&#xE6DD;</span>";    // ＮＥＷ
            $softbankToDocomo["%s219%"] = "[UP]";
            $softbankToDocomo["%s220%"] = "[COOL]";
            $softbankToDocomo["%s221%"] = "[有]";
            $softbankToDocomo["%s222%"] = "[無]";
            $softbankToDocomo["%s223%"] = "[月]";
            $softbankToDocomo["%s224%"] = "[申]";
            $softbankToDocomo["%s225%"] = "&#xE69C;";    // 新月
            $softbankToDocomo["%s226%"] = "&#xE69C;";    // 新月
            $softbankToDocomo["%s227%"] = "&#xE69C;";    // 新月
            $softbankToDocomo["%s228%"] = "&#xE6E2;";    // 1
            $softbankToDocomo["%s229%"] = "&#xE6E3;";    // 2
            $softbankToDocomo["%s230%"] = "&#xE6E4;";    // 3
            $softbankToDocomo["%s231%"] = "&#xE6E5;";    // 4
            $softbankToDocomo["%s232%"] = "&#xE6E6;";    // 5
            $softbankToDocomo["%s233%"] = "&#xE6E7;";    // 6
            $softbankToDocomo["%s234%"] = "&#xE6E8;";    // 7
            $softbankToDocomo["%s235%"] = "&#xE6E9;";    // 8
            $softbankToDocomo["%s236%"] = "&#xE6EA;";    // 9
            $softbankToDocomo["%s237%"] = "&#xE6EB;";    // 0
            $softbankToDocomo["%s238%"] = "[得]";
            $softbankToDocomo["%s239%"] = "[割]";
            $softbankToDocomo["%s240%"] = "[ｻｰﾋﾞｽ]";
            $softbankToDocomo["%s241%"] = "<span style=\"color:red;\">&#xE6D8;</span>";    // ID
            $softbankToDocomo["%s242%"] = "<span style=\"color:red;\">&#xE73B;</span>";    // 満室・満席・満車
            $softbankToDocomo["%s243%"] = "<span style=\"color:blue;\">&#xE739;</span>";    // 空室・空席・空車
            $softbankToDocomo["%s244%"] = "[指]";
            $softbankToDocomo["%s245%"] = "[営]";
            $softbankToDocomo["%s246%"] = "↑";
            $softbankToDocomo["%s247%"] = "↓";
            $softbankToDocomo["%s248%"] = "←";
            $softbankToDocomo["%s249%"] = "→";
            $softbankToDocomo["%s250%"] = "↑";
            $softbankToDocomo["%s251%"] = "↓";
            $softbankToDocomo["%s252%"] = "→";
            $softbankToDocomo["%s253%"] = "←";
            $softbankToDocomo["%s254%"] = "&#xE678;";    // 右斜め上
            $softbankToDocomo["%s255%"] = "&#xE697;";    // 左斜め上
            $softbankToDocomo["%s256%"] = "&#xE696;";    // 右斜め下
            $softbankToDocomo["%s257%"] = "&#xE6A5;";    // 左斜め下
            $softbankToDocomo["%s258%"] = ">";
            $softbankToDocomo["%s259%"] = "<";
            $softbankToDocomo["%s260%"] = ">>";
            $softbankToDocomo["%s261%"] = "<<";
            $softbankToDocomo["%s262%"] = "[占い]";
            $softbankToDocomo["%s263%"] = "<span style=\"color:red;\">&#xE646;</span>";    // 牡羊座
            $softbankToDocomo["%s264%"] = "<span style=\"color:orange;\">&#xE647;</span>";    // 牡牛座
            $softbankToDocomo["%s265%"] = "<span style=\"color:green;\">&#xE648;</span>";    // 双子座
            $softbankToDocomo["%s266%"] = "<span style=\"color:blue;\">&#xE649;</span>";    // 蟹座
            $softbankToDocomo["%s267%"] = "<span style=\"color:red;\">&#xE64A;</span>";    // 獅子座
            $softbankToDocomo["%s268%"] = "<span style=\"color:orange;\">&#xE64B;</span>";    // 乙女座
            $softbankToDocomo["%s269%"] = "<span style=\"color:green;\">&#xE64C;</span>";    // 天秤座
            $softbankToDocomo["%s270%"] = "<span style=\"color:blue;\">&#xE64D;</span>";    // 蠍座
            $softbankToDocomo["%s271%"] = "<span style=\"color:red;\">&#xE64E;</span>";    // 射手座
            $softbankToDocomo["%s272%"] = "<span style=\"color:orange;\">&#xE64F;</span>";    // 山羊座
            $softbankToDocomo["%s273%"] = "<span style=\"color:green;\">&#xE650;</span>";    // 水瓶座
            $softbankToDocomo["%s274%"] = "<span style=\"color:blue;\">&#xE651;</span>";    // 魚座
            $softbankToDocomo["%s275%"] = "[蛇使座]";
            $softbankToDocomo["%s276%"] = "[TOP]";
            $softbankToDocomo["%s277%"] = "<span style=\"color:red;\">&#xE70B;</span>";    // 決定
            $softbankToDocomo["%s278%"] = "&#xE731;";    // コピーライト
            $softbankToDocomo["%s279%"] = "&#xE736;";    // レジスタードトレードマーク
            $softbankToDocomo["%s280%"] = "[ﾏﾅｰﾓｰﾄﾞ]";
            $softbankToDocomo["%s281%"] = "[ｹｰﾀｲOFF]";
            $softbankToDocomo["%s282%"] = "<span style=\"color:orange;\">&#xE737;</span>";    // 危険・警告
            $softbankToDocomo["%s283%"] = "[家庭教師]";
            $softbankToDocomo["%s285%"] = "[土星]";
            $softbankToDocomo["%s286%"] = "[紙飛行機]";
            $softbankToDocomo["%s287%"] = "[紙飛行機]";
            $softbankToDocomo["%s301%"] = "<span style=\"color:gold;\">&#xE689;</span>";    // メモ
            $softbankToDocomo["%s302%"] = "[ﾈｸﾀｲ]";
            $softbankToDocomo["%s303%"] = "[ﾊｲﾋﾞｽｶｽ]";
            $softbankToDocomo["%s304%"] = "<span style=\"color:red;\">&#xE743;</span>";    // チューリップ
            $softbankToDocomo["%s305%"] = "[ひまわり]";
            $softbankToDocomo["%s306%"] = "[花束]";
            $softbankToDocomo["%s307%"] = "[ﾋﾞｰﾁ]";
            $softbankToDocomo["%s308%"] = "[ｻﾎﾞﾃﾝ]";
            $softbankToDocomo["%s309%"] = "[WC]";
            $softbankToDocomo["%s310%"] = "<span style=\"color:blue;\">&#xE67A;</span>";    // 音楽
            $softbankToDocomo["%s311%"] = "<span style=\"color:salmon;\">&#xE74B;</span>";    // とっくり（おちょこ付き）
            $softbankToDocomo["%s312%"] = "<span style=\"color:gold;\">&#xE672;</span>";    // ビール
            $softbankToDocomo["%s313%"] = "[祝]";
            $softbankToDocomo["%s314%"] = "&#xE67F;";    // 喫煙
            $softbankToDocomo["%s315%"] = "[薬]";
            $softbankToDocomo["%s316%"] = "[風船]";
            $softbankToDocomo["%s317%"] = "&#xE6FE;";    // 爆弾
            $softbankToDocomo["%s318%"] = "[ｸﾗｯｶｰ]";
            $softbankToDocomo["%s319%"] = "<span style=\"color:blue;\">&#xE675;</span>";    // 美容院
            $softbankToDocomo["%s320%"] = "<span style=\"color:red;\">&#xE684;</span>";    // リボン
            $softbankToDocomo["%s321%"] = "<span style=\"color:red;\">&#xE734;</span>";    // マル秘
            $softbankToDocomo["%s322%"] = "[ﾌﾛｯﾋﾟｰ]";
            $softbankToDocomo["%s323%"] = "[ｽﾋﾟｰｶ]";
            $softbankToDocomo["%s324%"] = "[帽子]";
            $softbankToDocomo["%s325%"] = "[ﾄﾞﾚｽ]";
            $softbankToDocomo["%s326%"] = "<span style=\"color:red;\">&#xE674;</span>";    // ブティック
            $softbankToDocomo["%s327%"] = "[ﾌﾞｰﾂ]";
            $softbankToDocomo["%s328%"] = "<span style=\"color:red;\">&#xE710;</span>";    // 化粧
            $softbankToDocomo["%s329%"] = "[ﾏﾆｷｭｱ]";
            $softbankToDocomo["%s330%"] = "[ｴｽﾃ]";
            $softbankToDocomo["%s331%"] = "<span style=\"color:blue;\">&#xE675;</span>";    // 美容院
            $softbankToDocomo["%s332%"] = "[床屋]";
            $softbankToDocomo["%s333%"] = "[着物]";
            $softbankToDocomo["%s334%"] = "[ﾋﾞｷﾆ]";
            $softbankToDocomo["%s335%"] = "<span style=\"color:red;\">&#xE682;</span>";    // カバン
            $softbankToDocomo["%s336%"] = "&#xE6AC;";    // カチンコ
            $softbankToDocomo["%s337%"] = "<span style=\"color:gold;\">&#xE713;</span>";    // チャペル
            $softbankToDocomo["%s338%"] = "<span style=\"color:red;\">&#xE6FF;</span>";    // ムード
            $softbankToDocomo["%s339%"] = "<span style=\"color:red;\">&#xE6EC;</span>";    // 黒ハート
            $softbankToDocomo["%s340%"] = "<span style=\"color:red;\">&#xE6ED;</span>";    // 揺れるハート
            $softbankToDocomo["%s341%"] = "<span style=\"color:red;\">&#xE6EC;</span>";    // 黒ハート
            $softbankToDocomo["%s342%"] = "<span style=\"color:red;\">&#xE6EC;</span>";    // 黒ハート
            $softbankToDocomo["%s343%"] = "<span style=\"color:red;\">&#xE6EC;</span>";    // 黒ハート
            $softbankToDocomo["%s344%"] = "<span style=\"color:red;\">&#xE6EC;</span>";    // 黒ハート
            $softbankToDocomo["%s345%"] = "<span style=\"color:red;\">&#xE6EC;</span>";    // 黒ハート
            $softbankToDocomo["%s346%"] = "<span style=\"color:gold;\">&#xE6FA;</span>";    // ぴかぴか（新しい）
            $softbankToDocomo["%s347%"] = "☆";
            $softbankToDocomo["%s348%"] = "&#xE708;";    // ダッシュ（走り出すさま）
            $softbankToDocomo["%s349%"] = "&#xE706;";    // あせあせ（飛び散る汗）
            $softbankToDocomo["%s350%"] = "&#xE6A0;";    // 満月
            $softbankToDocomo["%s351%"] = "×";
            $softbankToDocomo["%s352%"] = "&#xE6FC;";    // むかっ（怒り）
            $softbankToDocomo["%s353%"] = "☆";
            $softbankToDocomo["%s354%"] = "?";
            $softbankToDocomo["%s355%"] = "<span style=\"color:red;\">&#xE702;</span>";    // exclamation
            $softbankToDocomo["%s356%"] = "<span style=\"color:green;\">&#xE71E;</span>";    // 湯のみ
            $softbankToDocomo["%s357%"] = "<span style=\"color:salmon;\">&#xE74D;</span>";    // パン
            $softbankToDocomo["%s358%"] = "[ｿﾌﾄｸﾘｰﾑ]";
            $softbankToDocomo["%s359%"] = "[ﾎﾟﾃﾄ]";
            $softbankToDocomo["%s360%"] = "[だんご]";
            $softbankToDocomo["%s361%"] = "[せんべい]";
            $softbankToDocomo["%s362%"] = "<span style=\"color:gold;\">&#xE74C;</span>";    // どんぶり
            $softbankToDocomo["%s363%"] = "[ﾊﾟｽﾀ]";
            $softbankToDocomo["%s364%"] = "<span style=\"color:gold;\">&#xE74C;</span>";    // どんぶり
            $softbankToDocomo["%s365%"] = "[ｶﾚｰ]";
            $softbankToDocomo["%s366%"] = "&#xE749;";    // おにぎり
            $softbankToDocomo["%s367%"] = "[おでん]";
            $softbankToDocomo["%s368%"] = "[すし]";
            $softbankToDocomo["%s369%"] = "<span style=\"color:red;\">&#xE745;</span>";    // りんご
            $softbankToDocomo["%s370%"] = "[みかん]";
            $softbankToDocomo["%s371%"] = "[ｲﾁｺﾞ]";
            $softbankToDocomo["%s372%"] = "[ｽｲｶ]";
            $softbankToDocomo["%s373%"] = "[ﾄﾏﾄ]";
            $softbankToDocomo["%s374%"] = "[ﾅｽ]";
            $softbankToDocomo["%s375%"] = "<span style=\"color:red;\">&#xE686;</span>";    // バースデー
            $softbankToDocomo["%s376%"] = "[弁当]";
            $softbankToDocomo["%s377%"] = "[鍋]";
            $softbankToDocomo["%s401%"] = "<span style=\"color:blue;\">&#xE723;</span>";    // 冷や汗2
            $softbankToDocomo["%s402%"] = "<span style=\"color:orange;\">&#xE72C;</span>";    // 猫2
            $softbankToDocomo["%s403%"] = "<span style=\"color:green;\">&#xE720;</span>";    // 考えてる顔
            $softbankToDocomo["%s404%"] = "<span style=\"color:orange;\">&#xE753;</span>";    // ウッシッシ
            $softbankToDocomo["%s405%"] = "<span style=\"color:pink;\">&#xE729;</span>";    // ウィンク
            $softbankToDocomo["%s406%"] = "<span style=\"color:blue;\">&#xE72B;</span>";    // がまん顔
            $softbankToDocomo["%s407%"] = "<span style=\"color:green;\">&#xE6F3;</span>";    // もうやだ～（悲しい顔）
            $softbankToDocomo["%s408%"] = "<span style=\"color:blue;\">&#xE701;</span>";    // 眠い(睡眠)
            $softbankToDocomo["%s409%"] = "<span style=\"color:red;\">&#xE728;</span>";    // あっかんべー
            $softbankToDocomo["%s410%"] = "<span style=\"color:pink;\">&#xE721;</span>";    // ほっとした顔
            $softbankToDocomo["%s411%"] = "<span style=\"color:blueviolet;\">&#xE757;</span>";    // げっそり
            $softbankToDocomo["%s412%"] = "[風邪ひき]";
            $softbankToDocomo["%s413%"] = "<span style=\"color:pink;\">&#xE72A;</span>";    // うれしい顔
            $softbankToDocomo["%s414%"] = "<span style=\"color:blueviolet;\">&#xE725;</span>";    // ボケーっとした顔
            $softbankToDocomo["%s415%"] = "<span style=\"color:blue;\">&#xE723;</span>";    // 冷や汗2
            $softbankToDocomo["%s416%"] = "<span style=\"color:blue;\">&#xE6F4;</span>";    // ふらふら
            $softbankToDocomo["%s417%"] = "<span style=\"color:blue;\">&#xE72D;</span>";    // 泣き顔
            $softbankToDocomo["%s418%"] = "<span style=\"color:pink;\">&#xE6F0;</span><span style=\"color:blue;\">&#xE72D;</span>";    // わーい（嬉しい顔） 泣き顔
            $softbankToDocomo["%s419%"] = "<span style=\"color:blue;\">&#xE72E;</span>";    // 涙
            $softbankToDocomo["%s420%"] = "<span style=\"color:pink;\">&#xE6F0;</span>";    // わーい（嬉しい顔）
            $softbankToDocomo["%s421%"] = "<span style=\"color:pink;\">&#xE6F0;</span>";    // わーい（嬉しい顔）
            $softbankToDocomo["%s422%"] = "<span style=\"color:red;\">&#xE724;</span>";    // ぷっくっくな顔
            $softbankToDocomo["%s423%"] = "<span style=\"color:pink;\">&#xE726;</span>";    // 目がハート
            $softbankToDocomo["%s424%"] = "<span style=\"color:pink;\">&#xE726;</span>";    // 目がハート
            $softbankToDocomo["%s425%"] = "&#xE691;";    // 目
            $softbankToDocomo["%s426%"] = "[鼻]";
            $softbankToDocomo["%s427%"] = "<span style=\"color:orange;\">&#xE692;</span>";    // 耳
            $softbankToDocomo["%s428%"] = "<span style=\"color:red;\">&#xE6F9;</span>";    // キスマーク
            $softbankToDocomo["%s429%"] = "(>人<)";
            $softbankToDocomo["%s430%"] = "<span style=\"color:orange;\">&#xE695;</span>";    // 手（パー）
            $softbankToDocomo["%s431%"] = "[拍手]";
            $softbankToDocomo["%s432%"] = "<span style=\"color:red;\">&#xE70B;</span>";    // 決定
            $softbankToDocomo["%s433%"] = "<span style=\"color:blue;\">&#xE700;</span>";    // バッド（下向き矢印）
            $softbankToDocomo["%s434%"] = "<span style=\"color:orange;\">&#xE695;</span>";    // 手（パー）
            $softbankToDocomo["%s435%"] = "<span style=\"color:red;\">&#xE72F;</span>";    // NG
            $softbankToDocomo["%s436%"] = "<span style=\"color:red;\">&#xE70B;</span>";    // 決定
            $softbankToDocomo["%s437%"] = "<span style=\"color:red;\">&#xE6ED;</span>";    // 揺れるハート
            $softbankToDocomo["%s438%"] = "[m(_ _)m]";
            $softbankToDocomo["%s439%"] = "[＼(^o^)／]";
            $softbankToDocomo["%s440%"] = "[ｶｯﾌﾟﾙ]";
            $softbankToDocomo["%s441%"] = "[ﾊﾞﾆｰ]";
            $softbankToDocomo["%s442%"] = "<span style=\"color:gold;\">&#xE658;</span>";    // バスケットボール
            $softbankToDocomo["%s443%"] = "[ﾌｯﾄﾎﾞｰﾙ]";
            $softbankToDocomo["%s444%"] = "[ﾋﾞﾘﾔｰﾄﾞ]";
            $softbankToDocomo["%s445%"] = "[水泳]";
            $softbankToDocomo["%s446%"] = "<span style=\"color:green;\">&#xE65F;</span>";    // 車（ＲＶ）
            $softbankToDocomo["%s447%"] = "[ﾄﾗｯｸ]";
            $softbankToDocomo["%s448%"] = "[消防車]";
            $softbankToDocomo["%s449%"] = "[救急車]";
            $softbankToDocomo["%s450%"] = "[ﾊﾟﾄｶｰ]";
            $softbankToDocomo["%s451%"] = "[ｼﾞｪｯﾄｺｰｽﾀｰ]";
            $softbankToDocomo["%s452%"] = "<span style=\"color:orange;\">&#xE65C;</span>";    // 地下鉄
            $softbankToDocomo["%s453%"] = "<span style=\"color:blue;\">&#xE65D;</span>";    // 新幹線
            $softbankToDocomo["%s454%"] = "[門松]";
            $softbankToDocomo["%s455%"] = "[ﾌﾟﾚｾﾞﾝﾄ]";
            $softbankToDocomo["%s456%"] = "[ひな祭り]";
            $softbankToDocomo["%s457%"] = "[卒業式]";
            $softbankToDocomo["%s458%"] = "[ﾗﾝﾄﾞｾﾙ]";
            $softbankToDocomo["%s459%"] = "[こいのぼり]";
            $softbankToDocomo["%s460%"] = "<span style=\"color:blue;\">&#xE645;</span>";    // 小雨
            $softbankToDocomo["%s461%"] = "[教会]";
            $softbankToDocomo["%s462%"] = "<span style=\"color:blue;\">&#xE73F;</span>";    // 波
            $softbankToDocomo["%s463%"] = "[ｶｷ氷]";
            $softbankToDocomo["%s464%"] = "[線香花火]";
            $softbankToDocomo["%s465%"] = "[巻貝]";
            $softbankToDocomo["%s466%"] = "[風鈴]";
            $softbankToDocomo["%s467%"] = "<span style=\"color:red;\">&#xE643;</span>";    // 台風
            $softbankToDocomo["%s468%"] = "[稲]";
            $softbankToDocomo["%s469%"] = "[ﾊﾛｳｨﾝ]";
            $softbankToDocomo["%s470%"] = "[お月見]";
            $softbankToDocomo["%s471%"] = "<span style=\"color:red;\">&#xE747;</span>";    // もみじ
            $softbankToDocomo["%s472%"] = "[ｻﾝﾀ]";
            $softbankToDocomo["%s473%"] = "<span style=\"color:red;\">&#xE63E;</span>";    // 晴れ
            $softbankToDocomo["%s474%"] = "<span style=\"color:red;\">&#xE63E;</span>";    // 晴れ
            $softbankToDocomo["%s475%"] = "&#xE6B3;";    // 夜
            $softbankToDocomo["%s476%"] = "[虹]";
            $softbankToDocomo["%s501%"] = "<span style=\"color:green;\">&#xE669;</span><span style=\"color:red;\">&#xE6EF;</span>";    // ホテル ハートたち（複数ハート）
            $softbankToDocomo["%s502%"] = "<span style=\"color:plum;\">&#xE67B;</span>";    // アート
            $softbankToDocomo["%s503%"] = "&#xE67C;";    // 演劇
            $softbankToDocomo["%s504%"] = "[ﾃﾞﾊﾟｰﾄ]";
            $softbankToDocomo["%s505%"] = "[城]";
            $softbankToDocomo["%s506%"] = "[城]";
            $softbankToDocomo["%s507%"] = "&#xE677;";    // 映画
            $softbankToDocomo["%s508%"] = "[工場]";
            $softbankToDocomo["%s509%"] = "[東京ﾀﾜｰ]";
            $softbankToDocomo["%s510%"] = "[ﾛｹｯﾄ]";
            $softbankToDocomo["%s511%"] = "[日の丸]";
            $softbankToDocomo["%s512%"] = "[USA]";
            $softbankToDocomo["%s513%"] = "[ﾌﾗﾝｽ]";
            $softbankToDocomo["%s514%"] = "[ﾄﾞｲﾂ]";
            $softbankToDocomo["%s515%"] = "[ｲﾀﾘｱ]";
            $softbankToDocomo["%s516%"] = "[ｲｷﾞﾘｽ]";
            $softbankToDocomo["%s517%"] = "[ｽﾍﾟｲﾝ]";
            $softbankToDocomo["%s518%"] = "[ﾛｼｱ]";
            $softbankToDocomo["%s519%"] = "[中国]";
            $softbankToDocomo["%s520%"] = "[韓国]";
            $softbankToDocomo["%s521%"] = "[白人]";
            $softbankToDocomo["%s522%"] = "[中国人]";
            $softbankToDocomo["%s523%"] = "[ｲﾝﾄﾞ人]";
            $softbankToDocomo["%s524%"] = "[おじいさん]";
            $softbankToDocomo["%s525%"] = "[おばあさん]";
            $softbankToDocomo["%s526%"] = "[赤ちゃん]";
            $softbankToDocomo["%s527%"] = "[工事現場の人]";
            $softbankToDocomo["%s528%"] = "[お姫様]";
            $softbankToDocomo["%s529%"] = "[自由の女神]";
            $softbankToDocomo["%s530%"] = "[兵隊]";
            $softbankToDocomo["%s531%"] = "[ﾀﾞﾝｽ]";
            $softbankToDocomo["%s532%"] = "[ｲﾙｶ]";
            $softbankToDocomo["%s533%"] = "<span style=\"color:gold;\">&#xE74F;</span>";    // ひよこ
            $softbankToDocomo["%s534%"] = "<span style=\"color:blue;\">&#xE751;</span>";    // 魚
            $softbankToDocomo["%s535%"] = "<span style=\"color:gold;\">&#xE74F;</span>";    // ひよこ
            $softbankToDocomo["%s536%"] = "<span style=\"color:orange;\">&#xE6A1;</span>";    // 犬
            $softbankToDocomo["%s537%"] = "[ｹﾞｼﾞｹﾞｼﾞ]";
            $softbankToDocomo["%s538%"] = "[ｿﾞｳ]";
            $softbankToDocomo["%s539%"] = "[ｺｱﾗ]";
            $softbankToDocomo["%s540%"] = "[ｻﾙ]";
            $softbankToDocomo["%s541%"] = "<span style=\"color:red;\">&#xE646;</span>";    // 牡羊座
            $softbankToDocomo["%s542%"] = "<span style=\"color:orange;\">&#xE6A1;</span>";    // 犬
            $softbankToDocomo["%s543%"] = "[牛]";
            $softbankToDocomo["%s544%"] = "[ｳｻｷﾞ]";
            $softbankToDocomo["%s545%"] = "[ﾍﾋﾞ]";
            $softbankToDocomo["%s546%"] = "[ﾆﾜﾄﾘ]";
            $softbankToDocomo["%s547%"] = "[ｲﾉｼｼ]";
            $softbankToDocomo["%s548%"] = "[ﾗｸﾀﾞ]";
            $softbankToDocomo["%s549%"] = "[ｶｴﾙ]";
            $softbankToDocomo["%s550%"] = "[A]";
            $softbankToDocomo["%s551%"] = "[B]";
            $softbankToDocomo["%s552%"] = "[AB]";
            $softbankToDocomo["%s553%"] = "[O]";
            $softbankToDocomo["%s554%"] = "<span style=\"color:orange;\">&#xE698;</span>";    // 足
            $softbankToDocomo["%s555%"] = "&#xE732;";    // トレードマーク
        }

        return $softbankToDocomo;
    }

    /**
     * getSoftbankToEzwebメソッド
     *
     * Softbank用の変換文字をキーにしたEzweb絵文字データ配列を返します。
     *
     * @return $softbankToEzweb Ezweb絵文字配列
     */

    public static function getSoftbankToEzweb() {
        static $softbankToEzweb;

        if (!isset($softbankToEzweb)) {
            $softbankToEzweb["%s1%"] = "<IMG LOCALSRC=80>";
            $softbankToEzweb["%s2%"] = "<IMG LOCALSRC=50>";
            $softbankToEzweb["%s3%"] = "<IMG LOCALSRC=273>";
            $softbankToEzweb["%s4%"] = "<IMG LOCALSRC=80>";
            $softbankToEzweb["%s5%"] = "<IMG LOCALSRC=50>";
            $softbankToEzweb["%s6%"] = "<IMG LOCALSRC=335>";
            $softbankToEzweb["%s7%"] = "<IMG LOCALSRC=336>";
            $softbankToEzweb["%s8%"] = "<IMG LOCALSRC=94>";
            $softbankToEzweb["%s9%"] = "<IMG LOCALSRC=85>";
            $softbankToEzweb["%s10%"] = "<IMG LOCALSRC=161>";
            $softbankToEzweb["%s11%"] = "<IMG LOCALSRC=166>";
            $softbankToEzweb["%s12%"] = "<IMG LOCALSRC=337>";
            $softbankToEzweb["%s13%"] = "<IMG LOCALSRC=281>";
            $softbankToEzweb["%s14%"] = "<IMG LOCALSRC=287>";
            $softbankToEzweb["%s15%"] = "<IMG LOCALSRC=284>";
            $softbankToEzweb["%s16%"] = "<IMG LOCALSRC=817>";
            $softbankToEzweb["%s17%"] = "<IMG LOCALSRC=319>";
            $softbankToEzweb["%s18%"] = "<IMG LOCALSRC=320>";
            $softbankToEzweb["%s19%"] = "<IMG LOCALSRC=421>";
            $softbankToEzweb["%s20%"] = "<IMG LOCALSRC=306>";
            $softbankToEzweb["%s21%"] = "<IMG LOCALSRC=220>";
            $softbankToEzweb["%s22%"] = "<IMG LOCALSRC=45>";
            $softbankToEzweb["%s23%"] = "<IMG LOCALSRC=751>";
            $softbankToEzweb["%s24%"] = "<IMG LOCALSRC=219>";
            $softbankToEzweb["%s25%"] = "<IMG LOCALSRC=203>";
            $softbankToEzweb["%s26%"] = "<IMG LOCALSRC=248>";
            $softbankToEzweb["%s27%"] = "<IMG LOCALSRC=125>";
            $softbankToEzweb["%s28%"] = "<IMG LOCALSRC=169>";
            $softbankToEzweb["%s29%"] = "<IMG LOCALSRC=168>";
            $softbankToEzweb["%s30%"] = "<IMG LOCALSRC=172>";
            $softbankToEzweb["%s31%"] = "<IMG LOCALSRC=217>";
            $softbankToEzweb["%s32%"] = "<IMG LOCALSRC=3>";
            $softbankToEzweb["%s33%"] = "<IMG LOCALSRC=2>";
            $softbankToEzweb["%s34%"] = "<IMG LOCALSRC=51>";
            $softbankToEzweb["%s35%"] = "<IMG LOCALSRC=265>";
            $softbankToEzweb["%s36%"] = "<IMG LOCALSRC=46>";
            $softbankToEzweb["%s37%"] = "<IMG LOCALSRC=46>";
            $softbankToEzweb["%s38%"] = "<IMG LOCALSRC=46>";
            $softbankToEzweb["%s39%"] = "<IMG LOCALSRC=46>";
            $softbankToEzweb["%s40%"] = "<IMG LOCALSRC=46>";
            $softbankToEzweb["%s41%"] = "<IMG LOCALSRC=46>";
            $softbankToEzweb["%s42%"] = "<IMG LOCALSRC=46>";
            $softbankToEzweb["%s43%"] = "<IMG LOCALSRC=46>";
            $softbankToEzweb["%s44%"] = "<IMG LOCALSRC=46>";
            $softbankToEzweb["%s45%"] = "<IMG LOCALSRC=46>";
            $softbankToEzweb["%s46%"] = "<IMG LOCALSRC=46>";
            $softbankToEzweb["%s47%"] = "<IMG LOCALSRC=46>";
            $softbankToEzweb["%s48%"] = "<IMG LOCALSRC=235>";
            $softbankToEzweb["%s49%"] = "<IMG LOCALSRC=354>";
            $softbankToEzweb["%s50%"] = "<IMG LOCALSRC=339>";
            $softbankToEzweb["%s51%"] = "<IMG LOCALSRC=234>";
            $softbankToEzweb["%s52%"] = "<IMG LOCALSRC=72>";
            $softbankToEzweb["%s53%"] = "<IMG LOCALSRC=72>";
            $softbankToEzweb["%s54%"] = "<IMG LOCALSRC=112>";
            $softbankToEzweb["%s55%"] = "<IMG LOCALSRC=340>";
            $softbankToEzweb["%s56%"] = "<IMG LOCALSRC=156>";
            $softbankToEzweb["%s57%"] = "<IMG LOCALSRC=795>";
            $softbankToEzweb["%s58%"] = "<IMG LOCALSRC=213>";
            $softbankToEzweb["%s59%"] = "<IMG LOCALSRC=342>";
            $softbankToEzweb["%s60%"] = "<IMG LOCALSRC=289>";
            $softbankToEzweb["%s61%"] = "<IMG LOCALSRC=110>";
            $softbankToEzweb["%s62%"] = "<IMG LOCALSRC=343>";
            $softbankToEzweb["%s63%"] = "<IMG LOCALSRC=120>";
            $softbankToEzweb["%s64%"] = "[ﾊﾟｲﾌﾟ]";
            $softbankToEzweb["%s65%"] = "<IMG LOCALSRC=292>";
            $softbankToEzweb["%s66%"] = "<IMG LOCALSRC=469>";
            $softbankToEzweb["%s67%"] = "<IMG LOCALSRC=146>";
            $softbankToEzweb["%s68%"] = "<IMG LOCALSRC=52>";
            $softbankToEzweb["%s69%"] = "<IMG LOCALSRC=93>";
            $softbankToEzweb["%s70%"] = "<IMG LOCALSRC=239>";
            $softbankToEzweb["%s71%"] = "<IMG LOCALSRC=65>";
            $softbankToEzweb["%s72%"] = "<IMG LOCALSRC=191>";
            $softbankToEzweb["%s73%"] = "<IMG LOCALSRC=107>";
            $softbankToEzweb["%s74%"] = "<IMG LOCALSRC=44>";
            $softbankToEzweb["%s75%"] = "<IMG LOCALSRC=95>";
            $softbankToEzweb["%s76%"] = "<IMG LOCALSRC=15>";
            $softbankToEzweb["%s77%"] = "<IMG LOCALSRC=493>";
            $softbankToEzweb["%s78%"] = "<IMG LOCALSRC=344>";
            $softbankToEzweb["%s79%"] = "<IMG LOCALSRC=251>";
            $softbankToEzweb["%s80%"] = "<IMG LOCALSRC=345>";
            $softbankToEzweb["%s81%"] = "<IMG LOCALSRC=346>";
            $softbankToEzweb["%s82%"] = "<IMG LOCALSRC=134>";
            $softbankToEzweb["%s83%"] = "<IMG LOCALSRC=347>";
            $softbankToEzweb["%s84%"] = "<IMG LOCALSRC=246>";
            $softbankToEzweb["%s85%"] = "<IMG LOCALSRC=252>";
            $softbankToEzweb["%s86%"] = "<IMG LOCALSRC=454>";
            $softbankToEzweb["%s87%"] = "<IMG LOCALSRC=257>";
            $softbankToEzweb["%s88%"] = "<IMG LOCALSRC=444>";
            $softbankToEzweb["%s89%"] = "<IMG LOCALSRC=258>";
            $softbankToEzweb["%s90%"] = "<IMG LOCALSRC=283>";
            $softbankToEzweb["%s101%"] = "<IMG LOCALSRC=129>";
            $softbankToEzweb["%s102%"] = "<IMG LOCALSRC=129>";
            $softbankToEzweb["%s103%"] = "<IMG LOCALSRC=784>";
            $softbankToEzweb["%s104%"] = "<IMG LOCALSRC=513>";
            $softbankToEzweb["%s105%"] = "<IMG LOCALSRC=264>";
            $softbankToEzweb["%s106%"] = "<IMG LOCALSRC=349>";
            $softbankToEzweb["%s107%"] = "<IMG LOCALSRC=350>";
            $softbankToEzweb["%s108%"] = "<IMG LOCALSRC=351>";
            $softbankToEzweb["%s109%"] = "<IMG LOCALSRC=249>";
            $softbankToEzweb["%s110%"] = "<IMG LOCALSRC=352>";
            $softbankToEzweb["%s111%"] = "<IMG LOCALSRC=254>";
            $softbankToEzweb["%s112%"] = "<IMG LOCALSRC=274>";
            $softbankToEzweb["%s113%"] = "<IMG LOCALSRC=353>";
            $softbankToEzweb["%s114%"] = "<IMG LOCALSRC=354>";
            $softbankToEzweb["%s115%"] = "<IMG LOCALSRC=77>";
            $softbankToEzweb["%s116%"] = "<IMG LOCALSRC=53>";
            $softbankToEzweb["%s117%"] = "<IMG LOCALSRC=355>";
            $softbankToEzweb["%s118%"] = "<IMG LOCALSRC=144>";
            $softbankToEzweb["%s119%"] = "<IMG LOCALSRC=296>";
            $softbankToEzweb["%s120%"] = "<IMG LOCALSRC=119>";
            $softbankToEzweb["%s121%"] = "<IMG LOCALSRC=218>";
            $softbankToEzweb["%s122%"] = "<IMG LOCALSRC=356>";
            $softbankToEzweb["%s123%"] = "<IMG LOCALSRC=357>";
            $softbankToEzweb["%s124%"] = "<IMG LOCALSRC=133>";
            $softbankToEzweb["%s125%"] = "<IMG LOCALSRC=358>";
            $softbankToEzweb["%s126%"] = "<IMG LOCALSRC=277>";
            $softbankToEzweb["%s127%"] = "<IMG LOCALSRC=236>";
            $softbankToEzweb["%s128%"] = "<IMG LOCALSRC=286>";
            $softbankToEzweb["%s129%"] = "<IMG LOCALSRC=269>";
            $softbankToEzweb["%s130%"] = "<IMG LOCALSRC=359>";
            $softbankToEzweb["%s131%"] = "[いす]";
            $softbankToEzweb["%s132%"] = "<IMG LOCALSRC=245>";
            $softbankToEzweb["%s133%"] = "<IMG LOCALSRC=360>";
            $softbankToEzweb["%s134%"] = "<IMG LOCALSRC=361>";
            $softbankToEzweb["%s135%"] = "<IMG LOCALSRC=224>";
            $softbankToEzweb["%s136%"] = "<IMG LOCALSRC=223>";
            $softbankToEzweb["%s137%"] = "<IMG LOCALSRC=106>";
            $softbankToEzweb["%s138%"] = "<IMG LOCALSRC=300>";
            $softbankToEzweb["%s139%"] = "<IMG LOCALSRC=300>";
            $softbankToEzweb["%s140%"] = "<IMG LOCALSRC=338>";
            $softbankToEzweb["%s141%"] = "<IMG LOCALSRC=115>";
            $softbankToEzweb["%s142%"] = "<IMG LOCALSRC=288>";
            $softbankToEzweb["%s143%"] = "<IMG LOCALSRC=274>";
            $softbankToEzweb["%s144%"] = "[指定]";
            $softbankToEzweb["%s145%"] = "<IMG LOCALSRC=362>";
            $softbankToEzweb["%s146%"] = "<IMG LOCALSRC=363>";
            $softbankToEzweb["%s147%"] = "<IMG LOCALSRC=233>";
            $softbankToEzweb["%s148%"] = "<IMG LOCALSRC=231>";
            $softbankToEzweb["%s149%"] = "<IMG LOCALSRC=364>";
            $softbankToEzweb["%s150%"] = "<IMG LOCALSRC=222>";
            $softbankToEzweb["%s151%"] = "<IMG LOCALSRC=229>";
            $softbankToEzweb["%s152%"] = "<IMG LOCALSRC=248>";
            $softbankToEzweb["%s153%"] = "<IMG LOCALSRC=169>";
            $softbankToEzweb["%s154%"] = "<IMG LOCALSRC=215>";
            $softbankToEzweb["%s155%"] = "<IMG LOCALSRC=368>";
            $softbankToEzweb["%s156%"] = "[♂]";
            $softbankToEzweb["%s157%"] = "[♀]";
            $softbankToEzweb["%s158%"] = "<IMG LOCALSRC=710>";
            $softbankToEzweb["%s159%"] = "<IMG LOCALSRC=304>";
            $softbankToEzweb["%s160%"] = "<IMG LOCALSRC=261>";
            $softbankToEzweb["%s161%"] = "<IMG LOCALSRC=16>";
            $softbankToEzweb["%s162%"] = "<IMG LOCALSRC=124>";
            $softbankToEzweb["%s163%"] = "<IMG LOCALSRC=369>";
            $softbankToEzweb["%s164%"] = "<IMG LOCALSRC=207>";
            $softbankToEzweb["%s165%"] = "<IMG LOCALSRC=13>";
            $softbankToEzweb["%s166%"] = "<IMG LOCALSRC=13>";
            $softbankToEzweb["%s167%"] = "<IMG LOCALSRC=370>";
            $softbankToEzweb["%s168%"] = "<IMG LOCALSRC=138>";
            $softbankToEzweb["%s169%"] = "<IMG LOCALSRC=138>";
            $softbankToEzweb["%s170%"] = "<IMG LOCALSRC=371>";
            $softbankToEzweb["%s171%"] = "<IMG LOCALSRC=240>";
            $softbankToEzweb["%s172%"] = "<IMG LOCALSRC=122>";
            $softbankToEzweb["%s173%"] = "[$\]";
            $softbankToEzweb["%s174%"] = "<IMG LOCALSRC=373>";
            $softbankToEzweb["%s175%"] = "<IMG LOCALSRC=210>";
            $softbankToEzweb["%s176%"] = "<IMG LOCALSRC=271>";
            $softbankToEzweb["%s177%"] = "<IMG LOCALSRC=212>";
            $softbankToEzweb["%s178%"] = "<IMG LOCALSRC=99>";
            $softbankToEzweb["%s179%"] = "<IMG LOCALSRC=208>";
            $softbankToEzweb["%s180%"] = "<IMG LOCALSRC=209>";
            $softbankToEzweb["%s181%"] = "<IMG LOCALSRC=207>";
            $softbankToEzweb["%s182%"] = "<IMG LOCALSRC=374>";
            $softbankToEzweb["%s183%"] = "<IMG LOCALSRC=375>";
            $softbankToEzweb["%s184%"] = "<IMG LOCALSRC=205>";
            $softbankToEzweb["%s185%"] = "<IMG LOCALSRC=376>";
            $softbankToEzweb["%s186%"] = "<IMG LOCALSRC=206>";
            $softbankToEzweb["%s187%"] = "<IMG LOCALSRC=377>";
            $softbankToEzweb["%s188%"] = "<IMG LOCALSRC=378>";
            $softbankToEzweb["%s189%"] = "<IMG LOCALSRC=216>";
            $softbankToEzweb["%s190%"] = "<IMG LOCALSRC=125>";
            $softbankToEzweb["%s201%"] = "<IMG LOCALSRC=800>";
            $softbankToEzweb["%s202%"] = "<IMG LOCALSRC=379>";
            $softbankToEzweb["%s203%"] = "[ココ]";
            $softbankToEzweb["%s204%"] = "<IMG LOCALSRC=51>";
            $softbankToEzweb["%s205%"] = "<IMG LOCALSRC=267>";
            $softbankToEzweb["%s206%"] = "<IMG LOCALSRC=28>";
            $softbankToEzweb["%s207%"] = "<IMG LOCALSRC=380>";
            $softbankToEzweb["%s208%"] = "<IMG LOCALSRC=177>";
            $softbankToEzweb["%s209%"] = "<IMG LOCALSRC=179>";
            $softbankToEzweb["%s210%"] = "<IMG LOCALSRC=178>";
            $softbankToEzweb["%s211%"] = "<IMG LOCALSRC=381>";
            $softbankToEzweb["%s212%"] = "<IMG LOCALSRC=414>";
            $softbankToEzweb["%s213%"] = "<IMG LOCALSRC=315>";
            $softbankToEzweb["%s214%"] = "<IMG LOCALSRC=314>";
            $softbankToEzweb["%s215%"] = "<IMG LOCALSRC=316>";
            $softbankToEzweb["%s216%"] = "<IMG LOCALSRC=818>";
            $softbankToEzweb["%s217%"] = "[ﾌﾘｰﾀﾞｲﾔﾙ]";
            $softbankToEzweb["%s218%"] = "<IMG LOCALSRC=334>";
            $softbankToEzweb["%s219%"] = "<IMG LOCALSRC=303>";
            $softbankToEzweb["%s220%"] = "<IMG LOCALSRC=382>";
            $softbankToEzweb["%s221%"] = "[有]";
            $softbankToEzweb["%s222%"] = "[無]";
            $softbankToEzweb["%s223%"] = "[月]";
            $softbankToEzweb["%s224%"] = "[申]";
            $softbankToEzweb["%s225%"] = "<IMG LOCALSRC=40>";
            $softbankToEzweb["%s226%"] = "<IMG LOCALSRC=41>";
            $softbankToEzweb["%s227%"] = "<IMG LOCALSRC=41>";
            $softbankToEzweb["%s228%"] = "<IMG LOCALSRC=180>";
            $softbankToEzweb["%s229%"] = "<IMG LOCALSRC=181>";
            $softbankToEzweb["%s230%"] = "<IMG LOCALSRC=182>";
            $softbankToEzweb["%s231%"] = "<IMG LOCALSRC=183>";
            $softbankToEzweb["%s232%"] = "<IMG LOCALSRC=184>";
            $softbankToEzweb["%s233%"] = "<IMG LOCALSRC=185>";
            $softbankToEzweb["%s234%"] = "<IMG LOCALSRC=186>";
            $softbankToEzweb["%s235%"] = "<IMG LOCALSRC=187>";
            $softbankToEzweb["%s236%"] = "<IMG LOCALSRC=188>";
            $softbankToEzweb["%s237%"] = "<IMG LOCALSRC=325>";
            $softbankToEzweb["%s238%"] = "<IMG LOCALSRC=285>";
            $softbankToEzweb["%s239%"] = "<IMG LOCALSRC=383>";
            $softbankToEzweb["%s240%"] = "<IMG LOCALSRC=384>";
            $softbankToEzweb["%s241%"] = "<IMG LOCALSRC=385>";
            $softbankToEzweb["%s242%"] = "<IMG LOCALSRC=386>";
            $softbankToEzweb["%s243%"] = "<IMG LOCALSRC=387>";
            $softbankToEzweb["%s244%"] = "<IMG LOCALSRC=388>";
            $softbankToEzweb["%s245%"] = "<IMG LOCALSRC=389>";
            $softbankToEzweb["%s246%"] = "<IMG LOCALSRC=390>";
            $softbankToEzweb["%s247%"] = "<IMG LOCALSRC=391>";
            $softbankToEzweb["%s248%"] = "<IMG LOCALSRC=140>";
            $softbankToEzweb["%s249%"] = "<IMG LOCALSRC=141>";
            $softbankToEzweb["%s250%"] = "<IMG LOCALSRC=29>";
            $softbankToEzweb["%s251%"] = "<IMG LOCALSRC=30>";
            $softbankToEzweb["%s252%"] = "<IMG LOCALSRC=63>";
            $softbankToEzweb["%s253%"] = "<IMG LOCALSRC=64>";
            $softbankToEzweb["%s254%"] = "<IMG LOCALSRC=70>";
            $softbankToEzweb["%s255%"] = "<IMG LOCALSRC=42>";
            $softbankToEzweb["%s256%"] = "<IMG LOCALSRC=43>";
            $softbankToEzweb["%s257%"] = "<IMG LOCALSRC=71>";
            $softbankToEzweb["%s258%"] = "<IMG LOCALSRC=6>";
            $softbankToEzweb["%s259%"] = "<IMG LOCALSRC=5>";
            $softbankToEzweb["%s260%"] = "<IMG LOCALSRC=8>";
            $softbankToEzweb["%s261%"] = "<IMG LOCALSRC=7>";
            $softbankToEzweb["%s262%"] = "<IMG LOCALSRC=392>";
            $softbankToEzweb["%s263%"] = "<IMG LOCALSRC=192>";
            $softbankToEzweb["%s264%"] = "<IMG LOCALSRC=193>";
            $softbankToEzweb["%s265%"] = "<IMG LOCALSRC=194>";
            $softbankToEzweb["%s266%"] = "<IMG LOCALSRC=195>";
            $softbankToEzweb["%s267%"] = "<IMG LOCALSRC=196>";
            $softbankToEzweb["%s268%"] = "<IMG LOCALSRC=197>";
            $softbankToEzweb["%s269%"] = "<IMG LOCALSRC=198>";
            $softbankToEzweb["%s270%"] = "<IMG LOCALSRC=199>";
            $softbankToEzweb["%s271%"] = "<IMG LOCALSRC=200>";
            $softbankToEzweb["%s272%"] = "<IMG LOCALSRC=201>";
            $softbankToEzweb["%s273%"] = "<IMG LOCALSRC=202>";
            $softbankToEzweb["%s274%"] = "<IMG LOCALSRC=203>";
            $softbankToEzweb["%s275%"] = "<IMG LOCALSRC=204>";
            $softbankToEzweb["%s276%"] = "[TOP]";
            $softbankToEzweb["%s277%"] = "<IMG LOCALSRC=326>";
            $softbankToEzweb["%s278%"] = "<IMG LOCALSRC=81>";
            $softbankToEzweb["%s279%"] = "<IMG LOCALSRC=82>";
            $softbankToEzweb["%s280%"] = "<IMG LOCALSRC=393>";
            $softbankToEzweb["%s281%"] = "<IMG LOCALSRC=394>";
            $softbankToEzweb["%s282%"] = "<IMG LOCALSRC=1>";
            $softbankToEzweb["%s283%"] = "[家庭教師]";
            $softbankToEzweb["%s285%"] = "[土星]";
            $softbankToEzweb["%s286%"] = "[紙飛行機]";
            $softbankToEzweb["%s287%"] = "[紙飛行機]";
            $softbankToEzweb["%s301%"] = "<IMG LOCALSRC=395>";
            $softbankToEzweb["%s302%"] = "<IMG LOCALSRC=396>";
            $softbankToEzweb["%s303%"] = "<IMG LOCALSRC=397>";
            $softbankToEzweb["%s304%"] = "<IMG LOCALSRC=113>";
            $softbankToEzweb["%s305%"] = "<IMG LOCALSRC=256>";
            $softbankToEzweb["%s306%"] = "<IMG LOCALSRC=398>";
            $softbankToEzweb["%s307%"] = "<IMG LOCALSRC=255>";
            $softbankToEzweb["%s308%"] = "<IMG LOCALSRC=399>";
            $softbankToEzweb["%s309%"] = "[WC]";
            $softbankToEzweb["%s310%"] = "<IMG LOCALSRC=294>";
            $softbankToEzweb["%s311%"] = "<IMG LOCALSRC=400>";
            $softbankToEzweb["%s312%"] = "<IMG LOCALSRC=401>";
            $softbankToEzweb["%s313%"] = "<IMG LOCALSRC=402>";
            $softbankToEzweb["%s314%"] = "<IMG LOCALSRC=176>";
            $softbankToEzweb["%s315%"] = "<IMG LOCALSRC=403>";
            $softbankToEzweb["%s316%"] = "<IMG LOCALSRC=404>";
            $softbankToEzweb["%s317%"] = "<IMG LOCALSRC=268>";
            $softbankToEzweb["%s318%"] = "<IMG LOCALSRC=405>";
            $softbankToEzweb["%s319%"] = "<IMG LOCALSRC=104>";
            $softbankToEzweb["%s320%"] = "<IMG LOCALSRC=312>";
            $softbankToEzweb["%s321%"] = "<IMG LOCALSRC=279>";
            $softbankToEzweb["%s322%"] = "<IMG LOCALSRC=126>";
            $softbankToEzweb["%s323%"] = "<IMG LOCALSRC=13>";
            $softbankToEzweb["%s324%"] = "<IMG LOCALSRC=407>";
            $softbankToEzweb["%s325%"] = "<IMG LOCALSRC=793>";
            $softbankToEzweb["%s326%"] = "<IMG LOCALSRC=124>";
            $softbankToEzweb["%s327%"] = "<IMG LOCALSRC=408>";
            $softbankToEzweb["%s328%"] = "<IMG LOCALSRC=295>";
            $softbankToEzweb["%s329%"] = "<IMG LOCALSRC=409>";
            $softbankToEzweb["%s330%"] = "<IMG LOCALSRC=297>";
            $softbankToEzweb["%s331%"] = "<IMG LOCALSRC=410>";
            $softbankToEzweb["%s332%"] = "<IMG LOCALSRC=411>";
            $softbankToEzweb["%s333%"] = "<IMG LOCALSRC=412>";
            $softbankToEzweb["%s334%"] = "<IMG LOCALSRC=413>";
            $softbankToEzweb["%s335%"] = "<IMG LOCALSRC=83>";
            $softbankToEzweb["%s336%"] = "<IMG LOCALSRC=226>";
            $softbankToEzweb["%s337%"] = "<IMG LOCALSRC=48>";
            $softbankToEzweb["%s338%"] = "<IMG LOCALSRC=291>";
            $softbankToEzweb["%s339%"] = "<IMG LOCALSRC=415>";
            $softbankToEzweb["%s340%"] = "<IMG LOCALSRC=803>";
            $softbankToEzweb["%s341%"] = "<IMG LOCALSRC=272>";
            $softbankToEzweb["%s342%"] = "<IMG LOCALSRC=416>";
            $softbankToEzweb["%s343%"] = "<IMG LOCALSRC=417>";
            $softbankToEzweb["%s344%"] = "<IMG LOCALSRC=418>";
            $softbankToEzweb["%s345%"] = "<IMG LOCALSRC=419>";
            $softbankToEzweb["%s346%"] = "<IMG LOCALSRC=420>";
            $softbankToEzweb["%s347%"] = "<IMG LOCALSRC=69>";
            $softbankToEzweb["%s348%"] = "<IMG LOCALSRC=282>";
            $softbankToEzweb["%s349%"] = "<IMG LOCALSRC=330>";
            $softbankToEzweb["%s350%"] = "<IMG LOCALSRC=422>";
            $softbankToEzweb["%s351%"] = "<IMG LOCALSRC=61>";
            $softbankToEzweb["%s352%"] = "<IMG LOCALSRC=262>";
            $softbankToEzweb["%s353%"] = "<IMG LOCALSRC=69>";
            $softbankToEzweb["%s354%"] = "<IMG LOCALSRC=3>";
            $softbankToEzweb["%s355%"] = "<IMG LOCALSRC=2>";
            $softbankToEzweb["%s356%"] = "<IMG LOCALSRC=423>";
            $softbankToEzweb["%s357%"] = "<IMG LOCALSRC=424>";
            $softbankToEzweb["%s358%"] = "<IMG LOCALSRC=425>";
            $softbankToEzweb["%s359%"] = "<IMG LOCALSRC=426>";
            $softbankToEzweb["%s360%"] = "<IMG LOCALSRC=427>";
            $softbankToEzweb["%s361%"] = "<IMG LOCALSRC=428>";
            $softbankToEzweb["%s362%"] = "<IMG LOCALSRC=429>";
            $softbankToEzweb["%s363%"] = "<IMG LOCALSRC=430>";
            $softbankToEzweb["%s364%"] = "<IMG LOCALSRC=333>";
            $softbankToEzweb["%s365%"] = "<IMG LOCALSRC=431>";
            $softbankToEzweb["%s366%"] = "<IMG LOCALSRC=244>";
            $softbankToEzweb["%s367%"] = "<IMG LOCALSRC=432>";
            $softbankToEzweb["%s368%"] = "<IMG LOCALSRC=433>";
            $softbankToEzweb["%s369%"] = "<IMG LOCALSRC=434>";
            $softbankToEzweb["%s370%"] = "<IMG LOCALSRC=435>";
            $softbankToEzweb["%s371%"] = "<IMG LOCALSRC=243>";
            $softbankToEzweb["%s372%"] = "<IMG LOCALSRC=238>";
            $softbankToEzweb["%s373%"] = "<IMG LOCALSRC=436>";
            $softbankToEzweb["%s374%"] = "<IMG LOCALSRC=437>";
            $softbankToEzweb["%s375%"] = "<IMG LOCALSRC=313>";
            $softbankToEzweb["%s376%"] = "<IMG LOCALSRC=438>";
            $softbankToEzweb["%s377%"] = "<IMG LOCALSRC=439>";
            $softbankToEzweb["%s401%"] = "<IMG LOCALSRC=351>";
            $softbankToEzweb["%s402%"] = "<IMG LOCALSRC=440>";
            $softbankToEzweb["%s403%"] = "<IMG LOCALSRC=441>";
            $softbankToEzweb["%s404%"] = "<IMG LOCALSRC=442>";
            $softbankToEzweb["%s405%"] = "<IMG LOCALSRC=348>";
            $softbankToEzweb["%s406%"] = "<IMG LOCALSRC=443>";
            $softbankToEzweb["%s407%"] = "<IMG LOCALSRC=444>";
            $softbankToEzweb["%s408%"] = "<IMG LOCALSRC=445>";
            $softbankToEzweb["%s409%"] = "<IMG LOCALSRC=264>";
            $softbankToEzweb["%s410%"] = "<IMG LOCALSRC=446>";
            $softbankToEzweb["%s411%"] = "<IMG LOCALSRC=447>";
            $softbankToEzweb["%s412%"] = "<IMG LOCALSRC=448>";
            $softbankToEzweb["%s413%"] = "<IMG LOCALSRC=449>";
            $softbankToEzweb["%s414%"] = "<IMG LOCALSRC=450>";
            $softbankToEzweb["%s415%"] = "<IMG LOCALSRC=447>";
            $softbankToEzweb["%s416%"] = "<IMG LOCALSRC=451>";
            $softbankToEzweb["%s417%"] = "<IMG LOCALSRC=259>";
            $softbankToEzweb["%s418%"] = "<IMG LOCALSRC=786>";
            $softbankToEzweb["%s419%"] = "<IMG LOCALSRC=791>";
            $softbankToEzweb["%s420%"] = "<IMG LOCALSRC=454>";
            $softbankToEzweb["%s421%"] = "<IMG LOCALSRC=257>";
            $softbankToEzweb["%s422%"] = "<IMG LOCALSRC=779>";
            $softbankToEzweb["%s423%"] = "<IMG LOCALSRC=455>";
            $softbankToEzweb["%s424%"] = "<IMG LOCALSRC=456>";
            $softbankToEzweb["%s425%"] = "<IMG LOCALSRC=317>";
            $softbankToEzweb["%s426%"] = "<IMG LOCALSRC=457>";
            $softbankToEzweb["%s427%"] = "<IMG LOCALSRC=318>";
            $softbankToEzweb["%s428%"] = "<IMG LOCALSRC=458>";
            $softbankToEzweb["%s429%"] = "<IMG LOCALSRC=459>";
            $softbankToEzweb["%s430%"] = "<IMG LOCALSRC=463>";
            $softbankToEzweb["%s431%"] = "<IMG LOCALSRC=460>";
            $softbankToEzweb["%s432%"] = "<IMG LOCALSRC=461>";
            $softbankToEzweb["%s433%"] = "<IMG LOCALSRC=462>";
            $softbankToEzweb["%s434%"] = "<IMG LOCALSRC=463>";
            $softbankToEzweb["%s435%"] = "<IMG LOCALSRC=464>";
            $softbankToEzweb["%s436%"] = "<IMG LOCALSRC=465>";
            $softbankToEzweb["%s437%"] = "<IMG LOCALSRC=467>";
            $softbankToEzweb["%s438%"] = "<IMG LOCALSRC=466>";
            $softbankToEzweb["%s439%"] = "<IMG LOCALSRC=820>";
            $softbankToEzweb["%s440%"] = "[ｶｯﾌﾟﾙ]";
            $softbankToEzweb["%s441%"] = "<IMG LOCALSRC=468>";
            $softbankToEzweb["%s442%"] = "<IMG LOCALSRC=307>";
            $softbankToEzweb["%s443%"] = "<IMG LOCALSRC=96>";
            $softbankToEzweb["%s444%"] = "<IMG LOCALSRC=470>";
            $softbankToEzweb["%s445%"] = "<IMG LOCALSRC=471>";
            $softbankToEzweb["%s446%"] = "<IMG LOCALSRC=125>";
            $softbankToEzweb["%s447%"] = "<IMG LOCALSRC=148>";
            $softbankToEzweb["%s448%"] = "<IMG LOCALSRC=472>";
            $softbankToEzweb["%s449%"] = "<IMG LOCALSRC=473>";
            $softbankToEzweb["%s450%"] = "<IMG LOCALSRC=474>";
            $softbankToEzweb["%s451%"] = "<IMG LOCALSRC=475>";
            $softbankToEzweb["%s452%"] = "<IMG LOCALSRC=341>";
            $softbankToEzweb["%s453%"] = "<IMG LOCALSRC=217>";
            $softbankToEzweb["%s454%"] = "<IMG LOCALSRC=476>";
            $softbankToEzweb["%s455%"] = "<IMG LOCALSRC=770>";
            $softbankToEzweb["%s456%"] = "<IMG LOCALSRC=477>";
            $softbankToEzweb["%s457%"] = "<IMG LOCALSRC=478>";
            $softbankToEzweb["%s458%"] = "<IMG LOCALSRC=479>";
            $softbankToEzweb["%s459%"] = "<IMG LOCALSRC=480>";
            $softbankToEzweb["%s460%"] = "<IMG LOCALSRC=481>";
            $softbankToEzweb["%s461%"] = "<IMG LOCALSRC=340>";
            $softbankToEzweb["%s462%"] = "<IMG LOCALSRC=810>";
            $softbankToEzweb["%s463%"] = "<IMG LOCALSRC=483>";
            $softbankToEzweb["%s464%"] = "<IMG LOCALSRC=484>";
            $softbankToEzweb["%s465%"] = "<IMG LOCALSRC=485>";
            $softbankToEzweb["%s466%"] = "<IMG LOCALSRC=486>";
            $softbankToEzweb["%s467%"] = "<IMG LOCALSRC=190>";
            $softbankToEzweb["%s468%"] = "[稲]";
            $softbankToEzweb["%s469%"] = "<IMG LOCALSRC=487>";
            $softbankToEzweb["%s470%"] = "<IMG LOCALSRC=488>";
            $softbankToEzweb["%s471%"] = "<IMG LOCALSRC=358>";
            $softbankToEzweb["%s472%"] = "<IMG LOCALSRC=489>";
            $softbankToEzweb["%s473%"] = "<IMG LOCALSRC=493>";
            $softbankToEzweb["%s474%"] = "<IMG LOCALSRC=371>";
            $softbankToEzweb["%s475%"] = "<IMG LOCALSRC=490>";
            $softbankToEzweb["%s476%"] = "<IMG LOCALSRC=491>";
            $softbankToEzweb["%s501%"] = "<IMG LOCALSRC=492>";
            $softbankToEzweb["%s502%"] = "<IMG LOCALSRC=309>";
            $softbankToEzweb["%s503%"] = "<IMG LOCALSRC=494>";
            $softbankToEzweb["%s504%"] = "<IMG LOCALSRC=495>";
            $softbankToEzweb["%s505%"] = "<IMG LOCALSRC=496>";
            $softbankToEzweb["%s506%"] = "<IMG LOCALSRC=497>";
            $softbankToEzweb["%s507%"] = "<IMG LOCALSRC=110>";
            $softbankToEzweb["%s508%"] = "<IMG LOCALSRC=498>";
            $softbankToEzweb["%s509%"] = "<IMG LOCALSRC=228>";
            $softbankToEzweb["%s510%"] = "[ﾛｹｯﾄ]";
            $softbankToEzweb["%s511%"] = "<IMG LOCALSRC=237>";
            $softbankToEzweb["%s512%"] = "<IMG LOCALSRC=90>";
            $softbankToEzweb["%s513%"] = "<IMG LOCALSRC=499>";
            $softbankToEzweb["%s514%"] = "<IMG LOCALSRC=700>";
            $softbankToEzweb["%s515%"] = "<IMG LOCALSRC=701>";
            $softbankToEzweb["%s516%"] = "<IMG LOCALSRC=702>";
            $softbankToEzweb["%s517%"] = "<IMG LOCALSRC=366>";
            $softbankToEzweb["%s518%"] = "<IMG LOCALSRC=367>";
            $softbankToEzweb["%s519%"] = "<IMG LOCALSRC=703>";
            $softbankToEzweb["%s520%"] = "<IMG LOCALSRC=704>";
            $softbankToEzweb["%s521%"] = "<IMG LOCALSRC=705>";
            $softbankToEzweb["%s522%"] = "<IMG LOCALSRC=706>";
            $softbankToEzweb["%s523%"] = "<IMG LOCALSRC=707>";
            $softbankToEzweb["%s524%"] = "<IMG LOCALSRC=708>";
            $softbankToEzweb["%s525%"] = "<IMG LOCALSRC=709>";
            $softbankToEzweb["%s526%"] = "<IMG LOCALSRC=710>";
            $softbankToEzweb["%s527%"] = "<IMG LOCALSRC=711>";
            $softbankToEzweb["%s528%"] = "<IMG LOCALSRC=712>";
            $softbankToEzweb["%s529%"] = "[自由の女神]";
            $softbankToEzweb["%s530%"] = "[兵隊]";
            $softbankToEzweb["%s531%"] = "<IMG LOCALSRC=714>";
            $softbankToEzweb["%s532%"] = "<IMG LOCALSRC=713>";
            $softbankToEzweb["%s533%"] = "<IMG LOCALSRC=78>";
            $softbankToEzweb["%s534%"] = "<IMG LOCALSRC=715>";
            $softbankToEzweb["%s535%"] = "<IMG LOCALSRC=78>";
            $softbankToEzweb["%s536%"] = "[犬]";
            $softbankToEzweb["%s537%"] = "<IMG LOCALSRC=716>";
            $softbankToEzweb["%s538%"] = "<IMG LOCALSRC=717>";
            $softbankToEzweb["%s539%"] = "<IMG LOCALSRC=718>";
            $softbankToEzweb["%s540%"] = "<IMG LOCALSRC=249>";
            $softbankToEzweb["%s541%"] = "<IMG LOCALSRC=192>";
            $softbankToEzweb["%s542%"] = "<IMG LOCALSRC=134>";
            $softbankToEzweb["%s543%"] = "<IMG LOCALSRC=719>";
            $softbankToEzweb["%s544%"] = "<IMG LOCALSRC=247>";
            $softbankToEzweb["%s545%"] = "<IMG LOCALSRC=720>";
            $softbankToEzweb["%s546%"] = "<IMG LOCALSRC=721>";
            $softbankToEzweb["%s547%"] = "<IMG LOCALSRC=722>";
            $softbankToEzweb["%s548%"] = "<IMG LOCALSRC=723>";
            $softbankToEzweb["%s549%"] = "<IMG LOCALSRC=250>";
            $softbankToEzweb["%s550%"] = "<IMG LOCALSRC=724>";
            $softbankToEzweb["%s551%"] = "<IMG LOCALSRC=725>";
            $softbankToEzweb["%s552%"] = "<IMG LOCALSRC=727>";
            $softbankToEzweb["%s553%"] = "<IMG LOCALSRC=726>";
            $softbankToEzweb["%s554%"] = "<IMG LOCALSRC=728>";
            $softbankToEzweb["%s555%"] = "<IMG LOCALSRC=54>";
        }

        return $softbankToEzweb;
    }

    /**
     * getJphoneEmojiメソッド
     *
     * Softbank用の変換文字をキーにしたJphone絵文字データ配列を返します。
     * ※入力される絵文字データに関して、SoftbankとJ-PHONEで異なるため
     *   別メソッドとなります。
     *   出力に関しては、Jphone用のコードで下位互換となっているので
     *   Softbank、J-PHONEの区分けはありません。
     *
     * @return $jphoneEmoji Jphone絵文字配列
     */

    public static function getJphoneEmoji() {
        static $jphoneEmoji;

        if (!isset($jphoneEmoji)) {
            $jphoneEmoji["%s1%"] = "\x1b\$G!\x0f";
            $jphoneEmoji["%s2%"] = "\x1b\$G\"\x0f";
            $jphoneEmoji["%s3%"] = "\x1b\$G#\x0f";
            $jphoneEmoji["%s4%"] = "\x1b\$G\$\x0f";
            $jphoneEmoji["%s5%"] = "\x1b\$G%\x0f";
            $jphoneEmoji["%s6%"] = "\x1b\$G&\x0f";
            $jphoneEmoji["%s7%"] = "\x1b\$G'\x0f";
            $jphoneEmoji["%s8%"] = "\x1b\$G(\x0f";
            $jphoneEmoji["%s9%"] = "\x1b\$G)\x0f";
            $jphoneEmoji["%s10%"] = "\x1b\$G*\x0f";
            $jphoneEmoji["%s11%"] = "\x1b\$G+\x0f";
            $jphoneEmoji["%s12%"] = "\x1b\$G,\x0f";
            $jphoneEmoji["%s13%"] = "\x1b\$G-\x0f";
            $jphoneEmoji["%s14%"] = "\x1b\$G.\x0f";
            $jphoneEmoji["%s15%"] = "\x1b\$G/\x0f";
            $jphoneEmoji["%s16%"] = "\x1b\$G0\x0f";
            $jphoneEmoji["%s17%"] = "\x1b\$G1\x0f";
            $jphoneEmoji["%s18%"] = "\x1b\$G2\x0f";
            $jphoneEmoji["%s19%"] = "\x1b\$G3\x0f";
            $jphoneEmoji["%s20%"] = "\x1b\$G4\x0f";
            $jphoneEmoji["%s21%"] = "\x1b\$G5\x0f";
            $jphoneEmoji["%s22%"] = "\x1b\$G6\x0f";
            $jphoneEmoji["%s23%"] = "\x1b\$G7\x0f";
            $jphoneEmoji["%s24%"] = "\x1b\$G8\x0f";
            $jphoneEmoji["%s25%"] = "\x1b\$G9\x0f";
            $jphoneEmoji["%s26%"] = "\x1b\$G:\x0f";
            $jphoneEmoji["%s27%"] = "\x1b\$G;\x0f";
            $jphoneEmoji["%s28%"] = "\x1b\$G<\x0f";
            $jphoneEmoji["%s29%"] = "\x1b\$G=\x0f";
            $jphoneEmoji["%s30%"] = "\x1b\$G>\x0f";
            $jphoneEmoji["%s31%"] = "\x1b\$G?\x0f";
            $jphoneEmoji["%s32%"] = "\x1b\$G@\x0f";
            $jphoneEmoji["%s33%"] = "\x1b\$GA\x0f";
            $jphoneEmoji["%s34%"] = "\x1b\$GB\x0f";
            $jphoneEmoji["%s35%"] = "\x1b\$GC\x0f";
            $jphoneEmoji["%s36%"] = "\x1b\$GD\x0f";
            $jphoneEmoji["%s37%"] = "\x1b\$GE\x0f";
            $jphoneEmoji["%s38%"] = "\x1b\$GF\x0f";
            $jphoneEmoji["%s39%"] = "\x1b\$GG\x0f";
            $jphoneEmoji["%s40%"] = "\x1b\$GH\x0f";
            $jphoneEmoji["%s41%"] = "\x1b\$GI\x0f";
            $jphoneEmoji["%s42%"] = "\x1b\$GJ\x0f";
            $jphoneEmoji["%s43%"] = "\x1b\$GK\x0f";
            $jphoneEmoji["%s44%"] = "\x1b\$GL\x0f";
            $jphoneEmoji["%s45%"] = "\x1b\$GM\x0f";
            $jphoneEmoji["%s46%"] = "\x1b\$GN\x0f";
            $jphoneEmoji["%s47%"] = "\x1b\$GO\x0f";
            $jphoneEmoji["%s48%"] = "\x1b\$GP\x0f";
            $jphoneEmoji["%s49%"] = "\x1b\$GQ\x0f";
            $jphoneEmoji["%s50%"] = "\x1b\$GR\x0f";
            $jphoneEmoji["%s51%"] = "\x1b\$GS\x0f";
            $jphoneEmoji["%s52%"] = "\x1b\$GT\x0f";
            $jphoneEmoji["%s53%"] = "\x1b\$GU\x0f";
            $jphoneEmoji["%s54%"] = "\x1b\$GV\x0f";
            $jphoneEmoji["%s55%"] = "\x1b\$GW\x0f";
            $jphoneEmoji["%s56%"] = "\x1b\$GX\x0f";
            $jphoneEmoji["%s57%"] = "\x1b\$GY\x0f";
            $jphoneEmoji["%s58%"] = "\x1b\$GZ\x0f";
            $jphoneEmoji["%s59%"] = "\x1b\$G[\x0f";
            $jphoneEmoji["%s60%"] = "\x1b\$G\\x0f";
            $jphoneEmoji["%s61%"] = "\x1b\$G]\x0f";
            $jphoneEmoji["%s62%"] = "\x1b\$G^\x0f";
            $jphoneEmoji["%s63%"] = "\x1b\$G_\x0f";
            $jphoneEmoji["%s64%"] = "\x1b\$G`\x0f";
            $jphoneEmoji["%s65%"] = "\x1b\$Ga\x0f";
            $jphoneEmoji["%s66%"] = "\x1b\$Gb\x0f";
            $jphoneEmoji["%s67%"] = "\x1b\$Gc\x0f";
            $jphoneEmoji["%s68%"] = "\x1b\$Gd\x0f";
            $jphoneEmoji["%s69%"] = "\x1b\$Ge\x0f";
            $jphoneEmoji["%s70%"] = "\x1b\$Gf\x0f";
            $jphoneEmoji["%s71%"] = "\x1b\$Gg\x0f";
            $jphoneEmoji["%s72%"] = "\x1b\$Gh\x0f";
            $jphoneEmoji["%s73%"] = "\x1b\$Gi\x0f";
            $jphoneEmoji["%s74%"] = "\x1b\$Gj\x0f";
            $jphoneEmoji["%s75%"] = "\x1b\$Gk\x0f";
            $jphoneEmoji["%s76%"] = "\x1b\$Gl\x0f";
            $jphoneEmoji["%s77%"] = "\x1b\$Gm\x0f";
            $jphoneEmoji["%s78%"] = "\x1b\$Gn\x0f";
            $jphoneEmoji["%s79%"] = "\x1b\$Go\x0f";
            $jphoneEmoji["%s80%"] = "\x1b\$Gp\x0f";
            $jphoneEmoji["%s81%"] = "\x1b\$Gq\x0f";
            $jphoneEmoji["%s82%"] = "\x1b\$Gr\x0f";
            $jphoneEmoji["%s83%"] = "\x1b\$Gs\x0f";
            $jphoneEmoji["%s84%"] = "\x1b\$Gt\x0f";
            $jphoneEmoji["%s85%"] = "\x1b\$Gu\x0f";
            $jphoneEmoji["%s86%"] = "\x1b\$Gv\x0f";
            $jphoneEmoji["%s87%"] = "\x1b\$Gw\x0f";
            $jphoneEmoji["%s88%"] = "\x1b\$Gx\x0f";
            $jphoneEmoji["%s89%"] = "\x1b\$Gy\x0f";
            $jphoneEmoji["%s90%"] = "\x1b\$Gz\x0f";
            $jphoneEmoji["%s101%"] = "\x1b\$E!\x0f";
            $jphoneEmoji["%s102%"] = "\x1b\$E\"\x0f";
            $jphoneEmoji["%s103%"] = "\x1b\$E#\x0f";
            $jphoneEmoji["%s104%"] = "\x1b\$E\$\x0f";
            $jphoneEmoji["%s105%"] = "\x1b\$E%\x0f";
            $jphoneEmoji["%s106%"] = "\x1b\$E&\x0f";
            $jphoneEmoji["%s107%"] = "\x1b\$E'\x0f";
            $jphoneEmoji["%s108%"] = "\x1b\$E(\x0f";
            $jphoneEmoji["%s109%"] = "\x1b\$E)\x0f";
            $jphoneEmoji["%s110%"] = "\x1b\$E*\x0f";
            $jphoneEmoji["%s111%"] = "\x1b\$E+\x0f";
            $jphoneEmoji["%s112%"] = "\x1b\$E,\x0f";
            $jphoneEmoji["%s113%"] = "\x1b\$E-\x0f";
            $jphoneEmoji["%s114%"] = "\x1b\$E.\x0f";
            $jphoneEmoji["%s115%"] = "\x1b\$E/\x0f";
            $jphoneEmoji["%s116%"] = "\x1b\$E0\x0f";
            $jphoneEmoji["%s117%"] = "\x1b\$E1\x0f";
            $jphoneEmoji["%s118%"] = "\x1b\$E2\x0f";
            $jphoneEmoji["%s119%"] = "\x1b\$E3\x0f";
            $jphoneEmoji["%s120%"] = "\x1b\$E4\x0f";
            $jphoneEmoji["%s121%"] = "\x1b\$E5\x0f";
            $jphoneEmoji["%s122%"] = "\x1b\$E6\x0f";
            $jphoneEmoji["%s123%"] = "\x1b\$E7\x0f";
            $jphoneEmoji["%s124%"] = "\x1b\$E8\x0f";
            $jphoneEmoji["%s125%"] = "\x1b\$E9\x0f";
            $jphoneEmoji["%s126%"] = "\x1b\$E:\x0f";
            $jphoneEmoji["%s127%"] = "\x1b\$E;\x0f";
            $jphoneEmoji["%s128%"] = "\x1b\$E<\x0f";
            $jphoneEmoji["%s129%"] = "\x1b\$E=\x0f";
            $jphoneEmoji["%s130%"] = "\x1b\$E>\x0f";
            $jphoneEmoji["%s131%"] = "\x1b\$E?\x0f";
            $jphoneEmoji["%s132%"] = "\x1b\$E@\x0f";
            $jphoneEmoji["%s133%"] = "\x1b\$EA\x0f";
            $jphoneEmoji["%s134%"] = "\x1b\$EB\x0f";
            $jphoneEmoji["%s135%"] = "\x1b\$EC\x0f";
            $jphoneEmoji["%s136%"] = "\x1b\$ED\x0f";
            $jphoneEmoji["%s137%"] = "\x1b\$EE\x0f";
            $jphoneEmoji["%s138%"] = "\x1b\$EF\x0f";
            $jphoneEmoji["%s139%"] = "\x1b\$EG\x0f";
            $jphoneEmoji["%s140%"] = "\x1b\$EH\x0f";
            $jphoneEmoji["%s141%"] = "\x1b\$EI\x0f";
            $jphoneEmoji["%s142%"] = "\x1b\$EJ\x0f";
            $jphoneEmoji["%s143%"] = "\x1b\$EK\x0f";
            $jphoneEmoji["%s144%"] = "\x1b\$EL\x0f";
            $jphoneEmoji["%s145%"] = "\x1b\$EM\x0f";
            $jphoneEmoji["%s146%"] = "\x1b\$EN\x0f";
            $jphoneEmoji["%s147%"] = "\x1b\$EO\x0f";
            $jphoneEmoji["%s148%"] = "\x1b\$EP\x0f";
            $jphoneEmoji["%s149%"] = "\x1b\$EQ\x0f";
            $jphoneEmoji["%s150%"] = "\x1b\$ER\x0f";
            $jphoneEmoji["%s151%"] = "\x1b\$ES\x0f";
            $jphoneEmoji["%s152%"] = "\x1b\$ET\x0f";
            $jphoneEmoji["%s153%"] = "\x1b\$EU\x0f";
            $jphoneEmoji["%s154%"] = "\x1b\$EV\x0f";
            $jphoneEmoji["%s155%"] = "\x1b\$EW\x0f";
            $jphoneEmoji["%s156%"] = "\x1b\$EX\x0f";
            $jphoneEmoji["%s157%"] = "\x1b\$EY\x0f";
            $jphoneEmoji["%s158%"] = "\x1b\$EZ\x0f";
            $jphoneEmoji["%s159%"] = "\x1b\$E[\x0f";
            $jphoneEmoji["%s160%"] = "\x1b\$E\\x0f";
            $jphoneEmoji["%s161%"] = "\x1b\$E]\x0f";
            $jphoneEmoji["%s162%"] = "\x1b\$E^\x0f";
            $jphoneEmoji["%s163%"] = "\x1b\$E_\x0f";
            $jphoneEmoji["%s164%"] = "\x1b\$E`\x0f";
            $jphoneEmoji["%s165%"] = "\x1b\$Ea\x0f";
            $jphoneEmoji["%s166%"] = "\x1b\$Eb\x0f";
            $jphoneEmoji["%s167%"] = "\x1b\$Ec\x0f";
            $jphoneEmoji["%s168%"] = "\x1b\$Ed\x0f";
            $jphoneEmoji["%s169%"] = "\x1b\$Ee\x0f";
            $jphoneEmoji["%s170%"] = "\x1b\$Ef\x0f";
            $jphoneEmoji["%s171%"] = "\x1b\$Eg\x0f";
            $jphoneEmoji["%s172%"] = "\x1b\$Eh\x0f";
            $jphoneEmoji["%s173%"] = "\x1b\$Ei\x0f";
            $jphoneEmoji["%s174%"] = "\x1b\$Ej\x0f";
            $jphoneEmoji["%s175%"] = "\x1b\$Ek\x0f";
            $jphoneEmoji["%s176%"] = "\x1b\$El\x0f";
            $jphoneEmoji["%s177%"] = "\x1b\$Em\x0f";
            $jphoneEmoji["%s178%"] = "\x1b\$En\x0f";
            $jphoneEmoji["%s179%"] = "\x1b\$Eo\x0f";
            $jphoneEmoji["%s180%"] = "\x1b\$Ep\x0f";
            $jphoneEmoji["%s181%"] = "\x1b\$Eq\x0f";
            $jphoneEmoji["%s182%"] = "\x1b\$Er\x0f";
            $jphoneEmoji["%s183%"] = "\x1b\$Es\x0f";
            $jphoneEmoji["%s184%"] = "\x1b\$Et\x0f";
            $jphoneEmoji["%s185%"] = "\x1b\$Eu\x0f";
            $jphoneEmoji["%s186%"] = "\x1b\$Ev\x0f";
            $jphoneEmoji["%s187%"] = "\x1b\$Ew\x0f";
            $jphoneEmoji["%s188%"] = "\x1b\$Ex\x0f";
            $jphoneEmoji["%s189%"] = "\x1b\$Ey\x0f";
            $jphoneEmoji["%s190%"] = "\x1b\$Ez\x0f";
            $jphoneEmoji["%s201%"] = "\x1b\$F!\x0f";
            $jphoneEmoji["%s202%"] = "\x1b\$F\"\x0f";
            $jphoneEmoji["%s203%"] = "\x1b\$F#\x0f";
            $jphoneEmoji["%s204%"] = "\x1b\$F\$\x0f";
            $jphoneEmoji["%s205%"] = "\x1b\$F%\x0f";
            $jphoneEmoji["%s206%"] = "\x1b\$F&\x0f";
            $jphoneEmoji["%s207%"] = "\x1b\$F'\x0f";
            $jphoneEmoji["%s208%"] = "\x1b\$F(\x0f";
            $jphoneEmoji["%s209%"] = "\x1b\$F)\x0f";
            $jphoneEmoji["%s210%"] = "\x1b\$F*\x0f";
            $jphoneEmoji["%s211%"] = "\x1b\$F+\x0f";
            $jphoneEmoji["%s212%"] = "\x1b\$F,\x0f";
            $jphoneEmoji["%s213%"] = "\x1b\$F-\x0f";
            $jphoneEmoji["%s214%"] = "\x1b\$F.\x0f";
            $jphoneEmoji["%s215%"] = "\x1b\$F/\x0f";
            $jphoneEmoji["%s216%"] = "\x1b\$F0\x0f";
            $jphoneEmoji["%s217%"] = "\x1b\$F1\x0f";
            $jphoneEmoji["%s218%"] = "\x1b\$F2\x0f";
            $jphoneEmoji["%s219%"] = "\x1b\$F3\x0f";
            $jphoneEmoji["%s220%"] = "\x1b\$F4\x0f";
            $jphoneEmoji["%s221%"] = "\x1b\$F5\x0f";
            $jphoneEmoji["%s222%"] = "\x1b\$F6\x0f";
            $jphoneEmoji["%s223%"] = "\x1b\$F7\x0f";
            $jphoneEmoji["%s224%"] = "\x1b\$F8\x0f";
            $jphoneEmoji["%s225%"] = "\x1b\$F9\x0f";
            $jphoneEmoji["%s226%"] = "\x1b\$F:\x0f";
            $jphoneEmoji["%s227%"] = "\x1b\$F;\x0f";
            $jphoneEmoji["%s228%"] = "\x1b\$F<\x0f";
            $jphoneEmoji["%s229%"] = "\x1b\$F=\x0f";
            $jphoneEmoji["%s230%"] = "\x1b\$F>\x0f";
            $jphoneEmoji["%s231%"] = "\x1b\$F?\x0f";
            $jphoneEmoji["%s232%"] = "\x1b\$F@\x0f";
            $jphoneEmoji["%s233%"] = "\x1b\$FA\x0f";
            $jphoneEmoji["%s234%"] = "\x1b\$FB\x0f";
            $jphoneEmoji["%s235%"] = "\x1b\$FC\x0f";
            $jphoneEmoji["%s236%"] = "\x1b\$FD\x0f";
            $jphoneEmoji["%s237%"] = "\x1b\$FE\x0f";
            $jphoneEmoji["%s238%"] = "\x1b\$FF\x0f";
            $jphoneEmoji["%s239%"] = "\x1b\$FG\x0f";
            $jphoneEmoji["%s240%"] = "\x1b\$FH\x0f";
            $jphoneEmoji["%s241%"] = "\x1b\$FI\x0f";
            $jphoneEmoji["%s242%"] = "\x1b\$FJ\x0f";
            $jphoneEmoji["%s243%"] = "\x1b\$FK\x0f";
            $jphoneEmoji["%s244%"] = "\x1b\$FL\x0f";
            $jphoneEmoji["%s245%"] = "\x1b\$FM\x0f";
            $jphoneEmoji["%s246%"] = "\x1b\$FN\x0f";
            $jphoneEmoji["%s247%"] = "\x1b\$FO\x0f";
            $jphoneEmoji["%s248%"] = "\x1b\$FP\x0f";
            $jphoneEmoji["%s249%"] = "\x1b\$FQ\x0f";
            $jphoneEmoji["%s250%"] = "\x1b\$FR\x0f";
            $jphoneEmoji["%s251%"] = "\x1b\$FS\x0f";
            $jphoneEmoji["%s252%"] = "\x1b\$FT\x0f";
            $jphoneEmoji["%s253%"] = "\x1b\$FU\x0f";
            $jphoneEmoji["%s254%"] = "\x1b\$FV\x0f";
            $jphoneEmoji["%s255%"] = "\x1b\$FW\x0f";
            $jphoneEmoji["%s256%"] = "\x1b\$FX\x0f";
            $jphoneEmoji["%s257%"] = "\x1b\$FY\x0f";
            $jphoneEmoji["%s258%"] = "\x1b\$FZ\x0f";
            $jphoneEmoji["%s259%"] = "\x1b\$F[\x0f";
            $jphoneEmoji["%s260%"] = "\x1b\$F\\x0f";
            $jphoneEmoji["%s261%"] = "\x1b\$F]\x0f";
            $jphoneEmoji["%s262%"] = "\x1b\$F^\x0f";
            $jphoneEmoji["%s263%"] = "\x1b\$F_\x0f";
            $jphoneEmoji["%s264%"] = "\x1b\$F`\x0f";
            $jphoneEmoji["%s265%"] = "\x1b\$Fa\x0f";
            $jphoneEmoji["%s266%"] = "\x1b\$Fb\x0f";
            $jphoneEmoji["%s267%"] = "\x1b\$Fc\x0f";
            $jphoneEmoji["%s268%"] = "\x1b\$Fd\x0f";
            $jphoneEmoji["%s269%"] = "\x1b\$Fe\x0f";
            $jphoneEmoji["%s270%"] = "\x1b\$Ff\x0f";
            $jphoneEmoji["%s271%"] = "\x1b\$Fg\x0f";
            $jphoneEmoji["%s272%"] = "\x1b\$Fh\x0f";
            $jphoneEmoji["%s273%"] = "\x1b\$Fi\x0f";
            $jphoneEmoji["%s274%"] = "\x1b\$Fj\x0f";
            $jphoneEmoji["%s275%"] = "\x1b\$Fk\x0f";
            $jphoneEmoji["%s276%"] = "\x1b\$Fl\x0f";
            $jphoneEmoji["%s277%"] = "\x1b\$Fm\x0f";
            $jphoneEmoji["%s278%"] = "\x1b\$Fn\x0f";
            $jphoneEmoji["%s279%"] = "\x1b\$Fo\x0f";
            $jphoneEmoji["%s280%"] = "\x1b\$Fp\x0f";
            $jphoneEmoji["%s281%"] = "\x1b\$Fq\x0f";
            $jphoneEmoji["%s282%"] = "\x1b\$Fr\x0f";
            $jphoneEmoji["%s283%"] = "\x1b\$Fs\x0f";
            $jphoneEmoji["%s285%"] = "\x1b\$Fu\x0f";
            $jphoneEmoji["%s286%"] = "\x1b\$Fv\x0f";
            $jphoneEmoji["%s287%"] = "\x1b\$Fw\x0f";
            $jphoneEmoji["%s301%"] = "\x1b\$O!\x0f";
            $jphoneEmoji["%s302%"] = "\x1b\$O\"\x0f";
            $jphoneEmoji["%s303%"] = "\x1b\$O#\x0f";
            $jphoneEmoji["%s304%"] = "\x1b\$O\$\x0f";
            $jphoneEmoji["%s305%"] = "\x1b\$O%\x0f";
            $jphoneEmoji["%s306%"] = "\x1b\$O&\x0f";
            $jphoneEmoji["%s307%"] = "\x1b\$O'\x0f";
            $jphoneEmoji["%s308%"] = "\x1b\$O(\x0f";
            $jphoneEmoji["%s309%"] = "\x1b\$O)\x0f";
            $jphoneEmoji["%s310%"] = "\x1b\$O*\x0f";
            $jphoneEmoji["%s311%"] = "\x1b\$O+\x0f";
            $jphoneEmoji["%s312%"] = "\x1b\$O,\x0f";
            $jphoneEmoji["%s313%"] = "\x1b\$O-\x0f";
            $jphoneEmoji["%s314%"] = "\x1b\$O.\x0f";
            $jphoneEmoji["%s315%"] = "\x1b\$O/\x0f";
            $jphoneEmoji["%s316%"] = "\x1b\$O0\x0f";
            $jphoneEmoji["%s317%"] = "\x1b\$O1\x0f";
            $jphoneEmoji["%s318%"] = "\x1b\$O2\x0f";
            $jphoneEmoji["%s319%"] = "\x1b\$O3\x0f";
            $jphoneEmoji["%s320%"] = "\x1b\$O4\x0f";
            $jphoneEmoji["%s321%"] = "\x1b\$O5\x0f";
            $jphoneEmoji["%s322%"] = "\x1b\$O6\x0f";
            $jphoneEmoji["%s323%"] = "\x1b\$O7\x0f";
            $jphoneEmoji["%s324%"] = "\x1b\$O8\x0f";
            $jphoneEmoji["%s325%"] = "\x1b\$O9\x0f";
            $jphoneEmoji["%s326%"] = "\x1b\$O:\x0f";
            $jphoneEmoji["%s327%"] = "\x1b\$O;\x0f";
            $jphoneEmoji["%s328%"] = "\x1b\$O<\x0f";
            $jphoneEmoji["%s329%"] = "\x1b\$O=\x0f";
            $jphoneEmoji["%s330%"] = "\x1b\$O>\x0f";
            $jphoneEmoji["%s331%"] = "\x1b\$O?\x0f";
            $jphoneEmoji["%s332%"] = "\x1b\$O@\x0f";
            $jphoneEmoji["%s333%"] = "\x1b\$OA\x0f";
            $jphoneEmoji["%s334%"] = "\x1b\$OB\x0f";
            $jphoneEmoji["%s335%"] = "\x1b\$OC\x0f";
            $jphoneEmoji["%s336%"] = "\x1b\$OD\x0f";
            $jphoneEmoji["%s337%"] = "\x1b\$OE\x0f";
            $jphoneEmoji["%s338%"] = "\x1b\$OF\x0f";
            $jphoneEmoji["%s339%"] = "\x1b\$OG\x0f";
            $jphoneEmoji["%s340%"] = "\x1b\$OH\x0f";
            $jphoneEmoji["%s341%"] = "\x1b\$OI\x0f";
            $jphoneEmoji["%s342%"] = "\x1b\$OJ\x0f";
            $jphoneEmoji["%s343%"] = "\x1b\$OK\x0f";
            $jphoneEmoji["%s344%"] = "\x1b\$OL\x0f";
            $jphoneEmoji["%s345%"] = "\x1b\$OM\x0f";
            $jphoneEmoji["%s346%"] = "\x1b\$ON\x0f";
            $jphoneEmoji["%s347%"] = "\x1b\$OO\x0f";
            $jphoneEmoji["%s348%"] = "\x1b\$OP\x0f";
            $jphoneEmoji["%s349%"] = "\x1b\$OQ\x0f";
            $jphoneEmoji["%s350%"] = "\x1b\$OR\x0f";
            $jphoneEmoji["%s351%"] = "\x1b\$OS\x0f";
            $jphoneEmoji["%s352%"] = "\x1b\$OT\x0f";
            $jphoneEmoji["%s353%"] = "\x1b\$OU\x0f";
            $jphoneEmoji["%s354%"] = "\x1b\$OV\x0f";
            $jphoneEmoji["%s355%"] = "\x1b\$OW\x0f";
            $jphoneEmoji["%s356%"] = "\x1b\$OX\x0f";
            $jphoneEmoji["%s357%"] = "\x1b\$OY\x0f";
            $jphoneEmoji["%s358%"] = "\x1b\$OZ\x0f";
            $jphoneEmoji["%s359%"] = "\x1b\$O[\x0f";
            $jphoneEmoji["%s360%"] = "\x1b\$O\\x0f";
            $jphoneEmoji["%s361%"] = "\x1b\$O]\x0f";
            $jphoneEmoji["%s362%"] = "\x1b\$O^\x0f";
            $jphoneEmoji["%s363%"] = "\x1b\$O_\x0f";
            $jphoneEmoji["%s364%"] = "\x1b\$O`\x0f";
            $jphoneEmoji["%s365%"] = "\x1b\$Oa\x0f";
            $jphoneEmoji["%s366%"] = "\x1b\$Ob\x0f";
            $jphoneEmoji["%s367%"] = "\x1b\$Oc\x0f";
            $jphoneEmoji["%s368%"] = "\x1b\$Od\x0f";
            $jphoneEmoji["%s369%"] = "\x1b\$Oe\x0f";
            $jphoneEmoji["%s370%"] = "\x1b\$Of\x0f";
            $jphoneEmoji["%s371%"] = "\x1b\$Og\x0f";
            $jphoneEmoji["%s372%"] = "\x1b\$Oh\x0f";
            $jphoneEmoji["%s373%"] = "\x1b\$Oi\x0f";
            $jphoneEmoji["%s374%"] = "\x1b\$Oj\x0f";
            $jphoneEmoji["%s375%"] = "\x1b\$Ok\x0f";
            $jphoneEmoji["%s376%"] = "\x1b\$Ol\x0f";
            $jphoneEmoji["%s377%"] = "\x1b\$Om\x0f";
            $jphoneEmoji["%s401%"] = "\x1b\$P!\x0f";
            $jphoneEmoji["%s402%"] = "\x1b\$P\"\x0f";
            $jphoneEmoji["%s403%"] = "\x1b\$P#\x0f";
            $jphoneEmoji["%s404%"] = "\x1b\$P\$\x0f";
            $jphoneEmoji["%s405%"] = "\x1b\$P%\x0f";
            $jphoneEmoji["%s406%"] = "\x1b\$P&\x0f";
            $jphoneEmoji["%s407%"] = "\x1b\$P'\x0f";
            $jphoneEmoji["%s408%"] = "\x1b\$P(\x0f";
            $jphoneEmoji["%s409%"] = "\x1b\$P)\x0f";
            $jphoneEmoji["%s410%"] = "\x1b\$P*\x0f";
            $jphoneEmoji["%s411%"] = "\x1b\$P+\x0f";
            $jphoneEmoji["%s412%"] = "\x1b\$P,\x0f";
            $jphoneEmoji["%s413%"] = "\x1b\$P-\x0f";
            $jphoneEmoji["%s414%"] = "\x1b\$P.\x0f";
            $jphoneEmoji["%s415%"] = "\x1b\$P/\x0f";
            $jphoneEmoji["%s416%"] = "\x1b\$P0\x0f";
            $jphoneEmoji["%s417%"] = "\x1b\$P1\x0f";
            $jphoneEmoji["%s418%"] = "\x1b\$P2\x0f";
            $jphoneEmoji["%s419%"] = "\x1b\$P3\x0f";
            $jphoneEmoji["%s420%"] = "\x1b\$P4\x0f";
            $jphoneEmoji["%s421%"] = "\x1b\$P5\x0f";
            $jphoneEmoji["%s422%"] = "\x1b\$P6\x0f";
            $jphoneEmoji["%s423%"] = "\x1b\$P7\x0f";
            $jphoneEmoji["%s424%"] = "\x1b\$P8\x0f";
            $jphoneEmoji["%s425%"] = "\x1b\$P9\x0f";
            $jphoneEmoji["%s426%"] = "\x1b\$P:\x0f";
            $jphoneEmoji["%s427%"] = "\x1b\$P;\x0f";
            $jphoneEmoji["%s428%"] = "\x1b\$P<\x0f";
            $jphoneEmoji["%s429%"] = "\x1b\$P=\x0f";
            $jphoneEmoji["%s430%"] = "\x1b\$P>\x0f";
            $jphoneEmoji["%s431%"] = "\x1b\$P?\x0f";
            $jphoneEmoji["%s432%"] = "\x1b\$P@\x0f";
            $jphoneEmoji["%s433%"] = "\x1b\$PA\x0f";
            $jphoneEmoji["%s434%"] = "\x1b\$PB\x0f";
            $jphoneEmoji["%s435%"] = "\x1b\$PC\x0f";
            $jphoneEmoji["%s436%"] = "\x1b\$PD\x0f";
            $jphoneEmoji["%s437%"] = "\x1b\$PE\x0f";
            $jphoneEmoji["%s438%"] = "\x1b\$PF\x0f";
            $jphoneEmoji["%s439%"] = "\x1b\$PG\x0f";
            $jphoneEmoji["%s440%"] = "\x1b\$PH\x0f";
            $jphoneEmoji["%s441%"] = "\x1b\$PI\x0f";
            $jphoneEmoji["%s442%"] = "\x1b\$PJ\x0f";
            $jphoneEmoji["%s443%"] = "\x1b\$PK\x0f";
            $jphoneEmoji["%s444%"] = "\x1b\$PL\x0f";
            $jphoneEmoji["%s445%"] = "\x1b\$PM\x0f";
            $jphoneEmoji["%s446%"] = "\x1b\$PN\x0f";
            $jphoneEmoji["%s447%"] = "\x1b\$PO\x0f";
            $jphoneEmoji["%s448%"] = "\x1b\$PP\x0f";
            $jphoneEmoji["%s449%"] = "\x1b\$PQ\x0f";
            $jphoneEmoji["%s450%"] = "\x1b\$PR\x0f";
            $jphoneEmoji["%s451%"] = "\x1b\$PS\x0f";
            $jphoneEmoji["%s452%"] = "\x1b\$PT\x0f";
            $jphoneEmoji["%s453%"] = "\x1b\$PU\x0f";
            $jphoneEmoji["%s454%"] = "\x1b\$PV\x0f";
            $jphoneEmoji["%s455%"] = "\x1b\$PW\x0f";
            $jphoneEmoji["%s456%"] = "\x1b\$PX\x0f";
            $jphoneEmoji["%s457%"] = "\x1b\$PY\x0f";
            $jphoneEmoji["%s458%"] = "\x1b\$PZ\x0f";
            $jphoneEmoji["%s459%"] = "\x1b\$P[\x0f";
            $jphoneEmoji["%s460%"] = "\x1b\$P\\x0f";
            $jphoneEmoji["%s461%"] = "\x1b\$P]\x0f";
            $jphoneEmoji["%s462%"] = "\x1b\$P^\x0f";
            $jphoneEmoji["%s463%"] = "\x1b\$P_\x0f";
            $jphoneEmoji["%s464%"] = "\x1b\$P`\x0f";
            $jphoneEmoji["%s465%"] = "\x1b\$Pa\x0f";
            $jphoneEmoji["%s466%"] = "\x1b\$Pb\x0f";
            $jphoneEmoji["%s467%"] = "\x1b\$Pc\x0f";
            $jphoneEmoji["%s468%"] = "\x1b\$Pd\x0f";
            $jphoneEmoji["%s469%"] = "\x1b\$Pe\x0f";
            $jphoneEmoji["%s470%"] = "\x1b\$Pf\x0f";
            $jphoneEmoji["%s471%"] = "\x1b\$Pg\x0f";
            $jphoneEmoji["%s472%"] = "\x1b\$Ph\x0f";
            $jphoneEmoji["%s473%"] = "\x1b\$Pi\x0f";
            $jphoneEmoji["%s474%"] = "\x1b\$Pj\x0f";
            $jphoneEmoji["%s475%"] = "\x1b\$Pk\x0f";
            $jphoneEmoji["%s476%"] = "\x1b\$Pl\x0f";
            $jphoneEmoji["%s501%"] = "\x1b\$Q!\x0f";
            $jphoneEmoji["%s502%"] = "\x1b\$Q\"\x0f";
            $jphoneEmoji["%s503%"] = "\x1b\$Q#\x0f";
            $jphoneEmoji["%s504%"] = "\x1b\$Q\$\x0f";
            $jphoneEmoji["%s505%"] = "\x1b\$Q%\x0f";
            $jphoneEmoji["%s506%"] = "\x1b\$Q&\x0f";
            $jphoneEmoji["%s507%"] = "\x1b\$Q'\x0f";
            $jphoneEmoji["%s508%"] = "\x1b\$Q(\x0f";
            $jphoneEmoji["%s509%"] = "\x1b\$Q)\x0f";
            $jphoneEmoji["%s510%"] = "\x1b\$Q*\x0f";
            $jphoneEmoji["%s511%"] = "\x1b\$Q+\x0f";
            $jphoneEmoji["%s512%"] = "\x1b\$Q,\x0f";
            $jphoneEmoji["%s513%"] = "\x1b\$Q-\x0f";
            $jphoneEmoji["%s514%"] = "\x1b\$Q.\x0f";
            $jphoneEmoji["%s515%"] = "\x1b\$Q/\x0f";
            $jphoneEmoji["%s516%"] = "\x1b\$Q0\x0f";
            $jphoneEmoji["%s517%"] = "\x1b\$Q1\x0f";
            $jphoneEmoji["%s518%"] = "\x1b\$Q2\x0f";
            $jphoneEmoji["%s519%"] = "\x1b\$Q3\x0f";
            $jphoneEmoji["%s520%"] = "\x1b\$Q4\x0f";
            $jphoneEmoji["%s521%"] = "\x1b\$Q5\x0f";
            $jphoneEmoji["%s522%"] = "\x1b\$Q6\x0f";
            $jphoneEmoji["%s523%"] = "\x1b\$Q7\x0f";
            $jphoneEmoji["%s524%"] = "\x1b\$Q8\x0f";
            $jphoneEmoji["%s525%"] = "\x1b\$Q9\x0f";
            $jphoneEmoji["%s526%"] = "\x1b\$Q:\x0f";
            $jphoneEmoji["%s527%"] = "\x1b\$Q;\x0f";
            $jphoneEmoji["%s528%"] = "\x1b\$Q<\x0f";
            $jphoneEmoji["%s529%"] = "\x1b\$Q=\x0f";
            $jphoneEmoji["%s530%"] = "\x1b\$Q>\x0f";
            $jphoneEmoji["%s531%"] = "\x1b\$Q?\x0f";
            $jphoneEmoji["%s532%"] = "\x1b\$Q@\x0f";
            $jphoneEmoji["%s533%"] = "\x1b\$QA\x0f";
            $jphoneEmoji["%s534%"] = "\x1b\$QB\x0f";
            $jphoneEmoji["%s535%"] = "\x1b\$QC\x0f";
            $jphoneEmoji["%s536%"] = "\x1b\$QD\x0f";
            $jphoneEmoji["%s537%"] = "\x1b\$QE\x0f";
            $jphoneEmoji["%s538%"] = "\x1b\$QF\x0f";
            $jphoneEmoji["%s539%"] = "\x1b\$QG\x0f";
            $jphoneEmoji["%s540%"] = "\x1b\$QH\x0f";
            $jphoneEmoji["%s541%"] = "\x1b\$QI\x0f";
            $jphoneEmoji["%s542%"] = "\x1b\$QJ\x0f";
            $jphoneEmoji["%s543%"] = "\x1b\$QK\x0f";
            $jphoneEmoji["%s544%"] = "\x1b\$QL\x0f";
            $jphoneEmoji["%s545%"] = "\x1b\$QM\x0f";
            $jphoneEmoji["%s546%"] = "\x1b\$QN\x0f";
            $jphoneEmoji["%s547%"] = "\x1b\$QO\x0f";
            $jphoneEmoji["%s548%"] = "\x1b\$QP\x0f";
            $jphoneEmoji["%s549%"] = "\x1b\$QQ\x0f";
            $jphoneEmoji["%s550%"] = "\x1b\$QR\x0f";
            $jphoneEmoji["%s551%"] = "\x1b\$QS\x0f";
            $jphoneEmoji["%s552%"] = "\x1b\$QT\x0f";
            $jphoneEmoji["%s553%"] = "\x1b\$QU\x0f";
            $jphoneEmoji["%s554%"] = "\x1b\$QV\x0f";
            $jphoneEmoji["%s555%"] = "\x1b\$QW\x0f";
        }

        return $jphoneEmoji;
    }

    /**
     * getEzwebToDocomoMailメソッド
     *
     * Ezweb用の変換文字をキーにしたDocomo絵文字データ配列を返します。
     * メール送信用
     * @return $ezwebToDocomo Docomo絵文字配列
     */
    public static function getEzwebToDocomoMail() {
        static $ezwebToDocomo;

        if (!isset($ezwebToDocomo)) {
            $ezwebToDocomo["%e1%"] = "\xf9\xdc";
            $ezwebToDocomo["%e104%"] = "\xf8\xd6";
            $ezwebToDocomo["%e106%"] = "\xf8\xdf";
            $ezwebToDocomo["%e107%"] = "\xf8\xa0";
            $ezwebToDocomo["%e108%"] = "\xf9\x77";
            $ezwebToDocomo["%e109%"] = "\xf9\x7a";
            $ezwebToDocomo["%e110%"] = "\xf8\xd8";
            $ezwebToDocomo["%e112%"] = "\xf8\xc4";
            $ezwebToDocomo["%e113%"] = "\xf9\xe8";
            $ezwebToDocomo["%e116%"] = "\xf8\xfb";
            $ezwebToDocomo["%e118%"] = "\xf9\x7e";
            $ezwebToDocomo["%e119%"] = "\xf9\x81";
            $ezwebToDocomo["%e12%"] = "\xf9\xfb";
            $ezwebToDocomo["%e120%"] = "\xf9\x7d";
            $ezwebToDocomo["%e122%"] = "\xf8\xe4";
            $ezwebToDocomo["%e124%"] = "\xf8\xd5";
            $ezwebToDocomo["%e125%"] = "\xf8\xbf";
            $ezwebToDocomo["%e133%"] = "\xf9\xec";
            $ezwebToDocomo["%e134%"] = "\xf9\x45";
            $ezwebToDocomo["%e143%"] = "\xf9\xd5";
            $ezwebToDocomo["%e144%"] = "\xf8\xe6";
            $ezwebToDocomo["%e146%"] = "\xf8\xd0";
            $ezwebToDocomo["%e149%"] = "\xf9\xbe";
            $ezwebToDocomo["%e15%"] = "\xf9\x43";
            $ezwebToDocomo["%e152%"] = "\xf9\xbd";
            $ezwebToDocomo["%e156%"] = "\xf8\xc5";
            $ezwebToDocomo["%e16%"] = "\xf8\xa3";
            $ezwebToDocomo["%e160%"] = "\xf8\xe9";
            $ezwebToDocomo["%e166%"] = "\xf9\x74";
            $ezwebToDocomo["%e168%"] = "\xf8\xc3";
            $ezwebToDocomo["%e169%"] = "\xf9\x47";
            $ezwebToDocomo["%e172%"] = "\xf8\xbc";
            $ezwebToDocomo["%e176%"] = "\xf8\xe0";
            $ezwebToDocomo["%e177%"] = "\xf8\xe1";
            $ezwebToDocomo["%e178%"] = "\xf8\xfc";
            $ezwebToDocomo["%e180%"] = "\xf9\x87";
            $ezwebToDocomo["%e181%"] = "\xf9\x88";
            $ezwebToDocomo["%e182%"] = "\xf9\x89";
            $ezwebToDocomo["%e183%"] = "\xf9\x8a";
            $ezwebToDocomo["%e184%"] = "\xf9\x8b";
            $ezwebToDocomo["%e185%"] = "\xf9\x8c";
            $ezwebToDocomo["%e186%"] = "\xf9\x8d";
            $ezwebToDocomo["%e187%"] = "\xf9\x8e";
            $ezwebToDocomo["%e188%"] = "\xf9\x8f";
            $ezwebToDocomo["%e190%"] = "\xf8\xa4";
            $ezwebToDocomo["%e191%"] = "\xf8\xa2";
            $ezwebToDocomo["%e192%"] = "\xf8\xa7";
            $ezwebToDocomo["%e193%"] = "\xf8\xa8";
            $ezwebToDocomo["%e194%"] = "\xf8\xa9";
            $ezwebToDocomo["%e195%"] = "\xf8\xaa";
            $ezwebToDocomo["%e196%"] = "\xf8\xab";
            $ezwebToDocomo["%e197%"] = "\xf8\xac";
            $ezwebToDocomo["%e198%"] = "\xf8\xad";
            $ezwebToDocomo["%e199%"] = "\xf8\xae";
            $ezwebToDocomo["%e2%"] = "\xf9\xa7";
            $ezwebToDocomo["%e20%"] = "\xf8\xaf";
            $ezwebToDocomo["%e200%"] = "\xf8\xb0";
            $ezwebToDocomo["%e201%"] = "\xf8\xb1";
            $ezwebToDocomo["%e202%"] = "\xf8\xb2";
            $ezwebToDocomo["%e203%"] = "\xf9\xf6";
            $ezwebToDocomo["%e205%"] = "\xf8\xc9";
            $ezwebToDocomo["%e206%"] = "\xf8\xcb";
            $ezwebToDocomo["%e207%"] = "\xf8\xcf";
            $ezwebToDocomo["%e208%"] = "\xf8\xcd";
            $ezwebToDocomo["%e212%"] = "\xf8\xc8";
            $ezwebToDocomo["%e213%"] = "\xf8\xcc";
            $ezwebToDocomo["%e215%"] = "\xf9\xc2";
            $ezwebToDocomo["%e216%"] = "\xf8\xc1";
            $ezwebToDocomo["%e217%"] = "\xf8\xbe";
            $ezwebToDocomo["%e218%"] = "\xf9\xd8";
            $ezwebToDocomo["%e219%"] = "\xf8\xb7";
            $ezwebToDocomo["%e220%"] = "\xf8\xb6";
            $ezwebToDocomo["%e221%"] = "\xf9\xb7";
            $ezwebToDocomo["%e222%"] = "\xf8\xba";
            $ezwebToDocomo["%e224%"] = "\xf9\x9c";
            $ezwebToDocomo["%e226%"] = "\xf9\x50";
            $ezwebToDocomo["%e232%"] = "\xf8\xec";
            $ezwebToDocomo["%e233%"] = "\xf9\xba";
            $ezwebToDocomo["%e234%"] = "\xf9\x48";
            $ezwebToDocomo["%e235%"] = "\xf9\xed";
            $ezwebToDocomo["%e239%"] = "\xf9\xef";
            $ezwebToDocomo["%e241%"] = "\xf9\xe7";
            $ezwebToDocomo["%e244%"] = "\xf9\xee";
            $ezwebToDocomo["%e245%"] = "\xf8\xd4";
            $ezwebToDocomo["%e248%"] = "\xf9\xf9";
            $ezwebToDocomo["%e25%"] = "\xf9\xc4";
            $ezwebToDocomo["%e251%"] = "\xf9\x46";
            $ezwebToDocomo["%e252%"] = "\xf9\xf5";
            $ezwebToDocomo["%e254%"] = "\xf9\xfa";
            $ezwebToDocomo["%e257%"] = "\xf9\x95";
            $ezwebToDocomo["%e258%"] = "\xf9\x96";
            $ezwebToDocomo["%e259%"] = "\xf9\xd2";
            $ezwebToDocomo["%e261%"] = "\xf9\xa6";
            $ezwebToDocomo["%e262%"] = "\xf9\xa1";
            $ezwebToDocomo["%e263%"] = "\xf9\xac";
            $ezwebToDocomo["%e264%"] = "\xf9\xcd";
            $ezwebToDocomo["%e265%"] = "\xf9\x93";
            $ezwebToDocomo["%e266%"] = "\xf9\x94";
            $ezwebToDocomo["%e268%"] = "\xf9\xa3";
            $ezwebToDocomo["%e273%"] = "\xf9\x9e";
            $ezwebToDocomo["%e279%"] = "\xf9\xd9";
            $ezwebToDocomo["%e281%"] = "\xf9\xa2";
            $ezwebToDocomo["%e282%"] = "\xf9\xad";
            $ezwebToDocomo["%e287%"] = "\xf9\xcc";
            $ezwebToDocomo["%e288%"] = "\xf8\xeb";
            $ezwebToDocomo["%e289%"] = "\xf8\xd7";
            $ezwebToDocomo["%e290%"] = "\xf9\xb4";
            $ezwebToDocomo["%e291%"] = "\xf9\xa4";
            $ezwebToDocomo["%e294%"] = "\xf8\xdb";
            $ezwebToDocomo["%e295%"] = "\xf9\xb5";
            $ezwebToDocomo["%e299%"] = "\xf9\x7b";
            $ezwebToDocomo["%e300%"] = "\xf8\xed";
            $ezwebToDocomo["%e305%"] = "\xf8\xa5";
            $ezwebToDocomo["%e306%"] = "\xf8\xb5";
            $ezwebToDocomo["%e307%"] = "\xf8\xb9";
            $ezwebToDocomo["%e308%"] = "\xf8\xbb";
            $ezwebToDocomo["%e309%"] = "\xf8\xdc";
            $ezwebToDocomo["%e311%"] = "\xf8\xde";
            $ezwebToDocomo["%e312%"] = "\xf8\xe5";
            $ezwebToDocomo["%e313%"] = "\xf8\xe7";
            $ezwebToDocomo["%e314%"] = "\xf8\xef";
            $ezwebToDocomo["%e315%"] = "\xf8\xf0";
            $ezwebToDocomo["%e316%"] = "\xf8\xf1";
            $ezwebToDocomo["%e317%"] = "\xf8\xf2";
            $ezwebToDocomo["%e318%"] = "\xf8\xf3";
            $ezwebToDocomo["%e319%"] = "\xf8\xf5";
            $ezwebToDocomo["%e320%"] = "\xf8\xf6";
            $ezwebToDocomo["%e321%"] = "\xf9\x40";
            $ezwebToDocomo["%e322%"] = "\xf9\x41";
            $ezwebToDocomo["%e323%"] = "\xf9\x42";
            $ezwebToDocomo["%e324%"] = "\xf9\x80";
            $ezwebToDocomo["%e325%"] = "\xf9\x90";
            $ezwebToDocomo["%e326%"] = "\xf9\xb0";
            $ezwebToDocomo["%e327%"] = "\xf9\x99";
            $ezwebToDocomo["%e329%"] = "\xf9\xaa";
            $ezwebToDocomo["%e330%"] = "\xf9\xab";
            $ezwebToDocomo["%e333%"] = "\xf9\xf1";
            $ezwebToDocomo["%e334%"] = "\xf9\x82";
            $ezwebToDocomo["%e335%"] = "\xf9\xb3";
            $ezwebToDocomo["%e337%"] = "\xf9\xbb";
            $ezwebToDocomo["%e341%"] = "\xf8\xbd";
            $ezwebToDocomo["%e342%"] = "\xf9\xe5";
            $ezwebToDocomo["%e343%"] = "\xf9\x9b";
            $ezwebToDocomo["%e348%"] = "\xf9\xce";
            $ezwebToDocomo["%e349%"] = "\xf9\xcb";
            $ezwebToDocomo["%e350%"] = "\xf9\xfc";
            $ezwebToDocomo["%e351%"] = "\xf9\xc8";
            $ezwebToDocomo["%e354%"] = "\xf9\xbf";
            $ezwebToDocomo["%e375%"] = "\xf8\xc6";
            $ezwebToDocomo["%e376%"] = "\xf8\xc7";
            $ezwebToDocomo["%e377%"] = "\xf9\xe3";
            $ezwebToDocomo["%e378%"] = "\xf8\xca";
            $ezwebToDocomo["%e379%"] = "\xf8\xc2";
            $ezwebToDocomo["%e385%"] = "\xf9\x7c";
            $ezwebToDocomo["%e386%"] = "\xf9\xe0";
            $ezwebToDocomo["%e387%"] = "\xf9\xde";
            $ezwebToDocomo["%e395%"] = "\xf8\xea";
            $ezwebToDocomo["%e4%"] = "\xf9\x86";
            $ezwebToDocomo["%e400%"] = "\xf9\xf0";
            $ezwebToDocomo["%e414%"] = "\xf8\xee";
            $ezwebToDocomo["%e42%"] = "\xf8\xf8";
            $ezwebToDocomo["%e420%"] = "\xf9\x9f";
            $ezwebToDocomo["%e421%"] = "\xf8\xb8";
            $ezwebToDocomo["%e422%"] = "\xf9\xc3";
            $ezwebToDocomo["%e423%"] = "\xf9\xf2";
            $ezwebToDocomo["%e43%"] = "\xf8\xf7";
            $ezwebToDocomo["%e434%"] = "\xf9\xea";
            $ezwebToDocomo["%e44%"] = "\xf8\x9f";
            $ezwebToDocomo["%e440%"] = "\xf9\xd1";
            $ezwebToDocomo["%e441%"] = "\xf9\x97";
            $ezwebToDocomo["%e443%"] = "\xf9\xd0";
            $ezwebToDocomo["%e444%"] = "\xf9\x98";
            $ezwebToDocomo["%e446%"] = "\xf9\xc6";
            $ezwebToDocomo["%e45%"] = "\xf8\xb4";
            $ezwebToDocomo["%e450%"] = "\xf9\xca";
            $ezwebToDocomo["%e454%"] = "\xf9\xf7";
            $ezwebToDocomo["%e46%"] = "\xf9\x5e";
            $ezwebToDocomo["%e48%"] = "\xf9\xb8";
            $ezwebToDocomo["%e481%"] = "\xf8\xa6";
            $ezwebToDocomo["%e490%"] = "\xf9\x57";
            $ezwebToDocomo["%e494%"] = "\xf8\xdd";
            $ezwebToDocomo["%e508%"] = "\xf9\x52";
            $ezwebToDocomo["%e51%"] = "\xf9\x91";
            $ezwebToDocomo["%e513%"] = "\xf9\x72";
            $ezwebToDocomo["%e52%"] = "\xf8\xd2";
            $ezwebToDocomo["%e53%"] = "\xf9\xe6";
            $ezwebToDocomo["%e54%"] = "\xf9\xd7";
            $ezwebToDocomo["%e58%"] = "\xf9\xc1";
            $ezwebToDocomo["%e65%"] = "\xf8\xd3";
            $ezwebToDocomo["%e70%"] = "\xf8\xd9";
            $ezwebToDocomo["%e71%"] = "\xf9\x49";
            $ezwebToDocomo["%e72%"] = "\xf9\xc0";
            $ezwebToDocomo["%e728%"] = "\xf8\xf9";
            $ezwebToDocomo["%e729%"] = "\xf8\xfa";
            $ezwebToDocomo["%e730%"] = "\xf9\x83";
            $ezwebToDocomo["%e731%"] = "\xf9\x9a";
            $ezwebToDocomo["%e732%"] = "\xf9\xa5";
            $ezwebToDocomo["%e733%"] = "\xf9\xa8";
            $ezwebToDocomo["%e734%"] = "\xf9\xa9";
            $ezwebToDocomo["%e735%"] = "\xf9\xaf";
            $ezwebToDocomo["%e739%"] = "\xf9\xe9";
            $ezwebToDocomo["%e77%"] = "\xf9\xa0";
            $ezwebToDocomo["%e779%"] = "\xf9\xc9";
            $ezwebToDocomo["%e78%"] = "\xf9\xf4";
            $ezwebToDocomo["%e784%"] = "\xf9\x73";
            $ezwebToDocomo["%e791%"] = "\xf9\xd3";
            $ezwebToDocomo["%e803%"] = "\xf9\x92";
            $ezwebToDocomo["%e805%"] = "\xf9\xb6";
            $ezwebToDocomo["%e806%"] = "\xf9\xbc";
            $ezwebToDocomo["%e807%"] = "\xf9\xda";
            $ezwebToDocomo["%e808%"] = "\xf9\xe1";
            $ezwebToDocomo["%e809%"] = "\xf9\xe2";
            $ezwebToDocomo["%e81%"] = "\xf9\xd6";
            $ezwebToDocomo["%e810%"] = "\xf9\xe4";
            $ezwebToDocomo["%e811%"] = "\xf9\xeb";
            $ezwebToDocomo["%e812%"] = "\xf9\xf3";
            $ezwebToDocomo["%e814%"] = "\xf9\xf8";
            $ezwebToDocomo["%e817%"] = "\xf8\xf4";
            $ezwebToDocomo["%e818%"] = "\xf9\x85";
            $ezwebToDocomo["%e82%"] = "\xf9\xdb";
            $ezwebToDocomo["%e83%"] = "\xf8\xe3";
            $ezwebToDocomo["%e85%"] = "\xf8\xe8";
            $ezwebToDocomo["%e93%"] = "\xf8\xd1";
            $ezwebToDocomo["%e94%"] = "\xf8\xe2";
            $ezwebToDocomo["%e95%"] = "\xf8\xa1";
            $ezwebToDocomo["%e99%"] = "\xf8\xce";
        }

        return $ezwebToDocomo;
    }

    /**
     * getSoftbankToDocomoMailメソッド
     *
     * Softbank用の変換文字をキーにしたDocomo絵文字データ配列を返します。
     * メール送信用
     * @return $softbankToDocomo Docomo絵文字配列
     */

    public static function getSoftbankToDocomoMail() {
        static $softbankToDocomo;

        if (!isset($softbankToDocomo)) {
            $softbankToDocomo["%s1%"] = "\xf9\x95";
            $softbankToDocomo["%s2%"] = "\xf9\x95";
            $softbankToDocomo["%s3%"] = "\xf9\x9e";
            $softbankToDocomo["%s4%"] = "\xf9\x95";
            $softbankToDocomo["%s5%"] = "\xf9\x95";
            $softbankToDocomo["%s6%"] = "\xf9\xb3";
            $softbankToDocomo["%s7%"] = "\xf8\xfa";
            $softbankToDocomo["%s8%"] = "\xf8\xe2";
            $softbankToDocomo["%s9%"] = "\xf8\xe8";
            $softbankToDocomo["%s10%"] = "\xf8\xe9";
            $softbankToDocomo["%s11%"] = "\xf9\x74";
            $softbankToDocomo["%s12%"] = "\xf9\xbb";
            $softbankToDocomo["%s13%"] = "\xf9\xa2";
            $softbankToDocomo["%s14%"] = "\xf9\xcc";
            $softbankToDocomo["%s16%"] = "\xf8\xf4";
            $softbankToDocomo["%s17%"] = "\xf8\xf5";
            $softbankToDocomo["%s18%"] = "\xf8\xf6";
            $softbankToDocomo["%s19%"] = "\xf8\xb8";
            $softbankToDocomo["%s20%"] = "\xf8\xb5";
            $softbankToDocomo["%s21%"] = "\xf8\xb6";
            $softbankToDocomo["%s22%"] = "\xf8\xb4";
            $softbankToDocomo["%s23%"] = "\xf9\xb7";
            $softbankToDocomo["%s24%"] = "\xf8\xb7";
            $softbankToDocomo["%s25%"] = "\xf9\xf6";
            $softbankToDocomo["%s26%"] = "\xf9\xf9";
            $softbankToDocomo["%s27%"] = "\xf8\xbf";
            $softbankToDocomo["%s28%"] = "\xf9\x47";
            $softbankToDocomo["%s29%"] = "\xf8\xc3";
            $softbankToDocomo["%s30%"] = "\xf8\xbc";
            $softbankToDocomo["%s31%"] = "\xf8\xbe";
            $softbankToDocomo["%s33%"] = "\xf9\xa7";
            $softbankToDocomo["%s34%"] = "\xf9\x91";
            $softbankToDocomo["%s35%"] = "\xf9\x93";
            $softbankToDocomo["%s36%"] = "\xf9\x5e";
            $softbankToDocomo["%s37%"] = "\xf9\x5e";
            $softbankToDocomo["%s38%"] = "\xf9\x5e";
            $softbankToDocomo["%s39%"] = "\xf9\x5e";
            $softbankToDocomo["%s40%"] = "\xf9\x5e";
            $softbankToDocomo["%s41%"] = "\xf9\x5e";
            $softbankToDocomo["%s42%"] = "\xf9\x5e";
            $softbankToDocomo["%s43%"] = "\xf9\x5e";
            $softbankToDocomo["%s44%"] = "\xf9\x5e";
            $softbankToDocomo["%s45%"] = "\xf9\x5e";
            $softbankToDocomo["%s46%"] = "\xf9\x5e";
            $softbankToDocomo["%s47%"] = "\xf9\x5e";
            $softbankToDocomo["%s48%"] = "\xf9\xed";
            $softbankToDocomo["%s49%"] = "\xf9\xbf";
            $softbankToDocomo["%s51%"] = "\xf9\x48";
            $softbankToDocomo["%s52%"] = "\xf9\xc0";
            $softbankToDocomo["%s53%"] = "\xf9\xc0";
            $softbankToDocomo["%s54%"] = "\xf8\xc4";
            $softbankToDocomo["%s56%"] = "\xf8\xc5";
            $softbankToDocomo["%s58%"] = "\xf8\xcc";
            $softbankToDocomo["%s59%"] = "\xf9\xe5";
            $softbankToDocomo["%s60%"] = "\xf8\xd7";
            $softbankToDocomo["%s61%"] = "\xf8\xd8";
            $softbankToDocomo["%s62%"] = "\xf9\x9b";
            $softbankToDocomo["%s63%"] = "\xf9\x7d";
            $softbankToDocomo["%s67%"] = "\xf8\xd0";
            $softbankToDocomo["%s68%"] = "\xf8\xd2";
            $softbankToDocomo["%s69%"] = "\xf8\xd1";
            $softbankToDocomo["%s70%"] = "\xf9\xef";
            $softbankToDocomo["%s71%"] = "\xf8\xd3";
            $softbankToDocomo["%s72%"] = "\xf8\xa2";
            $softbankToDocomo["%s74%"] = "\xf8\x9f";
            $softbankToDocomo["%s75%"] = "\xf8\xa1";
            $softbankToDocomo["%s76%"] = "\xf9\x43";
            $softbankToDocomo["%s77%"] = "\xf8\xa0";
            $softbankToDocomo["%s79%"] = "\xf9\x46";
            $softbankToDocomo["%s82%"] = "\xf9\x45";
            $softbankToDocomo["%s85%"] = "\xf9\xf5";
            $softbankToDocomo["%s86%"] = "\xf9\x95";
            $softbankToDocomo["%s87%"] = "\xf9\x95";
            $softbankToDocomo["%s88%"] = "\xf9\x97";
            $softbankToDocomo["%s89%"] = "\xf9\x96";
            $softbankToDocomo["%s101%"] = "\xf8\xc6";
            $softbankToDocomo["%s102%"] = "\xf8\xc6";
            $softbankToDocomo["%s103%"] = "\xf9\x73";
            $softbankToDocomo["%s104%"] = "\xf9\x72";
            $softbankToDocomo["%s105%"] = "\xf9\xcd";
            $softbankToDocomo["%s106%"] = "\xf9\xcb";
            $softbankToDocomo["%s107%"] = "\xf9\xfc";
            $softbankToDocomo["%s108%"] = "\xf9\xc8";
            $softbankToDocomo["%s111%"] = "\xf9\xfa";
            $softbankToDocomo["%s114%"] = "\xf9\xbf";
            $softbankToDocomo["%s115%"] = "\xf9\xa0";
            $softbankToDocomo["%s116%"] = "\xf9\xe6";
            $softbankToDocomo["%s117%"] = "\xf9\x9e";
            $softbankToDocomo["%s118%"] = "\xf8\xe6";
            $softbankToDocomo["%s120%"] = "\xf9\x81";
            $softbankToDocomo["%s121%"] = "\xf9\xd8";
            $softbankToDocomo["%s124%"] = "\xf9\xec";
            $softbankToDocomo["%s130%"] = "\xf8\xe3";
            $softbankToDocomo["%s131%"] = "\xf9\x56";
            $softbankToDocomo["%s132%"] = "\xf8\xd4";
            $softbankToDocomo["%s135%"] = "\xf9\x9c";
            $softbankToDocomo["%s137%"] = "\xf8\xde";
            $softbankToDocomo["%s138%"] = "\xf8\xec";
            $softbankToDocomo["%s139%"] = "\xf8\xed";
            $softbankToDocomo["%s142%"] = "\xf8\xeb";
            $softbankToDocomo["%s147%"] = "\xf9\xba";
            $softbankToDocomo["%s150%"] = "\xf8\xba";
            $softbankToDocomo["%s152%"] = "\xf9\xf10";
            $softbankToDocomo["%s153%"] = "\xf9\x47";
            $softbankToDocomo["%s154%"] = "\xf9\xc2";
            $softbankToDocomo["%s160%"] = "\xf9\xa6";
            $softbankToDocomo["%s161%"] = "\xf8\xa3";
            $softbankToDocomo["%s162%"] = "\xf8\xd5";
            $softbankToDocomo["%s163%"] = "\xf9\x9c";
            $softbankToDocomo["%s164%"] = "\xf8\xcf";
            $softbankToDocomo["%s168%"] = "\xf9\x7d";
            $softbankToDocomo["%s169%"] = "\xf9\x7d";
            $softbankToDocomo["%s172%"] = "\xf8\xe4";
            $softbankToDocomo["%s177%"] = "\xf8\xc8";
            $softbankToDocomo["%s178%"] = "\xf8\xce";
            $softbankToDocomo["%s179%"] = "\xf8\xcd";
            $softbankToDocomo["%s181%"] = "\xf8\xcf";
            $softbankToDocomo["%s183%"] = "\xf8\xc6";
            $softbankToDocomo["%s184%"] = "\xf8\xc9";
            $softbankToDocomo["%s185%"] = "\xf8\xc7";
            $softbankToDocomo["%s186%"] = "\xf8\xcb";
            $softbankToDocomo["%s187%"] = "\xf9\xe3";
            $softbankToDocomo["%s188%"] = "\xf8\xca";
            $softbankToDocomo["%s189%"] = "\xf8\xc1";
            $softbankToDocomo["%s190%"] = "\xf8\xbf";
            $softbankToDocomo["%s201%"] = "\xf9\xd9";
            $softbankToDocomo["%s202%"] = "\xf8\xc2";
            $softbankToDocomo["%s204%"] = "\xf9\x9d";
            $softbankToDocomo["%s205%"] = "\xf9\x9d";
            $softbankToDocomo["%s206%"] = "\xf9\x9d";
            $softbankToDocomo["%s208%"] = "\xf8\xe1";
            $softbankToDocomo["%s210%"] = "\xf8\xfc";
            $softbankToDocomo["%s212%"] = "\xf8\xee";
            $softbankToDocomo["%s213%"] = "\xf8\xf0";
            $softbankToDocomo["%s214%"] = "\xf8\xef";
            $softbankToDocomo["%s215%"] = "\xf8\xf1";
            $softbankToDocomo["%s216%"] = "\xf9\x85";
            $softbankToDocomo["%s217%"] = "\xf9\x84";
            $softbankToDocomo["%s218%"] = "\xf9\x82";
            $softbankToDocomo["%s225%"] = "\xf9\x40";
            $softbankToDocomo["%s226%"] = "\xf9\x41";
            $softbankToDocomo["%s227%"] = "\xf9\x42";
            $softbankToDocomo["%s228%"] = "\xf9\x87";
            $softbankToDocomo["%s229%"] = "\xf9\x88";
            $softbankToDocomo["%s230%"] = "\xf9\x89";
            $softbankToDocomo["%s231%"] = "\xf9\x8a";
            $softbankToDocomo["%s232%"] = "\xf9\x8b";
            $softbankToDocomo["%s233%"] = "\xf9\x8c";
            $softbankToDocomo["%s234%"] = "\xf9\x8d";
            $softbankToDocomo["%s235%"] = "\xf9\x8e";
            $softbankToDocomo["%s236%"] = "\xf9\x8f";
            $softbankToDocomo["%s237%"] = "\xf9\x90";
            $softbankToDocomo["%s241%"] = "\xf9\x7c";
            $softbankToDocomo["%s242%"] = "\xf9\xe0";
            $softbankToDocomo["%s243%"] = "\xf9\xde";
            $softbankToDocomo["%s254%"] = "\xf8\xda";
            $softbankToDocomo["%s255%"] = "\xf8\xf8";
            $softbankToDocomo["%s256%"] = "\xf8\xf7";
            $softbankToDocomo["%s257%"] = "\xf9\x49";
            $softbankToDocomo["%s263%"] = "\xf8\xa7";
            $softbankToDocomo["%s264%"] = "\xf8\xa8";
            $softbankToDocomo["%s265%"] = "\xf8\xa9";
            $softbankToDocomo["%s266%"] = "\xf8\xaa";
            $softbankToDocomo["%s267%"] = "\xf8\xab";
            $softbankToDocomo["%s268%"] = "\xf8\xac";
            $softbankToDocomo["%s269%"] = "\xf8\xad";
            $softbankToDocomo["%s270%"] = "\xf8\xae";
            $softbankToDocomo["%s271%"] = "\xf8\xaf";
            $softbankToDocomo["%s272%"] = "\xf8\xb0";
            $softbankToDocomo["%s273%"] = "\xf8\xb1";
            $softbankToDocomo["%s274%"] = "\xf8\xb2";
            $softbankToDocomo["%s277%"] = "\xf9\xb0";
            $softbankToDocomo["%s278%"] = "\xf9\xd6";
            $softbankToDocomo["%s279%"] = "\xf9\xdb";
            $softbankToDocomo["%s282%"] = "\xf9\xdc";
            $softbankToDocomo["%s301%"] = "\xf8\xea";
            $softbankToDocomo["%s304%"] = "\xf9\xe8";
            $softbankToDocomo["%s310%"] = "\xf8\xdb";
            $softbankToDocomo["%s311%"] = "\xf9\xf0";
            $softbankToDocomo["%s312%"] = "\xf8\xd3";
            $softbankToDocomo["%s314%"] = "\xf8\xdf";
            $softbankToDocomo["%s317%"] = "\xf9\xa3";
            $softbankToDocomo["%s319%"] = "\xf8\xd5";
            $softbankToDocomo["%s320%"] = "\xf8\xe5";
            $softbankToDocomo["%s321%"] = "\xf9\xda";
            $softbankToDocomo["%s326%"] = "\xf8\xd5";
            $softbankToDocomo["%s328%"] = "\xf9\xb5";
            $softbankToDocomo["%s331%"] = "\xf8\xd6";
            $softbankToDocomo["%s335%"] = "\xf8\xe3";
            $softbankToDocomo["%s336%"] = "\xf9\x50";
            $softbankToDocomo["%s337%"] = "\xf9\xb8";
            $softbankToDocomo["%s338%"] = "\xf9\xa4";
            $softbankToDocomo["%s339%"] = "\xf9\x91";
            $softbankToDocomo["%s340%"] = "\xf9\x92";
            $softbankToDocomo["%s341%"] = "\xf9\x91";
            $softbankToDocomo["%s342%"] = "\xf9\x91";
            $softbankToDocomo["%s343%"] = "\xf9\x91";
            $softbankToDocomo["%s344%"] = "\xf9\x91";
            $softbankToDocomo["%s345%"] = "\xf9\x91";
            $softbankToDocomo["%s346%"] = "\xf9\x9f";
            $softbankToDocomo["%s348%"] = "\xf9\xad";
            $softbankToDocomo["%s349%"] = "\xf9\xab";
            $softbankToDocomo["%s350%"] = "\xf9\x44";
            $softbankToDocomo["%s352%"] = "\xf9\xa1";
            $softbankToDocomo["%s355%"] = "\xf9\xa7";
            $softbankToDocomo["%s356%"] = "\xf9\xc3";
            $softbankToDocomo["%s357%"] = "\xf9\xf2";
            $softbankToDocomo["%s362%"] = "\xf9\xf1";
            $softbankToDocomo["%s364%"] = "\xf9\xf1";
            $softbankToDocomo["%s366%"] = "\xf9\xee";
            $softbankToDocomo["%s369%"] = "\xf9\xea";
            $softbankToDocomo["%s375%"] = "\xf8\xe7";
            $softbankToDocomo["%s401%"] = "\xf9\xc8";
            $softbankToDocomo["%s402%"] = "\xf9\xd1";
            $softbankToDocomo["%s403%"] = "\xf9\xc5";
            $softbankToDocomo["%s404%"] = "\xf9\xf8";
            $softbankToDocomo["%s405%"] = "\xf9\xce";
            $softbankToDocomo["%s406%"] = "\xf9\xd0";
            $softbankToDocomo["%s407%"] = "\xf9\x98";
            $softbankToDocomo["%s408%"] = "\xf9\xa6";
            $softbankToDocomo["%s409%"] = "\xf9\xcd";
            $softbankToDocomo["%s410%"] = "\xf9\xc6";
            $softbankToDocomo["%s411%"] = "\xf9\xfc";
            $softbankToDocomo["%s413%"] = "\xf9\xcf";
            $softbankToDocomo["%s414%"] = "\xf9\xca";
            $softbankToDocomo["%s415%"] = "\xf9\xc8";
            $softbankToDocomo["%s416%"] = "\xf9\x99";
            $softbankToDocomo["%s417%"] = "\xf9\xd2";
            $softbankToDocomo["%s418%"] = "\xf9\x93";
            $softbankToDocomo["%s419%"] = "\xf9\xd3";
            $softbankToDocomo["%s420%"] = "\xf9\x95";
            $softbankToDocomo["%s421%"] = "\xf9\x95";
            $softbankToDocomo["%s422%"] = "\xf9\xc9";
            $softbankToDocomo["%s423%"] = "\xf9\xcb";
            $softbankToDocomo["%s424%"] = "\xf9\xcb";
            $softbankToDocomo["%s425%"] = "\xf8\xf2";
            $softbankToDocomo["%s427%"] = "\xf8\xf3";
            $softbankToDocomo["%s428%"] = "\xf9\x9e";
            $softbankToDocomo["%s430%"] = "\xf8\xf6";
            $softbankToDocomo["%s432%"] = "\xf9\xb0";
            $softbankToDocomo["%s433%"] = "\xf9\xa5";
            $softbankToDocomo["%s434%"] = "\xf8\xf6";
            $softbankToDocomo["%s435%"] = "\xf9\xd4";
            $softbankToDocomo["%s436%"] = "\xf9\xb0";
            $softbankToDocomo["%s437%"] = "\xf9\x92";
            $softbankToDocomo["%s442%"] = "\xf8\xb9";
            $softbankToDocomo["%s446%"] = "\xf8\xc0";
            $softbankToDocomo["%s452%"] = "\xf8\xbd";
            $softbankToDocomo["%s453%"] = "\xf8\xbe";
            $softbankToDocomo["%s460%"] = "\xf8\xa6";
            $softbankToDocomo["%s462%"] = "\xf9\xe4";
            $softbankToDocomo["%s467%"] = "\xf8\xa4";
            $softbankToDocomo["%s471%"] = "\xf9\xec";
            $softbankToDocomo["%s475%"] = "\xf9\x57";
            $softbankToDocomo["%s501%"] = "\xf8\xc9"."\xf9\x94";
            $softbankToDocomo["%s502%"] = "\xf8\xdc";
            $softbankToDocomo["%s503%"] = "\xf8\xdd";
            $softbankToDocomo["%s507%"] = "\xf8\xd9";
            $softbankToDocomo["%s533%"] = "\xf9\xf4";
            $softbankToDocomo["%s534%"] = "\xf9\xf7";
            $softbankToDocomo["%s535%"] = "\xf9\xf4";
            $softbankToDocomo["%s536%"] = "\xf9\x45";
            $softbankToDocomo["%s541%"] = "\xf8\xa7";
            $softbankToDocomo["%s542%"] = "\xf9\x45";
            $softbankToDocomo["%s554%"] = "\xf8\xf9";
            $softbankToDocomo["%s555%"] = "\xf9\xd7";
        }

        return $softbankToDocomo;
    }

    /**
     * getDocomoToDocomoMailメソッド
     *
     * getDocomoEmojiのエイリアス
     * ※可変関数を使用する都合上必要
     * メール送信用
     *
     * @return $docomoEmoji Docomo絵文字配列
     */
    public static function getDocomoToDocomoMail() {
        return self::getDocomoEmoji();
    }

    /**
     * getDocomoToEzwebMailメソッド
     *
     * Docomo用の変換文字をキーにしたEzweb絵文字データ配列を返します。
     * メール送信用
     *
     * @return $docomoToEzweb Ezweb絵文字配列
     */
    public static function getDocomoToEzwebMail() {
        static $docomoToEzweb;

        if (!isset($docomoToEzweb)) {
            $docomoToEzweb["%i1%"] = "\xEB\x60";
            $docomoToEzweb["%i2%"] = "\xEB\x65";
            $docomoToEzweb["%i3%"] = "\xEB\x64";
            $docomoToEzweb["%i4%"] = "\xEB\x5D";
            $docomoToEzweb["%i5%"] = "\xEB\x5F";
            $docomoToEzweb["%i6%"] = "\xEB\x41";
            $docomoToEzweb["%i7%"] = "\xEC\xB5";
            $docomoToEzweb["%i8%"] = "\xED\xBC";
            $docomoToEzweb["%i9%"] = "\xEB\x67";
            $docomoToEzweb["%i10%"] = "\xEB\x68";
            $docomoToEzweb["%i11%"] = "\xEB\x69";
            $docomoToEzweb["%i12%"] = "\xEB\x6A";
            $docomoToEzweb["%i13%"] = "\xEB\x6B";
            $docomoToEzweb["%i14%"] = "\xEB\x6C";
            $docomoToEzweb["%i15%"] = "\xEB\x6D";
            $docomoToEzweb["%i16%"] = "\xEB\x6E";
            $docomoToEzweb["%i17%"] = "\xEB\x6F";
            $docomoToEzweb["%i18%"] = "\xEB\x70";
            $docomoToEzweb["%i19%"] = "\xEB\x71";
            $docomoToEzweb["%i20%"] = "\xEB\x72";
            $docomoToEzweb["%i21%"] = mb_convert_encoding("[ｽﾎﾟｰﾂ]", "sjis-win", "auto");
            $docomoToEzweb["%i22%"] = "\xEB\x93";
            $docomoToEzweb["%i23%"] = "\xEC\xB6";
            $docomoToEzweb["%i24%"] = "\xEB\x90";
            $docomoToEzweb["%i25%"] = "\xEB\x8F";
            $docomoToEzweb["%i26%"] = "\xED\x80";
            $docomoToEzweb["%i27%"] = "\xEC\xB7";
            $docomoToEzweb["%i28%"] = "\xEB\x92";
            $docomoToEzweb["%i29%"] = "\xEC\xB8";
            $docomoToEzweb["%i30%"] = "\xEB\x8E";
            $docomoToEzweb["%i31%"] = "\xEC\xEC";
            $docomoToEzweb["%i32%"] = "\xEB\x89";
            $docomoToEzweb["%i33%"] = "\xEB\x8A";
            $docomoToEzweb["%i34%"] = "\xEB\x8A";
            $docomoToEzweb["%i35%"] = "\xEB\x88";
            $docomoToEzweb["%i36%"] = "\xED\x55";
            $docomoToEzweb["%i37%"] = "\xEB\x8C";
            $docomoToEzweb["%i38%"] = "\xEB\x84";
            $docomoToEzweb["%i39%"] = "\xEB\x86";
            $docomoToEzweb["%i40%"] = "\xED\x51";
            $docomoToEzweb["%i41%"] = "\xED\x52";
            $docomoToEzweb["%i42%"] = "\xEB\x83";
            $docomoToEzweb["%i43%"] = "\xEB\x7B";
            $docomoToEzweb["%i44%"] = "\xED\x54";
            $docomoToEzweb["%i45%"] = "\xEB\x7C";
            $docomoToEzweb["%i46%"] = "\xEC\x8E";
            $docomoToEzweb["%i47%"] = "\xEB\x7E";
            $docomoToEzweb["%i48%"] = "\xEB\x42";
            $docomoToEzweb["%i49%"] = "\xEB\x7D";
            $docomoToEzweb["%i50%"] = "\xEB\x85";
            $docomoToEzweb["%i51%"] = "\xEC\xB4";
            $docomoToEzweb["%i52%"] = "\xEB\x9B";
            $docomoToEzweb["%i53%"] = "\xEB\x9C";
            $docomoToEzweb["%i54%"] = "\xEB\xAF";
            $docomoToEzweb["%i55%"] = "\xEB\xF3";
            $docomoToEzweb["%i56%"] = "\xEB\xEF";
            $docomoToEzweb["%i57%"] = "\xEB\xDC";
            $docomoToEzweb["%i58%"] = "\xEB\xF0";
            $docomoToEzweb["%i59%"] = "\xEC\x71";
            $docomoToEzweb["%i60%"] = mb_convert_encoding("[遊園地]", "sjis-win", "auto");
            $docomoToEzweb["%i61%"] = "\xEB\xE1";
            $docomoToEzweb["%i62%"] = "\xEC\xB9";
            $docomoToEzweb["%i63%"] = "\xED\xC9";
            $docomoToEzweb["%i64%"] = "\xEC\xBB";
            $docomoToEzweb["%i65%"] = "\xEB\x76";
            $docomoToEzweb["%i66%"] = "\xEB\x55";
            $docomoToEzweb["%i67%"] = "\xEB\x56";
            $docomoToEzweb["%i68%"] = "\xEB\xEE";
            $docomoToEzweb["%i69%"] = "\xEB\x74";
            $docomoToEzweb["%i70%"] = "\xEB\x77";
            $docomoToEzweb["%i71%"] = "\xEC\xBC";
            $docomoToEzweb["%i72%"] = "\xEB\xA8";
            $docomoToEzweb["%i73%"] = "\xEC\xBD";
            $docomoToEzweb["%i74%"] = "\xEC\xB3";
            $docomoToEzweb["%i75%"] = "\xEC\xA5";
            $docomoToEzweb["%i76%"] = "\xED\x65";
            $docomoToEzweb["%i77%"] = "\xEB\xDB";
            $docomoToEzweb["%i78%"] = "\xEB\x9F";
            $docomoToEzweb["%i79%"] = "\xEB\xE5";
            $docomoToEzweb["%i80%"] = "\xED\x78";
            $docomoToEzweb["%i81%"] = "\xEC\xBE";
            $docomoToEzweb["%i82%"] = "\xEC\xBF";
            $docomoToEzweb["%i83%"] = "\xEC\xC0";
            $docomoToEzweb["%i84%"] = "\xEC\xC1";
            $docomoToEzweb["%i85%"] = "\xEC\xC2";
            $docomoToEzweb["%i86%"] = "\xEE\x88";
            $docomoToEzweb["%i87%"] = "\xEC\xC3";
            $docomoToEzweb["%i88%"] = "\xEC\xC4";
            $docomoToEzweb["%i89%"] = "\xEC\x69";
            $docomoToEzweb["%i90%"] = "\xEC\x68";
            $docomoToEzweb["%i91%"] = "\xED\xEB";
            $docomoToEzweb["%i92%"] = "\xED\xEC";
            $docomoToEzweb["%i93%"] = "\xEB\xD7";
            $docomoToEzweb["%i94%"] = "\xEB\x57";
            $docomoToEzweb["%i95%"] = "\xEC\xC5";
            $docomoToEzweb["%i96%"] = "\xEC\xC6";
            $docomoToEzweb["%i97%"] = "\xEC\xC7";
            $docomoToEzweb["%i98%"] = "\xEB\x5E";
            $docomoToEzweb["%i99%"] = mb_convert_encoding("○", "sjis-win", "auto");
            $docomoToEzweb["%i100%"] = "\xEB\xBA";
            $docomoToEzweb["%i101%"] = "\xEB\xB4";
            $docomoToEzweb["%i102%"] = "\xEB\x8D";
            $docomoToEzweb["%i103%"] = "\xEB\xA2";
            $docomoToEzweb["%i104%"] = "\xEC\x72";
            $docomoToEzweb["%i105%"] = "\xEC\xDF";
            $docomoToEzweb["%i106%"] = "\xEE\x66";
            $docomoToEzweb["%i107%"] = "\xEB\xF9";
            $docomoToEzweb["%i108%"] = mb_convert_encoding("[iﾓｰﾄﾞ]", "sjis-win", "auto");
            $docomoToEzweb["%i109%"] = mb_convert_encoding("[iﾓｰﾄﾞ]", "sjis-win", "auto");
            $docomoToEzweb["%i110%"] = "\xEB\xFA";
            $docomoToEzweb["%i111%"] = mb_convert_encoding("[ﾄﾞｺﾓ]", "sjis-win", "auto");
            $docomoToEzweb["%i112%"] = mb_convert_encoding("[ﾄﾞｺﾓﾎﾟｲﾝﾄ]", "sjis-win", "auto");
            $docomoToEzweb["%i113%"] = "\xEC\x9A";
            $docomoToEzweb["%i114%"] = "\xEC\x95";
            $docomoToEzweb["%i115%"] = "\xED\x5B";
            $docomoToEzweb["%i116%"] = "\xEB\xF2";
            $docomoToEzweb["%i117%"] = "\xEC\x79";
            $docomoToEzweb["%i118%"] = "\xEC\xC8";
            $docomoToEzweb["%i119%"] = "\xEB\xF1";
            $docomoToEzweb["%i120%"] = "\xEC\xE5";
            $docomoToEzweb["%i121%"] = "\xED\xED";
            $docomoToEzweb["%i122%"] = mb_convert_encoding("[ﾌﾘｰﾀﾞｲﾔﾙ]", "sjis-win", "auto");
            $docomoToEzweb["%i123%"] = "\xEE\x89";
            $docomoToEzweb["%i124%"] = "\xEC\x48";
            $docomoToEzweb["%i125%"] = "\xEB\xFB";
            $docomoToEzweb["%i126%"] = "\xEB\xFC";
            $docomoToEzweb["%i127%"] = "\xEC\x40";
            $docomoToEzweb["%i128%"] = "\xEC\x41";
            $docomoToEzweb["%i129%"] = "\xEC\x42";
            $docomoToEzweb["%i130%"] = "\xEC\x43";
            $docomoToEzweb["%i131%"] = "\xEC\x44";
            $docomoToEzweb["%i132%"] = "\xEC\x45";
            $docomoToEzweb["%i133%"] = "\xEC\x46";
            $docomoToEzweb["%i134%"] = "\xEC\xC9";
            $docomoToEzweb["%i135%"] = "\xEC\xCA";
            $docomoToEzweb["%i136%"] = "\xEC\xB2";
            $docomoToEzweb["%i137%"] = "\xEE\x79";
            $docomoToEzweb["%i138%"] = "\xEB\x4F";
            $docomoToEzweb["%i139%"] = "\xEB\x50";
            $docomoToEzweb["%i140%"] = "\xEB\x49";
            $docomoToEzweb["%i141%"] = "\xEB\x4A";
            $docomoToEzweb["%i142%"] = "\xED\x94";
            $docomoToEzweb["%i143%"] = "\xED\x97";
            $docomoToEzweb["%i144%"] = "\xEC\xCB";
            $docomoToEzweb["%i145%"] = "\xED\xEE";
            $docomoToEzweb["%i146%"] = "\xEC\xEE";
            $docomoToEzweb["%i147%"] = "\xEB\x95";
            $docomoToEzweb["%i148%"] = mb_convert_encoding("[かわいい]", "sjis-win", "auto");
            $docomoToEzweb["%i149%"] = "\xEB\xC4";
            $docomoToEzweb["%i150%"] = "\xED\x7E";
            $docomoToEzweb["%i151%"] = "\xEB\x4E";
            $docomoToEzweb["%i152%"] = "\xEB\xBE";
            $docomoToEzweb["%i153%"] = "\xEB\xCC";
            $docomoToEzweb["%i154%"] = "\xEB\x52";
            $docomoToEzweb["%i155%"] = "\xEB\xDE";
            $docomoToEzweb["%i156%"] = "\xED\xEF";
            $docomoToEzweb["%i157%"] = "\xEB\x4D";
            $docomoToEzweb["%i158%"] = "\xEB\x5A";
            $docomoToEzweb["%i159%"] = "\xED\xF0";
            $docomoToEzweb["%i160%"] = "\xED\xF1";
            $docomoToEzweb["%i161%"] = "\xEC\xCD";
            $docomoToEzweb["%i162%"] = "\xEC\xCE";
            $docomoToEzweb["%i163%"] = "\xEB\xBF";
            $docomoToEzweb["%i164%"] = "\xEB\xCD";
            $docomoToEzweb["%i165%"] = mb_convert_encoding("ｰ", "sjis-win", "auto");
            $docomoToEzweb["%i166%"] = "\xED\xF2";
            $docomoToEzweb["%i167%"] = "\xEB\x97";
            $docomoToEzweb["%i168%"] = mb_convert_encoding("[ふくろ]", "sjis-win", "auto");
            $docomoToEzweb["%i169%"] = "\xEC\xDA";
            $docomoToEzweb["%i170%"] = mb_convert_encoding("[人影]", "sjis-win", "auto");
            $docomoToEzweb["%i171%"] = mb_convert_encoding("[いす]", "sjis-win", "auto");
            $docomoToEzweb["%i172%"] = "\xED\xC5";
            $docomoToEzweb["%i173%"] = mb_convert_encoding("[soon]", "sjis-win", "auto");
            $docomoToEzweb["%i174%"] = mb_convert_encoding("[on]", "sjis-win", "auto");
            $docomoToEzweb["%i175%"] = mb_convert_encoding("[end]", "sjis-win", "auto");
            $docomoToEzweb["%i176%"] = "\xEC\xB1";
            $docomoToEzweb["%i1001%"] = mb_convert_encoding("[iｱﾌﾟﾘ]", "sjis-win", "auto");
            $docomoToEzweb["%i1002%"] = mb_convert_encoding("[iｱﾌﾟﾘ]", "sjis-win", "auto");
            $docomoToEzweb["%i1003%"] = "\xEC\xE6";
            $docomoToEzweb["%i1004%"] = "\xEB\xDD";
            $docomoToEzweb["%i1005%"] = "\xEB\xE2";
            $docomoToEzweb["%i1006%"] = "\xEE\x7B";
            $docomoToEzweb["%i1007%"] = "\xEB\x91";
            $docomoToEzweb["%i1008%"] = "\xEB\xEB";
            $docomoToEzweb["%i1009%"] = mb_convert_encoding("[ﾄﾞｱ]", "sjis-win", "auto");
            $docomoToEzweb["%i1010%"] = "\xEB\xA0";
            $docomoToEzweb["%i1011%"] = "\xEC\xE8";
            $docomoToEzweb["%i1012%"] = "\xEE\x7C";
            $docomoToEzweb["%i1013%"] = "\xEC\xA4";
            $docomoToEzweb["%i1014%"] = "\xEB\x79";
            $docomoToEzweb["%i1015%"] = "\xEC\xF9";
            $docomoToEzweb["%i1016%"] = "\xEB\xED";
            $docomoToEzweb["%i1017%"] = "\xEB\x54";
            $docomoToEzweb["%i1018%"] = "\xEB\x87";
            $docomoToEzweb["%i1019%"] = "\xED\x82";
            $docomoToEzweb["%i1020%"] = "\xEC\x97";
            $docomoToEzweb["%i1021%"] = "\xED\x94";
            $docomoToEzweb["%i1022%"] = "\xED\x99";
            $docomoToEzweb["%i1023%"] = "\xEB\x49\xEC\xCE";
            $docomoToEzweb["%i1024%"] = "\xEC\xF6";
            $docomoToEzweb["%i1025%"] = "\xEE\x61";
            $docomoToEzweb["%i1026%"] = "\xED\x9D";
            $docomoToEzweb["%i1027%"] = "\xEC\xF4";
            $docomoToEzweb["%i1028%"] = "\xEB\xD2";
            $docomoToEzweb["%i1029%"] = "\xEB\xC0";
            $docomoToEzweb["%i1030%"] = "\xEC\xF3";
            $docomoToEzweb["%i1031%"] = "\xED\x99";
            $docomoToEzweb["%i1032%"] = "\xED\x96";
            $docomoToEzweb["%i1033%"] = "\xED\x93";
            $docomoToEzweb["%i1034%"] = "\xEB\x4B";
            $docomoToEzweb["%i1035%"] = "\xEE\x6D";
            $docomoToEzweb["%i1036%"] = mb_convert_encoding("[NG]", "sjis-win", "auto");
            $docomoToEzweb["%i1037%"] = "\xEB\x78";
            $docomoToEzweb["%i1038%"] = "\xEC\x74";
            $docomoToEzweb["%i1039%"] = "\xEC\x6A";
            $docomoToEzweb["%i1040%"] = "\xEB\x43";
            $docomoToEzweb["%i1041%"] = "\xEB\xCA";
            $docomoToEzweb["%i1042%"] = "\xEE\x7D";
            $docomoToEzweb["%i1043%"] = "\xEC\x75";
            $docomoToEzweb["%i1044%"] = "\xEB\x59";
            $docomoToEzweb["%i1045%"] = mb_convert_encoding("[禁止]", "sjis-win", "auto");
            $docomoToEzweb["%i1046%"] = "\xED\x5D";
            $docomoToEzweb["%i1047%"] = mb_convert_encoding("[合格]", "sjis-win", "auto");
            $docomoToEzweb["%i1048%"] = "\xED\x5C";
            $docomoToEzweb["%i1049%"] = "\xEE\x7E";
            $docomoToEzweb["%i1050%"] = "\xEE\x80";
            $docomoToEzweb["%i1051%"] = "\xED\x53";
            $docomoToEzweb["%i1052%"] = "\xEE\x81";
            $docomoToEzweb["%i1053%"] = "\xEC\xED";
            $docomoToEzweb["%i1054%"] = "\xEB\xEC";
            $docomoToEzweb["%i1055%"] = "\xEB\xAB";
            $docomoToEzweb["%i1056%"] = "\xEB\xBD";
            $docomoToEzweb["%i1057%"] = "\xED\xF6";
            $docomoToEzweb["%i1058%"] = "\xED\x8D";
            $docomoToEzweb["%i1059%"] = "\xEE\x82";
            $docomoToEzweb["%i1060%"] = "\xEB\xA7";
            $docomoToEzweb["%i1061%"] = "\xEB\xA3";
            $docomoToEzweb["%i1062%"] = "\xEB\xAE";
            $docomoToEzweb["%i1063%"] = "\xEB\xA9";
            $docomoToEzweb["%i1064%"] = "\xED\x6A";
            $docomoToEzweb["%i1065%"] = "\xEC\xD1";
            $docomoToEzweb["%i1066%"] = "\xED\x83";
            $docomoToEzweb["%i1067%"] = "\xEE\x83";
            $docomoToEzweb["%i1068%"] = "\xEB\xB9";
            $docomoToEzweb["%i1069%"] = "\xEB\xB5";
            $docomoToEzweb["%i1070%"] = "\xEB\x72";
            $docomoToEzweb["%i1071%"] = "\xED\xA1";
            $docomoToEzweb["%i1072%"] = "\xEE\x85";
            $docomoToEzweb["%i1073%"] = "\xEB\xB1";
            $docomoToEzweb["%i1074%"] = "\xEB\xB7";
            $docomoToEzweb["%i1075%"] = "\xEB\x9A";
            $docomoToEzweb["%i1076%"] = "\xEC\xF5";
        }

        return $docomoToEzweb;
    }

    /**
     * getEzwebToEzwebMailメソッド
     *
     * Ezweb用の変換文字をキーにしたEzweb絵文字データ配列を返します。
     * メール送信用
     *
     * @return $ezwebToEzweb Ezweb絵文字配列
     */
    public static function getEzwebToEzwebMail() {
        static $ezwebToEzweb;

        if (!isset($ezwebToEzweb)) {
            $ezwebToEzweb["%e1%"] = "\xEB\x59";
            $ezwebToEzweb["%e2%"] = "\xEB\x60";
            $ezwebToEzweb["%e3%"] = "\xEB\x5B";
            $ezwebToEzweb["%e4%"] = "\xEC\x48";
            $ezwebToEzweb["%e5%"] = "\xEC\x49";
            $ezwebToEzweb["%e6%"] = "\xEC\x4A";
            $ezwebToEzweb["%e7%"] = "\xEC\x4B";
            $ezwebToEzweb["%e8%"] = "\xEC\x4C";
            $ezwebToEzweb["%e9%"] = "\xEC\x4D";
            $ezwebToEzweb["%e10%"] = "\xEC\x4E";
            $ezwebToEzweb["%e11%"] = "\xEC\x4F";
            $ezwebToEzweb["%e12%"] = "\xEB\x9A";
            $ezwebToEzweb["%e13%"] = "\xEB\xEA";
            $ezwebToEzweb["%e14%"] = "\xEC\x96";
            $ezwebToEzweb["%e15%"] = "\xEB\x5E";
            $ezwebToEzweb["%e16%"] = "\xEB\x5F";
            $ezwebToEzweb["%e17%"] = "\xEC\x50";
            $ezwebToEzweb["%e18%"] = "\xEC\x51";
            $ezwebToEzweb["%e19%"] = "\xEC\x52";
            $ezwebToEzweb["%e20%"] = "\xEC\x53";
            $ezwebToEzweb["%e21%"] = "\xEC\x54";
            $ezwebToEzweb["%e22%"] = "\xEC\x55";
            $ezwebToEzweb["%e23%"] = "\xEC\x56";
            $ezwebToEzweb["%e24%"] = "\xEC\x57";
            $ezwebToEzweb["%e25%"] = "\xEC\x97";
            $ezwebToEzweb["%e26%"] = "\xEC\x58";
            $ezwebToEzweb["%e27%"] = "\xEC\x59";
            $ezwebToEzweb["%e28%"] = "\xEC\x5A";
            $ezwebToEzweb["%e29%"] = "\xEC\x5B";
            $ezwebToEzweb["%e30%"] = "\xEC\x5C";
            $ezwebToEzweb["%e31%"] = "\xEC\x5D";
            $ezwebToEzweb["%e32%"] = "\xEC\x5E";
            $ezwebToEzweb["%e33%"] = "\xEC\x5F";
            $ezwebToEzweb["%e34%"] = "\xEC\x60";
            $ezwebToEzweb["%e35%"] = "\xEC\x61";
            $ezwebToEzweb["%e36%"] = "\xEC\x62";
            $ezwebToEzweb["%e37%"] = "\xEC\x63";
            $ezwebToEzweb["%e38%"] = "\xEC\x64";
            $ezwebToEzweb["%e39%"] = "\xEC\x65";
            $ezwebToEzweb["%e40%"] = "\xEC\x66";
            $ezwebToEzweb["%e41%"] = "\xEC\x67";
            $ezwebToEzweb["%e42%"] = "\xEC\x68";
            $ezwebToEzweb["%e43%"] = "\xEC\x69";
            $ezwebToEzweb["%e44%"] = "\xEB\x60";
            $ezwebToEzweb["%e45%"] = "\xEB\x93";
            $ezwebToEzweb["%e46%"] = "\xEC\xB1";
            $ezwebToEzweb["%e47%"] = "\xEB\x61";
            $ezwebToEzweb["%e48%"] = "\xEB\xEB";
            $ezwebToEzweb["%e49%"] = "\xEC\x7C";
            $ezwebToEzweb["%e50%"] = "\xEB\xD3";
            $ezwebToEzweb["%e51%"] = "\xEC\xB2";
            $ezwebToEzweb["%e52%"] = "\xEB\x9B";
            $ezwebToEzweb["%e53%"] = "\xEB\xEC";
            $ezwebToEzweb["%e54%"] = "\xEC\x6A";
            $ezwebToEzweb["%e55%"] = "\xEC\x6B";
            $ezwebToEzweb["%e56%"] = "\xEC\x7D";
            $ezwebToEzweb["%e57%"] = "\xEC\x98";
            $ezwebToEzweb["%e58%"] = "\xEB\x54";
            $ezwebToEzweb["%e59%"] = "\xEC\x7E";
            $ezwebToEzweb["%e60%"] = "\xEB\x62";
            $ezwebToEzweb["%e61%"] = "\xEC\x6C";
            $ezwebToEzweb["%e62%"] = "\xEC\x6D";
            $ezwebToEzweb["%e63%"] = "\xEC\x6E";
            $ezwebToEzweb["%e64%"] = "\xEC\x6F";
            $ezwebToEzweb["%e65%"] = "\xEB\x9C";
            $ezwebToEzweb["%e66%"] = "\xEC\x70";
            $ezwebToEzweb["%e67%"] = "\xEC\x80";
            $ezwebToEzweb["%e68%"] = "\xEB\xD4";
            $ezwebToEzweb["%e69%"] = "\xEB\x63";
            $ezwebToEzweb["%e70%"] = "\xEC\x71";
            $ezwebToEzweb["%e71%"] = "\xEC\x72";
            $ezwebToEzweb["%e72%"] = "\xEB\xED";
            $ezwebToEzweb["%e73%"] = "\xEC\x73";
            $ezwebToEzweb["%e74%"] = "\xEB\xB8";
            $ezwebToEzweb["%e75%"] = "\xEB\x40";
            $ezwebToEzweb["%e76%"] = "\xEB\x44";
            $ezwebToEzweb["%e77%"] = "\xEB\x4E";
            $ezwebToEzweb["%e78%"] = "\xEB\xB9";
            $ezwebToEzweb["%e79%"] = "\xEC\xAC";
            $ezwebToEzweb["%e80%"] = "\xEB\xD5";
            $ezwebToEzweb["%e81%"] = "\xEC\x74";
            $ezwebToEzweb["%e82%"] = "\xEC\x75";
            $ezwebToEzweb["%e83%"] = "\xEB\x74";
            $ezwebToEzweb["%e84%"] = "\xEC\xAD";
            $ezwebToEzweb["%e85%"] = "\xEC\xB3";
            $ezwebToEzweb["%e86%"] = "\xEB\xD6";
            $ezwebToEzweb["%e87%"] = "\xEC\x99";
            $ezwebToEzweb["%e88%"] = "\xEC\x76";
            $ezwebToEzweb["%e89%"] = "\xEC\x77";
            $ezwebToEzweb["%e90%"] = "\xEC\x90";
            $ezwebToEzweb["%e91%"] = "\xEB\x75";
            $ezwebToEzweb["%e92%"] = "\xEC\x81";
            $ezwebToEzweb["%e93%"] = "\xEC\xB4";
            $ezwebToEzweb["%e94%"] = "\xEB\xEE";
            $ezwebToEzweb["%e95%"] = "\xEB\x64";
            $ezwebToEzweb["%e96%"] = "\xEB\x94";
            $ezwebToEzweb["%e97%"] = "\xEC\x82";
            $ezwebToEzweb["%e98%"] = "\xEB\x5C";
            $ezwebToEzweb["%e99%"] = "\xEB\x42";
            $ezwebToEzweb["%e100%"] = "\xEC\x83";
            $ezwebToEzweb["%e101%"] = "\xEC\x84";
            $ezwebToEzweb["%e102%"] = "\xEC\x85";
            $ezwebToEzweb["%e103%"] = "\xEC\x86";
            $ezwebToEzweb["%e104%"] = "\xEB\xEF";
            $ezwebToEzweb["%e105%"] = "\xEC\x87";
            $ezwebToEzweb["%e106%"] = "\xEB\x76";
            $ezwebToEzweb["%e107%"] = "\xEB\x65";
            $ezwebToEzweb["%e108%"] = "\xEB\xFA";
            $ezwebToEzweb["%e109%"] = "\xEC\x9A";
            $ezwebToEzweb["%e110%"] = "\xEB\xF0";
            $ezwebToEzweb["%e111%"] = "\xEC\x9B";
            $ezwebToEzweb["%e112%"] = "\xEB\x84";
            $ezwebToEzweb["%e113%"] = "\xEB\xBD";
            $ezwebToEzweb["%e114%"] = "\xEC\x9C";
            $ezwebToEzweb["%e115%"] = "\xEC\x9D";
            $ezwebToEzweb["%e116%"] = "\xEB\xD7";
            $ezwebToEzweb["%e117%"] = "\xEC\x78";
            $ezwebToEzweb["%e118%"] = "\xEC\x79";
            $ezwebToEzweb["%e119%"] = "\xEB\xF1";
            $ezwebToEzweb["%e120%"] = "\xEB\xF2";
            $ezwebToEzweb["%e121%"] = "\xEC\x88";
            $ezwebToEzweb["%e122%"] = "\xEB\x77";
            $ezwebToEzweb["%e123%"] = "\xEC\x9E";
            $ezwebToEzweb["%e124%"] = "\xEB\xF3";
            $ezwebToEzweb["%e125%"] = "\xEB\x8A";
            $ezwebToEzweb["%e126%"] = "\xEC\x9F";
            $ezwebToEzweb["%e127%"] = "\xEC\x91";
            $ezwebToEzweb["%e128%"] = "\xEC\x92";
            $ezwebToEzweb["%e129%"] = "\xEB\xF4";
            $ezwebToEzweb["%e130%"] = "\xEC\xA0";
            $ezwebToEzweb["%e131%"] = "\xEC\x89";
            $ezwebToEzweb["%e132%"] = "\xEC\x7A";
            $ezwebToEzweb["%e133%"] = "\xEB\x7A";
            $ezwebToEzweb["%e134%"] = "\xEB\xBA";
            $ezwebToEzweb["%e135%"] = "\xEC\xA1";
            $ezwebToEzweb["%e136%"] = "\xEC\x7B";
            $ezwebToEzweb["%e137%"] = "\xEC\x8A";
            $ezwebToEzweb["%e138%"] = "\xEB\xF5";
            $ezwebToEzweb["%e139%"] = "\xEC\xA2";
            $ezwebToEzweb["%e140%"] = "\xEB\xD8";
            $ezwebToEzweb["%e141%"] = "\xEB\xD9";
            $ezwebToEzweb["%e142%"] = "\xEC\x8B";
            $ezwebToEzweb["%e143%"] = "\xEB\x78";
            $ezwebToEzweb["%e144%"] = "\xEB\xA8";
            $ezwebToEzweb["%e145%"] = "\xEB\xF6";
            $ezwebToEzweb["%e146%"] = "\xEB\x85";
            $ezwebToEzweb["%e147%"] = "\xEC\x8C";
            $ezwebToEzweb["%e148%"] = "\xEB\x8B";
            $ezwebToEzweb["%e149%"] = "\xEB\x79";
            $ezwebToEzweb["%e150%"] = "\xEC\xA3";
            $ezwebToEzweb["%e151%"] = "\xEC\xAE";
            $ezwebToEzweb["%e152%"] = "\xEC\xA4";
            $ezwebToEzweb["%e153%"] = "\xEC\xAF";
            $ezwebToEzweb["%e154%"] = "\xEC\xB0";
            $ezwebToEzweb["%e155%"] = "\xEB\xF7";
            $ezwebToEzweb["%e156%"] = "\xEB\x86";
            $ezwebToEzweb["%e157%"] = "\xEC\x8D";
            $ezwebToEzweb["%e158%"] = "\xEB\x7A";
            $ezwebToEzweb["%e159%"] = "\xEC\x93";
            $ezwebToEzweb["%e160%"] = "\xEB\x9D";
            $ezwebToEzweb["%e161%"] = "\xEC\xA5";
            $ezwebToEzweb["%e162%"] = "\xEC\xA6";
            $ezwebToEzweb["%e163%"] = "\xEB\xDA";
            $ezwebToEzweb["%e164%"] = "\xEC\xA7";
            $ezwebToEzweb["%e165%"] = "\xEB\xF8";
            $ezwebToEzweb["%e166%"] = "\xEB\xF9";
            $ezwebToEzweb["%e167%"] = "\xEB\x66";
            $ezwebToEzweb["%e168%"] = "\xEB\x8C";
            $ezwebToEzweb["%e169%"] = "\xEB\x8D";
            $ezwebToEzweb["%e170%"] = "\xEB\xA1";
            $ezwebToEzweb["%e171%"] = "\xEC\xA8";
            $ezwebToEzweb["%e172%"] = "\xEB\x8E";
            $ezwebToEzweb["%e173%"] = "\xEC\xA9";
            $ezwebToEzweb["%e174%"] = "\xEC\xAA";
            $ezwebToEzweb["%e175%"] = "\xEC\xAB";
            $ezwebToEzweb["%e176%"] = "\xEB\x55";
            $ezwebToEzweb["%e177%"] = "\xEB\x56";
            $ezwebToEzweb["%e178%"] = "\xEB\x57";
            $ezwebToEzweb["%e179%"] = "\xEB\x58";
            $ezwebToEzweb["%e180%"] = "\xEB\xFB";
            $ezwebToEzweb["%e181%"] = "\xEB\xFC";
            $ezwebToEzweb["%e182%"] = "\xEC\x40";
            $ezwebToEzweb["%e183%"] = "\xEC\x41";
            $ezwebToEzweb["%e184%"] = "\xEC\x42";
            $ezwebToEzweb["%e185%"] = "\xEC\x43";
            $ezwebToEzweb["%e186%"] = "\xEC\x44";
            $ezwebToEzweb["%e187%"] = "\xEC\x45";
            $ezwebToEzweb["%e188%"] = "\xEC\x46";
            $ezwebToEzweb["%e189%"] = "\xEC\x47";
            $ezwebToEzweb["%e190%"] = "\xEB\x41";
            $ezwebToEzweb["%e191%"] = "\xEB\x5D";
            $ezwebToEzweb["%e192%"] = "\xEB\x67";
            $ezwebToEzweb["%e193%"] = "\xEB\x68";
            $ezwebToEzweb["%e194%"] = "\xEB\x69";
            $ezwebToEzweb["%e195%"] = "\xEB\x6A";
            $ezwebToEzweb["%e196%"] = "\xEB\x6B";
            $ezwebToEzweb["%e197%"] = "\xEB\x6C";
            $ezwebToEzweb["%e198%"] = "\xEB\x6D";
            $ezwebToEzweb["%e199%"] = "\xEB\x6E";
            $ezwebToEzweb["%e200%"] = "\xEB\x6F";
            $ezwebToEzweb["%e201%"] = "\xEB\x70";
            $ezwebToEzweb["%e202%"] = "\xEB\x71";
            $ezwebToEzweb["%e203%"] = "\xEB\x72";
            $ezwebToEzweb["%e204%"] = "\xEB\x73";
            $ezwebToEzweb["%e205%"] = "\xEB\x7B";
            $ezwebToEzweb["%e206%"] = "\xEB\x7C";
            $ezwebToEzweb["%e207%"] = "\xEB\x7D";
            $ezwebToEzweb["%e208%"] = "\xEB\x7E";
            $ezwebToEzweb["%e209%"] = "\xEB\x80";
            $ezwebToEzweb["%e210%"] = "\xEB\x81";
            $ezwebToEzweb["%e211%"] = "\xEB\x82";
            $ezwebToEzweb["%e212%"] = "\xEB\x83";
            $ezwebToEzweb["%e213%"] = "\xEC\x8E";
            $ezwebToEzweb["%e214%"] = "\xEC\x8F";
            $ezwebToEzweb["%e215%"] = "\xEB\x87";
            $ezwebToEzweb["%e216%"] = "\xEB\x88";
            $ezwebToEzweb["%e217%"] = "\xEB\x89";
            $ezwebToEzweb["%e218%"] = "\xEB\x43";
            $ezwebToEzweb["%e219%"] = "\xEB\x8F";
            $ezwebToEzweb["%e220%"] = "\xEB\x90";
            $ezwebToEzweb["%e221%"] = "\xEB\x91";
            $ezwebToEzweb["%e222%"] = "\xEB\x92";
            $ezwebToEzweb["%e223%"] = "\xEB\x45";
            $ezwebToEzweb["%e224%"] = "\xEB\x95";
            $ezwebToEzweb["%e225%"] = "\xEB\x96";
            $ezwebToEzweb["%e226%"] = "\xEB\x97";
            $ezwebToEzweb["%e227%"] = "\xEB\x98";
            $ezwebToEzweb["%e228%"] = "\xEB\x99";
            $ezwebToEzweb["%e229%"] = "\xEB\x46";
            $ezwebToEzweb["%e230%"] = "\xEB\x47";
            $ezwebToEzweb["%e231%"] = "\xEB\x9E";
            $ezwebToEzweb["%e232%"] = "\xEB\x9F";
            $ezwebToEzweb["%e233%"] = "\xEB\xA0";
            $ezwebToEzweb["%e234%"] = "\xEB\xA2";
            $ezwebToEzweb["%e235%"] = "\cEB\xA3";
            $ezwebToEzweb["%e236%"] = "\xEB\xA4";
            $ezwebToEzweb["%e237%"] = "\xEB\xA5";
            $ezwebToEzweb["%e238%"] = "\xEB\xA6";
            $ezwebToEzweb["%e239%"] = "\xEB\xA9";
            $ezwebToEzweb["%e240%"] = "\xEB\xAA";
            $ezwebToEzweb["%e241%"] = "\xEB\xAB";
            $ezwebToEzweb["%e242%"] = "\xEB\xAC";
            $ezwebToEzweb["%e243%"] = "\xEB\xAD";
            $ezwebToEzweb["%e244%"] = "\xEB\xAE";
            $ezwebToEzweb["%e245%"] = "\xEB\xAF";
            $ezwebToEzweb["%e246%"] = "\xEB\x48";
            $ezwebToEzweb["%e247%"] = "\xEB\xB0";
            $ezwebToEzweb["%e248%"] = "\xEB\xB1";
            $ezwebToEzweb["%e249%"] = "\xEB\xB2";
            $ezwebToEzweb["%e250%"] = "\xEB\xB3";
            $ezwebToEzweb["%e251%"] = "\xEB\xB4";
            $ezwebToEzweb["%e252%"] = "\xEB\xB5";
            $ezwebToEzweb["%e253%"] = "\xEB\xB6";
            $ezwebToEzweb["%e254%"] = "\xEB\xB7";
            $ezwebToEzweb["%e255%"] = "\xEB\xBB";
            $ezwebToEzweb["%e256%"] = "\xEB\xBC";
            $ezwebToEzweb["%e257%"] = "\xEB\x49";
            $ezwebToEzweb["%e258%"] = "\xEB\x4A";
            $ezwebToEzweb["%e259%"] = "\xEB\x4B";
            $ezwebToEzweb["%e260%"] = "\xEB\x4C";
            $ezwebToEzweb["%e261%"] = "\xEB\x4D";
            $ezwebToEzweb["%e262%"] = "\xEB\xBE";
            $ezwebToEzweb["%e263%"] = "\xEB\xBF";
            $ezwebToEzweb["%e264%"] = "\xEB\xC0";
            $ezwebToEzweb["%e265%"] = "\xEB\x4F";
            $ezwebToEzweb["%e266%"] = "\xEB\x50";
            $ezwebToEzweb["%e267%"] = "\xEB\x51";
            $ezwebToEzweb["%e268%"] = "\xEB\x52";
            $ezwebToEzweb["%e269%"] = "\xEB\x53";
            $ezwebToEzweb["%e270%"] = "\xEB\xC1";
            $ezwebToEzweb["%e271%"] = "\xEB\xC2";
            $ezwebToEzweb["%e272%"] = "\xEB\xC3";
            $ezwebToEzweb["%e273%"] = "\xEB\xC4";
            $ezwebToEzweb["%e274%"] = "\xEB\xC5";
            $ezwebToEzweb["%e275%"] = "\xEB\xC6";
            $ezwebToEzweb["%e276%"] = "\xEB\xC7";
            $ezwebToEzweb["%e277%"] = "\xEB\xC8";
            $ezwebToEzweb["%e278%"] = "\xEB\xC9";
            $ezwebToEzweb["%e279%"] = "\xEB\xCA";
            $ezwebToEzweb["%e280%"] = "\xEB\xCB";
            $ezwebToEzweb["%e281%"] = "\xEB\xCC";
            $ezwebToEzweb["%e282%"] = "\sEB\xCD";
            $ezwebToEzweb["%e283%"] = "\xEB\xCE";
            $ezwebToEzweb["%e284%"] = "\xEB\xCF";
            $ezwebToEzweb["%e285%"] = "\xEB\xD0";
            $ezwebToEzweb["%e286%"] = "\xEB\xD1";
            $ezwebToEzweb["%e287%"] = "\xEB\xD2";
            $ezwebToEzweb["%e288%"] = "\xEB\xDB";
            $ezwebToEzweb["%e289%"] = "\xEB\xDC";
            $ezwebToEzweb["%e290%"] = "\xEB\xDD";
            $ezwebToEzweb["%e291%"] = "\xEB\xDE";
            $ezwebToEzweb["%e292%"] = "\xEB\xDF";
            $ezwebToEzweb["%e293%"] = "\xEB\xE0";
            $ezwebToEzweb["%e294%"] = "\xEB\xE1";
            $ezwebToEzweb["%e295%"] = "\xEB\xE2";
            $ezwebToEzweb["%e296%"] = "\xEB\xE3";
            $ezwebToEzweb["%e297%"] = "\xEB\xE4";
            $ezwebToEzweb["%e298%"] = "\xEC\x94";
            $ezwebToEzweb["%e299%"] = "\xEC\x95";
            $ezwebToEzweb["%e300%"] = "\xEB\xE5";
            $ezwebToEzweb["%e301%"] = "\xEB\xE6";
            $ezwebToEzweb["%e302%"] = "\xEB\xE7";
            $ezwebToEzweb["%e303%"] = "\xEB\xE8";
            $ezwebToEzweb["%e304%"] = "\xEB\xE9";
            $ezwebToEzweb["%e305%"] = "\xEC\xB5";
            $ezwebToEzweb["%e306%"] = "\xEC\xB6";
            $ezwebToEzweb["%e307%"] = "\xEC\xB7";
            $ezwebToEzweb["%e308%"] = "\xEC\xB8";
            $ezwebToEzweb["%e309%"] = "\xEC\xB9";
            $ezwebToEzweb["%e310%"] = "\xEC\xBA";
            $ezwebToEzweb["%e311%"] = "\xEC\xBB";
            $ezwebToEzweb["%e312%"] = "\xEC\xBC";
            $ezwebToEzweb["%e313%"] = "\xEC\xBD";
            $ezwebToEzweb["%e314%"] = "\xEC\xBE";
            $ezwebToEzweb["%e315%"] = "\xEC\xBF";
            $ezwebToEzweb["%e316%"] = "\xEC\xC0";
            $ezwebToEzweb["%e317%"] = "\xEC\xC1";
            $ezwebToEzweb["%e318%"] = "\xEC\xC2";
            $ezwebToEzweb["%e319%"] = "\xEC\xC3";
            $ezwebToEzweb["%e320%"] = "\xEC\xC4";
            $ezwebToEzweb["%e321%"] = "\xEC\xC5";
            $ezwebToEzweb["%e322%"] = "\xEC\xC6";
            $ezwebToEzweb["%e323%"] = "\xEC\xC7";
            $ezwebToEzweb["%e324%"] = "\xEC\xC8";
            $ezwebToEzweb["%e325%"] = "\xEC\xC9";
            $ezwebToEzweb["%e326%"] = "\xEC\xCA";
            $ezwebToEzweb["%e327%"] = "\xEC\xCB";
            $ezwebToEzweb["%e328%"] = "\xEC\xCC";
            $ezwebToEzweb["%e329%"] = "\xEC\xCD";
            $ezwebToEzweb["%e330%"] = "\xEC\xCE";
            $ezwebToEzweb["%e331%"] = "\xEC\xCF";
            $ezwebToEzweb["%e332%"] = "\xEC\xD0";
            $ezwebToEzweb["%e333%"] = "\xEC\xD1";
            $ezwebToEzweb["%e334%"] = "\xEC\xE5";
            $ezwebToEzweb["%e335%"] = "\xEC\xE6";
            $ezwebToEzweb["%e336%"] = "\xEC\xE7";
            $ezwebToEzweb["%e337%"] = "\xEC\xE8";
            $ezwebToEzweb["%e338%"] = "\xEC\xE9";
            $ezwebToEzweb["%e339%"] = "\xEC\xEA";
            $ezwebToEzweb["%e340%"] = "\xEC\xEB";
            $ezwebToEzweb["%e341%"] = "\xEC\xEC";
            $ezwebToEzweb["%e342%"] = "\xEC\xED";
            $ezwebToEzweb["%e343%"] = "\xEC\xEE";
            $ezwebToEzweb["%e344%"] = "\xEC\xEF";
            $ezwebToEzweb["%e345%"] = "\xEC\xF0";
            $ezwebToEzweb["%e346%"] = "\xEC\xF1";
            $ezwebToEzweb["%e347%"] = "\xEC\xF2";
            $ezwebToEzweb["%e348%"] = "\xEC\xF3";
            $ezwebToEzweb["%e349%"] = "\xEC\xF4";
            $ezwebToEzweb["%e350%"] = "\xEC\xF5";
            $ezwebToEzweb["%e351%"] = "\xEC\xF6";
            $ezwebToEzweb["%e352%"] = "\xEC\xF7";
            $ezwebToEzweb["%e353%"] = "\xEC\xF8";
            $ezwebToEzweb["%e354%"] = "\xEC\xF9";
            $ezwebToEzweb["%e355%"] = "\xEC\xFA";
            $ezwebToEzweb["%e356%"] = "\xEC\xFB";
            $ezwebToEzweb["%e357%"] = "\xEC\xFC";
            $ezwebToEzweb["%e358%"] = "\xED\x40";
            $ezwebToEzweb["%e359%"] = "\xED\x41";
            $ezwebToEzweb["%e360%"] = "\xED\x42";
            $ezwebToEzweb["%e361%"] = "\xED\x43";
            $ezwebToEzweb["%e362%"] = "\xED\x44";
            $ezwebToEzweb["%e363%"] = "\xED\x45";
            $ezwebToEzweb["%e364%"] = "\xED\x46";
            $ezwebToEzweb["%e365%"] = "\xED\x47";
            $ezwebToEzweb["%e366%"] = "\xED\x48";
            $ezwebToEzweb["%e367%"] = "\xED\x49";
            $ezwebToEzweb["%e368%"] = "\xED\x4A";
            $ezwebToEzweb["%e369%"] = "\xED\x4B";
            $ezwebToEzweb["%e370%"] = "\xED\x4C";
            $ezwebToEzweb["%e371%"] = "\xED\x4D";
            $ezwebToEzweb["%e372%"] = "\xED\x4E";
            $ezwebToEzweb["%e373%"] = "\xED\x4F";
            $ezwebToEzweb["%e374%"] = "\xED\x50";
            $ezwebToEzweb["%e375%"] = "\xED\x51";
            $ezwebToEzweb["%e376%"] = "\xED\x52";
            $ezwebToEzweb["%e377%"] = "\xED\x53";
            $ezwebToEzweb["%e378%"] = "\xED\x54";
            $ezwebToEzweb["%e379%"] = "\xED\x55";
            $ezwebToEzweb["%e380%"] = "\xED\x56";
            $ezwebToEzweb["%e381%"] = "\xED\x57";
            $ezwebToEzweb["%e382%"] = "\xED\x58";
            $ezwebToEzweb["%e383%"] = "\xED\x59";
            $ezwebToEzweb["%e384%"] = "\xED\x5A";
            $ezwebToEzweb["%e385%"] = "\xED\x5B";
            $ezwebToEzweb["%e386%"] = "\xED\x5C";
            $ezwebToEzweb["%e387%"] = "\xED\x5D";
            $ezwebToEzweb["%e388%"] = "\xED\x5E";
            $ezwebToEzweb["%e389%"] = "\xED\x5F";
            $ezwebToEzweb["%e390%"] = "\xED\x60";
            $ezwebToEzweb["%e391%"] = "\xED\x61";
            $ezwebToEzweb["%e392%"] = "\xED\x62";
            $ezwebToEzweb["%e393%"] = "\xED\x63";
            $ezwebToEzweb["%e394%"] = "\xED\x64";
            $ezwebToEzweb["%e395%"] = "\xED\x65";
            $ezwebToEzweb["%e396%"] = "\xED\x66";
            $ezwebToEzweb["%e397%"] = "\xED\x67";
            $ezwebToEzweb["%e398%"] = "\xED\x68";
            $ezwebToEzweb["%e399%"] = "\xED\x69";
            $ezwebToEzweb["%e400%"] = "\xED\x6A";
            $ezwebToEzweb["%e401%"] = "\xED\x6B";
            $ezwebToEzweb["%e402%"] = "\xED\x6C";
            $ezwebToEzweb["%e403%"] = "\xED\x6D";
            $ezwebToEzweb["%e404%"] = "\xED\x6E";
            $ezwebToEzweb["%e405%"] = "\xED\x6F";
            $ezwebToEzweb["%e406%"] = "\xED\x70";
            $ezwebToEzweb["%e407%"] = "\xED\x71";
            $ezwebToEzweb["%e408%"] = "\xED\x72";
            $ezwebToEzweb["%e409%"] = "\xED\x73";
            $ezwebToEzweb["%e410%"] = "\xED\x74";
            $ezwebToEzweb["%e411%"] = "\xED\x75";
            $ezwebToEzweb["%e412%"] = "\xED\x76";
            $ezwebToEzweb["%e413%"] = "\xED\x77";
            $ezwebToEzweb["%e414%"] = "\xED\x78";
            $ezwebToEzweb["%e415%"] = "\xED\x79";
            $ezwebToEzweb["%e416%"] = "\xED\x7A";
            $ezwebToEzweb["%e417%"] = "\xED\x7B";
            $ezwebToEzweb["%e418%"] = "\xED\x7C";
            $ezwebToEzweb["%e419%"] = "\xED\x7D";
            $ezwebToEzweb["%e420%"] = "\xED\x7E";
            $ezwebToEzweb["%e421%"] = "\xED\x80";
            $ezwebToEzweb["%e422%"] = "\xED\x81";
            $ezwebToEzweb["%e423%"] = "\xED\x82";
            $ezwebToEzweb["%e424%"] = "\xED\x83";
            $ezwebToEzweb["%e425%"] = "\xED\x84";
            $ezwebToEzweb["%e426%"] = "\xED\x85";
            $ezwebToEzweb["%e427%"] = "\xED\x86";
            $ezwebToEzweb["%e428%"] = "\xED\x87";
            $ezwebToEzweb["%e429%"] = "\xED\x88";
            $ezwebToEzweb["%e430%"] = "\xED\x89";
            $ezwebToEzweb["%e431%"] = "\xED\x8A";
            $ezwebToEzweb["%e432%"] = "\xED\x8B";
            $ezwebToEzweb["%e433%"] = "\xED\x8C";
            $ezwebToEzweb["%e434%"] = "\xED\x8D";
            $ezwebToEzweb["%e435%"] = "\xED\x8E";
            $ezwebToEzweb["%e436%"] = "\xED\x8F";
            $ezwebToEzweb["%e437%"] = "\xED\x90";
            $ezwebToEzweb["%e438%"] = "\xED\x91";
            $ezwebToEzweb["%e439%"] = "\xED\x92";
            $ezwebToEzweb["%e440%"] = "\xED\x93";
            $ezwebToEzweb["%e441%"] = "\xED\x94";
            $ezwebToEzweb["%e442%"] = "\xED\x95";
            $ezwebToEzweb["%e443%"] = "\xED\x96";
            $ezwebToEzweb["%e444%"] = "\xED\x97";
            $ezwebToEzweb["%e445%"] = "\xED\x98";
            $ezwebToEzweb["%e446%"] = "\xED\x99";
            $ezwebToEzweb["%e447%"] = "\xED\x9A";
            $ezwebToEzweb["%e448%"] = "\xED\x9B";
            $ezwebToEzweb["%e449%"] = "\xED\x9C";
            $ezwebToEzweb["%e450%"] = "\xED\x9D";
            $ezwebToEzweb["%e451%"] = "\xED\x9E";
            $ezwebToEzweb["%e452%"] = "\xED\x9F";
            $ezwebToEzweb["%e453%"] = "\xED\xA0";
            $ezwebToEzweb["%e454%"] = "\xED\xA1";
            $ezwebToEzweb["%e455%"] = "\xED\xA2";
            $ezwebToEzweb["%e456%"] = "\xED\xA3";
            $ezwebToEzweb["%e457%"] = "\xED\xA4";
            $ezwebToEzweb["%e458%"] = "\xED\xA5";
            $ezwebToEzweb["%e459%"] = "\xED\xA6";
            $ezwebToEzweb["%e460%"] = "\xED\xA7";
            $ezwebToEzweb["%e461%"] = "\xED\xA8";
            $ezwebToEzweb["%e462%"] = "\xED\xA9";
            $ezwebToEzweb["%e463%"] = "\xED\xAA";
            $ezwebToEzweb["%e464%"] = "\xED\xAB";
            $ezwebToEzweb["%e465%"] = "\xED\xAC";
            $ezwebToEzweb["%e466%"] = "\xED\xAD";
            $ezwebToEzweb["%e467%"] = "\xED\xAE";
            $ezwebToEzweb["%e468%"] = "\xED\xAF";
            $ezwebToEzweb["%e469%"] = "\xED\xB0";
            $ezwebToEzweb["%e470%"] = "\xED\xB1";
            $ezwebToEzweb["%e471%"] = "\xED\xB2";
            $ezwebToEzweb["%e472%"] = "\xED\xB3";
            $ezwebToEzweb["%e473%"] = "\xED\xB4";
            $ezwebToEzweb["%e474%"] = "\xED\xB5";
            $ezwebToEzweb["%e475%"] = "\xED\xB6";
            $ezwebToEzweb["%e476%"] = "\xED\xB7";
            $ezwebToEzweb["%e477%"] = "\xED\xB8";
            $ezwebToEzweb["%e478%"] = "\xED\xB9";
            $ezwebToEzweb["%e479%"] = "\xED\xBA";
            $ezwebToEzweb["%e480%"] = "\xED\xBB";
            $ezwebToEzweb["%e481%"] = "\xED\xBC";
            $ezwebToEzweb["%e482%"] = "\xED\xBD";
            $ezwebToEzweb["%e483%"] = "\xED\xBE";
            $ezwebToEzweb["%e484%"] = "\xED\xBF";
            $ezwebToEzweb["%e485%"] = "\xED\xC0";
            $ezwebToEzweb["%e486%"] = "\xED\xC1";
            $ezwebToEzweb["%e487%"] = "\xED\xC2";
            $ezwebToEzweb["%e488%"] = "\xED\xC3";
            $ezwebToEzweb["%e489%"] = "\xED\xC4";
            $ezwebToEzweb["%e490%"] = "\xED\xC5";
            $ezwebToEzweb["%e491%"] = "\xED\xC6";
            $ezwebToEzweb["%e492%"] = "\xED\xC7";
            $ezwebToEzweb["%e493%"] = "\xED\xC8";
            $ezwebToEzweb["%e494%"] = "\xED\xC9";
            $ezwebToEzweb["%e495%"] = "\xEDx\CA";
            $ezwebToEzweb["%e496%"] = "\xED\xCB";
            $ezwebToEzweb["%e497%"] = "\xED\xCC";
            $ezwebToEzweb["%e498%"] = "\xED\xCD";
            $ezwebToEzweb["%e499%"] = "\xED\xCE";
            $ezwebToEzweb["%e500%"] = "\xEC\xD2";
            $ezwebToEzweb["%e501%"] = "\xEC\xD3";
            $ezwebToEzweb["%e502%"] = "\xEC\xD4";
            $ezwebToEzweb["%e503%"] = "\xEC\xD5";
            $ezwebToEzweb["%e504%"] = "\xEC\xD6";
            $ezwebToEzweb["%e505%"] = "\xEC\xD7";
            $ezwebToEzweb["%e506%"] = "\xEC\xD8";
            $ezwebToEzweb["%e507%"] = "\xEC\xD9";
            $ezwebToEzweb["%e508%"] = "\xEC\xDA";
            $ezwebToEzweb["%e509%"] = "\xEC\xDB";
            $ezwebToEzweb["%e510%"] = "\xEC\xDC";
            $ezwebToEzweb["%e511%"] = "\xEC\xDD";
            $ezwebToEzweb["%e512%"] = "\xEC\xDE";
            $ezwebToEzweb["%e513%"] = "\xEC\xDF";
            $ezwebToEzweb["%e514%"] = "\xEC\xE0";
            $ezwebToEzweb["%e515%"] = "\xEC\xE1";
            $ezwebToEzweb["%e516%"] = "\xEC\xE2";
            $ezwebToEzweb["%e517%"] = "\xEC\xE3";
            $ezwebToEzweb["%e518%"] = "\xEC\xE4";
            $ezwebToEzweb["%e700%"] = "\xED\xCF";
            $ezwebToEzweb["%e701%"] = "\xED\xD0";
            $ezwebToEzweb["%e702%"] = "\xED\xD1";
            $ezwebToEzweb["%e703%"] = "\xED\xD2";
            $ezwebToEzweb["%e704%"] = "\xED\xD3";
            $ezwebToEzweb["%e705%"] = "\xED\xD4";
            $ezwebToEzweb["%e706%"] = "\xED\xD5";
            $ezwebToEzweb["%e707%"] = "\xED\xD6";
            $ezwebToEzweb["%e708%"] = "\xED\xD7";
            $ezwebToEzweb["%e709%"] = "\xED\xD8";
            $ezwebToEzweb["%e710%"] = "\xED\xD9";
            $ezwebToEzweb["%e711%"] = "\xED\xDA";
            $ezwebToEzweb["%e712%"] = "\xED\xDB";
            $ezwebToEzweb["%e713%"] = "\xED\xDC";
            $ezwebToEzweb["%e714%"] = "\xED\xDD";
            $ezwebToEzweb["%e715%"] = "\xED\xDE";
            $ezwebToEzweb["%e716%"] = "\xED\xDF";
            $ezwebToEzweb["%e717%"] = "\xED\xE0";
            $ezwebToEzweb["%e718%"] = "\xED\xE1";
            $ezwebToEzweb["%e719%"] = "\xED\xE2";
            $ezwebToEzweb["%e720%"] = "\xED\xE3";
            $ezwebToEzweb["%e721%"] = "\xED\xE4";
            $ezwebToEzweb["%e722%"] = "\xED\xE5";
            $ezwebToEzweb["%e723%"] = "\xED\xE6";
            $ezwebToEzweb["%e724%"] = "\xED\xE7";
            $ezwebToEzweb["%e725%"] = "\xED\xE8";
            $ezwebToEzweb["%e726%"] = "\xED\xE9";
            $ezwebToEzweb["%e727%"] = "\xED\xEA";
            $ezwebToEzweb["%e728%"] = "\xED\xEB";
            $ezwebToEzweb["%e729%"] = "\xED\xEC";
            $ezwebToEzweb["%e730%"] = "\xED\xED";
            $ezwebToEzweb["%e731%"] = "\xED\xEE";
            $ezwebToEzweb["%e732%"] = "\xED\xEF";
            $ezwebToEzweb["%e733%"] = "\xED\xF0";
            $ezwebToEzweb["%e734%"] = "\xED\xF1";
            $ezwebToEzweb["%e735%"] = "\xED\xF2";
            $ezwebToEzweb["%e736%"] = "\xED\xF3";
            $ezwebToEzweb["%e737%"] = "\xED\xF4";
            $ezwebToEzweb["%e738%"] = "\xED\xF5";
            $ezwebToEzweb["%e739%"] = "\xED\xF6";
            $ezwebToEzweb["%e740%"] = "\xED\xF7";
            $ezwebToEzweb["%e741%"] = "\xED\xF8";
            $ezwebToEzweb["%e742%"] = "\xED\xF9";
            $ezwebToEzweb["%e743%"] = "\xED\xFA";
            $ezwebToEzweb["%e744%"] = "\xED\xFB";
            $ezwebToEzweb["%e745%"] = "\xED\xFC";
            $ezwebToEzweb["%e746%"] = "\xEE\x40";
            $ezwebToEzweb["%e747%"] = "\xEE\x41";
            $ezwebToEzweb["%e748%"] = "\xEE\x42";
            $ezwebToEzweb["%e749%"] = "\xEE\x43";
            $ezwebToEzweb["%e750%"] = "\xEE\x44";
            $ezwebToEzweb["%e751%"] = "\xEE\x45";
            $ezwebToEzweb["%e752%"] = "\xEE\x46";
            $ezwebToEzweb["%e753%"] = "\xEE\x47";
            $ezwebToEzweb["%e754%"] = "\xEE\x48";
            $ezwebToEzweb["%e755%"] = "\xE\xE49";
            $ezwebToEzweb["%e756%"] = "\xEE\x4A";
            $ezwebToEzweb["%e757%"] = "\xEE\x4B";
            $ezwebToEzweb["%e758%"] = "\xEE\x4C";
            $ezwebToEzweb["%e759%"] = "\xEE\x4D";
            $ezwebToEzweb["%e760%"] = "\xEE\x4E";
            $ezwebToEzweb["%e761%"] = "\xEE\x4F";
            $ezwebToEzweb["%e762%"] = "\xEE\x50";
            $ezwebToEzweb["%e763%"] = "\xEE\x51";
            $ezwebToEzweb["%e764%"] = "\xEE\x52";
            $ezwebToEzweb["%e765%"] = "\xEE\x53";
            $ezwebToEzweb["%e766%"] = "\xEE\x54";
            $ezwebToEzweb["%e767%"] = "\xEE\x55";
            $ezwebToEzweb["%e768%"] = "\xEE\x56";
            $ezwebToEzweb["%e769%"] = "\xEE\x57";
            $ezwebToEzweb["%e770%"] = "\xEE\x58";
            $ezwebToEzweb["%e771%"] = "\xEE\x59";
            $ezwebToEzweb["%e772%"] = "\xEE\x5A";
            $ezwebToEzweb["%e773%"] = "\xEE\x5B";
            $ezwebToEzweb["%e774%"] = "\xEE\x5C";
            $ezwebToEzweb["%e775%"] = "\xEE\x5D";
            $ezwebToEzweb["%e776%"] = "\xEE\x5E";
            $ezwebToEzweb["%e777%"] = "\xEE\x5F";
            $ezwebToEzweb["%e778%"] = "\xEE\x60";
            $ezwebToEzweb["%e779%"] = "\xEE\x61";
            $ezwebToEzweb["%e780%"] = "\xEE\x62";
            $ezwebToEzweb["%e781%"] = "\xEE\x63";
            $ezwebToEzweb["%e782%"] = "\xEE\x64";
            $ezwebToEzweb["%e783%"] = "\xEE\x65";
            $ezwebToEzweb["%e784%"] = "\xEE\x66";
            $ezwebToEzweb["%e785%"] = "\xEE\x67";
            $ezwebToEzweb["%e786%"] = "\xEE\x68";
            $ezwebToEzweb["%e787%"] = "\xEE\x69";
            $ezwebToEzweb["%e788%"] = "\xEE\x6A";
            $ezwebToEzweb["%e789%"] = "\xEE\x6B";
            $ezwebToEzweb["%e790%"] = "\xEE\x6C";
            $ezwebToEzweb["%e791%"] = "\xEE\x6D";
            $ezwebToEzweb["%e792%"] = "\xEE\x6E";
            $ezwebToEzweb["%e793%"] = "\xEE\x6F";
            $ezwebToEzweb["%e794%"] = "\xEE\x70";
            $ezwebToEzweb["%e795%"] = "\xEE\x71";
            $ezwebToEzweb["%e796%"] = "\xEE\x72";
            $ezwebToEzweb["%e797%"] = "\xEE\x73";
            $ezwebToEzweb["%e798%"] = "\xEE\x74";
            $ezwebToEzweb["%e799%"] = "\xEE\x75";
            $ezwebToEzweb["%e800%"] = "\xEE\x76";
            $ezwebToEzweb["%e801%"] = "\xEE\x77";
            $ezwebToEzweb["%e802%"] = "\xEE\x78";
            $ezwebToEzweb["%e803%"] = "\xEE\x79";
            $ezwebToEzweb["%e804%"] = "\xEE\x7A";
            $ezwebToEzweb["%e805%"] = "\xEE\x7B";
            $ezwebToEzweb["%e806%"] = "\xEE\x7C";
            $ezwebToEzweb["%e807%"] = "\xEE\x7D";
            $ezwebToEzweb["%e808%"] = "\xEE\x7E";
            $ezwebToEzweb["%e809%"] = "\xEE\x80";
            $ezwebToEzweb["%e810%"] = "\xEE\x81";
            $ezwebToEzweb["%e811%"] = "\xEE\x82";
            $ezwebToEzweb["%e812%"] = "\xEE\x83";
            $ezwebToEzweb["%e813%"] = "\xEE\x84";
            $ezwebToEzweb["%e814%"] = "\xEE\x85";
            $ezwebToEzweb["%e815%"] = "\xEE\x86";
            $ezwebToEzweb["%e816%"] = "\xEE\x87";
            $ezwebToEzweb["%e817%"] = "\xEE\x88";
            $ezwebToEzweb["%e818%"] = "\xEE\x89";
            $ezwebToEzweb["%e819%"] = "\xEE\x8A";
            $ezwebToEzweb["%e820%"] = "\xEE\x8B";
            $ezwebToEzweb["%e821%"] = "\xEE\x8C";
            $ezwebToEzweb["%e822%"] = "\xEE\x8D";
        }

        return $ezwebToEzweb;
    }


    /**
     * getSoftbankToEzwebMailメソッド
     *
     * Softbank用の変換文字をキーにしたEzweb絵文字データ配列を返します。
     * メール送信用
     *
     * @return $softbankToEzweb Ezweb絵文字配列
     */

    public static function getSoftbankToEzwebMail() {
        static $softbankToEzweb;

        if (!isset($softbankToEzweb)) {
            $softbankToEzweb["%s1%"] = "\xEB\xD5";
            $softbankToEzweb["%s2%"] = "\xEB\xD3";
            $softbankToEzweb["%s3%"] = "\xEB\xC4";
            $softbankToEzweb["%s4%"] = "\xEB\xD5";
            $softbankToEzweb["%s5%"] = "\xEB\xD3";
            $softbankToEzweb["%s6%"] = "\xEC\xE6";
            $softbankToEzweb["%s7%"] = "\xEC\xE7";
            $softbankToEzweb["%s8%"] = "\xEB\xEE";
            $softbankToEzweb["%s9%"] = "\xEC\xB3";
            $softbankToEzweb["%s10%"] = "\xEC\xA5";
            $softbankToEzweb["%s11%"] = "\xEB\xF9";
            $softbankToEzweb["%s12%"] = "\xEC\xE8";
            $softbankToEzweb["%s13%"] = "\xEB\xCC";
            $softbankToEzweb["%s14%"] = "\xEB\xD2";
            $softbankToEzweb["%s15%"] = "\xEB\xCF";
            $softbankToEzweb["%s16%"] = "\xEE\x88";
            $softbankToEzweb["%s17%"] = "\xEC\xC3";
            $softbankToEzweb["%s18%"] = "\xEC\xC4";
            $softbankToEzweb["%s19%"] = "\xED\x80";
            $softbankToEzweb["%s20%"] = "\xEC\xB6";
            $softbankToEzweb["%s21%"] = "\xEB\x90";
            $softbankToEzweb["%s22%"] = "\xEB\x93";
            $softbankToEzweb["%s23%"] = "\xEE\x45";
            $softbankToEzweb["%s24%"] = "\xEB\x8F";
            $softbankToEzweb["%s25%"] = "\xEB\x72";
            $softbankToEzweb["%s26%"] = "\xEB\xB1";
            $softbankToEzweb["%s27%"] = "\xEB\x8A";
            $softbankToEzweb["%s28%"] = "\xEB\x8D";
            $softbankToEzweb["%s29%"] = "\xEB\x8C";
            $softbankToEzweb["%s30%"] = "\xEB\x8E";
            $softbankToEzweb["%s31%"] = "\xEB\x89";
            $softbankToEzweb["%s32%"] = "\xEB\x5B";
            $softbankToEzweb["%s33%"] = "\xEB\x5A";
            $softbankToEzweb["%s34%"] = "\xEC\xB2";
            $softbankToEzweb["%s35%"] = "\xEB\x4F";
            $softbankToEzweb["%s36%"] = "\xEC\xB1";
            $softbankToEzweb["%s37%"] = "\xEC\xB1";
            $softbankToEzweb["%s38%"] = "\xEC\xB1";
            $softbankToEzweb["%s39%"] = "\xEC\xB1";
            $softbankToEzweb["%s40%"] = "\xEC\xB1";
            $softbankToEzweb["%s41%"] = "\xEC\xB1";
            $softbankToEzweb["%s42%"] = "\xEC\xB1";
            $softbankToEzweb["%s43%"] = "\xEC\xB1";
            $softbankToEzweb["%s44%"] = "\xEC\xB1";
            $softbankToEzweb["%s45%"] = "\xEC\xB1";
            $softbankToEzweb["%s46%"] = "\xEC\xB1";
            $softbankToEzweb["%s47%"] = "\xEC\xB1";
            $softbankToEzweb["%s48%"] = "\xEB\xA3";
            $softbankToEzweb["%s49%"] = "\xEC\xF9";
            $softbankToEzweb["%s50%"] = "\xEC\xEA";
            $softbankToEzweb["%s51%"] = "\xEB\xA2";
            $softbankToEzweb["%s52%"] = "\xEB\xED";
            $softbankToEzweb["%s53%"] = "\xEB\xED";
            $softbankToEzweb["%s54%"] = "\xEB\x84";
            $softbankToEzweb["%s55%"] = "\xEC\xEB";
            $softbankToEzweb["%s56%"] = "\xEB\x86";
            $softbankToEzweb["%s57%"] = "\xEE\x71";
            $softbankToEzweb["%s58%"] = "\xEC\x8E";
            $softbankToEzweb["%s59%"] = "\xEC\xED";
            $softbankToEzweb["%s60%"] = "\xEB\xDC";
            $softbankToEzweb["%s61%"] = "\xEB\xF0";
            $softbankToEzweb["%s62%"] = "\xEC\xEE";
            $softbankToEzweb["%s63%"] = "\xEB\xF2";
            $softbankToEzweb["%s64%"] = mb_convert_encoding("[ﾊﾟｲﾌﾟ]", "sjis-win", "auto");
            $softbankToEzweb["%s65%"] = "\xEB\xDF";
            $softbankToEzweb["%s66%"] = "\xED\xB0";
            $softbankToEzweb["%s67%"] = "\xEB\x85";
            $softbankToEzweb["%s68%"] = "\xEB\x9B";
            $softbankToEzweb["%s69%"] = "\xEC\xB4";
            $softbankToEzweb["%s70%"] = "\xEB\xA9";
            $softbankToEzweb["%s71%"] = "\xEB\x9C";
            $softbankToEzweb["%s72%"] = "\xEB\x5D";
            $softbankToEzweb["%s73%"] = "\xEB\x65";
            $softbankToEzweb["%s74%"] = "\xEB\x60";
            $softbankToEzweb["%s75%"] = "\xEB\x64";
            $softbankToEzweb["%s76%"] = "\xEB\xE5";
            $softbankToEzweb["%s77%"] = "\xED\xC8";
            $softbankToEzweb["%s78%"] = "\xEC\xEF";
            $softbankToEzweb["%s79%"] = "\xEB\xB4";
            $softbankToEzweb["%s80%"] = "\xEC\xF0";
            $softbankToEzweb["%s81%"] = "\xEC\xF1";
            $softbankToEzweb["%s82%"] = "\xEB\xBA";
            $softbankToEzweb["%s83%"] = "\xEC\xF2";
            $softbankToEzweb["%s84%"] = "\xEB\x48";
            $softbankToEzweb["%s85%"] = "\xEB\xB5";
            $softbankToEzweb["%s86%"] = "\xED\xA1";
            $softbankToEzweb["%s87%"] = "\xEB\x49";
            $softbankToEzweb["%s88%"] = "\xED\x97";
            $softbankToEzweb["%s89%"] = "\xEB\x4A";
            $softbankToEzweb["%s90%"] = "\xEB\xCE";
            $softbankToEzweb["%s101%"] = "\xEB\xF4";
            $softbankToEzweb["%s102%"] = "\xEB\xF4";
            $softbankToEzweb["%s103%"] = "\xEE\x66";
            $softbankToEzweb["%s104%"] = "\xEC\xDF";
            $softbankToEzweb["%s105%"] = "\xEB\xC0";
            $softbankToEzweb["%s106%"] = "\xEC\xF4";
            $softbankToEzweb["%s107%"] = "\xEC\xF5";
            $softbankToEzweb["%s108%"] = "\xEC\xF6";
            $softbankToEzweb["%s109%"] = "\xEB\xB2";
            $softbankToEzweb["%s110%"] = "\xEC\xF7";
            $softbankToEzweb["%s111%"] = "\xEB\xB7";
            $softbankToEzweb["%s112%"] = "\cEB\cC5";
            $softbankToEzweb["%s113%"] = "\xEC\xF8";
            $softbankToEzweb["%s114%"] = "\xEC\xF9";
            $softbankToEzweb["%s115%"] = "\xEB\x4E";
            $softbankToEzweb["%s116%"] = "\xEB\xEC";
            $softbankToEzweb["%s117%"] = "\xEC\xFA";
            $softbankToEzweb["%s118%"] = "\xEB\xA8";
            $softbankToEzweb["%s119%"] = "\xEB\xE3";
            $softbankToEzweb["%s120%"] = "\xEB\xF1";
            $softbankToEzweb["%s121%"] = "\xEB\x43";
            $softbankToEzweb["%s122%"] = "\xEC\xFB";
            $softbankToEzweb["%s123%"] = "\xEC\xFC";
            $softbankToEzweb["%s124%"] = "\xEB\xA7";
            $softbankToEzweb["%s125%"] = "\xED\x40";
            $softbankToEzweb["%s126%"] = "\xEB\xC8";
            $softbankToEzweb["%s127%"] = "\xEB\xA4";
            $softbankToEzweb["%s128%"] = "\xEB\xD1";
            $softbankToEzweb["%s129%"] = "\xEB\x53";
            $softbankToEzweb["%s130%"] = "\xED\x41";
            $softbankToEzweb["%s131%"] = mb_convert_encoding("[いす]", "sjis-win", "auto");
            $softbankToEzweb["%s132%"] = "\xEB\xAF";
            $softbankToEzweb["%s133%"] = "\xED\x42";
            $softbankToEzweb["%s134%"] = "\xED\x43";
            $softbankToEzweb["%s135%"] = "\xEB\x95";
            $softbankToEzweb["%s136%"] = "\xEB\x45";
            $softbankToEzweb["%s137%"] = "\xEB\x76";
            $softbankToEzweb["%s138%"] = "\xEB\xE5";
            $softbankToEzweb["%s139%"] = "\xEB\xE5";
            $softbankToEzweb["%s140%"] = "\xEC\xE9";
            $softbankToEzweb["%s141%"] = "\xEC\x9D";
            $softbankToEzweb["%s142%"] = "\xEB\xDB";
            $softbankToEzweb["%s143%"] = "\xEB\xC5";
            $softbankToEzweb["%s144%"] = mb_convert_encoding("[指定]", "sjis-win", "auto");
            $softbankToEzweb["%s145%"] = "\xED\x44";
            $softbankToEzweb["%s146%"] = "\xED\x45";
            $softbankToEzweb["%s147%"] = "\xEB\xA0";
            $softbankToEzweb["%s148%"] = "\xEB\x9E";
            $softbankToEzweb["%s149%"] = "\xED\x46";
            $softbankToEzweb["%s150%"] = "\xEB\x92";
            $softbankToEzweb["%s151%"] = "\xEB\x46";
            $softbankToEzweb["%s152%"] = "\xEB\xB1";
            $softbankToEzweb["%s153%"] = "\xEB\x8D";
            $softbankToEzweb["%s154%"] = "\xEB\x87";
            $softbankToEzweb["%s155%"] = "\xED\x4A";
            $softbankToEzweb["%s156%"] = mb_convert_encoding("[♂]", "sjis-win", "auto");
            $softbankToEzweb["%s157%"] = mb_convert_encoding("[♀]", "sjis-win", "auto");
            $softbankToEzweb["%s158%"] = "\xED\xD9";
            $softbankToEzweb["%s159%"] = "\xEB\xE9";
            $softbankToEzweb["%s160%"] = "\xEB\x4D";
            $softbankToEzweb["%s161%"] = "\xEB\x5F";
            $softbankToEzweb["%s162%"] = "\xEB\xF3";
            $softbankToEzweb["%s163%"] = "\xED\x4B";
            $softbankToEzweb["%s164%"] = "\xEB\x7D";
            $softbankToEzweb["%s165%"] = "\xEB\xEA";
            $softbankToEzweb["%s166%"] = "\xEB\xEA";
            $softbankToEzweb["%s167%"] = "\xED\x4C";
            $softbankToEzweb["%s168%"] = "\xEB\xF5";
            $softbankToEzweb["%s169%"] = "\xEB\xF5";
            $softbankToEzweb["%s170%"] = "\xED\x4D";
            $softbankToEzweb["%s171%"] = "\xEB\xAA";
            $softbankToEzweb["%s172%"] = "\xEB\x77";
            $softbankToEzweb["%s173%"] = mb_convert_encoding("[$\]", "sjis-win", "auto");
            $softbankToEzweb["%s174%"] = "\xED\x4F";
            $softbankToEzweb["%s175%"] = "\xEB\x81";
            $softbankToEzweb["%s176%"] = "\xEB\xC2";
            $softbankToEzweb["%s177%"] = "\xEB\x83";
            $softbankToEzweb["%s178%"] = "\xEB\x42";
            $softbankToEzweb["%s179%"] = "\xEB\x7E";
            $softbankToEzweb["%s180%"] = "\xEB\x80";
            $softbankToEzweb["%s181%"] = "\xEB\x7D";
            $softbankToEzweb["%s182%"] = "\xED\x50";
            $softbankToEzweb["%s183%"] = "\xED\x51";
            $softbankToEzweb["%s184%"] = "\xEB\x7B";
            $softbankToEzweb["%s185%"] = "\xED\x52";
            $softbankToEzweb["%s186%"] = "\xEB\x7C";
            $softbankToEzweb["%s187%"] = "\xED\x53";
            $softbankToEzweb["%s188%"] = "\xED\x54";
            $softbankToEzweb["%s189%"] = "\xEB\x66";
            $softbankToEzweb["%s190%"] = "\xEB\x8A";
            $softbankToEzweb["%s201%"] = "\xEE\x76";
            $softbankToEzweb["%s202%"] = "\xED\x55";
            $softbankToEzweb["%s203%"] = mb_convert_encoding("[ココ]", "sjis-win", "auto");
            $softbankToEzweb["%s204%"] = "\xEC\xB2";
            $softbankToEzweb["%s205%"] = "\xEB\x51";
            $softbankToEzweb["%s206%"] = "\xEC\x5A";
            $softbankToEzweb["%s207%"] = "\xED\x56";
            $softbankToEzweb["%s208%"] = "\xEB\x56";
            $softbankToEzweb["%s209%"] = "\xEB\x58";
            $softbankToEzweb["%s210%"] = "\xEB\x57";
            $softbankToEzweb["%s211%"] = "\xED\x57";
            $softbankToEzweb["%s212%"] = "\xED\x78";
            $softbankToEzweb["%s213%"] = "\xEC\xBF";
            $softbankToEzweb["%s214%"] = "\xEC\xBE";
            $softbankToEzweb["%s215%"] = "\xEC\xC0";
            $softbankToEzweb["%s216%"] = "\xEE\x89";
            $softbankToEzweb["%s217%"] = mb_convert_encoding("[ﾌﾘｰﾀﾞｲﾔﾙ]", "sjis-win", "auto");
            $softbankToEzweb["%s218%"] = "\xEC\xE5";
            $softbankToEzweb["%s219%"] = "\xEB\xE8";
            $softbankToEzweb["%s220%"] = "\xED\x58";
            $softbankToEzweb["%s221%"] = mb_convert_encoding("[有]", "sjis-win", "auto");
            $softbankToEzweb["%s222%"] = mb_convert_encoding("[無]", "sjis-win", "auto");
            $softbankToEzweb["%s223%"] = mb_convert_encoding("[月]", "sjis-win", "auto");
            $softbankToEzweb["%s224%"] = mb_convert_encoding("[申]", "sjis-win", "auto");
            $softbankToEzweb["%s225%"] = "\xEC\x66";
            $softbankToEzweb["%s226%"] = "\xEC\x67";
            $softbankToEzweb["%s227%"] = "\xEC\x67";
            $softbankToEzweb["%s228%"] = "\xEB\xFB";
            $softbankToEzweb["%s229%"] = "\xEB\xFC";
            $softbankToEzweb["%s230%"] = "\xEC\x40";
            $softbankToEzweb["%s231%"] = "\xEC\x41";
            $softbankToEzweb["%s232%"] = "\xEC\x42";
            $softbankToEzweb["%s233%"] = "\xEC\x43";
            $softbankToEzweb["%s234%"] = "\xEC\x44";
            $softbankToEzweb["%s235%"] = "\xEC\x45";
            $softbankToEzweb["%s236%"] = "\xEC\x46";
            $softbankToEzweb["%s237%"] = "\xEC\xC9";
            $softbankToEzweb["%s238%"] = "\xEB\xD0";
            $softbankToEzweb["%s239%"] = "\xED\x59";
            $softbankToEzweb["%s240%"] = "\xED\x5A";
            $softbankToEzweb["%s241%"] = "\xED\x5B";
            $softbankToEzweb["%s242%"] = "\xED\x5C";
            $softbankToEzweb["%s243%"] = "\xED\x5D";
            $softbankToEzweb["%s244%"] = "\xED\x5E";
            $softbankToEzweb["%s245%"] = "\xED\x5F";
            $softbankToEzweb["%s246%"] = "\xED\x60";
            $softbankToEzweb["%s247%"] = "\xED\x61";
            $softbankToEzweb["%s248%"] = "\xEB\xD8";
            $softbankToEzweb["%s249%"] = "\xEB\xD9";
            $softbankToEzweb["%s250%"] = "\xEC\x5B";
            $softbankToEzweb["%s251%"] = "\xEC\x5C";
            $softbankToEzweb["%s252%"] = "\xEC\x6E";
            $softbankToEzweb["%s253%"] = "\xEC\x6F";
            $softbankToEzweb["%s254%"] = "\xEC\x71";
            $softbankToEzweb["%s255%"] = "\xEC\x68";
            $softbankToEzweb["%s256%"] = "\xEC\x69";
            $softbankToEzweb["%s257%"] = "\xEC\x72";
            $softbankToEzweb["%s258%"] = "\xEC\x4A";
            $softbankToEzweb["%s259%"] = "\xEC\x49";
            $softbankToEzweb["%s260%"] = "\xEC\x4C";
            $softbankToEzweb["%s261%"] = "\xEC\x4B";
            $softbankToEzweb["%s262%"] = "\xED\x62";
            $softbankToEzweb["%s263%"] = "\xEB\x67";
            $softbankToEzweb["%s264%"] = "\xEB\x68";
            $softbankToEzweb["%s265%"] = "\xEB\x69";
            $softbankToEzweb["%s266%"] = "\xEB\x6A";
            $softbankToEzweb["%s267%"] = "\xEB\x6B";
            $softbankToEzweb["%s268%"] = "\xEB\x6C";
            $softbankToEzweb["%s269%"] = "\xEB\x6D";
            $softbankToEzweb["%s270%"] = "\xEB\x6E";
            $softbankToEzweb["%s271%"] = "\xEB\x6F";
            $softbankToEzweb["%s272%"] = "\xEB\x70";
            $softbankToEzweb["%s273%"] = "\xEB\x71";
            $softbankToEzweb["%s274%"] = "\xEB\x72";
            $softbankToEzweb["%s275%"] = "\xEB\x73";
            $softbankToEzweb["%s276%"] = mb_convert_encoding("[TOP]", "sjis-win", "auto");
            $softbankToEzweb["%s277%"] = "\xEC\xCA";
            $softbankToEzweb["%s278%"] = "\xEC\x74";
            $softbankToEzweb["%s279%"] = "\xEC\x75";
            $softbankToEzweb["%s280%"] = "\xED\x63";
            $softbankToEzweb["%s281%"] = "\xED\x64";
            $softbankToEzweb["%s282%"] = "\xEB\x59";
            $softbankToEzweb["%s283%"] = mb_convert_encoding("[家庭教師]", "sjis-win", "auto");
            $softbankToEzweb["%s285%"] = mb_convert_encoding("[土星]", "sjis-win", "auto");
            $softbankToEzweb["%s286%"] = mb_convert_encoding("[紙飛行機]", "sjis-win", "auto");
            $softbankToEzweb["%s287%"] = mb_convert_encoding("[紙飛行機]", "sjis-win", "auto");
            $softbankToEzweb["%s301%"] = "\xED\x65";
            $softbankToEzweb["%s302%"] = "\xED\x66";
            $softbankToEzweb["%s303%"] = "\xED\x67";
            $softbankToEzweb["%s304%"] = "\xEB\xBD";
            $softbankToEzweb["%s305%"] = "\xEB\xBC";
            $softbankToEzweb["%s306%"] = "\xED\x68";
            $softbankToEzweb["%s307%"] = "\xEB\xBB";
            $softbankToEzweb["%s308%"] = "\xED\x69";
            $softbankToEzweb["%s309%"] = mb_convert_encoding("[WC]", "sjis-win", "auto");
            $softbankToEzweb["%s310%"] = "\xEB\xE1";
            $softbankToEzweb["%s311%"] = "\xED\x6A";
            $softbankToEzweb["%s312%"] = "\xED\x6B";
            $softbankToEzweb["%s313%"] = "\xED\x6C";
            $softbankToEzweb["%s314%"] = "\xEB\x55";
            $softbankToEzweb["%s315%"] = "\xED\x6D";
            $softbankToEzweb["%s316%"] = "\xED\x6E";
            $softbankToEzweb["%s317%"] = "\xEB\x52";
            $softbankToEzweb["%s318%"] = "\xED\x6F";
            $softbankToEzweb["%s319%"] = "\xEB\xEF";
            $softbankToEzweb["%s320%"] = "\xEC\xBC";
            $softbankToEzweb["%s321%"] = "\xEB\xCA";
            $softbankToEzweb["%s322%"] = "\xEC\x9F";
            $softbankToEzweb["%s323%"] = "\xEB\xEA";
            $softbankToEzweb["%s324%"] = "\xED\x71";
            $softbankToEzweb["%s325%"] = "\xEE\x6F";
            $softbankToEzweb["%s326%"] = "\xEB\xF3";
            $softbankToEzweb["%s327%"] = "\xED\x72";
            $softbankToEzweb["%s328%"] = "\xEB\xE2";
            $softbankToEzweb["%s329%"] = "\xED\x73";
            $softbankToEzweb["%s330%"] = "\xEB\xE4";
            $softbankToEzweb["%s331%"] = "\xED\x74";
            $softbankToEzweb["%s332%"] = "\xED\x75";
            $softbankToEzweb["%s333%"] = "\xED\x76";
            $softbankToEzweb["%s334%"] = "\xED\x77";
            $softbankToEzweb["%s335%"] = "\xEB\x74";
            $softbankToEzweb["%s336%"] = "\xEB\x97";
            $softbankToEzweb["%s337%"] = "\xEB\xEB";
            $softbankToEzweb["%s338%"] = "\xEB\xDE";
            $softbankToEzweb["%s339%"] = "\xED\x79";
            $softbankToEzweb["%s340%"] = "\xEE\x79";
            $softbankToEzweb["%s341%"] = "\xEB\xC3";
            $softbankToEzweb["%s342%"] = "\xED\x7A";
            $softbankToEzweb["%s343%"] = "\xED\x7B";
            $softbankToEzweb["%s344%"] = "\xED\x7C";
            $softbankToEzweb["%s345%"] = "\xED\x7D";
            $softbankToEzweb["%s346%"] = "\xED\x7E";
            $softbankToEzweb["%s347%"] = "\xEB\x63";
            $softbankToEzweb["%s348%"] = "\xEB\xCD";
            $softbankToEzweb["%s349%"] = "\xEC\xCE";
            $softbankToEzweb["%s350%"] = "\xED\x81";
            $softbankToEzweb["%s351%"] = "\xEC\x6C";
            $softbankToEzweb["%s352%"] = "\xEB\xBE";
            $softbankToEzweb["%s353%"] = "\xEB\x63";
            $softbankToEzweb["%s354%"] = "\xEB\x5B";
            $softbankToEzweb["%s355%"] = "\xEB\x5A";
            $softbankToEzweb["%s356%"] = "\xED\x82";
            $softbankToEzweb["%s357%"] = "\xED\x83";
            $softbankToEzweb["%s358%"] = "\xED\x84";
            $softbankToEzweb["%s359%"] = "\xED\x85";
            $softbankToEzweb["%s360%"] = "\xED\x86";
            $softbankToEzweb["%s361%"] = "\xED\x87";
            $softbankToEzweb["%s362%"] = "\xED\x88";
            $softbankToEzweb["%s363%"] = "\xED\x89";
            $softbankToEzweb["%s364%"] = "\xEC\xD1";
            $softbankToEzweb["%s365%"] = "\xED\x8A";
            $softbankToEzweb["%s366%"] = "\xEB\xAE";
            $softbankToEzweb["%s367%"] = "\xED\x8B";
            $softbankToEzweb["%s368%"] = "\xED\x8C";
            $softbankToEzweb["%s369%"] = "\xED\x8D";
            $softbankToEzweb["%s370%"] = "\xED\x8E";
            $softbankToEzweb["%s371%"] = "\xEB\xAD";
            $softbankToEzweb["%s372%"] = "\xEB\xA6";
            $softbankToEzweb["%s373%"] = "\xED\x8F";
            $softbankToEzweb["%s374%"] = "\xED\x90";
            $softbankToEzweb["%s375%"] = "\xEC\xBD";
            $softbankToEzweb["%s376%"] = "\xED\x91";
            $softbankToEzweb["%s377%"] = "\xED\x92";
            $softbankToEzweb["%s401%"] = "\xEC\xF6";
            $softbankToEzweb["%s402%"] = "\xED\x93";
            $softbankToEzweb["%s403%"] = "\xED\x94";
            $softbankToEzweb["%s404%"] = "\xED\x95";
            $softbankToEzweb["%s405%"] = "\xEC\xF3";
            $softbankToEzweb["%s406%"] = "\xED\x96";
            $softbankToEzweb["%s407%"] = "\xED\x97";
            $softbankToEzweb["%s408%"] = "\xED\x98";
            $softbankToEzweb["%s409%"] = "\xEB\xC0";
            $softbankToEzweb["%s410%"] = "\xED\x99";
            $softbankToEzweb["%s411%"] = "\xED\x9A";
            $softbankToEzweb["%s412%"] = "\xED\x9B";
            $softbankToEzweb["%s413%"] = "\xED\x9C";
            $softbankToEzweb["%s414%"] = "\xED\x9D";
            $softbankToEzweb["%s415%"] = "\xED\x9A";
            $softbankToEzweb["%s416%"] = "\xED\x9E";
            $softbankToEzweb["%s417%"] = "\xEB\x4B";
            $softbankToEzweb["%s418%"] = "\xEE\x68";
            $softbankToEzweb["%s419%"] = "\xEE\x6D";
            $softbankToEzweb["%s420%"] = "\xED\xA1";
            $softbankToEzweb["%s421%"] = "\xEB\x49";
            $softbankToEzweb["%s422%"] = "\xEE\x61";
            $softbankToEzweb["%s423%"] = "\xED\xA2";
            $softbankToEzweb["%s424%"] = "\xED\xA3";
            $softbankToEzweb["%s425%"] = "\xEC\xC1";
            $softbankToEzweb["%s426%"] = "\xED\xA4";
            $softbankToEzweb["%s427%"] = "\xEC\xC2";
            $softbankToEzweb["%s428%"] = "\xED\xA5";
            $softbankToEzweb["%s429%"] = "\xED\xA6";
            $softbankToEzweb["%s430%"] = "\xED\xAA";
            $softbankToEzweb["%s431%"] = "\xED\xA7";
            $softbankToEzweb["%s432%"] = "\xED\xA8";
            $softbankToEzweb["%s433%"] = "\xED\xA9";
            $softbankToEzweb["%s434%"] = "\xED\xAA";
            $softbankToEzweb["%s435%"] = "\xED\xAB";
            $softbankToEzweb["%s436%"] = "\xED\xAC";
            $softbankToEzweb["%s437%"] = "\xED\xAE";
            $softbankToEzweb["%s438%"] = "\xED\xAD";
            $softbankToEzweb["%s439%"] = "\xEE\x8B";
            $softbankToEzweb["%s440%"] = mb_convert_encoding("[ｶｯﾌﾟﾙ]", "sjis-win", "auto");
            $softbankToEzweb["%s441%"] = "\xED\xAF";
            $softbankToEzweb["%s442%"] = "\xEC\xB7";
            $softbankToEzweb["%s443%"] = "\xEB\x94";
            $softbankToEzweb["%s444%"] = "\xED\xB1";
            $softbankToEzweb["%s445%"] = "\xED\xB2";
            $softbankToEzweb["%s446%"] = "\xEB\x8A";
            $softbankToEzweb["%s447%"] = "\xEB\x8B";
            $softbankToEzweb["%s448%"] = "\xED\xB3";
            $softbankToEzweb["%s449%"] = "\xED\xB4";
            $softbankToEzweb["%s450%"] = "\xED\xB5";
            $softbankToEzweb["%s451%"] = "\xED\xB6";
            $softbankToEzweb["%s452%"] = "\xEC\xEC";
            $softbankToEzweb["%s453%"] = "\xEB\x89";
            $softbankToEzweb["%s454%"] = "\xED\xB7";
            $softbankToEzweb["%s455%"] = "\xEE\x58";
            $softbankToEzweb["%s456%"] = "\xED\xB8";
            $softbankToEzweb["%s457%"] = "\xED\xB9";
            $softbankToEzweb["%s458%"] = "\xED\xBA";
            $softbankToEzweb["%s459%"] = "\xED\xBB";
            $softbankToEzweb["%s460%"] = "\xED\xBC";
            $softbankToEzweb["%s461%"] = "\xEC\xEB";
            $softbankToEzweb["%s462%"] = "\xEE\x81";
            $softbankToEzweb["%s463%"] = "\xED\xBE";
            $softbankToEzweb["%s464%"] = "\xED\xBF";
            $softbankToEzweb["%s465%"] = "\xED\xC0";
            $softbankToEzweb["%s466%"] = "\xED\xC1";
            $softbankToEzweb["%s467%"] = "\xEB\x41";
            $softbankToEzweb["%s468%"] = mb_convert_encoding("[稲]", "sjis-win", "auto");
            $softbankToEzweb["%s469%"] = "\xED\xC2";
            $softbankToEzweb["%s470%"] = "\xED\xC3";
            $softbankToEzweb["%s471%"] = "\xED\x40";
            $softbankToEzweb["%s472%"] = "\xED\xC4";
            $softbankToEzweb["%s473%"] = "\xED\xC8";
            $softbankToEzweb["%s474%"] = "\xED\x4D";
            $softbankToEzweb["%s475%"] = "\xED\xC5";
            $softbankToEzweb["%s476%"] = "\xED\xC6";
            $softbankToEzweb["%s501%"] = "\xED\xC7";
            $softbankToEzweb["%s502%"] = "\xEC\xB9";
            $softbankToEzweb["%s503%"] = "\xED\xC9";
            $softbankToEzweb["%s504%"] = "\xED\xCA";
            $softbankToEzweb["%s505%"] = "\xED\xCB";
            $softbankToEzweb["%s506%"] = "\xED\xCC";
            $softbankToEzweb["%s507%"] = "\xEB\xF0";
            $softbankToEzweb["%s508%"] = "\xED\xCD";
            $softbankToEzweb["%s509%"] = "\xEB\x99";
            $softbankToEzweb["%s510%"] = mb_convert_encoding("[ﾛｹｯﾄ]", "sjis-win", "auto");
            $softbankToEzweb["%s511%"] = "\xEB\xA5";
            $softbankToEzweb["%s512%"] = "\xEC\x90";
            $softbankToEzweb["%s513%"] = "\xED\xCE";
            $softbankToEzweb["%s514%"] = "\xED\xCF";
            $softbankToEzweb["%s515%"] = "\xED\xD0";
            $softbankToEzweb["%s516%"] = "\xED\xD1";
            $softbankToEzweb["%s517%"] = "\xED\x48";
            $softbankToEzweb["%s518%"] = "\xED\x49";
            $softbankToEzweb["%s519%"] = "\xED\xD2";
            $softbankToEzweb["%s520%"] = "\xED\xD3";
            $softbankToEzweb["%s521%"] = "\xED\xD4";
            $softbankToEzweb["%s522%"] = "\xED\xD5";
            $softbankToEzweb["%s523%"] = "\xED\xD6";
            $softbankToEzweb["%s524%"] = "\xED\xD7";
            $softbankToEzweb["%s525%"] = "\xED\xD8";
            $softbankToEzweb["%s526%"] = "\xED\xD9";
            $softbankToEzweb["%s527%"] = "\xED\xDA";
            $softbankToEzweb["%s528%"] = "\xED\xDB";
            $softbankToEzweb["%s529%"] = mb_convert_encoding("[自由の女神]", "sjis-win", "auto");
            $softbankToEzweb["%s530%"] = mb_convert_encoding("[兵隊]", "sjis-win", "auto");
            $softbankToEzweb["%s531%"] = "\xED\xDD";
            $softbankToEzweb["%s532%"] = "\xED\xDC";
            $softbankToEzweb["%s533%"] = "\xEB\xB9";
            $softbankToEzweb["%s534%"] = "\xED\xDE";
            $softbankToEzweb["%s535%"] = "\xEB\xB9";
            $softbankToEzweb["%s536%"] = mb_convert_encoding("[犬]", "sjis-win", "auto");
            $softbankToEzweb["%s537%"] = "\xED\xDF";
            $softbankToEzweb["%s538%"] = "\xED\xE0";
            $softbankToEzweb["%s539%"] = "\xED\xE1";
            $softbankToEzweb["%s540%"] = "\xEB\xB2";
            $softbankToEzweb["%s541%"] = "\xEB\x67";
            $softbankToEzweb["%s542%"] = "\xEB\xBA";
            $softbankToEzweb["%s543%"] = "\xED\xE2";
            $softbankToEzweb["%s544%"] = "\xEB\xB0";
            $softbankToEzweb["%s545%"] = "\xED\xE3";
            $softbankToEzweb["%s546%"] = "\xED\xE4";
            $softbankToEzweb["%s547%"] = "\xED\xE5";
            $softbankToEzweb["%s548%"] = "\xED\xE6";
            $softbankToEzweb["%s549%"] = "\xEB\xB3";
            $softbankToEzweb["%s550%"] = "\xED\xE7";
            $softbankToEzweb["%s551%"] = "\xED\xE8";
            $softbankToEzweb["%s552%"] = "\xED\xEA";
            $softbankToEzweb["%s553%"] = "\xED\xE9";
            $softbankToEzweb["%s554%"] = "\xED\xEB";
            $softbankToEzweb["%s555%"] = "\xEC\x6A";
        }

        return $softbankToEzweb;
    }

    /**
     * getDocomoToSoftbankMailメソッド
     *
     * Docomo用の変換文字をキーにしたSoftbank絵文字データ配列を返します。
     * メール送信用
     *
     * @return $docomoToSoftbank Softbank絵文字配列
     */
    public static function getDocomoToSoftbankMail() {
        static $docomoToSoftbank;

        if (!isset($docomoToSoftbank)) {
            $docomoToSoftbank["%i1%"] = pack("C*", 0xf9,0x8b);
            $docomoToSoftbank["%i2%"] = pack("C*", 0xf9,0x8a);
            $docomoToSoftbank["%i3%"] = pack("C*", 0xf9,0x8c);
            $docomoToSoftbank["%i4%"] = pack("C*", 0xf9,0x89);
            $docomoToSoftbank["%i5%"] = pack("C*", 0xf7,0x7d);
            $docomoToSoftbank["%i6%"] = pack("C*", 0xfb,0x84);
            $docomoToSoftbank["%i7%"] = mb_convert_encoding("[霧]", "sjis-win", "auto");
            $docomoToSoftbank["%i8%"] = pack("C*", 0xfb,0x7c);
            $docomoToSoftbank["%i9%"] = pack("C*", 0xf7,0xdf);
            $docomoToSoftbank["%i10%"] = pack("C*", 0xf7,0xe0);
            $docomoToSoftbank["%i11%"] = pack("C*", 0xf7,0xe1);
            $docomoToSoftbank["%i12%"] = pack("C*", 0xf7,0xe2);
            $docomoToSoftbank["%i13%"] = pack("C*", 0xf7,0xe3);
            $docomoToSoftbank["%i14%"] = pack("C*", 0xf7,0xe4);
            $docomoToSoftbank["%i15%"] = pack("C*", 0xf7,0xe5);
            $docomoToSoftbank["%i16%"] = pack("C*", 0xf7,0xe6);
            $docomoToSoftbank["%i17%"] = pack("C*", 0xf7,0xe7);
            $docomoToSoftbank["%i18%"] = pack("C*", 0xf7,0xe8);
            $docomoToSoftbank["%i19%"] = pack("C*", 0xf7,0xe9);
            $docomoToSoftbank["%i20%"] = pack("C*", 0xf7,0xea);
            $docomoToSoftbank["%i21%"] = mb_convert_encoding("[ｽﾎﾟｰﾂ]", "sjis-win", "auto");
            $docomoToSoftbank["%i22%"] = pack("C*", 0xf9,0x56);
            $docomoToSoftbank["%i23%"] = pack("C*", 0xf9,0x54);
            $docomoToSoftbank["%i24%"] = pack("C*", 0xf9,0x55);
            $docomoToSoftbank["%i25%"] = pack("C*", 0xf9,0x58);
            $docomoToSoftbank["%i26%"] = pack("C*", 0xf9,0x53);
            $docomoToSoftbank["%i27%"] = pack("C*", 0xfb,0x6a);
            $docomoToSoftbank["%i28%"] = pack("C*", 0xf7,0x72);
            $docomoToSoftbank["%i29%"] = mb_convert_encoding("[ﾎﾟｹﾍﾞﾙ]", "sjis-win", "auto");
            $docomoToSoftbank["%i30%"] = pack("C*", 0xf9,0x5e);
            $docomoToSoftbank["%i31%"] = pack("C*", 0xfb,0x74);
            $docomoToSoftbank["%i32%"] = pack("C*", 0xfb,0x75);
            $docomoToSoftbank["%i33%"] = pack("C*", 0xf9,0x5b);
            $docomoToSoftbank["%i34%"] = pack("C*", 0xfb,0x6e);
            $docomoToSoftbank["%i35%"] = pack("C*", 0xf7,0x9a);
            $docomoToSoftbank["%i36%"] = pack("C*", 0xf7,0xdc);
            $docomoToSoftbank["%i37%"] = pack("C*", 0xf9,0x5d);
            $docomoToSoftbank["%i38%"] = pack("C*", 0xf9,0x76);
            $docomoToSoftbank["%i39%"] = pack("C*", 0xf9,0x78);
            $docomoToSoftbank["%i40%"] = pack("C*", 0xf7,0x94);
            $docomoToSoftbank["%i41%"] = pack("C*", 0xf7,0x96);
            $docomoToSoftbank["%i42%"] = pack("C*", 0xf7,0x8e);
            $docomoToSoftbank["%i43%"] = pack("C*", 0xf7,0x95);
            $docomoToSoftbank["%i44%"] = pack("C*", 0xf7,0x99);
            $docomoToSoftbank["%i45%"] = pack("C*", 0xf7,0x97);
            $docomoToSoftbank["%i46%"] = pack("C*", 0xf9,0x7a);
            $docomoToSoftbank["%i47%"] = pack("C*", 0xf7,0x90);
            $docomoToSoftbank["%i48%"] = pack("C*", 0xf7,0x8f);
            $docomoToSoftbank["%i49%"] = pack("C*", 0xf7,0x92);
            $docomoToSoftbank["%i50%"] = pack("C*", 0xf9,0x84);
            $docomoToSoftbank["%i51%"] = pack("C*", 0xf9,0x86);
            $docomoToSoftbank["%i52%"] = pack("C*", 0xf9,0x85);
            $docomoToSoftbank["%i53%"] = pack("C*", 0xf9,0x88);
            $docomoToSoftbank["%i54%"] = pack("C*", 0xf7,0x60);
            $docomoToSoftbank["%i55%"] = pack("C*", 0xf7,0x7e);
            $docomoToSoftbank["%i56%"] = pack("C*", 0xf9,0xb3);
            $docomoToSoftbank["%i57%"] = pack("C*", 0xf9,0x7c);
            $docomoToSoftbank["%i58%"] = pack("C*", 0xf9,0x7d);
            $docomoToSoftbank["%i59%"] = pack("C*", 0xf7,0xd6);
            $docomoToSoftbank["%i60%"] = mb_convert_encoding("[遊園地]", "sjis-win", "auto");
            $docomoToSoftbank["%i61%"] = pack("C*", 0xf9,0xaa);
            $docomoToSoftbank["%i62%"] = pack("C*", 0xfb,0xa2);
            $docomoToSoftbank["%i63%"] = pack("C*", 0xfb,0xa3);
            $docomoToSoftbank["%i64%"] = mb_convert_encoding("[ｲﾍﾞﾝﾄ]", "sjis-win", "auto");
            $docomoToSoftbank["%i65%"] = pack("C*", 0xf7,0x65);
            $docomoToSoftbank["%i66%"] = pack("C*", 0xf9,0xae);
            $docomoToSoftbank["%i67%"] = pack("C*", 0xf7,0xa8);
            $docomoToSoftbank["%i68%"] = pack("C*", 0xf9,0x48);
            $docomoToSoftbank["%i69%"] = pack("C*", 0xf9,0xc3);
            $docomoToSoftbank["%i70%"] = pack("C*", 0xf7,0x89);
            $docomoToSoftbank["%i71%"] = pack("C*", 0xf9,0xb4);
            $docomoToSoftbank["%i72%"] = pack("C*", 0xf7,0x52);
            $docomoToSoftbank["%i73%"] = pack("C*", 0xf9,0xeb);
            $docomoToSoftbank["%i74%"] = pack("C*", 0xf9,0x49);
            $docomoToSoftbank["%i75%"] = pack("C*", 0xf9,0x4a);
            $docomoToSoftbank["%i76%"] = pack("C*", 0xf9,0xa1);
            $docomoToSoftbank["%i77%"] = pack("C*", 0xf7,0x6a);
            $docomoToSoftbank["%i78%"] = mb_convert_encoding("[ｹﾞｰﾑ]", "sjis-win", "auto");
            $docomoToSoftbank["%i79%"] = pack("C*", 0xf7,0x66);
            $docomoToSoftbank["%i80%"] = pack("C*", 0xf7,0xac);
            $docomoToSoftbank["%i81%"] = pack("C*", 0xf7,0xae);
            $docomoToSoftbank["%i82%"] = pack("C*", 0xf7,0xad);
            $docomoToSoftbank["%i83%"] = pack("C*", 0xf7,0xaf);
            $docomoToSoftbank["%i84%"] = pack("C*", 0xfb,0x59);
            $docomoToSoftbank["%i85%"] = pack("C*", 0xfb,0x5b);
            $docomoToSoftbank["%i86%"] = pack("C*", 0xf9,0x50);
            $docomoToSoftbank["%i87%"] = pack("C*", 0xf9,0x51);
            $docomoToSoftbank["%i88%"] = pack("C*", 0xf9,0x52);
            $docomoToSoftbank["%i89%"] = pack("C*", 0xf7,0xd8);
            $docomoToSoftbank["%i90%"] = pack("C*", 0xf7,0xd7);
            $docomoToSoftbank["%i91%"] = pack("C*", 0xfb,0xd6);
            $docomoToSoftbank["%i92%"] = pack("C*", 0xf9,0x47);
            $docomoToSoftbank["%i93%"] = mb_convert_encoding("[ﾒｶﾞﾈ]", "sjis-win", "auto");
            $docomoToSoftbank["%i94%"] = pack("C*", 0xf7,0xaa);
            $docomoToSoftbank["%i95%"] = mb_convert_encoding("●", "sjis-win", "auto");
            $docomoToSoftbank["%i96%"] = pack("C*", 0xf9,0x8d);
            $docomoToSoftbank["%i97%"] = pack("C*", 0xf9,0x8d);
            $docomoToSoftbank["%i98%"] = pack("C*", 0xf9,0x8d);
            $docomoToSoftbank["%i99%"] = mb_convert_encoding("○", "sjis-win", "auto");
            $docomoToSoftbank["%i100%"] = pack("C*", 0xf9,0x93);
            $docomoToSoftbank["%i101%"] = pack("C*", 0xf9,0x90);
            $docomoToSoftbank["%i102%"] = pack("C*", 0xf9,0x5c);
            $docomoToSoftbank["%i103%"] = pack("C*", 0xf9,0x73);
            $docomoToSoftbank["%i104%"] = pack("C*", 0xf7,0xd9);
            $docomoToSoftbank["%i105%"] = pack("C*", 0xf7,0x44);
            $docomoToSoftbank["%i106%"] = pack("C*", 0xf7,0x43);
            $docomoToSoftbank["%i107%"] = pack("C*", 0xf9,0x4b);
            $docomoToSoftbank["%i108%"] = mb_convert_encoding("[iﾓｰﾄﾞ]", "sjis-win", "auto");
            $docomoToSoftbank["%i109%"] = mb_convert_encoding("[iﾓｰﾄﾞ]", "sjis-win", "auto");
            $docomoToSoftbank["%i110%"] = pack("C*", 0xf7,0x43);
            $docomoToSoftbank["%i111%"] = mb_convert_encoding("[ﾄﾞｺﾓ]", "sjis-win", "auto");
            $docomoToSoftbank["%i112%"] = mb_convert_encoding("[ﾄﾞｺﾓﾎﾟｲﾝﾄ]", "sjis-win", "auto");
            $docomoToSoftbank["%i113%"] = mb_convert_encoding("[有料]", "sjis-win", "auto");
            $docomoToSoftbank["%i114%"] = mb_convert_encoding("[無料]", "sjis-win", "auto");
            $docomoToSoftbank["%i115%"] = pack("C*", 0xf7,0xc9);
            $docomoToSoftbank["%i116%"] = pack("C*", 0xf9,0x80);
            $docomoToSoftbank["%i117%"] = mb_convert_encoding("[次]", "sjis-win", "auto");
            $docomoToSoftbank["%i118%"] = mb_convert_encoding("[ｸﾘｱ]", "sjis-win", "auto");
            $docomoToSoftbank["%i119%"] = pack("C*", 0xf7,0x54);
            $docomoToSoftbank["%i120%"] = pack("C*", 0xf7,0xb2);
            $docomoToSoftbank["%i121%"] = mb_convert_encoding("[位置情報]", "sjis-win", "auto");
            $docomoToSoftbank["%i122%"] = pack("C*", 0xf7,0xb1);
            $docomoToSoftbank["%i123%"] = pack("C*", 0xf7,0xb0);
            $docomoToSoftbank["%i124%"] = mb_convert_encoding("[ﾓﾊﾞQ]", "sjis-win", "auto");
            $docomoToSoftbank["%i125%"] = pack("C*", 0xf7,0xbc);
            $docomoToSoftbank["%i126%"] = pack("C*", 0xf7,0xbd);
            $docomoToSoftbank["%i127%"] = pack("C*", 0xf7,0xbe);
            $docomoToSoftbank["%i128%"] = pack("C*", 0xf7,0xbf);
            $docomoToSoftbank["%i129%"] = pack("C*", 0xf7,0xc0);
            $docomoToSoftbank["%i130%"] = pack("C*", 0xf7,0xc1);
            $docomoToSoftbank["%i131%"] = pack("C*", 0xf7,0xc2);
            $docomoToSoftbank["%i132%"] = pack("C*", 0xf7,0xc3);
            $docomoToSoftbank["%i133%"] = pack("C*", 0xf7,0xc4);
            $docomoToSoftbank["%i134%"] = pack("C*", 0xf7,0xc5);
            $docomoToSoftbank["%i135%"] = pack("C*", 0xf7,0xed);
            $docomoToSoftbank["%i136%"] = pack("C*", 0xf9,0x62);
            $docomoToSoftbank["%i137%"] = pack("C*", 0xf9,0xc7);
            $docomoToSoftbank["%i138%"] = pack("C*", 0xf9,0x63);
            $docomoToSoftbank["%i139%"] = pack("C*", 0xf9,0xc7);
            $docomoToSoftbank["%i140%"] = pack("C*", 0xf9,0x98);
            $docomoToSoftbank["%i141%"] = pack("C*", 0xf9,0x9a);
            $docomoToSoftbank["%i142%"] = pack("C*", 0xf9,0x99);
            $docomoToSoftbank["%i143%"] = pack("C*", 0xfb,0x47);
            $docomoToSoftbank["%i144%"] = pack("C*", 0xfb,0x46);
            $docomoToSoftbank["%i145%"] = pack("C*", 0xf7,0xd6);
            $docomoToSoftbank["%i146%"] = pack("C*", 0xf9,0x7e);
            $docomoToSoftbank["%i147%"] = pack("C*", 0xf7,0x63);
            $docomoToSoftbank["%i148%"] = mb_convert_encoding("[かわいい]", "sjis-win", "auto");
            $docomoToSoftbank["%i149%"] = pack("C*", 0xf9,0x43);
            $docomoToSoftbank["%i150%"] = pack("C*", 0xf9,0xce);
            $docomoToSoftbank["%i151%"] = pack("C*", 0xf7,0x4f);
            $docomoToSoftbank["%i152%"] = pack("C*", 0xf9,0xd4);
            $docomoToSoftbank["%i153%"] = pack("C*", 0xf9,0x4d);
            $docomoToSoftbank["%i154%"] = pack("C*", 0xf9,0xb1);
            $docomoToSoftbank["%i155%"] = pack("C*", 0xf9,0xc6);
            $docomoToSoftbank["%i156%"] = pack("C*", 0xf7,0xd8);
            $docomoToSoftbank["%i157%"] = pack("C*", 0xf7,0x7c);
            $docomoToSoftbank["%i158%"] = pack("C*", 0xf9,0x61);
//            $docomoToSoftbank["%i159%"] = "\x1b\$!?\x0f";
//            $docomoToSoftbank["%i160%"] = "\x1b\$!!\x0f";
            $docomoToSoftbank["%i159%"] = "";
            $docomoToSoftbank["%i160%"] = "";
            $docomoToSoftbank["%i161%"] = mb_convert_encoding("[衝撃]", "sjis-win", "auto");
            $docomoToSoftbank["%i162%"] = pack("C*", 0xf9,0xd1);
            $docomoToSoftbank["%i163%"] = pack("C*", 0xf9,0xd1);
            $docomoToSoftbank["%i164%"] = pack("C*", 0xf9,0xd0);
            $docomoToSoftbank["%i165%"] = mb_convert_encoding("ｰ", "sjis-win", "auto");
            $docomoToSoftbank["%i166%"] = mb_convert_encoding("ｰ", "sjis-win", "auto");
            $docomoToSoftbank["%i167%"] = pack("C*", 0xf9,0xc4);
            $docomoToSoftbank["%i168%"] = mb_convert_encoding("[ふくろ]", "sjis-win", "auto");
            $docomoToSoftbank["%i169%"] = mb_convert_encoding("[ﾍﾟﾝ]", "sjis-win", "auto");
            $docomoToSoftbank["%i170%"] = mb_convert_encoding("[人影]", "sjis-win", "auto");
            $docomoToSoftbank["%i171%"] = pack("C*", 0xf7,0x5f);
            $docomoToSoftbank["%i172%"] = pack("C*", 0xfb,0x8c);
            $docomoToSoftbank["%i173%"] = mb_convert_encoding("[soon]", "sjis-win", "auto");
            $docomoToSoftbank["%i174%"] = mb_convert_encoding("[on]", "sjis-win", "auto");
            $docomoToSoftbank["%i175%"] = mb_convert_encoding("[end]", "sjis-win", "auto");
            $docomoToSoftbank["%i176%"] = pack("C*", 0xf9,0x6d);
            $docomoToSoftbank["%i1001%"] = mb_convert_encoding("[iｱﾌﾟﾘ]", "sjis-win", "auto");
            $docomoToSoftbank["%i1002%"] = mb_convert_encoding("[iｱﾌﾟﾘ]", "sjis-win", "auto");
            $docomoToSoftbank["%i1003%"] = pack("C*", 0xf9,0x46);
            $docomoToSoftbank["%i1004%"] = mb_convert_encoding("[財布]", "sjis-win", "auto");
            $docomoToSoftbank["%i1005%"] = pack("C*", 0xf9,0xbc);
            $docomoToSoftbank["%i1006%"] = mb_convert_encoding("[ｼﾞｰﾝｽﾞ]", "sjis-win", "auto");
            $docomoToSoftbank["%i1007%"] = mb_convert_encoding("[ｽﾉﾎﾞ]", "sjis-win", "auto");
            $docomoToSoftbank["%i1008%"] = pack("C*", 0xf9,0xc5);
            $docomoToSoftbank["%i1009%"] = mb_convert_encoding("[ﾄﾞｱ]", "sjis-win", "auto");
            $docomoToSoftbank["%i1010%"] = pack("C*", 0xf7,0x6f);
            $docomoToSoftbank["%i1011%"] = pack("C*", 0xf9,0x4c);
            $docomoToSoftbank["%i1012%"] = pack("C*", 0xf7,0x43).pack("C*", 0xf9,0xc8);;
            $docomoToSoftbank["%i1013%"] = mb_convert_encoding("[ﾚﾝﾁ]", "sjis-win", "auto");
            $docomoToSoftbank["%i1014%"] = pack("C*", 0xf9,0xa1);
            $docomoToSoftbank["%i1015%"] = pack("C*", 0xf7,0x4e);
            $docomoToSoftbank["%i1016%"] = pack("C*", 0xf9,0x74);
            $docomoToSoftbank["%i1017%"] = mb_convert_encoding("[砂時計]", "sjis-win", "auto");
            $docomoToSoftbank["%i1018%"] = pack("C*", 0xf7,0x76);
            $docomoToSoftbank["%i1019%"] = pack("C*", 0xf9,0xd8);
            $docomoToSoftbank["%i1020%"] = mb_convert_encoding("[腕時計]", "sjis-win", "auto");
            $docomoToSoftbank["%i1021%"] = pack("C*", 0xfb,0x43);
            $docomoToSoftbank["%i1022%"] = pack("C*", 0xfb,0x4a);
            $docomoToSoftbank["%i1023%"] = pack("C*", 0xfb,0x55).pack("C*", 0xf9,0xd1);
            $docomoToSoftbank["%i1024%"] = pack("C*", 0xf7,0x48);
            $docomoToSoftbank["%i1025%"] = pack("C*", 0xfb,0x56);
            $docomoToSoftbank["%i1026%"] = pack("C*", 0xfb,0x4e);
            $docomoToSoftbank["%i1027%"] = pack("C*", 0xf7,0x46);
            $docomoToSoftbank["%i1028%"] = pack("C*", 0xf9,0x4e);
            $docomoToSoftbank["%i1029%"] = pack("C*", 0xf7,0x45);
            $docomoToSoftbank["%i1030%"] = pack("C*", 0xfb,0x45);
            $docomoToSoftbank["%i1031%"] = pack("C*", 0xfb,0x4a);
            $docomoToSoftbank["%i1032%"] = pack("C*", 0xfb,0x46);
            $docomoToSoftbank["%i1033%"] = pack("C*", 0xfb,0x7c);
            $docomoToSoftbank["%i1034%"] = pack("C*", 0xfb,0x51);
            $docomoToSoftbank["%i1035%"] = pack("C*", 0xfb,0x53);
            $docomoToSoftbank["%i1036%"] = mb_convert_encoding("[NG]", "sjis-win", "auto");
            $docomoToSoftbank["%i1037%"] = mb_convert_encoding("[ｸﾘｯﾌﾟ]", "sjis-win", "auto");
            $docomoToSoftbank["%i1038%"] = pack("C*", 0xf7,0xee);
            $docomoToSoftbank["%i1039%"] = pack("C*", 0xfb,0xd7);
            $docomoToSoftbank["%i1040%"] = pack("C*", 0xf7,0x55);
            $docomoToSoftbank["%i1041%"] = pack("C*", 0xf9,0xb5);
            $docomoToSoftbank["%i1042%"] = mb_convert_encoding("[ﾘｻｲｸﾙ]", "sjis-win", "auto");
            $docomoToSoftbank["%i1043%"] = pack("C*", 0xf7,0xef);
            $docomoToSoftbank["%i1044%"] = pack("C*", 0xf7,0xf2);
            $docomoToSoftbank["%i1045%"] = mb_convert_encoding("[禁止]", "sjis-win", "auto");
            $docomoToSoftbank["%i1046%"] = pack("C*", 0xf7,0xcb);
            $docomoToSoftbank["%i1047%"] = mb_convert_encoding("[合格]", "sjis-win", "auto");
            $docomoToSoftbank["%i1048%"] = pack("C*", 0xf7,0xca);
            $docomoToSoftbank["%i1049%"] = mb_convert_encoding("⇔", "sjis-win", "auto");
            $docomoToSoftbank["%i1050%"] = mb_convert_encoding("↑↓", "sjis-win", "auto");
            $docomoToSoftbank["%i1051%"] = pack("C*", 0xf7,0x98);
            $docomoToSoftbank["%i1052%"] = pack("C*", 0xfb,0x7e);
            $docomoToSoftbank["%i1053%"] = pack("C*", 0xf9,0x7b);
            $docomoToSoftbank["%i1054%"] = pack("C*", 0xf7,0x50);
            $docomoToSoftbank["%i1055%"] = mb_convert_encoding("[さくらんぼ]", "sjis-win", "auto");
            $docomoToSoftbank["%i1056%"] = pack("C*", 0xf9,0xa4);
            $docomoToSoftbank["%i1057%"] = mb_convert_encoding("[ﾊﾞﾅﾅ]", "sjis-win", "auto");
            $docomoToSoftbank["%i1058%"] = pack("C*", 0xf9,0xe5);
            $docomoToSoftbank["%i1059%"] = pack("C*", 0xf7,0x50);
            $docomoToSoftbank["%i1060%"] = pack("C*", 0xf7,0x58);
            $docomoToSoftbank["%i1061%"] = pack("C*", 0xf9,0x70);
            $docomoToSoftbank["%i1062%"] = pack("C*", 0xf9,0xe2);
            $docomoToSoftbank["%i1063%"] = pack("C*", 0xf9,0x87);
            $docomoToSoftbank["%i1064%"] = pack("C*", 0xf9,0xab);
            $docomoToSoftbank["%i1065%"] = pack("C*", 0xf9,0xe0);
            $docomoToSoftbank["%i1066%"] = pack("C*", 0xf9,0xd9);
            $docomoToSoftbank["%i1067%"] = mb_convert_encoding("[ｶﾀﾂﾑﾘ]", "sjis-win", "auto");
            $docomoToSoftbank["%i1068%"] = pack("C*", 0xfb,0xc3);
            $docomoToSoftbank["%i1069%"] = pack("C*", 0xf9,0x96);
            $docomoToSoftbank["%i1070%"] = pack("C*", 0xf9,0x59);
            $docomoToSoftbank["%i1071%"] = pack("C*", 0xf9,0x97);
            $docomoToSoftbank["%i1072%"] = pack("C*", 0xfb,0x44);
            $docomoToSoftbank["%i1073%"] = pack("C*", 0xf9,0x5a);
            $docomoToSoftbank["%i1074%"] = pack("C*", 0xf7,0x90);
            $docomoToSoftbank["%i1075%"] = pack("C*", 0xf9,0x85);
            $docomoToSoftbank["%i1076%"] = pack("C*", 0xf7,0x47);
        }

        return $docomoToSoftbank;
    }

    /**
     * getEzwebToSoftbankMailメソッド
     *
     * Ezweb用の変換文字をキーにしたSoftbank絵文字データ配列を返します。
     * メール送信用
     *
     * @return $ezwebToSoftbank Softbank絵文字配列
     */

    public static function getEzwebToSoftbankMail() {
        static $ezwebToSoftbank;

        if (!isset($ezwebToSoftbank)) {
            $ezwebToSoftbank["%e1%"] = pack("C*", 0xf7,0xf2);
            $ezwebToSoftbank["%e2%"] = pack("C*", 0xf9,0x62);
            $ezwebToSoftbank["%e3%"] = pack("C*", 0xf9,0x60);
            $ezwebToSoftbank["%e4%"] = mb_convert_encoding("[Q]", "sjis-win", "auto");
            $ezwebToSoftbank["%e5%"] = pack("C*", 0xf7,0xdb);
            $ezwebToSoftbank["%e6%"] = pack("C*", 0xf7,0xda);
            $ezwebToSoftbank["%e7%"] = pack("C*", 0xf7,0xdd);
            $ezwebToSoftbank["%e8%"] = pack("C*", 0xf7,0xdc);
            $ezwebToSoftbank["%e9%"] = pack("C*", 0xf7,0xbb);
            $ezwebToSoftbank["%e10%"] = pack("C*", 0xf7,0xba);
            $ezwebToSoftbank["%e11%"] = mb_convert_encoding("[i]", "sjis-win", "auto");
            $ezwebToSoftbank["%e12%"] = pack("C*", 0xf9,0x85);
            $ezwebToSoftbank["%e13%"] = pack("C*", 0xf7,0x82);
            $ezwebToSoftbank["%e14%"] = pack("C*", 0xf7,0x6f);
            $ezwebToSoftbank["%e15%"] = pack("C*", 0xf9,0x8d);
            $ezwebToSoftbank["%e16%"] = pack("C*", 0xf7,0x7d);
            $ezwebToSoftbank["%e17%"] = pack("C*", 0xf7,0xbb);
            $ezwebToSoftbank["%e18%"] = pack("C*", 0xf7,0xba);
            $ezwebToSoftbank["%e19%"] = pack("C*", 0xf7,0xbb);
            $ezwebToSoftbank["%e20%"] = pack("C*", 0xf7,0xbb);
            $ezwebToSoftbank["%e21%"] = pack("C*", 0xf7,0xbb);
            $ezwebToSoftbank["%e22%"] = pack("C*", 0xf7,0xba);
            $ezwebToSoftbank["%e23%"] = pack("C*", 0xf7,0xb9);
            $ezwebToSoftbank["%e24%"] = pack("C*", 0xf7,0xb9);
            $ezwebToSoftbank["%e25%"] = mb_convert_encoding("[腕時計]", "sjis-win", "auto");
            $ezwebToSoftbank["%e26%"] = mb_convert_encoding("＋", "sjis-win", "auto");
            $ezwebToSoftbank["%e27%"] = mb_convert_encoding("－", "sjis-win", "auto");
            $ezwebToSoftbank["%e28%"] = mb_convert_encoding("＊", "sjis-win", "auto");
            $ezwebToSoftbank["%e29%"] = pack("C*", 0xf7,0xd2);
            $ezwebToSoftbank["%e30%"] = pack("C*", 0xf7,0xd3);
            $ezwebToSoftbank["%e31%"] = mb_convert_encoding("[禁]", "sjis-win", "auto");
            $ezwebToSoftbank["%e32%"] = mb_convert_encoding("▼", "sjis-win", "auto");
            $ezwebToSoftbank["%e33%"] = mb_convert_encoding("▲", "sjis-win", "auto");
            $ezwebToSoftbank["%e34%"] = mb_convert_encoding("▼", "sjis-win", "auto");
            $ezwebToSoftbank["%e35%"] = mb_convert_encoding("▲", "sjis-win", "auto");
            $ezwebToSoftbank["%e36%"] = pack("C*", 0xf7,0xbb);
            $ezwebToSoftbank["%e37%"] = pack("C*", 0xf7,0xbb);
            $ezwebToSoftbank["%e38%"] = pack("C*", 0xf7,0xbb);
            $ezwebToSoftbank["%e39%"] = pack("C*", 0xf7,0xba);
            $ezwebToSoftbank["%e40%"] = pack("C*", 0xf7,0xb9);
            $ezwebToSoftbank["%e41%"] = pack("C*", 0xf7,0xb9);
            $ezwebToSoftbank["%e42%"] = pack("C*", 0xf7,0xd7);
            $ezwebToSoftbank["%e43%"] = pack("C*", 0xf7,0xd8);
            $ezwebToSoftbank["%e44%"] = pack("C*", 0xf9,0x8b);
            $ezwebToSoftbank["%e45%"] = pack("C*", 0xf9,0x56);
            $ezwebToSoftbank["%e46%"] = pack("C*", 0xf9,0x6d);
            $ezwebToSoftbank["%e47%"] = pack("C*", 0xf9,0x8d);
            $ezwebToSoftbank["%e48%"] = pack("C*", 0xf9,0xc5);
            $ezwebToSoftbank["%e49%"] = mb_convert_encoding("φ", "sjis-win", "auto");
            $ezwebToSoftbank["%e50%"] = pack("C*", 0xf9,0x7c);
            $ezwebToSoftbank["%e51%"] = pack("C*", 0xf9,0x62);
            $ezwebToSoftbank["%e52%"] = pack("C*", 0xf9,0x85);
            $ezwebToSoftbank["%e53%"] = pack("C*", 0xf7,0x50);
            $ezwebToSoftbank["%e54%"] = pack("C*", 0xfb,0xd7);
            $ezwebToSoftbank["%e55%"] = pack("C*", 0xf9,0xd3);
            $ezwebToSoftbank["%e56%"] = pack("C*", 0xf9,0xa1);
            $ezwebToSoftbank["%e57%"] = mb_convert_encoding("[砂時計]", "sjis-win", "auto");
            $ezwebToSoftbank["%e58%"] = mb_convert_encoding("[砂時計]", "sjis-win", "auto");
            $ezwebToSoftbank["%e59%"] = pack("C*", 0xf9,0xb6);
            $ezwebToSoftbank["%e60%"] = mb_convert_encoding("[雪結晶]", "sjis-win", "auto");
            $ezwebToSoftbank["%e61%"] = pack("C*", 0xf9,0xd3);
            $ezwebToSoftbank["%e62%"] = pack("C*", 0xf9,0xd3);
            $ezwebToSoftbank["%e63%"] = pack("C*", 0xf7,0xd4);
            $ezwebToSoftbank["%e64%"] = pack("C*", 0xf7,0xd5);
            $ezwebToSoftbank["%e65%"] = pack("C*", 0xf9,0x88);
            $ezwebToSoftbank["%e66%"] = mb_convert_encoding("÷", "sjis-win", "auto");
            $ezwebToSoftbank["%e67%"] = mb_convert_encoding("[ｶﾚﾝﾀﾞｰ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e68%"] = pack("C*", 0xf9,0x97);
            $ezwebToSoftbank["%e69%"] = pack("C*", 0xf9,0xcf);
            $ezwebToSoftbank["%e70%"] = pack("C*", 0xf7,0xd6);
            $ezwebToSoftbank["%e71%"] = pack("C*", 0xf7,0xd9);
            $ezwebToSoftbank["%e72%"] = pack("C*", 0xf9,0x74);
            $ezwebToSoftbank["%e73%"] = mb_convert_encoding("[ﾁｪｯｸﾏｰｸ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e74%"] = pack("C*", 0xf9,0x93);
            $ezwebToSoftbank["%e75%"] = mb_convert_encoding("☆彡", "sjis-win", "auto");
            $ezwebToSoftbank["%e76%"] = pack("C*", 0xf9,0xce);
            $ezwebToSoftbank["%e77%"] = pack("C*", 0xf7,0x4f);
            $ezwebToSoftbank["%e78%"] = pack("C*", 0xfb,0xc3);
            $ezwebToSoftbank["%e79%"] = mb_convert_encoding("[ﾌｫﾙﾀﾞ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e80%"] = pack("C*", 0xf9,0x41);
            $ezwebToSoftbank["%e81%"] = pack("C*", 0xf7,0xee);
            $ezwebToSoftbank["%e82%"] = pack("C*", 0xf7,0xef);
            $ezwebToSoftbank["%e83%"] = pack("C*", 0xf9,0xc3);
            $ezwebToSoftbank["%e84%"] = mb_convert_encoding("[ﾌｫﾙﾀﾞ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e85%"] = pack("C*", 0xf9,0x49);
            $ezwebToSoftbank["%e86%"] = mb_convert_encoding("[ﾌｷﾀﾞｼ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e87%"] = mb_convert_encoding("[ｶｰﾄﾞ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e88%"] = mb_convert_encoding("▲", "sjis-win", "auto");
            $ezwebToSoftbank["%e89%"] = mb_convert_encoding("▼", "sjis-win", "auto");
            $ezwebToSoftbank["%e90%"] = pack("C*", 0xfb,0xac);
            $ezwebToSoftbank["%e91%"] = pack("C*", 0xf7,0x89);
            $ezwebToSoftbank["%e92%"] = pack("C*", 0xf9,0xa1);
            $ezwebToSoftbank["%e93%"] = pack("C*", 0xf9,0x86);
            $ezwebToSoftbank["%e94%"] = pack("C*", 0xf9,0x48);
            $ezwebToSoftbank["%e95%"] = pack("C*", 0xf9,0x8c);
            $ezwebToSoftbank["%e96%"] = pack("C*", 0xfb,0x6b);
            $ezwebToSoftbank["%e97%"] = pack("C*", 0xf7,0x89);
            $ezwebToSoftbank["%e98%"] = pack("C*", 0xf7,0x77);
            $ezwebToSoftbank["%e99%"] = pack("C*", 0xf7,0x8f);
            $ezwebToSoftbank["%e100%"] = pack("C*", 0xf7,0x89);
            $ezwebToSoftbank["%e101%"] = pack("C*", 0xf7,0x89);
            $ezwebToSoftbank["%e102%"] = pack("C*", 0xf7,0x89);
            $ezwebToSoftbank["%e103%"] = pack("C*", 0xf9,0xa1);
            $ezwebToSoftbank["%e104%"] = pack("C*", 0xf9,0xb3);
            $ezwebToSoftbank["%e105%"] = mb_convert_encoding("[ｶﾚﾝﾀﾞｰ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e106%"] = pack("C*", 0xf7,0x65);
            $ezwebToSoftbank["%e107%"] = pack("C*", 0xf9,0x8a);
            $ezwebToSoftbank["%e108%"] = pack("C*", 0xf7,0x43);
            $ezwebToSoftbank["%e109%"] = mb_convert_encoding("￥", "sjis-win", "auto");
            $ezwebToSoftbank["%e110%"] = pack("C*", 0xf9,0x7d);
            $ezwebToSoftbank["%e111%"] = pack("C*", 0xf9,0x7d);
            $ezwebToSoftbank["%e112%"] = pack("C*", 0xf9,0x76);
            $ezwebToSoftbank["%e113%"] = pack("C*", 0xf9,0xa4);
            $ezwebToSoftbank["%e114%"] = mb_convert_encoding("[包丁]", "sjis-win", "auto");
            $ezwebToSoftbank["%e115%"] = pack("C*", 0xf7,0x69);
            $ezwebToSoftbank["%e116%"] = mb_convert_encoding("[ﾒｶﾞﾈ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e117%"] = mb_convert_encoding("└→", "sjis-win", "auto");
            $ezwebToSoftbank["%e118%"] = mb_convert_encoding("←┘", "sjis-win", "auto");
            $ezwebToSoftbank["%e119%"] = pack("C*", 0xf7,0x54);
            $ezwebToSoftbank["%e120%"] = pack("C*", 0xf9,0x80);
            $ezwebToSoftbank["%e121%"] = pack("C*", 0xf7,0x89);
            $ezwebToSoftbank["%e122%"] = pack("C*", 0xf7,0x89);
            $ezwebToSoftbank["%e123%"] = mb_convert_encoding("[ﾈｼﾞ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e124%"] = pack("C*", 0xf7,0x7e);
            $ezwebToSoftbank["%e125%"] = pack("C*", 0xf9,0x5b);
            $ezwebToSoftbank["%e126%"] = pack("C*", 0xf9,0xb6);
            $ezwebToSoftbank["%e127%"] = pack("C*", 0xf7,0x8b);
            $ezwebToSoftbank["%e128%"] = pack("C*", 0xf7,0x8b);
            $ezwebToSoftbank["%e129%"] = pack("C*", 0xf7,0x41);
            $ezwebToSoftbank["%e130%"] = mb_convert_encoding("[懐中電灯]", "sjis-win", "auto");
            $ezwebToSoftbank["%e131%"] = pack("C*", 0xf7,0x89);
            $ezwebToSoftbank["%e132%"] = mb_convert_encoding("[ﾁｪｯｸﾏｰｸ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e133%"] = pack("C*", 0xf7,0x58);
            $ezwebToSoftbank["%e134%"] = pack("C*", 0xf9,0x93);
            $ezwebToSoftbank["%e135%"] = mb_convert_encoding("[電池]", "sjis-win", "auto");
            $ezwebToSoftbank["%e136%"] = mb_convert_encoding("[ｽｸﾛｰﾙ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e137%"] = mb_convert_encoding("[画びょう]", "sjis-win", "auto");
            $ezwebToSoftbank["%e138%"] = pack("C*", 0xf7,0x85);
            $ezwebToSoftbank["%e139%"] = pack("C*", 0xf7,0x6f);
            $ezwebToSoftbank["%e140%"] = pack("C*", 0xf7,0x70);
            $ezwebToSoftbank["%e141%"] = pack("C*", 0xf7,0x71);
            $ezwebToSoftbank["%e142%"] = pack("C*", 0xf7,0x89);
            $ezwebToSoftbank["%e143%"] = mb_convert_encoding("[ｸﾘｯﾌﾟ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e144%"] = pack("C*", 0xf7,0x52);
            $ezwebToSoftbank["%e145%"] = mb_convert_encoding("[名札]", "sjis-win", "auto");
            $ezwebToSoftbank["%e146%"] = pack("C*", 0xf9,0x84);
            $ezwebToSoftbank["%e147%"] = pack("C*", 0xf7,0x89);
            $ezwebToSoftbank["%e148%"] = pack("C*", 0xfb,0x6f);
            $ezwebToSoftbank["%e149%"] = pack("C*", 0xf9,0xa1);
            $ezwebToSoftbank["%e150%"] = mb_convert_encoding("[PDC]", "sjis-win", "auto");
            $ezwebToSoftbank["%e151%"] = pack("C*", 0xf7,0x43);
            $ezwebToSoftbank["%e152%"] = mb_convert_encoding("[ﾚﾝﾁ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e153%"] = mb_convert_encoding("[送信BOX]", "sjis-win", "auto");
            $ezwebToSoftbank["%e154%"] = mb_convert_encoding("[受信BOX]", "sjis-win", "auto");
            $ezwebToSoftbank["%e155%"] = pack("C*", 0xf9,0x49);
            $ezwebToSoftbank["%e156%"] = pack("C*", 0xf9,0x78);
            $ezwebToSoftbank["%e157%"] = mb_convert_encoding("[定規]", "sjis-win", "auto");
            $ezwebToSoftbank["%e158%"] = mb_convert_encoding("[三角定規]", "sjis-win", "auto");
            $ezwebToSoftbank["%e159%"] = mb_convert_encoding("[ｸﾞﾗﾌ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e160%"] = mb_convert_encoding("[肉]", "sjis-win", "auto");
            $ezwebToSoftbank["%e161%"] = pack("C*", 0xf9,0x4a);
            $ezwebToSoftbank["%e162%"] = mb_convert_encoding("[ｺﾝｾﾝﾄ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e163%"] = mb_convert_encoding("[家族]", "sjis-win", "auto");
            $ezwebToSoftbank["%e164%"] = mb_convert_encoding("[ﾘﾝｸ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e165%"] = pack("C*", 0xf7,0x52);
            $ezwebToSoftbank["%e166%"] = pack("C*", 0xf9,0x4b);
            $ezwebToSoftbank["%e167%"] = pack("C*", 0xf9,0x8b).pack("C*", 0xf9,0x8a);
            $ezwebToSoftbank["%e168%"] = pack("C*", 0xf9,0x5d);
            $ezwebToSoftbank["%e169%"] = pack("C*", 0xf9,0x5c);
            $ezwebToSoftbank["%e170%"] = mb_convert_encoding("[ｻｲｺﾛ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e171%"] = mb_convert_encoding("[新聞]", "sjis-win", "auto");
            $ezwebToSoftbank["%e172%"] = pack("C*", 0xf9,0x5e);
            $ezwebToSoftbank["%e173%"] = mb_convert_encoding("　", "sjis-win", "auto");
            $ezwebToSoftbank["%e174%"] = "";
            $ezwebToSoftbank["%e175%"] = "";
            $ezwebToSoftbank["%e176%"] = pack("C*", 0xf9,0xae);
            $ezwebToSoftbank["%e177%"] = pack("C*", 0xf7,0xa8);
            $ezwebToSoftbank["%e178%"] = pack("C*", 0xf7,0xaa);
            $ezwebToSoftbank["%e179%"] = pack("C*", 0xf7,0xa9);
            $ezwebToSoftbank["%e180%"] = pack("C*", 0xf7,0xbc);
            $ezwebToSoftbank["%e181%"] = pack("C*", 0xf7,0xbd);
            $ezwebToSoftbank["%e182%"] = pack("C*", 0xf7,0xbe);
            $ezwebToSoftbank["%e183%"] = pack("C*", 0xf7,0xbf);
            $ezwebToSoftbank["%e184%"] = pack("C*", 0xf7,0xc0);
            $ezwebToSoftbank["%e185%"] = pack("C*", 0xf7,0xc1);
            $ezwebToSoftbank["%e186%"] = pack("C*", 0xf7,0xc2);
            $ezwebToSoftbank["%e187%"] = pack("C*", 0xf7,0xc3);
            $ezwebToSoftbank["%e188%"] = pack("C*", 0xf7,0xc4);
            $ezwebToSoftbank["%e189%"] = mb_convert_encoding("[10]", "sjis-win", "auto");
            $ezwebToSoftbank["%e190%"] = pack("C*", 0xfb,0x84);
            $ezwebToSoftbank["%e191%"] = pack("C*", 0xf9,0x89);
            $ezwebToSoftbank["%e192%"] = pack("C*", 0xf7,0xdf);
            $ezwebToSoftbank["%e193%"] = pack("C*", 0xf7,0xe0);
            $ezwebToSoftbank["%e194%"] = pack("C*", 0xf7,0xe1);
            $ezwebToSoftbank["%e195%"] = pack("C*", 0xf7,0xe2);
            $ezwebToSoftbank["%e196%"] = pack("C*", 0xf7,0xe3);
            $ezwebToSoftbank["%e197%"] = pack("C*", 0xf7,0xe4);
            $ezwebToSoftbank["%e198%"] = pack("C*", 0xf7,0xe5);
            $ezwebToSoftbank["%e199%"] = pack("C*", 0xf7,0xe6);
            $ezwebToSoftbank["%e200%"] = pack("C*", 0xf7,0xe7);
            $ezwebToSoftbank["%e201%"] = pack("C*", 0xf7,0xe8);
            $ezwebToSoftbank["%e202%"] = pack("C*", 0xf7,0xe9);
            $ezwebToSoftbank["%e203%"] = pack("C*", 0xf7,0xea);
            $ezwebToSoftbank["%e204%"] = pack("C*", 0xf7,0xeb);
            $ezwebToSoftbank["%e205%"] = pack("C*", 0xf7,0x95);
            $ezwebToSoftbank["%e206%"] = pack("C*", 0xf7,0x97);
            $ezwebToSoftbank["%e207%"] = pack("C*", 0xf7,0x92);
            $ezwebToSoftbank["%e208%"] = pack("C*", 0xf7,0x90);
            $ezwebToSoftbank["%e209%"] = pack("C*", 0xf7,0x91);
            $ezwebToSoftbank["%e210%"] = pack("C*", 0xf7,0x8c);
            $ezwebToSoftbank["%e211%"] = pack("C*", 0xf7,0xa2);
            $ezwebToSoftbank["%e212%"] = pack("C*", 0xf7,0x8e);
            $ezwebToSoftbank["%e213%"] = pack("C*", 0xf9,0x7a);
            $ezwebToSoftbank["%e214%"] = mb_convert_encoding("[地図]", "sjis-win", "auto");
            $ezwebToSoftbank["%e215%"] = pack("C*", 0xf7,0x76);
            $ezwebToSoftbank["%e216%"] = pack("C*", 0xf7,0x9a);
            $ezwebToSoftbank["%e217%"] = pack("C*", 0xf9,0x5f);
            $ezwebToSoftbank["%e218%"] = pack("C*", 0xf7,0x55);
            $ezwebToSoftbank["%e219%"] = pack("C*", 0xf9,0x58);
            $ezwebToSoftbank["%e220%"] = pack("C*", 0xf9,0x55);
            $ezwebToSoftbank["%e221%"] = mb_convert_encoding("[ｽﾉﾎﾞ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e222%"] = pack("C*", 0xf7,0x72);
            $ezwebToSoftbank["%e223%"] = pack("C*", 0xf7,0x64);
            $ezwebToSoftbank["%e224%"] = pack("C*", 0xf7,0x63);
            $ezwebToSoftbank["%e225%"] = pack("C*", 0xf9,0xab);
            $ezwebToSoftbank["%e226%"] = pack("C*", 0xf9,0xc4);
            $ezwebToSoftbank["%e227%"] = pack("C*", 0xfb,0x8c);
            $ezwebToSoftbank["%e228%"] = pack("C*", 0xfb,0xa9);
            $ezwebToSoftbank["%e229%"] = pack("C*", 0xf7,0x73);
            $ezwebToSoftbank["%e230%"] = mb_convert_encoding("[ｵﾒﾃﾞﾄｳ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e231%"] = pack("C*", 0xf7,0x70);
            $ezwebToSoftbank["%e232%"] = mb_convert_encoding("[ｹﾞｰﾑ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e233%"] = pack("C*", 0xf7,0x6f);
            $ezwebToSoftbank["%e234%"] = pack("C*", 0xf9,0x73);
            $ezwebToSoftbank["%e235%"] = pack("C*", 0xf9,0x70);
            $ezwebToSoftbank["%e236%"] = pack("C*", 0xf7,0x5b);
            $ezwebToSoftbank["%e237%"] = pack("C*", 0xfb,0xab);
            $ezwebToSoftbank["%e238%"] = pack("C*", 0xf9,0xe8);
            $ezwebToSoftbank["%e239%"] = pack("C*", 0xf9,0x87);
            $ezwebToSoftbank["%e240%"] = pack("C*", 0xf7,0x88);
            $ezwebToSoftbank["%e241%"] = mb_convert_encoding("[さくらんぼ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e242%"] = pack("C*", 0xf9,0x59);
            $ezwebToSoftbank["%e243%"] = pack("C*", 0xf9,0xe7);
            $ezwebToSoftbank["%e244%"] = pack("C*", 0xf9,0xe2);
            $ezwebToSoftbank["%e245%"] = pack("C*", 0xf7,0x60);
            $ezwebToSoftbank["%e246%"] = pack("C*", 0xf9,0x95);
            $ezwebToSoftbank["%e247%"] = pack("C*", 0xfb,0xcc);
            $ezwebToSoftbank["%e248%"] = pack("C*", 0xf9,0x5a);
            $ezwebToSoftbank["%e249%"] = pack("C*", 0xf7,0x49);
            $ezwebToSoftbank["%e250%"] = pack("C*", 0xfb,0xd1);
            $ezwebToSoftbank["%e251%"] = pack("C*", 0xf9,0x90);
            $ezwebToSoftbank["%e252%"] = pack("C*", 0xf9,0x96);
            $ezwebToSoftbank["%e253%"] = mb_convert_encoding("[ｱﾘ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e254%"] = pack("C*", 0xf7,0x4b);
            $ezwebToSoftbank["%e255%"] = pack("C*", 0xf9,0xa7);
            $ezwebToSoftbank["%e256%"] = pack("C*", 0xf9,0xa5);
            $ezwebToSoftbank["%e257%"] = pack("C*", 0xf9,0x98);
            $ezwebToSoftbank["%e258%"] = pack("C*", 0xf9,0x9a);
            $ezwebToSoftbank["%e259%"] = pack("C*", 0xfb,0x51);
            $ezwebToSoftbank["%e260%"] = pack("C*", 0xfb,0x46);
            $ezwebToSoftbank["%e261%"] = pack("C*", 0xf7,0x7c);
            $ezwebToSoftbank["%e262%"] = pack("C*", 0xf9,0xd4);
            $ezwebToSoftbank["%e263%"] = pack("C*", 0xf9,0xd1);
            $ezwebToSoftbank["%e264%"] = pack("C*", 0xf7,0x45);
            $ezwebToSoftbank["%e265%"] = pack("C*", 0xf9,0x63);
            $ezwebToSoftbank["%e266%"] = pack("C*", 0xf9,0xc7);
            $ezwebToSoftbank["%e267%"] = pack("C*", 0xf9,0xce);
            $ezwebToSoftbank["%e268%"] = pack("C*", 0xf9,0xb1);
            $ezwebToSoftbank["%e269%"] = pack("C*", 0xf7,0x5d);
            $ezwebToSoftbank["%e270%"] = mb_convert_encoding("[SOS]", "sjis-win", "auto");
            $ezwebToSoftbank["%e271%"] = pack("C*", 0xf7,0x8d);
            $ezwebToSoftbank["%e272%"] = pack("C*", 0xf9,0xc9);
            $ezwebToSoftbank["%e273%"] = pack("C*", 0xf9,0x43);
            $ezwebToSoftbank["%e274%"] = pack("C*", 0xf7,0x4c);
            $ezwebToSoftbank["%e275%"] = mb_convert_encoding("[なると]", "sjis-win", "auto");
            $ezwebToSoftbank["%e276%"] = pack("C*", 0xfb,0xd6);
            $ezwebToSoftbank["%e277%"] = pack("C*", 0xf7,0x5a);
            $ezwebToSoftbank["%e278%"] = mb_convert_encoding("[花丸]", "sjis-win", "auto");
            $ezwebToSoftbank["%e279%"] = pack("C*", 0xf9,0xb5);
            $ezwebToSoftbank["%e280%"] = mb_convert_encoding("[100点]", "sjis-win", "auto");
            $ezwebToSoftbank["%e281%"] = pack("C*", 0xf9,0x4d);
            $ezwebToSoftbank["%e282%"] = pack("C*", 0xf9,0xd0);
            $ezwebToSoftbank["%e283%"] = pack("C*", 0xf9,0x9b);
            $ezwebToSoftbank["%e284%"] = pack("C*", 0xf9,0x4f);
            $ezwebToSoftbank["%e285%"] = pack("C*", 0xf7,0xc6);
            $ezwebToSoftbank["%e286%"] = pack("C*", 0xf7,0x5c);
            $ezwebToSoftbank["%e287%"] = pack("C*", 0xf9,0x4e);
            $ezwebToSoftbank["%e288%"] = pack("C*", 0xf7,0x6a);
            $ezwebToSoftbank["%e289%"] = pack("C*", 0xf9,0x7c);
            $ezwebToSoftbank["%e290%"] = mb_convert_encoding("[財布]", "sjis-win", "auto");
            $ezwebToSoftbank["%e291%"] = pack("C*", 0xf9,0xc6);
            $ezwebToSoftbank["%e292%"] = pack("C*", 0xf9,0x82);
            $ezwebToSoftbank["%e293%"] = mb_convert_encoding("[ﾊﾞｲｵﾘﾝ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e294%"] = pack("C*", 0xf9,0xaa);
            $ezwebToSoftbank["%e295%"] = pack("C*", 0xf9,0xbc);
            $ezwebToSoftbank["%e296%"] = pack("C*", 0xf7,0x53);
            $ezwebToSoftbank["%e297%"] = pack("C*", 0xf9,0xbe);
            $ezwebToSoftbank["%e298%"] = mb_convert_encoding("[EZ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e299%"] = mb_convert_encoding("[FREE]", "sjis-win", "auto");
            $ezwebToSoftbank["%e300%"] = pack("C*", 0xf7,0x66);
            $ezwebToSoftbank["%e301%"] = pack("C*", 0xf9,0x46);
            $ezwebToSoftbank["%e302%"] = pack("C*", 0xf7,0x4c);
            $ezwebToSoftbank["%e303%"] = pack("C*", 0xf7,0xb3);
            $ezwebToSoftbank["%e304%"] = pack("C*", 0xf7,0x7b);
            $ezwebToSoftbank["%e305%"] = mb_convert_encoding("[霧]", "sjis-win", "auto");
            $ezwebToSoftbank["%e306%"] = pack("C*", 0xf9,0x54);
            $ezwebToSoftbank["%e307%"] = pack("C*", 0xfb,0x6a);
            $ezwebToSoftbank["%e308%"] = mb_convert_encoding("[ﾎﾟｹﾍﾞﾙ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e309%"] = pack("C*", 0xfb,0xa2);
            $ezwebToSoftbank["%e310%"] = pack("C*", 0xfb,0xa3);
            $ezwebToSoftbank["%e311%"] = mb_convert_encoding("[ｲﾍﾞﾝﾄ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e312%"] = pack("C*", 0xf9,0xb4);
            $ezwebToSoftbank["%e313%"] = pack("C*", 0xf9,0xeb);
            $ezwebToSoftbank["%e314%"] = pack("C*", 0xf7,0xae);
            $ezwebToSoftbank["%e315%"] = pack("C*", 0xf7,0xad);
            $ezwebToSoftbank["%e316%"] = pack("C*", 0xf7,0xaf);
            $ezwebToSoftbank["%e317%"] = pack("C*", 0xfb,0x59);
            $ezwebToSoftbank["%e318%"] = pack("C*", 0xfb,0x5b);
            $ezwebToSoftbank["%e319%"] = pack("C*", 0xf9,0x51);
            $ezwebToSoftbank["%e320%"] = pack("C*", 0xf9,0x52);
            $ezwebToSoftbank["%e321%"] = mb_convert_encoding("●", "sjis-win", "auto");
            $ezwebToSoftbank["%e322%"] = pack("C*", 0xf9,0x8d);
            $ezwebToSoftbank["%e323%"] = pack("C*", 0xf9,0x8d);
            $ezwebToSoftbank["%e324%"] = mb_convert_encoding("[CL]", "sjis-win", "auto");
            $ezwebToSoftbank["%e325%"] = pack("C*", 0xf7,0xc5);
            $ezwebToSoftbank["%e326%"] = pack("C*", 0xf7,0xed);
            $ezwebToSoftbank["%e327%"] = pack("C*", 0xfb,0x46);
            $ezwebToSoftbank["%e328%"] = pack("C*", 0xf9,0xc7);
            $ezwebToSoftbank["%e329%"] = mb_convert_encoding("[ﾄﾞﾝｯ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e330%"] = pack("C*", 0xf9,0xd1);
            $ezwebToSoftbank["%e331%"] = mb_convert_encoding("[ezplus]", "sjis-win", "auto");
            $ezwebToSoftbank["%e332%"] = mb_convert_encoding("[地球]", "sjis-win", "auto");
            $ezwebToSoftbank["%e333%"] = pack("C*", 0xf9,0xe0);
            $ezwebToSoftbank["%e334%"] = pack("C*", 0xf7,0xb2);
            $ezwebToSoftbank["%e335%"] = pack("C*", 0xf9,0x46);
            $ezwebToSoftbank["%e336%"] = pack("C*", 0xf9,0x47);
            $ezwebToSoftbank["%e337%"] = pack("C*", 0xf9,0x4c);
            $ezwebToSoftbank["%e338%"] = pack("C*", 0xf7,0x68);
            $ezwebToSoftbank["%e339%"] = pack("C*", 0xf9,0x72);
            $ezwebToSoftbank["%e340%"] = pack("C*", 0xf9,0x77);
            $ezwebToSoftbank["%e341%"] = pack("C*", 0xfb,0x74);
            $ezwebToSoftbank["%e342%"] = pack("C*", 0xf9,0x7b);
            $ezwebToSoftbank["%e343%"] = pack("C*", 0xf9,0x7e);
            $ezwebToSoftbank["%e344%"] = pack("C*", 0xf9,0x8f);
            $ezwebToSoftbank["%e345%"] = pack("C*", 0xf9,0x91);
            $ezwebToSoftbank["%e346%"] = pack("C*", 0xf9,0x92);
            $ezwebToSoftbank["%e347%"] = pack("C*", 0xf9,0x94);
            $ezwebToSoftbank["%e348%"] = pack("C*", 0xfb,0x45);
            $ezwebToSoftbank["%e349%"] = pack("C*", 0xf7,0x46);
            $ezwebToSoftbank["%e350%"] = pack("C*", 0xfb,0x50);
            $ezwebToSoftbank["%e351%"] = pack("C*", 0xf7,0x48);
            $ezwebToSoftbank["%e352%"] = pack("C*", 0xf7,0x4a);
            $ezwebToSoftbank["%e353%"] = pack("C*", 0xf7,0x4d);
            $ezwebToSoftbank["%e354%"] = pack("C*", 0xf7,0x4e);
            $ezwebToSoftbank["%e355%"] = pack("C*", 0xf7,0x51);
            $ezwebToSoftbank["%e356%"] = pack("C*", 0xf7,0x56);
            $ezwebToSoftbank["%e357%"] = pack("C*", 0xf7,0x57);
            $ezwebToSoftbank["%e358%"] = pack("C*", 0xf7,0x59);
            $ezwebToSoftbank["%e359%"] = pack("C*", 0xf7,0x5e);
            $ezwebToSoftbank["%e360%"] = pack("C*", 0xf7,0x61);
            $ezwebToSoftbank["%e361%"] = pack("C*", 0xf7,0x62);
            $ezwebToSoftbank["%e362%"] = pack("C*", 0xf7,0x6d);
            $ezwebToSoftbank["%e363%"] = pack("C*", 0xf7,0x6e);
            $ezwebToSoftbank["%e364%"] = pack("C*", 0xf7,0x71);
            $ezwebToSoftbank["%e365%"] = mb_convert_encoding("[ｶﾒ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e366%"] = pack("C*", 0xfb,0xb1);
            $ezwebToSoftbank["%e367%"] = pack("C*", 0xfb,0xb2);
            $ezwebToSoftbank["%e368%"] = pack("C*", 0xf7,0x77);
            $ezwebToSoftbank["%e369%"] = pack("C*", 0xf7,0x80);
            $ezwebToSoftbank["%e370%"] = pack("C*", 0xf7,0x84);
            $ezwebToSoftbank["%e371%"] = pack("C*", 0xf7,0x97);
            $ezwebToSoftbank["%e372%"] = pack("C*", 0xfb,0xc3);
            $ezwebToSoftbank["%e373%"] = pack("C*", 0xf7,0x8b);
            $ezwebToSoftbank["%e374%"] = pack("C*", 0xf7,0x93);
            $ezwebToSoftbank["%e375%"] = pack("C*", 0xf7,0x94);
            $ezwebToSoftbank["%e376%"] = pack("C*", 0xf7,0x96);
            $ezwebToSoftbank["%e377%"] = pack("C*", 0xf7,0x98);
            $ezwebToSoftbank["%e378%"] = pack("C*", 0xf7,0x99);
            $ezwebToSoftbank["%e379%"] = pack("C*", 0xf7,0xa2);
            $ezwebToSoftbank["%e380%"] = pack("C*", 0xf7,0xa7);
            $ezwebToSoftbank["%e381%"] = pack("C*", 0xf7,0xab);
            $ezwebToSoftbank["%e382%"] = pack("C*", 0xf7,0xb4);
            $ezwebToSoftbank["%e383%"] = pack("C*", 0xf7,0xc7);
            $ezwebToSoftbank["%e384%"] = pack("C*", 0xf7,0xc8);
            $ezwebToSoftbank["%e385%"] = pack("C*", 0xf7,0xc9);
            $ezwebToSoftbank["%e386%"] = pack("C*", 0xf7,0xca);
            $ezwebToSoftbank["%e387%"] = pack("C*", 0xf7,0xcb);
            $ezwebToSoftbank["%e388%"] = pack("C*", 0xf7,0xcc);
            $ezwebToSoftbank["%e389%"] = pack("C*", 0xf7,0xcd);
            $ezwebToSoftbank["%e390%"] = pack("C*", 0xf7,0xce);
            $ezwebToSoftbank["%e391%"] = pack("C*", 0xf7,0xcf);
            $ezwebToSoftbank["%e392%"] = pack("C*", 0xf7,0xde);
            $ezwebToSoftbank["%e393%"] = pack("C*", 0xf7,0xf0);
            $ezwebToSoftbank["%e394%"] = pack("C*", 0xf7,0xf1);
            $ezwebToSoftbank["%e395%"] = pack("C*", 0xf9,0xa1);
            $ezwebToSoftbank["%e396%"] = pack("C*", 0xf9,0xdc);
            $ezwebToSoftbank["%e397%"] = pack("C*", 0xf9,0xa3);
            $ezwebToSoftbank["%e398%"] = pack("C*", 0xf9,0xa6);
            $ezwebToSoftbank["%e399%"] = pack("C*", 0xf9,0xa8);
            $ezwebToSoftbank["%e400%"] = pack("C*", 0xf9,0xab);
            $ezwebToSoftbank["%e401%"] = pack("C*", 0xf9,0xac);
            $ezwebToSoftbank["%e402%"] = pack("C*", 0xf9,0xad);
            $ezwebToSoftbank["%e403%"] = pack("C*", 0xf9,0xaf);
            $ezwebToSoftbank["%e404%"] = pack("C*", 0xf9,0xb0);
            $ezwebToSoftbank["%e405%"] = pack("C*", 0xf9,0xb2);
            $ezwebToSoftbank["%e406%"] = mb_convert_encoding("[EZﾅﾋﾞ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e407%"] = pack("C*", 0xf9,0xb8);
            $ezwebToSoftbank["%e408%"] = pack("C*", 0xf9,0xbb);
            $ezwebToSoftbank["%e409%"] = pack("C*", 0xf9,0xbd);
            $ezwebToSoftbank["%e410%"] = pack("C*", 0xf9,0xbf);
            $ezwebToSoftbank["%e411%"] = pack("C*", 0xf9,0xc0);
            $ezwebToSoftbank["%e412%"] = pack("C*", 0xf9,0xc1);
            $ezwebToSoftbank["%e413%"] = pack("C*", 0xf9,0xc2);
            $ezwebToSoftbank["%e414%"] = pack("C*", 0xf7,0xac);
            $ezwebToSoftbank["%e415%"] = pack("C*", 0xf9,0xc7);
            $ezwebToSoftbank["%e416%"] = pack("C*", 0xf9,0xca);
            $ezwebToSoftbank["%e417%"] = pack("C*", 0xf9,0xcb);
            $ezwebToSoftbank["%e418%"] = pack("C*", 0xf9,0xcc);
            $ezwebToSoftbank["%e419%"] = pack("C*", 0xf9,0xcd);
            $ezwebToSoftbank["%e420%"] = pack("C*", 0xf9,0xce);
            $ezwebToSoftbank["%e421%"] = pack("C*", 0xf9,0x53);
            $ezwebToSoftbank["%e422%"] = pack("C*", 0xf9,0xd2);
            $ezwebToSoftbank["%e423%"] = pack("C*", 0xf9,0xd8);
            $ezwebToSoftbank["%e424%"] = pack("C*", 0xf9,0xd9);
            $ezwebToSoftbank["%e425%"] = pack("C*", 0xf9,0xda);
            $ezwebToSoftbank["%e426%"] = pack("C*", 0xf9,0xdb);
            $ezwebToSoftbank["%e427%"] = pack("C*", 0xf9,0xdc);
            $ezwebToSoftbank["%e428%"] = pack("C*", 0xf9,0xdd);
            $ezwebToSoftbank["%e429%"] = pack("C*", 0xf9,0xde);
            $ezwebToSoftbank["%e430%"] = pack("C*", 0xf9,0xdf);
            $ezwebToSoftbank["%e431%"] = pack("C*", 0xf9,0xe1);
            $ezwebToSoftbank["%e432%"] = pack("C*", 0xf9,0xe3);
            $ezwebToSoftbank["%e433%"] = pack("C*", 0xf9,0xe4);
            $ezwebToSoftbank["%e434%"] = pack("C*", 0xf9,0xe5);
            $ezwebToSoftbank["%e435%"] = pack("C*", 0xf9,0xe6);
            $ezwebToSoftbank["%e436%"] = pack("C*", 0xf9,0xe9);
            $ezwebToSoftbank["%e437%"] = pack("C*", 0xf9,0xea);
            $ezwebToSoftbank["%e438%"] = pack("C*", 0xf9,0xec);
            $ezwebToSoftbank["%e439%"] = pack("C*", 0xf9,0xed);
            $ezwebToSoftbank["%e440%"] = pack("C*", 0xfb,0x42);
            $ezwebToSoftbank["%e441%"] = pack("C*", 0xfb,0x43);
            $ezwebToSoftbank["%e442%"] = pack("C*", 0xfb,0x44);
            $ezwebToSoftbank["%e443%"] = pack("C*", 0xfb,0x46);
            $ezwebToSoftbank["%e444%"] = pack("C*", 0xfb,0x47);
            $ezwebToSoftbank["%e445%"] = pack("C*", 0xfb,0x48);
            $ezwebToSoftbank["%e446%"] = pack("C*", 0xfb,0x4a);
            $ezwebToSoftbank["%e447%"] = pack("C*", 0xfb,0x4b);
            $ezwebToSoftbank["%e448%"] = pack("C*", 0xfb,0x4c);
            $ezwebToSoftbank["%e449%"] = pack("C*", 0xfb,0x4d);
            $ezwebToSoftbank["%e450%"] = pack("C*", 0xfb,0x4e);
            $ezwebToSoftbank["%e451%"] = pack("C*", 0xfb,0x50);
            $ezwebToSoftbank["%e452%"] = pack("C*", 0xfb,0x4f);
            $ezwebToSoftbank["%e453%"] = pack("C*", 0xf9,0xc6);
            $ezwebToSoftbank["%e454%"] = pack("C*", 0xf9,0x97);
            $ezwebToSoftbank["%e455%"] = pack("C*", 0xfb,0x57);
            $ezwebToSoftbank["%e456%"] = pack("C*", 0xfb,0x58);
            $ezwebToSoftbank["%e457%"] = pack("C*", 0xfb,0x5a);
            $ezwebToSoftbank["%e458%"] = pack("C*", 0xfb,0x5c);
            $ezwebToSoftbank["%e459%"] = pack("C*", 0xfb,0x5d);
            $ezwebToSoftbank["%e460%"] = pack("C*", 0xfb,0x5f);
            $ezwebToSoftbank["%e461%"] = pack("C*", 0xfb,0x60);
            $ezwebToSoftbank["%e462%"] = pack("C*", 0xfb,0x61);
            $ezwebToSoftbank["%e463%"] = pack("C*", 0xfb,0x5e);
            $ezwebToSoftbank["%e464%"] = pack("C*", 0xfb,0x63);
            $ezwebToSoftbank["%e465%"] = pack("C*", 0xfb,0x64);
            $ezwebToSoftbank["%e466%"] = pack("C*", 0xfb,0x66);
            $ezwebToSoftbank["%e467%"] = pack("C*", 0xfb,0x65);
            $ezwebToSoftbank["%e468%"] = pack("C*", 0xfb,0x69);
            $ezwebToSoftbank["%e469%"] = pack("C*", 0xf9,0x83);
            $ezwebToSoftbank["%e470%"] = pack("C*", 0xfb,0x6c);
            $ezwebToSoftbank["%e471%"] = pack("C*", 0xfb,0x6d);
            $ezwebToSoftbank["%e472%"] = pack("C*", 0xfb,0x70);
            $ezwebToSoftbank["%e473%"] = pack("C*", 0xfb,0x71);
            $ezwebToSoftbank["%e474%"] = pack("C*", 0xfb,0x72);
            $ezwebToSoftbank["%e475%"] = pack("C*", 0xfb,0x73);
            $ezwebToSoftbank["%e476%"] = pack("C*", 0xfb,0x76);
            $ezwebToSoftbank["%e477%"] = pack("C*", 0xfb,0x78);
            $ezwebToSoftbank["%e478%"] = pack("C*", 0xfb,0x79);
            $ezwebToSoftbank["%e479%"] = pack("C*", 0xfb,0x7a);
            $ezwebToSoftbank["%e480%"] = pack("C*", 0xfb,0x7b);
            $ezwebToSoftbank["%e481%"] = pack("C*", 0xfb,0x7c);
            $ezwebToSoftbank["%e482%"] = mb_convert_encoding("[花嫁]", "sjis-win", "auto");
            $ezwebToSoftbank["%e483%"] = pack("C*", 0xfb,0x80);
            $ezwebToSoftbank["%e484%"] = pack("C*", 0xfb,0x81);
            $ezwebToSoftbank["%e485%"] = pack("C*", 0xfb,0x82);
            $ezwebToSoftbank["%e486%"] = pack("C*", 0xfb,0x83);
            $ezwebToSoftbank["%e487%"] = pack("C*", 0xfb,0x86);
            $ezwebToSoftbank["%e488%"] = pack("C*", 0xfb,0x87);
            $ezwebToSoftbank["%e489%"] = pack("C*", 0xfb,0x89);
            $ezwebToSoftbank["%e490%"] = pack("C*", 0xfb,0x8c);
            $ezwebToSoftbank["%e491%"] = pack("C*", 0xfb,0x8d);
            $ezwebToSoftbank["%e492%"] = pack("C*", 0xfb,0xa1);
            $ezwebToSoftbank["%e493%"] = pack("C*", 0xfb,0x8a);
            $ezwebToSoftbank["%e494%"] = pack("C*", 0xfb,0xa3);
            $ezwebToSoftbank["%e495%"] = pack("C*", 0xfb,0xa4);
            $ezwebToSoftbank["%e496%"] = pack("C*", 0xfb,0xa5);
            $ezwebToSoftbank["%e497%"] = pack("C*", 0xfb,0xa6);
            $ezwebToSoftbank["%e498%"] = pack("C*", 0xfb,0xa8);
            $ezwebToSoftbank["%e499%"] = pack("C*", 0xfb,0xad);
            $ezwebToSoftbank["%e500%"] = mb_convert_encoding("[ｵｰﾌﾟﾝｳｪﾌﾞ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e501%"] = pack("C*", 0xf7,0x85);
            $ezwebToSoftbank["%e502%"] = mb_convert_encoding("[ABCD]", "sjis-win", "auto");
            $ezwebToSoftbank["%e503%"] = mb_convert_encoding("[abcd]", "sjis-win", "auto");
            $ezwebToSoftbank["%e504%"] = mb_convert_encoding("[1234]", "sjis-win", "auto");
            $ezwebToSoftbank["%e505%"] = mb_convert_encoding("[記号]", "sjis-win", "auto");
            $ezwebToSoftbank["%e506%"] = mb_convert_encoding("[可]", "sjis-win", "auto");
            $ezwebToSoftbank["%e507%"] = mb_convert_encoding("[ﾁｪｯｸﾏｰｸ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e508%"] = mb_convert_encoding("[ﾍﾟﾝ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e509%"] = mb_convert_encoding("[ﾗｼﾞｵﾎﾞﾀﾝ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e510%"] = pack("C*", 0xf7,0x54);
            $ezwebToSoftbank["%e511%"] = pack("C*", 0xf7,0xd5);
            $ezwebToSoftbank["%e512%"] = mb_convert_encoding("[ﾌﾞｯｸﾏｰｸ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e513%"] = pack("C*", 0xf7,0x7c);
            $ezwebToSoftbank["%e514%"] = pack("C*", 0xf9,0x76);
            $ezwebToSoftbank["%e515%"] = pack("C*", 0xf7,0x41);
            $ezwebToSoftbank["%e516%"] = pack("C*", 0xf9,0xa1);
            $ezwebToSoftbank["%e517%"] = pack("C*", 0xf7,0x85);
            $ezwebToSoftbank["%e518%"] = mb_convert_encoding("↑↓", "sjis-win", "auto");
            $ezwebToSoftbank["%e700%"] = pack("C*", 0xfb,0xae);
            $ezwebToSoftbank["%e701%"] = pack("C*", 0xfb,0xaf);
            $ezwebToSoftbank["%e702%"] = pack("C*", 0xfb,0xb0);
            $ezwebToSoftbank["%e703%"] = pack("C*", 0xfb,0xb3);
            $ezwebToSoftbank["%e704%"] = pack("C*", 0xfb,0xb4);
            $ezwebToSoftbank["%e705%"] = pack("C*", 0xfb,0xb5);
            $ezwebToSoftbank["%e706%"] = pack("C*", 0xfb,0xb6);
            $ezwebToSoftbank["%e707%"] = pack("C*", 0xfb,0xb7);
            $ezwebToSoftbank["%e708%"] = pack("C*", 0xfb,0xb8);
            $ezwebToSoftbank["%e709%"] = pack("C*", 0xfb,0xb9);
            $ezwebToSoftbank["%e710%"] = pack("C*", 0xfb,0xba);
            $ezwebToSoftbank["%e711%"] = pack("C*", 0xfb,0xbb);
            $ezwebToSoftbank["%e712%"] = pack("C*", 0xfb,0xbc);
            $ezwebToSoftbank["%e713%"] = pack("C*", 0xfb,0xc0);
            $ezwebToSoftbank["%e714%"] = pack("C*", 0xfb,0xbf);
            $ezwebToSoftbank["%e715%"] = pack("C*", 0xfb,0xc2);
            $ezwebToSoftbank["%e716%"] = pack("C*", 0xfb,0xc5);
            $ezwebToSoftbank["%e717%"] = pack("C*", 0xfb,0xc6);
            $ezwebToSoftbank["%e718%"] = pack("C*", 0xfb,0xc7);
            $ezwebToSoftbank["%e719%"] = pack("C*", 0xfb,0xcb);
            $ezwebToSoftbank["%e720%"] = pack("C*", 0xfb,0xcd);
            $ezwebToSoftbank["%e721%"] = pack("C*", 0xfb,0xce);
            $ezwebToSoftbank["%e722%"] = pack("C*", 0xfb,0xcf);
            $ezwebToSoftbank["%e723%"] = pack("C*", 0xfb,0xd0);
            $ezwebToSoftbank["%e724%"] = pack("C*", 0xfb,0xd2);
            $ezwebToSoftbank["%e725%"] = pack("C*", 0xfb,0xd3);
            $ezwebToSoftbank["%e726%"] = pack("C*", 0xfb,0xd5);
            $ezwebToSoftbank["%e727%"] = pack("C*", 0xfb,0xd4);
            $ezwebToSoftbank["%e728%"] = pack("C*", 0xfb,0xd6);
            $ezwebToSoftbank["%e729%"] = pack("C*", 0xf9,0x47);
            $ezwebToSoftbank["%e730%"] = mb_convert_encoding("[旗]", "sjis-win", "auto");
            $ezwebToSoftbank["%e731%"] = pack("C*", 0xf7,0xd6);
            $ezwebToSoftbank["%e732%"] = pack("C*", 0xf7,0xd8);
            $ezwebToSoftbank["%e733%"] = mb_convert_encoding("!?", "sjis-win", "auto");
            $ezwebToSoftbank["%e734%"] = mb_convert_encoding("!!", "sjis-win", "auto");
            $ezwebToSoftbank["%e735%"] = mb_convert_encoding("～", "sjis-win", "auto");
            $ezwebToSoftbank["%e736%"] = mb_convert_encoding("[ﾒﾛﾝ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e737%"] = mb_convert_encoding("[ﾊﾟｲﾅｯﾌﾟﾙ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e738%"] = mb_convert_encoding("[ﾌﾞﾄﾞｳ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e739%"] = mb_convert_encoding("[ﾊﾞﾅﾅ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e740%"] = mb_convert_encoding("[とうもろこし]", "sjis-win", "auto");
            $ezwebToSoftbank["%e741%"] = mb_convert_encoding("[ｷﾉｺ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e742%"] = mb_convert_encoding("[栗]", "sjis-win", "auto");
            $ezwebToSoftbank["%e743%"] = mb_convert_encoding("[ﾓﾓ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e744%"] = mb_convert_encoding("[やきいも]", "sjis-win", "auto");
            $ezwebToSoftbank["%e745%"] = mb_convert_encoding("[ﾋﾟｻﾞ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e746%"] = mb_convert_encoding("[ﾁｷﾝ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e747%"] = mb_convert_encoding("[七夕]", "sjis-win", "auto");
            $ezwebToSoftbank["%e748%"] = pack("C*", 0xf9,0x85);
            $ezwebToSoftbank["%e749%"] = mb_convert_encoding("[辰]", "sjis-win", "auto");
            $ezwebToSoftbank["%e750%"] = mb_convert_encoding("[ﾋﾟｱﾉ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e751%"] = pack("C*", 0xf9,0x57);
            $ezwebToSoftbank["%e752%"] = pack("C*", 0xf9,0x59);
            $ezwebToSoftbank["%e753%"] = mb_convert_encoding("[ﾎﾞｰﾘﾝｸﾞ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e754%"] = mb_convert_encoding("[なまはげ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e755%"] = mb_convert_encoding("[天狗]", "sjis-win", "auto");
            $ezwebToSoftbank["%e756%"] = mb_convert_encoding("[ﾊﾟﾝﾀﾞ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e757%"] = pack("C*", 0xfb,0x49);
            $ezwebToSoftbank["%e758%"] = pack("C*", 0xf7,0x4b);
            $ezwebToSoftbank["%e759%"] = pack("C*", 0xf9,0xa5);
            $ezwebToSoftbank["%e760%"] = mb_convert_encoding("[ｱｲｽｸﾘｰﾑ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e761%"] = mb_convert_encoding("[ﾄﾞｰﾅﾂ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e762%"] = mb_convert_encoding("[ｸｯｷｰ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e763%"] = mb_convert_encoding("[ﾁｮｺ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e764%"] = mb_convert_encoding("[ｷｬﾝﾃﾞｨ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e765%"] = mb_convert_encoding("[ｷｬﾝﾃﾞｨ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e766%"] = mb_convert_encoding("(/_＼)", "sjis-win", "auto");
            $ezwebToSoftbank["%e767%"] = mb_convert_encoding("(・×・)", "sjis-win", "auto");
            $ezwebToSoftbank["%e768%"] = mb_convert_encoding("|(・×・)|", "sjis-win", "auto");
            $ezwebToSoftbank["%e769%"] = mb_convert_encoding("[火山]", "sjis-win", "auto");
            $ezwebToSoftbank["%e770%"] = pack("C*", 0xf9,0xc8);
            $ezwebToSoftbank["%e771%"] = mb_convert_encoding("[ABC]", "sjis-win", "auto");
            $ezwebToSoftbank["%e772%"] = mb_convert_encoding("[ﾌﾟﾘﾝ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e773%"] = mb_convert_encoding("[ﾐﾂﾊﾞﾁ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e774%"] = mb_convert_encoding("[てんとう虫]", "sjis-win", "auto");
            $ezwebToSoftbank["%e775%"] = mb_convert_encoding("[ﾊﾁﾐﾂ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e776%"] = pack("C*", 0xf9,0xe5);
            $ezwebToSoftbank["%e777%"] = mb_convert_encoding("[飛んでいくお金]", "sjis-win", "auto");
            $ezwebToSoftbank["%e778%"] = pack("C*", 0xfb,0x47);
            $ezwebToSoftbank["%e779%"] = pack("C*", 0xfb,0x56);
            $ezwebToSoftbank["%e780%"] = pack("C*", 0xfb,0x56);
            $ezwebToSoftbank["%e781%"] = pack("C*", 0xfb,0x8c);
            $ezwebToSoftbank["%e782%"] = pack("C*", 0xfb,0x58);
            $ezwebToSoftbank["%e783%"] = pack("C*", 0xf9,0x98);
            $ezwebToSoftbank["%e784%"] = pack("C*", 0xf7,0x43);
            $ezwebToSoftbank["%e785%"] = pack("C*", 0xfb,0x52);
            $ezwebToSoftbank["%e786%"] = pack("C*", 0xfb,0x52);
            $ezwebToSoftbank["%e787%"] = pack("C*", 0xf7,0x46);
            $ezwebToSoftbank["%e788%"] = pack("C*", 0xfb,0x43);
            $ezwebToSoftbank["%e789%"] = pack("C*", 0xfb,0x43);
            $ezwebToSoftbank["%e790%"] = pack("C*", 0xfb,0x53);
            $ezwebToSoftbank["%e791%"] = pack("C*", 0xfb,0x53);
            $ezwebToSoftbank["%e792%"] = pack("C*", 0xfb,0x44);
            $ezwebToSoftbank["%e793%"] = pack("C*", 0xf9,0xb9);
            $ezwebToSoftbank["%e794%"] = mb_convert_encoding("[ﾓｱｲ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e795%"] = pack("C*", 0xf9,0x79);
            $ezwebToSoftbank["%e796%"] = mb_convert_encoding("[花札]", "sjis-win", "auto");
            $ezwebToSoftbank["%e797%"] = mb_convert_encoding("[ｼﾞｮｰｶｰ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e798%"] = mb_convert_encoding("[ｴﾋﾞﾌﾗｲ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e799%"] = pack("C*", 0xf7,0x43);
            $ezwebToSoftbank["%e800%"] = pack("C*", 0xf7,0xa1);
            $ezwebToSoftbank["%e801%"] = pack("C*", 0xfb,0x72);
            $ezwebToSoftbank["%e802%"] = mb_convert_encoding("[EZﾑｰﾋﾞｰ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e803%"] = pack("C*", 0xf9,0xc7);
            $ezwebToSoftbank["%e804%"] = pack("C*", 0xfb,0xc3);
            $ezwebToSoftbank["%e805%"] = mb_convert_encoding("[ｼﾞｰﾝｽﾞ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e806%"] = mb_convert_encoding("E#OH", "sjis-win", "auto");
            $ezwebToSoftbank["%e807%"] = mb_convert_encoding("↑↓", "sjis-win", "auto");
            $ezwebToSoftbank["%e808%"] = mb_convert_encoding("⇔", "sjis-win", "auto");
            $ezwebToSoftbank["%e809%"] = mb_convert_encoding("↑↓", "sjis-win", "auto");
            $ezwebToSoftbank["%e810%"] = pack("C*", 0xfb,0x7e);
            $ezwebToSoftbank["%e811%"] = pack("C*", 0xf7,0x50);
            $ezwebToSoftbank["%e812%"] = mb_convert_encoding("[ｶﾀﾂﾑﾘ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e813%"] = pack("C*", 0xfb,0x44);
            $ezwebToSoftbank["%e814%"] = pack("C*", 0xfb,0x44);
            $ezwebToSoftbank["%e815%"] = mb_convert_encoding("[Cﾒｰﾙ]", "sjis-win", "auto");
            $ezwebToSoftbank["%e816%"] = pack("C*", 0xf7,0x50);
            $ezwebToSoftbank["%e817%"] = pack("C*", 0xf9,0x50);
            $ezwebToSoftbank["%e818%"] = pack("C*", 0xf7,0xb0);
            $ezwebToSoftbank["%e819%"] = pack("C*", 0xf9,0x52);
            $ezwebToSoftbank["%e820%"] = pack("C*", 0xfb,0x67);
            $ezwebToSoftbank["%e821%"] = pack("C*", 0xfb,0x43);
            $ezwebToSoftbank["%e822%"] = pack("C*", 0xfb,0x56);
        }

        return $ezwebToSoftbank;
    }

    /**
     * getSoftbankToSoftbankMailメソッド
     *
     * getJphoneEmojiのエイリアス(出力時はJphoneコード)
     * ※可変関数を使用する都合上必要
     * メール送信用
     *
     * @return $softbankEmoji Docomo絵文字配列
     */
    public static function getSoftbankToSoftbankMail() {
        return self::getJphoneEmojiMail();
    }

    /**
     * getJphoneEmojiMailメソッド
     *
     * Softbank用の変換文字をキーにしたJphone絵文字データ配列を返します。
     * ※入力される絵文字データに関して、SoftbankとJ-PHONEで異なるため
     *   別メソッドとなります。
     *   出力に関しては、Jphone用のコードで下位互換となっているので
     *   Softbank、J-PHONEの区分けはありません。
     * メール送信用
     *
     * @return $jphoneEmoji Jphone絵文字配列
     */

    public static function getJphoneEmojiMail() {
        static $jphoneEmoji;

        if (!isset($jphoneEmoji)) {
            $jphoneEmoji["%s1%"] = pack("C*", 0xf9,0x41);
            $jphoneEmoji["%s2%"] = pack("C*", 0xf9,0x7c);
            $jphoneEmoji["%s3%"] = pack("C*", 0xf9,0x43);
            $jphoneEmoji["%s4%"] = pack("C*", 0xf9,0x44);
            $jphoneEmoji["%s5%"] = pack("C*", 0xf9,0x45);;
            $jphoneEmoji["%s6%"] = pack("C*", 0xf9,0x46);
            $jphoneEmoji["%s7%"] = pack("C*", 0xf9,0x47);
            $jphoneEmoji["%s8%"] = pack("C*", 0xf9,0x48);
            $jphoneEmoji["%s9%"] = pack("C*", 0xf9,0x49);
            $jphoneEmoji["%s10%"] = pack("C*", 0xf9,0x4a);
            $jphoneEmoji["%s11%"] = pack("C*", 0xf9,0x4b);
            $jphoneEmoji["%s12%"] = pack("C*", 0xf9,0x4c);
            $jphoneEmoji["%s13%"] = pack("C*", 0xf9,0x4d);
            $jphoneEmoji["%s14%"] = pack("C*", 0xf9,0x4e);
            $jphoneEmoji["%s15%"] = pack("C*", 0xf9,0x4f);
            $jphoneEmoji["%s16%"] = pack("C*", 0xf9,0x50);
            $jphoneEmoji["%s17%"] = pack("C*", 0xf9,0x51);
            $jphoneEmoji["%s18%"] = pack("C*", 0xf9,0x52);
            $jphoneEmoji["%s19%"] = pack("C*", 0xf9,0x53);
            $jphoneEmoji["%s20%"] = pack("C*", 0xf9,0x54);
            $jphoneEmoji["%s21%"] = pack("C*", 0xf9,0x55);
            $jphoneEmoji["%s22%"] = pack("C*", 0xf9,0x56);
            $jphoneEmoji["%s23%"] = pack("C*", 0xf9,0x57);
            $jphoneEmoji["%s24%"] = pack("C*", 0xf9,0x58);
            $jphoneEmoji["%s25%"] = pack("C*", 0xf9,0x59);
            $jphoneEmoji["%s26%"] = pack("C*", 0xf9,0x5a);
            $jphoneEmoji["%s27%"] = pack("C*", 0xf9,0x5b);
            $jphoneEmoji["%s28%"] = pack("C*", 0xf9,0x5c);
            $jphoneEmoji["%s29%"] = pack("C*", 0xf9,0x5d);
            $jphoneEmoji["%s30%"] = pack("C*", 0xf9,0x5e);
            $jphoneEmoji["%s31%"] = pack("C*", 0xf9,0x5f);
            $jphoneEmoji["%s32%"] = pack("C*", 0xf9,0x60);
            $jphoneEmoji["%s33%"] = pack("C*", 0xf9,0x61);
            $jphoneEmoji["%s34%"] = pack("C*", 0xf9,0x62);
            $jphoneEmoji["%s35%"] = pack("C*", 0xf9,0x63);
            $jphoneEmoji["%s36%"] = pack("C*", 0xf9,0x64);
            $jphoneEmoji["%s37%"] = pack("C*", 0xf9,0x65);
            $jphoneEmoji["%s38%"] = pack("C*", 0xf9,0x66);
            $jphoneEmoji["%s39%"] = pack("C*", 0xf9,0x67);
            $jphoneEmoji["%s40%"] = pack("C*", 0xf9,0x68);
            $jphoneEmoji["%s41%"] = pack("C*", 0xf9,0x69);
            $jphoneEmoji["%s42%"] = pack("C*", 0xf9,0x6a);
            $jphoneEmoji["%s43%"] = pack("C*", 0xf9,0x6b);
            $jphoneEmoji["%s44%"] = pack("C*", 0xf9,0x6c);
            $jphoneEmoji["%s45%"] = pack("C*", 0xf9,0x6d);
            $jphoneEmoji["%s46%"] = pack("C*", 0xf9,0x6e);
            $jphoneEmoji["%s47%"] = pack("C*", 0xf9,0x6f);
            $jphoneEmoji["%s48%"] = pack("C*", 0xf9,0x70);
            $jphoneEmoji["%s49%"] = pack("C*", 0xf9,0x71);
            $jphoneEmoji["%s50%"] = pack("C*", 0xf9,0x72);
            $jphoneEmoji["%s51%"] = pack("C*", 0xf9,0x73);
            $jphoneEmoji["%s52%"] = pack("C*", 0xf9,0x74);
            $jphoneEmoji["%s53%"] = pack("C*", 0xf9,0x75);
            $jphoneEmoji["%s54%"] = pack("C*", 0xf9,0x76);
            $jphoneEmoji["%s55%"] = pack("C*", 0xf9,0x77);
            $jphoneEmoji["%s56%"] = pack("C*", 0xf9,0x78);
            $jphoneEmoji["%s57%"] = pack("C*", 0xf9,0x79);
            $jphoneEmoji["%s58%"] = pack("C*", 0xf9,0x7a);
            $jphoneEmoji["%s59%"] = pack("C*", 0xf9,0x7b);
            $jphoneEmoji["%s60%"] = pack("C*", 0xf9,0x7c);
            $jphoneEmoji["%s61%"] = pack("C*", 0xf9,0x7d);
            $jphoneEmoji["%s62%"] = pack("C*", 0xf9,0x7e);
            $jphoneEmoji["%s63%"] = pack("C*", 0xf9,0x80);
            $jphoneEmoji["%s64%"] = pack("C*", 0xf9,0x81);
            $jphoneEmoji["%s65%"] = pack("C*", 0xf9,0x82);
            $jphoneEmoji["%s66%"] = pack("C*", 0xf9,0x83);
            $jphoneEmoji["%s67%"] = pack("C*", 0xf9,0x84);
            $jphoneEmoji["%s68%"] = pack("C*", 0xf9,0x85);
            $jphoneEmoji["%s69%"] = pack("C*", 0xf9,0x86);
            $jphoneEmoji["%s70%"] = pack("C*", 0xf9,0x87);
            $jphoneEmoji["%s71%"] = pack("C*", 0xf9,0x88);
            $jphoneEmoji["%s72%"] = pack("C*", 0xf9,0x89);
            $jphoneEmoji["%s73%"] = pack("C*", 0xf9,0x8a);
            $jphoneEmoji["%s74%"] = pack("C*", 0xf9,0x8b);
            $jphoneEmoji["%s75%"] = pack("C*", 0xf9,0x8c);
            $jphoneEmoji["%s76%"] = pack("C*", 0xf9,0x8d);
            $jphoneEmoji["%s77%"] = pack("C*", 0xf9,0x8e);
            $jphoneEmoji["%s78%"] = pack("C*", 0xf9,0x8f);
            $jphoneEmoji["%s79%"] = pack("C*", 0xf9,0x90);
            $jphoneEmoji["%s80%"] = pack("C*", 0xf9,0x91);
            $jphoneEmoji["%s81%"] = pack("C*", 0xf9,0x92);
            $jphoneEmoji["%s82%"] = pack("C*", 0xf9,0x93);
            $jphoneEmoji["%s83%"] = pack("C*", 0xf9,0x94);
            $jphoneEmoji["%s84%"] = pack("C*", 0xf9,0x95);
            $jphoneEmoji["%s85%"] = pack("C*", 0xf9,0x96);
            $jphoneEmoji["%s86%"] = pack("C*", 0xf9,0x97);
            $jphoneEmoji["%s87%"] = pack("C*", 0xf9,0x98);
            $jphoneEmoji["%s88%"] = pack("C*", 0xf9,0x99);
            $jphoneEmoji["%s89%"] = pack("C*", 0xf9,0x9a);
            $jphoneEmoji["%s90%"] = pack("C*", 0xf9,0x9b);
            $jphoneEmoji["%s101%"] = pack("C*", 0xf7,0x41);
            $jphoneEmoji["%s102%"] = pack("C*", 0xf7,0x42);
            $jphoneEmoji["%s103%"] = pack("C*", 0xf7,0x43);
            $jphoneEmoji["%s104%"] = pack("C*", 0xf7,0x44);
            $jphoneEmoji["%s105%"] = pack("C*", 0xf7,0x45);
            $jphoneEmoji["%s106%"] = pack("C*", 0xf7,0x46);
            $jphoneEmoji["%s107%"] = pack("C*", 0xf7,0x47);
            $jphoneEmoji["%s108%"] = pack("C*", 0xf7,0x48);
            $jphoneEmoji["%s109%"] = pack("C*", 0xf7,0x49);
            $jphoneEmoji["%s110%"] = pack("C*", 0xf7,0x4a);
            $jphoneEmoji["%s111%"] = pack("C*", 0xf7,0x4b);
            $jphoneEmoji["%s112%"] = pack("C*", 0xf7,0x4c);
            $jphoneEmoji["%s113%"] = pack("C*", 0xf7,0x4d);
            $jphoneEmoji["%s114%"] = pack("C*", 0xf7,0x4e);
            $jphoneEmoji["%s115%"] = pack("C*", 0xf7,0x4f);
            $jphoneEmoji["%s116%"] = pack("C*", 0xf7,0x50);
            $jphoneEmoji["%s117%"] = pack("C*", 0xf7,0x51);
            $jphoneEmoji["%s118%"] = pack("C*", 0xf7,0x52);
            $jphoneEmoji["%s119%"] = pack("C*", 0xf7,0x53);
            $jphoneEmoji["%s120%"] = pack("C*", 0xf7,0x54);
            $jphoneEmoji["%s121%"] = pack("C*", 0xf7,0x55);
            $jphoneEmoji["%s122%"] = pack("C*", 0xf7,0x56);
            $jphoneEmoji["%s123%"] = pack("C*", 0xf7,0x57);
            $jphoneEmoji["%s124%"] = pack("C*", 0xf7,0x58);
            $jphoneEmoji["%s125%"] = pack("C*", 0xf7,0x59);
            $jphoneEmoji["%s126%"] = pack("C*", 0xf7,0x5a);
            $jphoneEmoji["%s127%"] = pack("C*", 0xf7,0x5b);
            $jphoneEmoji["%s128%"] = pack("C*", 0xf7,0x5c);
            $jphoneEmoji["%s129%"] = pack("C*", 0xf7,0x5d);
            $jphoneEmoji["%s130%"] = pack("C*", 0xf7,0x5e);
            $jphoneEmoji["%s131%"] = pack("C*", 0xf7,0x5f);
            $jphoneEmoji["%s132%"] = pack("C*", 0xf7,0x60);
            $jphoneEmoji["%s133%"] = pack("C*", 0xf7,0x61);
            $jphoneEmoji["%s134%"] = pack("C*", 0xf7,0x62);
            $jphoneEmoji["%s135%"] = pack("C*", 0xf7,0x63);
            $jphoneEmoji["%s136%"] = pack("C*", 0xf7,0x64);
            $jphoneEmoji["%s137%"] = pack("C*", 0xf7,0x65);
            $jphoneEmoji["%s138%"] = pack("C*", 0xf7,0x66);
            $jphoneEmoji["%s139%"] = pack("C*", 0xf7,0x67);
            $jphoneEmoji["%s140%"] = pack("C*", 0xf7,0x68);
            $jphoneEmoji["%s141%"] = pack("C*", 0xf7,0x69);
            $jphoneEmoji["%s142%"] = pack("C*", 0xf7,0x6a);
            $jphoneEmoji["%s143%"] = pack("C*", 0xf7,0x6b);
            $jphoneEmoji["%s144%"] = pack("C*", 0xf7,0x6c);
            $jphoneEmoji["%s145%"] = pack("C*", 0xf7,0x6d);
            $jphoneEmoji["%s146%"] = pack("C*", 0xf7,0x6e);
            $jphoneEmoji["%s147%"] = pack("C*", 0xf7,0x6f);
            $jphoneEmoji["%s148%"] = pack("C*", 0xf7,0x70);
            $jphoneEmoji["%s149%"] = pack("C*", 0xf7,0x71);
            $jphoneEmoji["%s150%"] = pack("C*", 0xf7,0x72);
            $jphoneEmoji["%s151%"] = pack("C*", 0xf7,0x73);
            $jphoneEmoji["%s152%"] = pack("C*", 0xf7,0x74);
            $jphoneEmoji["%s153%"] = pack("C*", 0xf7,0x75);
            $jphoneEmoji["%s154%"] = pack("C*", 0xf7,0x76);
            $jphoneEmoji["%s155%"] = pack("C*", 0xf7,0x77);
            $jphoneEmoji["%s156%"] = pack("C*", 0xf7,0x78);
            $jphoneEmoji["%s157%"] = pack("C*", 0xf7,0x79);
            $jphoneEmoji["%s158%"] = pack("C*", 0xf7,0x7a);
            $jphoneEmoji["%s159%"] = pack("C*", 0xf7,0x7b);
            $jphoneEmoji["%s160%"] = pack("C*", 0xf7,0x7c);
            $jphoneEmoji["%s161%"] = pack("C*", 0xf7,0x7d);
            $jphoneEmoji["%s162%"] = pack("C*", 0xf7,0x7e);
            $jphoneEmoji["%s163%"] = pack("C*", 0xf7,0x80);
            $jphoneEmoji["%s164%"] = pack("C*", 0xf7,0x81);
            $jphoneEmoji["%s165%"] = pack("C*", 0xf7,0x82);
            $jphoneEmoji["%s166%"] = pack("C*", 0xf7,0x83);
            $jphoneEmoji["%s167%"] = pack("C*", 0xf7,0x84);
            $jphoneEmoji["%s168%"] = pack("C*", 0xf7,0x85);
            $jphoneEmoji["%s169%"] = pack("C*", 0xf7,0x86);
            $jphoneEmoji["%s170%"] = pack("C*", 0xf7,0x87);
            $jphoneEmoji["%s171%"] = pack("C*", 0xf7,0x88);
            $jphoneEmoji["%s172%"] = pack("C*", 0xf7,0x89);
            $jphoneEmoji["%s173%"] = pack("C*", 0xf7,0x8a);
            $jphoneEmoji["%s174%"] = pack("C*", 0xf7,0x8b);
            $jphoneEmoji["%s175%"] = pack("C*", 0xf7,0x8c);
            $jphoneEmoji["%s176%"] = pack("C*", 0xf7,0x8d);
            $jphoneEmoji["%s177%"] = pack("C*", 0xf7,0x8e);
            $jphoneEmoji["%s178%"] = pack("C*", 0xf7,0x8f);
            $jphoneEmoji["%s179%"] = pack("C*", 0xf7,0x90);
            $jphoneEmoji["%s180%"] = pack("C*", 0xf7,0x91);
            $jphoneEmoji["%s181%"] = pack("C*", 0xf7,0x92);
            $jphoneEmoji["%s182%"] = pack("C*", 0xf7,0x93);
            $jphoneEmoji["%s183%"] = pack("C*", 0xf7,0x94);
            $jphoneEmoji["%s184%"] = pack("C*", 0xf7,0x95);
            $jphoneEmoji["%s185%"] = pack("C*", 0xf7,0x96);
            $jphoneEmoji["%s186%"] = pack("C*", 0xf7,0x97);
            $jphoneEmoji["%s187%"] = pack("C*", 0xf7,0x98);
            $jphoneEmoji["%s188%"] = pack("C*", 0xf7,0x99);
            $jphoneEmoji["%s189%"] = pack("C*", 0xf7,0x9a);
            $jphoneEmoji["%s190%"] = pack("C*", 0xf7,0x9b);
            $jphoneEmoji["%s201%"] = pack("C*", 0xf7,0xa1);
            $jphoneEmoji["%s202%"] = pack("C*", 0xf7,0xa2);
            $jphoneEmoji["%s203%"] = pack("C*", 0xf7,0xa3);
            $jphoneEmoji["%s204%"] = pack("C*", 0xf7,0xa4);
            $jphoneEmoji["%s205%"] = pack("C*", 0xf7,0xa5);
            $jphoneEmoji["%s206%"] = pack("C*", 0xf7,0xa6);
            $jphoneEmoji["%s207%"] = pack("C*", 0xf7,0xa7);
            $jphoneEmoji["%s208%"] = pack("C*", 0xf7,0xa8);
            $jphoneEmoji["%s209%"] = pack("C*", 0xf7,0xa9);
            $jphoneEmoji["%s210%"] = pack("C*", 0xf7,0xaa);
            $jphoneEmoji["%s211%"] = pack("C*", 0xf7,0xab);
            $jphoneEmoji["%s212%"] = pack("C*", 0xf7,0xac);
            $jphoneEmoji["%s213%"] = pack("C*", 0xf7,0xad);
            $jphoneEmoji["%s214%"] = pack("C*", 0xf7,0xae);
            $jphoneEmoji["%s215%"] = pack("C*", 0xf7,0xaf);
            $jphoneEmoji["%s216%"] = pack("C*", 0xf7,0xb0);
            $jphoneEmoji["%s217%"] = pack("C*", 0xf7,0xb1);
            $jphoneEmoji["%s218%"] = pack("C*", 0xf7,0xb2);
            $jphoneEmoji["%s219%"] = pack("C*", 0xf7,0xb3);
            $jphoneEmoji["%s220%"] = pack("C*", 0xf7,0xb4);
            $jphoneEmoji["%s221%"] = pack("C*", 0xf7,0xb5);
            $jphoneEmoji["%s222%"] = pack("C*", 0xf7,0xb6);
            $jphoneEmoji["%s223%"] = pack("C*", 0xf7,0xb7);
            $jphoneEmoji["%s224%"] = pack("C*", 0xf7,0xb8);
            $jphoneEmoji["%s225%"] = pack("C*", 0xf7,0xb9);
            $jphoneEmoji["%s226%"] = pack("C*", 0xf7,0xba);
            $jphoneEmoji["%s227%"] = pack("C*", 0xf7,0xbb);
            $jphoneEmoji["%s228%"] = pack("C*", 0xf7,0xbc);
            $jphoneEmoji["%s229%"] = pack("C*", 0xf7,0xbd);
            $jphoneEmoji["%s230%"] = pack("C*", 0xf7,0xbe);
            $jphoneEmoji["%s231%"] = pack("C*", 0xf7,0xbf);
            $jphoneEmoji["%s232%"] = pack("C*", 0xf7,0xc0);
            $jphoneEmoji["%s233%"] = pack("C*", 0xf7,0xc1);
            $jphoneEmoji["%s234%"] = pack("C*", 0xf7,0xc2);
            $jphoneEmoji["%s235%"] = pack("C*", 0xf7,0xc3);
            $jphoneEmoji["%s236%"] = pack("C*", 0xf7,0xc4);
            $jphoneEmoji["%s237%"] = pack("C*", 0xf7,0xc5);
            $jphoneEmoji["%s238%"] = pack("C*", 0xf7,0xc6);
            $jphoneEmoji["%s239%"] = pack("C*", 0xf7,0xc7);
            $jphoneEmoji["%s240%"] = pack("C*", 0xf7,0xc8);
            $jphoneEmoji["%s241%"] = pack("C*", 0xf7,0xc9);
            $jphoneEmoji["%s242%"] = pack("C*", 0xf7,0xca);
            $jphoneEmoji["%s243%"] = pack("C*", 0xf7,0xcb);
            $jphoneEmoji["%s244%"] = pack("C*", 0xf7,0xcc);
            $jphoneEmoji["%s245%"] = pack("C*", 0xf7,0xcd);
            $jphoneEmoji["%s246%"] = pack("C*", 0xf7,0xce);
            $jphoneEmoji["%s247%"] = pack("C*", 0xf7,0xcf);
            $jphoneEmoji["%s248%"] = pack("C*", 0xf7,0xd0);
            $jphoneEmoji["%s249%"] = pack("C*", 0xf7,0xd1);
            $jphoneEmoji["%s250%"] = pack("C*", 0xf7,0xd2);
            $jphoneEmoji["%s251%"] = pack("C*", 0xf7,0xd3);
            $jphoneEmoji["%s252%"] = pack("C*", 0xf7,0xd4);
            $jphoneEmoji["%s253%"] = pack("C*", 0xf7,0xd5);
            $jphoneEmoji["%s254%"] = pack("C*", 0xf7,0xd6);
            $jphoneEmoji["%s255%"] = pack("C*", 0xf7,0xd7);
            $jphoneEmoji["%s256%"] = pack("C*", 0xf7,0xd8);
            $jphoneEmoji["%s257%"] = pack("C*", 0xf7,0xd9);
            $jphoneEmoji["%s258%"] = pack("C*", 0xf7,0xda);
            $jphoneEmoji["%s259%"] = pack("C*", 0xf7,0xdb);
            $jphoneEmoji["%s260%"] = pack("C*", 0xf7,0xdc);
            $jphoneEmoji["%s261%"] = pack("C*", 0xf7,0xdd);
            $jphoneEmoji["%s262%"] = pack("C*", 0xf7,0xde);
            $jphoneEmoji["%s263%"] = pack("C*", 0xf7,0xdf);
            $jphoneEmoji["%s264%"] = pack("C*", 0xf7,0xe0);
            $jphoneEmoji["%s265%"] = pack("C*", 0xf7,0xe1);
            $jphoneEmoji["%s266%"] = pack("C*", 0xf7,0xe2);
            $jphoneEmoji["%s267%"] = pack("C*", 0xf7,0xe3);
            $jphoneEmoji["%s268%"] = pack("C*", 0xf7,0xe4);
            $jphoneEmoji["%s269%"] = pack("C*", 0xf7,0xe5);
            $jphoneEmoji["%s270%"] = pack("C*", 0xf7,0xe6);
            $jphoneEmoji["%s271%"] = pack("C*", 0xf7,0xe7);
            $jphoneEmoji["%s272%"] = pack("C*", 0xf7,0xe8);
            $jphoneEmoji["%s273%"] = pack("C*", 0xf7,0xe9);
            $jphoneEmoji["%s274%"] = pack("C*", 0xf7,0xea);
            $jphoneEmoji["%s275%"] = pack("C*", 0xf7,0xeb);
            $jphoneEmoji["%s276%"] = pack("C*", 0xf7,0xec);
            $jphoneEmoji["%s277%"] = pack("C*", 0xf7,0xed);
            $jphoneEmoji["%s278%"] = pack("C*", 0xf7,0xee);
            $jphoneEmoji["%s279%"] = pack("C*", 0xf7,0xef);
            $jphoneEmoji["%s280%"] = pack("C*", 0xf7,0xf0);
            $jphoneEmoji["%s281%"] = pack("C*", 0xf7,0xf1);
            $jphoneEmoji["%s282%"] = pack("C*", 0xf7,0xf2);
            $jphoneEmoji["%s283%"] = pack("C*", 0xf7,0xf3);
            $jphoneEmoji["%s285%"] = pack("C*", 0xf7,0xf5);
            $jphoneEmoji["%s286%"] = pack("C*", 0xf7,0xf6);
            $jphoneEmoji["%s287%"] = pack("C*", 0xf7,0xf7);
            $jphoneEmoji["%s301%"] = pack("C*", 0xf9,0xa1);
            $jphoneEmoji["%s302%"] = pack("C*", 0xf9,0xa2);
            $jphoneEmoji["%s303%"] = pack("C*", 0xf9,0xa3);
            $jphoneEmoji["%s304%"] = pack("C*", 0xf9,0xa4);
            $jphoneEmoji["%s305%"] = pack("C*", 0xf9,0xa5);
            $jphoneEmoji["%s306%"] = pack("C*", 0xf9,0xa6);
            $jphoneEmoji["%s307%"] = pack("C*", 0xf9,0xa7);
            $jphoneEmoji["%s308%"] = pack("C*", 0xf9,0xa8);
            $jphoneEmoji["%s309%"] = pack("C*", 0xf9,0xa9);
            $jphoneEmoji["%s310%"] = pack("C*", 0xf9,0xaa);
            $jphoneEmoji["%s311%"] = pack("C*", 0xf9,0xab);
            $jphoneEmoji["%s312%"] = pack("C*", 0xf9,0xac);
            $jphoneEmoji["%s313%"] = pack("C*", 0xf9,0xad);
            $jphoneEmoji["%s314%"] = pack("C*", 0xf9,0xae);
            $jphoneEmoji["%s315%"] = pack("C*", 0xf9,0xaf);
            $jphoneEmoji["%s316%"] = pack("C*", 0xf9,0xb0);
            $jphoneEmoji["%s317%"] = pack("C*", 0xf9,0xb1);
            $jphoneEmoji["%s318%"] = pack("C*", 0xf9,0xb2);
            $jphoneEmoji["%s319%"] = pack("C*", 0xf9,0xb3);
            $jphoneEmoji["%s320%"] = pack("C*", 0xf9,0xb4);
            $jphoneEmoji["%s321%"] = pack("C*", 0xf9,0xb5);
            $jphoneEmoji["%s322%"] = pack("C*", 0xf9,0xb6);
            $jphoneEmoji["%s323%"] = pack("C*", 0xf9,0xb7);
            $jphoneEmoji["%s324%"] = pack("C*", 0xf9,0xb8);
            $jphoneEmoji["%s325%"] = pack("C*", 0xf9,0xb9);
            $jphoneEmoji["%s326%"] = pack("C*", 0xf9,0xba);
            $jphoneEmoji["%s327%"] = pack("C*", 0xf9,0xbb);
            $jphoneEmoji["%s328%"] = pack("C*", 0xf9,0xbc);
            $jphoneEmoji["%s329%"] = pack("C*", 0xf9,0xbd);
            $jphoneEmoji["%s330%"] = pack("C*", 0xf9,0xbe);
            $jphoneEmoji["%s331%"] = pack("C*", 0xf9,0xbf);
            $jphoneEmoji["%s332%"] = pack("C*", 0xf9,0xc0);
            $jphoneEmoji["%s333%"] = pack("C*", 0xf9,0xc1);
            $jphoneEmoji["%s334%"] = pack("C*", 0xf9,0xc2);
            $jphoneEmoji["%s335%"] = pack("C*", 0xf9,0xc3);
            $jphoneEmoji["%s336%"] = pack("C*", 0xf9,0xc4);
            $jphoneEmoji["%s337%"] = pack("C*", 0xf9,0xc5);
            $jphoneEmoji["%s338%"] = pack("C*", 0xf9,0xc6);
            $jphoneEmoji["%s339%"] = pack("C*", 0xf9,0xc7);
            $jphoneEmoji["%s340%"] = pack("C*", 0xf9,0xc8);
            $jphoneEmoji["%s341%"] = pack("C*", 0xf9,0xc9);
            $jphoneEmoji["%s342%"] = pack("C*", 0xf9,0xca);
            $jphoneEmoji["%s343%"] = pack("C*", 0xf9,0xcb);
            $jphoneEmoji["%s344%"] = pack("C*", 0xf9,0xcc);
            $jphoneEmoji["%s345%"] = pack("C*", 0xf9,0xcd);
            $jphoneEmoji["%s346%"] = pack("C*", 0xf9,0xce);
            $jphoneEmoji["%s347%"] = pack("C*", 0xf9,0xcf);
            $jphoneEmoji["%s348%"] = pack("C*", 0xf9,0xd0);
            $jphoneEmoji["%s349%"] = pack("C*", 0xf9,0xd1);
            $jphoneEmoji["%s350%"] = pack("C*", 0xf9,0xd2);
            $jphoneEmoji["%s351%"] = pack("C*", 0xf9,0xd3);
            $jphoneEmoji["%s352%"] = pack("C*", 0xf9,0xd4);
            $jphoneEmoji["%s353%"] = pack("C*", 0xf9,0xd5);
            $jphoneEmoji["%s354%"] = pack("C*", 0xf9,0xd6);
            $jphoneEmoji["%s355%"] = pack("C*", 0xf9,0xd7);
            $jphoneEmoji["%s356%"] = pack("C*", 0xf9,0xd8);
            $jphoneEmoji["%s357%"] = pack("C*", 0xf9,0xd9);
            $jphoneEmoji["%s358%"] = pack("C*", 0xf9,0xda);
            $jphoneEmoji["%s359%"] = pack("C*", 0xf9,0xdb);
            $jphoneEmoji["%s360%"] = pack("C*", 0xf9,0xdc);
            $jphoneEmoji["%s361%"] = pack("C*", 0xf9,0xdd);
            $jphoneEmoji["%s362%"] = pack("C*", 0xf9,0xde);
            $jphoneEmoji["%s363%"] = pack("C*", 0xf9,0xdf);
            $jphoneEmoji["%s364%"] = pack("C*", 0xf9,0xe0);
            $jphoneEmoji["%s365%"] = pack("C*", 0xf9,0xe1);
            $jphoneEmoji["%s366%"] = pack("C*", 0xf9,0xe2);
            $jphoneEmoji["%s367%"] = pack("C*", 0xf9,0xe3);
            $jphoneEmoji["%s368%"] = pack("C*", 0xf9,0xe4);
            $jphoneEmoji["%s369%"] = pack("C*", 0xf9,0xe5);
            $jphoneEmoji["%s370%"] = pack("C*", 0xf9,0xe6);
            $jphoneEmoji["%s371%"] = pack("C*", 0xf9,0xe7);
            $jphoneEmoji["%s372%"] = pack("C*", 0xf9,0xe8);
            $jphoneEmoji["%s373%"] = pack("C*", 0xf9,0xe9);
            $jphoneEmoji["%s374%"] = pack("C*", 0xf9,0xea);
            $jphoneEmoji["%s375%"] = pack("C*", 0xf9,0xeb);
            $jphoneEmoji["%s376%"] = pack("C*", 0xf9,0xec);
            $jphoneEmoji["%s377%"] = pack("C*", 0xf9,0xed);
            $jphoneEmoji["%s401%"] = pack("C*", 0xfb,0x41);
            $jphoneEmoji["%s402%"] = pack("C*", 0xfb,0x42);
            $jphoneEmoji["%s403%"] = pack("C*", 0xfb,0x43);
            $jphoneEmoji["%s404%"] = pack("C*", 0xfb,0x44);
            $jphoneEmoji["%s405%"] = pack("C*", 0xfb,0x45);
            $jphoneEmoji["%s406%"] = pack("C*", 0xfb,0x46);
            $jphoneEmoji["%s407%"] = pack("C*", 0xfb,0x47);
            $jphoneEmoji["%s408%"] = pack("C*", 0xfb,0x48);
            $jphoneEmoji["%s409%"] = pack("C*", 0xfb,0x49);
            $jphoneEmoji["%s410%"] = pack("C*", 0xfb,0x4a);
            $jphoneEmoji["%s411%"] = pack("C*", 0xfb,0x4b);
            $jphoneEmoji["%s412%"] = pack("C*", 0xfb,0x4c);
            $jphoneEmoji["%s413%"] = pack("C*", 0xfb,0x4d);
            $jphoneEmoji["%s414%"] = pack("C*", 0xfb,0x4e);
            $jphoneEmoji["%s415%"] = pack("C*", 0xfb,0x4f);
            $jphoneEmoji["%s416%"] = pack("C*", 0xfb,0x50);
            $jphoneEmoji["%s417%"] = pack("C*", 0xfb,0x51);
            $jphoneEmoji["%s418%"] = pack("C*", 0xfb,0x52);
            $jphoneEmoji["%s419%"] = pack("C*", 0xfb,0x53);
            $jphoneEmoji["%s420%"] = pack("C*", 0xfb,0x54);
            $jphoneEmoji["%s421%"] = pack("C*", 0xfb,0x55);
            $jphoneEmoji["%s422%"] = pack("C*", 0xfb,0x56);
            $jphoneEmoji["%s423%"] = pack("C*", 0xfb,0x57);
            $jphoneEmoji["%s424%"] = pack("C*", 0xfb,0x58);
            $jphoneEmoji["%s425%"] = pack("C*", 0xfb,0x59);
            $jphoneEmoji["%s426%"] = pack("C*", 0xfb,0x5a);
            $jphoneEmoji["%s427%"] = pack("C*", 0xfb,0x5b);
            $jphoneEmoji["%s428%"] = pack("C*", 0xfb,0x5c);
            $jphoneEmoji["%s429%"] = pack("C*", 0xfb,0x5d);
            $jphoneEmoji["%s430%"] = pack("C*", 0xfb,0x5e);
            $jphoneEmoji["%s431%"] = pack("C*", 0xfb,0x5f);
            $jphoneEmoji["%s432%"] = pack("C*", 0xfb,0x60);
            $jphoneEmoji["%s433%"] = pack("C*", 0xfb,0x61);
            $jphoneEmoji["%s434%"] = pack("C*", 0xfb,0x62);
            $jphoneEmoji["%s435%"] = pack("C*", 0xfb,0x63);
            $jphoneEmoji["%s436%"] = pack("C*", 0xfb,0x64);
            $jphoneEmoji["%s437%"] = pack("C*", 0xfb,0x65);
            $jphoneEmoji["%s438%"] = pack("C*", 0xfb,0x66);
            $jphoneEmoji["%s439%"] = pack("C*", 0xfb,0x67);
            $jphoneEmoji["%s440%"] = pack("C*", 0xfb,0x68);
            $jphoneEmoji["%s441%"] = pack("C*", 0xfb,0x69);
            $jphoneEmoji["%s442%"] = pack("C*", 0xfb,0x6a);
            $jphoneEmoji["%s443%"] = pack("C*", 0xfb,0x6b);
            $jphoneEmoji["%s444%"] = pack("C*", 0xfb,0x6c);
            $jphoneEmoji["%s445%"] = pack("C*", 0xfb,0x6d);
            $jphoneEmoji["%s446%"] = pack("C*", 0xfb,0x6e);
            $jphoneEmoji["%s447%"] = pack("C*", 0xfb,0x6f);
            $jphoneEmoji["%s448%"] = pack("C*", 0xfb,0x70);
            $jphoneEmoji["%s449%"] = pack("C*", 0xfb,0x71);
            $jphoneEmoji["%s450%"] = pack("C*", 0xfb,0x72);
            $jphoneEmoji["%s451%"] = pack("C*", 0xfb,0x73);
            $jphoneEmoji["%s452%"] = pack("C*", 0xfb,0x74);
            $jphoneEmoji["%s453%"] = pack("C*", 0xfb,0x75);
            $jphoneEmoji["%s454%"] = pack("C*", 0xfb,0x76);
            $jphoneEmoji["%s455%"] = pack("C*", 0xfb,0x77);
            $jphoneEmoji["%s456%"] = pack("C*", 0xfb,0x78);
            $jphoneEmoji["%s457%"] = pack("C*", 0xfb,0x79);
            $jphoneEmoji["%s458%"] = pack("C*", 0xfb,0x7a);
            $jphoneEmoji["%s459%"] = pack("C*", 0xfb,0x7b);
            $jphoneEmoji["%s460%"] = pack("C*", 0xfb,0x7c);
            $jphoneEmoji["%s461%"] = pack("C*", 0xfb,0x7d);
            $jphoneEmoji["%s462%"] = pack("C*", 0xfb,0x7e);
            $jphoneEmoji["%s463%"] = pack("C*", 0xfb,0x80);
            $jphoneEmoji["%s464%"] = pack("C*", 0xfb,0x81);
            $jphoneEmoji["%s465%"] = pack("C*", 0xfb,0x82);
            $jphoneEmoji["%s466%"] = pack("C*", 0xfb,0x83);
            $jphoneEmoji["%s467%"] = pack("C*", 0xfb,0x84);
            $jphoneEmoji["%s468%"] = pack("C*", 0xfb,0x85);
            $jphoneEmoji["%s469%"] = pack("C*", 0xfb,0x86);
            $jphoneEmoji["%s470%"] = pack("C*", 0xfb,0x87);
            $jphoneEmoji["%s471%"] = pack("C*", 0xfb,0x88);
            $jphoneEmoji["%s472%"] = pack("C*", 0xfb,0x89);
            $jphoneEmoji["%s473%"] = pack("C*", 0xfb,0x8a);
            $jphoneEmoji["%s474%"] = pack("C*", 0xfb,0x8b);
            $jphoneEmoji["%s475%"] = pack("C*", 0xfb,0x8c);
            $jphoneEmoji["%s476%"] = pack("C*", 0xfb,0x8d);
            $jphoneEmoji["%s501%"] = pack("C*", 0xfb,0xa1);
            $jphoneEmoji["%s502%"] = pack("C*", 0xfb,0xa2);
            $jphoneEmoji["%s503%"] = pack("C*", 0xfb,0xa3);
            $jphoneEmoji["%s504%"] = pack("C*", 0xfb,0xa4);
            $jphoneEmoji["%s505%"] = pack("C*", 0xfb,0xa5);
            $jphoneEmoji["%s506%"] = pack("C*", 0xfb,0xa6);
            $jphoneEmoji["%s507%"] = pack("C*", 0xfb,0xa7);
            $jphoneEmoji["%s508%"] = pack("C*", 0xfb,0xa8);
            $jphoneEmoji["%s509%"] = pack("C*", 0xfb,0xa9);
            $jphoneEmoji["%s510%"] = pack("C*", 0xfb,0xaa);
            $jphoneEmoji["%s511%"] = pack("C*", 0xfb,0xab);
            $jphoneEmoji["%s512%"] = pack("C*", 0xfb,0xac);
            $jphoneEmoji["%s513%"] = pack("C*", 0xfb,0xad);
            $jphoneEmoji["%s514%"] = pack("C*", 0xfb,0xae);
            $jphoneEmoji["%s515%"] = pack("C*", 0xfb,0xaf);
            $jphoneEmoji["%s516%"] = pack("C*", 0xfb,0xb0);
            $jphoneEmoji["%s517%"] = pack("C*", 0xfb,0xb1);
            $jphoneEmoji["%s518%"] = pack("C*", 0xfb,0xb2);
            $jphoneEmoji["%s519%"] = pack("C*", 0xfb,0xb3);
            $jphoneEmoji["%s520%"] = pack("C*", 0xfb,0xb4);
            $jphoneEmoji["%s521%"] = pack("C*", 0xfb,0xb5);
            $jphoneEmoji["%s522%"] = pack("C*", 0xfb,0xb6);
            $jphoneEmoji["%s523%"] = pack("C*", 0xfb,0xb7);
            $jphoneEmoji["%s524%"] = pack("C*", 0xfb,0xb8);
            $jphoneEmoji["%s525%"] = pack("C*", 0xfb,0xb9);
            $jphoneEmoji["%s526%"] = pack("C*", 0xfb,0xba);
            $jphoneEmoji["%s527%"] = pack("C*", 0xfb,0xbb);
            $jphoneEmoji["%s528%"] = pack("C*", 0xfb,0xbc);
            $jphoneEmoji["%s529%"] = pack("C*", 0xfb,0xbd);
            $jphoneEmoji["%s530%"] = pack("C*", 0xfb,0xbe);
            $jphoneEmoji["%s531%"] = pack("C*", 0xfb,0xbf);
            $jphoneEmoji["%s532%"] = pack("C*", 0xfb,0xc0);
            $jphoneEmoji["%s533%"] = pack("C*", 0xfb,0xc1);
            $jphoneEmoji["%s534%"] = pack("C*", 0xfb,0xc2);
            $jphoneEmoji["%s535%"] = pack("C*", 0xfb,0xc3);
            $jphoneEmoji["%s536%"] = pack("C*", 0xfb,0xc4);
            $jphoneEmoji["%s537%"] = pack("C*", 0xfb,0xc5);
            $jphoneEmoji["%s538%"] = pack("C*", 0xfb,0xc6);
            $jphoneEmoji["%s539%"] = pack("C*", 0xfb,0xc7);
            $jphoneEmoji["%s540%"] = pack("C*", 0xfb,0xc8);
            $jphoneEmoji["%s541%"] = pack("C*", 0xfb,0xc9);
            $jphoneEmoji["%s542%"] = pack("C*", 0xfb,0xca);
            $jphoneEmoji["%s543%"] = pack("C*", 0xfb,0xcb);
            $jphoneEmoji["%s544%"] = pack("C*", 0xfb,0xcc);
            $jphoneEmoji["%s545%"] = pack("C*", 0xfb,0xcd);
            $jphoneEmoji["%s546%"] = pack("C*", 0xfb,0xce);
            $jphoneEmoji["%s547%"] = pack("C*", 0xfb,0xcf);
            $jphoneEmoji["%s548%"] = pack("C*", 0xfb,0xd0);
            $jphoneEmoji["%s549%"] = pack("C*", 0xfb,0xd1);
            $jphoneEmoji["%s550%"] = pack("C*", 0xfb,0xd2);
            $jphoneEmoji["%s551%"] = pack("C*", 0xfb,0xd3);
            $jphoneEmoji["%s552%"] = pack("C*", 0xfb,0xd4);
            $jphoneEmoji["%s553%"] = pack("C*", 0xfb,0xd5);
            $jphoneEmoji["%s554%"] = pack("C*", 0xfb,0xd6);
            $jphoneEmoji["%s555%"] = pack("C*", 0xfb,0xd7);
        }

        return $jphoneEmoji;
    }

}
?>