<?php
session_start();

// 커뮤니티 게시판 데이터베이스 연결
include('db_community.php'); // community_board DB 연결

// 게임 점수 데이터베이스 연결
include('db_game_scores.php'); // game_scores DB 연결

// 로그인 확인
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// game_scores 데이터베이스에서 사용자의 게임 점수 가져오기
$sql = "SELECT game_name, score FROM scores WHERE player_name = ?";
$stmt = $game_scores_conn->prepare($sql);

// 오류 확인
if (!$stmt) {
    die("SQL 오류: " . $game_scores_conn->error);  // SQL 오류가 있으면 오류 메시지 출력
}

$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// 게시글 작성 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $game_name = $_POST['game_name'];  // 선택한 게임 이름
    $score = $_POST['score'];          // 선택한 게임 점수

    // community_board 데이터베이스에서 사용자 ID 가져오기
    $sql = "SELECT user_id FROM users WHERE username = ?";
    $stmt = $community_board_conn->prepare($sql);

    // 오류 확인
    if (!$stmt) {
        die("SQL 오류: " . $community_board_conn->error);  // SQL 오류가 있으면 오류 메시지 출력
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $user_result = $stmt->get_result();
    $user = $user_result->fetch_assoc();
    $user_id = $user['user_id'];

    // 게시글 삽입
    $sql = "INSERT INTO posts (title, content, user_id, game_name, score) VALUES (?, ?, ?, ?, ?)";
    $stmt = $community_board_conn->prepare($sql);

    // 오류 확인
    if (!$stmt) {
        die("SQL 오류: " . $community_board_conn->error);  // SQL 오류가 있으면 오류 메시지 출력
    }

    $stmt->bind_param("ssiss", $title, $content, $user_id, $game_name, $score);

    if ($stmt->execute()) {
        header("Location: commu.php"); // 게시글 작성 후 게시판 홈으로 리다이렉트
        exit();
    } else {
        echo "게시글 작성에 실패했습니다.";
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시글 작성</title>
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
            <li><a href="my_posts.php">내가 쓴 글</a></li>
            <li><a href="logout.php">로그아웃</a></li>
        <?php else: ?>
            <li><a href="login.php">로그인</a></li>
            <li><a href="signup.php">회원가입</a></li>
        <?php endif; ?>
    </ul>

    <div class="container">
        <h2>게시글 작성</h2>
        <form method="POST" action="write_post.php">
            <label for="title">제목:</label><br>
            <input type="text" id="title" name="title" required><br><br>

            <label for="content">내용:</label><br>
            <textarea id="content" name="content" required></textarea><br><br>

            <!-- 게임 점수 선택 -->
            <label for="game_name">게임 이름:</label><br>
            <select name="game_name" id="game_name" required onchange="updateScore()">
                <option value="">게임을 선택하세요</option>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <option value="<?= $row['game_name'] ?>" data-score="<?= $row['score'] ?>"><?= $row['game_name'] ?> - <?= $row['score'] ?>점</option>
                <?php endwhile; ?>
            </select><br><br>

            <label for="score">점수:</label><br>
            <input type="text" id="score" name="score" readonly><br><br>

            <button type="submit">게시글 작성</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 커뮤니티 게시판. 모든 권리 보유.</p>
    </footer>

    <script>
    function updateScore() {
        var gameSelect = document.getElementById('game_name');
        var selectedOption = gameSelect.options[gameSelect.selectedIndex];
        var score = selectedOption.getAttribute('data-score'); // 선택된 게임의 점수

        // 점수 입력 필드를 해당 점수로 업데이트
        document.getElementById('score').value = score;
    }
    </script>

</body>
</html>
