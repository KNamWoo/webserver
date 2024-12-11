<?php
session_start();

// 커뮤니티 게시판 데이터베이스 연결
include('db_community.php'); // community_board DB 연결

// 게임 점수 데이터베이스 연결
include('db_game_scores.php'); // game_scores DB 연결

// 로그인 확인
if (!isset($_SESSION['username'])) {
    echo "로그인 상태가 아닙니다.";
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// 게시물 수정하려는 ID 확인
if (!isset($_GET['post_id'])) {
    echo "게시글 ID가 없습니다.<br>";
    exit();
}

$post_id = $_GET['post_id'];  // URL로 전달된 게시글 ID

// 게시글 정보 가져오기
$sql = "SELECT posts.title, posts.content, posts.game_name, posts.score 
        FROM posts 
        JOIN users ON posts.user_id = users.user_id 
        WHERE posts.post_id = ? AND users.username = ?";
$stmt = $community_board_conn->prepare($sql);
if (!$stmt) {
    die("쿼리 준비 오류: " . $community_board_conn->error);
}

$stmt->bind_param("is", $post_id, $username);
$stmt->execute();

if ($stmt->error) {
    echo "SQL 오류: " . $stmt->error . "<br>";
    exit();
}

$result = $stmt->get_result();
$post = $result->fetch_assoc();

// 게시글이 존재하지 않으면 오류 처리
if (!$post) {
    echo "게시글을 찾을 수 없습니다.<br>";
    exit();
}

// 게임 목록 가져오기
$sql_games = "SELECT game_name, score FROM scores WHERE player_name = ?";
$stmt_games = $game_scores_conn->prepare($sql_games);
if (!$stmt_games) {
    die("쿼리 준비 오류: " . $game_scores_conn->error);
}

$stmt_games->bind_param("s", $username);
$stmt_games->execute();
$games_result = $stmt_games->get_result();

// 게시물 수정 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 입력 값 처리
    $title = $_POST['title'];
    $content = $_POST['content'];
    $game_name = $_POST['game_name'];
    $score = $_POST['score'];

    // 필수 값 확인
    if (empty($title) || empty($content) || empty($game_name) || empty($score)) {
        echo "모든 필드를 채워주세요.<br>";
        exit();
    }

    // 사용자의 user_id 가져오기
    $sql_user_id = "SELECT user_id FROM users WHERE username = ?";
    $stmt_user_id = $community_board_conn->prepare($sql_user_id); // 쿼리 준비
    if (!$stmt_user_id) {
        die("쿼리 준비 오류: " . $community_board_conn->error);
    }
    $stmt_user_id->bind_param("s", $username);
    $stmt_user_id->execute();
    $user_result = $stmt_user_id->get_result();
    
    // 사용자 ID가 존재하는지 확인
    if ($user_result->num_rows > 0) {
        $user = $user_result->fetch_assoc();
        $user_id = $user['user_id'];
    } else {
        echo "사용자 ID를 찾을 수 없습니다.<br>";
        exit();
    }

    // 게시글 수정 쿼리
    $sql_update = "UPDATE posts SET title = ?, content = ?, user_id = ?, game_name = ?, score = ? WHERE post_id = ?";
    $stmt_update = $community_board_conn->prepare($sql_update);
    if (!$stmt_update) {
        die("쿼리 준비 오류: " . $community_board_conn->error);
    }

    // user_id가 변수로 선언되어야 하므로 수정합니다.
    $stmt_update->bind_param("ssissi", $title, $content, $user_id, $game_name, $score, $post_id);

    if ($stmt_update->execute()) {
        // 수정 완료 후 alert 표시
        echo "<script>alert('게시물이 성공적으로 수정되었습니다.');</script>";
        echo "<script>window.location.href = 'view_post.php?post_id=$post_id';</script>";
        exit();
    } else {
        echo "수정 실패: " . $stmt_update->error . "<br>";
    }

}
/*
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
}*/
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시글 수정</title>
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
        <h2>게시글 수정</h2>
        <form method="POST">
            <label for="title">제목:</label><br>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($post['title']) ?>" required><br><br>

            <label for="content">내용:</label><br>
            <textarea id="content" name="content" required><?= htmlspecialchars($post['content']) ?></textarea><br><br>

            <!-- 게임 점수 선택 -->
            <label for="game_name">게임 이름:</label><br>
            <select name="game_name" id="game_name" required onchange="updateScore()">
                <option value="">게임을 선택하세요</option>
                <?php while ($row = $games_result->fetch_assoc()): ?>
                    <option value="<?= $row['game_name'] ?>" data-score="<?= $row['score'] ?>" 
                            <?= ($row['game_name'] == $post['game_name']) ? 'selected' : '' ?>> 
                            <?= $row['game_name'] ?> - <?= $row['score'] ?>점
                    </option>
                <?php endwhile; ?>
            </select><br><br>

            <label for="score">점수:</label><br>
            <input type="text" id="score" name="score" value="<?= htmlspecialchars($post['score']) ?>" readonly><br><br>

            <button type="submit">수정 완료</button>
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
