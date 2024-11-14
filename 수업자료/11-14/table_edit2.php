<?php
    $jcode=$_POST["jcode"];
    $irum=$_POST["irum"];
    
    //계정 및 테이블 정보 정보
    $connect=mysqli_connect("localhost","root","");//mysql에 로그인
    mysqli_select_db($connect,"sample");
    
    //수정
    $editdata="update goods set irum='$irum' where jcode='$jcode'";
    $info=mysqli_query($connect,$editdata);
    if(!$info){
        die("수정에 실패했습니다.");
    }
    echo("수정작업성공");
    mysqli_close($connect);
?>
