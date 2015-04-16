<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty {emoji} modifier plugin
 *
 * Type:     modifier
 * Name:     emoji
 * 絵文字変換
 *
 * Examples:{$data|emoji}
 * i絵文字のshift-jisで入力
 * @param array
 * @param Smarty
 * @return string|null
 */
function smarty_modifier_emoji($data)
{
        $ComEmojiOBJ = ComEmoji::getInstance();

        // 他キャリアの絵文字を変換する際、半角カナを用いるよう設定
        $ComEmojiOBJ->useHalfwidthKatakana();

        // キャリア用に変換
        $data = $ComEmojiOBJ->convertCarrier($data);

        return $data;
}

?>
