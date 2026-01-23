<?php

session_start();

if (!isset($_SESSION['id'])) {
    http_response_code(401);
    echo json_encode(array("message" => "User not authenticated."));
    exit;
}

$idTrainer = $_SESSION['id'];

require_once("db_credentials.php");

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PW, DB_NAME);

$sql = "SELECT trainers.idTrainer, trainers.username,
               COUNT(pokemon.idPokemon) AS pokemonCount
        FROM trainers
        LEFT JOIN pokemon ON trainers.idTrainer = pokemon.idTrainer
        WHERE trainers.idTrainer <> $idTrainer AND trainers.idTrainer <> 0
        GROUP BY trainers.idTrainer, trainers.username";

$result = $mysqli->query($sql);

if (!$result) {
    die("Query failed: " . $mysqli->error);
}

$opponents = array();
for ($i = 0; $i < $result->num_rows; $i++) {
    $row = $result->fetch_assoc();
    $opponents[] = $row;
}

$mysqli->close();

header('Content-Type: application/json');

echo json_encode($opponents);
?>