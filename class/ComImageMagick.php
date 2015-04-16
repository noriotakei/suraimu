<?php
/**
 * ComImImageクラス
 *
 * ImageMagickを使用して画像処理を行う。
 *
 * @author  Shinichi Hata
 */
class ComImImage {

    const IMAGEMAGICK_PATH = "/usr/local/bin/";         // ImageMagickコマンドパス
    const FONT_TTF_PATH    = "/fonts/";      // フォントファイルパス

    const ERROR_LOG_FILE   = "/log/imagick_error.txt";    // エラーログファイル

    /** 処理画像のバイナリーバッファ */
    protected $buffer = null;

    /** 処理画像の詳細情報 */
    protected $info = array();

    /** 描画時ストローク色 */
    protected $stroke = null;

    /** 描画時ストローク幅 */
    protected $strokeWidth = null;

    /** 描画時フィル色 */
    protected $fill = null;

    /** 描画時背景色 */
    protected $underColor = null;

    /** 描画時文字フォント */
    protected $font = null;

    /** 描画時文字ポイント */
    protected $pointSize = null;

    /** 描画時アンチエイリアス */
    protected $antialias = true;

    /**
     * コンストラクタ
     */
    public function __construct($fileName = null) {
        if ($fileName) {
            $this->loadImage($fileName);
        }
    }

    /**
     * loadImage
     *
     * 画像データをバッファに読み込む。
     *
     * @param string $fileName ファイル名
     * @return boolean 成功ならtrue、失敗ならfalseを返す
     */
    public function loadImage($fileName) {

        if (!$fileName || !file_exists($fileName)) {
            return false;
        }

        $fp = fopen($fileName, "rb");

        if (!is_resource($fp)) {
            return false;
        }

        // 画像データの読み込み
        $this->buffer = fread($fp, filesize($fileName));

        fclose($fp);

        // 詳細情報のセット
        $this->setInfo($fileName);

        return true;
    }

    /**
     * setInfo
     *
     * 画像の詳細情報をセットする。
     *
     * @param string $fileName ファイル名
     * @return boolean 成功ならtrue、失敗ならfalseを返す
     */
    protected function setInfo($fileName) {

        if (!$fileName || !file_exists($fileName)) {
            return false;
        }

        // 取得情報フォーマットのオプション指定
        $format = "name:%t type:%e width:%w height:%h delay:%T size:%b scene:%n;";

        $command = "identify " . "-format '". $format . "' " . $fileName;

        // コマンドの実行
        $result = $this->direct($command);

        $dataArray = explode(";", $result);
        $delayArray = array();

        // 画像情報が複数の場合は1枚目の情報を基本情報とする
        foreach ($dataArray as $key => $value) {
            $detailArray = explode(" ", $value);

            foreach ($detailArray as $detailValue) {
                    list($infoKey, $infoValue) = explode(":", $detailValue);

                    if ($infoKey != "delay") {
                        if ($key == 0) {
                            // 1枚目の基本情報を格納
                            $this->info[$infoKey] = $infoValue;
                        } else {
                            // 2枚目以降はスルー
                            continue;
                        }
                    } else {
                        // 表示間隔配列へ一時格納
                        $delayArray[] = $infoValue;
                    }
            }
        }

        // 表示間隔の取得
        $this->info["delay"] = $delayArray;

        // ファイルパスの取得
        $data = pathinfo($fileName);
        $this->info["path"] = $data["dirname"];

        return true;
    }

    /**
     * setColor
     *
     * 描画色をセットする。
     *
     * @param string $stroke ストローク色
     * @param integer $strokeWidth ストローク幅
     * @param string $fill フィル色
     * @param string $underColor 背景色
     * @return boolean 成功ならtrue、失敗ならfalseを返す
     */
    public function setColor($stroke, $strokeWidth, $fill, $underColor = null) {
        $this->stroke = $stroke;
        $this->strokeWidth = $strokeWidth;
        $this->fill = $fill;
        $this->underColor = $underColor;

        return true;
    }

    /**
     * setFont
     *
     * フォントをセットする。
     *
     * @param string $font フォントファイル(TTF)
     * @param integer $pointSize 文字ポイント
     * @return boolean 成功ならtrue、失敗ならfalseを返す
     */
    public function setFont($font, $pointSize, $antialias = true) {
        $this->font = $font;
        $this->pointSize = $pointSize;
        $this->antialias = $antialias;

        return true;
    }

    /**
     * getInfo
     *
     * 画像の詳細情報を返す。
     *
     * @param string $keyName 項目名
     * @return boolean 成功なら詳細情報、失敗ならfalseを返す
     */
    public function getInfo($keyName) {

        if (!$keyName) {
            return false;
        }

        return $this->info[$keyName];
    }


    /**
     * direct
     *
     * コマンドを実行し、その結果を返す。
     *
     * @param string $command コマンド文字列
     * @return mixed 実行結果を返す
     */
    public function direct($command) {

        $command = self::IMAGEMAGICK_PATH . $command;

        // 出力バッファリング開始
        ob_start();

        // コマンドの実行＆出力内容の取得
        passthru($command);
        $result = ob_get_contents();

        // 出力バッファリング終了
        ob_end_clean();

        return $result;
    }

    /**
     * command
     *
     * バッファ内データを元にコマンドを実行し、
     * その結果をバッファに再格納する。
     *
     * @param string $command コマンド文字列
     * @return boolean 成功ならtrue、失敗ならfalseを返す
     */
    public function command($command) {

        $command = self::IMAGEMAGICK_PATH . $command;

        // バイナリデータ入出力を行うためのおまじない
        $descriptorSpec = array(
            0 => array("pipe", "r"),                        // 標準入力データ
            1 => array("pipe", "w"),                        // 標準出力データ
            2 => array("file", D_BASE_DIR . self::ERROR_LOG_FILE, "a")   // 実行時エラーログ
        );

        // 入出力ハンドル配列
        $pipes = array();

        // プロセスの開始
        $process = proc_open($command, $descriptorSpec, $pipes);

        // バッファデータがあれば、標準入力データとして書き込む
        if ($this->buffer) {
            fwrite($pipes[0], $this->buffer);
        }
        fclose($pipes[0]);

        // 出力バッファリング開始
        ob_start();

        // コマンドの実行＆出力内容の取得
        fpassthru($pipes[1]);
        $this->buffer = ob_get_contents();

        // 出力バッファリング終了
        ob_end_clean();

        fclose($pipes[1]);

        // プロセスの終了
        proc_close($process);

        return true;
    }

    /**
     * display
     *
     * バッファ内データを出力する。
     *
     * @return boolean 成功ならtrue、失敗ならfalseを返す
     */
    public function display() {

        // ヘッダー情報の送信
        $this->sendImageTypeHeader($this->info["type"]);
        // 画像の出力
        print($this->buffer);

        return true;
    }

    /**
     * sendImageTypeHeader
     *
     * 出力画像タイプのヘッダー情報を送信する。
     *
     * @param string $imageType 画像タイプ
     * @return boolean 成功ならtrue、失敗ならfalseを返す
     */
    public function sendImageTypeHeader($imageType) {

        // 画像タイプの指定
        switch (strtolower($imageType)) {
            case "jpg":
                $imageType = "jpeg";
                break;
            case "jpeg":
            case "gif":
            case "png":
            case "bmp":
                break;
            default:
                return false;
        }

        // ヘッダー情報の送信
        header("Content-type: image/" . $imageType);

        return true;
    }

    /**
     * save
     *
     * バッファ内データをファイルに保存する。
     *
     * @param string $targetFileName 保存先ファイル名
     * @return boolean 成功ならtrue、失敗ならfalseを返す
     */
    public function save($targetFileName = null) {

        // 保存先ファイル名指定がなければ、読み込み済み画像を上書きする
        if (!$targetFileName) {
            $targetFileName = $this->info["path"] . "/" . $this->info["name"] . "." . $this->info["type"];
        }

        $fp = fopen($targetFileName, "wb");

        if (!is_resource($fp) || !flock($fp, LOCK_EX)) {
            return false;
        }

        $result = fwrite($fp, $this->buffer);

        fclose($fp);

        return $result;
    }

    /**
     * convertImageType
     *
     * 画像フォーマットを変換する。
     *
     * @param string $imageType 変換後フォーマット
     * @return boolean 成功ならtrue、失敗ならfalseを返す
     */
    public function convertImageType($imageType) {

        switch (strtolower($imageType)) {
            case "jpg":
                $imageType = "jpeg";
                break;
            case "jpeg":
            case "gif":
            case "png":
            case "bmp":
                break;
            default:
                return false;
        }

        $command = "convert - " . $imageType . ":-";

        $result = $this->command($command);

        if ($result) {
            $this->info["type"] = $imageType;

            return true;
        } else {
            return false;
        }
    }

    /**
     * resizeGif
     *
     * アニメーションGIFを含む、GIF画像のリサイズを行う。(gif出力)
     *
     * @param integer $width 幅(px or %)
     * @param integer $height 高さ(px or %)
     * @param boolean $exactly 縦横比無視フラグ
     * @return boolean 成功ならtrue、失敗ならfalseを返す
     */
    public function resizeGif($width, $height, $exactly = "") {

        if (!is_numeric(str_replace("%", "", $width))
                || !is_numeric(str_replace("%", "", $height))) {
            return false;
        }

        if ($exactly) {
            $exactly = "!";
        }

        $command = "convert - -sample '" . $width . "x" . $height . $exactly . "' gif:-";

        $result = $this->command($command);

        if ($result) {
            $this->info["type"] = "gif";

            return true;
        } else {
            return false;
        }
    }

    /**
     * thumbnail
     *
     * サムネイル画像の生成。(jpeg出力)
     *
     * @param integer $width 幅(px or %)
     * @param integer $height 高さ(px or %)
     * @param integer $quality 画質(0-100)
     * @param boolean $exactly 縦横比無視フラグ
     * @return boolean 成功ならtrue、失敗ならfalseを返す
     */
    public function thumbnail($width, $height, $quality, $exactly = "") {

        if (!is_numeric(str_replace("%", "", $width))
                || !is_numeric(str_replace("%", "", $height)) || !is_numeric($quality)) {
            return false;
        }

        if ($exactly) {
            $exactly = "!";
        }

        if (preg_match("/%/", $width)) {
            // 2倍したら100%を超えた場合
            if (($scale = str_replace("%", "", $width) * 2) > 100) {
                $scale = 100;
            }

            $size = $scale . "%";
        } else {
            // 2倍したら元のサイズを超えた場合
            if (($scale = $width * 2) > $this->info["width"]) {
                $scale = $this->info["width"];
            }

            $size = $scale;
        }

        if (preg_match("/%/", $height)) {
            if (($scale = str_replace("%", "", $height) * 2) > 100) {
                $scale = 100;
            }

            $size .= "x" . $scale . "%";
        } else {
            if (($scale = $height * 2) > $this->info["height"]) {
                $scale = $this->info["height"];
            }

            $size .= "x" . $scale;
        }

        $thumbnail = $width . "x" . $height . $exactly;

        $command = "convert -size '". $size . "' - -quality " . $quality
                 . " -thumbnail '" . $thumbnail . "' " . "jpeg:-";

        $result = $this->command($command);

        if ($result) {
            $this->info["type"] = "jpeg";

            return true;
        } else {
            return false;
        }
    }

    /**
     * composite
     *
     * 画像の合成を行う。
     *
     * @param string $fileName 前景画像ファイル名
     * @param integer $x 配置x座標(px)
     * @param integer $y 配置y座標(px)
     * @param integer $dissolve 不透明度(0-100)
     * @param string $gravity 座標中心位置の指定
     * @return boolean 成功ならtrue、失敗ならfalseを返す
     */
    public function composite($fileName, $x, $y, $dissolve, $gravity = "") {

        if (!$fileName || !file_exists($fileName) ||
            !is_numeric($x) || !is_numeric($y) || !is_numeric($dissolve)) {
            return false;
        }

        switch (strtolower($gravity)) {
            case "":
                break;
            case "center":
            case "north":
            case "northeast":
            case "east":
            case "southeast":
            case "south":
            case "southwest":
            case "west":
            case "northwest":
                $gravity = "-gravity " . $gravity;
                break;
            default:
                return false;
        }

        if ($x >= 0) {
            $x = "+" . $x;
        }
        if ($y >= 0) {
            $y = "+" . $y;
        }

        $command = "composite " . $gravity . " -geometry '" . $x . $y . "' "
                 . "-dissolve " . $dissolve . " " . $fileName . " - " . $this->info["type"] . ":-";

        return $this->command($command);
    }

    /**
     * annotate
     *
     * テキストを画像に書き込む。
     *
     * @param string $text 書き込み文字列
     * @param integer $x 配置x座標(px)
     * @param integer $y 配置y座標(px)
     * @param string $gravity 座標中心位置の指定
     * @return boolean 成功ならtrue、失敗ならfalseを返す
     */
    public function annotate($text, $x, $y, $gravity = null) {

        if (!$text || !is_numeric($x) || !is_numeric($y) || !is_numeric($this->pointSize) || !$this->fill) {
            return false;
        }

        // 書き込むテキストのエンコーディングは「UTF-8」のみ指定可能
        if (mb_detect_encoding($text) != "UTF-8") {
           $text = mb_convert_encoding($text, "UTF-8", "auto");
        }

        // うまいこと書き込むためのエスケープ
        $text = mb_ereg_replace("`", "｀", $text);
        $text = mb_ereg_replace('"', '\"', $text);

        if ($this->font) {
            $font = " -font " . D_BASE_DIR . self::FONT_TTF_PATH . $this->font;
        }

        $font .= " -pointsize " . $this->pointSize . " -fill '" . $this->fill . "'";

        if ($this->stroke) {
            $font .= " -stroke '" . $this->stroke . "'";
        }
        if ($this->strokeWidth) {
            $font .= " -strokewidth " . $this->strokeWidth;
        }
        if ($this->underColor) {
            $font .= " -undercolor '" . $this->underColor . "'";
        }
        if (!$this->antialias) {
            $font .= " +antialias";
        }

        switch (strtolower($gravity)) {
            case "":
                break;
            case "center":
            case "north":
            case "northeast":
            case "east":
            case "southeast":
            case "south":
            case "southwest":
            case "west":
            case "northwest":
                $gravity = " -gravity " . $gravity;
                break;
            default:
                return false;
        }

        if ($x >= 0) {
            $x = "+" . $x;
        }
        if ($y >= 0) {
            $y = "+" . $y;
        }

        $command = "convert -" . $font . $gravity . " "
                 . "-annotate " . $x . $y . " \"" . $text . "\" " . $this->info["type"] . ":-";

        return $this->command($command);
    }

    /**
     * separateAnimatedGifToFile
     *
     * アニメーションGIFを、フレームごとに別ファイルとして保存する。
     * (フレームごとのファイル名はデフォルトで、???_f00,???_f01,･･･となる)
     *
     * @param string $savePath 保存先のパス
     * @param string $suffix ファイル名の接尾指定
     * @return boolean 成功ならtrue、失敗ならfalseを返す
     */
    public function separateAnimatedGifToFile($savePath = null, $suffix = "_f%02d") {

        if (!$suffix || !$this->info["name"] || !is_numeric($this->info["scene"])) {
            return false;
        }

        if (!$savePath) {
            $savePath = $this->info["path"];
        }

        $command = "convert - +adjoin -coalesce " . $savePath . "/" . $this->info["name"] . $suffix . ".gif";

        return $this->command($command);
    }

    /**
     * createAnimatedGifToFile
     *
     * 複数のGIFファイルからアニメーションGIFを生成し、ファイルに保存する。
     *
     * @param string $frameInfoArray フレーム情報配列
     * @param string $targetFileName 保存先ファイル名
     * @param integer $loop ループ回数
     * @param boolean $optimize 最適化フラグ
     * @param string $dispose アニメーション生成方法
     * @return boolean 成功ならtrue、失敗ならfalseを返す
     */
    public function createAnimatedGifToFile($frameInfoArray, $targetFileName, $loop = 0, $optimize = true, $dispose = "none") {

        if (!is_array($frameInfoArray) || !$targetFileName || !is_numeric($loop)) {
            return false;
        }

        foreach ($frameInfoArray as $value) {
            if (!is_numeric($value["delay"]) || !$value["name"]) {
                return false;
            }

            $frame .= "-delay " . $value["delay"] . " -page +0+0 " . $value["name"] . " ";
        }

        // アニメーションGIFの生成
        // -disposeオプション：アニメーションの生成方法を指定
        // ※通常は「none」で問題ないが、透過GIF等の処理でアニメーションが
        // うまく生成されない場合は「previous」を指定してください。
        $command = "convert -dispose " . $dispose . " " . $frame . " -loop " . $loop . " " . $targetFileName;

        $result = $this->command($command);

        if (!$result) {
            return false;
        }

        if ($optimize) {
            // 最適化処理
            $command = "convert " . $targetFileName . " -layers OptimizeTransparency +map " . $targetFileName;

            $result = $this->command($command);

            if (!$result) {
                return false;
            }
        }

        return true;
    }

    /**
     * drawLine
     *
     * 線を描画する。
     *
     * @param array $coordinateArray 座標配列
     * @return boolean 成功ならtrue、失敗ならfalseを返す
     */
    public function drawLine($coordinateArray) {

        if (!is_array($coordinateArray) || !$this->stroke) {
            return false;
        }

        foreach ($coordinateArray as $value) {
            if (!is_numeric($value["x"]) || !is_numeric($value["y"])) {
                return false;
            }

            $coord .= $value["x"] . "," . $value["y"] . " ";
        }

        $stroke = "-stroke '" . $this->stroke . "'";

        if ($this->strokeWidth) {
            $stroke .= " -strokewidth " . $this->strokeWidth;
        }

        $stroke .= " -fill none";

        if (!$this->antialias) {
            $stroke .= " +antialias";
        }

        $command = "convert - " . $stroke
                 . " -draw \"line " . $coord . "\" " . $this->info["type"] . ":-";

        return $this->command($command);
    }

    /**
     * drawPolyLine
     *
     * 折れ線を描画する。
     *
     * @param array $coordinateArray 座標配列
     * @return boolean 成功ならtrue、失敗ならfalseを返す
     */
    public function drawPolyLine($coordinateArray) {

        if (!is_array($coordinateArray) || !$this->stroke) {
            return false;
        }

        foreach ($coordinateArray as $value) {
            if (!is_numeric($value["x"]) || !is_numeric($value["y"])) {
                return false;
            }

            $coord .= $value["x"] . "," . $value["y"] . " ";
        }

        $stroke = "-stroke '" . $this->stroke . "'";

        if ($this->strokeWidth) {
            $stroke .= " -strokewidth " . $this->strokeWidth;
        }

        $stroke .= " -fill none";

        if (!$this->antialias) {
            $stroke .= " +antialias";
        }

        $command = "convert - " . $stroke
                 . " -draw \"polyline " . $coord . "\" " . $this->info["type"] . ":-";

        return $this->command($command);
    }

    /**
     * drawRectangle
     *
     * 四角形を描画する。
     *
     * @param array $coordinateArray 座標配列
     * @return boolean 成功ならtrue、失敗ならfalseを返す
     */
    public function drawRectangle($coordinateArray) {

        if (!is_array($coordinateArray)) {
            return false;
        }

        foreach ($coordinateArray as $value) {
            if (!is_numeric($value["x"]) || !is_numeric($value["y"])) {
                return false;
            }

            $coord .= $value["x"] . "," . $value["y"] . " ";
        }

        if ($this->stroke) {
            $stroke .= " -stroke '" . $this->stroke . "'";
        }
        if ($this->strokeWidth) {
            $stroke .= " -strokewidth " . $this->strokeWidth;
        }
        if ($this->fill) {
            $stroke .= " -fill '" . $this->fill . "'";
        }
        if (!$this->antialias) {
            $stroke .= " +antialias";
        }

        $command = "convert -" . $stroke
                 . " -draw \"rectangle " . $coord . "\" " . $this->info["type"] . ":-";

        return $this->command($command);
    }

    /**
     * drawPolygon
     *
     * 多角形を描画する。
     *
     * @param array $coordinateArray 座標配列
     * @return boolean 成功ならtrue、失敗ならfalseを返す
     */
    public function drawPolygon($coordinateArray) {

        if (!is_array($coordinateArray)) {
            return false;
        }

        foreach ($coordinateArray as $value) {
            if (!is_numeric($value["x"]) || !is_numeric($value["y"])) {
                return false;
            }

            $coord .= $value["x"] . "," . $value["y"] . " ";
        }

        if ($this->stroke) {
            $stroke .= " -stroke '" . $this->stroke . "'";
        }
        if ($this->strokeWidth) {
            $stroke .= " -strokewidth " . $this->strokeWidth;
        }
        if ($this->fill) {
            $stroke .= " -fill '" . $this->fill . "'";
        }
        if (!$this->antialias) {
            $stroke .= " +antialias";
        }

        $command = "convert -" . $stroke
                 . " -draw \"polygon " . $coord . "\" " . $this->info["type"] . ":-";

        return $this->command($command);
    }

    /**
     * drawCircle
     *
     * 円を描画する。
     *
     * @param integer $centerX 中心X座標
     * @param integer $centerY 中心Y座標
     * @param integer $radius 半径
     * @return boolean 成功ならtrue、失敗ならfalseを返す
     */
    public function drawCircle($centerX, $centerY, $radius) {

        if (!is_numeric($centerX) || !is_numeric($centerY) || !is_numeric($radius)) {
            return false;
        }

        $coord = $centerX . "," . $centerY . " " . ($centerX + $radius) . "," . $centerY;

        if ($this->stroke) {
            $stroke .= " -stroke '" . $this->stroke . "'";
        }
        if ($this->strokeWidth) {
            $stroke .= " -strokewidth " . $this->strokeWidth;
        }
        if ($this->fill) {
            $stroke .= " -fill '" . $this->fill . "'";
        }
        if (!$this->antialias) {
            $stroke .= " +antialias";
        }

        $command = "convert -" . $stroke
                 . " -draw \"circle " . $coord . "\" " . $this->info["type"] . ":-";

        return $this->command($command);
    }

    /**
     * drawEllipse
     *
     * 楕円を描画する。
     *
     * @param integer $centerX 中心X座標
     * @param integer $centerY 中心Y座標
     * @param integer $radiusX X半径
     * @param integer $radiusY Y半径
     * @param integer $startAngle 開始角度
     * @param integer $endAngle 終了角度
     * @return boolean 成功ならtrue、失敗ならfalseを返す
     */
    public function drawEllipse($centerX, $centerY, $radiusX, $radiusY, $startAngle = 0, $endAngle = 360) {

        if (!is_numeric($centerX) || !is_numeric($centerY) || !is_numeric($radiusX) || !is_numeric($radiusY)) {
            return false;
        }

        $coord = $centerX . "," . $centerY . " " . $radiusX . "," . $radiusY . " "
               . $startAngle . "," . $endAngle;

        if ($this->stroke) {
            $stroke .= " -stroke '" . $this->stroke . "'";
        }
        if ($this->strokeWidth) {
            $stroke .= " -strokewidth " . $this->strokeWidth;
        }
        if ($this->fill) {
            $stroke .= " -fill '" . $this->fill . "'";
        }
        if (!$this->antialias) {
            $stroke .= " +antialias";
        }

        $command = "convert -" . $stroke
                 . " -draw \"ellipse " . $coord . "\" " . $this->info["type"] . ":-";

        return $this->command($command);
    }

    /**
     * sharpen
     *
     * 画像をシャープにする。
     *
     * @param integer $sigma 強度(float)
     * @param integer $radius 半径(しきい値)
     * @return boolean 成功ならtrue、失敗ならfalseを返す
     */
    public function sharpen($sigma, $radius = 0) {

        if (!is_numeric($sigma) || !is_numeric($radius)) {
            return false;
        }

        $command = "convert - -sharpen ". $radius . "x" . $sigma . " " . $this->info["type"] . ":-";

        return $this->command($command);
    }

    /**
     * blur
     *
     * 画像をぼかす。
     *
     * @param integer $sigma 強度(float)
     * @param integer $radius 半径(しきい値)
     * @return boolean 成功ならtrue、失敗ならfalseを返す
     */
    public function blur($sigma, $radius = 0) {

        if (!is_numeric($sigma) || !is_numeric($radius)) {
            return false;
        }

        $command = "convert - -blur ". $radius . "x" . $sigma . " " . $this->info["type"] . ":-";

        return $this->command($command);
    }

    /**
     * flip
     *
     * 画像を上下反転させる。
     *
     * @return boolean 成功ならtrue、失敗ならfalseを返す
     */
    public function flip() {

        $command = "convert - -flip " . $this->info["type"] . ":-";

        return $this->command($command);
    }

    /**
     * flop
     *
     * 画像を左右反転させる。
     *
     * @return boolean 成功ならtrue、失敗ならfalseを返す
     */
    public function flop() {

        $command = "convert - -flop " . $this->info["type"] . ":-";

        return $this->command($command);
    }

    /**
     * rotate
     *
     * 画像を回転させる。
     *
     * @param integer $degree 回転角度
     * @return boolean 成功ならtrue、失敗ならfalseを返す
     */
    public function rotate($degree) {

        if (!is_numeric($degree)) {
            return false;
        }

        $command = "convert - -rotate " . $degree . " " . $this->info["type"] . ":-";

        return $this->command($command);
    }
}
?>
