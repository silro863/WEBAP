<?php

if(!isset($_POST['username']) || !isset($_POST['password'])) {
    echo("Invalid Post Parameters");
    http_response_code(400); 
    die();
}

session_start();

require_once ("./db_credentials.php");
$mysqli = new mysqli(DB_HOST,DB_USER,DB_PW,DB_NAME);

if ($mysqli->connect_errno) {
    echo "Sorry, this website is experiencing problems.";
    exit;
}

// Change character set to utf8
$mysqli -> set_charset("utf8");

$username = mysqli_real_escape_string($mysqli, $_POST['username']);
$sql = "SELECT idTrainer, password, username FROM trainers WHERE username='$username'";
$result = $mysqli->query($sql);

if (!$result) {
    echo "Query failed: " . $mysqli->error;
    http_response_code(500);
    exit;
}

if ($result->num_rows == 1) {
    $password = $_POST['password'];
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        $_SESSION["user"] = $row['username'];
        $_SESSION["id"] = $row['idTrainer'];
        echo("Login successful");
        http_response_code(200);
    } else {
        echo("Password incorrect");
        http_response_code(403);
    }
} else {
    echo("Username not found");
    http_response_code(404);
}

$mysqli -> close();