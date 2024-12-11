<?php
session_start();
include('db.php'); // db.php 파일 포함

// 게시글 ID 확인 및 검증
if (!isset($_GET['post_id']) || !ctype_digit($_GET['post_id'])) {
    die("잘못된 게시글 ID입니다.");
}
$post_id = (int)$_GET['post_id'];

// 게시글 조회 쿼리 (게임 이름과 점수, updated_at 추가)
$sql_post = "SELECT posts.title, posts.content, posts.created_at, posts.updated_at, users.username, posts.game_name, posts.score
             FROM posts 
             JOIN users ON posts.user_id = users.user_id 
             WHERE posts.post_id = ?";
$stmt_post = $conn->prepare($sql_post);
if (!$stmt_post) {
    die("게시글 쿼리 준비 오류: " . $conn->error);
}
$stmt_post->bind_param("i", $post_id);
$stmt_post->execute();
$result_post = $stmt_post->get_result();
$post = $result_post->fetch_assoc();

// 게시글이 없을 경우 처리
if (!$post) {
    die("게시글을 찾을 수 없습니다.");
}

// 댓글 조회 쿼리
$sql_comments = "SELECT comments.content, comments.created_at, users.username 
                 FROM comments 
                 JOIN users ON comments.user_id = users.user_id 
                 WHERE comments.post_id = ? 
                 ORDER BY comments.created_at DESC";
$stmt_comments = $conn->prepare($sql_comments);
if (!$stmt_comments) {
    die("댓글 쿼리 준비 오류: " . $conn->error);
}
$stmt_comments->bind_param("i", $post_id);
$stmt_comments->execute();
$result_comments = $stmt_comments->get_result();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시글 보기</title>
    <link rel="stylesheet" href="commu.css">
    <style>
        /* 간단한 스타일 추가 */
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        h2, h3 {
            margin-bottom: 15px;
        }
        .comment {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
        }
        textarea {
            width: 100%;
            height: 80px;
            margin-top: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            padding: 10px;
            resize: none;
        }
        button {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
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

    <!-- 게시글 표시 -->
    <div class="container">
        <h2><?= htmlspecialchars($post['title']) ?></h2>
        <p>작성자: <?= htmlspecialchars($post['username']) ?> | 작성일: <?= htmlspecialchars($post['created_at']) ?><br>수정일: <?= htmlspecialchars($post['updated_at']) ?></p>
        <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>

        <!-- 게임 이름과 점수 표시 -->
        <p><strong>게임 이름:</strong> <?= htmlspecialchars($post['game_name']) ?></p>
        <p><strong>점수:</strong> <?= htmlspecialchars($post['score']) ?>점</p>

        <!-- 댓글 섹션 -->
        <h3>댓글</h3>
        <?php while ($comment = $result_comments->fetch_assoc()): ?>
            <div class="comment">
                <p><strong><?= htmlspecialchars($comment['username']) ?>:</strong></p>
                <p><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
                <small>작성일: <?= htmlspecialchars($comment['created_at']) ?></small>
            </div>
        <?php endwhile; ?>

        <!-- 댓글 작성 폼 -->
        <?php if (isset($_SESSION['username'])): ?>
            <form method="POST" action="write_comment.php">
                <input type="hidden" name="post_id" value="<?= $post_id ?>">
                <textarea name="content" placeholder="댓글을 작성하세요..." required></textarea>
                <button type="submit">댓글 작성</button>
            </form>
        <?php else: ?>
            <p>댓글을 작성하려면 <a href="login.php">로그인</a> 해주세요.</p>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2024 커뮤니티 게시판. 모든 권리 보유.</p>
    </footer>
</body>
</html>
