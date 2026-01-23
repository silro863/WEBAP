<?php
session_start();

if (!isset($_SESSION['id'])) {
    http_response_code(401);
    echo json_encode(array("hasNew" => false));
    exit;
}

if (!isset($_GET['trainer'])) {
    http_response_code(400);
    echo json_encode(array("hasNew" => false));
    exit;
}

$otherTrainerId = $_GET['trainer'];
$currentTrainerId = $_SESSION['id'];

require_once("db_credentials.php");

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PW, DB_NAME);

if ($mysqli->connect_error) {
    http_response_code(500);
    echo json_encode(array("hasNew" => false));
    exit;
}

$mysqli->set_charset("utf8");

$sql = "SELECT 
            m.message,
            t.username as senderName,
            m.timestamp
        FROM messages m
        JOIN trainers t ON m.idSender = t.idTrainer
        WHERE m.idSender = $otherTrainerId AND m.idReceiver = $currentTrainerId AND m.isRead = 0
        ORDER BY m.timestamp DESC
        LIMIT 1";

$result = $mysqli->query($sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(array("hasNew" => false));
    exit;
}

$response = array("hasNew" => false);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $response = array(
        "hasNew" => true,
        "message" => $row['message'],
        "senderName" => $row['senderName'],
        "timestamp" => $row['timestamp']
    );

    $updateSql = "UPDATE messages SET isRead = 1 WHERE idSender = $otherTrainerId AND idReceiver = $currentTrainerId AND isRead = 0";
    $mysqli->query($updateSql);
}

$mysqli->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
