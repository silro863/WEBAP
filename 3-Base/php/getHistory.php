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

$sql = "SELECT battles.idBattle, battles.idPokemonDefendant, battles.idPokemonChallenger,
               battles.idWinner, battles.arena, battles.idTrainerChallenger, battles.idTrainerDefendant,
               battles.turn, trainers.username AS challenger_username
        FROM battles
        JOIN trainers ON battles.idTrainerChallenger = trainers.idTrainer
        WHERE (battles.idTrainerDefendant = $idTrainer OR battles.idTrainerChallenger = $idTrainer) AND battles.turn >= 1 AND battles.idWinner IS NOT NULL";

$result = $mysqli->query($sql);

if (!$result) {
    die("Query failed: " . $mysqli->error);
}

$battles = array();
for ($i = 0; $i < $result->num_rows; $i++) {
    $row = $result->fetch_assoc();
    $battles[] = $row;
}

$mysqli->close();

echo json_encode($battles);
?>