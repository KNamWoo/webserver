<?php
session_start();

// 세션 값 확인
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    die("로그인 후 이용 가능합니다.");
}

include('db_community.php'); // DB 연결

// 공지 작성 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];  // 세션에서 user_id 가져오기

    // 공지 게시글 삽입
    $sql = "INSERT INTO posts (title, content, user_id, game_name, score, is_announcement, created_at)
            VALUES (?, ?, ?, '공지', 0, 1, NOW())";
    $stmt = $community_board_conn->prepare($sql);
    
    if (!$stmt) {
        die("SQL 오류: " . $community_board_conn->error);
    }

    // 파라미터 바인딩
    $stmt->bind_param("ssi", $title, $content, $user_id); // user_id는 정수형

    if ($stmt->execute()) {
        header("Location: write_notice.php");
        exit();
    } else {
        echo "공지 작성에 실패했습니다.";
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>공지 작성</title>
    <link rel="stylesheet" href="commu.css">
</head>
<body>

    <!-- 네비바 -->
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

    <div class="container">
        <h2>공지 작성</h2>
        <form method="POST" action="">
            <label for="title">제목:</label><br>
            <input type="text" id="title" name="title" required><br><br>

            <label for="content">내용:</label><br>
            <textarea id="content" name="content" required></textarea><br><br>

            <button type="submit">공지 작성</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 커뮤니티 게시판. 모든 권리 보유.</p>
    </footer>

</body>
</html>
