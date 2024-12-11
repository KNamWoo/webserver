<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "community_board";

// MySQL 서버에 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
