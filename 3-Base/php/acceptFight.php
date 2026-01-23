<?php
// Start or resume the session
session_start();

// Check if the user is logged in (adjust this based on your authentication system)
if (!isset($_SESSION['user'])) {
    http_response_code(401); // Unauthorized
    echo "User not authenticated.";
    exit;
}

// User's trainer ID (replace with the actual ID)
$idTrainer = $_SESSION['id'];


// Check if the user is logged in (adjust this based on your authentication system)
if (!isset($_POST['battle'])) {
    http_response_code(401); // Unauthorized
    echo "No battle selected";
    exit;
}

// Check if the user is logged in (adjust this based on your authentication system)
if (!isset($_POST['pokemon'])) {
    http_response_code(401); // Unauthorized
    echo "No pokemon chosen";
    exit;
}

// Battle ID (replace with the actual ID)
$idBattle = $_POST['battle'];

// Pokémon ID chosen by the defendant (replace with the actual ID)
$idPokemonChosen = $_POST['pokemon'];

// Include database connection details
require_once("db_credentials.php");

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PW, DB_NAME);
if ($mysqli->connect_error) {
    http_response_code(500);
    echo json_encode(array("message" => "Database connection error."));
    exit;
}

$sqlCheckBattle = "SELECT idPokemonDefendant, idTrainerDefendant FROM battles WHERE idBattle = $idBattle";
$resultCheckBattle = $mysqli->query($sqlCheckBattle);

if (!$resultCheckBattle) {
    die("Query failed: " . $mysqli->error);
}

$row = $resultCheckBattle->fetch_assoc();
if (!$row) {
    die("Battle not found.");
}

$idPokemonDefendant = $row['idPokemonDefendant'];
$idTrainerDefendant = $row['idTrainerDefendant'];

// Check if the idPokemonDefendant is empty (null)
if (is_null($idPokemonDefendant)) {
    // Check if the user's trainer ID matches the idTrainerDefendant in the battle
    if ($idTrainer === $idTrainerDefendant) {
        $sqlCheckPokemonOwnership = "SELECT idPokemon FROM pokemon WHERE idTrainer = $idTrainer AND idPokemon = $idPokemonChosen";
        $resultCheckPokemonOwnership = $mysqli->query($sqlCheckPokemonOwnership);

        if (!$resultCheckPokemonOwnership) {
            die("Query failed: " . $mysqli->error);
        }

        if ($resultCheckPokemonOwnership->num_rows > 0) {
            $sqlUpdateBattle = "UPDATE battles SET idPokemonDefendant = $idPokemonChosen WHERE idBattle = $idBattle";
            if ($mysqli->query($sqlUpdateBattle)) {
                echo "Pokémon chosen successfully.";
            } else {
                echo "Error: " . $mysqli->error;
            }
        } else {
            echo "The chosen Pokémon does not belong to you.";
        }
    } else {
        echo "You are not the defendant in this battle.";
    }
} else {
    echo "The defendant has already chosen a Pokémon for this battle.";
}

$mysqli->close();
?>