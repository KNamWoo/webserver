<?php
    $a = $_GET["town"];
    $b = $_GET["money"];
    $c = $_GET["rentpay"];
    $tot = $b + ($c * 100);
    echo "<h1>귀하의 환산보증금은 ".number_format($tot)."원입니다.</h1>";
    if ($a == "서울" and $tot <= 240000000) {
        echo "서울지역 환산보증금은 ".number_format($tot)."원으로 <p>";
        echo "소액임차인 대상입니다.";
    }elseif ($a == "과밀억제" and $tot <= 190000000) {
        echo "과밀억제지역 환산보증금은 ".number_format($tot)."원으로 <p>";
        echo "소액임차인 대상입니다.";
    }else{
        echo "소액임차인 대상이 아닙니다.";
    }
?>