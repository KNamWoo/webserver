<?php
// URL 파라미터에서 's' 값을 가져옵니다.
$s = isset($_GET['s']) ? $_GET['s'] : null; // 's' 값이 없으면 null로 설정

// 랜덤한 값 생성
mt_srand((double)microtime() * 1000000); // 난수 생성기 초기화
$random = mt_rand(0, 2); // 0부터 2 사이의 랜덤 숫자 생성

// 컴퓨터의 선택 결정
switch ($random) {
    case 0: $c = "가위"; break; // 랜덤 값이 0일 때 가위
    case 1: $c = "바위"; break; // 랜덤 값이 1일 때 바위
    case 2: $c = "보"; break;   // 랜덤 값이 2일 때 보
}

print "사용자는 ".$s."를 선택했습니다. <br>"; //사용자의 선택
print "컴퓨터는 ".$c."를 선택했습니다. "; // 컴퓨터의 선택 출력

// 결과 판단
if ($s === null) {
    print "=> 잘못된 입력입니다."; // 잘못된 입력 처리
} else if ($s == $c) {
    print "=> 비겼습니다."; // 비긴 경우
} else if (($s == "가위" && $c == "보") || ($s == "바위" && $c == "가위") || ($s == "보" && $c == "바위")) {
    print "=> 이겼습니다."; // 이긴 경우
} else {
    print "=> 졌습니다."; // 진 경우
}
?>
