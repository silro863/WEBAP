<?php
if (
    isset($_POST['username']) &&
    isset($_POST['birthdate']) &&
    isset($_POST['gender']) &&
    isset($_POST['hometown']) &&
    isset($_POST['password']) &&
    isset($_POST['passwordc'])
) {
    $username = $_POST['username'];
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];
    $hometown = $_POST['hometown'];
    $password = $_POST['password'];
    $passwordc = $_POST['passwordc'];

    require_once("db_credentials.php");
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PW, DB_NAME);

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    $username = mysqli_real_escape_string($mysqli, $username);
    $birthdate = mysqli_real_escape_string($mysqli, $birthdate);
    $gender = mysqli_real_escape_string($mysqli, $gender);
    $hometown = mysqli_real_escape_string($mysqli, $hometown);
    
    $sql = "INSERT INTO trainers (username, birthdate, gender, hometown, password) VALUES ('$username', '$birthdate', '$gender', '$hometown', '$hashedPassword')";

    if ($mysqli->query($sql)) {
        echo "User registered successfully!";
        http_response_code(200);
    } else {
        echo "Error: " . $mysqli->error;
        http_response_code(500);
    }

    $mysqli->close();
} else {
    echo "Incomplete POST data.";
    http_response_code(400);
}
?>