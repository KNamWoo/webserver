<?php
    session_start();
    if (!isset($_SESSION['goodinfo'])) {
        echo "현재 세션이 없습니다.";
    }else {
        echo "세션정보는".$_SESSION['goodinfo'];
    }
?>