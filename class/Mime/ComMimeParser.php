<?php
/**
 * Mime_ComMimeParser.php
 *
 * Mime(Multipurpose Internet Mail Extensions)フォーマットに基づいたデータを解析するクラス
 *
 * ※PEAR::Mail_mimeDecode参考
 *
 * @author    mitsuhiro_nakamura
 * @since     2009/08/11
 */

/**
 * Mime_ComMimeParser
 *
 * @author  mitsuhiro_nakamura
 * @version 1.0
 */
class Mime_ComMimeParser {
    /**
     * コンストラクタ
     */
    public function __construct() {
        // 何もしない
    }

    /**
     * parseメソッド
     *
     * データ全体を解析する
     *
     * stdClass:http://phpspot.net/php/pgPHP%95W%8F%80%83N%83%89%83X%82%CCstdClass%82??%A2%82%C4.html
     *
     * @param  string $input  Mimeフォーマットデータ
     * @return object $return フォーマットされたオブジェクト(stdClass)
     */
    public function parse($input) {
        // オブジェクトで返すため、PHP標準クラスのstdClassを使用
        $return = new stdClass;
        $return->headers = array();

        // headerとbodyを分割
        list($header, $body) = $this->_splitBodyHeader($input);

        // headerを整形(2次元配列:[添え字]["name"]、[添え字]["value"])
        $headers = $this->_parseHeaders($header);

        // headerを返り値へ格納
        // ↓ここちょっと変な処理。。。
        foreach ($headers as $value) {
            // 名前は小文字で統一
            $name = strtolower($value["name"]);

            // セットされているが、配列でない。つまり2つ目の値
            if (isset($return->headers[$name]) && !is_array($return->headers[$name])) {
                // 1つ目の値を配列の1番目に入れ直す
                $return->headers[$name]   = array($return->headers[$name]);
                // 2つ目を追加
                $return->headers[$name][] = $value["value"];
            // セットされていて、配列。つまり3つ目以降の値
            } else if (isset($return->headers[$name])) {
                // そのまま配列に追加
                $return->headers[$name][] = $value["value"];
            // 最初は単数と見なして文字列で格納
            } else {
                $return->headers[$name]   = $value["value"];
            }
        }

        // content-type・content-disposition・content-transfer-encodingを返り値へ格納
        foreach ($headers as $key => $value) {
            switch (strtolower($value["name"])) {
                case "content-type":
                    $contentType = $this->_parseHeaderValue($value["value"]);
                    // 「/」区切り
                    $matches = array();
                    if (preg_match("/([0-9a-z+.-]+)\/([0-9a-z+.-]+)/i", $contentType["value"], $matches)) {
                        $return->contentType["primary"]   = $matches[1];
                        $return->contentType["secondary"] = $matches[2];
                    }

                    // 付加パラメータ
                    if (isset($contentType["other"])) {
                        $return->contentType["other"] = $contentType["other"];
                    }
                    break;
                case "content-disposition":
                    $contentDisposition         = $this->_parseHeaderValue($value["value"]);
                    $return->contentDisposition = $contentDisposition["value"];

                    // 付加パラメータ
                    if (isset($contentDisposition["other"])) {
                        $return->contentDisposition["other"] = $contentDisposition["other"];
                    }
                    break;
                case "content-transfer-encoding":
                    $contentTransferEncoding         = $this->_parseHeaderValue($value["value"]);
                    $return->contentTransferEncoding = $this->_parseHeaderValue($value["value"]);
                    break;
            }
        }

        // Content-Type別
        if (isset($contentType)) {
            switch (strtolower($contentType["value"])) {
                // テキスト
                case "text/plain":
                    $encoding = isset($contentTransferEncoding["value"]) ? $contentTransferEncoding["value"] : "7bit";
                    $charset  = isset($contentType["other"]["charset"]) ? $contentType["other"]["charset"] : "";
                    $return->body = $this->_decodeBody($body, $encoding, $charset);
                    break;
                // HTML
                case "text/html":
                    $encoding = isset($contentTransferEncoding["value"]) ? $contentTransferEncoding["value"] : "7bit";
                    $charset  = isset($contentType["other"]["charset"]) ? $contentType["other"]["charset"] : "";
                    $return->body = $this->_decodeBody($body, $encoding, $charset);
                    break;
                // multipart
                case "multipart/parallel":
                case "multipart/appledouble":   // Appledouble mail
                case "multipart/report":        // RFC1892
                case "multipart/signed":        // PGP
                case "multipart/digest":
                case "multipart/alternative":
                case "multipart/related":
                case "multipart/mixed":
                    // multipartなのにboundaryがない
                    if(!isset($contentType["other"]["boundary"])){
                        return false;
                    }

                    // multipartBodyをboundaryで分割
                    $parts = $this->_boundarySplit($body, $contentType["other"]["boundary"]);
                    // multipart毎にさらにparse
                    for ($i = 0; $i < count($parts); $i++) {
                        $return->multipart[] = self::parse($parts[$i]);
                    }
                    break;

                /* よくわからないのでパス
                case "message/rfc822":
                    $return->multipart[] = self::parse($body);
                    break;
                */
                default:
                    $encoding = isset($contentTransferEncoding["value"]) ? $contentTransferEncoding["value"] : "7bit";
                    $charset  = isset($contentType["other"]["charset"]) ? $contentType["other"]["charset"] : "";
                    $return->body = $this->_decodeBody($body, $encoding, $charset);
                    break;
            }
        // デフォルト(Content-Type text/plain; charset=7bit)
        } else {
            $ctype = explode("/", "text/plain");
            $return->contentType["primary"]   = $ctype[0];
            $return->contentType["secondary"] = $ctype[1];
            $return->body = $this->_decodeBody($body);
        }

        return $return;
    }

    /**
     * _parseHeadersメソッド
     *
     * ヘッダを解析する
     *
     * @param  string $header        ヘッダデータ
     * @return array  $returnHeaders 配列化されたheader名と値
     */
    protected function _parseHeaders($header) {
        // 「\r\n」形式に統一
        $header = preg_replace("/\r?\n/", "\r\n", $header);
        // 複数行データを1行へ整形
        $header = preg_replace("/\r\n(\t| )+/", " ", $header);
        // 「\r\n」区切りで配列化
        $headerRows = explode("\r\n", trim($header));

        $returnHeaders = array();

        if (is_array($headerRows)) {
            foreach ($headerRows as $row) {
                // 区切りの「:」の位置を取得
                $pos = strpos($row, ":");

                // header名と値を分割
                $headerName  = substr($row, 0, $pos);
                $headerValue = substr($row, $pos + 1);

                // 先頭のスペースを除去
                $headerValue = ($headerValue[0] == " ") ? substr($headerValue, 1) : $headerValue;

                // 署名(名前)付きheaderのdecode
                $headerValue = $this->_decodeHeader($headerValue);

                $matches = array();
                // 署名付き
                if (preg_match("/(.+)[\s]<(.+)>$/", $headerValue, $matches)) {
                    $decodeHeaderValue = $matches[1];
                    $headerValue       = $matches[2];

                    // 署名を別名格納 to ⇒ to_name,subject ⇒ subject_name,etc...
                    $decodeHeaderName = $headerName . "_name";

                    // 名前とアドレスを別々に配列化
                    $returnHeaders[] = array("name" => $headerName, "value" => $headerValue);
                    $returnHeaders[] = array("name" => $decodeHeaderName, "value" => $decodeHeaderValue);
                } else {
                    // アドレスに括られている<>を除去
                    $headerValue = preg_replace("/^<(.+)>$/", "\\1", $headerValue);
                    // 配列化
                    $returnHeaders[] = array("name" => $headerName, "value" => $headerValue);
                }
            }
        }

        return $returnHeaders;
    }

    /**
     * _boundarySplitメソッド
     *
     * bodyをバウンダリ区切りで分割する
     *
     * @param  string $input    ボディデータ
     * @return string $boundary バウンダリ
     */
    protected function _boundarySplit($input, $boundary) {
        $parts = array();

        $bsPossible = substr($boundary, 2, -2);
        $bsCheck = '\"' . $bsPossible . '\"';
        if ($boundary == $bsCheck) {
            $boundary = $bsPossible;
        }

        $tmp = explode("--" . $boundary, $input);

        for ($i = 1; $i < count($tmp) - 1; $i++) {
            $parts[] = $tmp[$i];
        }

        return $parts;
    }

    /**
     * _splitBodyHeaderメソッド
     *
     * Mimeフォーマットデータをヘッダとボディに分割する
     *
     * @param  string $input Mimeフォーマットデータ
     * @return array         ヘッダ、ボディ
     */
    protected function _splitBodyHeader($input) {
        // 改行2つ分で分割
        if (preg_match("/^(.*?)\r?\n\r?\n(.*)/s", $input, $match)) {
            return array($match[1], $match[2]);
        }

        return false;
    }

    /**
     * _decodeHeaderメソッド
     *
     * ヘッダをデコードする
     *
     * @param  string $input ヘッダの値
     * @return string $input デコードされたヘッダ値
     */
    protected function _decodeHeader($input) {
        // 複数行のsubjectなどの空白の除去
        while (preg_match("/(=\?[^?]+\?(q|b)\?[^?]*\?=)(\s)+=\?/i", $input, $match)) {
            $input = preg_replace("/(=\?[^?]+\?(q|b)\?[^?]*\?=)(\s)+=\?/i", "\\1=?", $input);
        }

        // 1:マッチング文字列 2:キャラセット 3:エンコードタイプ 4:エンコード文字列
        while (preg_match("/(=\?([^?]+)\?(q|b)\?([^?]*)\?=)/i", $input, $matches)) {
            $encoded  = $matches[1];
            $charset  = $matches[2];
            $encoding = $matches[3];
            $text     = $matches[4];

            switch (strtolower($encoding)) {
                // base64
                case 'b':
                    $text = base64_decode($text);
                    break;
                // quoted-printable
                case 'q':
                    // ↓ここはよくわかりません。。。
                    $text = str_replace("_", " ", $text);
                    preg_match_all("/=([a-f0-9]{2})/i", $text, $matches);
                    foreach ($matches[1] as $value) {
                        $text = str_replace("=" . $value, chr(hexdec($value)), $text);
                    }
                    break;
            }

            $text = $this->_convertEncoding($text, $charset);

            // 対象文字列をデコード文字列と置換
            $input = str_replace($encoded, $text, $input);
        }

        return $input;
    }

    /**
     * _parseHeaderValueメソッド
     *
     * Content-Type･Content-Disposition･Content-Transfer-Encodingなどの付加パラメータの解析
     *
     * @param  string $input  Content-Typeなどの値 例:text/plain; charset=iso-2022-jp
     * @return array  $return 連想配列の「value」にそのheaderの値、「other」に付加された文字列の名前と値の配列
     */
    protected function _parseHeaderValue($input) {
        // 区切りの「;」の位置を取得(含まれていたら「other」あり？)
        $pos = strpos($input, ";");

        if ($pos !== false) {
            // 「;」より前部分はheaderの値
            $return["value"] = trim(substr($input, 0, $pos));

            // 「;」よりさらに後ろを分解
            $input = trim(substr($input, $pos + 1));
            if (strlen($input) > 0) {
                // 「"」で括られている(boundaryなど)、                  [^;'\"]*['\"]([^'\"]*([^'\"]*)*)['\"][^;'\"]*
                // または括られていないもの(charset=iso-2022-jpなど)、  ([^;]+)
                // 末尾は「;」またはそのまま終わりにマッチ              (;|$)
                $splitRegex = "/([^;'\"]*['\"]([^'\"]*([^'\"]*)*)['\"][^;'\"]*|([^;]+))(;|$)/";
                $matches = array();
                preg_match_all($splitRegex, $input, $matches);

                $parameters = array();
                for ($i=0; $i<count($matches[0]); $i++) {
                    $param = $matches[0][$i];
                    // 1行あたりに付加できる値は252文字まで。252文字以上の場合は「\;」で複数行指定可能らしいです。
                    while (substr($param, -2) == "\;") {
                        // なので「\;」で終わっていたら、それ以降を同じ値と見なし追加
                        $param .= $matches[0][++$i];
                    }
                    $parameters[] = $param;
                }

                // 付加パラメータ(ohter)をさらに名前と値に分割
                for ($i = 0; $i < count($parameters); $i++) {
                    // 「=」区切り
                    $pos = strpos($parameters[$i], "=");

                    // 不要なクォーテーション・セミコロン・タブ・バックスラッシュ・スペースを排除
                    $paramName  = trim(substr($parameters[$i], 0, $pos), "'\";\t\\ ");
                    $paramValue = substr($parameters[$i], $pos + 1);
                    $paramValue = trim(str_replace("\;", ";", $paramValue), "'\";\t\\ ");

                    // 「"」で2重に括られていたら前後1文字ずつ排除
                    if ($paramValue[0] == '"') {
                        $paramValue = substr($paramValue, 1, -1);
                    }

                    // 名前は小文字で
                    $paramName = strtolower($paramName);
                    $return["other"][$paramName] = $paramValue;
                }
            }
        } else {
            // 「;」なしなので、headerの値のみ返す
            $return["value"] = trim($input);
        }

        return $return;
    }

    /**
     * _decodeBodyメソッド
     *
     * ボディをデコードする
     *
     * @param  string $input    ボディ
     * @param  string $encoding エンコーディング
     * @param  string $charset  キャラクターセット
     * @return string $input    デコードされたボディ
     */
    protected function _decodeBody($input, $encoding = "7bit", $charset = "") {
        switch (strtolower($encoding)) {
            case "7bit":
                break;
            case "quoted-printable":
                $input = $this->_quotedPrintableDecode($input);
                break;
            case "base64":
                $input = base64_decode($input);
                break;
            default:
                break;
        }

        $input = $this->_convertEncoding($input, $charset);

        return $input;
    }

    /**
     * _quotedPrintableDecodeメソッド
     *
     * quoted-printableデコードする
     *
     * @param  string $input デコードする値
     * @return string $input デコードされた値
     */
    protected function _quotedPrintableDecode($input) {
        // Remove soft line breaks
        $input = preg_replace("/=\r?\n/", "", $input);

        // Replace encoded characters
        $input = preg_replace("/=([a-f0-9]{2})/ie", "chr(hexdec('\\1'))", $input);
        return $input;
    }

    /**
     * _convertEncodingメソッド
     *
     * 文字コード変換
     *
     * @param  string $input エンコードする値
     * @return string $input エンコードされた値
     */
    protected function _convertEncoding($input, $charset) {
        if (!$charset) {
            return $input;
        }

        $encoding = "";
        switch (strtolower($charset)) {
            // iso-2022-jpでもイケた気がするが、一応JISで。
            case "iso-2022-jp":
                $encoding = "JIS";
                break;
            // 絵文字が取れるかも？
            case "shift_jis":
                $encoding = "sjis-win";
                break;
            case "euc-jp":
                $encoding = "eucjp-win";
                break;
            default:
                $encoding = $charset;
                break;
        }

        $internal = mb_internal_encoding();
        $input = mb_convert_encoding($input, $internal, $encoding);
        return $input;
    }
}
?>