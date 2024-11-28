<?php
$host = 'localhost';
$db = 'sample';
$user = 'root';
$pass = ''; // XAMPP 사용 시 기본 비밀번호는 비어 있음
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}?>