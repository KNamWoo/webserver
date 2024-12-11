<?php
session_start();

// 관리자 권한 체크
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// 데이터베이스 연결 (game_scores DB)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "game_scores";  // game_scores DB

// 게임 점수 DB 연결
$game_scores_conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($game_scores_conn->connect_error) {
    die("Connection failed (game_scores): " . $game_scores_conn->connect_error);
}

// 게임 및 점수 관리 로직
$sql = "SELECT * FROM scores";  // 모든 점수 조회
$result = $game_scores_conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게임 관리</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        td {
            background-color: #fff;
        }
    </style>
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
        <li><a href="logout.php">로그아웃</a></li>
    <?php else: ?>
        <li><a href="login.php">로그인</a></li>
        <li><a href="signup.php">회원가입</a></li>
    <?php endif; ?>
</ul>

<div class="container">
    <h2>게임 관리</h2>
    <table>
        <thead>
            <tr>
                <th>게임 이름</th>
                <th>플레이어</th>
                <th>점수</th>
                <th>삭제</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['game_name'] ?></td>
                    <td><?= $row['player_name'] ?></td>
                    <td><?= $row['score'] ?></td>
                    <td>
                        <!-- 삭제 버튼 -->
                        <form action="delete_score.php" method="get" onsubmit="return confirm('정말 삭제하시겠습니까?');">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type="submit">삭제</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
