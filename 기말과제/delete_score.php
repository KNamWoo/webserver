<?php
session_start();

// 게임 점수 데이터베이스 연결 (game_scores DB 연결)
$game_scores_conn = new mysqli('localhost', 'root', '', 'game_scores');

// 연결 오류 확인
if ($game_scores_conn->connect_error) {
    die("게임 점수 데이터베이스 연결 실패: " . $game_scores_conn->connect_error);
}

// score_id가 존재하는지 확인
if (isset($_GET['id'])) {
    $score_id = $_GET['id'];

    // 점수 삭제 쿼리 실행
    $sql = "DELETE FROM scores WHERE id = ?";
    $stmt = $game_scores_conn->prepare($sql);
    $stmt->bind_param("i", $score_id);

    if ($stmt->execute()) {
        echo "<script>alert('삭제되었습니다.'); window.location.href = 'game_manage.php';</script>";
    } else {
        echo "<script>alert('삭제 실패'); window.location.href = 'game_manage.php';</script>";
    }
} else {
    echo "<script>alert('잘못된 요청입니다.'); window.location.href = 'game_manage.php';</script>";
}

// 연결 종료
$game_scores_conn->close();
?>
