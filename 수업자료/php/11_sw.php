<?php
    $city = $_POST["city"];
    echo "선택하신 지역은";
    foreach ($city as $cityname) {
        echo "<h1> $cityname </h1>";
    }
?>