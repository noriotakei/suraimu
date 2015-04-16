<?php
/**
 * ComMime.php
 *
 * MimeType配列クラス
 *
 * @author    mitsuhiro_nakamura
 * @since     2009/08/11
 */

/**
 * ComMime
 *
 * @author  mitsuhiro_nakamura
 * @version 1.0
 */

class ComMime {
    /** @var array 拡張子をキーにしたMimeType配列 */
    public static $mimeType = array(
        "gif"  => "image/gif",
        "jpg"  => "image/jpeg",
        "jpeg" => "image/jpeg",
        "jpe"  => "image/jpeg",
        "bmp"  => "image/bmp",
        "png"  => "image/png",
        "tif"  => "image/tiff",
        "tiff" => "image/tiff",
        "swf"  => "application/x-shockwave-flash",
        "doc"  => "application/msword",
        "xls"  => "application/vnd.ms-excel",
        "ppt"  => "application/vnd.ms-powerpoint",
        "pdf"  => "application/pdf",
        "ps"   => "application/postscript",
        "eps"  => "application/postscript",
        "rtf"  => "application/rtf",
        "bz2"  => "application/x-bzip2",
        "gz"   => "application/x-gzip",
        "tgz"  => "application/x-gzip",
        "tar"  => "application/x-tar",
        "zip"  => "application/zip",
        "html" => "text/html",
        "htm"  => "text/html",
        "txt"  => "text/plain",
        "css"  => "text/css",
        "js"   => "text/javascript",
        "xml"  => "text/xml"
    );
}
?>
