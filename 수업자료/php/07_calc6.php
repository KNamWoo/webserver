<?php
    $money = $_GET["money"];
    $rentpay = $_GET["rentpay"];
    $tot = $money + ($rentpay * 100);
    
    echo "<h1>귀하의 환산보증금은 $tot 입니다.</h1>";
    if ($tot > 240000000) {
        echo "소액임차인 적용대상이 되지 않습니다.";
    }else if($tot > 190000000){
        echo "서울지역-소액임차인 대상입니다.<br>";
        echo "과밀억제권지역 - 소액임차인 대상이 아닙니다.<br>";
    }
    echo "상가임대차보호법과 관련한 자세한 내용은 질문으로 보내주세요";
?>