<?php
session_start();

if (!isset($_SESSION['id'])) {
    http_response_code(401);
    echo json_encode(array("message" => "User not authenticated."));
    exit;
}

require_once("db_credentials.php");
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PW, DB_NAME);

if ($mysqli->connect_error) {
    http_response_code(500);
    echo json_encode(array("message" => "Database connection error."));
    exit;
}

$mysqli->set_charset("utf8");
$trainerId = $_SESSION['id'];

$sql = "SELECT idPokemon, name, level, currentHp, maxHp FROM pokemonteam WHERE idTrainer = $trainerId ORDER BY position ASC";
$result = $mysqli->query($sql);

if (!$result) {
    http_response_code(500);
    echo "Query failed: " . $mysqli->error;
    exit;
}

if ($result->num_rows > 0) {
    for ($i = 0; $i < $result->num_rows; $i++) {
        $row = $result->fetch_assoc();
        $pokemonId = str_pad($row['idPokemon'], 3, "0", STR_PAD_LEFT);
        $currentHp = $row['currentHp'];
        $maxHp = $row['maxHp'];
        $healthPercent = ($currentHp / $maxHp) * 100;
        
        if ($healthPercent > 70) {
            $healthClass = "full-health";
        } elseif ($healthPercent >= 30) {
            $healthClass = "medium-health";
        } else {
            $healthClass = "low-health";
        }
        
        $html .= '<section class="section">';
        $html .= '<h2>Name: ' . htmlspecialchars($row['name']) . '</h2>';
        $html .= '<p>Level: ' . $row['level'] . '</p>';
        $html .= '<img id="opponentimg" src="assets/pokedata/thumbnails/' . $pokemonId . '.png" alt="' . htmlspecialchars($row['name']) . '">';
        $html .= '<div class="pokemon-health">';
        $html .= '<div class="health-bar">';
        $html .= '<div class="current-health ' . $healthClass . '" style="width:' . $healthPercent . '%">';
        $html .= '<div class="health-text"><span class="current-hp">' . $currentHp . '</span>/<span class="max-hp">' . $maxHp . '</span> HP</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</section>';
    }
} else {
    $html = '<p>No Pokémon on your team yet!</p>';
}

$mysqli->close();

echo $html;
?>
