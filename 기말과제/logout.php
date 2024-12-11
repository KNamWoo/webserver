<?php
session_start();
session_unset(); // 세션 변수 모두 해제
session_destroy(); // 세션 종료

header("Location: commu.php"); // 로그아웃 후 게시판 홈으로 리다이렉트
exit();
?>
