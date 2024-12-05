<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원가입</title>
    <link rel="stylesheet" href="./signup.css">
    <script src="./signup.js" defer></script>
</head>
<body>

<div class="form-container">
    <h1>회원가입</h1>
    <form id="signupForm">
        <div class="form-group">
            <label for="username">아이디</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">비밀번호</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="confirmPassword">비밀번호 확인</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>
        </div>
        <div class="form-group">
            <label for="email">이메일</label>
            <input type="email" id="email" name="email" required>
        </div>
        <button type="submit">회원가입</button>
        <p class="redirect">이미 계정이 있으신가요? <a href="../login/login.php">로그인</a></p>
    </form>
</div>

</body>
</html>
