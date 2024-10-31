<?php
    $fileinfo = "addr.txt";
    $content = file($fileinfo);
    unset($content[0]);
    $content = array_values($content);
    file_put_contents($fileinfo, implode($content));
    echo "1개의 레코드가 삭제 되었습니다.";
?>