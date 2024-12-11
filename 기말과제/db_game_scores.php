<?php
// 게임 점수 DB 연결
$game_scores_conn = new mysqli('localhost', 'root', '', 'game_scores');

if ($game_scores_conn->connect_error) {
    die("Connection failed: " . $game_scores_conn->connect_error);
}
?>
