<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로그인</title>
    <link rel="stylesheet" href="./login.css">
    <script src="./login.js" defer></script>
</head>
<body>

<div class="form-container">
    <h1>로그인</h1>
    <form id="loginForm">
        <div class="form-group">
            <label for="username">아이디</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">비밀번호</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">로그인</button>
        <p class="redirect">계정이 없으신가요? <a href="../signup/signup.php">회원가입</a></p>
    </form>
</div>

</body>
</html>
