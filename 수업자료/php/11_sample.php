<?php
    $person['irum'] = "홍길동";
    $person['email'] = "baba99@intizen.com";
    $person['age'] = 99;
    extract($person);
    echo "이름 : $irum <br>";
    echo "이메일 : $email <br>";
    echo "나이 : $age";
?>