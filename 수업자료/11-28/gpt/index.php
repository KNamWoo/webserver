<?php
include 'db.php';
$result = $conn->query("SELECT * FROM board2 ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>게시판</title>
</head>
<body>
    <h1>게시판 목록</h1>
    <a href="write.php">글 작성</a>
    <table border="1">
        <tr>
            <th>번호</th>
            <th>제목</th>
            <th>작성자</th>
            <th>작성일</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><a href="view.php?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['title']) ?></a></td>
            <td><?= htmlspecialchars($row['author']) ?></td>
            <td><?= $row['created_at'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>