<?php
// Start or resume the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(array("message" => "User not authenticated."));
    exit;
}

// Check if battle ID is provided
if (!isset($_GET['battle'])) {
    http_response_code(400); // Bad Request
    echo json_encode(array("message" => "Battle ID not provided."));
    exit;
}

$idBattle = $_GET['battle'];
$idTrainer = $_SESSION['id'];

// Include database connection details
require_once("db_credentials.php");

// Create a new MySQLi connection
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PW, DB_NAME);

// Check if the connection was successful
if ($mysqli->connect_error) {
    http_response_code(500); // Internal Server Error
    echo json_encode(array("message" => "Database connection error."));
    exit;
}

$mysqli->set_charset("utf8");

$sql = "SELECT 
            b.idBattle, 
            b.idPokemonChallenger, 
            b.idPokemonDefendant,
            b.idTrainerChallenger,
            b.idTrainerDefendant,
            b.arena,
            b.turn,
            pc.idSpecies AS challenger_species,
            pc.nickname AS challenger_nickname,
            pc.level AS challenger_level,
            pc.health AS challenger_health,
            pd.idSpecies AS defender_species,
            pd.nickname AS defender_nickname,
            pd.level AS defender_level,
            pd.health AS defender_health,
            tc.username AS challenger_username,
            td.username AS defender_username
        FROM battles b
        LEFT JOIN pokemon pc ON b.idPokemonChallenger = pc.idPokemon
        LEFT JOIN pokemon pd ON b.idPokemonDefendant = pd.idPokemon
        JOIN trainers tc ON b.idTrainerChallenger = tc.idTrainer
        JOIN trainers td ON b.idTrainerDefendant = td.idTrainer
        WHERE b.idBattle = $idBattle";

$result = $mysqli->query($sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(array("message" => "Query failed: " . $mysqli->error));
    exit;
}

$battle = $result->fetch_assoc();

if (!$battle) {
    http_response_code(404);
    echo json_encode(array("message" => "Battle not found."));
    exit;
}

// Format the response
$fightData = array(
    "idBattle" => $battle['idBattle'],
    "arena" => $battle['arena'],
    "turn" => $battle['turn'],
    "challenger" => array(
        "idTrainer" => $battle['idTrainerChallenger'],
        "username" => $battle['challenger_username'],
        "idPokemon" => $battle['idPokemonChallenger'],
        "nickname" => $battle['challenger_nickname'],
        "level" => $battle['challenger_level'],
        "health" => $battle['challenger_health'],
        "maxHealth" => 100,
        "idSpecies" => $battle['challenger_species']
    ),
    "defender" => array(
        "idTrainer" => $battle['idTrainerDefendant'],
        "username" => $battle['defender_username'],
        "idPokemon" => $battle['idPokemonDefendant'],
        "nickname" => $battle['defender_nickname'],
        "level" => $battle['defender_level'],
        "health" => $battle['defender_health'],
        "maxHealth" => 100,
        "idSpecies" => $battle['defender_species']
    ),
    "isPlayerChallenger" => ($battle['idTrainerChallenger'] == $idTrainer),
    "isPlayerDefender" => ($battle['idTrainerDefendant'] == $idTrainer)
);

$mysqli->close();

header('Content-Type: application/json');
echo json_encode($fightData);
?>
