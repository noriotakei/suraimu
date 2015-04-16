<?php
/**
 * ComUserAgentMobileEzweb.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * AU端末情報を扱うクラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      Mitsuhiro Nakamura
 */

class ComUserAgentMobileEzweb {

    /** @var string ユーザーエージェント情報 */
    protected $_httpUserAgent = null;

    /** @var object リクエストobject */
    protected $_requestOBJ = null;

    /**
     * AU新機種が発売された際は、以下のURLから
     * デバイスIDデータを配列に追加してください。
     * http://www.au.kddi.com/ezfactory/tec/spec/4_4.html
     *
     * @var array デバイスIDデータ配列
     */
    private $_modelArray = array(
        // ■CDMA 1X WIN (W03H、W02H、W01を除く)
        // デバイスID => 機種名
        "PT36" => "PT002",
        "TS3X" => "T006",
        "KC42" => "K007",
        "SH3L" => "SH011",
        "KC43" => "K008",
        "SN3S" => "S006",
        "CA3J" => "CA006",
        "CA3I" => "G\'zOne TYPE-X",
        "SH3K" => "SH010",
        "TS3W" => "X-RAY [iida]",
        "SN3Q" => "S005",
        "TS3V" => "T005",
        "SN3R" => "URBANO MOND",
        "KC41" => "K006 カメラなしモデル",
        "SH3J" => "SH009",
        "KC3Z" => "K006",
        "TS3U" => "LIGHT POOL [iida]",
        "KC3Y" => "K005",
        "SH3I" => "SH008",
        "SN3O" => "S003",
        "KC3X" => "SA002",
        "TS3S" => "T004",
        "SN3P" => "S004",
        "HI3H" => "beskey",
        "CA3H" => "CA005",
        "SH3H" => "SH007",
        "KC3W" => "mamorino",
        "SH3G" => "SH006",
        "KC3V" => "lotta[iida]",
        "KC3U" => "K004",
        "SN3N" => "URBANO BARONE",
        "SH3F" => "SH005",
        "SN3L" => "BRAVIA® Phone U1",
        "SH3E" => "SH004",
        "KC3S" => "PRISMOID[iida]",
        "TS3R" => "T003",
        "SH3D" => "SH003",
        "CA3G" => "CA004",
        "SN3M" => "S002",
        "KC3R" => "SA001",
        "CA3F" => "CA003",
        "TS3Q" => "PLY[iida]",
        "KC3P" => "K003",
        "HI3G" => "Mobile Hi-Vision CAM Wooo",
        "KC3Q" => "misora[iida]",
        "TS3O" => "biblio",
        "TS3P" => "T002",
        "SH3B" => "SH002",
        "KC3O" => "K002",
        "SH3C" => "Sportio water beat",
        "CA3E" => "CA002",
        "SN3K" => "G9[iida]",
        "SN3J" => "S001",
        "PT35" => "NS02",
        "MA35" => "P001",
        "TS3N" => "T001",
        "HI3F" => "H001",
        "SH38" => "SH001",
        "CA3D" => "CA001",
        "SN3I" => "Premier3",
        "KC3N" => "NS01",
        "KC3M" => "K001",
        "SN3H" => "Xmini",
        "HI3E" => "W63H",
        "TS3M" => "W65T",
        "CA3C" => "W63CA",
        "SH37" => "W64SH",
        "KC3I" => "W65K",
        "SN3G" => "W64S",
        "MA34" => "W62P",
        "TS3L" => "W64T",
        "KC3K" => "W63K",
        "SH36" => "URBANO",
        "PT34" => "W62PT",
        "SA3E" => "W64SA",
        "CA3B" => "W62CA",
        "HI3D" => "W62H",
        "SH35" => "W62SH",
        "SN3F" => "FULL CHAN re",
        "KC3H" => "W63K",
        "TS3K" => "Sportio",
        "TS3J" => "W62T",
        "SA3D" => "W63SA",
        "KC3G" => "W62K",
        "SN3D" => "W61S",
        "SA3C" => "W61SA",
        "SN3E" => "W62S",
        "TS3I" => "W61T",
        "HI3C" => "W61H",
        "ST34" => "W62SA",
        "PT33" => "W61PT",
        "MA33" => "W61P",
        "CA3A" => "W61CA",
        "KC3D" => "W61K",
        "SA3B" => "W54SA",
        "SH34" => "W61SH",
        "SN3C" => "W54S",
        "TS3H" => "W56T",
        "TS3G" => "W55T",
        "HI3B" => "W53H",
        "KC3B" => "W53K",
        "ST33" => "INFOBAR 2",
        "KC3E" => "W44K II",
        "SN3B" => "W53S",
        "CA39" => "W53CA",
        "ST32" => "W53SA",
        "TS3E" => "W54T",
        "SH33" => "W52SH",
        "CA38" => "W52CA",
        "MA32" => "W52P",
        "SN3A" => "W52S",
        "TS3D" => "W53T",
        "SA3A" => "W52SA",
        "HI3A" => "W52H",
        "KC3A" => "MEDIA SKIN",
        "SH32" => "W51SH",
        "SN39" => "W51S",
        "TS3C" => "W52T",
        "TS3B" => "W51T",
        "SA39" => "W51SA",
        "HI39" => "W51H",
        "CA37" => "W51CA",
        "MA31" => "W51P",
        "KC39" => "W51K",
        "TS39" => "DRAPE",
        "TS3A" => "W47T",
        "SN38" => "W44S",
        "KC38" => "W44K",
        "SA38" => "W43SA",
        "TS38" => "W45T",
        "CA35" => "W43CA",
        "HI38" => "W43H,W43H II",
        "SN37" => "W43S",
        "KC37" => "W43K",
        "ST31" => "W42SA",
        "SH31" => "W41SH",
        "CA34" => "W42CA",
        "HI37" => "W42H",
        "TS37" => "W44T,W44T II,W44T III",
        "TS35" => "neon",
        "TS36" => "W43T",
        "SN36" => "W42S",
        "KC36" => "W42K",
        "KC35" => "W41K",
        "SA36" => "W41SA",
        "TS34" => "W41T",
        "HI36" => "W41H",
        "CA33" => "W41CA",
        "SN34" => "W41S",
        "HI34" => "PENCK",
        "SA35" => "W33SA,W33SA II",
        "TS33" => "W32T",
        "SA34" => "W32SA",
        "KC34" => "W32K",
        "HI35" => "W32H",
        "SN33" => "W32S",
        "SN35" => "W32S",
        "CA32" => "W31CA",
        "TS32" => "W31T",
        "SN32" => "W31S",
        "KC33" => "W31K,W31K II",
        "SA33" => "W31SA,W31SA II",
        "SA32" => "W22SA",
        "HI33" => "W22H",
        "CA31" => "W21CA,W21CA II",
        "TS31" => "W21T",
        "SA31" => "W21SA",
        "SN31" => "W21S",
        "KC32" => "W21K",
        "HI32" => "W21H",
        "KC31" => "W11K",
        "HI31" => "W11H",
        "TS3T" => "E08T",
        "KC3T" => "E07K",
        "SH3A" => "E06SH",
        "SH39" => "E05SH",
        "CA36" => "E03CA",
        "SA37" => "E02SA",
        // ■CDMA 1X
        "ST2C" => "Sweets cute",
        "ST29" => "Sweets pure",
        "CA28" => "G\'zOne TYPE-R",
        "ST26" => "Sweets",
        "ST25" => "talby",
        "ST22" => "INFOBAR",
        "ST2D" => "A5525SA",
        "TS2D" => "A5523T",
        "SA29" => "A5522SA",
        "KC28" => "A5521K",
        "ST2A" => "A5520SA,A5520SA II",
        "ST28" => "A5518SA",
        "TS2C" => "A5517T",
        "TS2B" => "A5516T",
        "KC27" => "A5515K",
        "ST27" => "A5514SA",
        "CA27" => "A5512CA",
        "TS2A" => "A5511T",
        "TS29" => "A5509T",
        "ST24" => "A5507SA",
        "TS28" => "A5506T",
        "SA27" => "A5505SA",
        "TS27" => "A5504T",
        "SA26" => "A5503SA",
        "KC24" => "A5502K",
        "KC25" => "A5502K",
        "TS26" => "A5501T",
        "CA26" => "A5407CA",
        "CA25" => "A5406CA",
        "ST23" => "A5405SA",
        "SN25" => "A5404S",
        "CA24" => "A5403CA",
        "SN24" => "A5402S",
        "CA23" => "A5401CA II",
        "CA23" => "A5401CA",
        "ST21" => "A5306ST",
        "KC22" => "A5305K",
        "TS24" => "A5304T",
        "HI24" => "A5303H II",
        "HI23" => "A5303H",
        "CA22" => "A5302CA",
        "TS23" => "A5301T",
        "SA22" => "A3015SA",
        "PT22" => "A1406PT",
        "PT21" => "A1405PT",
        "SN29" => "A1404S,A1404S II",
        "KC26" => "A1403K",
        "SN27" => "A1402S II",
        "SN28" => "A1402S II non camera",
        "SN26" => "A1402S",
        "KC23" => "A1401K",
        "SA28" => "A1305SA",
        "TS25" => "A1304T II",
        "TS25" => "A1304T",
        "SA25" => "A1303SA",
        "SA24" => "A1302SA",
        "SN23" => "A1301S",
        "ST14" => "A1014ST",
        "KC15" => "A1013K",
        "KC26" => "B01K",
        // ■cdmaOne
        "SN21" => "A3014S",
        "TS22" => "A3013T",
        "CA21" => "A3012CA",
        "SA21" => "A3011SA",
        "SN22" => "A1101S",
        "KC14" => "A1012K II",
        "KC14" => "A1012K",
        "ST13" => "A1011ST",
        "TS21" => "C5001T",
        "MA21" => "C3003P",
        "KC21" => "C3002K",
        "HI21" => "C3001H",
        "SN17" => "C1002S",
        "SY15" => "C1001SA",
        "CA14" => "C452CA",
        "HI14" => "C451H",
        "TS14" => "C415T",
        "KC13" => "C414K II",
        "KC13" => "C414K",
        "SN15" => "C413S",
        "SN16" => "C413S",
        "SY14" => "C412SA",
        "ST12" => "C411ST",
        "TS13" => "C410T",
        "CA13" => "C409CA",
        "MA13" => "C408P",
        "HI13" => "C407H",
        "SN13" => "C406S",
        "SY13" => "C405SA",
        "SN12" => "C404S",
        "SN14" => "C404S",
        "ST11" => "C403ST",
        "DN11" => "C402DE",
        "SY12" => "C401SA",
        // ■Tu-Ka
        "KCTE" => "TK51",
        "TST9" => "TT51",
        "KCU1" => "TK41",
        "SYT5" => "TS41",
        "KCTD" => "TK40",
        "TST8" => "TT32",
        "TST7" => "TT31",
        "KCTC" => "TK31",
        "SYT4" => "TS31",
        "KCTB" => "TK23",
        "KCTA" => "TK22",
        "TST6" => "TT22",
        "KCT9" => "TK21",
        "TST5" => "TT21",
        "TST4" => "TT11",
        "KCT8" => "TK12",
        "SYT3" => "TS11",
        "KCT7" => "TK11",
        "MIT1" => "TD11",
        "MAT3" => "TP11",
        "KCT6" => "TK05",
        "TST3" => "TT03",
        "KCT5" => "TK04",
        "KCT4" => "TK03",
        "SYT2" => "TS02",
        "MAT1" => "TP01",
        "MAT2" => "TP01",
        "TST2" => "TT02",
        "KCT3" => "TK0K",
        "KCT2" => "TK02",
        "KCT1" => "TK01",
        "TST1" => "TT01",
        "SYT1" => "TS01",
        "CA3J" => "CA006",
    );

    /**
     * コンストラクタ
     *
     * @param string $httpUserAgent $_SERVER["HTTP_USER_AGENT"]の値
     */
    public function __construct($httpUserAgent) {
        $this->_httpUserAgent = $httpUserAgent;
        $this->_requestOBJ = ComRequest::getInstance();
    }

    /**
     * WAP2端末かどうかをチェックする。
     *
     * @return boolean WAP2ならtrue、違うならfalse
     */
    public function isWap2() {

        if (!$this->_httpUserAgent) {
            return false;
        }

        $wap2Regex = "/^KDDI-[A-Z]+\d+[A-Z]? /";

        if (preg_match($wap2Regex, $this->_httpUserAgent)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * WIN端末かどうかをチェックする。
     *
     * デバイスIDの3桁目が「3」ならWIN端末。
     *
     * @return boolean WIN端末ならtrue、違うならfalse
     */
    public function isWin() {
        // デバイスIDの取得
        $deviceId = $this->getDeviceId();

        // デバイスIDの3桁目が「3」ならWIN端末。
        if (substr($deviceId, 2, 1) == "3" OR substr($deviceId, 2, 1) == "4") {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 携帯機種名を取得する。
     *
     * @return mixed 取得成功なら携帯機種名、失敗ならfalse
     */
    public function getModel() {
        // デバイスIDの取得
        $deviceId = $this->getDeviceId();
        // デバイスIDから機種名に変換
        $model = $this->convertDeviceIdToModel($deviceId);

        /* エラーメール飛ばさない hosoda 2012-01-13
        if(!$model){
            $SendMailOBJ = SendMail::getInstance();
            $mailElements["subject"] = "getEzwebModelError";
            $mailElements["text_body"] = "ComUserAgentMobileEzweb.phpに機種名称、デバイスID（".$deviceId."）がありません";
            // システムにエラーメール
            $SendMailOBJ->debugMailTo($mailElements);
        }
        */

        return $model;
    }

    /**
     * デバイスIDを取得する。
     *
     * @return mixed デバイスID、失敗ならfalse
     */
    public function getDeviceId() {

        // 正規表現文字列に「/」を使用するため、「!」がデリミタ
        $deviceRegex = "!^(?:KDDI|UP.Browser/[\d\.]+)-(\S+) !";

        if (!preg_match($deviceRegex, $this->_httpUserAgent, $matches)) {
            return false;
        }

        $deviceId = $matches[1];

        return $deviceId;
    }

    /**
     * デバイスIDを携帯機種名に変換する。
     *
     * AUのユーザーエージェント内には、デバイスIDのみが
     * 格納されているため、この変換処理が必要。
     *
     * @param  string $deviceId デバイスID
     * @return mixed 携帯機種名
     */
    private function convertDeviceIdToModel($deviceId) {

        if (!$deviceId) {
            return false;
        }

        if (!array_key_exists($deviceId, $this->_modelArray)) {
            return false;
        }

        return $this->_modelArray[$deviceId];
    }

    /**
     * 個体識別番号(サブスクライバID)を取得する。
     *
     * @return string サブスクライバID
     */
    public function getSerialNumber() {
        return $this->_requestOBJ->getParameter("HTTP_X_UP_SUBNO", "", "server");
    }
}

?>
