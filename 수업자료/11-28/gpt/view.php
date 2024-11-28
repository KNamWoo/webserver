<?php
include 'db.php';
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM board2 WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($row['title']) ?></title>
</head>
<body>
    <h1><?= htmlspecialchars($row['title']) ?></h1>
    <p>작성자: <?= htmlspecialchars($row['author']) ?></p>
    <p>작성일: <?= $row['created_at'] ?></p>
    <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>
    <a href="edit.php?id=<?= $row['id'] ?>">수정</a>
    <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('정말 삭제하시겠습니까?')">삭제</a>
    <a href="index.php">목록으로</a>
</body>
</html>