<?php
session_start();

// 초기화
if (!isset($_SESSION['player'])) {
    $_SESSION['player'] = [
        'name' => 'Hero',
        'health' => 100,
        'attack' => 20,
        'defense' => 10
    ];
    $_SESSION['monster'] = [
        'name' => 'Goblin',
        'health' => 50,
        'attack' => 15
    ];
    $_SESSION['message'] = "The battle begins!";
}

// 전투 로직
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $player = &$_SESSION['player'];
    $monster = &$_SESSION['monster'];

    if ($action === 'attack') {
        $damage = max(0, $player['attack'] - rand(0, $monster['attack']));
        $monster['health'] -= $damage;
        $_SESSION['message'] = "You attacked the {$monster['name']} for $damage damage!";

        if ($monster['health'] > 0) {
            $damage = max(0, $monster['attack'] - rand(0, $player['defense']));
            $player['health'] -= $damage;
            $_SESSION['message'] .= " The {$monster['name']} attacked you for $damage damage!";
        } else {
            $_SESSION['message'] .= " You defeated the {$monster['name']}!";
        }
    } elseif ($action === 'heal') {
        $heal = rand(10, 30);
        $player['health'] = min(100, $player['health'] + $heal);
        $_SESSION['message'] = "You healed yourself for $heal health.";
    }

    if ($player['health'] <= 0) {
        $_SESSION['message'] = "You were defeated by the {$monster['name']}!";
        session_destroy();
    } elseif ($monster['health'] <= 0) {
        $_SESSION['message'] .= " You are victorious!";
        session_destroy();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple RPG</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .status {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            margin: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Simple RPG Game</h1>
    <div class="status">
        <h2>Player: <?= $_SESSION['player']['name'] ?></h2>
        <p>Health: <?= $_SESSION['player']['health'] ?></p>
        <p>Attack: <?= $_SESSION['player']['attack'] ?></p>
        <p>Defense: <?= $_SESSION['player']['defense'] ?></p>
    </div>
    <div class="status">
        <h2>Monster: <?= $_SESSION['monster']['name'] ?></h2>
        <p>Health: <?= $_SESSION['monster']['health'] ?></p>
        <p>Attack: <?= $_SESSION['monster']['attack'] ?></p>
    </div>
    <p><?= $_SESSION['message'] ?></p>
    <form method="POST">
        <button name="action" value="attack">Attack</button>
        <button name="action" value="heal">Heal</button>
    </form>
</body>
</html>
