<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>내가 좋아요한 글 - 게시판</title>
    <link rel="stylesheet" href="liked-posts.css">
</head>
<body>
<ul id="navbar">
    <li style="float: left;">
        <a class="active" id="home" href="commu.php">마켓</a>
    </li>
    <li class="dropdown" style="float: right; display: flex; height: 100%;">
        <a class="dropbtn">내 정보</a>
        <div class="dropdown-content">
            <a href="./my-posts.php">내가 올린 상품</a>
            <a href="./liked-posts.php">좋아요한 상품</a>
            <a href="./my-cart.php">장바구니</a>
            <a href="#">개인정보 수정</a>
        </div>
    </li>
    <li style="float: right; display: flex; height: 100%;">
        <a href="all-goods.php">전체 상품</a>
        <a href="info.php">공지사항</a>
        <a href="./login/login.php">로그인</a>
    </li>
</ul>

<div class="container">
    <h2>내가 좋아요한 글</h2>
    <div class="board-list">
        <div class="board-item">
            <h3><a href="#">좋아요한 글 제목 1</a></h3>
            <p>작성자: 홍길동 | 좋아요일시: 2024-11-22</p>
        </div>
        <div class="board-item">
            <h3><a href="#">좋아요한 글 제목 2</a></h3>
            <p>작성자: 김철수 | 좋아요일시: 2024-11-21</p>
        </div>
    </div>
</div>

<footer>
    <p>&copy; 2024 게시판. 모든 권리 보유.</p>
</footer>
</body>
</html>
