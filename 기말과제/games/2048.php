<?php
// 점수 저장 로직
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(session_status() == PHP_SESSION_NONE) {
        session_start(); // 세션 시작
    }

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
    $player_name = $_SESSION['username']; // 세션에서 가져온 플레이어 이름
    $game_name = "2048"; // 게임 이름을 고정

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO scores (game_name, player_name, score) VALUES ('2048', :player_name, :score)");
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2048</title>
    <style>
        #table {
            border-collapse: collapse;
            user-select: none;
        }

        #table td {
            border: 10px solid #bbada0;
            width: 116px;
            height: 128px;
            font-size: 50px;
            font-weight: bold;
            text-align: center;
        }

        #score {
            user-select: none;
            font-size: 50px;
            color: navy;
        }
        #back, #save {
            width: 100px;
            height: 40px;
            font-size: 20px;
            margin: 5px;
        }

        .color-2 { background-color: #eee4da; color: #776e55; }
        .color-4 { background-color: #eee1c9; color: #776e55; }
        .color-8 { background-color: #f3b27a; color: white; }
        .color-16 { background-color: #f69664; color: white; }
        .color-32 { background-color: #f77c5f; color: white; }
        .color-64 { background-color: #f75f3b; color: white; }
        .color-128 { background-color: #edd073; color: #776e55; }
        .color-256 { background-color: #edcc62; color: #776e55; }
        .color-512 { background-color: #edc950; color: #776e55; }
        .color-1024 { background-color: #edc53f; color: #776e55; }
        .color-2048 { background-color: #edc22e; color: #776e55; }
    </style>
</head>
<body>
    <table id="table"></table>
    <div>
        <span id="score">0점</span>
        <button id="back">되돌리기</button>
        <form method="POST" style="display: inline;">
            <input type="hidden" name="score" id="score-input">
            <input type="hidden" name="player_name" id="player-name-input">
            <button type="submit" id="save">점수 저장</button>
        </form>
    </div>

    <script>
        const $table = document.querySelector("#table");
        const $score = document.querySelector("#score");
        const $back = document.querySelector("#back");
        let data = [];
        const history = [];

        $back.addEventListener("click", () => {
            const prevData = history.pop();
            if (!prevData) return;
            $score.textContent = prevData.score;
            data = prevData.table;
            draw();
        });

        function startGame() {
            const $fragment = document.createDocumentFragment();
            [1, 2, 3, 4].forEach(function () {
                const rowData = [];
                data.push(rowData);
                const $tr = document.createElement("tr");
                [1, 2, 3, 4].forEach(() => {
                    rowData.push(0);
                    const $td = document.createElement("td");
                    $tr.appendChild($td);
                });
                $fragment.appendChild($tr);
            });
            $table.appendChild($fragment);
            put2ToRandomCell();
            draw();
        }

        function put2ToRandomCell() {
            const emptyCells = [];
            data.forEach((rowData, i) => {
                rowData.forEach((cellData, j) => {
                    if (!cellData) emptyCells.push([i, j]);
                });
            });
            const randomCell = emptyCells[Math.floor(Math.random() * emptyCells.length)];
            data[randomCell[0]][randomCell[1]] = 2;
        }

        function draw() {
            data.forEach((rowData, i) => {
                rowData.forEach((cellData, j) => {
                    const $target = $table.children[i].children[j];
                    if (cellData > 0) {
                        $target.textContent = cellData;
                        $target.className = `color-` + cellData;
                    } else {
                        $target.textContent = "";
                        $target.className = "";
                    }
                });
            });
        }

        startGame();

        function moveCells(direction) {
            history.push({
                table: JSON.parse(JSON.stringify(data)),
                score: $score.textContent,
            });

            let moved = false;
            if (direction === "up") {
                for (let j = 0; j < 4; j++) {
                    const column = [data[0][j], data[1][j], data[2][j], data[3][j]];
                    const newColumn = merge(column);
                    for (let i = 0; i < 4; i++) {
                        if (data[i][j] !== newColumn[i]) moved = true;
                        data[i][j] = newColumn[i];
                    }
                }
            } else if (direction === "down") {
                for (let j = 0; j < 4; j++) {
                    const column = [data[3][j], data[2][j], data[1][j], data[0][j]];
                    const newColumn = merge(column);
                    for (let i = 0; i < 4; i++) {
                        if (data[3 - i][j] !== newColumn[i]) moved = true;
                        data[3 - i][j] = newColumn[i];
                    }
                }
            } else if (direction === "left") {
                for (let i = 0; i < 4; i++) {
                    const row = data[i];
                    const newRow = merge(row);
                    for (let j = 0; j < 4; j++) {
                        if (data[i][j] !== newRow[j]) moved = true;
                        data[i][j] = newRow[j];
                    }
                }
            } else if (direction === "right") {
                for (let i = 0; i < 4; i++) {
                    const row = [...data[i]].reverse();
                    const newRow = merge(row);
                    for (let j = 0; j < 4; j++) {
                        if (data[i][3 - j] !== newRow[j]) moved = true;
                        data[i][3 - j] = newRow[j];
                    }
                }
            }

            if (moved) {
                put2ToRandomCell();
                draw();

                // 2048 확인
                if (data.flat().includes(2048)) {
                    setTimeout(() => {
                        alert(`축하합니다! 2048을 만들었습니다. ${$score.textContent}`);
                    }, 0);
                }

                // 게임 오버 확인
                if (!data.flat().includes(0) && !canMove()) {
                    alert(`패배했습니다. ${$score.textContent}`);
                }
            }
        }

        function merge(line) {
            const newLine = line.filter(cell => cell);
            for (let i = 0; i < newLine.length - 1; i++) {
                if (newLine[i] === newLine[i + 1]) {
                    newLine[i] *= 2;
                    $score.textContent = parseInt($score.textContent) + newLine[i];
                    newLine[i + 1] = 0;
                }
            }
            return [...newLine.filter(cell => cell), ...Array(4 - newLine.filter(cell => cell).length).fill(0)];
        }

        function canMove() {
            for (let i = 0; i < 4; i++) {
                for (let j = 0; j < 4; j++) {
                    if (data[i][j] === 0) return true;
                    if (j < 3 && data[i][j] === data[i][j + 1]) return true;
                    if (i < 3 && data[i][j] === data[i + 1][j]) return true;
                }
            }
            return false;
        }

        window.addEventListener("keyup", (event) => {
            if (event.key === "ArrowUp") moveCells("up");
            else if (event.key === "ArrowDown") moveCells("down");
            else if (event.key === "ArrowLeft") moveCells("left");
            else if (event.key === "ArrowRight") moveCells("right");
        });

        // 점수 저장 버튼 클릭 시 자동으로 player_name 입력
        document.querySelector("#save").addEventListener("click", (event) => {
            // player_name은 이미 세션에서 받아와서 입력된 상태이므로 추가로 입력 받을 필요 없음
            document.querySelector("#score-input").value = $score.textContent.replace("점", "");
            document.querySelector("#player-name-input").value = "<?php echo $_SESSION['username']; ?>";
        });
    </script>
</body>
</html>
