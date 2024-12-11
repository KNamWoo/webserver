<?php
session_start();
include('db.php');

// 한 페이지에 표시할 게시글 수
$posts_per_page = 5;
$announcements_per_page = 5;

// 현재 페이지 번호를 가져오기 (기본값 1)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $posts_per_page;
$announcement_offset = ($page - 1) * $announcements_per_page;

// 공지사항을 최상단에 먼저 출력하기 위한 SQL 쿼리
$sql_announcements = "SELECT posts.post_id, posts.title, posts.content, posts.created_at, users.username 
                     FROM posts 
                     JOIN users ON posts.user_id = users.user_id 
                     WHERE posts.is_announcement = 1
                     ORDER BY posts.created_at DESC
                     LIMIT ? OFFSET ?";
$stmt_announcements = $conn->prepare($sql_announcements);

// 쿼리가 준비되지 않았을 경우 에러 출력
if (!$stmt_announcements) {
    die('Query failed: ' . $conn->error);
}

$stmt_announcements->bind_param("ii", $announcements_per_page, $announcement_offset);
$stmt_announcements->execute();
$result_announcements = $stmt_announcements->get_result();

// 일반 게시글을 출력하기 위한 SQL 쿼리 (페이지네이션 적용)
$sql_posts = "SELECT posts.post_id, posts.title, posts.content, posts.created_at, users.username 
              FROM posts 
              JOIN users ON posts.user_id = users.user_id 
              WHERE posts.is_announcement = 0
              ORDER BY posts.created_at DESC
              LIMIT ? OFFSET ?";
$stmt_posts = $conn->prepare($sql_posts);

// 쿼리가 준비되지 않았을 경우 에러 출력
if (!$stmt_posts) {
    die('Query failed: ' . $conn->error);
}

$stmt_posts->bind_param("ii", $posts_per_page, $offset);
$stmt_posts->execute();
$result_posts = $stmt_posts->get_result();

// 전체 게시글 수 구하기
$total_sql = "SELECT COUNT(*) AS total_posts 
              FROM posts 
              WHERE is_announcement = 0";
$total_result = $conn->query($total_sql);
$total_posts = $total_result->fetch_assoc()['total_posts'];

// 전체 페이지 수 계산
$total_pages = ceil($total_posts / $posts_per_page);

// 전체 공지사항 수 구하기
$total_announcements_sql = "SELECT COUNT(*) AS total_announcements 
                            FROM posts 
                            WHERE is_announcement = 1";
$total_announcements_result = $conn->query($total_announcements_sql);
$total_announcements = $total_announcements_result->fetch_assoc()['total_announcements'];

// 전체 공지사항 페이지 수 계산
$total_announcements_pages = ceil($total_announcements / $announcements_per_page);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판</title>
    <link rel="stylesheet" href="commu.css">
    <style>
        /* 공지사항과 게시글을 세로로 배치 */
        .container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* 각 항목을 세로로 배치 */
        .posts-container, .announcements-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* 게시글과 공지사항을 가로로 배치 */
        .post-item, .announcement-item {
            display: flex;
            justify-content: space-between;
            background-color: white;
            color: black;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        /* 게시글 제목과 공지사항 제목을 한 줄로 끝나게 하고, 길면 ...으로 표시 */
        .post-item a, .announcement-item a {
            background-color: green;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 3px;
            display: block;  /* 링크를 블록으로 만들어 전체 영역을 클릭 가능하게 */
            width: 70%;  /* 제목의 최대 너비 */
            overflow: hidden;  /* 넘치는 부분 숨기기 */
            text-overflow: ellipsis;  /* 넘치는 부분에 ... 표시 */
            white-space: nowrap;  /* 한 줄로 끝내기 */
        }

        /* 제목 미리보기 스타일 */
        .post-item .preview, .announcement-item .preview {
            background-color: #f9f9f9;
            padding: 5px;
            border-radius: 5px;
            width: 50%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* 페이지네이션 스타일 */
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

    <!-- 공지사항 -->
    <div class="container">
        <h2>공지사항</h2>
        <div class="announcements-container">
            <?php if ($result_announcements->num_rows > 0): ?>
                <?php while ($announcement = $result_announcements->fetch_assoc()): ?>
                    <div class="announcement-item">
                        <a href="view_post.php?post_id=<?= $announcement['post_id'] ?>" target="_blank">
                            <?= htmlspecialchars($announcement['title']) ?>
                        </a>
                        <div class="preview"><?= htmlspecialchars($announcement['content']) ?></div>
                        <span>작성자: <?= htmlspecialchars($announcement['username']) ?> | 작성일: <?= htmlspecialchars($announcement['created_at']) ?></span>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>공지사항이 없습니다.</p>
            <?php endif; ?>
        </div>

        <!-- 페이지네이션 -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="commu.php?page=<?= $page - 1 ?>">이전</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_announcements_pages; $i++): ?>
                <a href="commu.php?page=<?= $i ?>" <?= ($i == $page) ? 'style="font-weight: bold;"' : '' ?>><?= $i ?></a>
            <?php endfor; ?>

            <?php if ($page < $total_announcements_pages): ?>
                <a href="commu.php?page=<?= $page + 1 ?>">다음</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- 일반 게시글 -->
    <div class="container">
        <h2>게시글</h2>
        <div class="posts-container">
            <?php if ($result_posts->num_rows > 0): ?>
                <?php while ($post = $result_posts->fetch_assoc()): ?>
                    <div class="post-item">
                        <a href="view_post.php?post_id=<?= $post['post_id'] ?>" target="_blank">
                            <?= htmlspecialchars($post['title']) ?>
                        </a>
                        <div class="preview"><?= htmlspecialchars($post['content']) ?></div>
                        <span>작성자: <?= htmlspecialchars($post['username']) ?> | 작성일: <?= htmlspecialchars($post['created_at']) ?></span>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>게시글이 없습니다.</p>
            <?php endif; ?>

            <!-- 페이지네이션 -->
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="commu.php?page=<?= $page - 1 ?>">이전</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="commu.php?page=<?= $i ?>" <?= ($i == $page) ? 'style="font-weight: bold;"' : '' ?>><?= $i ?></a>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <a href="commu.php?page=<?= $page + 1 ?>">다음</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 커뮤니티 게시판. 모든 권리 보유.</p>
    </footer>

</body>
</html>
