<?php
/*
$to = "鳥山員也<ayuzak.777@docomo.ne.jp>" ;
//$to = "\"yone-pa-cino@docomo.ne.jp\"<yone-pa-cino@docomo.ne.jp>" ;
//$to = "ayuzak.777@docomo.ne.jp" ;

$to = ereg_replace("/^[ぁ-んァ-ヶー一-龠]+$/u", "", $to);



print $to ;
*/

$pc_address = "test" ;
$payType = 3 ;

if ($pc_address AND ($payType != 1 and $payType != 10)) {

print "表示" ;
}
?>