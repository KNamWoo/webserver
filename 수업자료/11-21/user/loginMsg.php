<?php
    session_start();  // 세션 시작

    // 세션 값이 존재하는지 확인
    if (isset($_SESSION['nicname']) && isset($_SESSION['regdate'])) {
        $nicname = $_SESSION['nicname'];
        $regdate = $_SESSION['regdate'];
    } else {
        // 세션이 없으면 경고 메시지와 함께 로그인 페이지로 리디렉션
        echo "<script>alert('세션이 만료되었습니다. 다시 로그인 해주세요.'); window.location.href='login.html';</script>";
        exit;
    }
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>회원 정보</title>
    <style>
        p {
            color: #ccaa11;
            font-size: 1.2em;
        }
    </style>
</head>
<body>
    <p>안녕하세요 <?php echo $nicname; ?> 님</p>
    <p>회원님은 <?php echo $regdate; ?> 일에 가입하셨습니다. 청운대에서 좋은 시간 보내세요</p>
</body>
</html>
