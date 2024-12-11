<?php
session_start();
include('db.php');

// 로그인 확인
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// 사용자의 게임 점수 가져오기
$sql = "SELECT score_id, game_name, score FROM game_scores WHERE user_id = (SELECT user_id FROM users WHERE username = ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게임 점수</title>
    <link rel="stylesheet" href="commu.css">
</head>
<body>

    <!-- 네비바 -->
    <ul id="navbar">
        <li><a href="commu.php">홈</a></li>
        <li><a href="write_post.php">게시글 작성</a></li>
        <?php if (isset($_SESSION['username'])): ?>
            <li><a href="logout.php">로그아웃</a></li>
        <?php else: ?>
            <li><a href="login.php">로그인</a></li>
            <li><a href="signup.php">회원가입</a></li>
        <?php endif; ?>
    </ul>

    <div class="container">
        <h2>게임 점수</h2>
        <form method="POST" action="write_post.php">
            <label for="score">게임 점수 선택:</label><br>
            <select name="score_id" id="score">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <option value="<?= $row['score_id'] ?>"><?= $row['game_name'] ?> - <?= $row['score'] ?>점</option>
                <?php endwhile; ?>
            </select><br><br>
            <button type="submit">게시글 작성</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 커뮤니티 게시판. 모든 권리 보유.</p>
    </footer>

</body>
</html>
