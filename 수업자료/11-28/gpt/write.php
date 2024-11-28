<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_POST['author'];
    $stmt = $conn->prepare("INSERT INTO board2 (title, content, author) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $content, $author);
    $stmt->execute();
    header("Location: index.php");
    exit;
}?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>글 작성</title>
</head>
<body>
    <h1>글 작성</h1>
    <form method="post">
        <label>제목: <input type="text" name="title" required></label><br>
        <label>작성자: <input type="text" name="author" required></label><br>
        <label>내용:<br><textarea name="content" required></textarea></label><br>
        <button type="submit">작성</button>
    </form>
</body>
</html>