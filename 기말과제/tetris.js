const canvas = document.getElementById("tetris");
const context = canvas.getContext("2d");

context.scale(20, 20);

// 테트리스 블록 데이터
function createPiece(type) {
    switch (type) {
        case "T": return [[0, 1, 0], [1, 1, 1], [0, 0, 0]];
        case "O": return [[1, 1], [1, 1]];
        case "L": return [[0, 0, 1], [1, 1, 1], [0, 0, 0]];
        case "J": return [[1, 0, 0], [1, 1, 1], [0, 0, 0]];
        case "I": return [[0, 0, 0, 0], [1, 1, 1, 1], [0, 0, 0, 0]];
        case "S": return [[0, 1, 1], [1, 1, 0], [0, 0, 0]];
        case "Z": return [[1, 1, 0], [0, 1, 1], [0, 0, 0]];
    }
}

// 충돌 감지
function collide(arena, player) {
    const [m, o] = [player.matrix, player.pos];
    for (let y = 0; y < m.length; y++) {
        for (let x = 0; x < m[y].length; x++) {
            if (m[y][x] !== 0 && (arena[y + o.y] && arena[y + o.y][x + o.x]) !== 0) {
                return true;
            }
        }
    }
    return false;
}

// 테트리스 맵 초기화
function createMatrix(w, h) {
    const matrix = [];
    while (h--) {
        matrix.push(new Array(w).fill(0));
    }
    return matrix;
}

// 테트리스 블록 병합
function merge(arena, player) {
    player.matrix.forEach((row, y) => {
        row.forEach((value, x) => {
            if (value !== 0) {
                arena[y + player.pos.y][x + player.pos.x] = value;
            }
        });
    });
}

// 행 제거
function sweep() {
    outer: for (let y = arena.length - 1; y > 0; y--) {
        for (let x = 0; x < arena[y].length; x++) {
            if (arena[y][x] === 0) {
                continue outer;
            }
        }
        const row = arena.splice(y, 1)[0].fill(0);
        arena.unshift(row);
        y++;
        player.score += 10;
    }
}

// 블록 회전
function rotate(matrix, dir) {
    for (let y = 0; y < matrix.length; y++) {
        for (let x = 0; x < y; x++) {
            [matrix[x][y], matrix[y][x]] = [matrix[y][x], matrix[x][y]];
        }
    }
    if (dir > 0) {
        matrix.forEach(row => row.reverse());
    } else {
        matrix.reverse();
    }
}

// 드로잉
function drawMatrix(matrix, offset) {
    matrix.forEach((row, y) => {
        row.forEach((value, x) => {
            if (value !== 0) {
                context.fillStyle = "red";
                context.fillRect(x + offset.x, y + offset.y, 1, 1);
            }
        });
    });
}

// 게임 드로잉
function draw() {
    context.fillStyle = "#000";
    context.fillRect(0, 0, canvas.width, canvas.height);
    drawMatrix(arena, { x: 0, y: 0 });
    drawMatrix(player.matrix, player.pos);
}

// 업데이트 루프
function update(time = 0) {
    const delta = time - lastTime;
    dropCounter += delta;
    if (dropCounter > dropInterval) {
        player.pos.y++;
        if (collide(arena, player)) {
            player.pos.y--;
            merge(arena, player);
            playerReset();
            sweep();
        }
        dropCounter = 0;
    }
    lastTime = time;
    draw();
    requestAnimationFrame(update);
}

// 블록 리셋
function playerReset() {
    const pieces = "TOLJISZ";
    player.matrix = createPiece(pieces[(pieces.length * Math.random()) | 0]);
    player.pos.y = 0;
    player.pos.x = (arena[0].length / 2) | 0 - (player.matrix[0].length / 2) | 0;
    if (collide(arena, player)) {
        arena.forEach(row => row.fill(0));
        player.score = 0;
    }
}

// 초기 변수 설정
const arena = createMatrix(12, 20);
const player = {
    pos: { x: 0, y: 0 },
    matrix: null,
    score: 0,
};

let dropCounter = 0;
let dropInterval = 1000;
let lastTime = 0;

document.addEventListener("keydown", event => {
    if (event.key === "ArrowLeft") {
        player.pos.x--;
        if (collide(arena, player)) {
            player.pos.x++;
        }
    } else if (event.key === "ArrowRight") {
        player.pos.x++;
        if (collide(arena, player)) {
            player.pos.x--;
        }
    } else if (event.key === "ArrowDown") {
        player.pos.y++;
        if (collide(arena, player)) {
            player.pos.y--;
        }
    } else if (event.key === "q") {
        rotate(player.matrix, -1);
    } else if (event.key === "w") {
        rotate(player.matrix, 1);
    }
});

playerReset();
update();
