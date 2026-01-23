<?php
session_start();

if (!isset($_SESSION['id'])) {
    http_response_code(401);
    echo json_encode(array("message" => "User not authenticated."));
    exit;
}

if (!isset($_GET['trainer'])) {
    http_response_code(400);
    echo json_encode(array("message" => "Trainer ID not provided."));
    exit;
}

$otherTrainerId = $_GET['trainer'];
$currentTrainerId = $_SESSION['id'];

require_once("db_credentials.php");

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PW, DB_NAME);

if ($mysqli->connect_error) {
    http_response_code(500);
    echo json_encode(array("message" => "Database connection error."));
    exit;
}

$mysqli->set_charset("utf8");

if ($otherTrainerId == "all") {
    $sql = "SELECT 
                m.idMessage,
                m.message,
                m.timestamp,
                m.idSender,
                m.idReceiver,
                t.username as senderName
            FROM messages m
            JOIN trainers t ON m.idSender = t.idTrainer
            WHERE m.idSender = $currentTrainerId OR m.idReceiver = $currentTrainerId
            ORDER BY m.timestamp ASC";
} else {
    $sql = "SELECT 
                m.idMessage,
                m.message,
                m.timestamp,
                m.idSender,
                t.username as senderName
            FROM messages m
            JOIN trainers t ON m.idSender = t.idTrainer
            WHERE (m.idSender = $currentTrainerId AND m.idReceiver = $otherTrainerId) 
               OR (m.idSender = $otherTrainerId AND m.idReceiver = $currentTrainerId)
            ORDER BY m.timestamp ASC";
}

$result = $mysqli->query($sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(array("message" => "Query failed: " . $mysqli->error));
    exit;
}

$messages = array();
for ($i = 0; $i < $result->num_rows; $i++) {
    $row = $result->fetch_assoc();
    $messages[] = array(
        "idMessage" => $row['idMessage'],
        "message" => $row['message'],
        "timestamp" => $row['timestamp'],
        "senderName" => $row['senderName'],
        "isSent" => ($row['idSender'] == $currentTrainerId)
    );
}

$mysqli->close();

header('Content-Type: application/json');
echo json_encode($messages);
?>
