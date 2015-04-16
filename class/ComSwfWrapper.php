<?php
/**
 * ComSwfWrapper.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * swfファイルwrapper処理を行うクラス。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      Mitsuhiro Nakamura
 */

class ComSwfWrapper {

    /**
     * swfのバイナリを作成する。
     *
     *
     * @param  stirng $file ファイル名
     * @param  array $item 引数配列
     *
     * @return binary swfバイナリ
     */

    public static function swfWrapper($file,$item){
        $tags   = self::buildTags($item);
        $src    = file_get_contents($file);
        $i  = (ord($src[8])>>1)+5;
        $length = ceil((((8-($i&7))&7)+$i)/8)+17;
        $head   = substr($src,0,$length);
        return(
            substr($head,0,4).
            pack("V",strlen($src)+strlen($tags)).
            substr($head,8).
            $tags.
            substr($src,$length)
        );
    }

    /**
     * swfのヘッダータグを作成する。
     *
     *
     * @param  array $item 引数配列
     *
     * @return string ヘッダータグ
     */

    public function buildTags($item){
        $tags = array();
        foreach($item as $k => $v){
            array_push( $tags, sprintf(
                "\x96%s\x00%s\x00\x96%s\x00%s\x00\x1d",
                pack("v",strlen($k)+2), $k,
                pack("v",strlen($v)+2), $v
            ));
        }
        $s = implode('',$tags);
        return(sprintf(
            "\x3f\x03%s%s\x00",
            pack("V",strlen($s)+1),
            $s
        ));
    }
}

?>
