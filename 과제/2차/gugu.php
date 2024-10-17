<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>구구단 프로그램</title>
    <link rel="stylesheet" href="gugu.css">
</head>
<body>
    <?php

    echo "<font size = 5>구구단 프로그램</font><br><br>";
    echo "<div class='gugu-container'>";

    for ($Row = 1; $Row <= 9; $Row++) {
        $Col = 2;
        echo "<div class='gugu-row'>";
        while ($Col <= 9) {
            $Gop = $Col * $Row;
            echo "<div class='gugu-cell'>{$Col} * {$Row} = {$Gop}</div>";
            $Col++;
        }
        echo "</div>";
    }

    echo "</div>";
    ?>
</body>
</html>
