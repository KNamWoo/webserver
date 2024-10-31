<?php
    $a=file_exists("addr.txt");
    if(!$a){
        echo "원하는 파일이 존재하지 않습니다.";
        exit;
    }
    $fi=fopen("addr.txt","r");

    $a=fread($fi,filesize("addr.txt"));
    print $a ."<br>";

    fclose($fi);
?>
