<?php
    $price = array(3000, 3500, 4500, 3900);
    $tot = 0;
    $cnt = count($price);
    for($i=0; $i<$cnt; $i++){
        $tot += $price[$i];
    }
    echo "커피 평균 판매가 = ".number_format($tot/4);
    echo "<p>커피 평균 판매가 : ".number_format($tot/$cnt);
?>