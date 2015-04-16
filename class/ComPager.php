<?php
/**
 * ComPager.php
 *
 * Copyright (c) 2009 Fraise, Inc.
 * All rights reserved.
 */

/**
 * ページング処理を行うクラス。
 *
 * @copyright   2009 Fraise, Inc.
 * @author      Mitsuhiro Nakamura
 */

class ComPager {

    /**
     * ページリンクを取得する。
     *
     * ページリンク設定配列：
     * "total_count"      => 全データ件数
     * "offset"           => オフセット値
     * "disp_count"       => 1ページ表示件数
     * "link_count"       => ページ番号リンク数※
     * "action_name"      => リンク先ページアクション名※
     * "offset_name"      => オフセットのパラメータキー名※
     * "previous_name"    => 前ページリンク名※
     * "next_name"        => 次ページリンク名※
     * "additional_param" => 追加パラメータ※
     *
     * ※の項目は省略可能
     *
     * @param  array $pagerArray ページリンク設定配列
     * @return mixed ページリンク配列
     */
    public static function getLink($pagerArray) {

        if (!is_array($pagerArray)) {
            return false;
        }

        if (!is_numeric($pagerArray["total_count"]) ||
                !is_numeric($pagerArray["offset"]) || !is_numeric($pagerArray["disp_count"])) {
            return false;
        }

        // デフォルトのページ番号リンク数は10
        if (!is_numeric($pagerArray["link_count"])) {
            $pagerArray["link_count"] = 10;
        }

        // デフォルトのアクション名は現在ページ
        if (!$pagerArray["action_name"]) {

            $requestOBJ = ComRequest::getInstance();
            $actionName = $requestOBJ->getActionName();

            if ($actionName) {
                $pagerArray["action_name"] = $actionName;
            } else {
                $pagerArray["action_name"] = "index";
            }
        }

        // デフォルトのオフセットのパラメータキー名はoffset
        if (!$pagerArray["offset_name"]) {
            $pagerArray["offset_name"] = "offset";
        }

        // デフォルトの前ページリンク名はprev
        if (!$pagerArray["previous_name"]) {
            $pagerArray["previous_name"] = "prev";
        }

        // デフォルトの次ページリンク名はnext
        if (!$pagerArray["next_name"]) {
            $pagerArray["next_name"] = "next";
        }

        // デフォルトの次ページリンク名はhome
        if (!$pagerArray["home_name"]) {
            $pagerArray["home_name"] = "home";
        }

        // 件数を0から数えるのでマイナス1
        $pagerArray["total_count"]--;

        // 全ページ数
        $totalPage = (int) ($pagerArray["total_count"] / $pagerArray["disp_count"]) + 1;
        // 現在表示中のページ
        $currentPage = (int) ($pagerArray["offset"] / $pagerArray["disp_count"]) + 1;
        // リンクの先頭ページ
        $startPage = (int) ($pagerArray["offset"] / ($pagerArray["disp_count"] * $pagerArray["link_count"])) * $pagerArray["link_count"];
        $startPage++;
        // リンクの終端ページ
        $endPage = $startPage + ($pagerArray["link_count"] - 1);
        if ($totalPage < $endPage) {
            $endPage = $totalPage;
        }

        // 前のページに一気に移動するリンクを作る
        if ($startPage != 1) {
            $linkArray["pages"][] .= "<a href=\"./?action_" . $pagerArray["action_name"]
                                  . "&".$pagerArray["offset_name"]."=".(($startPage - 2) * $pagerArray["disp_count"]).$pagerArray["additional_param"]."\">"
                                  . "～".($startPage - 1)."</a>\n";
        }

        // ページ番号リンクを1ページ分ずつ作る
        for ($i = $startPage; $i <= $endPage; $i++) {
            $offset = ($i - 1) * $pagerArray["disp_count"];

            // 表示中のページでなければリンク作成
            if ($i != $currentPage) {
                $linkArray["pages"][] .= "<a href=\"./?action_" . $pagerArray["action_name"]
                                      . "&".$pagerArray["offset_name"]."=".$offset.$pagerArray["additional_param"]."\" title=\"".$i."\">".$i."</a>";
            // 表示中のページならただの数字
            } else {
                $linkArray["pages"][] = "<strong>".$i."</strong>";
            }
        }

        // 次のページに一気に移動するリンクを作る
        if ($endPage < $totalPage) {
            $linkArray["pages"][] .= "<a href=\"./?action_" . $pagerArray["action_name"]
                                  . "&".$pagerArray["offset_name"]."=".($endPage * $pagerArray["disp_count"]).$pagerArray["additional_param"]."\">"
                                  . "".($endPage + 1)."～</a>\n";
        }


        // 前のページへリンク
        $linkArray["previous"] = "";
        if ($currentPage != 1) {
            $linkArray["previous"] .= "<a href=\"./?action_" . $pagerArray["action_name"];
            $linkArray["previous"] .= "&".$pagerArray["offset_name"]."=".(($currentPage - 2) * $pagerArray["disp_count"]).$pagerArray["additional_param"]."\" accesskey=\"4\">";
            $linkArray["previous"] .= $pagerArray["previous_name"]."</a>";
        }

        // 次のページへリンク
        $linkArray["next"] = "";
        if ($currentPage < $totalPage) {
            $linkArray["next"] .= "<a href=\"./?action_" . $pagerArray["action_name"];
            $linkArray["next"] .= "&".$pagerArray["offset_name"]."=".($currentPage * $pagerArray["disp_count"]).$pagerArray["additional_param"]."\" accesskey=\"6\">";
            $linkArray["next"] .= $pagerArray["next_name"]."</a>";
        }

        if($pagerArray["show_home"] && (!$pagerArray["last_link"] || ($currentPage >= $totalPage))) {
            $linkArray["home"] = "<a href=\"{$pagerArray["show_home"]}\">{$pagerArray["home_name"]}</a>";
        }

        return $linkArray;
    }
}

?>
