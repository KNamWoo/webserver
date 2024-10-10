<?php
    $y = 1995;
    $m = 05;
    $d = 10;
    $birth = mktime(0,0,0,$m,$d,$y);
    $current = time();
    echo $birth."<br>";
    echo $current."<br>";
    $subdiff = $current - $birth;

    $age = floor($subdiff/(365*24*60*60));
    echo "당신의 나이는 $age 입니다.";