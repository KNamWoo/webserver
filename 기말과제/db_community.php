<?php
// 커뮤니티 게시판 DB 연결
$community_board_conn = new mysqli('localhost', 'root', '', 'community_board');

if ($community_board_conn->connect_error) {
    die("Connection failed: " . $community_board_conn->connect_error);
}
?>
