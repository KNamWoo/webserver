<?php
session_start();
include('db.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$post_id = $_POST['post_id'];
$content = $_POST['content'];
$username = $_SESSION['username'];

// 사용자 ID 가져오기
$sql = "SELECT user_id FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$user_id = $user['user_id'];

// 댓글 삽입
$sql = "INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $post_id, $user_id, $content);

if ($stmt->execute()) {
    echo "댓글이 작성되었습니다.";
    header("Location: view_post.php?post_id=" . $post_id);
    exit();
} else {
    echo "댓글 작성에 실패했습니다.";
}

$stmt->close();
$conn->close();
?>
