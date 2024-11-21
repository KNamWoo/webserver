<style>
    div {
        width: 350px;
        border-bottom: 1px dashed #cc9900;
        height: 28px;
        margin: 30px;
        padding: 5px;
        font-size: 1.2em;
    }
    input {
        color: #ddaa99;
        font-size: 1.1em;
    }
    a {
        text-decoration: none;
        font-size: 1.3em;
    }
    a:hover {
        color: #ddaa88;
    }
</style>

<?php
    $id = $_GET['id'];
    $connect = mysqli_connect("localhost", "root", "");
    mysqli_select_db($connect, "sample");
    mysqli_query($connect, 'set names utf8');
    $sqlrec = "SELECT * FROM member WHERE id='$id'";
    $info = mysqli_query($connect, $sqlrec);
    if (!$info)
        die("쿼리실패!!");
    $data = mysqli_fetch_array($info);
?>

<form>
    <h2> <?=$data['id']?> 회원 상세정보</h2>
    <div>이름 : <?=$data['irum']?></div>
    <div>아이디 : <?=$data['id']?></div>
    <div>별명 : <?=$data['nicname']?></div>
    <div>이메일 : <?=$data['email']?></div>
    <div>비밀번호 : <?=$data['pwd']?></div>
    <div>가입일자 : <?=$data['regdate']?></div>
</form>

<p><a href="javascript:history.back()">회원조회화면으로 이동</a></p>
