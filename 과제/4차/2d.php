<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2D</title>
    <style>
        .cell {
            display: inline-block;
            width: 80px;
            height: 30px;
            padding: 5px;
            text-align: center;
            font-size: 20px;
        }
        .row {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <?php
        // 함수: 학생별 총점 계산
        function calculateStudentTotals(&$student) { // 매개변수로 전달한 값
            $new = [];
            $rowCount = count($student);
            $columnCount = count($student[0]);
            for ($i = 0; $i < $columnCount; $i++) { // 세로
                $sum = 0;
                for ($j = 0; $j < $rowCount; $j++) {
                    $sum += $student[$j][$i];
                }
                $new[] = $sum; // 과목별 총점
            }
            $student[] = $new; // 새 행 추가
        }

        // 함수: 과목별 총점 계산
        function calculateSubjectTotals(&$student) { // 매개변수로 전달한 값
            $rowCount = count($student); // 세로 길이
            $columnCount = count($student[0]); // 가로 길이
            for ($i = 0; $i < $columnCount; $i++) { // 가로
                $sum = 0;
                for ($j = 0; $j < $rowCount; $j++) {
                    $sum += $student[$i][$j];
                }
                $student[$i][] = $sum; // 학생별 총점 추가
            }
        }

        // 함수: 과목 평균 계산
        function calculateSubjectAverages(&$student) { // 매개변수로 전달한 값
            $rowCount = count($student);
            $columnCount = count($student[0]);
            $averages = [];
            for ($i = 0; $i < $columnCount; $i++) {
                $averages[] = number_format($student[3][$i] / 3, 2); // 과목 평균
            }
            $student[] = $averages; // 평균 행 추가
        }

        // 함수: 학생별 평균 계산
        function calculateStudentAverages(&$student) { // 매개변수로 전달한 값
            for ($i = 0; $i < 5; $i++) { // 가로
                $student[$i][] = number_format($student[$i][4] / 4, 2); // 학생별 평균 추가
            }
        }

        // 출력 함수
        function displayTable($student) { // 매개변수로 전달한 값
            foreach ($student as $row) {
                echo "<div class='2d'>";
                foreach ($row as $element) {
                    echo "<div class='cell'>";
                    echo $element;
                    echo "</div>";
                }
                echo "</div>";
            }
        }

        // 메인 코드
        $student = [
            [100, 91, 90, 69],
            [99, 89, 81, 60],
            [80, 79, 70, 59]
        ];

        // 함수 호출
        calculateStudentTotals($student); // 매개변수로 전달한 값
        calculateSubjectTotals($student); // 매개변수로 전달한 값
        calculateSubjectAverages($student); // 매개변수로 전달한 값
        calculateStudentAverages($student); // 매개변수로 전달한 값

        // 결과 출력
        displayTable($student); // 매개변수로 전달한 값
    ?>
</body>
</html>
