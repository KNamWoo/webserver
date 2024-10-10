<?php
    function result_form(){
        echo "<br> result =======>";
    }
    $sum = 0;
    for ($i=1; $i <= 100; $i++) { 
        $sum += $i;
        if($i%10 == 0){
            result_form();
            echo "$i 까지 합 $sum";
        }
    }
?>