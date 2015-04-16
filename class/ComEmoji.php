<?php

/**
 * Convert emoji of mobile phones.
 *
 * PHP versions 4 and 5
 *
 * Copyright (c) 2009 revulo
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to
 * deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 *
 * @category   HTML
 * @package    ComEmoji
 * @author     revulo <revulon@gmail.com>
 * @copyright  2009 revulo
 * @license    http://www.opensource.org/licenses/mit-license.php  MIT License
 * @version    Release: 0.7
 * @link       http://www.revulo.com/PHP/library/HTML_Emoji.html
 */

/**
 * ComEmoji
 *
 * This class manages emoji binary string and provides the following functions:
 *
 *  - Convert an emoji of other carriers to its alternative.
 *  - Convert character encoding of emoji between UTF-8 and Shift_JIS.
 *
 * @category   HTML
 * @package    ComEmoji
 * @author     revulo <revulon@gmail.com>
 * @copyright  2009 revulo
 * @license    http://www.opensource.org/licenses/mit-license.php  MIT License
 * @version    Release: 0.7
 * @link       http://www.revulo.com/PHP/library/HTML_Emoji.html
 */
class ComEmoji
{
    /**
     * Carrier name
     * @var    string
     */
    var $_carrier = '';

    /**
     * Regular expression of UTF-8 code area of emojis
     * @var    string
     */
    var $_regexOthers = '/\xEE[\x80-\xBF][\x80-\xBF]|\xEF[\x81-\x83][\x80-\xBF]/';

    /**
     * Regular expression of SJIS code area of emojis
     * @var    string
     */
    var $_regexOthersSJIS = '/(\xF8)([\x9F-\xFC])|(\xF9)([\x40-\x49\x50-\x52\x55-\x57\x5B-\x5E\x72-\xFC])|([\xF3\xF6\xF7])([\x40-\xFC])
                                |(\xF4)([\x40-\x8D])|(\xF7)([\x41-\x7E\x80-\x9B\xA1-\xE9\xEA-\xF3])|(\xF9)([\x41-\x7E\x80-\x9B\xA1-\xED])|(\xFB)([\x41-\x7E\x80-\x8D\xA1-\xD7])/';

    /**
     * Emoji translation table
     * @var    array
     */
    var $_translationTable;

     /**
     * Emoji mail translation table
     * @var    array
     */
    var $_mailTranslationTable;

    /**
     * Use half-width katakana
     * @var    boolean
     */
    var $_halfwidthKatakana = false;

    /**
     * Return an ComEmoji_* instance for that carrier.
     *
     * @param  string  $carrier
     * @return ComEmoji_*
     */
    function &getInstance($carrier = null)
    {
        static $instances = array();

        $aliases = array(
            'docomo'   => 'docomo',
            'i-mode'   => 'docomo',
            'imode'    => 'docomo',
            'au'       => 'au',
            'kddi'     => 'au',
            'ezweb'    => 'au',
            'softbank' => 'softbank',
            'disney'   => 'softbank',
            'vodafone' => 'softbank',
            'j-phone'  => 'jphone',
            'jphone'   => 'jphone',
            'willcom'  => 'docomo',
            'emobile'  => 'docomo',
        );

        if (isset($carrier) === false) {
            $carrier = ComEmoji::_detectCarrier();
        }
        $carrier = strtolower($carrier);
        $carrier = isset($aliases[$carrier]) ? $aliases[$carrier] : 'pc';

        if (isset($instances[$carrier]) === false) {
            $class    = 'HTML_Emoji_' . ucfirst($carrier);
            $dirname  = substr(__FILE__, 0, -4);
            $filename = $dirname . '/' . ucfirst($carrier) . '.php';

            require_once $filename;
            $instance = new $class;
            $instance->_carrier  = $carrier;
            $instances[$carrier] = $instance;
        }

        return $instances[$carrier];
    }

    /**
     * Redirect to getInstance() method.
     *
     * @deprecated Since 0.7
     * @param  string  $carrier
     * @return ComEmoji_*
     */
    function &factory($carrier = null)
    {
        trigger_error(__FUNCTION__ . ' is deprecated; use getInstance instead.');
        return ComEmoji::getInstance($carrier);
    }

    /**
     * Set the base URL to image files.
     *
     * @param  string  $url
     */
    function setImageUrl($url)
    {
    }

    /**
     * Redirect to setImageUrl() method.
     *
     * @deprecated Since 0.7
     * @param  string  $url
     */
    function setImagePath($url)
    {
        trigger_error(__FUNCTION__ . ' is deprecated; use setImageUrl instead.');
        $this->setImageUrl($url);
    }

    /**
     * Use half-width katakana.
     *
     * @param  boolean $flag
     */
    function useHalfwidthKatakana($flag = true)
    {
        $this->_halfwidthKatakana = (boolean)$flag;

        if (isset($this->_translationTable) === true) {
            $this->_initTranslationTable();
        }
    }

    /**
     * Convert all UTF-8 emojis of other carriers.
     *
     * @param  string  $text
     * @return string
     */
    function convertCarrier($text)
    {
        $pattern  = $this->_regexOthers;
        $callback = array($this, '_convertCharacter');
        return preg_replace_callback($pattern, $callback, $text);
    }

    /**
     * Mail Convert all UTF-8 emojis of other carriers.
     *
     * @param  string  $text
     * @return string
     */
    function mailConvertCarrier($text)
    {
        if ($this->isSjisCarrier()) {
            // SJIS-winパターン
            $pattern  = $this->_regexOthersSJIS;
        } else {
            // UTF-8パターン
            $pattern  = $this->_regexOthers;
        }
        $callback = array($this, '_mailConvertCharacter');
        return preg_replace_callback($pattern, $callback, $text);
    }

    /**
     * Wrapper function for mb_convert_encoding().
     *
     * @param  string  $text
     * @param  string  $to
     * @param  string  $from
     * @return string
     */
    function convertEncoding($text, $to, $from)
    {
        if (strcasecmp($to, 'SJIS') === 0) {
            $to = 'SJIS-win';
        }
        if (strcasecmp($from, 'SJIS') === 0) {
            $from = 'SJIS-win';
        }
        return mb_convert_encoding($text, $to, $from);
    }

    /**
     * Return true if the user agent is categorized as mobile.
     *
     * @return boolean
     */
    function isMobile()
    {
        return true;
    }

    /**
     * Return true if UTF-8 is a recommended encoding for the carrier.
     *
     * @return boolean
     */
    function isUtf8Carrier()
    {
        $carrier = $this->getCarrier();
        if ($carrier === 'pc' || $carrier === 'softbank') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Return true if Shift_JIS is a recommended encoding for the carrier.
     *
     * @return boolean
     */
    function isSjisCarrier()
    {
        return !$this->isUtf8Carrier();
    }

    /**
     * Return the carrier name.
     *
     * 'docomo', 'au', 'softbank', 'jphone' or 'pc'.
     *
     * @return string
     */
    function getCarrier()
    {
        return $this->_carrier;
    }

    /**
     * Determine a carrier from HTTP_USER_AGENT string.
     *
     * @return string
     */
    function _detectCarrier()
    {
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $userAgent = $_SERVER['HTTP_USER_AGENT'];
            if (preg_match('/^DoCoMo/', $userAgent)) {
                return 'docomo';
            } else if (preg_match('/^KDDI-/', $userAgent)) {
                return 'au';
            } else if (preg_match('/^(?:SoftBank|Vodafone|MOT-)/', $userAgent)) {
                return 'SoftBank';
            } else if (preg_match('/^J-PHONE/', $userAgent)) {
                return 'J-PHONE';
            } else if (preg_match('#^Mozilla/3\.0\((?:WILLCOM|DDIPOCKET);#', $userAgent)) {
                return 'WILLCOM';
            } else if (preg_match('/^(?:emobile|Huawei)/', $userAgent)) {
                return 'EMOBILE';
            }
        }
        return 'PC';
    }

    /**
     * Callback function called by convertCarrier() method.
     *
     * This function converts an emoji to its alternative.
     *
     * @param  array   $matches
     * @return string
     */
    function _convertCharacter($matches)
    {
        if (isset($this->_translationTable) === false) {
            $this->_initTranslationTable();
        }

        $utf8 = $matches[0];
        if (isset($this->_translationTable[$utf8]) === true) {
            return $this->_translationTable[$utf8];
        } else {
            return $utf8;
        }
    }

    /**
     * Read emoji translation table.
     */
    function _initTranslationTable()
    {
        $aliases = array(
            'jphone'  => 'softbank',
            'willcom' => 'docomo',
            'emobile' => 'docomo',
        );

        $carrier = $this->getCarrier();
        if (isset($aliases[$carrier])) {
            $carrier = $aliases[$carrier];
        }

        if ($carrier === 'pc') {
            $filename = 'Image.php';
        } else if ($this->_halfwidthKatakana === true) {
            $filename = 'Halfwidth.php';
        } else {
            $filename = 'Fullwidth.php';
        }

        $dirname = substr(__FILE__, 0, -4) . '/' . ucfirst($carrier);
        $this->_translationTable = include $dirname . '/' . $filename;
    }

    /**
     * Callback function called by mailConvertCarrier() method.
     *
     * This function converts an emoji to its alternative.
     *
     * @param  array   $matches
     * @return string
     */
    function _mailConvertCharacter($matches)
    {
        if (isset($this->_mailTranslationTable) === false) {
            $this->_initMailTranslationTable();
        }

        if ($this->isSjisCarrier()) {
            // SJIS-winで来るのでUTF-8に変換
            $utf8 = mb_convert_encoding($matches[0], "UTF-8", "SJIS-win");
        } else {
            $utf8 = $matches[0];
        }
        if (isset($this->_mailTranslationTable[$utf8]) === true) {
            return $this->_mailTranslationTable[$utf8];
        } else {
            return $matches[0];
        }
    }

    /**
     * Read emoji mail translation table.
     */
    function _initMailTranslationTable()
    {
        $aliases = array(
            'jphone'  => 'softbank',
            'willcom' => 'docomo',
            'emobile' => 'docomo',
        );

        $carrier = $this->getCarrier();
        if (isset($aliases[$carrier])) {
            $carrier = $aliases[$carrier];
        }

        if ($carrier === 'au') {
            $filename = 'Mail.php';
        } else {
            $filename = 'Halfwidth.php';
        }

        $dirname = substr(__FILE__, 0, -4) . '/' . ucfirst($carrier);
        $this->_mailTranslationTable = include $dirname . '/' . $filename;
    }
}
