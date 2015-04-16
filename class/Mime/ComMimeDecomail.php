<?php
/**
 * Mime_ComMimeDecomail.php
 *
 * デコメール用にヘッダとcidを生成するメソッドを
 * オーバーライドしました。
 *
 * @author  mitsuhiro_nakamura
 * @version 2009/08/11
 */

/**
 * Mime_ComMimeDecomail
 *
 * @author  mitsuhiro_nakamura
 * @version 1.0
 */

class Mime_ComMimeDecomail extends Mime_ComMimeMail {
    /**
     * _buildBodyメソッド
     *
     * 解析した送信フォーマットに対応したメールボディを生成する
     *
     * @return boolean メールボディ生成に成功したらtrue、失敗したらfalseを返す
     */
    public function _buildBody() {
        $this->_body = "";
        switch ($this->_parseElements()) {
            // text(テキストパートのみ)
            case parent::TYPE_TEXT_PART:
                $this->_buildHeader("Content-Type: text/plain; charset=\"" . $this->_charset . "\"");
                $this->_body .= $this->_text;
                break;
            // text＆html(テキストパートとHTMLパート)
            case parent::TYPE_TEXT_PART + parent::TYPE_HTML_PART:
                $this->_buildHeader("Content-Type: multipart/alternative; boundary=\"" . $this->_boundaryAlt . "\"");
                $this->_body .= "--" . $this->_boundaryAlt . $this->EOL;
                $this->_body .= "Content-Type: text/plain; charset=\"" . $this->_charset . "\"" . $this->EOL;
                $this->_body .= "Content-Transfer-Encoding: 7bit" . $this->EOL . $this->EOL;
                $this->_body .= $this->_text . $this->EOL . $this->EOL;
                $this->_body .= "--" . $this->_boundaryAlt . $this->EOL;
                $this->_body .= "Content-Type: text/html; charset=\"" . $this->_charset . "\"" . $this->EOL;
                $this->_body .= "Content-Transfer-Encoding: 7bit" . $this->EOL . $this->EOL;
                $this->_body .= $this->_html . $this->EOL . $this->EOL;
                $this->_body .= "--" . $this->_boundaryAlt . "--" . $this->EOL;
                break;
            // text＆attachment(テキストパートと添付ファイル)
            case parent::TYPE_TEXT_PART + parent::TYPE_ATTACHMENT_PART:
                $this->_buildHeader("Content-Type: multipart/mixed; boundary=\"" . $this->_boundaryMix . "\"");
                $this->_body .= "--" . $this->_boundaryMix . $this->EOL;
                $this->_body .= "Content-Type: text/plain; charset=\"" . $this->_charset . "\"" . $this->EOL;
                $this->_body .= "Content-Transfer-Encoding: 7bit" . $this->EOL . $this->EOL;
                $this->_body .= $this->_text . $this->EOL . $this->EOL;
                foreach ($this->_attachments as $value) {
                    $this->_body .= "--" . $this->_boundaryMix . $this->EOL;
                    $this->_body .= "Content-Type: " . $value["type"] . "; name=\"" . $value["name"] . "\"" . $this->EOL;
                    $this->_body .= "Content-Disposition: attachment; filename=\"" . $value["name"] . "\"" . $this->EOL;
                    $this->_body .= "Content-Transfer-Encoding: base64" . $this->EOL . $this->EOL;
                    $this->_body .= $value["content"] . $this->EOL . $this->EOL;
                }
                $this->_body .= "--" . $this->_boundaryMix . "--" . $this->EOL;
                break;
            // text＆html＆attachment(テキストパートとHTMLパートと添付ファイル)
            case parent::TYPE_TEXT_PART + parent::TYPE_HTML_PART + parent::TYPE_ATTACHMENT_PART:
                $this->_buildHeader("Content-Type: multipart/mixed; boundary=\"" . $this->_boundaryMix . "\"");
                $this->_body .= "--" . $this->_boundaryMix . $this->EOL;
                $this->_body .= "Content-Type: multipart/alternative; boundary=\"" . $this->_boundaryAlt . "\"" . $this->EOL . $this->EOL;
                $this->_body .= "--" . $this->_boundaryAlt . $this->EOL;
                $this->_body .= "Content-Type: text/plain; charset=\"" . $this->_charset . "\"" . $this->EOL;
                $this->_body .= "Content-Transfer-Encoding: 7bit" . $this->EOL . $this->EOL;
                $this->_body .= $this->_text . $this->EOL . $this->EOL;
                $this->_body .= "--" . $this->_boundaryAlt . $this->EOL;
                $this->_body .= "Content-Type: text/html; charset=\"" . $this->_charset . "\"" . $this->EOL;
                $this->_body .= "Content-Transfer-Encoding: 7bit" . $this->EOL . $this->EOL;
                $this->_body .= $this->_html . $this->EOL . $this->EOL;
                $this->_body .= "--" . $this->_boundaryAlt . "--" . $this->EOL . $this->EOL;
                foreach ($this->_attachments as $value) {
                    $this->_body .= "--" . $this->_boundaryMix . $this->EOL;
                    $this->_body .= "Content-Type: " . $value["type"] . "; name=\"" . $value["name"] . "\"" . $this->EOL;
                    $this->_body .= "Content-Disposition: attachment; filename=\"" . $value["name"] . "\"" . $this->EOL;
                    $this->_body .= "Content-Transfer-Encoding: base64" . $this->EOL . $this->EOL;
                    $this->_body .= $value["content"] . $this->EOL . $this->EOL;
                }
                $this->_body .= "--" . $this->_boundaryMix . "--" . $this->EOL;
                break;
            // text＆html＆inlineImage(テキストパートとHTMLパートとインライン画像)
            case parent::TYPE_TEXT_PART + parent::TYPE_HTML_PART + parent::TYPE_ATTACHMENT_IMAGE_PART:
                //$this->_buildHeader("Content-Type: multipart/related; type=\"multipart/alternative\"; boundary=\"" . $this->_boundaryRel . "\"");
                $this->_buildHeader("Content-Type: multipart/related; boundary=\"" . $this->_boundaryRel . "\"");
                $this->_body .= "--" . $this->_boundaryRel . $this->EOL;
                $this->_body .= "Content-Type: multipart/alternative; boundary=\"" . $this->_boundaryAlt . "\"" . $this->EOL . $this->EOL;
                $this->_body .= "--" . $this->_boundaryAlt . $this->EOL;
                $this->_body .= "Content-Type: text/plain; charset=\"" . $this->_charset . "\"" . $this->EOL;
                $this->_body .= "Content-Transfer-Encoding: 7bit" . $this->EOL . $this->EOL;
                $this->_body .= $this->_text . $this->EOL . $this->EOL;
                $this->_body .= "--" . $this->_boundaryAlt . $this->EOL;
                $this->_body .= "Content-Type: text/html; charset=\"" . $this->_charset . "\"" . $this->EOL;
                $this->_body .= "Content-Transfer-Encoding: 7bit" . $this->EOL . $this->EOL;
                $this->_body .= $this->_html . $this->EOL . $this->EOL;
                $this->_body .= "--" . $this->_boundaryAlt . "--" . $this->EOL . $this->EOL;
                foreach ($this->_attachments as $value) {
                    if ($value["embedded"]) {
                        $this->_body .= "--" . $this->_boundaryRel . $this->EOL;
                        $this->_body .= "Content-ID: <" . $value["embedded"] . ">" . $this->EOL;
                        $this->_body .= "Content-Type: " . $value["type"] . "; name=\"" . $value["name"] . "\"" . $this->EOL;
                        // デコメール対応のため、Content-Dispositionはコメントアウト
                        //$this->_body .= "Content-Disposition: attachment; filename=\"" . $value["name"] . "\"" . $this->EOL;
                        $this->_body .= "Content-Transfer-Encoding: base64" . $this->EOL . $this->EOL;
                        $this->_body .= $value["content"] . $this->EOL . $this->EOL;
                    }
                }
                $this->_body .= "--" . $this->_boundaryRel . "--" . $this->EOL;
                break;
            // text＆html＆attachment＆inlineImage(テキストパートとHTMLパートと添付ファイルとインライン画像)
            case parent::TYPE_TEXT_PART + parent::TYPE_HTML_PART + parent::TYPE_ATTACHMENT_PART + parent::TYPE_ATTACHMENT_IMAGE_PART:
                $this->_buildHeader("Content-Type: multipart/mixed; boundary=\"" . $this->_boundaryMix . "\"");
                $this->_body .= "--" . $this->_boundaryMix . $this->EOL;
                $this->_body .= "Content-Type: multipart/related; type=\"multipart/alternative\"; boundary=\"" . $this->_boundaryRel . "\"" . $this->EOL . $this->EOL;
                $this->_body .= "--" . $this->_boundaryRel . $this->EOL;
                $this->_body .= "Content-Type: multipart/alternative; boundary=\"" . $this->_boundaryAlt . "\"" . $this->EOL . $this->EOL;
                $this->_body .= "--" . $this->_boundaryAlt . $this->EOL;
                $this->_body .= "Content-Type: text/plain; charset=\"" . $this->_charset . "\"" . $this->EOL;
                $this->_body .= "Content-Transfer-Encoding: 7bit" . $this->EOL . $this->EOL;
                $this->_body .= $this->_text . $this->EOL . $this->EOL;
                $this->_body .= "--" . $this->_boundaryAlt . $this->EOL;
                $this->_body .= "Content-Type: text/html; charset=\"" . $this->_charset . "\"" . $this->EOL;
                $this->_body .= "Content-Transfer-Encoding: 7bit" . $this->EOL . $this->EOL;
                $this->_body .= $this->_html . $this->EOL . $this->EOL;
                $this->_body .= "--" . $this->_boundaryAlt . "--" . $this->EOL . $this->EOL;
                foreach ($this->_attachments as $value) {
                    if ($value["embedded"]) {
                        $this->_body .= "--" . $this->_boundaryRel . $this->EOL;
                        $this->_body .= "Content-ID: <" . $value["embedded"] . ">" . $this->EOL;
                        $this->_body .= "Content-Type: " . $value["type"] . "; name=\"" . $value["name"] . "\"" . $this->EOL;
                        $this->_body .= "Content-Disposition: attachment; filename=\"" . $value["name"] . "\"" . $this->EOL;
                        $this->_body .= "Content-Transfer-Encoding: base64" . $this->EOL . $this->EOL;
                        $this->_body .= $value["content"] . $this->EOL . $this->EOL;
                    }
                }
                $this->_body .= "--" . $this->_boundaryRel . "--" . $this->EOL . $this->EOL;
                foreach ($this->_attachments as $value) {
                    if (!$value["embedded"]) {
                        $this->_body .= "--" . $this->_boundaryMix . $this->EOL;
                        $this->_body .= "Content-Type: " . $value["type"] . "; name=\"" . $value["name"] . "\"" . $this->EOL;
                        $this->_body .= "Content-Disposition: attachment; filename=\"" . $value["name"] . "\"" . $this->EOL;
                        $this->_body .= "Content-Transfer-Encoding: base64" . $this->EOL . $this->EOL;
                        $this->_body .= $value["content"] . $this->EOL . $this->EOL;
                    }
                }
                $this->_body .= "--" . $this->_boundaryMix . "--" . $this->EOL;
                break;
            default:
                throw new ComMimeException(__FILE__ . ":" . __LINE__ . "Body Build Incomplete");
        }

        $this->_sendedIndex++;
        return true;
    }

    /**
     * _searchImagesメソッド
     *
     * 添付ファイルにImageが存在するか走査し、
     * 見つかった場合、HTMLデータ内で使用可能なデータを生成する
     * ※cidの付け方が通常のメールと異なります(auで「@」が必須)
     *   <img src="cid:***@+++++++">    *** ⇒ [001]～[999] +++++++ ⇒ 日時
     *
     * @return void
     */
    protected function _searchImages(){
        if ($this->_attachmentsIndex != 0) {
            foreach($this->_attachments as $key => $value) {
                $imgId = substr($value["name"], 0, strrpos($value["name"], "."));
                if (preg_match('/(css|image)/i', $value["type"]) &&
                    preg_match('/\s(background|href|src)\s*=\s*[\"|\'](' . $imgId . ')[\"|\'].*>/is', $this->_html)) {
                    $contentId = $imgId . "@" . date("ymd.His");
                    $this->_html = preg_replace(
                                    '/\s(background|href|src)\s*=\s*[\"|\'](?:(?:cid:)?' . $imgId . ')[\"|\']/is',
                                    ' \\1="cid:' . $contentId . '"',
                                    $this->_html);
                    $this->_attachments[$key]["embedded"] = $contentId;
                    $this->_attachmentsImg[] = $value["name"];
                }
            }
        }
    }
}
?>