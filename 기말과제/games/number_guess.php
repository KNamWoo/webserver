<?php
// 점수 저장 로직
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (session_status() == PHP_SESSION_NONE) {
        session_start(); // 세션 시작
    }

    // 로그인되지 않은 경우 로그인 페이지로 리다이렉션
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit;
    }

    $servername = "localhost";
    $username = "root"; // 데이터베이스 사용자 이름
    $password = ""; // 데이터베이스 비밀번호
    $dbname = "game_scores"; // 데이터베이스 이름

    $score = $_POST['score'];
    $player_name = $_SESSION['username']; // 세션에서 가져온 플레이어 이름
    $game_name = "number_guess"; // 게임 이름 고정

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 데이터베이스에 점수 저장
        $stmt = $conn->prepare("INSERT INTO scores (game_name, player_name, score) VALUES (:game_name, :player_name, :score)");
        $stmt->bindParam(':game_name', $game_name);
        $stmt->bindParam(':player_name', $player_name);
        $stmt->bindParam(':score', $score);
        $stmt->execute();

        echo "<script>alert('점수가 저장되었습니다!');</script>";
    } catch (PDOException $e) {
        echo "<script>alert('저장 중 오류 발생: " . $e->getMessage() . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Guess the Number</title>
</head>
<body>
    <h1>Guess the Number</h1>
    <p>Guess a number between 1 and 100</p>
    <input type="number" id="guess" min="1" max="100">
    <button onclick="checkGuess()">Guess</button>
    <p id="message"></p>
    <form id="scoreForm" method="POST" style="display: none;">
        <!-- 게임 점수를 숨김 필드로 전송 -->
        <input type="hidden" name="score" id="finalScore">
        <button type="submit">Record Score</button>
    </form>
    <script>
        const target = Math.floor(Math.random() * 100) + 1; // 랜덤 숫자 생성
        let attempts = 0;

        function checkGuess() {
            const guess = parseInt(document.getElementById('guess').value); // 입력된 숫자
            const message = document.getElementById('message');
            attempts++;

            if (guess === target) {
                message.innerText = `Correct! It took you ${attempts} attempts.`; // 정답 메시지 표시
                document.getElementById('finalScore').value = attempts; // 시도 횟수 저장
                document.getElementById('scoreForm').style.display = "block"; // 점수 저장 폼 표시
            } else if (guess < target) {
                message.innerText = "Too low!";
            } else {
                message.innerText = "Too high!";
            }
        }
    </script>
</body>
</html>
