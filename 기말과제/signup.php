<?php
session_start();
include('db.php');  // DB 연결

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // 비밀번호 확인
    if ($password !== $confirm_password) {
        echo "<div class='error-message'>비밀번호가 일치하지 않습니다.</div>";
    } else {
        // 비밀번호 암호화
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // 아이디 중복 확인
        $sql_check = "SELECT * FROM users WHERE username = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("s", $username);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            echo "<div class='error-message'>이미 존재하는 아이디입니다.</div>";
        } else {
            // 사용자 정보 삽입
            $sql_insert = "INSERT INTO users (full_name, username, email, password) VALUES (?, ?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("ssss", $full_name, $username, $email, $hashed_password);

            if ($stmt_insert->execute()) {
                echo "<div class='success-message'>회원가입 성공! 로그인 페이지로 이동합니다.</div>";
                header("refresh:2;url=login.php");  // 2초 후 로그인 페이지로 리다이렉트
            } else {
                echo "<div class='error-message'>회원가입에 실패했습니다. 다시 시도해주세요.</div>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원가입</title>
    <link rel="stylesheet" href="login.css"> <!-- 로그인 스타일 -->
</head>
<body>
    <div class="signup-container">
        <h2>회원가입</h2>
        <form method="POST" action="signup.php">
            <input type="text" name="full_name" placeholder="전체 이름" required><br>
            <input type="text" name="username" placeholder="아이디" required><br>
            <input type="email" name="email" placeholder="이메일" required><br>
            <input type="password" name="password" placeholder="비밀번호" required><br>
            <input type="password" name="confirm_password" placeholder="비밀번호 확인" required><br>
            <button type="submit">회원가입</button>
        </form>
        <div class="error-message">
            <!-- 오류 메시지 출력 -->
        </div>
        <div class="login-link">
            <span>이미 계정이 있으신가요? <a href="login.php">로그인</a></span>
        </div>
    </div>
</body>
</html>
