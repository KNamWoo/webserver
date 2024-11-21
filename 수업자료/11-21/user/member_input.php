<?php
    $irum = $_POST['irum'];
    $id = $_POST['id'];
    $nicname = $_POST['nicname'];
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];
    $regdate = $_POST['regdate'];

    $connect = mysqli_connect("localhost", "root", "");     
    if (!$connect) {
        die("데이터베이스 연결 실패");
    }

    mysqli_select_db($connect, "sample");

    // 문자셋을 UTF-8로 설정
    mysqli_query($connect, 'set names utf8'); // 데이터 연결을 받아야 함

    $inrec = "INSERT INTO member VALUES('$irum', '$id', '$nicname', '$email', '$pwd', '$regdate')";
    $info = mysqli_query($connect, $inrec);

    if (!$info) {
        die("회원가입 실패");
    }

    echo "회원가입이 완료되었습니다.";

    mysqli_close($connect);
?>
<a href="login.html">처음으로 이동</a>
