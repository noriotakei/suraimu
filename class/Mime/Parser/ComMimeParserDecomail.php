<?php
/**
 * Mime_Parser_ComMimeParserDecomail.php
 *
デコメフォーマットを解析するクラス
 *
 * @author    mitsuhiro_nakamura
 * @since     2009/08/11
 */

/**
 * Mime_Parser_ComMimeParserDecomail
 *
 * @author  mitsuhiro_nakamura
 * @version 1.0
 */
class Mime_Parser_ComMimeParserDecomail extends Mime_Parser_ComMimeParserMail {
    /**
     * parseHeadersメソッド
     *
     * ヘッダを解析する
     *
     * @param  string $header         ヘッダデータ
     * @return array  $return_headers 配列化されたheader名と値
     */
    protected function _parseHeaders($header) {
        // 「\r\n」形式に統一
        $header = preg_replace("/\r?\n/", "\r\n", $header);
        // 複数行データを1行へ整形
        $header = preg_replace("/\r\n(\t| )+/", ' ', $header);
        // 「\r\n」区切りで配列化
        $headerRows = explode("\r\n", trim($header));

        $returnHeaders = array();

        if (is_array($headerRows)) {
            foreach ($headerRows as $row) {
                // 区切りの「:」の位置を取得
                $pos = strpos($row, ":");

                if ($pos === false) {
                    $headerName  = "decomail-version";
                    $headerValue = $row;
                } else {
                    // header名と値を分割
                    $headerName  = substr($row, 0, $pos);
                    $headerValue = substr($row, $pos + 1);
                }

                // 先頭のスペースを除去
                $headerValue = ($headerValue[0] == " ") ? substr($headerValue, 1) : $headerValue;

                // 署名(名前)付きheaderのdecode
                $headerValue = $this->_decodeHeader($headerValue);

                $matches = array();
                // 署名付き
                if (preg_match("/(.+)[\s]<(.+)>/", $headerValue, $matches)) {
                    $decodeHeaderValue = $matches[1];
                    $headerValue       = $matches[2];

                    // 署名を別名格納 to ⇒ to_name,subject ⇒ subject_name,etc...
                    $decodeHeaderName = $headerName . "_name";

                    // 名前とアドレスを別々に配列化
                    $returnHeaders[] = array("name" => $headerName, "value" => $headerValue);
                    $returnHeaders[] = array("name" => $decodeHeaderName, "value" => $decodeHeaderValue);
                } else {
                    // 配列化
                    $returnHeaders[] = array("name" => $headerName, "value" => $headerValue);
                }
            }
        }

        return $returnHeaders;
    }

    /**
     * splitBodyHeaderメソッド
     *
     * デコメフォーマットデータをヘッダとボディに分割する
     *
     * @param  string $input デコメフォーマットデータ
     * @return array         ヘッダ、ボディ
     */
    protected function _splitBodyHeader($input) {
        // 改行2つ分で分割
        if (preg_match("/^(.*?)\r?\n\r?\n(.*)/s", $input, $match)) {
            // softbank仕様
            if (preg_match("/^(MIME-Version.*?)\r?\n\r?\n(.*)/is", $match[2], $matches)) {
                $header = $match[1] . "\r\n" . $matches[1];
                $body   = $matches[2];
                return array($header, $body);
            } else {
                return array($match[1], $match[2]);
            }
        }

        return false;
    }
}
?>