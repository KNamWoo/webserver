<?php
  // 현재 시간
  date_default_timezone_set('Asia/Seoul');
  $now = time();

  // 서울 시간
  $seoul = getdate($now);
  print "서울 시간: " .
    $seoul['year'] . "년 " . $seoul['mon'] . "월 " . $seoul['mday'] . "일 " .
    $seoul['hours'] . "시 " . $seoul['minutes'] . "분 " .
    $seoul['seconds'] . "초<br>";

  // 뉴욕 시간
  date_default_timezone_set('America/New_York');
  $newyork = getdate();
  print "뉴욕 시간: " .
    $newyork['year'] . "년 " . $newyork['mon'] . "월 " . $newyork['mday'] . "일 " .
    $newyork['hours'] . "시 " . $newyork['minutes'] . "분 " .
    $newyork['seconds'] . "초<br>";

  // 파리 시간
  date_default_timezone_set('Europe/Paris');
  $paris = getdate();
  print "파리 시간: " .
    $paris['year'] . "년 " . $paris['mon'] . "월 " . $paris['mday'] . "일 " .
    $paris['hours'] . "시 " . $paris['minutes'] . "분 " .
    $paris['seconds'] . "초<br>";
?>
