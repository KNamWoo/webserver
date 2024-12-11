<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>홈페이지</title>
    <link rel="stylesheet" href="commu.css">
</head>
<body>
    <!-- 네비게이션 바 -->
    <ul id="navbar" style="display:flex;">
        <li><a href="index.php">홈</a></li>
        <li><a href="commu.php">게시판</a></li>
        <li><a href="write_post.php">게시글 작성</a></li>
        <li><a href="info.php">공지사항</a></li>
        <?php if (isset($_SESSION['username'])): ?>
            <!--관리자일 경우 게임 관리메뉴-->
            <?php if($_SESSION['username'] === 'admin'): ?>
                <li><a href="game_manage.php">게임 기록 관리</a></li>
            <?php endif; ?>
            <li><a href="my_posts.php">내가 쓴 글</a></li>
            <li><a href="logout.php">로그아웃</a></li>
        <?php else: ?>
            <li><a href="login.php">로그인</a></li>
            <li><a href="signup.php">회원가입</a></li>
        <?php endif; ?>
    </ul>

    <div id="home-selection">
        <h1>게임 또는 게시판 선택</h1>
        <form method="get">
            <button type="submit" name="choice" value="board" class="btn">게시판</button>
            <button type="submit" name="choice" value="game" class="btn">게임</button>
        </form>

        <?php
        if (isset($_GET['choice'])) {
            $choice = $_GET['choice'];
            if ($choice == 'board') {
                header("Location: commu.php");  // 게시판 페이지로 이동
                exit;
            } elseif ($choice == 'game') {
                header("Location: game_select.php");  // 게임 선택 페이지로 이동
                exit;
            }
        }
        ?>
    </div>

    <footer>
        <p>&copy; 2024 커뮤니티 게시판. 모든 권리 보유.</p>
    </footer>

</body>
</html>
