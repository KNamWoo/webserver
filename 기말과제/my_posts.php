<?php
session_start();
include('db.php');

// 사용자가 로그인했는지 확인
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // 로그인되지 않은 사용자는 로그인 페이지로 리디렉션
    exit;
}

// 한 페이지에 표시할 게시글 수
$posts_per_page = 5;

// 현재 페이지 번호를 가져오기 (기본값 1)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $posts_per_page;

// 로그인한 사용자의 ID를 가져오기
$user_id = $_SESSION['user_id'];

// 사용자가 작성한 게시글을 출력하기 위한 SQL 쿼리 (페이지네이션 적용)
$sql_posts = "SELECT posts.post_id, posts.title, posts.content, posts.created_at, users.username 
              FROM posts 
              JOIN users ON posts.user_id = users.user_id 
              WHERE posts.user_id = ? 
              ORDER BY posts.created_at DESC
              LIMIT ? OFFSET ?";
$stmt_posts = $conn->prepare($sql_posts);

// 쿼리가 준비되지 않았을 경우 에러 출력
if (!$stmt_posts) {
    die('Query failed: ' . $conn->error);
}

$stmt_posts->bind_param("iii", $user_id, $posts_per_page, $offset);
$stmt_posts->execute();
$result_posts = $stmt_posts->get_result();

// 전체 게시글 수 구하기 (로그인한 사용자가 작성한 게시글만)
$total_sql = "SELECT COUNT(*) AS total_posts 
              FROM posts 
              WHERE user_id = ?";
$total_stmt = $conn->prepare($total_sql);
$total_stmt->bind_param("i", $user_id);
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_posts = $total_result->fetch_assoc()['total_posts'];

// 전체 페이지 수 계산
$total_pages = ceil($total_posts / $posts_per_page);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>내 게시글</title>
    <link rel="stylesheet" href="commu.css">
    <style>
        .container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .posts-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .post-item {
            display: flex;
            justify-content: space-between;
            background-color: white;
            color: black;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .post-item a {
            background-color: green;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 3px;
            display: block;
            width: 70%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .post-item .preview {
            background-color: #f9f9f9;
            padding: 5px;
            border-radius: 5px;
            width: 50%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .pagination a {
            padding: 5px 10px;
            border: 1px solid #ccc;
            text-decoration: none;
            color: #007bff;
        }

        .pagination a:hover {
            background-color: #f1f1f1;
        }

        .pagination a[style="font-weight: bold;"] {
            background-color: #007bff;
            color: white;
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

    <!-- 내가 쓴 게시글 -->
    <div class="container">
        <h2>내가 쓴 게시글</h2>
        <div class="posts-container">
            <?php if ($result_posts->num_rows > 0): ?>
                <?php while ($post = $result_posts->fetch_assoc()): ?>
                    <div class="post-item">
                        <a href="view_post.php?post_id=<?= $post['post_id'] ?>" target="_blank">
                            <?= htmlspecialchars($post['title']) ?>
                        </a>
                        <div class="preview"><?= htmlspecialchars($post['content']) ?></div>
                        <span>작성일: <?= htmlspecialchars($post['created_at']) ?></span>
                        <!-- 수정 버튼 추가 -->
                        <a href="edit_post.php?post_id=<?= $post['post_id'] ?>">[수정]</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>작성한 게시글이 없습니다.</p>
            <?php endif; ?>
        </div>

        <!-- 페이지네이션 -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="my_posts.php?page=<?= $page - 1 ?>">이전</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="my_posts.php?page=<?= $i ?>" <?= ($i == $page) ? 'style="font-weight: bold;"' : '' ?>><?= $i ?></a>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <a href="my_posts.php?page=<?= $page + 1 ?>">다음</a>
            <?php endif; ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 커뮤니티 게시판. 모든 권리 보유.</p>
    </footer>

</body>
</html>
