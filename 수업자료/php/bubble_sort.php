<?php
    $num = array(15, 13, 9, 7, 6, 12, 19, 30, 28, 26);

    $count = 10;

    echo "정렬 전 : ";
    for ($a=0; $a < 10; $a++) { 
        echo $num[$a]." ";
    }
    echo "<br>";

    for ($i=$count-2; $i>=0; $i--) { 
        for ($j=0; $j<=$i; $j++) { 
            if ($num[$j]>$num[$j+1]) {
                $tmp = $num[$j];
                $num[$j] = $num[$j+1];
                $num[$j+1] = $tmp;
            }
        }
    }

    echo "버블 정렬 (오름차순) 후 : ";
    for ($a=0; $a<10; $a++) { 
        echo $num[$a]." ";
    }
    echo "<br>";

    for ($i=$count-1; $i>=0; $i--) { 
        for ($j=0; $j<$i; $j++) { 
            if($num[$j+1]>$num[$j]){
                $tmp = $num[$j];
                $num[$j] = $num[$j+1];
                $num[$j+1] = $tmp;
            }
        }
    }

    echo "버블 정렬 (내림차순) 후 : ";
    for ($a=0; $a<10; $a++) { 
        echo $num[$a]." ";
    }
?>