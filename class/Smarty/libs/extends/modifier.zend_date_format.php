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
 * Name:     date_format
 * 日付フォーマット
 *
 * Examples:{$data|date_format:'YYYY-mm-dd'}
 * @param string $data
 * @param string $format
 *
 * @return string|null
 */
function smarty_modifier_zend_date_format($data, $format = "yyyy-MM-dd")
{
        if (!ComValidation::isDatetime($data) AND !ComValidation::isDate($data)) {
            return "";
        }
        $date = new ComDate($data);
        // 日付をフォーマット
        $data = $date->toString($format);
        return $data;
}

?>
