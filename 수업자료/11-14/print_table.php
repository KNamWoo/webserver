<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <style>
         td{
            background: #94aaee;
            font-size: 1.2em;
         }
      </style>
      <title>Document</title>
   </head>
   <body>
      <?php
        $connect=mysqli_connect("localhost", "root", "");
        mysqli_select_db($connect, "sample");
        
        $sqlrec="select * from goods";
        $info=mysqli_query($connect, $sqlrec);
        echo "<table>";
        while ($i=mysqli_fetch_array($info)) {
            echo "<tr>";
            echo "<td> 제품코드 : $i[jcode] </td> ";
            echo "<td> 제품명 : $i[irum] </td>";
            echo "<td> 수량 : $i[que] </td>";
            echo "<td> 단가 : $i[price] </td>";
            echo "</tr>";
        }
        echo "</table>";
        mysqli_close($connect);
      ?>
   </body>
</html>