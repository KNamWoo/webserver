<?php
session_start();

// 게임 이름을 GET 방식으로 받기
if (isset($_GET['game_name'])) {
    $game_name = $_GET['game_name'];
} else {
    echo "게임이 선택되지 않았습니다.";
    exit;
}

// 게임 파일 경로 설정
$game_file = 'games/' . $game_name . '.php'; // 'games/' 폴더에 있는 게임 파일

// DB 연결
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "game_scores";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 게임 점수 정보 가져오기
$sql = "SELECT * FROM scores WHERE game_name = ? ORDER BY score DESC LIMIT 5";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $game_name);
$stmt->execute();
$result = $stmt->get_result();

// 게임 점수 저장 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $player_name = $_SESSION['username']; // 세션에서 사용자 이름 가져오기
    $score = $_POST['score']; // 제출된 점수 가져오기

    // 점수 저장 쿼리
    $sql_insert = "INSERT INTO scores (game_name, player_name, score) VALUES (?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("ssi", $game_name, $player_name, $score);
    $stmt_insert->execute();

    // 점수 저장 후 리다이렉트 (새로고침 방지)
    header("Location: " . $_SERVER['PHP_SELF'] . "?game_name=" . urlencode($game_name));
    exit;
}

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($game_name); ?> - 게임 플레이</title>
    <link rel="stylesheet" href="commu.css">
</head>
<body>
    <!-- 네비게이션 바 -->
    <ul id="navbar" style="display:flex;">
        <li><a href="index.php">홈</a></li>
        <li><a href="commu.php">게시판</a></li>
        <li><a href="game_select.php">게임 선택</a></li>
        <?php if (isset($_SESSION['username'])): ?>
            <li><a href="logout.php">로그아웃</a></li>
        <?php else: ?>
            <li><a href="login.php">로그인</a></li>
            <li><a href="signup.php">회원가입</a></li>
        <?php endif; ?>
    </ul>

    <div id="game-play">
        <h2><?php echo htmlspecialchars($game_name); ?> 게임을 플레이하세요!</h2>

        <!-- 게임 화면 (게임 시작 버튼을 대체) -->
        <div id="game-screen">
            <?php
            // 게임 로직이 바로 실행되도록 하기 위해 버튼 없이 게임 파일을 직접 실행
            include($game_file);
            ?>
        </div>

        <h3>Top 5 점수</h3>
        <table>
            <tr>
                <th>플레이어</th>
                <th>점수</th>
            </tr>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['player_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['score']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2">점수가 없습니다.</td>
                </tr>
            <?php endif; ?>
        </table>

        <footer>
            <p>&copy; 2024 커뮤니티 게시판. 모든 권리 보유.</p>
        </footer>
    </div>

</body>
</html>

<?php
$conn->close();
?>
