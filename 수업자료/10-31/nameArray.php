<?php
    $data = file("name.txt");

    foreach ($data as $name) {
        print "Name : ".$name."<br>";
    }
?>