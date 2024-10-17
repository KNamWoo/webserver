<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABCDE</title>
</head>
<body>
    <?php
    $ABCDE = "ABCDE";

    for ($Row = -4; $Row <= 4; $Row++) {
        echo "<br>";
        if($Row < 0){
            for ($i=0; $i <= abs($Row+4); $i++) { 
                echo $ABCDE[$i]." ";
            }//-4-3-2-1
        }else{
            for ($i=0; $i <= abs($Row-4); $i++) { 
                echo $ABCDE[$i]." ";
            }//01234
        }
    }
    ?>
</body>
</html>
