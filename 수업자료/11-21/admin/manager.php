<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>청운대 전체 회원 현황</title>
        <style>
            /* 테이블 스타일 */
            table {
                width: 500px;
                border-collapse: collapse; /* 테이블 셀 경계선이 중복되지 않도록 설정 */
                margin: 20px auto; /* 테이블을 화면 중앙에 배치 */
            }
            /* 테이블 헤더 스타일 */
            th {
                color: white;
                background: #ee9911;
                padding: 10px;
                text-align: center; /* 헤더 내용 가운데 정렬 */
            }
            /* 테이블 데이터 스타일 */
            td {
                background: #aa55cc;
                color: white;
                font-size: 1.2em;
                padding: 10px;
                text-align: center; /* 셀 내용 가운데 정렬 */
            }
            /* 링크 스타일 */
            a {
                text-decoration: none;
                color: white;
            }
            a:hover {
                color: #ffcc00; /* 마우스 오버 시 링크 색상 변경 */
            }
            .back-link {
                display: block;
                margin: 20px auto;
                padding: 10px 20px;
                background-color: #ee9911;
                text-align: center;
                color: white;
                font-size: 1.1em;
                border-radius: 5px;
                width: 150px;
            }
            .back-link:hover {
                background-color: #dd8800; /* 마우스 오버 시 색상 변경 */
            }
        </style>
    </head>
    <body>
        <h2>청운대 전체 회원 현황</h2>
        
        <table>
            <tr>
                <th>아이디</th>
                <th>비밀번호</th>
                <th>가입일자</th>
                <th>보기</th>
            </tr>

            <?php
                // 데이터베이스 연결
                $connect = mysqli_connect("localhost", "root", "");
                mysqli_select_db($connect, "sample");
                mysqli_query($connect, 'set names utf8');
        
                // 회원 정보 조회 쿼리
                $sqlrec = "SELECT * FROM member ORDER BY regdate DESC";
                $info = mysqli_query($connect, $sqlrec);
        
                // 회원 정보를 테이블에 출력
                while ($rowinfo = mysqli_fetch_array($info)) {
                    echo "<tr>";
                    echo "<td>" . $rowinfo['id'] . "</td>";
                    echo "<td>" . $rowinfo['pwd'] . "</td>";
                    echo "<td>" . $rowinfo['regdate'] . "</td>";
                    echo "<td><a href='member_Detail.php?id=" . $rowinfo['id'] . "'>상세보기</a></td>";
                    echo "</tr>";
                }
        
                mysqli_close($connect);  // 연결 종료
            ?>
        </table>

        <!-- 이전 화면으로 돌아가는 링크 추가 -->
        <a href="javascript:history.back()" class="back-link">이전화면으로 돌아가기</a>
    </body>
</html>
