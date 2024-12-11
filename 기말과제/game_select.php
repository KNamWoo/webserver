<?php
session_start();

// 게임 폴더에서 게임 목록을 불러옵니다.
$game_folder = 'games'; // 게임 파일이 들어있는 폴더

// 게임 폴더에서 모든 PHP 파일을 읽어옵니다.
$games = [];
if ($handle = opendir($game_folder)) {
    while (($file = readdir($handle)) !== false) {
        if ($file != "." && $file != ".." && pathinfo($file, PATHINFO_EXTENSION) == 'php') {
            $games[] = pathinfo($file, PATHINFO_FILENAME); // 게임 이름만 추출
        }
    }
    closedir($handle);
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게임 선택</title>
    <link rel="stylesheet" href="commu.css">
</head>
<body>
    <ul id="navbar" style="display:flex">
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

    <h2>게임 목록</h2>
    <ul style="display:flex">
        <?php if (!empty($games)): ?>
            <?php foreach ($games as $game): ?>
                <li><a href="game_play.php?game_name=<?php echo htmlspecialchars($game); ?>"><?php echo htmlspecialchars($game); ?> 게임</a></li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>게임이 없습니다.</li>
        <?php endif; ?>
    </ul>
</body>
</html>
