<?php
    $id=$_POST['id'];
    $pwd=$_POST['pwd'];
    $connect=mysqli_connect("localhost","root","");
    mysqli_select_db($connect,"sample");
    mysqli_query($connect,'set names utf8');
    $sqlrec="select * from manager where id='$id' and pwd='$pwd'";
    $info=mysqli_query($connect,$sqlrec);
    if(!$info){
        echo "<script>alert('아이디 또는 비밀번호가 일치하지 않습니다.');history.back();</script>";
        exit;
    }

    // 첫 번째 인자: $info, 두 번째 인자: MYSQLI_ASSOC
    $a = mysqli_fetch_array($info, MYSQLI_ASSOC);
?>

<h3>청운대발전을 위해</h3>
<?php echo $id ?>님 반갑습니다.<br>
<div>
    <ul>
        <li><a href="manager.php">회원관리</a></li>
        <li><a href="#">상품입고관리</a></li>
        <li><a href="#">상품재고관리</a></li>
        <li><a href="#">거래처관리</a></li>
    </ul>
</div>
