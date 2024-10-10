<?php
    $hours = gmdate("h");
    $min = gmdate("m");
    $info = getdate();
    echo "현재시간 ".$info['hours']."시 ".$info['minutes']."<br> ";
    echo "표준시간 ".$hours."시 ".$min."<br>";
?>