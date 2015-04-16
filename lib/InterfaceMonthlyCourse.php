<?php
/**
 * InterfaceMonthlyCourse.php
 *
 * Copyright (c) 2010 Fraise, Inc.
 * All rights reserved.
 */

/**
 * 月額コースクラスインターフェース。
 *
 * @copyright   2010 Fraise, Inc.
 * @author      norihisa ohnami
 */
interface InterfaceMonthlyCourse {

    // 更新タイプ
    const COURSE_TYPE_NEW     = 1;  // '新規'
    const COURSE_TYPE_UPDATE  = 2;  // '更新'

    // 商品購入時(支払い手続き時)のデバイスタイプ(PC or MB or どちらか)。
    // 決済戻り値の「clientip」から判断する。
    const DEVICE_TYPE_PC     = 1;  // 'PC'
    const DEVICE_TYPE_MB     = 2;  // 'MB'
    const DEVICE_TYPE_EITHER = 3;  // 'どちらか'

}

?>