<?php
session_start();
include('db.php');

// 게시글 ID 가져오기
$post_id = $_GET['post_id'];

// 로그인 확인
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// 게시글 정보 가져오기
$sql = "SELECT posts.title, posts.content, posts.post_id, posts.user_id, users.username
        FROM posts 
        JOIN users ON posts.user_id = users.user_id
        WHERE posts.post_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

// 작성자가 맞는지 확인
if ($post['username'] !== $_SESSION['username']) {
    echo "본인만 삭제할 수 있습니다.";
    exit();
}

// 게시글 삭제 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 게시글 삭제
    $sql = "DELETE FROM posts WHERE post_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);

    if ($stmt->execute()) {
        header("Location: commu.php"); // 삭제 후 게시판 홈으로 리다이렉트
        exit();
    } else {
        echo "게시글 삭제에 실패했습니다.";
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시글 삭제</title>
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
        <h2>게시글 삭제</h2>
        <p>게시글을 삭제하시겠습니까?</p>
        <form method="POST" action="delete_post.php?post_id=<?= $post_id ?>">
            <button type="submit">삭제하기</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 커뮤니티 게시판. 모든 권리 보유.</p>
    </footer>

</body>
</html>
