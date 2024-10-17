<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2D</title>
    <style>
        .cell{
            display: inline-block;
            width: 60px;
            height: 10px;
            padding: 5px;
            text-align: right;
            font-size: 20px;
        }
        .row{
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <?php
        $student = array(
            array(100, 91, 90, 69),
            array(99, 89, 81, 60),
            array(80, 79, 70, 59)
        );
        $new = [];
        $rowCount = count($student);//세로 길이=3
        $columnCount = count($student[0]);//가로 길이=4
        $sum = 0;

        for($i=0; $i<$columnCount; $i++){//세로 더하기
            $sum = 0;
            for ($j=0; $j < $rowCount; $j++) {
                $sum += $student[$j][$i];
            }
            $new[] = $sum;
        }

        $student[] = $new;

        $rowCount = count($student);//세로 길이
        $columnCount = count($student[0]);//가로 길이

        for($i=0; $i<$columnCount; $i++){//가로 더하기
            $sum = 0;
            for ($j=0; $j < $rowCount; $j++) { 
                $sum += $student[$i][$j];
            }
            $student[$i][] = $sum;
        }

        foreach ($student as $row) {
            echo "<div class='2d'>";
            foreach ($row as $element) {
                echo "<div class='cell'>";
                echo $element;
                echo "</div>";
            }
            echo "</div>";
        }
    ?>
</body>
</html>