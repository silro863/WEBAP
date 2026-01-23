<?php
require_once("db_credentials.php");

if (isset($_POST['username'])) {
    $username = mysqli_real_escape_string(new mysqli(DB_HOST, DB_USER, DB_PW, DB_NAME), $_POST['username']);
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PW, DB_NAME);

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $sql = "SELECT username FROM trainers WHERE username = '$username'";
    $result = $mysqli->query($sql);

    if (!$result) {
        echo "Query failed: " . $mysqli->error;
        http_response_code(500);
        exit;
    }

    if ($result->num_rows > 0) {
        echo "exsists";
        http_response_code(200);
    } else {
        echo "ok";
        http_response_code(200);
    }

    $mysqli->close();
} else {
    echo "Invalid POST data.";
    http_response_code(400);
}
?>


