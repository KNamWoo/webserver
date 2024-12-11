<?php
    //DB 서버접속 연결
    $connect = mysqli_connect('localhost', 'root', '');
    if (!$connect) {
        die("연결에 실패하였습니다.".mysqli_error());
    }
    echo "성공적으로 연결되었습니다.";
    echo "</p>";

    //데이터베이스 연결
    $select = mysqli_select_db($connect, "sample");
    if (!$select) {
        die("DB선택에 실패".mysqli_error());
    }
    echo "현재 DB선택에 성공";

    //데이터베이스 종료
    mysqli_close($connect);
?>