<?php
include 'db.php';
$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_POST['author'];
    $stmt = $conn->prepare("UPDATE board2 SET title = ?, content = ?, author = ? WHERE id = ?");
    $stmt->bind_param("sssi", $title, $content, $author, $id);
    $stmt->execute();
    header("Location: view.php?id=$id");
    exit;
}$stmt = $conn->prepare("SELECT * FROM board2 WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>글 수정</title>
</head>
<body>
    <h1>글 수정</h1>
    <form method="post">
        <label>제목: <input type="text" name="title" value="<?= htmlspecialchars($row['title']) ?>" required></label><br>
        <label>작성자: <input type="text" name="author" value="<?= htmlspecialchars($row['author']) ?>" required></label><br>
        <label>내용:<br><textarea name="content" required><?= htmlspecialchars($row['content']) ?></textarea></label><br>
        <button type="submit">수정</button>
    </form>
</body>
</html>