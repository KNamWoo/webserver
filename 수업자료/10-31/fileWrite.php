<?php
    $fi = fopen("addr.txt", "a");
    $a = "인천광역시 강화군 강화읍 남산리 184";
    fwrite($fi, $a);// -> fputs 가능
    echo "1건의 주소가 추가되었습니다.";
    fclose($fi);
?>