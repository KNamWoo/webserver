<?php
    $connect=mysqli_connect("localhost","root","");
    mysqli_select_db($connect,"sample");
    $str="CREATE TABLE board (
        no INT NOT NULL AUTO_INCREMENT,
        irum VARCHAR(10) NOT NULL,
        pwd VARCHAR(8) NOT NULL,
        title VARCHAR(50) NOT NULL,
        content TEXT NOT NULL,
        regdate DATE,
        hits INT,
        PRIMARY KEY (no)
    )";
    $qry=mysqli_query($connect,$str);
    if(!$qry){
        die("게시판 테이블 작성실패");
    }
    echo "게시판 테이블이 생성되었습니다.";
    mysqli_close($connect);
?>
