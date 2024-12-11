<?php
session_start();
include('db.php'); // db.php 파일 포함

// 사용자 정보 확인
$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
$is_admin = false;

if ($username === 'admin') {
    $is_admin = true;
}

// 페이지네이션을 위한 변수 설정
$limit = 5;  // 페이지당 공지사항 수
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// 공지사항 조회 쿼리 실행
$sql = "SELECT * FROM posts WHERE is_announcement = 1 ORDER BY created_at DESC LIMIT ?, ?";
$stmt = $conn->prepare($sql);

// 오류 체크
if (!$stmt) {
    die("쿼리 준비 오류: " . $conn->error);
}

$stmt->bind_param("ii", $offset, $limit);
$stmt->execute();
$result = $stmt->get_result();

// 결과가 없을 때 처리
if (!$result) {
    die("쿼리 실행 오류: " . $stmt->error);
}

// 전체 공지사항의 수를 가져와서 페이지네이션 처리
$sql_count = "SELECT COUNT(*) AS total FROM posts WHERE is_announcement = 1";
$result_count = $conn->query($sql_count);
$total_anns = $result_count->fetch_assoc()['total'];
$total_pages = ceil($total_anns / $limit);

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>공지사항</title>
    <link rel="stylesheet" href="commu.css">
    <style>
        /* 공지사항 버튼과 레이아웃 조정 */
        #notice-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%; /* 버튼 너비를 100%로 설정하여 화면 크기에 맞게 버튼 크기 조정 */
        }
        #notice-button:hover {
            background-color: #0056b3;
        }

        /* 공지사항 목록을 세로로 배치 */
        .notice-container {
            display: flex;
            flex-direction: column;
            margin-bottom: 50px;
        }

        /* 각 공지사항 항목 스타일 */
        .notice-item {
            margin-bottom: 10px;
            padding: 10px;
            background-color: #f1f1f1;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .notice-item a {
            text-decoration: none;
            color: #333;
        }

        .notice-item a:hover {
            text-decoration: underline;
        }

        /* 페이지네이션 스타일 */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a {
            padding: 5px 10px;
            margin: 0 5px;
            text-decoration: none;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
        }

        .pagination a:hover {
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
            <li><a href="logout.php">로그아웃</a></li>
        <?php else: ?>
            <li><a href="login.php">로그인</a></li>
        <?php endif; ?>
    </ul>

    <!-- 공지사항 목록 출력 -->
    <div class="notice-container">
        <h2>공지사항</h2>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($notice = $result->fetch_assoc()): ?>
                <div class="notice-item">
                    <a href="view_post.php?post_id=<?= $notice['post_id'] ?>"><?= htmlspecialchars($notice['title']) ?> - <?= htmlspecialchars($notice['created_at']) ?></a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>등록된 공지사항이 없습니다.</p>
        <?php endif; ?>

        <!-- 관리자만 공지사항 작성 버튼 -->
        <?php if ($is_admin): ?>
            <button id="notice-button" onclick="location.href='write_notice.php'">공지사항 작성</button>
        <?php endif; ?>

        <!-- 페이지네이션 -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="info.php?page=<?= $page - 1 ?>">이전</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="info.php?page=<?= $i ?>" <?= ($i == $page) ? 'style="background-color:#0056b3;"' : '' ?>><?= $i ?></a>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <a href="info.php?page=<?= $page + 1 ?>">다음</a>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
