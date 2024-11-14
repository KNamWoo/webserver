<?php
    $connect=mysqli_connect("localhost","root","");
    if(!$connect)
        die("db connect error". mysqli_error());
    mysqli_select_db($connect,"sample");

    $str="create table goods(jcode char(5) not null,irum varchar(20) not null, que int(4),price int(8),primary key(jcode))";

    $qury=mysqli_query($connect,$str);
    if(!$qury)
    die("테이블 작성 오류");
    else
    echo("테이블 작성 성공");
    mysqli_close($connect);
?>
