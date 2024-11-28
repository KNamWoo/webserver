<style>
/* 스타일 설정 */
h1 { color: #aacc22; }
table { width: 600px; border-bottom: 1px dashed #808080; }
th { background: #ddaa88; font-size: 1.2em; padding: 3px; }
#data1 { height: 30px; }
a { text-decoration: none; color: #505050; }
a:hover { color: #ddaa88; }
#ab { color: #ee9988; }
</style>
<body>
    <h1>청운대학교 자유 게시판 </h1>
    <table>
        <tr>
            <!-- 테이블 헤더 설정 -->
            <th>NO</th><th>제목</th><th>작성자</th><th>작성일</th><th>조회</th>
        </tr>
        <?php
        // DB 연결 및 설정
        $connect = mysqli_connect("localhost", "root", ""); // DB 연결
        mysqli_select_db($connect, "sample"); // 데이터베이스 선택
        mysqli_query($connect, 'set names utf8'); // UTF-8 설정

        // 현재 페이지 설정
        // page가 비어 있는 경우 1로 초기화
        if (empty($_GET['page'])) { 
            $page = 1; 
        } else { 
            $page = $_GET['page']; 
        }

        // 페이지네이션 설정
        $line_page = 5; // 한 페이지에 보여줄 글 수
        $block_page = 10; // 한 블록당 페이지 수
        $s1 = "select * from board"; // 전체 글 조회 쿼리
        $result = mysqli_query($connect, $s1); // 쿼리 실행
        $totrow = mysqli_num_rows($result); // 총 게시물 수
        $totpage = ceil($totrow / $line_page); // 총 페이지 수 계산
        $totblock = ceil($totpage / $block_page); // 총 블록 수 계산
        $cblock = ceil($page / $block_page); // 현재 블록 계산 (초기값:1)
        $frow = ($page - 1) * $line_page; // 현재 페이지의 첫 글 번호 계산

        // 현재 페이지에 해당하는 글 조회
        $selrec = "select * from board order by no desc limit $frow, $line_page";
        $info = mysqli_query($connect, $selrec); // 쿼리 실행

        // 게시물 출력
        while ($rowinfo = mysqli_fetch_array($info)) {
            echo "<tr>";
            echo "<td> $rowinfo[no] </td>"; // 게시물 번호
            echo "<td> <a href='postInfo.php?title=$rowinfo[title]'> $rowinfo[title] </a></td>"; // 제목 링크
            echo "<td> $rowinfo[irum] </td>"; // 작성자
            echo "<td> $rowinfo[regdate] </td>"; // 작성일
            echo "<td> $rowinfo[hits] </td>"; // 조회수
            echo "</tr>";
        }
        mysqli_close($connect); // DB 연결 종료
        ?>
    </table>
</body>
<?php
// 페이지 네비게이션 설정
$fpage = (($cblock - 1) * $block_page) + 1; // 현재 블록의 첫 페이지 번호
$lpage = min($totpage, $cblock * $block_page); // 현재 블록의 마지막 페이지 번호

// 첫 페이지로 이동 링크 생성
if ($page > 1) {
    echo "<a href='cwuBoard.php?page=1'>◀첫 페이지</a> "; 
}

// 이전 블록으로 이동 링크 생성
if ($cblock > 1) { 
    $prvblock = ($cblock - 1) * $block_page; 
    echo "<a href='cwuBoard.php?page=$prvblock'>◀이전</a> "; 
}

// 현재 블록의 페이지 링크 생성
for ($i = $fpage; $i <= $lpage; $i++) {
    if ($i == $page) {
        echo "<b id='ab'>[$i]</b>"; // 현재 페이지 강조 표시
    } else {
        echo "<a href='cwuBoard.php?page=$i'>[$i]</a>"; // 다른 페이지 링크
    }
}

// 다음 블록으로 이동 링크 생성
if ($cblock < $totblock) { 
    $nxtblock = $cblock * $block_page + 1;
    echo "<a href='cwuBoard.php?page=$nxtblock'>다음▶</a> "; 
}

// 마지막 페이지로 이동 링크 생성
if ($page < $totpage) {
    echo "<a href='cwuBoard.php?page=$totpage'>마지막 페이지▶</a>"; 
}
?>
