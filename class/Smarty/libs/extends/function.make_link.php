<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty {make_link} function plugin
 *
 * Type:     function
 * Name:     make_link
 * リンクURLの作成
 *
 * Examples:{make_link action="action_*****_*****" getTags=$getTag(引数)}
 * @param array
 * @param Smarty
 * @return string|null
 */
function smarty_function_make_link($params, &$smarty)
{
        $linkString = "./";
        if ($params["action"]) {
            $linkString .= "?" . $params["action"] . "=1";
            if ($params["getTags"]) {
                $linkString .= "&" . $params["getTags"];
            }
        } else {
            if ($params["getTags"]) {
                $linkString .= "?" . $params["getTags"];
            }
        }
        return $linkString;
}

?>
