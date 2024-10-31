<?php
    $filep = fopen("./logfile.txt", "a");
    if (!$filep) {
        die("파일을 열 수 없습니다.");
    }
    $time = date("Y-m-d H:i:s", time());
    fputs($filep, $time);

    fclose($filep);

    print "logfile 생성 connect service";
?>