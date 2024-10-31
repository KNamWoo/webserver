<?php
    $a = file_exists("addr.txt");
    if (!$a) {
        echo "원하는 파일이 존재하지 않습니다.";
    }else {
        echo "파일이 존재합니다.";
    }
?>