<!DOCTYPE HTML>
<html> 
<head>
<title> 컴퓨터공학과 </title>
</head>
<body>
<h2>  웹서버 프로그래밍 과제4 </h2>
<head>
<?PHP
// 성적 배열 정의
$student = array( array(100, 91, 90, 69,0),
                 array(99, 89, 81, 60,0),
                 array(80, 79, 70, 59,0),
                array(0, 0, 0, 0, 0));

// 학생 성적처리
$temp = 0;
 for ($i=0; $i<3; $i++)
     for($j=0; $j<4; $j++) {
         $student[$i][4] += $student[$i][$j];  //성적 계산
         $student[3][$j] += $student[$i][$j];  //과목별 총점 계산
         $temp += $student[$i][$j];               //모든 점수 총합 계산
         } 
      $student[$i][$j] = $temp;

// 성적처리 결과 출력
    echo "<pre>";
	for($i=0; $i<4; $i++) {
		 for ($j=0; $j<5; $j++) 
	     printf("%8d", $student[$i][$j]);
         echo "<br>";
	     }
    echo "</pre>";
?>
</body>
</html>
