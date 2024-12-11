<?php
session_start();
include('db.php');  // DB 연결

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 사용자 정보 조회
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // 사용자 존재 여부 확인
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // 비밀번호 검증
        if (password_verify($password, $user['password'])) {
            // 비밀번호가 맞다면 세션에 사용자 정보 저장
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['full_name'] = $user['full_name']; // 전체 이름도 저장

            // 로그인 성공 후 리다이렉트
            header("Location: index.php");
            exit;
        } else {
            echo "<div class='error-message'>아이디 또는 비밀번호가 잘못되었습니다.</div>";
        }
    } else {
        echo "<div class='error-message'>아이디 또는 비밀번호가 잘못되었습니다.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로그인</title>
    <link rel="stylesheet" href="login.css"> <!-- 로그인 스타일 -->
</head>
<body>
    <div class="login-container">
        <h2>로그인</h2>
        <form method="POST" action="login.php">
            <input type="text" name="username" placeholder="아이디" required><br>
            <input type="password" name="password" placeholder="비밀번호" required><br>
            <button type="submit">로그인</button>
        </form>
        <div class="error-message">
            <!-- 오류 메시지 출력 -->
        </div>
        <div class="signup-link">
            <span>회원가입이 아직 안되셨나요? <a href="signup.php">회원가입</a></span>
        </div>
    </div>
</body>
</html>
