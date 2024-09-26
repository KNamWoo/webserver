<?php
    $score[0] = 90;
    $score[1] = 80;
    $score[2] = 85;
    $score[3] = 95;
    $score[4] = 93;

    $sum = 0;
    for ($a=0; $a <= 4; $a++) { 
        $sum += $score[$a];
    }

    $avg = $sum/5;

    echo "과목점수 : $score[0], $score[1], $score[2], $score[3], $score[4]<br>";
    echo "합계 : $sum, 평균 : $avg <br>";
?>