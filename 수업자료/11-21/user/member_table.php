<?php
    $connect = mysqli_connect("localhost","root","");
    mysqli_select_db($connect,"sample");
    $str = "create table member(irum varchar(10) not null,id varchar(13) not null,nicname varchar(10) not null,email varchar(30) not null,pwd  varchar(15) not null, regdate date,primary key(id))";

    $qry = mysqli_query($connect,$str);
    if(!$qry){
        die("테이블 작성실패");
    }
    else{
        echo "테이블이 생성되었습니다.";
    }
    mysqli_close($connect);
?>
