<?php
// 세션 시작
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 점수 저장 로직
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 로그인되지 않은 경우 로그인 페이지로 리다이렉션
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit;
    }

    $servername = "localhost";
    $username = "root"; // 데이터베이스 사용자 이름
    $password = ""; // 데이터베이스 비밀번호
    $dbname = "game_scores"; // 데이터베이스 이름

    $score = $_POST['score'];
    $player_name = $_SESSION['username']; // 세션에서 로그인한 사용자 이름을 가져옴
    $game_name = "maze"; // 게임 이름을 고정

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 점수를 데이터베이스에 저장
        $stmt = $conn->prepare("INSERT INTO scores (game_name, player_name, score) VALUES (:game_name, :player_name, :score)");
        $stmt->bindParam(':game_name', $game_name);
        $stmt->bindParam(':player_name', $player_name);
        $stmt->bindParam(':score', $score);
        $stmt->execute();

        echo "<script>alert('점수가 저장되었습니다!');</script>";
    } catch (PDOException $e) {
        echo "<script>alert('저장 중 오류 발생: " . $e->getMessage() . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Random Maze Generator</title>
</head>
<body>

<canvas id="maze"></canvas>

<br/>
<br/>

Maze Size : <input type="text" id="sizeInput" onkeyup="enterkey();"/>
<br/>
Min: 5, Max: 99 홀수만 가능

<br/>
<br/>

<label id="text"></label>

<script type="text/javascript">
var tc = 21; // 타일 개수 (홀수만 가능)
var gs = 20; // 그리드 크기
var field; // 맵 위치 배열, 0은 벽, 1~2는 길
var px = py = 1; // 0 <= px, py < tc
var xv = yv = 0;
var tracker;
var stack;
var stucked;

var cx, cy;
var moveCount = 0; // 이동 횟수 변수 추가

window.onload = function() {
    canv = document.getElementById("maze");    
    ctx = canv.getContext("2d");    
    document.addEventListener("keydown", keyPush);
    initialize();
}

function enterkey() {
    if (window.event.keyCode == 13) {
        var sizeInput = document.getElementById("sizeInput").value;
        if (sizeInput % 2 == 0) {
            alert("홀수만 입력하세요.");
        } else if (sizeInput < 5 || sizeInput > 99) {
            alert("5와 99 사이의 숫자를 입력하세요.");
        } else {
            tc = sizeInput;
            initialize();
        }
    }
}

function initialize() {
    document.getElementById("sizeInput").value = tc;
    make2DArray();
    
    ctx.fillStyle = "black";
    canv.width = canv.height = tc * gs;
    ctx.fillRect(0, 0, canv.width, canv.height);
    
    makeWay(0, 1);
    makeWay(tc - 1, tc - 2);
    
    px = py = 1;
    // 트래커 초기 위치
    tracker = {x: px, y: py};
    stack = [];
    stack.push(tracker);
    stucked = false;
    randomMazeGenerator();
    
    cx = 0; cy = 1;
    // 캐릭터 초기 위치
    ctx.fillStyle = "red";
    ctx.fillRect(cx * gs, cy * gs, gs, gs);
    
    moveCount = 0;
}

function makeWay(xx, yy) {
    field[yy][xx]++;
    ctx.fillStyle = "white";
    ctx.fillRect(xx * gs, yy * gs, gs, gs);
}

function keyPush(evt) {
    switch (evt.keyCode) {
    case 37:
        xv = -1; yv = 0;
        break;
    case 38:
        xv = 0; yv = -1;
        break;
    case 39:
        xv = 1; yv = 0;
        break;
    case 40:
        xv = 0; yv = 1;
        break;
    }
    cx += xv;
    cy += yv;
    if (cx < 0 || cx > tc - 1 || cy < 0 || cy > tc - 1 || field[cy][cx] == 0) {
        cx -= xv;
        cy -= yv;
        return;
    } else {
        ctx.fillStyle = "red";
        ctx.fillRect(cx * gs, cy * gs, gs, gs);
        ctx.fillStyle = "white";
        ctx.fillRect((cx - xv) * gs, (cy - yv) * gs, gs, gs);
        moveCount++; // 이동할 때마다 이동 횟수 증가
        document.getElementById("text").innerHTML = "이동 횟수: " + moveCount;
        if (cx == tc - 1 && cy == tc - 2) {
            alert("You Win! 이동 횟수: " + moveCount);
            saveScore(moveCount); // 게임이 끝나면 이동 횟수를 저장하는 함수 호출
            initialize();
        }
    }
}

function make2DArray() {
    field = new Array(parseInt(tc));
    for (var i = 0; i < field.length; i++) {
        field[i] = new Array(parseInt(tc));
    }
    for (var i = 0; i < field.length; i++) {
        for (var j = 0; j < field[i].length; j++) {
            field[i][j] = 0; // 0은 방문하지 않은 곳, 1은 방문한 곳, 2는 되돌아간 곳
        }
    }
}

function randomMazeGenerator() {
    var cnt = 0;
    while (stack.length > 0) {
        if (stucked)
            backtracking();
        else    
            tracking();
    }            
}

function tracking() {
    /* 랜덤 이동 */
    key = Math.floor(Math.random() * 4);
    switch (key) {
    case 0: // 왼쪽 이동
        xv = -2; yv = 0;
        break;
    case 1: // 위로 이동
        xv = 0; yv = -2;
        break;
    case 2: // 오른쪽 이동
        xv = 2; yv = 0;
        break;
    case 3: // 아래로 이동
        xv = 0; yv = 2;
        break;
    }
    
    px += xv;
    py += yv;
    if (px < 0 || px > tc - 1 || py < 0 || py > tc - 1) {
        px -= xv;
        py -= yv;
        return;
    } 
    if (field[py][px] < 1) {
        makeWay(px - xv / 2, py - yv / 2);
        makeWay(px, py);
        tracker = {x: px, y: py};
        stack.push(tracker);
        blockCheck();    
    } else {
        px -= xv;
        py -= yv;
        return;
    }
}

function blockCheck() {
    var blockCount = 0;
    if (py + 2 > tc - 1 || field[py + 2][px] != 0)
        blockCount++;
    if (py - 2 < 0 || field[py - 2][px] != 0)
        blockCount++;
    if (px + 2 > tc - 1 || field[py][px + 2] != 0)
        blockCount++;
    if (px - 2 < 0 || field[py][px - 2] != 0)
        blockCount++;
    if (blockCount >= 4)
        stucked = true;
    else
        stucked = false;
}

function backtracking() {
    var backtracker = stack.pop();
    px = backtracker.x;
    py = backtracker.y;
    blockCheck();    
}

// 이동 횟수를 MySQL에 저장하는 함수
function saveScore(score) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            alert("점수가 저장되었습니다.");
        }
    };
    xhr.send("score=" + score);
}
</script>

</body>
</html>
