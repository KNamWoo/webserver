<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판</title>
    <link rel="stylesheet" href="commu.css">
    <script src="./commu.js"></script>
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
    <!-- 왼쪽 위: 최근 글 -->
    <div class="section">
        <h2><a href="recent-posts.php">최근 올라온 상품</a></h2>
        <div class="board-list">
            <div class="board-item">
                <h3><a href="#">첫 번째 최근 글 제목</a></h3>
                <p>작성자: 홍길동 | 작성일: 2024-11-21</p>
                <p>최근 글 내용이 여기에 들어갑니다.</p>
            </div>
            <div class="board-item">
                <h3><a href="#">두 번째 최근 글 제목</a></h3>
                <p>작성자: 김철수 | 작성일: 2024-11-20</p>
                <p>최근 글 내용이 여기에 들어갑니다.</p>
            </div>
        </div>
    </div>

    <!-- 오른쪽 위: 인기 글 -->
    <div class="section">
        <h2><a href="popular-posts.php">인기 상품</a></h2>
        <div class="board-list">
            <div class="board-item">
                <h3><a href="#">인기 글 1</a></h3>
                <p>작성자: 이영희 | 작성일: 2024-11-19</p>
                <p>인기 글의 본문 내용이 여기에 들어갑니다.</p>
            </div>
            <div class="board-item">
                <h3><a href="#">인기 글 2</a></h3>
                <p>작성자: 박민수 | 작성일: 2024-11-18</p>
                <p>인기 글의 본문 내용이 여기에 들어갑니다.</p>
            </div>
        </div>
    </div>

    <!-- 왼쪽 아래: 내 글 -->
    <div class="section">
        <h2><a href="my-posts.php">마이 상품</a></h2>
        <div class="board-list">
            <div class="board-item">
                <h3><a href="#">내가 쓴 글 1</a></h3>
                <p>작성자: 나 | 작성일: 2024-11-15</p>
                <p>내 글 내용이 여기에 들어갑니다.</p>
            </div>
            <div class="board-item">
                <h3><a href="#">내가 쓴 글 2</a></h3>
                <p>작성자: 나 | 작성일: 2024-11-10</p>
                <p>내 글 내용이 여기에 들어갑니다.</p>
            </div>
        </div>
    </div>

    <!-- 오른쪽 아래: 내가 좋아요한 글 -->
    <div class="section">
        <h2><a href="liked-posts.php">좋아요한 상품</a></h2>
        <div class="board-list">
            <div class="board-item">
                <h3><a href="#">좋아요한 글 1</a></h3>
                <p>작성자: 김철수 | 작성일: 2024-11-12</p>
                <p>좋아요한 글 내용이 여기에 들어갑니다.</p>
            </div>
            <div class="board-item">
                <h3><a href="#">좋아요한 글 2</a></h3>
                <p>작성자: 이영희 | 작성일: 2024-11-05</p>
                <p>좋아요한 글 내용이 여기에 들어갑니다.</p>
            </div>
        </div>
    </div>
</div>

<footer>
    <p>&copy; 2024 게시판. 모든 권리 보유.</p>
</footer>

</body>
</html>
