<?php
    $id = $_POST['id'];
    $pwd = $_POST['pwd'];
    $connect = mysqli_connect("localhost", "root", "");
    mysqli_select_db($connect, "sample");
    mysqli_query($connect, 'set names utf8');
    
    // 아이디와 비밀번호로 회원 정보 조회
    $sqlrec = "SELECT * FROM member WHERE id='$id' AND pwd='$pwd'";
    $info = mysqli_query($connect, $sqlrec);

    if (!$info) {
        echo "<script>alert('아이디 또는 비밀번호가 존재하지 않습니다.'); history.back();</script>";
        exit;
    }

    // 회원 정보 조회 후 세션에 저장
    while ($i = mysqli_fetch_array($info)) {
        $b = $i['nicname'];  // 닉네임
        $c = $i['regdate'];   // 가입일자
    }

    // 세션 시작 및 세션 변수에 값 저장
    session_start();
    $_SESSION['nicname'] = $b;
    $_SESSION['regdate'] = $c;

    // 리디렉션: 로그인 후 loginMsg.php로 이동
    echo "<meta http-equiv='refresh' content='0;url=loginMsg.php'>";
?>
